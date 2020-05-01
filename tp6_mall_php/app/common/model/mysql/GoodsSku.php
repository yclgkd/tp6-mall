<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/21
 * Time: 12:18
 */
namespace app\common\model\mysql;

class GoodsSku extends ModelBase {
    public function goods() {
        return $this->hasOne(Goods::class, "id", "goods_id");
    }

    public function getNormalByGoodsId($goodsId = 0){
        $where = [
            "goods_id" => $goodsId,
            "status" => config("status.mysql.table_normal")
        ];
        return $this->where($where)->select();
    }

    public function  decStock($id, $num) {
        return $this->where("id", "=", $id)
            ->dec("stock", $num)
            ->update();
    }
}