<?php
/**
 * Created by PhpStorm.
 * User: GG
 * Date: 2018/6/29
 * Time: 9:42
 */

namespace app\index\validate;
use think\Validate;

class Base extends Validate
{
    //验证
    public function goCheck($scene="",$data=""){
        if($data===false){
            $data=input('param.');
        }
        if(!$this->scene($scene)->check($data)){
            errorReturn('500', $this->getError());
        }else{
            return true;
        }
    }
}