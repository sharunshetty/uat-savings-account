<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @package     : LCode PHP WebFrame
 * @version     : 3.0.0
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

/** User Interface Class */
class AppData {

    /** Safe Input Data */
    public function strsafe_input($data) {
        if(is_array($data)) {
            foreach($data as $var=>$val) {
                $string[$var] = $this->strsafe_input($val);
            }
        } else {
            $search = array(
                '@<script[^>]*?>.*?</script>@si', // javascript
                '@<[\/\!]*?[^<>]*?>@si', // html tags
                '@<style[^>]*?>.*?</style>@siU', // style tags properly
                '@<![\s\S]*?--[ \t\n\r]*>@', // multi-line comments
                '@<!--(.|\s)*?-->@', // html comments
                '@<!--@', // html comments
            );
            $string = preg_replace($search,'', $data);
        }
        return $string;
    }

    /** Safe Output Data */
    public function strsafe_output($data) {
        if(is_array($data)) {
            foreach($data as $var=>$val) {
                $string[$var] = $this->strsafe_output($val);
            }
        } else {
            //$string = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $string = htmlentities($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        return $string;
    }

    /** Safe Modal Data */
    public function strsafe_modal($data) {
        if(is_array($data)) {
            foreach($data as $var=>$val) {
                $string[$var] = $this->strsafe_modal($val);
            }
        } else {
            $string = base64_encode($this->strsafe_output($data));
        }
        return $string;
    }

	/** Convert string to UTF-8 character encoding */
    function strsafe_utf8($string) {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    }

    /** Stop Form POST Data - If Duplicate Fields Found */
    public function post_dup_fields_check() {
        $post = array();
        foreach (explode('&', file_get_contents('php://input')) as $keyValuePair) {
            if($keyValuePair) {
                list($key, $value) = explode('=', $keyValuePair);
                if(!strpos($key, '%5B%5D')) {
                    if(!in_array($key, $post)) {
                        $post[] = $key;
                    } else {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /** CSRF Protection Token */
    public function csrf_token() {
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes(32));
        } else {
            return bin2hex(openssl_random_pseudo_bytes(32));
        }
    }

    /** Session Add Data */
    public function session_set($data) {
        if(is_array($data)) {
            session_start();
            foreach($data as $var => $val) { $_SESSION[$var] = $val; }
            session_write_close();
            return true;
        } else {
            //if(APP_PRODUCTION == false) { die('Session add failed'); }
            return false;
        }
    }

    /** Session Remove Data */
    public function session_remove($data) {
        if(is_array($data)) {
            session_start();
            foreach($data as $var) { unset($_SESSION[$var]); }
            session_write_close();
            return true;
        } else {
            //if(APP_PRODUCTION == false) { die('Session remove failed'); }
            return false;
        }
    }

    /** One Time Password (OTP) Generation */
    public function get_otpcode($length = "6") {
        return mt_rand(str_repeat(1,$length),str_repeat(9,$length));
        //return strtoupper(substr(md5(uniqid()), 0, $length));
    }

    /** User IP Address */
    //  public function current_ip() {
    //     if (!empty($_SERVER['HTTP_CLIENT_IP'])) { $ip = $_SERVER['HTTP_CLIENT_IP']; }
    //     elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
    //     else { $ip = $_SERVER['REMOTE_ADDR']; }
    //     return $ip;
    // } 

//    public function current_ip() {
//         if (!empty($_SERVER['HTTP_CLIENT_IP'])) { $ip = $_SERVER['HTTP_CLIENT_IP']; }
//         elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
//             $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//             if (strstr($ip, ',')) { 
//                 $multiple = explode(',', $ip);
//                 $ip = $multiple[0];
//             }
//         }
//         else { $ip = $_SERVER['REMOTE_ADDR']; }
//         return $ip;
//     }

    public function current_ip() {  //updated 28-05-2025
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { $ip = $_SERVER['HTTP_CLIENT_IP']; }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (strstr($ip, ',')) { 
                $multiple = explode(',', $ip);
                $ip = $multiple[0];
            }
        }
        else { $ip = $_SERVER['REMOTE_ADDR']; }

        // Remove port if present
        if (strpos($ip, ":") !== false) {
            $parts = explode(":", $ip);
            // Only IP Receive
            $ip = $parts[0];
        }
        
        return $ip;
    }

    /** String Length Count without Blank Space */
    public function wordlen($string) {
        return strlen(preg_replace('/\s+/','',$string));
    }

    /** Array No Duplicate Values */
    public function array_nodup($myVar) {
        if (count($myVar) != count(array_unique($myVar))) {
            return false;
        }
        return true;
    }

    /** Valid Array */
    public function valid_array($myVar) {
        if(is_array($myVar)) {
            foreach ($myVar as $key => $value) {
                if($value == NULL || $value == "") { return false; }
            }
            return true;
        }
        return false;
    }

    /** Valid Text */
    public function valid_date($myVar,$format = null) {
        if($format == null) { $format = "d-m-Y h:ia"; }
        return date($format, strtotime($myVar));
    }

    /** Check Date */
    public function check_date_exists($myDate) {
        return (bool)strtotime($myDate);
    }

    public function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /** Difference Between Two Dates */
    public function date_diff($date1 = null, $date2 = null) {
        if($date2 == null) { $date2 = date("Y-m-d H:i:s"); }
        if($date1 != null && $date2 != null) {
            if( $this->check_date_exists($date1) && $this->check_date_exists($date2)) {
                $diff = date_diff(date_create($date1), date_create($date2));
                return $diff->format("%a");
            }
        }
        return false;
    }

    /** Valid Text */
    public function valid_text($myVar){
        if(isset($myVar) && (empty($myVar) || $myVar === false || $myVar == NULL || $this->wordlen($myVar) < "2")) {
            return false;
        }
        return true;
    }

    /** Valid Number */
    public function valid_num($myVar){
        if(isset($myVar) && (empty($myVar) || $myVar === false || $myVar == NULL || !is_numeric($myVar))) {
            return false;
        }
        return true;
    }

    /** Valid URL */
    public function valid_url($url) {
       if(preg_match( '/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$url)) {
            if(filter_var($url, FILTER_VALIDATE_URL)) { 
                return true; 
            }
        }
        return false;
    }

    /** Valid Email Address */
    public function valid_email($email_id) {
        return filter_var($email_id, FILTER_VALIDATE_EMAIL);
    }

    /** Valid Email Address */
    public function valid_pancard($pan_card) {
        return preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/",$pan_card);
    }

    /** Valid 10 Digit Mobile Number */
    public function valid_mobile($mob_num) {
        $mob = preg_match('/^[5-9]\d{9}$/', $mob_num);
        if($mob == true) { $mob = preg_match('/^[0-9]{10}+$/', $mob_num); }
		return $mob;
    }

    /** Mask String */
    public function mask_text($string) {
        $len = strlen(preg_replace('/\s+/','',$string));
        return substr_replace($string, str_repeat("*", ($len - 2) ), 1, ($len - 2) );
    }

    /** Mask Mobile Number */
    public function mask_mobile($string) {
        if($string == NULL) { return ""; }
        $len = strlen(preg_replace('/\s+/','',$string));
        return substr_replace($string, str_repeat("X", ($len - 6) ), 2, ($len - 6) );
    }

    /** Mask Email id */
    public function mask_email($string) {
        if($string == NULL) { return ""; }
        $em   = explode("@",$string);
        if(count($em) > "1") {
            $name = implode('@', array_slice($em, 0, count($em)-1));
            $len  = floor(strlen($name)/2);
            return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);  
        } else {
            return $this->mask_text(end($em));
        }
    }

    /** String Max Length Replace */
    public static function strlimit_output($string,$limit = 100,$end = '...') {
        if(mb_strwidth($string, 'UTF-8') <= $limit) { return $string; }
        return rtrim(mb_strimwidth($string, 0, $limit, '', 'UTF-8')).$end;
    }

    /** Safe Data For AJAX Passing */
    public function jsescape($str) {
        return addcslashes( $str, "\\\\'\"&\n\r<>" );
    }

    /** Resize Image */
    public function get_image_resized($file_full_path,$resize_width) {
        $size = getimagesize($file_full_path);
        if($size) {
            $ratio = $size[0]/$size[1]; // width/height
            $width = $resize_width;
            $height = $resize_width / $ratio;
            $src = imagecreatefromstring(file_get_contents($file_full_path));
            $new_img = imagecreatetruecolor($width,$height);
            imagecopyresampled($new_img,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
            return $new_img;
        } else {
            return false;
        }
    }

    /** Custom Pagination */
    public function page_nav($start,$limit,$total,$filePath,$otherParams) {
        $allPages = ceil($total/$limit);
        $currentPage = floor($start/$limit) + 1;
        $pagination = "";
        if(1 < $allPages) {
            $maxPages = 9 < $allPages ? 9 : $allPages;
            /* if ( 9 < $allPages ) { */
            if (1 <= $currentPage && $currentPage <= $allPages) {
                $pagination .= 4 < $currentPage ? "" : "";
                $minPages = 4 < $currentPage ? $currentPage : 5;
                $maxPages = $currentPage < $allPages - 4 ? $currentPage : $allPages - 4;
                $i = $minPages - 4;
                while ($i < ($maxPages + 5)) {
                    $pagination .= $i == $currentPage ? "<li class='page-item active'><a href=\"#\" class=\"page-link currentpage\">".$i."</a></li> " : "<li class='page-item'><a class='page-link' href=\"".$filePath."?s=".( $i - 1 ) * $limit.$otherParams."\">".$i."</a></li> ";
                    ++$i;
                }
                $pagination .= $currentPage < $allPages - 4 ? "" : "";
            } else { 
                $pagination .= ""; 
            }
            /* } */
        } else { 
            do { 
                $i = 1;
            } while(0);
            while($i < ($allPages + 1)) {
                //$pagination .= $i == $currentPage ? "<li class='page-item'><a class='page-link active' href=\"#\" class=\"page-link currentpage\">".$i."</a></li> " : "<li class='page-item'><a class='page-link' href=\"".$filePath."?s=".( $i - 1 ) * $limit.$otherParams."\">".$i."</a></li> ";
                ++$i;
                break;
            }
        }
        if(1 < $currentPage) {
            $pagination = "<li class='page-item prevnext'><a class='page-link' href=\"".$filePath."?s=0".$otherParams."\">&lt;&lt;</a></li> <li class='page-item prevnext'><a class='page-link' href=\"".$filePath."?s=".( $currentPage - 2 ) * $limit.$otherParams."\">&lt;</a></li> ".$pagination;
        }
        if($currentPage < $allPages) {
            $pagination .= "<li class='page-item prevnext'><a class='page-link' href=\"".$filePath."?s=".$currentPage * $limit.$otherParams."\">&gt;</a></li> <li class='page-item prevnext'><a class='page-link' href=\"".$filePath."?s=".( $allPages - 1 ) * $limit.$otherParams."\">&gt;&gt;</a></li> ";
        }
        return $pagination;
    }

    /** Set Money Format to INR */
    public function set_price($amount) {
        if(strstr($amount,"-")) {
            $amount = str_replace("-","",$amount);
            $negative = "-";
        }
        $split_number = @explode(".",$amount);
        $rupee = $split_number[0];
        $paise = @$split_number[1];
        if(@strlen($rupee) > 3) {
            $hundreds = substr($rupee,strlen($rupee)-3);
            $thousands_in_reverse = strrev(substr($rupee,0,strlen($rupee)-3));
            $thousands = '';
            for($i=0; $i<(strlen($thousands_in_reverse)); $i=$i+2) {
                $thousands .= $thousands_in_reverse[$i].$thousands_in_reverse[$i+1].",";
            }
            $thousands = strrev(trim($thousands,","));
            $formatted_rupee = $thousands.",".$hundreds;
        } else {
            $formatted_rupee = $rupee;
        }
        if((int)$paise > 0) {
            $formatted_paise = ".".substr($paise,0,2);
        } else {
            $formatted_paise = '.00';
        }
        return $negative.$formatted_rupee.$formatted_paise;
    }

}
