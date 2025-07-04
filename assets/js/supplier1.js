var ct = 0;
var ku = 0;

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function rereremove() {
    //   alert(ct);
    $('.remove-file').click(function () {
        //  alert('test');

        // ct = ct - 1;
        //alert(ct);
        $('#attcount').val(ct);
        var remid = $(this).attr('id');
        var remfin = remid.replace('rem', '');
        //alert(remfin);
        $("#grp" + remfin).remove();
        //var cat = $('#attcount').val();
        //alert(ct);

    });
    $('.upload-file').on("change", function (e) {
        var fileid = $(this).attr('id');
        //alert(fileid);
        var fileName = document.getElementById(fileid).files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
        nextSibling.style.color = 'black'
    });

    $('.upload-file').click(function () {
        var fileid = $(this).attr('id');
        $('#' + fileid).val(null);
        $('#' + fileid).html(
            '<span style="color:gray">Upload File</span>');
    });
}

function reremove() {
    $('.remove-file').click(function () {
        if (confirm('This will remove existing attachment. Proceed?')) {
            var remid = $(this).attr('id');
            var remfin = remid.replace('remm', '');
            $.ajax({
                type: "POST",
                url: "Supplier/deleteattach",
                data: {
                    remfin: remfin,
                    _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                },

                beforeSend: function () { }
            }).done(function (data) {
                $("#grpp" + remfin).remove();
            });
        }
    });
}
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

function onlyNumberKey(evt) {

    // Only ASCII charactar in that range allowed
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}


$('.ajax-loader').addClass('d-none').removeClass("d-flex");

$(document).ajaxStart(function () {
    $('.ajax-loader').removeClass('d-none').addClass("d-flex");
})
    .ajaxComplete(function () {
        $('.ajax-loader').addClass('d-none').removeClass("d-flex");
    });

$(".number").on('input', function () {
    //alert('test');
    var number = $(this).val().replace(/[^\d]/g, '')
    if (number.length == 11) {
        number = number.replace(/(\d{4})(\d{5})/, "$1-$2");
    }
    $(this).val(number);
});


function allTriggers() {

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

var error = 0;

$('.proceedform').click(function () {

    var nameproceed = $(this).attr('name');
    $("#msform").append('<input type="text" name ="buttontype" value="' + nameproceed + '" />');
    var numItems = $('.yourclass').length
    var isValid = true;
    $('.yourclass').each(function () {
        if ($(this).val() === '')
            isValid = false;
    });
    if (isValid == false) {
        alert('Please fill out all added attachments.');
        return false;
    }
    else {
        $("#msform").submit();
    }
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

var tabthree = ["source_fund", "salary", "business_income", "other_income", "gross_income", "idses", "busses", "spouses"]
var reqthree = ["source_fund", "source_income"]

var tabtwo = ["maiden_name", "no_children", "nationality",
    "birthday", "age", "birthplace", "education_attainment",
    "tin", "sss_gsis", "presentaddress", "address", "tenurecountyears", "tenurecountmonths", "sameadd", "permanentaddress", "address_sub", "previousaddress", "address_prev", "facebook", "instagram", "other_social", "home_tel", "home_fax", "dependent", "residence_type", "marital_status",
    "seperated_years", "widow_years", "spousefname", "spousemname", "spouselname", "spousenname", "spouse_nationality", "spouse_birthday", "spouse_age", "spouse_contact", "spouse_telno", "spouse_address", "spouse_birthplace",
    "borrower_type", "borrower_nature", "borrower_size", "company_name", "existencelengthyears", "existencelengthmonths", "position", "position_status", "register", "busaddress", "address_bus", "nature_work", "telephone_no", "previous_email", "years_business", "previous_employer_name", "previous_employer_telno", "previous_employer_street", "previous_employer_address", "previous_job", "previouslengthyears", "previouslengthmonths", "monthly_income", "monthly_provision",
    "idses", "custses", "sameaddindi", "busses", "spouses"]
var reqtwo = ["birthday", "age", "birthplace", "education_attainment", "presentaddress", "address",
    "tenurecountyears", "tenurecountmonths", "residence_type", "marital_status", "borrower_type",
    "company_name", "existencelengthyears", "existencelengthmonths", "position", "position_status", "busaddress", "address_bus", "years_business"]

var reqone = ["SupplierName", "SupplierCode", "ContactPerson", "Email", "ContactNumber", "TaxTypeId", "TypeOfOwnershipId", "TIN", "presentaddress", "Street", "PrevCompanyName", "NatureOfBusiness", "TotalBusinessYears", "LandlineNo", "Remarks", "OfficialWebsiteAddress"]
var tabone = ["SupplierName", "SupplierCode", "ContactPerson", "Email", "ContactNumber", "TaxTypeId", "TypeOfOwnershipId", "TIN", "presentaddress", "Street", "PrevCompanyName", "NatureOfBusiness", "TotalBusinessYears", "LandlineNo", "Remarks", "OfficialWebsiteAddress"]

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

function decodeEntities(encodedString) {
    var textArea = document.createElement('textarea');
    textArea.innerHTML = encodedString;
    return textArea.value;
}

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
            alert('Form Sent. Your Record Id is ' + duce.id + '. Thank you for choosing Motortrade Group.');
            $('#exampleModal').modal('hide');
            $('#oneproc').click();
            sessionStorage.setItem("id", duce.id);
            sessionStorage.setItem("customer_id", duce.customer_id);
            $(".recid").html(sessionStorage.getItem("id"));
            $("#idses").val(sessionStorage.getItem("id"));
            $("#custses").val(sessionStorage.getItem("customer_id"));
        });
    }
    else {
        $("#" + tabno).click(function () {
            var arr = [];
            var obj = {};


            //alert(reqtwo);
            array.forEach(function (value) {
                window[value] = $("#" + value).val();
                obj[value] = window[value];
            });

            req = allAdjustments(tabno, req);
            var rv = true;
            obj._cmcToken= $(`meta[name="_cmcToken"]`).attr("content");

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
                        if (value == 'presentaddress' && $("#psgccheck").is(':checked')) {
                        }
                        else {
                            //  alert('Please fill out First Name');
                            document.getElementById(value).style.borderColor = "red";
                            $("#" + value).siblings(".select2-container").css('border', '0.5px solid red');
                            rv = false;
                        }
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
                if ($('#myChecked').prop("checked") == false) {
                    alert('Please check the Privacy Statement to proceed.');
                    return false;
                }
                if ($('#msform').data('formstate') == 0) {
                    alert("Please Check The I'm not a robot!");
                    return false;
                }


                if ($("#idses").val() == '') {
                    alert('joke');
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
                    if (confirm('Motortrade will now send OTP to ' + value + ' to continue. Proceed?')) {
                        otpsend = otpsend + 1;
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
                                url: "Supplier/sms_sending",
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
                                // alert(data);
                                //  alert('OTP has been sent to '+ value +' Please enter the code in the box provided or click the Resend button to resend (up to 2 times only).');
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
                }
                else {
                    if ($("#Email").val() != '' && !validateEmail($("#Email").val())) {
                        alert('You\'ve entered invalid email.');
                        return false;
                    }
                    var valued = $("#ContactNumber").val();
                    if (valued.length < 12 || valued.substring(0, 2) != '09') {
                        alert('Please make sure you put a valid mobile number. Kindly recheck it.');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: "Supplier/tabotp",
                        data: obj,

                        beforeSend: function () { }
                    }).done(function (data) {
                        $('#oneproc').click();
                    });

                }
            }
            else {
                $.ajax({
                    type: "POST",
                    url: "Supplier/" + tabno,
                    data: obj,

                    beforeSend: function () { }
                }).done(function (data) {
                    alert(data);
                });
            }
        });
    }
}
var num = 1;

