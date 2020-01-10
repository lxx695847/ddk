<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:34:"./views/admin/useragent/index.html";i:1578453290;s:46:"/www/wwwroot/www.ddk.com/views/admin/base.html";i:1578453289;}*/ ?>
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
            <li class="layui-this">代理商管理</li>
            <li class=""><a href="<?php echo url('/backend/useragent/add'); ?>">添加代理商</a></li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">

                <form class="layui-form layui-form-pane" id="myform" action="<?php echo url('/backend/useragent/index'); ?>" method="get">
				<!--<a class="layui-btn layui-btn-normal layui-btn-radius" target="_blank" href="<?php echo url('admin/user/getAll',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-mini">组织架构图</a>-->
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="请输入关键词" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">开始时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input start_time" name="startTime" id="date1" value="<?php echo $startTime; ?>">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">结束时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input end_time" name="endTime" id="date2" value="<?php echo $endTime; ?>">
                        </div>
                    </div>
						
                    <div class="layui-inline">
                      
						 <div class="layui-inline">
									<button onclick="search()" class="layui-btn">搜索</button>
					</div>
                       <div class="layui-inline">
									<button onclick="excel()" class="layui-btn">导出EXCEL</button>
								</div>
                    </div>
                </form>
                <hr>

                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>手机</th>
                        <th>代理类型</th>
                        <th>推荐人</th>
                        <th>有效</th>
                        <th>余额</th>
                        <th>总业绩</th>
                        <th>备注</th>
                        <th>创建时间</th>
                        <th>状态</th>
                        <th>是否添加微信</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($user_list) || $user_list instanceof \think\Collection || $user_list instanceof \think\Paginator): if( count($user_list)==0 ) : echo "" ;else: foreach($user_list as $key=>$vo): ?>
                    <tr>
                        <td><?php echo $vo['id']; ?></td>
                        <td><?php echo $vo['names']; ?></td>
                        <td><?php echo $vo['mobile']; ?></td>
                      	<td><?php echo $vo['agent_name']; ?></td>
                      	<td><?php echo $vo['pnames']; ?></td>
                        <td><?php echo $vo['status']==1 ? '启用' : '禁用'; ?></td>
                        <td><?php echo $vo['money']; ?></td>
                        <td><?php echo $vo['total_achievement']; ?></td>
                        <td><?php echo $vo['note']; ?></td>
                        <td><?php echo $vo['create_time']; ?></td>
                        <td><a href="<?php echo url('backend/useragent/index',['total_achievement'=>$vo['total_achievement'] > 0 ? 1 : 0]); ?>" style="color: #4b9ffa;"><?php echo $vo['total_achievement']>0 ? '有效' : '无效'; ?></a></td>
                        <td>
                            <?php if(isset($vo['iswx']) and $vo['iswx'] == 1): ?>
                            <a  data-id= "<?php echo $vo['id']; ?>" data-iswx = '0' class="layui-btn layui-btn-normal layui-btn-mini iswxs">已添加</a>
                            <?php else: ?>
                            <a  data-id= "<?php echo $vo['id']; ?>" data-iswx = '1' class="layui-btn layui-btn-danger layui-btn-mini iswx">未添加</a>
                            <?php endif; ?>
                        </td>
                        <td>
                         	<a href="<?php echo url('backend/useragent/selxia',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-mini">查下级</a>
                            <a href="<?php echo url('backend/useragent/edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-mini">编辑</a>
                            <a href="<?php echo url('backend/useragent/delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-mini ajax-delete">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
					<div style="float:right; font-size:20px;"> 今日注册代理数：<?php echo $countjin; ?> 其中有效代理：<?php echo $countyouxiaojin; ?>  | 代理总人数：<?php echo $count; ?>其中有效代理：<?php echo $countyouxiao; ?></div>
                <!--分页-->
                <?php echo $user_list->render(); ?>
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

<!--页面JS脚本-->

<script src="/public/layer/layer.js"></script>
<script>
  
  $(document).ready(function(){
        $('.iswx').on('click',function(){
            var id = $(this).attr('data-id');
            var iswx = $(this).attr('data-iswx');
            wx(id,iswx);
        })

        $('.iswxs').on('click',function(){
            var id = $(this).attr('data-id');
            var iswx = $(this).attr('data-iswx');
            wx(id,iswx);
        })
    });

    function wx(id,iswx){
        $.ajax({
            url:'<?php echo url("backend/useragent/iswx"); ?>',
            type:'post',
            data:{'id':id,'iswx':iswx},
            dataType:'json',
            success : function(json){
                if(json){
                    layer.msg('成功',{time:500},function(){
                        var pageURL = $(location).attr("href");
                        window.location.href = pageURL;
                    });
                }else{
                    layer.msg('失败');
                }
            }
        })
    }
  
  
  
    function addOne(){
		$.get("<?php echo url('backend/useragent/form'); ?>",function(data){
			$(".form_customer:first").prepend(data);
			form.render('select');
		});
	}
	function excel(){
		 $("#myform").attr('action',"<?php echo url('backend/useragent/excel'); ?>");
	}
	function search(){
		 $("#myform").attr('action',"<?php echo url('backend/useragent/index'); ?>");
	}
</script>

</body>
</html>