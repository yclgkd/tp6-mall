<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/13
 * Time: 14:11
 */
namespace app\api\controller;

class Logout extends AuthBase {
    public function index() {
        //删除redis缓存
        $res = cache(config("redis.token_pre").$this->accessToken, NULL);
        if ($res) {
            return show(config("status.success"), "退出登录成功");
        }
        return show(config("status.error"), "退出登录失败");
    }
}