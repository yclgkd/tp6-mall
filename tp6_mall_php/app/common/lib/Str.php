<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/11
 * Time: 10:32
 */
namespace app\common\lib;

class Str {
    public static function getLoginToken($string) {
        //生成一个不会重复的token
        $str = md5(uniqid(md5(microtime(true)), true));
        $token = sha1($str.$string);
        return $token;//加密并返回token
    }
}