<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:34:"./views/index/promotion/index.html";i:1578453275;s:53:"/www/wwwroot/www.ddk.com/views/index/layout/main.html";i:1578453278;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>产品推广</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/mui.picker.min.css">
    <link rel="stylesheet" href="/public/css/mui.dtpicker.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/extension.css?v=789">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/index/js/clipboard.min.js"></script>
    <script src="/public/js/mui.picker.min.js"></script>
    <script src="/public/js/mui.dtpicker.js"></script>
    <script src="/public/layui/layui.all.js"></script>
</head>
<style>
    .set_box p span input{
        font-size: 0.3rem;
        height: 0.48rem;
        width: 2.4rem;
        padding: 0;
        margin: 0;
        border: none;
    }
</style>
<body>
<div class="container">
    <div class="main">
        <div class="btn_box clearfix">
            <button class="active">贷款平台推广</button>
            <!-- <button>律师咨询推广</button>-->
        </div>
        <div class="extension_box">
            <div class="extension_item active">
                <?php if(isset($data) && empty($data)): ?>
                <p class="set_price">价格设置</p>
                <div class="set_box">
                    <input type="hidden" name="type" value="<?php echo $prices['pid']; ?>" disabled>
                    <input type="hidden" name="pname" value="<?php echo $prices['pname']; ?>" disabled>
                    <p>平台查询</p>
                    <p>推广价格<span>￥<?php if(isset($prices['price']) && $prices['price'] != 0): ?><?php echo $prices['price']; else: ?><?php echo $prices['price']; endif; ?></span></p>
                    <button id="submit_save">添加推广</button>
                </div>
                <?php endif; ?>
                <p class="set_price extension_link">推广链接</p>
                <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="set_box">
                    <p>平台查询</p>
                    <p>链接代号：<?php echo $vo['link_name']; ?></p>
                    <!-- <p>成本价格<span>￥<?php if(isset($prices['price']) && $prices['price'] != 0): ?><?php echo $prices['price']; else: ?><?php echo $prices['price']; endif; ?></span></p>-->
                    <p>佣<span class="blank_p">佣金</span>金<span>￥</span><span class="price_com"><?php echo $vo['ticheng']; ?></span></p>
                    <p>推广价格<span>￥<?php echo $vo['price']; ?></p>
                    <input name="url" style="text-align: center;font-size: 0.1px;z-index: -999;position: absolute;left: 39%;top: 21px;width: 1.2rem;height: 0.4rem;" value="<?php echo $vo['url']; ?>" id="foo2"  style="width:300px;"  type="text">
                    <span class="mui-popup-button copy_links copys" style="width: 1.46rem;height: 0.4rem;line-height: 22px;background-color: #7785eb;border-radius: 0.1rem;border: none;display: block;margin: 0.3rem auto;font-size: 0.24rem;color: #ffffff;" data-clipboard-action="copy" data-clipboard-target="#foo2" id="webcopy">复制链接</span>
                    <button class="copy_code" data-pid="<?php echo $vo['id']; ?>" style="top: 56%;">推广二维码</button>
                    <button class="delete del" data-id="<?php echo $vo['id']; ?>">删除</button>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
    <?php
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
        $(".btn_box button").click(function(){
            $(this).addClass("active").siblings().removeClass("active")
            var index = $(this).index()
            $(".extension_item").eq(index).addClass("active").siblings().removeClass("active")
        })
        $(".choose_type").click(function(){
            $(".choose_box ul").toggle()
            var val = $(".choose_type").attr("data-val");
            console.log(val)
            $(".choose_box ul li").each(function(){
                if($(this).attr("data-val") == val){
                    $(this).css("background","#bcd9f9")
                }
            })
        })
        $(".choose_box ul li").click(function(){
            var txt = $(this).html();
            var val = $(this).data("val");
            $(this).css("background","#bcd9f9").siblings().css("background","#f0f0f0")
            $(".choose_type").find(".choose_txt").html(txt);
            $(".choose_type").attr("data-val",val);
            $(".choose_box ul").hide()
        })
        $(".tab_item").click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        })


        $('.del').on('click',function(){
            var id = $(this).attr('data-id');
            layer.confirm('是否确定删除该条链接？',function(){
                $.ajax({
                    url:"<?php echo url('index/promotion/del'); ?>",
                    type:'post',
                    dataType:'json',
                    data:{"id":id},
                    success:function(json){
                        if(json.code == 0){
                            layer.msg(json.message,{time:500},function(){
                                window.location.href = "<?php echo url('index/promotion/index'); ?>";
                            })
                        }else{
                            layer.msg(json.message);
                        }
                    }
                })
            });
        });

        $('#submit_save').on('click',function(){
            var type = $('input:hidden[name="type"]').val();
            var pname = $('input:hidden[name="pname"]').val();
            var ling = layer.load();
            $.ajax({
                url:"<?php echo url('index/promotion/add'); ?>",
                type:'post',
                dataType:'json',
                data:{'type':type,'pname':pname},
                success:function(json){
                    layer.close(ling);
                    if(json.code == 0){
                        layer.msg('添加成功',{time:500},function(){
                            window.location.href = "<?php echo url('index/promotion/index'); ?>";
                        });
                        $(".cover_box2").hide();
                    }else{
                        layer.msg(json.message);
                    }
                }
            })
        });

        $('#submit_edit').on('click',function(){
            var price = $('input[name="price_c"]').val();
            var type = $('input:hidden[name="type"]').val();
            var id = $('input:hidden[name="id"]').val();
            var link_name = $('input[name="link_name_c"]').val();
            if(link_name == ''){
                layer.msg('链接名不能为空');
                return;
            }
            if(!/^[\u4e00-\u9fa5]|\d+$/.test(link_name)){
                layer.msg('链接名只能为中文');
                return;
            }
            if(!/^(?:[1-9][0-9]*(?:\.[0-9]{1,2})?|0(?:\.[0-9]{1,2})?)$/.test(price)){
                layer.msg('请输入正确的金额');
                return;
            }
            var ling = layer.load();
            $.ajax({
                url:"<?php echo url('index/promotion/edit'); ?>",
                type:'post',
                dataType:'json',
                data:{'price':price,'id':id,'link_name':link_name,'type':type},
                success:function(json){
                    layer.close(ling);
                    if(json.code == 0){
                        layer.msg('添加成功',{time:500},function(){
                            window.location.href = "<?php echo url('index/promotion/index'); ?>";
                        });
                        $(".cover_box").hide();
                    }else{
                        layer.msg(json.message);
                    }
                }
            })
        });


        $("#webcopy").on('click',function(){
            var clipboard = new Clipboard('.copys');
            layer.msg('链接复制成功',{time:500},function(){
                $(".cover_box1").hide();
            });

        });

        $('.copy_code').on('click',function(){
            var pid = $(this).attr('data-pid');
            window.location.href = '/index/promotion/code_img?pid='+pid;
        })
    })
</script>
</html>