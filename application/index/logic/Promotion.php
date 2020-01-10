<?php
namespace app\index\logic;
use think\Model;
use app\common\base\Mapper;
use app\common\base\DigitalHelper;
use helper\Rsas;
use helper\Imgdeal;


class Promotion extends Model{
    public function getList(){
        $res['price'] = db('agent_price')->where(['uid'=>Session('user_id'),'product_type' => Mapper::PRODUCT_TYPE_TWO])->select();
        $res['prices'] = $this->var_data();
        return $res;
    }

    /**
     *  获取链接默认数据
     */
    public function var_data(){
            $uid = session('user_id');
            $user = db('user')->field('id,names,agent_class,mobile')->where(['id'=>$uid])->find();

            $authAgent = db('auth_agent')->where(['aid'=>$user['agent_class'],'pid'=>Mapper::PRODUCT_TYPE_TWO])->find();
            //查询版本
            $product = db('product')->where(['id'=>$authAgent['pid']])->find();

            $user['price'] = $authAgent['price'];
            $user['price1'] = $authAgent['price1'];
            $user['pid'] = $authAgent['pid'];
            $user['rename'] = $product['name'];
            $user['prices'] = $product['prices'];
            $user['prices1'] = $product['prices1'];
            return $user;
    }


    /**
     * 添加
     */
    public function add($params){
        if(isset($params['type']) && !empty($params['type'])){
            if($params['type']!=Mapper::PRODUCT_TYPE_TWO){
                errorReturn(401);
            }else{
                $uid=session("user_id");
                $agent_class=db('user')->where(['id'=>$uid])->value("agent_class");
                if($agent_class == false ){
                    errorReturn(1003,"请联系客服添加用户权限");
                }else{
                    //判断用户是否添加代理
                    $authAgent =db('auth_agent')->where(['aid'=>$agent_class,'pid'=>$params['type']])->find();
                    if(!$authAgent){
                        errorReturn(1001,'请联系客服添加代理');
                    }

                    if($params['price'] < $authAgent['price']){
                        errorReturn(1001,'查询金额不能低于成本价格');
                    }

                    if($params['price1'] < $authAgent['price1']){
                        errorReturn(1001,'热门问题金额不能低于成本价格');
                    }

                    if($params['price'] > $authAgent['highestprice']){
                        errorReturn(1001,'查询金额不能高于平台设置价格');
                    }

                    if($params['price1'] > $authAgent['highestprice']){
                        errorReturn(1001,'热门问题金额不能高于平台设置价格');
                    }
                    $data = [
                        'a_p_id' => $authAgent['id'],
                        'product_type' => $params['type'],
                        'rename' => $params['rename'],
                        'price' => $params['price'],
                        'price1'=>$params['price1'],
                        'ticheng' => DigitalHelper::sub($params['price'],$authAgent['price'],2),  //减法运算
                        'ticheng1' => DigitalHelper::sub($params['price1'],$authAgent['price1'],2),  //减法运算
                        'uid' => $uid,
                        'define' => 1,
                        'isdel' => 1,
                        'createdAt' => time(),
                    ];
                    if($params['link_name']==false){
                        $data['link_name']="律师查询";
                    }else{
                        $data['link_name'] = trim($params['link_name']);
                    }
                    $agent_price=db('agent_price');
                    $id = $agent_price->insertGetId($data);
                    if($id){
                        $host = 'http://'.$_SERVER['SERVER_NAME'].'/';
                        $page="index/lawyer/index";
                        $sign = Rsas::getInstance()->encode(http_build_query(['pid'=>$id,'uid'=>$uid]));
                        $url = $this->shortenSinaUrl($host.$page.'?sign='.$sign);
                        $agent_price->where('id',intval($id))->update(['url'=>$url]);
                        successReturn(201);
                    }else{
                        errorReturn(405);
                    }
                }
            }
        }else{
            errorReturn(400);
        }
    }


