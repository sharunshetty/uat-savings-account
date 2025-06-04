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
            'ACCOUNT_TYPE_PROD' => (isset($_POST['field_val'])) ? $main_app->strsafe_input($_POST['field_val']) : "",
        );

        $sql_exe = $main_app->sql_run("SELECT * FROM {$page_table_name} WHERE ACCOUNT_TYPE_PROD = :ACCOUNT_TYPE_PROD", $page_primary_keys);
        $item_data = $sql_exe->fetch();

        if(isset($item_data['ACCOUNT_TYPE_PROD']) && $item_data['ACCOUNT_TYPE_PROD'] != NULL) {

            //Update Value
    	    $html_op .= "$('#ACCOUNT_TYPE').val('".$main_app->strsafe_output($item_data['ACCOUNT_TYPE_DESC'])."');";
        
        } 
        
    }

    //Print
    echo "<script> {$html_op} </script>";
}

?>