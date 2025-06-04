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
if(!isset($_SESSION['USER_APP']) || $_SESSION['USER_APP'] != APP_CODE || !isset($_SESSION['OTP_REQ_ID']) || !isset($_SESSION['OTP_EMAIL_TIME']) || !isset($_SESSION['OTP_EMAIL_CHK']) || $_SESSION['OTP_EMAIL_CHK'] != "Y") {
    echo "<script> sess_error('Session expired. Please try again.'); loader_stop(); </script>";
    exit();
}

//Check OTP Timeout
if(isset($_SESSION['OTP_EMAIL_TIME']) && defined('APP_OTP_TIMEOUT') && ( time() - (int)$_SESSION['OTP_EMAIL_TIME'] ) > APP_OTP_TIMEOUT ) {
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
elseif(!isset($_SESSION['OTP_EMAIL_CODE']) || $_SESSION['OTP_EMAIL_CODE'] == NULL || $_SESSION['OTP_EMAIL_CODE'] == "") {
    echo "<script> swal.fire('','Unable to validate OTP code'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_SESSION['OTP_EMAIL_ATTEMPTS']) || $_SESSION['OTP_EMAIL_ATTEMPTS'] == NULL || !is_numeric($_SESSION['OTP_EMAIL_ATTEMPTS'])) {
    echo "<script> swal.fire('','Unable to process your request (E09)'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($preData['ReqType']) || ($preData['ReqType'] != "N" && $preData['ReqType'] != "E")) {
    echo "<script> swal.fire('','Unable to process your request (E10)'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($otp_data['OTP_EMAIL_ID']) || $otp_data['OTP_EMAIL_ID'] == NULL || $otp_data['OTP_EMAIL_ID'] == "") {
    echo "<script> swal.fire('','Unable to process your request (E11)'); loader_stop(); enable('sbt'); </script>";
}

elseif($preData['ReqType'] == "N" && (!isset($preData['RegMob']) || $preData['RegMob'] != $otp_data['OTP_MOBILE_NUM'])) {
    echo "<script> swal.fire('','Unable to process your request (E12)'); loader_stop(); enable('sbt'); </script>";
}
elseif($preData['ReqType'] == "E" && (!isset($preData['LoginMob']) || $preData['LoginMob'] != $otp_data['OTP_MOBILE_NUM'])) {
    echo "<script> swal.fire('','Unable to process your request (E13)'); loader_stop(); enable('sbt'); </script>";
}
elseif($preData['ReqType'] == "N" && (!isset($preData['RegEmail']) || $preData['RegEmail'] != $otp_data['OTP_EMAIL_ID'])) {
    echo "<script> swal.fire('','Unable to process your request (E14)'); loader_stop(); enable('sbt'); </script>";
}
elseif($preData['ReqType'] == "E" && (!isset($preData['LoginEmail']) || $preData['LoginEmail'] != $otp_data['OTP_EMAIL_ID'])) {
    echo "<script> swal.fire('','Unable to process your request (E15)'); loader_stop(); enable('sbt'); </script>";
}
elseif($_SESSION['OTP_EMAIL_ATTEMPTS'] >= "5") {
    echo "<script> swal.fire('','You have reached the maximum OTP attempt limit'); loader_stop(); enable('sbt'); </script>";
}
elseif($_SESSION['OTP_EMAIL_CODE'] != "S" && $plain_otp_code != $_SESSION['OTP_EMAIL_CODE']) {
    // Update Session
    $main_app->session_set([ 'OTP_EMAIL_ATTEMPTS' => $_SESSION['OTP_EMAIL_ATTEMPTS'] + 1 ]);
    echo "<script> swal.fire('','OTP entered is incorrect'); loader_stop(); enable('sbt'); </script>";
}
elseif($preData['ReqType'] == "E" && (!isset($preData['LoginAppId']) || $preData['LoginAppId'] == NULL || $preData['LoginAppId'] == "")) {
    echo "<script> swal.fire('','Unable to process your request (R16)'); loader_stop(); enable('sbt'); </script>";
}
else {

    // Check OTP with MB Server
    if($_SESSION['OTP_EMAIL_CODE'] == "S") {

        $MobNum = ($preData['ReqType'] == 'N') ? $preData['RegMob'] : $preData['LoginMob'];
        $EmailId = ($preData['ReqType'] == 'N') ? $preData['RegEmail'] : $preData['LoginEmail'];

        //Email OTP Gen.
        $send_data = array();
        $send_data['METHOD_NAME'] = "validateEmailOTP";
        $send_data['MOBILE_NUMBER'] = $MobNum;
        $send_data['CUST_EMAIL'] = strtolower($EmailId);
        $send_data['OTP'] = $plain_otp_code;

        try {
            $apiConn = new ReachMobApi;
            $output = $apiConn->ReachMobConnect($send_data, "40");
        } catch(Exception $e) {
            $ErrorMsg = $e->getMessage(); //Error from Class
        }

        if(!isset($ErrorMsg) || $ErrorMsg == "") {
            if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
                $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
                $main_app->session_set([ 'OTP_EMAIL_ATTEMPTS' => $_SESSION['OTP_EMAIL_ATTEMPTS'] + 1 ]);
            }
        }

        if(isset($ErrorMsg) && $ErrorMsg != "") {
            echo "<script> swal.fire('', deStr('".$main_app->strsafe_modal($ErrorMsg)."')); loader_stop(); enable('sbt'); </script>";
            exit();
        }

    }
    
    //Validate Process

    $updated_flag = true;

    // Update DB
    $data = array();
    $data['EMAIL_VERIFIED_FLAG'] = "S";
    $data['EMAIL_VERIFIED_ON'] = date("Y-m-d H:i:s");
    $db_output = $main_app->sql_update_data("LOG_OTPREQ", $data, array('OTP_REQ_ID' => $_SESSION['OTP_REQ_ID'])); // Update

    /** 1 - Registration */
    if($preData['ReqType'] == "N") {

        $AppRefNum = $main_app->sql_sequence("SBREQ_MASTER_SEQ","ARN"); // Seq. No.

        if(!$AppRefNum || $AppRefNum == false || $AppRefNum == "1") {
            echo "<script> swal.fire('','An error has occurred: Unable to generate reference number'); loader_stop(); enable('sbt'); </script>";
            exit();
        }

        $data = array();
        $data['SBREQ_APP_NUM'] = $AppRefNum;
        $data['SBREQ_MOBILE_NUM'] = $preData['RegMob'];
        $data['SBREQ_EMAIL_ID'] = $preData['RegEmail'];
        $data['SBREQ_APP_STATUS'] = "P";
        $data['SBREQ_CUST_TITLE'] = isset($preData['RegCustTitle']) ? $preData['RegCustTitle'] : NULL;
        $data['SBREQ_CUST_NAME'] = isset($preData['RegName']) ? $preData['RegName'] : NULL;
        $data['SBREQ_DBT_CHOICE'] = isset($preData['RegDbt']) ? $preData['RegDbt'] : NULL;
        $data['REFERRAL_CODE'] = (isset($preData['RegReferral']) && $preData['RegReferral'] != "") ? $preData['RegReferral'] : NULL;
        $data['CR_BY'] = isset($_SESSION['OTP_REQ_ID']) ? $_SESSION['OTP_REQ_ID'] : NULL;
        $data['CR_ON'] = date("Y-m-d H:i:s");
        $db_output = $main_app->sql_insert_data("SBREQ_MASTER",$data); // Insert
        if($db_output == false) { $updated_flag = false; }

        if($updated_flag == false) {
            echo "<script> swal.fire('','Unable to process your request (D01)'); loader_stop(); enable('sbt'); </script>";
            exit();
        }

     }

    /** 2 - Resume Application */
    elseif($preData['ReqType'] == "E") {

        //Check App Pending
        $RecordKeyVal = array( 'SBREQ_APP_NUM' => $preData['LoginAppId'], 'SBREQ_MOBILE_NUM' => $preData['LoginMob'], 'SBREQ_EMAIL_ID' => $preData['LoginEmail'] );
        $sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_MOBILE_NUM, SBREQ_EMAIL_ID FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND SBREQ_MOBILE_NUM = :SBREQ_MOBILE_NUM AND SBREQ_EMAIL_ID = :SBREQ_EMAIL_ID ORDER BY CR_ON DESC", $RecordKeyVal);
        $appData = $sql_exe2->fetch();

        if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
            echo "<script> swal.fire('','Unable to fetch application details'); loader_stop(); enable('sbt'); </script>";
            exit();
        }
        elseif(!isset($appData['SBREQ_MOBILE_NUM']) || $appData['SBREQ_MOBILE_NUM'] == NULL || $appData['SBREQ_MOBILE_NUM'] != $preData['LoginMob']) {
            echo "<script> swal.fire('','Unable to process your request (R01)'); loader_stop(); enable('sbt'); </script>";
            exit();
        }
        elseif(!isset($appData['SBREQ_EMAIL_ID']) || $appData['SBREQ_EMAIL_ID'] == NULL || $appData['SBREQ_EMAIL_ID'] != $preData['LoginEmail']) {
            echo "<script> swal.fire('','Unable to process your request (R02)'); loader_stop(); enable('sbt'); </script>";
            exit();
        }

        $AppRefNum = $appData['SBREQ_APP_NUM']; // Application

    }

     //get application reference number
     if($preData['ReqType'] == "N") { 
        $SBREQ_APP_NUM = $AppRefNum;
     }elseif($preData['ReqType'] == "E") { 
        $SBREQ_APP_NUM = $preData['LoginAppId'];
     }


    //fetch basic details from main table
     $sql_exe = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array('SBREQ_APP_NUM' => $SBREQ_APP_NUM));
     $basic_details = $sql_exe->fetch();


     //fetch aadhaar response
    $sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $SBREQ_APP_NUM));
    $kycDetails = $sql_exe3->fetch();

    //decode aadhaar response
    if(isset($kycDetails['DOC_DATA']) && $kycDetails['DOC_DATA'] != "") {
    $kycDetails = json_decode(stream_get_contents($kycDetails['DOC_DATA']), true, JSON_UNESCAPED_SLASHES); 
    }

    //fetch pan details
    $sql_exe4 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'PAN' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $SBREQ_APP_NUM));
    $panDATA = $sql_exe4->fetch();

    //decode aadhaar response
    if(isset($panDATA['DOC_DATA']) && $panDATA['DOC_DATA'] != "") {
        $panDetails = json_decode(stream_get_contents($panDATA['DOC_DATA']), true, JSON_UNESCAPED_SLASHES); 
    }

    $pan_firstname = isset($panDetails['firstName']) ? $panDetails['firstName'] : "";

    //combine pan name
    $fullname = "";

    $fullname .= (isset($panDetails['firstName']) && $panDetails['firstName'] != "") ? trim($panDetails['firstName']) : "";
    $fullname .= (isset($panDetails['midName']) && $panDetails['midName'] != "") ? " ". $panDetails['midName'] : "";
    $fullname .= (isset($panDetails['lastName']) && $panDetails['lastName'] != "") ? " ". $panDetails['lastName'] : "";

    $cust_name = explode(' ', $basic_details['SBREQ_CUST_NAME']);
    $custname1 = isset($cust_name[0]) ? $cust_name[0] : NULL;

     //convert name to uppercase
     if(isset($kycDetails['name']) && $kycDetails['name'] != "") {
        $aadhaar_name = strtoupper($kycDetails['name']);
     }

     if(isset($fullname) && $fullname != "") {
        $pan_full_name = strtoupper($fullname);
     }

     if(isset($pan_firstname) && $pan_firstname != "") {
        $pan_custname1 = strtoupper($pan_firstname);
     }

    //compare name and set session
    if(isset($aadhaar_name) && $aadhaar_name != "" && ($aadhaar_name != $basic_details['SBREQ_CUST_NAME'])) {
        $name_flag = $main_app->session_set([ 'name_flag' =>  "Y"]);
    }
    elseif(isset($pan_custname1) && $pan_custname1 != ""  && ($pan_custname1 != $custname1)) {
        $main_app->session_set(['name_flag' =>  "Y"]);
    }

    //Start Application

   // Session Data
    $main_app->session_set([
        'USER_APP' => APP_CODE,
        'USER_REF_NUM' => $AppRefNum, // Application Number
        'USER_ROLE' => "CUST", // Store User I/P
        'USER_IP_ADD' => $main_app->current_ip(),
        'USER_BROWSER' => $browser_name,
        'USER_BROWSER_VER' => $browser_ver,
        'USER_TIMEOUT' => time(),
        'OTP_SMS_CHK' => "S",
        'OTP_EMAIL_CHK' => "S",
        'EMAIL_VERIFIED_FLAG' => "S",
        'name_flag' => (isset($name_flag) && $name_flag != "") ? $name_flag : NULL

    ]);

    $homePgm = APP_URL."/ac-process";
    echo "<script> goto_url('{$homePgm}'); </script>"; // Done

}
