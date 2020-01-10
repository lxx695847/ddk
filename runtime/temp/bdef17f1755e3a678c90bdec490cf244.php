<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:33:"./views/admin/platform/index.html";i:1578453291;s:46:"/www/wwwroot/www.ddk.com/views/admin/base.html";i:1578453289;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>懂贷咖CMS后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/admin/css/font-awesome.min.css">
    <link rel="Shortcut Icon" type="image/x-icon" href="/favicon.ico">
    <!--CSS引用-->
    
<link rel="stylesheet" href="/public/index/css/mui.min.css">
<link rel="stylesheet" href="/public/index/css/iconfont.css">
<link rel="stylesheet" href="/public/index/css/style.css">
<link rel="stylesheet" href="/public/index/css/result1.css?v=12">

    <link rel="stylesheet" href="/public/admin/css/admin.css">
    <!--[if lt IE 9]>
    <script src="/public/admin/js/html5shiv.min.js"></script>
    <script src="/public/admin/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div class="layui-layout layui-layout-admin">
    <!--头部-->
    <div class="layui-header header">
        <a href=""><img class="logo" src="" alt="" width="177px"></a>
        <ul class="layui-nav" style="position: absolute;top: 0;right: 20px;background: none;">
            <li class="layui-nav-item"><a href="<?php echo url('/'); ?>" target="_blank">前台首页</a></li>
            <li class="layui-nav-item"><a href="" data-url="<?php echo url('backend/system/clear'); ?>" id="clear-cache">清除缓存</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;"><?php echo session('names'); ?></a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="<?php echo url('backend/change_password/index'); ?>">修改密码</a></dd>
                    <dd><a href="<?php echo url('backend/login/logout'); ?>">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>


    <!--侧边栏-->
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item layui-nav-title"><a>管理菜单</a></li>
                <li class="layui-nav-item">
                    <a href="<?php echo url('backend/index/index'); ?>"><i class="fa fa-home"></i> 系统信息</a>
                </li>
                <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): if(isset($vo['children'])): ?>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="<?php echo $vo['icon']; ?>"></i> <?php echo $vo['title']; ?></a>
                    <dl class="layui-nav-child">
                        <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): if( count($vo['children'])==0 ) : echo "" ;else: foreach($vo['children'] as $key=>$v): ?>
                        <dd><a href="<?php echo url($v['name']); ?>"> <?php echo $v['title']; ?></a></dd>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
                <?php else: ?>
                <li class="layui-nav-item">
                    <a href="<?php echo url($vo['name']); ?>"><i class="<?php echo $vo['icon']; ?>"></i> <?php echo $vo['title']; ?></a>
                </li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                <li class="layui-nav-item" style="height: 30px; text-align: center"></li>
            </ul>
        </div>
    </div>
    <!--主体-->
    
<style>
    .layui-input-block{
        margin-left:0px;
    }
    .layui-form-item{
        margin-bottom:0px;
    }
    .mui-scroll-wrapper{
        position: initial;
    }
    .mui-scroll {
        position: inherit;
    }
    .mui-table-view{
        background-color:transparent;
    }
    .mui-table-view:before{
        background-color:transparent;
    }
    .mui-table-view:after{
        background-color:transparent;
    }
    .mui-pull-caption{
        display: inherit;
    }
    .del-huifu {
        border: 1px solid #f6f6f6;
        background: #f6f6f6;
        margin-right: 5%;
    }

    .del-huifu ul li {
        list-style: none;
        font-size: 0.25rem;
        margin-left: 2%;
        color: #4b8beb;
        line-height: 30px;
    }
