/**
 * Created By Russel CMC Developer @ Motortrade 
 * 11/9/2020
 */

 window.onload = () => {
 const myInput = document.getElementsByClassName('mobile');
 myInput.onpaste = e => e.preventDefault();
}

var otpTimerSec;
 $(document).ready( function ()
 {
    /* Init Modified in First Load */
    var p = $(".required-field").parents('.form-group');
    p.find('label:first-child').prepend('<span class="text-danger">* </span>');
    $('.ajax-loader').addClass('d-none').removeClass("d-flex");

    $(".use-select2").select2({
        "width": "100%",
        "multiple": true,
        "maximumSelectionLength" : 1
    });

    $("#branch_code").select2({
        "placeholder" : "Type at least 3 characters",
        "width": "100%",
        "matcher" : matchCustom,
        "maximumSelectionLength" : 1
    });

    $('.datetime').datetimepicker({
        format:'m-d-Y H:i'
    });

    $("#preferrededatetime").datetimepicker({
        allowTimes:[
            '9:00', '10:00', '11:00', '12:00', 
            '13:00', '14:00', '15:00', '16:00'
        ],
        minDate: 0,
        minTime: '9:00',
        maxTime: '17:00',
        validateOnBlur: false,
    });
    /* End Modified in First Load */
    $(document).ajaxStart(function()
    {
        $('.ajax-loader').removeClass('d-none').addClass("d-flex");
    })
    .ajaxComplete(function () {
        $('.ajax-loader').addClass('d-none').removeClass("d-flex");
    });

    if (typeof categories !== 'undefined') {
        filledInSelectElem($("#category_id"), categories);
        filledInSelectElem($("#mc_brand"), mc_brand);
        // filledInSelectElem($("#mc_color"), mc_colors);
        // filledInSelectElem($("#region"), regions);
        // filledInSelectElem($("#b_region"), b_regions);
    }
    
    filledInSelectElem($("#branch_code"), branchesData);

    $(document).on("change", ".main-filterer", function ()
    {
        if ( $(this).val() != "" || $(this).val() != null || $(this).val() != undefined ) {
            var el = $(this).data("target-idelem");
            var arrayData;
            switch ($(this).data("target-json"))
            {
                case 'mc_models':
                    arrayData = mc_models;
                    break;
                case 'provinces':
                    arrayData = provinces;
                    break;
                case 'cities':
                    arrayData = cities;
                    break;
                case 'barangays':
                    arrayData = barangays;
                    break;
                case 'branchesData':
                    arrayData = branchesData;
                    break;
                case 'b_areas':
                    arrayData = b_areas;
                    break;
                default:
                    /* No Deafult */
                    break;
            }
            // end switch
            filledInSelectElem($(el), arrayData, $(this).val());
        }
    });

    // Form Submit
    var serviceForm = $("#service-appoinment-form");
    serviceForm.on("submit", function(e)
    {
        if ( $("#mainformbody").find('.custom-alert').length > 0 ) {
            $(".custom-alert").remove();
        }

        var f = $(this).find(".required-field");
        var vl = true;
        var formData = new FormData(this);
        var valuen = $("#mobile_no").val();

        if ( $(this).data('formstate') == 0 ) {
            alert("Please Check The I'm not a robot!");
            return false;
        }

        if(valuen.length < 12 || valuen.substring(0, 2) != '09') {
            alert('Please make sure you put a valid mobile number. Kindly recheck it.');
            return false;
        }

        $.each(f, function(i, d)
        {
            var p = $(this).parents('.form-group');
            if ( ($(this).val() == "" || $(this) == null || $(this).val() == undefined || $(this).val() == '- Select -') && !$(this).is("label") )
            {
                vl = false;
                errorField(this);
                // return false;
            }
            else
            {
                p.find('label').removeClass('text-danger');
                p.find('input, select, radio, .select2').removeClass('is-invalid');
            }
        });

        if ( !vl ) {
            showAlert("alert-danger", "ERROR!");
            return false;
        }

       e.preventDefault();

        $.when( checkBookingDateTime() ).done( function (cbd) {
            if ( !Number(cbd) && cbd != 0 ) {
                return false;
            }
            
            if ( $("#service-appoinment-form").data("otpstate") == 1 ) {
                return toggleOTPModal();
            }

            if ( ($("#gen_otp").val() == "0" && $("#input_otp").val() == "") || $("#service-appoinment-form").data("formstate") == 1 ) {
                return sendOTP($("#mobile_no").val(), $(this).data('otpstate'), $("#service-appoinment-form"), "service");
            }
        });
    });
    // End Form Submit

    // mobile number on keypress
    $("#mobile_no").keyup(function (e)
    {
        if ( $(this).val().length > 11) return false;
        var key = e.charCode || e.keyCode || 0;
        $t = $(this); 
        if (key !== 8 && key !== 9) {
            if ($t.val().length === 4) {
                $t.val($t.val() + '-');
            }
        }
    });

    $("#mobile_no").keypress(function (e)
    {
        var ASCIICode = (e.which) ? e.which : e.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    });

    // btn confrim otp
    $("#btn-confirmotp").click(function () {
        if ( $('#input_otp').val() == $('#gen_otp').val() ) {
            var formData = new FormData($("#service-appoinment-form")[0]);
            return formDataSA(formData);
        }
        errorField($("#input_otp"), 1, "Invalid OTP");
    });

    $(document).on("keyup" , "#input_otp", function (e) {
        if ( e.which === 13 )
        {
            if ( $('#input_otp').val() == $('#gen_otp').val() ) {
                var formData = new FormData($("#service-appoinment-form")[0]);
                return formDataSA(formData);
            }
            errorField($("#input_otp"), 1, "Invalid OTP");
        }
    });

    // send otp butotn
    $(document).on("click", ".sendotp", function() {
       sendOTP ($("#mobile_no").val());
    });

    // Resend OTP
    $(document).on("click", "#re-otp", function() {
        var thisForm = $($("form")[0]);
        sendOTP ($("#mobile_no").val(), thisForm.data("otpstate"), thisForm);
    });

    // Agreement Check Change
    $("#agreement-checkbox").change(function () {
        enableBtnSignup();
    });

    // Cancel Submit the form
    $("#cancenl-submit").click(function (e) {
        e.preventDefault();
        toggleOTPModal('hide');
        // cancelOTP();
        grecaptcha.reset();
        enableBtnSignup();
    });

    // on close of modal reset the recaptcha
    $('#confirm-otp-modal').on('hidden.bs.modal', function () {
        // cancelOTP();
        grecaptcha.reset();
        enableBtnSignup();
    });
      

    // only number in otp
    setInputFilter( document.getElementById("input_otp"), function(v) {
        return /^-?\d*$/.test(v);
    });

    // DateTime on keypress
    $(document).on("keypress keydown", "#preferrededatetime", function (e) {
        if ( e.which === 8 ) {
            return false;
        }
        if ( e.which === 9 ) {
            return true;
        }
        return false;
    });

    // On window resize
    $(window).resize( function () {
        windowSize ( $(window).width() );
    });

    // call the window onload
    windowSize ();

 });
 // End of Document Ready function

