<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @package     : Send A-Sync SMS & EMAIL
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

/** SendAlertRequestClass */
class SendAlert {

    // SMS or EMAIL Queue Process
    public static function SendAlertRequest($alertType, $toAddress, $templateCode, $params = null, $priority = "1", $txnId = null) {

        global $main_app;

        if($alertType != "SMS" && $alertType != "EMAIL") {
            throw new Exception('Invalid alert type');
        }

        if($alertType == "SMS" && SMS_ENABLE != "YES") {
            return false;
        }

        if($toAddress == NULL || $toAddress == "") {
            throw new Exception('Invalid alert destination');
        }

        if($templateCode == NULL || $templateCode == "") {
            throw new Exception('Invalid alert template code');
        }

        $sql_exe = $main_app->sql_run("SELECT * FROM APP_SMS_TEMPLATES WHERE SMSTPL_CODE = :SMSTPL_CODE AND SMSTPL_ENABLE = '1'", array( 'SMSTPL_CODE' => $templateCode ));
        $item_data = $sql_exe->fetch();

        if(!isset($item_data['SMSTPL_CODE']) || $item_data['SMSTPL_CODE'] == NULL) {
            throw new Exception('Invalid template');
        }

        if(isset($item_data['SMSTPL_TEXT']) && $item_data['SMSTPL_TEXT'] != "") {

            //Process
            $TemplateTxt = isset($item_data['SMSTPL_TEXT']) ? $item_data['SMSTPL_TEXT'] : "";
            if($params != NULL && is_array($params)) {
                $replaceTxt = is_array($params) ? $params : array($params => $params);
                $TemplateTxt = strtr($TemplateTxt, $replaceTxt);
            }

            $RefId = $main_app->sql_sequence("SEND_ALERT_SEQ","SA"); // Seq. No.

            // Store SMS Req.
            $data = array();
            $data['ALERT_REQ_ID'] = $RefId;
            $data['ALERT_TYPE'] = $alertType;
            $data['ALERT_TO_ADD'] = $toAddress;
            $data['ALERT_SUBJECT'] = isset($item_data['SMSTPL_SUBJECT']) ? $item_data['SMSTPL_SUBJECT'] : NULL;
            $data['ALERT_BODY'] = $TemplateTxt;
            $data['ALERT_TPL_CODE'] = isset($item_data['SMSTPL_CODE']) ? $item_data['SMSTPL_CODE'] : NULL;
            $data['ALERT_PRIORITY'] = isset($priority) ? $priority : "1";
            $data['ALERT_TXN_ID'] = isset($txnId) ? $txnId : NULL;
            $data['CR_ON'] = date("Y-m-d H:i:s");
            $db_output = $main_app->sql_insert_data("SEND_ALERT", $data);

            if($db_output) {
                $data2 = array();
                $data2['ALERT_REQ_ID'] = $RefId;
                $data2['ALERT_TYPE'] = $alertType;
                $data2['ALERT_PRIORITY'] = isset($priority) ? $priority : "1";
                $data2['PROCESS_LOCK_FLG'] = "P";
                $data2['CR_ON'] = date("Y-m-d H:i:s");
                $db_output = $main_app->sql_insert_data("SEND_ALERT_QUEUE", $data2);
            }

        }

    }

}
