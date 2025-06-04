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

$page_title = "";
$page_link = "./";

$parent_page_title = "";
$parent_page_link = "";

/** Get Application Details */
$sql_exe = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_APP_STATUS, SBREQ_MOBILE_NUM, SBREQ_EMAIL_ID, SBREQ_DOB_DATE, SBREQ_PAN_NUM, SBREQ_PAN_NAME FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array('SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM']));
$app_data = $sql_exe->fetch();

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<!-- L1 -->
<div class="row">

  <div class="col-md-12 col-lg-12 form-group order-2 order-lg-1">
    <div class="page-card">

    <div class="row">

      <div class="col-lg-12">
      <?php
      $appProcessBar = "P1";
      include( dirname(__FILE__) . '/index-app-process.php' );
      ?>
      </div>

      <div class="col-lg-9 form-group mb-5">

        <div class="h5 text-center mb-4">Aadhaar e-KYC Verification</div>

        <ul class="nav nav-tabs" id="myP1Tab" role="tablist" style="display: none;">
        <li class="nav-item"><a class="nav-link active" id="tab-adt-1" data-toggle="tab" href="#adt-1" role="tab" aria-controls="adt-1" aria-selected="true">tab 1</a></li>
        <li class="nav-item"><a class="nav-link" id="tab-adt-2" data-toggle="tab" href="#adt-2" role="tab" aria-controls="adt-2" aria-selected="false">tab 2</a></li>
        </ul>

        <div class="tab-content w-100" id="myP1TabContent">

          <!-- Tab 1 : Start -->
          <div class="tab-pane show active" id="adt-1" role="tabpanel" aria-labelledby="adt-1">

            <div class="row justify-content-md-center">
              <div class="col-lg-8 form-group text-justify">
              I am providing my Aadhaar Card details to the Bank and give my consent for Bank's action to perform Aadhaar based authentication using e-KYC authentication facility for account opening. I agree and hereby authorize Reach Bank to featch my personal deatils from UIDAI. I confirm that no other account has been opened nor will be opening using OTP based e-KYC with any other bank.
              </div>
              <div class="col-lg-8 form-group text-center mt-3">
                <button onclick="LogoutAlert();" class="btn btn-outline-secondary btn-ux" id="btnP1Cancel">Cancel</button>
                <button data-toggle="tab" href="#adt-2" role="tab" aria-controls="adt-2" class="btn btn-ux btn-ux-success" id="btn-adt-2">Proceed <span class="mdi mdi-arrow-right"></span></button>
              </div>
            </div>

          </div>

          <!-- Tab 2 : Start -->
          <div class="tab-pane fade" id="adt-2" role="tabpanel" aria-labelledby="adt-2">
          
            <form id="app-form" name="app-form" method="post" action="javascript:void(null);" class="form-material">
            <input type="hidden" name="cmd" value="master_city"/>
            <input type="hidden" name="token" value="<?php echo (isset($_SESSION['APP_TOKEN'])) ? $_SESSION['APP_TOKEN'] : ""; ?>"/>
            <div class="row justify-content-md-center">

              <div class="col-md-5 col-lg-5 form-group">
              <label class="col-md-12 label_head">Enter your Aadhaar Number / Virtual ID (VID)</label>
              <div class="col-md-12">
                <input type="text" name="AADHAAR_VID" id="AADHAAR_VID" placeholder="" maxlength="20" class="form-control border-input js-isNumeric" autocomplete="off">
              </div>
              </div>
            
            </div>
            <div class="row justify-content-md-center">

              <div class="col-md-5 col-lg-5 form-group">
              <label class="col-md-12 label_head">Verification Mode</label>
              <div class="col-md-12 customRadio input_div">
                <label for="item1">
                  <input type="radio" class="form-radio" id="item1" name="AADHAAR_VMODE" value="1" autocomplete="off">
                  <span>ONLINE</span>
                </label>
                <label for="item2">
                  <input type="radio" class="form-radio" id="item2" name="AADHAAR_VMODE" value="2" autocomplete="off">
                  <span>OFFLINE (using XML)</span>
                </label>
              </div>
              </div>

            </div>
            <div class="row">

              <div class="col-md-12 text-center">
              <button type="button" tabIndex="-1" class="btn btn-outline-secondary btn-ux" onclick="$('#app-form').trigger('reset');$('.reset-form').empty();">Reset</button>
              <button type="button" class="btn btn-ux btn-ux-primary" name="sbt" id="sbt" onclick="send_form(); return false;">Submit <span class="mdi mdi-arrow-right"></span></button>
              </div>
            
            </div>
            </form>

          </div>

        </div>

      </div>
  
      <div class="col-lg-3 form-group">
      <div class="h6">Request Details</div>
      <?php include( dirname(__FILE__) . '/index-user-info.php' ); ?>
      </div>

    </div>

    </div>
  </div>

</div>

<!-- Content : End -->

<?php 
/** Page Footer */
require( dirname(__FILE__) . '/../theme/app-footer.php' );
?>

  <script type="text/javascript">
  </script>

</body>
</html>