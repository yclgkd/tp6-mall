<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/31
 * Time: 21:27
 */

namespace app\admin\controller;

use think\captcha\facade\Captcha;

class Verify
{
    public function index() {
        return Captcha::create("verify");
    }
}