</style>
<div class="layui-body">
<div class="container">
    <div class="blue_bg"></div>
    <header>
        <!-- 有logo -->
        <div class="logo_box" style="display: none;">
            <img src="/public/index/img/logo_renrendai.png" alt="">
        </div>
        <!-- 无logo -->
        <img class="no_logo" src="<?php if(isset($data['logo']) && !empty($data['logo'])): ?><?php echo $data['logo']; else: ?>/public/index/img/logo_no.png<?php endif; ?>" alt="">
        <div class="score_box">
            <p class="platform_name"><?php if(isset($data['name']) && !empty($data['name'])): ?><?php echo $data['name']; endif; ?></p>
            <div class="score_top clearfix">
                <div class="score_left">
                    <p><?php echo $data['score']; ?></p>
                    <p>综合评分：
                        <?php $__FOR_START_1844730255__=0;$__FOR_END_1844730255__=$data['score'];for($i=$__FOR_START_1844730255__;$i < $__FOR_END_1844730255__;$i+=1){ ?>
                        <img src="/public/index/img/xing_shi.png" alt="">
                        <?php } if(isset($data['score']) && $data['score'] < 5): $a = 5-round($data['score']); $__FOR_START_1896040394__=0;$__FOR_END_1896040394__=$a;for($i=$__FOR_START_1896040394__;$i < $__FOR_END_1896040394__;$i+=1){ ?>
                        <img src="/public/index/img/xing_kong.png" alt="">
                        <?php } endif; ?>
                    </p>
                </div>
                <div class="score_right">
                    <p>电话催收：
                        <?php $__FOR_START_2090053767__=0;$__FOR_END_2090053767__=$data['p_collection'];for($i=$__FOR_START_2090053767__;$i < $__FOR_END_2090053767__;$i+=1){ ?>
                        <img src="/public/index/img/xing_shi.png" alt="">
                        <?php } if(isset($data['p_collection']) && $data['p_collection'] < 5): $a = 5-round($data['p_collection']); $__FOR_START_430020796__=0;$__FOR_END_430020796__=$a;for($i=$__FOR_START_430020796__;$i < $__FOR_END_430020796__;$i+=1){ ?>
                        <img src="/public/index/img/xing_kong.png" alt="">
                        <?php } endif; ?>
                    </p>
                    <p>上门催收：
                        <?php $__FOR_START_572835252__=0;$__FOR_END_572835252__=$data['s_collection'];for($i=$__FOR_START_572835252__;$i < $__FOR_END_572835252__;$i+=1){ ?>
                        <img src="/public/index/img/xing_shi.png" alt="">
                        <?php } if(isset($data['s_collection']) && $data['s_collection'] < 5): $a = 5-round($data['s_collection']); $__FOR_START_537856659__=0;$__FOR_END_537856659__=$a;for($i=$__FOR_START_537856659__;$i < $__FOR_END_537856659__;$i+=1){ ?>
                        <img src="/public/index/img/xing_kong.png" alt="">
                        <?php } endif; ?>
                    </p>
                    <p>司法起诉：
                        <?php $__FOR_START_2032255366__=0;$__FOR_END_2032255366__=$data['c_collection'];for($i=$__FOR_START_2032255366__;$i < $__FOR_END_2032255366__;$i+=1){ ?>
                        <img src="/public/index/img/xing_shi.png" alt="">
                        <?php } if(isset($data['c_collection']) && $data['c_collection'] < 5): $a = 5-round($data['c_collection']); $__FOR_START_1351545597__=0;$__FOR_END_1351545597__=$a;for($i=$__FOR_START_1351545597__;$i < $__FOR_END_1351545597__;$i+=1){ ?>
                        <img src="/public/index/img/xing_kong.png" alt="">
                        <?php } endif; ?>
                    </p>
                </div>
                <div class="ver_line"></div>
            </div>
            <div class="score_top score_top1 clearfix">
                <div class="score_left">
                    <img class="daikuan_pic" src="/public/index/img/edu_pic.png" alt="">
                    <p class="daikuan_ed">可贷额度</p>
                    <p class="daikuan_num"><?php echo $data['amount']; ?></p>
                </div>
                <div class="score_right">
                    <img class="daikuan_pic" src="/public/index/img/liv_pic1.png" alt="">
                    <p class="daikuan_ed">年化利率</p>
                    <p class="daikuan_num" style="left: 1.2rem;"><?php echo $data['interest']; ?></p>
                </div>
                <div class="ver_line"></div>
            </div>
        </div>
    </header>
    <div class="content_box">
        <div class="record_list clearfix">
            <div class="record_item">
                <p class="record_ti">放贷前<br>是否查征信</p>
                <p class="record_pan"><span><?php echo $data['isletter']; ?></span></p>
            </div>
            <div class="record_item record_item1">
                <p class="record_ti">逾期记录<br>是否上征信</p>
                <p class="record_pan"><span><?php echo $data['isonletter']; ?></span></p>
            </div>
        </div>
        <div class="platform">
            <p class="platform_ti">平台详细信息</p>
            <ul class="clearfix">
                <li class="platform_lil">
                    <p class="plat_left">
                        <img src="/public/index/img/nlyq.png" alt="">年龄要求
                    </p>
                    <p class="plat_right"><?php echo $data['age']; ?></p>
                </li>
                <li class="platform_lir">
                    <p class="plat_left">
                        <img src="/public/index/img/kdqs.png" alt="">可贷期数
                    </p>
                    <p class="plat_right"><?php echo $data['periods']; ?></p>
                </li>
                <li class="platform_lil">
                    <p class="plat_left">
                        <img src="/public/index/img/icon_time.png" alt="">成立时间
                    </p>
                    <p class="plat_right"><?php echo $data['established']; ?></p>
                </li>
                <li class="platform_lir">
                    <p class="plat_left">
                        <img src="/public/index/img/gsszd.png" alt="">公司所在地
                    </p>
                    <p class="plat_right"><?php echo $data['city']; ?></p>
                </li>
                <li class="platform_lil">
                    <p class="plat_left">
                        <img src="/public/index/img/paizhao.png" alt="">网络小贷牌照
                    </p>
                    <p class="plat_right"><?php echo $data['islicense']; ?></p>
                </li>
                <li class="platform_lir">
                    <p class="plat_left">
                        <img src="/public/index/img/mingcheng.png" alt="">征信上体现名称
                    </p>
                    <p class="plat_right"><?php if(isset($data['creditname']) and !empty($data['creditname'])): ?><?php echo $data['creditname']; else: ?>无<?php endif; ?></p>
                </li>
                <li class="platform_lil">
                    <p class="plat_left">
                        <img src="/public/index/img/jigou.png" alt="">所属机构
                    </p>
                    <p class="plat_right"><?php echo $data['mechanism']; ?></p>
                </li>
                <li class="platform_lir">
                    <p class="plat_left">
                        <img src="/public/index/img/dianhua.png" alt="">联系电话
                    </p>
                    <p class="plat_right"><?php echo $data['phone']; ?></p>
                </li>
                <li class="platform_lic">
                    <p class="plat_left">
                        <img src="/public/index/img/dizhi.png" alt="">公司地址
                    </p>
                    <p class="plat_right"><?php echo $data['address']; ?></p>
                </li>
            </ul>
        </div>
        <div class="comment">
            <p class="platform_ti">用户评论</p>
            <div id="refreshContainer" class="mui-scroll-wrapper reply" style="margin-top: 14px;border-radius: 4px;height: 270px;">
                <div class="mui-scroll">
                    <!--数据列表-->
                    <ul class="mui-table-view mui-table-view-chevron lai">

                    </ul>
                </div>
            </div>
        </div>
        <div class="send_comment"  style="left: 55%;">
            <div class="send_cen">
                <textarea id="" name="content"></textarea>
                <p class="text_tishi">
                    <span class="iconfont iconxiepinglun"></span> 说几句...
                </p>
                <p class="comment_num">
                    <img src="/public/index/img/icon_com.png" alt=""> <?php echo $count; ?>
                </p>
                <button class="send_btn" data-id="<?php echo $data['id']; ?>">发布</button>
            </div>
        </div>
    </div>
