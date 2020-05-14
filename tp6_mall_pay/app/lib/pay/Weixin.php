<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/29
 * Time: 13:34
 */
namespace app\lib\pay;
use app\lib\pay\weixin\lib\database\WxPayUnifiedOrder;
use app\lib\pay\weixin\lib\WxPayNativePay;

class Weixin implements PayBase{

    /**
     * 统一下单API
     * @param $data
     * @return string
     */
    public function unifiedOrder($data) {
        try {
            $notify = new WxPayNativePay();
            $input = new WxPayUnifiedOrder();
            // 业务的标题
            $input->SetBody($data['body']);
            $input->SetOut_trade_no($data['order_id']);
            $input->SetTotal_fee($data['total_price']);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + config("pay.pay_expire.weixin")));
            $input->SetNotify_url(config("pay.pay_notify.weixin"));
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id($data['goods_id']);

            $result = $notify->GetPayUrl($input);
            // 记录日志 $result
        }catch(\Exception $e) {
            throw new \Exception("对接微信支付内部异常");
        }
        if($result  && isset($result['result_code'])
            && isset($result['return_code'])
            && $result['result_code'] == "SUCCESS"
            && $result['return_code'] == "SUCCESS"
        ) {
            $url = $result["code_url"];
            return request()->domain().(string)url("qcode/index", ["data"=>$url]);
        } else {

            throw new \Exception("下单失败，请稍候重试");
        }
    }
}