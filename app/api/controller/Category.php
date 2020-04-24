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
     * 请求格式api/category/search/51
     * 商品列表页面中 按栏目检索的内容
     * @return \think\response\Json
     */
    public function search() {
        $id = input("param.id", 0, "intval");
        $result = (new CategoryBis())->search($id);
        return show(config("status.success"), "ok", $result);
    }

    /**
     * 获取子分类  category/sub/2
     * @return \think\response\Json
     */
    public function sub() {
        $id = input("param.id", 0, "intval");
        $result = (new CategoryBis())->sub($id);
        return show(config("status.success"), "ok", $result);
    }
}