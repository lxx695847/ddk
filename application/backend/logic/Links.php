<?php
namespace app\backend\logic;
use think\Model;
use app\common\base\DigitalHelper;


class Links extends Model{
    public function getList($params=[],$other=""){
        $opt['a.id']=['GT',0];
        if(!empty($params['keyword'])){
            $opt['d.name|a.link_name']=['like',"%".$params['keyword']."%"];
        }

        if(!empty($params['start']) && !empty($params['end'])){
            if(strtotime($params['start'])>strtotime($params['end'])){
                errorReturn(1001,"时间格式不对");
            }else{
                $time=[strtotime($params['start']),strtotime($params['end'])];
                $opt['a.createdAt']=['between',$time];
            }
        }else{
            if(!empty($params['start'])){
                $opt['a.createdAt']=['EGT',strtotime($params['start'])];
            }
            if(!empty($params['end'])){
                $opt['a.createdAt']=['LT',strtotime($params['end'])];
            }
        }

        if($other==false){
            $res=db('agent_price')->alias("a")
                ->field("a.*,c.names as aname,d.name as pname,g.price as gprice,g.rebate as grebate,g.erjiprice as gerjiprice")
                ->join("auth_agent b",'a.a_p_id = b.id')
                ->join("user c",'a.uid = c.id')
                ->join('product d','b.pid=d.id')
                ->join('auth_agent g','a.a_p_id = g.id')
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
            $list=db('agent_price')->alias("a")
                ->field("a.*,c.names as aname,d.name as pname,g.price as gprice,g.rebate as grebate,g.erjiprice as gerjiprice")
                ->join("auth_agent b",'a.a_g_id = b.id')
                ->join("user c",'a.uid = c.id')
                ->join('product d','b.pid=d.id')
                ->join('auth_agent g','a.a_p_id = g.id')
                ->where($opt)
                ->order('a.id DESC')
                ->select();
        }
        return $list;
    }

    /**
     * 删除
     */
    public function del($sign){
        if(isset($sign) && !empty($sign)) {
            $params = desSign($sign);
            if ($params == false) {
                errorReturn(1001, "签名错误");
            } else {
                $res=db('agent_price')->where(['id'=>$params['id']])->delete();
                check($res,3);
            }
        }else{
            errorReturn(1002,"参数错误");
        }
    }

    /**
     * 表格
     */
    public function excel($params=[]){
        $data=$this->getList($params,1);
        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Writer.Excel5");
        vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel=new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '代理商')
            ->setCellValue('C1', '链接名')
            ->setCellValue('D1', '版本名')
            ->setCellValue('E1', '推广链接')
            ->setCellValue('F1', '定义查询价格')
            ->setCellValue('G1', '热门问题价格')
            ->setCellValue('H1', '时间');
        if ($data){
            $count = count($data);  //计算有多少条数据
            for ($i = 2; $i <= $count+1; $i++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $data[$i-2]["id"]);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data[$i-2]["aname"]);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data[$i-2]["link_name"]);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data[$i-2]["pname"]);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $data[$i-2]["url"]);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $data[$i-2]["price"]);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $data[$i-2]["price1"]);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, date("Y-m-d",$data[$i-2]["createdAt"]));
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('版本管理');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="版本管理.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }

    /**
     * 编辑信息
     */
    public function edit_info($sign){
        if(isset($sign) && !empty($sign)) {
            $params = desSign($sign);
            if ($params == false) {
                msg("签名错误");
            } else {
                return db('agent_price')
                    ->field('id,price,price1,product_type')
                    ->where(['id'=>$params['id']])
                    ->find();
            }
        }else{
            msg("参数错误");
        }
    }

    /**
     * 编辑
     */
    public function edit($params=[]){
        $opt['a.id']=$params['id'];
        $check=db('agent_price')->alias('a')
            ->field('b.price,b.highestprice,b.price1')
            ->join('auth_agent b','a.a_p_id=b.id')
            ->where($opt)
            ->find();
        if($check!=false){
            if($params['price']<$check['price']){
                errorReturn(1001,"价格不能低于成本价");
            }
            if($params['price']>$check['highestprice']){
                errorReturn(1002,"价格不能高于最高定价");
            }
            $data=[
                'price'=>$params['price'],
                'createdAt'=>time(),
                'ticheng'=>DigitalHelper::sub($params['price'],$check['price'],2),  //减法运算
            ];
            if ($params['type']==2){
                if($params['price1']<$check['price1']){
                    errorReturn(1001,"热门问题价格不能低于成本价");
                }
                if($params['price1']>$check['highestprice']){
                    errorReturn(1001,"热门问题价格不能高于最高定价");
                }

                $data['price1']=$params['price1'];
                $data['ticheng1']=DigitalHelper::sub($params['price1'],$check['price1'],2);  //减法运算
            }
            $res=db('agent_price')->where(["id"=>$params['id']])->update($data);
            check($res,2);
        }else{
            errorReturn(1003,"参数错误");
        }
    }
}