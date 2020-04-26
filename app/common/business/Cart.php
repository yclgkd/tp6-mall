<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/26
 * Time: 15:30
 */
namespace app\common\business;

use think\facade\Cache;
use app\common\lib\Key;

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

    public function lists($userId) {
        try {
            $res = Cache::hGetAll(Key::UserCart($userId));
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
            $v = json_decode($v, true);
            $v["id"] = $k;
            //对图片的url地址做转换
            $v["image"] = preg_match("/http:\/\//", $v["image"]) ? $v["image"] : request()->domain().$v["image"];
            $v["price"] = $skuIdPrice[$k] ?? 0;
            $v["sku"] = $specsValues[$k] ?? "暂无规格";
            $result[] = $v;
        }
        return $result;
    }
}