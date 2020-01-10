<?php

namespace app\index\logic;


use app\common\base\LogicQuery;
use think\Db;

class SubordinateLogicQuery extends LogicQuery{


    /**
     * 分页
     * @param null $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \Exception
     */
    public function querys($params = null){
        try{
            if(empty($params)){
                $params = $this->request->param();
            }
            $userid = session('user_id');
            $query = Db::name('user')->field($params['select']);
            $this->query($query,['userid'=>$userid,'page'=>isset($params['page'])?$params['page']:1,'limit'=>isset($params['limit'])?$params['limit']:10]);
            $data = $query->select();
            $this->Conversion($data);
        }catch(\Exception $e){
            $this->log($e);
            throw $e;
        }
        return $data;
    }


    /**
     * 个人团队数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function counts(){
        $data = [];
        $startTime = mktime(0,0,0,date('m'),date('d'),date('y'));
        $endTime = mktime(23,59,59,date('m'),date('d'),date('y'));
        $data['pmoney'] = Db::name('profit')->where('profit_id',session('user_id'))->where('type','二级奖励')->sum('money');
        $data['dmoney'] = Db::name('profit')->where('profit_id',session('user_id'))->where('type','二级奖励')->where('create_time','between',[$startTime,$endTime])->sum('money');
        $data['user'] = Db::name('user')
            ->alias('u')
            ->field('u.id as uid , count(x.id) xid ,s.id as sid ,s.names as snames,s.mobile')
            ->join('__USER__ x','u.id = x.pid and x.agent_class > 1','left')
            ->join('__USER__ s','u.pid = s.id and s.agent_class > 1','left')
            ->where('u.id',session('user_id'))
            ->find();
        return $data;
    }


    /**
     * 数据转换
     * @param $data
     */
    public function Conversion(&$data){
        foreach($data as &$item){
            $item['mobile'] = substr_replace($item['mobile'], '****', 3, 4);
            $item['createdAt'] = date('Y-m-d H:i',$item['create_time']);
            $item['p_sum'] = Db::name('profit')->where('type','二级奖励')->where('profit_id',session('user_id'))->where('uid',$item['id'])->sum('money');
         }
    }


    /**
     * 查询条件
     * @param $query
     * @param $params
     */
    public function query($query,$params){
        if(isset($params['userid']) && !empty($params['userid'])){
            $query->where('pid','=',$params['userid']);
        }
        if(isset($params['page']) && !empty($params['page'])){
            $limit = isset($params['limit'])?$params['limit']:10;
            $query->page($params['page'],$limit);
        }
        $query->where('agent_class','>','1');
        $query->order('create_time desc');
    }


}