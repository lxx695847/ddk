<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:29:"./views/index/index/paid.html";i:1578563702;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>懂贷咖</title>
    <link rel="stylesheet" href="/public/index/css/mui.min.css">
    <link rel="stylesheet" href="/public/index/css/iconfont.css">
    <link rel="stylesheet" href="/public/index/css/style.css">
    <link rel="stylesheet" href="/public/index/css/paid.css">
    <script src="/public/index/js/mui.min.js"></script>
    <script src="/public/index/js/jquery.min.js"></script>
   <!-- <script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script> -->
    <!--<script src="/public/index/wxsdk/sha1.js"></script>
    <script src="/public/index/wxsdk/wxShare_data.js?v=5"></script>
    <script src="/public/index/wxsdk/wxShare.js?v=4"></script>-->
    <style>
    	.bot_left, .bot_right{
    		font-size: 0.3rem;
    	}
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="logo_box">
            <img src="<?php if(isset($data['logo']) && !empty($data['logo'])): ?><?php echo $data['logo']; else: ?>/public/logo/ddk.png<?php endif; ?>" alt="">
        </div>
        <p class="platform_name"><?php echo $data['cname']; ?></p>
        <p class="saomiao"><img src="/public/index/img/saomiao.png" alt="">已为您扫描10万+数据</p>
        <div class="saomiao_list">
            <ul>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">可贷额度
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">年龄要求
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">可贷期数
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">利息区间
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">所属机构
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">公司地址
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">放贷前是否查征信
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">逾期记录是否上征信
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">征信上体现名称
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">逾期后平台处理方法
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">联系电话
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">是否持有金融牌照
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
                <li class="clearfix">
                    <p class="list_left">
                        <img src="/public/index/img/xuanxiang.png" alt="">其他借款用户真实评价
                    </p>
                    <p class="list_right">
                        <img src="/public/index/img/suo.png" alt="">待解锁
                    </p>
                </li>
            </ul>
        </div>
        <div class="pay_bot clearfix">
            <div class="bot_left" style="width: 50%;"><a href="<?php echo url('/index/wxpay/pay',['sign'=>$sign]); ?>" style="color:#FFF;">限时优惠<?php echo $price['price']; ?>元查看结果</a></div>
             <div class="bot_right">分享免费看</div>
        </div>
        <div class="cover">
            <div class="cover_box">
                <p class="cover_ti">您将错过以下检测</p>
                <div class="jiance clearfix">
                    <div class="jiance_item">
                        <img src="/public/index/img/img_heimingdan.png" alt="">
                        <p>黑名单记录</p>
                    </div>
                    <div class="jiance_item">
                        <img src="/public/index/img/img_shouxin.png" alt="">
                        <p>授信预估</p>
                    </div>
                    <div class="jiance_item">
                        <img src="/public/index/img/img_fengxian.png" alt="">
                        <p>风险排查</p>
                    </div>
                </div>
                <p class="cover_tips">支付成功了解更多个人信息，预防个人风险，借钱不再困难。</p>
                <div class="cover_bot">
                    <button class="give_up">放弃查看</button>
                    <button class="continue">继续查询</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="http://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
<script>

   $('.bot_right').on('click', function () {

		//通过config接口注入权限验证配置
        wx.config({
        	
            debug: false,

            appId: '<?php if(isset($signPackage['appId']) && !empty($signPackage['appId'])): ?><?php echo $signPackage['appId']; endif; ?>',

            timestamp: '<?php if(isset($signPackage['timestamp']) && !empty($signPackage['timestamp'])): ?><?php echo $signPackage['timestamp']; endif; ?>',

            nonceStr: '<?php if(isset($signPackage['nonceStr']) && !empty($signPackage['nonceStr'])): ?><?php echo $signPackage['nonceStr']; endif; ?>',

            signature: '<?php if(isset($signPackage['signature']) && !empty($signPackage['signature'])): ?><?php echo $signPackage['signature']; endif; ?>',

            jsApiList: ['updateAppMessageShareData', 'updateTimelineShareData']

        });
        
      

        wx.ready(function () {

            var

                s_title = '懂贷咖',  // 分享标题

                s_link = 'http://www.xinqianjincx.com/index/index',  // 分享链接

                s_desc = '懂贷咖',  //分享描述

                s_imgUrl = 'http://www.xinqianjincx.com/public/index/img/xuanxiang.png'; // 分享图标
                
            //朋友圈
            wx.updateAppMessageShareData({

                title: s_title, // 分享标题

                link: s_link, // 分享链接

                imgUrl: s_imgUrl, // 分享图标

                success: function (json) {
                	
                	//console.log(json);
                },

                cancel: function (error) {
                	
                	//console.log(error);
                },
                

            });

            //发送给好友

            wx.updateTimelineShareData({

                title: s_title, // 分享标题

                desc: s_desc, // 分享描述

                link: s_link, // 分享链接

                imgUrl: s_imgUrl, // 分享图标

                type: '', // 分享类型,music、video或link，不填默认为link

                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空

                success: function (json) {
                //	console.log(json);
                },

                cancel: function (error) {
                //	console.log(error);
                }

            });
            
        	wx.error(function(res){
        		console.log(res);
				// config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
			});
			

        });
    })
    	
   

   
</script>

</body>
</html>
