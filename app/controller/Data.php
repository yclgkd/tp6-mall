<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/27
 * Time: 13:40
 */
namespace app\controller;
use app\BaseController;
use think\facade\Db;
use app\model\Demo;

class Data extends BaseController {
    public function index(){
        //$result = Db::table("mall_demo")->where("id", 2)->find();
        //通过容器的方式来处理
        //$result = app("db")->table("mall_demo")->where("id", 2)->find();
        $result = Db::table("mall_demo")
            //->order("id", "desc")
            //->limit(0, 2)
            //->page(1, 1)
                ->where([
                    ["id","=",1],
//        ["id","=",2]
            ])
            ->select();
        dump($result);
    }
    public function model1(){
        $result = Demo::find(2);
        dump($result->toArray());
    }
    public function model2(){
        $modelObj = new Demo();
        $result = $modelObj->where("category_id", 3)
            ->limit(2)
            ->order("id", "desc")
            ->select();
        foreach ($result as $result){
            //$result->content
            //ArrayAccess像数组一样访问对象
            dump($result['content']);
            dump($result->status_text);
        }
    }
}