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

$page_title = "Upload KYC details";
$page_link = "./schedule-video-kyc";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

if(isset($_GET['vkycapply']) && $_GET['vkycapply'] != "") {
  $selval = base64_decode($_GET['vkycapply']);
}

if(!isset($selval) && $selval == "") {
  $ErrorMsg = "Invalid Request, Please try later";
} 
elseif(isset($selval) && $selval != "" && ($selval != "A" && $selval != "RA")) {
  $ErrorMsg = "Invalid Request, Please try later";
}


/** Steps Pending */
$sql_exe2 = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_EKYC_FLAG, SBREQ_PAN_FLAG FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
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
      
      <form name="schedule-video-kyc" id="schedule-video-kyc" method="post" action="javascript:void(0);" class="form-material">
        <input type="hidden" name="cmd" value="schedule_video_kyc">
        <input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
        <input type="hidden" id="arnValde" name="arnValde" value="<?php echo $_SESSION['USER_REF_NUM'];?>" />
        <input type="hidden" id="selVal" name="selVal" value="<?php echo $safe->str_encrypt($selval, $_SESSION['SAFE_KEY']);?>" />
       <input type="hidden" name="token" value="<?php echo (isset($_SESSION['APP_TOKEN'])) ? $_SESSION['APP_TOKEN'] : ""; ?>"/>
               
        <div class="row justify-content-center my-4">

        <?php if(isset($ErrorMsg) && $ErrorMsg != "") { ?>
            <span class="text-danger large"><?php echo $ErrorMsg; ?></span>
        <?php } else { ?>

          <div class="col-lg-4">

            <div class="row mt-2">
              <div class="col-md-12 form-group">
                <label class="col-md-12 label_head">Schedule date for Video KYC <mand>*</mand></label>
                <div class="col-md-12">
                  <input type="text" name="SCH_DATE" id="SCH_DATE" placeholder="DD-MM-YYYY" class="form-control border-input reset-form" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-12 form-group">
                <label class="col-md-12 label_head">Schedule Time Slot <mand>*</mand></label>
                <div class="col-md-12">
                  <select name="TIMESLOT_CODE" id="TIMESLOT_CODE" class="form-control border-input" autocomplete="none" disabled>
                    <option value="">-- Select --</option>
                   </select>
                </div>   
              </div>

             </div>
          </div>
        </div>

        <div class="row px-2 mb-3 mt-5">
            <div class="col-12 col-md-6 col-lg-6 form-group text-center">
              <button type="button" class="btn btn-light px-4 mr-2 border" name="prevBtn" id="prevBtn" style="background-color:#e1e1e1" onclick="preButton2();"><i class="mdi mdi-arrow-left"></i> Go Back</button>
            </div>
            <div class="col-12 col-md-6 col-lg-6  form-group text-center ">
              <button type="submit" class="btn h-btn3 m-0 px-4 py-2" id="sbt" name="sbt" tabindex="3" onclick="submitKycDetail();">Schedule Video KYC<span class="mdi mdi-arrow-right" aria-hidden="true"></span></button>
            </div>
       </div>

       <?php } ?>

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

      $("#SCH_DATE").daterangepicker({
      isInvalidDate: function(date) {
        if (date.day() == 0)
        return true;
      },
      autoUpdateInput: false,
      startDate: moment().format('DD-MM-YYYY'), // Current
      minYear: moment().format('YYYY'), // Min date
      minDate: moment().format('DD-MM-YYYY'), // Min date
      singleDatePicker: true,
      drops:"down",
      locale: {
        format: 'DD-MM-YYYY', // Format    
      },

    });

    $("#SCH_DATE").on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY'));
      on_change('sb-vkyc-schedule','modify',this.value , 'VKYCSCHED' );
    });

    $("#SCH_DATE").on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

    function submitKycDetail() {

      disable('sbt');
      loader_start();
      var formData = new FormData();	
      formData.append('cmd','schedule_video_kyc');
      formData.append('SCH_DATE',$("#SCH_DATE").val());
      formData.append('selVal',$("#selVal").val());
      formData.append('TIMESLOT_CODE',$("#TIMESLOT_CODE").val());
      formData.append('token','<?php echo $_SESSION['APP_TOKEN']; ?>');

      $.ajax({
        type: 'POST',
        enctype: 'multipart/form-data',
        url: "post/data-post",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (result) {
            $('#result2').html(result);
        },
        error: function (result) {
            loader_stop();
            enable('sbt');
            alert('Error : Unable to process request, Please try again.');
        }
      });

      }

      function preButton2() {
          loader_start();
          goto_url('final-account-detail');
      }
  </script>

</body>
</html>