<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

if(isset($_POST['otp_code']) && $_POST['otp_code'] != "") {
    $safe = new Encryption();
    $plain_otp_code = $safe->rsa_decrypt($_POST['otp_code']);
}

if(isset($_SESSION['PRE_LOGIN_DATA']) && $_SESSION['PRE_LOGIN_DATA'] != "") {
    $preData = json_decode($_SESSION['PRE_LOGIN_DATA'], true);
}

//Check OTP Session
if(!isset($_SESSION['USER_APP']) || $_SESSION['USER_APP'] != APP_CODE || !isset($_SESSION['OTP_REQ_ID']) || !isset($_SESSION['OTP_SMS_TIME']) || !isset($_SESSION['OTP_SMS_CHK']) || $_SESSION['OTP_SMS_CHK'] != "Y") {
    echo "<script> sess_error('Session expired. Please try again.'); loader_stop(); </script>";
    exit();
}

//Check OTP Timeout
if(isset($_SESSION['OTP_SMS_TIME']) && defined('APP_OTP_TIMEOUT') && ( time() - (int)$_SESSION['OTP_SMS_TIME'] ) > APP_OTP_TIMEOUT ) {
    $go_url = APP_URL.'/logout';
    echo "<script> swal.fire({ title:'Session Timeout', text:'Your session has timed out. Please start again.', icon:'error', allowOutsideClick:false, confirmButtonText:'OK' }).then(function (result) { if (result.value) { goto_url('" . $go_url . "'); } }); loader_stop(); </script>";
    exit();
}

//OTP Sent Data
$sql1_exe = $main_app->sql_run("SELECT OTP_REQ_ID, OTP_MOBILE_NUM, OTP_EMAIL_ID FROM LOG_OTPREQ WHERE OTP_REQ_ID = :OTP_REQ_ID", array( 'OTP_REQ_ID' => $_SESSION['OTP_REQ_ID'] ));
$otp_data = $sql1_exe->fetch();

if(!isset($_POST['otp_code']) || isset($_POST['otp_code']) == NULL || isset($_POST['otp_code']) == "") {
    echo "<script> swal.fire('','Enter valid OTP code'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($plain_otp_code) || $plain_otp_code == false) {
    echo "<script> swal.fire('','Unable to process your request (E08)'); loader_stop(); enable('sbt'); </script>";
}
elseif(strlen($plain_otp_code) != "6") {
    echo "<script> swal.fire('','OTP code length not matching'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_SESSION['OTP_SMS_CODE']) || $_SESSION['OTP_SMS_CODE'] == NULL || $_SESSION['OTP_SMS_CODE'] == "") {
    echo "<script> swal.fire('','Unable to validate OTP code'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_SESSION['OTP_SMS_ATTEMPTS']) || $_SESSION['OTP_SMS_ATTEMPTS'] == NULL || !is_numeric($_SESSION['OTP_SMS_ATTEMPTS'])) {
    echo "<script> swal.fire('','Unable to process your request (E09)'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($preData['ReqType']) || ($preData['ReqType'] != "N" && $preData['ReqType'] != "E")) {
    echo "<script> swal.fire('','Unable to process your request (E10)'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($otp_data['OTP_MOBILE_NUM']) || $otp_data['OTP_MOBILE_NUM'] == NULL || $otp_data['OTP_MOBILE_NUM'] == "") {
    echo "<script> swal.fire('','Unable to process your request (E11)'); loader_stop(); enable('sbt'); </script>";
}

elseif($preData['ReqType'] == "N" && (!isset($preData['RegMob']) || $preData['RegMob'] != $otp_data['OTP_MOBILE_NUM'])) {
    echo "<script> swal.fire('','Unable to process your request (E12)'); loader_stop(); enable('sbt'); </script>";
}
elseif($preData['ReqType'] == "E" && (!isset($preData['LoginMob']) || $preData['LoginMob'] != $otp_data['OTP_MOBILE_NUM'])) {
    echo "<script> swal.fire('','Unable to process your request (E13)'); loader_stop(); enable('sbt'); </script>";
}
elseif($preData['ReqType'] == "E" && (!isset($preData['LoginEmail']) || $preData['LoginEmail'] != $otp_data['OTP_EMAIL_ID'])) {
    echo "<script> swal.fire('','Unable to process your request (R15)'); loader_stop(); enable('sbt'); </script>";
}

