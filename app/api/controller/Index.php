<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/22
 * Time: 21:25
 */
namespace app\api\controller;

use app\common\business\Goods as GoodsBis;

class Index extends ApiBase {
    public function getRotationChart() {
        $result = (new GoodsBis())->getRotationChart();
        return show(config("status.success"), "OK", $result);
    }
}