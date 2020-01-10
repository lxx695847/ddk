<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:34:"./views/index/withdrawal/bank.html";i:1578453273;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加银行卡</title>
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
    <?php if(isset($user['banknumber']) && !empty($user['banknumber'])): ?>
    <div class="bank_list">
        <div class="bank_item">
            <p class="bank_type">储蓄卡</p>
            <p class="bank_cardnum">****   ****   ****   <?php echo substr($user['banknumber'],-4); ?></p>
        </div>
    </div>
    <?php else: ?>
    <img class="top_img" src="/public/index/img/bank_top.png">
    <?php endif; ?>

    <div class="main">
        <div class="bind_box">
            <p class="change_ti">添加银行卡</p>
            <input type="text" placeholder="请输入银行卡号" name="banknumber" value="<?php echo $user['banknumber']; ?>">
            <input type="text" placeholder="请输入持卡人姓名" name="bname" value="<?php echo $user['bname']; ?>">
            <input type="text" placeholder="请输入联系人手机号" name="phone" value="<?php echo $user['phone']; ?>">
            <div class="clearfix"></div>
            <p class="bind_tips">*请确认信息无误</p>
            <button class="submit_btn">确定完成</button>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $(".submit_btn").on('click',function () {
        var banknumber = $('input[name="banknumber"]').val();
        var bname = $('input[name="bname"]').val();
        var phone = $('input[name="phone"]').val();

        var patterns = /^[\u4E00-\u9FA5]{1,6}$/;

        var pattern = /^1[3456789]\d{9}$/;

        /*if (banknumber == '') {
            layer.msg('银行卡账号不能为空');
            return false;
        }

        if (bname == '') {
            layer.msg('收款人姓名不能为空');
            return false;
        }

        if (phone == '') {
            layer.msg('联系人手机号码不能为空');
            return false;
        }

        if(!patterns.test(bname)){
            layer.msg('请填写正确姓名');
            return false;
        }

        if(!pattern.test(phone)) {
            layer.msg('请填写正确的联系人手机号');
            return false;
        }*/
        var ufs = layer.load();
        $.ajax({
            url: "<?php echo url('index/user/edit'); ?>",
            type: "post",
            dataType: 'json',
            data: {'banknumber': banknumber, 'bname': bname, 'phone': phone, 'type': 2},
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