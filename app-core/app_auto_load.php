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

/** Product Configuration */
define('PRODUCT_NAME', 'OnlineSB');
define('PRODUCT_VERSION', '1.0.0');

/** Application */
define('APP_CODE', 'OnlineSB');
define('APP_URL', '/projects/uat-savings-account/web-app');

/** Content Delivery Network */
define('CDN_URL', '/projects/uat-savings-account');
define('CDN_VER', '1.0.8');

/** Application Settings */
define('APP_PRODUCTION', false); // TRUE = Production Server, FALSE = UAT Server
define('APP_SSL_MODE', true); // HTTPS: TRUE - Enabled, FALSE - Disabled
define('APP_DEBUG', false);
define('APP_MAINTENANCE', false);
define('APP_DB_AUDIT_LOG', false); // TRUE - Enabled, FALSE - Disabled
define('DIRPATH', dirname(__FILE__)); // Core path


/** ReachAPI Remote API Server */
if(APP_PRODUCTION == true) {

    define('API_REMOTE_ADDRESS', 'http://192.168.0.42:18080/ReachAcOpen/OnlineAcOpenApi'); // API Reach MB New
    define('API_REACH_MB_CHANNEL', 'CSFBWEB'); // Reach Channel ID

    /** AES Secret Key & IV & Random key */
    $safe_secret_key = "LCode@2012!#INTR";
    $safe_iv_key = "c664f7b3d8d9141e";

    // Documents Folder
    define('UPLOAD_DOCS_DIR', '/LCode/VKYC-Data');

    // Public Files (*Not Secure*)
    define('UPLOAD_PUBLIC_DIR', 'C:/XAMPP/htdocs/projects/uat-savings-account/uploads');
    define('UPLOAD_PUBLIC_CDN_URL', '/uat-savings-account/uploads');

} else {

    //define('API_REMOTE_ADDRESS', 'http://172.19.1.105:37070/ucomb/OnlineAcOpenApi'); // Sample
    define('API_REMOTE_ADDRESS', 'http://172.31.0.163:18080/ReachAcOpen/OnlineAcOpenApi'); // Internal server
    define('API_REACH_MB_CHANNEL', 'CSFBWEB'); // Reach Channel ID

    /** AES Secret Key & IV & Random key */
    $safe_secret_key = "LCode@2012!#INTR";
    $safe_iv_key = "c664f7b3d8d9141e";
    
    // Documents Folder
    define('UPLOAD_DOCS_DIR', '/LCode/VKYC-Data');

    // Public Files (*Not Secure*)
    define('UPLOAD_PUBLIC_DIR', '/var/www/html/uat-savings-account/uploads');
    define('UPLOAD_PUBLIC_CDN_URL', '/uat-savings-account/uploads');

}

/** User Idle Timeout */
define('APP_USR_TIMEOUT', '1800'); // Value in seconds: 60 = 1Min
define('APP_OTP_TIMEOUT', '1800');

/** Start Database Connection */
require_once( DIRPATH . '/database_conn.php');

$db = new Database();
$db_master = $db->db_connect_master(); // DB Conn.

/** App Settings */
require_once( DIRPATH . '/app_settings.php');

/** Web Configuration */
require_once( DIRPATH . '/set_config.php');

/** Custom Class */
require_once( DIRPATH . '/set_custom_class.php');

$main_app = new LCodeWebApp($db_master);
$safe = new Encryption();

/** Custom Functions */
require_once( DIRPATH . '/set_custom_func.php');
