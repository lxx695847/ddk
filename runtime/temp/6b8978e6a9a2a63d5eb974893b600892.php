<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./views/index/subordinate/index.html";i:1578474518;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我的团队</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css?v=12">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/team.css">
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/layui/layui.all.js"></script>
</head>
<body>
<div class="container">
    <div class="colour_bg"></div>
    <div class="team_top">
        <div class="top_head clearfix">
            <div class="head_item">
                <p><?php if(isset($data['user']['xid']) && !empty($data['user']['xid'])): ?><?php echo $data['user']['xid']; else: ?>0<?php endif; ?></p>
                <p>团队总人数</p>
            </div>
            <div class="head_item">
                <p><?php if(isset($data['pmoney']) && !empty($data['pmoney'])): ?><?php echo $data['pmoney']; else: ?>0<?php endif; ?></p>
                <p>团队总收益</p>
            </div>
            <div class="head_item">
                <p><?php if(isset($data['dmoney']) && !empty($data['dmoney'])): ?><?php echo $data['dmoney']; else: ?>0<?php endif; ?></p>
                <p>团队今日收益</p>
            </div>
        </div>
        <p class="invite">邀请我的人</p>
        <div class="invite_box clearfix">
            <div class="invite_left">
                <img src="/public/index/img/user_headnan.png" alt="">
            </div>
            <div class="invite_right">
                <p class="user_num"><?php if(isset($data['user']['snames']) && !empty($data['user']['snames'])): ?><?php echo $data['user']['snames']; else: ?>0<?php endif; ?></p>
                <p class="user_id"><?php if(isset($data['user']['mobile']) && !empty($data['user']['mobile'])): ?><?php echo substr_replace($data['user']['mobile'],"****",3,4); else: ?>0<?php endif; ?></p>
            </div>
        </div>
    </div>
    <div class="list_box">
        <p class="invite invite1">我邀请的人
        </p>
        <div id="refreshContainer" class="mui-scroll-wrapper reply" style="margin-top:69%;border-radius:4px;height:525px;">
            <div class="mui-scroll lai">

            </div>
        </div>
    </div>
</div>
</body>
<script>
    page = 0;
    limit = 10;
    pullupRefresh();

    mui.init({
        pullRefresh: {
            container: "#refreshContainer",//待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
            up: {
                contentrefresh: "正在加载...",//可选，正在加载状态时，上拉加载控件上显示的标题内容
                contentnomore: ' ',//可选，请求完毕若没有更多数据时显示的提醒内容；
                callback: pullupRefresh //必选，刷新函数，根据具体业务来编写，比如通过ajax从服务器获取新数据；
            }
        }
    });
    function pullupRefresh() {
        setTimeout(function () {
            page++;
            data();
        },500);
    }


    function data(){
        $.ajax({
            url: '<?php echo url("/index/subordinate/query"); ?>',
            type: 'post',
            data: {"page": page, "limit": limit},
            dataType: 'json',
            success: function (json) {
                if (json.length < limit) {
                    mui('#refreshContainer').pullRefresh().endPullupToRefresh(true);
                }else{
                    mui('#refreshContainer').pullRefresh().endPullupToRefresh(false);
                }
                $.each(json, function (index, obj) {

                    var img = '';
                    if(obj.gender == 2){
                        img = '/public/index/img/userhead_nv.png';
                    }else{
                        img = '/public/index/img/user_headnan.png';
                    }
                    var html = '<div class="invite_box invite_box1 clearfix">\n' +
                        '            <div class="invite_left">\n' +
                        '                <img src="'+ img +'" alt="">\n' +
                        '            </div>\n' +
                        '            <div class="invite_right">\n' +
                        '                <p class="user_num">'+ obj.names +'</p>\n' +
                        '                <p class="user_id">'+ obj.mobile +'</p>\n' +
                        '                <p class="user_profit">累积收益:<span>'+ obj.total_achievement +'元</span>&nbsp;&nbsp;&nbsp;&nbsp;创造贡献:<span>'+obj.p_sum+'元</span></p>\n' +
                        '                <p class="active_time">注册时间:'+ obj.createdAt +'</p>\n' +
                        '            </div>\n' +
                        '        </div>';
                    $('.lai').append(html);
                });
            }
        })
    }
</script>
<script>
    $(function(){
        $(".top_right span").click(function(){
            $(this).addClass("active").siblings().removeClass("active");
            var index = $(this).index();
            $(".data_box").eq(index).addClass("active").siblings().removeClass("active");
        })
    })
</script>
<script>
    $(function(){
        $(".sort span").click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        })
    })
</script>
</html>