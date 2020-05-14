<?php
/**
 * Created by singwa
 * User: singwa
 * motto: 现在的努力是为了小时候吹过的牛逼！
 * Time: 22:14
 */

return [
    // 填写支付的类型，按实际情况来定。
    "pay_types" => [
        "alipay",
        "weixin",
        "baidu"
    ],

    /**
     * 支付回调通知
     *
     */
    "pay_notify" => [
        "weixin" => "https://pay.singwa666.com/notify.weixin",
        "alipay" => "https://pay.singwa666.com/notify.alipay"
    ],

    "pay_expire" => [
        "weixin" => 300, // 失效时间
    ],

];