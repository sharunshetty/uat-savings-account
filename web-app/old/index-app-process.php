<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

if(!isset($appProcessBar) || $appProcessBar == NULL) {
    $appProcessBar = "";
}

$ProcessList = array(
    'P1' => 'Verify Aadhaar',
    'P2' => 'Verify PAN Card',
    'P3' => 'Additional Details',
    'P4' => 'Apply for VKYC',
);

echo "<div class='arrow-steps clearfix d-none d-lg-block mb-4'>";

foreach($ProcessList as $ProListKey => $ProListVal) {
    if($ProListKey == $appProcessBar)
    echo "<div class='step current'><span>{$ProListVal}</span></div>";
    else
    echo "<div class='step'><span>{$ProListVal}</span></div>";
}

echo "</div>";

?>