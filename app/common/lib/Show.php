<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/23
 * Time: 13:59
 */
namespace app\common\lib;

class Show {
    public static function success($data = [], $message = "OK") {
        $result = [
            "status" => config("status.success"),
            "message" => $message,
            "result" => $data
        ];
        return json($result);
    }

    public static function error($data = [], $message = "error", $status = 0) {
        $result = [
            "status" => $status,
            "message" => $message,
            "result" => $data
        ];
        return json($result);
    }
}