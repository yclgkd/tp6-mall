<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/10
 * Time: 21:06
 */
declare(strict_types = 1);
namespace app\common\lib\sms;

interface SmsBase {
    public static function sendCode(string $phone, int $code);
}