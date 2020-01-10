<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Request;
use helper\Rsas;
define("info","当前用户访问过多,请稍后访问");

// 应用公共文件
function errorReturn($code, $info = ""){
    header('Content-Type:application/json; charset=utf-8');
    $data['code'] = $code;
    $data['status'] = "error";

    if ($code == 400) {
        $data['msg'] = "平台参数缺失";
    } elseif ($code == 401) {
        $data['msg'] = "未授权认证或参数错误";
    } elseif ($code == 402) {
        $data['msg'] = "内容已存在或重复提交";
    } elseif ($code == 403) {
        $data['msg'] = "请求的方式错误";
    } elseif ($code == 404) {
        $data['msg'] = "请求的资源不存在";
    } elseif ($code == 405) {
        $data['msg'] = "操作失败";
    } elseif ($code == 406) {
        $data['msg'] = "数据已更改";
    } else {
        $data['msg'] = $info;
    }

    if ($info) {
        $data['msg'] = $info;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}


function successReturn($code, $info = "", $result = array()){
    header('Content-Type:application/json; charset=utf-8');
    $data = [
        'code' => $code,
        'data' => $result
    ];
    switch ($code) {
        case 200:
            $data['msg'] = "请求成功";
            break;
        case 201:
            $data['msg'] = "创建成功";
            break;
        case 202:
            $data['msg'] = "更新成功";
            break;
        case 203:
            $data['msg'] = "删除成功";
            break;
        case 204:
            $data['msg'] = "暂无内容";
            break;
        case 205:
            $data['msg'] = "操作成功";
            break;
        case 206:
            $data['msg'] = $info;
    }
    $data['status'] = "success";
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}


//数据操作(增、删、改)的简单验证
function result_check($result, $s_code, $data = array(), $e_code, $info = ""){
    if ($result !== false) {
        successReturn($s_code, "", $data);
    } else {
        errorReturn($e_code, $info);
    }
}


//数据操作(查询)的简单验证
function result_show($result){
    if ($result) {
        successReturn(200, "", $result);
    } else {
        successReturn(204);
    }
}

//常见操作验证
function check($data,$type){
    if ($data!==false) {
        switch ($type){
            //新增
            case 1:
                successReturn(201);
                break;
            //更新
            case 2:
                successReturn(202);
                break;
            //删除
            case 3:
                successReturn(203);
                break;
        }
    } else {
        errorReturn(405);
    }
}


function writeLog($e){
    $request=Request::instance();
    $file="errorLog".$request->controller().".txt";
    if ($e instanceof \Exception) {
        $error = [$e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine()];
        file_put_contents($file,$error,FILE_APPEND);
    }
}


function makeSign($data=[]){
    return Rsas::getInstance()->encode(http_build_query($data));
}

function desSign($sign,$param=[]){
    $data = Rsas::getInstance()->decode($sign);
    //把查询字符串解析到变量中
    parse_str($data,$param);
    return $param;
}

function msg($msg){
    echo "<head>        
               <meta name='viewport' content='width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no'>
               <meta http-equiv='X-UA-Compatible' content='ie=edge'>
               <script src='/public/js/jquery.min.js'></script>
               <script src='/public/layer/layer.js'></script>
          </head>          
          <script>
               layer.msg('".$msg."',{time:3000},function(){
                   window.location.href='javascript:history.go(-1)';}
               );
          </script>";
    exit;
}
