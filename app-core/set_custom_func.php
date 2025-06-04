<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @package     : LCode PHP WebFrame
 * @version     : 3.0.0
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

// ######### App Functions ######### //

/** Browser Validation **/
$browser = new Browser();
$browser_name = $browser->getBrowser();
$browser_ver = $browser->getVersion();

if($browser_name == "Internet Explorer" && $browser_ver < "10") {
    include( DIRPATH . '/view/unsupported.php');
    exit();
}

/** Check Maintenance Mode */
if(defined('APP_MAINTENANCE') && APP_MAINTENANCE == true) {
    if(!isset($_POST['cmd']) && !isset($_GET['cmd'])) {
        require_once( DIRPATH . '/view/maintenance.php');
    }
    exit();
}

/** Stop - If Duplicate Fields in POST */
if($main_app->post_dup_fields_check() == false) {
    die('Error: Invalid Request');
}

/** CSRF Protection Token */
if(!isset($_SESSION['APP_TOKEN']) || $_SESSION['APP_TOKEN'] == NULL) {
    $main_app->session_set([ 'APP_TOKEN' => $main_app->csrf_token() ]); // New random key
}

/** Encryption Key */
if(!isset($_SESSION['SAFE_KEY']) || $_SESSION['SAFE_KEY'] == NULL) {
    $main_app->session_set([ 'SAFE_KEY' => substr(hash('sha256',mt_rand().microtime()),0,12) ]); // New random key
}

// ######### Custom Functions ######### //

/** Check User Session */
function check_usr_login() {

    //$_SESSION['USER_APP'],$_SESSION['USER_ID'],$_SESSION['USER_ROLE'],$_SESSION['USER_IP_ADD'],$_SESSION['USER_BROWSER'],$_SESSION['USER_BROWSER_VER'],$_SESSION['USER_TIMEOUT']

    global $main_app, $browser_name, $browser_ver;
    if(isset($_SESSION['USER_APP']) && defined('APP_CODE') && $_SESSION['USER_APP'] == APP_CODE && isset($_SESSION['USER_REF_NUM']) && isset($_SESSION['USER_ROLE']) ) {    
    if(isset($_SESSION['USER_IP_ADD']) && isset($_SESSION['USER_BROWSER']) && isset($_SESSION['USER_BROWSER_VER']) && $_SESSION['USER_IP_ADD'] == $main_app->current_ip() && $_SESSION['USER_BROWSER'] == $browser_name && $_SESSION['USER_BROWSER_VER'] == $browser_ver ) {        
    if(isset($_SESSION['USER_TIMEOUT']) && defined('APP_USR_TIMEOUT') && ( time() - (int)$_SESSION['USER_TIMEOUT'] ) < APP_USR_TIMEOUT ) {
                $main_app->session_set([ 'USER_TIMEOUT' => time() ]);
                return true; // User Logged-In

            }
        }
    }

    return false; // Fail

}

/** WebApp Copyrights */
function app_copyrights() {
    return "Copyright &copy; ".date('Y')." ".COPYRIGHT_BY;
}

/** WebApp Powered by */
function app_poweredby() {
    return "<span class='pw-link'> Powered by <span class='pw-logo'></span> LCode </span>";
}

/** Send SMS Notification */
function send_sms($mob_num,$sms_text,$testFlag = false) {
    try {

        if(SMS_ENABLE == "YES") {

            //$mob_num = "8660677277";
            //$mob_num = "7892963815";

            //$sms_text = urlencode($sms_text); // MSG
            if(is_array($mob_num)) { $mob_num = implode(",", $mob_num); }
            //$URL = "http://bulkpush.mytoday.com/BulkSms/SingleMsgApi?senderid=UCOBNK&username=9830415156&feedid=350953&password=uco123&to=".$mob_num."&text=".$sms_text;
            $URL = "https://bulkpush.mytoday.com/BulkSms/SingleMsgApi";

            $values['senderid'] = "UCOBNK";
            $values['username'] = "9830415156";
            $values['password'] = "uco123";
            $values['feedid'] = "350953";
            $values['to'] = $mob_num;
            $values['text'] = $sms_text;
			
			$ProxyCert = "C:\Proxy\1626415310_PCAcert.cer";

            $options = array(
                CURLOPT_RETURNTRANSFER => true,   // return web page - If you set TRUE then curl_exec returns actual result
                CURLOPT_HEADER         => false,  // Return headers
                CURLOPT_FOLLOWLOCATION => true,   // follow redirects
                CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
                CURLOPT_ENCODING       => "",     // handle compressed
                CURLOPT_USERAGENT      => "", // name of client
                CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
                CURLOPT_CONNECTTIMEOUT => 15,     // time-out on connect
                CURLOPT_TIMEOUT        => 15,     // time-out on response
                CURLOPT_SSL_VERIFYPEER => false,  // SSL verification
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_URL => $URL,  // URL
                CURLOPT_POST => true,  // Post method
                CURLOPT_POSTFIELDS => http_build_query($values),  // Post value
                CURLOPT_HTTPPROXYTUNNEL => 1,
                //CURLOPT_PROXY => "172.19.247.10",
				CURLOPT_PROXY => "172.19.135.41",
                //CURLOPT_PROXYPORT => "8080",
				CURLOPT_PROXYPORT => "8088",
				CURLOPT_CAINFO => $ProxyCert,
				//CURLOPT_CAPATH => $ProxyCert
            );

            $ch = curl_init(); // CURL Start
            curl_setopt_array($ch, $options); // Load CURL Options
            $response = curl_exec($ch); // Connection
			
			if ($testFlag == true) {
				echo "CURL Error: ".curl_error($ch)."<br/>";
				var_dump($response);
			}

            curl_close($ch); // Close CURL
            return $response;

        }

    } catch (Exception $e) {
        return false;
    }
}

