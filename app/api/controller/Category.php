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
        try {
            $categoryBisObj = new CategoryBis();
            $categories = $categoryBisObj->getNormalAllCategories();
        } catch (\Exception $e) {
            //todo:加日志
            //返回空数据
            return show(config("status.success"), "内部异常");
        }
        if (empty($categories)) {
            return show(config("status.success"), "数据为空");
        }
        $result = \app\common\lib\Arr::getTree($categories);
        $result = \app\common\lib\Arr::sliceTreeArr($result);
        return show(config("status.success"), "OK", $result);
    }
}