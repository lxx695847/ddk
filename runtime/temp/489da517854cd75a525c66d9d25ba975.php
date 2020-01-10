<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:30:"./views/admin/company/add.html";i:1578453294;s:46:"/www/wwwroot/www.ddk.com/views/admin/base.html";i:1578453289;}*/ ?>
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
            <li class=""><a href="<?php echo url('backend/company/index'); ?>">公司列表</a></li>
            <li class="layui-this">添加公司</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form form-container" action="<?php echo url('backend/company/save'); ?>" method="post">
                    <div class="layui-form-item">
                        <label class="layui-form-label">平台名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="<?php if(isset($get['name']) && !empty($get['name'])): ?><?php echo $get['name']; endif; ?>" required lay-verify="required" placeholder="平台名称"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">平台logo</label>
                        <div class="layui-input-block">
                            <input type="text" name="logo" value="" class="layui-input layui-input-inline" id="thumb">
                            <button type="button" class="layui-btn" id="file_upload" data-type="4"
                                    style="height: 38px;"><i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">综合评分</label>
                        <div class="layui-input-block">
                            <input type="text" name="score" value="" required lay-verify="required" placeholder="5" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">电话催收评分</label>
                        <div class="layui-input-block">
                            <input type="text" name="p_collection" value="" required lay-verify="required" placeholder="5" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">上门催收评分</label>
                        <div class="layui-input-block">
                            <input type="text" name="s_collection" value="" required lay-verify="required" placeholder="5" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">司法催收评分</label>
                        <div class="layui-input-block">
                            <input type="text" name="c_collection" value="" required lay-verify="required" placeholder="5" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">可贷额度</label>
                        <div class="layui-input-block">
                            <input type="text" name="amount" value="" required lay-verify="required"
                                   placeholder="请输入放款额度如:1千-5千" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">年化利率</label>
                        <div class="layui-input-block">
                            <input type="text" name="interest" value="" placeholder="请输入利息如:年化12%-24%" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">是否查征信</label>
                        <div class="layui-input-block">
                            <?php foreach($iswhether as $key => $value): ?>
                            <input type="radio" name="isletter" value="<?php echo $value; ?>" <?php if($key == 0): ?>checked="checked" <?php endif; ?> title="<?php echo $value; ?>">
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">是否上征信</label>
                        <div class="layui-input-block">
                            <?php foreach($iswhether as $key => $value): ?>
                            <input type="radio" name="isonletter" value="<?php echo $value; ?>" <?php if($key == 0): ?>checked="checked" <?php endif; ?> title="<?php echo $value; ?>">
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">年龄要求</label>
                        <div class="layui-input-block">
                            <input type="text" name="age" value="" required lay-verify="required"
                                   placeholder="请输入年龄要求如:18-55岁" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">可贷期数</label>
                        <div class="layui-input-block">
                            <input type="text" name="periods" value="" required lay-verify="required"
                                   placeholder="请输入放款额度如:7-14天" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">成立时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="established" value="" required lay-verify="required"
                                   placeholder="请输入平台成立时间如:3年以上" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">公司所在地</label>
                        <div class="layui-input-block">
                            <input type="text" name="city" value="" placeholder="请输入平台所在地" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">持有金融牌照类型</label>
                        <div class="layui-input-block">
                            <select name="islicense" lay-verify="required">
                                <?php if(is_array($islcense) || $islcense instanceof \think\Collection || $islcense instanceof \think\Paginator): if( count($islcense)==0 ) : echo "" ;else: foreach($islcense as $key=>$vo): ?>
                                <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">征信上体现名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="creditname" value=""  placeholder="请输入征信商体现名称" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">所属机构</label>
                        <div class="layui-input-block">
                            <input type="text" name="mechanism" value="" required lay-verify="required"
                                   placeholder="请输入放款机构如:*****有限公司" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">联系电话</label>
                        <div class="layui-input-block">
                            <input type="text" name="phone" value="" required lay-verify="required"
                                   placeholder="请输入联系电话" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">公司地址</label>
                        <div class="layui-input-block">
                            <input type="text" name="address" value="" placeholder="请输入平台所在地" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="*">保存</button>
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