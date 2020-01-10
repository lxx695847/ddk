<?php

namespace app\index\controller;


use app\common\base\Controllers;

class Ranking extends Controllers {


    /**
     * 代理排行榜
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }


    /**
     * 平台排行榜
     * @return mixed
     */
    public function pindex(){
        return $this->fetch();
    }


}