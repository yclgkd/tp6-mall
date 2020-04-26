<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/26
 * Time: 0:32
 */
namespace app\api\controller;

use app\common\lib\Show;
use app\common\business\Cart as CartBis;

class Cart extends AuthBase {
    public function add () {
        if (!$this->request->isPost()) {
            return Show::error();
        }
        $id = input("param.id", 0, "intval");
        $num = input("param.num", 0, "intval");
        $data = [
            "id" => $id,
            "num" => $num
        ];
        $validate = new \app\api\validate\Cart();
        if (!$validate->check($data)) {
            return show(config("status.error"), $validate->getError());
        }
        $res = (new CartBis())->insertRedis($this->userId, $id, $num);
        //如果之前数据没有回返回1 覆盖返回2 错误FALSE
        if ($res === FALSE) {
            return Show::error();
        }
        return Show::success();
    }

    public function lists() {
        $res = (new CartBis())->lists($this->userId);
        if ($res ===FALSE) {
            return Show::error();
        }
        return Show::success($res);
    }


    public function delete() {
        if(!$this->request->isPost()) {
            return Show::error();
        }
        $id = input("param.id", 0, "intval");
        if(!$id) {
            return Show::error("参数不合法");
        }
        $res = (new CartBis())->deleteRedis($this->userId, $id);
        if($res === FALSE) {
            return Show::error();
        }
        return Show::success($res);
    }

    public function update() {
        if(!$this->request->isPost()) {
            return Show::error();
        }
        $id = input("param.id", 0, "intval");
        $num = input("param.num", 0, "intval");
        if(!$id || !$num) {
            return Show::error("参数不合法");
        }
        try {
            $res = (new CartBis())->updateRedis($this->userId, $id, $num);
        }catch (\think\Exception $e) {
            return Show::error($e->getMessage());
        }
        if($res === FALSE) {
            return Show::error();
        }
        return Show::success($res);
    }
}