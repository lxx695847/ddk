<?php
namespace app\backend\controller;
use app\backend\base\AuthController;
use app\backend\validate\newWithdraw;

class Link extends AuthController{
    public function index(){
        try{
            $params=input("get.");
            $list=model('backend/Links','logic')->getList($params);
            return view('index',['list'=>$list]);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 删除
     */
    public function del(){
        try{
            $sign=input("post.sign");
            $list=model('backend/Links','logic')->del($sign);
            return view('index',['list'=>$list]);
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
            model('backend/Links','logic')->excel($params);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 编辑
     */
    public function edit(){
        try{
            if(request()->isPost()){
                $res="";
                $params=input("post.");
                $check=new newWithdraw();
                switch ($params['type']){
                    case 1:
                        $res=$check->goCheck('system',$params);
                        break;
                    case 2:
                        $res=$check->goCheck('lawyer',$params);
                        break;
                }
                if($res===true){
                    model('backend/Links','logic')->edit($params);
                }
            }else{
                $sign=input("get.sign");
                $list=model('backend/Links','logic')->edit_info($sign);
                return view('edit',['list'=>$list]);
            }
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }
}