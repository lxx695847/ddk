<?php
namespace app\backend\controller;
use app\backend\base\AuthController;


class Income extends AuthController{
    public function index(){
        try{
            $params=input("get.");
            $list=model('backend/Income','logic')->getList($params);
            return view('index',['list'=>$list]);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    //退款
    public function back_money(){
        try{
            $sign=input("post.sign");
            model('backend/Income','logic')->get_back($sign);
        }catch (\Exception $e){
            writeLog($e);
            errorReturn(500,info);
        }
    }

    //导出表格
    public function excel(){
        try{
            $params=input("get.");
            model('backend/Income','logic')->get_excel($params);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }
}