<?php
namespace app\index\validate;

class newAgent extends Base{
    protected $rule = [
        'price'   =>  'require|number',
        'price1'  =>  'require|number',
        'money'   =>  'require|number',
        'wname'   =>  'require',
        'bankname'  =>  'require|number',
        'phone'   =>  'require|number|length:11',
        'bname'   =>  'require',
        'banknumber'  =>  'require|number|length:19'
    ];

    //定义字段描述信息
    protected $field = [
        'price'    =>   '成本价',
        'price1'   =>   '查询价',
        'money'    =>   '提现金额',
        'wname'    =>   '支付名',
        'bankname'    =>   '支付账号',
        'phone'    =>   '联系方式',
        'bname'    =>   '卡户名',
        'banknumber'   =>   '银行卡账号'
    ];

    //定义错误提示信息
    protected $message = [
        'price.require'   =>  '查询价必须',
        'price1.require'  =>  '热门问题价格必须',
        'money.require'   =>  '提现金额必须',
        'wname.require'   =>  '支付名必须',
        'bankname.require'  =>  '支付账号必须',
        'phone.require'   =>  '联系方式必须',
        'bname.require'   =>  '卡户名必须',
        'banknumber.require'  =>  '银行卡账号必须'
    ];

    //定义场景
    protected $scene = [
        'lawyer' =>  ['price','price1'],
        'withdraw'  =>   ['money'],
        'alipay'    =>   ['wname','bankname','phone'],
        'bank'      =>   ['bname','banknumber','phone']
    ];
}