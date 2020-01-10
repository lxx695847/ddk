<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:38:"./views/index/personal/supplement.html";i:1578453277;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>懂贷咖</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/mui.picker.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/user_info.css">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/js/mui.picker.min.js"></script>
    <script src="/public/layui/layui.all.js"></script>
</head>
<body>
<div class="container">
    <div class="content">
        <p class="info_list">
            头像
            <a href="javascript:;">
                <?php if(isset($data['gender']) && $data['gender'] == 2): ?>
                    <img src="/public/index/img/userhead_mm.png" alt="">
                <?php else: ?>
                    <img src="/public/index/img/userhead_nan.png" alt="">
                <?php endif; ?>
            </a>
        </p>
        <p class="info_list">
            用户名
            <a class="change_name" href="javascript:;">
                <span class="info_right"><?php if(isset($data['names']) && !empty($data['names'])): ?><?php echo $data['names']; endif; ?></span>
                <span class="mui-icon mui-icon-arrowright"></span>
            </a>
        </p>
        <p class="info_list">
            性别
            <a class="change_sex" href="javascript:;">
                <span class="info_right"><?php if(isset($data['gender']) && $data['gender'] == 1): ?>男<?php elseif(isset($data['gender']) && $data['gender'] == 2): ?>女<?php endif; ?></span>
                <span class="mui-icon mui-icon-arrowright"></span>
            </a>
        </p>
    </div>
    <div class="content">
        <p class="info_list">
            地区
            <a class="change_area" href="javascript:;">
                <span class="info_right"><?php if(isset($data['province']) && !empty($data['province'])): ?><?php echo $data['province'].$data['city']; endif; ?></span>
                <span class="mui-icon mui-icon-arrowright"></span>
            </a>
        </p>
        <p class="info_list">
            注册时间
            <a href="javascript:;"><?php if(isset($data['create_time']) && !empty($data['create_time'])): ?><?php echo date("Y-m-d H:i:s",$data['create_time']); else: endif; ?></a>
        </p>
    </div>
    <!-- 修改昵称 -->
    <div class="cover_box">
        <div class="cover_warp">
            <textarea name="" id="" cols="30" rows="10">小欧小</textarea>
            <p>支持中文、英文
                <button>确定</button>
            </p>
        </div>
    </div>
</div>
</body>
<script>
    $(function () {
        $(".change_name").click(function () {
            $(".cover_box").show()
        })
        $(".cover_warp button").click(function () {
            var name = $(this).parent().siblings("textarea").val();
            $.ajax({
               url:"<?php echo url('/index/personal/edit'); ?>",
                type:'post',
                dataType:'json',
                data:{'names':name},
                success:function(json){
                    if(json.code == '0'){
                        layer.msg(json.message);
                    }else{
                        layer.msg(json.message);
                    }
                }
            });
            $(".change_name .info_right").text(name);
            $(".cover_box").hide()
        })
        $(".change_sex").click(function () {
            var picker = new mui.PopPicker();
            picker.setData([{value: '1', text: '男'}, {value: '2', text: '女'}]);
            picker.show(function (selectItems) {
                $.ajax({
                    url:"<?php echo url('/index/personal/edit'); ?>",
                    type:'post',
                    dataType:'json',
                    data:{'gender':selectItems[0].value},
                    success:function(json){
                        if(json.code == '0'){
                            layer.msg(json.message);
                        }else{
                            layer.msg(json.message);
                        }
                    }
                });
                $(".change_sex .info_right").text(selectItems[0].text)
            })
        })
        $(".change_area").click(function () {
            var province ;
            $.ajax({
                url:"<?php echo url('/index/personal/province'); ?>",
                type:'post',
                dataType:'json',
               // data:{'gender':selectItems[0].value},
                success:function(json){
                    var picker = new mui.PopPicker({
                        layer: 2
                    });
                    picker.setData(json);
                    picker.show(function (SelectedItem) {
                        $.ajax({
                            url:"<?php echo url('/index/personal/edit'); ?>",
                            type:'post',
                            dataType:'json',
                            data:{'province':SelectedItem[0].text,'city':SelectedItem[1].text},
                            success:function(json){
                                if(json.code == '0'){
                                    layer.msg(json.message);
                                }else{
                                    layer.msg(json.message);
                                }
                            }
                        });
                        $(".change_area .info_right").text(SelectedItem[0].text + SelectedItem[1].text)
                    })
                }
            });



        })
    })
</script>
</html>