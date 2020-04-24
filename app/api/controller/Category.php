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
        $result = [
            "name" => "我是一级分类",
            "focus_ids" => [1, 11],
            "list" => [
                [
                    ["id" => 1, "name" => "二级分类1"],
                    ["id" => 2, "name" => "二级分类2"],
                    ["id" => 3, "name" => "二级分类3"],
                    ["id" => 4, "name" => "二级分类4"],
                    ["id" => 5, "name" => "二级分类5"],
                ],

                [
                    ["id" => 11, "name" => "三级分类1"],
                    ["id" => 12, "name" => "三级分类2"],
                    ["id" => 13, "name" => "三级分类3"],
                    ["id" => 14, "name" => "三级分类4"],
                    ["id" => 15, "name" => "三级分类5"],
                ],
            ],
        ];

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