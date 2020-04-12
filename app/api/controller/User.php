<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/11
 * Time: 15:48
 */
namespace app\api\controller;

use app\common\business\User as UserBis;

class User extends AuthBase {
    public function index() {
        $user = (new UserBis())->getNormalUserById($this->userId);
        $resultUser = [
            "id" => $this->userId,
            "username" => $user['username'],
            "sex" => $user['sex']
        ];
        return show(config("status.success"), "OK", $resultUser);
    }
}