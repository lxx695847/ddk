<?php
namespace app\backend\validate;

class newWithdraw extends Base{
    protected $rule = [
        'user_id'  => 'require',
        'name'   =>   'require',
        'money'   =>  'require|number',
        'bankcard'  =>  'require|number|length:19',
        'mobile'  =>  'require|number|length:11',
        'price'   =>  'require|number',
        'price1'  =>  'require|number'
    ];

    //定义字段描述信息
    protected $field = [
        'user_id'  =>  '用户',
        'name'    =>   '提现名',
        'money'    =>   '提现金额',
        'bankcard'   =>   '提现账号',
        'mobile'   =>   '提现手机号',
        'price'  =>   '查询价格',
        'price1'  =>  '热门问题价格'
    ];

    //定义错误提示信息
    protected $message = [
        'user_id'  =>  '用户必须',
        'name.require'  =>   '提现名必须',
        'money.require'   =>  '提现金额必须',
        'bankcard.require'  =>  '提现账号必须',
        'price.require'  =>   '查询价格必须',
        'price1.require'  =>  '热门问题价格必须',
    ];

    //定义场景
    protected $scene = [
        'withdraw' =>  ['user_id','name','money','bankcard','mobile'],
        'system'   =>  ['price'],
        'lawyer'  =>   ['price','price1']
    ];
}