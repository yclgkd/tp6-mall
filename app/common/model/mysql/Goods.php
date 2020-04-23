<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/21
 * Time: 12:17
 */
namespace app\common\model\mysql;

class Goods extends ModelBase {
    public function searchTitleAttr($query, $value) {
        $query->where('title', 'like', '%' . $value . '%');
    }

    public function searchCreateTimeAttr($query, $value) {
        $query->whereBetweenTime('create_time', $value[0], $value[1]);
    }

    public function getLists($likeKeys, $data, $num = 10) {
        $order = ["listorder" => "desc", "id" => "desc"];
        if(!empty($likeKeys)) {
            // 搜索器
            $res = $this->withSearch($likeKeys, $data);
        }else {
            $res = $this;
        }
        $list = $res->whereIn("status", [0, 1])
            ->order($order)
            ->paginate($num);
        //echo $this->getLastSql();exit;
        //SELECT * FROM `mall_goods` WHERE `title` LIKE '%kk%' AND `status` IN (0,1) ORDER BY `listorder` DESC,`id` DESC LIMIT 0,5
        //SELECT * FROM `mall_goods` WHERE `title` LIKE '%kk%' AND `create_time` BETWEEN 1587558000 AND 1587558120 AND `status` IN (0,1) ORDER BY `listorder` DESC,`id` DESC LIMIT 0,5
        return $list;
    }

    public function getNormalGoodsByCondition($where, $field = true, $limit = 5) {
        $order = ["listorder" => "desc", "id" => "decs"];
        $where["status"] = config("status.success");
        $result = $this->where($where)
            ->order($order)
            ->field($field)
            ->limit($limit)
            ->select();
        return $result;
    }

    /**
     * 图片获取，处理图片不同源的情况，使前端正常显示图片
     */
    public function getImageAttr($value) {
        return request()->domain().$value;
    }
}