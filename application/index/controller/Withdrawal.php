<?php

namespace app\index\controller;


use app\common\base\AuthController;
use app\index\logic\UserLogicQuery;
use app\index\logic\WithdrawalLogicQuery;
use think\Db;

class Withdrawal extends AuthController{


    /**
     * 提现
     * @return mixed
     */
    public function index(){
        try{
            $user = UserLogicQuery::getInstance()->find_one(['id'=>session('user_id')],'id,banktype,banknumber,bankname,phone,names,mobile,money,wname');
            $this->assign('user',$user);
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $this->fetch();
    }


    /**
     * 绑定银行卡
     * @return mixed
     */
    public function bank(){
        try{
            $user = UserLogicQuery::getInstance()->find_one(['id'=>session('user_id')],'id,banktype,banknumber,bankname,phone,names,mobile,money,bname');
            $this->assign('user',$user);
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $this->fetch();
    }


    /**
     * 绑定支付宝
     * @return mixed
     */
    public function zfb(){
        try{
            $user = UserLogicQuery::getInstance()->find_one(['id'=>session('user_id')],'id,banktype,banknumber,bankname,phone,names,mobile,money,wname');
            $this->assign('user',$user);
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $this->fetch();
    }


    /**
     * 余额提现
     * @return mixed|string
     */
    public function mention(){
        try{
            $result = WithdrawalLogicQuery::getInstance()->save();
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $this->renderSuccess($result);
    }


    /**
     * 列表
     * @return mixed
     */
    public function list_index(){
        return $this->fetch('query');
    }


    /**
     * 提现记录
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function query(){
        try{
            $params = $this->request->param();
            $params['select'] = '*';
            $data = WithdrawalLogicQuery::getInstance()->list_data($params);
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $data;
    }

}