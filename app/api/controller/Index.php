<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/22
 * Time: 21:25
 */
namespace app\api\controller;

use app\common\business\Goods as GoodsBis;
use app\common\lib\Show;

class Index extends ApiBase {
    //首页推荐大图
    public function getRotationChart() {
        $result = (new GoodsBis())->getRotationChart();
        return Show::success($result);
    }

    /**
     * 分类商品推荐
     * @return \think\response\Json
     */
    public function categoryGoodsRecommend() {
        //71：女装 72：男装
        $categoryIds = [
            71,
            51
        ];
        $result = (new GoodsBis())->categoryGoodsRecommend($categoryIds);
        return Show::success($result);
    }
}