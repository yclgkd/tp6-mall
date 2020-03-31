<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/3/31
 * Time: 12:43
 */
namespace app\demo\middleware;
class check {
    public function handle($request, \Closure $next) {
        $request->type = "demo-singwa";
        return $next($request);
    }

    /**
     * 中间件结束调度
     * @param \think\Response $response
     */
    public function end(\think\Response $response) {

    }
}