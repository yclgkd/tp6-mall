<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/31
 * Time: 14:02
 */
namespace app\demo\controller;
use app\BaseController;

class Detail extends BaseController{
    public function index(){
        dump($this->request->type);
    }
}