    /**
     * 编辑
     */
    public function edit($params){
        $uid=session("user_id");
        $agent_class=db('user')->where(['id'=>$uid])->value("agent_class");
        if($agent_class == false ){
            errorReturn(1003,"请联系客服添加用户权限");
        }else {
            //判断用户是否添加代理
            $authAgent = db('auth_agent')->where(['aid' => $agent_class, 'pid' => Mapper::PRODUCT_TYPE_TWO])->find();
            if (!$authAgent) {
                errorReturn(1001, '请联系客服添加代理');
            }

            if ($params['price'] < $authAgent['price']) {
                errorReturn(1001, '查询金额不能低于成本价格');
            }

            if ($params['price1'] < $authAgent['price1']) {
                errorReturn(1001, '热门问题金额不能低于成本价格');
            }

            if ($params['price'] > $authAgent['highestprice']) {
                errorReturn(1001, '查询金额不能高于平台设置价格');
            }

            if ($params['price1'] > $authAgent['highestprice']) {
                errorReturn(1001, '热门问题金额不能高于平台设置价格');
            }
            $data = [
                'price' =>$params['price'],
                'price1'=>$params['price1'],
                'ticheng' => DigitalHelper::sub($params['price'],$authAgent['price'],2),  //减法运算
                'ticheng1' => DigitalHelper::sub($params['price1'],$authAgent['price1'],2),  //减法运算
                'updatedAt' => time(),
            ];
            if ($params['link_name'] == false) {
                $data['link_name'] = "律师查询";
            }else{
                $data['link_name'] = trim($params['link_name']);
            }

            $res=db('agent_price')->where('id',intval($params['id']))->update($data);
            check($res,2);
        }
    }


    /**
     * 删除
     */
    public function del($id){
        $res=db('agent_price')->where(['id'=>$id])->delete();
        check($res,3);
    }


    /**
     * 二维码
     */
    public function code_img($pid){
        $b_img =db('banner')->where('names','in',['贷款平台','空白二维码','logo1'])->select();
        $agent_price = db('agent_price')->where('id','=',intval($pid))->find();
        $platform_img = '';
        $code_img = '';
        $logo = '';
        if(isset($b_img) && !empty($b_img)){
            foreach($b_img as $item){
                if($item['names'] == '贷款平台'){
                    $platform_img = $item['thumb'];
                }
                if($item['names'] == '空白二维码'){
                    $code_img = $item['thumb'];
                }

                if($item['names'] == 'logo1'){
                    $logo = $item['thumb'];
                }
            }
        }
        $img = Imgdeal::getInstance()->img_conversion($platform_img,$agent_price['url'],$code_img,7,$logo,260,1000);
        echo '<body style="margin:0px;padding:0;"><div style="height:100px;line-height:100px;text-align:center;font-size:40px;background: #ac5cff;"><a href="/index/promotion/index" style=" text-decoration: none;color:#fff;margin:0px;padding:0;">回到主页面</a></div>
                    <img src="/img/' . $img . '" style="width:100%;margin:0px;padding:0;"/>
              </body>';
    }


    /**
     * [shortenSinaUrl 短网址接口]
     * @param  [integer] $long_url   需要转换的网址
     * @return [string]          [返回转结果]
     * @author king
     */
    protected function shortenSinaUrl($long_url){
        //apikey需要自己申请  方法见网址：   http://c7.gg/page/apidoc.html
        $apiUrl = 'http://api.c7.gg/api.php?format=json&url=' . $long_url . "&apikey=oJmWtN079SVfXf9iFk@ddd";
        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, $apiUrl);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array(
            'Content-type:application/json'
        ));
        $response = curl_exec($curlObj);
        curl_close($curlObj);
        $json = json_decode($response);
        if (empty($json->error)) {
            $url = $json->url;
        } else {
            $url = "none";
        }
        return $url;
    }
}

