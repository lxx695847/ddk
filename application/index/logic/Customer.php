<?php
namespace app\index\logic;
use think\Model;

class Customer extends Model{
    public function getInfo(){
        return db('user')
            ->where(['id'=>session("uid")])
            ->find();
    }

    public function getEdit($params){
        $res=db('user')->where(['id'=>session("uid")])->setField(key($params),$params[key($params)]);
        check($res,2);
    }

    /**
     * 奖励
     */
    public function money(){
        $res=db('profit')
                 ->where(['profit_id'=>session('uid')])
                 ->field('money,type,create_time')
                 ->select();
        $data['total']=0;
        if($res){
            foreach($res as $k=>$v){
                $data['total']+=$v['money'];
            }
        }
        $data['list']=$res;
        return $data;
    }

    /**
     * 提现
     */
    public function withdraw($params=[]){
        if(isset($params['sign']) && !empty($params['sign'])) {
            $sign = desSign($params['sign']);
            if ($sign == false) {
                errorReturn(1006, "签名错误");
            } else {
                $data=[];
                $info=db('user')->where(['id'=>$sign['id']])->find();
                $opt=[
                    'user_id'=>$sign['id'],
                    'status'=>0
                ];
                $order=db('withdraw')->where($opt)->find();
                if($order){
                    errorReturn(1009,"您有一笔提现订单待处理");
                }

                if((int)$params['money']===0){
                    errorReturn(1008,"提现金额错误");
                }

                if($params['money']>$info['money']){
                    errorReturn(1007,"余额不足");
                }else{
                    $data=[
                        'user_id'=>$sign["id"],
                        'create_time'=>time(),
                        'money'=>$params["money"],
                        'type'=>$params['type']
                    ];
                }

                function get_check($name,$code,$info){
                    if($name==false){
                        errorReturn($code,$info);
                    }
                }

                switch ($params['type']){
                    case 1:
                        get_check($info['wname'],1001,"请先完善支付信息");
                        get_check($info['bankname'],1003,"请先绑定支付宝账号");
                        $data['bankcard']=$info['bankname'];
                        $data['name']=$info['wname'];
                        break;
                    case 2:
                        get_check($info['bname'],1001,"请先完善银行卡信息");
                        get_check($info['banknumber'],1003,"请先绑定银行卡账号");
                        $data['bankcard']=$info['banknumber'];
                        $data['name']=$info['bname'];
                        break;
                }
                get_check($info['phone'],1002,"请完善联系方式");
                $data['mobile']=$info['phone'];
                $res=db("withdraw")->insert($data);
                check($res,1);
            }
        }else{
            errorReturn(1005,"参数错误");
        }
    }

    /**
     * 提现记录
     */
    public function get_record(){
        return db('withdraw')->where(['user_id'=>session('uid')])->select();
    }

    /**
     * 绑定提交
     */
    public function blind($params){
        $res=db('user')->where(['id'=>session("uid")])->update($params);
        check($res,2);
    }

    /**
     * 评论
     */
    public function get_news($type){
        switch ($type){
            case 1:
                $opt=[
                    'uid'=>session("uid"),
                    'isstop'=>0
                ];
                $res=db('comment')
                    ->order('createdAt desc')
                    ->where($opt)
                    ->select();
                $data['praise']=0;$data['reply']=0;
                if($res){
                    foreach($res as $v){
                        $data['praise']+=$v['awesome'];
                        $data['reply']+=$v['responses'];
                    }
                }
                $data['list']=$res;
                return $data;
                break;
            case 2:
                $opt=[
                    'a.uid'=>session("uid"),
                    'a.isstop'=>0
                ];
                return db('comment')->alias('a')
                    ->field('a.content,b.createdAt,c.names')
                    ->join('awesome b','a.id=b.commentId')
                    ->join('user c','b.uid=c.id')
                    ->order('a.createdAt desc')
                    ->where($opt)
                    ->select();
                break;
            case 3:
                $opt=[
                    'a.replyId'=>session("uid"),
                    'a.isstop'=>1
                ];
                return db('reply')->alias('a')
                    ->field('a.content,a.createdAt,a.uid,a.uname,b.content as cont')
                    ->join('comment b','a.commentId=b.id')
                    ->order('a.createdAt desc')
                    ->where($opt)
                    ->select();
                break;
        }
    }
}