<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/20
 * Time: 15:22
 */
namespace app\common\business;

use \app\common\model\mysql\SpecsValue as SpecsValueModel;

class SpecsValue extends BusBase {
    public $model = NULL;
    public function __construct()
    {
        $this->model = new SpecsValueModel();
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