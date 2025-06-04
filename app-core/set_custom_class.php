<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @package     : LCode PHP WebFrame
 * @version     : 3.0.0
 **/

/** No Direct Access */
defined('DIRPATH') OR exit();

/** Load Plugin Class */
require_once( DIRPATH . '/class/class_mod_browser.php'); // Browser Detection Class
//require_once( DIRPATH . '/class/class_mod_mail.php'); // PHPMailer Class

/** Load Application Class */
require_once( DIRPATH . '/class/class_app_encrypt.php'); // Encryption & Decryption Class
//require_once( DIRPATH . '/class/class_app_reachapi.php'); // ReachWeb API (JSON Comm.)
require_once( DIRPATH . '/class/class_mod_sendalerts.php'); // SMS & EMAIL Queue
require_once( DIRPATH . '/class/class_app_reach_mb.php'); // Reach Mobile API (JSON Comm.)
require_once( DIRPATH . '/class/class_app_external_api.php'); //External API : Template Based
require_once( DIRPATH . '/class/class_app_remote.php'); // Remote API Connect Class
require_once( DIRPATH . '/class/class_app_data.php'); // User Interface Class
require_once( DIRPATH . '/class/class_app_core.php'); // App Core Class
