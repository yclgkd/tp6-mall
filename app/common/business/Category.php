<?php
/**
 * 分类管理前台和后台都需要用到
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/15
 * Time: 13:21
 */
namespace app\common\business;

use app\common\model\mysql\Category as CategoryModel;

class Category {
    public $categoryObj = null;
    public function __construct()
    {
        $this->categoryObj = new CategoryModel();
    }

    public function add($data) {
        $data['status'] = config("status.mysql.table_normal");
        $this->categoryObj->save($data);
        //返回最后一个新增ID
        return $this->categoryObj->getLastInsID();
    }
}