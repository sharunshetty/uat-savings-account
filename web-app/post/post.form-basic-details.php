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


//get aadhaar data
$sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM']));
$kycDetails = $sql_exe3->fetch();

//decode aadhaar data
if(isset($kycDetails['DOC_DATA']) && $kycDetails['DOC_DATA'] != "") {
$kycDetails = json_decode(stream_get_contents($kycDetails['DOC_DATA']), true, JSON_UNESCAPED_SLASHES); 
}

//make name to uppercase
if(isset($kycDetails['name']) && $kycDetails['name'] != "") {
    $aadhaar_name = strtoupper($kycDetails['name']);
}

//validation for customer name
if(isset($_POST['CUST_FULL_NAME']) && $_POST['CUST_FULL_NAME'] != "" && ($_POST['CUST_FULL_NAME'] != $aadhaar_name)) {
   echo "<script> swal.fire('','Registered name and name in PIDs does not match! please update Registered Name'); loader_stop(); enable('sbt'); </script>";
} 
elseif(!isset($_POST['PLACE_OF_BIRTH']) || $_POST['PLACE_OF_BIRTH'] == NULL || $_POST['PLACE_OF_BIRTH'] == "") {
    echo "<script> swal.fire('','Please select place of birth'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['OCCUPATION']) || $_POST['OCCUPATION'] == NULL || $_POST['OCCUPATION'] == "") {
    echo "<script> swal.fire('','Please select occupation'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['ANNUAL_INCOME']) || $_POST['ANNUAL_INCOME'] == NULL || $_POST['ANNUAL_INCOME'] == "") {
    echo "<script> swal.fire('','Please select Annual Income'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_SESSION['USER_REF_NUM']) || $_SESSION['USER_REF_NUM'] == NULL || $_SESSION['USER_REF_NUM'] == "") {
    echo "<script> swal.fire('','Unable to validate your request (E03)'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['FATHERS_NAME']) || $_POST['FATHERS_NAME'] == NULL || $_POST['FATHERS_NAME'] == "") {
    echo "<script> swal.fire('','Please enter Fathers Name'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['MOTHERS_NAME']) || $_POST['MOTHERS_NAME'] == NULL || $_POST['MOTHERS_NAME'] == "") {
    echo "<script> swal.fire('','Please enter Mothers Name'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['DOB']) || $_POST['DOB'] == NULL || $_POST['DOB'] == "") {
    echo "<script> swal.fire('','Invalid date of birth'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['MARITAL_STATUS']) || $_POST['MARITAL_STATUS'] == NULL || $_POST['MARITAL_STATUS'] == "") {
    echo "<script> swal.fire('','Please select Marital Status'); loader_stop(); enable('sbt'); </script>";
}
elseif((isset($_POST['MARITAL_STATUS']) && $_POST['MARITAL_STATUS'] == "2") && (!isset($_POST['SPOUSE_NAME']) || $_POST['SPOUSE_NAME'] == NULL || $_POST['SPOUSE_NAME'] == "")) {
    echo "<script> swal.fire('','Please enter Spouse Name'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['QUALIFICATION']) || $_POST['QUALIFICATION'] == NULL || $_POST['QUALIFICATION'] == "") {
    echo "<script> swal.fire('','Please enter qualification'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['DBT_BENEFICIARY']) || $_POST['DBT_BENEFICIARY'] == NULL || $_POST['DBT_BENEFICIARY'] == "") {
    echo "<script> swal.fire('','Please select DBT Beneficiary'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($plain_arn_val) || $plain_arn_val == false) {
    echo "<script> swal.fire('','Unable to process your request (E02)'); loader_stop(); enable('sbt'); </script>";
}
elseif($plain_arn_val != $_SESSION['USER_REF_NUM']) {
    echo "<script> swal.fire('','Unable to process your request (E04)'); loader_stop(); enable('sbt'); </script>";
}
elseif((isset($_POST['MARITAL_STATUS']) && $_POST['MARITAL_STATUS'] == "2") && (!isset($_POST['SPOUSE_NAME']) || $_POST['SPOUSE_NAME'] == NULL || $_POST['SPOUSE_NAME'] == "")) {
    echo "<script> swal.fire('','Please enter Spouse Name'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['FATHERS_NAME']) || $_POST['FATHERS_NAME'] == NULL || $_POST['FATHERS_NAME'] == "") {
    echo "<script> swal.fire('','Invalid Fathers Name'); loader_stop(); enable('sbt'); </script>";
}
else {

    $updated_flag = true;

    $sql1_exe = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $item_data = $sql1_exe->fetch();

    if(!isset($item_data['SBREQ_APP_NUM']) || $item_data['SBREQ_APP_NUM'] == NULL || $item_data['SBREQ_APP_NUM'] == "") {
        echo "<script> swal.fire('','Unable to validate your request (R01)'); loader_stop(); enable('sbt2'); </script>";
        exit();
    }

    $data2 = array();
    $data2['SBREQ_BASIC_DETAIL_FLG'] = "Y";
    $data2['SBREQ_CUST_NAME'] = isset($_POST['CUST_FULL_NAME']) ? $_POST['CUST_FULL_NAME'] : $item_data['SBREQ_CUST_NAME'];
    $db_output2 = $main_app->sql_update_data("SBREQ_MASTER", $data2, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
    if($db_output2 == false) { $updated_flag = false; }
    
    $data = array();
    $data['SBREQ_TITLE_CODE'] = $item_data['SBREQ_CUST_TITLE'];
    $data['SBREQ_RELIGION_CODE'] = "";
    $data['SBREQ_PLACE_OF_BIRTH'] = $_POST['PLACE_OF_BIRTH'];
    $data['SBREQ_LANGUAGE_CODE'] = "";
    $data['SBREQ_OCCUPATION_CODE'] = $_POST['OCCUPATION'];
    $data['SBREQ_COMPANY_CODE'] = "";
    $data['SBREQ_DESIGNATION_CODE'] = "";
    $data['SBREQ_ANNUAL_INCOME'] = $_POST['ANNUAL_INCOME'];
    $data['SBREQ_TYPEOF_ACCOMODATION'] = "";
    $data['SBREQ_INUSURANCE_INFO'] = "";
    $data['SBREQ_FATHERSNAME'] = $_POST['FATHERS_NAME']; 
    $data['SBREQ_MOTHERSNAME'] = $_POST['MOTHERS_NAME']; 
    $data['SBREQ_DOB'] = ""; 
    $data['SBREQ_MARITAL_STATUS'] = $_POST['MARITAL_STATUS']; 
    $data['SBREQ_RELATIVENAME'] = isset($_POST['RELATIVE_NAME']) ? $_POST['RELATIVE_NAME'] : NULL;
    $data['SBREQ_SPOUSE_NAME'] = isset($_POST['SPOUSE_NAME']) ? $_POST['SPOUSE_NAME'] : NULL;  
    $data['SBREQ_QUALIFICATION'] = $_POST['QUALIFICATION']; 
    $data['SBREQ_DBTCHECK'] = $_POST['DBT_BENEFICIARY']; 
    $data['MO_BY'] = isset($_SESSION['OTP_REQ_ID']) ? $_SESSION['OTP_REQ_ID'] : NULL;
    $data['MO_ON'] = date("Y-m-d H:i:s");
    
    $db_output = $main_app->sql_update_data("SBREQ_ACCOUNTDATA", $data, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
    if($db_output == false) { $updated_flag = false; }

    if($updated_flag == false) {
       echo "<script> swal.fire('','Unable to process your request.)'); loader_stop(); enable('sbt'); </script>";
       exit();
    }

    // Success
    $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
    echo "<script> goto_url('form-nominee-details'); </script>"; // Done


}
