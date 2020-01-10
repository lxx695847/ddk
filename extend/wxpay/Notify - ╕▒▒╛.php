<?php
namespace wxpay;
use think\Loader;
require_once 'lib/WxPayException.php';
Loader::import('wxpay.lib.WxPayApi');
Loader::import('wxpay.lib.WxPayNotify');
/**
 * 异步通知处理类
*/
class Notify extends \WxPayNotify
{
    /**
     * 此为主函数, 即处理自己业务的函数, 重写后, 框架会自动调用
     *
     * @param array $data 微信传递过来的参数数组
     * @param string $msg 错误信息, 用于记录日志
     */
    public function NotifyProcess($data, &$msg)
    {
        // 一下均为实例代码
        // 1.校检参数
        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }

        // 2.微信服务器查询订单，判断订单真实性(可不需要)
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }

        // 3.去本地服务器检查订单状态(强烈建议需要)
        $order = $this->getOrder($data);
        if(empty($order)) {
            $msg = '本地订单不存在';
            return false;
        }

        // 4.检查订单状态
        if($this->checkOrderStatus($order)) {
            // 如果订单处理过, 则直接返回true
            return true;
        }

        // 订单状态未修改情况下, 进行处理业务
        $result = $this->processOrder($order, $data);
        if(!$result) {
            $msg = '订单处理失败';
            return false;
        }

        return true;
    }

    /**
     * 处理核心业务
     * @param  array $order 订单信息
     * @param  array $data  通知数组
     * @return Bollean
     */
    public function processOrder($order, $data)
    {
        // 进行核心业务处理, 如更新状态, 发送通知等等
        // 处理成功, 返回true, 处理失败, 返回false
        // 例如:
      
      //查询有没有订单进来sales表
       $sales=db('sales')->where('id','=', $order['id'])->find();
      //如果有，查询改订单是否已经有为1的状态
      if($sales)
      {
        
        //执行查询
        $tag=db('sales')->where('id','=', $order['id'])->where('status','=',1)->find();
        //如果有，就不管了，如果没有，改1，并执行其他操作
        if(!$tag)
        {
        	 $result = db('sales')->where('id', $order['id'])->update(['status'=>1, 'transaction_id'=>$data['transaction_id']]);
          	//准备数据，准备插入查询表
          	 $user=db('user')->where('id','=', $sales['uid'])->find();
             //查询查询用户
          $sessionuser=db('user')->where('id','=', $sales['sessionid'])->find();
          	$userid=session('uid');
          if(empty($userid)){
          $userid=$sales['sessionid'];
          }
       		 $datas=[
                  'ordernumber'=>$sales['body'],
                  'uid'=> $userid,
                  'dates'=>time(),
                  'remarks'=>0,
                  'pid'=>$sales['pid'],
                  'price'=>$sales['total_fee']/100,
                  'sid'=>$sales['id'],
                  'names'=>$user['names'],
                  'idcard'=>$user['idcard'],
                  'tel'=>$user['mobile']
                 ];
          	$chaxunid=db('chaxun')->insertGetId($datas);
          	//判断是否扫码
            $fpid=session('fpid');
            if(!empty($fpid)){
               
            
          	//插入完成后，算提成
          	//如果查的是专业版和高级版，就算提成，如果不是，不算提成，直接给结果
          	if($sales['pid'] == 2 or $sales['pid'] == 3){
                if(!empty($chaxunid))
                {
                  //查询上级信息
                  $useryiji=db('user')
                  ->alias('u')
                  ->join('sun_agent a','u.agent_class=a.id')
                  ->field('u.*,a.ratio1,a.ratio2,a.ratio3,a.ratio4,a.ratio5,a.ratio6')
                  ->where('u.id','=',$sessionuser['pid'])->find();
                   //查询分成金额
                  //$productyiji=db('product')->where('id','=', $sales['pid'])->find();
				  //判断是中级还是高级
                  if($sales['pid'] == 2){
                    $tichengs=$useryiji['ratio3'];
                  }else if($sales['pid'] == 3){
                    $tichengs=$useryiji['ratio5'];
                  }
                  
                  //$tichengs=intval($sales['total_fee']*$useryiji['ratio1']/100);
                  
                  
                  
                  $balance=$useryiji['money']+$tichengs;

                    $datayiji=[
                      'order_id'=>$sales['body'],
                      'profit_id'=>$useryiji['id'],
                      'ratio'=>$useryiji['ratio1'],
                      'create_time'=>time(),
                      'money'=>$tichengs,
                      'type'=>"直推奖励",
                      'balance'=>$balance
                                  ];

                    $chaxun_ids=db('profit')->insertGetId($datayiji);
                   if(!empty($chaxun_ids))
                   {
                      	$moneyyi['money']=$balance;
      					        $moneyyi['id']=$useryiji['id'];


                         $updateuser=db('user')->update($moneyyi);
                      if($updateuser){
                        $usererji=db('user')
                        ->alias('u')
                        ->join('sun_agent a','u.agent_class=a.id')
                        ->field('u.*,a.ratio1,a.ratio2,a.ratio3,a.ratio4,a.ratio5,a.ratio6')
                        ->where('u.id','=',$useryiji['pid'])->find();
                        
                        
                           //查询分成金额
                  //$producterji=db('product')->where('id','=', $sales['pid'])->find();
				  //判断是中级还是高级
                    if($sales['pid'] == 2){
                   $tichengss=$usererji['ratio4'];
                  }else if($sales['pid'] == 3){
                    $tichengss=$usererji['ratio6'];
                  }
                        
                        //$tichengss=intval($sales['total_fee']*$usererji['ratio2']/100);
                        $balances=$usererji['money']+$tichengss;


                            if($usererji)
                            {
                              $dataerji=[
                                'order_id'=>$sales['body'],
                                'profit_id'=>$usererji['id'],
                                'ratio'=>$usererji['ratio2'],
                                'create_time'=>time(),
                                'money'=>$tichengss,
                                'type'=>"二级奖励",
                                'balance'=>$balances
                                            ];

                             	 $chaxuner=db('profit')->insertGetId($dataerji);

                             	if(!empty($chaxuner))
                                {
                                $moneyer['money']=$balances;
                                $moneyer['id']=$usererji['id'];
                                $updateuserer=db('user')->update($moneyer);

                                  return $result;
                              	}

                            }
                      }else{
                              return $result;
                        }
                    }
                  }
     		       }
              }
          	else
            {
            	//直接给查询结果即可，不提成
              	return $result;
            }
          
        }
      	
        
      }
      //如果没有，
      else
      {
      	return;
      }
      
      
      
      
      
      
      		
      
  
    }


    // 去微信服务器查询是否有此订单
    public function Queryorder($transaction_id)
    {
        $input = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = \WxPayApi::orderQuery($input);
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    // 去本地服务器查询订单信息
    public function getOrder($data)
    {
        // 可根据商户订单号进行查询
        // 例如:
        $order = db('sales')->where('out_trade_no', $data['out_trade_no'])->find();
        return $order;
    }

    /**
     * 检查order状态, 是否已经做过修改, 避免重复修改
     * 原因: 可能由于业务处理较慢, 还未等回复微信服务器, 同一订单的另一个通知已到达,
     *      为了避免重复修改订单, 需要对状态进行检查
     *
     * @return Bollean
     */
    public function checkOrderStatus($order)
    {
        // 检查还未修改, 则返回true, 检查已经修改过了, 则返回false
        // 例如:
        return $order['status'] == 1 ? true : false;
    }

}

