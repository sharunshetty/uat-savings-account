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

$page_title = "Aadhaar Verification";
$page_link = "./form-aadhaar-view";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_MOBILE_NUM, SBREQ_EKYC_FLAG FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
    $ErrorMsg = "Unable to fetch application details";
}

$sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $appData['SBREQ_APP_NUM']));
$kycDetails = $sql_exe3->fetch();

if(!isset($kycDetails['SBREQ_APP_NUM']) || !isset($appData['SBREQ_EKYC_FLAG']) || $appData['SBREQ_EKYC_FLAG'] != "Y") {
  header('Location: '.APP_URL.'/form-aadhaar');
  exit();
}

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

      <div class="row justify-content-center mt-4">

        <div class="col-md-12 form-group h5 txt-c1 text-center">Your Aadhaar Details</div>
        <div class="col-md-3 form-group text-center text-lg-right">
          <?php if(isset($kycDetails['image']) && $kycDetails['image'] != "") {
              $img_data = (gettype($kycDetails['image']) == "resource") ? stream_get_contents($kycDetails['image']) : $kycDetails['image'];
          } ?>
        <img height="160" width="130" class="mr-lg-4 mb-3" src="data:image/jpeg;charset=utf-8;base64,<?php echo $img_data; ?>" />
        </div>

        <div class="col-md-6 form-group">
          <div class="row">

              <div class="col-md-6 form-group">
                <label class="col-md-12 label_head">Name as per Aadhaar</label>
                <div class="col-md-12"><?php echo isset($kycDetails['name']) ? $main_app->strsafe_output($kycDetails['name']) : ""; ?></div>
              </div>

          </div>
          <div class="row">
              
              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Date of Birth</label>
                <div class="col-md-12"><?php echo isset($kycDetails['dob']) ? $main_app->strsafe_output($kycDetails['dob']) : ""; ?></div>
              </div>

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Gender</label>
                <div class="col-md-12"><?php echo isset($kycDetails['gender']) ? $main_app->strsafe_output($kycDetails['gender']) : ""; ?></div>
              </div>

              <div class="col-md-12 form-group">
                <label class="col-md-12 label_head">Address</label>
                <div class="col-md-12">
                  <?php 
		    $combined_address = (isset($kycDetails['combinedAddress']) && $kycDetails['combinedAddress'] != NULL) ? $main_app->strsafe_output($kycDetails['combinedAddress']) : NULL;
                    echo $combined_address."<br/>";
                  ?>
                </div>
              </div>

          </div>  
        </div>

        <div class="col-md-12 form-group text-center">
            <div class="input_div small">
              <label for="DetailAgree">
                <input type="checkbox" name="DetailAgree" id="DetailAgree" value="1" class="form-radio checkbox"> 
                I confirm that the above information is true
              </label>
            </div>
        </div>

        
        <div class="col-md-6 my-3 text-center">
          <button class="btn h-btn3 m-0 px-4 py-2" onclick="nextScreen();" tabindex="1">Continue  <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
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

   function nextScreen() {
        if( $('#DetailAgree').is(':checked') ){
          loader_start();
          goto_url('form-pan');
        }
        else{
            swal.fire('','Please click on checkbox');
        }
   }


  </script>

</body>
</html>