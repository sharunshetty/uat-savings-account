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

$page_title = "Post-VKYC Schedule Screen";
$page_link = "./vkyc-scheduled";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_EKYC_FLAG, SBREQ_PAN_FLAG, SBREQ_VKYC_STATUS FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
  $ErrorMsg = "Unable to fetch application details";
}


/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h">
      
      <form name="form-final-verify" id="form-final-verify" method="post" action="javascript:void(0);" class="form-material">
      <input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
      <input type="hidden" id="pKey" value="<?php echo $safe->rsa_public_key();?>" />
      <div class="row justify-content-center my-4">

        <div class="col-lg-9 form-group">

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="box400 text-center my-4 pb-1 col-md-6 card card-border lc-card">
                        <div class="row">
                              <div class="col-md-12 text-center justify-content-center mt-3" style="color:cornflowerblue">
                                  <span class="col-md-12 h5" >Your Video KYC has been scheduled</span>
                              </div>

                            <div class="col-md-12 text-muted font-weight-bold text-left title4 mt-4">Please find Your Digital Savings Account details</div>
                            <div class="col-md-12 mt-3 mb-1 text-left">
                                <div class="row">
                                    <div class="col-md-6 ">Account number</div>
                                    <div class="col-md-6">123456789090</div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 ">Account Name</div>
                                    <div class="col-md-6">HARSHITHA GOWDA</div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 ">IFSC Code</div>
                                    <div class="col-md-6">BRN78989</div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 ">Branch Name</div>
                                    <div class="col-md-6">Mangalore</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                         <div class="lc-card mt-4" style="display: none;">
                            <img src="<?php echo CDN_URL; ?>/uploads/images/kyc.jpg"  width="300" height= "200" class="text-center">
                             <button type="submit" class="btn h-btn3 mb-4 mt-3" id="sbt" name="sbt" tabindex="3"> Schedule Video KYC Now <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
                             <?php if(!isset($appData['VKYC_STATUS']) || $appData['VKYC_STATUS'] == "P") { ?>
                            <label class="btn btn-success mb-4 mt-3" id="sbt" name="sbt" tabindex="3"> Your Video KYC Status is pending </label>
                             <?php } else { ?>
                             <label class="btn btn-success mb-4 mt-3" id="sbt" name="sbt" tabindex="3"> Your Video KYC Status is in progress </label>
                             <?php } ?>
                            </div>
                    </div>
                    <div class="col-md-12">
                         <div class="lc-card mt-4">
                             <div class="text-center" style="color:brown;"> Do you want to upgrade your account?   Please download App</div>
                              <button type="submit" class="btn btn-danger mt-3 mb-4" id="sbt" name="sbt" tabindex="3">Download Now <span><i class="mdi mdi-arrow-down"></i></span></button>
                        </div>
                    </div>
                    
                </div>

            </div>
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

</body>
</html>