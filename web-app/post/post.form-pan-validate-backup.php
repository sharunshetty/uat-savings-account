<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

if(isset($_POST['arnVal']) && $_POST['arnVal'] != "") {
    $plain_arn_val = $safe->str_decrypt($_POST['arnVal'], $_SESSION['SAFE_KEY']);
}

if(isset($_POST['panNum']) && $_POST['panNum'] != "") {
    $safe = new Encryption();
    $plain_panNum = $safe->rsa_decrypt($_POST['panNum']);
}

$name_flag = "N";

$sql_exe = $main_app->sql_run("select * from cbuat2.piddocs p where p.piddocs_pid_type='PAN' and p.piddocs_docid_num=:PAN_NUMBER", array('PAN_NUMBER' => $plain_panNum));
$itemdata = $sql_exe->fetch();

//validation
if(isset($itemdata) && $itemdata != "" || $itemdata != NULL) {
    echo "<script> swal.fire('','PAN already registered with Bank, Kindly visit nearest Branch'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['panNum']) || isset($_POST['panNum']) == NULL || isset($_POST['panNum']) == "") {
    echo "<script> swal.fire('','Enter valid PAN Card Number'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($plain_panNum) || $plain_panNum == false) {
    echo "<script> swal.fire('','Unable to process your request (E01)'); loader_stop(); enable('sbt'); </script>";
}
elseif($main_app->valid_pancard($plain_panNum) == false) {
    echo "<script> swal.fire('','Invalid PAN format'); loader_stop(); enable('sbt'); focus('panNum'); </script>";
}
elseif(!isset($plain_arn_val) || $plain_arn_val == false) {
    echo "<script> swal.fire('','Unable to process your request (E02)'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['PanAgree']) || $_POST['PanAgree'] != "1") {
    echo "<script> swal.fire('','Please click on radio button checkbox to proceed'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_SESSION['USER_REF_NUM']) || $_SESSION['USER_REF_NUM'] == NULL || $_SESSION['USER_REF_NUM'] == "") {
    echo "<script> swal.fire('','Unable to validate your request (E05)'); loader_stop(); enable('sbt'); </script>";
}
elseif($plain_arn_val != $_SESSION['USER_REF_NUM']) {
    echo "<script> swal.fire('','Unable to process your request (E06)'); loader_stop(); enable('sbt'); </script>";
}
else {

    $updated_flag = true;

    $sql1_exe = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_MOBILE_NUM, SBREQ_CUST_NAME FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $item_data = $sql1_exe->fetch();

    if(!isset($item_data['SBREQ_APP_NUM']) || $item_data['SBREQ_APP_NUM'] == NULL || $item_data['SBREQ_APP_NUM'] == "") {
        echo "<script> swal.fire('','Unable to validate your request (R01)'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    //Check if pan is linked with aadhaar
    $send_data['METHOD_NAME'] = "linkedPanStatus";
    $send_data['PAN_NUMBER'] = $plain_panNum;

    try {
        $apiConn = new ReachMobApi;
        //$output = $apiConn->ReachMobConnect($send_data, "120");
        $output = json_decode('{"MESSAGE":"PAN is linked with Adhaar","responseCode":"S"}', true);
    } 
     catch(Exception $e) {
        $ErrorMsg = $e->getMessage(); //Error from Class
    }

    if(!isset($ErrorMsg) || $ErrorMsg == "") {
        if(!isset($output['responseCode']) || $output['responseCode'] != "S") {

            $ErrorMsg = isset($output['MESSAGE']) ? $output['MESSAGE'] : "Unexpected API Error";
        }
    }

    if(isset($ErrorMsg) && $ErrorMsg != "") {
        echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    //PAN Verify
    $send_data = array();
    $send_data['METHOD_NAME'] = "validatePan";
    $send_data['PAN_NUMBER'] = $plain_panNum;
    $send_data['CHANNEL_CODE'] = API_REACH_MB_CHANNEL;
    $send_data['USER_AGENT'] = $browser->getBrowser();

    try {
        $apiConn = new ReachMobApi;
        //$output = $apiConn->ReachMobConnect($send_data, "120");
        $output = json_decode('{"errorMessage":"","responseCode":"S","lastName":"PRAVEEN","firstName":"","midName":""}', true);

      } catch(Exception $e) {
       error_log($e->getMessage());
       $ErrorMsg = "Please try again!!"; //Error from Class    
    }

    if(!isset($ErrorMsg) || $ErrorMsg == "") {
        if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
           $ErrorMsg = isset($output['errorMessage']) ? "PAN ".$output['errorMessage'] : "Unexpected API Error (E01)";
        }
    }

    if(isset($ErrorMsg) && $ErrorMsg != "") {
        echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    $data2 = array();
    $data2['SBREQ_PAN_FLAG'] = "Y";
    $data2['SBREQ_PAN_CARD'] = $safe->str_encrypt($plain_panNum, $item_data['SBREQ_APP_NUM']);;
    $db_output2 = $main_app->sql_update_data("SBREQ_MASTER", $data2, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
    if($db_output2 == false) { $updated_flag = false; }

    if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to update PAN details'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    $doc_sl = $main_app->sql_fetchcolumn("SELECT NVL(MAX(DOC_SL), 0) + 1 FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'PAN' ", array("SBREQ_APP_NUM" => $item_data['SBREQ_APP_NUM'])); // Seq. No.
    
    if($doc_sl == false || $doc_sl == NULL || $doc_sl == "" || $doc_sl == "0") {
        echo "<script> swal.fire('','Unable to generate detail serial'); loader_stop(); enable('sbt2'); </script>";
        exit();
    }

    // Save PAN Record
    $data = array();
    $data['SBREQ_APP_NUM'] = $item_data['SBREQ_APP_NUM'];
    $data['DOC_CODE'] = 'PAN';
    $data['DOC_SL'] = $doc_sl;
    $data['DOC_DATA'] = json_encode($output, true);
    $data['CR_BY'] = isset($_SESSION['OTP_REQ_ID']) ? $_SESSION['OTP_REQ_ID'] : NULL;
    $data['CR_ON'] = date("Y-m-d H:i:s");

    $db_output = $main_app->sql_insert_data("SBREQ_EKYC_DOCS", $data); // Insert
    if($db_output == false) { $updated_flag = false; }

    if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to update PAN details'); loader_stop(); enable('sbt2'); </script>";
        exit();
    }

    $sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM']));
    $kycDetails = $sql_exe3->fetch();

    if(isset($kycDetails['DOC_DATA']) && $kycDetails['DOC_DATA'] != "") {
      $kycDetails = json_decode(stream_get_contents($kycDetails['DOC_DATA']), true, JSON_UNESCAPED_SLASHES); 
    }

    $pan_firstname = $output['firstName'];

    //combine pan name
    $fullname = "";

    $fullname .= (isset($output['firstName']) && $output['firstName'] != "") ? trim($output['firstName']) : "";
    $fullname .= (isset($output['midName']) && $output['midName'] != "") ? " ". $output['midName'] : "";
    $fullname .= (isset($output['lastName']) && $output['lastName'] != "") ? " ". $output['lastName'] : "";

    $cust_name = explode(' ', $item_data['SBREQ_CUST_NAME']);
    $custname1 = $cust_name[0];
    
   //convert name to uppercase
    $aadhaar_name = strtoupper($kycDetails['name']);
    $pan_full_name = strtoupper(trim($fullname));
    $pan_custname1 = strtoupper($pan_firstname);

   if($aadhaar_name != $pan_full_name) {
        echo "<script> swal.fire('', 'Aadhaar Name and Pan Name does not match'); loader_stop(); enable('sbt'); </script>";
    } 
    elseif($aadhaar_name != $item_data['SBREQ_CUST_NAME']) {
        echo "<script> swal.fire('', 'Registered Customer name and Name on UID does not match');loader_stop(); enable('sbt'); </script>";
        $main_app->session_set([ 'name_flag' =>  "Y"]);
        // Success
        $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
        echo "<script> goto_url('form-branch-details'); </script>"; // Done

    }
    elseif($pan_custname1 != $custname1) {
        
	echo "<script> swal.fire('', 'Registered Customer name and name on PAN Card does not match'); loader_stop(); enable('sbt'); </script>";
        $main_app->session_set(['name_flag' =>  "Y"]);
        // Success
        $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
        echo "<script> goto_url('form-branch-details'); </script>"; // Done
        
    } else {

        // Success
        $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
        echo "<script> goto_url('form-branch-details'); </script>"; // Done

    }
}
