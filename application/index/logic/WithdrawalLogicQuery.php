<?php

namespace app\index\logic;

use app\common\base\LogicQuery;
use app\common\model\Withdraw;
use think\Db;
use think\Exception;

class WithdrawalLogicQuery extends LogicQuery{


    /**
     * 提现
     * @param null $params
     * @throws \Exception
     */
    public function save($params = null){
        try{
            if(empty($params)){
                $params = $this->request->param();
            }
            $result = $this->validate($params,'Mention');
            if($result !== true){
                throw new Exception($result,1);
            }
            $user = UserLogicQuery::getInstance()->find_one(['id'=>session('user_id')],'id,banktype,banknumber,bankname,phone,names,mobile,money,wname,bname');
            if(empty($user)){
                throw new Exception('请先登录',1);
            }

            if($params['price'] > $user['money']){
                throw new Exception('提现金额不能大于账户余额',1);
            }

            $price = Db::name('Withdraw')->where('user_id',session('user_id'))->where('status',0)->find();
            if(!empty($price)){
                throw new Exception('您有提现正在审核中，请耐心等待审核',1);
            }

            $sum = Db::name('Withdraw')->where('user_id',session('user_id'))->where('create_time', 'between', [mktime(0, 0, 0, date("m"), date("d"), date("Y")), time()])->count();

            if(!empty($sum) &&  $sum >= 3){
                throw new Exception('当天提现不能超过3笔');
            }

            if(isset($params['type']) && $params['type'] == 1){
                $data['bankcard'] = $user['bankname'];
                $data['name'] = $user['wname'];
            }else{
                $data['bankcard'] = $user['banknumber'];
                $data['name'] = $user['bname'];
            }
            $data['user_id'] = $user['id'];
            $data['money'] = $params['price'];
            $data['type'] = $params['type'];
            $data['mobile'] = $user['phone'];
            $data['operator'] = $user['id'];
            $data['create_time'] = time();
            $data['status'] = 0;
            $withdraw = new Withdraw();
            $status = $withdraw->allowField(true)->save($data);
            if(!$status){
                throw new Exception('提现失败',1);
            }
        }catch(\Exception $e){
            $this->log($e);
            throw $e;
        }
    }




    public function list_data($params = null){
        try{
            if(empty($params)){
                $params = $this->request->param();
            }
            $userid = session('user_id');
            $query = Db::name('withdraw')->field($params['select']);
            $this->query($query,['user_id'=>$userid,'page'=>isset($params['page'])?$params['page']:1,'limit'=>isset($params['limit'])?$params['limit']:10]);
            $data = $query->select();
            $this->Conversion($data);
        }catch(\Exception $e){
            $this->log($e);
            throw $e;
        }
        return $data;
    }

    public function Conversion(&$data){
        foreach($data as &$item){
            $item['createAt'] =  date('Y-m-d H:i',$item['create_time']);
            $item['updateAt'] =  date('Y-m-d H:i',$item['update_time']);
         }
    }


    public function query($query,$params){
        if(isset($params['user_id']) && !empty($params['user_id'])){
            $query->where('user_id','=',$params['user_id']);
        }
        if(isset($params['page']) && !empty($params['page'])){
            $limit = isset($params['limit'])?$params['limit']:10;
            $query->page($params['page'],$limit);
        }
        $query->order('create_time desc');
    }


}