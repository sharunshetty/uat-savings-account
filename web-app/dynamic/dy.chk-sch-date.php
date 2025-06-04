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

    if($_POST['field_name'] == "modify") {

        if($_POST['field_val'] != "") {

            $key = explode('|', $_POST['field_val']);
  
            $send_data = array();
            $send_data['METHOD_NAME'] = "checkScheduledDate";
            $send_data['SCH_DATE'] = $key[0];

            try {
                $apiConn = new ReachMobApi;
                $output = $apiConn->ReachMobConnect($send_data, "60");
            } catch(Exception $e) {
                $ErrorMsg = $e->getMessage(); //Error from Class
            }

            if(!isset($ErrorMsg) || $ErrorMsg == "") {
                if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
                    $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
                }
            }

            if(isset($ErrorMsg) && $ErrorMsg != "") {
                echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop();  </script>";
                exit();
            }

            if(isset($output['responseCode']) || $output['responseCode'] == "S") {

                $send_data = array();
                $send_data['METHOD_NAME'] = "getVKYCDocList";
                $send_data['APPLICATION_NUMBER'] = $key[1];

                try {
                    $apiConn = new ReachMobApi;
                    $output = $apiConn->ReachMobConnect($send_data, "120");
                } catch(Exception $e) {
                    $ErrorMsg = $e->getMessage(); //Error from Class
                }

                if(!isset($ErrorMsg) || $ErrorMsg == "") {
                    if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
                        $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
                    }
                }
    
                if(isset($ErrorMsg) && $ErrorMsg != "") {
                    echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop();  </script>";
                    exit();
                }       
                if(isset($output['timeDetails']) && count($output['timeDetails']) >0) {

                    $html_op .= '<option value="">-- Select --</option>';
                    foreach ($output['timeDetails'] as $outputdata) {
                        if(isset($outputdata['timeSlotCode']) && $outputdata['timeSlotCode'] != NULL) {
                            $html_op .= '<option value="'.$outputdata['timeSlotCode'].'">'. $outputdata['timeSlotName'] . '</option>';
                        }
                    }
                }
                else {
                        $html_op .= '<option value="">-- No Results  --</option>';
                }

            } else {
                echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop();  </script>";

            }

            //Print
            echo "<script> $('#SCH_TIME_SLOT').html('".$main_app->jsescape($html_op)."'); enable('SCH_TIME_SLOT'); </script>";
        
        } else {
            
            $html_op .= '<option value="">-- Select --</option>';

            //Print
            echo "<script> $('#SCH_TIME_SLOT').html('".$main_app->jsescape($html_op)."'); enable('SCH_TIME_SLOT'); </script>";

        }

    }

    

}

?>