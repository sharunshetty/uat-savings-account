<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

/** Check User Logged-In */
if(check_usr_login() == false) {
    header('Location: '.APP_URL.'/logout'); //?sess=expired
    exit();
}
