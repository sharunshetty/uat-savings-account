<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

$page_table_name = "VKYC_REQUESTS";
$page_table_name_2 = "VKYC_REQUESTS_CDATA";
$page_table_name_3 = "VKYC_REQUESTS_DOCS";

if(isset($_POST['selVal']) && $_POST['selVal'] != "") {
    $selectedValue = $safe->str_decrypt($_POST['selVal'], $_SESSION['SAFE_KEY']);
}

//validate selected value
if(!isset($selectedValue) || $selectedValue == "") {
    echo "<script> swal.fire('','Invalid Request'); loader_stop(); disable('sbt'); disable('firstBtn'); </script>";
}
elseif(isset($selectedValue) && $selectedValue != "" && ($selectedValue != "A" && $selectedValue != "RA")) {
    echo "<script> swal.fire('','Invalid Request'); loader_stop(); disable('sbt'); disable('firstBtn'); </script>";
}

//validations
if(!isset($_POST['SCH_DATE']) || $_POST['SCH_DATE'] == "") {
    echo "<script> focus('SCH_DATE'); swal.fire('','Please select schedule date'); loader_stop(); enable('sbt'); enable('firstBtn'); </script>";
}
elseif(!isset($_POST['TIMESLOT_CODE']) || $_POST['TIMESLOT_CODE'] == "") {
    echo "<script> focus('TIMESLOT_CODE'); swal.fire('','Please select schedule time slot'); loader_stop(); enable('sbt'); enable('firstBtn'); </script>";
}
else {

    $updated_flag = true;
    $sys_datetime = date("Y-m-d H:i:s");

    $sql_exe = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $cust_dtls = $sql_exe->fetch();

   if(!isset($cust_dtls['SBREQ_APP_NUM']) || $cust_dtls['SBREQ_APP_NUM'] == NULL || $cust_dtls['SBREQ_APP_NUM'] == "") {
        echo "<script> swal.fire('','Unable to validate your request (R01)'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    $sql_exe2= $main_app->sql_run("SELECT * FROM SBREQ_ACCOUNTDATA WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $cust_acdata = $sql_exe2->fetch();

   if(!isset($cust_acdata['SBREQ_APP_NUM']) || $cust_acdata['SBREQ_APP_NUM'] == NULL || $cust_acdata['SBREQ_APP_NUM'] == "") {
        echo "<script> swal.fire('','Unable to validate your request (R02)'); loader_stop(); enable('sbt'); </script>";
        exit();
    }

    //restrict customers from applying for video kyc if total requests already present is equal to number of vkyc_agents
    $scheduled_date = date("d-m-Y", strtotime($_POST['SCH_DATE']));  

    $totalvkycRequests = $main_app->sql_fetchcolumn("SELECT count(0) FROM $page_table_name WHERE VKYC_MEETING_DATE = TO_DATE('{$scheduled_date}', 'DD-MM-YYYY') AND VKYC_PREFER_TIME = :VKYC_PREFER_TIME", array("VKYC_PREFER_TIME" => $_POST['TIMESLOT_CODE']));
    $totalAgents =  $main_app->sql_fetchcolumn("SELECT count(0) FROM USER_ACCOUNTS WHERE (USER_ID = 'CSFBREVIEWER' OR USER_ID = 'CSFBAGENT') and USER_STATUS = '1'");   
    if($totalvkycRequests == $totalAgents) {
        echo "<script> swal.fire('','Current selected slot is already booked. Please select another slot.'); loader_stop(); enable('sbt'); </script>";
        exit();
    }
    
    if(isset($cust_acdata['SBREQ_APP_NUM']) && $cust_acdata['SBREQ_APP_NUM'] != "") {
        $occupation = $main_app->getval_field('OCCUPATIONS', 'OCCUPATIONS_DESCN', 'OCCUPATIONS_CODE', $cust_acdata['SBREQ_OCCUPATION_CODE']);
        $income_group = $main_app->getval_field('INCOMESLAB', 'INCSLAB_DESCN', 'INCSLAB_CODE', $cust_acdata['SBREQ_ANNUAL_INCOME']);
        $religion = $main_app->getval_field('RELIGION', 'RELIGION_DESCN', 'RELIGION_CODE', $cust_acdata['SBREQ_RELIGION_CODE']);
        $branch_code = $main_app->getval_field('MBRN', 'MBRN_CODE', 'MBRN_CODE', $cust_acdata['SBREQ_BRANCH_CODE']);
        $branch_name = $main_app->getval_field('MBRN', 'MBRN_NAME', 'MBRN_CODE', $cust_acdata['SBREQ_BRANCH_CODE']);
    }
	 
    //combine branch code and name
    $branch_detail = $branch_code. "-" .$branch_name;

    $sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC ", array('SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM']));
    $ekyc_docsdata = $sql_exe3->fetch();

    if(isset($ekyc_docsdata['DOC_DATA']) && $ekyc_docsdata['DOC_DATA'] != "") {
      $aadhaardetails = json_decode(stream_get_contents($ekyc_docsdata['DOC_DATA']), true, JSON_UNESCAPED_SLASHES);
    }   

    /*$address = array();
    $address[] = isset($aadhaardetails['vtc']) ? $main_app->strsafe_output($aadhaardetails['vtc']) : NULL;
    $address[] = isset($aadhaardetails['house']) ? $main_app->strsafe_output($aadhaardetails['house']) : NULL;
    $address[] = isset($aadhaardetails['street']) ? $main_app->strsafe_output($aadhaardetails['street']) : NULL;
    $address[] = isset($aadhaaardetails['postOffice']) ? $main_app->strsafe_output($aadhaardetails['postOffice']) : NULL;

    foreach($address as $addval) {
        if($addval != NULL) { 
            $address = $addval." "; 
        }
    }*/

   if(isset($aadhaardetails['combinedAddress']) && $aadhaardetails['combinedAddress'] != "") {
        $address = isset($aadhaardetails['combinedAddress']) ? $aadhaardetails['combinedAddress'] : "";
    }

    if (strlen($address) <= 500) {
        $address1 = $address;
        $address2 = "";
    } else {
        $address1 = substr($address, 0, 500);
        $address2 = substr($address, 500);
    }

    $sch_date = date("Y-m-d", strtotime($_POST['SCH_DATE']));  

    //generate ref. num
    $refer_num = strtoupper(substr(md5(uniqid()), 0, 10));

    //Main table
    if(isset($selectedValue) && $selectedValue == "A") {

        $data = array();
        $data['VKYC_REF_NUM'] = $refer_num;
        $data['VKYC_CHANNEL_ID'] = "CSFBWEB";
        $data['VKYC_SERVICE_CODE'] = "VKYC";
        $data['VKYC_REGION_CODE'] = "VKYC-CSFB";
        $data['EXTERNAL_INWARD_NUM'] = $cust_acdata['SBREQ_APP_NUM'];
        $data['EXTERNAL_CUST_ID'] = (isset($cust_dtls['CBS_CUST_ID']) && $cust_dtls['CBS_CUST_ID'] != "") ? $cust_dtls['CBS_CUST_ID'] : NULL;
        $data['VKYC_CUST_NAME'] = (isset($cust_dtls['SBREQ_CUST_NAME']) && $cust_dtls['SBREQ_CUST_NAME'] != "") ? $cust_dtls['SBREQ_CUST_NAME'] : NULL;
        $data['VKYC_CUST_MOBILE'] = (isset($cust_dtls['SBREQ_MOBILE_NUM']) && $cust_dtls['SBREQ_MOBILE_NUM'] != "") ? $cust_dtls['SBREQ_MOBILE_NUM'] : NULL;
        $data['VKYC_CUST_EMAIL'] = (isset($cust_dtls['SBREQ_EMAIL_ID']) && $cust_dtls['SBREQ_EMAIL_ID'] != "") ? $cust_dtls['SBREQ_EMAIL_ID'] : NULL;
        $data['VKYC_MEETING_DATE'] = isset($sch_date) ? $sch_date : NULL;
        $data['VKYC_PREFER_TIME'] = (isset($_POST['TIMESLOT_CODE']) && $_POST['TIMESLOT_CODE'] != "") ? $_POST['TIMESLOT_CODE'] : NULL;
        $data['VKYC_BRN_CODE'] = (isset($branch_detail) && $branch_detail != "") ? $branch_detail : NULL;
        $data['VKYC_STATUS_FLAG'] = "U"; //Under Review
        $data['VKYC_STATUS_DATE'] = $sys_datetime;
        $data['CR_BY'] = (isset($_SESSION['USER_REF_NUM']) && $_SESSION['USER_REF_NUM'] != "") ? $_SESSION['USER_REF_NUM'] : NULL;
        $data['CR_ON'] = $sys_datetime;

        $db_output = $main_app->sql_insert_data($page_table_name,$data); // Insert
        if($db_output == false) { $updated_flag = false; }

        if($updated_flag == true) {
            
            $date_of_birth = date("d-m-Y", strtotime($aadhaardetails['dob']));  

            //Cdata : Insert
            $encAdharNum = (isset($cust_dtls['SBREQ_EKYC_UID']) && $cust_dtls['SBREQ_EKYC_UID'] != "") ? $cust_dtls['SBREQ_EKYC_UID'] : "";
            $encPanNum = (isset($cust_dtls['SBREQ_PAN_CARD']) && $cust_dtls['SBREQ_PAN_CARD'] != "") ? $cust_dtls['SBREQ_PAN_CARD'] : "";

            $pan_number = $safe->str_decrypt($encPanNum, $_SESSION['USER_REF_NUM']); //decode
            $adhaar_number = $safe->str_decrypt($encAdharNum, $_SESSION['USER_REF_NUM']); //decode

            $data2 = array();
            $data2['CDATA_VKYC_REF_NUM'] = $refer_num;
            $data2['CDATA_NAME'] = (isset($cust_dtls['SBREQ_CUST_NAME']) && $cust_dtls['SBREQ_CUST_NAME'] != "") ? $cust_dtls['SBREQ_CUST_NAME'] : NULL;
            $data2['CDATA_PAN_NUM'] = (isset($pan_number) && $pan_number != false) ? $pan_number : NULL;
            $data2['CDATA_AADHAAR_NUM'] = (isset($adhaar_number) && $adhaar_number != false) ? $adhaar_number : NULL;
            $data2['CDATA_STATE'] = (isset($aadhaardetails['state']) && $aadhaardetails['state'] != "") ? $aadhaardetails['state'] : NULL;
            $data2['CDATA_CITY'] = (isset($aadhaardetails['district']) && $aadhaardetails['district'] != "") ? $aadhaardetails['district'] : NULL;
            $data2['CDATA_DOB'] = date('Y-m-d', strtotime($aadhaardetails['dob']));
            $data2['CDATA_GENDER'] = (isset($aadhaardetails['gender']) && $aadhaardetails['gender'] != "") ? $aadhaardetails['gender'] : NULL;
            $data2['CDATA_OCCUPATION'] = (isset($occupation) && $occupation != "") ? $occupation : NULL;
            $data2['CDATA_COMMUNITY'] = (isset($religion) && $religion != "") ? $religion : NULL;
            $data2['CDATA_CASTE'] = "";
            $data2['CDATA_PREFER_DATE'] = isset($sch_date) ? $sch_date : NULL;
            $data2['CDATA_PREFER_TIMESLOT'] = (isset($_POST['TIMESLOT_CODE']) && $_POST['TIMESLOT_CODE'] != "") ? $_POST['TIMESLOT_CODE'] : NULL;
            $data2['CDATA_PINCODE'] = (isset($aadhaardetails['pincode']) && $aadhaardetails['pincode'] != "") ? $aadhaardetails['pincode'] : NULL;
            $data2['CDATA_INCOME_GROUP'] = (isset($income_group) && $income_group != "") ? $income_group : NULL;
            $data2['CDATA_ADDRESS'] = (isset($address1) && $address1) ? $address1 : NULL;
            $data2['CDATA_ADDRESS_2'] = (isset($address2) && $address2) ? $address2 : NULL;
            $data2['CDATA_NOMINEE_NAME'] = (isset($cust_acdata['SBREQ_NOMINEE_NAME']) && $cust_acdata['SBREQ_NOMINEE_NAME'] != "") ? $cust_acdata['SBREQ_NOMINEE_NAME'] : NULL;
            $data2['CDATA_NOMINEE_RELATION'] = (isset($cust_acdata['SBREQ_NOMINEE_RELATION']) && $cust_acdata['SBREQ_NOMINEE_RELATION'] != "") ? $cust_acdata['SBREQ_NOMINEE_RELATION'] : NULL;
            $data2['CDATA_NOMINEE_ADDRESS'] = (isset($cust_acdata['SBREQ_NOMINEE_ADDRESS']) && $cust_acdata['SBREQ_NOMINEE_ADDRESS'] != "") ? $cust_acdata['SBREQ_NOMINEE_ADDRESS'] : NULL;
            $data2['CDATA_NOMINEE_DOB'] = (isset($cust_acdata['SBREQ_NOMINEE_DOB']) && $cust_acdata['SBREQ_NOMINEE_DOB'] != "") ? $cust_acdata['SBREQ_NOMINEE_DOB'] : NULL;
            $data2['CDATA_IS_MINOR'] = (isset($cust_acdata['SBREQ_MINOR_FLAG']) && $cust_acdata['SBREQ_MINOR_FLAG'] != "") ? $cust_acdata['SBREQ_MINOR_FLAG'] : NULL;
            $data2['CDATA_GARDIAN_NAME'] = (isset($cust_acdata['SBREQ_NOMINEE_GUARDIAN']) && $cust_acdata['SBREQ_NOMINEE_GUARDIAN'] != "") ? $cust_acdata['SBREQ_NOMINEE_GUARDIAN'] : NULL;
            $data2['CDATA_GARDIAN_RELATION'] = (isset($cust_acdata['SBREQ_GUARDIAN_NATURE']) && $cust_acdata['SBREQ_GUARDIAN_NATURE'] != "") ? $cust_acdata['SBREQ_GUARDIAN_NATURE'] : NULL;
            $data2['CDATA_ACCOUNT_NUM'] = $cust_dtls['CBS_ACC_NUM'];
            $data2['CDATA_CUSTOMER_ID'] = $cust_dtls['CBS_CUST_ID'];        
            $data2['CR_BY'] = (isset($_SESSION['USER_REF_NUM']) && $_SESSION['USER_REF_NUM'] != "") ? $_SESSION['USER_REF_NUM'] : NULL;
            $data2['CR_ON'] = $sys_datetime;

            $db_output = $main_app->sql_insert_data($page_table_name_2,$data2); // Insert
            if($db_output == false) { $updated_flag = false; }
            
            if($updated_flag == true) {

                $data10 = array();
                $data10['SBREQ_VKYC_STATUS'] = "P";
                $db_output10 = $main_app->sql_update_data("SBREQ_MASTER", $data10, array( 'SBREQ_APP_NUM' => $cust_dtls['SBREQ_APP_NUM'] )); // Update
                if($db_output10 == false) { $updated_flag = false; }
            
                if($updated_flag == false) {
                    echo "<script> swal.fire('','Unable to update VKYC details'); loader_stop(); enable('sbt'); </script>";
                    exit();
                }
            }

            //store logs for vkyc - account upgrade
            if($updated_flag == true) {
                $data11 = array();
                $data11['VKYC_REF_NUM'] = $refer_num;
                $data11['VKYC_STATUS'] = "P";
                $data11['VKYC_STATUS_UPDATED_ON'] = $sys_datetime;
                $data11['MO_BY'] = $cust_dtls['SBREQ_APP_NUM'];
                $data11['MO_ON'] = $sys_datetime;

                $db_output11 = $main_app->sql_update_data("LOGS_SBREQ_ACUPGRADE", $data11, array( 'APP_REF_NUM' => $cust_dtls['SBREQ_APP_NUM'] )); // Update
                if($db_output11 == false) { $updated_flag = false; }
            
                if($updated_flag == false) {
                    echo "<script> swal.fire('','Unable to update VKYC Log'); loader_stop(); enable('sbt'); </script>";
                    exit();
                }
                
            } 

        }
    } 

elseif(isset($selectedValue) && $selectedValue == "RA") {

        $sql_exe4 = $main_app->sql_run("SELECT VKYC_REF_NUM FROM VKYC_REQUESTS WHERE EXTERNAL_INWARD_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
        $vkyc_dtls = $sql_exe4->fetch();
        
        $data3 = array();
        $data3['VKYC_MEETING_DATE'] = isset($sch_date) ? $sch_date : NULL;
        $data3['VKYC_PREFER_TIME'] = (isset($_POST['TIMESLOT_CODE']) && $_POST['TIMESLOT_CODE'] != "") ? $_POST['TIMESLOT_CODE'] : NULL;
        $data3['MO_BY'] = (isset($_SESSION['USER_REF_NUM']) && $_SESSION['USER_REF_NUM'] != "") ? $_SESSION['USER_REF_NUM'] : NULL;
        $data3['MO_ON'] = $sys_datetime;

        $db_output3 = $main_app->sql_update_data($page_table_name, $data3, array( 'VKYC_REF_NUM' => $vkyc_dtls['VKYC_REF_NUM'])); // Update
        if($db_output3 == false) { $updated_flag = false; }

        if($updated_flag == true) {

            $data4 = array();
            $data4['CDATA_PREFER_DATE'] = isset($sch_date) ? $sch_date : NULL;
            $data4['CDATA_PREFER_TIMESLOT'] = (isset($_POST['TIMESLOT_CODE']) && $_POST['TIMESLOT_CODE'] != "") ? $_POST['TIMESLOT_CODE'] : NULL;
            $data4['MO_BY'] = (isset($_SESSION['USER_REF_NUM']) && $_SESSION['USER_REF_NUM'] != "") ? $_SESSION['USER_REF_NUM'] : NULL;
            $data4['MO_ON'] = $sys_datetime;
                
            $db_output4 = $main_app->sql_update_data($page_table_name_2, $data4, array( 'CDATA_VKYC_REF_NUM' => $vkyc_dtls['VKYC_REF_NUM'])); // Update
            if($db_output4 == false) { $updated_flag = false; }

        }

    }
  

    /** Final */
    if ($updated_flag == true) {
        $go_url = APP_URL."/final-account-detail"; // Page Refresh URL
        $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
        echo "<script> swal.fire({ title:'VKYC Meeting Request Submitted', text:'You will receive details via SMS', icon:'success', allowOutsideClick:false, confirmButtonText:'OK' }).then(function (result) { if (result.value) { goto_url('" . $go_url . "'); loader_start(); } }); loader_stop(); enable('sbt'); </script>";
    } else {
        echo "<script> swal.fire({ title:'Error', text:'Unable to upload content', icon:'error', allowOutsideClick:false, confirmButtonText:'OK' }).then(function (result) { if (result.value) { } }); loader_stop(); enable('sbt'); </script>";
    }

}