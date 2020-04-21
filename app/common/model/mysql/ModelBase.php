<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/21
 * Time: 21:17
 */
namespace app\common\model\mysql;

use think\Model;

class ModelBase extends Model {
    protected $autoWriteTimestamp = true;
    public function updateById($id, $data) {
        $data['update_time'] = time();
        return $this->where(["id" => $id])->save($data);
    }
}