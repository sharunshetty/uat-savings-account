<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../app-core/app_auto_load.php');

// Cron Job : Send SMS from Queue

ini_set('max_execution_time', 1500); // Max. Run 25min
$txn_chk_date = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -30 minutes")); // 30min ago time

echo "Send SMS Process \n";

/* Get Pending Transaction */
$sql_exe = $main_app->sql_run("SELECT * FROM SEND_ALERT_QUEUE WHERE ALERT_TYPE = 'SMS' AND PROCESS_LOCK_FLG = 'Q' ORDER BY ALERT_PRIORITY DESC LIMIT 50");
$pendingData = $sql_exe->fetchAll();

if($pendingData == false || !is_array($pendingData) || count($pendingData) < "1") {
    exit('No records');
}

//Lock Processing
$ReqList = array();
foreach($pendingData as $row) {
    if(isset($row['ALERT_REQ_ID']) && $row['ALERT_REQ_ID'] != NULL) {
        $ReqList[] = $row['ALERT_REQ_ID'];
    }
}

if(!is_array($ReqList) || count($ReqList) < "1") {
    exit('No records for process');
}

$sql_exe2 = $main_app->sql_run("UPDATE SEND_ALERT_QUEUE SET PROCESS_LOCK_FLG = 'E' WHERE ALERT_TYPE = 'SMS' AND ALERT_REQ_ID IN ('".implode("','", $ReqList)."')");
if($sql_exe2 == false) {
    exit('Unable to update lock');
}

foreach($pendingData as $record) {
    if(isset($record['ALERT_REQ_ID']) && $record['ALERT_REQ_ID'] != NULL) {
        
        //Pick SMS Record
        $sql_exe = $main_app->sql_run("SELECT ALERT_REQ_ID, ALERT_TO_ADD, ALERT_BODY FROM SEND_ALERT WHERE ALERT_REQ_ID = :ALERT_REQ_ID", array( 'ALERT_REQ_ID' => $record['ALERT_REQ_ID'] ));
        $item_data = $sql_exe->fetch();

        if(isset($item_data['ALERT_REQ_ID']) && $item_data['ALERT_REQ_ID'] != NULL) {
            //Send SMS
            $result = send_sms($item_data['ALERT_TO_ADD'], $item_data['ALERT_BODY']);

            $data = array();
            $data['ALERT_SENT_LOG'] = ($result == false || $result == NULL) ? "F" : substr($result, 0, 250);
            $data['MO_ON'] = date("Y-m-d H:i:s");
            $db_output = $main_app->sql_update_data("SEND_ALERT",$data, array("ALERT_REQ_ID" => $item_data['ALERT_REQ_ID'] )); // Update

            //Delete Send Record from Queue
            $main_app->sql_delete_data("SEND_ALERT_QUEUE", array("ALERT_REQ_ID" => $item_data['ALERT_REQ_ID'] ));
            
        }

    }
}