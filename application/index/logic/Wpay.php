<?php
namespace app\index\logic;
use think\Model;
use think\Db;
use helper\PublicHelper;
use app\common\base\Mapper;

class Wpay extends Model{
    public function prepare_order($params){
        if(!isset($params['pid']) && empty($params['pid'])){
            msg("参数错误");
        }else{
            Db::startTrans();
            $opt=['id'=>$params['pid'], 'isdel'=>1];
            $price = db('agent_price')->where($opt)->find();
            $authAgent = db('auth_agent')->where(['id'=>$price['a_p_id']])->find();
            $data = [
                'uid' => session('?uid')? session('uid'):0, //用户UID
                'cid' => $params['qid'] , //商品ID
                'pid' => isset($price) && !empty($price) ? $price['id'] : 0 , //推广连接ID
                'cname' =>  $price['rename'],
                'p_type' => $price['product_type'],
                'p_name' => $price['rename'],
                'proxyid' => isset($price['uid']) ? $price['uid'] : 0, //代理UID
                'number_order' => PublicHelper::number(),
                'body' => Mapper::$WX_PRODUCE_NAME[$price['product_type']],
                'price' => $price['price']*100,
                'commission' => $authAgent['erjiprice'], //二级提成
                'source' => $params['source'],//支付类型
                'status' => 0,
                'isstop' => 1,
                'createdAt' => time(),
            ];
            $order=db("order")->insert($data);
            Db::commit();
            if($order===false){
                Db::rollback();
                msg("创建订单失败,请联系客服");
            }else{
                return $data;
            }
        }
    }

    public function wx_pay($params){
        $result = \wxpay\JsApiPay::getPayParams($params);
        return $result;
    }

    public function getPrice($params){
        $opt = ['id' => $params['pid'], 'isdel' => 1];
        $price = db('agent_price')->where($opt)->find();
        return $price;
    }

    // 拉起支付宝
    public function aly_pay($params){
        $sign=makeSign([['id'=>$params['cid'],'out_trade_no'=>$params['number_order']]]);
        $wap_config = [
                //合作身份者id，以2088开头的16位纯数字
            'partner' => '2088331380973764',
                //收款支付宝账号
            'seller_id' => '18062677701@163.com',
                // 商户的私钥（后缀是.pen）文件相对路径
            'private_key_path' => '/www/wwwroot/www.ddk.cn/extend/alipaywap/key/rsa_private_key.pem',
                //支付宝公钥（后缀是.pen）文件相对路径
            'ali_public_key_path' => '/www/wwwroot/www.ddk.cn/extend/alipaywap/key/alipay_public_key.pem',
                //签名方式
            'sign_type' => strtoupper('MD5'),
            'key' => 'ef19eg11mvccjaa0q0y4y36tbz5ysvdw',
                //字符编码格式 目前支持 gbk 或 utf-8
            'input_charset' => strtolower('utf-8'),
                //ca证书路径地址，用于curl中ssl校验
                //请保证cacert.pem文件在当前文件夹目录中
            'cacert' => getcwd() . '/Think/Library/Org/Alipaywap/cacert.pem',
                //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
            'transport' => 'http',
                //异步通知url base64_decode(base64_decode($params['cop']))
            'notify_url' => 'http://www.xinqianjincx.com/index/wxpay/alnotify',
                //跳转通知url
            'return_url' => 'http://www.xinqianjincx.com/index/index/detail?signs='.$sign,
            ];

            //构造要请求的参数数组
            $parameter = array(
                "service" => "alipay.wap.create.direct.pay.by.user",
                "partner" => $wap_config['partner'],
                "_input_charset" => strtolower($wap_config['input_charset']),
                "sign_type" => $wap_config['sign_type'],
                "notify_url" => $wap_config['notify_url'],
                "return_url" => isset($params['return_url']) ? $params['return_url'] : $wap_config['return_url'],
                "out_trade_no" => $params['number_order'],//商户订单号
                "subject" => '机构分析查询',//订单名称
                "total_fee" => $params['price'],//付款金额
                "seller_id" => $wap_config['seller_id'],
                "payment_type" => "1", //支付类型，不能修改
                "body" => '大数据查询分析优化',//订单描述
                "show_url" => '',//商品展示地址
                "it_b_pay" => '1h',//设置超时时间为1小时
            );
            if (isset($params['app_pay']) && $params['app_pay'] == 'Y') {
                $parameter['app_pay'] = 'Y'; //是否调起支付宝客户端进行支付
            }
            //建立请求
            $alipaySubmit = new \alipaywap\AlipaySubmit($wap_config);
            $html_text = $alipaySubmit->buildRequestForm($parameter, "post", '');
            echo $html_text;
    }
}