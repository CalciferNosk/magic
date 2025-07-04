window.onload = () => {
 const myInput = document.getElementById('contact_no');
 myInput.onpaste = e => e.preventDefault();
}

  $(".number").on('input', function() {
    //alert('test');
    var number = $(this).val().replace(/[^\d]/g, '')
    if (number.length == 11) {
      number = number.replace(/(\d{4})(\d{5})/, "$1-$2");
    }
    $(this).val(number);
  });
 $(document).ready( function ()
 {
    $(".branch").select2({
        "placeholder" : "Type City or Address to identify branch",
        "matcher" : matchCustom
    });
  });

    function matchCustom(params, data)
{
    // If there are no search terms, return all of the data
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

$('.daylight').click(function(){
if(count >= 3){
location.reload(true);
}
});

    $('.ajax-loader').addClass('d-none').removeClass("d-flex");

        $(document).ajaxStart(function()
    {
        $('.ajax-loader').removeClass('d-none').addClass("d-flex");
    })
    .ajaxComplete(function () {
        $('.ajax-loader').addClass('d-none').removeClass("d-flex");
    });

  $('#exampleModal').on('hidden.bs.modal', function () {
grecaptcha.reset();
$("#myChecked").prop("checked", false);
//$("#text").css("display", "none");
$('#text').prop("disabled", true);
});

  $('#exampleModal').on('shown.bs.modal', function () {
    setInterval(function(){
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

function area(item, index) {
  //  if(item.parentid == $("#brand").val()){
   // alert('test');
    var region_id = $("#region option:selected").attr('data-id');
   // alert(area_id);
   //alert(region_id);
   if(region_id == item['parent_org_id']){
      var clusterer_id = region_id;
     // alert(cluster_id);
        //obja.forEach(function (item, index) {
    anotherone(clusterer_id, item, index);
//});
   }



  //  }
}

function branch(item, index) {
  //  if(item.parentid == $("#brand").val()){
    var area_id = $("#area option:selected").attr('data-id');
   // alert(area_id);
  // alert(item['parent_org_id']);
   if(area_id == item['parent_org_id']){
   // alert('test');
      var cluster_id = area_id;
  //      objb.forEach(function (item, index) {
    another(cluster_id, item, index);
//});
   }



  //  }
}

var error = 0;
$('#submitModal').click(function(){
if($('#hiddenOTP').val() == $('#otp-input').val()){
    //      alert('Form sent. Thank you for choosing Motortrade Group.');
       document.getElementById("myCheck").click();
                 $("#modalfin").html('');
          $('button').prop('disabled', true);
           $('submit').prop('disabled', true);
}
else{
  alert('You\'ve entered incorrect OTP code.');
  error += 1;
  if(error >= 3){
    $('#submitModal').prop('disabled', true);
    location.reload(true);
  }
}
});
var test;
function another(cluster_id, item, index) {
  //  if(item.parentid == $("#brand").val()){
  // alert(item['id']);


      if(cluster_id == item['parent_org_id']){
        //alert(item['id']);
        var clusterrr_id = item['id'];
           objcl.forEach(another.bind(null, clusterrr_id)
  //          function (item, index) {
   // anothertwo(item['id'], item, index);
   // alert(clusterrr_id);
     //if(clusterrr_id == item['parent_org_id']){
     // var clusterer_id = region_id;
     // alert(cluster_id);
        //obja.forEach(function (item, index) {
   // anothertwo(clustererrr_id, item, index);
//});
//   }
//}
);
        test = "(" + item['address'] + ")";
        if(item['address'] == null){
          test = '';
        }
      if(item['org_type'] == 'BRN'){
      $("#branch").append("<option value='"+ item['code'] +"'>" + item['code'] + " "+ item['description'] + " "+ test +"</option>");
    }
   }



  //  }
}

function anothertwo(clusterr_id, item, index){
alert(clusterr_id);
//  if(clusterr_id == item['parent_org_id']){
    //  alert(item['description']);
// $("#branch").append("<option value='"+ item['code'] +"'>" + item['code'] + " "+ item['description'] + " "+ test +"</option>");
//}
}

function anotherone(clusterer_id, item, index) {
  //  if(item.parentid == $("#brand").val()){
  // alert(clusterer_id + " "+ item['parent_org_id']);
      if(clusterer_id == item['parent_org_id']){
       // alert('test');
      $("#area").append("<option value='"+ item['code'] +"' data-id='"+ item['id'] +"'>" + item['description'] + "</option>");
   }



  //  }
}

function recaptchaCallback() {
    //datacheckbox();
var checkBox = document.getElementById("myChecked");
  // Get the output text
  var text = document.getElementById("text");

  // If the checkbox is checked, display the output text
 /* if (checkBox.checked == true){
  //  alert('test');
    $('#text').prop("disabled", false);
  } else {
   // alert('earae');
    $('#text').prop("disabled", true); 
}; */
}

function isCaptchaChecked() {
  return grecaptcha && grecaptcha.getResponse().length !== 0;
}

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

$("#sourceparam").val(getUrlParameter('source'));
var otpsend = 0;
var count = 0,
  getOTP;

$('.get-random').click(function() {
  var value = $("#contact_no").val();
//  alert(value);
if(confirm('Motortrade will now send OTP to ' + value +'. Continue?')){
  otpsend = otpsend + 1;
  //alert(otpsend);
    if(otpsend == 2){
  $('.get-random').prop('disabled', true);
}
     if(value.length < 12){
        alert('Please make sure you put a valid mobile number. Kindly recheck it.');
    }
    else{
  $('.otpdisplay').css('display','block');
  $(".get-random").html("Resend OTP");
  min = Math.ceil(1111);
  max = Math.floor(9999);
  getOTP = Math.floor(Math.random() * (max - min)) + min;
  $('.custom-random').text(getOTP);
  count = count + 1;
  //$('.save-random').text(count);
 // alert(getOTP);
  //$('.save-random').append('<b>' + count + " : " + get + '</b>');
        $.ajax({
          type: "POST",
          url: "Customercare/sms_sending",
          data: { getOTP:  getOTP, value:value},

    beforeSend : function(){
    }
    }).done(function(data){
     // alert(data);
     alert('OTP has been sent. Please enter the code in the box provided or click the Resend button to resend (up to 3 times only).');

});
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

$( "#region" ).change(function() {
$("#region option[value='0']").remove();
// $('#generateBranch').removeAttr('disabled');

//alert(area_id);
$("#area").empty();
      $("#branch").empty();
obja.forEach(area);
});

$( "#area" ).change(function() {
$("#area option[value='0']").remove();
// $('#generateBranch').removeAttr('disabled');

//alert(area_id);
      $("#branch").empty();
objb.forEach(branch);
});

$( "#brand" ).change(function() {
   // alert();
$("#brand option[value='0']").remove();
// $('#generateBranch').removeAttr('disabled');
var reg_code = $("#brand option:selected").attr('data-id');
      $("#model").empty();
//alert(reg_code);
      var branchCode = $(this).data('id');


      $.ajax({
          type: "POST",
          url: "Customercare/getModel",
          data: { reg_code:  reg_code},

    beforeSend : function(){

        // do your stuff here
        //alert(JSON.stringify(data));
    $("#model").prop("disabled", true);
    $("#model").append("<option value='test'>Loading...</option>");
    $('#model').val('test');
 /*       $("#city").prop("disabled", true);
    $("#city").append("<option value='test'>Loading...</option>");
    $('#city').val('test');
        $("#barangay").prop("disabled", true);
    $("#barangay").append("<option value='test'>Loading...</option>");
    $('#barangay').val('test'); */
   // $('#branch').select2().trigger('change');

    }
    }).done(function(data){
     // alert(data);
       $("#model").empty();
       $("#model").prop("disabled", false);
            data = $.parseJSON(data);
            var list = new Array();
            var obj = {}
            $.each(data, function(i, item) {
              list.push(item);
              obj[i] = item;
            });
            $('#model').val();
            //$('#branch').select2().trigger('change');

            //<option value = "" disabled selected >Choose</option>
            $("#model").append("<option value='0' id='defchoose'>Choose</option>");
            $.each(obj, function(i, item) {
              $("#model").append("<option value='"+ item['id'] +"' data-id='"+ item['id'] +"'>" + item['ModelName'] + " </option>");
            });
});
});

    $("#mobile_number").attr({
   "min" : 7
});


var totalresend = 0;
function reSend(){
 // $('#exampleModal').modal('toggle');
  var value = $("#contact_no").val();
totalresend += 1;
if(totalresend = 3){
  otpsend = otpsend + 1;
  //alert(otpsend);
    if(otpsend == 2){
  $('.get-random').prop('disabled', true);
}
     if(value.length < 12){
        alert('Please make sure you put a valid mobile number. Kindly recheck it.');
    }
    else{
    //  alert(count);

  if(count >= 4){
    location.reload(true);
  }
 else{
 
  $('.otpdisplay').css('display','block');
  $(".get-random").html("Resend OTP");
  min = Math.ceil(1111);
  max = Math.floor(9999);
  getOTP = Math.floor(Math.random() * (max - min)) + min;
  $('.custom-random').text(getOTP);
 count = count + 1;
  if(count == 2){
    tries = 'try';
  }
  else{
    tries = 'tries';
  }
  if(count >= 3){
    $("#resending").html("Resend OTP ("+ (3 - count) +" "+ tries+" left)");
  }
  else{
     $("#resending").html("<a href=\"#\" onclick=\"reSend()\" data-dismiss=\"modal\">Resend OTP ("+ (3 - count) +" "+ tries+" left)</a>");
  }
  //$('.save-random').text(count);
  //alert(getOTP);

  //$('.save-random').append('<b>' + count + " : " + get + '</b>');
        $.ajax({
          type: "POST",
          url: "Customercare/sms_sending",
          data: { getOTP:  getOTP, value:value},

    beforeSend : function(){
      $('input').attr('disabled', true);
      $('select').attr('disabled', true);
      $('textarea').attr('disabled', true);
      $('button').attr('disabled', true);
    }
    }).done(function(data){
       $('input').removeAttr('disabled');
       $('select').removeAttr('disabled');
       $('textarea').removeAttr('disabled');
       $('button').removeAttr('disabled');
     // alert(data);
   //  alert('OTP has been sent to '+ value +' Please enter the code in the box provided or click the Resend button to resend (up to 2 times only).');
      $("#hiddenOTP").val(getOTP);
      $("#triesleft").html(3-count);
     $('#exampleModal').modal({
                    backdrop: 'static',
              keyboard: false
          });

});
  }
  }
}
else{
//  location.reload();
}
}

function isCaptchaChecked() {
  return grecaptcha && grecaptcha.getResponse().length !== 0;
}

    function myFunctions() {
      if (isCaptchaChecked()) {
  $('#text').prop("disabled", false);
}
     // alert(recaptchaCallback());
  //  alert('r');
  // Get the checkbox
 /* var checkBox = document.getElementById("myChecked");
  // Get the output text
  var text = document.getElementById("text");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
  //  alert('test');
    text.style.display = "block";
  } else {
   // alert('earae');
    text.style.display = "none";
  } */
}

var invalidtry = 0;
function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
function myFunction(){
  //  alert('tess');
  var otpinput = $("#otp-input").val();
  var value = $("#contact_no").val();
    if($('#myChecked').prop("checked") == false){
                alert('Please check the Privacy Statement to proceed.');
                return false;
            }

if (isCaptchaChecked()) {
//alert('test');
}
else{
  alert('Please validate Captcha to see if you\'re not a robot');
  return false;
}

   if(value.length < 12 || value.substring(0, 2) != '09'){
        alert('Please make sure you put a valid mobile number. Kindly recheck it.');
    }
        else if($("#first_name").val() == ''){
        alert('Please fill out First Name');
    }
     /*   else if($("#middle_name").val() == ''){
        alert('Please fill out Middle Name');
    } */
        else if($("#last_name").val() == ''){
        alert('Please fill out Last Name');
    }
   /*      else if($("#area").val() == null || $("#area").val() == '0' || $("#area").val() == ''){
        alert('Please fill out Area');
    }
        else if($("#branch").val() == null || $("#branch").val() == '0' || $("#branch").val() == ''){
        alert('Please fill out Branch');
    }
        else if($("#brand").val() == null || $("#brand").val() == '0' || $("#brand").val() == ''){
        alert('Please fill out Brand');
    }
        else if($("#model").val() == null || $("#model").val() == '0' || $("#model").val() == ''){
        alert('Please fill out Model');
    }
                else if($("#color").val() == null || $("#color").val() == '0' || $("#color").val() == ''){
        alert('Please fill out Color');
    }*/
    else if($("#cat option:selected").val() == 0){
        alert('Please choose a category for Complaint');
    }
            else if($("#details").val() == ''){
        alert('Please fill out Complaint Details');
    }
 /*               else if($("#email").val() == null || $("#email").val() == '0' || $("#email").val() == ''){
        alert('Please enter your email address.');
    }*/
    else if ($("#email").val() != '' && !validateEmail($("#email").val())) {
        alert('You\'ve entered invalid email.');
    }
 /*   else if($("#otp-input").val() == null || $("#otp-input").val() == '') {
      alert('Please validate your Mobile Number');
    }
   else if(otpinput != getOTP){
    //  alert(getOTP);
    //  alert($("otp-input").text());
      alert('Invalid OTP Code. Please try again. (up to 5 times)');
      invalidtry = invalidtry + 1;
      if(invalidtry == 5){
        alert('You cannot submit further due to a maximum limit of attempts.');
        $('#text').prop('disabled', true);
      }
    }  */
    else{
   //   document.getElementById("myCheck").click();

        //
          var value = $("#contact_no").val();
//  alert(value);
if(confirm('Motortrade will now send OTP to ' + value +' to continue. Proceed?')){
  otpsend = otpsend + 1;
  //alert(otpsend);
    if(otpsend == 2){
  $('.get-random').prop('disabled', true);
}
     if(value.length < 12){
        alert('Please make sure you put a valid mobile number. Kindly recheck it.');
    }
    else{
  $('.otpdisplay').css('display','block');
  $(".get-random").html("Resend OTP");
  min = Math.ceil(1111);
  max = Math.floor(9999);
  getOTP = Math.floor(Math.random() * (max - min)) + min;
  $('.custom-random').text(getOTP);
  count = count + 1;
  //$('.save-random').text(count);
  //alert(getOTP);

  //$('.save-random').append('<b>' + count + " : " + get + '</b>');
        $.ajax({
          type: "POST",
          url: "Customercare/sms_sending",
          data: { getOTP:  getOTP, value:value},

    beforeSend : function(){
      $('input').attr('disabled', true);
      $('button').attr('disabled', true);
      $('textarea').attr('disabled', true);
      $('select').attr('disabled', true);
    }
    }).done(function(data){
       $('input').removeAttr('disabled');
       $('select').removeAttr('disabled');
       $('textarea').removeAttr('disabled');
       $('button').removeAttr('disabled');
     // alert(data);
   //  alert('OTP has been sent to '+ value +' Please enter the code in the box provided or click the Resend button to resend (up to 2 times only).');
      $("#hiddenOTP").val(getOTP);
      $("#triesleft").html(3-count);
  if(count == 2){
    tries = 'try';
  }
  else{
    tries = 'tries';
  }
  if(count >= 3){
    $("#resending").html("Resend OTP ("+ (3 - count) +" "+ tries+" left)");
  }
  else{
     $("#resending").html("<a href=\"#\" onclick=\"reSend()\" data-dismiss=\"modal\">Resend OTP ("+ (3 - count) +" "+ tries+" left)</a>");
  }
     $('#exampleModal').modal({
                    backdrop: 'static',
              keyboard: false
          });

});
  }
}


   /*      var isGood = confirm('Confirm submit?');
    if (isGood) {
        alert('Form sent.');
        document.getElementById("myCheck").click();
    }  
    */
 }
 //
}

function submit(){
    alert('Complaint successfully sent!');
}
  $(".testregion").select2({  
    "placeholder": "Please select Region, Province, Municipality, Barangay",

  maximumSelectionLength: 1,
  minimumInputLength: 3,
   allowclear: true,
   multiple:true,
                ajax: {
                    url: "inquiry/find_psgc",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    }
                }
            });