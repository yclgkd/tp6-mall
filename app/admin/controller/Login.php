<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/31
 * Time: 14:55
 */
namespace app\admin\controller;

use app\BaseController;
use think\facade\View;
use app\common\model\mysql\AdminUser;

class Login extends BaseController {
    public function index() {
        return View::fetch();
    }
    public function md5() {
        //admin admin
        echo md5("admin_tp6_mall");
    }
    public function check() {
        if (!$this->request->isPost()){
            return show(config("status.error"), "请求方式错误");
        }
        // 参数校验 1、原生方式 2、tp6的校验机制
        $username = $this->request->param("username", "", "trim");
        $password = $this->request->param("password", "", "trim");
        $captcha = $this->request->param("captcha", "", "trim");
        if (empty($username) || empty($password) || empty($captcha)) {
            return show(config("status.error"), "参数不能为空");
        }
        //校验验证码
        if (!captcha_check($captcha)) {
            //验证码校验失败
            return show(config("status.error"), "验证码不正确");
        }
        $adminUserObj = new AdminUser();
        //判断是否存在该用户
        $adminUser = $adminUserObj->getAdminUserByUsername($username);
        if (empty($adminUser) || $adminUser->status != config("status.mysql.table_normal")) {
            return show(config("status.error"), "不存在该用户");
        }
        $adminUser = $adminUser->toArray();
        //判断密码是否正确
        if ($adminUser['password'] != md5($password . "_tp6_mall")) {
            return show(config("status.error"), "密码错误");
        }
        return show(config("status.success"), "登录成功");
    }
}