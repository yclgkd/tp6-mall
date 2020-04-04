<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/4
 * Time: 14:51
 */
namespace app\admin\controller;

class Logout extends AdminBase {
    public function index() {
        // 清除session
        session(config("admin.session_admin"), null);
        // 执行跳转
        return redirect(url("login/index"));
    }
}