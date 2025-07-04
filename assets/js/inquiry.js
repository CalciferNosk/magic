
$(document).ready(function(){
  $('#inquiry-form').on("submit", function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    // console.log(formData)
    formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
    $.ajax({
      url: "Inquiry/submit",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(r) {
        if (r.response == 'true') {
          alert("Form Sent. Your Record Id is "+ r.id +". Thank you for choosing Motortrade Group.");
          $('#inquiry-form')[0].reset();
          location.reload(true);
          return;
        } else {
          alert('System error: Record not saved to database. Please re-submit the form. Thank you.');
        }
        return false;
      },
      error: function(xhr, textStatus, thrwError) {
        return alert('System error: Record not saved to database. Please re-submit the form. Thank you.');
      }
    });
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

// Updated by Arwin 01/14 
// Update new loan link from inquiry page
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
  window.location = 'loan?cls=' + $('#clusterparam').val() + '&src=' + $('#sourceparam').val();

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
$(".number").on('input', function () {
  //alert('test');
  var number = $(this).val().replace(/[^\d]/g, '')
  if (number.length == 11) {
    number = number.replace(/(\d{4})(\d{5})/, "$1-$2");
  }
  $(this).val(number);
});

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
    $("#model").append("<option value='" + item['grid'] + "*" + item['TypeId'] + "'>" + item['referencename'].toUpperCase() + modeldesc.toUpperCase() + " </option>");
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

// Updated by Arwin 01/14 
// Update new loan link from inquiry page
test = $("#sourceparam").val(getUrlParameter('src'));
$("#clusterparam").val(getUrlParameter('cls'));
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
    document.getElementById("myCheck").click();
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

$("#inquiry").change(function () {
  var sourced = document.getElementsByClassName("mc");
  //alert($('#source').val());
  if ($('#inquiry').val() == '167') {
    //  alert('test');
    $(".mc").css("display", "none");
  } else {
    // alert('earae');
    $(".mc").css("display", "block");
  }
});

$("#area").change(function () {
  // alert();
  // alert('test');
  $("#area option[value='']").remove();
  // $('#generateBranch').removeAttr('disabled');
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
      // do your stuff here
      //alert(JSON.stringify(data));
      $("#branch").prop("disabled", true);
      $("#branch").append("<option value='test'>Loading...</option>");
      $('#branch').val('test');

    }
  }).done(function (data) {
    // alert(data);
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
    //$('#branch').select2().trigger('change');

    //<option value = "" disabled selected >Choose</option>
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
  // $('#exampleModal').modal('toggle');
  var value = $("#contact_no").val();
  totalresend += 1;
  if (totalresend = 3) {
    otpsend = otpsend + 1;
    //alert(otpsend);
    if (otpsend == 2) {
      $('.get-random').prop('disabled', true);
    }
    if (value.length < 12) {
      alert('Please make sure you put a valid mobile number. Kindly recheck it.');
    }
    else {
      //  alert(count);

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
  var first_name = $("#customer_fname").val();
  var last_name = $("#customer_lname").val();
  var mobile_no = $("#contact_no").val();
  var model = $("#model").val();
  var table = 'tblforminquiry';
  var count = 0;
  $.ajax({
    type: "POST",
    url: "Inquiry/verify_exist",
    data: {
      first_name: first_name,
      last_name: last_name,
      mobile_no: mobile_no,
      model: model,
      table: table,
      _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
    },
    beforeSend: function () {
    }
  }).done(function (data) {
    if (data == 'true') {
      alert('There is an existing record based on the information given.');
      return false;
    }

    var otpinput = $("#otp-input").val();
    var value = $("#contact_no").val();

    if ($('#myChecked').prop("checked") == false) {
      alert('Please check the Privacy Statement to proceed.');
      return false;
    }

    if (isCaptchaChecked()) {
      //alert('test');
    }
    else {
      alert('Please validate Captcha to see if you\'re not a robot');
      return false;
    }
    var category = $('#inquiry').val();
    if ($.inArray(parseInt(category), [151,152]) > -1 && $('#branch').val() == '') {
      alert("Please fill out Preferred Branch");
      return false;
    }
    if (value.length < 12 || value.substring(0, 2) != '09') {
      alert('Please make sure you put a valid mobile number. Kindly recheck it.');
    }
    else if ($("#date_purchase").val() == '' && $("#inquiry").val() != '167') {
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
    
    else if ($("#inquiry option:selected").val() == 0) {
      alert('Please choose a category for Inquiry');
    }
    
    else if ($("#email").val() != '' && !validateEmail($("#email").val())) { //edited by Arwin 31/05
      alert('You\'ve entered invalid email.');
    }
    
    else {
      var value = $("#contact_no").val();
      //  alert(value);
      if (confirm('Motortrade will now send OTP to ' + value + ' to continue. Proceed?')) {
        otpsend = otpsend + 1;
        //alert(otpsend);
        if (otpsend == 2) {
          $('.get-random').prop('disabled', true);
        }
        if (value.length < 12) {
          alert('Please make sure you put a valid mobile number. Kindly recheck it.');
        }
        else {
          $('.otpdisplay').css('display', 'block');
          $(".get-random").html("Resend OTP");
          min = Math.ceil(1111);
          max = Math.floor(9999);
          getOTP = Math.floor(Math.random() * (max - min)) + min;
          $('.custom-random').text(getOTP);
          count = count + 1;
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
            $('#exampleModal').modal({
              backdrop: 'static',
              keyboard: false
            });

          });
        }
      }
    }
  });
  //
}

function submit() {
  alert('Inquiry successfully sent!');
}


// function validate(form) {

//   // validation code here ...


//   if (!valid) {
//     alert('Please correct the errors in the form!');
//     return false;
//   }
//   else {
//     return
//   }
// }

$("input[data-type='currency']").on({
  keyup: function () {
    formatCurrency($(this));
  },
  blur: function () {
    formatCurrency($(this), "blur");
  }
});


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
    input_val = left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = input_val;

    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }

  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}
$('#inquiry').on('change',function(){

  if($('#inquiry').val() == 149 || $('#inquiry').val() == 150 || $('#inquiry').val() == 151 || $('#inquiry').val() == 152 ){
  
    $('.Mc-purchase-type').css('display','block');
    $("#first_time_customer").css("display","block");
    // document.getElementById('choose1').setAttribute('required', '');
    document.getElementById('choose2').setAttribute('required', '');
    document.getElementById('choose3').setAttribute('required', '');
    document.getElementById('choose4').setAttribute('required', '');
    $('#choose3').prop("checked", true);
   
  }
  else {
    $('.Mc-purchase-type').css('display','none');
    $("#first_time_customer").css("display","none");
    // document.getElementById('choose1').removeAttribute('required', '');
    document.getElementById('choose2').removeAttribute('required', '');
    document.getElementById('choose3').removeAttribute('required', '');
    document.getElementById('choose4').removeAttribute('required', '');
  };
  // $('#text').on('click' , function(){
  //     if($('#choose1') == '' || $('#choos2') == '' ||  $('#choose3') == '' || $('#choose4') == ''){
  //         alert('pls choose')
  //     }
  
  // })
  
  })

