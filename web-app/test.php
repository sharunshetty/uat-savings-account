<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../app-core/app_auto_load.php');


//API Test
$send_data = array();

$pid_data = array(array('PAN_NUMBER' => 'AAAPW9785A', 'NAME' => 'VINITA H BHANUSHALI', 'FATHER_NAME' => '', 'DATE_OF_BIRTH' => '09/02/1928'));
var_dump($pid_data);

$pid_data_array = json_encode($pid_data, true);

$send_data['METHOD_NAME'] = "validatePan";
$send_data['PAN_LIST'] = $pid_data_array;

try {
    $apiConn = new ReachMobApi;
    $output = $apiConn->ReachMobConnect($send_data, "40");
} catch(Exception $e) {
    $ErrorMsg = $e->getMessage(); //Error from Class
}

if(!isset($ErrorMsg) || $ErrorMsg == "") {
    if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
        $ErrorMsg = isset($output['errorMessage']) ? $output['errorMessage'] : "Unexpected API Error";
    }
}

if(isset($ErrorMsg) && $ErrorMsg != "") {
    echo "Error: ".$ErrorMsg."\n \n";	
}

echo json_encode($output); 
// echo $output['otpRefNumber'];
//echo $output['responseCode'];