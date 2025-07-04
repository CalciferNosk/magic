//$('select').on('change', function() { alert( this.value ); });
$(".number").on('input', function () {
    //alert('test');
    var number = $(this).val().replace(/[^\d]/g, '')
    if (number.length == 11) {
        number = number.replace(/(\d{4})(\d{5})/, "$1-$2");
    }
    $(this).val(number);
});


function allTriggers() {
    if ($("#tenurecountyears").val() >= 2 || $("#tenurecountmonths").val() >= 24 || ($("#tenurecountyears").val() >=
        1 && $("#tenurecountmonths").val() >= 12)) {
        $(".prev").css("display", "none");
    } else {
        $(".prev").css("display", "block");
    }

    if ($("#marital_status option:selected").text() == 'Married') {
        $(".Married").css("display", "block");
        $(".Divorced").css("display", "none");
        $(".Widowed").css("display", "none");
    }
    else if ($("#marital_status option:selected").text() == 'Live-In') {
        $(".Married").css("display", "block");
        $(".Divorced").css("display", "none");
        $(".Widowed").css("display", "none");
    } else if ($("#marital_status option:selected").text() == 'Widow') {
        $(".Married").css("display", "none");
        $(".Divorced").css("display", "block");
        $(".Widowed").css("display", "none");
    } else if ($("#marital_status option:selected").text() == 'Legally Seperated') {
        $(".Married").css("display", "none");
        $(".Divorced").css("display", "block");
        $(".Widowed").css("display", "none");
    } else {
        $(".Married").css("display", "none");
        $(".Divorced").css("display", "none");
        $(".Widowed").css("display", "none");
    }
}
$(window).keydown(function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        return false;
    }
});


$('input').each(function (i, item) {
    // console.log(item.id);
});
$('select').each(function (i, item) {
    // console.log(item.id);
});
//console.log('test');
$("input[data-type='currency']").on({
    keyup: function () {
        formatCurrency($(this));
    },
    blur: function () {
        formatCurrency($(this), "blur");
    }
});

radio(loan_type);
radio(gender);
function radio(name) {
    $('input:radio[name="' + name + '"]').change(
        function () {
            if ($(this).is(':checked')) {
                $('#' + name).val($(this).val());
            }
        });
}

var error = 0;

$('#proceedform').click(function () {

    const blank = isCanvasBlank(document.getElementById('sig-canvas'));
    var payslip = $('#payslip').val();
    var coe = $('#coe').val();
    var voucher = $('#voucher').val();
    var valid_id = $('#valid_id').val();
    var comapny_id = $('#comapny_id').val();
    var permit = $('#permit').val();
    var remittance = $('#remittance').val();
    var statement_account = $('#statement_account').val();
    var contract = $('#contract').val();
    var proof_income = $('#proof_income').val();
        // e.preventDefault();
        if( $('#source_fund').val() == ''){
            alert('Source Fund is Required!');
            return false;
        }
        if($('#source_fund').val() == 633){
            if(payslip == '' || coe == '' || valid_id == '' || comapny_id == ''){
                alert('Please fill out all attachments!');
                return false;
            }
        }
        if($('#source_fund').val() == 634){
            if(permit == '' || valid_id == ''){
                alert('Please fill out all attachments!');
                return false;
            }
        }
        if($('#source_fund').val() == 635){
            if(remittance == '' || valid_id == ''){
                alert('Please fill out all attachments!');
                return false;
            }
        }
        if($('#source_fund').val() == 636){
            if(statement_account == '' || valid_id == ''){
                alert('Please fill out all attachments!');
                return false;
            }
        }
        if($('#source_fund').val() == 2139){
            if(contract == ''){
                alert('Please fill out all attachments!');
                return false;
            }
        }
        if($('#source_fund').val() == 637){
            if(proof_income == '' || valid_id == ''){
                alert('Please fill out all attachments!');
                return false;
            }
        }

 
        $("#msform").submit();
    
});

$('.dis').attr('disabled', true);

var spousefield = ["spousefname", "spousemname", "spouselname", "spousenname", "spouse_nationality", "spouse_birthday", "spouse_age", "spouse_contact", "spouse_telno", "spouse_address", "spouse_birthplace"]
var permaddfield = ["permanentaddress", "address_sub"]
var prevaddfield = ["previousaddress", "address_prev"]
var widowfield = ["widow_years"]
var seperatefield = ["seperated_years"]
var borrowerfield = ["borrower_nature", "borrower_size"]

var tabsix = ["sig-dataUrl"]
var reqsix = ["sig-dataUrl"]

var tabfive = ["r1_name", "r1_address", "r1_contact_no", "r1_relationship", "r2_name", "r2_address", "r2_contact_no", "r2_relationship", "r3_name", "r3_address", "r3_contact_no", "r3_relationship", "idses", "busses", "spouses", "r1ses", "r2ses", "r3ses"]
var reqfive = ["r1_name", "r1_address", "r1_contact_no", "r1_relationship", "r2_name", "r2_address", "r2_contact_no", "r2_relationship", "r3_name", "r3_address", "r3_contact_no", "r3_relationship"]

var tabfour = ["l1_bank", "l1_type", "l1_amount", "l1_monthly", "l1_terms", "l1_granted", "l1_maturity", "l2_bank", "l2_type", "l2_amount", "l2_monthly", "l2_terms", "l2_granted", "l2_maturity", "l3_bank", "l3_type", "l3_amount", "l3_monthly", "l3_terms", "l3_granted", "l3_maturity", "idses", "busses", "spouses", "l1ses", "l2ses", "l3ses"]
var reqfour = []

var tabthree = ["source_fund", "salary", "business_income", "other_income", "gross_income", "idses", "busses", "spouses","company_name","len_service","position","address"]
var reqthree = ["source_fund", "source_income"]

var tabtwo = ["maiden_name", "no_children", "nationality",
    "birthday", "age", "birthplace", "gender", "education_attainment",
    "tin", "sss_gsis", "presentaddress", "address", "tenurecountyears", "tenurecountmonths", "sameadd", "permanentaddress", "address_sub", "previousaddress", "address_prev", "facebook", "instagram", "other_social", "home_tel", "home_fax", "dependent", "residence_type", "marital_status",
    "seperated_years", "widow_years", "spousefname", "spousemname", "spouselname", "spousenname", "spouse_nationality", "spouse_birthday", "spouse_age", "spouse_contact", "spouse_telno", "spouse_address", "spouse_birthplace",
    "borrower_type", "borrower_nature", "borrower_size", "company_name", "existencelengthyears", "existencelengthmonths", "position", "position_status", "register", "busaddress", "address_bus", "nature_work", "telephone_no", "previous_email", "years_business", "previous_employer_name", "previous_employer_telno", "previous_employer_street", "previous_employer_address", "previous_job", "previouslengthyears", "previouslengthmonths", "monthly_income", "monthly_provision",
    "idses", "custses", "sameaddindi", "busses", "spouses"]
var reqtwo = ["birthday", "age", "birthplace", "education_attainment", "presentaddress", "address",
    "tenurecountyears", "tenurecountmonths", "residence_type", "marital_status", "borrower_type",
    "company_name", "existencelengthyears", "existencelengthmonths", "position", "position_status", "busaddress", "address_bus", "years_business"]

var reqone = ["customer_fname", "customer_lname", "contact_no", "model", "brand", "color", "loan_term", "loan_amount", "downpayment"]
var tabone = ["customer_fname", "customer_lname", "customer_mname",
    "model", "brand", "color", "datetime", "loan_purpose",
    "loan_term", "loan_type", "loan_amount", "contact_no", "downpayment", "loan_purpose", "email", "clusterid", "sourceid", "idses", "custses", "busses", "spouses", "campaignid"]

tabs('tabone', tabone, reqone, 'one');
tabs('tabtwo', tabtwo, reqtwo, 'two');
tabs('tabthree', tabthree, reqthree, 'three');
tabs('tabfour', tabfour, reqfour, 'four');
tabs('tabfive', tabfive, reqfive, 'five');
tabs('tabsix', tabsix, reqsix, 'six');

