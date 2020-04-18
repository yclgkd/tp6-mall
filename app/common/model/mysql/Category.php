<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/15
 * Time: 13:25
 */
namespace app\common\model\mysql;

use think\Model;

class Category extends Model {

    /**
     * 自动生成时间
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    public function getCategoryByCategoryName($name) {
        $results = $this->where("name", $name)
           ->select()->toArray();
        return $results;
    }

    public function getNormalCategories($field = "*") {
        $where = [
            "status" => config("status.mysql.table_normal"),
        ];
        $result = $this->where($where)->field($field)->select();
        return $result;
    }

    public function getLists($where, $num = 10) {
        $order = [
            "listorder" => "desc",
            "id" => "desc",
        ];
        $result = $this->where("status", "<>", config("status.mysql.table_delete"))
            ->where($where)
            ->order($order)
            ->paginate($num);
        return $result;
    }

    //根据Id更新库里的数据
    public function updateById($id, $data) {
        $data['update_time'] = time();
        return $this->where(["id" => $id])->save($data);
    }

    public function getChildCountInPids($condition) {
        $where[] = ["pid", "in", $condition['pid']];
        $where[] = ["status", "<>", config("status.mysql.table_delete")];
        $res = $this->where($where)
            ->field(["pid", "count(*) as count"])
            ->group("pid")
            ->select();
//        echo $this->getLastSql();exit();
        return $res;
    }
}