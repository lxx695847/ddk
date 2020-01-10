<?php

namespace app\index\logic;


use app\common\base\DigitalHelper;
use app\common\base\LogicQuery;
use app\common\base\Mapper;
use helper\Imgdeal;
use helper\Rsas;
use think\Db;

class CustomerLogicQuery extends LogicQuery{


    /**
     * 公众号图片
     * @param null $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \Exception
     */
    public function img(){
        try{
            $data = Db::name('banner')->where('names','in',['公众号二维码','客户二维码'])->select();
        }catch(\Exception $e){
            $this->log($e);
            throw $e;
        }
        return $data;
    }

    /**
     * 二维码推广图片处理
     * @param $pid
     */
    public function invite(){
        $b_img = Db::name('banner')->where('names','in',['空白二维码','logo1'])->select();
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/index/login/registered?pid='.session('user_id');
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
        $img = Imgdeal::getInstance()->img_code($url,$code_img,7,$logo);
        return ['img'=>'/img/'.$img,'url'=>$url];
    }


    /**
     * 随机获取代理邀请记录
     * @param null $params
     * @return array
     * @throws \Exception
     */
    public function agent($params = null){
        try{
            if(empty($params)){
                $params = $this->request->param();
            }
            $data = Db::name('user')->field('id,mobile')->where('agent_class','>',1)->orderRaw("RAND()")->limit(20)->select();
            $result = $this->filver($data);
        }catch(\Exception $e){
            $this->log($e);
            throw $e;
        }
        return $result;
    }


    /**
     * 转换数据
     * @param $data
     * @return array
     * @throws \think\Exception
     */
    public function filver($data){
        $result = [];
        $i = 0;
        foreach($data as $kye => $item){
            $count = Db::name('user')->where('pid','=',$item['id'])->where('agent_class','>',1)->count('id');
            if(empty($count)){
                continue;
            }
            $i ++;
            $result[$i]['mobile'] = substr_replace($item['mobile'],'****',3,4);
            $result[$i]['count'] = $count;
        }
        return $result;
    }


    /**
     * 查询费用
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function price(){
        $user = Db::name('User')->field('id,names,agent_class,mobile')->where('id',session('user_id'))->find();
        $authAgent = Db::name('authAgent')->where(['aid'=>$user['agent_class'],'pid'=>Mapper::PRODUCT_TYPE])->find();
        $prices = DigitalHelper::div($authAgent['rebate'],100);
        $prices_r = DigitalHelper::div($authAgent['erjiprice'],100);
        $data['price'] = DigitalHelper::mul($authAgent['price'],$prices);
        $data['price_r'] = DigitalHelper::mul($authAgent['price'],$prices_r);
        return $data;
    }
}