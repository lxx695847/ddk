<?php

namespace app\index\controller;

use app\common\base\ClientController;
use app\index\logic\PlatformLogicQuery;

class Platform extends ClientController {

    /**
     * 客户列表
     * @return array|string
     */
    public function query(){
        try{
            $data = PlatformLogicQuery::getInstance()->query();
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $data;
    }

    /**
     * 列表页面
     * @return mixed
     */
    public function index($keyWord='',$type = 1){
        $this->assign('keyWord',$keyWord);
        $this->assign('type',$type);
        return $this->fetch();
    }


    /**
     * 收集信息页面
     * @return mixed
     */
    public function collect($sign = ''){
        $this->assign('sign',$sign);
        return $this->fetch();
    }



    public function save(){
        try{
            $data = PlatformLogicQuery::getInstance()->save();
        }catch(\Exception $e){
            $this->renderError($e);
        }
        return $this->renderSuccess($data);
    }

}