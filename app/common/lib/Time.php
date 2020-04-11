<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/11
 * Time: 14:08
 */
namespace app\common\lib;

class Time {
    public static function userLoginExpiresTime($type = 2) {
        $type = !in_array($type, [1,2]) ? 2 : $type;
        if ($type == 1) {
            $day = $type * 7;
        }else if($type == 2) {
            $day =  $type * 30;
        }
        return $day * 24 * 3600;
    }
}