<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:28:"./views/index/index/del.html";i:1578453278;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查询结果</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/user_center.css">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <img class="top_banner" src="/public/index/img/no_result_banner.png" alt="">
    <img class="no_result" src="/public/index/img/no_result.png" alt="">
    <a class="add_plat" href="./index.html">搜索其他贷款平台</a>
    <div class="recommend_box clearfix">
        <div class="recommend_item">
            <a href="<?php echo url('/index/ranking/pindex'); ?>">
                <img class="recommend_pic" src="/public/index/img/hot_pic.png" alt="">
                热门搜索推荐
                <img class="pointer" src="/public/index/img/pointer.gif" alt="">
            </a>
        </div>
        <div class="recommend_item">
            <a href="<?php echo url('/index/platform/collect',['sign'=>$sign]); ?>">
                <img class="recommend_pic" src="/public/index/img/add_pic.png" alt="">
                添加平台获得奖金
            </a>
        </div>
    </div>
</div>
</body>
</html>