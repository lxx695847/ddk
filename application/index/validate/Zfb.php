<?php

namespace app\index\validate;


use think\Validate;

class Zfb extends Validate{
    protected $rule = [
        'bankname' => 'require',
        'wname' => 'require|chsAlpha',
        'phone' => 'require|regex:\d{11}',

    ];

    protected $message = [
        'wname.require' => '提现名称不能为空',
        'wname.chsAlpha' => '用户名只能是汉字、字母',
        'bankname.require' => '支付宝账号不能为空',
        'phone.require' => '联系人手机号码不能为空',
        'phone.regex' => '请填写正确的手机号码',
    ];
}