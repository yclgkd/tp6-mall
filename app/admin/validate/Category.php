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
    ];

    protected $message = [
        'name' => '分类名必须',
        'pid' => '父类ID必须',
    ];
}