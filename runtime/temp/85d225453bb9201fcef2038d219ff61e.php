<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:32:"./views/admin/company/index.html";i:1578453295;s:46:"/www/wwwroot/www.ddk.com/views/admin/base.html";i:1578453289;}*/ ?>
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
    <style>
        .layui-input-block{
            margin-left: 0px;
            min-height: 0px;
        }
        .layui-layer-page .layui-layer-content{
            overflow: inherit;
        }
    </style>
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">公司列表</li>
            <li class=""><a href="<?php echo url('backend/company/add'); ?>">添加公司</a></li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form layui-form-pane" id="myform" action="<?php echo url('backend/company/index'); ?>" method="get">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="请输入关键词" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">类型</label>
                        <div class="layui-input-block">
                            <select name="platformType" lay-verify="required">
                                <option value="0">全部</option>
                                <?php if(is_array($loan) || $loan instanceof \think\Collection || $loan instanceof \think\Paginator): if( count($loan)==0 ) : echo "" ;else: foreach($loan as $key=>$vo): ?>
                                <option value="<?php echo $key; ?>" <?php if(isset($sts) && !empty($sts) && $sts == $key): ?>selected="selected"<?php endif; ?> ><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">开始时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input start_time" name="start_time" id="date1" value="<?php echo $start_time; ?>">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">结束时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input end_time" name="end_time" id="date2" value="<?php echo $end_time; ?>">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <button class="layui-btn">搜索</button>
                    </div>
                    <div class="layui-inline" onclick="excel()">
                        <button  class="layui-btn">导出模板</button>
                    </div>
                    <div class="layui-inline ">
                         <button type="button" class="layui-btn" id="file_excel" data-type="2" >导入数据</button>
                    </div>
                </form>
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>平台</th>
                        <th>额度</th>
                        <th>期限</th>
                        <th>机构</th>
                        <th>电话</th>
                        <th>状态</th>
                        <th>访问量</th>
                        <th>logo</th>
                        <th>创建时间</th>
                        <th width="8%">操作</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center;">
                    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
                    <tr>
                        <td style="width:4%"><?php echo $vo['id']; ?></td>
                        <td style="width:10%"><?php echo $vo['name']; ?></td>
                        <td style="width:8%"><?php echo $vo['amount']; ?></td>
                        <td style="width:5%"><?php echo $vo['periods']; ?></td>
                        <td style="width:15%;"><?php echo $vo['mechanism']; ?></td>
                        <td style="width:10%"><?php echo $vo['phone']; ?></td>
                        <td style="width:4%"><?php echo $status[$vo['status']]; ?></td>
                        <td style="width:4%"><a href="<?php echo url('backend/company/index',['flow'=>1]); ?>" style="color:#4b9ffa"><?php echo $vo['flow']; ?></a></td>
                        <td style="width:4%"><?php if(isset($vo['logo']) && !empty($vo['logo'])): ?><img src="<?php echo $vo['logo']; ?>" width="40px" height="40px"/><?php endif; ?></td>
                        <td  style="width:10%"><?php echo date("Y-m-d H:i:s",$vo['createdAt']); ?></td>
                        <td style="text-align:center; width:15%">
                            <a href="javascript:void(0);" class="layui-btn layui-btn-primary layui-btn-xs send_btn" data-id="<?php echo $vo['id']; ?>" data-name="<?php echo $vo['name']; ?>">评论</a>
                            <a href="<?php echo url('backend/platform/index',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-xs layui-btn-normal">详情</a>
                            <a href="<?php echo url('backend/company/edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-xs">编辑</a>
                            <a href="<?php echo url('backend/company/delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-xs ajax-delete">删除</a>
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

<script>


    $(".send_btn").on('click',function(){
        var id = $(this).attr('data-id');
        //var index = layer.load();
        var name = $(this).attr('data-name');
        layer.open({
            type: 1,
            title:name,
            area: ['350px', '200px'],
            btn:['确定','取消'],
            scrollbar: false,
            content: '<form class="layui-form" action=""> ' +
                '<div class="layui-form-item layui-form-text">' +
                '<div class="layui-input-block">'+
                '<textarea name="contents" placeholder="内容" class="layui-textarea"></textarea>'+
                '</div>'+
                '</div>'+
                '</form>'
            ,yes: function(index,layero){
                var content = $('textarea[name="contents"]').val();
                $.ajax({
                    url:'/backend/platform/save',
                    type:'post',
                    dataType:'json',
                    data:{'content':content,'cid':id},
                    success:function(info){
                        //layer.close(index);
                        if(info.code == 0){
                            layer.msg(info.message,{tiem:300},function(){
                                window.location.reload();
                            });
                        }else{
                            layer.msg(info.message,{tiem:300});
                        }
                    }
                })
            }
        });
    });
function excel(){
    $("#myform").attr('action',"<?php echo url('/backend/company/excel'); ?>");
};
</script>

<!--页面JS脚本-->

</body>
</html>