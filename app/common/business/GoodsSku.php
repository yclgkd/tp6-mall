<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/20
 * Time: 21:04
 */
namespace app\common\business;

use app\common\model\mysql\GoodsSku as GoodsSkuModel;

class GoodsSku extends BusBase {
    public $model = NULL;
    public function __construct()
    {
        $this->model = new GoodsSkuModel();
    }

    public function saveAll($data) {
        if(!$data['skus']) {
            return false;
        }

        foreach($data['skus'] as $value) {
            $insertData[] = [
                "goods_id" => $data['goods_id'],
                "specs_value_ids" => $value['propvalnames']['propvalids'],
                "price" => $value['propvalnames']['skuSellPrice'],
                "cost_price" => $value['propvalnames']['skuMarketPrice'],
                "stock" => $value['propvalnames']['skuStock'],
            ];
        }

        //number_format round
        try {
            $result = $this->model->saveAll($insertData);
            return $result->toArray();
        }catch (\Exception $e) {
            ///echo $e->getMessage();exit;
            //记录日志
            trace("GoodsSku-saveAll-SeverException".$e->getMessage(), "error");
            return false;
        }
    }

    public function getNormalSkuAndGoods($id) {
        try {
            $result = $this->model->with("goods")->find($id);
        } catch (\Exception $e) {
            return [];
        }
        if (!$result) {
            return [];
        }
        $result = $result->toArray();
        if ($result["status"] != config("status.mysql.table_normal")) {
            return [];
        }
        return $result;
    }

    public function getSkusByGoodsId($goodsId = 0) {
        if (!$goodsId) {
            return [];
        }
        try {
            $skus = $this->model->getNormalByGoodsId($goodsId);
        } catch (\Exception $e) {
            return [];
        }
        return $skus->toArray();
    }
}