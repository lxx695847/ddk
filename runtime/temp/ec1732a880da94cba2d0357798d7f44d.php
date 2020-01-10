<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./views/index/platform/collect.html";i:1578453276;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加平台信息</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/add_platform.css">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/layui/layui.all.js"></script>
</head>
<body>
<div class="container">
    <form class="layui-form form-container form_data" method="post" onsubmit="return false">
    <div class="add_box">
        <div class="add_item clearfix">
            <span>平台名称</span>
            <input type="text" name="name" placeholder="必填" required>
        </div>
        <div class="add_item clearfix">
            <span>平台LOGO</span>
            <input class="plat_logo" name="logo" type="text" placeholder="必填" required id="thumb">
            <button class="choose_pic" id="file_upload" data-type="2">选择图片</button>
        </div>
        <div class="add_item clearfix">
            <span>是否上征信</span>
            <input type="text" name="credit" placeholder="选填">
        </div>
        <div class="add_item clearfix">
            <span>联系电话</span>
            <input type="text" name="mobile" placeholder="选填">
        </div>
        <div class="add_item clearfix">
            <span>年龄要求</span>
            <input type="text" name="age" placeholder="选填">
        </div>
        <div class="add_item clearfix">
            <span>成立时间</span>
            <input type="text" name="established" placeholder="选填">
        </div>
        <div class="add_item clearfix">
            <span>公司地址</span>
            <input type="text" name="address" placeholder="选填">
        </div>
        <div class="add_item clearfix">
            <span>可贷期数</span>
            <input type="text" name="period" placeholder="选填">
        </div>
        <div class="add_item clearfix">
            <span>更多信息</span>
            <input type="hidden" name="sign" value="<?php echo $sign; ?>" placeholder="选填">
            <textarea  name="remark" placeholder="添加您了解的信息"></textarea>
        </div>
        <button class="sure_btn">确认信息无误并上传</button>
    </div>
    </form>
</div>
</body>
<script>
    $(document).ready(function(){
        $('.sure_btn').on('click',function(){
            var name = $('input[name="name"]').val();
            var logo = $('input[name="logo"]').val();

            if(name == ''){
                layer.msg('平台名称不能为空');return;
            }
            if(logo == ''){
                layer.msg('平台logo不能为空');return;
            }
            $.ajax({
                url:"<?php echo url('/index/platform/save'); ?>",
                type:'post',
                dataType:'json',
                data:$('.form_data').serialize(),
                success:function(json){
                    if(json.code == 0){
                        layer.msg(json.message,{time:500},function(){
                            window.location.href = '';
                        });
                    }else{
                        layer.msg(json.message);
                    }
                }
            })
        });



        layui.use('upload', function () {
            var upload = layui.upload;
            var type = $('#file_upload').attr('data-type');
            var uploadInst = upload.render({
                elem: '#file_upload',
                url: '/backend/uploads/single',
                data: {type:type},
                accept: 'images',
                exts: 'jpg|png|gif|bmp|jpeg',
                multiple: true,
                number: 5,
                done: function (res, index, uploads) {
                    if (res){
                        document.getElementById('thumb').value = res.file.url;
                    } else {
                        layer.msg(res);
                    }
                }
            })
        });
    })

</script>
</html>