<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:33:"./views/index/personal/index.html";i:1578453277;s:53:"/www/wwwroot/www.ddk.com/views/index/layout/main.html";i:1578453278;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>懂贷咖</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/css/iconfont.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/index/css/xuser.css">
    <script src="/public/js/mui.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
</head>
<body>

<style>
    .bot_box {
        margin-top: 0.2rem;
        padding-bottom: 1rem;
    }

    .set_out {
        height: 0.9rem;
        line-height: 0.9rem;
        background: #fff;
        text-align: center;
        font-size: 0.3rem;
        margin-bottom: 0.2rem;
    }

    .set_out a {
        color: #333333;
    }

    .sign_out a {
        color: #ff4444;
    }
</style>

<div class="container">
    <div class="user_box">
        <div class="user_top">
            <div class="user_head clearfix">
                <div class="head_left">
                    <?php if(isset($data['gender']) && $data['gender'] == 2): ?>
                    <img src="/public/index/img/userhead_mm.png" alt="">
                    <?php else: ?>
                    <img src="/public/index/img/userhead_nan.png" alt="">
                    <?php endif; ?>
                </div>
                <div class="head_cen">
                    <p><?php echo $data['names']; ?></p>
                    <p><?php echo substr_replace($data['mobile'], '****',3,4); ?></p>
                </div>
                <a href="<?php echo url('/index/personal/supplement'); ?>">
                    <div class="head_right">
                        <i class="mui-icon mui-icon-arrowright"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="gray_area"></div>
        <div class="user_cen">
            <p class="remain_ti"><?php echo $data['money']; ?></p>
            <p class="remain_p">账户余额</p>
            <p class="remain_p">累计总收入：<?php echo $data['total_achievement']; ?></p>
            <a class="withdrawal_btn" href="<?php echo url('/index/withdrawal/index'); ?>">立即提现</a>
        </div>
    </div>
    <div class="user_item">
        <a href="<?php echo url('/index/ranking/index'); ?>">
            <p>
                <img src="/public/index/img/icon_agent_ranking.png" alt="">排行榜
                <i class="mui-icon mui-icon-arrowright"></i>
            </p>
        </a>
    </div>
    <div class="user_item">
        <a href="<?php echo url('/index/withdrawal/list_index'); ?>">
            <p>
                <img src="/public/index/img/fk.png" alt="">提现记录
                <i class="mui-icon mui-icon-arrowright"></i>
            </p>
        </a>
        <a href="<?php echo url('/index/subordinate/index'); ?>">
            <p>
                <img src="/public/index/img/icon_team.png" alt="">我的团队
                <i class="mui-icon mui-icon-arrowright"></i>
            </p>
        </a>
        <a href="<?php echo url('/index/customer/invite'); ?>">
            <p>
                <img src="/public/index/img/icon_invite.png" alt="">邀请代理
                <i class="mui-icon mui-icon-arrowright"></i>
            </p>
        </a>
    </div>
    <div class="user_item">
        <a href="<?php echo url('/index/Agent/handbook'); ?>">
            <p>
                <img src="/public/index/img/icon_operate.png" alt="">操作手册
                <i class="mui-icon mui-icon-arrowright"></i>
            </p>
        </a>
    </div>
    <div class="user_item">
        <a href="<?php echo url('/index/Agent/commonProblem'); ?>">
            <p>
                <img src="/public/index/img/icon_question.png" alt="">常见问题
                <i class="mui-icon mui-icon-arrowright"></i>
            </p>
        </a>
        <a href="<?php echo url('/index/customer/index'); ?>">
            <p>
                <img src="/public/index/img/icon_customer.png" alt="">联系客服
                <i class="mui-icon mui-icon-arrowright"></i>
            </p>
        </a>
    </div>
    <div class="user_item">
        <a href="<?php echo url('/index/personal/modify'); ?>">
            <p>
                <img src="/public/index/img/icon_change.png" alt="">密码修改
                <i class="mui-icon mui-icon-arrowright"></i>
            </p>
        </a>
    </div>

    <div class="bot_box">
        <!--  <div class="set_out">
              <a href="javascript:;">切换账号</a>
          </div> -->
        <div class="set_out sign_out">
            <a href="<?php echo url('index/login/drop'); ?>">退出登录</a>
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
    $(function () {
        $(".tab_item").click(function () {
            $(this).addClass("active").siblings().removeClass("active");
        })
    })
</script>