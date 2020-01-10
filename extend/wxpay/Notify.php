<?php

namespace wxpay;

use app\common\base\DigitalHelper;
use think\Loader;
use Corebairo\Corebairo;
use Con\Con;

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
        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            return false;
        }

        // 2.微信服务器查询订单，判断订单真实性(可不需要)
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            return false;
        }

        // 3.去本地服务器检查订单状态(强烈建议需要)
        $order = $this->getOrder($data);
        if (empty($order)) {
            $msg = '本地订单不存在';
            return false;
        }

        // 4.检查订单状态
        if ($this->checkOrderStatus($order)) {
            // 如果订单处理过, 则直接返回true
            return true;
        }

        // 订单状态未修改情况下, 进行处理业务
        $result = $this->processOrder($order, $data);
        if (!$result) {
            $msg = '订单处理失败';
            return false;
        }

        return true;
    }

    /**
     * 处理核心业务
     * @param  array $order 订单信息
     * @param  array $data 通知数组
     * @return Bollean
     */
    public function processOrder($order, $data)
    {
        // 进行核心业务处理, 如更新状态, 发送通知等等
        if ($order) {
        	file_put_contents('2222.txt',$order['id']);
            if (!empty($order) && $order['status'] != 1) {
                $result = db('Order')->where('id', $order['id'])->update(['status' => 1, 'transaction_id' => $data['transaction_id']]);
                db('user')->where('id', $order['uid'])->setInc('pingfeng');
                file_put_contents('1111.txt',$result);
                if ($result) {
                    $this->fenyong($order['id']);
                }
                return $result;
            }
        }
    }


    // 去微信服务器查询是否有此订单
    public function Queryorder($transaction_id)
    {
        $input = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = \WxPayApi::orderQuery($input);
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS") {
            return true;
        }
        return false;
    }

    // 去本地服务器查询订单信息
    public function getOrder($data)
    {
        // 可根据商户订单号进行查询
        $order = db('Order')->where('number_order', $data['out_trade_no'])->find();
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
        return $order['status'] == 1 ? true : false;
    }


    public function fenyong($dingdanid)
    {
        //查询订单
        $order = db('Order')->where('id', '=', $dingdanid)->find();

        //查询代理商
        $agent_user = db('User')->where('id', '=', $order['proxyid'])->find();

        //版本表查询
        $price = db('AgentPrice')->where('id', '=', $order['pid'])->find();

        //授权数据
        $authAgent = Db('AuthAgent')->where('id', '=', $price['a_p_id'])->find();

        //产品信息
        $product = Db('Product')->where('id', '=', $authAgent['pid'])->find();

        //支付金额
        $price_r = $order['price'];

        //成本价格
        if ($authAgent) {
            $chengben = $authAgent['price'];
        } else {
            $chengben = $product['price'];
        }

        //计算佣金
        if (isset($authAgent['rebate']) && !empty($authAgent['rebate'])) {
            $rebate = DigitalHelper::div($authAgent['rebate'], 100, 2);
            $tichengs = DigitalHelper::mul($price_r, $rebate, 2);
           /// $tichengs = $price_b > $authAgent['price'] ? $price_b : $authAgent['price'];
        }else{
            $tichengs = DigitalHelper::mul($price_r, 0.6, 2);
        }
        if ($tichengs < 0) {
            $tichengs = 0;
        }
        
        //计算成本价格
        
        if(isset($agent_user['pid']) && $agent_user['pid'] > 0){
        	$cb_price = DigitalHelper::div(DigitalHelper::add($authAgent['rebate'], $authAgent['erjiprice'], 2), 100, 2);
        	$t = DigitalHelper::sub(1,$cb_price, 2);
        	$cost_price = DigitalHelper::mul($price_r, $t, 2);
        }else{
        	$cb_price = DigitalHelper::div($authAgent['rebate'], 100, 2);
        	$t = DigitalHelper::sub(1,$cb_price, 2);
        	$cost_price = DigitalHelper::mul($price_r, $t, 2);
        }

        //余额
        $balance = DigitalHelper::add($agent_user['money'], $tichengs, 2);
        //插入提成表
        $datayiji = [
            'order_id' => $order['number_order'],
            'profit_id' => $agent_user['id'],
            'ratio' => $price_r,
            'create_time' => time(),
            'money' => $tichengs,
            'type' => "直推奖励",
            'balance' => $balance,
            'uid' => $order['uid'],
            'aid' => $price['product_type'],
            'cost_price' => $cost_price,
        ];
        $profit_ids = db('profit')->insertGetId($datayiji);

        if ($profit_ids) {
            $agent_cost['money'] = $balance;
            $agent_cost['total_achievement'] = DigitalHelper::add($agent_user['total_achievement'], $tichengs, 2);
            db('user')->where('id', '=', $agent_user['id'])->update($agent_cost);
        }

        //判断上级是否有提成权利
        $superior = db('user')->where('id', '=', $agent_user['pid'])->find();

        if (isset($superior) && !empty($superior)) {
            //计算佣金
            if (isset($authAgent['erjiprice']) && !empty($authAgent['erjiprice'])) {
                $rebates = DigitalHelper::div($authAgent['erjiprice'], 100, 2);
                $erjiprice = DigitalHelper::mul($price_r, $rebates, 2);
            }
            if (isset($erjiprice) and !empty($erjiprice)) {
                $balances = DigitalHelper::add($superior['money'], $erjiprice, 2);
                $dataerji = [
                    'order_id' => $order['number_order'],
                    'profit_id' => $superior['id'],
                    'ratio' => $price_r,
                    'create_time' => time(),
                    'money' => $erjiprice,
                    'type' => "二级奖励",
                    'balance' => $balances,
                    'uid' => $agent_user['id'],
                    'aid' => $price['product_type'],
                    'cost_price' => 0,
                ];
                $chaxuner = db('profit')->insertGetId($dataerji);
                if ($chaxuner) {
                    $moneyer['money'] = $balances;
                    $moneyer['total_achievement'] = DigitalHelper::add($superior['total_achievement'], $erjiprice, 2);
                    db('user')->where('id', '=', $superior['id'])->update($moneyer);
                }
            }
        }
    }


    public function fenyongs($dingdanid)
    {
        //查询订单
        $order = db('Order')->where('id', '=', $dingdanid)->find();

        //查询代理商
        $agent_user = db('User')->where('id', '=', $order['proxyid'])->find();

        //版本表查询
        $price = db('AgentPrice')->where('id', '=', $order['pid'])->find();

        //授权数据
        $authAgent = Db('AuthAgent')->where('id', '=', $price['a_p_id'])->find();

        //产品信息
        $product = Db('Product')->where('id', '=', $authAgent['pid'])->find();

        //支付金额
        $price_r = DigitalHelper::div($order['price'], 100, 2);

        //成本价格
        if ($authAgent) {
            $chengben = $authAgent['price'];
        } else {
            $chengben = $product['price'];
        }

        //计算佣金
        if (isset($authAgent['rebate']) && !empty($authAgent['rebate'])) {
            $rebate = DigitalHelper::div($authAgent['rebate'], 100, 2);
            $price_b = DigitalHelper::mul($price_r, $rebate, 2);
            $tichengs = $price_b > $authAgent['price'] ? $price_b : $authAgent['price'];
        } else {
            $tichengs = DigitalHelper::sub($price_r, $chengben, 2);
        }
        if ($tichengs < 0) {
            $tichengs = 0;
        }

        //余额
        $balance = DigitalHelper::add($agent_user['money'], $tichengs, 2);
        //插入提成表
        $datayiji = [
            'order_id' => $order['number_order'],
            'profit_id' => $agent_user['id'],
            'ratio' => $price_r,
            'create_time' => time(),
            'money' => $tichengs,
            'type' => "直推奖励",
            'balance' => $balance,
            'uid' => $order['uid'],
            'aid' => $price['product_type'],
            'cost_price' => $authAgent['price'],
        ];
        $profit_ids = db('profit')->insertGetId($datayiji);

        //判断上级是否有提成权利
        $superior = db('user')->where('id', '=', $agent_user['pid'])->find();

        if ($agent_user['isStaff'] == 1 && !empty($superior)) {
            //员工推广佣金
            $balances = $superior['money'] + $tichengs;
            $dataerji = [
                'order_id' => $order['number_order'],
                'profit_id' => $superior['id'],
                'ratio' => $price_r,
                'create_time' => time(),
                'money' => $tichengs,
                'type' => "员工推广",
                'balance' => $balance,
                'uid' => $order['uid'],
                'aid' => $price['product_type'],
                'cost_price' => $authAgent['price'],
            ];
            $chaxuner = db('profit')->insertGetId($dataerji);
            if ($chaxuner) {
                $superior_cost['money'] = $balances;
                $superior_cost['total_achievement'] = DigitalHelper::add($superior['total_achievement'], $tichengs, 2);
                db('user')->where('id', '=', $superior['id'])->update($superior_cost);
            }
            if ($profit_ids) {
                $agent_cost['total_achievement'] = $agent_user['total_achievement'] + $tichengs;
                db('user')->where('id', '=', $agent_user['id'])->update($agent_cost);
            }
        } else {
            if ($profit_ids) {
                $agent_cost['money'] = $balance;
                $agent_cost['total_achievement'] = DigitalHelper::add($agent_user['total_achievement'], $tichengs, 2);
                db('user')->where('id', '=', $agent_user['id'])->update($agent_cost);
            }
            if (isset($superior) && !empty($superior) && $agent_user['isStaff'] != 1) {
                //授权数据
                $erjiticheng = Db('AuthAgent')->where('aid', '=', $superior['agent_class'])->where('pid', '=', $product['id'])->find();

                if (isset($erjiticheng) and $erjiticheng['erjiprice'] > 0) {
                    $erjiprice = $erjiticheng['erjiprice'];
                } else {
                    if (isset($product) and $product['commission'] > 0) {
                        $erjiprice = $product['commission'];
                    }
                }

                if (isset($erjiprice) and !empty($erjiprice)) {
                    $balances = $superior['money'] + $erjiprice;
                    $dataerji = [
                        'order_id' => $order['number_order'],
                        'profit_id' => $superior['id'],
                        'ratio' => $order['price'] / 100,
                        'create_time' => time(),
                        'money' => $erjiprice,
                        'type' => "二级奖励",
                        'balance' => $balances,
                        'uid' => $order['uid'],
                        'aid' => $price['product_type'],
                    ];
                    $chaxuner = db('profit')->insertGetId($dataerji);
                    if ($chaxuner) {
                        $moneyer['money'] = $balances;
                        $moneyer['total_achievement'] = $superior['total_achievement'] + $erjiprice;
                        db('user')->where('id', '=', $superior['id'])->update($moneyer);
                    }
                }
            }
        }
    }
}

