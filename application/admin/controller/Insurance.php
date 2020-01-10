<?php

namespace app\admin\controller;

use app\common\model\Insurance as InsuranceModel;

use app\common\controller\AdminBase;
use PHPExcel_IOFactory;
use PHPExcel;

class Insurance extends AdminBase{
	

    protected function _initialize()
    {
        parent::_initialize();
        $this->insurance_model  = new InsuranceModel();
    }


    /**
     * 评论列表
     * @param string $keyword
     * @param int $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1,$status='',$startTime='',$endTime='',$type=''){
        $map = [];
        $maps = [];
        if ($keyword) {
            $map['a.name|a.mobile|a.IdCard'] = ['like', "%{$keyword}%"];
        }
        
        if(!empty($status) && $status == 1){
        	$map =  ['a.status' => 1];
        }
        
        if(!empty($status) && $status == 2){
        	$map = ['a.status' => 0];
        }
        
        if(!empty($type) && $type == 1){
        	$map =  ['a.type' => 1];
        	$maps =  ['type' => 1];
        }
        
        if(!empty($type) && $type == 2){
        	$map = ['a.type' => 2 ];
        	$maps = ['type' => 2 ];
        }
        
        $times = [];
        
        
        if(!empty($startTime)){
			$d1=strtotime($startTime);
            $times['a.createAt'] = [['>=',$d1],['<=',time()]];
        }
        
        if(!empty($endTime)){
			$d2=strtotime($endTime);
			$times['a.createAt'] = [['>=',!empty($d1)?$d1:0],['<=',$d2]];
        }
        if(empty($startTime) && empty($endTime)){
        	$times['a.createAt'] = [['>=',strtotime('-15 day',time())],['<=',time()]];
        }
        
        $data = $this->insurance_model->alias("a")
            ->field("a.*")
            ->where($map)
            ->where($times)
            ->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
           
            
            
        $ccount =  $this->insurance_model->where($maps)->where('status','=',1)->count();   
        $scount =  $this->insurance_model->where($maps)->where('status','=',0)->count();
        
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $dccount =  $this->insurance_model->where($maps)->where('status','=',1)->where('createAt','between',[$beginToday,time()])->count();   
        $dscount =  $this->insurance_model->where($maps)->where('status','=',0)->where('createAt','between',[$beginToday,time()])->count();
       
        $this->assign('data',$data);
        
        $this->assign('ccount',$ccount);
        $this->assign('scount',$scount);
        $this->assign('dccount',$dccount);
        $this->assign('dscount',$dscount);
        
        $this->assign('startTime',$startTime);
        $this->assign('endTime',$endTime);
        $this->assign('keyword',$keyword);
        
        
        return $this->fetch();
    }
    
    
    
    
    /**
     *  数据导出
     */
    
    public function excel($keyword = '', $page = 1,$status='',$startTime='',$endTime='',$type=''){
		set_time_limit(0);
	
		$map = [];
        $maps = [];
        if ($keyword) {
            $map['a.name|a.mobile|a.IdCard'] = ['like', "%{$keyword}%"];
        }
        
        if(!empty($status) && $status == 1){
        	$map =  ['a.status' => 1];
        }
        
        if(!empty($status) && $status == 2){
        	$map = ['a.status' => 0];
        }
        
        if(!empty($type) && $type == 1){
        	$map =  ['a.type' => 1];
        	$maps =  ['type' => 1];
        }
        
        if(!empty($type) && $type == 2){
        	$map = ['a.type' => 2 ];
        	$maps = ['type' => 2 ];
        }
        
        $times = [];
        
        
        if(!empty($startTime)){
			$d1=strtotime($startTime);
            $times['a.createAt'] = [['>=',$d1],['<=',time()]];
        }
        
        if(!empty($endTime)){
			$d2=strtotime($endTime);
			$times['a.createAt'] = [['>=',!empty($d1)?$d1:0],['<=',$d2]];
        }
        
       
        $data = $this->insurance_model->alias("a")
            ->field("a.*")
            ->where($map)
            ->where($times)
            ->order('id DESC')->select();

         
        if($data){
        	$data = collection($data)->toArray();
        }
		vendor("PHPExcel.PHPExcel");
		vendor("PHPExcel.PHPExcel.Writer.Excel5");
		vendor("PHPExcel.PHPExcel.Writer.Excel2007");
		vendor("PHPExcel.PHPExcel.IOFactory");
		$objPHPExcel=new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '用户名')
            ->setCellValue('C1', '手机号码')
            ->setCellValue('D1', '身份证')
            ->setCellValue('E1', '状态')
            ->setCellValue('F1', '返回备注')
            ->setCellValue('G1', '接口')
            ->setCellValue('H1', '时间');
		if ($data){
			$i=2;  //定义一个i变量，目的是在循环输出数据是控制行数
			$count = count($data);  //计算有多少条数据
			for ($i = 2; $i <= $count+1; $i++) {
				$status = isset($data[$i-2]["status"]) && $data[$i-2]["status"] == 1 ? '成功' : '失败';
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $data[$i-2]["id"]);
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data[$i-2]["name"]);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data[$i-2]["mobile"]);
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, "'".$data[$i-2]["IdCard"]."'");
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $status);
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $data[$i-2]["message"]);
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, isset($data[$i-2]["type"]) && $data[$i-2]["type"] == 1 ? '平台A' : '平台B');
				$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, date('Y-m-d H:i',$data[$i-2]["createAt"]));
			}
		}	
		$objPHPExcel->getActiveSheet()->setTitle('查询明细');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="查询明细.xls"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
	}
    
    


    /**
     * 删除数据
     * @param $id
     */
    public function delete($id){
    	
    	if ($this->insurance_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
       
    }
}