</div>
</div>

    <!--底部-->
    <div class="layui-footer footer">
        <div class="layui-main">
            <p> 2018 - 2021  </p>
        </div>
    </div>
</div>
<script>
    // 定义全局JS变量
    var GV = {
        current_controller: "backend/<?php echo (isset($controller) && ($controller !== '')?$controller:''); ?>/",
        base_url: "/public"
    };
</script>
<!--JS引用-->
<script src="/public/admin/js/jquery.min.js"></script>
<script src="/public/layui/layui.all.js"></script>
<script src="/public/layer/layer.js"></script>
<script src="/public/admin/js/admin.js?=12456"></script>

<script src="/public/index/js/mui.min.js"></script>

<!--页面JS脚本-->

<script>
    page = 0;
    limit = 5;
    pullupRefresh();

    mui.init({
        pullRefresh: {
            container: "#refreshContainer",//待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
            up: {
                contentrefresh: "正在加载...",//可选，正在加载状态时，上拉加载控件上显示的标题内容
                contentnomore: '没有更多数据了',//可选，请求完毕若没有更多数据时显示的提醒内容；
                callback: pullupRefresh //必选，刷新函数，根据具体业务来编写，比如通过ajax从服务器获取新数据；
            }
        }
    });
    function pullupRefresh() {
        var cid = "<?php echo $data['id']; ?>";
        setTimeout(function () {
            page++;
            data(cid);
        },500);
    }


    function data(cid){
        $.ajax({
            url: '<?php echo url("/api/comment/index"); ?>',
            type: 'post',
            data: {"cid": cid, "page": page, "limit": limit},
            dataType: 'json',
            success: function (json) {
                if (json.data.length < limit) {
                    mui('#refreshContainer').pullRefresh().endPullupToRefresh(true);
                }else{
                    mui('#refreshContainer').pullRefresh().endPullupToRefresh(false);
                }
                $.each(json.data, function (index, obj) {
                    var user_name = "<?php echo Session('user_name') ?>";
                    var reply = '';
                    var clas = obj.isawe ? '': 'awesome';
                    $.each(obj.reply,function(index,re){
                        reply += '<li>'+ re.uname +'<span style="margin-left: 3px;color: #999;">@'+ re.pname +'</span><a href="javascript:void(0)" style="color: #4b8beb;" class="'+ (re.uname == user_name ? "":'huifus') +'" data-commentId="' + obj.id + '" data-id="'+ obj.cid +'" data-replyid="'+ re.uid +'" data-name="'+ re.uname +'"> ' + (re.uname == user_name ? "":'回复') +':</a><span style="color:#878787;line-height: 16px;">'+ re.content +'</span></li>';
                    });
                    var html = '<li class="clearfix">\n' +
                        '                    <div class="comment_left">\n' +
                        '                        <img src="/public/index/img/userhead_nan.png" alt="">\n' +
                        '                    </div>\n' +
                        '                    <div class="comment_right">\n' +
                        '                        <p class="username">' + obj.uname + '\n' +
                        '                           <span class="zan_num">' + obj.awesome + '</span>\n' +
                        '                           <img src="/public/index/img/zan.png" alt="" class ="'+ clas + '" data-id="' + obj.id + '">\n' +
                        '                        </p>\n' +
                        '                        <p class="comment_txt">' + obj.content + '</p>\n' +
                        '                   <div class="'+ (reply.length > 0 ? 'del-huifu':'') + '">\n' +
                        '                        <ul>\n' + reply +
                        '                        </ul>\n'+
                        '                    </div>\n' +
                        '                        <p class="comment_time"> '+ new Date(parseInt(obj.createdAt) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ') +'<span class="'+ (obj.uname == user_name ? "":'huifus') +'" data-id="' + obj.cid + '" data-commentId="' + obj.id + '" data-replyid="' + obj.uid + '" data-name="' + obj.uname + '">回复</span></p>\n' +
                        '                    </div>\n' +
                        '                </li>';
                    $('.lai').append(html);
                });
            }
        })
    }






    $(function(){
        $(".send_cen textarea").focus(function(){
            $(".text_tishi").hide()
        })
        $(".send_cen textarea").blur(function(){
            if($(this).val() == ''){
                $(".text_tishi").show()
            }
        });

        $('.send_btn').on('click',function(){
            var id = $(this).attr('data-id');
            var content = $('textarea[name="content"]').val();
            var index = layer.load();
            $.ajax({
                url:'/backend/platform/save',
                type:'post',
                dataType:'json',
                data:{'content':content,'cid':id},
                success:function(info){
                    layer.close(index);
                    if(info.code == 0){
                        layer.msg(info.message,{tiem:300},function(){
                            window.location.reload();
                        });
                    }else{
                        layer.msg(info.message,{tiem:300});
                    }
                }
            })
        });


        mui(".mui-scroll").on('tap','.awesome',function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url:"<?php echo url('/api/awesome/save'); ?>",
                type:'post',
                data:{'commentId':id},
                dataType:'json',
                success:function(info){
                    if(info.code == 0){
                        window.location.reload();
                    }else{
                        layer.msg(info.message,{tiem:300});
                    }
                }
            })
        });

        mui(".mui-scroll").on('tap','.huifus',function(){
            var id = $(this).attr('data-id');
            var replyid = $(this).attr('data-replyid');
            var name = $(this).attr('data-name');
            var commentId = $(this).attr('data-commentId');
            layer.open({
                type: 1,
                area: ['350px', '200px'],
                btn:['确定','取消'],
                content: '<form class="layui-form" action=""> ' +
                    '<div class="layui-form-item layui-form-text">' +
                    '<div class="layui-input-block">'+
                    '<textarea name="contents" placeholder="@'+name+'" class="layui-textarea"></textarea>'+
                    '</div>'+
                    '</div>'+
                    '</form>'
                ,yes: function(index, layero){
                    var contents = $('textarea[name="contents"]').val();
                    $.ajax({
                        url:'/backend/platform/reply',
                        type:'post',
                        dataType:'json',
                        data:{'cid':id,'replyid':replyid,'pname':name,'commentId':commentId,'content':contents},
                        success:function(info){
                            if(info.code == 0){
                                layer.msg(info.message,{tiem:300},function(){
                                    window.location.reload();
                                });
                                layer.close(index);
                            }else{
                                layer.msg(info.message,{tiem:300});
                            }
                        }
                    })
                }
            });

        });
    })
</script>

</body>
</html>