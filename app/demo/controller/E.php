<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/30
 * Time: 13:08
 */
namespace app\demo\controller;
use app\BaseController;

class E extends BaseController{
    public function index(){
//        echo $abc;
        throw new \think\exception\HttpException(404, "找不到相应的数据");
    }
}