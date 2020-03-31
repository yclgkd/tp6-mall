<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/31
 * Time: 14:55
 */
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;

class Login extends BaseController {
    public function index() {
        return View::fetch();
    }
}