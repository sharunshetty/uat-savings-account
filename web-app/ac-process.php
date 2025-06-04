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

$page_title = "Online Savings Account Opening";
$page_link = "./ac-process";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();


if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
    $ErrorMsg = "Unable to fetch application details";
}

if(!isset($appData['SBREQ_EKYC_FLAG']) || $appData['SBREQ_EKYC_FLAG'] == NULL || $appData['SBREQ_EKYC_FLAG'] != "Y") {
    header('Location: '.APP_URL.'/form-aadhaar');
    exit();
}
elseif(!isset($appData['SBREQ_PAN_FLAG']) || $appData['SBREQ_PAN_FLAG'] == NULL || $appData['SBREQ_PAN_FLAG'] != "Y") {
  header('Location: '.APP_URL.'/form-aadhaar-view');
  exit();
}
elseif(!isset($appData['SBREQ_BRANCH_FLAG']) || $appData['SBREQ_BRANCH_FLAG'] == NULL || $appData['SBREQ_BRANCH_FLAG'] != "Y") {
  header('Location: '.APP_URL.'/form-branch-details');
  exit();
}
elseif(!isset($appData['SBREQ_BASIC_DETAIL_FLG']) || $appData['SBREQ_BASIC_DETAIL_FLG'] == NULL || $appData['SBREQ_BASIC_DETAIL_FLG'] != "Y") {
  header('Location: '.APP_URL.'/form-basic-details');
  exit();
}
elseif(!isset($appData['SBREQ_NOM_DETL_FLG']) || $appData['SBREQ_NOM_DETL_FLG'] == NULL || $appData['SBREQ_NOM_DETL_FLG'] != "Y") {
  header('Location: '.APP_URL.'/form-nominee-details');
  exit();
}
elseif(!isset($appData['SBREQ_APP_STATUS']) || $appData['SBREQ_APP_STATUS'] == NULL || $appData['SBREQ_APP_STATUS'] != "S") {
  header('Location: '.APP_URL.'/form-nominee-details');
  exit();
}
elseif(isset($appData['SBREQ_APP_STATUS']) && $appData['SBREQ_APP_STATUS'] == "S") {
  header('Location: '.APP_URL.'/final-account-detail');
  exit();
}


/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h text-center text-danger">
        <div class="h5 mt-3">Error</div>
        <div class="h6"><?php echo $main_app->strsafe_output($ErrorMsg); ?></div>
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