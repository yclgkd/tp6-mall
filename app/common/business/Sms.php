<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/9
 * Time: 21:34
 */
declare(strict_types=1);
namespace app\common\business;

use app\common\lib\sms\AliSms;
use app\common\lib\Num;
use app\common\lib\ClassArr;

class Sms {
    public static function sendCode(string $phoneNumber, int $len, $type = "ali") :bool {

        $code = Num::getCode($len);
        //$sms = AliSms::sendCode($phoneNumber, $code);

        //工厂模式
        //$type = ucfirst($type);
        //$class = "app\common\lib\sms\\".$type."Sms";
        //$sms = $class::sendCode($phoneNumber, $code);

        $classStat = ClassArr::smsClassStat();
        $classObj = ClassArr::initClass($type, $classStat);
        $sms = $classObj::sendCode($phoneNumber, $code);
        if ($sms) {
            //如果短信发送成功，把短信验证码发送到redis中，并设置失效时间
            cache(config("redis.code_pre").$phoneNumber, $code, config("redis.code_expire"));
        }
        return true;
    }
}