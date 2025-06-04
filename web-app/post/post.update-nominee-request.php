<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

 /** Table Settings */
$page_table_name = "SBREQ_ACCOUNTDATA";
$page_subtable_name = "SBREQ_MASTER";
$primary_key = "SBREQ_APP_NUM";

$app_num= $safe->str_decrypt($_POST['arnVal'],$_SESSION['SAFE_KEY']);

$sbreq_app_num = isset($_POST['arnVal']) ? $app_num : ""; // Post ID
$primary_value = $sbreq_app_num; // Don't change

$sql_exe1 = $main_app->sql_run("SELECT * FROM {$page_table_name} WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $primary_value ));
$item_data = $sql_exe1->fetch();

if(!isset($item_data) && $item_data == "") {
    echo "<script> swal.fire('','Unable to validate your request'); loader_stop(); enable('sbt'); </script>";
    exit();    
}

$sql_exe2 = $main_app->sql_run("SELECT * FROM {$page_subtable_name} WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM",array( 'SBREQ_APP_NUM' => $primary_value ));
$item_data1 = $sql_exe2->fetch();

if(!isset($item_data1) && $item_data1 == "") {
    echo "<script> swal.fire('','Unable to validate your Request'); loader_stop(); enable('sbt'); </script>";
    exit();    
}

if(isset($item_data1['SBREQ_EKYC_UID']) && $item_data1['SBREQ_EKYC_UID'] != "") {
    $aadhaarNo = $safe->str_decrypt($item_data1['SBREQ_EKYC_UID'], $item_data1['SBREQ_APP_NUM']);
}

$sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM']));
$ekyc_docsdata = $sql_exe3->fetch();

if(!isset($ekyc_docsdata['DOC_DATA']) && $ekyc_docsdata['DOC_DATA'] == "") {
    echo "<script> swal.fire('','Unable to validate your request.'); loader_stop(); enable('sbt'); </script>";
    exit();    
}

if(isset($ekyc_docsdata['DOC_DATA']) && $ekyc_docsdata['DOC_DATA'] != "") {
     $aadhaardetails = json_decode(stream_get_contents($ekyc_docsdata['DOC_DATA']), true, JSON_UNESCAPED_SLASHES);
}

//implode date of birth for nominee
if(isset($_POST['NOMINEE_DOB']) && $_POST['NOMINEE_DOB'] != ""){
    $birth_date = explode('-', $_POST['NOMINEE_DOB']);
    $dateofbirth = $birth_date[0].''.$birth_date[1].''.$birth_date[2];
}

     //call Nominee API on successful account opening
     $send_data = array();
     $send_data['METHOD_NAME'] = "addNominee"; 
     $send_data['CUSTOMER_CODE'] = "";
     $send_data['CUSTOMER_NAME'] = $item_data['SBREQ_NOMINEE_NAME']; 
     $send_data['DOB'] = isset($dateofbirth) ? $dateofbirth : "";
     $send_data['RELATION_TO_ACC_HOLDER'] = isset($item_data['SBREQ_NOMINEE_RELATION']) ? $item_data['SBREQ_NOMINEE_RELATION'] : ""; 
     $send_data['NOMINEE_ADDRESS'] = isset($item_data['SBREQ_NOMINEE_ADDRESS']) ? $item_data['SBREQ_NOMINEE_ADDRESS'] : ""; 
     $send_data['GUARDIAN_CUST_CODE'] = "";
     $send_data['GUARDIAN_NAME'] = isset($item_data['SBREQ_NOMINEE_GUARDIAN']) ? $item_data['SBREQ_NOMINEE_GUARDIAN'] : "";
     $send_data['NATURE_OF_GUARDIAN'] = isset($item_data['SBREQ_NOMINEE_NATURE']) ? $item_data['SBREQ_NOMINEE_NATURE'] : "";
     $send_data['USER_ID'] = isset($item_data1['CBS_CUST_ID']) ? $item_data1['CBS_CUST_ID'] : "";
     $send_data['ACCOUNT_NUMBER'] = isset($item_data1['CBS_ACC_NUM']) ? $item_data1['CBS_ACC_NUM'] : "";
     $send_data['CLIENT_REF_NUMBER'] = $item_data1['SBREQ_APP_NUM'];

     try {
         $apiConn = new ReachMobApi;
         $output = $apiConn->ReachMobConnect($send_data, "60");
     } catch(Exception $e) {
         error_log($e->getMessage());
         $ErrorMsg = "Technical Error, Please try later"; //Error from Class    
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

     $updated_flag=true;
     $data2 = array();
     $data2['SBREQ_NOMINEE_STATUS'] = $output['responseCode'];
     $db_output2 = $main_app->sql_update_data("SBREQ_MASTER", $data2, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
     if($db_output2 == false) { $updated_flag = false; }

     if($updated_flag == false) {
         echo "<script> swal.fire('','Unable to update Nominee details'); loader_stop(); enable('sbt'); </script>";
         exit();
     }

    //Apply for virtual debit card - API Call
    $send_data['METHOD_NAME'] = "virtualCardReq";
    $send_data['CARD_TYPE'] = "T";
    $send_data['SUB_TYPE'] = "04";
    $send_data['BRANCH_ID'] = "3";
    $send_data['BANK_ID'] = "";
    $send_data['COUNTRY_CODE'] = "91";
    $send_data['EMB_NAME'] = isset($aadhaardetails['name']) ? $aadhaardetails['name'] : "";
    $send_data['LAST_NAME'] = "";
    $send_data['FIRST_NAME'] = "";
    $send_data['MID_NAME'] = "";
    $send_data['MOBILE_NUMBER'] = isset($item_data1['SBREQ_MOBILE_NUM']) ? $item_data1['SBREQ_MOBILE_NUM'] : "";
    $send_data['SMS_ALERT'] = "Y";
    $send_data['DOB'] = "";
    $send_data['PAN_NUM'] = "";
    $send_data['TAN_NUM'] = "";
    $send_data['AADHAAR_NUM'] = isset($aadhaarNo) ? $aadhaarNo : "";
    $send_data['EMAIL_ID'] = isset($item_data1['SBREQ_EMAIL_ID']) ? $item_data1['SBREQ_EMAIL_ID'] : "";
    $send_data['ACC_NUM'] =  isset($item_data1['CBS_ACC_NUM']) ? $item_data1['CBS_ACC_NUM'] : "";
    $send_data['ACC_TYPE'] = "S";
    $send_data['ADDRESS1'] =  isset($aadhaardetails['houseNumber']) ? $aadhaardetails['houseNumber'] : "";
    $send_data['ADDRESS2'] = isset($aadhaardetails['street']) ? $aadhaardetails['street'] : "";
    $send_data['ADDRESS3'] = isset($aadhaardetails['vtcName']) ? $aadhaardetails['vtcName'] : "";
    $send_data['CITY'] = isset($aadhaardetails['district']) ? $aadhaardetails['district'] : "";
    $send_data['STATE'] = isset($aadhaardetails['state']) ? $aadhaardetails['state'] : "";
    $send_data['PIN_CODE'] = "";
    $send_data['CLIENT_REF_NUMBER'] = $item_data1['SBREQ_APP_NUM'];

    try {
        $apiConn = new ReachMobApi;
        $output2 = $apiConn->ReachMobConnect($send_data, "60");
     } catch(Exception $e) {
        error_log($e->getMessage());
        $ErrorMsg = "Technical Error, Please try later"; //Error from Class
    }

    if(!isset($ErrorMsg) || $ErrorMsg == "") {
        if(!isset($output2['responseCode']) || $output2['responseCode'] != "S") {
            $ErrorMsg = isset($output2['errorMessage']) ? "Error: ".$output2['errorMessage'] : "Unexpected API Error";
        }
    }

    if(isset($ErrorMsg) && $ErrorMsg != "") {
        echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    $updated_flag=true;
    $data3 = array();
    $data3['SBREQ_VDC_STATUS'] = $output2['responseCode'];
    $db_output3 = $main_app->sql_update_data("SBREQ_MASTER", $data3, array( 'SBREQ_APP_NUM' => $item_data1['SBREQ_APP_NUM'] )); // Update
    if($db_output3 == false) { $updated_flag = false; }

    if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to update VDC details'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

     $go_url = ""; // Page Refresh URL
     echo "<script> swal.fire({ title:'Details updated successfully', text:'', icon:'success', allowOutsideClick:false, confirmButtonText:'OK' }).then(function (result) { if (result.value) { goto_url('" . $go_url . "'); } }); loader_stop(); enable('sbt'); </script>";
           

?>
