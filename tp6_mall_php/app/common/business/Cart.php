<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/26
 * Time: 15:30
 */
namespace app\common\business;

use think\facade\Cache;
use app\common\lib\Key;
use app\common\lib\Arr;

class Cart extends BusBase {
    public function insertRedis($userId, $id, $num) {
        // id获取商品的数据
        $goodsSku = (new GoodsSku())->getNormalSkuAndGoods($id);
        if (!$goodsSku) {
            return FALSE;
        }
        $data = [
            "title" => $goodsSku["goods"]["title"],
            "image" => $goodsSku["goods"]["recommend_image"],
            "num" => $num,
            "goods_id" => $goodsSku["goods"]["id"],
            "create_time" => time()
        ];
        try {
            $get = Cache::hGet(Key::UserCart($userId), $id);
            if ($get) {
                $get = json_decode($get, true);
                $data["num"] += $get["num"];
            }
            $res = Cache::hSet(Key::UserCart($userId), $id, json_encode($data));
        } catch (\Exception $e) {
            return FALSE;
        }
        return $res;
    }

    public function lists($userId, $ids) {
        try {
            if ($ids) { //如果有id获取选中的id商品，在购物车和订单页面都适用
                $ids = explode(",", $ids);
                $res = Cache::hMget(Key::UserCart($userId), $ids);
                // 判断非法用户获取数据
                if (in_array(FALSE, array_values($res))) {
                    return [];
                }
            } else { //如果没有id，获取所有商品
                $res = Cache::hGetAll(Key::UserCart($userId));
            }
        } catch (\Exception $e) {
            $res = [];
        }
        if (!$res) {
            return [];
        }
        $result = [];
        $skuIds = array_keys($res);
        $skus = (new GoodsSku())->getNormalInIds($skuIds);
        $skuIdPrice = array_column($skus, "price", "id");
        $skuIdSpecsValueIds = array_column($skus, "specs_value_ids", "id");
        $specsValues = (new SpecsValue())->dealSpecsValue($skuIdSpecsValueIds);
        foreach ($res as $k => $v) {
            $price = $skuIdPrice[$k] ?? 0;
            $v = json_decode($v, true);
            if($ids && isset($stocks[$k]) && $stocks[$k] < $v['num']) { //如果不存在或者商品数量不够
                throw new \think\Exception($v['title']."的商品库存不足");
            }
            $v['id'] = $k;
            $v['image'] = preg_match("/http:\/\//", $v['image']) ? $v['image'] : request()->domain().$v['image'];
            $v['price'] = $price;
            $v['total_price'] = $price * $v['num'];
            $v['sku'] = $specsValues[$k] ?? "暂无规则";
            $result[] = $v;
        }
        if (!empty($result)) {
            //购物车排列，根据时间做倒序排序
            $result = Arr::arrSortByKey($result, "create_time");
        }
        return $result;
    }

    /**
     * 删除购物车功能
     * @param $userId
     * @param $id
     * @return bool
     */
    public function deleteRedis($userId, $ids) {
        if(!is_array($ids)) {
            $ids = explode(",", $ids); // id=1  => [1]  ,  1,2 => [1, 2, 5,6]
        }
        try {
            // ... 可变参数
            $res = Cache::hDel(Key::userCart($userId), ...$ids);
        }catch (\Exception $e) {
            return FALSE;
        }
        return $res;
    }


    /**
     * 更新购物车中的商品数量
     * @param $userId
     * @param $id
     * @param $num
     * @return bool
     * @throws \think\Exception
     */
    public function updateRedis($userId,  $id, $num) {
        try {
            $get = Cache::hGet(Key::userCart($userId), $id);
        }catch (\Exception $e) {
            return FALSE;
        }
        if($get) {
            $get = json_decode($get, true);
            $get['num'] = $num;
        } else {
            throw new \think\Exception("不存在该购物车的商品，更新没有任何意义");
        }
        try {
            $res = Cache::hSet(Key::userCart($userId), $id, json_encode($get));
        }catch (\Exception $e) {
            return FALSE;
        }
        return $res;
    }

    /**
     * 获取购物车数据
     * @param $userId
     * @return int
     */
    public function getCount($userId) {
        try {
            $count = Cache::hLen(Key::userCart($userId));
        }catch (\Exception $e) {
            return 0;
        }
        return intval($count);
    }
}