<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../app_auto_load.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <!-- ============================================================== -->
    <!-- ######### POWERED BY LCODE TECHNOLOGIES PVT. LTD. ############ -->
    <!-- ============================================================== -->

    <title>JavaScript Error</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <link rel="shortcut icon" href="<?php echo CDN_URL; ?>/favicon.ico" type="image/ico"/>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo CDN_URL; ?>/theme/css/style-main.css?v=<?php echo CDN_VER; ?>" type="text/css" media="screen"/>

</head>
<body>

<div class="bg-info">
    <div class="container text-center">
        <div class="h4 text-white pt-5 pb-3">JavaScript Error</div>
    </div>
</div>

<div class="container text-center">

    <h6 class="mt-4">
        JavaScript must be enabled on your browser to access this application.
    </h6>

    <hr class="mt-5"/>
    <div class="mb-5"><?php echo app_poweredby(); ?></div>

</div>


</body>
</html>