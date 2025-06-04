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

$page_title = "Submit Application";
$page_link = "./form-nominee-details";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_EKYC_FLAG, SBREQ_PAN_FLAG, SBREQ_APP_STATUS FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
  $ErrorMsg = "Unable to fetch application details";
}

$sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR' ORDER BY CR_ON DESC", array('SBREQ_APP_NUM' => $appData['SBREQ_APP_NUM']));
$kycDetails = $sql_exe3->fetch();

if(isset($kycDetails['DOC_DATA']) && $kycDetails['DOC_DATA'] != "") {
  $kycDetails = json_decode(stream_get_contents($kycDetails['DOC_DATA']), true, JSON_UNESCAPED_SLASHES);
}

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h">
      <form name="form-nominee-details" id="form-nominee-details" method="post" action="javascript:void(0);" class="form-material">
      <input type="hidden" name="cmd" value="form_nominee_details">
      <input type="hidden" name="token" value="<?php echo (isset($_SESSION['APP_TOKEN'])) ? $_SESSION['APP_TOKEN'] : ""; ?>"/>
      <input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
      <input type="hidden" id="pKey" value="<?php echo $safe->rsa_public_key();?>" />
         <div class="h6 text-muted border-bottom pb-2">Nominee Details</div>

            <div class="row mt-3">

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Nominee Name <mand>*</mand> </label>
                <div class="col-md-12">
                <input type="text" name="NOMINEE_NAME" id="NOMINEE_NAME" class="form-control border-input reset-form" autocomplete="none">
                </div>
              </div>

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Date of birth <mand>*</mand></label>
                <div class="col-md-12">
                  <?php
                    $date = date('Y-m-d');
                    echo'<input type="date" name="NOMINEE_DOB" id="NOMINEE_DOB"  max="'.$date.'" class="form-control border-input reset-form" autocomplete="none">';
                  ?>
                  </div>
              </div>

             <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Relation to the Account holder <mand>*</mand></label>
                <div class="col-md-12">
                  <select name="NOMINEE_RELATION" id="NOMINEE_RELATION" class="form-control border-input" autocomplete="none">
                    <option value="">-- Select --</option>
                    <?php
                      $sql_exe = $main_app->sql_run("SELECT RELATION_CODE, RELATION_DESCN FROM RELATION ORDER BY RELATION_DESCN ASC");
                      while ($row = $sql_exe->fetch()) {
                        echo "<option value=".$row['RELATION_CODE'].">".$row['RELATION_DESCN']."</option>";
                      }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-md-4 form-group">
                <label class="col-md-12 label_head">Address <mand>*</mand></label>
                <div class="col-md-12">
                <textarea name="NOMINEE_ADDRESS" id="NOMINEE_ADDRESS" maxlength="250" class="form-control border-input js-maxCheck js-noEnter no-resize" autocomplete="none"></textarea>
                </div>
              </div>

              
              <div class="col-md-8">
                <input type="hidden" name="NOMINEE_HIDDENAFLG" id="NOMINEE_HIDDENAFLG"/>
                <div class="row" id="guarddetails">
                  <div class="col-md-6 form-group">
                    <label class="col-md-12 label_head">Nature of the Guardian </label>
                    <div class="col-md-12">
                      <select name="NOMINEE_NATURE" id="NOMINEE_NATURE" class="form-control border-input" autocomplete="off">
                        <option value="">-- Select --</option>
                        <option value="F"> Father</option>
                        <option value="M"> Mother </option>
                        <option value="O"> Others </option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6 form-group">
                    <label class="col-md-12 label_head">Guardian Name </label>
                    <div class="col-md-12">
                      <input type="text" name="NOMINEE_GUARDIAN" id="NOMINEE_GUARDIAN" class="form-control border-input reset-form" autocomplete="none">
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <div class="col-md-12">
                <hr class="m-0 mb-2"/>
                <div class="input_div">
                <label for="RegAgree2" class="ml-1">
                  <input type="checkbox" name="RegAgree" id="RegAgree" value="1" class="form-radio checkbox">
                  I accept <a href="https://www.capitalbank.co.in/downloads/Capital_Bank_Updated_TERMS_AND_CONDITIONS_End_Journey_Final.pdf" target="_blank">Terms & Conditions</a> 
                </label>
                </div>
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
                  <div class="row my-3">
                      <div class="col-md-12 text-justify large text-center text-danger">
                      Please Mandatory Open Terms and Conditions.

                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-success px-3 text-center" onClick="$('#RegAgree').prop('checked', true); $('#TermsPopup').modal('hide');">I Agree</button>
              </div>
            </div>
            </div>
            </div>

            <div class="col-md-12 form-group text-center mt-1">
            <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="sbt" name="sbt" tabindex="3" onclick="send_form('form-nominee-details', 'sbt');">Create My Account <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
            </div>

            </div>


       </div>     
     </form>

    </div>
  </div>

</div>


<!-- Content : End -->

<?php 
/** Page Footer */
require( dirname(__FILE__) . '/../theme/app-footer.php' );
?>

  <script type="text/javascript">

      //check nominee age
      $("#NOMINEE_DOB").on('change', function(){    
          var nom_age = $('#NOMINEE_DOB').val();       
          if(nom_age != "") {
            var now = new Date();
            var nomage = new Date(nom_age);

            var nowYear = now.getFullYear();
            var nomAge = nomage.getFullYear();
            var age = nowYear - nomAge;
          
            if (age >= 18) {
              $('#NOMINEE_HIDDENAFLG').val('N');
              hide('guarddetails');  
            
            } else {
              $('#NOMINEE_HIDDENAFLG').val('Y');
              show('guarddetails');
            
            }
          }
     
      });

      function chkvalidation(item){
        if($("#"+item).prop('checked') == true){
            $("#"+item).val('1');
        } else {
            $("#"+item).val('');
        }
     }

    //Terms 
    $("#RegAgree").on('click', function(){
      if($("#RegAgree").is(':checked')){
        window.open('https://www.capitalbank.co.in/downloads/Capital_Bank_Updated_TERMS_AND_CONDITIONS_End_Journey_Final.pdf', '_blank');
      }
    });

     $(document).ready(function(){
       hide('guarddetails');
     });

  </script>

</body>
</html>