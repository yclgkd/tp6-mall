<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/27
 * Time: 22:37
 */

namespace app\controller;

use app\lib\pay\weixin\lib\database\WxPayUnifiedOrder;
use app\lib\pay\weixin\lib\WxPayNativePay;
// 必须要添加这个哦。
use think\annotation\Route;
use app\lib\Show;

use app\business\Pay as PayBis;
use think\facade\Cache;
class Pay extends AuthBase
{

    /**
     * 支付demo
     */
    public function index() {
        $notify = new WxPayNativePay();
        $input = new WxPayUnifiedOrder();
        //title
        $input->SetBody("Troku商城");
        $input->SetAttach("欢迎选购");
        //订单号
        $input->SetOut_trade_no("Troku".date("YmdHis"));
        //支付金额
        $input->SetTotal_fee("1");
        //时间戳开始时间
        $input->SetTime_start(date("YmdHis"));
        //过期时间
        $input->SetTime_expire(date("YmdHis", time() + 300));
        $input->SetGoods_tag("test");
        //回调地址，对支付的结果进行处理
        $input->SetNotify_url("http://192.168.37.6/pay/notify/weixin"); // 回调地址公网可访问
        $input->SetTrade_type("NATIVE");
        //订单ID
        $input->SetProduct_id("123456789");
        //微信支付返回的url
        $result = $notify->GetPayUrl($input);
        $url2 = $result["code_url"];

        echo "<img src='".url("qcode/index", ["data"=>$url2])."'>";
        //支付二维码
//        echo "<img src='http://192.168.37.6/qcode/index.html?data=weixin%3A%2F%2Fwxpay%2Fbizpayurl%3Fpr%3DyfUgY5H'>";
    }

    /**
     * 下单API
     * @return string
     * @Route("unifiedOrder", method="POST")
     */
    public function unifiedOrder() {
        // todo:基本参数校验
        $params = input("param.");
        try {
            $result = (new PayBis())->unifiedOrder($this->appId, $this->payType, $params);
        }catch (\Exception $e) {
            return Show::error($e->getMessage());
        }
        if(!$result) {
            return Show::error("下单失败");
        }
        return Show::success($result);
    }

    /**
     * @Route("getOrder", method="POST")
     * 对外API
     */
    public function getOrder() {
        try {
            $orderId = input("param.order_id", "", "trim");
            if (!$orderId) {
                return Show::error("订单ID错误");
            }
            $result = (new PayBis())->getOrder($orderId, $this->appId);
        }catch (\Exception $e) {
            //echo $e->getMessage();exit;
            return Show::error();
        }
        if(!$result) {
            return Show::error();
        }
        return Show::success($result);
    }
}
