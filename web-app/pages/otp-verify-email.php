<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . './../../app-core/app_auto_load.php');

//if login not available or OTP verify not required
if(!isset($_SESSION['USER_APP']) || $_SESSION['USER_APP'] != APP_CODE || !isset($_SESSION['OTP_REQ_ID']) || !isset($_SESSION['OTP_EMAIL_TIME']) || !isset($_SESSION['OTP_EMAIL_CHK']) || $_SESSION['OTP_EMAIL_CHK'] != "Y") {
  header('Location: '.APP_URL.'/');
  exit();
}

//OTP Timeout
if(isset($_SESSION['OTP_EMAIL_TIME']) && defined('APP_OTP_TIMEOUT') && ( time() - (int)$_SESSION['OTP_EMAIL_TIME'] ) > APP_OTP_TIMEOUT ) {
  header('Location: '.APP_URL.'/logout');
  exit();
}

//OTP Sent Data
$sql1_exe = $main_app->sql_run("SELECT OTP_REQ_ID, OTP_EMAIL_ID FROM LOG_OTPREQ WHERE OTP_REQ_ID = :OTP_REQ_ID", array( 'OTP_REQ_ID' => $_SESSION['OTP_REQ_ID'] ));
$otp_data = $sql1_exe->fetch();

if(!isset($otp_data['OTP_REQ_ID']) || $otp_data['OTP_REQ_ID'] == NULL || $otp_data['OTP_REQ_ID'] != $_SESSION['OTP_REQ_ID']) {
  header('Location: '.APP_URL.'/logout');
  exit();
}

$emailAddress = (isset($otp_data['OTP_EMAIL_ID']) && $otp_data['OTP_EMAIL_ID'] != "") ? $main_app->mask_email($otp_data['OTP_EMAIL_ID']) : "";

/** Page Header */
require( dirname(__FILE__) . '/../../theme/app-header.php' );
?>

<div class="main-container ace-save-state" id="main-container">
<div class="container mt-4 mb-5 min-high">

  <div class="row d-flex justify-content-center">
  <div class="col-lg-5">
  <div class="row">

    <form name="OtpForm" id="OtpForm" method="post">
    <input type="hidden" id="otp_key" value="<?php echo $safe->rsa_public_key();?>" />

      <div class="position-relative">
      <div class="p-2">

        <div class="h5 text-center text-primary mt-3 mb-2">Verify your Email</div>
        <div class="text-center text-secondary mb-4 px-4">Please enter the 6 digit OTP verification code that has been sent to your email address <?php echo $emailAddress; ?></div>

        <div class="row justify-content-center m-4">
            <div class="col-md-5 form-group">
               <div class="input_div">
                  <input type="password" id="OtpText" name="OtpText" placeholder="X X X X X X" maxlength="6" class="form-control border-input js-noSpace js-isNumeric" autocomplete="off">
              </div>
          </div>
        </div>


        <div class="row px-1 mb-4">
          <div class="col-md-6 form-group text-center text-md-left">
            <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="sbt" name="sbt" tabindex="7">Verify Email OTP  <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
          </div>
          <div class="col-md-6 form-group text-center text-md-right">
            <button class="btn btn-link btn-sm text-dark disabled small" onclick="resendEmailOtp(); return false;" name="ResendBtn" id="ResendBtn" tabindex="-1">Resend OTP</button>
          </div>
        </div>

        <div>
           <ul class="small text-danger pl-3">
            <li class="mb-1">Please do not hit refresh or browser back button.</li>
            <li class="mb-1">An OTP will be valid for 2 minutes after which it will expire. If you do not receive your OTP code within 2 minutes, Please click on Resend/Logout and try again.</li>
          </ul>        
         </div>

      </div>
      </div>
    
    </form>

  </div>
  </div>
  </div>

</div>
</div>

<?php 
/** Page Footer */
require( dirname(__FILE__) . '/../../theme/app-footer.php' );
?>

  <script type="text/javascript">

    //Counter
    function startCounter() {
      disable('ResendBtn');
      var counter = 60;
      var btn = document.getElementById("ResendBtn");
      timer = setInterval(function(){
        counter--;
        if(counter > 1) {
          btn.innerHTML = counter + " seconds left";
        }
        else if(counter == 1) {
          btn.innerHTML = counter + " second left";
        }
        else {
          clearInterval(timer);
          btn.innerHTML = "Resend OTP";
          enable('ResendBtn');
        }
      },"1000");
    }

    //Resend
    function resendEmailOtp() {
      on_change('resend_email_otp','modify');
    }

    //Validate
    function ValidateOtp() {
      var OtpTxt = $('#OtpText').val();
      var encrypt = new JSEncrypt();
      encrypt.setPublicKey($('#otp_key').val());
      var safeData = {
        cmd : "otp_email_verify",
        token : window.req_id,
        otp_code : encrypt.encrypt(OtpTxt)
      }
      //console.log(safeData.otp_code);
      disable('sbt');
      loader_start();
      post_safe_data(safeData);
    }


    $("#OtpForm").submit(function(e) {
      e.preventDefault();
    }).validate({
        rules: {
          OtpText: { required: true, minlength: 6 }
        },
        messages: {
          OtpText: {
              required: "Please enter OTP Code",
              minlength: "Enter valid 6 digit OTP Code"
          },
        },
        errorPlacement: function (error, element) {
            if(element.closest('.input_div').length) {
                error.insertAfter(element.closest('.input_div'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: ValidateOtp
    });

  
    $(document).ready(function(){

      startCounter();

    });



  </script>

</body>
</html>