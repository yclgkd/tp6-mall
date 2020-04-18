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
}