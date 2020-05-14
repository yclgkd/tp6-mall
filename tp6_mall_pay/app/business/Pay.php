<?php
/**
 * Created by singwa
 * User: singwa
 * motto: 现在的努力是为了小时候吹过的牛逼！
 * Time: 02:18
 */
namespace app\business;
use app\lib\ClassArr;
use think\facade\Cache;
use app\lib\Key;

class Pay {
    /**
     * 统一下单 - 扫码支付
     */
    public function unifiedOrder($appId, $payType, $data) {
        $classStats = ClassArr::payClassStat();
        $classObj = ClassArr::initClass($payType, $classStats, [], true);
        try {
            $result = $classObj->unifiedOrder($data);
        }catch (\Exception $e) {
            return false;
        }

        $orderData = [
            "pay_status" => 0, // 待支付  1:已支付
            "pay_type" => $payType,
            "create_time" => time(),
        ];
        try {
            //Cache::hSet();
            // 记录数据到redis中
            Cache::store('redis')->hSet(Key::Order($appId), $data['order_id'], json_encode($orderData));
            //Cache::hSet(Key::Order($appId), $data['order_id'], json_encode($orderData));
        }catch (\Exception $e) {
            echo $e->getMessage();exit;
            return false;
        }
        return ["code_url" => $result];
    }

    public function notify($payType, $data) {
//        $classStats = ClassArr::payClassStat();
//        $classObj = ClassArr::initClass($payType, $classStats, [], true);
//        try {
//            $result = $classObj->unifiedOrder($data);
//        }catch (\Exception $e) {
//            return false;
//        }
    }

    public function getOrder($orderId, $appId) {
        try {
            $result = Cache::store('redis')->hGet(Key::Order($appId), $orderId);
        }catch (\Exception $e) {
            $result = [];
        }
        if($result) {
            $result = json_decode($result, true);
        }
        return $result;
    }
}