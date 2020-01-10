<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:38:"./views/index/announcement/indexs.html";i:1578545790;s:53:"/www/wwwroot/www.ddk.com/views/index/layout/main.html";i:1578453278;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>平台公告</title>
    <link rel="stylesheet" href="/public/css/mui.min.css">
    <link rel="stylesheet" href="/public/index/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/mui.picker.min.css">
    <link rel="stylesheet" href="/public/css/mui.dtpicker.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/index/css/notice.css">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/index/js/clipboard.min.js"></script>
    <script src="/public/layui/layui.all.js"></script>
</head>
<body>
	<style>
		.copy_cont{
			    width: 1.2rem;
    			height: 0.36rem;
    			display: block;
    			background-color: #ffeedb;
    			border-radius: 0.185rem;
    			border: none;
    			font-size: 0.24rem;
    			color: #df8826;
    			text-align: center;
    			line-height: 0.36rem;
    			margin-top: 0.16rem;
		}
	</style>
<div class="container">
    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $k=>$vo): ?>
    <div class="info_list">
    	<a href="<?php echo url('/index/note/index',['id'=>$vo['id']]); ?>">
        <p class="info_ti"><?php if(!empty($vo['tid']) && $vo['tid'] == 4): ?>公告文案<?php else: ?>产品素材<?php endif; ?></p>
        <p class="info_time"><?php echo $vo['lasttime']; ?></p>
        
        <p class="info_des"><?php echo $vo['title']; ?></p>
        </a>
        <p class="info_des"><?php echo $vo['jianjie']; ?></p>
        <div class="img_box clearfix">
            <?php if(isset($vo['thumb']) && !empty($vo['thumb'])): ?>
            <img src="<?php echo $vo['thumb']; ?>" alt="">
            <?php endif; ?>
        </div>
        <input name="url" style="text-align: center;font-size: 0.1px;z-index: -999;position: absolute;left: 2%;border-radius: 0.185rem; width: 1.3rem; height: 0.1rem;" value="<?php echo $_SERVER['HTTP_HOST']; ?>/index/note/index/id/<?php echo $vo['id']; ?>" id="foo<?php echo $vo['id']; ?>"  style="width:300px;"  type="text">
        <span class="copy_cont copys webcopy" style="text-align: center;" data-clipboard-action="copy" data-clipboard-target="#foo<?php echo $vo['id']; ?>" id="webcopy">复制链接</span>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; 
use think\Request;
$type = Request::instance()->controller();
?>
<div class="tabbar">
    <a href="<?php echo url('/index/income/index'); ?>">
    <div class="tab_item <?php if($type == 'Income'): ?>active<?php endif; ?>">
        <p><span class="iconfont iconmingxi"></span></p>
        <p>收入明细</p>
    </div>
    </a>
    <a href="<?php echo url('/index/promotion/index'); ?>">
    <div class="tab_item <?php if($type == 'Promotion'): ?>active<?php endif; ?>" >
        <p><span class="iconfont iconchanpintuiguang"></span></p>
        <p>产品推广</p>
    </div>
    </a>
    <a href="<?php echo url('/index/announcement/index?tid=2'); ?>">
    <div class="tab_item <?php if($type == 'Announcement'): ?>active<?php endif; ?>">
        <p><span class="iconfont iconsee-icon-m3-notice-fill"></span></p>
        <p>平台公告</p>
    </div>
    </a>
    <a href="<?php echo url('/index/personal/index'); ?>">
    <div class="tab_item <?php if($type == 'Personal'): ?>active<?php endif; ?>">
        <p><span class="iconfont iconicon-test"></span></p>
        <p>个人中心</p>
    </div>
    </a>
</div>
</div>
</body>
<script>
    $(function(){
        $(".tab_item").click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        })

        $(".webcopy").on('click',function(){
            var clipboard = new Clipboard('.copys');
            layer.msg('链接复制成功',{time:500},function(){
                $(".cover_box1").hide();
            });

        });
    })
</script>
</html>