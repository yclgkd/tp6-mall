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
        return view();
    }
    public function add() {
        return view();
    }

    public function save() {
        // 判断是否为post请求， 也可以通过在路由中做配置支持post即可，方法有很多就看同学们喜欢哪个。。。
        if(!$this->request->isPost()) {
            return show(config('status.error'), "参数不合法");
        }
        // 预留作业1：请大家仿照老师之前讲解的validate验证机制自行验证参数, 并且严格判断数据类型。
        $data = input("param.");
//        $check = $this->request->checkToken('__token__');
//        if(!$check) {
//            return show(config('status.error'), "非法请求");
//        }
        // 数据处理 = > 基于 我们得验证成功之后
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