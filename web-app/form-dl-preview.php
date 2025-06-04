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

$page_title = "DL Verification";
$page_link = "./form-dl-preview";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_MOBILE_NUM, SBREQ_DL_FLAG FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
    $ErrorMsg = "Unable to fetch application details";
}

if(!isset($appData['SBREQ_APP_NUM']) || !isset($appData['SBREQ_DL_FLAG']) || $appData['SBREQ_DL_FLAG'] != "Y") {
  header('Location: '.APP_URL.'/form-pan');
exit();
}

$sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'DL' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $appData['SBREQ_APP_NUM']));
$dlDetails = $sql_exe3->fetch();

if(!isset($dlDetails['SBREQ_APP_NUM']) || $dlDetails['SBREQ_APP_NUM'] == NULL || $dlDetails['SBREQ_APP_NUM'] == "") {
  $ErrorMsg = "Unable to fetch DL details";
}

if(isset($dlDetails['DOC_DATA']) && $dlDetails['DOC_DATA'] != "") {
  $dlData = json_decode(stream_get_contents($dlDetails['DOC_DATA']), true, JSON_UNESCAPED_SLASHES);
}   

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h">

      <div class="row justify-content-center mt-4">

        <div class="col-md-12 form-group h5 txt-c1 text-center">Driving Licence Details</div>

        <?php if(isset($ErrorMsg) && $ErrorMsg != "") { ?>
      
      <div class="text-danger text-center h6"><?php echo $main_app->strsafe_output($ErrorMsg); ?></div>

      <?php } else { ?>

        <div class="col-md-3 form-group text-center text-lg-right">
          <?php if(isset($dlData['img']) && $dlData['img'] != "") { 
              $img_data = (gettype($dlData['img']) == "resource") ? stream_get_contents($dlData['img']) : $dlData['img'];
            ?>  
          <img height="160" width="130" class="mr-lg-4 mb-3" src="data:image/jpeg;charset=utf-8;base64,<?php echo $img_data; ?>" />
          <?php } ?>
        </div>

        <div class="col-md-6 form-group">
          <div class="row">

              <div class="col-md-6 form-group">
                <label class="col-md-12 label_head">Name </label>
                <div class="col-md-12"><?php echo isset($dlData['name']) ? $main_app->strsafe_output($dlData['name']) : ""; ?></div>
              </div>

          </div>
          <div class="row">
              
              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Date of Birth</label>
                <div class="col-md-12"><?php echo isset($dlData['dob']) ? $main_app->strsafe_output(date('d-m-Y',strtotime($dlData['dob']))) : ""; ?></div>
              </div>

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Blood group</label>
                <div class="col-md-12"><?php echo isset($dlData['boodGroup']) ? $main_app->strsafe_output($dlData['boodGroup']) : ""; ?></div>
              </div>
              
              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Fathers Name</label>
                <div class="col-md-12"><?php echo isset($dlData['fatherName']) ? $main_app->strsafe_output($dlData['fatherName']) : ""; ?></div>
              </div>

              
              <div class="col-md-6 my-3 text-center">
                <button class="btn h-btn3 m-0 px-4 py-2" onclick="nextScreen();" tabindex="1">Continue  <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
              </div>

          </div>  
        </div>

        <?php } ?>

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
     loader_start();
     goto_url('form-final-details');
   }

  </script>

</body>
</html>