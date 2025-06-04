<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

//Check OTP Session
if(!isset($_SESSION['USER_APP']) || $_SESSION['USER_APP'] != APP_CODE || !isset($_SESSION['OTP_REQ_ID']) || !isset($_SESSION['OTP_SMS_TIME']) || !isset($_SESSION['OTP_SMS_CHK']) || $_SESSION['OTP_SMS_CHK'] != "Y") {
    echo "<script> sess_error('Session expired. Please try again.'); </script>";
    exit();
}

//Check OTP Timeout
if(isset($_SESSION['OTP_SMS_TIME']) && defined('APP_OTP_TIMEOUT') && ( time() - (int)$_SESSION['OTP_SMS_TIME'] ) > APP_OTP_TIMEOUT ) {
    $go_url = APP_URL.'/logout';
    echo "<script> swal.fire({ title:'Session Timeout', text:'Your session has timed out. Please start again.', icon:'error', allowOutsideClick:false, confirmButtonText:'OK' }).then(function (result) { if (result.value) { goto_url('" . $go_url . "'); } }); </script>";
    exit();
}

//OTP Sent Data
$sql1_exe = $main_app->sql_run("SELECT OTP_REQ_ID, OTP_MOBILE_NUM, SMS_RESENT_COUNT FROM LOG_OTPREQ WHERE OTP_REQ_ID = :OTP_REQ_ID", array( 'OTP_REQ_ID' => $_SESSION['OTP_REQ_ID'] ));
$otp_data = $sql1_exe->fetch();

if(!isset($otp_data['SMS_RESENT_COUNT']) || $otp_data['SMS_RESENT_COUNT'] == NULL) {
    $otp_data['SMS_RESENT_COUNT'] = 0;
}

// if(isset($_SESSION['PRE_LOGIN_DATA']) && $_SESSION['PRE_LOGIN_DATA']) {
//     $preData = json_decode($_SESSION['PRE_LOGIN_DATA'], true);
// }

//OTP Still Pending Check
if(!isset($otp_data['OTP_REQ_ID']) || $otp_data['OTP_REQ_ID'] == NULL || $otp_data['OTP_REQ_ID'] != $_SESSION['OTP_REQ_ID']) {
    echo "<script> swal.fire('','E01: Unable to process your request'); </script>";
    exit();
}
elseif(!isset($otp_data['OTP_MOBILE_NUM']) || $otp_data['OTP_MOBILE_NUM'] == NULL || $otp_data['OTP_MOBILE_NUM'] == "") {
    echo "<script> swal.fire('',''E02: Unable to process your request'); </script>";
    exit();
}
elseif(!isset($otp_data['SMS_RESENT_COUNT']) || $otp_data['SMS_RESENT_COUNT'] >= "3") {
    echo "<script> swal.fire('','You have reached maximum OTP resend limit'); disable('ResendBtn'); </script>";
    exit(); 
}

// Generate OTP
$otpCodeSms = $main_app->get_otpcode();

//Update
$data = array();
$data['SMS_RESENT_COUNT'] = $otp_data['SMS_RESENT_COUNT'] + 1;
$data['SMS_SENT_RESP'] = base64_encode($otpCodeSms);
$db_output = $main_app->sql_update_data("LOG_OTPREQ", $data, array('OTP_REQ_ID' => $_SESSION['OTP_REQ_ID'])); // Update

if($db_output == false) {
    echo "<script> swal.fire('',''E03: Unable to process your request'); </script>";
    exit();
}

// Session Data
$main_app->session_set([
    'OTP_SMS_CODE' => $otpCodeSms,
    'OTP_SMS_TIME' => time(),
    'OTP_SMS_ATTEMPTS' => "0"
]);

//Send SMS
/*try {
    require_once(DIRPATH.'/class/class_mod_sendalerts.php');
    SendAlert::SendAlertRequest("SMS", $otp_data['OTP_MOBILE_NUM'], "OTP-SMS", array('@@OTPCODE@@' => $otpCodeSms), "5", $_SESSION['OTP_REQ_ID']);
} catch (Exception $e) {
    echo "<script> swal.fire('','".$e->getMessage()."'); </script>";
    exit();
}
*/

$SmsTemplate = $main_app->sql_fetchcolumn("SELECT SMSTPL_TEXT FROM APP_SMS_TEMPLATES WHERE SMSTPL_CODE = 'OTP-SMS' AND SMSTPL_ENABLE = '1'");
if($SmsTemplate && $SmsTemplate != NULL && $SmsTemplate != "") {
    $ShortTags = array( '@@OTPCODE@@' => isset($otpCodeSms) ? $otpCodeSms : "" );
    $SmsTemplate = strtr($SmsTemplate, $ShortTags);
    $sms_sentlog = send_sms($otp_data['OTP_MOBILE_NUM'], $SmsTemplate);
}

echo "<script> swal.fire('New OTP Sent','','success'); startCounter(); </script>";

