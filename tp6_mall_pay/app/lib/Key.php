<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/28
 * Time: 3:03
 */

namespace app\lib;
class Key {

    /**
     *
     * @param $appId
     * @return string
     */
    public static function Order($appId) {
        return "order_".$appId;
    }
}