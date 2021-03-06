<?php

namespace app\calculator\logic;

use app\calculator\base\LogicQuery;
use app\common\model\Cadmin;
use think\Config;
use think\Db;
use think\Exception;
use think\Session;

class LoginLogicQuery extends LogicQuery{

    /**
     * 添加管理员用户
     * @param null $params
     * @throws \Exception
     */
    public function save($params = null){
        self::startTrans();
        try{
            if(empty($params)){
                throw new Exception('参数错误',1);
            }
            $result = $this->validate($params,'Cadmin');
            if($result !== true){
                throw new Exception($result,1);
            }
            $params['password'] = md5($params['password'] . Config::get('salt'));
            $Cadmin = new Cadmin();
            $Cadmin->allowField(true)->save($params);
            self::commit();
        }catch(\Exception $e){
            $this->log($e);
            self::rollback();
            throw $e;
        }
    }


    /**
     * 登录验证
     * @param null $params
     * @throws \Exception
     */
    public function login($params = null){
        try{
            if(empty($params)){
                throw  new Exception('参数错误',1);
            }
            $result = $this->validate($params,'login');
            if($result !==  true ){
                throw  new Exception($result,1);
            }
            $where['username'] = $params['username'];
            $where['password'] = md5($params['password'] . Config::get('salt'));
            $admin_user = Db::name('admin_user')->field('id,username,names,status')->where($where)->find();
            if(!empty($admin_user)){
                if($admin_user['status'] != 1){
                    throw  new Exception('当前用户已禁用',1);
                }
                Session::set('cadmin_id', $admin_user['id']);
                Session::set('cadmin_name', $admin_user['username']);
                Session::set('cnames', $admin_user['names']);
                db('admin_user')->where('id',intval($admin_user['id']))->update([
                    'last_login_time' => date('Y-m-d H:i:s', time()),
                    'last_login_ip'   => $this->request->ip(),
                ]);
            }else{
                throw  new Exception('用户名或密码错误',1);
            }
        }catch(\Exception $e){
            $this->log($e);
            throw $e;
        }

    }

}