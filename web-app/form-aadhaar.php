<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../app-core/app_auto_load.php');

/** Check User Session */
require_once(dirname(__FILE__) . '/check-login.php');

/** Current Page */
$page_pgm_code = "";

$page_title = "Aadhaar Verification";
$page_link = "./form-aadhaar";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_EKYC_FLAG FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
  $ErrorMsg = "Unable to fetch application details";
}


/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h">

    <?php if(isset($ErrorMsg) && $ErrorMsg != "") { ?>
      
      <div class="text-danger text-center h6"><?php echo $main_app->strsafe_output($ErrorMsg); ?></div>

    <?php } else { ?>

      <ul class="nav nav-tabs" id="myTab" role="tablist" style="display: none;" >
          <li class="nav-item"><a class="nav-link active" id="tab-nav-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Aadhar / VID Number Details</a></li>
          <li class="nav-item"><a class="nav-link" id="tab-nav-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">OTP Details</a></li>
          <li class="nav-item"><a class="nav-link" id="tab-nav-3" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Aadhaar Details</a></li>
      </ul>
      
      <div class="tab-content w-100" id="myTabContent">
        
        <!-- Tab 1 : Start -->
        <div class="tab-pane show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
          <div class="row justify-content-center">

            <div class="col-md-7 col-lg-6 text-center my-4">

              <div class="h5 txt-c1 mt-4">Please enter your Aadhaar Number</div>

              <form name="aadhaar-otp" id="aadhaar-otp" method="post" action="javascript:void(0);" class="form-material">
                <input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
                <input type="hidden" id="pKey" value="<?php echo $safe->rsa_public_key();?>" />                

                <div class="row justify-content-center mt-4">
                  <div class="col-md-7 form-group">
                    <div class="input_div">
                      <input type="text" id="ekycNum" name="ekycNum" placeholder="12 Digit UID" maxlength="12" class="form-control border-input js-noSpace js-isNumeric" autocomplete="off">
                    </div>

                    <div class="mt-4">
                      <div class="col-md-12">
                        <label for="AadhAgree" class="ml-1 label_head"> </label>
                        <input type="checkbox" name="AadhAgree" id="AadhAgree"  class="form-radio checkbox"> I agree to Terms & Conditions.   
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
                            <div class="modal-body text-dark"> <!--max-h-280-->
                              <div class="row">
                                <div class="col-md-12 text-justify small">
                                  <p>A. I hereby provide my voluntary consent to Capital Small Finance Bank to use the Aadhaar details provided by me for authentication and agree to the terms and conditions related to Aadhaar consent and updation.</p>
                                  <p>B. I am aware that there are various alternate options provided by Capital Small Finance Bank ("Bank") for establishing my identity/address proof for opening a Savings Account and agree and confirm that for opening the online Savings Account, I have voluntarily submitted my Aadhaar number to the Bank and hereby give my consent to the Bank:- (i) to establish my identity / address proof and verify my mobile number by Aadhaar based authentication system through biometric and/or One Time Pin (OTP) and/or Yes/No authentication and/or any other authentication mechanism) independently or verify the genuineness of the Aadhaar through such manner as set out by UIDAI or any other law from time to time; (ii) share my Aadhaar detail with UIDAI, NPCI, concerned regulatory or statutory authorities as any be required under applicable laws. (iii) to collect, store and use the Aadhaar details for the aforesaid purpose(s) and update my mobile number registered with UIDAI in the bank records for sending SMS alerts/other communications to me.</p>
                                  <p>C. I hereby also agree with the below terms pertaining to Aadhaar based authentication/verification:
                                    <ol style="padding-left: 25px;">
                                      <li>I have been informed that: (a) upon authentication, UIDAI may share with Capital Small Finance Bank information in nature of my demographic information including photograph, mobile number which Capital Small Finance Bank may use as an identity/address proof for the purpose of account opening;(b) my Aadhaar details (including my demographic information) shared by UIDAI will not be used for any purpose other than the purpose mentioned above or as per requirements of law; (c) my biometric information will not be stored by the Bank.</li>
                                      <li>I hereby declare that all the above information voluntarily furnished by me is true, correct and complete in all respects.</li>
                                      <li>I understand that Capital Small Finance Bank shall be relying upon the information received from UIDAI for processing my Savings Account opening f ormalities.</li>
                                    </ol>
                                  </p>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-sm btn-success px-3" onClick="$('#AadhAgree').prop('checked', true); $('#TermsPopup').modal('hide');">I Agree</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> 
                  </div>
                  
                  <div class="col-md-12 form-group mt-4">
                    <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="sbt" name="sbt" tabindex="7">Generate OTP  <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
                  </div>
                </div>

              </form>

              <div class="text-muted small mt-3">Aadhaar 12 digit individual identification number issued by the <br/>Unique Identification Authority Of India (UIDAI) on behalf of the Government of India.</div>
                  
            </div>
            
          </div>
        </div>
        <!-- Tab 1 : End -->

        <!-- Tab 2 : Start -->
        <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab-2">
          <div class="row justify-content-center">

            <div class="col-md-7 col-lg-6 text-center my-4">

              <div class="h5 txt-c1 mt-4">Aadhaar OTP Verification</div>
              <div class="text-muted small">Please enter OTP Code received on your Aadhaar registered mobile number</div>

              <form name="aadhaar-verify" id="aadhaar-verify" method="post" action="javascript:void(0);" class="form-material">
              <input type="hidden" id="reqid" name="reqid" />
              <input type="hidden" id="ekycNum2" name="ekycNum" />
              <input type="hidden" id="arnVal2" name="arnVal2" />

                <div class="row justify-content-center mt-4">
                <div class="col-md-5 form-group">
                  <div class="input_div">
                  <input type="password" id="ekycOtp" name="ekycOtp" placeholder="X X X X X X" maxlength="6" class="form-control border-input js-noSpace js-isNumeric" autocomplete="off">
                  </div>
                </div>
                <div class="col-md-12 form-group">
                  <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="sbt2" name="sbt2" tabindex="7">Verify OTP  <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
                </div>
                <div class="col-md-12 mt-3">
                  <a href="javascript:void(0);" onclick="btnOtpScn();" class="text-danger"><i class="mdi mdi-arrow-left"></i> Go back & Regenerate OTP</a>
                </div>
                </div>

              </form>                
            </div>
            
          </div>
        </div>
        <!-- Tab 2 : End -->

      </div>

    <?php } ?>

    </div>
  </div>

