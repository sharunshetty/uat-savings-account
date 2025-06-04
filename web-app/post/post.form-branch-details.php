
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

//validation
if(!isset($_POST['STATE']) || $_POST['STATE'] == NULL || $_POST['STATE'] == "") {
    echo "<script> swal.fire('','Please select state'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['DISTRICT_CODE']) || $_POST['DISTRICT_CODE'] == NULL || $_POST['DISTRICT_CODE'] == "") {
    echo "<script> swal.fire('','Please select City'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['BRANCH_CODE']) || $_POST['BRANCH_CODE'] == NULL || $_POST['BRANCH_CODE'] == "") {
    echo "<script> swal.fire('','Please select branch'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['PRODUCT_CODE']) || $_POST['PRODUCT_CODE'] == NULL || $_POST['PRODUCT_CODE'] == "") {
    echo "<script> focus('PRODUCT_CODE'); swal.fire('','Please select Product Code'); loader_stop(''); enable('sbt'); </script>";
}
elseif(!isset($_SESSION['USER_REF_NUM']) || $_SESSION['USER_REF_NUM'] == NULL || $_SESSION['USER_REF_NUM'] == "") {
    echo "<script> swal.fire('','Unable to validate your request (E03)'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($plain_arn_val) || $plain_arn_val == false) {
    echo "<script> swal.fire('','Unable to process your request (E02)'); loader_stop(); enable('sbt'); </script>";
}
elseif($plain_arn_val != $_SESSION['USER_REF_NUM']) {
    echo "<script> swal.fire('','Unable to process your request (E04)'); loader_stop(); enable('sbt'); </script>";
}
else {

    $updated_flag = true;

    $sql1_exe = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $item_data = $sql1_exe->fetch();

    if(!isset($item_data['SBREQ_APP_NUM']) || $item_data['SBREQ_APP_NUM'] == NULL || $item_data['SBREQ_APP_NUM'] == "") {
        echo "<script> swal.fire('','Unable to validate your request (R01)'); loader_stop(); enable('sbt2'); </script>";
        exit();
    }

    $sql1_exe = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $item_data = $sql1_exe->fetch();

    $data2 = array();
    $data2['SBREQ_BRANCH_FLAG'] = "Y";
    $db_output2 = $main_app->sql_update_data("SBREQ_MASTER", $data2, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
    if($db_output2 == false) { $updated_flag = false; }
    $data = array();
    $data['SBREQ_APP_NUM'] = $item_data['SBREQ_APP_NUM'];
    $data['SBREQ_PRODUCT_CODE'] = $_POST['PRODUCT_CODE'];
    $data['SBREQ_BRANCH_CODE'] = $_POST['BRANCH_CODE'];
    $data['SBREQ_STATE_CODE'] = $_POST['STATE']; 
    $data['SBREQ_CITY_CODE'] = $_POST['DISTRICT_CODE'];  
    $data['CR_BY'] = isset($_SESSION['OTP_REQ_ID']) ? $_SESSION['OTP_REQ_ID'] : NULL;
    $data['CR_ON'] = date("Y-m-d H:i:s");
    
    $db_output = $main_app->sql_insert_data("SBREQ_ACCOUNTDATA",$data); // Insert
    if($db_output == false) { $updated_flag = false; }

    if($updated_flag == false) {
       echo "<script> swal.fire('','Unable to process your request.)'); loader_stop(); enable('sbt'); </script>";
       exit();
    }
    // Success
    $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
    echo "<script> goto_url('form-basic-details'); </script>"; // Done
}
