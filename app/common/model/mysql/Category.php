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
           ->find();
    }
}