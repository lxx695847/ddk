<?php

namespace app\index\validate;

use think\Validate;

class Collect extends Validate{

    protected $rule = [
        'name' => 'require',
        'logo' => 'require',

    ];

    protected $message = [
        'name.require' => '平台名称不能为空',
        'logo.require' => '平台logo不能为空',
    ];



}