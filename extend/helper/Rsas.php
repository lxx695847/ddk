<?php

/**
 *   php 密钥加密
 *
 *  1、非对称加密、解密：256位  rsa
 *
 *  2、对称加密、解密 ： 64位  aes
 *
 *  3、ECB/PKCS5Padding加密、解密
 *
 *  4、generate() 生成密钥
 *
 */
namespace helper;


class Rsas extends HelperClass
{

    private $pubKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC968SvmdrSWZ9c1fg/MJpsP5bmhaIJGRBGlC4Xs6cmSFmdTntH/DToWl/SC5nFrgDqQo69iqK12tYEkKfv3A5jncDRUSkNZRT50IuUvhFQ+fKS3YNpsBx6HxRUJ50HH+MQobOg7636rvEKQc6wBZHfh0PM3s0vTzIqpcKdwmPC+QIDAQAB';
    private $priKey = 'MIICxjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQIXEFeW7CzTJ8CAggAMBQGCCqGSIb3DQMHBAiSuKKWJJYcGgSCAoCQvlmmGPvMd6fxuiktttpCGBW+5yrkD3Zr4DRAIKey5z53CoIErGRQXApuWAUN6DSI6iJJ+JEoU5MXdISi1M36IqUHsM3cB3iP1Zbvk/p/O4MRbSQXqucoMJlAZA3bhLdgcWARUkm6ZIR0h/+0okR1OfZ26Kk1xXPVmz5L+aM9mHnsdyOQLlaNl5jjwo248YnMXpC4/EKZnciZE1QFvYg0pFwVxgUC0MB2ZNZ/u+enJB12vnsGyYAZejdONTDab1tnR/VsS9LilUXBnVVTgy+Qa5ighP2a4Jo2bDyr6BIZWm1ZFI/DjqbDl8vrWsd8n/veFCFRCkV43GBCyYpfg3G779VuXvfe2/6R6t37of1q1LfFfdV4EmpTDQJk1YMtGmRlk86hWykdHjpkNBAa7OwIEECMVI+mjWsnJNBT+WQretpS3guRqM1SpZ+2hMG9ftkQdU8OjAPEGTctOc1W7OWfuB/qKAZBoNI9x/oHgAHeij2hLuJoVvrwu63l9rY+c4cJCpdpm+hzB5YAwMSDn3Xzev+eR3gdTVNsZ+9nhTUBOw8KXsBxoRgl2nb33KSUtMc3T00EJoMjiH+ERWoXIi/1fmBT7DUN+diqBbAEx1YK9Wm2tc5Kf6O9LBsPMVFeP0KtnqjfPDd6n/OI+ROCNzVKFJ3jF+U1Oma2MT5i6bhl3S9m5Xy3Y1smt+rF15lKGDwtbGDAh4q0MOnIbGTW2IC2q1yigb3OjNuEpfzsgWVTJTUdBWimSdCuGGqg++vvtikpMnr2rDe//QcDLye8BEGCbOf8F1JZh2/iIcCZhcGTK6O6GhtAUCLUvSh88EhsBqzT7Tc4jUGKTdf6wBcGPmRI';
    private $aes_key = 'SDF561werSFDBHJIoinju165iuheifAS';


    /**
     * 自定义错误处理
     */
    private function _error($msg)
    {
        die('RSA Error:' . $msg); //TODO
    }

    /**
     * 读取公钥和私钥
     * @param $key
     * @param string $pwd
     */
    public function read_rsa($key, $pwd = '')
    {
        if (empty($pwd)) {
            $key = '-----BEGIN PUBLIC KEY-----' . PHP_EOL . wordwrap($key, 64, "\n", true) . PHP_EOL . '-----END PUBLIC KEY-----';
            $this->pubKey = openssl_get_publickey($key);
        } else {
            $key = '-----BEGIN ENCRYPTED PRIVATE KEY-----' . PHP_EOL . wordwrap($key, 64, "\n", true) . PHP_EOL . '-----END ENCRYPTED PRIVATE KEY-----';
            $this->priKey = openssl_get_privatekey($key, $pwd);
        }
    }

