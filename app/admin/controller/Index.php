<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/2
 * Time: 14:05
 */
namespace app\admin\controller;

use think\facade\View;

class Index extends AdminBase {
    public function index() {
        return View::fetch();
    }
    public function welcome() {
        return View::fetch();
    }
}