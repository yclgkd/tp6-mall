<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/15
 * Time: 13:25
 */
namespace app\common\model\mysql;

class Category extends ModelBase {
    public function getCategoryByCategoryName($name) {
        $results = $this->where("name", $name)
           ->select()->toArray();
        return $results;
    }

    public function getNormalCategories($field = "*") {
        $where = [
            "status" => config("status.mysql.table_normal"),
        ];
        $order = [
            "listorder" => "desc",
            "id" => "desc",
        ];
        $result = $this->where($where)
            ->field($field)
            ->order($order)
            ->select();
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

    public function getChildCountInPids($condition) {
        $where[] = ["pid", "in", $condition['pid']];
        $where[] = ["status", "<>", config("status.mysql.table_delete")];
        $res = $this->where($where)
            ->field(["pid", "count(*) as count"])
            ->group("pid")
            ->select();
        return $res;
    }

    public function getNormalByPid($pid = 0, $field) {
        $where = [
            "pid" => $pid,
            "status" => config("status.mysql.table_normal")
        ];
        $order = [
            "listorder" => "desc",
            "id" => "desc"
        ];
        $res = $this->where($where)
            ->field($field)
            ->order($order)
            ->select();
        return $res;
    }

    public function getCategoryTreeByPids($categoryIds) {
        $order = [
            "listorder" => "desc",
            "id" => "desc"
        ];
        $field = "id as category_id, name, pid";
        $where[] = ["id|pid", "in", $categoryIds];
        $where[] = ["status", "=", config("status.mysql.table_normal")];
        $res = $this->where($where)
            ->order($order)
            ->field($field)
            ->select();
        //echo $this->getLastSql();exit();
        //SELECT `id`,`name`,`pid` FROM `mall_category` WHERE ( `id` IN (71,51) OR `pid` IN (71,51) ) AND `status` = 1 ORDER BY `listorder` DESC,`id` DESC
        return $res;
    }
}