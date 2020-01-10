<?php
namespace app\index\controller;
use app\common\base\ClientController;
use app\index\logic\CustomerLogicQuery;
use app\index\logic\PersonalLogicQuery;
use app\index\validate\newAgent;

class Customers extends ClientController {

    /**
     * 客户中心
     * @return \think\response\View
     * @throws \Exception
     */
    public function index(){
        $data = PersonalLogicQuery::getInstance()->getUser(['type'=>2]);
        $this->assign('user',$data);
        return view();
    }

    /**
     * 个人信息
     */
    public function detail(){
        try{
            if(request()->isPost()){
                $param=input("post.");
                model('index/Customer','logic')->getEdit($param);
            }else{
                $res=model('index/Customer','logic')->getInfo();
                return view('',['res'=>$res]);
            }
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 零钱
     */
    public function money(){
        try{
            $res=model('index/Customer','logic')->money();
            return view('',['res'=>$res]);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 提现
     */
    public function withdraw(){
        try{
            if(request()->isPost()){
                $params=input("post.");
                $res=(new newAgent())->goCheck('withdraw',$params);
                if($res===true){
                    model('index/Customer','logic')->withdraw($params);
                }
            }else{
                $res=model('index/Customer','logic')->getInfo();
                $res['sign']=makeSign(['id'=>session('uid')]);
                return view('',['res'=>$res]);
            }
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 提现记录
     */
    public function record(){
        try{
            $res=model('index/Customer','logic')->get_record();
            return view('',['res'=>$res]);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 绑定添加支付宝
     */
    public function blindpay(){
        try{
            if(request()->isPost()){
                $params=input("post.");
                $res=(new newAgent())->goCheck('alipay',$params);
                if($res===true){
                    model('index/Customer','logic')->blind($params);
                }
            }else{
                return view();
            }
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 绑定添加银行卡
     */
    public function blindbank(){
        try{
            if(request()->isPost()){
                $params=input("post.");
                $res=(new newAgent())->goCheck('bank',$params);
                if($res===true){
                    model('index/Customer','logic')->blind($params);
                }
            }else{
                return view();
            }
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 评论管理
     */
    public function comment(){
        try{
            $res=model('index/Customer','logic')->get_news(1);
            return view('',['res'=>$res]);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 点赞
     */
    public function praise(){
        try{
            $res=model('index/Customer','logic')->get_news(2);
            return view('',['res'=>$res]);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 回复
     */
    public function reply(){
        try{
            $res=model('index/Customer','logic')->get_news(3);
            return view('',['res'=>$res]);
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }

    /**
     * 排行榜
     */
    public function rank(){
        try{
            return view();
        }catch (\Exception $e){
            writeLog($e);
            msg(info);
        }
    }


    /**
     * 联系我们
     * @return mixed|string
     */
    public function kefu(){
        try{
            $img = CustomerLogicQuery::getInstance()->img();
            $this->assign('data',$img);
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $this->fetch();
    }
}