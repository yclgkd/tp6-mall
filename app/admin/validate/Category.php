<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/15
 * Time: 12:57
 */
namespace app\admin\validate;

use think\Validate;

class Category extends Validate {
    protected $rule = [
        'name' => 'require',
        'pid' => 'require',
        'id' => 'require',
        'listorder' => 'require',
        'status' => 'require|in:0,1,99'
    ];

    protected $message = [
        'name' => '分类名必须',
        'pid' => '父类ID必须',
        'id' => 'Id必须',
        'listorder' => 'listorder必须',
        'status.require' => '状态必须',
        'status.in' => '状态数值错误'
    ];

    protected $scene = [
        'addCategory' => ['name', 'pid'],
        'listorder' => ['id', 'listorder'],
        'updateStatus' => ['id', 'status']
    ];
}