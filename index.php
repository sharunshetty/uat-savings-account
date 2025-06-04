<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @package     : LCode PHP WebFrame
 * @version     : 3.0.0
 * @project     : Savings Account - Video KYC
 * @created     : Feb 2021
 * @pro_version : 1.0.0
 * @developers  : Shivananda (Madhukar), Karthik
 * Last Updated : 08/02/2021
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/app-core/app_auto_load.php');

/** Redirect to Web-App directory */
header('Location: '.APP_URL.'/');