elseif($_SESSION['OTP_SMS_ATTEMPTS'] >= "5") {
    echo "<script> swal.fire('','You have reached the maximum OTP attempt limit'); loader_stop(); enable('sbt'); </script>";
}
elseif($plain_otp_code != $_SESSION['OTP_SMS_CODE']) {
    // Update Session
    $main_app->session_set([ 'OTP_SMS_ATTEMPTS' => $_SESSION['OTP_SMS_ATTEMPTS'] + 1 ]);
    echo "<script> swal.fire('','OTP entered is incorrect'); loader_stop(); enable('sbt'); </script>";
}
elseif($preData['ReqType'] == "E" && (!isset($preData['LoginAppId']) || $preData['LoginAppId'] == NULL || $preData['LoginAppId'] == "")) {
    echo "<script> swal.fire('','Unable to process your request (R16)'); loader_stop(); enable('sbt'); </script>";
}
else {

    // Generate OTP
    if(APP_PRODUCTION == false || SMS_ENABLE == "NO") {
        
        $otpCodeEmail = "123123";
    
    } else {

        $MobNum = ($preData['ReqType'] == 'N') ? $preData['RegMob'] : $preData['LoginMob'];
        $EmailId = ($preData['ReqType'] == 'N') ? $preData['RegEmail'] : $preData['LoginEmail'];

        //Email OTP Gen.
        $send_data = array();
        $send_data['METHOD_NAME'] = "generateEmailOTP";
        $send_data['MOBILE_NUMBER'] = $MobNum;
        $send_data['CUST_EMAIL'] = strtolower($EmailId);

        try {
            $apiConn = new ReachMobApi;
            $output = $apiConn->ReachMobConnect($send_data, "40");
        } catch(Exception $e) {
            $ErrorMsg = $e->getMessage(); //Error from Class
        }

        if(!isset($ErrorMsg) || $ErrorMsg == "") {
            if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
                $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
            }
        }

        if(isset($ErrorMsg) && $ErrorMsg != "") {
            echo "<script> swal.fire('', deStr('".$main_app->strsafe_modal($ErrorMsg)."')); loader_stop(); enable('sbt'); </script>";
            exit();
        }

        $otpCodeEmail = (isset($output['responseCode']) && $output['responseCode'] == "S") ? $output['responseCode'] : "F";

    }

    // Send Email
    /*try {
        require_once(DIRPATH.'/class/class_mod_sendalerts.php');
        SendAlert::SendAlertRequest("EMAIL", $otp_data['OTP_EMAIL_ID'], "OTP-EMAIL", array('@@OTPCODE@@' => $otpCodeEmail), "5", $_SESSION['OTP_REQ_ID']);
    } catch (Exception $e) {
        echo "<script> swal.fire('','Email Error: ".$e->getMessage()."'); loader_stop(); </script>";
        exit();
    }
    */

    // $EmailTemplate = $main_app->sql_fetchcolumn("SELECT SMSTPL_TEXT FROM APP_SMS_TEMPLATES WHERE SMSTPL_CODE = 'OTP-EMAIL' AND SMSTPL_ENABLE = '1'");
    // if($EmailTemplate && $EmailTemplate != NULL && $EmailTemplate != "") {
    //     $ShortTags = array( '@@OTPCODE@@' => isset($otpCodeEmail) ? $otpCodeEmail : "" );
    //     $EmailTemplate = strtr($EmailTemplate, $ShortTags);
    //     $email_sentlog = send_sms($otp_data['OTP_EMAIL_ID'], $EmailTemplate);
    //     var_dump($email_sentlog);
    // }

    // Update DB
    $data = array();
    $data['SMS_VERIFIED_FLAG'] = "S";
    $data['SMS_VERIFIED_ON'] = date("Y-m-d H:i:s");
    $data['EMAIL_VERIFIED_FLAG'] = "P";
    $data['EMAIL_RESENT_COUNT'] = NULL;
    $data['EMAIL_SENT_RESP'] = $otpCodeEmail;
    $db_output = $main_app->sql_update_data("LOG_OTPREQ", $data, array('OTP_REQ_ID' => $_SESSION['OTP_REQ_ID'])); // Update

    if($db_output == false) {
        echo "<script> swal.fire('','Unable to process your request (D01)'); loader_stop(); </script>";
        exit();
    }

    // Session Data
    $main_app->session_remove([ 'OTP_SMS_CODE', 'OTP_SMS_TIME', 'OTP_SMS_ATTEMPTS' ]);
    $main_app->session_set([
        'OTP_SMS_CHK' => "S",
        'OTP_EMAIL_CODE' => $otpCodeEmail,
        'OTP_EMAIL_TIME' => time(),
        'OTP_EMAIL_CHK' => "Y",
        'OTP_EMAIL_ATTEMPTS' => "0",
	'SMS_VERIFIED_FLAG' => "S"
    ]);

    $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
    echo "<script> goto_url('otp-verify-email'); </script>"; // Done

}
