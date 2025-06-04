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
    $_POST['data'] = base64_decode($_POST['data']);
    $ReqData = ($_POST['data']) ? json_decode($_POST['data'], true) : NULL;
    // $ReqData = json_decode($_POST['data'], true);
    if(is_array($ReqData) && count($ReqData) > "0") {
        foreach($ReqData as $key => $value) {
            if($value != "") {
                $ReqData[$key] = $safe->rsa_decrypt($value);
            }
        }
    }
}

/** Register Form */
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
elseif(!isset($ReqData['reg_token']) || $ReqData['reg_token'] == "" || $ReqData['reg_token'] != $_SESSION['LOGIN_TOKEN']) {
    echo "R006 : Invalid data token";
    exit(StopProcess());
}
else {

    //Safe user i/p values
    foreach($ReqData as $key => $value) {
        $ReqData[$key] = $main_app->strsafe_input($value);
    }

    //Start Validation
    if(!isset($ReqData['RegCustTitle']) || $ReqData['RegCustTitle'] == NULL || ($ReqData['RegCustTitle'] != "1" && $ReqData['RegCustTitle'] != "2" && $ReqData['RegCustTitle'] != "3") ) {
        echo "Please select valid Customer Title";
        exit(StopProcess());
    }
    elseif(!isset($ReqData['RegName']) || $ReqData['RegName'] == NULL || $ReqData['RegName'] == "" || $main_app->valid_text($ReqData['RegName']) == false ) {
        echo "Please enter valid Full Name";
        exit(StopProcess());
    }
    if(!isset($ReqData['RegEmail']) || $ReqData['RegEmail'] == NULL || $main_app->valid_email($ReqData['RegEmail']) == false ) {
        echo "Please enter valid Email ID";
        exit(StopProcess());
    }
    elseif(strlen($ReqData['RegEmail']) > "120") {
        echo "Email ID - Maximum 120 characters allowed";
        exit(StopProcess());
    }
    elseif(!isset($ReqData['RegMob']) || $ReqData['RegMob'] == NULL || $main_app->valid_mobile($ReqData['RegMob']) == false) {
        echo "Please enter valid Mobile Number";
        exit(StopProcess());
    }
    elseif(isset($ReqData['RegReferral']) && $ReqData['RegReferral'] != "" && strlen($ReqData['RegReferral']) > "120") {
        echo "RegReferral - Maximum 120 characters allowed";
        exit(StopProcess());
    }
    elseif(!isset($_SESSION['SECURITY_CODE']) || $_SESSION['SECURITY_CODE'] == NULL) {
        echo "Captcha/Security code not generated for your request, Please refresh and try again.";
        exit(StopProcess());
    }
    elseif(!isset($ReqData['RegCaptcha']) || $ReqData['RegCaptcha'] == NULL || strtoupper($ReqData['RegCaptcha']) != strtoupper($_SESSION['SECURITY_CODE'])) {
        echo "Please enter valid Security verification code";
        exit(StopProcess());
    }
    elseif(!isset($ReqData['RegAgree1']) || $ReqData['RegAgree1'] != "1") {
        echo "Please click the checkbox to proceed";
        exit(StopProcess());
    }
    elseif(!isset($ReqData['RegAgree2']) || $ReqData['RegAgree2'] != "1") {
        echo "Please click the checkbox to proceed";
        exit(StopProcess());
    }
    elseif(!isset($ReqData['RegAgree3']) || $ReqData['RegAgree3'] != "1") {
        echo "Please click the checkbox to proceed";
        exit(StopProcess());
    }
    elseif(isset($ReqData['RegReferral']) &&  $ReqData['RegReferral'] != ""){
        $referal_code = $main_app->sql_run("SELECT * FROM SBREQ_REFERRAL_CODES WHERE REFERRAL_CODE = :REFERRAL_CODE", array("REFERRAL_CODE" => $ReqData['RegReferral']));
        $item_data2 = $referal_code->fetch();

        if(!isset($item_data2['REFERRAL_CODE']) || $item_data2 == false || $item_data2['REFERRAL_CODE'] == "" || $item_data2['REFERRAL_CODE'] == false) {
            echo "Referral Code is invalid";
            exit(StopProcess());
        } else {
           echo "ok";
        }
    }
    else {

	$RecordKeymob = array('SBREQ_MOBILE_NUM' => $ReqData['RegMob']);
        $Mailchck = $main_app->sql_fetchcolumn("SELECT SBREQ_EMAIL_ID FROM SBREQ_MASTER WHERE SBREQ_MOBILE_NUM = :SBREQ_MOBILE_NUM ORDER BY CR_ON DESC", $RecordKeymob);// AND SBREQ_APP_STATUS !='F' 
        if($Mailchck && $Mailchck != NULL && $Mailchck != "") {
            if($Mailchck != strtolower($ReqData['RegEmail'])){
                echo "Mobile Number Already Exists in the Account Detail Applcation";
                exit(StopProcess());   
            }
        }


       $RecordKeymail = array('SBREQ_EMAIL_ID' => strtolower($ReqData['RegEmail']));
        $Mobchck = $main_app->sql_fetchcolumn("SELECT SBREQ_MOBILE_NUM FROM SBREQ_MASTER WHERE SBREQ_EMAIL_ID = :SBREQ_EMAIL_ID ORDER BY CR_ON DESC", $RecordKeymail);
        if($Mobchck && $Mobchck != NULL && $Mobchck != "") {
            if($Mobchck != $ReqData['RegMob']){
                echo "Email ID already exists in the Account Detail Applcation";
                exit(StopProcess());   
            }
        }


        //Check Pending
        $RecordKeyVal = array(
            'SBREQ_MOBILE_NUM' => $ReqData['RegMob'],
            'SBREQ_EMAIL_ID' => strtolower($ReqData['RegEmail'])
        );
    
        $acctchck = $main_app->sql_fetchcolumn("SELECT count(0) FROM SBREQ_MASTER WHERE SBREQ_MOBILE_NUM = :SBREQ_MOBILE_NUM AND SBREQ_EMAIL_ID = :SBREQ_EMAIL_ID AND SBREQ_APP_STATUS='S'", $RecordKeyVal);
        
        if($acctchck && $acctchck > "0") {
            echo "Account Details Already exists, Kindly Click on Resume Application";
            exit(StopProcess());
        }

        $pendingCount = $main_app->sql_fetchcolumn("SELECT count(0) FROM SBREQ_MASTER WHERE SBREQ_MOBILE_NUM = :SBREQ_MOBILE_NUM AND SBREQ_EMAIL_ID = :SBREQ_EMAIL_ID", $RecordKeyVal);
        
        if($pendingCount && $pendingCount > "0") {
            echo "Similar application exists for your details, Kindly Click on Resume Application";
            exit(StopProcess());
        }

     
        // Format User Data
        $userData = array (
            'ReqType' => "N", // New Request
            'RegCustTitle' => $ReqData['RegCustTitle'],
            'RegName' => $ReqData['RegName'],
            'RegEmail' => strtolower($ReqData['RegEmail']),
            'RegMob' => $ReqData['RegMob'],
            'RegReferral' => $ReqData['RegReferral'],
            'RegDbt' => $ReqData['RegDbt']
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
            /*try {
                require_once(DIRPATH.'/class/class_mod_sendalerts.php');
                SendAlert::SendAlertRequest("SMS", $ReqData['RegMob'], "OTP-SMS", array('@@OTPCODE@@' => $otpCodeSms), "5", $otpReqId);
            } catch (Exception $e) {
                exit("SMS Error: ".$e->getMessage());
            }
            */

            $SmsTemplate = $main_app->sql_fetchcolumn("SELECT SMSTPL_TEXT FROM APP_SMS_TEMPLATES WHERE SMSTPL_CODE = 'OTP-SMS' AND SMSTPL_ENABLE = '1'");
            if($SmsTemplate && $SmsTemplate != NULL && $SmsTemplate != "") {
                $ShortTags = array( '@@OTPCODE@@' => isset($otpCodeSms) ? $otpCodeSms : "" );
                $SmsTemplate = strtr($SmsTemplate, $ShortTags);
                $sms_sentlog = send_sms($ReqData['RegMob'], $SmsTemplate);
            }

            //Log DB
            $data = array();
            $data['OTP_REQ_ID'] = $otpReqId;
            $data['OTP_PGMCODE'] = "N"; // New Registration
            $data['OTP_MOBILE_NUM'] = $ReqData['RegMob'];
            $data['OTP_EMAIL_ID'] = strtolower($ReqData['RegEmail']);
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
                    'OTP_SMS_ATTEMPTS' => "0", 
                    'SMS_VERIFIED_FLAG' => "P",
                    'EMAIL_VERIFIED_FLAG' => "P"

                ]);

                echo "ok"; // Success

            } else {
                echo "Unable to proceed";
            }

        }

    }

}

