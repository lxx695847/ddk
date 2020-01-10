<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:34:"./views/index/customers/money.html";i:1578453280;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>钱包</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/index/css/iconfont.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/index/css/reward.css">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="reward_box">
        <div class="reward_all">
            总奖励金额：￥<?php echo $res['total']; ?>
            <a href="<?php echo url('index/Customers/withdraw'); ?>">
                <img src="/public/index/img/user/icon_wallet.png" alt="">
                立即提现
            </a>
        </div>
        <p class="reward_ti">奖励明细</p>
        <?php if($res['list'] != false): foreach($res['list'] as $v): ?>
            <div class="reward_list">
                <p class="platform_name">奖励说明：<?php echo $v['type']; ?></p>
                <p class="platform_time">奖励时间：<?php echo date("Y-m-d",$v['create_time']); ?></p>
                <p class="platform_num">+<?php echo $v['money']; ?>元</p>
            </div>
            <?php endforeach; else: ?>
        <p style="text-align: center;line-height: 80px;">暂无奖励</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>