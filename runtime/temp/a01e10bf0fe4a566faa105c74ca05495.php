<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:30:"./views/index/index/index.html";i:1578537976;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>懂贷咖</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/layer/mobile/need/layer.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/index/css/indexs.css">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
    <script src="/public/layer/layer.js"></script>
    <script src="/public/index/js/indexs.js?v=789456"></script>
    <style>
	    .cont_txt{
	    	width: 5.6rem;
	    	margin: 0.6rem auto 0;
	    }
    	.cover_ti2{
    		margin-left: 0.6rem;
    	}
    </style>
</head>
<body>
<div class="container">

    <div class="content">
        <div class="cont_head clearfix">
        	<a href="<?php echo url('/index/ranking/pindex'); ?>">
            <div class="head_left">排行榜</div>
             </a>
            <div class="head_cen">
                <img src="/public/index/img/laba.png" alt="">
                <marquee scrollamount="5">
                    <?php if(is_array($gonggao) || $gonggao instanceof \think\Collection || $gonggao instanceof \think\Paginator): $i = 0; $__LIST__ = $gonggao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <p><?php echo html_entity_decode($vo['marks']); ?></p>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </marquee>
            </div>
            <a href="<?php echo url('/index/login/login'); ?>">
            <div class="head_right">
                <img src="/public/index/img/head.png" alt="">
            </div>
            </a>
        </div>
        <img class="cont_txt" src="/public/index/img/wangdai1.png" alt="">
        <div class="cir_box">
            <ul>
                <li>
                    <img src="/public/index/img/edu001.png" alt="">可贷额度?
                </li>
                <li>
                    <img src="/public/index/img/leixing.png" alt="">真实利息?
                </li>
                <li>
                    <img src="/public/index/img/lixi001.png" alt="">上不上征信?
                </li>
                <li>
                    <img src="/public/index/img/zhengxin001.png" alt="">平台是否合规？
                </li>
                <li>
                    <img src="/public/index/img/paizhao.png" alt="">逾期会怎么样？
                </li>
            </ul>
        </div>
        <p class="search_tips">请输入平台全称，如“宜人贷”、“你我贷”、“陆金服”等。</p>
        <div class="mui-input-row mui-input-search" style="overflow: initial;">
                <input id="search_ipt" class="mui-input-clear se" name="company" type="text" oninput = "search()"  placeholder="输入您想要查询的贷款平台">
                <img class="search_icon" src="/public/index/img/search.png" alt="">
                <input type="hidden" name="pid" value="<?php echo $pid; ?>" >
                <input type="hidden" name="uid" value="<?php echo $uid; ?>" >
                <button class="search_btn mui-btn-royal" id="royal">立即查询</button>
            <div class="mui-scroll-wrapper" style="margin-top: 61px;border-radius: 4px;">
                <div class="mui-scroll">
                    <ul class="mui-table-view compan">

                    </ul>
                </div>
            </div>
        </div>
        <div class="cover_box">
            <div class="cover_wrap">
                <p class="cover_ti1">输入手机号</p>
                <p class="cover_ti2">便于查看搜索记录</p>
                <p class="cover_ti3">请输入手机号</p>
                <input type="text" placeholder="请输入11位手机号">
                <button class="submit">提&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;交</button>
                <button class="cancle">暂不提交</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript" charset="utf-8">
    search();
    mui.init();
    window.onload = function() {
        mui('.mui-scroll-wrapper').scroll({
            deceleration: 0.0005, //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
            bounce: true, //滚动条是否有弹力默认是true
            indicators: false, //是否显示滚动条,默认是true
        });
    };
    $(document).ready(function(){
        var companys;
        var pid = $('input[name="pid"]:hidden').val();
        var uid = $('input[name="uid"]:hidden').val();

        $("#royal").on('click',function(){
            companys = $(".se").val();
            $(".cover_box").show();
        });
        $(document).on('click','.del',function(){
            companys = $(this).attr('data-name');
            $(".cover_box").show();
        });

        $(".submit").click(function(){
            var telTest = /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;
            var mobile = $(".cover_wrap input").val();
            //var index = layer.load();
            if(telTest.test(mobile)){
                $.ajax({
                    url:"<?php echo url('/index/index/findOne'); ?>",
                    type:"post",
                    dataType:"json",
                    data:{'comp':companys,'pid':pid,'mobile':mobile,'uid':uid},
                    success:function(json){
                        if(json.code == 0){
                            window.location.href = json.data.redirect;
                        }else{
                            layer.msg(json.message);
                        }
                    }
                })
            }else if(mobile == ''){
                layer.msg('请输入手机号码');
                return;
            }else{
                layer.msg('请输入正确手机号码');
            }
        });


        $(".cancle").click(function(){
            $(".cover_box").hide();
        })
    });



    function search(){
        var company = $(".se").val();
        $(".mui-btn-royal").css('display','block');
        if($(".se").val() == ''){
            $(".mui-btn-royal").css('display','none');
            $('.compan').html('');
            $('.mui-scroll-wrapper').css('height','0px');
        }else{
            $.ajax({
                url:"<?php echo url('/api/index/index'); ?>",
                type:"post",
                dataType:"json",
                data:{'company':company},
                success:function(json){
                    if(json.code == 0){
                        if(json.data.data.length > 0){
                            $('.mui-scroll-wrapper').css('height','175px');
                        }else{
                            $('.mui-scroll-wrapper').css('height','0px');
                        }
                        $('.compan').html(json.data.data);
                    }
                }
            })
        }
    }
</script>