</div>

<!-- Content : End -->

<?php 
/** Page Footer */
require( dirname(__FILE__) . '/../theme/app-footer.php' );
?>

  <script type="text/javascript">

    // Form OTP - 1
    $("#aadhaar-otp").submit(function(e) {
      e.preventDefault();
    }).validate({
        rules: {
          ekycNum: { required: true, minlength: 12 },
          AadhAgree :   { required : true }
        },
        messages: {
          ekycNum: {
              minlength: "Enter valid 12 digit Aadhaar number"
          },
          AadhAgree : {
            required : "Please accept the Terms & Conditions."
          }
        },
        errorPlacement: function (error, element) {
            if(element.closest('.input_div').length) {
                error.insertAfter(element.closest('.input_div'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: ekycOtp
    });

    function ekycOtp() {
      var ekycNum = $('#ekycNum').val();
      var arnVal = $('#arnVal').val();
      var encrypt = new JSEncrypt();
      encrypt.setPublicKey($('#pKey').val());
      var safeData = {
        cmd : "form_aadhaar_otp",
        token : window.req_id,
        arnVal : arnVal,
        ekycNum : encrypt.encrypt(ekycNum),
     }
      disable('sbt');
      loader_start();
      post_safe_data(safeData);
    }

    // Form Verification - 2
    $("#aadhaar-verify").submit(function(e) {
      e.preventDefault();
    }).validate({
        rules: {
          ekycOtp: { required: true, minlength: 6 }
        },
        messages: {
          ekycOtp: {
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
        submitHandler: ekycVerify
    });

    function ekycVerify() {
      var ekycOtp = $('#ekycOtp').val();
      var reqid = $('#reqid').val();
      var ekycNum2 = $('#ekycNum2').val();
      var arnVal = $('#arnVal2').val();
      var encrypt = new JSEncrypt();
      encrypt.setPublicKey($('#pKey').val());
      var safeData = {
        cmd : "form_aadhaar_verify",
        token : window.req_id,
        ekycOtp : encrypt.encrypt(ekycOtp),
        reqid : reqid,
        arnVal : arnVal,
        ekycNum : ekycNum2,
      }
      disable('sbt2');
      loader_start();
      post_safe_data(safeData,'sbt2');
    }

    //BackBtn-1
     function btnOtpScn() {
      $('#tab-nav-1').trigger('click');
      $('#AadhAgree').prop('checked', false);
      $('#ekycOtp').val('');  
    }

    $('#AadhAgree').on('click', function(e){
      if(e.target.checked) {
        e.preventDefault();
        $('#TermsPopup').appendTo("body").modal({ show: true, backdrop: 'static', keyboard: true, show: true });
      }
    });

 
  </script>

</body>
</html>