$("#attachadd").click(function () {
    $("#addatt").append('<div class="input-group" id="grp' + num + '"><div class="custom-file"><input type="file" class="custom-file-input upload-file yourclass" id="' + num + '" data-max-size="2048" name="add' + num + '" accept="image/jpeg, image/png, application/pdf," aria-describedby="' + num + '" required><label class="custom-file-label" id="' + num + 'lab" for="add' + num + '" style="color:gray">Upload File</label></div><div class="input-group-append"><button type="button" id="rem' + num + '" class="remove-file"><i class="fa fa-times" aria-hidden="true"></i></button></div></div>');
    num++;
    ct++;
    $('#attcount').val(ct);
    rereremove();
});

$("#testupdate").click(function () {
    if ($("#updateid").val() == '') {
        alert('Please enter Supplier Code.');
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
            url: "Supplier/getall",
            data: {
                updateid: updateid,
                updatenum: updatenum,
                _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
            },

            beforeSend: function () { }
        }).done(function (data) {

            if (data == '' || data == 'null') {
                alert('Please enter valid Supplier Code/Mobile Number.');
                return false;
            }

            if (updatenum.length < 12 || updatenum.substring(0, 2) != '09') {
                alert('Please make sure you put a valid mobile number. Kindly recheck it.');
                return false;
            }

            var ducee = JSON.parse(data);

            if (ducee.CurrentStatusId == '831') {
                alert('This Record cannot be edited. Please contact Branch.');
                return false;
            }

            if (ducee.CurrentStatusId == '748') {
                alert('The data for this account has been already completed. Please contact purchasing for concern.');
                return false;
            }

            $(".recid").html(ducee.SupplierCode);

            $('input').each(function (i, item) {
                console.log(item)
                $.each(ducee, function (key, val) {
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

            $('select').each(function (i, item) {
                $.each(ducee, function (key, val) {
                    if (item.id == key) {
                        if (val != '') {
                            $("#" + item.id).val(val);
                        }
                    }
                });
            });

            $('.summernote').summernote('code', decodeEntities(ducee['Remarks']));

            var formid = ducee['id'];

            $.ajax({
                type: "POST",
                url: "Supplier/getfiles",
                data: {
                    formid: formid,
                    _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                },

                beforeSend: function () { }
            }).done(function (data) {
                var duceet = JSON.parse(data);

                $.each(duceet, function (key, val) {
                    $.each(val, function (k, v) {
                        if (k == 'id') {
                            duceid = v;
                        }
                        if (k == 'Label') {
                            $("#curatt").append('<div class="input-group" id="grpp' + duceid + '"><div class="custom-file"><input type="file" class="custom-file-input upload-file disabledfile" id="' + duceid + '" data-max-size="2048" name="' + duceid + '" accept="image/jpeg, image/png, application/pdf," aria-describedby="' + duceid + '" disabled><label class="custom-file-label" id="' + duceid + 'lab" for="' + duceid + '" style="color:gray">' + v + '</label></div><div class="input-group-append"><button type="button" id="remm' + duceid + '" class="remove-file"><i class="fa fa-times" aria-hidden="true"></i></button></div></div>');
                        }
                    });

                });
                reremove();

                $("#proceed").click();
            });
        });


    }

});

$(document).ready(function () {
    $('#psgccheck').change(function () {
        if (this.checked) {
            $("#psgcshow").css("display", "none");
        }
        else {
            $("#psgcshow").removeAttr('style');
        }
    });
    var editor = $('.summernote');
    editor.summernote({
        toolbar: false
    });

    $(".previous").click(function () {

        // $("#validations").css('display', 'none');

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
});