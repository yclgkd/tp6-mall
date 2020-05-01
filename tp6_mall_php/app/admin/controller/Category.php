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
        $pid = input("param.pid", "", "intval");
        $data = [
            'pid' => $pid,
        ];
        try {
            $categories = (new CategoryBus())->getLists($data, 5);
        } catch (\Exception $e) {
            $categories = \app\common\lib\Arr::getPaginateDefaultData(5);
        }
        return View::fetch("", [
            "categories" => $categories,
            "pid" => $pid
        ]);
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
        $validate = (new \app\admin\validate\Category())->scene("addCategory");
        if (!$validate->check($data)) {
            return show(config("status.error"), $validate->getError());
        }

        try {
            $result = (new CategoryBus())->add($data);
        } catch (\Exception $e) {
            return show(config("status.error"), $e->getMessage());
        }
        if ($result) {
            return show(config("status.success"), "OK");
        } else {
            return show(config("status.error"), "新增分类失败");
        }
    }

    /**
     * 排序
     * @return \think\response\Json
     */
    public function listorder() {
        $id = input("param.id", 0, "intval");
        $listorder = input("param.listorder", 0, "intval");
        $data = [
            'id' => $id,
            'listorder' => $listorder
        ];
        $validate = (new \app\admin\validate\Category())->scene("listorder");
        if (!$validate->check($data)) {
            return show(config("status.error"), $validate->getError());
        }
        try {
            $res = (new CategoryBus())->listorder($id, $listorder);
        } catch (\Exception $e) {
            return show(config("status.error"), $e->getMessage());
        }
        if ($res) {
            return show(config("status.success"), "排序成功");
        } else {
            return show(config("status.error"), "排序失败");
        }
    }

    //更新状态
    public function status() {
        $status = input("param.status", 0, "intval");
        $id = input("param.id", 0, "intval");
        $data = [
            'id' => $id,
            'status' => $status
        ];
        $validate = (new \app\admin\validate\Category())->scene("updateStatus");
        if (!$validate->check($data)) {
            return show(config("status.error"), $validate->getError());
        }
        try {
            $res = (new CategoryBus())->status($id, $status);
        } catch (\Exception $e) {
            return show(config("status.error"), $e->getMessage());
        }
        if ($res) {
            return show(config("status.success"), "状态更新成功");
        } else {
            return show(config("status.error"), "状态更新失败");
        }
    }

    public function dialog() {
        //获取正常的一级分类数据
        $categories = (new CategoryBus)->getNormalByPid();
        return view("", [
            "categories" => json_encode($categories)
        ]);
    }

    public function getByPid() {
        $pid = input("param.pid", 0, "intval");
        $categories = (new CategoryBus())->getNormalByPid($pid);
        return show(config("status.success"), "OK", $categories);
    }
}