<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

//Decrypt Application reference number
if(isset($_POST['arnVal']) && $_POST['arnVal'] != "") {
    $plain_arn_val = $safe->str_decrypt($_POST['arnVal'], $_SESSION['SAFE_KEY']);
}

//decrypt aadhaar number
if(isset($_POST['ekycNum']) && $_POST['ekycNum'] != "") {
    $safe = new Encryption();
    $plain_ekyc_num = $safe->rsa_decrypt($_POST['ekycNum']);
}

//decrypt aadhaar number
if(isset($_POST['ekycNum']) && $_POST['ekycNum'] != "") {
    $safe = new Encryption();
    $plain_ekyc_num = $safe->rsa_decrypt($_POST['ekycNum']);
}

// $sql_exe = $main_app->sql_run("select * from cbuat.piddocs p where p.piddocs_pid_type='UID' and p.piddocs_docid_num=:AADHAAR_NUMBER", array('AADHAAR_NUMBER' => $plain_ekyc_num));
// $itemdata = $sql_exe->fetch();

// if(isset($itemdata) && $itemdata != "" || $itemdata != NULL) {
//   echo "<script> swal.fire('','Aadhaar already registered with Bank, Kindly visit nearest Branch'); loader_stop(); enable('sbt'); </script>";
// }
// else
if(!isset($_POST['ekycNum']) || isset($_POST['ekycNum']) == NULL || isset($_POST['ekycNum']) == "") {
    echo "<script> swal.fire('','Enter valid Aadhaar number'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($plain_ekyc_num) || $plain_ekyc_num == false) {
    echo "<script> swal.fire('','Unable to process your request (E01)'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($plain_arn_val) || $plain_arn_val == false) {
    echo "<script> swal.fire('','Unable to process your request (E02)'); loader_stop(); enable('sbt'); </script>";
}   
elseif(!isset($_SESSION['USER_REF_NUM']) || $_SESSION['USER_REF_NUM'] == NULL || $_SESSION['USER_REF_NUM'] == "") {
    echo "<script> swal.fire('','Unable to validate your request (E03)'); loader_stop(); enable('sbt'); </script>";
}	
elseif($plain_arn_val != $_SESSION['USER_REF_NUM']) {
    echo "<script> swal.fire('','Unable to process your request (E04)'); loader_stop(); enable('sbt'); </script>";
}   
else {

    $updated_flag = true;

    $sql1_exe = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_MOBILE_NUM FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $item_data = $sql1_exe->fetch();

    if(!isset($item_data['SBREQ_APP_NUM']) || $item_data['SBREQ_APP_NUM'] == NULL || $item_data['SBREQ_APP_NUM'] == "") {
        echo "<script> swal.fire('','Unable to validate your request (R02)'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    //Aadhaar OTP Gen.
    $send_data = array();
    $send_data['METHOD_NAME'] = "getAadhaarOtp";
    $send_data['AADHAAR_NUMBER'] = $plain_ekyc_num;
    $send_data['CHANNEL_CODE'] = API_REACH_MB_CHANNEL;
    $send_data['USER_AGENT'] = $browser->getBrowser();

    try {
        $apiConn = new ReachMobApi;
       // $output = $apiConn->ReachMobConnect($send_data, "120");
        $output = json_decode('{"errorMessage":"","responseCode":"S","requestId":"73cdbde2-80f7-11e7-8f0c-e7e769f70bd1","successMessage":"OTP sent to registered mobile number"}', true);

	} catch(Exception $e) {  
        error_log($e->getMessage());
        $ErrorMsg = "Please click again!!"; //Error from Class    
    }

    if(!isset($ErrorMsg) || $ErrorMsg == "") {
        if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
            $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
        }
    }

    if(isset($ErrorMsg) && $ErrorMsg != "") {
        echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    $requestid= $output['requestId'];

    // Success
    echo "<script>";
    
    $arnNum = $safe->str_encrypt($item_data['SBREQ_APP_NUM'], $_SESSION['SAFE_KEY']);
    echo " $('#arnVal2').val(deStr('".$main_app->strsafe_modal($arnNum)."')); ";

    $reqId = $safe->str_encrypt($requestid, $_SESSION['SAFE_KEY']);
    echo " $('#reqid').val(deStr('".$main_app->strsafe_modal($reqId)."')); ";

    $enc_ekycnum = $safe->str_encrypt($plain_ekyc_num, $_SESSION['SAFE_KEY']);
    echo " $('#ekycNum2').val(deStr('".$main_app->strsafe_modal($enc_ekycnum)."')); ";

    echo " $('#tab-nav-2').trigger('click'); loader_stop(); enable('sbt'); ";
    echo "</script>";

}
