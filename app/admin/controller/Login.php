<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/31
 * Time: 14:55
 */
namespace app\admin\controller;

use app\BaseController;
use think\captcha\Captcha;
use think\facade\View;

class Login extends BaseController {
    public function index() {
        return View::fetch();
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
            return show(config("status.error"), "还是不行");
        }
        return show(config("status.success"), "登录成功");
    }
}