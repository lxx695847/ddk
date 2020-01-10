<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:31:"./views/index/client/login.html";i:1578453283;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>登录</title>
    <link href="/public/index/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/public/index/css/index.css">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
</head>
<body>
<div class="mui-content">
    <div class="mui-card-content login-img">
        <img src="/public/index/img/login01.png">
        <div class="logs">
            <img src="<?php if(isset($logo) and !empty($logo)): ?><?php echo $logo; else: ?>/public/logo/ddk.png<?php endif; ?>">
        </div>
    </div>
    <div class="layui-tab layui-tab-brief login-red" style="margin-top:20%">
        <ul class="layui-tab-title">
            <li>验证码登录</li>
        </ul>
        <form class="login-form layui-form" action="<?php echo url('/api/client/login'); ?>" method="post">
            <div class="input-one shouj">
                <span class="sj"></span>
                <input type="text"  name="mobile" lay-verType="tips" required  lay-verify="required|phone|number"  lay-reqText='手机号码不能为空' class="mui-input-clear" placeholder="请输入您的手机号码">
            </div>
            <div class="input-one layui-tab-item layui-show">
                <input type="text" style="width:60%;float:left;" lay-verType="tips" name="verification" required  lay-verify="verification" lay-reqText='验证码不能为空' class="mui-input-password password" placeholder="请输入验证码">
                <button type="button" class="layui-btn layui-btn-normal pull-right" style="border-radius:5px;width: 100px;height: 40px;line-height: 40px;">获取验证码</button>
            </div>
            <div class="bottm-ti">
                <input name="type" value="1" type="hidden">
                <button lay-submit lay-filter="*" class="mui-btn mui-btn-primary tj01">登录</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<script src="/public/index/js/jquery.min.js"></script>
<script src="/public/index/js/mui.min.js"></script>
<script src="/public/layui/layui.all.js"></script>
<script src="/public/index/js/cindex.js?v=741"></script>