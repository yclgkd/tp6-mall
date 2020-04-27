<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/27
 * Time: 13:18
 */
namespace app\common\business;

use app\common\lib\Snowflake;
use app\common\model\mysql\Order as OrderModel;
use app\common\model\mysql\OrderGoods as OrderGoodsModel;
use think\facade\Cache;

class Order extends BusBase {
    public $model = NULL;

    public function __construct()
    {
        $this->model = new OrderModel();
    }

    public function save($data) {
        // 拿到一个订单号
        $workId = rand(1, 1023);
        $orderId = Snowflake::getInstance()->setWorkId($workId)->id();
        //echo "order1:".$orderId.PHP_EOL;

        $orderId = (string) $orderId;
        // 获取购物车数据， => redis
        $carObj = new Cart();
        $result = $carObj->lists($data['user_id'], $data['ids']);
        if(!$result) {
            return false;
        }
        $newResult = array_map(function($v) use($orderId){
            $v['sku_id'] = $v['id'];
            unset($v['id']);
            $v['order_id'] = $orderId;
            return $v;
        }, $result);

        $price = array_sum(array_column($result, "total_price"));
        $orderData = [
            "user_id" => $data['user_id'],
            "order_id" => $orderId,
            "total_price" => $price,
            "address_id" => $data['address_id'],
        ];

        $this->model->startTrans();
        try {
            // 新增 order
            $id = $this->add($orderData);
            if (!$id) {
                return 0;
            }
            // 新增order_goods
            $orderGoodsResult = (new OrderGoodsModel())->saveAll($newResult);
            // goods_sku 更新
            $skuRes = (new GoodsSku())->updateStock($result);
            // todo:goods 更新
            // 删除购物车里面的商品
            $carObj->deleteRedis($data['user_id'], $data['ids']);

            $this->model->commit();
            //echo "order2:".$orderId.PHP_EOL;

            // 把当前订单ID 放入延迟队列中， 定期检测订单是否已经支付 （因为订单有效期是20分钟，超过这个时间还没有支付的，
            // 需要把这个订单取消 ， 然后库存+操作）
            try {
                Cache::zAdd(config("redis.order_status_key"), time() + config("redis.order_expire"), $orderId);
            }catch (\Exception $e) {
                // 记录日志， 添加监控 ，异步根据监控内容处理。
            }
            return ["id" => $orderId];
        }catch (\Exception $e) {
            $this->model->rollback();
            return false;
        }
    }

    public function detail($data) {
        // user_id 订单ID组合查询
        $conditon = [
            "user_id" => $data['user_id'],
            "order_id" => $data['order_id'],
        ];
        try {
            $orders = $this->model->getByCondition($conditon);
        }catch (\Exception $e) {
            $orders = [];
        }
        if(!($orders)) {
            return [];
        }
        $orders = $orders->toArray();
        $orders = !empty($orders) ? $orders[0] : [];
        if(empty($orders)) {
            return [];
        }

        $orders['id'] = $orders['order_id'];
        // 模拟地址
        //todo:真实地址
        $orders['consignee_info'] = "江西省 赣州市 章贡区 xxx";

        // 根据order_id查询 order_goods表信息数据
        $orderGoods = (new OrderGoods())->getByOrderId($data['order_id']);

        $orders['malls'] = $orderGoods;
        return $orders;
    }

    /**
     * @param $orderId
     * @param $time
     * @return bool
     */
    public function checkOrderStatus() {

        $result = Cache::store('redis')->zRangeByScore("order_status", 0, time(), ['limit' => [0, 1]]);

        if(empty($result) || empty($result[0])) {
            return false;
        }

        try {
            $delRedis = Cache::store('redis')->zRem("order_status", $result[0]);
        }catch (\Exception $e) {
            // 记录日志
            $delRedis = "";
        }
        if($delRedis) {
            echo "订单id:{$result[0]}在规定时间内没有完成支付 我们判定为无效订单删除".PHP_EOL;
            /**
             * @todo :
             * 第一步： 根据订单ID 去数据库order表里面获取当前这条订单数据 看下当前状态是否是待支付:status = 1
             *        如果是那么我们需要把状态更新为 已取消 status = 7， 否则不需要care
             *
             * 第二步： 如果第一步status修改7之后， 我们需要再查询order_goods表， 拿到 sku_id num  把sku表数据库存增加num
             *        goods表总库存也需要修改。
             *
             *
             */
        } else {
            return false;
        }

        return true;
    }
}