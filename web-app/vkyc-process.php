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

$page_title = "Video KYC process";
$page_link = "./vkyc-process";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_EKYC_FLAG, SBREQ_PAN_FLAG, SBREQ_VKYC_STATUS, CBS_ACC_NUM, CBS_SOL_ID FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h">
      
      <form name="vkyc-process" id="vkyc-process" method="post" action="javascript:void(0);" class="form-material">
      <input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
      <input type="hidden" id="pKey" value="<?php echo $safe->rsa_public_key();?>" />
      <div class="row justify-content-center my-4">

        <div class="col-lg-9 form-group">

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                     <div class="row">
                            <div class="col-md-12 mt-4 mb-1 text-center">
                                <div class="row">
                                    <div class="col-md-12 text-bold h3">Your Video KYC Request is under process..</div>
                                </div>
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