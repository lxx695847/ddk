<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:33:"./views/admin/authagent/edit.html";i:1578453297;s:46:"/www/wwwroot/www.ddk.com/views/admin/base.html";i:1578453289;}*/ ?>
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
            <li class=""><a href="<?php echo url('backend/authagent/index'); ?>">授权管理</a></li>
            <li class=""><a href="<?php echo url('backend/authagent/add'); ?>">添加授权</a></li>
            <li class="layui-this">编辑授权</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form form-container" action="<?php echo url('backend/authagent/update'); ?>" method="post">
					<div class="layui-form-item">
                        <label class="layui-form-label">代理商类型</label>
                        <div class="layui-input-block">
							<select name="aid" lay-search>
								<option value="0">请选择</option>
								<?php if(is_array($agent_list) || $agent_list instanceof \think\Collection || $agent_list instanceof \think\Paginator): if( count($agent_list)==0 ) : echo "" ;else: foreach($agent_list as $key=>$vo): ?>
                                <option value="<?php echo $vo['id']; ?>" <?php if($agent['aid']==$vo['id']): ?> selected="selected"<?php endif; ?>><?php echo $vo['agent_name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
					<div class="layui-form-item">
                        <label class="layui-form-label">产品</label>
                        <div class="layui-input-block">
							<select name="pid" lay-search>
								<option value="0">请选择</option>
								<?php if(is_array($product_list) || $product_list instanceof \think\Collection || $product_list instanceof \think\Paginator): if( count($product_list)==0 ) : echo "" ;else: foreach($product_list as $key=>$vo): ?>
                                <option value="<?php echo $vo['id']; ?>" <?php if($agent['pid']==$vo['id']): ?> selected="selected"<?php endif; ?>><?php echo $vo['name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                   	<div class="layui-form-item">
                        <label class="layui-form-label">默认成本价</label>
                        <div class="layui-input-block">
                            <input type="text" name="price" value="<?php echo $agent['price']; ?>" placeholder="请输入默认成本价" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">一级返佣</label>
                        <div class="layui-input-block">
                            <input type="text" name="rebate" value="<?php echo $agent['rebate']; ?>" placeholder="一级返佣百分比" class="layui-input">
                        </div>
                    </div>
                  	<div class="layui-form-item">
                        <label class="layui-form-label">二级返佣</label>
                        <div class="layui-input-block">
                            <input type="text" name="erjiprice" value="<?php echo $agent['erjiprice']; ?>" placeholder="请输入二级返佣百分比" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">最高定价</label>
                        <div class="layui-input-block">
                            <input type="text" name="highestprice" value="<?php echo $agent['highestprice']; ?>" placeholder="该版本最高定价多少" class="layui-input">
                        </div>
                    </div>
					
					<div class="layui-form-item">
                        <div class="layui-input-block">
                             <input type="hidden" name="id" value="<?php echo $agent['id']; ?>">
							<button class="layui-btn" lay-submit lay-filter="*">更新</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
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

</body>
</html>