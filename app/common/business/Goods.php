<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/20
 * Time: 21:03
 */
namespace app\common\business;

use app\common\model\mysql\Goods as GoodsModel;
use app\common\business\GoodsSku as GoodsSkuBis;
use app\common\business\SpecsValue as SpecsValueBis;

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

    /**
     * 首页商品推荐
     * @param $categoryIds
     * @return array
     */
    public function categoryGoodsRecommend($categoryIds) {
        if(!$categoryIds) {
            return [];
        }
        // 分类以及子分类和分类下商品的获取 71 51  in category by  id or pid
        $categoryTree = (new Category())->getCategoryTreeByPids($categoryIds);
        if (empty($categoryTree)) {
            return [];
        }
       $result = [];
        foreach ($categoryTree as $k => $v) {
            if (isset($v['pid'])) {
                unset($v['pid']);
            }
            $result[$k]["categories"] = $v;
        }
        //防止key混乱，直接用result foreach
        foreach ($result as $key => $value) {
            $result[$key]["goods"] = $this->getNormalGoodsFindInSetCategoryId($value["categories"]["category_id"]);
        }
        return $result;
    }

    public function getNormalGoodsFindInSetCategoryId($categoryId) {
        $field = "sku_id as id, title, price , recommend_image as image";
        try {
            $result = $this->model->getNormalGoodsFindInSetCategoryId($categoryId, $field);
        }catch (\Exception $e) {
            //记录日志
            trace("Goods-getNormalGoodsFindInSetCategoryId-SeverException".$e->getMessage(), "error");
            return [];
        }
        return $result->toArray();
    }

    public function getNormalLists($data, $num = 5, $order) {
        try {
            $field = "sku_id as id, title, recommend_image as image,price";
            $list = $this->model->getNormalLists($data, $num, $field, $order);
            $res = $list->toArray();
            $result = [
                "total_page_num" => isset($res['last_page']) ? $res['last_page'] : 0,
                "count" => isset($res['total']) ? $res['total'] : 0,
                "page" => isset($res['current_page']) ? $res['current_page'] : 0,
                "page_size" => $num,
                "list" => isset($res['data']) ? $res['data'] : []
            ];
        }catch (\Exception $e) {
            ///echo $e->getMessage();exit;
            //记录日志
            trace("Goods-getNormalLists-SeverException".$e->getMessage(), "error");
            $result = [];
        }
        return $result;
    }

    public function getGoodsDetailBySkuId($skuId) {
        //sku_id sku表 => goods_id   goods表 => title,image,description
        //goods_id sku表 => sku数据
        $skuBisObj = new GoodsSkuBis();
        $goodsSku = $skuBisObj->getNormalSkuAndGoods($skuId);
        if (!$goodsSku) {
            return [];
        }
        if (empty($goodsSku["goods"])) {
            return [];
        }
        $goods = $goodsSku["goods"];
        $skus = $skuBisObj->getSkusByGoodsId($goods['id']);
        if (!$skus) {
            return [];
        }
        $flagValue = ""; //标注值
        foreach ($skus as $sv) {
            if ($sv["id"] == $skuId) {
                $flagValue = $sv["specs_value_ids"];
            }
        }
        $gids = array_column($skus, "id", "specs_value_ids");
        if ($goods["goods_specs_type"] == 1) {
            //统一规格
            $sku = [];
        } else {
            //多规格
            $sku = (new SpecsValueBis())->dealGoodsSkus($gids, $flagValue);
        }
        $result = [
            "title" => $goods["title"],
            "price" => $goodsSku["price"],
            "cost_price" => $goodsSku["cost_price"],
            "sales_count" => 0,
            "stock" => $goodsSku["stock"],
            "gids" => $gids,
            "image" => $goods["carousel_image"],
            "sku" => $sku,
            "detail" => [
                "d1" => [
                    "商品编码" => $goodsSku["id"],
                    "上架时间" => $goodsSku["create_time"],
                ],
                "d2" => preg_replace('/(<img src=")(.*?)/', '$1'.request()->domain().'$2', $goods["description"])
            ],
        ];
        return $result;
    }
}