<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:33:"./views/index/customers/kefu.html";i:1578453280;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>联系我们</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/index/css/iconfont.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/index/css/contact.css">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="erweima_box">
        <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
        <div>
            <img src="<?php echo $vo['thumb']; ?>" alt="">
            <p>懂贷咖<?php echo $vo['names']; ?></p>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <p class="contact_tips">长按二维码保存，添加客服微信，可随时联系到我们</p>
</div>
</body>
</html>