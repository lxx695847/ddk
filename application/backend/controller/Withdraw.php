<?php
namespace app\backend\controller;
use app\backend\base\AuthController;
use app\backend\validate\newWithdraw;


class Withdraw extends AuthController{
    public function index(){
        try{
            $params=input("get.");
            $list=model('backend/Withdraw','logic')->getList($params);
            return view('index',['list'=>$list]);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 添加提现
     */
    public function add(){
        try{
            if(request()->isPost()){
                $params=input("post.");
                $res=(new newWithdraw())->goCheck('withdraw',$params);
                if($res===true) {
                    model('backend/Withdraw', 'logic')->get_add($params);
                }
            }else{
                $res=db('user')->field('id,names')->select();
                return view('add',['res'=>$res]);
            }
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 编辑
     */
    public function get_edit(){
        try{
            if(request()->isPost()){
                $params=input("post.");
                model('backend/Withdraw','logic')->get_edit($params);
            }else{
                $sign=input("get.sign");
                $res=model('backend/Withdraw','logic')->edit_info($sign);
                return view('edit',['res'=>$res]);
            }
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 提现处理
     */
    public function get_pay(){
        try{
            $sign=input("post.sign");
            model('backend/Withdraw','logic')->get_pay($sign);
        }catch (\Exception $e){
            writeLog($e);
            errorReturn(500,info);
        }
    }

    /**
     * 删除
     */
    public function get_del(){
        try{
            $sign=input("post.sign");
            model('backend/Withdraw','logic')->get_del($sign);
        }catch (\Exception $e){
            writeLog($e);
            errorReturn(500,info);
        }
    }

    /**
     * 表格
     */
    public function excel(){
        try{
            $params=input("get.");
            model('backend/Withdraw','logic')->get_excel($params);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }
}