<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 友情链接验证器
 * Class link
 * @package app\admin\validate
 */
class Link extends Validate
{
    protected $rule = [
        'name' => 'require'
    ];

    protected $message = [
        'name.require' => '请输入名称'
    ];
}