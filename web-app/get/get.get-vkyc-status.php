<?php

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

/** Table Settings */
$page_table_name = "SBREQ_MASTER";
$primary_key = "SBREQ_APP_NUM";
$sbreq_app_num = isset($_POST['id']) ? $safe->str_decrypt($_POST['id'],$_SESSION['SAFE_KEY']) : ""; // Post ID

$primary_value = $sbreq_app_num; // Don't change

/** Get Tip */
if( isset($sbreq_app_num) && $sbreq_app_num != "") {
	$sql_exe = $main_app->sql_run("SELECT * FROM {$page_table_name} WHERE $primary_key = :primary_value",array('primary_value' => $primary_value));
	$item_data = $sql_exe->fetch();
}
    
?>


<?php if(isset($item_data) && $item_data) { $ModalLabel = "View VKYC Status"; } else { $ModalLabel = ""; } ?>

<!-- // Update // Start -->
<form id="myform" name="myform" method="post" action="javascript:void(null);" class="form-material">
<input type="hidden" name="cmd" id="cmd" value="update_vkyc_status"/>
<input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
<input type="hidden" id="pKey" value="<?php echo $safe->rsa_public_key();?>" />


    <div class="modal-body">
    <div class="row">

        <div class="col-md-12 form-group">
            <label class="col-md-12 label_head">Account Number </label>
            <div class="col-md-12">
                <?php echo $item_data['CBS_ACC_NUM'] ?>
            </div>
        </div>

        <?php 

        if(isset($item_data) && $item_data) { $ModalLabel = "Get Status"; } else { $ModalLabel = ""; }
        
        $html_op = "";

        $send_data = array();
        $send_data['METHOD_NAME'] = "getVkycStatus";
        $send_data['APPLICATION_NUMBER'] = $sbreq_app_num;

        try {
            $apiConn = new ReachMobApi;
            $output = $apiConn->ReachMobConnect($send_data, "60");
        } catch(Exception $e) {
            $ErrorMsg = $e->getMessage(); //Error from Class
        }

        // Test Data
        $output = json_decode('{"message":"Do you want to schedule for video KYC?","responseCode":"S","vkycStatus":"N"}', true);


        if(!isset($ErrorMsg) || $ErrorMsg == "") {
            if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
                $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
            }
        }

        if(isset($ErrorMsg) && $ErrorMsg != "") {
            echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop();  </script>";
            exit();
        }

        if(isset($output['vkycStatus']) && ($output['vkycStatus'] == 'S' || $output['vkycStatus']== 'R'))
        {
            $data = array();
            $data['SBREQ_VKYC_STATUS'] = $output['vkycStatus'];
            $db_output = $main_app->sql_update_data("SBREQ_MASTER", $data, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
            if($db_output == false) { $updated_flag = false; }
         
            if($updated_flag == false) {
                echo "<script> swal.fire('','Unable to update VKYC details'); loader_stop(); enable('sbt'); </script>";
                exit();
            }

        }

        ?>

        <div class="col-md-12 form-group">
            <label class="col-md-12 label_head">VKYC Status </label>
            <div class="col-md-12">
                <?php if(isset($output['vkycStatus']) && ($output['vkycStatus'])== 'N') { ?>
                    Do you want to schedule for video KYC?
                <?php } elseif (isset($output['vkycStatus']) && ($output['vkycStatus'])== 'U'){ ?>
                    Your VKYC request is under Review
                <?php } elseif(isset($output['vkycStatus']) && ($output['vkycStatus'])== 'H') { ?>
                    Your VKYC request is on Hold
                <?php } elseif(isset($output['vkycStatus']) && ($output['vkycStatus'])== 'M') { ?>               
                    'Your VKYC request is Scheduled On
                 <?php } elseif(isset($output['vkycStatus']) && ($output['vkycStatus'])== 'MH') { ?>               
                    Your VKYC request is Schedule is on Hold
                 <?php } elseif(isset($output['vkycStatus']) && ($output['vkycStatus'])== 'P') { ?>               
                    Your VKYC request is Pending for approval
                 <?php } elseif(isset($output['vkycStatus']) && ($output['vkycStatus'])== 'S') { ?>               
                    Your VKYC request is Approved
                 <?php } elseif(isset($output['vkycStatus']) && ($output['vkycStatus'])== 'R') { ?>               
                    Your VKYC request is Rejected, Kindly re initiate new Schedule
                    
                 <?php } else { ?>               
                    No Account Opening Application has received
                 <?php } ?>
            </div>
        </div>

       

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" name="sbt" id="sbt" onclick="update_content(); return false;">Submit</button>
    </div>

</form>
<!-- // End -->




<script type="text/javascript">

	$(document).ready(function() {

	//#ModalLabel
        $('#ModalWin-ModalLabel').html('<?php echo $ModalLabel; ?>');
	});

</script>