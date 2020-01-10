<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:29:"./views/index/wxpay/hpay.html";i:1578453272;}*/ ?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>订单支付</title>
    <script src="/public/js/jquery.min.js"></script>
    <link href="/public/index/css/mui.min.css" rel="stylesheet" />
</head>
<body>
<div class="mui-content">
    <div class="mui-card" style="position: relative;top:0px;">
        <div class="mui-card-content">
            <form name="payform" action="<?php echo url('/index/wxpay/alypay'); ?>" method="post" target="_blank" style="display:none;" id="czpay">
                <?php if(isset($data['cid']) && !empty($data['cid'])): ?>
                    <input type="hidden" name="cid" value="<?php echo $data['cid']; ?>">
                <?php else: ?>
                    <input type="hidden" name="lid" value="<?php echo $data['lid']; ?>">
                <?php endif; ?>
                <input type="hidden" name="pid" value="<?php echo $data['pid']; ?>">
            </form>
            <div class="mui-card-content-inner">
                <div style="font-size: 20px;padding-bottom: 16px;padding-left: 0px;">
                    <p>贷款平台服务费<?php echo $price+28.8; ?>元</p>
                    <p style="width:100%;font-size: 14px;color: red; line-height: 30px; border-bottom: 1px solid #ebebeb;"><font color="red" style="font-size: 16px;text-align: center;"><b>限时特价优惠<span style="font-size: 24px;">28.8</span>元</b></font></p>
                </div>
                <div style="font-size: 20px;padding-bottom: 16px;color: #333333;padding-left: 0px;">
                    <p style="width:100%;font-size: 14px;color: #333333; line-height: 30px;">请选择支付方式</p>
                    <p style="line-height: 40px;clear: both;">
                        <img src="/public/index/img/zfb.jpg"  style="width: 40px;float: left;"/><span style="padding-left: 15px;color: #000;;">支付宝</span><input   type="radio"   value="zfb" checked="checked"   name="zhifu" style="float: right;margin-top: 10px;"/>
                    </p>
                </div>
                <div align="center">
                    <button id="ljzf" style="width:210px; height:40px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;margin-top: 30px;" >立即支付</button>
                </div>
             </div>
        </div>
    </div>
</div>
<br/>
</body>
</html>
<script>
    $('#ljzf').click(function(){
        var val = $('input[name="zhifu"]:checked').val();
        var browser = navigator.userAgent.toLowerCase();
        if(val == 'wx' && browser.match(/Alipay/i)=="alipay"){
            alert('当前为支付宝环境，请选择支付宝支付。');
        }
        else if(val == 'wx'){
            document.getElementsByTagName("title")[0].innerText = '微信支付';
            window.location.href = "";
        }
        else{
            document.getElementsByTagName("title")[0].innerText = '支付宝支付';
            document.getElementById("czpay").submit();
        }
    })
</script>