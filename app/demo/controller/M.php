<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/29
 * Time: 20:15
 */
namespace app\demo\controller;
use \app\BaseController;
use app\controller\Demo;

class M extends BaseController{
    public function index(){
        $categoryId = $this->request->param("categoryId", 0, "intval");
        if (empty($categoryId)){
            return show(config("status.error"), "参数错误");
        }
        $modal = new Demo();

    }
}