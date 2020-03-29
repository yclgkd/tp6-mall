<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/29
 * Time: 20:15
 */
namespace app\demo\controller;
use \app\BaseController;
use \app\model\Demo;


class M extends BaseController{
    public function index(){
        $categoryId = $this->request->param("category_id", 0, "intval");
        if (empty($categoryId)){
            return show(config("status.error"), "参数错误");
        }
        $model = new Demo();
        $results = $model->getDemoDataByCategoryId($categoryId);
        $categorys = config("category");
        if (empty($results)){
            return show(config("status.error"), "数据为空");
        }
        foreach ($results as $key=>$result){
            $results[$key]['category_id'] = $categorys[$result["category_id"]] ?? "其他";
        }
        return show(config("status.success"), "ok", $results);
    }
}