/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @version     : 3.1.0
 **/

const loginLoader = "data:image/gif;base64,R0lGODlhEAALAPQAAP///wAAANra2tDQ0Orq6gYGBgAAAC4uLoKCgmBgYLq6uiIiIkpKSoqKimRkZL6+viYmJgQEBE5OTubm5tjY2PT09Dg4ONzc3PLy8ra2tqCgoMrKyu7u7gAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCwAAACwAAAAAEAALAAAFLSAgjmRpnqSgCuLKAq5AEIM4zDVw03ve27ifDgfkEYe04kDIDC5zrtYKRa2WQgAh+QQJCwAAACwAAAAAEAALAAAFJGBhGAVgnqhpHIeRvsDawqns0qeN5+y967tYLyicBYE7EYkYAgAh+QQJCwAAACwAAAAAEAALAAAFNiAgjothLOOIJAkiGgxjpGKiKMkbz7SN6zIawJcDwIK9W/HISxGBzdHTuBNOmcJVCyoUlk7CEAAh+QQJCwAAACwAAAAAEAALAAAFNSAgjqQIRRFUAo3jNGIkSdHqPI8Tz3V55zuaDacDyIQ+YrBH+hWPzJFzOQQaeavWi7oqnVIhACH5BAkLAAAALAAAAAAQAAsAAAUyICCOZGme1rJY5kRRk7hI0mJSVUXJtF3iOl7tltsBZsNfUegjAY3I5sgFY55KqdX1GgIAIfkECQsAAAAsAAAAABAACwAABTcgII5kaZ4kcV2EqLJipmnZhWGXaOOitm2aXQ4g7P2Ct2ER4AMul00kj5g0Al8tADY2y6C+4FIIACH5BAkLAAAALAAAAAAQAAsAAAUvICCOZGme5ERRk6iy7qpyHCVStA3gNa/7txxwlwv2isSacYUc+l4tADQGQ1mvpBAAIfkECQsAAAAsAAAAABAACwAABS8gII5kaZ7kRFGTqLLuqnIcJVK0DeA1r/u3HHCXC/aKxJpxhRz6Xi0ANAZDWa+kEAA7AAAAAAAAAAAA";

$.validator.addMethod("dateFormat", function(value, element) { 
    return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
},"Enter valid format DD-MM-YYYY.");

function safeJson(fid,fkey) {
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey($(fkey).val());
    var formdata = $(fid).serializeArray();
    var data = {};
    $(formdata).each(function(index, obj){
        if(obj.value != "") {
            data[obj.name] = encrypt.encrypt(obj.value);
        } else {
            data[obj.name] = "";
        }
    });
    return JSON.stringify(data);
}

