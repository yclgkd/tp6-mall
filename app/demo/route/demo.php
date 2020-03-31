<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/29
 * Time: 20:08
 */
use think\facade\Route;

Route::rule("test", "index/hello", "GET");
Route::rule("detail", "detail/index", "GET")->middleware(\app\demo\middleware\Detail::class);
