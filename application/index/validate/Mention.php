<?php

namespace app\index\validate;


use think\Validate;

class Mention extends Validate{
    protected $rule = [
        'price' => 'require|number|egt:50',
        'type'=>'in:1,2',
    ];

    protected $message = [
        'price.require' => '提现金额不能为空',
        'price.number' => '提现金额必须是数字',
        'price.egt' => '提现金额不能低于50',
        'type.in' => '提现参数错误'
    ];
}