/** Send Email Notification */
function send_email( $mail_sub, $mail_content, $mail_to = null, $mail_cc = null, $mail_bcc = null, $uploadfiles = null) {

    global $_SESSION;
    global $main_app;

    if(EMAIL_ENABLE != "YES") {
        error_log('Email disabled in settings');
        return false;
    }

    try {
        
        $mail = new PHPMailer();
        $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ));

        $mail->IsHTML(true);
        $mail->IsSMTP();
        $mail->SMTPAuth = EMAIL_AUTH_REQ; // true, false
        $mail->SMTPSecure = EMAIL_SECURE; // ssl, tls
        $mail->Host = EMAIL_HOST;
        $mail->Port = EMAIL_PORT;
        $mail->Username = EMAIL_USERNAME;
        $mail->Password = EMAIL_PASSWORD;
        $mail->From = EMAIL_FROM;
        $mail->FromName = EMAIL_FROM_NAME;
        $mail->Subject = $mail_sub;
        $mail->Body = $mail_content;

        //Email TO list
        if($mail_to) {
            if(is_array($mail_to)) { foreach($mail_to as $to_val) { $mail->AddAddress($to_val); } } 
            else { $mail->AddAddress($mail_to); }
        }

        //Email CC list
        if($mail_cc) {
            if(is_array($mail_cc)) { foreach($mail_cc as $cc_val) { $mail->AddCC($cc_val); } } 
            else { $mail->AddCC($mail_cc); }
        }

        //Email BCC list
        if($mail_bcc) {
            if(is_array($mail_bcc)) { foreach($mail_bcc as $bcc_val) { $mail->AddBCC($bcc_val); } } 
            else { $mail->AddBCC($mail_bcc); }
        }

        //Email Upload Files
        if($uploadfiles) {
            if(is_array($uploadfiles)) {
                foreach($uploadfiles as $file_name => $data ) { 
                    $mail->addStringAttachment($data, $file_name); 
                }
            }
        }

        //$mail->set('X-Priority','1'); // Priority 1 = High, 3 = Normal, 5 = Low
        $result = $mail->Send();
        if($result == false) { die($mail->ErrorInfo); }

        // $API_REQ_NUM = $main_app->sql_fetchcolumn("SELECT IFNULL(MAX(EMAIL_REF_NUM), 0) + 1 FROM APP_EMAIL_LOGS"); // Seq. No.

        //     $data = array();
        //     $data['EMAIL_REF_NUM'] = $API_REQ_NUM;
        //     $data['EMAIL_TO'] = $mail_to;
        //     $data['EMAIL_SUB'] = $mail_sub;
        //     $data['EMAIL_RESP'] = $result;
        //     $data['EMAIL_ERROR'] = substr($mail->ErrorInfo, 0, 50);
        //     $data['LOGIN_REF_ID'] = $_SESSION['LOGIN_REQ_NUM'];

        //     $data['CR_ON'] = date("Y-m-d H:i:s");
        //     $data['CR_BY'] = isset($_SESSION['USR_ID']) ? $_SESSION['USR_ID'] : "SYSTEM";
        //     $api_sent_logs = $main_app->sql_insert_data("APP_EMAIL_LOGS", $data); // Email log

        return $result;

    } catch (Exception $e) {
        return false;
    }
}

//newly added for checking country origin

