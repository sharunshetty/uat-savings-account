<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

if(isset($_POST['arnVal']) && $_POST['arnVal'] != "") {
    $plain_arn_val = $safe->str_decrypt($_POST['arnVal'], $_SESSION['SAFE_KEY']);
}

//validation
if(!isset($_SESSION['USER_REF_NUM']) || $_SESSION['USER_REF_NUM'] == NULL || $_SESSION['USER_REF_NUM'] == "") {
    echo "<script> swal.fire('','Unable to validate your request .)'); loader_stop(); enable('sbt'); </script>";
}
elseif((isset($_POST['NOMINEE_NAME']) && $_POST['NOMINEE_NAME'] != "") && (!isset($_POST['NOMINEE_DOB']) || $_POST['NOMINEE_DOB'] == NULL || $_POST['NOMINEE_DOB'] == "")) {
    echo "<script> swal.fire('','Please enter Date of birth of Nominee'); loader_stop(); enable('sbt'); </script>";
}
elseif((isset($_POST['NOMINEE_NAME']) && $_POST['NOMINEE_NAME'] != "") && (!isset($_POST['NOMINEE_RELATION']) || $_POST['NOMINEE_RELATION'] == NULL || $_POST['NOMINEE_RELATION'] == "")) {
    echo "<script> swal.fire('','Please enter Relation to the Account holder'); loader_stop(); enable('sbt'); </script>";
}
elseif((isset($_POST['NOMINEE_NAME']) && $_POST['NOMINEE_NAME'] != "") && (!isset($_POST['NOMINEE_ADDRESS']) || $_POST['NOMINEE_ADDRESS'] == NULL || $_POST['NOMINEE_ADDRESS'] == "")) {
    echo "<script> swal.fire('','Please enter Nominee Address'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($_POST['RegAgree']) || $_POST['RegAgree'] == NULL || $_POST['RegAgree'] == "") {
    echo "<script> swal.fire('','Please click on check box to accept terms and conditions.'); loader_stop(); enable('sbt'); </script>";
}
elseif(!isset($plain_arn_val) || $plain_arn_val == false) {
    echo "<script> swal.fire('','Unable to process your request (E02)'); loader_stop(); enable('sbt'); </script>";
}
elseif($plain_arn_val != $_SESSION['USER_REF_NUM']) {
    echo "<script> swal.fire('','Unable to process your request (E04)'); loader_stop(); enable('sbt'); </script>";
}
else {

    $updated_flag = true;
    $sys_datetime = date("Y-m-d H:i:s");

    $sql1_exe = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $item_data = $sql1_exe->fetch();

    if(!isset($item_data['SBREQ_APP_NUM']) || $item_data['SBREQ_APP_NUM'] == NULL || $item_data['SBREQ_APP_NUM'] == "") {
        echo "<script> swal.fire('','Unable to validate your request (R01)'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    if(isset($item_data['SBREQ_EKYC_UID']) && $item_data['SBREQ_EKYC_UID'] != "") {
        $aadhaarNo = $safe->str_decrypt($item_data['SBREQ_EKYC_UID'], $item_data['SBREQ_APP_NUM']);
    }

    if(isset($item_data['SBREQ_PAN_CARD']) && $item_data['SBREQ_PAN_CARD'] != "") {
        $panNo = $safe->str_decrypt($item_data['SBREQ_PAN_CARD'], $item_data['SBREQ_APP_NUM']);
    }
  
    $pid_data = array(array('PID_TYPE' => "UID", 'PID_NUM' => $aadhaarNo, 'CARD_NUM' => '', 'DATE_OF_ISSUE' => '', 'PLACE_OF_ISSUE' => '', 'ISSUING_AUTH' => 'GOI', 'ISSUING_COUNTRY' => '', 'EXPIRY_DATE' => '', 'USEDOF_ADDRESS_PF' => '1', 'USEDOF_IDENTITY_CHK' => '1' ),
                            array('PID_TYPE' => "PAN", 'PID_NUM' => $panNo, 'CARD_NUM' => '', 'DATE_OF_ISSUE' => '', 'PLACE_OF_ISSUE' => '', 'ISSUING_AUTH' => 'GOI', 'ISSUING_COUNTRY' => '', 'EXPIRY_DATE' => '', 'USEDOF_ADDRESS_PF' => '0', 'USEDOF_IDENTITY_CHK' => '1' ));
    if(!empty($dl_array)) {
        array_push($pid_data, $dl_array);
    }

    //json array of pid_list
    $pid_data_array = json_encode($pid_data, true);

    $sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM']));
    $ekyc_docsdata = $sql_exe3->fetch();

    if(!isset($ekyc_docsdata['DOC_DATA']) && $ekyc_docsdata['DOC_DATA'] == "") {
        echo "<script> swal.fire('','Unable to validate your request..'); loader_stop(); enable('sbt2'); </script>";
        exit();    
    }

    if(isset($ekyc_docsdata['DOC_DATA']) && $ekyc_docsdata['DOC_DATA'] != "") {
        $aadhaardetails = json_decode(stream_get_contents($ekyc_docsdata['DOC_DATA']), true, JSON_UNESCAPED_SLASHES);
    }
    
    /*if(isset($aadhaardetails['name']) && $aadhaardetails['name'] != "") {
        $name = explode(' ', $aadhaardetails['name']);
        $first_name = $name[0];
        $middle_name = isset($name[1]) ? $name[1] : NULL ;
        $last_name = isset($name[2]) ? $name[2] : NULL;
    }*/

    //get pan data
    $sql_exe_pan = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'PAN' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM']));
    $pan_docsdata = $sql_exe_pan->fetch();

    if(isset($pan_docsdata['DOC_DATA']) && $pan_docsdata['DOC_DATA'] != "") {
        $pan_details = json_decode(stream_get_contents($pan_docsdata['DOC_DATA']), true, JSON_UNESCAPED_SLASHES);
    }

    if(isset($pan_details['firstName']) && $pan_details['firstName'] != "") {
        $first_name = $pan_details['firstName'];
    }

    if(isset($pan_details['midName']) && $pan_details['midName'] != "") { 
        $middle_name = $pan_details['midName'];
    }

    if(isset($pan_details['lastName']) && $pan_details['lastName'] != "") { 
        $last_name = $pan_details['lastName'];
    }

     //take last name from pan response if first name is not present(rare case)
    if(isset($pan_details['firstName']) && $pan_details['firstName'] == "") {
            if(isset($pan_details['lastName']) && $pan_details['lastName'] != "") {
                $first_name = $pan_details['lastName'];
                $last_name = ".";
        }
    }

    //calculate age
    $dob = $aadhaardetails['dob'];
    $diff = (date('Y') - date('Y',strtotime($dob)));
    if($diff >= "60") {
        $ac_sub_type = "03";
        $it_status_code = "IS";
    } else {
        $ac_sub_type = "01";
        $it_status_code = "I";
    }
    
    $dob = trim($aadhaardetails['dob']);

   //implode dob aadhaar
    if(isset($aadhaardetails['dob']) && $aadhaardetails['dob'] != ""){
	$dobaadhaar = date('d-m-Y',strtotime($aadhaardetails['dob']));
        $birth_date = explode('-', $dobaadhaar);
        $dateofbirth = $birth_date[0].''.$birth_date[1].''.$birth_date[2];
    }

    //Fetch all basic details of customer
    $sql_exe4 = $main_app->sql_run("SELECT * FROM SBREQ_ACCOUNTDATA WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY MO_ON DESC", array('SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM']));
    $cust_details = $sql_exe4->fetch(); 
    
    if(!isset($cust_details['SBREQ_APP_NUM']) || $cust_details['SBREQ_APP_NUM'] == NULL || $cust_details['SBREQ_APP_NUM'] == "") {
        echo "<script> swal.fire('','Unable to validate your Request.'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    if(isset($aadhaardetails['fatherName']) && $aadhaardetails['fatherName'] != ""){
        $fathernameuid = $aadhaardetails['fatherName'];
    }

    $fathersname = isset($fathernameuid) ? $fathernameuid : $aadhaardetails['careOf'];

   //date of birth conversion to format like 09-Mar-1998
    $date= date_create($aadhaardetails['dob']);    
    $dob_aadhaar = date_format($date,"d-M-Y");
    
    $splitAddress = $aadhaardetails['street'] . ", " . $aadhaardetails['district'] . ", " . $aadhaardetails['vtcName'] . ", " . $aadhaardetails['postOffice'] . "," . $aadhaardetails['state'];

    //DEDUP FOR VALIDATING IF ACCOUNT IS PRESENT IN CBS 
    /*$sql_exeq = $main_app->sql_run("select wm_concat(Distinct cic.indclient_code||' | '||cc.clients_home_brn_code ||' | '||trim(cc.clients_name)||' | '||
    to_char(cic.indclient_birth_date, 'DD-Mon-YYYY')||' | '||cic.indclient_father_name||chr(10)) dup_client from cbuat.indclients cic
    Join cbuat.clients cc on cc.clients_code = cic.indclient_code
    Left Join cbuat.clntmergseldtl cmc on cmc.cmseld_entity_num=1 and cmc.cmseld_existing_clientnum = cic.indclient_code
    where cmc.cmseld_merge_sl is NULL and to_char(cic.indclient_birth_date,'YYYYMMDD') = to_char(to_date('{$dob_aadhaar}','DD-Mon-YYYY'),'YYYYMMDD')
    and Upper(Replace(cc.clients_name,' ','')) = Upper(replace('{$aadhaardetails['name']}',' ','')) 
    and Upper(Replace(cic.indclient_father_name,' ','')) = Upper(replace('{$fathersname}',' ',''))
    and ( utl_match.edit_distance_similarity(Upper(Replace('{$aadhaardetails['street']} ||{$aadhaardetails['district']} || {$aadhaardetails['vtcName']} || {$aadhaardetails['postOffice']} || {$aadhaardetails['state']}',' ','')),
    Upper(replace('{$aadhaardetails['combinedAddress']}',' ',''))) >= 20 
    or
    utl_match.edit_distance_similarity(Upper(Replace('{$aadhaardetails['street']} || {$aadhaardetails['district']} || {$aadhaardetails['vtcName']} || {$aadhaardetails['postOffice']} || {$aadhaardetails['state']}',' ','')),
    Upper(replace('{$splitAddress}',' ',''))) >= 50)");
    $dedupdata = $sql_exeq->fetch();

    if(isset($dedupdata) && ($dedupdata['DUP_CLIENT'] != "" || $dedupdata['DUP_CLIENT'] != NULL)) {
        echo "<script> swal.fire('','Details are already present in Bank, Kindly visit nearest Branch'); loader_stop(); enable('sbt'); </script>";
    	exit();
    }*/

 
 //take address from aadhaar response for sending address 1 in ISO
  if(isset($aadhaardetails['houseNumber']) && $aadhaardetails['houseNumber'] != "" && $aadhaardetails['houseNumber'] != " " && $aadhaardetails['houseNumber'] != " " && $aadhaardetails['houseNumber'] != "null" && $aadhaardetails['houseNumber'] != "NULL"){
        $address1 = $aadhaardetails['houseNumber'];
    } else {
        if(isset($aadhaardetails['postOffice']) && $aadhaardetails['postOffice'] != "" && $aadhaardetails['postOffice'] != " " && $aadhaardetails['postOffice'] != "null" && $aadhaardetails['postOffice'] != "NULL") {
            $address1 = $aadhaardetails['postOffice'];
        } else {
            if(isset($aadhaardetails['vtcName']) && $aadhaardetails['vtcName'] != "" && $aadhaardetails['vtcName'] != " " && $aadhaardetails['vtcName'] != "null" && $aadhaardetails['vtcName'] != "NULL") {
                $address1 = $aadhaardetails['vtcName'];
            }
            else {
                if(isset($aadhaardetails['subdistrict']) && $aadhaardetails['subdistrict'] != "" && $aadhaardetails['subdistrict'] != " " && $aadhaardetails['subdistrict'] != "null" && $aadhaardetails['subdistrict'] != "NULL") {
                    $address1 = $aadhaardetails['subdistrict'];
                }
                 else {
                    if(isset($aadhaardetails['district']) && $aadhaardetails['district'] != "" && $aadhaardetails['district'] != " " && $aadhaardetails['district'] != "null" && $aadhaardetails['district'] != "NULL") {
                        $address1 = $aadhaardetails['district'];

                    }
                 }
            }
        }
    }

   //trim address1 if length is greater than 25( For virtual debit card generation)
    if(isset($address1) && $address1 != "") {
        $addresslength = strlen($address1);
        if($addresslength > 25) {
            $Address1 = substr($address1, 0, 25);
        } else {
            $Address1  = $address1;
        }
    }

    //trim address2 if length is greater than 25( For virtual debit card generation)
    if(isset($aadhaardetails['street']) && $aadhaardetails['street'] != "" && $aadhaardetails['street'] != "null") {
        $addresslength = strlen($aadhaardetails['street']);
        if($addresslength > 25) {
            $Address2 = substr($aadhaardetails['street'], 0, 25);
        } else {
            $Address2  = $aadhaardetails['street'];
        }
    }

    //trim address3 if length is greater than 25( For virtual debit card generation)
    if(isset($aadhaardetails['district']) && $aadhaardetails['district'] != "" && $aadhaardetails['district'] != "null") {
        $addresslength = strlen($aadhaardetails['district']);
        if($addresslength > 25) {
            $Address3 = substr($aadhaardetails['district'], 0, 25);
        } else {
            $Address3  = $aadhaardetails['district'];
        }
    }


    $accountdetail = $main_app->sql_run("SELECT CBS_USER_ID, USERCRE_RESP_CODE, CBS_ACNT_NUMBER, ACCOUNT_RESP_CODE FROM PORTALONLINEACCOPEN WHERE ENTITY_NUM = '1' AND APP_NUMBER = :APP_NUMBER", array( 'APP_NUMBER' => $_SESSION['USER_REF_NUM']));
    $item_data_ac = $accountdetail->fetch();

    if(isset($item_data_ac) && $item_data_ac != "" && $item_data_ac['USERCRE_RESP_CODE'] == "S" && $item_data_ac['ACCOUNT_RESP_CODE'] == "S") {

        $output['responseCode'] = "S";
        $output['userId'] = $item_data_ac['CBS_USER_ID'];
        $output['acntNumber'] = $item_data_ac['CBS_ACNT_NUMBER'];
	$output['userResp'] = $item_data_ac['USERCRE_RESP_CODE'];
        $output['accResp'] = $item_data_ac['ACCOUNT_RESP_CODE'];
    } 
    else {


    // Account Opening Verify 
    $send_data['METHOD_NAME'] = "createAccount"; 
    $send_data['PRODUCT_CODE'] = $cust_details['SBREQ_PRODUCT_CODE'];
    $send_data['ACC_TYPE'] = $main_app->getval_field('SBREQ_ACCOUNT_TYPE','ACCOUNT_TYPE_CODE','ACCOUNT_TYPE_PROD',$cust_details['SBREQ_PRODUCT_CODE']);
    $send_data['ACC_SUB_TYPE'] = $ac_sub_type;
    $send_data['BRANCH_CODE'] = $cust_details['SBREQ_BRANCH_CODE'];
    $send_data['TITLE_CODE'] = $item_data['SBREQ_CUST_TITLE'];
    $send_data['CONST_CODE'] = "1";
    $send_data['RELIGION_CODE'] = "99";
    $send_data['NATIONALITY_CODE'] = "IN";
    $send_data['WEAKER_SEC_CODE'] = "99";
    $send_data['CUST_CATCODE'] = "1";
    $send_data['CUST_SUB_CATCODE'] = "0"; //to be shared by bank
    $send_data['CUST_SEGMENT_CODE'] = "99999";
    $send_data['BUSINESS_DIVCODE'] = "99"; //change during live
    $send_data['POB_LOC_CODE'] = $cust_details['SBREQ_PLACE_OF_BIRTH'];
    $send_data['LANGUAGE_CODE'] = "04";
    $send_data['OCCUPATION_CODE'] = $cust_details['SBREQ_OCCUPATION_CODE'];
    $send_data['COMPANY_CODE'] = "OTHERS";
    $send_data['DESIGN_CODE'] = "Blank";
    $send_data['CITY_CODE'] = $cust_details['SBREQ_CITY_CODE']; //change
    $send_data['COUNTRY_CODE'] = "0091";
    $send_data['STATE_CODE'] = $cust_details['SBREQ_STATE_CODE']; //change
    $send_data['ANNUAL_INSLAB'] = $cust_details['SBREQ_ANNUAL_INCOME'];
    $send_data['IT_STATUS_CODE'] = $it_status_code; //I / IS
    $send_data['IT_SUBSTATUS_CODE'] = "0"; //to be shared by bank
    $send_data['CUST_ARM_CODE'] = "1";
    $send_data['TYPEOF_CUST'] = "R";
    $send_data['RISK_CAT'] = "3"; //to be clarified bank
    $send_data['TYPEOF_ACCOMODATION'] = "6";
    $send_data['INSUPOLICY_INFO'] = "2"; 
    $send_data['CURRENCY_CODE'] = "INR"; 
    $send_data['ANNUAL_INCOME'] = "100000";
    $send_data['TAX_TIN_NUMBER'] = "0";
    $send_data['FIRST_NAME'] = $first_name;
    $send_data['MID_NAME'] = isset($middle_name) ? $middle_name : NULL;
    $send_data['LAST_NAME'] = isset($last_name) ? $last_name : NULL;
    $send_data['FATHER_NAME'] = $cust_details['SBREQ_FATHERSNAME'];
    $send_data['DOB'] = $dateofbirth;
    $send_data['GENDER'] = isset($aadhaardetails['gender']) ? $aadhaardetails['gender'] : NULL ;
    $send_data['UNDER_POVERTY'] = "";
    $send_data['RESIDENT_STATUS'] = "R";
    $send_data['MARITAL_STATUS'] = "";
    $send_data['BANK_RELATION'] = "N";
    $send_data['EMPNO'] = "";
    $send_data['COMPANY_NAME'] = "";
    $send_data['ADDRESS1'] = $Address1;
    $send_data['ADDRESS2'] = isset($Address2) ? $Address2 : NULL ;
    $send_data['ADDRESS3'] = isset($Address3) ? $Address3 : NULL ;    
    $send_data['ADDRESS4'] = isset($aadhaardetails['state']) ? $aadhaardetails['state'] : NULL ;
    $send_data['ADDRESS5'] = isset($aadhaardetails['pincode']) ? $aadhaardetails['pincode'] : NULL ;   
    $send_data['POSTBOX_NUM'] = "";
    $send_data['MOBILE_NUMBER'] = $item_data['SBREQ_MOBILE_NUM'];
    $send_data['EMIAL_ID'] = $item_data['SBREQ_EMAIL_ID'];
    $send_data['OFFICE_PHONE_NUM'] = "";
    $send_data['FAX_NUM'] = "";
    $send_data['ALTERNATE_CONTACT_NUM'] = "";
    $send_data['PERSON_NAME'] = "";
    $send_data['RESIDENT_NO'] = "";
    $send_data['OFFICE_NO'] = "";
    $send_data['EXTENSION_NO'] = "";
    $send_data['AUTH_CAPITAL'] = "";
    $send_data['ISSUED_CAPITAL'] = "";
    $send_data['PAID_UP_CAPITAL'] = "";
    $send_data['NETWORTH'] = "";
    $send_data['DATE_OF_INCORP'] = "";
    $send_data['COUNTRY_OF_INCORP'] = "";
    $send_data['REGISTRATION_NUM'] = "";
    $send_data['REGISTRATION_DATE'] = "";
    $send_data['REGISTRATION_AUTH'] = "";
    $send_data['YEARS_IN_BUSSINESS'] = "";
    $send_data['GROSS_TURNOVER'] = "";
    $send_data['NO_OF_EMP'] = "";
    $send_data['NO_OF_BRANCH'] = "";
    $send_data['INDUSTRY_CODE'] = "";
    $send_data['SUB_INDUSTRY_CODE'] = "";
    $send_data['PUBLIC_SEC_ENTP'] = "";
    $send_data['REGISTRATION_EXPIRY_DATE'] = "";
    $send_data['REGISTRATION_OFFC_ADDRESS'] = "";
    $send_data['CLIENT_TYPE'] = "I";
    $send_data['BANK_EMP_CODE'] = "I";
    $send_data['TYPE_OF_EMPLOYMENT'] = "N";
    $send_data['WORK_FROM_ADTE'] = "";
    $send_data['CURRENT_ADDRESS'] = "1";
    $send_data['PERMANENT_ADDRESS'] = "1";
    $send_data['COMMUNICATION_ADDRESS'] = "1";
    $send_data['RESIDENT_PHONE_NUM'] = "";
    $send_data['AADHAAR_REF_NUMBER'] = "";
    $send_data['CLIENT_REF_NUMBER'] = $item_data['SBREQ_APP_NUM'];
    $send_data['REFER_BY'] = "";
    $send_data['PID_LIST'] = $pid_data_array;

    try {
        $apiConn = new ReachMobApi;
       // $output = $apiConn->ReachMobConnect($send_data, "120");
        $output = json_decode('{"smsResp":"S","userResp":"S","accResp":"S","successMessage":"Thank you opening the account with CSF bank.We welcome you to digital platform","emailResp":"S","userId":"809005","acntNumber":"062205001511","responseCode":"S"}', true);   

      } catch(Exception $e) {
        error_log($e->getMessage());
        $ErrorMsg = "We are unable to process your request, Please try after some time."; //Error from Class    
    }

    //Skip Dedupe Error
     if(isset($output['responseCode']) && $output['responseCode'] == "S") {
        //cooment in localhost
        // $accountdetail2 = $main_app->sql_run("SELECT CBS_USER_ID, USERCRE_RESP_CODE, CBS_ACNT_NUMBER, ACCOUNT_RESP_CODE FROM PORTALONLINEACCOPEN WHERE ENTITY_NUM = '1' AND APP_NUMBER = :APP_NUMBER", array( 'APP_NUMBER' => $_SESSION['USER_REF_NUM']));
     	// $item_data_ac2 = $accountdetail2->fetch();

        // $output['responseCode'] = "S";
        // $output['userId'] = $item_data_ac2['CBS_USER_ID'];
        // $output['acntNumber'] = $item_data_ac2['CBS_ACNT_NUMBER'];
        // $output['userResp'] = $item_data_ac2['USERCRE_RESP_CODE'];
        // $output['accResp'] = $item_data_ac2['ACCOUNT_RESP_CODE'];

    }

    if(!isset($ErrorMsg) || $ErrorMsg == "") {
        if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
            $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
        }
    }

    if(isset($ErrorMsg) && $ErrorMsg != "") {
        echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    if(!isset($output['acntNumber']) || $output['acntNumber'] == "") {
        echo "<script> swal.fire('','Unable to process API response.'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    if(!isset($output['userId']) || $output['userId'] == "") {
        echo "<script> swal.fire('','Unable to process API response'); loader_stop(); enable('sbt'); </script>";
        exit();
    }
  }

    if(isset($output['responseCode']) && $output['responseCode'] == "S") {

        $sql1_exe = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
        $item_data = $sql1_exe->fetch();

        $data2 = array();
        $data2['SBREQ_APP_STATUS'] = "S";
        $data2['CBS_ACC_NUM'] = isset($output['acntNumber']) ? $output['acntNumber'] : NULL;
        $data2['CBS_CUST_ID'] = $output['userId'];
        $data2['CUST_IP'] = $main_app->current_ip();
        $db_output2 = $main_app->sql_update_data("SBREQ_MASTER", $data2, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
        if($db_output2 == false) { $updated_flag = false; }
    }

   //send SMS
    if(isset($output['responseCode']) && $output['responseCode'] == "S" && $output['userResp'] == "S" && $output['accResp'] == "S" ) {

        $data = array($item_data['SBREQ_MOBILE_NUM'], $item_data['SBREQ_EMAIL_ID'], "");
        $smsdata = implode("|", $data);

        //call sms API 
        $send_data2 = array();
        $send_data2['METHOD_NAME'] = "smsEmailNotify"; 
        $send_data2['REQ_TYPE'] =  "S";
        $send_data2['SERVICE_CODE'] =  "SMS-NEW-AC";
        $send_data2['REQ_DATA'] =  $smsdata;

        try {
            $apiConn = new ReachMobApi;
           // $output = $apiConn->ReachMobConnect($send_data2, "120");
            // Test Data
            $output = json_decode('{"smsResp":"S","userResp":"S","accResp":"S","successMessage":"Thank you opening the account with CSF bank.We welcome you to digital platform","emailResp":"S","userId":"909005","acntNumber":"062205001531","responseCode":"S"}', true);   

        } catch(Exception $e) {
            error_log($e->getMessage());
            $ErrorMsg = "We are unable to process your request, Please try after some time."; //Error from Class    
        }

        if(!isset($ErrorMsg) || $ErrorMsg == "") {
            if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
                $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
            }
        }
    
        if(isset($ErrorMsg) && $ErrorMsg != "") {
            echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop(); enable('sbt'); </script>";
            exit();
        }
            
        //call EMAIL API 

        $data2 = array($item_data['SBREQ_MOBILE_NUM'], $item_data['SBREQ_EMAIL_ID'], $item_data['SBREQ_APP_NUM']);
        $emaildata = implode("|", $data2);

        $send_data3 = array();
        $send_data3['METHOD_NAME'] = "smsEmailNotify"; 
        $send_data3['REQ_TYPE'] =  "E";
        $send_data3['SERVICE_CODE'] =  "EMAIL-AC-DETAILS";
        $send_data3['REQ_DATA'] =  $emaildata;

        try {
            $apiConn = new ReachMobApi;
           // $output = $apiConn->ReachMobConnect($send_data3, "120");
            // Test Data
            $output = json_decode('{"smsResp":"S","userResp":"S","accResp":"S","successMessage":"Thank you opening the account with CSF bank.We welcome you to digital platform","emailResp":"S","userId":"909005","acntNumber":"062205001531","responseCode":"S"}', true);   

        } catch(Exception $e) {
            error_log($e->getMessage());
            $ErrorMsg = "We are unable to process your request, Please try after some time."; //Error from Class    
        }

        if(!isset($ErrorMsg) || $ErrorMsg == "") {
            if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
                $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
            }
        }
    
        if(isset($ErrorMsg) && $ErrorMsg != "") {
            echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop(); enable('sbt'); </script>";
            exit();
        }
    }

   //implode date of birth for nominee
   if(isset($_POST['NOMINEE_DOB']) && $_POST['NOMINEE_DOB'] != ""){
        $nomineedob = date('d-m-Y',strtotime($_POST['NOMINEE_DOB']));
        $birth_date = explode('-', $nomineedob);
        $dateofbirthnom = $birth_date[0].''.$birth_date[1].''.$birth_date[2];
    }

    //to fetch customer id and account number
    $sql2_exe = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $item_data2 = $sql2_exe->fetch();

    $data = array();
    $data['SBREQ_NOMINEE_NAME'] = $_POST['NOMINEE_NAME']; 
    $data['SBREQ_NOMINEE_DOB'] = $_POST['NOMINEE_DOB']; 
    $data['SBREQ_NOMINEE_RELATION'] = $_POST['NOMINEE_RELATION']; 
    $data['SBREQ_NOMINEE_ADDRESS'] = $_POST['NOMINEE_ADDRESS']; 
    $data['SBREQ_MINOR_FLAG'] = isset($_POST['NOMINEE_HIDDENAFLG']) ? $_POST['NOMINEE_HIDDENAFLG'] : NULL;  
    $data['SBREQ_GUARDIAN_NATURE'] = isset($_POST['NOMINEE_NATURE']) ? $_POST['NOMINEE_NATURE'] : NULL;  
    $data['SBREQ_NOMINEE_GUARDIAN'] = isset($_POST['NOMINEE_GUARDIAN']) ? $_POST['NOMINEE_GUARDIAN'] : NULL;  
    $data['CR_BY'] = isset($_SESSION['OTP_REQ_ID']) ? $_SESSION['OTP_REQ_ID'] : NULL;
    $data['CR_ON'] = date("Y-m-d H:i:s");
    
    $db_output = $main_app->sql_update_data("SBREQ_ACCOUNTDATA", $data, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
    if($db_output == false) { $updated_flag = false; }

    if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to process your request for Nominee.)'); loader_stop(); enable('sbt'); </script>";
        exit();
     }

    //call Nominee API on successful account opening
    $send_data = array();
    $send_data['METHOD_NAME'] = "addNominee"; 
    $send_data['CUSTOMER_CODE'] = "";
    $send_data['CUSTOMER_NAME'] = isset($_POST['NOMINEE_NAME']) ? $_POST['NOMINEE_NAME'] : ""; 
    $send_data['DOB'] = isset($dateofbirthnom) ? $dateofbirthnom : "";
    $send_data['RELATION_TO_ACC_HOLDER'] = isset($_POST['NOMINEE_RELATION']) ? $_POST['NOMINEE_RELATION'] : ""; 
    $send_data['NOMINEE_ADDRESS'] = isset($_POST['NOMINEE_ADDRESS']) ? $_POST['NOMINEE_ADDRESS'] : ""; 
    $send_data['GUARDIAN_CUST_CODE'] = "";
    $send_data['GUARDIAN_NAME'] = isset($_POST['NOMINEE_GUARDIAN']) ? $_POST['NOMINEE_GUARDIAN'] : "";
    $send_data['NATURE_OF_GUARDIAN'] = isset($_POST['NOMINEE_NATURE']) ? $_POST['NOMINEE_NATURE'] : "";
    $send_data['USER_ID'] = isset($item_data2['CBS_CUST_ID']) ? $item_data2['CBS_CUST_ID'] : "";
    $send_data['ACCOUNT_NUMBER'] = isset($item_data2['CBS_ACC_NUM']) ? $item_data2['CBS_ACC_NUM'] : "";
    $send_data['CLIENT_REF_NUMBER'] = $item_data2['SBREQ_APP_NUM'];

    try {
        $apiConn = new ReachMobApi;
       // $output_2 = $apiConn->ReachMobConnect($send_data, "60");
        $output_2 = json_decode('{"acntNumber":"062205001531","responseCode":"S"}', true);   

      } catch(Exception $e) {
        error_log($e->getMessage());
        $ErrorMsg = "Technical Error, Please try later"; //Error from Class    
    }

    $updated_flag=true;
    $data2 = array();
    $data2['SBREQ_NOMINEE_STATUS'] = $output_2['responseCode'];
    $data2['SBREQ_NOM_DETL_FLG'] = "Y";
    $db_output2 = $main_app->sql_update_data("SBREQ_MASTER", $data2, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
    if($db_output2 == false) { $updated_flag = false; }

    if($updated_flag == false) {
       echo "<script> swal.fire('','Unable to process your request.'); loader_stop(); enable('sbt'); </script>";
       exit();
    }

    //insert logs for account upgrade
    $data3= array();
    $data3['APP_REF_NUM'] = $item_data['SBREQ_APP_NUM'];
    $data3['APP_STATUS'] = $output['responseCode'];
    $data3['APP_STATUS_UPDATED_ON'] = $sys_datetime;
    $data3['REVIEWER_STATUS'] = "";
    $data3['REVIEWER_STATUS_UPDATED_ON'] = "";
    $data3['CR_BY'] = $item_data['SBREQ_APP_NUM'];
    $data3['CR_ON'] = $sys_datetime;

    $db_output = $main_app->sql_insert_data("LOGS_SBREQ_ACUPGRADE",$data3); // Insert
    if($db_output == false) { $updated_flag = false; }

    /*if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to update Log Data.'); loader_stop(); enable('sbt'); </script>";
        exit();
     }*/

    // Success
    $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
    echo "<script> goto_url('final-account-detail'); </script>"; // Done

}
