<?php

namespace app\index\controller;


use app\common\base\AuthController;
use app\index\logic\UserLogicQuery;

class User extends AuthController{


    /**
     * 首页
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }


    /**
     * 更新提现账号
     * @return mixed|string
     */
    public function edit(){
        try{
            $data = UserLogicQuery::getInstance()->edit();
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $this->renderSuccess($data);
    }
}