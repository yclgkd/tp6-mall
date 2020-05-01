<?php
/**
 * 收货地址是Mock数据
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/27
 * Time: 10:18
 */
namespace app\api\controller;
class Address extends AuthBase {
    public function index() {
        // 获取该用户下所有设置的收获地址
        $result = [
            [
                "id" => 1,
                // 收货人 信息
                "consignee_info" => "江西 赣州 章贡区 红旗大道86号 Troku收 182xxxx",
                "is_default" => 1,
            ],
            [
                "id" => 2,
                // 收货人 信息
                "consignee_info" => "江西 赣州 章贡区 红旗大道86号  二狗收 182xxxx",
                "is_default" => 0,
            ],
            [
                "id" => 3,
                // 收货人 信息
                "consignee_info" => "江西 赣州 章贡区 红旗大道86号 王老板收 182xxxx",
                "is_default" => 0,
            ],
        ];

        return show(1, "OK", $result);
    }
}