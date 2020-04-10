<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/9
 * Time: 17:25
 */
namespace app\api\controller;

use app\BaseController;
use app\common\business\Sms as SmsBus;

class Sms extends BaseController {
    public function code() :object {
        $phoneNumber = input('param.phone_number', '', 'trim');

        $data = [
            'phone_number' => $phoneNumber,
        ];
        try {
            validate(\app\api\validate\User::class)->scene("send_code")->check($data);
        }catch (\think\exception\ValidateException $e) {
            return show(config("status.error"), $e->getError());
        }

        //$rand_num = rand(0,9);
        //if(($rand_num >= 0) && ($rand_num < 4)) {
            //40%使用阿里云短信验证
        //} else if(($rand_num >= 4) && ($rand_num < 7)) {
            //30%使用百度云短信验证
        //} else {
            //30%使用京东云短信验证
        //}

        //调用business层的数据
        if (SmsBus::sendCode($phoneNumber, 6, "ali")) {
            return show(config("status.success"), "发送验证码成功");
        }
        return show(config("status.error"), "发送验证码失败");
    }
}