<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:33:"./views/index/platform/index.html";i:1578453277;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查询记录</title>
    <link rel="stylesheet" href="/public/css/mui.min.css?v=963">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/index/css/reward.css">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="time_box">
        <span class="time_ti">时间：</span>
        <div class="choose_time">
            <input type="text" value="<?php echo $keyWord; ?>"  name="keyWord" id="keyWord" placeholder="搜索平台名称">
            <img src="/public/index/img/icon_search.png" alt="" id="btn">
        </div>
    </div>
    <p class="my_order">查询记录</p>

    <div class="order_box">

        <div class="mui-content mui-scroll-wrapper order_box" style="margin-top: 20%;padding-top:0px;height:600px;"
             id="pullrefresh">
            <div style="padding:0;margin:0;background-color: #efeff4;">
                <div class="mui-content-padded" style="background-color: #efeff4;">
                    <div class="mui-input-row mui-search input-search" style="width:100%;background-color: #efeff4;">
                    </div>
                </div>
                <ul id="lis" class="mui-table-view mui-table-view-chevron" style="background-color: #efeff4;">

                </ul>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    page = 0;
    limit = 20;
    mui.init({
        pullRefresh: {
            container: "#pullrefresh",//待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
            up: {
                auto:true,
                contentrefresh: "正在加载...",//可选，正在加载状态时，上拉加载控件上显示的标题内容
                contentnomore: '没有更多数据了',//可选，请求完毕若没有更多数据时显示的提醒内容；
                callback: pullupRefresh //必选，刷新函数，根据具体业务来编写，比如通过ajax从服务器获取新数据；
            }
        }
    });
    function pullupRefresh() {
        setTimeout(function () {
            page++;
            data();
        }, 500);
    };
    mui('body').on('tap', 'a', function () {
        window.top.location.href = this.href;
    });
    $("#btn").click(function () {
        var keyWord = $("#keyWord").val();
        window.location.href = "<?php echo url('/index/platform/index'); ?>?keyWord=" + keyWord;
    });

    var lis = document.getElementById("lis");
    function data() {
        var keyWord = '<?php echo $keyWord; ?>';
        var type = '<?php echo $type; ?>';
        $.ajax({
            url:"<?php echo url('/index/platform/query'); ?>",
            type:'post',
            data:{'keyWord':keyWord,"page":page,"limit":limit,'type':type},
            success: function (data) {
                if (data.data.length < limit) {
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(true);
                } else {
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(false);
                }

                for (var a in data.data) {
                    // console.log(data.data);
                    //  var score = '<div class="score_num">'+ data.data[a].score +'</div><p>报告分数</p>';
                    var url = '<?php echo url("index/index/detail"); ?>?signs=' + data.data[a].signs;

                    var indexs = '<li><div class="order_list">\n' +
                        '            <p>平台名称：'+ data.data[a].name +'</p>\n' +
                        '            <p>可贷额度：<span>'+ data.data[a].amount +'</span></p>\n' +
                        '            <p>年化利率：<span>'+ data.data[a].interest +'</span></p>\n' +
                        '            <p>联系方式：<span>'+ data.data[a].phone +'</span></p>\n' +
                        '            <p class="order_time">查询时间：'+ data.data[a].createdAt +'</p>\n' +
                        '            <div class="score_box">\n' +
                        '                <div class="score_num"><span>'+ data.data[a].score +'</span><br>评分</div>\n' +
                        '                <div class="clearfix"></div>\n' +
                        '                <a href="'+ url +'"><img src="/public/index/img/icon_srecord.png">查看详情</a>\n' +
                        '            </div>\n' +
                        '        </div></li>';
                    lis.innerHTML += indexs;
                }
            }
        });
    }
    window.addEventListener('toggle', function (event) {
        if (event.target.id === 'M_Toggle') {
            var isActive = event.detail.isActive;
            var table = document.querySelector('.mui-table-view');
            var card = document.querySelector('.mui-card');
            if (isActive) {
                card.appendChild(table);
                card.style.display = '';
            } else {
                var content = document.querySelector('.mui-content');
                content.insertBefore(table, card);
                card.style.display = 'none';
            }
        }
    });
</script>
</html>