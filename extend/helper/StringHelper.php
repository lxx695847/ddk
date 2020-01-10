<?php

namespace helper;

class StringHelper extends HelperClass{

    /**
     * HTML转码 : 把预定义的字符  如："<" （小于）和 ">" （大于）转换为 HTML 实体
     * @param string $str
     * @return string
     */
    public static function escape($str) {
        if (empty($str)) {
            return $str . '';
        }
        $str = htmlspecialchars($str, ENT_QUOTES);
        $str = str_replace("'", '&#39;', $str);
        $str = str_replace('"', '&#34;', $str);
        return trim($str);
    }

    /**
     * HTML转码 : 把字符转换为 HTML 实体
     * @param string $str
     * @return string
     */
    public static function htmlentities($str) {
        return htmlentities($str, ENT_QUOTES | ENT_IGNORE, "UTF-8");
    }

    /**
     * 过滤XSS代码
     * @param unknown $str
     * @param string $ubb
     * @return mixed
     */
    public static function filter($str, $ubb = false) {
        $search = array(
            '/<script.*>.*<\/script.*>/isU',
            '/<i?frame.*>.*<\/i?frame.*>/isU',
            '/<\/?i?frame.*>/isU',
            '/<applet.*>.*<\/applet.*>/isU',
            '/<style.*>.*<\/style.*>/isU',
            '/<\/?html.*>/isU',
            '/<\/?head.*>/isU',
            '/<\/?meta.*>/isU',
            '/<\/?body.*>/isU'
        );
        $str = preg_replace($search, '', $str);
        $str = preg_replace('/on([\w+]\s*=)/i', 'on<x>\\1', $str);
        return $str;
    }


    /**
     * 生成用户名
     * @return string
     */
    public static function userName()
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_~|";
        $username = "";
        for ( $i = 0; $i < 6; $i++ )
        {
            $username .= $chars[mt_rand(0, strlen($chars))];
        }
        return $username;
    }

    /**
     * UBB代码
     * @param string $str
     * @return string
     */
    public static function ubb($str) {
        if (empty($str)) {
            return $str;
        }
        //空格替换
        $str = str_replace(' ', '&nbsp;', $str);
        //在字符串中的新行（\n）之前插入换行符
        $str = nl2br($str);
        return $str;
    }

    /**
     * 过滤标签
     * @param string $str
     * @param int $len
     * @param string $etc
     * @return string
     */
    public static function stripTags($str, $len, $etc = '..') {
        //剥去字符串中的 HTML 标签
        $str = strip_tags($str);
        $str = trim($str);
        return static::cutstr($str, $len, $etc);
    }

    /**
     * 字符串截取
     * @param string $string
     * @param integer $length
     * @param string $etc
     * @return string
     */
    public static function cutstr($string, $length, $etc = '') {
        $result = '';
        //把 HTML 实体转换为字符
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strLen = strlen($string);
        for ($i = 0; ($i < $strLen && $length > 0); $i++){
            $number = strpos(str_pad(decbin(ord($string[$i])), 8, '0', STR_PAD_LEFT), '0');
            if (!empty($number)){
                $result .= substr($string, $i, $number);
                $length -= 2;
                $i += $number - 1;
            } else {
                $result .= substr($string, $i, 1);
                $length -= 1;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strLen){
            $result .= $etc;
        }
        return $result;
    }

    /**
     * 中文特殊符号转英文
     * @param string $str
     * @return string
     */
    public static function mbReplace($str) {
        $str = str_replace(array('、', '，', '；'), array('\\', ',', ';'), $str);
        return $str;
    }

    /**
     * 字符串分割数组
     * @param string $str
     * @return string[]
     */
    public static function tags($str) {
        $str = trim($str);
        $str = self::mbReplace($str);
        return preg_split('/[,\s|.\\;]+/', $str);
    }

    /**
     * 去掉头尾空格
     * @param string $str
     * @return string
     */
    public static function strip($str) {
        $str = strip_tags($str);
        $str = trim($str);
        return $str;
    }

    /**
     * 获取摘要
     * @param string $str
     * @param number $len
     * @param string $dot
     * @return string
     */
    public static function desc($str, $len = 200, $dot = '') {
        $str = self::strip($str);
        $str = preg_replace('/\s+/isU', '', $str);
        $str = self::cutstr($str, $len, $dot);
        return $str;
    }

    /**
     * 特殊符号过滤
     * @param string $str
     * @return string
     */
    public static function specials($str) {
        if (!function_exists('mb_str_split')) {
            function mb_str_split($string) {
                return preg_split('/(?<!^)(?!$)/u', $string );
            }
        }
        $words = '~!@#$%^&*~,./<>?;\':"！￥…；：’‘”“，。、《》？';
        $search = mb_str_split($words);
        $str = str_replace($search, '', $str);
        return $str;
    }


    /**
     * 关键词分词
     * @param string $str
     * @return array
     */
    public static function splitWords($str) {
        if (empty($str)) {
            return [];
        }
        $str = preg_replace('/[^\x{4e00}-\x{9fa5}A-Za-z0-9]/u', ' ', $str);
        $array = preg_split('/\s+/sU', $str);
        return array_filter($array);
    }

    /**
     * 中文分组
     * @param string $str
     * @return array
     */
    public static function mbSplit($str) {
        $array = [];
        preg_match_all("/./u", $str, $array);
        return $array[0];
    }


    /**
     * 获取邀请码
     * @return string
     */
    public static function create_invite_code() {
        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = $code[rand(0,25)]
            .strtoupper(dechex(date('m')))
            .date('d')
            .substr(time(),-5)
            .substr(microtime(),2,5)
            .sprintf('%02d',rand(0,99));
        for(
            $a = md5( $rand, true ),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            $d = '',
            $f = 0;
            $f < 6;
            $g = ord( $a[ $f ] ),
            $d .= $s[ ( $g ^ ord( $a[ $f + 8 ] ) ) - $g & 0x1F ],
            $f++
        );
        return $d;
    }

}