<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:29:"./views/admin/note/index.html";i:1578453292;s:46:"/www/wwwroot/www.ddk.com/views/admin/base.html";i:1578453289;}*/ ?>
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
    <!--tab标签-->
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">文章列表</li>
            <li class=""><a href="<?php echo url('backend/note/add'); ?>">添加文章</a></li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">

                <form class="layui-form layui-form-pane" action="<?php echo url('backend/note/index'); ?>" method="get">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="请输入关键词" class="layui-input">
                        </div>
                    </div>
					
                    <div class="layui-inline">
                        <button class="layui-btn">搜索</button>
                    </div>
                </form>
                <hr>

                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                       <th>标题</th>
						 <th>简介</th>
						 <th>分类</th>
                       	<th>排序</th>
						<th>时间</th>
                        <th width="8%">操作</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($note_list) || $note_list instanceof \think\Collection || $note_list instanceof \think\Paginator): if( count($note_list)==0 ) : echo "" ;else: foreach($note_list as $key=>$vo): ?>
                    <tr>
                        <td style="width:4%"><?php echo $vo['id']; ?></td>
                     	<td style="width:20%"><b><a style="color:#007aff" href="javascript:title(<?php echo $vo['id']; ?>)"><?php echo $vo['title']; ?></a></b></td>
						<td style="width:20%"><?php echo $vo['jianjie']; ?></td>
						<td style="width:10%"><?php echo $vo['tname']; ?></td>
                        <td style="width:4%"><?php echo $vo['descc']; ?></td>
                        <td  style="width:10%"><?php echo date("Y-m-d H:i:s",$vo['lasttime']); ?></td>
                        <td style="text-align:center">
                            <a href="<?php echo url('backend/note/edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-mini">编辑</a>
                            <a href="<?php echo url('backend/note/delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-mini ajax-delete">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <!--分页-->
                <?php echo $note_list->render(); ?>
            </div>
        </div>
    </div>
</div>
 <script>
            var lis=document.getElementById("lis");
            var marks=document.getElementById("marks");

            function title(id){
                $.ajax({
                    url:"<?php echo url('backend/note/title'); ?>",
                    type:'post',
                    dateType:'json',
                    data:{'id':id},
                    success:function(json){
                        if(json.code == 0){
                            layer.open({
                                type: 1,
                                title: false,
                                area: ['800px','900px'], //宽高
                                closeBtn: 0,
                                shadeClose: true,
                                skin: 'yourclass',
                                content: '<div style="padding:50px;"><h2 class="detail-title" style="box-sizing: border-box; font-size: 24px; text-align: center; font-weight: 400; padding-right: 40px; white-space: normal;padding-bottom:20px;"></br>'+json.data.title+'</h2><div style="line-height: 40px;">'+json.data.content+'</div></div>'
                            });
                        }else{
                            layer.msg(json.msg);
                        }
                    }
                })
            }
 </script>

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

</body>
</html>