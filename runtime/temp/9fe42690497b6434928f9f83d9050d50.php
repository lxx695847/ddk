<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./views/index/withdrawal/index.html";i:1578453273;}*/ ?>
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
    <link rel="stylesheet" href="/public/layer/mobile/need/layer.css">
    <link rel="stylesheet" href="/public/index/css/withdrawal.css?v=78">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
    <script src="/public/layer/layer.js"></script>
</head>
<body>
<style>
    .submit_btn {
        width: 6.1rem;
        height: 0.76rem;
        background-image: linear-gradient(87deg, #a051f2 0%, #7536d4 100%), linear-gradient(#8948d2, #8948d2);
        background-blend-mode: normal, normal;
        border-radius: 0.38rem;
        border: none;
        font-size: 0.3rem;
        color: #ffffff;
        display: block;
        margin: 0.8rem auto 0;
    }
</style>
<div class="container">
    <div class="withdrawal_top">
        <div class="money_box">
            <span>￥</span>
            <input type="text" name="price" id="" value="0">
            <input type="hidden" name="bankname" value="<?php echo $user['bankname']; ?>">
            <input type="hidden" name="banknumber" value="<?php echo $user['banknumber']; ?>">
            <input type="hidden" name="phone" value="<?php echo $user['phone']; ?>">
            <input type="hidden" name="type" value="1">
        </div>
        <p class="withdrawal_ti">可提现余额：<?php echo $user['money']; ?></p>
    </div>
    <div class="withdrawal_way">
        <p>
            <span class="choose active" data-type="1"></span>支付宝<a class="withdrawal_p" href="<?php echo url('/index/withdrawal/zfb'); ?>"><?php if(isset($user['bankname']) && empty($user['bankname'])): ?>未绑定<?php else: ?>更换<?php endif; ?>支付宝账号</a>
        </p>
        <p>
            <span class="choose" data-type="2"></span>银行卡<a class="withdrawal_p" href="<?php echo url('/index/withdrawal/bank'); ?>"><?php if(isset($user['banknumber']) && empty($user['banknumber'])): ?>未绑定<?php else: ?>更换<?php endif; ?>银行卡号</a>
        </p>
    </div>
    <p class="change_way">
        <a href="javascript:void(0);">
            <img src="/public/index/img/icon_alipy.png" alt="">更换支付宝账号
        </a>
        <a href="javascript:void(0);">
            <img class="yinl" src="/public/index/img/icon_yin.png" alt="">添加新的银行卡
        </a>
    </p>
    <div class="explain">
        <p>提现说明：</p>
        <p>1.单笔最少50元</p>
        <p>2.工作日内半小时到账（9:00-19：00）</p>
        <p>3.非工作日48小时之内到账</p>
    </div>
    <button class="submit_btn">确定</button>
</div>
</body>
<script>
    $(function(){
        $(".choose").click(function(){
            $('input:hidden[name="type"]').val($(this).attr('data-type'));
            $(this).addClass("active").parent().siblings().find(".choose").removeClass("active")
        });


        $('.submit_btn').on('click', function () {
            var price = $('input[name="price"]').val();
            var bankname = $('input:hidden[name="bankname"]').val();
            var banknumber = $('input:hidden[name="banknumber"]').val();
            var phone = $('input:hidden[name="phone"]').val();
            var type = $('input:hidden[name="type"]').val();
            //很多判断
            if (price == '') {
                layer.msg('金额不能为空');return;
            }
            if (price < 50) {
                layer.msg('提现金额不能低于50元！');return;
            }

            if(type == 1){
                if(bankname == '' || phone == ''){
                    layer.msg('请去补全提现信息',{time:500},function(){
                            window.location.href = "<?php echo url('index/withdrawal/zfb'); ?>";
                    })
                }
            }

            if(type == 2){
                if(banknumber == '' || phone == ''){
                    layer.msg('请去补全提现信息',{time:500},function(){
                        window.location.href = "<?php echo url('index/withdrawal/bank'); ?>";
                    })
                }
            }

            $.ajax({
                url:"<?php echo url('index/withdrawal/mention'); ?>",
                type:'post',
                dataType:'json',
                data:{'price':price,'type':type},
                success:function(json){
                    if(json.code == 0){
                        layer.msg(json.message,{time:500},function(){
                            window.location.href = '';
                        })
                    }else{
                        layer.msg(json.message);
                    }
                }
            })

        })
    })
</script>
</html>