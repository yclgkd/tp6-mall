<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/20
 * Time: 15:22
 */
namespace app\common\business;

use \app\common\model\mysql\SpecsValue as SpecsValueModel;

class SpecsValue {
    public $model = NULL;
    public function __construct()
    {
        $this->model = new SpecsValueModel();
    }

    //新增
    public function add($data) {
        $data['status'] = 1;
        //todo：根据name查询$name是否存在
        try {
            $this->model->save($data);
        } catch (\Exception $e) {
            //todo：记录日志
            return 0;
        }
        return $this->model->id;
    }

    public function getBySpecsId($specsId) {
        try {
            $result = $this->model->getNormalBySpecsId($specsId, "id, name");
        } catch (\Exception $e) {
            return [];
        }
        $result = $result->toArray();
        return $result;
    }
}