<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:30:"./views/admin/login/index.html";i:1578453293;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>懂贷咖后台管理系统</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/public/layui/css/layui.css">
    <link rel="stylesheet" href="/public/admin/css/admin.css">
    <!--[if lt IE 9]>
    <script src="/public/admin/js/html5shiv.min.js"></script>
    <script src="/public/admin/js/respond.min.js"></script>
    <style>
        .login .login-form input {color: #000;}
    </style>
    <![endif]-->
</head>
<body class="login">
<div class="login-title">
懂贷咖CMS登陆
</div>
<form class="layui-form login-form" style="color:#FFF" action="<?php echo url('backend/login/login'); ?>" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
            <input type="text" name="username" required lay-verify="required" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="password" name="password" required lay-verify="required" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">验证码</label>
        <div class="layui-input-block">
            <input type="text" name="verify" required lay-verify="required" class="layui-input layui-input-inline">
            <img src="<?php echo captcha_src(); ?>" alt="点击更换" title="点击更换" onClick="this.src='<?php echo captcha_src(); ?>?time='+Math.random()" class="captcha">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="*">登 录</button>
        </div>
    </div>
</form>
<script>
    // 定义全局JS变量
    var GV = {
        current_controller: "backend/<?php echo (isset($controller) && ($controller !== '')?$controller:''); ?>/"
    };
</script>
<script src="/public/admin/js/jquery.min.js"></script>
<script src="/public/layui/layui.all.js"></script>
<script src="/public/admin/js/admin.js"></script>

</body>
</html>