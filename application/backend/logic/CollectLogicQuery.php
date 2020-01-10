<?php

namespace app\backend\logic;


use app\backend\base\LogicQuery;
use think\Db;

class CollectLogicQuery extends LogicQuery{


    /**
     * 收集记录
     * @param null $params
     * @param string $select
     * @return \think\Paginator
     * @throws \Exception
     */
    public function query($params = null,$select="c.*,u.names as user_name"){
        try{
            $query = Db::name('Collect');
            $query->alias('c');
            $query->field($select);
            $this->params($params,$query);
            $query->join('__USER__ u','c.uid = u.id','left');
            $data = $query->order('createdAt DESC')->paginate(15, false, ['query'=>request()->param()]);
        }catch(\Exception $e){
            $this->log($e);
            throw $e;
        }
        return $data;
    }


    /**
     * 查询参数
     * @param null $params
     * @return array
     */
    public function params($params=null,$query){
        if (isset($params['keyWord']) && is_numeric($params['keyWord']) && !empty($params['keyWord'])) {
            $query->where('c.id','=',$params['keyWord']);
        }
        if(isset($params['keyWord']) && !is_numeric($params['keyWord']) && !empty($params['keyWord'])){
            $query->where('c.name|c.mobile','like',"%{$params['keyWord']}%");
        }
        if(isset($params['start_time']) && !empty($params['start_time'])){
            $startime = strtotime($params['start_time']);
            $query->where('c.createdAt','>=',$startime);
        }

        if(isset($params['end_time']) && !empty($params['end_time'])){
            $endtime = strtotime($params['end_time']);
            $query->where('c.createdAt','<=',$endtime);
        }
        if(isset($params['uid']) && !empty($params['uid'])){
            $query->where('c.uid','=',$params['uid']);
        }
    }



}