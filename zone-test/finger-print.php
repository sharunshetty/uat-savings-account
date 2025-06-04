<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/../app-core/app_auto_load.php');

/** Current Page */
$page_pgm_code = "";

$page_title = "Fingerprint Scan Testing";
$page_link = "./finger-print";

$parent_page_title = "";
$parent_page_link = "";

/** Page Header */
require( dirname(__FILE__) . '/../theme/app-header.php' );
?>

<!-- Content : Start -->

<div class="row">
<div class="col-md-12 form-group">
<div class="page-card box-min-h">

        <div class="row">

            <div class="col-md-6">
                <input class="btn btn-primary btn-200" onclick="discoverAvdm();" type="button" value="Discover AVDM">
                <br/>
                <br/>
                <div class="row">

                    <div class="col-md-12 form2-group">Select Option to Capture</div>

                    <div class="col-md-12 form-group">
                        <label class="col-md-12 label_head">AVDM <span class="text-danger small">*</span></label>
                        <div class="col-md-12">
                            <select id="ddlAVDM" class="form-control" class="form-control border-input" autocomplete="off">
                            <option></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 form2-group">
                        <input type="button" class="btn btn-success btn-200 px-4 mr-2" onclick="CaptureAvdm();" value="Capture" />
                        <input type="button" class="btn btn-secondary btn-200" onclick="reset();" value="Reset" />
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="row">

                    <div class="col-md-4 form2-group">
                    <label class="col-md-12 label_head">Timeout</label>
                    <div class="col-md-12">
                        <select id="Timeout" class="form-control">
                            <option>10000</option>
                            <option>10000</option>
                            <option>20000</option>
                            <option>30000</option>
                            <option>40000</option>
                            <option>50000</option>
                            <option>60000</option>
                            <option>70000</option>
                            <option>80000</option>
                            <option>90000</option>
                            <option>100000</option>
                            <option>0</option>
                        </select>
                    </div>
                    </div>
                    
                    <div class="col-md-4 form2-group">
                    <label class="col-md-12 label_head">Env</label>
                    <div class="col-md-12">
                        <select id="Env" class="form-control">
                            <option>S</option>
                            <option>PP</option>
                            <option selected="true">P</option>
                        </select>
                    </div>
                    </div>
                    
                    <div class="col-md-4 form2-group">
                    <label class="col-md-12 label_head">DataType</label>
                    <div class="col-md-12">
                        <select id="Dtype" class="form-control">
                            <option value="0">X</option>
                            <option value="1">P</option>
                        </select>
                    </div>
                    </div>
                    
                    <div class="col-md-12 form2-group">
                    <label class="col-md-12 label_head">Wadh</label>
                    <div class="col-md-12">
                        <textarea id="txtWadh" class="form-control"></textarea>
                    </div>
                    </div>

                    <input type="hidden" id="Pidver" value="2.0">

                </div>
            </div>

        </div>



    <input type="hidden" id="Fcount" value="1">
    <input type="hidden" id="Ftype" value="0">
    <input type="hidden" id="Icount" value="0">
    <input type="hidden" id="Itype" value="SELECT">
    <input type="hidden" id="Pcount" value="0">
    <input type="hidden" id="Ptype" value="SELECT">


    <div class="row">
        <div class="col-md-12">
        <table style="display:none;">
                <tbody>
                    <tr>
                        <td>
                            <strong>PERSONAL IDENTITY(PI)</strong><br />
                            <table border="1" width="500px">
                                <tbody>
                                    <tr>
                                        <td style="text-align: right;">
                                            Name:
                                        </td>
                                        <td>
                                            <input id="txtName" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            Match Value:
                                        </td>
                                        <td>
                                            <select id="drpMatchValuePI" class="form-control">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            Match Strategy:
                                        </td>
                                        <td>
                                            <input name="RDPI" id="rdExactPI" checked="true" type="radio">Exact</input>
                                            <input name="RDPI" id="rdPartialPI" type="radio">Partial</input>
                                            <input name="RDPI" id="rdFuzzyPI" type="radio">Fuzzy</input>
                                        </td>
                                        <td style="text-align: right;">
                                            Age:
                                        </td>
                                        <td>
                                            <input id="txtAge" type="text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            Local Name:
                                        </td>
                                        <td>
                                            <input id="txtLocalNamePI" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            LocalMatchValue:
                                        </td>
                                        <td>
                                            <select id="drpLocalMatchValuePI">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            DOB:
                                        </td>
                                        <td>
                                            <input id="txtDOB" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            Gender:
                                        </td>
                                        <td>
                                            <select id="drpGender" class="form-control">
                                                <option value="0">Select</option>
                                                <option>MALE</option>
                                                <option>FEMALE</option>
                                                <option>TRANSGENDER</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            Phone:
                                        </td>
                                        <td>
                                            <input id="txtPhone" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            Email:
                                        </td>
                                        <td>
                                            <input id="txtEmail" type="text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            DOB Type:
                                        </td>
                                        <td>
                                            <select id="drpDOBType" class="form-control">
                                                <option value="0">select</option>
                                                <option>V</option>
                                                <option>D</option>
                                                <option>A</option>
                                            </select>
                                        </td>
                                        <td style="text-align: right;">
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <strong>PERSONAL ADDRESS(PA)</strong><br />
                            <table border="1" width="500px">
                                <tbody>
                                    <tr>
                                        <td style="text-align: right;">
                                            Care Of:
                                        </td>
                                        <td>
                                            <input id="txtCareOf" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            Building:
                                        </td>
                                        <td>
                                            <input id="txtBuilding" type="text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            Landmark:
                                        </td>
                                        <td>
                                            <input id="txtLandMark" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            Street:
                                        </td>
                                        <td>
                                            <input id="txtStreet" type="text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            Locality:
                                        </td>
                                        <td>
                                            <input id="txtLocality" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            PO Name:
                                        </td>
                                        <td>
                                            <input id="txtPOName" type="text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            City:
                                        </td>
                                        <td>
                                            <input id="txtCity" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            Sub Dist:
                                        </td>
                                        <td>
                                            <input id="txtSubDist" type="text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            District:
                                        </td>
                                        <td>
                                            <input id="txtDist" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            State:
                                        </td>
                                        <td>
                                            <input id="txtState" type="text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">
                                            PinCode:
                                        </td>
                                        <td>
                                            <input id="txtPinCode" type="text" />
                                        </td>
                                        <td style="text-align: right;">
                                            Match Strategy:
                                        </td>
                                        <td>
                                            <input id="rdMatchStrategyPA" checked="true" type="radio">Exact</input>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            </br>
            <table border="1" width="1000px" style="display:none;">
                <tbody>
                    <tr>
                        <td colspan="6">
                            <strong>PERSONAL FULL ADDRESS(PFA)</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            Match Strategy:
                        </td>
                        <td>
                            <input name="RD" id="rdExactPFA" checked="true" type="radio">Exact</input>
                            <input name="RD" id="rdPartialPFA" type="radio">Partial </input>
                            <input name="RD" id="rdFuzzyPFA" type="radio">Fuzzy</input>
                        </td>
                        <td style="text-align: right;">
                            Match Value:
                        </td>
                        <td>
                            <select id="drpMatchValuePFA">
                            </select>
                        </td>
                        <td style="text-align: right;">
                            Local Match Value:
                        </td>
                        <td>
                            <select id="drpLocalMatchValue">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            Address Value:
                        </td>
                        <td colspan="3">
                            <textarea id="txtAddressValue" style="width: 100%; height: 50px;" class="form-control"></textarea>
                        </td>
                        <td style="text-align: right;">
                            Local Address:
                        </td>
                        <td colspan="3">
                            <textarea id="txtLocalAddress" style="width: 100%; height: 50px;" class="form-control"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <label>
                avdm/device info</label>
            <textarea id="txtDeviceInfo" style="width: 100%; height: 160px;" class="form-control"> </textarea>
            <label>
                pid options</label>
            <textarea id="txtPidOptions" style="width: 100%; height: 100px;" class="form-control"> </textarea>
            <label>
                pid data</label>
            <textarea id="txtPidData" style="width: 100%; height: 150px;" class="form-control"> </textarea>
            <label id="lblstatus">
            </label>

        </div>
    </div>

