<?php

namespace app\index\validate;


use think\Validate;

class Bank extends Validate{
    protected $rule = [
        'banknumber' => 'require|number',
        'bname' => 'require|chsAlpha',
        'phone' => 'require|regex:\d{11}',

    ];

    protected $message = [
        'bname.require' => '提现名称不能为空',
        'bname.chsAlpha' => '用户名只能是汉字、字母',
        'banknumber.require' => '银行卡号不能为空',
        'banknumber.number' => '银行卡号只能为数字',
        'phone.require' => '联系人手机号码不能为空',
        'phone.regex' => '请填写正确的手机号码',
    ];
}