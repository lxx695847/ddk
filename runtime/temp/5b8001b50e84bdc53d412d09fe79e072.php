<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:29:"./views/index/note/index.html";i:1578545934;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>公告</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/article.css">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/index/js/clipboard.min.js"></script>
    <script src="/public/layui/layui.all.js"></script>
</head>
<body>
<style>
    img{
        width: 100%;
    }
    .copy_btn {
    width: 1.74rem;
    height: 0.46rem;
    background-color: #7785eb;
    border-radius: 0.1rem;
    font-size: 0.28rem;
    color: #fff;
    display: block;
    margin: 0.01rem auto;
    border: none;
}
</style>
<div class="container">
    <div class="content">
        <h5><?php echo $data['title']; ?></h5>
        <p class="release_time"><img src="/public/index/img/ddk_logo.png" alt=""> <?php echo date('Y-m-d H:i',$data['lasttime']); ?></p>
        <p class="article_cont"><?php echo htmlspecialchars_decode($data['content']); ?>
        </p>
        <input name="url" style="text-align: center;font-size: 0.1px;z-index: -999;position: absolute;left: 39%;width: 1.2rem;height: 0.4rem;" value="<?php echo $_SERVER['HTTP_HOST']; ?>/index/note/index/id/<?php echo $data['id']; ?>" id="foo2"  style="width:300px;"  type="text">
        <span class="copy_btn copys webcopy" style="text-align: center;" data-clipboard-action="copy" data-clipboard-target="#foo2" id="webcopy">复制链接</span>
    </div>
</div>
</body>
<script>
    $(function(){
        $(".webcopy").on('click',function(){
            var clipboard = new Clipboard('.copys');
            layer.msg('链接复制成功',{time:500},function(){
                $(".cover_box1").hide();
            });

        });
    });
</script>
</html>