<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:33:"./views/admin/withdraw/index.html";i:1578453289;s:46:"/www/wwwroot/www.ddk.com/views/admin/base.html";i:1578453289;}*/ ?>
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
            <li class="layui-this">提现管理</li>
            <li class=""><a href="<?php echo url('backend/withdraw/add'); ?>">添加提现</a></li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form layui-form-pane" id="myform" method="get">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" id="keyword" name="keyword" value="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">开始时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input start_time" name="start" id="start" value="">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">结束时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input end_time" name="end" id="end" value="">
                        </div>
                    </div>
                </form>

                <div class="layui-inline">
                    <button onclick="getSearch()" class="layui-btn">搜索</button>
                </div>
                <div class="layui-inline">
                    <button onclick="excel()" class="layui-btn">导出EXCEL</button>
                </div>
                <div class="layui-inline">
                    <button onclick="reset()" class="layui-btn">重置</button>
                </div>

                <hr>
                <?php if($list['res'] != false): ?>
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th style="width: 30px;">ID</th>
                        <th>客户名</th>
                        <th>提现金额</th>
                        <th>账户余额</th>
                        <th>类型</th>
                        <th>提现名</th>
                        <th>联系方式</th>
                        <th>账号</th>
                        <th>状态</th>
                        <th>时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list['res'] as $vo): if($vo['money'] > $vo['balance']): ?>
                    <tr style="background: rgba(255,0,0,0.1);">
                        <td><?php echo $vo['id']; ?></td>
                        <td><?php echo $vo['names']; ?></td>
                        <td><?php echo $vo['money']; ?></td>
                        <td><?php echo $vo['balance']; ?></td>
                        <td><?php if($vo['type'] == 1): ?>支付宝<?php else: ?>银行卡<?php endif; ?></td>
                        <td><?php echo $vo['name']; ?></td>
                        <td><?php echo $vo['mobile']; ?></td>
                        <td><?php echo $vo['bankcard']; ?></td>
                        <td>待处理</td>
                        <td><?php echo date("Y-m-d",$vo['create_time']); ?></td>
                        <td>
                            <a href="<?php echo url('backend/Withdraw/get_edit'); ?>?sign=<?php echo $vo['sign']; ?>" class="layui-btn layui-btn-normal layui-btn-mini">编辑</a>
                            <a data-sign="<?php echo $vo['sign']; ?>" class="getDel layui-btn layui-btn-danger layui-btn-mini">删除</a>
                        </td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td><?php echo $vo['id']; ?></td>
                        <td><?php echo $vo['names']; ?></td>
                        <td><?php echo $vo['money']; ?></td>
                        <td><?php echo $vo['balance']; ?></td>
                        <td><?php if($vo['type'] == 1): ?>支付宝<?php else: ?>银行卡<?php endif; ?></td>
                        <td><?php echo $vo['name']; ?></td>
                        <td><?php echo $vo['mobile']; ?></td>
                        <td><?php echo $vo['bankcard']; ?></td>
                        <td><?php if($vo['status'] == 1): ?>
                            已支付
                            <?php else: ?>
                            <a data-sign="<?php echo $vo['sign']; ?>" class="getPay layui-btn layui-btn-danger layui-btn-mini">支付</a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date("Y-m-d",$vo['create_time']); ?></td>
                        <td>
                            <a href="<?php echo url('backend/Withdraw/get_edit'); ?>?sign=<?php echo $vo['sign']; ?>" class="layui-btn layui-btn-normal layui-btn-mini">编辑</a>
                            <a data-sign="<?php echo $vo['sign']; ?>" class="getDel layui-btn layui-btn-danger layui-btn-mini">删除</a>
                        </td>
                    </tr>
                    <?php endif; endforeach; ?>
                    </tbody>
                </table>
                <!--分页-->
                <?php echo $list['page']; else: ?>
                <p style="text-align: center;line-height: 80px;font-size: 18px;">暂无记录</p>
                <?php endif; ?>
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

<script>
    $(function(){
        //支付
        $(".getPay").on('click',function () {
            var load=layer.load(1);
            var send="<?php echo url('backend/Withdraw/get_pay'); ?>";
            var sign=$(this).data('sign');
            $.post(send,{'sign':sign},function (row) {
                layer.close(load);
                if(row.status=="success"){
                    layer.msg(row.msg,{icon:1},function () {
                        location.reload();
                    })
                }else{
                    layer.msg(row.msg,{icon:2},function () {
                        location.reload();
                    })
                }
            })
        });

        //删除
        $(".getDel").on('click',function () {
            layer.confirm("确定要删除该提现记录?",{btn:['确认','取消']},function () {
                var load1=layer.load(1);
                var send1="<?php echo url('backend/Withdraw/get_del'); ?>";
                var sign=$(this).data('sign');
                $.post(send1,{'sign':sign},function (row) {
                    layer.close(load1);
                    if(row.status=="success"){
                        layer.msg("删除成功",{icon:1},function () {
                            location.reload();
                        })
                    }else{
                        layer.msg("删除失败",{icon:2},function () {
                            location.reload();
                        })
                    }
                })
            })
        })
    });

    function excel(){
        var keyword=$("#keyword").val();
        var start=$("#start").val();
        var end=$("#end").val();
        layer.msg("导出数据中...",function () {
            location.replace("<?php echo url('backend/Withdraw/excel'); ?>?keyword="+keyword+"&start="+start+"&end="+end);
        });
    }

    function getSearch() {
        layer.msg("搜索中....");
        var keyword=$("#keyword").val();
        var start=$("#start").val();
        var end=$("#end").val();
        if(keyword==false && start==false && end==false){
            layer.closeAll();
            layer.msg("请至少选择一个搜索条件");
        }else{
            layer.closeAll();
            location.replace("<?php echo url('backend/Withdraw/index'); ?>?keyword="+keyword+"&start="+start+"&end="+end);
        }
    }

    function reset() {
        $("#myform")[0].reset();
        location.replace("<?php echo url('backend/Withdraw/index'); ?>")
    }
</script>

</body>
</html>