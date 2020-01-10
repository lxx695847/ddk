<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./views/index/login/registered.html";i:1578453277;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>注册</title>
	<link href="/public/index/css/mui.min.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="/public/index/css/index.css?v=147">
	<link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
</head>
<body>
	<div class="mui-content">
		<div class="mui-card-content registered-img">
			<img src="/public/index/img/login01.png">
			<div class="logs">
				<img src="<?php if(isset($logo) and !empty($logo)): ?><?php echo $logo; else: ?>/public/logo/ddk.png<?php endif; ?>">
			</div>
		</div>
		<form class="registered-from layui-form" action="<?php echo url('/api/login/add'); ?>" method="post">
			<div class="input-one tou">
				<span class="sj"></span>
				<input type="text"  name="username" lay-verType="tips" autocomplete="off"  required  lay-verify="required|username"  lay-reqText='请输入您的姓名'   class="mui-input-clear" placeholder="请输入您的姓名">
			</div>
			<div class="input-one">
				<span class="sj"></span>
				<input type="text"  name="mobile" lay-verType="tips" autocomplete="off"  required  lay-verify="required|phone|number"  lay-reqText='请输入手机号码'   class="mui-input-clear" placeholder="请输入您的手机号码">
			</div>
			<div class="input-one sou">
				<span class="sj"></span>
				<input type="password" name="password" lay-verType="tips" required  lay-verify="required|pass" lay-reqText='请输入密码' class="mui-input-password password" placeholder="请输入密码">
			</div>
			<div class="input-one sou">
				<span class="sj"></span>
				<input type="password" name="password_confirm" lay-verType="tips" required  lay-verify="required|confirm"  lay-reqText='请输入重复密码' class="mui-input-password password_confirm" placeholder="请输入密码">
			</div>
			<div class="bottm-ti">
				<input type="hidden" name="pid" value="<?php echo $pid; ?>">
				<button lay-submit  lay-filter="*" class="mui-btn mui-btn-primary tj01">立即注册</button>
				<a href="<?php echo url('/index/login/login'); ?>" type="button" class="mui-btn mui-btn-danger qx01" >取消</a>
			</div>
		</form>
	</div>
</body>
</html>
<script src="/public/index/js/jquery.min.js"></script>
<script src="/public/layui/layui.all.js"></script>
<script src="/public/index/js/index.js?v=789456"></script>
