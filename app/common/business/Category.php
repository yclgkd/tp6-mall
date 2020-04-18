<?php
/**
 * 分类管理前台和后台都需要用到
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/15
 * Time: 13:21
 */
namespace app\common\business;

use app\common\model\mysql\Category as CategoryModel;

class Category {
    public $model = null;
    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function add($data) {
        $data['status'] = config("status.mysql.table_normal");
        $name = $data['name'];
        // 根据$name去数据库查询是否存在这条记录
        if ($this->model->getCategoryByCategoryName($name)) {
           throw new \think\Exception("分类名已存在");
        }
        try {
            $this->model->save($data);
        } catch (\Exception $e) {
            throw new \think\Exception("服务内部异常");
        }
        //返回最后一个新增ID
        //return $this->model->getLastInsID();
        return $this->model->id;
    }

    public function getNormalCategories() {
        $field = "id, name, pid";
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
            // todo：记录日志
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
            //todo:记录日志
            return false;
        }
        return $res;
    }
}