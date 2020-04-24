<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/24
 * Time: 16:58
 */
namespace app\api\controller\mall;

use app\api\controller\ApiBase;
use app\common\lib\Show;
use app\common\business\Goods as GoodsBis;

class Lists extends ApiBase {
    public function index() {
        $pageSize = input("param.page_size", 10, "intval");
        $categoryId = input("param.category_id", 0, "intval");
        if (!$categoryId) {
            return Show::success();
        }
        $data = [
            "category_path_id" => $categoryId
        ];
        $field = input("param.field", "listorder", "trim");
        $order = input("param.order", 2, "intval");
        $order = $order == 2 ? "desc" : "asc";
        $order = [$field => $order];
        $goods= (new GoodsBis())->getNormalLists($data, $pageSize, $order);
        return Show::success($goods);
    }
}