    /**
     * rsa 生成签名 - sign
     * @param $data
     * @param $key
     * @return string
     */
    public function sign($data = null, $code = 'hex')
    {
        $this->read_rsa($this->priKey, $this->aes_key);
        $output = false;
        if (openssl_sign($data, $output, $this->priKey, OPENSSL_ALGO_SHA256)) {
            $ret = $this->_encode($output, $code);
        }
        return $ret;
    }


    /**
     * 验证签名
     *
     * @param string 签名材料
     * @param string 签名值
     * @param string 签名编码（base64/hex/bin）
     * @return bool
     */
    public function verify($data, $sign, $code = 'hex')
    {
        $this->read_rsa($this->pubKey);
        $ret = false;
        $sign = $this->_decode($sign, $code);
        if ($sign !== false) {
            switch (openssl_verify($data, $sign, $this->pubKey, OPENSSL_ALGO_SHA256)) {
                case 1:
                    $ret = true;
                    break;
                case 0:
                case -1:
                default:
                    $ret = false;
            }
        }
        return $ret;
    }



    /**
     *  rsa 非对称加密
     * @param string 明文
     * @param string 密文编码（base64/hex/bin）
     * @param int 填充方式（貌似php有bug，所以目前仅支持OPENSSL_PKCS1_PADDING）
     * @return string 密文
     */
    public function encrypt($data, $code = 'hex', $padding = OPENSSL_PKCS1_PADDING)
    {
        $this->read_rsa($this->pubKey);
        $ret = false;
        if (!$this->_checkPadding($padding, 'en')) $this->_error('padding error');
        if (openssl_public_encrypt($data, $result, $this->pubKey, $padding)) {
            $ret = $this->_encode($result, $code);
        }
        return $ret;
    }


    /**
     * rsa 非对称解密
     *
     * @param string 密文
     * @param string 密文编码（base64/hex/bin）
     * @param int 填充方式（OPENSSL_PKCS1_PADDING / OPENSSL_NO_PADDING）
     * @param bool 是否翻转明文（When passing Microsoft CryptoAPI-generated RSA cyphertext, revert the bytes in the block）
     * @return string 明文
     */
    public function decrypt($data, $code = 'hex', $padding = OPENSSL_PKCS1_PADDING, $rev = false)
    {
        $this->read_rsa($this->priKey,$this->aes_key);
        $ret = false;
        $data = $this->_decode($data, $code);
        if (!$this->_checkPadding($padding, 'de')) $this->_error('padding error');
        if ($data !== false) {
            if (openssl_private_decrypt($data, $result, $this->priKey, $padding)) {
                $ret = $rev ? rtrim(strrev($result), "\0") : '' . $result;
            }
        }
        return $ret;
    }


    /**
     *  aes对称加密
     * @param string $data 字符串   . $key 密钥 须是16位
     * @return string
     */
    public function encode($data, $code = 'hex')
    {
        return $this->_encode(openssl_encrypt($data,"AES-256-ECB",$this->aes_key,OPENSSL_RAW_DATA),$code);
    }


    /**
     * aes对称解密字符串
     * @param string $data 字符串  . $key 密钥 须是16位
     * @return string
     */
    public function decode($str, $code = 'hex')
    {
        return openssl_decrypt($this->_decode($str,$code),"AES-256-ECB",$this->aes_key,OPENSSL_RAW_DATA);
    }


    /**
     * 转换数组
     * @param $data
     * @return string
     */

    public function getSignContent($data)
    {
        $buff = '';
        foreach ($data as $k => $v) {
            $buff .= (!in_array($k, ['sign', 'customer_code']) && $v !== '' && !is_array($v)) ? $k . '=' . $v . '&' : '';
        }
        return trim($buff, '&');
    }


    /**
     * 密钥转换格式
     * @param $data
     * @param $code
     * @return string
     */
    private function _encode($data, $code)
    {
        switch (strtolower($code)) {
            case 'base64':
                $data = base64_encode('' . $data);
                break;
            case 'hex':
                $data = bin2hex($data);
                break;
            case 'bin':
            default:
        }
        return $data;
    }

    /**
     * 密钥转换格式
     * @param $data
     * @param $code
     * @return string
     */
    private function _decode($data, $code)
    {
        switch (strtolower($code)) {
            case 'base64' :
                $data = base64_decode(''.$data);
                break;
            case 'hex' :
                $data = $this->_hex2bin($data);
                break;
            case 'bin' :
            default :
        }
        return $data;
    }

