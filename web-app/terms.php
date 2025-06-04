<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../app-core/app_auto_load.php');

/** Current Page */
$page_pgm_code = "";

$page_title = "Terms & Conditions";
$page_link = "./terms";

$parent_page_title = "";
$parent_page_link = "";

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h">
      <a href="https://www.capitalbank.co.in/TermsConditions/" target="_blank"><i><span class="mdi mdi-arrow-right"></span> Click here to view Terms & Conditions.</i></a>
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