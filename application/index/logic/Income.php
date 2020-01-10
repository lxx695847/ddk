<?php
namespace app\index\logic;
use think\Model;

class Income extends Model{
    public function getList(){
        $uid=session('user_id');
        $opt=['a.profit_id'=>$uid];
//        dump(db('profit')->where(['profit_id'=>$uid])->select());
//        exit;
        //总数据
        $res1=db('profit')->alias('a')
            ->field('c.cname,b.mobile,a.money,a.create_time,a.type')
            ->join('user b','a.uid=b.id')
            ->join('order c','a.order_id=c.number_order')
            ->where($opt)
            ->select();

        $data['todayIncome']=0;$data['totalIncome']=0;
        $data['todayCustom']=0;$data['totalCustom']=count($res1);
        $todayStart=strtotime(date("Y-m-d",time()));
        $end=time();
        if($res1){
            foreach($res1 as $k=>$v){
                if($v['create_time']>=$todayStart && $v['create_time']<$end){
                    $data['todayIncome']+=$v['money'];
                    $data['todayCustom']++;
                }
                $data['totalIncome']+=$v['money'];
            }
        }
        $data['time']=date("Y.m.d",time());
        return $data;
    }


    public function getParse($param){
        $uid=session('user_id');
        if(strtotime($param['start'])>strtotime($param['end'])){
            errorReturn(1001,"开始时间不能大于结束时间");
        }else{
            $time=[strtotime($param['start']),strtotime($param['end'])+86400];
            $opt['a.create_time']=['between',$time];
        }
        if($param['sort']==1){
            $opt['a.profit_id']=$uid;
            $opt['a.type']="直推奖励";
        }else{
            $opt['a.profit_id']=$uid;
            $opt['a.type']="二级奖励";
        }
        $opt['a.aid']=$param['type'];
        $offset=8;
        $page=isset($param['page']) ? $param['page'] : 1;

        $res=db('profit')->alias('a')
            ->field('c.cname,b.mobile,a.money,a.create_time,a.type')
            ->join('user b','a.uid=b.id')
            ->join('order c','c.number_order=a.order_id')
            ->where($opt)
            ->page($page,$offset)
            ->select();
        return $res;
    }
}