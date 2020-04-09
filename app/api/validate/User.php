<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/9
 * Time: 21:44
 */

namespace app\api\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username' => 'require',
        'phone_number' => 'require|mobile',
    ];

    protected $message = [
        'username' => '用户名未输入',
        'phone_number.require' => '手机号未输入',
        'phone_number.mobile' => '手机号不正确，请重新输入'
    ];

    protected $scene = [
        'send_code' => ['phone_number']
    ];
}