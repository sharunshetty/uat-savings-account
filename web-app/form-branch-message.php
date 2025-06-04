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
$page_link = "";

$parent_page_title = "";
$parent_page_link = "";


/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

    <div class="col-md-12 form-group">
        <div class="page-card box-min-h">

            <div class="row justify-content-center mt-4">

                <div class="col-md-12 form-group h4 txt-c1 text-center justify-content-center d-flex align-items-center" style="min-height: 50vh;color: #EE2225;">
              
                    <span>Please visit your nearest branch to complete VKYC </span>
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



</body>
</html>