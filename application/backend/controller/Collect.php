<?php
namespace app\backend\controller;


use app\backend\base\AuthController;
use app\backend\logic\CollectLogicQuery;

class Collect extends AuthController{


    /**
     * 收集信息
     * @return mixed|string
     */
    public function index(){
        try{
            $params = $this->request->param();
            //var_dump($params);die;
            $data = CollectLogicQuery::getInstance()->query($params);
            $this->assign('data',$data);
            $this->assign('get',$params);
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $this->fetch();
    }

}