function allAdjustments(tabno, req) {
    if (tabno == 'tabtwo') {
        var labell = $('#borrower_type :selected').parent().attr('label');
        //  alert(label);
        if (labell == '---Engaged In Business---') {
            Array.prototype.push.apply(req, borrowerfield);
        } else {
            req = req.filter((el) => !borrowerfield.includes(el));
        }
        if ($("#marital_status option:selected").text() == 'Married' || $("#marital_status option:selected").text() == 'Live-In') {
            //reqtwo.push("spousefname");
            Array.prototype.push.apply(req, spousefield);
        }
        else {
            req = req.filter((el) => !spousefield.includes(el));
        }
        if ($("#marital_status option:selected").text() == 'Widow') {
            Array.prototype.push.apply(req, widowfield);
        }
        else {
            req = req.filter((el) => !widowfield.includes(el));
        }
        if ($("#marital_status option:selected").text() == 'Legally Separated') {
            // alert('test');
            Array.prototype.push.apply(req, seperatefield);
        }
        else {
            req = req.filter((el) => !seperatefield.includes(el));
        }
        var checkAdd = document.getElementById("sameaddindi");
        //  alert(checkAdd.checked);
        if (checkAdd.checked == false) {
            Array.prototype.push.apply(req, permaddfield);
        }
        else {
            //   alert('test');
            req = req.filter((el) => !permaddfield.includes(el));
        }

        if ($("#tenurecountyears").val() >= 2 || $("#tenurecountmonths").val() >= 24 || ($("#tenurecountyears").val() >=
            1 && $("#tenurecountmonths").val() >= 12)) {
            req = req.filter((el) => !prevaddfield.includes(el));
        }
        else {
            Array.prototype.push.apply(req, prevaddfield);
        }
    }

    return req;
}
$('#submitModal').click(function () {
    if ($('#hiddenOTP').val() == $('#otp-input').val()) {
        // alert('Form sent. Thank you for choosing Motortrade Group.');
        tabs('tabotp', tabone, reqone);
        //document.getElementById("myCheck").click();
        //$("#modalfin").html('');
        //$('button').prop('disabled', true);
        //$('submit').prop('disabled', true);
    } else {
        alert('You\'ve entered incorrect OTP code.');
        error += 1;
        if (error >= 3) {
            $('#submitModal').prop('disabled', true);
            location.reload(true);
        }
    }
});


$(".next").click(function () {
    // alert('tess');
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({
        opacity: 0
    }, {
        step: function (now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            next_fs.css({
                'opacity': opacity
            });
        },
        duration: 600
    });
});

//alert(sessionStorage.getItem("id"));

