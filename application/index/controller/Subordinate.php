<?php

namespace app\index\controller;

use app\common\base\AuthController;
use app\index\logic\SubordinateLogicQuery;

class Subordinate extends AuthController{


    /**
     * 下级代理
     * @return mixed
     */
    public function index(){
        $data = SubordinateLogicQuery::getInstance()->counts(['pid'=>session('user_id')]);
        $this->assign('data',$data);
        return $this->fetch();
    }


    /**
     * 下级代理 -> 列表
     * @return mixed
     */
    public function query(){
        try{
            $params = $this->request->param();
            $params['select'] = 'id,names,mobile,create_time,gender,total_achievement';
            $data = SubordinateLogicQuery::getInstance()->querys($params);
        }catch(\Exception $e){
            return $this->renderError($e);
        }
        return $data;
    }
}