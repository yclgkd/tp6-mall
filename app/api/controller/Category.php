<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/18
 * Time: 15:44
 */
namespace app\api\controller;

use app\common\business\Category as CategoryBis;

class Category extends ApiBase {
    public function index() {
        // 获取所有分类的内容
        $categoryBisObj = new CategoryBis();
        $categories = $categoryBisObj->getNormalAllCategories();
        $result = \app\common\lib\Arr::getTree($categories);
        return show(config("status.success"), "OK", $result);
    }
}