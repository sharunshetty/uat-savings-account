<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../app-core/app_auto_load.php');

/** Check User Session**/
require_once(dirname(__FILE__) . '/check-login.php'); 

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );


/** Current Page */
$page_pgm_code = "";
$page_title = "Account Details";
$page_link = "./final-account-detail";

$parent_page_title = "";
$parent_page_link = "";

$ErrorMsg = "";

$sql_exe2 = $main_app->sql_run("SELECT * FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$appData = $sql_exe2->fetch();

if(!isset($appData['SBREQ_APP_NUM']) || $appData['SBREQ_APP_NUM'] == NULL || $appData['SBREQ_APP_NUM'] == "") {
  $ErrorMsg = "Unable to fetch application details";
}

$sql_exe3 = $main_app->sql_run("SELECT * FROM SBREQ_ACCOUNTDATA WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM ORDER BY CR_ON DESC", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
$branchData = $sql_exe3->fetch();

if(!isset($branchData['SBREQ_APP_NUM']) || $branchData['SBREQ_APP_NUM'] == NULL || $branchData['SBREQ_APP_NUM'] == "") {
  $ErrorMsg = "Unable to fetch account details";
}


//check vkyc status for pending
if(isset($appData['SBREQ_VKYC_STATUS']) && $appData['SBREQ_VKYC_STATUS'] != "") {

    //check vkyc status
    $status = $appData['SBREQ_VKYC_STATUS'];

    switch($status) {

        case "U" :
        $vkyc_status = "Under Review";
        break;
        case "H" :
        $vkyc_status = "On-Hold";
        break;
        case "M" :
        $vkyc_status = "Meeting Scheduled";
        break;
        case "MH" : 
        $vkyc_status = "Meeting On-Hold";
        break;
        case "P" :
        $vkyc_status = "Pending for Approval";
        break;
        case "S" :
        $vkyc_status = "Approved";
        break;
        case "R" :
        $vkyc_status = "Rejected";
        break;
        case "N" :
        $vkyc_status = "";
        break;
        default :
        $vkyc_status = "";
        break;

    }

}

$ifsc = $main_app->getval_field('MBRN', 'MBRN_IFSC_CODE', 'MBRN_CODE', $branchData['SBREQ_BRANCH_CODE']);
$ifsc_code = isset($ifsc)? $ifsc : NULL;

$brn_name = $main_app->getval_field('MBRN', 'MBRN_NAME', 'MBRN_CODE', $branchData['SBREQ_BRANCH_CODE']);
$brn_nm = isset($brn_name)? $brn_name : NULL;

$brn_address = $main_app->getval_field('MBRN', 'MBRN_ADDR1', 'MBRN_CODE', $branchData['SBREQ_BRANCH_CODE']);
$brn_ad = isset($brn_address)? $brn_address : NULL;

$brn_address1 = $main_app->getval_field('MBRN', 'MBRN_ADDR2', 'MBRN_CODE', $branchData['SBREQ_BRANCH_CODE']);
$brn_ad1 = isset($brn_address1)? $brn_address1 : NULL;

$brn_address2 = $main_app->getval_field('MBRN', 'MBRN_ADDR3', 'MBRN_CODE', $branchData['SBREQ_BRANCH_CODE']);
$brn_ad2 = isset($brn_address2)? $brn_address2 : NULL;

$brn_contactno1 = $main_app->getval_field('MBRN', 'MBRN_TEL_NO1', 'MBRN_CODE', $branchData['SBREQ_BRANCH_CODE']);
$brn_contactno2 = $main_app->getval_field('MBRN', 'MBRN_TEL_NO2', 'MBRN_CODE', $branchData['SBREQ_BRANCH_CODE']);

$brn_cn= $brn_contactno1;
if($brn_contactno1 && $brn_contactno2){
    $brn_cn= $brn_contactno1.'<br/>'.$brn_contactno2;
}

?>

<!-- Content : Start -->

<div class="row">

    <div class="col-md-12 form-group">
        <div class="page-card box-min-h">
      
            <form name="final-detail" id="final-detail" method="post" action="javascript:void(0);" class="form-material">
                <input type="hidden" id="arnVal" name="arnVal" value="<?php echo $safe->str_encrypt($_SESSION['USER_REF_NUM'], $_SESSION['SAFE_KEY']);?>" />
                <input type="hidden" id="pKey" value="<?php echo $safe->rsa_public_key();?>" />
                <input type="hidden" name="token" value="<?php echo (isset($_SESSION['APP_TOKEN'])) ? $_SESSION['APP_TOKEN'] : ""; ?>"/>
                <input type="hidden" name="cmd" value="form-branch-visit">
             
                <div class="row justify-content-center my-4">

                    <div class="col-lg-9 form-group">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 order-2 order-md-1">
                                    <div class="box400 text-center my-2 pb-1 col-md-6 card card-border lc-card">
                                        <div class="row">
                                            <div class="col-md-12 text-muted font-weight-bold text-center title4">Your Capital E-Savings Account</div><hr/>
                                            <div class="col-md-12 mb-1 text-left">
                                                <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                    <th class="text-left" width="40%">Account Number</th>
                                                    <td width='60%'><?php echo isset($appData['CBS_ACC_NUM'])? $appData['CBS_ACC_NUM'] : ""?></td>
                                                    </tr>
                                                    <tr>
                                                    <th class="text-left">Customer ID</th>
                                                    <td width='60%'><?php echo isset($appData['CBS_CUST_ID'])? $appData['CBS_CUST_ID'] : ""?></td>
                                                    </tr>
                                                    <tr>
                                                    <th class="text-left">Account Name</th>
                                                    <?php echo "<td>"; echo $appData['SBREQ_CUST_NAME'] ."</td>"; ?>
                                                    </tr>
                                                    <tr>
                                                    <th class="text-left">IFSC Code</th>       
                                                    <?php echo "<td>".$ifsc_code."</td>";?>        
                                                    </tr>
                                                    <tr>
                                                    <th class="text-left">Branch Name</th>
                                                        <?php echo"<td>".$brn_nm."</td>"; ?>
                                                    </tr>
                                                    <tr>
                                                    <th class="text-left">Branch Address</th>
                                                    <?php echo "<td mb-2>"; echo $brn_ad.' '.$brn_ad1.' '.$brn_ad2."</td>"; ?>
                                                    </tr>   
                                                    <tr>
                                                    <th class="text-left">Branch Contact No</th>
                                                    <?php echo "<td mb-2>".$brn_cn."</td>"; ?>
                                                    </tr>                              
                                                   
                                                </tbody>
                                                </table>
                                            </div>               
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 order-1 order-md-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box400 text-center mb-3 pb-5 col-md-6 card lc-card mt-2">

                                                <div class="col-md-12 font-weight-bold title4 text-center">Video KYC</div>

                                                <div class="text-center mt-4" style="color:blue;">Do you want to Upgrade your account? Please Apply for Video KYC</div> 

                                                <img src="<?php echo CDN_URL; ?>/uploads/images/kyc.jpg"  width="300" height= "150" class="text-center">
                                                
                                                <?php if(isset($vkyc_status) && ($vkyc_status != "")) { ?>
                                                   <div class="col-md-12 font-weight-bold text-danger text-center h6 mt-2">Status: <span class="font-weight-bold"><?php echo $vkyc_status ?></span></div>
                                                    <div class="row mt-3" style="width: 100%;">
                                                      <div class="col-md-7 font-weight-bold" style="color: #ea2f2f;"> 
	                                                    Apply for Video KYC
                                                       </div>

                                                    <div class="col-md-5 applyvkyc p-0" > 
	                                                    <select name="vkycapply" id="vkycapply" class="form-control border-input" autocomplete="off">
                                                            <option value="">-- Select-- </option>
                                                            <option value="RA"> Re Apply for Video KYC</option>
                                                            <option value="B"> Visit your nearest branch </option>
	                                                    </select>
                                                    </div>
                                                 </div>

                                                <?php } elseif(isset($appData['SBREQ_VKYC_STATUS']) && ($appData['SBREQ_VKYC_STATUS'] == "S")) { ?>
                                                    <div class="col-md-12 font-weight-bold text-success text-center h6 mt-2 mb-4 pb-1">Your Video KYC is Successfull</div>

                                                <?php } elseif(isset($appData['SBREQ_VKYC_STATUS']) && ($appData['SBREQ_VKYC_STATUS'] == "R")) { ?>
                                                     <div class="col-md-12 font-weight-bold text-danger text-center h6">Your Video KYC Request Rejected</div>
                                                    <!-- <a href="<?php echo APP_URL.'/schedule-video-kyc';?>" type="submit" class="btn h-btn3 mb-4 mt-3" id="sbt" name="sbt" tabindex="3">Re-Apply for Video KYC <span class="mdi mdi-arrow-right" aria-hidden="true"></span></a> -->
                                                    <div class="row" style="width: 100%;">
                                                        <div class="col-md-7 font-weight-bold" style="color: #ea2f2f;"> 
                                                            Re-Apply for Video KYC
                                                        </div>

                                                        <div class="col-md-5 applyvkyc p-0" > 
                                                            <select name="vkycapply" id="vkycapply" class="form-control border-input" autocomplete="off">
                                                                <option value="">-- Select-- </option>
                                                                <option value="RA"> Re Apply for Video KYC</option>
                                                                <option value="B"> Visit your nearest branch </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php } elseif(isset($appData['SBREQ_VKYC_STATUS']) && ($appData['SBREQ_VKYC_STATUS'] == "B")) { ?>
                                                    <div class="col-md-12 font-weight-bold text-danger text-center h6 mt-2 mb-4 pb-1">Please Visit Branch</div>
                                                <?php }else { ?>
                                                    <div class="row mt-3 pt-1" style=" width: 100%;">
                                                        <div class="col-md-5 font-weight-bold" style="color: #ea2f2f;"> 
                                                            Select anyone Option
                                                        </div>

                                                        <div class="col-md-7 applyvkyc"> 
                                                            <select name="vkycapply" id="vkycapply" class="form-control border-input" autocomplete="off">
                                                                <option value="">-- Select-- </option>
                                                                <option value="A"> Apply for Video KYC</option>
                                                                <option value="B"> Visit your nearest branch </option>
                                                            </select>
                                                        </div>
                                                    </div>
             
                                                <?php } ?>
                                            </div>
                                        
                                    
                                            <div class="col-md-12 text-center mt-4 p-3 card lc-card card-bottom">
                                                <div class="col-md-12 text-center">
                                                    <span class="font-weight-bold d-block mb-2" style="color: #ea2f2f;">Please Download Capital Mobile+ App to operate your account</span>   
                                                    <span class="d-block mb-2"><a href="https://bit.ly/csfbcmpandroid" target="_blank" style="font-size: 15px;color: blue;"><span class="mdi mdi-download"></span>&nbsp;For Android App User</a></span>   
                                                    <span class="d-block"><a href="https://bit.ly/csfbcmpios" target="_blank" style="font-size: 15px;color: blue;"><span class="mdi mdi-download"></span>&nbsp;For IOS App User</a></span>   
                                               
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

$('#vkycapply').on('change', function() {
        var selval = $(this).val();
        var encselVal = window.btoa(selval);
        var arnval = $('#arnVal').val();
        if (selval =="A" || selval == "RA") { 
            goto_url("schedule-video-kyc?arnvalue=" +arnval + "&vkycapply=" +encselVal);
        }else if (selval=="B") {      
            send_form('final-detail','vkycapply');
        }
        return false;
    });                                    
</script>

</body>
</html>