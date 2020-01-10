<?php
namespace app\index\controller;
use think\Controller;

class Base extends Controller{
    public function _initialize(){
        if(session("?uid")===false){
            $this->error("请先登录","index/Client/login");
        }
    }
}