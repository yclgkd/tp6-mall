<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/9
 * Time: 21:34
 */
declare(strict_types=1);
namespace app\common\business;

use app\common\lib\sms\AliSms;

class Sms {
    public static function sendCode(string $phoneNumber) :bool {

        $code = rand(100000, 999999); //生成6位验证码
        $sms = AliSms::sendCode($phoneNumber, $code);
        if ($sms) {
            //如果短信发送成功，把短信验证码发送到redis中，并设置失效时间
            cache(config("redis.code_pre").$phoneNumber, $code, config("redis.code_expire"));
        }
        return true;
    }
}