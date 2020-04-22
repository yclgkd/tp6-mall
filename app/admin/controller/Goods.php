<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/20
 * Time: 13:12
 */
namespace app\admin\controller;

use app\common\business\Goods as GoodsBis;

class Goods extends AdminBase {
    public function index() {
        $data = [];
        $title = input("param.title", "", "trim");
        $time = input("param.time", "", "trim");
        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($time)) {
            $data['create_time'] = explode(" - ", $time);
        }
        $goods = (new GoodsBis())->getLists($data, 5);
        return view("", [
            "goods" => $goods
        ]);
    }

    public function add() {
        return view();
    }

    public function save() {
        // 判断是否为post请求
        if(!$this->request->isPost()) {
            return show(config('status.error'), "参数不合法");
        }
        // todo：验证参数
        $data = input("param.");
        //防止csrf攻击做一次校验
        $check = $this->request->checkToken('__token__');
        if(!$check) {
            return show(config('status.error'), "非法请求");
        }
        // 数据处理 = > 基于验证成功之后
        $data['category_path_id'] = $data['category_id'];
        $result = explode(",", $data['category_path_id']);
        $data['category_id'] = end($result);
        $res = (new GoodsBis())->insertData($data);
        if(!$res) {
            return show(config('status.error'), "商品新增失败");
        }

        return show(config('status.success'), "商品新增成功");
    }
}