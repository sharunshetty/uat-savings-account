<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <!-- ============================================================== -->
    <!-- ######### POWERED BY LCODE TECHNOLOGIES PVT. LTD. ############ -->
    <!-- ============================================================== -->

    <title><?php echo (isset($page_title) && $page_title != NULL) ? $page_title : BRAND_SHORT_NAME." - ".APP_NAME; ?></title>
   
<meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="shortcut icon" href="<?php echo CDN_URL; ?>/favicon.ico" type="image/ico"/>
    <link rel="manifest" href="<?php echo CDN_URL; ?>/manifest.json">

    <!-- CSS-->
    <link rel="stylesheet" href="<?php echo CDN_URL; ?>/theme/css/style-main.css?v=<?php echo CDN_VER; ?>" type="text/css" media="screen"/>
    <?php
    /** Extra Headers */
    echo (isset($page_headers)) ? $page_headers : "";
    ?>

</head>
<!-- <body class="no-scroll" style="overflow-y:hidden;"> -->
<body>
<div class="page-container">

<header class="cd-auto-hide-header">
<div class="container">

    <div class="row pt-1">
        <div class="col-6">
        <a href="<?php echo APP_URL; ?>/"><img src="<?php echo CDN_URL; ?>/uploads/images/csfb_logo.png" alt="<?php echo BRAND_NAME; ?>" class="nav-head-logo"></a>
        </div>
        <div class="col-6 text-left text-md-right">

            <nav class="cd-primary-nav">
           <?php if(isset($_SESSION['USER_REF_NUM']) || isset($_SESSION['OTP_REQ_ID'])) { ?>

            <a href="#cd-navigation" class="nav-trigger">
                <span>
                    <em aria-hidden="true"></em>
                    Menu
                </span>
            </a>
           <?php } ?>

            
            <ul id="cd-navigation">

            <?php if(isset($_SESSION['USER_REF_NUM']) || isset($_SESSION['OTP_REQ_ID'])) { ?>
            <?php if(isset($_SESSION['USER_REF_NUM']) && $_SESSION['USER_REF_NUM'] != "" && isset($_SESSION['SMS_VERIFIED_FLAG']) && $_SESSION['SMS_VERIFIED_FLAG'] == "S" && isset($_SESSION['EMAIL_VERIFIED_FLAG']) && $_SESSION['EMAIL_VERIFIED_FLAG'] == "S") { ?>
                <li><a href="<?php echo APP_URL; ?>/ac-process" class="start-loader">My Application</a></li>
                <li><a href="javascript:void(0);" onClick="LogoutAlert();" class="text-danger">Logout</a></li>
                <?php } ?>
            <?php } else { ?>
                <li><i class="mdi mdi-phone text-danger"></i>  1800 120 1600</li>
            <?php } ?>
                
            </ul>
            </nav>

        </div>
    </div>


</div>
</header>
        
        <main class="cd-main-content animate__animated animate__fadeIn">
        <div class="container">

        <div class="row">
            <div class="col-lg-8">
                <div class="page-title">
                <?php echo (isset($page_title) && $page_title != "") ? $page_title : ""; ?>
                </div>
            </div>
            <?php if(isset($_SESSION['USER_REF_NUM']) && $_SESSION['USER_REF_NUM'] != "") { ?>
            <div class="col-lg-4 d-none d-lg-block text-right small mb-2">
                Application Reference Number<br/>
                <span class='text-info'><?php echo $_SESSION['USER_REF_NUM']; ?></span>
            </div>
            <?php } ?>
        </div>
