<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/18
 * Time: 16:15
 */
namespace app\common\lib;

class Arr {
    /**
     * 无限极分类
     * @param $data
     * @return array
     */
    public static function getTree($data) {
        $items = array();
        foreach ($data as $v) {
            $items[$v['category_id']] = $v;
        }
        $tree = [];
        foreach ($items as $id => $item) {
            if (isset($items[$item['pid']])) { //pid为非0值，即不是一级分类
                $items[$item['pid']]['list'][] = &$items[$id]; //&:允许用两个变量来指向同一个内容
            } else { //pid为0值，此分类是一级分类
                $tree[] = &$items[$id];
            }
        }
        return $tree;
    }

    public static function sliceTreeArr($data, $firstCount = 5, $secondCount = 3, $threeCount = 5) {
        $data = array_slice($data, 0, $firstCount);
        foreach ($data as $k => $v) {
            if (!empty($v['list'])) {
                $data[$k]['list'] = array_slice($v['list'], 0, $secondCount);
                foreach ($v['list'] as $kk => $vv) {
                    if (!empty($vv['list'])) {
                        $data[$k]['list'][$kk]['list'] = array_slice($vv['list'], 0, $threeCount);
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 分页默认返回的数据
     * @param $num
     * @return array
     */
    public static function getPaginateDefaultData($num) {
        $result = [
            "total" => 0,
            "per_page" => $num,
            "current_page" => 1,
            "last_page" => 0,
            "data" => [],
        ];
        return $result;
    }

    public static function search() {
        $result = [
            "name" => "一级分类",
            //分类的定位焦点 ，注意这个地方 有可能是一个，有可能是两个，也有可能没有
            "focus_ids" => [1, 11],
            "list" => [
                [
                    ["id" => 1, "name" => "二级分类1"],
                    ["id" => 2, "name" => "二级分类2"],
                    ["id" => 3, "name" => "二级分类3"],
                    ["id" => 4, "name" => "二级分类4"],
                    ["id" => 5, "name" => "二级分类5"],
                ],

                [
                    ["id" => 11, "name" => "三级分类1"],
                    ["id" => 12, "name" => "三级分类2"],
                    ["id" => 13, "name" => "三级分类3"],
                    ["id" => 14, "name" => "三级分类4"],
                    ["id" => 15, "name" => "三级分类5"],
                ],
            ],
        ];
        return $result;
    }
}