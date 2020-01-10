<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:34:"./views/index/customer/invite.html";i:1578453282;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>邀请代理</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/invite.css">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="invite_box">
        <div class="scoll_notice clearfix">
            <img class="notice_left" src="/public/index/img/icon_horn.png" alt="">
            <div class="notice_right">
                <div class="noticeScoll">
                    <?php if(is_array($result) || $result instanceof \think\Collection || $result instanceof \think\Paginator): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <p><?php echo $vo['mobile']; ?>邀请了<?php echo $vo['count']; ?>个好友</p>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>
        <div class="invite_cen">
            <p class="invite_ti">简单分享轻松赚钱</p>
            <p class="invite_des">1.点击立即邀请，发送链接或海报给好友</p>
            <p class="invite_des">2.好友通过海报或链接，注册成为代理</p>
            <p class="invite_des">3.好友成功推荐用户，使用并付费，您即可获得奖励收益</p>
        </div>
    </div>
    <button class="invite_btn">立即邀请</button>
    <div class="invite_rule">
        <p class="invite_ti">分佣规则</p>
        <table border="1" cellspacing="0" cellpadding="0">
            <tr>
                <td>产品名称</td>
                <td>直推奖励</td>
                <td>团队奖励</td>
            </tr>
            <tr>
                <td>平台查询</td>
                <td>最高<?php echo $price['price']; ?>元</td>
                <td><?php echo $price['price_r']; ?>元</td>
            </tr>
            <!--<tr>
                <td>律师咨询</td>
                <td>最高34元</td>
                <td>1.5元</td>
            </tr>
            <tr>
                <td>热门问题</td>
                <td>最高12元</td>
                <td>1.5元</td>
            </tr>-->
        </table>
    </div>
</div>
</body>
<script>
    $(function(){

        $('.invite_btn').on('click',function(){
            window.location.href = '/index/customer/code_img';
        });


        var hidden, visibilityChange;
        if (typeof document.hidden !== "undefined") {
            hidden = "hidden";
            visibilityChange = "visibilitychange";
        } else if (typeof document.mozHidden !== "undefined") {
            hidden = "mozHidden";
            visibilityChange = "mozvisibilitychange";
        } else if (typeof document.msHidden !== "undefined") {
            hidden = "msHidden";
            visibilityChange = "msvisibilitychange";
        } else if (typeof document.webkitHidden !== "undefined") {
            hidden = "webkitHidden";
            visibilityChange = "webkitvisibilitychange";
        }
        //公告向上滚动
        var up;
        if($(".notice_right .noticeScoll p").length > 1){
            up = setInterval('autoScroll(".notice_right")', 3000);
            document.addEventListener(visibilityChange,function(){
                if(document.hidden === true){
                    clearInterval(up);
                }else{
                    up = setInterval('autoScroll(".notice_right")', 3000);
                }
            })
            $(document).on('mouseover','.notice_right',function(){
                clearInterval(up);
            })
            $(document).on('mouseout','.notice_right',function(){
                up = setInterval('autoScroll(".notice_right")', 3000);
            })
        }
    })
    function autoScroll(obj) {
        $(obj).find(".noticeScoll").animate({
            marginTop: "-0.56rem"
        }, 1000, function () {
            $(this).css({marginTop: "0px"}).find("p:first").appendTo(this);
        })
    }
</script>
</html>