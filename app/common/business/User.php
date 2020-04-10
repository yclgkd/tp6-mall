<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/10
 * Time: 23:37
 */
namespace app\common\business;
use app\common\model\mysql\User as UserModel;

class User {
    public $userObj = null;
    public function __construct()
    {
        $this->userObj = new UserModel();
    }
    public function login($data) {
        $redisCode = cache(config("redis.code_pre").$data['phone-number']);
        if (empty($redisCode) || $redisCode != $data['code']) {
            throw new \think\Exception("不存在该验证码", -1009);
        }
    }
}