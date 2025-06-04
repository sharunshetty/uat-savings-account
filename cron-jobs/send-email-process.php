<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../app-core/app_auto_load.php');

// Cron Job : Send EMAIL from Queue

ini_set('max_execution_time', 1500); // Max. Run 25min
$txn_chk_date = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -30 minutes")); // 30min ago time

if( !defined('EMAIL_ENABLE') || EMAIL_ENABLE != "YES") {
    exit('EMAIL service not enabled in settings.');
}

echo "Send Email Process \n";

// Include Email Class
require_once( DIRPATH . '/class/class_mod_mail.php'); // PHPMailer Class
// require_once( DIRPATH . '../app-core/class/class_mod_mail.php'); // PHPMailer Class


/* Get Pending Transaction */
$sql_exe = $main_app->sql_run("SELECT * FROM SEND_ALERT_QUEUE WHERE ALERT_TYPE = 'EMAIL' AND PROCESS_LOCK_FLG = 'P' ORDER BY ALERT_PRIORITY DESC LIMIT 50");
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
    exit('No records for process \n');
}

$sql_exe2 = $main_app->sql_run("UPDATE SEND_ALERT_QUEUE SET PROCESS_LOCK_FLG = 'E' WHERE ALERT_TYPE = 'EMAIL' AND ALERT_REQ_ID IN ('".implode("','", $ReqList)."')");
if($sql_exe2 == false) {
    exit('Unable to update lock \n');
}

foreach($pendingData as $record) {
    if(isset($record['ALERT_REQ_ID']) && $record['ALERT_REQ_ID'] != NULL) {
        
        //Pick SMS Record
        $sql_exe = $main_app->sql_run("SELECT ALERT_REQ_ID, ALERT_TYPE, ALERT_TO_ADD, ALERT_SUBJECT, ALERT_BODY, ALERT_TPL_CODE, ALERT_TXN_ID FROM SEND_ALERT WHERE ALERT_REQ_ID = :ALERT_REQ_ID", array( 'ALERT_REQ_ID' => $record['ALERT_REQ_ID'] ));
        $item_data = $sql_exe->fetch();

        if(isset($item_data['ALERT_REQ_ID']) && $item_data['ALERT_REQ_ID'] != NULL && $item_data['ALERT_TYPE'] == "EMAIL") {
            
            if(isset($item_data['ALERT_TO_ADD']) && $item_data['ALERT_TO_ADD'] != NULL && $item_data['ALERT_TO_ADD'] != "") {

                //Email
                try {
                    $mail = new PHPMailer();
                    $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ));
                    $mail->IsHTML(true);
                    $mail->IsSMTP();
                    $mail->SMTPAuth = EMAIL_AUTH_REQ; // true, false
                    $mail->SMTPSecure = EMAIL_SECURE; // ssl, tls
                    $mail->Host = EMAIL_HOST;
                    $mail->Port = EMAIL_PORT;
                    $mail->Username = EMAIL_USERNAME;
                    $mail->Password = EMAIL_PASSWORD;
                    $mail->From = EMAIL_FROM;
                    $mail->FromName = EMAIL_FROM_NAME;
                    $mail->Subject = isset($item_data['ALERT_SUBJECT']) ? $item_data['ALERT_SUBJECT'] : "";
                    $mail->Body = isset($item_data['ALERT_BODY']) ? $item_data['ALERT_BODY'] : "";
                    $mail->AddAddress($item_data['ALERT_TO_ADD']);
                    //$mail->set('X-Priority','1'); // Priority 1 = High, 3 = Normal, 5 = Low
                    $result = $mail->Send();

                    $data = array();
                    $data['ALERT_SENT_LOG'] = ($result == false) ? substr($mail->ErrorInfo, 0, 250) : substr($result, 0, 250);
                    $data['MO_ON'] = date("Y-m-d H:i:s");
                    $db_output = $main_app->sql_update_data("SEND_ALERT",$data, array("ALERT_REQ_ID" => $item_data['ALERT_REQ_ID'] )); // Update
        
                    //Delete Send Record from Queue
                    $main_app->sql_delete_data("SEND_ALERT_QUEUE", array("ALERT_REQ_ID" => $item_data['ALERT_REQ_ID'] ));        

                } catch(Exception $e) {
                    echo "Failed \n"; 
                }

            }

        } else {
            echo "Fail \n"; 
        }

    }
}