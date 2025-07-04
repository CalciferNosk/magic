/**
 * Created by Russel
 * 2022-03-11
 */
$(document).ready(function () {
  $('#color').val(null).trigger('change');
  $('#category').val(null).trigger('change');
  // PSGC
  $('.cus_psgc').select2({
    placeholder: "Enter Municipality, Barangay (ex. Camarines Sur, Bato, Agos)",
    minimumInputLength: 5,
    maximumSelectionLength: 1,
    allowclear: true,
    multiple: true,
    ajax: {
      url: `${base_url}big-bike/psgc`,
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
          results: response
        };
      }
    }
  });

  $(document).on('change', '.cus_psgc', function () {
    var d = $(this).select2('data')[0];

    // return false if this value is empty
    if ($(this).val() == null || $(this).val() == "") {
      $(this)
        .data('psgc_brgy_code', 0)
        .data('psgc_citymun_code', 0)
        .data('psgc_prov_code', 0)
        .data('psgc_region_code', 0)
        .data('psgc_zip_code', 0);
      return false;
    }

    $(this)
      .data('psgc_brgy_code', d.psgc_brgy_code)
      .data('psgc_citymun_code', d.psgc_citymun_code)
      .data('psgc_prov_code', d.psgc_prov_code)
      .data('psgc_region_code', d.psgc_region_code)
      .data('psgc_zip_code', d.psgc_zip_code);
  });

  // Form Submit
  var bigbikeForm = $("#bigbike-reservation-form");
  bigbikeForm.on("submit", function (e) {
    if ($("#mainformbody").find('.custom-alert').length > 0) {
      $(".custom-alert").remove();
    }

    var f = $(this).find(".required-field");
    var vl = true;
    var formData = new FormData(this);
    var valuen = $("#mobile_no").val();

    if ($(this).data('formstate') == 0) {
      alert("Please Check The I'm not a robot!");
      return false;
    }

    if (valuen.length < 12 || valuen.substring(0, 2) != '09') {
      alert('Please make sure you put a valid mobile number. Kindly recheck it.');
      return false;
    }

    $.each(f, function (i, d) {
      var p = $(this).parents('.form-group');
      if (($(this).val() == "" || $(this) == null || $(this).val() == undefined || $(this).val() == '- Select -') && !$(this).is("label")) {
        vl = false;
        errorField(this);
        // return false;
      }
      else {
        p.find('label').removeClass('text-danger');
        p.find('input, select, radio, .select2').removeClass('is-invalid');
      }
    });

    if (!vl) {
      showAlert("alert-danger", "ERROR!");
      return false;
    }

    e.preventDefault();

    if (bigbikeForm.data("otpstate") == 1) {
      return toggleOTPModal();
    }

    if (($("#gen_otp").val() == "0" && $("#input_otp").val() == "") || bigbikeForm.data("formstate") == 1) {
      return sendOTP($("#mobile_no").val(), $(this).data('otpstate'), $("#bigbike-reservation-form"));
    }

  });
  // End Form Submit

  // btn confrim otp
  $("#btn-confirmotp-bigbike").click(function () {
    if ($('#input_otp').val() == $('#gen_otp').val()) {
      var formData = new FormData($("#bigbike-reservation-form")[0]);
      return formDataBigbike(formData);
    }
    errorField($("#input_otp"), 1, "Invalid OTP");
  });

  $(".use-select2").val(null).trigger("change");

  $(document).on("change", "#bigbike", function() {

    $("#brand_id").val($(this).find("option:selected").data("brandid"));
  });
});
// end document

function formDataBigbike(formData = null) {
  if (formData === null) {
    alert("Something Error unable get the Form Details.");
    return false;
  }

  if ($("#mainformbody").find('.custom-alert').length > 0) {
    $(".custom-alert").remove();
  }

  if ($("#bigbike-reservation-form").data("otp-exp-min") == 0) {
    return false;
  }

  var elem = $("#bigbike-reservation-form").find('.cus_psgc');
  formData.append('psgc_brgy_code', elem.data('psgc_brgy_code'));
  formData.append('psgc_citymun_code', elem.data('psgc_citymun_code'));
  formData.append('psgc_prov_code', elem.data('psgc_prov_code'));
  formData.append('psgc_region_code', elem.data('psgc_region_code'));
  formData.append('psgc_zip_code', elem.data('psgc_zip_code'));
  formData.append('_cmcToken', $(`meta[name="_cmcToken"]`).attr("content"));

  return $.ajax({
    url: `${base_url}big-bike/store`,
    type: 'POST',
    data: formData,
    timeout: 600000,
    contentType: false,
    processData: false,
    success: function (r) {
      var str = r.replace(/\s/g, '');
      if (str == '1' || str == 1) {
        alert("Form sent. Thank you for choosing Motortrade Group.");
        toggleOTPModal('hide');
        $("#confirm-otp-modal").find('input').val('');
        $("#bigbike-reservation-form").trigger("reset");
        $(".use-select2").val(null).trigger("change");
        $(".cus_psgc").val(null).trigger("change");
        $("#input_otp").val('');
        $("#bigbike-reservation-form").data("formstate", 0).data("reotp", 0).data("otpstate", 0).data("otptries", 3);
        remErorField($("#input_otp"));
        enableBtnSignup();
        clearInterval(otpTimerSec);
        $("html, body").animate({ scrollTop: 0 }, 100);
        return grecaptcha.reset();
      }
      toggleOTPModal('hide');
      return showAlert('alert-danger', "ERROR:", r);
    },
    error: function (xhr, textStatus, thrownErr) {
      showAlert('alert-danger', 'ERROR', "Error description: <br>" + xhr.responseText + "<br>" + textStatus + "<br>" + thrownErr);
      toggleOTPModal('hide');
      $("html, body").animate({ scrollTop: 0 }, 100);
    }
  });
}
