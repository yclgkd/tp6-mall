<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/13
 * Time: 19:18
 */
namespace app\admin\controller;

use think\facade\View;
use app\common\business\Category as CategoryBus;

class Category extends AdminBase {
    public function index() {
        return View::fetch();
    }

    public function add() {
        try {
            $categories = (new CategoryBus())->getNormalCategories();
        } catch (\Exception $e) {
            $categories = [];
        }
        return View::fetch("",
            [
                "categories" => json_encode($categories),
            ]);
    }

    /**
     * 新增分类
     */
    public function save() {
        $pid = input("param.pid", "", "trim");
        $name = input("param.name", "", "trim");

        //参数校验
        $data = [
            'pid' => $pid,
            'name' => $name
        ];
        $validate = new \app\admin\validate\Category();
        if (!$validate->check($data)) {
            return show(config("status.error"), $validate->getError());
        }

        try {
            $result = (new CategoryBus())->add($data);
        } catch (\Exception $e) {
            return show(config("status.error"), $e->getMessage());
        }
        return show(config("status.success"), "OK");
    }

}