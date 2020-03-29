<?php
/**
 * Author: Troku<chunlai0928@foxmail.com>
 * Date: 2020/3/27
 * Time: 12:44
 */
namespace app\controller;

class Error{
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        $result = [
            'status' => config("status.controller_not_found"),
            'message' => '找不到该控制器',
            'result' => null
        ];
        return json($result, 400);
    }
}