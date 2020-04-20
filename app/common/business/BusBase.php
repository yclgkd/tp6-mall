<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/20
 * Time: 19:42
 */
namespace app\common\business;

class BusBase {
    //新增
    public function add($data) {
        $data['status'] = config("status.mysql.table_normal");
        //todo：根据name查询$name是否存在
        try {
            $this->model->save($data);
        } catch (\Exception $e) {
            //todo：记录日志
            return 0;
        }
        return $this->model->id;
    }
}