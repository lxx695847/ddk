<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:33:"./views/index/withdrawal/zfb.html";i:1578453273;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>更换支付宝</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/index/css/iconfont.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/layer/mobile/need/layer.css">
    <link rel="stylesheet" href="/public/index/css/bindBank.css">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
    <script src="/public/layer/layer.js"></script>
</head>
<body>
<div class="container container1">
    <?php if(isset($user['bankname']) && !empty($user['bankname'])): ?>
    <div class="ali_account">
        <img src="/public/index/img/icon_alipys.png" alt="">
        <?php echo $user['wname']; ?><span><?php echo $user['bankname']; ?></span>
    </div>
    <?php else: ?>
    <img class="top_img" src="/public/index/img/alipay_top.png">
    <?php endif; ?>
    <div class="main">
        <div class="bind_box">
            <p class="change_ti">支付宝账号</p>
            <input type="text" placeholder="请输入支付宝账号" name="bankname" value="<?php echo $user['bankname']; ?>">
            <input type="text" placeholder="请输入真实姓名" name="wname" value="<?php echo $user['wname']; ?>">
            <input type="text" placeholder="请输入联系人手机号" name="phone" value="<?php echo $user['phone']; ?>">
            <div class="clearfix"></div>
            <p class="bind_tips">*请确认信息无误</p>
            <button class="submit_btn submit_btn1">确定完成</button>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $(".submit_btn").on('click',function () {
        var bankname = $('input[name="bankname"]').val();
        var wname = $('input[name="wname"]').val();
        var phone = $('input[name="phone"]').val();

        var patterns = /^[\u4E00-\u9FA5]{1,6}$/;

        var pattern = /^1[3456789]\d{9}$/;

         if (bankname == '') {
            layer.msg('支付宝账号不能为空');
            return false;
        }

        if (wname == '') {
            layer.msg('收款人姓名不能为空');
            return false;
        }

        if (phone == '') {
            layer.msg('联系人手机号码不能为空');
            return false;
        }

        if(!patterns.test(wname)){
            layer.msg('请填写正确姓名');
            return false;
        }

        if(!pattern.test(phone)) {
            layer.msg('请填写正确的联系人手机号');
            return false;
        }
        var ufs = layer.load();
        $.ajax({
            url: "<?php echo url('index/user/edit'); ?>",
            type: "post",
            dataType: 'json',
            data: {'bankname': bankname, 'wname': wname, 'phone': phone, 'type': 1},
            success: function (json) {
                layer.close(ufs);
                if(json.code == 0){
                    layer.msg(json.message,{time:500},function(){
                        window.location.href = "<?php echo url('index/withdrawal/index'); ?>";
                    });
                }else{
                    layer.msg(json.message);
                }
            }
        });

    });

</script>
</html>