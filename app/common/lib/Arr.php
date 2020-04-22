<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/18
 * Time: 16:15
 */
namespace app\common\lib;

class Arr {
    public static function getTree($data) {
        $items = array();
        foreach ($data as $v) {
            $items[$v['category_id']] = $v;
        }
        $tree = [];
        foreach ($items as $id => $item) {
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['list'][] = &$items[$id];
            } else {
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
}