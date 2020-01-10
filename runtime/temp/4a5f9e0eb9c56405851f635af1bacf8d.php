<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./views/index/customers/record.html";i:1578453281;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>提现</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/index/css/iconfont.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/index/css/withdrawal_record.css">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <p class="my_order">最新提现记录</p>
    <?php if($res != false): foreach($res as $v): ?>
            <div class="order_box">
                <div class="order_list">
                    <p>金额：<?php echo $v['money']; ?>元
                        <?php if($v['status'] != 0): ?>
                        <span class="success">成功</span>
                        <?php else: ?>
                        <span class="audit">审核中</span>
                        <?php endif; ?>
                    </p>
                    <p>姓名：<?php echo $v['name']; ?></p>
                    <p>类型：<?php if($v['type'] == 1): ?>支付宝<?php else: ?>银行卡<?php endif; ?></p>
                    <p class="order_time">下单时间：<?php echo date("Y-m-d H:i",$v['create_time']); ?></p>
                </div>
            </div>
        <?php endforeach; else: ?>
        <p style="text-align: center;line-height: 60px;">暂无提现记录</p>
    <?php endif; ?>
</div>
</body>
<script>
    $(function(){
        $(".choose").click(function(){
            $(this).addClass("active").parent().siblings().find(".choose").removeClass("active")
        })
    })
</script>
</html>