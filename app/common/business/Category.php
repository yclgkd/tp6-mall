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
        $name = $data['name'];
        // 根据$name去数据库查询是否存在这条记录
        if ($this->categoryObj->getCategoryByCategoryName($name)) {
           throw new \think\Exception("分类名已存在");
        }
        try {
            $this->categoryObj->save($data);
        } catch (\Exception $e) {
            throw new \think\Exception("服务内部异常");
        }
        //返回最后一个新增ID
        return $this->categoryObj->getLastInsID();
    }

    public function getNormalCategories() {
        $field = "id, name, pid";
        $categories = $this->categoryObj->getNormalCategories($field);
        if (!$categories) {
            $categories = [];
        }
        return $categories->toArray();
    }
}