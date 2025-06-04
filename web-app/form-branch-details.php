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

$page_title = "Branch Details";
$page_link = "./form-branch-details";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_EKYC_FLAG, SBREQ_PAN_FLAG, SBREQ_APP_STATUS FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
  $ErrorMsg = "Unable to fetch application details";
}

$sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $appData['SBREQ_APP_NUM']));
$kycDetails = $sql_exe3->fetch();

if(isset($kycDetails['DOC_DATA']) && $kycDetails['DOC_DATA'] != "") {
  $kycDetails = json_decode(stream_get_contents($kycDetails['DOC_DATA']), true, JSON_UNESCAPED_SLASHES); 
}

/*$pincode = "149024";*/

$pincode = $kycDetails['pincode'];

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h ">
      
      <form name="branch-details" id="branch-details" method="post" action="javascript:void(0);" class="form-material">
      <input type="hidden" name="cmd" value="form_branch_details">
      <input type="hidden" name="token" value="<?php echo (isset($_SESSION['APP_TOKEN'])) ? $_SESSION['APP_TOKEN'] : ""; ?>"/>
      <input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
      <input type="hidden" id="pKey" value="<?php echo $safe->rsa_public_key();?>" />
      <input type="hidden" id="pCode" value="<?php echo $pincode;?>" />

            <div class="row mt-3 mb-4">

              
              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">State <mand>*</mand></label>
                <div class="col-md-12">
                  <select name="STATE" id="STATE" class="form-control border-input text-uppercase" autocomplete="off">
                  </select>
                </div>
              </div>

            

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">City <mand>*</mand></label>
                <div class="col-md-12">
                  <!-- <input type="text" name="DISTRICT_NAME" id="DISTRICT_NAME" class="form-control border-input" autocomplete="off" readonly>
                  <input type="hidden" name="DISTRICT_CODE" id="DISTRICT_CODE" value=""> -->
                   <select name="DISTRICT_CODE" id="DISTRICT_CODE" class="form-control border-input text-uppercase" autocomplete="off">   
                    </select>
                </div>
              </div>
    
              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Branch code & Name<mand>*</mand></label>
                <div class="col-md-12">
                   <select name="BRANCH_CODE" id="BRANCH_CODE" class="form-control border-input text-uppercase" autocomplete="off">
                    </select>
                </div>

                
              </div>

            </div>

            <div class="col-md-4 form-group">
              <label class="col-md-12 label_head">Product <mand>*</mand></label>
              <div class="col-md-12">
                <select name="PRODUCT_CODE" id="PRODUCT_CODE" class="form-control border-input" autocomplete="none">
                <?php
                    $sql_exe = $main_app->sql_run("SELECT PRODUCT_CODE, PRODUCT_DESC FROM SBREQ_PRODUCT_CODE WHERE PRODUCT_STATUS = '1' ORDER BY PRODUCT_DESC ASC");
                    while ($row = $sql_exe->fetch()) {
                        echo "<option value=".$row['PRODUCT_CODE'].">".$row['PRODUCT_DESC']. "</option>";
                    }
                  ?>
                  </select>
                  <a href="https://www.capitalbank.co.in/home/accounts/savings/e-savings-account" target="_blank">Click here for Product Details</a>
              </div>
            </div>

            <div class="col-md-12 form-group text-center mt-1 mb-3">
            <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="sbt" name="sbt" tabindex="3" onclick="send_form('branch-details', 'sbt');">Submit <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
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
       /****server */

  //  //on change state
  //     $("#STATE").on('change', function() {
  //       $('#BRANCH_CODE').find('option').remove();
  //       disable('DISTRICT_CODE');
  //       on_change('sb-enq-district','modify',this.value, 'STATE');
  //     });

  //     //on change district
  //     $("#DISTRICT_CODE").on('change', function() {
  //       var state_val = $('#STATE').val();
  //       var district_val = $('#DISTRICT_CODE').val();
  //       disable('BRANCH_CODE');
  //       on_change('sb-enq-district','modify',state_val+'|'+district_val, 'DISTRICT' );

  //     });

  //     $(document).ready(function(){
  //       var pincode_val = $('#pCode').val();
  //       on_change('sb-enq-district','modify',pincode_val, 'PINCODE');
  //     });



     /****localhost */
      //on change state
      $("#STATE").on('change', function() {
        //$("#BRANCH_CODE").attr("selected", false); //Unselect each option
        $('#BRANCH_CODE').find('option').remove();
        disable('DISTRICT_CODE');
        on_change('sb-enq-district','modify',this.value, 'STATE');
      });

      //on change district
      $("#DISTRICT_CODE").on('change', function() {
        // disable('TALUK');
        disable('BRANCH_CODE');
        on_change('sb-enq-district','modify',this.value, 'DISTRICT' );
      });

      $(document).ready(function(){

       var pincode_val = $('#pCode').val();
       on_change('sb-enq-district','modify',pincode_val, 'PINCODE');

      });

     
  </script>

</body>
</html>