<?php

namespace helper;

use think\Db;

class ModelHelperQuery extends HelperClass {


    /**
     * 数据统计
     * @param null $name
     * @return int|string
     * @throws \think\Exception
     */
    public static function countData($name=null,$code=false,$string=''){
        if(!empty($name)){
            $max =  Db::name($name)->count();
            if($code){
                $max += 1;
                 $max = $string . str_pad($max, 8, '0', STR_PAD_LEFT);
            }
        }else{
            $max = 0;
        }
        return $max;
    }





}