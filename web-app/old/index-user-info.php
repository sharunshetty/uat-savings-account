<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

?>

<div class="bg-note p-3">
<div class="row text-break">

    <div class="col-md-12 form-group2">
        <div class="col-md-12 text-info">Application Number</div>
        <div class="col-md-12"><?php echo isset($app_data['SBREQ_APP_NUM']) ? $main_app->strsafe_output($app_data['SBREQ_APP_NUM']) : ""; ?></div>
    </div>

    <div class="col-md-12 form-group2">
        <div class="col-md-12 text-info">Date of Birth</div>
        <div class="col-md-12"><?php echo isset($app_data['SBREQ_DOB_DATE']) ? $main_app->valid_date($app_data['SBREQ_DOB_DATE'],"d-m-Y") : ""; ?></div>
    </div>

    <div class="col-md-12 form-group2">
        <div class="col-md-12 text-info">Contact Details</div>
        <div class="col-md-12">
            <?php echo isset($app_data['SBREQ_MOBILE_NUM']) ? $main_app->strsafe_output($main_app->mask_mobile($app_data['SBREQ_MOBILE_NUM'])) : ""; ?><br/>
            <span class="small"><?php echo isset($app_data['SBREQ_EMAIL_ID']) ? $main_app->strsafe_output($main_app->mask_email($app_data['SBREQ_EMAIL_ID'])) : ""; ?></span>
        </div>
    </div>
    
</div>
</div>
