<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:32:"./views/admin/comment/index.html";i:1578453295;s:46:"/www/wwwroot/www.ddk.com/views/admin/base.html";i:1578453289;}*/ ?>
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
    
<div class="layui-body">
    <style>
        .layui-input-block{
            margin-left: 0px;
            min-height: 0px;
        }
        .layui-layer-page .layui-layer-content{
            overflow: inherit;
        }
    </style>
    <!--tab标签-->
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">评论列表</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form layui-form-pane" id="myform" action="<?php echo url('backend/comment/index'); ?>"
                      method="get">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" value="<?php if(isset($get['keyword'])): ?><?php echo $get['keyword']; endif; ?>"
                            placeholder="请输入关键词" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">开始时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input start_time" name="start_time" id="date1"
                                   value="<?php if(isset($get['start_time'])): ?><?php echo $get['start_time']; endif; ?>">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">结束时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input end_time" name="end_time" id="date2"
                                   value="<?php if(isset($get['end_time'])): ?><?php echo $get['end_time']; endif; ?>">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <button class="layui-btn">搜索</button>
                    </div>
                </form>
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户</th>
                        <th>平台</th>
                        <th>内容</th>
                        <th>点赞量</th>
                        <th>回复量</th>
                        <th>创建时间</th>
                        <th width="8%">操作</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center;">
                    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
                    <tr>
                        <td style="width:4%"><?php echo $vo['id']; ?></td>
                        <td style="width:10%"><?php if(isset($vo['uid']) && $vo['uid'] > 0): ?><?php echo $vo['uname']; else: ?>总部<?php endif; ?>
                        </td>
                        <td style="width:8%"><?php echo $vo['name']; ?></td>
                        <td style="width:5%"><?php echo $vo['content']; ?></td>
                        <td style="width:15%;"><?php echo $vo['awesome']; ?></td>
                        <td style="width:8%;"><span class="res" style="color:#4b9ffa" data-id="<?php echo $vo['id']; ?>" data-cid="<?php echo $vo['cid']; ?>"><?php echo $vo['responses']; ?></span></td>
                        <td style="width:10%"><?php echo date("Y-m-d H:i:s",$vo['createdAt']); ?></td>
                        <td style="text-align:center; width:10%">
                            <a href="javascript:void(0);"
                               class="layui-btn layui-btn-xs huifus" data-commentId="<?php echo $vo['id']; ?>" data-id="<?php echo $vo['cid']; ?>" data-replyid="<?php echo $vo['uid']; ?>" data-name="<?php echo $vo['uname']; ?>">回复</a>
                            <a href="<?php echo url('backend/platform/index',['id'=>$vo['cid']]); ?>"
                               class="layui-btn layui-btn-xs layui-btn-normal">详情</a>
                            <a href="<?php echo url('backend/comment/delete',['id'=>$vo['id']]); ?>"
                               class="layui-btn layui-btn-danger layui-btn-xs ajax-delete">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <!--分页-->
                <?php echo $data->render(); ?>
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

<!--页面JS脚本-->

    <script>
        $('.res').on('click', function () {
           var id =  $(this).attr('data-id');
           var cid =  $(this).attr('data-cid');
            layer.open({
                type: 2,
                area: ['800px', '320px'],
                title:'回复',
                fixed: false, //不固定
                maxmin: true,
                shadeClose: true,
                shade: 0.8,
                content: 'subdirectory?id='+id+'&cid='+cid
            });
        });

        $(".huifus").on('click',function(){
            var id = $(this).attr('data-id');
            var replyid = $(this).attr('data-replyid');
            var name = $(this).attr('data-name');
            var commentId = $(this).attr('data-commentId');
            layer.open({
                type: 1,
                area: ['350px', '200px'],
                btn:['确定','取消'],
                scrollbar: false,
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

        function excel() {
            $("#myform").attr('action', "<?php echo url('/backend/company/excel'); ?>");
        };
    </script>
    
</body>
</html>