// function on load window size
function windowSize ( w )
{
    w = w === undefined ? $(window).width() : w ;
    var mw = $('#main-wrapper');
    var sw = $('#sub-wrapper');
    var midw = 991.98;

    if ( w < midw && mw.hasClass('py-2 px-5') ) {
        mw.removeClass('py-2  px-5');
        sw.removeClass('px-5');
        return false;
    }

    if ( w > midw && !mw.hasClass('py-2 px-5') ) {
        mw.addClass('py-2 px-5');
        sw.addClass('px-5');
        return false;
    }
}

 // Function to repopulate Select Elements, if idFiltereed is Available this function will produce filtered data
function filledInSelectElem(elem, arrayData, idFiltered = null, isBrandId = false)
{
    if ( arrayData === undefined || arrayData == 0) {
        return alert("Unable to Load server Data");
    }

    elem.empty().append('<option>- Select -</option>');
    var attr = "";
    $.each(arrayData, function(i, d)
    {
        attr += (d.isFilter !== undefined || d.isFilter !== null) ? "" : ' data-filterid = "'+ d.isFilter +'"';
        attr += isBrandId ? ` data-brandid="${d.BrandId}"` : "";
        attr += $('.main-filterer').data('target-json') == 'mc_models' ? ` data-mccategory = "${d.Category}"`: "";
        if ( idFiltered !== null ) {
            if ( d.isFilter == idFiltered ) {
                elem.append('<option value="'+ d.id +'" '+ attr +'>'+ d.displayName +'</option>');
            }
            attr = "";
            return true;
        }
        elem.append(`<option value="${d.id}" ${attr}>${d.displayName}</option>`);

        attr = "";
    });
    
    return true; // This is manok
}
/** Validate Email */
function validateEmail (email)
{
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

// reCaptcha Callback
function recaptchaCallback()
{
    $("#service-appoinment-form, #ltrs-application-form, #msform, #job-application-form, #bigbike-reservation-form , #testride-form").data("formstate", 1);
    enableBtnSignup();
}

function recaptchaExpired()
{
    // $("#service_appoinment_form").prop("disabled", true);
    $("#service-appoinment-form, #ltrs-application-form, #msform, #job-application-form, #bigbike-reservation-form, #testride-form").data('formstate', 0);
    // $("#confirm-otp-modal").modal('hide');
    toggleOTPModal('hide');
}

// OTP Related?
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

// function send ajax FormData to Server
function formDataSA(formData = null)
{
    if (formData === null) {
        alert("Something Error unable get the Form Details.");
        return false;
    }

    if ( $("#mainformbody").find('.custom-alert').length > 0 ) {
        $(".custom-alert").remove();
    }

    if ( $("#service-appoinment-form").data("otp-exp-min") == 0 ) {
        return false;
    }

    formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
    formData.append("categoryname", $("#category_id").data("categoryname"));
    formData.append("mccategory", $("#mc_model option:selected").data("mccategory"));
    
    return $.ajax({
        url: base_url + 'Service/newServiceAppointment',
        type: 'POST',
        data: formData,
        timeout: 600000,
        contentType: false,
        processData: false,
       
        success: function(r) {
          var str = r.replace(/\s/g, '');
          if (str == '1' || str == 1 )
          {
            alert("Form sent. Thank you for choosing Motortrade Group." );
            toggleOTPModal('hide');
            $("#confirm-otp-modal").find('input').val('');
            // showAlert('alert-success', "Form Sent", "Thank you for choosing Motortrade Group.");
            $("#service-appoinment-form").trigger("reset");
            $(".use-select2").val(null).trigger("change");
            $("#input_otp").val('');
            $("#service-appoinment-form").data("formstate", 0).data("reotp", 0).data("otpstate", 0).data("otptries", 3);
            remErorField($("#input_otp"));
            enableBtnSignup();
            clearInterval(otpTimerSec);
            $("html, body").animate({scrollTop: 0}, 100);
            return grecaptcha.reset();
          }
          toggleOTPModal('hide');
          return showAlert('alert-danger', "ERROR:", r );
        },
        error: function(xhr, textStatus, thrownErr) {
            showAlert('alert-danger', 'ERROR', "Error description: <br>"+ xhr.responseText +"<br>"+ textStatus +"<br>"+ thrownErr);
            toggleOTPModal('hide');
            $("html, body").animate({scrollTop: 0}, 100);
        }
    });
}

function errorField(el, isa = 0, m = "")
{
    // m = ( m != "" ) ? m : "Error: "+ $(el).parents('.form-group').find('label').text() +' is required';
    m = ( m != "" ) ? m : "Form contains error. Please provide the correct details.";
    var p = $(el).parents('.form-group');
    p.find('label').addClass('text-danger');
    p.find('input, select, radio, .select2').addClass('is-invalid');
    $(el).focus();

    return (isa == 1) ? alert(m) : true ;
}

function remErorField(el)
{
    var p = $(el).parents('.form-group');
    p.find('label').removeClass('text-danger');
    p.find('input, select, radio, .select2').removeClass('is-invalid');
    $(el).focus();
    return true;
}

function showAlert(type = "alert-info", cusName = "", message = "Form contains error. Please provide the correct details.")
{
    m = $("#mainformbody");
    var e = "";
    e += '<div class="custom-alert alert '+ type +' alert-dismissible fade show" role="alert">';
    e +=    '<strong>'+ cusName +'</strong> '+message;
    e +=    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    e +=        '<span aria-hidden="true">&times;</span>';
    e +=    '</button>';
    e += '</div>';

    if ( m.find('.custom-alert').length == 0 ) {
        $("html, body").animate({scrollTop: 0}, 100);
        return $("#mainformbody").prepend(e);
    }
}

function sendOTP (m = "", r = 0, thisForm = null, form_name = "")
{
    if ( m == "" ) {
        return showAlert("alert-danger", "Mobile Number!", "Mobile number is not set");
    }

    var thisForm = thisForm === null ? $("#service-appoinment-form") : thisForm;

    if ( !reachedLimitOTP() ) {
        return false;
    }

    if ( thisForm.data('otpstate') == '0' || thisForm.data('otpstate') == 0 )
    {
       if ( confirm("Motortrade will send a verification code to your number "+ $("#mobile_no").val() +". Proceed?") ) {
           return sendtoServer (m, r, thisForm, form_name);
       }
       return showAlert('alert-danger', "ERROR!", "You'd cancelled the verification of your mobile number" );
    }
    else
    {
        return sendtoServer (m, r, thisForm, form_name);
    }
    function sendEmail(otpstate) {
        var email = $('#applicant_email').val();
        var url = base_url + "send-otp-email";
        var formData = new FormData();
        formData.append("otp", otpstate);
        formData.append("email", email);
		formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));

        $.ajax({
			type: "POST",
			url: url,
			data: formData,
			processData: false, // Prevent jQuery from automatically processing the data
			contentType: false, // Set content type to false
			dataType: "json",
			success: function (result) {
				console.log(result);
				
			},
			error: function (xhr, status, error) {
				console.error("Ajax request error:", error);
			},
		});
	}
    function sendtoServer (m, r, thisForm, form_name)
    {
        /* Init */
        min = Math.ceil(1111);
        max = Math.floor(9999);
        getOTP = Math.floor(Math.random() * (max - min)) + min;
        var thisForm = thisForm === null ? $("#service-appoinment-form") : thisForm;
        var formName = form_name;
        if(form_name == "job_app") {
            sendEmail(getOTP)
        }
       

        return $.ajax({
            url: base_url + "Service/sendOTP",
            type: "POST",
            data: {
                getOTP  :   getOTP,
                m_no    :   $("#mobile_no").val(),
                form_name : formName,
                _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
            },
            success: function (res)
            {
                if ( !Number(res) ) {
                    var a = res.split(',');
                    toggleOTPModal('hide');
                    return showAlert('alert-danger', 'ERROR: ', a[1]);
                }
                $("#otp-attempts").text( thisForm.data("otptries") - 1 );
                // $("#confirm-otp-modal").find(".modal-title").text("Confirm OTP "+ getOTP); // remove if sending is done
                $("#gen_otp").val(getOTP);
                $("#m-no").text(m);
                $("#cs-labl").remove();
                toggleOTPModal();
                
                if ( thisForm.data("otpstate") == 0 ) {
                    otpTimer(parseInt(thisForm.data("otp-exp-min")) * 60, $(".otp-timer-num"));
                }
                $(thisForm)
                    .data("otptries", Number(thisForm.data("otptries")) - 1)
                    .data("formstate", 1)
                    .data("reotp", 1)
                    .data("otpstate", 1);
                return true;
            },
            beforeSend: function() {
                // $(".ajax-loader").append('<h3 id="cs-labl" class="align-self-center"> &nbsp; Sending OTP</h3>');
            },
            error: function(xhr, textStatus, thrownErr) {
                showAlert('alert-danger', 'ERROR', "Error description: <br>"+ xhr.responseText +"<br>"+ textStatus +"<br>"+ thrownErr);
            }
        });
    }
}

