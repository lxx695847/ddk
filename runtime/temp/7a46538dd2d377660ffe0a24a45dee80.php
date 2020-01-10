<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./views/index/customers/comment.html";i:1578453280;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>评论管理</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/index/css/iconfont.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/index/css/comment.css">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
    <style>
        .show{width: 21px;height: 21px;border-radius: 50%;background: red;line-height: 21px;
            text-align: center;margin-top: 13px; display: inline-block;color: white;float: right;margin-right: 10%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="comment_top">
        <p>
            <a href="<?php echo url('index/Customers/reply'); ?>">
                <img src="/public/index/img/user/icon_coms.png" alt="">回复我的
                <?php if($res['reply'] != 0): ?>
                <span class="show"><?php echo $res['reply']; ?></span>
                <?php endif; ?>
                <i class="mui-icon mui-icon-arrowright"></i>
            </a>
        </p>
        <p>
            <a href="<?php echo url('index/Customers/praise'); ?>">
                <img src="/public/index/img/user/icon_zan.png" alt="">点赞
                <?php if($res['praise'] != 0): ?>
                <span class="show"><?php echo $res['praise']; ?></span>
                <?php endif; ?>
                <i class="mui-icon mui-icon-arrowright"></i>
            </a>
        </p>
    </div>
    <div class="gray_line"></div>

    <div class="comment_box">
        <p class="comment_ti">我的评论</p>
        <?php if($res['list'] != false): foreach($res['list'] as $v): ?>
            <div class="comment_list">
                <div class="comment_head clearfix">
                    <div class="head_left">
                        <img src="/public/index/img/user/userhead_nv.png" alt="">
                    </div>
                    <div class="head_right">
                        <p><?php echo $v['uname']; ?></p>
                        <p><?php echo date("Y-m-d",$v['createdAt']); ?></p>
                    </div>
                </div>
                <p class="comment_cont"><?php echo $v['content']; ?></p>
                <p class="zan_num">
                    <img src="/public/index/img/user/zan_red.png" alt=""><?php echo $v['awesome']; ?>人赞过
                </p>
            </div>
            <?php endforeach; else: ?>
            <p style="text-align: center;line-height: 60px;">暂无评论</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>