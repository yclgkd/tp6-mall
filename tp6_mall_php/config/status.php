<?php
/**
 * 该文件是主要用来存放业务状态码相关的配置
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/27
 * Time: 13:25
 */
return [
    "success" => 1,
    "error" => 0,
    "not_login" => -1,
    "user_is_register" => -2,
    "action_not_found" => -3,
    "controller_not_found" => -4,
    //mysql的相关状态配置
    "mysql" => [
        "table_normal" => 1, //正常
        "table_pending" => 0, //待审核
        "table_delete" => 99 //删除
    ],
];