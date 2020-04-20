<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/20
 * Time: 15:29
 */
namespace app\common\model\mysql;

use think\Model;

class SpecsValue extends Model {
    //自动写入时间
    protected $autoWriteTimestamp = true;

    public function getNormalBySpecsId($specsId, $field = "*") {
        $where = [
            "specs_id" => $specsId,
            "status" => config("status.mysql.table_normal")
        ];
        $res = $this->where($where)
            ->field($field)
            ->select();
        return $res;
    }
}