function store_geolog($ref_num, $req, $resp, $error) {

    global $main_app, $db_output;
    $data = array();
    $data['GEOIP_VKYC_REF_NUM'] = $ref_num;
    $dtl_sl = $main_app->sql_fetchcolumn("SELECT NVL(MAX(DTL_SL), 0) + 1 FROM LOGS_GEOIPTRACKER WHERE GEOIP_VKYC_REF_NUM = :GEOIP_VKYC_REF_NUM", array('GEOIP_VKYC_REF_NUM' => $ref_num));
    $data['DTL_SL'] = $dtl_sl;
    $data['RAW_REQ'] = isset($req) ? $req : "";
    $data['RAW_RESPONSE'] = is_array($resp) ? json_encode($resp) : $resp;
    $data['CR_ON'] = date("Y-m-d H:i:s");
    $data['CR_BY'] = "ACOPENUSER";
    $data['ERROR_MESSAGE'] = $error;

    $geoip_logs = $main_app->sql_insert_data("LOGS_GEOIPTRACKER", $data); // API Log

}

//IP Spoof API Call
function check_countrywise_ip() {

    global $main_app;

    $refer_num = 'AC' . strtoupper(substr(md5(uniqid()), 0, 10));
	
	if (strpos($main_app->current_ip(), ":") !== false) {
		$parts = explode(":", $main_app->current_ip());
		//Only IP Receive
		$serv_ip = $parts[0];
	} else {
		$serv_ip = $main_app->current_ip();
	}
	
	$ip_req = "http://172.31.0.103:8090/GetCityDetails?key=7c756203dbb38590a66e01a5a3e1ad96&fqcn=". $serv_ip;

    //prod ip
    //$outputdata = file_get_contents('http://192.168.0.56:9501/GetCityDetails?key=7c756203dbb38590a66e01a5a3e1ad96&fqcn='. $ip_req);
   // $output = json_decode($outputdata, true);
   

    //$outputdata = file_get_contents('http://172.31.0.103:8090/GetCityDetails?key=7c756203dbb38590a66e01a5a3e1ad96&fqcn='. $ip_req);
  
    //$outputdata = file_get_contents('https://secure.geobytes.com/GetCityDetails?key=7c756203dbb38590a66e01a5a3e1ad96&fqcn=');
    $output = json_decode('{"geobytesforwarderfor":"","geobytesremoteip":"122.167.27.91","geobytesipaddress":"122.167.27.91","geobytescertainty":"31","geobytesinternet":"IN" ,"geobytescountry":"India","geobytesregionlocationcode":"INKA","geobytesregion":"Karnataka","geobytescode":"KA","geobyteslocationcode":"INKABANG","geobytesdma":"0","geobytescity":"Bangalore","geobytescityid":"4058","geobytesfqcn":"Bangalore, KA, India","geobyteslatitude":"12.983000","geobyteslongitude":"77.583000","geobytescapital":"New Delhi","geobytestimezone":"+05:30","geobytesnationalitysingular":"Indian","geobytespopulation":"1029991145","geobytesnationalityplural":"Indians","geobytesmapreference":"Asia ","geobytescurrency":"Indian Rupee ","geobytescurrencycode":"INR","geobytestitle":"India"}', true);
 
    
    if($output == "" || $output == false || $output == NULL || $output == null) {
        store_geolog($refer_num, $ip_req ,"", "");  
        return "Invalid Link";
    }
    elseif (isset($output['geobytesinternet']) && strtoupper($output['geobytesinternet']) != "IN" || $output['geobytesinternet'] == "" ) {
        store_geolog($refer_num, $ip_req, $output, "Country of origin is invalid");
        return "Country of origin is invalid";
    }
    elseif (strtoupper($output['geobytescountry']) != "INDIA" || $output['geobytescountry'] == "") {
        store_geolog($refer_num, $ip_req, $output, "Invalid Country");
        return "Invalid Country";
    }
    elseif (strtoupper($output['geobytescapital']) != "NEW DELHI" || $output['geobytescapital'] == "") {
        store_geolog($refer_num, $ip_req, $output, "Invalid Capital");
        return "Invalid County Capital";
    }
    elseif (strtoupper($output['geobytestimezone']) != "+05:30" || $output['geobytestimezone'] == "") {
        store_geolog($refer_num, $ip_req, $output, "Invalid Time Zone");
        return "Invalid Time Zone";
    }
    elseif (strtoupper($output['geobytesnationalitysingular']) != "INDIAN" || $output['geobytesnationalitysingular'] == "") {
        store_geolog($refer_num, $ip_req, $output, "Invalid nationality");
        return "Invalid nationality";  
    }  
   else {

        store_geolog($refer_num, $ip_req, $output, "success");
    } 

}
