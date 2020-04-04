<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/2
 * Time: 14:05
 */
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController {
    public function index() {
        return View::fetch();
    }
    public function welcome() {
        return View::fetch();
    }
}