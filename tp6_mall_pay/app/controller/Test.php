<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/28
 * Time: 1:03
 */
namespace app\controller;

use app\BaseController;

use app\lib\phpqrcode\QRcode;
class Test extends BaseController {

    /**
     * 生成二维码
     */
    public function index() {
//        echo "<img src='http://192.168.37.6/qcode/index.html?data=weixin%3A%2F%2Fwxpay%2Fbizpayurl%3Fpr%3D436MP2H'>";
//        echo "<img src='".url("qcode/index", ["data"=>"12312312"])."'>";
    }
}