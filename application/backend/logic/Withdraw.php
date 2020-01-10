<?php
namespace app\backend\logic;
use think\Model;
use think\Db;

class Withdraw extends Model{
    public function getList($params=[],$other=""){
        $opt['a.id']=['GT',0];
        if(!empty($params['keyword'])){
            $opt['b.names|a.name']=['like',"%".$params['keyword']."%"];
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
            $res=db('withdraw')->alias("a")
                ->field("a.*,b.names,b.money as balance,c.names as operator_name")
                ->join("__USER__ b",'a.user_id = b.id','LEFT')
                ->join("__ADMIN_USER__ c",'a.operator = c.id','LEFT')
                ->where($opt)
                ->order('a.id DESC')
                ->paginate(15, false, ['query'=>request()->param()]);
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
            $list=db('withdraw')->alias("a")
                ->field("a.*,b.names,b.money as balance,c.names as operator_name")
                ->join("__USER__ b",'a.user_id = b.id','LEFT')
                ->join("__ADMIN_USER__ c",'a.operator = c.id','LEFT')
                ->where($opt)
                ->order('a.id DESC')
                ->select();
        }
        return $list;
    }

    /**
     * 提现处理
     * @param $sign
     */
    public function get_pay($sign){
        if(isset($sign) && !empty($sign)){
            $params=desSign($sign);
            if($params==false){
                errorReturn(1001,"签名错误");
            }else{
                $withdraw=db('withdraw');
                $user=db('user');
                $tx=$withdraw->find($params['id']);
                $yh=$user->find($tx['user_id']);
                if($yh){
                    if ($yh["money"] >= $tx["money"]){
                        Db::startTrans();
                        $leave=$yh["money"]-$tx["money"];
                        $res1=$user->where(['id'=>$tx['user_id']])->setField('money',$leave);
                        $res2=$withdraw->where(['id'=>$params['id']])->setField('status',1);
                        $data=[
                            'order_id'=>$params['id']+100000,
                            'profit_id'=>$tx["user_id"],
                            'ratio'=>0,
                            'create_time'=>time(),
                            'money'=>$tx["money"],
                            'type'=>'提现',
                            'balance'=>$leave
                        ];
                        $res3=db("profit")->insert($data);
                        Db::commit();
                        if($res1!==false && $res2!==false && $res3!==false){
                            successReturn(200,"支付成功");
                        }else{
                            Db::rollback();
                            errorReturn(1006,"退款失败");
                        }
                    }else{
                        errorReturn(1004,"账户余额不足,请充值");
                    }
                }else{
                    errorReturn(1003,"用户信息错误");
                }
            }
        }else{
            errorReturn(1002,"参数错误");
        }
    }

    /**
     * 删除
     * @param $sign
     */
    public function get_del($sign){
        if(isset($sign) && !empty($sign)) {
            $params = desSign($sign);
            if ($params == false) {
                errorReturn(1001, "签名错误");
            } else {
                $res=db('withdraw')->where(['id'=>$params['id']])->delete();
                check($res,3);
            }
        }else{
            errorReturn(1002,"参数错误");
        }
    }

    /**
     * 编辑
     */
    public function get_edit($params){
        $params['update_time']=time();
        $res=db('withdraw')->where(['id'=>$params['id']])->update($params);
        check($res,2);
    }

    /**
     * 编辑信息
     * @param $sign
     */
    public function edit_info($sign){
        if(isset($sign) && !empty($sign)) {
            $params = desSign($sign);
            if ($params == false) {
                msg("签名错误");
            } else {
                return db('withdraw')->where(['id'=>$params['id']])->find();
            }
        }else{
            msg("参数错误");
        }
    }

    /**
     * 添加
     */
    public function get_add($params){
        $withdraw=db('withdraw');
        $opt=[
            'user_id'=>$params['user_id'],
            'status'=>0
        ];
        $info=$withdraw->where($opt)->find();
        if($info){
            errorReturn(1005,'你有一笔提现待处理,请稍后处理');
        }else{
            $params['create_time']=time();
            $res=$withdraw->insert($params);
            check($res,1);
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
            ->setCellValue('C1', '提现金额')
            ->setCellValue('D1', '账户余额')
            ->setCellValue('E1', '类型')
            ->setCellValue('F1', '提现名')
            ->setCellValue('G1', '联系方式')
            ->setCellValue('H1', '账号')
            ->setCellValue('I1', '时间')
            ->setCellValue('J1', '状态');
        if ($data){
            $count = count($data);  //计算有多少条数据
            for ($i = 2; $i <= $count+1; $i++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $data[$i-2]["id"]);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data[$i-2]["names"]);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data[$i-2]["money"]);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data[$i-2]["balance"]);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $data[$i-2]["type"]=1?"支付宝":"银行卡");
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $data[$i-2]["name"]);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $data[$i-2]["mobile"]);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $data[$i-2]["bankcard"]);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, date("Y-m-d",$data[$i-2]["create_time"]));
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $data[$i-2]["status"]=1?"已支付":"待支付");
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('提现管理');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="提现管理.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }
}