<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/28
 * Time: 4:05
 */
namespace app\lib\pay;
interface PayBase {
    public function unifiedOrder($data);
}