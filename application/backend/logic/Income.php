<?php
namespace app\backend\logic;
use think\Model;
use think\Db;

class Income extends Model{
    /**
     * 获取列表数据
     * @return array
     */
    public function getList($params=[],$other=""){
        $opt['a.id']=['GT',0];
        if(!empty($params['keyword'])){
            $opt['b.names|c.names|a.type']=['like',"%".$params['keyword']."%"];
        }

        if(!empty($params['start']) && !empty($params['end'])){
            if(strtotime($params['start'])>strtotime($params['end'])){
                errorReturn(1001,"时间格式不对");
            }else{
                $time=[strtotime($params['start']),strtotime($params['end'])];
                $opt['a.create_time']=['between',$time];
            }
        }else{
            if(!empty($params['start'])){
                $opt['a.create_time']=['EGT',strtotime($params['start'])];
            }
            if(!empty($params['end'])){
                $opt['a.create_time']=['LT',strtotime($params['end'])];
            }
        }

        if($other==false){
            $res=db('profit')->alias('a')
                ->field('a.*,b.names,c.names as cnames')
                ->join('user b','a.uid=b.id')
                ->join('user c','a.profit_id=c.id')
                ->order('a.create_time desc')
                ->where($opt)
                ->paginate(10,false, ['query'=>request()->param()]);
            $items = $res->items();
            foreach($items as $k=>$v){
                $items[$k]['sign']=makeSign(['id'=>$v['id']]);
            }
            $list=[
                'res'=>$items,
                'page'=>$res->render()
            ];
        }else{
            //表格数据
            $list=db('profit')->alias('a')
                ->field('a.*,b.names,c.names as cnames')
                ->join('user b','a.uid=b.id')
                ->join('user c','a.profit_id=c.id')
                ->order('a.create_time desc')
                ->where($opt)
                ->select();
        }
        return $list;
    }

    /**
     * 退款
     * @param $sign
     */
    public function get_back($sign){
        if(isset($sign) && !empty($sign)){
            $params=desSign($sign);
            if($params==false){
                errorReturn(1001,"签名错误");
            }else{
                Db::startTrans();
                $profits=db('profit');
                $user=db('user');
                $opt['id']=$params['id'];
                $profit =$profits->where($opt)->find();
                $data=[
                    "create_time"=>time(),
                    "pid"=>1,
                    "type"=>"退款",
                    "balance"=>$profit["balance"]-$profit["money"]
                ];
                $res1=$profits->where($opt)->update($data);

                //代理商
                $opt1['id']=$profit["profit_id"];
                $info = $user->where($opt1)->field('money,total_achievement')->find();
                $sin=[
                    "money"=>$info["money"]-$profit["money"],
                    "total_achievement"=>$info["total_achievement"]-$profit["money"]
                ];
                $res2=$user->where($opt1)->update($sin);

                Db::commit();
                if($res1!==false && $res2!==false){
                    successReturn(205,"退款成功");
                }else{
                    Db::rollback();
                    errorReturn(1003,"退款失败");
                }
            }
        }else{
            errorReturn(1002,"参数错误");
        }
    }

    /**
     * 表格导出
     */
    public function get_excel($params=[]){
        $data=$this->getList($params,1);
        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Writer.Excel5");
        vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel=new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '客户名')
            ->setCellValue('C1', '查询价格')
            ->setCellValue('D1', '成本价格')
            ->setCellValue('E1', '代理提成')
            ->setCellValue('F1', '提成者')
            ->setCellValue('G1', '提成类型')
            ->setCellValue('H1', '提成余额')
            ->setCellValue('I1', '查询时间');
        if ($data){
            $count = count($data);  //计算有多少条数据
            for ($i = 2; $i <= $count+1; $i++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $data[$i-2]["id"]);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data[$i-2]["names"]);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data[$i-2]["ratio"]);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data[$i-2]["cost_price"]);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $data[$i-2]["money"]);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $data[$i-2]["cnames"]);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $data[$i-2]["type"]);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $data[$i-2]["balance"]);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, date("Y-m-d",$data[$i-2]["create_time"]));
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('奖励明细');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="奖励明细.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }
}