function enableBtnSignup()
{
    return false;
    if ( $("#agreement-checkbox").is(':checked') && $("#service-appoinment-form").data('formstate') == 1 ) {
        $("#service_appoinment_form").prop("disabled", false);
    } else {
        $("#service_appoinment_form").prop("disabled", true);
    }
}

function cancelOTP(thisForm = null)
{
    thisForm = thisForm === null ? $("#service_appoinment_form") : thisForm;
    thisForm.prop("disabled", true).addClass("d-none");
    thisForm.data('formstate', 0);
    // $("#agreement-checkbox").prop("checked", false);
}

function checkBookingDateTime ()
{
    return $.ajax({
        url: base_url + "Service/checkBookDatetime",
        type: "POST",
        data: {
            preferrededatetime  :   $("#preferrededatetime").val(),
            branch_code         :   $("#branch_code").val(),
            _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
        },
        success: function (r)
        {
            if ( !Number(r) && r != 0 ) {
                errorField("#preferrededatetime", 1, r);
                return showAlert('alert-danger', 'ERROR: ', r);
            }
        },
        error: function(xhr, textStatus, thrownErr) {
            return showAlert('alert-danger', 'ERROR', "Error description: <br>"+ xhr.responseText +"<br>"+ textStatus +"<br>"+ thrownErr);
        }
    });
}

