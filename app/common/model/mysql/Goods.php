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

    public function getCarouselImageAttr($value) {
        if (!empty($value)) {
            $value = explode(",", $value);
            $value = array_map(function($v) {
                return request()->domain().$v;
            }, $value);
            return $value;
        }

    }

    public function getNormalGoodsFindInSetCategoryId($categoryId, $field = true, $limit = 10) {
        $order = ["listorder" => "desc", "id" => "decs"];
        $result = $this->whereFindInSet("category_path_id", $categoryId)
            ->where("status", "=", config("status.success"))
            ->order($order)
            ->field($field)
            ->limit($limit)
            ->select();
        //echo $this->getLastSql();exit;
        //SELECT sku_id as id,`title`,`price`,recommend_image as image FROM `mall_goods` WHERE FIND_IN_SET(71, `category_path_id`) AND `status` = 1 ORDER BY `listorder` DESC,`id` LIMIT 10
        return $result;
    }

    public function getNormalLists($data, $num = 10, $field = true, $order) {
        $res = $this;
        if(isset($data['category_path_id'])) {
            $res = $this->whereFindInSet("category_path_id", $data['category_path_id']);
        }
        $list = $res->where("status", "=", config("status.mysql.table_normal"))
            ->order($order)
            ->field($field)
            ->paginate($num);

        //echo $this->getLastSql();exit;
        return $list;
    }
}