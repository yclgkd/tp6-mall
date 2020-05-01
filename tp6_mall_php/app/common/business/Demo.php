<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/30
 * Time: 12:55
 */
namespace app\common\business;
use app\common\model\mysql\Demo as DemoModel;
class Demo{
    /**
     * business 层通过这个方法来获取数据
     * @param $categoryId
     * @param int $limit
     * @return array
     */
    public function getDemoDataByCategoryId($categoryId, $limit = 10){
        $model = new DemoModel();
        $results = $model->getDemoDataByCategoryId($categoryId, $limit);
        if (empty($results)){
            return [];
        }
        $categorys = config("category");
        foreach ($results as $key=>$result){
            $results[$key]['category_id'] = $categorys[$result["category_id"]] ?? "其他";
        }
        return $results;
    }
}