<?php
/**
 * Num 记录和数据相关的类库中的方法
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/10
 * Time: 20:23
 */
declare(strict_types = 1);
namespace app\common\lib;

class Num {

    /**
     * 生成手机验证码
     * @param int $len
     * @return int
     */
    public static function getCode(int $len = 4) : int{
        $code = rand(1000, 9999);
        if ($len == 6) {
            $code = rand(100000, 999999);
        }
        return $code;
    }
}
