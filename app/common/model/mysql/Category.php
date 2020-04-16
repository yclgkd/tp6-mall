<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/15
 * Time: 13:25
 */
namespace app\common\model\mysql;

use think\Model;

class Category extends Model {

    /**
     * 自动生成时间
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    public function getCategoryByCategoryName($name) {
        $results = $this->where("name", $name)
           ->select()->toArray();
        return $results;
    }

    public function getNormalCategories($field = "*") {
        $where = [
            "status" => config("status.mysql.table_normal"),
        ];
        $result = $this->where($where)->field($field)->select();
        return $result;
    }
}