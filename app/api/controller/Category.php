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

    /**
     * api/category/search/51  todo:
     * 商品列表页面中 按栏目检索的内容
     * @return \think\response\Json
     */
    public function search() {
        $id = input("param.id", 0, "intval");
        $result = (new CategoryBis())->search($id);
        return show(config("status.success"), "ok", $result);
    }

    /**
     * 获取子分类  category/sub/2   todo:
     * @return \think\response\Json
     */
    public function sub() {
        $result = [
            ["id" => 21, "name" => "点二到三分类1"],
            ["id" => 22, "name" => "点二级三分类2"],
            ["id" => 33, "name" => "点二到三分类3"],
            ["id" => 134, "name" => "点二到三分类4"],
            ["id" => 154, "name" => "点二到三分类5"],
        ];
        return show(config("status.success"), "ok", $result);
    }
}