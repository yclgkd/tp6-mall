<?php
/**
 * 支付pay 服务 公共API
 */
namespace app\controller;

class AuthBase extends ApiBase {

    public $appId = "";
    public $token = "";
    public $time = 0;
    public $userId = 0;
    public function initialize() {
        //
        //59a387e24211c4feb09ea27da9da8d98 1582452200
        //$t = time();
        //echo md5($t."&mp"."troku_mall&mpm*68+0sg_12")."<br />";
        //echo $t;
        //exit;
        parent::initialize();
        $this->appId = input("param.appid", "", "trim");
        $this->token = input("param.token", "", "trim");
        $this->time = input("param.time", 0, "intval");
        $this->userId = input("param.user_id", 0, "intval");
        if(!$this->appId || !$this->token || !$this->time || !$this->userId) {
            //$this->show("appid,token,time字段不能为空");
        }
        //$this->checkAuth();
    }

    /**
     * app_id:
     * app_key:
     * access_token:
     * post请求
     */
    public function checkAuth() {
        $app = config("appuser.{$this->appId}");
        if(!$app) {
            $this->show("不存在该appid，请联系支付平台负责人申请开通", ["appid" => $this->appId]);
        }

        $data = [
            $this->time,
            $this->appId,
            $app["key"],
            $this->userId,
        ];
        // 时间检验
        if ($app['expire'] + $this->time < time() ) {
            //$this->show("请求token时间已过期，请重新生成token");
        }
        // token检验  $this->time."_".$this->appId."_".$app["key"]
        if($this->token != md5(implode($app['stitching_symbol'], $data))) {
           // $this->show("不合法的请求，请检验token是否合法");
        }
        // todo:把token放到redis 只让token用一次 => 安全
        //dump($app);exit;
        return true;
    }
}
