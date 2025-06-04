<?php

/**
 * @copyright   : (c) 2020 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();
$html_op = "";

/** On Change */
if($_POST['cmd2'] == "onChange" && isset($_POST['field_name']) && isset($_POST['field_val']) && isset($_POST['dest_id'])) {

    if($_POST['field_name'] == "modify" && $_POST['field_val'] != "") {

        //Modify
        $page_table_name = "SBREQ_ACCOUNT_TYPE";
        $page_primary_keys = array(
            'ZONE_SOL_ID' => (isset($_POST['field_val'])) ? $main_app->strsafe_input($_POST['field_val']) : "",
        );

        $sql_exe = $main_app->sql_run("SELECT * FROM {$page_table_name} WHERE ZONE_SOL_ID = :ZONE_SOL_ID", $page_primary_keys);
        $item_data = $sql_exe->fetch();

        if(isset($item_data['ZONE_SOL_ID']) && $item_data['ZONE_SOL_ID'] != NULL) {

            //Update Value
    	    $html_op .= "$('#ZONE_DESC').val(decode_ajax('".$main_app->strsafe_ajax($item_data['ZONE_DESC'])."'));";
            $html_op .= "$('#ZONE_PC_SOL_ID').val(decode_ajax('".$main_app->strsafe_ajax($item_data['ZONE_PC_SOL_ID'])."'));";
            $html_op .= "$('#ZONE_STATUS').val(decode_ajax('".$main_app->strsafe_ajax($item_data['ZONE_STATUS'])."'));";
        
        } 
        
    }

    //Print
    echo "<script> {$html_op} </script>";

}

?>