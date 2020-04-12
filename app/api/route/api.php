<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/9
 * Time: 16:41
 */
use \think\facade\Route;

Route::rule("smscode", "sms/code", "POST");
Route::resource('user', "User");