function tabs(tabno, array, req, proc) {
    if (tabno == 'tabotp') {
        var arr = [];
        var obj = {};


        array.forEach(function (value) {
            window[value] = $("#" + value).val();
            obj[value] = window[value];
        });

        obj._cmcToken = $(`meta[name="_cmcToken"]`).attr("content");

        $.ajax({
            type: "POST",
            url: "Loan/" + tabno,
            data: obj,

            beforeSend: function () { }
        }).done(function (data) {
            var duce = JSON.parse(data);
            var form = new FormData(document.getElementById('msform'));
            //append files
            var file = document.getElementById('uploaddl').files[0];
            if (file) {
                form.append('uploaddl', file);
                form.append('idses', duce.id);
            }

            form.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
            $.ajax({
                type: "POST",
                url: "Loan/driverslicense",
                data: form,
                cache: false,
                contentType: false, //must, tell jQuery not to process the data
                processData: false,
                //data: $("#upload_img").serialize(),
                success: function (data) {
                    alert('Form Sent. Your Record Id is ' + duce.id + '. Thank you for choosing Motortrade Group.');
                    $('#exampleModal').modal('hide');
                    $('#oneproc').click();
                    sessionStorage.setItem("id", duce.id);
                    sessionStorage.setItem("customer_id", duce.customer_id);
                    //  alert(sessionStorage.getItem("id"));
                    $(".recid").html(sessionStorage.getItem("id"));
                    $("#idses").val(sessionStorage.getItem("id"));
                    $("#custses").val(sessionStorage.getItem("customer_id"));
                }
            });

        });
    }
    else {
        // alert('test');
        $("#" + tabno).click(function () {

            //var array=["customer_fname","customer_lname","customer_mname", "model", "brand", "color", "datetime", "loan_purpose", "loan_term"]
            //var req=["customer_fname","customer_lname"]
            var arr = [];
            var obj = {};


            //alert(reqtwo);
            array.forEach(function (value) {
                window[value] = $("#" + value).val();
                obj[value] = window[value];
            });

            req = allAdjustments(tabno, req);
            var rv = true;
            obj._cmcToken = $(`meta[name="_cmcToken"]`).attr("content");

            $.each(req, function (key, value) {
                if (value == 'sig-dataUrl' && $("#" + value).val() == '') {
                    alert('Please fill up the signature');
                    return false;
                }
                else {
                    if ($("#" + value).val() == '' || $("#" + value).val() == 0) {
                        if (value == 'gross_income') {
                            alert('Please enter Salary or Business Income or Other Income.');
                            return false;
                        }
                        //  alert('Please fill out First Name');
                        document.getElementById(value).style.borderColor = "red";
                        $("#" + value).siblings(".select2-container").css('border', '0.5px solid red');
                        rv = false;
                    } else {
                        if ($("#" + value).length) {
                            document.getElementById(value).style.borderColor = "green";
                        }
                        else {
                            //  alert(value);
                        }
                    }
                }
            });
            if (rv == false) {
                alert('Please fill out the fields in red.');
                return false;
            }
            if (tabno == 'tabone') {
                if ($("#idses").val() == '') {
                    //tabs('tabotp', tabone, reqone);
                    // alert('joke');
                    var first_name = $("#customer_fname").val();
                    var last_name = $("#customer_lname").val();
                    var mobile_no = $("#contact_no").val();
                    var model = $("#model").val();
                    var table = 'tblformloanapplication';
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
                        //console.log(data);
                        if (data == 'true') {
                            alert('There is an existing record based on the information given.');
                            return false;
                        }

                        // if ($("#uploaddl").val() == '') {
                        //     alert('Please insert Driver\'s License');
                        //     return false;
                        // }
                        if ($('#myChecked').prop("checked") == false) {
                            alert('Please check the Privacy Statement to proceed.');
                            return false;
                        }

                        if (isCaptchaChecked()) {
                            //alert('test');
                        } else {
                            alert('Please validate Captcha to see if you\'re not a robot');
                            return false;
                        }
                        var value = $("#contact_no").val();
                        // tabs('tabotp', tabone, reqone); error here!
                        if (confirm('Motortrade will now send OTP to ' + value + ' to continue. Proceed?')) {
                            otpsend = otpsend + 1;
                            //alert(otpsend);
                            if (otpsend == 2) {
                                $('.get-random').prop('disabled', true);
                            }
                            if (value.length < 12) {
                                alert('Please make sure you put a valid mobile number. Kindly recheck it.');
                            } else {
                                $('.otpdisplay').css('display', 'block');
                                $(".get-random").html("Resend OTP");
                                min = Math.ceil(1111);
                                max = Math.floor(9999);
                                getOTP = Math.floor(Math.random() * (max - min)) + min;
                                $('.custom-random').text(getOTP);
                                count = count + 1;

                                $.ajax({
                                    type: "POST",
                                    url: "Loan/sms_sending",
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
                                    $('.dis').attr('disabled', true);
                                    $("#hiddenOTP").val(getOTP);
                                    $("#triesleft").html(3 - count);
                                    if (count == 2) {
                                        tries = 'try';
                                    } else {
                                        tries = 'tries';
                                    }
                                    if (count >= 3) {
                                        $("#resending").html("Resend OTP (" + (3 - count) + " " + tries + " left)");
                                    } else {
                                        $("#resending").html(
                                            "<a href=\"#\" onclick=\"reSend()\" data-dismiss=\"modal\">Resend OTP (" + (3 -
                                                count) + " " + tries + " left)</a>");
                                    }
                                    $('#exampleModal').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    });

                                });


                            }
                        }
                    });
                }
                else {
                    //alert(JSON.stringify(obj));
                    $.ajax({
                        type: "POST",
                        url: "Loan/tabotp",
                        data: obj,

                        beforeSend: function () { }
                    }).done(function (data) {
                        // alert(data);
                        //    var duce = JSON.parse(data);
                        var form = new FormData(document.getElementById('msform'));
                        //append files
                        var file = document.getElementById('uploaddl').files[0];
                        if (file) {
                            form.append('uploaddl', file);
                            form.append('idses', $("#idses").val());
                        }

                        form.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
                        $.ajax({
                            type: "POST",
                            url: "Loan/driverslicense",
                            data: form,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                $('#oneproc').click();
                            }
                        });
                    });
                }
            }
            else {
                $.ajax({
                    type: "POST",
                    url: `Loan/${tabno}`,
                    data: obj,
                    beforeSend: function () { }
                }).done(function (data) {
                    $('#' + proc + 'proc').click();
                });
            }
        });
    }
}
function formatNumber(n) {
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
if (((getUrlParameter('src') == null) && (getUrlParameter('cls') == null)) || (getUrlParameter('src') == null)) {
    //  alert('test');
    window.location.href = "FormError";
}

$('input[type="number"]').attr("min", "0");

/*$('#validateForm').on('submit', function() {
  alert('test')
         return $('#validateForm').jqxValidator('validate');
*/


function stayTrigger() {
    if ($("#tenurecountyears").val() >= 2 || $("#tenurecountmonths").val() >= 24 || ($("#tenurecountyears").val() >=
        1 && $("#tenurecountmonths").val() >= 12)) {
        $(".prev").css("display", "none");
    } else {
        $(".prev").css("display", "block");
    }
}


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

//document.getElementByClassName("birthday").setAttribute("max", today);
$(".birthday").attr("max", today);
$('input[name="birthday"]').change(function () {
    var dob = $("#birthday").val();

    if (Date.parse(dob)) {
        dob = new Date(dob);
        var today = new Date();
        var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
        if (age > 0) {
            $('#age').val(age);
        }
        //alert(age);
    }
});

$('input[name="spouse_birthday"]').change(function () {
    var dob = $("#spouse_birthday").val();

    if (Date.parse(dob)) {
        dob = new Date(dob);
        var today = new Date();
        var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
        if (age > 0) {
            $('#spouse_age').val(age);
        }
        //alert(age);
    }
});



/* var dob = $('#date').val();
  dob = new Date(dob);

*/
function isCaptchaChecked() {
    return grecaptcha && grecaptcha.getResponse().length !== 0;
}

//$('#exampleModal').modal('show');
$('#govtidrem').click(function () {
    // alert($('#govtid').val());
    $('#govtid').val(null);
    $('#govtidlab').html(
        '<span style="color:gray">Upload one valid ID (Government ID, Driver\'s License, etc) *</span>');
});
$('#coerem').click(function () {
    // alert($('#coe').val());
    $('#coe').val(null);
    $('#coelab').html('<span style="color:gray">Upload your current Certificate of Employment</span>');
});
$('#billingrem').click(function () {
    // alert($('#billing').val());
    $('#billing').val(null);
    $('#billinglab').html('<span style="color:gray">Proof of billing *</span>');
});
$('#selfierem').click(function () {
    // alert($('#selfie').val());
    $('#selfie').val(null);
    $('#selfielab').html('<span style="color:gray">Upload a selfie so that we can recognize you *</span>');
});
$('#sketchrem').click(function () {
    // alert($('#sketch').val());
    $('#sketch').val(null);
    $('#sketchlab').html('<span style="color:gray">Take a photo of the sketch of your home</span>');
});


document.querySelector('#govtid').addEventListener('change', function (e) {
    var fileName = document.getElementById("govtid").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = fileName
    nextSibling.style.color = 'black'
})
document.querySelector('#coe').addEventListener('change', function (e) {
    var fileName = document.getElementById("coe").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = fileName
    nextSibling.style.color = 'black'
})
document.querySelector('#billing').addEventListener('change', function (e) {
    var fileName = document.getElementById("billing").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = fileName
    nextSibling.style.color = 'black'
})
document.querySelector('#selfie').addEventListener('change', function (e) {
    var fileName = document.getElementById("selfie").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = fileName
    nextSibling.style.color = 'black'
})
document.querySelector('#sketch').addEventListener('change', function (e) {
    var fileName = document.getElementById("sketch").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = fileName
    nextSibling.style.color = 'black'
})


function isCanvasBlank(canvas) {
    const context = canvas.getContext('2d');

    const pixelBuffer = new Uint32Array(
        context.getImageData(0, 0, canvas.width, canvas.height).data.buffer
    );

    return !pixelBuffer.some(color => color !== 0);
}


(function () {
    window.requestAnimFrame = (function (callback) {
        return window.requestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.oRequestAnimationFrame ||
            window.msRequestAnimaitonFrame ||
            function (callback) {
                window.setTimeout(callback, 1000 / 60);
            };
    })();

    var canvas = document.getElementById("sig-canvas");
    $(window).resize(function () {

        if ($(window).width() <= 768) {
            x = $(window).width() * .67;
            $("canvas").attr("width", x);
            $("#govtidlab").text("Valid ID");
            $("#coelab").text("COE");
            $("#selfielab").text("Selfie");
            $("#sketchlab").text("Sketch of home");

        } else {
            x = $(window).width() * .33;
            $("canvas").attr("width", x);
            $("#govtidlab").text("Upload one valid ID (Government ID, Driver's License, etc) *");
            $("#coelab").text("Upload your current Certificate of Employment");
            $("#selfielab").text("Selfie");
            $("#sketchlab").text("Sketch of home");
        }

    });

    if ($(window).width() <= 767) {
        x = $(window).width() * .67;
        $("canvas").attr("width", x);
        $("#govtidlab").text("Valid ID");
        $("#coelab").text("COE");
        $("#selfielab").text("Selfie");
        $("#sketchlab").text("Sketch of home");

    } else {
        x = $(window).width() * .33;
        $("canvas").attr("width", x);
    }

    var ctx = canvas.getContext("2d");
    ctx.strokeStyle = "#1C3393";
    ctx.lineWidth = 4;

    var drawing = false;
    var mousePos = {
        x: 0,
        y: 0
    };
    var lastPos = mousePos;


    canvas.addEventListener("mousedown", function (e) {
        drawing = true;
        lastPos = getMousePos(canvas, e);
    }, false);

    canvas.addEventListener("mouseup", function (e) {
        drawing = false;
    }, false);

    canvas.addEventListener("mousemove", function (e) {
        mousePos = getMousePos(canvas, e);
    }, false);

    // Add touch event support for mobile
    canvas.addEventListener("touchstart", function (e) {

    }, false);

    canvas.addEventListener("touchstart", function (event) {
        event.preventDefault()
    })
    canvas.addEventListener("touchmove", function (event) {
        event.preventDefault()
    })
    canvas.addEventListener("touchend", function (event) {
        event.preventDefault()
    })
    canvas.addEventListener("touchcancel", function (event) {
        event.preventDefault()
    })

    canvas.addEventListener("touchmove", function (e) {
        var touch = e.touches[0];
        var me = new MouseEvent("mousemove", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(me);
    }, false);

    canvas.addEventListener("touchstart", function (e) {
        mousePos = getTouchPos(canvas, e);
        var touch = e.touches[0];
        var me = new MouseEvent("mousedown", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(me);
    }, false);

    canvas.addEventListener("touchend", function (e) {
        var me = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(me);
    }, false);

    function getMousePos(canvasDom, mouseEvent) {
        var rect = canvasDom.getBoundingClientRect();
        return {
            x: mouseEvent.clientX - rect.left,
            y: mouseEvent.clientY - rect.top
        }
    }

    function getTouchPos(canvasDom, touchEvent) {
        var rect = canvasDom.getBoundingClientRect();
        return {
            x: touchEvent.touches[0].clientX - rect.left,
            y: touchEvent.touches[0].clientY - rect.top
        }
    }

    function renderCanvas() {
        if (drawing) {
            ctx.moveTo(lastPos.x, lastPos.y);
            ctx.lineTo(mousePos.x, mousePos.y);
            ctx.stroke();
            lastPos = mousePos;
        }
    }

    // Prevent scrolling when touching the canvas
    document.body.addEventListener("touchstart", function (e) {
        if (e.target == canvas) {
            e.preventDefault();
        }
    }, false);
    document.body.addEventListener("touchend", function (e) {
        if (e.target == canvas) {
            e.preventDefault();
        }
    }, false);
    document.body.addEventListener("touchmove", function (e) {
        if (e.target == canvas) {
            e.preventDefault();
        }
    }, false);

    (function drawLoop() {
        requestAnimFrame(drawLoop);
        renderCanvas();
    })();

    function clearCanvas() {
        canvas.width = canvas.width;
        canvas.getContext("2d").strokeStyle = "#1C3393";
        canvas.getContext("2d").lineWidth = 4;
    }

    // Set up the UI
    var sigText = document.getElementById("sig-dataUrl");
    var sigImage = document.getElementById("sig-image");
    var clearBtn = document.getElementById("sig-clearBtn");
    var submitBtn = document.getElementById("proceedform");
    clearBtn.addEventListener("click", function (e) {
        clearCanvas();
        sigText.innerHTML = "Data URL for your signature will go here!";
        sigImage.setAttribute("src", "");

    }, false);
    submitBtn.addEventListener("click", function (e) {

    }, false);
    $('canvas').on('mouseup', function () {
        var dataUrl = canvas.toDataURL();
        // alert(dataUrl);
        sigText.innerHTML = dataUrl;
        // sigImage.setAttribute("src", dataUrl);
    });

})();

$(document).ready(function () {

    $(".testregion").select2({
        "placeholder": "Please enter Province, Municipality, Barangay",

        maximumSelectionLength: 1,
        minimumInputLength: 3,
        allowclear: true,
        multiple: true,
        ajax: {
            url: "loan/find_psgc",
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

$("#brand").val(sessionStorage.getItem("brand"));
$("#model").val(sessionStorage.getItem("model"));
// alert(sessionStorage.getItem("brand"));

$("#color").val(sessionStorage.getItem("color"));
$("#customer_fname").val(sessionStorage.getItem("customer_fname"));
$("#customer_mname").val(sessionStorage.getItem("customer_mname"));
$("#customer_lname").val(sessionStorage.getItem("customer_lname"));
$("#region").val(sessionStorage.getItem("region"));
$("#province").val(sessionStorage.getItem("province"));
$("#city").val(sessionStorage.getItem("city"));
$("#barangay").val(sessionStorage.getItem("barangay"));
$("#address").val(sessionStorage.getItem("address"));
$("#email").val(sessionStorage.getItem("email"));
$("#contact_no").val(sessionStorage.getItem("contact_no"));
sessionStorage.clear();
$('#collapseOne').collapse('show');
$("#accordion").on("hide.bs.collapse show.bs.collapse", e => {
    $(e.target)
        .prev()
        .find("i:last-child")
        .toggleClass("fa-minus fa-plus");
});
/*var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
 if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 

todayy = yyyy+'-'+mm+'-'+ (dd - 1);
today = yyyy+'-'+mm+'-'+dd;
document.getElementById("birthday").setAttribute("max", todayy);
document.getElementById("date_purchase").setAttribute("min", today);*/

$('#exampleModal').on('hidden.bs.modal', function () {
    //    alert(count);

    grecaptcha.reset();
    $("#myChecked").prop("checked", false);
    //$("#text").css("display", "none");
    $('#text').prop("disabled", true);
});

$('#exampleModal').on('shown.bs.modal', function () {
    setInterval(function () {
        //reSend();
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


//objb.forEach(foreach);


if (sessionStorage.getItem("brand") != 'null') {
    objm.forEach(brand);
    //$("#model").val();
    // selectElement('model', sessionStorage.getItem("model"));

}

function selectElement(id, valueToSelect) {
    let element = document.getElementById(id);
    element.value = valueToSelect;
}

function region(item, index) {

    if (item.regCode == $("#regiona").val()) {
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

function regionsub(item, index) {

    if (item.regCode == $("#region_sub").val()) {
        $("#province_sub").append("<option value='" + item['provCode'] + "'>" + item['provDesc'] + " </option>");
    }
}

function provincesub(item, index) {

    if (item.provCode == $("#province_sub").val()) {
        // alert(item['cityDesc']);
        $("#city_sub").append("<option value='" + item['citymunCode'] + "'>" + item['citymunDesc'] + " </option>");
    }
}

function citysub(item, index) {
    if (item.citymunCode == $("#city_sub").val()) {
        $("#barangay_sub").append("<option value='" + item['brgyCode'] + "'>" + item['brgyDesc'] + " </option>");
    }
}

function regionbus(item, index) {

    if (item.regCode == $("#region_bus").val()) {
        $("#province_bus").append("<option value='" + item['provCode'] + "'>" + item['provDesc'] + " </option>");
    }
}

function provincebus(item, index) {

    if (item.provCode == $("#province_bus").val()) {
        // alert(item['cityDesc']);
        $("#city_bus").append("<option value='" + item['citymunCode'] + "'>" + item['citymunDesc'] + " </option>");
    }
}

function citybus(item, index) {
    if (item.citymunCode == $("#city_bus").val()) {
        $("#barangay_bus").append("<option value='" + item['brgyCode'] + "'>" + item['brgyDesc'] + " </option>");
    }
}

function regionprev(item, index) {

    if (item.regCode == $("#region_prev").val()) {
        $("#province_prev").append("<option value='" + item['provCode'] + "'>" + item['provDesc'] + " </option>");
    }
}

function provinceprev(item, index) {

    if (item.provCode == $("#province_prev").val()) {
        // alert(item['cityDesc']);
        $("#city_prev").append("<option value='" + item['citymunCode'] + "'>" + item['citymunDesc'] + " </option>");
    }
}

function cityprev(item, index) {
    if (item.citymunCode == $("#city_prev").val()) {
        $("#barangay_prev").append("<option value='" + item['brgyCode'] + "'>" + item['brgyDesc'] + " </option>");
    }
}

function brand(item, index) {
    var modeldesc;
    if (item.parentid == $("#brand").val()) {
        if (item['referencedesc'] != null) {
            modeldesc = " (" + item['referencedesc'] + ")";
        } else {
            modeldesc = '';
        }
        $("#model").append("<option value='" + item['grid'] + "*" + item['TypeId'] + "'>" + item['referencename'] + modeldesc + " </option>");

    }

}
//alert(JSON.stringify(obja));

function area(item, index) {
    //  if(item.parentid == $("#brand").val()){
    // alert('test');
    var region_id = $("#region option:selected").attr('data-id');
    // alert(area_id);
    //alert(region_id);
    if (region_id == item['parent_org_id']) {
        var clusterer_id = region_id;
        // alert(cluster_id);
        //obja.forEach(function (item, index) {
        anotherone(clusterer_id, item, index);
        //});
    }
}

function validateEmail(email) {
    const re =
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function branch(item, index) {
    //  if(item.parentid == $("#brand").val()){
    var area_id = $("#area option:selected").attr('data-id');
    // alert(area_id);
    // alert(item['parent_org_id']);
    if (area_id == item['parent_org_id']) {
        // alert('test');
        var cluster_id = area_id;
        //      objb.forEach(function (item, index) {
        another(cluster_id, item, index);
        //});
    }



    //  }
}


var test;

function another(cluster_id, item, index) {
    //  if(item.parentid == $("#brand").val()){
    // alert(item['id']);


    if (cluster_id == item['parent_org_id']) {
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
        if (item['address'] == null) {
            test = '';
        }
        if (item['org_type'] == 'BRN') {
            $("#branch").append("<option value='" + item['code'] + "'>" + item['code'] + " " + item['description'] +
                " " + test + "</option>");
        }
    }



    //  }
}

function anothertwo(clusterr_id, item, index) {
    //alert(clusterr_id);
    //  if(clusterr_id == item['parent_org_id']){
    //  alert(item['description']);
    // $("#branch").append("<option value='"+ item['code'] +"'>" + item['code'] + " "+ item['description'] + " "+ test +"</option>");
    //}
}



//  }


function anotherone(clusterer_id, item, index) {
    //  if(item.parentid == $("#brand").val()){
    // alert(clusterer_id + " "+ item['parent_org_id']);
    if (clusterer_id == item['parent_org_id']) {
        // alert('test');
        $("#area").append("<option value='" + item['code'] + "' data-id='" + item['id'] + "'>" + item['description'] +
            "</option>");
    }



    //  }
}

function compute() {
    var salary = $("#salary").val().replace(/,/g, '');
    var business_income = $("#business_income").val().replace(/,/g, '');
    var other_income = $("#other_income").val();
    if (salary == '') {
        salary = '0';
    }
    if (business_income == '') {
        business_income = '0';
    }
    if (other_income == '') {
        other_income = '0';
    }
    salary = salary.replace(/\D/g, '');
    business_income = business_income.replace(/\D/g, '');
    other_income = other_income.replace(/\D/g, '');
    var totalincome = parseInt(salary) + parseInt(business_income) + parseInt(other_income);
    var totalincomefinal = totalincome.toLocaleString("en");
    //alert(totalincomefinal);
    $("#gross_income").val(totalincomefinal);
}

function recaptchaCallback() {
    //datacheckbox();
    var checkBox = document.getElementById("myChecked");
    // Get the output text
    var text = document.getElementById("text");

    // If the checkbox is checked, display the output text
    if (checkBox.checked == true) {
        //  alert('test');
        $('#text').prop("disabled", false);
    } else {
        // alert('earae');
        $('#text').prop("disabled", true);
    };
}


$("#sourceparam").val(getUrlParameter('source'));
$("#clusterparam").val(getUrlParameter('cluster'));
$("#clusterparame").text(getUrlParameter('cluster'));
var otpsend = 0;
var count = 0,
    getOTP;

$('.get-random').click(function () {
    var value = $("#contact_no").val();
    //  alert(value);
    if (confirm('Motortrade will now send OTP to ' + value + '. Continue?')) {
        otpsend = otpsend + 1;
        //alert(otpsend);
        if (otpsend == 2) {
            $('.get-random').prop('disabled', true);
        }
        if (value.length < 12) {
            alert('Please make sure you put a valid mobile number. Kindly recheck it.');
        } else {
            $('.otpdisplay').css('display', 'block');
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
                url: "Loan/sms_sending",
                data: {
                    getOTP: getOTP,
                    value: value,
                    _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                },

                beforeSend: function () { }
            }).done(function (data) {
                // alert(data);
                alert(
                    'OTP has been sent. Please enter the code in the box provided or click the Resend button to resend (up to 3 times only).'
                );

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
    $('.mobile').keydown(function (e) {
        var key = e.charCode || e.keyCode || 0;
        $text = $(this);
        if (key !== 8 && key !== 9) {
            if ($text.val().length === 4) {
                $text.val($text.val() + '-');
            }

        }


    });
    $('.tin').keydown(function (e) {
        var key = e.charCode || e.keyCode || 0;
        $text = $(this);
        // if (key !== 8 && key !== 9) {
        if ($text.val().length === 3 || $text.val().length === 7 || $text.val().length === 11) {
            $text.val($text.val() + '-');
        }

        //             }


    });
});

$('.js-example-basic-multiple-another').select2({
    maximumSelectionLength: 1
});
$('.js-example-basic-multiple').select2({
    maximumSelectionLength: 1
});

$("#residence_type").change(function () {
    //alert($("#residence_type option:selected" ).text());
    if ($("#residence_type option:selected").text() == 'Mortgaged') {
        $(".living").css("display", "none");
        $(".mortgaged").css("display", "block");
        $(".renting").css("display", "none");
    } else if ($("#residence_type option:selected").text() == 'Renting') {
        $(".living").css("display", "none");
        $(".mortgaged").css("display", "none");
        $(".renting").css("display", "block");
    } else if ($("#residence_type option:selected").text() == 'Living With Relatives') {
        $(".living").css("display", "block");
        $(".mortgaged").css("display", "none");
        $(".renting").css("display", "none");
    } else {
        $(".living").css("display", "none");
        $(".mortgaged").css("display", "none");
        $(".renting").css("display", "none");
    }

    //$(".Living").css("display", "block");
});

$("#marital_status").change(function () {
    //  alert('test');
    // alert($("#marital_status option:selected" ).text());
    if ($("#marital_status option:selected").text() == 'Married') {
        $(".Married").css("display", "block");
        $(".Divorced").css("display", "none");
        $(".Widowed").css("display", "none");
    }
    else if ($("#marital_status option:selected").text() == 'Live-In') {
        $(".Married").css("display", "block");
        $(".Divorced").css("display", "none");
        $(".Widowed").css("display", "none");
    } else if ($("#marital_status option:selected").text() == 'Widow') {
        //$("#widow_years").val();
        $(".Married").css("display", "none");
        $(".Divorced").css("display", "none");
        $(".Widowed").css("display", "block");
    } else if ($("#marital_status option:selected").text() == 'Legally Separated') {
        // $("#seperated_years").val('');
        $(".Married").css("display", "none");
        $(".Divorced").css("display", "block");
        $(".Widowed").css("display", "none");
    } else {
        $(".Married").css("display", "none");
        $(".Divorced").css("display", "none");
        $(".Widowed").css("display", "none");
    }



    //$(".Living").css("display", "block");
});

$("#source_income").change(function () {
    // alert($("#source_income option:selected" ).text());
    var label = $(this.options[this.selectedIndex]).closest('optgroup').prop('label');
    //  alert(label);
    if (label == '---Employed Private---') {
        $(".selfemployed").css("display", "none");
        $(".employed").css("display", "block");
        $(".ofw").css("display", "none");
        $(".recipient").css("display", "none");
        $(".ofw").css("display", "none");
        $(".tenurelength").css("display", "block");
        $(".existencelength").css("display", "none");
        $(".monthlyremittance").css("display", "none");
        $(".monthlyincome").css("display", "block");
        if ($("#source_income option:selected").is(':contains("OFW")')) {
            //if($(:contains(OFW)" )){
            $(".ofw").css("display", "block");
        }
    } else if (label == '---Self Employed---') {
        $(".selfemployed").css("display", "block");
        $(".employed").css("display", "none");
        $(".ofw").css("display", "none");
        $(".recipient").css("display", "none");
        $(".ofw").css("display", "none");
        $(".tenurelength").css("display", "none");
        $(".existencelength").css("display", "block");
        $(".monthlyremittance").css("display", "none");
        $(".monthlyincome").css("display", "block");
    }
    /* else if($("#source_income option:selected" ).text() == 'OFW / Seaman'){
    //alert('test');
 $(".selfemployed").css("display", "none");
      $(".employed").css("display", "none");
      $(".ofw").css("display", "block");
      $(".recipient").css("display", "none");
      //$(".ofw").css("display", "none");
      $(".tenurelength").css("display", "block");
      $(".existencelength").css("display", "none");
      $(".monthlyremittance").css("display", "none");
      $(".monthlyincome").css("display", "block");
   }
   */
    else if (label == '---Unemployed---') {
        $(".selfemployed").css("display", "none");
        $(".employed").css("display", "none");
        $(".ofw").css("display", "none");
        $(".recipient").css("display", "block");
        $(".ofw").css("display", "none");
        $(".tenurelength").css("display", "none");
        $(".existencelength").css("display", "block");
        $(".monthlyremittance").css("display", "block");
        $(".monthlyincome").css("display", "none");
    }
    /*
      else if($("#source_income option:selected" ).text() == 'Other Source of Income'){
       $(".selfemployed").css("display", "none");
       $(".employed").css("display", "none");
       $(".ofw").css("display", "none");
       $(".recipient").css("display", "none");
       $(".ofw").css("display", "none");
       $(".tenurelength").css("display", "block");
       $(".existencelength").css("display", "none");
       $(".monthlyremittance").css("display", "none");
       $(".monthlyincome").css("display", "block");
    }
    */
    else {
        $(".selfemployed").css("display", "none");
        $(".employed").css("display", "none");
        $(".ofw").css("display", "none");
        $(".recipient").css("display", "none");
        $(".ofw").css("display", "none");
        $(".tenurelength").css("display", "none");
        $(".existencelength").css("display", "none");
        $(".monthlyremittance").css("display", "none");
        $(".monthlyincome").css("display", "none");
    }

    //$(".Living").css("display", "block");
});
$(".borrowbusiness").css("display", "none");
$("#borrower_type").change(function () {
    // alert($("#source_income option:selected" ).text());
    //var labell = $(this.options[this.selectedIndex]).closest('optgroup').prop('label');
    var tess = $("#borrower_type").val();
    //alert(JSON.stringify(this));
    var labell = $('#borrower_type :selected').parent().attr('label');
    //  alert(label);
    if (labell == '---Engaged In Business---') {
        $(".borrowbusiness").css("display", "block");
    } else {
        $(".borrowbusiness").css("display", "none");
    }

    //$(".Living").css("display", "block");
});

$("#region").change(function () {
    $("#region option[value='0']").remove();
    // $('#generateBranch').removeAttr('disabled');

    //alert(area_id);
    $("#area").empty();
    $("#branch").empty();
    obja.forEach(area);
});

$("#area").change(function () {
    $("#area option[value='0']").remove();
    // $('#generateBranch').removeAttr('disabled');

    //alert(area_id);
    $("#branch").empty();
    objbr.forEach(branch);
});


$("#brand").change(function () {

    $("#model").empty();
    $("#model").append("<option value='' id='defchoose'>Choose</option>");
    objm.forEach(brand);

});

$("#region_prev").change(function () {
    $("#region_prev option[value='']").remove();
    $("#province_prev").empty();
    $("#city_prev").empty();
    $("#barangay_prev").empty();
    $("#province_prev").append("<option value='' id='defchoose'>Choose</option>");
    objp.forEach(regionprev);

});

$("#province_prev").change(function () {
    $("#province_prev option[value='']").remove();
    $("#city_prev").empty();
    $("#barangay_prev").empty();
    $("#city_prev").append("<option value='' id='defchoose'>Choose</option>");
    objc.forEach(provinceprev);

});

$("#city_prev").change(function () {
    $("#city_prev option[value='']").remove();
    $("#barangay_prev").empty();
    $("#barangay_prev").append("<option value='' id='defchoose'>Choose</option>");
    objb.forEach(cityprev);

});

$("#region_sub").change(function () {
    $("#region_sub option[value='']").remove();
    $("#province_sub").empty();
    $("#city_sub").empty();
    $("#barangay_sub").empty();
    $("#province_sub").append("<option value='' id='defchoose'>Choose</option>");
    objp.forEach(regionsub);

});

$("#province_sub").change(function () {
    $("#province_sub option[value='']").remove();
    $("#city_sub").empty();
    $("#barangay_sub").empty();
    $("#city_sub").append("<option value='' id='defchoose'>Choose</option>");
    objc.forEach(provincesub);

});

$("#city_sub").change(function () {
    $("#city_sub option[value='']").remove();
    $("#barangay_sub").empty();
    $("#barangay_sub").append("<option value='' id='defchoose'>Choose</option>");
    objb.forEach(citysub);

});

$("#region_bus").change(function () {
    $("#region_bus option[value='']").remove();
    $("#province_bus").empty();
    $("#city_bus").empty();
    $("#barangay_bus").empty();
    $("#province_bus").append("<option value='' id='defchoose'>Choose</option>");
    objp.forEach(regionbus);

});

$("#province_bus").change(function () {
    $("#province_bus option[value='']").remove();
    $("#city_bus").empty();
    $("#barangay_bus").empty();
    $("#city_bus").append("<option value='' id='defchoose'>Choose</option>");
    objc.forEach(provincebus);

});

$("#city_bus").change(function () {
    $("#city_bus option[value='']").remove();
    $("#barangay_bus").empty();
    $("#barangay_bus").append("<option value='' id='defchoose'>Choose</option>");
    objb.forEach(citybus);

});

$("#regiona").change(function () {
    var checkAdd = document.getElementById("sameadd");
    if (checkAdd.checked == true) {
        sameaddress();
    }
    $("#regiona option[value='']").remove();
    $("#province").empty();
    $("#city").empty();
    $("#barangay").empty();
    $("#province").append("<option value='' id='defchoose'>Choose</option>");
    objp.forEach(region);

});

$("#province").change(function () {
    var checkAdd = document.getElementById("sameadd");
    if (checkAdd.checked == true) {
        sameaddress();
    }
    $("#province option[value='']").remove();
    $("#city").empty();
    $("#barangay").empty();
    $("#city").append("<option value='' id='defchoose'>Choose</option>");
    objc.forEach(provincea);

});

$("#city").change(function () {
    var checkAdd = document.getElementById("sameadd");
    if (checkAdd.checked == true) {
        sameaddress();
    }
    $("#city option[value='']").remove();
    $("#barangay").empty();
    $("#barangay").append("<option value='' id='defchoose'>Choose</option>");
    objb.forEach(citya);

});

$("#barangay").change(function () {
    var checkAdd = document.getElementById("sameadd");
    if (checkAdd.checked == true) {
        sameaddress();
    }
});

$("#mobile_number").attr({
    "min": 7
});


var totalresend = 0;

function reSend() {
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
        } else {
            //  alert(count);


            $('.otpdisplay').css('display', 'block');
            $(".get-random").html("Resend OTP");
            min = Math.ceil(1111);
            max = Math.floor(9999);
            getOTP = Math.floor(Math.random() * (max - min)) + min;
            $('.custom-random').text(getOTP);
            count = count + 1;
            if (count >= 4) {
                location.reload(true);
            } else {
                $.ajax({
                    type: "POST",
                    url: "Loan/sms_sending",
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
                    } else {
                        tries = 'tries';
                    }
                    if (count >= 3) {
                        $("#resending").html("Resend OTP (" + (3 - count) + " " + tries + " left)");
                    } else {
                        $("#resending").html(
                            "<a href=\"#\" onclick=\"reSend()\" data-dismiss=\"modal\">Resend OTP (" + (3 -
                                count) + " " + tries + " left)</a>");
                    }
                    $('#exampleModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                });
            }
        }
    } else {
        //  location.reload();
    }
}

function isCaptchaChecked() {
    return grecaptcha && grecaptcha.getResponse().length !== 0;
}
$('#permanentaddress').val($('#presentaddress').val());

function sameaddress() {
    //alert($('#regiona').val());
    //alert($('#presentaddress').val());
    var checkAdd = document.getElementById("sameaddindi");
    if (checkAdd.checked == true) {
        //  $(".permanentadd").css("display", "block");
        $(".permanentsub").css("display", "none");
        $('#sameaddindi').val(1);
    } else {
        $(".permanentsub").css("display", "block");
        //$(".permanentadd").css("display", "none");
        $('#sameaddindi').val(0);
    }
    $("#zip_per").val($('#zip').val());
    $('#address_per').val($('#address').val());
    $('#permanentaddresssub').val($('#presentaddress').val());
    $('#permanentaddresssub').trigger('change');
    $('#region_per').val($('#regiona').val());
    $('#province_per').val($('#province').val());
    $('#city_per').val($('#city').val());
    $('#barangay_per').val($('#barangay').val());
    //$('#address_per').val($('#address').val());
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

function myFunction() {
    // if ($('#sameadd').is(":checked")) {
    //     $('#sameaddindi').val('test');
    // }          

    var valuea = $("#spouse_contact").val();
    if ($('.Married').css('display') == 'none') {
    }
    else {
        if (valuea.length < 12 || valuea.substring(0, 2) != '09') {
            alert('Please make sure you put a valid mobile number. Kindly recheck it.');
            document.getElementById('spouse_contact').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('spouse_contact').style.borderColor = "green";
        }
    }

    $('#presentaddress').attr('style', 'border-color: red !important');
    var $myForm = $('#validateForm');

    if (!$myForm[0].checkValidity()) {
        // If the form is invalid, submit it. The form won't actually submit;
        // this will just cause the browser to display the native HTML5 error messages.
        $('#collapseTwo').collapse('show');
        $('#collapseThree').collapse('show');
        $('#collapseFour').collapse('show');
        $('#collapseFive').collapse('show');
        $('#collapseSix').collapse('show');
        //  $myForm.find(':submit').click();
    }

    if ($('#myChecked').prop("checked") == false) {
        alert('Please check the Privacy Statement to proceed.');
        return false;
    }

    if (isCaptchaChecked()) {
        //alert('test');
    } else {
        alert('Please validate Captcha to see if you\'re not a robot');
        return false;
    }


    const blank = isCanvasBlank(document.getElementById('sig-canvas'));

    //   //alert(blank ? 'blank' : 'not blank');
    //   if(blank){
    //     alert('Please sign the signature');
    //     return false;
    //   }
    // //return true;
    //     var isValid = true;

    //   $('input:required').each(function() {
    //      $(this).css("border-color", "green");
    //     if ( $(this).val() == '' || $(this).val() == '0 '){
    //    //   alert($(this).attr('type'));
    //     $(this).css("border-color", "red");
    //        isValid = false;
    //       }
    //   });
    //   $('select:required').each(function() {
    //       $(this).css("border-color", "green");
    //     if ( $(this).val() == '' || $(this).val() == 'undefined' ){
    //  //     alert('Testing');
    //     $(this).css("border-color", "red");
    //        isValid = false;
    //       }
    //   });
    // //  alert(isValid);
    //   if(isValid == false){
    //     alert('Please fill up fields inside the red lines.')
    //  return isValid;
    // }

    //  alert('testd');
    var result = $("#div_selector input:required").filter(function () {
        return $.trim($(this).val()).length == 0
    }).length == 0;
    // alert(result);
    //  alert('tess');
    //  document.querySelectorAll("input").style.borderColor = "red";
    //$("input ['required']").css("background-color");

    $("form").find("input").css("border: 0.1em solid red");

    var otpinput = $("#otp-input").val();
    var value = $("#contact_no").val();
    var valueb = $("#r1_contact_no").val();
    var valuec = $("#r2_contact_no").val();
    var valued = $("#r3_contact_no").val();

    if ($("#brand").val() == null || $("#brand").val() == '0' || $("#brand").val() == '') {
        alert('Please fill out Brand');
        document.getElementById('brand').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('brand').style.borderColor = "green";
    }
    if ($("#model").val() == null || $("#model").val() == '0' || $("#model").val() == '') {
        alert('Please fill out Model');
        document.getElementById('model').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('model').style.borderColor = "green";
    }
    if ($("#color").val() == null || $("#color").val() == '0' || $("#color").val() == '') {
        alert('Please fill out Color');
        document.getElementById('color').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('color').style.borderColor = "green";
    }

    if (value.length < 12 || value.substring(0, 2) != '09') {
        alert('Please make sure you put a valid mobile number. Kindly recheck it.');
        document.getElementById('contact_no').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('contact_no').style.borderColor = "green";
    }

    if (valueb.length < 12 || valueb.substring(0, 2) != '09') {
        alert('Please make sure you put a valid mobile number. Kindly recheck it.');
        document.getElementById('r1_contact_no').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('r1_contact_no').style.borderColor = "green";
    }
    if (valuec.length < 12 || valuec.substring(0, 2) != '09') {
        alert('Please make sure you put a valid mobile number. Kindly recheck it.');
        document.getElementById('r2_contact_no').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('r2_contact_no').style.borderColor = "green";
    }
    if (valued.length < 12 || valued.substring(0, 2) != '09') {
        alert('Please make sure you put a valid mobile number. Kindly recheck it.');
        document.getElementById('r3_contact_no').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('r3_contact_no').style.borderColor = "green";
    }
    //alert('test');



    if ($("#maiden_name").val() == '') {
        alert('Please fill out Mothers Maiden Name');
        document.getElementById('maiden_name').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('maiden_name').style.borderColor = "green";
    }

    if ($("#birthday").val() == null || $("#birthday").val() == '0' || $("#birthday").val() == '') {
        alert('Please fill out Birthday');
        document.getElementById('birthday').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('birthday').style.borderColor = "green";
    }
    if ($("#birthplace").val() == null || $("#birthplace").val() == '0' || $("#birthplace").val() == '') {
        alert('Please fill out Birth Place');
        document.getElementById('birthplace').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('birthplace').style.borderColor = "green";
    }

    if ($("#email").val() != '' && !validateEmail($("#email").val())) {
        alert('You\'ve entered invalid email.');
        document.getElementById('email').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('email').style.borderColor = "green";
    }

    if ($("#education_attainment").val() == '') {
        alert('Please fill out Educational Attainment');
        document.getElementById('education_attainment').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('education_attainment').style.borderColor = "green";
    }

    /* if($("#tin").val() == ''){
         alert('Please fill out TIN');
          document.getElementById('tin').style.borderColor = "red";
         return false;
     }
     else{
       document.getElementById('tin').style.borderColor = "green";
     } */

    if ($("#sss").val() == '') {
        alert('Please fill out SSS');
        document.getElementById('sss').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('sss').style.borderColor = "green";
    }

    if ($("#residence_type").val() == null || $("#residence_type").val() == '0' || $("#residence_type").val() == '') {
        alert('Please fill out Residence Type');
        document.getElementById('residence_type').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('residence_type').style.borderColor = "green";
    }

    if ($("#tenurecountyears").val() == '' && $("#tenurecountmonths").val() == '') {
        alert('Please fill out Residence Tenure');
        document.getElementById('tenurecountyears').style.borderColor = "red";
        document.getElementById('tenurecountmonths').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('tenurecountyears').style.borderColor = "green";
    }

    if ($("#marital_status").val() == null || $("#marital_status").val() == '0' || $("#marital_status").val() == '') {
        alert('Please fill out Marital Status');
        document.getElementById('marital_status').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('marital_status').style.borderColor = "green";
    }

    if ($("#company_name").val() == null || $("#company_name").val() == '0' || $("#company_name").val() == '') {
        alert('Please fill out Company Name');
        document.getElementById('company_name').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('company_name').style.borderColor = "green";
    }

    if ($("#existencelengthyears").val() == null || $("#existencelengthyears").val() == '0' || $(
        "#existencelengthyears").val() == '') {
        alert('Please fill out Length of Existence');
        document.getElementById('existencelengthyears').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('existencelengthyears').style.borderColor = "green";
    }

    if ($("#position").val() == null || $("#position").val() == '0' || $("#position").val() == '') {
        alert('Please fill out Rank / Position in Current Job');
        document.getElementById('position').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('position').style.borderColor = "green";
    }

    if ($("#position_status").val() == null || $("#position_status").val() == '0' || $("#position_status").val() ==
        '') {
        alert('Please fill out Status');
        document.getElementById('position_status').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('position_status').style.borderColor = "green";
    }

    if ($("#address_bus").val() == null || $("#address_bus").val() == '0' || $("#address_bus").val() == '') {
        alert('Please fill out Company Address');
        document.getElementById('address_bus').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('address_bus').style.borderColor = "green";
    }

    /* if ($("#zip_bus").val() == null || $("#zip_bus").val() == '0' || $("#zip_bus").val() == '') {
         alert('Please fill out Zip Code');
         document.getElementById('zip_bus').style.borderColor = "red";
         return false;
     } else {
         document.getElementById('zip_bus').style.borderColor = "green";
     } */

    if ($("#years_business").val() == null || $("#years_business").val() == '0' || $("#years_business").val() == '') {
        alert('Please fill out Years of Business');
        document.getElementById('years_business').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('years_business').style.borderColor = "green";
    }

    if ($("#gross_income").val() == null || $("#gross_income").val() == '0' || $("#gross_income").val() == '') {
        alert('Please fill out Gross Income');
        document.getElementById('gross_income').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('gross_income').style.borderColor = "green";
    }

    /*(if ($("#govtid").val() == 0) {
        alert('Please provide one valid ID');
        return false;
    }*/
    /*     if($("#billing").val() == 0){
        alert('Please provide proof of billing');
        return false;
     }
         if($("#selfie").val() == 0){
        alert('Please provide selfie');
        return false;
     }*/
    if (result == false) {
        alert('Please complete References details');
        // document.getElementById("myCheck").click();
        if ($("#r1_customer_name").val() == '') {
            //    alert('Please fill out First Name');
            document.getElementById('r1_customer_name').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r1_customer_name').style.borderColor = "green";
        }
        if ($("#r1_contact_no").val() == '') {
            //    alert('Please fill out First Name');
            document.getElementById('r1_contact_no').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r1_contact_no').style.borderColor = "green";
        }
        if ($("#r1_address").val() == '') {
            document.getElementById('r1_address').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r1_address').style.borderColor = "green";
        }
        if ($("#r1_relationship").val() == '') {
            document.getElementById('r1_relationship').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r1_relationship').style.borderColor = "green";
        }
        if ($("#r2_customer_name").val() == '') {
            //    alert('Please fill out First Name');
            document.getElementById('r2_customer_name').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r2_customer_name').style.borderColor = "green";
        }
        if ($("#r2_contact_no").val() == '') {
            //    alert('Please fill out First Name');
            document.getElementById('r2_contact_no').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r2_contact_no').style.borderColor = "green";
        }
        if ($("#r2_address").val() == '') {
            document.getElementById('r2_address').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r2_address').style.borderColor = "green";
        }
        if ($("#r2_relationship").val() == '') {
            document.getElementById('r2_relationship').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r2_relationship').style.borderColor = "green";
        }
        if ($("#r3_customer_name").val() == '') {
            //    alert('Please fill out First Name');
            document.getElementById('r3_customer_name').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r3_customer_name').style.borderColor = "green";
        }
        if ($("#r3_contact_no").val() == '') {
            //    alert('Please fill out First Name');
            document.getElementById('r3_contact_no').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r3_contact_no').style.borderColor = "green";
        }
        if ($("#r3_address").val() == '') {
            document.getElementById('r3_address').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r3_address').style.borderColor = "green";
        }
        if ($("#r3_relationship").val() == '') {
            document.getElementById('r3_relationship').style.borderColor = "red";
            return false;
        } else {
            document.getElementById('r3_relationship').style.borderColor = "green";
        }
        return false;
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
    $(function () {
        var fileInput = $('.upload-file');
        var maxSize = fileInput.data('max-size');
        $('.upload-form').submit(function (e) {
            if (fileInput.get(0).files.length) {
                var fileSize = fileInput.get(0).files[0].size; // in bytes
                if (fileSize > maxSize) {
                    alert('file size is more than ' + maxSize + ' bytes');
                    return false;
                } else {
                    alert('file size is correct - ' + fileSize + ' bytes');
                }
            } else {
                alert('Please select the file to upload');
                return false;
            }

        });
    });
    //
    var value = $("#contact_no").val();
    //   alert('test');
    //  alert(value);
    if (confirm('Motortrade will now send OTP to ' + value + ' to continue. Proceed?')) {
        otpsend = otpsend + 1;
        //alert(otpsend);
        if (otpsend == 2) {
            $('.get-random').prop('disabled', true);
        }
        if (value.length < 12) {
            alert('Please make sure you put a valid mobile number. Kindly recheck it.');
        } else {
            $('.otpdisplay').css('display', 'block');
            $(".get-random").html("Resend OTP");
            min = Math.ceil(1111);
            max = Math.floor(9999);
            getOTP = Math.floor(Math.random() * (max - min)) + min;
            $('.custom-random').text(getOTP);
            count = count + 1;
            $.ajax({
                type: "POST",
                url: "Loan/sms_sending",
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
                } else {
                    tries = 'tries';
                }
                if (count >= 3) {
                    $("#resending").html("Resend OTP (" + (3 - count) + " " + tries + " left)");
                } else {
                    $("#resending").html(
                        "<a href=\"#\" onclick=\"reSend()\" data-dismiss=\"modal\">Resend OTP (" + (3 -
                            count) + " " + tries + " left)</a>");
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
     }  */

    //
}

function submit() {
    alert('Complaint successfully sent!');
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

//$('#exampleModalCenter').modal('show');
$(".pio").hide();
$("#changeee").click(function () {
    //   alert('test');
    $(".pio").show();
    $(".buttons").hide();
});

$("#create").click(function () {
    $("#proceed").click();
});

$("#testupdate").click(function () {
    //  alert('test');
    $("#validations").css('display', 'none');
    if ($("#updateid").val() == '') {
        alert('Please enter an id.');
        return false;
    }
    else if ($("#updateno").val() == '') {
        alert('Please enter a phone number.');
    }
    else {
        var updateid = $("#updateid").val();
        var updatenum = $("#updateno").val();
        $.ajax({
            type: "POST",
            url: "Loan/getall",
            data: {
                updateid: updateid,
                updatenum: updatenum,
                _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
            },
            beforeSend: function () { }
        }).done(function (data) {
            var ducee = JSON.parse(data);
            if (ducee['formid'] == 'null' || ducee['CurrentStatusId'] != 286 || ducee['contact_no'] == '') {
                alert('This Record cannot be edited. Please contact Branch.');
                return false;
            }
            $("#idses").val(updateid);
            // alert(JSON.stringify(ducee));
            $(".recid").html(ducee.formid);
            $("#idses").val(ducee.formid);
            $("#custses").val(ducee.cust_id);
            $("#spouses").val(ducee.spouse_id);
            $("#busses").val(ducee.employment_id);
            $("#l1ses").val(ducee.loan1_id);
            $("#l2ses").val(ducee.loan2_id);
            $("#l3ses").val(ducee.loan3_id);
            $("#r1ses").val(ducee.ref1_id);
            $("#r2ses").val(ducee.ref2_id);
            $("#r3ses").val(ducee.ref3_id);
            //  alert(ducee.loan_amount);
            document.getElementById('datetime').valueAsDate = new Date();
            $('input').each(function (i, item) {
                $.each(ducee, function (key, val) {
                    //  alert(val);
                    if (item.id == key) {
                        if ($("#" + item.id).is('[type="date"]')) {
                            $("#" + item.id).val(formatDate(val));
                        }
                        else {
                            $("#" + item.id).val(val);
                        }
                    }
                });
            });
            //  document.getElementById('datetime').value = formatDate('May 11,2014');
            $('select').each(function (i, item) {
                $.each(ducee, function (key, val) {
                    //  alert(val);

                    if (item.id == key) {
                        if (key == 'brand') {
                            $("#" + item.id).val(val).change();
                        }
                        else if (key == 'model') {
                            $('#model option[value^=' + val + ']').attr('selected', 'selected');
                        }
                        else {
                            if (val != '') {
                                $("#" + item.id).val(val);
                            }
                        }

                    }
                });
            });
            allTriggers();
            $("#proceed").click();
        });
    }
});

$(document).ready(function () {
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;



    $("#proceed").click(function () {
        // alert('tess');
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({
                    'opacity': opacity
                });
            },
            duration: 600
        });
    });

    $(".previous").click(function () {

        $("#validations").css('display', 'none');

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({
                    'opacity': opacity
                });
            },
            duration: 600
        });
    });

    $('.radio-group .radio').click(function () {
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    $(".submit").click(function () {
        return false;
    })

});


$(document).ready(function(){
    $(document).on('change','#source_fund',function(e){
       
        e.preventDefault();
        var val = $('#source_fund').val();
        
        $('.upload-display').hide();
        if(val == 633){ // Employment
            $('#attach_payslip, #attach_coe, #attach_company_id').show();
            $('#payslip , #coe ,#voucher ,#valid_id , #comapny_id').attr('required','required');
        }
        if(val == 634){// Business /self employed
            $('#attach_permit,#attach_valid_id').show();
            $('#permit ,#valid_id').attr('required','required');
        }
        if(val == 635){// Remittances
            $('#attach_remittance , #attach_valid_id').show();
            $('#remittance ,#valid_id').attr('required','required');
        }
        if(val == 636){// Pension
            $('#attach_statement_account , #attach_valid_id').show();
            $('#statement_account ,#valid_id').attr('required','required');
        }
        if(val == 2139){// OFW / Seaman
            $('#attach_contract , #attach_valid_id').show();
            $('#contract ,#valid_id').attr('required','required');
        }
        if(val == 637){// others 
            $('#attach_proof_income , #attach_valid_id').show();
        }
    })
})