</div>
</div>
</div>


<!-- Content : End -->

<?php 
/** Page Footer */
require( dirname(__FILE__) . '/../theme/app-footer.php' );
?>

  <script type="text/javascript">

<!-- $(document).ready(function (){ -->
			<!-- alert("D m calling..."); -->
		<!-- }); -->
		var GetPIString='';
		var GetPAString='';
		var GetPFAString='';
		var DemoFinalString='';
		var select = '';
		select += '<option val=0>Select</option>';
		for (i=1;i<=100;i++){
			select += '<option val=' + i + '>' + i + '</option>';
		}
		$('#drpMatchValuePI').html(select);
		$('#drpMatchValuePFA').html(select);
		$('#drpLocalMatchValue').html(select);
		$('#drpLocalMatchValuePI').html(select);

		var finalUrl="";
		var MethodInfo="";
		var MethodCapture="";
		var OldPort=false;






		function test()
		{
			alert("I am calling..");
		}

		function reset()
		{
			$('#txtWadh').val('');
		    $('#txtDeviceInfo').val('');
			$('#txtPidOptions').val('');
			$('#txtPidData').val('');
		    $("select#ddlAVDM").prop('selectedIndex', 0);
		    $("select#Timeout").prop('selectedIndex', 0);
			$("select#Icount").prop('selectedIndex', 0);
			$("select#Fcount").prop('selectedIndex', 0);
			$("select#Icount").prop('selectedIndex', 0);
			$("select#Itype").prop('selectedIndex', 0);
			$("select#Ptype").prop('selectedIndex', 0);
			$("select#Ftype").prop('selectedIndex', 0);
			$("select#Dtype").prop('selectedIndex', 0);
		}
		// All New Function

		function Demo()
		{

		var GetPIStringstr='';
		var GetPAStringstr='';
		var GetPFAStringstr='';

			if(GetPI()==true)
			{
				GetPIStringstr ='<Pi '+GetPIString+' />';
				//alert(GetPIStringstr);
			}
			else
			{
				GetPIString='';
			}

			if(GetPA()==true)
			{
				GetPAStringstr ='<Pa '+GetPAString+' />';
				//alert(GetPAStringstr);
			}
			else
			{
				GetPAString='';
			}

			if(GetPFA()==true)
			{
				GetPFAStringstr ='<Pfa '+GetPFAString+' />';
				//alert(GetPFAStringstr);
			}
			else
			{
				GetPFAString='';
			}

			if(GetPI()==false && GetPA()==false && GetPFA()==false)
			{
				//alert("Fill Data!");
				DemoFinalString='';
			}
			else
			{
				DemoFinalString = '<Demo>'+ GetPIStringstr +' ' + GetPAStringstr + ' ' + GetPFAStringstr + ' </Demo>';
				//alert(DemoFinalString)
			}
		}

		function GetPI()
		{
			var Flag=false;
			GetPIString='';

			 if ($("#txtName").val().trim().length > 0)
            {
                Flag = true;
                GetPIString += "name="+ "\""+$("#txtName").val().trim()+"\"";
            }

            if ($("#drpMatchValuePI").val() > 0 && Flag)
            {
                Flag = true;
				GetPIString += " mv="+ "\""+$("#drpMatchValuePI").val().trim()+"\"";
            }

			if ($('#rdExactPI').is(':checked') && Flag)
            {
                Flag = true;
                GetPIString += " ms="+ "\"E\"";
            }
            else if ($('#rdPartialPI').is(':checked') && Flag)
            {
                Flag = true;
               GetPIString += " ms="+ "\"P\"";
            }
            else if ($('#rdFuzzyPI').is(':checked') && Flag)
            {
                Flag = true;
                GetPIString += " ms="+ "\"F\"";
            }
			if ($("#txtLocalNamePI").val().trim().length > 0)
            {
				Flag = true;
                GetPIString += " lname="+ "\""+$("#txtLocalNamePI").val().trim()+"\"";
            }

			if ($("#txtLocalNamePI").val().trim().length > 0 && $("#drpLocalMatchValuePI").val() > 0)
            {
				Flag = true;
				GetPIString += " lmv="+ "\""+$("#drpLocalMatchValuePI").val().trim()+"\"";
            }

            <!-- if ($("#drpGender").val() > 0) -->
            <!-- { -->

                if ($("#drpGender").val().trim() == "MALE")
                {
                    Flag = true;
					 GetPIString += " gender="+ "\"M\"";
                }
                else if ($("#drpGender").val().trim() == "FEMALE")
                {
                    Flag = true;
                     GetPIString += " gender="+ "\"F\"";
                }
                else if ($("#drpGender").val().trim() == "TRANSGENDER")
                {
                    Flag = true;
                   GetPIString += " gender="+ "\"T\"";
                }
            //}
			    if ($("#txtDOB").val().trim().length > 0 )
				{
					Flag = true;
					GetPIString += " dob="+ "\""+$("#txtDOB").val().trim()+"\"";
				}

				if ($("#drpDOBType").val() != "0")
				{
					Flag = true;
					GetPIString += " dobt="+ "\""+$("#drpDOBType").val().trim()+"\"";
				}

				if ($("#txtAge").val().trim().length)
				{
					Flag = true;
					GetPIString += " age="+ "\""+$("#txtAge").val().trim()+"\"";
				}

				if ($("#txtPhone").val().trim().length > 0 || $("#txtEmail").val().trim().length > 0)
				{
					Flag = true;
					GetPIString += " phone="+ "\""+$("#txtPhone").val().trim()+"\"";
				}
				if ($("#txtEmail").val().trim().length > 0)
				{
					Flag = true;
					GetPIString += " email="+ "\""+$("#txtEmail").val().trim()+"\"";
				}

			//alert(GetPIString);
			return Flag;
		}


		function GetPA()
		{
			var Flag=false;
			GetPAString='';

			if ($("#txtCareOf").val().trim().length > 0)
            {
				Flag = true;
                GetPAString += "co="+ "\""+$("#txtCareOf").val().trim()+"\"";
            }
            if ($("#txtLandMark").val().trim().length > 0 )
            {
                Flag = true;
                GetPAString += " lm="+ "\""+$("#txtLandMark").val().trim()+"\"";
            }
            if ($("#txtLocality").val().trim().length > 0 )
            {
               Flag = true;
                GetPAString += " loc="+ "\""+$("#txtLocality").val().trim()+"\"";
            }
            if ($("#txtCity").val().trim().length > 0 )
            {
                Flag = true;
                GetPAString += " vtc="+ "\""+$("#txtCity").val().trim()+"\"";
            }
            if ($("#txtDist").val().trim().length > 0 )
            {
                Flag = true;
                GetPAString += " dist="+ "\""+$("#txtDist").val().trim()+"\"";
            }
            if ($("#txtPinCode").val().trim().length > 0 )
            {
                Flag = true;
                GetPAString += " pc="+ "\""+$("#txtPinCode").val().trim()+"\"";
            }
            if ($("#txtBuilding").val().trim().length > 0 )
            {
                 Flag = true;
                GetPAString += " house="+ "\""+$("#txtBuilding").val().trim()+"\"";
            }
            if ($("#txtStreet").val().trim().length > 0 )
            {
                 Flag = true;
                GetPAString += " street="+ "\""+$("#txtStreet").val().trim()+"\"";
            }
            if ($("#txtPOName").val().trim().length > 0 )
            {
                 Flag = true;
                GetPAString += " po="+ "\""+$("#txtPOName").val().trim()+"\"";
            }
            if ($("#txtSubDist").val().trim().length > 0 )
            {
                  Flag = true;
                GetPAString += " subdist="+ "\""+$("#txtSubDist").val().trim()+"\"";
            }
            if ($("#txtState").val().trim().length > 0)
            {
                 Flag = true;
                GetPAString += " state="+ "\""+$("#txtState").val().trim()+"\"";
            }
            if ( $('#rdMatchStrategyPA').is(':checked') && Flag)
            {
                Flag = true;
                GetPAString += " ms="+ "\"E\"";
            }
			//alert(GetPIString);
			return Flag;
		}



		function GetPFA()
		{
			var Flag=false;
			GetPFAString='';

			if ($("#txtAddressValue").val().trim().length > 0)
            {
				Flag = true;
                GetPFAString += "av="+ "\""+$("#txtAddressValue").val().trim()+"\"";
            }

			if ($("#drpMatchValuePFA").val() > 0 && $("#txtAddressValue").val().trim().length > 0)
            {
                Flag = true;
				GetPFAString += " mv="+ "\""+$("#drpMatchValuePFA").val().trim()+"\"";
            }

			if ($('#rdExactPFA').is(':checked') && Flag)
            {
                Flag = true;
                GetPFAString += " ms="+ "\"E\"";
            }
            else if ($('#rdPartialPFA').is(':checked') && Flag)
            {
                Flag = true;
               GetPFAString += " ms="+ "\"P\"";
            }
            else if ($('#rdFuzzyPFA').is(':checked') && Flag)
            {
                Flag = true;
                GetPFAString += " ms="+ "\"F\"";
            }

			if ($("#txtLocalAddress").val().trim().length > 0)
            {
				Flag = true;
                GetPFAString += " lav="+ "\""+$("#txtLocalAddress").val().trim()+"\"";
            }

			if ($("#drpLocalMatchValue").val() > 0 && $("#txtLocalAddress").val().trim().length > 0)
            {
                Flag = true;
				GetPFAString += " lmv="+ "\""+$("#drpLocalMatchValue").val().trim()+"\"";
            }
			//alert(GetPIString);
			return Flag;
		}

		$( "#ddlAVDM" ).change(function() {
		//alert($("#ddlAVDM").val());
		discoverAvdmFirstNode($("#ddlAVDM").val());
		});


		$( "#chkHttpsPort" ).change(function() {
		    if($("#chkHttpsPort").prop('checked')==true)
		    {
		        OldPort=true;
		    }
		    else
		    {
		        OldPort=false;
		    }

		});

		function discoverAvdmFirstNode(PortNo)
		{

			$('#txtWadh').val('');
		    $('#txtDeviceInfo').val('');
			$('#txtPidOptions').val('');
			$('#txtPidData').val('');

		//alert(PortNo);

		var primaryUrl = "http://127.0.0.1:";
            url = "";
					 var verb = "RDSERVICE";
                        var err = "";
						var res;
						$.support.cors = true;
						var httpStaus = false;
						var jsonstr="";
						 var data = new Object();
						 var obj = new Object();

							$.ajax({
							type: "RDSERVICE",
							async: false,
							crossDomain: true,
							url: primaryUrl + PortNo,
							contentType: "text/xml; charset=utf-8",
							processData: false,
							cache: false,
							async:false,
							crossDomain:true,
							success: function (data) {
								httpStaus = true;
								res = { httpStaus: httpStaus, data: data };
							    //alert(data);

								//debugger;

								 $("#txtDeviceInfo").val(data);

								var $doc = $.parseXML(data);

								//alert($($doc).find('Interface').eq(1).attr('path'));


								if($($doc).find('Interface').eq(0).attr('path')=="/rd/capture")

								{
								  MethodCapture=$($doc).find('Interface').eq(0).attr('path');
								}
								if($($doc).find('Interface').eq(1).attr('path')=="/rd/capture")

								{
								  MethodCapture=$($doc).find('Interface').eq(1).attr('path');
								}

								if($($doc).find('Interface').eq(0).attr('path')=="/rd/info")

								{
								  MethodInfo=$($doc).find('Interface').eq(0).attr('path');
								}
								if($($doc).find('Interface').eq(1).attr('path')=="/rd/info")

								{
								  MethodInfo=$($doc).find('Interface').eq(1).attr('path');
								}

								<!-- MethodInfo=$($doc).find('Interface').eq(0).attr('path'); -->
								<!-- MethodCapture=$($doc).find('Interface').eq(1).attr('path'); -->

								 alert("RDSERVICE Discover Successfully");
							},
							error: function (jqXHR, ajaxOptions, thrownError) {
							$('#txtDeviceInfo').val("");
							//alert(thrownError);
								res = { httpStaus: httpStaus, err: getHttpError(jqXHR) };
							},
						});

						return res;
		}








		function discoverAvdm()
		{

            <!-- ddlAVDM.empty(); -->

			// New

			openNav();


			$('#txtWadh').val('');
		    $('#txtDeviceInfo').val('');
			$('#txtPidOptions').val('');
			$('#txtPidData').val('');

			//


			var SuccessFlag=0;
            var primaryUrl = "http://127.0.0.1:";

						 try {
							 var protocol = window.location.href;
							 if (protocol.indexOf("https") >= 0) {
								primaryUrl = "https://127.0.0.1:";
							}
						 } catch (e)
						{ }


            url = "";
			 $("#ddlAVDM").empty();
			//alert("Please wait while discovering port from 11100 to 11120.\nThis will take some time.");
			    for (var i = 11100; i <= 11120; i++)
                {
					if(primaryUrl=="https://127.0.0.1:" && OldPort==true)
					{
					   i="8005";
					}
				    $("#lblStatus1").text("Discovering RD service on port : " + i.toString());

						var verb = "RDSERVICE";
                        var err = "";
						SuccessFlag=0;
						var res;
						$.support.cors = true;
						var httpStaus = false;
						var jsonstr="";
						 var data = new Object();
						 var obj = new Object();



							$.ajax({

							type: "RDSERVICE",
							async: false,
							crossDomain: true,
							url: primaryUrl + i.toString(),
							contentType: "text/xml; charset=utf-8",
							processData: false,
							cache: false,
							crossDomain:true,

							success: function (data) {

								httpStaus = true;
								res = { httpStaus: httpStaus, data: data };
							    //alert(data);
								finalUrl = primaryUrl + i.toString();
								var $doc = $.parseXML(data);
								var CmbData1 =  $($doc).find('RDService').attr('status');
								var CmbData2 =  $($doc).find('RDService').attr('info');
								if(RegExp('\\b'+ 'Mantra' +'\\b').test(CmbData2)==true)
								{
								    closeNav();
									$("#txtDeviceInfo").val(data);

									if($($doc).find('Interface').eq(0).attr('path')=="/rd/capture")
									{
									  MethodCapture=$($doc).find('Interface').eq(0).attr('path');
									}
									if($($doc).find('Interface').eq(1).attr('path')=="/rd/capture")
									{
									  MethodCapture=$($doc).find('Interface').eq(1).attr('path');
									}
									if($($doc).find('Interface').eq(0).attr('path')=="/rd/info")
									{
									  MethodInfo=$($doc).find('Interface').eq(0).attr('path');
									}
									if($($doc).find('Interface').eq(1).attr('path')=="/rd/info")
									{
									  MethodInfo=$($doc).find('Interface').eq(1).attr('path');
									}

									$("#ddlAVDM").append('<option value='+i.toString()+'>(' + CmbData1 +')'+CmbData2+'</option>')
									SuccessFlag=1;
									alert("RDSERVICE Discover Successfully");
									return;

								}

								//alert(CmbData1);
								//alert(CmbData2);

							},
							error: function (jqXHR, ajaxOptions, thrownError) {
							if(i=="8005" && OldPort==true)
							{
								OldPort=false;
								i="11099";
							}
							$('#txtDeviceInfo').val("");
							//alert(thrownError);

								//res = { httpStaus: httpStaus, err: getHttpError(jqXHR) };
							},

						});



						if(SuccessFlag==1)
						{
						  break;
						}

						//$("#ddlAVDM").val("0");

                }

				if(SuccessFlag==0)
				{
				 alert("Connection failed Please try again.");
				}

				$("select#ddlAVDM").prop('selectedIndex', 0);

				//$('#txtDeviceInfo').val(DataXML);

				<!-- var PortVal= $('#ddlAVDM').val($('#ddlAVDM').find('option').first().val()).val(); -->

				<!-- if(PortVal>11099) -->
				<!-- { -->

				   <!-- discoverAvdmFirstNode(PortVal); -->
				<!-- } -->
				closeNav();
				return res;
		}


		function openNav() {
			<!-- document.getElementById("myNav").style.width = "100%"; -->
		}

		function closeNav() {
			<!-- document.getElementById("myNav").style.width = "0%"; -->
		}

		function deviceInfoAvdm()
		{
			//alert($("#ddlAVDM").val());
            <!-- ddlAVDM.empty(); -->





            url = "";

					<!-- alert(i.toString()); -->
                    // $("#lblStatus").text("Discovering RD Service on Port : " + i.toString());
					//Dynamic URL

						finalUrl = "http://127.0.0.1:" + $("#ddlAVDM").val();

						try {
							var protocol = window.location.href;
							if (protocol.indexOf("https") >= 0) {
								finalUrl = "https://127.0.0.1:" + $("#ddlAVDM").val();
							}
						} catch (e)
						{ }

					//
					 var verb = "DEVICEINFO";
                      //alert(finalUrl);

                        var err = "";

						var res;
						$.support.cors = true;
						var httpStaus = false;
						var jsonstr="";
						;
							$.ajax({

							type: "DEVICEINFO",
							async: false,
							crossDomain: true,
							url: finalUrl+MethodInfo,
							contentType: "text/xml; charset=utf-8",
							processData: false,
							success: function (data) {
							//alert(data);
								httpStaus = true;
								res = { httpStaus: httpStaus, data: data };

								$('#txtDeviceInfo').val(data);
							},
							error: function (jqXHR, ajaxOptions, thrownError) {
							alert(thrownError);
								res = { httpStaus: httpStaus, err: getHttpError(jqXHR) };
							},
						});

						return res;

		}



		function CaptureAvdm()
		{

	   Demo();
	   if($("#txtWadh").val().trim()!="")
	   {
		var XML='<?xml version="1.0"?> <PidOptions ver="1.0"> <Opts fCount="'+$("#Fcount").val()+'" fType="'+$("#Ftype").val()+'" iCount="'+$("#Icount").val()+'" pCount="'+$("#Pcount").val()+'" format="'+$("#Dtype").val()+'"   pidVer="'+$("#Pidver").val()+'" timeout="'+$("#Timeout").val()+'" wadh="'+$("#txtWadh").val()+'" posh="UNKNOWN" env="'+$("#Env").val()+'" /> '+DemoFinalString+'<CustOpts><Param name="mantrakey" value="'+$("#txtCK").val()+'" /></CustOpts> </PidOptions>';
	   }
	   else
	   {
		var XML='<?xml version="1.0"?> <PidOptions ver="1.0"> <Opts fCount="'+$("#Fcount").val()+'" fType="'+$("#Ftype").val()+'" iCount="'+$("#Icount").val()+'" pCount="'+$("#Pcount").val()+'" format="'+$("#Dtype").val()+'"   pidVer="'+$("#Pidver").val()+'" timeout="'+$("#Timeout").val()+'" posh="UNKNOWN" env="'+$("#Env").val()+'" /> '+DemoFinalString+'<CustOpts><Param name="mantrakey" value="'+$("#txtCK").val()+'" /></CustOpts> </PidOptions>';
	   }
			//alert(XML);

            <!-- url = ""; -->

					 var verb = "CAPTURE";


                        var err = "";

						var res;
						$.support.cors = true;
						var httpStaus = false;
						var jsonstr="";
						;

                            if(finalUrl+MethodCapture == "") {
                                alert('Device not discovered');
                                return false;
                            }

							$.ajax({

							type: "CAPTURE",
							async: false,
							crossDomain: true,
							url: finalUrl+MethodCapture,
							data:XML,
							contentType: "text/xml; charset=utf-8",
							processData: false,
							success: function (data) {
							//alert(data);
								httpStaus = true;
								res = { httpStaus: httpStaus, data: data };

								$('#txtPidData').val(data);
								$('#txtPidOptions').val(XML);

								var $doc = $.parseXML(data);
								var Message =  $($doc).find('Resp').attr('errInfo');

								alert(Message);

							},
							error: function (jqXHR, ajaxOptions, thrownError) {
							//$('#txtPidOptions').val(XML);
							alert(thrownError);
								res = { httpStaus: httpStaus, err: getHttpError(jqXHR) };
							},
						});

						return res;
		}
		function getHttpError(jqXHR) {
		    var err = "Unhandled Exception";
		    if (jqXHR.status === 0) {
		        err = 'Service Unavailable';
		    } else if (jqXHR.status == 404) {
		        err = 'Requested page not found';
		    } else if (jqXHR.status == 500) {
		        err = 'Internal Server Error';
		    } else if (thrownError === 'parsererror') {
		        err = 'Requested JSON parse failed';
		    } else if (thrownError === 'timeout') {
		        err = 'Time out error';
		    } else if (thrownError === 'abort') {
		        err = 'Ajax request aborted';
		    } else {
		        err = 'Unhandled Error';
		    }
		    return err;
		}

  </script>

</body>
</html>