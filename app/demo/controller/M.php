<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/29
 * Time: 20:15
 */
namespace app\demo\controller;
use \app\BaseController;
use app\common\business\Demo;


class M extends BaseController{
    public function index(){
        $categoryId = $this->request->param("category_id", 0, "intval");
        if (empty($categoryId)){
            return show(config("status.error"), "参数错误");
        }
        //调用business层的方法
        $demo = new Demo();
        $results = $demo->getDemoDataByCategoryId($categoryId);
        return show(config("status.success"), "ok", $results);
    }
}