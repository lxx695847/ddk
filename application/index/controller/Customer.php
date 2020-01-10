<?php

namespace app\index\controller;


use app\common\base\AuthController;
use app\index\logic\CustomerLogicQuery;
use helper\Imgdeal;
use think\Db;

class Customer extends AuthController {


    /**
     * 联系我们
     * @return mixed|string
     */
    public function index(){
        try{
            $img = CustomerLogicQuery::getInstance()->img();
            $this->assign('data',$img);
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $this->fetch();
    }


    /**
     * 邀请代理
     * @return mixed|string
     */
    public function invite(){
        try{
            $img = CustomerLogicQuery::getInstance()->invite();
            $data = CustomerLogicQuery::getInstance()->agent();
            $price = CustomerLogicQuery::getInstance()->price();
            $this->assign('data',$img);
            $this->assign('result',$data);
            $this->assign('price',$price);
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $this->fetch();
    }



    /**
     * 邀请代理二维码图片处理
     */
    public function code_img(){
        $b_img = Db::name('banner')->where('names','in',['邀请代理','空白二维码','logo1'])->select();
        $agent_price = 'http://'.$_SERVER['HTTP_HOST'].'/index/login/registered?pid='.session('user_id');
        $platform_img = '';
        $code_img = '';
        $logo = '';
        if(isset($b_img) && !empty($b_img)){
            foreach($b_img as $item){
                if($item['names'] == '邀请代理'){
                    $platform_img = $item['thumb'];
                }
                if($item['names'] == '空白二维码'){
                    $code_img = $item['thumb'];
                }

                if($item['names'] == 'logo1'){
                    $logo = $item['thumb'];
                }
            }
        }
        $img = Imgdeal::getInstance()->img_conversion($platform_img,$agent_price,$code_img,6,$logo,248,1000);
        echo '<body style="margin:0px;padding:0;"><div style="height:100px;line-height:100px;text-align:center;font-size:40px;background: #ac5cff;"><a href="/index/promotion/index" style=" text-decoration: none;color:#fff;margin:0px;padding:0;">回到主页面</a></div>
                    <img src="/img/' . $img . '" style="width:100%;margin:0px;padding:0;"/>
              </body>';
    }






}