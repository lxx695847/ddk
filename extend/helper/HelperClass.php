<?php

namespace helper;

abstract class HelperClass {

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

}