<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/10
 * Time: 23:24
 */
declare(strict_types = 1);
namespace app\api\controller;

use app\BaseController;

class Login extends BaseController {
    public function index() :object {
        $phoneNumber = $this->request->param("phone_number", "", "trim");
        $code = input("param.code", 0, "intval");
        $type = input("param.type", 0, "intval");
        //参数校验
        $data = [
            'phone_number' => $phoneNumber,
            'code' => $code,
            'type' => $type
        ];
        $validate = new \app\api\validate\User();
        if (!$validate->scene('login')->check($data)) {
            return show(config('status.error'), $validate->getError());
        }
        $result = (new \app\common\business\User())->login($data);
        return show(config('status.error'), "登录失败");
    }
}