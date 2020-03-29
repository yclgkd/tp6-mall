<?php
/**
 * Author: Troku<chunlai0928@foxmail.com>
 * Date: 2020/2/20
 * Time: 16:08
 */
namespace app\controller;

use app\Request;
use think\facade\Request as ABC;

class Learn{
    public function index(Request $request) {
        dump($request->request("abc"));
        dump(input("abc"));
        dump(request()->param("abc"));
        dump(ABC::param("abc"));
    }
}