<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/20
 * Time: 21:03
 */
namespace app\common\business;

use app\common\model\mysql\Goods as GoodsModel;
use app\common\business\GoodsSku as GoodsSkuBis;

class Goods extends BusBase {
    public $model = NULL;

    public function __construct()
    {
        $this->model = new GoodsModel();
    }

    public function insertData($data) {
        //开启事务
        $this->model->startTrans();
        try {
            //写入商品的基本信息
            $goodsId = $this->add($data);
            if (!$goodsId) {
                return $goodsId;
            }
            // 如果是统一规格
            if ($data['goods_specs_type'] == 1) {
                $goodsSkuData = [
                    "goods_id" => $goodsId
                ];
                // todo:
                return true;
            } elseif ($data['goods_specs_type'] == 2) { //如果是多规格
                $goodsSkuBisobj = new GoodsSkuBis();
                $data['goods_id'] = $goodsId;
                //写入sku表
                $res = $goodsSkuBisobj->saveAll($data);
                //如果不为空
                if (!empty($res)) {
                    // 总库存
                    $stock = array_sum(array_column($res, "stock"));
                    $goodsUpdateData = [
                        "price" => $res[0]['price'],
                        "cost_price" => $res[0]['cost_price'],
                        "stock" => $stock,
                        "sku_id" => $res[0]['id'],
                    ];
                    // 执行完毕之后 回写商品的基本信息
                    $goodsRes = $this->model->updateById($goodsId, $goodsUpdateData);
                    if (!$goodsRes) {
                        throw  new \think\Exception("insertData:goods主表更新失败");
                    }
                } else {
                    throw new \think\Exception("sku表新增失败");
                }
                //事务提交
                $this->model->commit();
            }
        } catch (\think\Exception $e) {
            //事务回滚
            $this->model->rollback();
        }
        return true;
    }

    public function getLists($data, $num = 5) {
        $likeKeys = [];
        if (!empty($data)) {
            $likeKeys = array_keys($data);
        }
        try{
            $list = $this->model->getLists($likeKeys, $data, $num);
            $result = $list->toArray();
        } catch (\Exception $e) {
           $result = \app\common\lib\Arr::getPaginateDefaultData($num);
        }
        return $result;
    }

    public function getRotationChart() {
        $data = [
            "is_index_recommend" => 1,
        ];
        $field = "sku_id as id, title, big_image as image";
        try {
            $result = $this->model->getNormalGoodsByCondition($data, $field, 5);
        } catch (\Exception $e) {
            return [];
        }
        return $result->toArray();
    }
}