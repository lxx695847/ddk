<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:28:"./views/index/wxpay/pay.html";i:1578453273;}*/ ?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>微信支付</title>
    <script src="/public/js/jquery.min.js"></script>
    <script type="text/javascript">
        $().ready(function(){
            callpay();
        });
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $result; ?>,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                }
            );
        }
        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
        function query(){
            var order_no="<?php echo $order_no; ?>";
            $.post("/index/index/one",{out_trade_no:order_no}, function(data) {
                if(data.code == 0){
                    window.location.href="<?php echo url('index/index/detail'); ?>?signs="+data.data.signs;
                }
            },'json');
        }
        $(document).ready(function(){
            setInterval(query, 3000);
        });
    </script>
</head>
<body>
</body>
</html>