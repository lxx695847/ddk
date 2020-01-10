<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./views/index/withdrawal/query.html";i:1578453273;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>提现</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/withdrawal_record.css">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <p class="my_order">最新提现记录</p>
    <div class="order_box">
        <div id="refreshContainer" class="mui-scroll-wrapper reply" style="margin-top:15%;border-radius:4px;height:525px;">
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
            url: '<?php echo url("/index/withdrawal/query"); ?>',
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
                    var edit = '';
                    if(obj.status == 0){
                        img = '<span class="audit">审核中</span>';
                        //<a class="edit_btn" href="javascript:;">编辑</a>
                        edit = '';
                    }else if(obj.status == 1){
                        img = '<span class="success">成功</span>';
                        edit = '';
                    }else{
                        img = '<span class="fail">失败</span>';
                        edit = '';
                    }
                    var type = '';
                    if(obj.type == 1){
                        type = '支付宝';
                    }else{
                        type = '银行卡';
                    }

                    var html = '<div class="order_list">\n' +
                        '                    <p>金额：'+ obj.money +'元'+ img +'</p>\n' +
                        '                    <p>姓名：'+ obj.name +'</p>\n' +
                        '                    <p>类型：'+ type +'</p>\n' +
                        '                    <p class="order_time">下单时间：'+ obj.createAt +'</p>\n' +
                        '                    <p class="order_time">处理时间：'+ obj.updateAt +'</p>\n' +
                        edit +
                        '                </div>';
                    $('.lai').append(html);
                });
            }
        })
    }
</script>
<script>
    $(function(){
        $(".choose").click(function(){
            $(this).addClass("active").parent().siblings().find(".choose").removeClass("active")
        })
    })
</script>
</html>