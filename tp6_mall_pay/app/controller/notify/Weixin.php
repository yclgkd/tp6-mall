<?php
/**
 * Created by singwa
 * User: singwa
 * motto: 现在的努力是为了小时候吹过的牛逼！
 * Time: 22:37
 */

namespace app\controller\notify;
use app\BaseController;
class Weixin extends BaseController
{
    public $payType = "weixin";

    /**
     *
     */
    public function index() {
        // 获取流式数据
        // input("param.");
        ///dump(input("param."));exit;
        $data = $this->request->getInput();
        // 测试数据是否在服务端能接收。。。
        //file_put_contents("/tmp/a.log", $data, FILE_APPEND);
        // 第一： 解析数据， 校验数据是否 订单 => redis ,
        // 要告诉微信 ， success ok,  redis hash
    }

//     <xml><appid><![CDATA[wx60f11480dce266ab]]></appid>
//    <bank_type><![CDATA[OTHERS]]></bank_type>
//    <cash_fee><![CDATA[12]]></cash_fee>
//    <fee_type><![CDATA[CNY]]></fee_type>
//    <is_subscribe><![CDATA[Y]]></is_subscribe>
//    <mch_id><![CDATA[1571949741]]></mch_id>
//    <nonce_str><![CDATA[3zzmo1075uj2shgt76pdrxh7ntdove2w]]></nonce_str>
//    <openid><![CDATA[oJmWawUNTJpPXqdvPt5PzQ9uVxxc]]></openid>
//    <out_trade_no><![CDATA[1111m1gd122sgsg253463]]></out_trade_no>
//    <result_code><![CDATA[SUCCESS]]></result_code>
//    <return_code><![CDATA[SUCCESS]]></return_code>
//    <sign><![CDATA[4AC3A4046BC1C61A1D518D6B12F7CC9CA0D48D426710BA0C0E28F9FE4635FC1E]]></sign>
//    <time_end><![CDATA[20200223124139]]></time_end>
//    <total_fee>12</total_fee>
//    <trade_type><![CDATA[NATIVE]]></trade_type>
//    <transaction_id><![CDATA[4200000508202002239368222928]]></transaction_id>
//    </xml>
}
