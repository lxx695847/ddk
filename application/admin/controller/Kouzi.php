<?php
namespace app\admin\controller;

use app\common\model\Kouzi as KouziModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 口子管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Kouzi extends AdminBase
{
    protected $kouzi_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->kouzi_model = new KouziModel();
		
    }

    /**
     * 口子管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
	
	
        $map = [];
        if ($keyword) {
            $map['a.kname|a.ktitle|a.kmarks'] = ['like', "%{$keyword}%"];
        }
         $kouzi_list = $this->kouzi_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(8, false, ['query'=>request()->param()]);
		
		$count=$this->kouzi_model->alias("a")->where($map)->count('a.id');
		
		//dump($count);die;
        return $this->fetch('index', ['kouzi_list' => $kouzi_list, 'keyword' => $keyword, 'count' => $count]);
		
		
    }
	

	
	
	
	
	
    /**
     * 添加口子
     * @return mixed
     */
    public function add()
    {
		//地址
		$type_list = Db::name('kouzitype')->select();
		$this->assign("type_list",$type_list);
		
		return $this->fetch();
    }

    /**
     * 保存口子
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Kouzi');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               
				if ($data["ktype"]!=0){
					$info=Db::name("kouzitype")->where(array("id"=>$data["ktype"]))->find();
					$data["typename"]=$info["tname"];
				}
				$data["dates"]=time();
				
				
				if(!strstr($data["thumb"],"http"))
				{
					$data["thumb"]="/public".$data["thumb"];
				}
				
				if ($this->kouzi_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑口子
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $kouzi = $this->kouzi_model->find($id);
		
		//口子type
		$type_list=Db::name("kouzitype")->select();
		$this->assign("type_list",$type_list);
		

        return $this->fetch('edit', ['kouzi' => $kouzi]);
    }

    /**
     * 更新口子
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Kouzi');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
			
			 
			    $kouzi           = $this->kouzi_model->find($id);
                $kouzi->id       = $id;
                $kouzi->kname = $data['kname'];
               
                $kouzi->ktitle    = $data['ktitle'];
                $kouzi->kmarks    = $data['kmarks'];
                $kouzi->kheight    = $data['kheight'];
                $kouzi->klast    = $data['klast'];
                $kouzi->descc    = $data['descc'];
                $kouzi->hrefs    = $data['hrefs'];
                $kouzi->state    = $data['state'];
                $kouzi->remarks    = $data['remarks'];
                $kouzi->ktype    = $data['ktype'];
				
				if ($data["ktype"]!=0){
					$info=Db::name("kouzitype")->where(array("id"=>$data["ktype"]))->find();
					$kouzi->typename=$info["tname"];
					
				}else{
					$kouzi->typename = array('exp','null');
				}
				if(!strstr($data["thumb"],"http"))
				{
					$data["thumb"]="/public".$data["thumb"];
				}
				 $kouzi->thumb   = $data['thumb'];
                if ($kouzi->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            }
        }
		
    }

    /**
     * 删除口子
     * @param $id
     */
    public function delete($id)
    {
        if ($this->kouzi_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}