
/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @version     : 3.0.0
 **/

function focus(id) {
    $('#'+id).focus();
}

function hide(id) {
    $('#'+id).hide();
}

function show(id) {
    $('#'+id).show();
}

function disable(id) {
    $('#'+id).attr('disabled', true);
    $('#'+id).addClass('disabled');
}

function enable(id) {
    $('#'+id).attr('disabled', false);
    $('#'+id).removeClass('disabled');
}

function temp_disable(id) {
    $('#'+id).addClass('disabled');
    setTimeout(function () { $('#'+id).removeClass('disabled'); }, 2000);
}

function remove(id) {
    $('#'+id).remove();
}

function goto_url(url) {
    if(url) { window.location = url; } else { window.location.reload(); }
}

function user_said(txt) {
    alert(txt);
}

function sess_error(txt) {
    swal.fire('', txt);
    setTimeout(function() { goto_url(); }, 1000);
}

function safeFormData(fid, fkey) {
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

/* ------ Comm. ---- */

function data_serial(obj) {
    var str = [];
    for(var p in obj) {
        if(obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    }
    return str.join("&");
}

function get_data(info) {
    $.ajax({
        type: 'POST',
        url: 'get/data-get',
        data: data_serial(info),
        success: function(result) {
            $('#result').html(result);
            return true;
        },
        error: function(result) {
            //loader_stop();
            alert('Error : Unable to process request, Please try again.');
        }
    });
    return false;
}

function dynamic_data(info, fieldName) {
    if(fieldName && fieldName == "modify") {  loader_start(); }
    $.ajax({
        type: 'POST',
        url: 'dynamic/data-dynamic',
        data: data_serial(info),
        success: function(result) {
            if(fieldName && fieldName == "modify") { loader_stop(); }
            $('#result2').html(result);
            return true;
        },
        error: function(result) {
            if(fieldName && fieldName == "modify") { loader_stop(); }
            alert('Error : Unable to process request, Please try again.');
        }
    });
    return false;
}

function post_safe_data(formData, sbt = "sbt") {
    $.ajax({
        type: 'POST',
        url: 'post/data-post',
        data: data_serial(formData),
        success: function(result) {
            $('#result2').html(result);
            return true;
        },
        error: function(result) {
            if(sbt) { enable(sbt); }
            loader_stop();
            alert('Error : Unable to process request, Please try again.');
        }
    });
    return false;
}

function post_data(form, sbt) {
    $.ajax({
        type: 'POST',
        url: 'post/data-post',
        data: $('#'+form).serialize(),
        success: function(result) {
            $('#result2').html(result);
            return true;
        },
        error: function(result) {
            if(sbt) { enable(sbt); }
            loader_stop();
            alert('Error : Unable to process request, Please try again.');
        }
    });
    return false;
}

function deStr(data) {
    var str = document.createElement("textarea");
    str.innerHTML = atob(data);
    return str.value;
}


/** Modal Fix */

// Multi Modal
$(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});

// Modal Scroll
$(document).on('show.bs.modal','#ModalWin', function () {
    OverlayScrollbars(document.querySelector('#ModalWin'), {});
});

/** Get Modal */

function fetch_modal(fun, modal_size, mode, item = "", item2 = "", item3 = "") {
    if(!modal_size || modal_size == '') { modal_size = "lg" }
    if(!mode || mode == '') { mode = "V" }
    var data = {
        cmd: fun,
        data_mode: mode,
        req_token: window.req_id,
        id: item, id2: item2, id3: item3
    };
    get_modal_data(data, modal_size);
}

function send_form(id = "app-form", btn = "sbt") {
    disable(btn); loader_start(); post_data(id,btn);
}

function get_modal_data(info,m_size) {
    show_dataModal(m_size,'ModalWin','result'); // Open Pop-Up
    $.ajax({
        type: 'POST',
        url: 'get/data-get',
        data: data_serial(info),
        success: function (result) {
            $('#ModalWin-Response').html(result);
            return true;
        },
        error: function (result) {
            $('#ModalWin').modal('hide');
            alert('Error : Unable to process request, Please try again.');
        }
    });
    return false;
}

function show_dataModal(m_size, modal_id = "ModalWin", result_id = "result") {
    if (m_size == "lg") { m_size = "modal-lg"; }
    else if (m_size == "xl") { m_size = "modal-xl"; }
    else if (m_size == "xxl") { m_size = "modal-xxl"; }
    else { m_size = ""; }
    var html_data = "<div class='modal' id='" + modal_id + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'><div class='modal-dialog modal-dialog-centered " + m_size + "' role='document'><div class='modal-content'><div class='modal-header'><h5 class='modal-title ml-3' id='" + modal_id + "-ModalLabel'>Loading...</h5><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><div id='" + modal_id + "-Response'><div class='modal-body'><div class='row'><div class='col-md-6 form-group'><div class='skeleton-wrapper-body'><div class='skeleton-label'></div><div class='skeleton-content'></div></div></div><div class='col-md-6 form-group'><div class='skeleton-wrapper-body'><div class='skeleton-label'></div><div class='skeleton-content'></div></div></div><div class='col-md-6 form-group'><div class='skeleton-wrapper-body'><div class='skeleton-label'></div><div class='skeleton-content'></div></div></div><div class='col-md-6 form-group'><div class='skeleton-wrapper-body'><div class='skeleton-label'></div><div class='skeleton-content'></div></div></div><div class='col-md-6 form-group d-none d-md-block'><div class='skeleton-wrapper-body'><div class='skeleton-label'></div><div class='skeleton-content'></div></div></div><div class='col-md-6 form-group d-none d-md-block'><div class='skeleton-wrapper-body'><div class='skeleton-label'></div><div class='skeleton-content'></div></div></div><div class='col-md-6 form-group d-none d-md-block'><div class='skeleton-wrapper-body'><div class='skeleton-label'></div><div class='skeleton-content'></div></div></div><div class='col-md-6 form-group d-none d-md-block'><div class='skeleton-wrapper-body'><div class='skeleton-label'></div><div class='skeleton-content'></div></div></div></div></div></div></div></div></div></div>";
    $('#'+modal_id).modal('hide');
    $('#'+modal_id).remove();
    $('#'+result_id).html(html_data);
    $('#'+modal_id).appendTo("body").modal({ show: true, backdrop: 'static', keyboard: true, show: true });
    return true;
    //#ModalWin-ModalLabel #ModalResponse
}

/** Loader */

function loader_start(id) {
    if(id) { $('#'+id).LoadingOverlay('show'); } else { $.LoadingOverlay('show'); }
}

function loader_stop(id) {
    if(id) { $('#'+id).LoadingOverlay('hide', true); } else { $.LoadingOverlay('hide', true); }
}

//On Click Loader
$(".start-loader").on("click", function () {
    loader_start();
});

// No Blank Space
$(document).on('keyup change', '.js-noSpace', function () {
    $(this).val($(this).val().replace(/ +?/g, ''));
});

// Uppercase
$(document).on('keyup change', '.js-toUpper', function () { 
    $(this).val($(this).val().toUpperCase());
});

// Lowercase
$(document).on('keyup change', '.js-toLower', function () { 
    $(this).val($(this).val().toLowerCase());
});

// Only Alphanumeric
$(document).on('keyup change', '.js-alphaNumeric', function () {
    $(this).val(this.value.replace(/[^a-zA-Z0-9]/g, ''));
});

// Only characters
$(document).on('keyup change', '.js-Character', function () {
    $(this).val(this.value.replace(/[^a-zA-Z ]+$/, ''));
});

// Only Numbers
$(document).on('keydown keyup change paste', '.js-isNumeric', function () {
    $(this).val(this.value.replace(/[^0-9\.]/g, ''));
});

// Only Alphanumeric and space
$(document).on('keydown keyup change paste', '.js-alphaNumericspace', function () {
    $(this).val(this.value.replace(/[^a-zA-Z0-9 ]/g, ''));
});

// Card Number I/P
$(document).on('keyup change', '.js-isCard', function () {
    var foo = $(this).val().split("-").join("").replace(/[^0-9\.]/g,""); // remove hyphens
    if (foo.length > 0) {
      foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
    }
    $(this).val(foo);
});

// Auto resize textarea
$(document).on('change keyup keydown paste cut', '.js-autoResize', function () {
    $(this).css("height", "initial");
    $(this).height($(this)[0].scrollHeight - 16);
});

// Remove line breaks in textarea
$(document).on('change keyup keydown paste cut', '.js-noEnter', function () {
    $(this).val($(this).val().replace(/\r?\n/gi, ' '));
});

$(document).on('change keyup keydown paste cut', '.js-noEnter', function (e) {
    if (e.keyCode == 13 && !e.shiftKey) {
        e.preventDefault();
        return false;
    }
});

// Auto Tab
$(document).on('keyup change', '.js-autoTab', function () {
    //$(this).val(this.value.replace(/[^0-9\.]/g, ''));
    var $this = $(this);
    setTimeout(function () {
        if ($this.val().length >= parseInt($this.attr("maxlength"), 10))
            $this.next("input").focus();
    }, 100);
});


// Check Max. Characters
function max_characters(eid) {
    var max_chars = $(eid).attr('maxLength');
    if ($.isNumeric(max_chars)) {
        var t_length = $(eid).val().length;
        $(eid).val($(eid).val().substring(0, max_chars));
        var t_length = $(eid).val().length;
        var remain = max_chars - parseInt(t_length);
        $(eid).next('div').remove();
        $(eid).after('<div class="text-muted small my-1"> Max. ' + remain + ' characters remaining</div>');
    }
}

$(document).on('change keyup keydown paste cut', '.js-maxCheck', function () {
    max_characters($(this));
});

$(".js-maxCheck").each(function () {
    max_characters($(this));
});

$(document).ajaxComplete(function () {
    $(".js-maxCheck").each(function () {
        max_characters($(this));
    });
});

function LogoutAlert() {
    Swal.fire({
        title: 'Are you sure?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#828792',
        confirmButtonText: 'Yes, Cancel!',
        cancelButtonText: 'No',
    }).then((result) => {
    if(result.value) {
        loader_start();
        goto_url('../web-app/logout'); 
        }
    });
}

function on_change(pgm_code, fieldName, fieldVal, destID = "result2") {
    if(pgm_code) {
        if (fieldName && destID) {
            var data = {
                cmd: pgm_code, req_token: window.req_id,
                cmd2: 'onChange', field_name: fieldName, field_val: fieldVal, dest_id: destID
            };
            dynamic_data(data, fieldName);
        }
    } else {
        alert('onChange : Invalid Pgm.');
    }
}

/** Mask Mobile Number */
function mask_mobile($string) {
    if($string == NULL) { return ""; }
    $len = strlen(preg_replace('/\s+/','',$string));
    return substr_replace($string, str_repeat("*", ($len - 6) ), 2, ($len - 6) );
}

//new 
function on_change_client(pgm_code, fieldName, fieldVal, destID = "result2") {
    if(pgm_code) {
        if (fieldName && destID) {
            var data = {
                cmd: pgm_code, req_token: window.req_id,
                cmd2: 'onChange', field_name: fieldName, field_val: fieldVal, dest_id: destID
            };
            dynamic_data_client(data, fieldName);
        }
    } else {
        alert('onChange : Invalid Pgm.');
    }
}

function dynamic_data_client(info, fieldName) {
    if(fieldName && fieldName == "modify") {  loader_start(); }
    $.ajax({
        type: 'POST',
        url: 'prelogin/dynamic/data-dynamic',
        data: data_serial(info),
        success: function(result) {
            if(fieldName && fieldName ==    "modify") { loader_stop(); }
            $('#result2').html(result);
            return true;
        },
        error: function(result) {
            if(fieldName && fieldName == "modify") { loader_stop(); }
            alert('Error : Unable to process request, Please try again.');
        }
    });
    return false;
}