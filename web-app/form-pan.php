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

$page_title = "PAN Verification";
$page_link = "./form-pan";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_EKYC_FLAG, SBREQ_PAN_FLAG FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
  $ErrorMsg = "Unable to fetch application details";
}

//e-KYC not done
if(!isset($appData['SBREQ_EKYC_FLAG']) || $appData['SBREQ_EKYC_FLAG'] != "Y") {
  header('Location: '.APP_URL.'/form-aadhaar');
  exit();
}


/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">

  <div class="col-md-12 form-group">
    <div class="page-card box-min-h">
      
      <form name="pan-verify" id="pan-verify" method="post" action="javascript:void(0);" class="form-material">
      <input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
      <input type="hidden" id="pKey" value="<?php echo $safe->rsa_public_key();?>" />
      <div class="row justify-content-center my-4">

        <div class="col-md-12 form-group text-center mt-2">
          <div class="h5 txt-c1">Enter your PAN Card Details</div>
          <div class="text-muted small">PAN issued by the Income Tax Department to Indian taxpayers</div>
        </div>

        <!-- <div class="col-md-6  form-group text-center">
          <div class="input_div">
          <input type="text" id="panNum" name="panNum" index="1" placeholder="X X X X X X X X X X" maxlength="10" class="form-control border-input js-noSpace js-toUpper text-center" autocomplete="off">
          </div>
        </div>

        <div class="col-md-6 form-group text-center">
          <div class="input_div">
          <input type="text" id="fullname" name="fullname" index="" placeholder="" maxlength="" class="form-control border-input js-noSpace js-toUpper text-center" autocomplete="off">
          </div>
        </div> -->

        <div class="row mt-3">

        <div class="col-md-4 form-group">
          <label class="col-md-12 label_head">PAN Card Number </label>
          <div class="col-md-12">
          <input type="text" id="panNum" name="panNum" index="1" placeholder="X X X X X X X X X X" maxlength="10" class="form-control border-input js-noSpace js-toUpper text-center" autocomplete="off">
          </div>
        </div>

        <div class="col-md-4 form-group">
          <label class="col-md-12 label_head">Name </label>
          <div class="col-md-12">
          <input name="FULL_NAME" id="FULL_NAME" maxlength="\" class="form-control border-input" autocomplete="off">
          </div>
        </div>

        <div class="col-md-4 form-group">
          <label class="col-md-12 label_head">Father's Name </label>
          <div class="col-md-12">
          <input name="FATHER_NAME" id="FATHER_NAME" maxlength="" class="form-control border-input" autocomplete="off">
          </div>
        </div>

        <div class="col-md-4 form-group">
          <label class="col-md-12 label_head">Date of birth </label>
          <div class="col-md-12">
              <input type="text" name="DATE_OF_BIRTH" id="DATE_OF_BIRTH" class="form-control border-input date" autocomplete="none">
            </div>
        </div>

        <div class="col-md-12 form-group">
        <div class="col-md-12">
          <div class="input_div">
          <label for="PanAgree" class="ml-1">
            <div class="text-muted small">Foreign Account Tax Compliance Act (FATCA)</div>
            <input type="checkbox" name="PanAgree" id="PanAgree" value="1" class="form-radio checkbox"> 
            I am an INDIAN citizen and a tax resident of India and of no other country.
          </label>
          </div>
        </div>
        </div>

        <div class="col-md-12 text-center"> 
            
            <div class="col-md-12 form-group text-center mt-4">
              <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="sbt" name="sbt" tabindex="3">Next <span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
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

  $("#DATE_OF_BIRTH").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    //timePicker: true,
    autoApply: true,
    //startDate: moment().format('DD-MM-YYYY hh:mm A'), // Current
    //minDate: moment().format('DD-MM-YYYY'), // Min date
    //maxDate: moment().add(30, 'days').format('DD-MM-YYYY'), // Max date
    locale: {
      format: 'DD-MM-YYYY', // Format
    },
    autoUpdateInput: false,
  }, function(chosen_date) {
    $('#DATE_OF_BIRTH').val(chosen_date.format('DD-MM-YYYY'));
  });

  $('input[name="DATE_OF_BIRTH"]').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('DD-MM-YYYY'));
    this.form.submit();
  });

    // Form PAN
    $("#pan-verify").submit(function(e) {
      e.preventDefault();
    }).validate({
        rules: {
          panNum: { required: true, minlength: 10 },
          FULL_NAME: { required: true},
          FATHER_NAME: { required: true},
          DATE_OF_BIRTH: { required: true},
          PanAgree: { required: true }, 
          
        },
        messages: {
          panNum: {
              required: "Enter your PAN",
              minlength: "Please enter valid PAN"
          },
          FULL_NAME: {
            required: "Enter your Full name on PAN Card",
          },
          FATHER_NAME: {
            required: "Enter your Father's name",
          },
          DATE_OF_BIRTH: {
            required: "Enter your Date of birth",
          },
          PanAgree: {
              required: "Please click on checkbox"
          }, 
         },
        errorPlacement: function (error, element) {
            if(element.closest('.input_div').length) {
                error.insertAfter(element.closest('.input_div'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: PanValidate
    });

    function PanValidate() {
      var panNum = $('#panNum').val();
      var PanAgree = $('#PanAgree').val();
      var arnVal = $('#arnVal').val();
      var FULL_NAME = $('#FULL_NAME').val();
      var FATHER_NAME = $('#FATHER_NAME').val();
      var DATE_OF_BIRTH = $('#DATE_OF_BIRTH').val();
      var encrypt = new JSEncrypt();
      encrypt.setPublicKey($('#pKey').val());
      var safeData = {
        cmd : "form_pan_validate",
        token : window.req_id,
        arnVal : arnVal,
        PanAgree : PanAgree,
        panNum : encrypt.encrypt(panNum),
        fullname : FULL_NAME,
        fathername : FATHER_NAME,
        dateofbirth : DATE_OF_BIRTH,
      }
      disable('sbt');
      loader_start();
      post_safe_data(safeData);
    }



  </script>

</body>
</html>