function setInputFilter(textbox, inputFilter)
{
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach( function(e) {
      textbox.addEventListener(e, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    });
}

function toggleOTPModal ($t = "show")
{
    var e = $("#confirm-otp-modal");

    if ( $t == 'show' ) {
        return e.modal({
            keyboard: true,
            backdrop: 'static'
        });
    }

    if ( $t == 'hide' ) {
        return e.modal('hide');
    }
}

function otpTimer(duration, el)
{
    var timer = duration, minutes, seconds;
    otpTimerSec = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        // el.textContent = minutes + ":" + seconds;
        // console.log(minutes + ":" + seconds);
        // el.html(minutes + ":" + seconds);

        if (--timer < 0) {
            clearInterval(otpTimerSec);
            toggleOTPModal('hide');
            showAlert("alert-danger", "Mobile number Verification Expires", "Please retry again.");
            serviceForm.data("otp-exp-min", 0);
        }
    }, 1000);
}

function reachedLimitOTP ()
{
    var fs = $("#service-appoinment-form");
    if ( fs.data("otptries") == 0 ) {
        alert("You have reached the maximum tries to confirm your mobile number.");
        showAlert("alert-danger", "You have reached the maximum tries to confirm your mobile number.", "");
        return false;
    }

    return true;
}

// Match Custom for the select2
function matchCustom(params, data)
{
    // If there are no search terms, return null of the data
    if ($.trim(params.term) === '' || (params.term).length < 3 ) {
      return null;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
      return null;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    // var n = data.text.toUpperCase();
    if (data.text.indexOf((params.term).toUpperCase()) > -1) {
      var modifiedData = $.extend({}, data, true);
    //   modifiedData.text += ' (matched)';

      // You can return modified objects from here
      // This includes matching the `children` how you want in nested data sets
      return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
}

function error(data='',message='')
{
    Swal.fire({
        title: data,
        icon: 'error',
        text: message,
        customClass: 'swal-width'
      })
}

function success()
{
    Swal.fire({
        title: 'Success',
        icon: 'success',
        confirmButtonText: 'Done',
      }).then((result) => {
          window.location.reload()
      })
}

function confirmation()
{
    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`
      }).then((result) => {
        if (result.isConfirmed) {
          success()
        }
      })
}

function success(title)
{
    Swal.fire({
        title: title,
        icon: 'success',
        confirmButtonText: 'Done',
    }).then((result) => {
        window.location.reload()
    })
}