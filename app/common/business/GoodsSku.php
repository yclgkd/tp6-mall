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
}