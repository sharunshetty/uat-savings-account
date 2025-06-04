<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

$page_table_name = "SBREQ_MASTER";

if(isset($_POST['arnVal']) && $_POST['arnVal'] != "") {
    $arnVal = $safe->str_decrypt($_POST['arnVal'], $_SESSION['SAFE_KEY']); 
    if($arnVal) {
        $sql_exe = $main_app->sql_run("SELECT SBREQ_APP_NUM FROM $page_table_name WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ", array('SBREQ_APP_NUM' =>  $arnVal));
        $item_data = $sql_exe->fetch();
    }
}

if(!isset($_POST['arnVal']) || $_POST['arnVal'] == NULL || $_POST['arnVal'] == "") {
    echo "<script> swal.fire('','Invalid request'); loader_stop(); enable(); </script>";
}
elseif(!isset($item_data['SBREQ_APP_NUM']) || $item_data['SBREQ_APP_NUM'] == NULL) {
    echo "<script> swal.fire('','Invalid request'); loader_stop(); enable(); </script>";

}elseif($arnVal != $_SESSION['USER_REF_NUM']) {
    echo "<script> swal.fire('','Unable to process your request'); loader_stop(); enable('sbt'); </script>";
}
else{

    $updated_flag = true;
	
   $VKYC_REF_NUM = $main_app->sql_fetchcolumn("SELECT VKYC_REF_NUM FROM VKYC_REQUESTS WHERE EXTERNAL_INWARD_NUM = :EXTERNAL_INWARD_NUM ORDER BY CR_ON DESC", array('EXTERNAL_INWARD_NUM' =>  $arnVal));

    if(isset($VKYC_REF_NUM) && $VKYC_REF_NUM != "") {
          
        $data2 = array();
        $data2['VKYC_BRANCH_VISIT_STATUS'] = 'Y';
        $db_output = $main_app->sql_update_data("VKYC_REQUESTS", $data2, array( 'VKYC_REF_NUM' => $VKYC_REF_NUM )); // Update
        if($db_output == false) { $updated_flag = false; }

    }

    $data = array();
    $data['SBREQ_VKYC_STATUS'] = "B";
    $data['VKYC_REF_NUM'] = isset($VKYC_REF_NUM) ? $VKYC_REF_NUM : "";
    $db_output = $main_app->sql_update_data("SBREQ_MASTER", $data, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
    if($db_output == false) { $updated_flag = false; }

    if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to update VKYC details'); loader_stop(); enable(); </script>";
        exit();
    }else{
        echo "<script> goto_url('form-branch-message'); </script>"; // Done
    }

   
}

?>