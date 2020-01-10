<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:34:"./views/index/customers/index.html";i:1578544906;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人中心</title>
    <link rel="stylesheet" href="/public/index/css/mui.css">
    <link rel="stylesheet" href="/public/index/css/iconfont.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/index/css/user_center.css">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="user_box">
        <div class="user_top">
            <div class="user_head clearfix">
                <div class="head_left">
                    <?php if(isset($user['gender']) && $user['gender'] == 2): ?>
                    <img src="/public/index/img/userhead_mm.png" alt="">
                    <?php else: ?>
                    <img src="/public/index/img/userhead_nan.png" alt="">
                    <?php endif; ?>
                </div>
                <div class="head_cen">
                    <p><?php echo $user['names']; ?></p>
                    <p><?php echo $user['mobile']; ?></p>
                </div>
                <div class="head_right">
                    <a href="<?php echo url('index/Customers/detail'); ?>"><i class="mui-icon mui-icon-arrowright"></i></a>
                </div>
            </div>
        </div>
        <div class="gray_area"></div>
        <div class="user_cen clearfix">
            <div class="cen_item">
                <a href="<?php echo url('index/Customers/money'); ?>">
                    <img src="/public/index/img/user/icon_reward.png" alt="">
                    <p>我的钱包</p>
                </a>
            </div>
            <div class="cen_item">
                <a href="<?php echo url('index/Platform/index'); ?>">
                    <img src="/public/index/img/user/icon_record.png" alt="">
                    <p>查询记录</p>
                </a>
            </div>
            <div class="cen_item">
                <a href="<?php echo url('index/Customers/comment'); ?>">
                    <img src="/public/index/img/user/icon_comment.png" alt="">
                    <p>评论管理</p>
                </a>
            </div>
            <div class="cen_item">
                <a href="<?php echo url('index/Customers/rank'); ?>">
                    <img src="/public/index/img/user/icon_ranking.png" alt="">
                    <p>排行榜</p>
                </a>
            </div>
        </div>
    </div>
    <img class="user_ban" src="/public/index/img/user/tuiguangbanner.png" alt="">
    <a href="<?php echo url('/index/login/registered',['pid'=>$user['pid']]); ?>">
    <div class="up_agent">
        <span>
            <img src="/public/index/img/user/a1.png" alt="">
        </span>
        成为代理
        <i class="mui-icon mui-icon-arrowright"></i>
    </div>
    </a>
    <ul class="set_box">
        <a href="<?php echo url('index/customers/kefu'); ?>">
        <li>
            <span>
                <img src="/public/index/img/user/b1.png" alt="">
            </span>
            联系客服
            <i class="mui-icon mui-icon-arrowright"></i>
        </li>
        </a>
        <li>
            <span>
                <img src="/public/index/img/user/c1.png" alt="">
            </span>
            帮助中心
            <i class="mui-icon mui-icon-arrowright"></i>
        </li>
        <li>
            <span>
                <img src="/public/index/img/user/d1.png" alt="">
            </span>
            设置
            <i class="mui-icon mui-icon-arrowright"></i>
        </li>
    </ul>
</div>
</body>
</html>