<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/4
 * Time: 18:32
 */
namespace app\admin\validate;

use think\Validate;

class AdminUser extends Validate {
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha' => 'require|checkCaptcha',
    ];
    protected $message = [
        'username' => '用户名未输入',
        'password' => '密码未输入',
        'captcha' => '验证码未输入',
    ];
    protected function checkCaptcha($value, $rule, $data = []) {
        if (!captcha_check($value)) {
            return "您输入的验证码不正确！";
        }
        return true;
    }
}