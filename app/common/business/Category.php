<?php
/**
 * 分类管理前台和后台都需要用到
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/15
 * Time: 13:21
 */
namespace app\common\business;

use app\common\model\mysql\Category as CategoryModel;
use app\common\lib\Arr;

class Category {
    public $model = null;
    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function add($data) {
        //开启事务
        $this->model->startTrans();
        try {
            $data['status'] = config("status.mysql.table_normal");
            $name = $data['name'];
            //获取他上级分类的path
            $res = $this->model->getCategoryId($data['pid']);
            $res = $res->toArray();
            $path = $res[0]["path"];
            // 根据$name去数据库查询是否存在这条记录
            if ($this->model->getCategoryByCategoryName($name)) {
                throw new \think\Exception("分类名已存在");
            }
            //首先保存分类名
            $this->model->save($data);
            //获取最后一个新增ID return $this->model->getLastInsID();
            $id = $this->model->id;
            $path = $path.",".$id;
            $data = [
                "path" => $path
            ];
            //通过拼接path，再做一次更新
            $this->model->updateById($id, $data);
            //事务提交
            $this->model->commit();
            return $id;
        } catch (\think\Exception $e) {
            //事务回滚
            $this->model->rollback();
            throw new \think\Exception("服务内部异常");
        }
    }

    public function getNormalCategories() {
        $field = "id, name, pid";
        $categories = $this->model->getNormalCategories($field);
        if (!$categories) {
            return [];
        }
        return $categories->toArray();
    }

    public function getNormalAllCategories() {
        $field = "id as category_id, name, pid";
        $categories = $this->model->getNormalCategories($field);
        if (!$categories) {
            return [];
        }
        return $categories->toArray();
    }

    public function getLists($data, $num) {
        $list = $this->model->getLists($data, $num);
        if (!$list) {
            return [];
        }
        $result = $list->toArray();
        $result['render'] = $list->render();
        //获取分类下的子分类
        $pids = array_column($result['data'], "id");
        if ($pids) {
            $idCountResult = $this->model->getChildCountInPids(['pid' => $pids]);
            $idCountResult = $idCountResult->toArray(); //如果没有的话返回空数组
            $idCounts = [];
            foreach ($idCountResult as $countResult) {
                $idCounts[$countResult['pid']] = $countResult['count'];
            }
        }
        if ($result['data']) {
            foreach ($result['data'] as $k => $value) {
                //$result['data'][$k]['childCount'] = isset($idCounts[$value['id']]) ? $idCounts[$value['id']] : 0;
                $result['data'][$k]['childCount'] = $idCounts[$value['id']] ?? 0;
            }
        }

        return $result;
    }

    //根据Id获取某条记录
    public function getById($id) {
        $result = $this->model->find($id);
        if (empty($result)) {
            return [];
        }
        $result = $result->toArray();
        return $result;
    }

    //排序
    public function listorder($id, $listorder) {
        //查询这条数据是否存在
        $res = $this->getById($id);
        if (!$res) {
            throw new \think\Exception("不存在该条记录");
        }
        $data = [
            "listorder" => $listorder
        ];
        try {
            $res = $this->model->updateById($id, $data);
        } catch (\Exception $e) {
            //记录日志
            trace("Category-listorder-SeverException".$e->getMessage(), "error");
            return false;
        }
        return $res;
    }

    //更新状态
    public function status($id, $status) {
        $res = $this->getById($id);
        if (!$res) {
            throw new \think\Exception("不存在该条记录");
        }
        if ($res['status'] ==  $status) {
            throw new \think\Exception("修改值与原数值不能一样");
        }
        $data = [
            "status" => $status,
        ];
        try {
            $res = $this->model->updateById($id, $data);
        } catch (\Exception $e) {
            //记录日志
            trace("Category-status-SeverException".$e->getMessage(), "error");
            return false;
        }
        return $res;
    }

    /**
     * 获取一级分类的内容
     * @param int $pid
     * @param string $field
     * @return array
     */
    public function getNormalByPid($pid = 0, $field = "id, name, pid") {
        //$field = "id, name, pid";
        try {
            $res = $this->model->getNormalByPid($pid, $field);
        } catch (\Exception $e) {
            //记录日志
            trace("Category-getNormalByPid-SeverException".$e->getMessage(), "error");
            return [];
        }
        $res = $res->toArray();
        return $res;
    }

    public function getCategoryTreeByPids($categoryIds) {
        if (!is_array($categoryIds)) {
            return [];
        }
        $categoryInfo = $this->model->getCategoryTreeByPids($categoryIds);
        $categoryInfo = $categoryInfo->toArray();
        if (empty($categoryInfo)) {
            return [];
        }
        return Arr::getTree($categoryInfo);
    }

    public function search($id) {
        try {
            $result = [];
            $res = $this->model->getCategoryId($id)->toArray();
            // 获取path值
            $categoryPath = explode(",", $res[0]['path']);
            //获取一级分类名称
            $categoryOne = array_slice($categoryPath, 0, 1);
            $result["name"] = $this->model
                ->getCategoryId($categoryOne, "name")
                ->toArray()[0]['name'];
            //获取定位点focus_ids
            $result["focus_ids"] = array_slice($categoryPath, 1);
            foreach ($result['focus_ids'] as $key => $value) {
                $result['focus_ids'][$key] = intval($value);
            }
            //获取子分类list
            array_pop($categoryPath);
            if (count($categoryPath) == 0) {
                $result['list'][0] = $this->model
                    ->getNormalByPid($categoryOne, "id, name")
                    ->toArray();
            } else {
                foreach ($categoryPath as $k => $v) {
                    $result['list'][$k] = $this->model
                        ->getNormalByPid($v, "id, name")
                        ->toArray();
                }
            }
        } catch (\Exception $e) {
            //记录日志
            trace("Category-search-SeverException".$e->getMessage(), "error");
            return Arr::search();
        }
        return $result;
    }

    public function sub($id) {
        try {
            $result =  $this->model->getNormalByPid($id, "id,name")->toArray();
        } catch (\Exception $e) {
            //记录日志
            trace("Category-sub-SeverException".$e->getMessage(), "error");
            return [];
        }
        return $result;
    }
}