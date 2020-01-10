<?php

namespace app\index\controller;

use app\common\base\AuthController;
use app\index\logic\PersonalLogicQuery;

class Income extends AuthController {
    public function index(){
        try{
            $data=model('index/Income','logic')->getList();
            $user = PersonalLogicQuery::getInstance()->getUser();
            $this->assign('user',$user);
            return $this->fetch('index',['data'=>$data]);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 获取列表数据
     */
    public function getParse(){
        try{
            $param=input("post.");
            $data=model('index/Income','logic')->getParse($param);
            successReturn(200,"",$data);
        }catch (\Exception $e){
            writeLog($e);
            errorReturn(500,info);
        }
    }
}