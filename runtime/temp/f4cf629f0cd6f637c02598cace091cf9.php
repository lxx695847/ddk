<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:38:"./views/index/personal/modifypass.html";i:1578453277;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改密码</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/index/css/iconfont.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/index/css/change_password.css">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
    <script src="/public/layui/layui.all.js"></script>
</head>
<body>
<div class="container">
    <input type="text" name="mobile" placeholder="请输入手机号">
    <input type="password" name="pass" placeholder="请输入原密码">
    <input type="password" name="password" placeholder="请输入新密码">
    <input type="password" name="passwords" placeholder="请确认新密码">
    <button id="but">确认修改</button>
</div>
</body>
<script>
    $(document).ready(function () {
        $('#but').on('click', function () {
            var mobile = $('input[name="mobile"]').val();
            var pass = $("input[name='pass']").val();
            var password = $("input[name='password']").val();
            var passwords = $("input[name='passwords']").val();
            var verify = /^\d{11}$/;
            if (mobile == '' || !verify.test(mobile)) {
                layer.msg('手机号码格式错误');
                return;
            }
            if(pass == ''){
                layer.msg('原始密码不能为空');return;
            }

            if(password == ''){
                layer.msg('新密码不能为空');return;
            }

            if(passwords == ''){
                layer.msg('确认密码不能为空');return;
            }

            if(password != passwords){
                layer.msg('两次密码不一致');return;
            }
            var index = layer.load(1);
            $.ajax({
                url: "<?php echo url('api/login/edit'); ?>",
                type: 'post',
                dataType: 'json',
                data: {'mobile': mobile, 'pass': pass, 'password': password, 'passwords': passwords,'type':1},
                success: function (json) {
                    if(json.code == 0){
                         layer.close(index);
                         layer.msg(json.message,{time:300},function(){
                             window.location.href = '/index/login/login';
                         });
                    }else{
                        layer.close(index);
                        layer.msg(json.message);
                    }
                }
            })

        });
    })


</script>
</html>