// Registration Validation
$("#RegForm").validate({
    rules: {
        RegCustTitle: {
            required: true
        },
        RegName: {
            required: true,
            minlength: 2
        },
        RegEmail: {
            required: true,
            email: true
        },
        RegMob: {
            required: true,
            minlength: 10
        },
        RegReferral: {
            required: false
        },
        RegCaptcha: {
            required: true
        },
        RegAgree1: {
            required: true
        },
        RegAgree2: {
            required: true
        },
    },
    groups: {
        RegAgree: "RegAgree1 RegAgree2"
    },
    messages: {
        RegCustTitle : "Please select title",
        RegName : {
            required: "Please enter your Full Name",
            minlength: "Please enter valid Name"
        },
        RegEmail: {
            required: "We need your email address",
            email: "Your email address must be in valid format"
        },
        RegMob: {
            required: "Please enter mobile number",
            minlength: "Please enter 10 digit number"
        },
        RegCaptcha: "Please enter code shown in above image",
        RegAgree1: "Please click on checkbox",
        RegAgree2: "Please click on checkbox",
    },
    errorPlacement: function (error, element) {
        if(element.closest('.input_div').length) {
            error.insertAfter(element.closest('.input_div'));
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: validateDbt
});

// Validate DBT
function validateDbt() {
    var dbt = $('#reg_dbt_choice').val();
    if(dbt == "Y" || dbt == "N") {
        RegFormSubmit();
    } else {

        // PopUp-1
        swal.fire({ 
            title:'', 
            text:"DBT beneficiary in another Bank account", 
            icon:'info', 
            allowOutsideClick:false, 
            confirmButtonText:'YES',
            showCancelButton: true,
            cancelButtonText:'NO'
        }).then(function (result) {
            if (result.value) {
                $('#reg_dbt_choice').val('Y');
                RegFormSubmit();
            } else {

                // PopUp-2
                swal.fire({ 
                    title:'', 
                    text:"I will receive benefits or subsidies of welfare schemes in some other Bank account.", 
                    icon:'info', 
                    allowOutsideClick:false, 
                    confirmButtonText:'PROCEED',
                    showCancelButton: true,
                    cancelButtonText:'CANCEL'
                }).then(function (result) {
                    if (result.value) {
                        $('#reg_dbt_choice').val('N');
                        RegFormSubmit();
                    }
                });

            }
        });
        
    }
}

// Registration Form
function RegFormSubmit() {

    disable('btnRegister');

    var jsonData = safeJson("#RegForm","#reg_key");
    //console.log(jsonData);
    var ReqData = {
        regToken: $('#reg_token').val(),
        data: jsonData
    };

    $.ajax({
        type: 'POST',
        url: 'post/req-register',
        data: ReqData,
        beforeSend: function () {
            //disable('btnRegister');
            $("#btnRegister").html('<span class="mdi mdi-swap-horizontal"></span> Validating');
        },
        success: function (response) {
            if(response == "ok") {
                $("#btnRegister").html('<img src="' + loginLoader + '" /> &nbsp; Loading...');
                window.location.href = "./pages/otp-verify";
            } else {
                RegCaptcha();
                swal.fire('', response, 'warning');
                $("#btnRegister").html('Start Now  <span class="mdi mdi-chevron-right"></span>');
                enable('btnRegister');
            }
        },
        error: function (response) {
            alert('Error : Unable to process request, Please try again.');
            $("#btnRegister").html('Start Now <span class="mdi mdi-chevron-right"></span>');
            enable('btnRegister');
        }
    });

    return false;

}

// Resume Validation
$("#SignInForm").validate({
    rules: {
        LoginMob: {
            required: true,
            minlength: 10
        },
        LoginEmail: {
            required: true,
            email: true
        },
        LoginCaptcha: {
            required: true
        },
        RegAgree3: {
            required: true
        },
    },
    messages: {
        LoginMob: {
            required: "Please enter mobile number",
            minlength: "Please enter 10 digit number"
        },
        LoginEmail: {
            required: "We need your email address",
            email: "Your email address must be in valid format"
        },
        LoginCaptcha: "Please enter code shown in above image",
        RegAgree3: "Please click on checkbox",
    },
    errorPlacement: function (error, element) {
        if(element.closest('.input_div').length) {
            error.insertAfter(element.closest('.input_div'));
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: SignInSubmit
});


// Resume Form
function SignInSubmit() {

    disable('btnSignIn');

    var jsonData = safeJson("#SignInForm","#signIn_key");
    //console.log(jsonData);
    var ReqData = {
        regToken: $('#signIn_token').val(),
        data: jsonData
    };

    $.ajax({
        type: 'POST',
        url: 'post/req-login',
        data: ReqData,
        beforeSend: function() {
            //disable('btnSignIn');
            $("#btnSignIn").html('<span class="mdi mdi-swap-horizontal"></span> Validating');
        },
        success: function(response) {
            if(response == "ok") {
                $("#btnSignIn").html('<img src="' + loginLoader + '" /> &nbsp; Loading...');
                window.location.href = "./pages/otp-verify";
            } else {
                SingInCaptcha();
                swal.fire('', response, 'warning');
                $("#btnSignIn").html('Proceed  <span class="mdi mdi-chevron-right"></span>');
                enable('btnSignIn');
            }
        },
        error: function(response) {
            alert('Error : Unable to process request, Please try again.');
            $("#btnSignIn").html('Proceed <span class="mdi mdi-chevron-right"></span>');
            enable('btnSignIn');
        }
    });

    return false;

}
