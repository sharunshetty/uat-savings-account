<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** Application Core **/
require_once(dirname(__FILE__) . '/../app-core/app_auto_load.php');

/** Check User Session */
require_once(dirname(__FILE__) . '/check-login.php');

/** Current Page */
$page_pgm_code = "";

$page_title = "";
$page_link = "./";

$parent_page_title = "";
$parent_page_link = "";

/** Login CSRF Token */
if(!isset($_SESSION['LOGIN_TOKEN'])) {
  $main_app->session_set([ 'LOGIN_TOKEN' => $main_app->csrf_token() ]);
}

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<!-- L1 -->
<div class="row">

  <div class="col-md-12 col-lg-5 form-group order-1 order-lg-1">
    <div class="lc-card">

      <ul class="nav nav-tabs" id="myTab" role="tablist" style="display:none;">
      <li class="nav-item"><a class="nav-link active" id="tab-nav-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">tab 1</a></li>
      <li class="nav-item"><a class="nav-link" id="tab-nav-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">tab 2</a></li>
      <li class="nav-item"><a class="nav-link" id="tab-nav-3" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">tab 3</a></li>
      </ul>

      <div class="tab-content box-min-h w-100" id="myTabContent">

        <!-- Tab 1 : Start -->
        <div class="tab-pane show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
          
          <div class="box400 text-center my-4 pb-1">
            <div class="h4 tc5 title2">UCO Digital Savings Account</div>

            <div class="mt-3 pt-1">
              <div class="text-center h6 title4">FEATURES</div><br/>
              <ul class="checkmark d-inline-block mb-1">
              <li>Instant Digital Savings Account</li>
              <li>Upgrade with Video KYC Process</li>
              <li>Debit Card & Cheque Book</li>
              <li>UPI, IMPS, NEFT & RTGS</li>
              <li>Risk-Free Investment Options</li>
              <li>Bill Payment &amp; Recharge</li>
              </ul>
            </div>

            <hr/>

            <div class="row">
              <div class="col-md-6 form-group">
              <a href="javascript:void(0);" class="btn h-btn-a1 btnNewReq">Get Started <i class="mdi mdi-arrow-right"></i></a>
              </div>
              <div class="col-md-6 form-group">
              <a href="javascript:void(0);" class="btn h-btn-a2 btnResume">Resume Application</a>
              </div>
            </div>
            
            <div class="text-justify small text-muted">
            By clicking on "Get Started" or "Resume Application", You authorize <?php echo BRAND_NAME; ?> and its representatives to contact you through Call, Email, SMS or WhatsApp. This consent overrides your registration under DNC/NDNC (this would mean we would contact you even if you are registered on any Do Not Disturb list).</div>
          </div>

        </div>
        <!-- Tab 1 : End -->

        <!-- Tab 2 : Start -->
        <div class="tab-pane" id="tab-2" role="tabpanel" aria-labelledby="tab-2">

          <div class="mt-3">
          <div class="h5 m-1 h-text-a11">Let's get started</div>
            <a href="javascript:void(0);" class="text-muted btnHome ml-1"><i class="mdi mdi-arrow-left"></i> Back</a>
          </div>

          <form name="RegForm" id="RegForm" method="post" autocomplete="off">
          <input type="hidden" name="reg_token" id="reg_token" value="<?php echo $_SESSION['LOGIN_TOKEN'];?>" />
          <input type="hidden" id="reg_key" value="<?php echo $safe->rsa_public_key();?>" />
          <div class="row mt-3">

            <div class="col-md-6 form2-group">
              <label class="col-md-12 label_head">Mobile Number <mand>*</mand></label>
              <div class="col-md-12">
                <div class="input-group input_div">
                  <div class="input-group-prepend">
                    <div class="input-group-text font-t1 mx-auto">+91</div>
                  </div>
                  <input type="text" name="RegMob" id="RegMob" placeholder="10 Digit Number" maxlength="10" class="form-control border-input js-isNumeric" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="col-md-6 form2-group">
              <label class="col-md-12 label_head">Date of Birth <mand>*</mand></label>
              <div class="col-md-12">
                <div class="input-group input_div">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                    <span class="mdi mdi-calendar mx-auto" onclick="$('#RegDOB').focus();"></span>
                    </div>
                  </div>
                  <input type="text" name="RegDOB" id="RegDOB" placeholder="DD-MM-YYYY" maxlength="10" class="form-control border-input js-noSpace" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="col-md-12 form2-group">
              <label class="col-md-12 label_head">Email ID <mand>*</mand></label>
              <div class="col-md-12">
                <div class="input-group input_div">
                  <div class="input-group-prepend">
                  <div class="input-group-text">
                  <span class="mdi mdi-email-outline mx-auto"></span>
                  </div>
                  </div>
                  <input type="text" name="RegEmail" id="RegEmail" placeholder="" maxlength="120" class="form-control border-input js-noSpace" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="col-md-6 form2-group">
              <label class="col-md-12 label_head">PAN Card Number <mand>*</mand></label>
              <div class="col-md-12">
                <div class="input-group input_div">
                  <input type="text" name="RegPAN" id="RegPAN" placeholder="" maxlength="10" class="form-control border-input js-noSpace js-toUpper" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="col-md-6 form2-group">
              <label class="col-md-12 label_head">Referral Code <span class="text-muted small">(optional)</span></label>
              <div class="col-md-12">
                <input type="text" name="RegReferral" id="RegReferral" placeholder="" maxlength="120" class="form-control border-input js-noSpace" autocomplete="off">
              </div>
            </div>

            <div class="col-md-12 form2-group">
              <label class="col-md-12 label_head">Security Check <mand>*</mand></label>
              <div class="col-md-12 mb-2">
                <img src="" id="NEW_SC_IMG" class="mr-1" alt="Loading..." height="40" width="130"> 
                <a href="#" class="p-1 btn btn-light" title="Refresh Code" id="RegCaptchaBtn" onClick="temp_disable(this.id); RegCaptcha(); return false;" tabindex="-1"><i class="mdi mdi-autorenew"></i></a><br/>
              </div>
              <div class="col-md-6">
                <input type="text" name="RegCaptcha" id="RegCaptcha" class="form-control border-input js-alphaNumeric js-noSpace" maxlength="10" placeholder="Enter verification code" autocomplete="off" />
              </div>
            </div>

            <div class="col-md-12 form2-group small">
              <div class="col-md-12">
                <hr class="m-0 mb-2"/>
                <label for="RegAgree" class="input_div ml-1">
                <input type="checkbox" name="RegAgree" id="RegAgree" value="1" class="form-radio checkbox">
                I am an Indian citizen and a tax resident of India.
                </label>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <div class="col-md-12 text-center text-md-right">
                <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="btnRegister">Start Now <span class="mdi mdi-chevron-right"></span></button>
              </div>
            </div>

          </div>
          </form>

        </div>
        <!-- Tab 2 : End -->

        <!-- Tab 3 : Start -->
        <div class="tab-pane" id="tab-3" role="tabpanel" aria-labelledby="tab-3">

          <div class="mt-3">
          <div class="h5 m-1 h-text-a22">Resume Application</div>
            <a href="javascript:void(0);" class="text-muted btnHome ml-1"><i class="mdi mdi-arrow-left"></i> Back</a>
          </div>

          <form name="SignInForm" id="SignInForm" method="post" autocomplete="off">
          <input type="hidden" name="signIn_token" id="signIn_token" value="<?php echo $_SESSION['LOGIN_TOKEN'];?>" />
          <input type="hidden" id="signIn_key" value="<?php echo $safe->rsa_public_key();?>" />
          <div class="row mt-3">

            <div class="col-md-6 form2-group">
              <label class="col-md-12 label_head">Mobile Number <mand>*</mand></label>
              <div class="col-md-12">
                <div class="input-group input_div">
                  <div class="input-group-prepend">
                    <div class="input-group-text font-t1 mx-auto">+91</div>
                  </div>
                  <input type="text" name="LoginMob" id="LoginMob" placeholder="10 Digit Number" maxlength="10" class="form-control border-input js-isNumeric" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="col-md-6 form2-group">
              <label class="col-md-12 label_head">Date of Birth <mand>*</mand></label>
              <div class="col-md-12">
                <div class="input-group input_div">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                  <span class="mdi mdi-calendar mx-auto" onclick="$('#LoginDOB').focus();"></span>
                  </div>
                </div>
                <input type="text" name="LoginDOB" id="LoginDOB" placeholder="DD-MM-YYYY" maxlength="10" class="form-control border-input js-noSpace" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="col-md-12 form2-group">
              <label class="col-md-12 label_head">Email ID <mand>*</mand></label>
              <div class="col-md-12">
                <div class="input-group input_div">
                  <div class="input-group-prepend">
                  <div class="input-group-text">
                  <span class="mdi mdi-email-outline mx-auto"></span>
                  </div>
                  </div>
                  <input type="text" name="LoginEmail" id="LoginEmail" placeholder="" maxlength="120" class="form-control border-input js-noSpace" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="col-md-12 form2-group">
              <label class="col-md-12 label_head">Security Check <mand>*</mand></label>
              <div class="col-md-12 mb-2">
                <img src="" id="APP_SC_IMG" class="mr-1" alt="Loading..." height="40" width="130"> 
                <a href="#" class="p-1 btn btn-light" title="Refresh Code" id="SingInCaptcha" onClick="temp_disable(this.id);SingInCaptcha(); return false;" tabindex="-1"><i class="mdi mdi-autorenew"></i></a><br/>
              </div>
              <div class="col-md-6">
                <input type="text" name="LoginCaptcha" id="LoginCaptcha" class="form-control border-input js-alphaNumeric js-noSpace" maxlength="10" placeholder="Enter verification code" autocomplete="off" />
              </div>
            </div>

            <div class="col-md-12 form-group">
              <div class="col-md-12 text-center text-md-right">
              <hr class="m-0 mt-3 mb-4"/>
              <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="btnSignIn">Proceed  <span class="mdi mdi-chevron-right" aria-hidden="true"></span></button>
              </div>
            </div>

          </div>
          </form>

        </div>
        <!-- Tab 3 : End -->

      </div>
      <!-- #myTabContent -->

    </div>
  </div>

  <div class="col-md-12 col-lg-7 form-group order-2 order-lg-2">
    <div class="mb-3">
      <img src="<?php echo CDN_URL; ?>/uploads/images/homepage-banner-01.jpg" alt="" class="w-100 rounded">
    </div>

    <div class="h6 mb-3">Steps to Open Savings Account Online</div>

    <div class="row">

      <div class="col-md-4 form-group">
        <div class="lc-card text-center py-2">
          <div class="font-color-1 h5 mb-1">1</div>
          <div class="text-dark small">Fill Personal details, Then authorize with SMS &amp; EMAIL OTP</div>
        </div>
      </div>

      <div class="col-md-4 form-group">
        <div class="lc-card text-center py-2">
          <div class="font-color-1 h5 mb-1">2</div>
          <div class="text-dark small">Aadhaar e-KYC & PAN Card Verification</div>
        </div>
      </div>

      <div class="col-md-4 form-group">
        <div class="lc-card text-center py-2">
          <div class="font-color-1 h5 mb-1">3</div>
          <div class="text-dark small">Fill mandatory information related to Account Opening</div>
        </div>
      </div>

      <div class="col-md-4 form-group">
        <div class="lc-card text-center py-2">
          <div class="font-color-1 h5 mb-1">4</div>
          <div class="text-dark small">Upload Signature & Other <br/>Required Documents</div>
        </div>
      </div>

      <div class="col-md-4 form-group">
        <div class="lc-card text-center py-2">
          <div class="font-color-1 h5 mb-1">5</div>
          <div class="text-dark small">Get your Instant Digital Savings Account details</div>
        </div>
      </div>

      <div class="col-md-4 form-group">
        <div class="lc-card text-center py-2">
          <div class="font-color-1 h5 mb-1">6</div>
          <div class="text-dark small">Schedule Video KYC Appointment for Upgrade</div>
        </div>
      </div>

    </div>

    <div class="text-muted small">* Availability of Video KYC service is only on Bank workings days.</div>

  </div>

