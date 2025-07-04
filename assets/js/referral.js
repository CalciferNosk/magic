$(".number").on('input', function () {
  var number = $(this).val().replace(/[^\d]/g, '')
  if (number.length == 11) {
    number = number.replace(/(\d{4})(\d{5})/, "$1-$2");
  }
  $(this).val(number);
});

$(document).ready(function () {
  $(".testregion").select2({
    "placeholder": "Please select Region, Province, Municipality, Barangay",

    maximumSelectionLength: 1,
    minimumInputLength: 3,
    allowclear: true,
    multiple: true,
    ajax: {
      url: "inquiry/find_psgc",
      type: "post",
      dataType: 'json',
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
  $(".branch").select2({
    maximumSelectionLength: 1,
    "placeholder": "Type at least 3 characters",
    "matcher": matchCustom
  });
});

function matchCustom(params, data) {
  // If there are no search terms, return all of the data
  if ($.trim(params.term) === '' || (params.term).length < 3) {
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
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
if (dd < 10) {
  dd = '0' + dd
}
if (mm < 10) {
  mm = '0' + mm
}

todayy = yyyy + '-' + mm + '-' + (dd - 1);
today = yyyy + '-' + mm + '-' + dd;

document.getElementById("date_purchase").setAttribute("min", today);

$('.daylight').click(function () {
  if (count >= 3) {
    location.reload(true);
  }
});

$('.ajax-loader').addClass('d-none').removeClass("d-flex");

$(document).ajaxStart(function () {
  $('.ajax-loader').removeClass('d-none').addClass("d-flex");
})
  .ajaxComplete(function () {
    $('.ajax-loader').addClass('d-none').removeClass("d-flex");
  });

// link inside #main_menu or #second_menu
function myfunc() {


  sessionStorage.setItem("brand", $("#brand").val());
  sessionStorage.setItem("model", $("#model").val());
  sessionStorage.setItem("color", $("#color").val());
  sessionStorage.setItem("customer_fname", $("#customer_fname").val());
  sessionStorage.setItem("customer_mname", $("#customer_mname").val());
  sessionStorage.setItem("customer_lname", $("#customer_lname").val());
  sessionStorage.setItem("region", $("#region").val());
  sessionStorage.setItem("province", $("#province").val());
  sessionStorage.setItem("city", $("#city").val());
  sessionStorage.setItem("barangay", $("#barangay").val());
  sessionStorage.setItem("address", $("#address").val());
  sessionStorage.setItem("email", $("#email").val());
  sessionStorage.setItem("contact_no", $("#contact_no").val());
  window.location = 'loan?cluster=' + $('#clusterparam').val() + '&source=' + $('#sourceparam').val();

}

$('#exampleModal').on('hidden.bs.modal', function () {
  if (count >= 3) {
    location.reload(true);
  }
  grecaptcha.reset();
  $("#myChecked").prop("checked", false);
  //$("#text").css("display", "none");
  $('#text').prop("disabled", true);
});


$('#exampleModal').on('shown.bs.modal', function () {
  setInterval(function () {
    $('#exampleModal').modal('hide');
  }, 300000);
  // do something...
});

function onlyNumberKey(evt) {

  // Only ASCII charactar in that range allowed
  var ASCIICode = (evt.which) ? evt.which : evt.keyCode
  if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
    return false;
  return true;
}

function recaptchaCallback() {
  //datacheckbox();
  var checkBox = document.getElementById("myChecked");
  // Get the output text
  var text = document.getElementById("text");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true) {
    //  alert('test');
    //$('#text').prop("disabled", false);
  } else {
    // alert('earae');
    // $('#text').prop("disabled", true);
  };
}



function brand(item, index) {
  var modeldesc;
  if (item.parentid == $("#brand").val()) {
    if (item['referencedesc'] != null) {
      modeldesc = " (" + item['referencedesc'] + ")";
    }
    else {
      modeldesc = '';
    }
    $("#model").append("<option value='" + item['grid'] + "*" + item['TypeId'] + "'>" + item['referencename'] + modeldesc + " </option>");
  }
}

function region(item, index) {

  if (item.regCode == $("#region").val()) {
    $("#province").append("<option value='" + item['provCode'] + "'>" + item['provDesc'] + " </option>");
  }
}

function provincea(item, index) {

  if (item.provCode == $("#province").val()) {
    // alert(item['cityDesc']);
    $("#city").append("<option value='" + item['citymunCode'] + "'>" + item['citymunDesc'] + " </option>");
  }
}

function citya(item, index) {
  if (item.citymunCode == $("#city").val()) {
    $("#barangay").append("<option value='" + item['brgyCode'] + "'>" + item['brgyDesc'] + " </option>");
  }
}



//alert($("#sourceparam").val());
var otpsend = 0;
var count = 0,
  getOTP;
var subcount = 0;

$('.get-random').click(function () {

});

var error = 0;
$('#submitModal').click(function () {
  if ($('#hiddenOTP').val() == $('#otp-input').val()) {

    $("#modalfin").html('');
    $('button').prop('disabled', true);
    $('submit').prop('disabled', true);
  }
  else {
    alert('You\'ve entered incorrect OTP code.');
    error += 1;
    if (error >= 3) {
      $('#submitModal').prop('disabled', true);
      location.reload(true);
    }
  }
});
/*$('.otp-input').keyup(function(){
  var input = $('.otp-input').val();
  if (getOTP == input) {
    $('.otp-input').prop('readonly', true);
    alert('Mobile Number successfully validated.');
   // $('body').css('background', 'green');
  } else {
  //  $('body').css('background', 'red');
  }
  setTimeout(function() {
    $('body').css('background', '#fff');
  }, 3000);
});*/

$(function () {
  $('#contact_no').keydown(function (e) {
    //alert('test');
    var value = $("#contact_no").val();
    if (value.length == 12 && $("#region").val() != '' && $("#city").val() != '' && $("#province").val() != '' && $("#barangay").val() != '' && $("#customer_fname").val() != '' && $("#customer_mname").val() != '' && $("#customer_lname").val() != '' && $("#email").val() != '' && $("#inquiry option:selected").val() != 0) {
      //alert('test');
      $('.get-random').prop('disabled', false);
    }
    else {
      $('.get-random').prop('disabled', true);
    }
    var key = e.charCode || e.keyCode || 0;
    $text = $(this);
    if (key !== 8 && key !== 9) {
      if ($text.val().length === 4) {
        $text.val($text.val() + '-');
      }

    }


  });
});
$('.js-example-basic-multiple-another').select2({
  maximumSelectionLength: 1
});
$('.js-example-basic-multiple').select2({
  maximumSelectionLength: 1
});
$("#source").change(function () {
  var source = document.getElementById("hays");
  //alert($('#source').val());
  if ($('#source').val() == 'OTHERS') {
    //  alert('test');

    source.style.display = "block";
  } else {
    // alert('earae');
    source.style.display = "none";
  }
});
$("#area").change(function () {
  $("#area option[value='']").remove();
  var reg_code = $("#area option:selected").attr('data-id');
  $("#branch").empty();

  var branchCode = $(this).data('id');


  $.ajax({
    type: "POST",
    url: "Inquiry/getBranch",
    data: {
      reg_code: reg_code,
      _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
    },

    beforeSend: function () {
      $("#branch").prop("disabled", true);
      $("#branch").append("<option value='test'>Loading...</option>");
      $('#branch').val('test');
    }
  }).done(function (data) {
    $("#branch").empty();
    $("#branch").prop("disabled", false);
    data = $.parseJSON(data);
    var list = new Array();
    var obj = {}
    $.each(data, function (i, item) {
      list.push(item);
      obj[i] = item;
    });
    $('#branch').val();
    $("#branch").append("<option value='' id='defchoose'>Choose</option>");
    $.each(obj, function (i, item) {
      $("#branch").append("<option value='" + item['branchdesc'] + "' data-id='" + item['branchcode'] + "'>" + item['branchdesc'] + " </option>");
    });
  });
});


$("#brand").change(function () {
  // alert('test');
  $("#model").empty();
  $("#model").append("<option value='' id='defchoose'>Choose</option>");
  objm.forEach(brand);

});

$("#region").change(function () {
  $("#region option[value='']").remove();
  $("#province").empty();
  $("#city").empty();
  $("#barangay").empty();
  $("#province").append("<option value='' id='defchoose'>Choose</option>");
  objp.forEach(region);

});

$("#province").change(function () {
  $("#province option[value='']").remove();
  $("#city").empty();
  $("#barangay").empty();
  $("#city").append("<option value='' id='defchoose'>Choose</option>");
  objc.forEach(provincea);

});

$("#city").change(function () {
  $("#city option[value='']").remove();
  $("#barangay").empty();
  $("#barangay").append("<option value='' id='defchoose'>Choose</option>");
  objb.forEach(citya);

});

function isCaptchaChecked() {
  return grecaptcha && grecaptcha.getResponse().length !== 0;
}

function myFunctions() {
  if (isCaptchaChecked()) {
    $('#text').prop("disabled", false);
  }
}

var invalidtry = 0;

function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
var totalresend = 0;
var tries;
function reSend() {
  var value = $("#contact_no").val();
  totalresend += 1;
  if (totalresend = 3) {
    otpsend = otpsend + 1;
    if (otpsend == 2) {
      $('.get-random').prop('disabled', true);
    }
    if (value.length < 12) {
      alert('Please make sure you put a valid mobile number. Kindly recheck it.');
    }
    else {
      if (count >= 4) {
        location.reload(true);
      }
      else {

        $('.otpdisplay').css('display', 'block');
        $(".get-random").html("Resend OTP");
        min = Math.ceil(1111);
        max = Math.floor(9999);
        getOTP = Math.floor(Math.random() * (max - min)) + min;
        $('.custom-random').text(getOTP);
        count = count + 1;
        if (count == 2) {
          tries = 'try';
        }
        else {
          tries = 'tries';
        }
        if (count >= 3) {
          $("#resending").html("Resend OTP (" + (3 - count) + " " + tries + " left)");
        }
        else {
          $("#resending").html("<a href=\"#\" onclick=\"reSend()\" data-dismiss=\"modal\">Resend OTP (" + (3 - count) + " " + tries + " left)</a>");
        }

        $.ajax({
          type: "POST",
          url: "Inquiry/sms_sending",
          data: {
            getOTP: getOTP,
            value: value,
            _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
          },

          beforeSend: function () {
            $('input').attr('disabled', true);
            $('select').attr('disabled', true);
          }
        }).done(function (data) {
          $('input').removeAttr('disabled');
          $('select').removeAttr('disabled');
          $("#hiddenOTP").val(getOTP);
          $("#triesleft").html(3 - count);
          $('#exampleModal').modal({
            backdrop: 'static',
            keyboard: false
          });

        });
      }
    }
  }
  else {
    //  location.reload();
  }
}
function isCaptchaChecked() {
  return grecaptcha && grecaptcha.getResponse().length !== 0;
}

function myFunction() {
  //  alert('tess');
  // var otpinput = $("#otp-input").val();
  var value = $("#contact_no").val();
  //alert($("#branch").val());
  /* if($('#myChecked').prop("checked") == false){
               alert('Please check the Privacy Statement to proceed.');
               return false;
           } */

  if (isCaptchaChecked()) {
    //alert('test');
  }
  else {
    alert('Please validate Captcha to see if you\'re not a robot');
    return false;
  }
  if (value.length < 12 || value.substring(0, 2) != '09') {
    alert('Please make sure you put a valid mobile number. Kindly recheck it.');
  }
  else if ($("#date_purchase").val() == '') {
    alert('Please fill out Plan Date of Purchase');
  }
  else if ($("#customer_fname").val() == '') {
    alert('Please fill out Customer First Name');
  }
  /*      else if($("#customer_mname").val() == ''){
        alert('Please fill out Customer Middle Name');
    }*/
  else if ($("#customer_lname").val() == '') {
    alert('Please fill out Customer Last Name');
  }
  else if ($("#psgc").val() == null || $("#psgc").val() == '0' || $("#psgc").val() == '') {
    alert('Please fill out Region, Province, City and Barangay.');
  }
  else if ($("#referral_name").val() == null || $("#referral_name").val() == '0' || $("#referral_name").val() == '') {
    alert('Please fill out Referral Name');
  }
  else if ($("#source").val() == null || $("#source").val() == '0' || $("#source").val() == '') {
    alert('Please fill out Source');
  }
  else if ($("#branch").val() == null || $("#branch").val() == '0' || $("#branch").val() == '') {
    alert('Please fill out Branch');
  }
  else if ($("#inquiry option:selected").val() == 0) {
    alert('Please choose a category for Inquiry');
  }
  else if (!validateEmail($("#email").val()) && $("#email").val() != '') {
    alert('You\'ve entered invalid email.');
  }
  else {
    //
    var value = $("#contact_no").val();
    //  alert(value); 
    if (confirm('Please confirm to submit.')) {
      //         alert('Form sent. Thank you for choosing Motortrade Group.');
      document.getElementById("myCheck").click();
    }

  }
  //
}

function submit() {
  alert('Inquiry successfully sent!');
}


function validate(form) {

  // validation code here ...


  if (!valid) {
    alert('Please correct the errors in the form!');
    return false;
  }
  else {
    return
  }
}
