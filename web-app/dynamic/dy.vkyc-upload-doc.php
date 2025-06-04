<?php
/**
 * POWERED BY 	: LCODE TECHNOLOGIES PVT. LTD.
 * DEVELOPER  	: SHIVANANDA SHENOY (MB)
 **/

/** NO DIRECT ACCESS **/
defined('PRODUCT_NAME') OR exit();

if(!isset($_POST['FILE_CODE']) || $_POST['FILE_CODE'] == NULL || $_POST['FILE_CODE'] == "" ) {
    echo "<script> swal.fire('','Invalid Request'); loader_stop(); </script>";
    exit();
}

$i = $_POST['FILE_CODE'];

$plain_arn_val = $safe->str_decrypt($_POST['APP_REF_NUM'], $_SESSION['SAFE_KEY']);
$html_op = "";

// File Configs
$allowed_ext = ['jpg'];
$allowed_mimes = ['image/jpg', 'image/jpeg'];
$allowed_size = "500000"; //Bytes // - 2097152 = 2MB // 550000 = 550KB // 350000 = 350 KB  500000 = 500 KB
$Extension = "";


function is_image($path) {
    try{

        $a = getimagesize($path);
        $image_type = $a[2];
        if($image_type == IMAGETYPE_JPEG){
            if(imagecreatefromjpeg($path)){
                return true;
            }
        }
    }
    catch(Exception $e) {
        return false;
    }
}


if(isset($_FILES['UPLOAD_FILE']) && !empty($_FILES['UPLOAD_FILE']) && $_FILES['UPLOAD_FILE']['error'] == 0) {

    $dataName = $_FILES['UPLOAD_FILE']['name'];
    $dataSize = $_FILES['UPLOAD_FILE']['size'];
    $dataTmpName  = $_FILES['UPLOAD_FILE']['tmp_name'];
    $dataType = $_FILES['UPLOAD_FILE']['type'];
    $dataTmp = explode('.', $dataName);
    $Extension = strtolower(end($dataTmp));
    $fileName = $dataName;
    $FILE_EXTSN = $Extension;

}

//Allow File Codes
// $allowed_fileCodes = array("PAN", "AADHAARF", "AADHAARB", "PASSPORTF", "PASSPORTB", "VOTERID", "VOTERIDB", "DL", "DLB");

if(!isset($_POST['FILE_CODE']) || $_POST['FILE_CODE'] == "") {
    echo "<script> swal.fire('','W01: Select valid document type'); enable('sbt'); enable('".$_POST['FILE_CODE']."_BTN'); loader_stop(); </script>";
}
elseif($_POST['FILE_CODE'] != "AADHAAR1F" && $_POST['FILE_CODE'] != "AADHAAR2B" && $_POST['FILE_CODE'] != "PAN" && $_POST['FILE_CODE'] != "SELF" && $_POST['FILE_CODE'] != "SIGN") {
    echo "<script> swal.fire('','W01: Invalid document'); enable('sbt'); enable('".$_POST['FILE_CODE']."_BTN'); loader_stop(); </script>";
}
elseif(!isset($_FILES['UPLOAD_FILE']['name']) || empty($_FILES['UPLOAD_FILE']['name'] || $_FILES['UPLOAD_FILE']['tmp_name'] == NULL)) {
    echo "<script> swal.fire('','W05: Please select file'); enable('sbt'); enable('".$_POST['FILE_CODE']."_BTN'); loader_stop(); </script>";
}
elseif($_FILES['UPLOAD_FILE']['error'] != 0 || !is_uploaded_file($_FILES['UPLOAD_FILE']['tmp_name'])) {
    echo "<script> swal.fire('','W06: file not uploaded'); enable('sbt'); enable('".$_POST['FILE_CODE']."_BTN'); loader_stop(); </script>";
}
elseif(!in_array($Extension,$allowed_ext) ) { //|| !in_array($dataType,$allowed_mimes)
    echo "<script> swal.fire('','W07: Unsupported file format'); enable('".$_POST['FILE_CODE']."_BTN'); enable('sbt'); loader_stop();</script>";
}
elseif(!empty($_FILES['UPLOAD_FILE']['name']) && $dataSize > $allowed_size) {
    echo "<script> swal.fire('','W08: Maximum file size 500 KB'); enable('sbt'); enable('".$_POST['FILE_CODE']."_BTN'); loader_stop(); </script>";
}
elseif(is_image($_FILES['UPLOAD_FILE']['tmp_name']) == false) {
    echo "<script> swal.fire('','W09: Invalid file type uploaded'); enable('".$_POST['FILE_CODE']."_BTN'); enable('sbt'); loader_stop(); </script>";
}
else {

    $data = file_get_contents($dataTmpName); //Files 
    
    // $data_file = base64_encode($fileName);
    $data_file = base64_encode($data);

    $updated_flag = true;
    $sys_datetime = date("Y-m-d H:i:s");

    $send_data = array();
    $send_data['METHOD_NAME'] = "VKYCUploadDoc";
    $send_data['APPLICATION_NUMBER'] = $plain_arn_val;
    // $send_data['DOC_DATA'] = $fileName;
    $send_data['DOC_DATA'] = $data_file;
    $send_data['DOC_CODE'] = $_POST['FILE_CODE'];

    //Call VKYC API
    try{
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
        // $html_op .= '<option value="">'.$ErrorMsg.'</option>';
        // echo "<script> $('#brnName').html('".$main_app->strsafe_output($html_op)."'); enable('brnName'); </script>";
    }

    if(isset($output['docPath']) && $output['docPath'] != "") {

        // Store to DB

        $totalResults = $main_app->sql_fetchcolumn("SELECT COUNT(0) FROM SBREQ_UPLOADS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = :DOC_CODE", array('SBREQ_APP_NUM' => $plain_arn_val, 'DOC_CODE' => $_POST['FILE_CODE']));

        if($totalResults && $totalResults > "0") {

            $data2 = array();
            $data2['DOC_DATA'] = $output['docPath'];
            $data2['MO_ON'] = date("Y-m-d H:i:s");
            $db_output2 = $main_app->sql_update_data("SBREQ_UPLOADS", $data2, array( 'SBREQ_APP_NUM' => $plain_arn_val, 'DOC_CODE' => $_POST['FILE_CODE'])); // Update
            if($db_output2 == false) { $updated_flag = false; }

        } else {

            $data = array();
            $data['SBREQ_APP_NUM'] = $plain_arn_val;
            $data['DOC_CODE'] = $_POST['FILE_CODE'];
            $data['DOC_DATA'] = $output['docPath'];
            $data['CR_ON'] = date("Y-m-d H:i:s");
            $db_output = $main_app->sql_insert_data("SBREQ_UPLOADS", $data); // Insert
            if($db_output == false) { $updated_flag = false; }

        }

        //Response

        $add_row ="";
        $add_row .= '<a class="font-weight-bold text-success">Uploaded <i class="mdi mdi-check"></i></a>';
        $output_val = $safe->str_encrypt($output['docPath'], $_SESSION['SAFE_KEY']);
        echo "<script> $('#".$_POST['FILE_CODE']."_TXT').html('".$add_row."'); hide('".$_POST['FILE_CODE']."_SELECT'); </script>";
        echo "<script> $('#".$_POST['FILE_CODE']."_FILE').val('".$output_val."'); </script>";

    }
    else {

        echo "<script> swal.fire('','Unable to get Document List Information'); loader_stop();  </script>";

    }

    echo "<script> loader_stop(); hide('".$_POST['FILE_CODE']."_BTN'); </script>";

}

?>