<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

/**
 * 这块的配置 小伙伴可以做一个后端管理， 把配置信息存入表中，其实这块完全可以放入redis中哦。
 */
return [
    // https://pay.singwa666.com/x?appid=xxx&token=xxx&time=当前时间
    // token: md5(time."_".appid."_".key)

    // md5(time()."&mpm*68+0sg_12singwa_mall");  => token  redis加固使得token只能用一次
    // appid => []
    "singwa_mall" => [
        "key" => "m*68+0sg_12",
        "expire" => 10000000000,
        "stitching_symbol" => "&mp",
    ],
    "muku_abc" => [
        "key" => "ampqmtp",
        "expire" => 6000,
        "stitching_symbol" => "+_"
    ]
];
