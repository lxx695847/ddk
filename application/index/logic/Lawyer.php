<?php
namespace app\index\logic;
use think\Model;

class Lawyer extends Model{
    public function getList($sign="",$param=[]){
        $price=[];
        if(isset($sign) && !empty($sign)){
            $params=desSign($sign,$param);
           if($params==false){
               msg("版本签名有误,请联系代理商重新更换版本连接");
           }else{
               if(!isset($params['pid']) && empty($params['pid'])){
                   msg('版本信息有误,请联系代理商重新更换版本连接');
               }else{
                   $opt=['id'=>$params['pid'], 'isdel'=>1];
                   $price=db('agent_price')->where($opt)->find();
                   //版本信息
                   if(!isset($price) || empty($price)){
                       msg('版本信息有误,请联系代理商重新更换版本连接');
                   }

                   //授权代理数据
                   $authAgent=db('auth_agent')->where(['id'=>$price['a_p_id']])->find();
                   if(!isset($authAgent) && empty($authAgent)){
                       msg('授权代理信息错误,请联系代理商重新更换');
                   }

                   //代理
                   $agent=db('agent')->where(['id'=>$authAgent['aid']])->find();
                   if(!isset($agent) && empty($agent)){
                       msg('授权代理信息错误,请联系代理商重新更换');
                   }

                   //版本信息
                   $product =  db('product')->where(['id'=>$authAgent['pid']])->find();
                   if(!isset($product) && empty($product)){
                       msg('授权代理信息错误,请联系代理商重新更换');
                   }

                   //判断版本价格是否大于设置的最高价格
                   if($price['price'] > $authAgent['highestprice']){
                       msg('支付金额已超出平台规定价格,请联系代理商重新更换');
                   }

                   //判断代理设置的价格是否低于平台版本价，测试账号除外
                   if($price['price'] < $authAgent['price']){
                       msg('支付金额已低于平台成本价格,请联系代理商重新更换');
                   }
               }
           }
        }else{
            msg("版本签名缺失,请联系代理商重新更换版本连接");
        }

        $res=db("lawyer_question")->order('reads desc')->select();
        foreach ($res as $k=>$v){
            $params['qid']=$v['id'];
            $res[$k]['sign']=makeSign($params);
            $res[$k]['count']=db("lawyer_answer")->where(['qid'=>$v['id']])->count();
        }
        $list=[
            'price'=>$price,
            'res'=>$res
        ];
        return $list;
    }
}