<?php
/**
 * 该文件主要是存放业务状态码相关的配置
 * Created by PhpStorm.
 * User: singwa
 * Date: 2019-11-23
 * Time: 14:00
 */

return [
    "success" => 1,
    "error" => 0,

    "mysql" => [
        "table_normal" => 1,  // 正常
        "table_pending" => 0, // 待审
        "table_delete" => 99, // 删除
    ],
];
