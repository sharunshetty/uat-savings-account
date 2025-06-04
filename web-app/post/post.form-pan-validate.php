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

function updatePanDetails($panNum, $app_num, $outputresp, $pan_full_name) {

    global $main_app, $safe;

    $updated_flag = true;
    
    $data2 = array();
    $data2['SBREQ_PAN_FLAG'] = "Y";
    $data2['SBREQ_PAN_CARD'] = $safe->str_encrypt($panNum, $app_num);
    $data2['SBREQ_PAN_NAME'] = $pan_full_name;
    $db_output2 = $main_app->sql_update_data("SBREQ_MASTER", $data2, array( 'SBREQ_APP_NUM' => $app_num )); // Update
    if($db_output2 == false) { $updated_flag = false; }

    if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to update PAN details'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    $doc_sl = $main_app->sql_fetchcolumn("SELECT NVL(MAX(DOC_SL), 0) + 1 FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'PAN' ", array("SBREQ_APP_NUM" => $app_num)); // Seq. No.

    if($doc_sl == false || $doc_sl == NULL || $doc_sl == "" || $doc_sl == "0") {
        echo "<script> swal.fire('','Unable to generate detail serial'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    // Save PAN Record
    $data = array();
    $data['SBREQ_APP_NUM'] = $app_num;
    $data['DOC_CODE'] = 'PAN';
    $data['DOC_SL'] = $doc_sl;
    $data['DOC_DATA'] = json_encode($outputresp, true);
    $data['CR_BY'] = isset($_SESSION['OTP_REQ_ID']) ? $_SESSION['OTP_REQ_ID'] : NULL;
    $data['CR_ON'] = date("Y-m-d H:i:s");

    $db_output = $main_app->sql_insert_data("SBREQ_EKYC_DOCS", $data); // Insert
    if($db_output == false) { $updated_flag = false; }

    if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to update PAN details'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

}

$name_flag = "N";

//validate if pan number is present in CBS using db link query
// $sql_exe = $main_app->sql_run("select * from cbuat.piddocs p where p.piddocs_pid_type='PAN' and p.piddocs_docid_num=:PAN_NUMBER", array('PAN_NUMBER' => $plain_panNum));
// $itemdata = $sql_exe->fetch();

// //validation
// if(isset($itemdata) && $itemdata != "" || $itemdata != NULL) {
//     echo "<script> swal.fire('','PAN already registered with Bank, Kindly visit nearest Branch'); loader_stop(); enable('sbt'); </script>";
// }
if(!isset($_POST['panNum']) || isset($_POST['panNum']) == NULL || isset($_POST['panNum']) == "") {
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
elseif(!isset($_POST['fullname']) || isset($_POST['fullname']) == NULL || isset($_POST['fullname']) == "") {
    echo "<script> swal.fire('','Enter valid Name'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['fathername']) || isset($_POST['fathername']) == NULL || isset($_POST['fathername']) == "") {
    echo "<script> swal.fire('','Enter valid fathers name'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['dateofbirth']) || isset($_POST['dateofbirth']) == NULL || isset($_POST['dateofbirth']) == "") {
    echo "<script> swal.fire('','Please select valid date of birth'); loader_stop(); enable('sbt'); </script>";
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

     /* date of birth for pan validation */
    if(isset($_POST['dateofbirth']) && $_POST['dateofbirth'] != "") {
        $date_of_birth = date('d/m/Y', strtotime($_POST['dateofbirth']));
        $con_dob = str_replace('-', '/', $date_of_birth);
    }

    //Check if pan is linked with aadhaar
    $send_data['METHOD_NAME'] = "linkedPanStatus";
    $send_data['PAN_NUMBER'] = $plain_panNum;

    try {
        $apiConn = new ReachMobApi;
       // $output = $apiConn->ReachMobConnect($send_data, "120");
        // Test Data
        $output = json_decode('{"MESSAGE":"PAN is linked with Adhaar","responseCode":"S"}', true);

    } catch(Exception $e) {
        $ErrorMsg = $e->getMessage(); //Error from Class
    }

    if(!isset($ErrorMsg) || $ErrorMsg == "") {
        if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
            //var_dump($output);
            $ErrorMsg = isset($output['errorMessage']) ? $output['errorMessage'] : "Unexpected API Error";
        }
    }

    if(isset($ErrorMsg) && $ErrorMsg != "") {
        echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop(); enable('sbt'); </script>";
        exit();
    }


    
    $pan_data = array(array('PAN_NUMBER' => $plain_panNum, 'NAME' => $_POST['fullname'], 'FATHER_NAME' => $_POST['fathername'], 'DATE_OF_BIRTH' => $con_dob));

    //json array of pan data_list
    $pan_data_array = json_encode($pan_data, JSON_UNESCAPED_SLASHES);

    //PAN Verify
    $send_data = array();
    $send_data['METHOD_NAME'] = "validatePan";
    /*$send_data['PAN_LIST'] = $pan_data_array;*/
    $send_data['PAN_NUMBER'] = $plain_panNum;
    $send_data['CHANNEL_CODE'] = API_REACH_MB_CHANNEL;
    $send_data['USER_AGENT'] = $browser->getBrowser();

    try {
        $apiConn = new ReachMobApi;
        //$output = $apiConn->ReachMobConnect($send_data, "120");
        // Test Data
        // $output = json_decode('{"lastName":"ABHISHEK","firstName":"","lastUpdateOn":"12\/10\/2017"","midName":"","panTitle":"Kumari","responseCode":"S"}', true);
         $output = json_decode('{"errorMessage":"","responseCode":"S","lastName":"YADAV","firstName":"NAVEEN","midName":"KUMAR"}', true);
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


    $sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM']));
    $kycDetails = $sql_exe3->fetch();

    if(isset($kycDetails['DOC_DATA']) && $kycDetails['DOC_DATA'] != "") {
    $kycDetails = json_decode(stream_get_contents($kycDetails['DOC_DATA']), true, JSON_UNESCAPED_SLASHES); 
    }

    $pan_firstname = $output['firstName'];

    //combine pan name
    $fullname = "";

    $fullname .= (isset($output['firstName']) && $output['firstName'] != "") ? trim($output['firstName']) : "";
    $fullname .= (isset($output['midName']) && $output['midName'] != "") ? " ". trim($output['midName']) : "";
    $fullname .= (isset($output['lastName']) && $output['lastName'] != "") ? " ". trim($output['lastName']) : "";

    $cust_name = explode(' ', $item_data['SBREQ_CUST_NAME']);
    $custname1 = $cust_name[0];

     //convert name to uppercase
    $aadhaar_name = strtoupper($main_app->strsafe_output($kycDetails['name']));
    $pan_full_name = strtoupper(trim($main_app->strsafe_output($fullname)));
    $pan_custname1 = strtoupper($main_app->strsafe_output($pan_firstname));

    //check if aadhar name is equal to pan name
    if($aadhaar_name !=  $pan_full_name) {
        echo "<script> swal.fire('', 'Aadhaar Name and Pan Name does not match'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    elseif($aadhaar_name != $item_data['SBREQ_CUST_NAME']) {

        updatePanDetails($plain_panNum, $item_data['SBREQ_APP_NUM'], $output, $pan_full_name);

        echo "<script> swal.fire('', 'Registered Customer name and Name on UID does not match');loader_stop(); enable('sbt'); </script>";

        $main_app->session_set([ 'name_flag' =>  "Y"]);
        // Success
        $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
        echo "<script> goto_url('form-branch-details'); </script>"; // Done

    }
    elseif($pan_custname1 != $custname1) {

        updatePanDetails($plain_panNum, $item_data['SBREQ_APP_NUM'], $output, $pan_full_name);

        echo "<script> swal.fire('', 'Registered Customer name and name on PAN Card does not match'); loader_stop(); enable('sbt'); </script>";
        $main_app->session_set(['name_flag' =>  "Y"]);

        // Success
        $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
        echo "<script> goto_url('form-branch-details'); </script>"; // Done
        
    } else {

        updatePanDetails($plain_panNum, $item_data['SBREQ_APP_NUM'], $output, $pan_full_name);

        // Success
        $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
        echo "<script> goto_url('form-branch-details'); </script>"; // Done

    }
}
