/**
 * Created by Mgezun
 * 12-08-2022
 */

$(document).ready(function() {
	if ($("#mrfId").val() == 0){
		$("#desired_position").css('display','block');
		$("#applicant_desired_position").addClass("required-field");
	} else {
		$("#desired_position").css('display','none');
		$("#applicant_desired_position").removeClass("required-field");
	}

    document.querySelector('#resume').addEventListener('change', function(e) {
        var fileName = document.getElementById("resume").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
        nextSibling.style.color = 'black'
    });

    $('#remove_resume').click(function() {
        $('#resume').val(null);
        $('#resume_label').html(
            '<span style="color:gray">Upload one Resume *</span>');
    });

    $(".cus_psgc").select2({
		placeholder: "Enter Municipality, Barangay (ex. Camarines Sur, Bato, Agos)",
		minimumInputLength: 5,
		maximumSelectionLength: 1,
		width: '100%',
		allowclear: true,
		multiple: true,
		ajax: {
			url: base_url + "ltrs/psgc",
			type: "POST",
			dataType: "json",
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					_cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
		},
	});

	$(document).on("change", ".cus_psgc", function () {
		var d = $(this).select2("data")[0];

		// return false if this value is empty
		if ($(this).val() == null || $(this).val() == "") {
			$(this)
				.data("psgc_brgy_code", 0)
				.data("psgc_citymun_code", 0)
				.data("psgc_prov_code", 0)
				.data("psgc_region_code", 0)
				.data("psgc_zip_code", 0);
			return false;
		}

		$(this)
			.data("psgc_brgy_code", d.psgc_brgy_code)
			.data("psgc_citymun_code", d.psgc_citymun_code)
			.data("psgc_prov_code", d.psgc_prov_code)
			.data("psgc_region_code", d.psgc_region_code)
			.data("psgc_zip_code", d.psgc_zip_code);
	});

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

    // Form Submit
	var jobAppForm = $("#job-application-form");
	jobAppForm.on("submit", function (e) {
		e.preventDefault();
		if ($("#mainformbody").find(".custom-alert").length > 0) {
			$(".custom-alert").remove();
		}

		var f = $(this).find(".required-field");
		var vl = true;
		var formData = new FormData(this);
		var valuen = $("#mobile_no").val();

		if ($(this).data("formstate") == 0) {
			alert("Please Check The I'm not a robot!");
			return false;
		}

		if (valuen.length < 12 || valuen.substring(0, 2) != "09") {
			alert(
				"Please make sure you put a valid mobile number. Kindly recheck it."
			);
			return false;
		}

		$.each(f, function (i, d) {
			var p = $(this).parents(".form-group");
			if ($(this).attr("disabled")) return true;

			if (
				($(this).val() == "" ||
					$(this).val() == undefined ||
					$(this).val() == "- Select -") &&
				!$(this).is("label")
			) {
				vl = false;
				errorField(this);
			} else {
				p.find("label").removeClass("text-danger");
				p.find("input, select, radio, .select2").removeClass("is-invalid");
			}
		});

		if (!vl) {
			showAlert("alert-danger", "ERROR!");
			return false;
		}

		if (jobAppForm.data("otpstate") == 1) {
			return toggleOTPModal();
		}

		if (
			($("#gen_otp").val() == "0" && $("#input_otp").val() == "") ||
			jobAppForm.data("formstate") == 1
		) {
			console.log("nani");
			return sendOTP(
				$("#mobile_no").val(),
				$(this).data("otpstate"),
				$("#job-application-form"),
				"job_app"
			);
		}
	});
	// End Form Submit

	// btn confrim otp
	$("#btn-confirmotp-jobapp").click(function () {
		if ($("#input_otp").val() == $("#gen_otp").val()) {
			var formData = new FormData($("#job-application-form")[0]);
			return formDataJobApp(formData);
		}
		errorField($("#input_otp"), 1, "Invalid OTP");
	});

	$(".use-select2").val(null).trigger("change");

	$('#question1_Yes').on('click',function(){
		$('#question1_answer').css('display','block')
	 })
	 
	 $('#question1_No').on('click',function(){
		 $('#question1_answer').css('display','none')
	  })
	 
	 $('#question2_Yes').on('click',function(){
		 $('#question2_answer').css('display','block')
	 })
	 
	 $('#question2_No').on('click',function(){
		 $('#question2_answer').css('display','none')
	 })
	 
	 $('#question3_Yes').on('click',function(){
		 $('#question3_answer').css('display','block')
	 })
	 
	 $('#question3_No').on('click',function(){
		 $('#question3_answer').css('display','none')
	 })
	 
	 $('#question4_Yes').on('click',function(){
		 $('#question4_answer').css('display','block')
	 })
	 
	 $('#question4_No').on('click',function(){
		 $('#question4_answer').css('display','none')
	 })

	$("input[data-type='currency']").on({
		keyup: function() {
			formatCurrency($(this));
		},
		blur: function() {
			formatCurrency($(this), "blur");
		}
	});

});
// end document

