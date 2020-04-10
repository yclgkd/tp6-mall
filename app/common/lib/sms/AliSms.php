<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/4
 * Time: 22:12
 */
declare(strict_types=1);
namespace app\common\lib\sms;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class AliSms {
    /**
     * 阿里云发送短信验证码的场景
     * @param string $phone
     * @param int $code
     * @return bool
     * @throws ClientException
     */
    public static function sendCode(string $phone, int $code)   : bool{
        if (empty($phone) || empty($code)) {
            return false;
        }


        $templateParam = [
            "code" => $code,
        ];
        AlibabaCloud::accessKeyClient(config("aliyun.access_key_id"), config("aliyun.access_key_secret"))
            ->regionId(config("aliyun.region_id"))
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host(config("aliyun.host"))
                ->options([
                    'query' => [
                        'RegionId' => config("aliyun.region_id"),
                        'PhoneNumbers' => $phone,
                        'SignName' => config("aliyun.sign_name"),
                        'TemplateCode' => config("aliyun.template_code"),
                        'TemplateParam' => json_encode($templateParam),
                    ],
                ])
                ->request();
            //print_r($result->toArray());
        } catch (ClientException $e) {
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        }
        return true;
    }
}