</div>

<!-- L2 -->
<div class="row">

  <div class="col-md-12">
  </div>

</div>


  <!-- The Disclaimer Modal -->
  <div class="modal fade" id="TermsPopup" tabindex="-1" role="dialog" aria-labelledby="TermsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
  <div class="modal-content">
    <div class="modal-header">
        <h6 class="modal-title" id="NeedHelpLabel">Terms &amp; Conditions</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body text-dark max-h-280">
        <div class="row my-4">
            <div class="col-md-12 text-justify small">
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-sm btn-success px-3" onClick="$('#RegAgree').prop('checked', true); $('#TermsPopup').modal('hide');">I Agree</button>
    </div>
  </div>
  </div>
  </div>


<!-- Content : End -->

<?php 
/** Page Footer */
require( dirname(__FILE__) . '/../theme/app-footer.php' );
?>

  <script type="text/javascript" src="<?php echo CDN_URL; ?>/login-auth.js?v=<?php echo CDN_VER; ?>"></script>

  <script type="text/javascript">

  $(".btnHome").on("click", function() {

    $("#tab-nav-1").trigger("click");
    if(typeof scrollbar !== 'undefined') {
      scrollbar.scroll({ top : 0 }, 0);
    } else {
      $("html, body").animate({ scrollTop: "0" });
    }

    $('#RegForm').trigger('reset');
    $("#NEW_SC_IMG").attr("src","");
    $("#RegForm").validate().resetForm();

    $('#SignInForm').trigger('reset');
    $("#APP_SC_IMG").attr("src","");
    $("#SignInForm").validate().resetForm();
  
  });

  $(".btnNewReq").on("click", function() {
    RegCaptcha();
    if(typeof scrollbar !== 'undefined') {
      scrollbar.scroll({ top : 0 }, 300);
    } else {
      $("html, body").animate({ scrollTop: "0" });
    }
    $("#tab-nav-2").trigger("click");
  });

  $(".btnResume").on("click", function() {
    SingInCaptcha();
    if(typeof scrollbar !== 'undefined') {
      scrollbar.scroll({ top : 0 }, 300);
    } else {
      $("html, body").animate({ scrollTop: "0" });
    }
    $("#tab-nav-3").trigger("click");
  });

  function RegCaptcha() {
    $('#RegCaptcha').val('');
    $("#NEW_SC_IMG").attr("src","../captcha?data=" + req_id + "&seq="+new Date().getTime());
  }

  function SingInCaptcha() {
    $('#LoginCaptcha').val('');
    $("#APP_SC_IMG").attr("src","../captcha?data=" + req_id + "&seq="+new Date().getTime());
  }

  $('.help-tip').popover();

  // Date Selection 1 : RegDOB

  $("#RegDOB").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: false,
    autoApply: true,
    //startDate: moment().format('DD-MM-YYYY hh:mm A'), // Current
    //minDate: moment().format('DD-MM-YYYY'), // Min date
    //maxDate: moment().add(30, 'days').format('DD-MM-YYYY'), // Max date
    locale: {
      format: 'DD-MM-YYYY', // Format
      cancelLabel: 'Clear'
    },
    autoUpdateInput: false,
  }, function(chosen_date) {
    $('#RegDOB').val(chosen_date.format('DD-MM-YYYY'));
  });

  // Date Selection 2 : LoginDOB

  $("#LoginDOB").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: false,
    autoApply: true,
    //startDate: moment().format('DD-MM-YYYY hh:mm A'), // Current
    //minDate: moment().format('DD-MM-YYYY'), // Min date
    //maxDate: moment().add(30, 'days').format('DD-MM-YYYY'), // Max date
    locale: {
      format: 'DD-MM-YYYY', // Format
      cancelLabel: 'Clear'
    },
    autoUpdateInput: false,
  }, function(chosen_date) {
    $('#LoginDOB').val(chosen_date.format('DD-MM-YYYY'));
  });

  //Terms
  $('#RegAgree').on('click', function(e){
    if(e.target.checked) {
      e.preventDefault();
      $('#TermsPopup').appendTo("body").modal({ show: true, backdrop: 'static', keyboard: true, show: true });
    }
  });

  </script>

</body>
</html>