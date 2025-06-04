<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../app-core/app_auto_load.php');

/** Check User Session */
require_once(dirname(__FILE__) . '/check-login.php');

/** Current Page */
$page_pgm_code = "";

$page_title = "Submit Application";
$page_link = "./form-basic-details";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_EKYC_FLAG, SBREQ_PAN_FLAG, SBREQ_APP_STATUS, SBREQ_CUST_NAME FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
  $ErrorMsg = "Unable to fetch application details";
}

$sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $appData['SBREQ_APP_NUM']));
$kycDetails = $sql_exe3->fetch();

if(isset($kycDetails['DOC_DATA']) && $kycDetails['DOC_DATA'] != "") {
  $kycDetails = json_decode(stream_get_contents($kycDetails['DOC_DATA']), true, JSON_UNESCAPED_SLASHES); 
}

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h">
      
      <form name="form-basic-details" id="form-basic-details" method="post" action="javascript:void(0);" class="form-material">
      <input type="hidden" name="cmd" value="form_basic_details">
      <input type="hidden" name="token" value="<?php echo (isset($_SESSION['APP_TOKEN'])) ? $_SESSION['APP_TOKEN'] : ""; ?>"/>
      <input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
      <input type="hidden" id="pKey" value="<?php echo $safe->rsa_public_key();?>" />
    
            <div class="h6 text-muted border-bottom pb-2">Customer Details</div>

            <div class="row mt-3 mb-4">

              <?php if(isset($_SESSION['name_flag']) && $_SESSION['name_flag'] == "Y") { ?>
              <div class="col-md-4 form-group">
                  <label class="col-md-12 label_head">Please enter Customer Full name <mand>*</mand></label>
                  <div class="col-md-12">
                  <input type="text" name="CUST_FULL_NAME" id="CUST_FULL_NAME" maxlength="" class="form-control border-input reset-form js-toUpper" autocomplete="none" value= "<?php echo $main_app->strsafe_input($appData['SBREQ_CUST_NAME']); ?>" >
                  <span id="name_change" class="text-danger small"><small>* Your name is different than Aadhaar and PAN in the PID. Kindly update the name to proceed for account opening. </small></span>
                  </div>
                </div>
              <?php } ?>

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Place of birth <mand>*</mand></label>
                <div class="col-md-12">
                  <select name="PLACE_OF_BIRTH" id="PLACE_OF_BIRTH" class="form-control border-input text-uppercase" autocomplete="none">
                  <option value="">-- Select --</option>
                  <?php
                    $sql_exe = $main_app->sql_run("SELECT DISTINCT LOCN_CODE, LOCN_NAME FROM LOCATION WHERE LOCN_CNTRY_CODE='IN' ORDER BY LOCN_NAME ASC");
                    while ($row = $sql_exe->fetch()) {
                        echo "<option value=".$row['LOCN_CODE'].">".$row['LOCN_NAME']."</option>";
                    }
                  ?>
                  </select>
                </div>
              </div>

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Occupation <mand>*</mand></label>
                <div class="col-md-12">
                  <select name="OCCUPATION" id="OCCUPATION" class="form-control border-input" autocomplete="none">
                  <option value="">-- Select --</option>
                  <?php
                    $sql_exe = $main_app->sql_run("SELECT OCCUPATIONS_CODE, OCCUPATIONS_DESCN FROM OCCUPATIONS ORDER BY OCCUPATIONS_DESCN ASC");
                    while ($row = $sql_exe->fetch()) {
                        echo "<option value=".$row['OCCUPATIONS_CODE'].">".$row['OCCUPATIONS_DESCN']."</option>";
                    }
                  ?>
                  </select>
                </div>
              </div> 

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Annual Income <mand>*</mand></label>
                <div class="col-md-12">
                  <select name="ANNUAL_INCOME" id="ANNUAL_INCOME" class="form-control border-input" autocomplete="none">
                  <option value="">-- Select --</option>
                  <?php
                    $sql_exe = $main_app->sql_run("SELECT INCSLAB_CODE, INCSLAB_DESCN FROM incomeslab ORDER BY INCSLAB_DESCN ASC");
                    while ($row = $sql_exe->fetch()) {
                        echo "<option value=".$row['INCSLAB_CODE'].">".$row['INCSLAB_DESCN']."</option>";
                    }
                  ?>
                  </select>
                </div>
              </div>
            
               <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Fathers name <mand>*</mand></label>
                <div class="col-md-12">
                  <?php if(isset($kycDetails['fatherName']) && $kycDetails['fatherName'] !="") { ?>
                    <input type="text" name="FATHERS_NAME" id="FATHERS_NAME"  value="<?php echo $kycDetails['fatherName']; ?>" class="form-control border-input reset-form" autocomplete='none' readonly>
                  <?php } else { ?>
                    <input type="text" name="FATHERS_NAME" id="FATHERS_NAME"  value="" class="form-control border-input reset-form" autocomplete="none">
                  <?php } ?> 
                </div>
              </div>

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Mothers name <mand>*</mand></label>
                <div class="col-md-12">
                <input type="text" name="MOTHERS_NAME" id="MOTHERS_NAME" maxlength="" class="form-control border-input reset-form" autocomplete="none">
                </div>
              </div>

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Date of birth <mand>*</mand></label>
                <div class="col-md-12">
                <input type="text" name="DOB" id="DOB" maxlength="" value="<?php echo isset($kycDetails['dob']) ? date('d-m-Y ',strtotime($kycDetails['dob'])) : ""; ?>" class="form-control border-input reset-form" autocomplete="none" readonly>
                </div>
              </div>

              <div class="col-md-4 form-group">
                  <label class="col-md-12 label_head">Marital Status <mand>*</mand></label>
                  <?php if((isset($kycDetails['gender']) && $kycDetails['gender'] == "F") && (isset($kycDetails['husbandName']) && $kycDetails['husbandName'] !="")) { ?>
                  <div class="col-md-12">
                    <select name="MARITAL_STATUS" id="MARITAL_STATUS" class="form-control border-input" autocomplete="off" readonly>
                      <option value="2"> Married </option>
                    </select>
                  </div>
                  <?php } else { ?>
                  <div class="col-md-12">
                        <select name="MARITAL_STATUS" id="MARITAL_STATUS" class="form-control border-input" autocomplete="off">
                        <option value="">-- Select --</option>
                        <option value="1"> Single</option>
                        <option value="2"> Married </option>
                        <option value="3"> Divorced </option>
                        </select>
                  </div>
                  <?php } ?>
              </div>

              <?php if(isset($kycDetails['husbandName']) && $kycDetails['husbandName'] !="") { ?>
              <div class="col-md-4 form-group">
                  <label class="col-md-12 label_head">Spouse Name <mand>*</mand></label>
                  <div class="col-md-12">
                    <input type="text" name="SPOUSE_NAME" id="SPOUSE_NAME" maxlength="" value="<?php echo $kycDetails['husbandName'] ?>" class="form-control border-input reset-form" autocomplete="none" readonly>
                  </div>
              </div>
              <?php } else { ?>
                <div class="col-md-4 form-group" id="spouse_name">
                  <label class="col-md-12 label_head">Spouse Name <mand>*</mand></label>
                  <div class="col-md-12">
                    <input type="text" name="SPOUSE_NAME" id="SPOUSE_NAME" maxlength="" value="" class="form-control border-input reset-form" autocomplete="none">
                  </div>
              </div>
              <?php } ?>

               <?php if(isset($kycDetails['relativeName']) && $kycDetails['relativeName'] !="") { ?>
                    <div class="col-md-4 form-group" id="rel_name">
                        <label class="col-md-12 label_head">Relative Name <mand>*</mand></label>
                        <div class="col-md-12">
                            <input type="text" name="RELATIVE_NAME" id="RELATIVE_NAME" maxlength=""
                                value="<?php echo $kycDetails['relativeName'] ?>"
                                class="form-control border-input reset-form" autocomplete="none">
                        </div>
                    </div>
                <?php } ?>

             <div class="col-md-4 form-group">
                  <label class="col-md-12 label_head">Qualification <mand>*</mand></label>
                  <div class="col-md-12">
                    <select name="QUALIFICATION" id="QUALIFICATION" class="form-control border-input" autocomplete="off">
                      <option value="">-- Select --</option>
                      <option value="UG">Under Graduate</option>
                      <option value="G"> Graduate </option>
                      <option value="PG"> Post Graduate and above </option>
                    </select>
                  </div>
              </div>

              <div class="col-md-4 form-group">
                  <label class="col-md-12 label_head">DBT Beneficiary <mand>*</mand></label>
                  <div class="col-md-12">
                    <select name="DBT_BENEFICIARY" id="DBT_BENEFICIARY" class="form-control border-input" autocomplete="off">
                      <option value="">-- Select --</option>
                      <option value="1">Yes</option>
                      <option value="0"> No </option>
                    </select>
                  </div>
              </div>

              <div class="col-md-4 form-group" id="spouse_name">
                  <label class="col-md-12 label_head">Nationality <mand>*</mand></label>
                  <div class="col-md-12">
                    <input type="text" name="NATIONALITY" id="NATIONALITY" maxlength="" class="form-control border-input reset-form" value="<?php echo isset($kycDetails['country']) ? $kycDetails['country'] : NULL; ?>" autocomplete="none" readonly>
                  </div>
              </div>

              <div class="col-md-4 form-group">
              <label class="col-md-12 label_head">Address <mand>*</mand></label>
              <div class="col-md-12">
                    <?php 
                     $combined_address = (isset($kycDetails['combinedAddress']) && $kycDetails['combinedAddress'] != NULL) ? $main_app->strsafe_output($kycDetails['combinedAddress']) : NULL;
                    echo '<textarea name="CUST_ADDRESS" id="CUST_ADDRESS" class="form-control border-input" rows="4" autocomplete="none" readonly>'.$combined_address.'</textarea>';

                  ?>
             
              </div>
              </div>

              
            <div class="col-md-12 form-group text-center mt-1 mb-3">
            <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="sbt" name="sbt" tabindex="3" onclick="send_form('form-basic-details', 'sbt');">Submit <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
            </div>

            </div>

       
      </form>

    </div>
  </div>

</div>


<!-- Content : End -->

<?php 
/** Page Footer */
require( dirname(__FILE__) . '/../theme/app-footer.php' );
?>

  <script type="text/javascript">

    $("#MARITAL_STATUS").on('change', function(){
      var mar_status = $('#MARITAL_STATUS').val();
      if(mar_status == "2") {
        show('spouse_name');
      } else {
        hide('spouse_name');
      }
    });

      $(document).ready(function(){

        $("#OCCUPATIONS").val('').select2();
        disable('DISTRICT_CODE');
        disable('TALUK');
        disable('BRANCH_CODE');
        hide('spouse_name');
        hide('guarddetails');

      });

  </script>

</body>
</html>