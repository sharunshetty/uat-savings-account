<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../../app-core/app_auto_load.php');

function StopProcess() {
    global $main_app;
    $main_app->session_remove(['SECURITY_CODE']);
}

if(isset($_POST['data'])) {
    $_POST['data2'] = base64_decode($_POST['data']);
    $ReqData = ($_POST['data2']) ? json_decode($_POST['data2'], true, JSON_UNESCAPED_SLASHES) : NULL;
    if(is_array($ReqData) && count($ReqData) > "0") {
        foreach($ReqData as $key => $value) {
            if($value != "") {
                $ReqData[$key] = $safe->rsa_decrypt($value);
            }
        }
    }
}

/** Login Form */
if(!isset($_POST['regToken']) || !isset($_POST['data']) || $_POST['data'] == "") {
    echo "R001 : Invalid request";
    exit(StopProcess());
}
elseif(!isset($_SESSION['LOGIN_TOKEN']) || $_SESSION['LOGIN_TOKEN'] == "") {
    echo "R002 : No request token";
    exit(StopProcess());
}
elseif($_POST['regToken'] != $_SESSION['LOGIN_TOKEN']) {
    echo "R003 : Invalid request token";
    exit(StopProcess());
}
elseif(!isset($ReqData) || $ReqData == false) {
    echo "R004 : Invalid data";
    exit(StopProcess());
}
elseif(!is_array($ReqData) || count($ReqData) < "1") {
    echo "R005 : Invalid data values";
    exit(StopProcess());
}
elseif(!isset($ReqData['signIn_token']) || $ReqData['signIn_token'] == "" || $ReqData['signIn_token'] != $_SESSION['LOGIN_TOKEN']) {
    echo "R006 : Invalid data token";
    exit(StopProcess());
}
else {

    //Safe user i/p values
    foreach($ReqData as $key => $value) {
        $ReqData[$key] = $main_app->strsafe_input($value);
    }

    //Start Validation
    if(!isset($ReqData['LoginMob']) || $ReqData['LoginMob'] == NULL || $main_app->valid_mobile($ReqData['LoginMob']) == false) {
        echo "Please enter valid Mobile Number";
        exit(StopProcess());
    }
    elseif(!isset($ReqData['LoginEmail']) || $ReqData['LoginEmail'] == NULL || $main_app->valid_email($ReqData['LoginEmail']) == false ) {
        echo "Please enter valid Email ID";
        exit(StopProcess());
    }
    elseif(strlen($ReqData['LoginEmail']) > "120") {
        echo "Email ID - Maximum 120 characters allowed";
        exit(StopProcess());
    }
    elseif(!isset($_SESSION['SECURITY_CODE']) || $_SESSION['SECURITY_CODE'] == NULL) {
        echo "Captcha/Security code not generated for your request, Please refresh and try again.";
        exit(StopProcess());
    }
    elseif(!isset($ReqData['LoginCaptcha']) || $ReqData['LoginCaptcha'] == NULL || strtoupper($ReqData['LoginCaptcha']) != strtoupper($_SESSION['SECURITY_CODE'])) {
        echo "Please enter valid Security verification code";
        exit(StopProcess());
    }
    else {

       $RecordKeymob = array('SBREQ_MOBILE_NUM' => $ReqData['LoginMob']);
        /*$Mailchck = $main_app->sql_fetchcolumn("SELECT SBREQ_EMAIL_ID FROM SBREQ_MASTER WHERE SBREQ_MOBILE_NUM = :SBREQ_MOBILE_NUM ORDER BY CR_ON DESC", $RecordKeymob);// AND SBREQ_APP_STATUS !='F'
        if($Mailchck && $Mailchck != NULL && $Mailchck != "") {
            if($Mailchck != strtolower($ReqData['LoginEmail'])){
                echo "Mobile Number already exists in different Account Detail in the Applcation";
                exit(StopProcess());   
            }
        }


        $RecordKeymail = array('SBREQ_EMAIL_ID' => strtolower($ReqData['LoginEmail']));
        $Mobchck = $main_app->sql_fetchcolumn("SELECT SBREQ_MOBILE_NUM FROM SBREQ_MASTER WHERE SBREQ_EMAIL_ID = :SBREQ_EMAIL_ID ORDER BY CR_ON DESC", $RecordKeymail);
        if($Mobchck && $Mobchck != NULL && $Mobchck != "") {
            if($Mobchck != $ReqData['LoginMob']){
                echo "Email ID already exists in different Account Detail in the Applcation";
                exit(StopProcess());   
            }
        }*/

        //Check App Pending
        $RecordKeyVal = array( 'SBREQ_MOBILE_NUM' => $ReqData['LoginMob'], 'SBREQ_EMAIL_ID' => strtolower($ReqData['LoginEmail']) );
        $sql_exe = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_MOBILE_NUM, SBREQ_EMAIL_ID, SBREQ_APP_STATUS FROM SBREQ_MASTER WHERE SBREQ_MOBILE_NUM = :SBREQ_MOBILE_NUM AND SBREQ_EMAIL_ID = :SBREQ_EMAIL_ID AND (SBREQ_APP_STATUS = 'P' OR SBREQ_APP_STATUS = 'S' OR SBREQ_APP_STATUS = 'F' OR SBREQ_VKYC_STATUS = 'P') ORDER BY CR_ON DESC", $RecordKeyVal);
        $appData = $sql_exe->fetch();

        if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
            //echo "No pending application available";
            echo "Details you entered does not exists in the Application, Kindly Click on Get Started.";
            exit(StopProcess());
        }
        elseif(isset($appData['SBREQ_APP_STATUS']) && $appData['SBREQ_APP_STATUS'] == "F") {
            echo "{$appData['CBS_REMARKS']}";
            exit(StopProcess());
        }
        elseif(!isset($appData['SBREQ_MOBILE_NUM']) || $appData['SBREQ_MOBILE_NUM'] == NULL || $appData['SBREQ_MOBILE_NUM'] != $ReqData['LoginMob']) {
            echo "Unable to process your request (R01)";
            exit(StopProcess());
        }
        elseif(!isset($appData['SBREQ_EMAIL_ID']) || $appData['SBREQ_EMAIL_ID'] == NULL || $appData['SBREQ_EMAIL_ID'] != strtolower($ReqData['LoginEmail'])) {
            echo "Unable to process your request (R02)";
            exit(StopProcess());
        }

        //De-Dupe check with CBS

        // Format User Data
        $userData = array (
            'ReqType' => "E", // ReLogin for Edit
            'LoginMob' => $ReqData['LoginMob'],
            'LoginEmail' => strtolower($ReqData['LoginEmail']),
            'LoginAppId' => $appData['SBREQ_APP_NUM']
        );

        // Generate OTP
        if(APP_PRODUCTION == false || SMS_ENABLE == "NO") {
            $otpCodeSms = "123123";
        } else {
            $otpCodeSms = $main_app->get_otpcode();
        }

        // Write Log
        $otpReqId = $main_app->sql_sequence("LOG_OTPREQ_SEQ","OTP"); // Seq. No.

        if($otpReqId == false || $otpReqId == "" || $otpReqId == "1") {
            echo "Unable to generate OTP Reference ID";
        } else {

            //Send SMS
            /*
            try {
                require_once(DIRPATH.'/class/class_mod_sendalerts.php');
                SendAlert::SendAlertRequest("SMS", $ReqData['LoginMob'], "OTP-SMS", array('@@OTPCODE@@' => $otpCodeSms), "5", $otpReqId);
            } catch (Exception $e) {
                exit("SMS Error: ".$e->getMessage());
            }
            */
            $SmsTemplate = $main_app->sql_fetchcolumn("SELECT SMSTPL_TEXT FROM APP_SMS_TEMPLATES WHERE SMSTPL_CODE = 'OTP-SMS' AND SMSTPL_ENABLE = '1'");
            if($SmsTemplate && $SmsTemplate != NULL && $SmsTemplate != "") {
                $ShortTags = array( '@@OTPCODE@@' => isset($otpCodeSms) ? $otpCodeSms : "" );
                $SmsTemplate = strtr($SmsTemplate, $ShortTags);
                $sms_sentlog = send_sms($ReqData['LoginMob'], $SmsTemplate);
            }

            //Log DB
            $data = array();
            $data['OTP_REQ_ID'] = $otpReqId;
            $data['OTP_PGMCODE'] = "E"; // Edit or Resume Application
            $data['OTP_MOBILE_NUM'] = $ReqData['LoginMob'];
            $data['OTP_EMAIL_ID'] = strtolower($ReqData['LoginEmail']);
            $data['SMS_VERIFIED_FLAG'] = "P";
            $data['SMS_RESENT_COUNT'] = NULL;
            $data['SMS_SENT_RESP'] = base64_encode($otpCodeSms);
            $data['REQ_DATA'] = json_encode($userData);
            $data['GEN_PLATFORM'] = $browser->getPlatform();
            $data['GEN_BROWSER_NAME'] = $browser->getBrowser();
            $data['GEN_BROWSER_VER'] = $browser->getVersion();
            $data['GEN_IP_ADDRESS'] = $main_app->current_ip();
            $data['CR_ON'] = date("Y-m-d H:i:s");
            $otpData = $main_app->sql_insert_data("LOG_OTPREQ", $data); // User log

            if($otpData) {

                // Session Data
                $main_app->session_set([
                    'USER_APP' => APP_CODE,
                    'OTP_REQ_ID' => $otpReqId, // OTP Request ID
                    'PRE_LOGIN_DATA' => json_encode($userData), // Store User I/P
                    'OTP_SMS_CODE' => $otpCodeSms,
                    'OTP_SMS_TIME' => time(),
                    'OTP_SMS_CHK' => "Y",
                    'OTP_SMS_ATTEMPTS' => "0"
                ]);

                echo "ok"; // Success

            } else {
                echo "Unable to proceed";
            }

        }

    }

}

