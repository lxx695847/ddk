<?php

namespace app\common\base;

use think\Controller;
use think\Db;

abstract class LogicQuery extends Controller{

    protected static $instance = [];
    /**
     * 单列
     * @return static|self
     */
    public static function getInstance(){
        $className = get_called_class();
        if(!isset(static::$instance[$className])){
            static::$instance[$className] = new $className;
        }
        return static::$instance[$className];
    }


    /**
     * 过滤get数据
     * @param $data
     */

    public function getFilter($params){
        $data = [];
        foreach($params as $key => $value){
            $m = [];
            if(is_array($value)){
                self::getFilter($value);
            }
            if($value === '' || $value ===false){
                unset($params[$key]);
                continue;
            }
            $data[$key] = self::str($value);
        }
        return $data;
    }

    /**
     * 过滤特殊字符
     * @param $str
     * @return mixed
     */
    public static function str($str){
        $str = str_replace('%20','',$str);
        $str = str_replace('%27','',$str);
        $str = str_replace('%2527','',$str);
        $str = str_replace('*','',$str);
        $str = str_replace('"','',$str);
        $str = str_replace("'",'',$str);
        $str = str_replace('"','',$str);
        $str = str_replace(';','',$str);
        $str = str_replace('<','',$str);
        $str = str_replace('>','',$str);
        $str = str_replace("{",'',$str);
        $str = str_replace('}','',$str);
        $str = str_replace('\\','',$str);
        return $str;
    }



    /**
     * 添加错误日志
     * @param string $message
     */
    protected function log($message=''){
        Logger::log($message);
    }

    /**
     * 开启事务
     */
    protected function startTrans(){
        Db::startTrans();
    }

    /**
     * 提交事务
     */
    protected function commit(){
        Db::commit();
    }


    /**
     * 关闭事务
     */
    protected function rollback(){
        Db::rollback();
    }



}