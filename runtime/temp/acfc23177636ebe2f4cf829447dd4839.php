<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:31:"./views/index/income/index.html";i:1578479288;s:53:"/www/wwwroot/www.ddk.com/views/index/layout/main.html";i:1578453278;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>懂贷咖</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/mui.picker.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/income.css?v=1">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/js/mui.picker.min.js"></script>
    <script src="/public/layer/layer.js"></script>
</head>
<body>
<div class="container">
    <div class="headtop">
        <div class="user_head">
            <p>
                <img src="/public/index/img/dailishang/userhead_mm.png" alt="">小欧小
<!--                <a href="<?php echo url('/index/agent/ranking'); ?>"><span class="iconfont iconpaihangbang-&#45;&#45;"></span></a>-->
            </p>
        </div>
        <div class="total_income clearfix">
            <div class="total_list">
                <p class="income_num"><?php echo $data['todayIncome']; ?></p>
                <p class="income_ti">今日收入</p>
            </div>
            <div class="total_list">
                <p class="income_num"><?php echo $data['totalIncome']; ?></p>
                <p class="income_ti">累计收入</p>
            </div>
            <div class="total_list">
                <p class="income_num"><?php echo $data['todayCustom']; ?></p>
                <p class="income_ti">今日订单</p>
            </div>
            <div class="total_list">
                <p class="income_num"><?php echo $data['totalCustom']; ?></p>
                <p class="income_ti">累计订单</p>
            </div>
        </div>
        <p class="income_tab">
            <span class="active" type="1">借款平台查询</span>
            <span type="2">律师咨询服务</span>
        </p>
    </div>
    <div class="choose_box">
        <div class="choose_time">
            <span class="time_start">2019.01.01</span>至
            <span class="time_end"><?php echo $data['time']; ?></span>
            <span class="iconfont iconsaomiao search"></span>
        </div>
        <div class="choose_type">
            <span class="choose_txt tif">本人</span>
            <span class="sanjiaoxing tif"></span>
        </div>
        <ul>
            <li data-val="1">本人</li>
            <li data-val="2">下级</li>
        </ul>
    </div>
    <div class="table_box">
        <div class="search_box active"></div>
    </div>
    <div class="tabbar">
        <?php
use think\Request;
$type = Request::instance()->controller();
?>
<div class="tabbar">
    <a href="<?php echo url('/index/income/index'); ?>">
    <div class="tab_item <?php if($type == 'Income'): ?>active<?php endif; ?>">
        <p><span class="iconfont iconmingxi"></span></p>
        <p>收入明细</p>
    </div>
    </a>
    <a href="<?php echo url('/index/promotion/index'); ?>">
    <div class="tab_item <?php if($type == 'Promotion'): ?>active<?php endif; ?>" >
        <p><span class="iconfont iconchanpintuiguang"></span></p>
        <p>产品推广</p>
    </div>
    </a>
    <a href="<?php echo url('/index/announcement/index?tid=2'); ?>">
    <div class="tab_item <?php if($type == 'Announcement'): ?>active<?php endif; ?>">
        <p><span class="iconfont iconsee-icon-m3-notice-fill"></span></p>
        <p>平台公告</p>
    </div>
    </a>
    <a href="<?php echo url('/index/personal/index'); ?>">
    <div class="tab_item <?php if($type == 'Personal'): ?>active<?php endif; ?>">
        <p><span class="iconfont iconicon-test"></span></p>
        <p>个人中心</p>
    </div>
    </a>
</div>
    </div>
</div>
</body>
<script>
    $(function(){
        function getData(type,sort){
            var url="<?php echo url('index/Income/getParse'); ?>";
            var start=$(".time_start").html().split(".").join("-");
            var end=$(".time_end").html().split(".").join("-");
            var send={"type":type,"start":start,"end":end,"sort":sort};
            $.post(url,send,function (row) {
                var a="";
                if(row.status=="success"){
                    if(row.data!=false){
                        $.each(row.data,function (i,v) {
                            a+="<div class='search_item'>"
                                +"<p class='search_plat'>借款平台:<span>"+v.cname+"</span><span class='plat_way'>"+v.type+"</span></p>"
                                +"<p class='search_plat'>手机号:"+v.mobile+"</p>"
                                +"<p class='search_plat'>时间:"+timestamp(v.create_time)+"</p>"
                                +"<p class='search_num'>+"+v.money+"<span>元</span></p>"
                                +"</div>"
                        });
                    }else{
                        a="<p style='text-align: center;line-height: 80px;font-size: 18px;'>暂无记录</p>";
                    }
                    $(".search_box").html(a);
                }else{
                    layer.msg(row.msg);
                }
            })
        }
        var type=1;
        var sort=1;
        getData(type,sort);
        //搜索
        $(".search").on('click',function () {
            getData(type,sort);
        });

        //选择
        $("ul li").on('click',function () {
            sort=$(this).data('val');
            getData(type,sort);
        });

        function timestamp(timestamp){
            var d = new Date(timestamp * 1000);    //根据时间戳生成的时间对象
            var date = (d.getFullYear()) + "." +
                (d.getMonth() + 1) + "." +
                (d.getDate());
            return date
        }

        $(".income_tab span").click(function(){
            $(this).addClass("active").siblings().removeClass("active");
            type=$(this).attr("type");
            getData(type,sort);

            //搜索
            $(".search").on('click',function () {
                getData(type,sort);
            });

            //选择
            $("ul li").on('click',function () {
                sort=$(this).data('val');
                getData(type,sort);
            });
        });

        $(".choose_type").click(function(){
            $(".choose_box ul").show()
        });

        $(".choose_box ul li").click(function(){
            var txt = $(this).html();
            var val = $(this).data("val");
            $(".choose_type").find(".choose_txt").html(txt);
            $(".choose_type").attr("data-val",val);
            $(".choose_box ul").hide()
        });

        $(".tab_item").click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

        $(".time_start").click(function(){
            var dtpicker = new mui.DtPicker(
                {
                    type: "date", //设置日历初始视图模式
                    beginDate: new Date(2018, 01, 01), //设置开始日期
                    endDate: new Date()
                }
            );
            dtpicker.show(function (selectItems) {
                $(".time_start").text(selectItems.text)
            })
        });

        $(".time_end").click(function(){
            var dtpicker = new mui.DtPicker(
                {
                    type: "date", //设置日历初始视图模式
                    beginDate: new Date(2019, 01, 01), //设置开始日期
                    endDate: new Date()
                }
            );
            dtpicker.show(function (selectItems) {
                $(".time_end").text(selectItems.text)
            })
        });
    })
</script>
</html>