function formatNumber(n) {
	// format number 1000000 to 1,234,567
	return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
	// appends $ to value, validates decimal side
	// and puts cursor back in right position.

	// get input value
	var input_val = input.val();

	// don't validate empty input
	if (input_val === "") { return; }

	// original length
	var original_len = input_val.length;

	// initial caret position 
	var caret_pos = input.prop("selectionStart");

	// check for decimal
	if (input_val.indexOf(".") >= 0) {

		// get position of first decimal
		// this prevents multiple decimals from
		// being entered
		var decimal_pos = input_val.indexOf(".");

		// split number by decimal point
		var left_side = input_val.substring(0, decimal_pos);
		var right_side = input_val.substring(decimal_pos);

		// add commas to left side of number
		left_side = formatNumber(left_side);

		// validate right side
		right_side = formatNumber(right_side);

		// On blur make sure 2 numbers after decimal
		if (blur === "blur") {
			right_side += "00";
		}

		// Limit decimal to only 2 digits
		right_side = right_side.substring(0, 2);

		// join number by .
		input_val = left_side;

	} else {
		// no decimal entered
		// add commas to number
		// remove all non-digits
		input_val = formatNumber(input_val);
		input_val = input_val;

		// final formatting
		if (blur === "blur") {
			//   input_val += ".00";
		}
	}

	// send updated string to input
	input.val(input_val);

	// put caret back in the right position
	var updated_len = input_val.length;
	caret_pos = updated_len - original_len + caret_pos;
	input[0].setSelectionRange(caret_pos, caret_pos);
}

function formDataJobApp(formData = null) {
	if (formData === null) {
		alert("Something Error unable get the Form Details.");
		return false;
	}

	if ($("#mainformbody").find(".custom-alert").length > 0) {
		$(".custom-alert").remove();
	}

	if ($("#job-application-form").data("otp-exp-min") == 0) {
		return false;
	}

	var elem = $("#job-application-form").find(".cus_psgc");
	formData.append("psgc_brgy_code", elem.data("psgc_brgy_code"));
	formData.append("psgc_citymun_code", elem.data("psgc_citymun_code"));
	formData.append("psgc_prov_code", elem.data("psgc_prov_code"));
	formData.append("psgc_region_code", elem.data("psgc_region_code"));
	formData.append("psgc_zip_code", elem.data("psgc_zip_code"));
	formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));

	return $.ajax({
		url: base_url + "jobapplication/submit",
		type: "POST",
		data: formData,
		timeout: 600000,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (r) {
			console.log(r, r.redirect_url);
			if (r.status_code == 200) {
				toggleOTPModal("hide");
				$("#confirm-otp-modal").find("input").val("");
				$("#job-application-form").trigger("reset");
				$(".use-select2").val(null).trigger("change");
				$(".cus_psgc").val(null).trigger("change");
				$("#input_otp").val("");
				$("#job-application-form")
					.data("formstate", 0)
					.data("reotp", 0)
					.data("otpstate", 0)
					.data("otptries", 3);
				remErorField($("#input_otp"));
				enableBtnSignup();
				clearInterval(otpTimerSec);
				$("html, body").animate({ scrollTop: 0 }, 100);
				grecaptcha.reset();
				showAlert("alert-success", "Success:", r.message); 
				setTimeout(function() { location.href = r.redirect_url;}, 5000);
			} else if (r.status_code == 400) {
				toggleOTPModal("hide");             
				showAlert("alert-warning", "Warning:", r.message);
				setTimeout(function(){
					$(".custom-alert").alert('close');
				},1500)
			} else {
				toggleOTPModal("hide");                      
				showAlert("alert-danger", "ERROR:", r.message);
				setTimeout(function(){
					$(".custom-alert").alert('close');
				},1500);
			}
		},
		error: function (xhr, textStatus, thrownErr) {
			showAlert(
				"alert-danger",
				"ERROR",
				"Error description: <br>" +
					xhr.responseText +
					"<br>" +
					textStatus +
					"<br>" +
					thrownErr
			);
			setTimeout(function(){
				$(".custom-alert").alert('close');
			},1500);
			toggleOTPModal("hide");
			$("html, body").animate({ scrollTop: 0 }, 100);
		},
	});

	
}