    /**
     *  十六进制值转换
     * @param bool $hex
     * @return bool|string
     */
    private function _hex2bin($hex = false)
    {
        $ret = $hex !== false && preg_match('/^[0-9a-fA-F]+$/i', $hex) ? pack("H*", $hex) : false;
        return $ret;
    }


    /**
     * 检测填充类型
     * 加密只支持PKCS1_PADDING
     * 解密支持PKCS1_PADDING和NO_PADDING
     * @param int 填充模式
     * @param string 加密en/解密de
     * @return bool
     */
    private function _checkPadding($padding, $type)
    {
        if ($type == 'en') {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING:
                    $ret = true;
                    break;
                default:
                    $ret = false;
            }
        } else {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING:
                case OPENSSL_NO_PADDING:
                    $ret = true;
                    break;
                default:
                    $ret = false;
            }
        }
        return $ret;
    }


    /**
     * 生成Rsa公钥和私钥
     * @param int $private_key_bits 建议：[512, 1024, 2048, 4096]
     * @return array
     */
    public function generate($private_key_bits = 1024)
    {
        $opensslConfigPath = "D:/phpStudy/PHPTutorial/Apache/conf/openssl.cnf";
        $rsa = [
            "private_key" => "",
            "public_key" => ""
        ];
        $config = [
            "digest_alg" => "sha512",
            "private_key_bits" => $private_key_bits, #此处必须为int类型
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
            'config' => $opensslConfigPath,
        ];
        $str = openssl_pkey_new($config); //创建公钥和私钥
        openssl_pkey_export($str, $rsa['private_key'], null, $config); //提取私钥
        $rsa['public_key'] = openssl_pkey_get_details($str)["key"];  //生成公钥
        return $rsa;
    }




/***************************************************************  ECB/PKCS5Padding加密  **************************************************/

    /**
     *  1、操作步骤：将数组转换成json格式数据,再调用 getBytes()方法将字符转换成byte 格式。
     *
     *  2、操作步骤：将byte格式转换成toStr() 字符串。
     *
     *  3、操作步骤: encrypt_ecb() 字符串，密钥  加密
     *
     *  4、操作步骤: decrypt_ecb() 字符串，密钥  解密
     */


    /**
     * ECB/PKCS5Padding - 加密
     * @param $input
     * @param $key
     * @return string
     */
    public function encrypt_ecb($input, $key) {

        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);

        $input = $this->pkcs5_pad($input, $size);

        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');

        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);

        mcrypt_generic_init($td, $key, $iv);

        $data = mcrypt_generic($td, $input);

        mcrypt_generic_deinit($td);

        mcrypt_module_close($td);

        return base64_encode($data);

    }


    /**
     *  ECB - 解密
     * @param $sStr
     * @param $sKey
     * @return bool|string
     */
    public function decrypt_ecb($sStr, $sKey) {

        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$sKey,base64_decode($sStr),MCRYPT_MODE_ECB);

        $dec_s = strlen($decrypted);

        $padding = ord($decrypted[$dec_s-1]);

        $decrypted = substr($decrypted, 0, -$padding);

        return $decrypted;

    }


    /**
     *  加密数据处理
     * @param $text
     * @param $blocksize
     * @return string
     */
    private function pkcs5_pad ($text, $blocksize) {

        $pad = $blocksize - (strlen($text) % $blocksize);

        return $text . str_repeat(chr($pad), $pad);

    }

    /**
     * 将字符串转换成byte[]格式
     * @param $str
     * @return array
     */
    public function getBytes($str) {
        $len = strlen($str);
        $bytes = array();
        for($i=0;$i<$len;$i++) {
            if(ord($str[$i]) >= 128){
                $byte = ord($str[$i]) - 256;
            }else{
                $byte = ord($str[$i]);
            }
            $bytes[] = $byte ;
        }
        return $bytes;
    }


    /**
     * 将byte 格式转换成字符串
     * @param $bytes
     * @return string
     */
    public function toStr($bytes) {
        $str = '';
        foreach($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }
}
