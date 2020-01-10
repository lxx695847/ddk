<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Feedback as FeedbackModel;

class Opinion extends AdminBase{

    protected $feedback_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->feedback_model = new FeedbackModel();
    }


    public function index($keyword = '', $page = 1){
        $map = [];
        if ($keyword) {
            $map['a.name|a.mobile'] = ['like', "%{$keyword}%"];
        }
        $data = $this->feedback_model->alias("a")
            ->field("a.*")
            ->where($map)
            ->order('create_time DESC')->paginate(15, false, ['query'=>request()->param()]);

        foreach($data as &$item){
            $user = db('user')->field('id,names')->where('mobile',$item['mobile'])->find();
            $item['names'] = isset($user['names']) && !empty($user['names']) ? $user['names'] : '';
        }
        $this->assign('data',$data);
        $this->assign('keyword',$keyword);
        return $this->fetch();
    }








}