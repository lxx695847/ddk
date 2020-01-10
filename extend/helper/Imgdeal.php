<?php

namespace helper;

use think\Request;

class Imgdeal extends  HelperClass{

    const TIME = 30;

    public function img_conversion($img,$url,$code,$img_size = 4,$logo,$left, $height){
        Vendor('phpqrcode.phpqrcode');
        $background_img = str_replace("\\", "/", $img);

        //容错级别
        $errorCorrectionLevel = 'H';
        //生成一个二维码
        ob_clean();
        $object = new \QRcode();
        $object->png($url, ROOT_PATH .$code, $errorCorrectionLevel, $img_size, 2);

        //获取图片的绝对路径
        $qrcode = ROOT_PATH.$code;
        $logo = ROOT_PATH.$logo;

        if ($logo !== FALSE) {
            $qrcode = imagecreatefromstring(file_get_contents($qrcode));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $qrcode_width = imagesx($qrcode);   //二维码图片宽度
            $qrcode_height = imagesy($qrcode);  //二维码图片高度
            $logo_width = imagesx($logo);       //logo图片宽度
            $logo_height = imagesy($logo);      //logo图片高度
            $logo_qr_width = $qrcode_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($qrcode_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($qrcode, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }
        @unlink($qrcode); //删除二维码与logo的合成图片

        $QIMG = ROOT_PATH .$code;

        imagepng($qrcode, $QIMG);

        $dst_path = ROOT_PATH . $background_img;//背景图片路径

        $src_path = $QIMG;//覆盖图
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $src = imagecreatefromstring(file_get_contents($src_path));

        //获取覆盖图图片的宽高
        $dst_width = imagesx($dst);   //二维码图片宽度
        $dst_height = imagesy($dst);  //二维码图片高度
        list($src_w, $src_h) = getimagesize($src_path);

        $from_w = ($dst_width - $src_w) / 2;

        imagecopymerge($dst, $src, $left, $height, 0, 0, $src_w, $src_h, 100);
        @unlink($QIMG); //删除二维码与logo的合成图片
        $suijishu = rand(100000, 999999);
        $bj_logo = ROOT_PATH . DS . 'img/' . $suijishu . '.png';
        //重新组合图片并调整大小
        //将覆盖图复制到目标图片上，最后个参数100是设置透明度（100是不透明），这里实现不透明效果
        $color = imagecolorallocatealpha($dst, 0, 0, 0, 0);

        $fontfile = ROOT_PATH . '/public/fonts/simkai.ttf';

        $feng = '';
        imagettftext($dst, 24, 0, 150, 755, $color, $fontfile, $feng);

        imagepng($dst, $bj_logo);//根据需要生成相应的图片
        $file = pathinfo($bj_logo);
        $logo_name = $file['basename'];

        $data['url'] = $logo_name;
        $bjimg_id = db('bj_url')->insertGetId($data);
        $bj_img = db('bj_url')->where('id', '=', $bjimg_id)->find();
        if ($bj_img) {
            $bj_unimg = db('bj_url')->where('id', 'neq', $bjimg_id)->select();
            foreach ($bj_unimg as $key => $value) {
                $bjimgname = ROOT_PATH . 'img/' . $value['url'];
                if ($bjimgname !== FALSE) {//检查图片文件是否存在
                    if(file_exists($bjimgname)){
                        unlink($bjimgname);
                    }
                    db('bj_url')->where('id', '=', $value['id'])->delete();
                } else {
                    $this->redirect('index/index/index');
                }
            }
        }
        return $logo_name;
    }


    /**
     *
     * 生成log二维码
     * @param $url
     * @param $code
     * @param int $img_size
     * @param $logo
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function img_code($url,$code,$img_size = 4,$logo){
        Vendor('phpqrcode.phpqrcode');
        //容错级别
        $errorCorrectionLevel = 'H';
        //生成一个二维码
        ob_clean();
        $object = new \QRcode();
        $object->png($url, ROOT_PATH .$code, $errorCorrectionLevel, $img_size, 2);

        //获取图片的绝对路径
        $qrcode = ROOT_PATH.$code;
        $logo = ROOT_PATH.$logo;

        if ($logo !== FALSE) {
            $qrcode = imagecreatefromstring(file_get_contents($qrcode));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $qrcode_width = imagesx($qrcode);   //二维码图片宽度
            $qrcode_height = imagesy($qrcode);  //二维码图片高度
            $logo_width = imagesx($logo);       //logo图片宽度
            $logo_height = imagesy($logo);      //logo图片高度
            $logo_qr_width = $qrcode_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($qrcode_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($qrcode, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }
        @unlink($qrcode); //删除二维码与logo的合成图片

        $QIMG = ROOT_PATH .$code;

        imagepng($qrcode, $QIMG);

        $src_path = $QIMG;//覆盖图
        //创建图片的实例
        $src = imagecreatefromstring(file_get_contents($src_path));

        @unlink($QIMG); //删除二维码与logo的合成图片
        $suijishu = rand(100000, 999999);
        $bj_logo = ROOT_PATH . DS . 'img/' . $suijishu . '.png';
        //重新组合图片并调整大小
        //将覆盖图复制到目标图片上，最后个参数100是设置透明度（100是不透明），这里实现不透明效果
        $color = imagecolorallocatealpha($src, 0, 0, 0, 0);

        $fontfile = ROOT_PATH . '/public/fonts/simkai.ttf';

        $feng = '';
        imagettftext($src, 24, 0, 150, 755, $color, $fontfile, $feng);

        imagepng($src, $bj_logo);//根据需要生成相应的图片
        $file = pathinfo($bj_logo);

        $logo_name = $file['basename'];

        $data['url'] = $logo_name;
        $bjimg_id = db('bj_url')->insertGetId($data);
        $bj_img = db('bj_url')->where('id', '=', $bjimg_id)->find();
        if ($bj_img) {
            $bj_unimg = db('bj_url')->where('id', 'neq', $bjimg_id)->select();
            foreach ($bj_unimg as $key => $value) {
                $bjimgname = ROOT_PATH . 'img/' . $value['url'];
                if ($bjimgname !== FALSE) {//检查图片文件是否存在
                    if(file_exists($bjimgname)){
                        unlink($bjimgname);
                    }
                    db('bj_url')->where('id', '=', $value['id'])->delete();
                } else {
                    $this->redirect('index/index/index');
                }
            }
        }
        return $logo_name;
    }



}