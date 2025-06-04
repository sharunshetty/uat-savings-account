<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

//Check OTP Session
if(!isset($_SESSION['USER_APP']) || $_SESSION['USER_APP'] != APP_CODE || !isset($_SESSION['OTP_REQ_ID']) || !isset($_SESSION['OTP_EMAIL_TIME']) || !isset($_SESSION['OTP_EMAIL_CHK']) || $_SESSION['OTP_EMAIL_CHK'] != "Y") {
    echo "<script> sess_error('Session expired. Please try again.'); </script>";
    exit();
}

//Check OTP Timeout
if(isset($_SESSION['OTP_EMAIL_TIME']) && defined('APP_OTP_TIMEOUT') && ( time() - (int)$_SESSION['OTP_EMAIL_TIME'] ) > APP_OTP_TIMEOUT ) {
    $go_url = APP_URL.'/logout';
    echo "<script> swal.fire({ title:'Session Timeout', text:'Your session has timed out. Please start again.', icon:'error', allowOutsideClick:false, confirmButtonText:'OK' }).then(function (result) { if (result.value) { goto_url('" . $go_url . "'); } }); </script>";
    exit();
}

//OTP Sent Data
$sql1_exe = $main_app->sql_run("SELECT OTP_REQ_ID, OTP_EMAIL_ID, EMAIL_RESENT_COUNT FROM LOG_OTPREQ WHERE OTP_REQ_ID = :OTP_REQ_ID", array( 'OTP_REQ_ID' => $_SESSION['OTP_REQ_ID'] ));
$otp_data = $sql1_exe->fetch();

if(!isset($otp_data['EMAIL_RESENT_COUNT']) || $otp_data['EMAIL_RESENT_COUNT'] == NULL) {
    $otp_data['EMAIL_RESENT_COUNT'] = 0;
}

if(isset($_SESSION['PRE_LOGIN_DATA']) && $_SESSION['PRE_LOGIN_DATA']) {
    $preData = json_decode($_SESSION['PRE_LOGIN_DATA'], true);
}

//OTP Still Pending Check
if(!isset($otp_data['OTP_REQ_ID']) || $otp_data['OTP_REQ_ID'] == NULL || $otp_data['OTP_REQ_ID'] != $_SESSION['OTP_REQ_ID']) {
    echo "<script> swal.fire('','E01: Unable to process your request'); </script>";
    exit();
}
elseif(!isset($otp_data['OTP_EMAIL_ID']) || $otp_data['OTP_EMAIL_ID'] == NULL || $otp_data['OTP_EMAIL_ID'] == "") {
    echo "<script> swal.fire('',''E02: Unable to process your request'); </script>";
    exit();
}
elseif(!isset($otp_data['EMAIL_RESENT_COUNT']) || $otp_data['EMAIL_RESENT_COUNT'] >= "3") {
    echo "<script> swal.fire('','You have reached maximum OTP resend limit'); disable('ResendBtn'); </script>";
    exit(); 
}

// Generate OTP
//$otpCodeEmail = $main_app->get_otpcode();

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

//Update
$data = array();
$data['EMAIL_RESENT_COUNT'] = $otp_data['EMAIL_RESENT_COUNT'] + 1;
$data['EMAIL_SENT_RESP'] = isset($output['responseCode']) ? $output['responseCode'] : $otpCodeEmail;

$db_output = $main_app->sql_update_data("LOG_OTPREQ", $data, array('OTP_REQ_ID' => $_SESSION['OTP_REQ_ID'])); // Update

if($db_output == false) {
    echo "<script> swal.fire('',''E03: Unable to process your request'); </script>";
    exit();
}

// Session Data
$main_app->session_set([
    'OTP_EMAIL_CODE' => $otpCodeEmail,
    'OTP_EMAIL_TIME' => time(),
    'OTP_EMAIL_ATTEMPTS' => "0"
]);

// Send Email
// try {
//     require_once(DIRPATH.'/class/class_mod_sendalerts.php');
//     SendAlert::SendAlertRequest("EMAIL", $otp_data['OTP_EMAIL_ID'], "OTP-EMAIL", array('@@OTPCODE@@' => $otpCodeEmail), "5", $_SESSION['OTP_REQ_ID']);
// } catch (Exception $e) {
//     echo "<script> swal.fire('','Email Error: ".$e->getMessage()."'); </script>";
//     exit();
// }


echo "<script> swal.fire('New OTP Sent','','success'); startCounter(); </script>";

