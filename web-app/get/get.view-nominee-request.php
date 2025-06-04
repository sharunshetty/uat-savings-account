<?php

// /** No Direct Access */
defined('PRODUCT_NAME') OR exit();

/** Table Settings */
$page_table_name = "SBREQ_ACCOUNTDATA";
$primary_key = "SBREQ_APP_NUM";
$sbreq_app_num = isset($_POST['id']) ? $safe->str_decrypt($_POST['id'],$_SESSION['SAFE_KEY']) : ""; // Post ID

$primary_value = $sbreq_app_num; // Don't change

/** Get Tip */
if( isset($sbreq_app_num) && $sbreq_app_num != "") {
	$sql_exe = $main_app->sql_run("SELECT * FROM {$page_table_name} WHERE $primary_key = :primary_value",array('primary_value' => $primary_value));
	$item_data = $sql_exe->fetch();
}

if(!isset($item_data['SBREQ_APP_NUM']) || $item_data['SBREQ_APP_NUM'] == NULL || $item_data['SBREQ_APP_NUM'] == "") {
    echo "<script> swal.fire('','Unable to validate your request'); loader_stop(); enable('sbt'); </script>";
    exit();
}
    
?>

<?php if(isset($item_data) && $item_data) { $ModalLabel = "Nominee Details - " . $primary_value; } else { $ModalLabel = ""; } ?>

<form id="myform" name="myform" method="post" action="javascript:void(null);" class="form-material">
    
	<input type="hidden" name="cmd" id="cmd" value="update_nominee_request"/>
	<input type="hidden" name="token" value="<?php echo (isset($_SESSION['APP_TOKEN'])) ? $_SESSION['APP_TOKEN'] : ""; ?>" />
	<input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
    
	<div class="modal-body min-div" id="load-content">
	
		<div class="row justify-content-center">
			<div class="col-md-6">
				<label class="col-md-12 label_head">Nominee Name </label>  
				<input type="text" name="NOMINEE_NAME" class="form-control border-input js-isNumeric" value="<?php echo isset($item_data['SBREQ_NOMINEE_NAME']) ? $item_data['SBREQ_NOMINEE_NAME'] : ""; ?>" readonly>
			</div> 
			
			<div class="col-md-6">
				<label class="col-md-12 label_head">Nominee DOB </label>
				<input type="text" name="NOMINEE_DOB" class="form-control border-input" value="<?php echo isset($item_data['SBREQ_NOMINEE_DOB']) ? $main_app->strsafe_output(date('d-m-Y',strtotime($item_data['SBREQ_NOMINEE_DOB']))) : ""; ?>" readonly>
			</div> 
		</div> 

		<div class="row justify-content-center mt-3">
			<div class="col-md-6">
				<label class="col-md-12 label_head">Nominee Relation </label>
				<input type="text" name="NOMINEE_RELATION" class="form-control border-input js-isNumeric" value="<?php echo isset($item_data['SBREQ_NOMINEE_RELATION']) ? $item_data['SBREQ_NOMINEE_RELATION'] : ""; ?>" readonly>
			</div>

			<div class="col-md-6">
				<label class="col-md-12 label_head">Nominee Address </label>
				<input type="text" name="NOMINEE_ADDRESS" class="form-control border-input js-isNumeric" value="<?php echo isset($item_data['SBREQ_NOMINEE_ADDRESS']) ? $item_data['SBREQ_NOMINEE_ADDRESS'] : ""; ?>" readonly>
			</div> 
		</div>

		<?php 
		
		if($item_data['SBREQ_MINOR_FLAG']=='Y') { ?>
			<div class="row justify-content-center mt-3">
				
				<?php
					if($item_data['SBREQ_GUARDIAN_NATURE']=='F'){
						$guard_nature='Father';
					}else if($item_data['SBREQ_GUARDIAN_NATURE']=='M'){
						$guard_nature='Mother';
					}else if($item_data['SBREQ_GUARDIAN_NATURE']=='O'){
						$guard_nature='Others';
					}
				?>

				<div class="col-md-6">
					<label class="col-md-12 label_head">Nature of the Guardian</label>
					<input type="text" name="NATURE_GUARDIAN"  class="form-control border-input js-isNumeric" value="<?php echo isset($guard_nature) ? $guard_nature : ""; ?>" autocomplete="off" readonly>
				</div>

				<div class="col-md-6">
					<label class="col-md-12 label_head">Guardian Name</label>
					<input type="text"  name="GUARDIAN_NAME"  class="form-control border-input js-isNumeric" value="<?php echo isset($item_data['SBREQ_NOMINEE_GUARDIAN']) ? $item_data['SBREQ_NOMINEE_GUARDIAN'] : ""; ?>" autocomplete="off" readonly>
				</div> 
			</div>

		<?php } ?>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    	<button type="button" class="btn btn-primary" name="sbt" id="sbt" onclick="send_form('myform'); return false;">Submit</button>
	</div>

</form>
<!-- // End -->




<script type="text/javascript">

	$(document).ready(function() {
	  //#ModalLabel
          $('#ModalWin-ModalLabel').html('<?php echo $ModalLabel; ?>');
	});

</script>