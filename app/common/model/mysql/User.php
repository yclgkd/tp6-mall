<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/3
 * Time: 17:05
 */

namespace app\common\model\mysql;

use think\Model;

class User extends Model
{
    /**
     * 根据用户名获取后端表的数据
     * getAdminUserByUsername
     * @param $username 用户名
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminUserByUsername($username)
    {
        if (empty($username)) {
            return false;
        }
        $where = [
            "username" => $username,
        ];
        return $this->where($where)->find();
    }

    /**
     * 根据主键ID更新数据表中的数据
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id, $data)
    {
        $id = intval($id);
        if (empty($id) || empty($data) || !is_array($data)) {
            return false;
        }
        $where = [
            "id" => $id,
        ];
        return $this->where($where)->save($data);
    }
}
