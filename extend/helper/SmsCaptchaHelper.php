<?php

namespace helper;


use app\common\base\Client;
use app\common\model\Captcha;
use think\Exception;
class SmsCaptchaHelper extends HelperClass {


    /**
     * 发送短信验证码
     * @param $mobile
     * @param $captcha
     * @return bool
     * @throws \Exception
     */
    public static function sendSms($mobile, $captcha) {
        $params = [
            'code' => $captcha,
        ];
        $client = new Client();
        $client->sendCaptcha($mobile, $params);
        return true;
    }

    /**
     * 发送验证码
     * @param $targetType
     * @param $targetId
     * @param $mobile
     * @param string $type
     * @return bool
     * @throws Exception
     */
    public static function send($mobile) {
        try {
            $captcha = rand(100000, 999999) . '';
            static::create($mobile, $captcha);
            static::sendSms($mobile, $captcha);
        } catch (\Exception $e) {
            throw new Exception('短信发送失败', 0);
        }
        return true;
    }

    /**
     * 创建验证码记录
     * @param string $targetType
     * @param integer $userId
     * @param string $mobile
     * @param string $captcha
     * @param string $type
     * @return \com\wanxin\erp\common\models\SmsCaptcha
     */
    protected static function create($mobile, $captcha, $type = 1) {
        $params = [
            'type' => $type,
            'mobile' => $mobile,
            'code' => $captcha,
            'endtime' => strtotime('+ 30 minute',time()),
            'email' => '0',
            'status' => '1',
            'createdAt' => time(),
        ];
        $captcha = new Captcha();
        return $captcha->allowField(true)->save($params);
    }

}