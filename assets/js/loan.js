$(".number").on('input', function () {
    //alert('test');
    var number = $(this).val().replace(/[^\d]/g, '')
    if (number.length == 11) {
        number = number.replace(/(\d{4})(\d{5})/, "$1-$2");
    }
    $(this).val(number);
});

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
if (((getUrlParameter('source') == null) && (getUrlParameter('cluster') == null)) || (getUrlParameter('source') == null)) {
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
    var submitBtn = document.getElementById("text");
    clearBtn.addEventListener("click", function (e) {
        clearCanvas();
        sigText.innerHTML = "Data URL for your signature will go here!";
        sigImage.setAttribute("src", "");

    }, false);
    submitBtn.addEventListener("click", function (e) {
        var dataUrl = canvas.toDataURL();
        //alert(dataUrl);
        sigText.innerHTML = dataUrl;
        sigImage.setAttribute("src", dataUrl);
    }, false);

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
            },
            cache: true
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

var error = 0;
$('#submitModal').click(function () {
    if ($('#hiddenOTP').val() == $('#otp-input').val()) {
        // alert('Form sent. Thank you for choosing Motortrade Group.');

        document.getElementById("myCheck").click();
        $("#modalfin").html('');
        $('button').prop('disabled', true);
        $('submit').prop('disabled', true);
    } else {
        alert('You\'ve entered incorrect OTP code.');
        error += 1;
        if (error >= 3) {
            $('#submitModal').prop('disabled', true);
            location.reload(true);
        }
    }
});
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
    var salary = $("#salary").val();
    var business_income = $("#business_income").val();
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
    var totalincome = parseInt(salary) + parseInt(business_income) + parseInt(other_income);
    $("#gross_income").val(totalincome);
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
    //alert('test');
    //alert($("#marital_status option:selected" ).text());
    if ($("#marital_status option:selected").text() == 'Married') {
        $(".Married").css("display", "block");
        $(".Divorced").css("display", "none");
        $(".Widowed").css("display", "none");
    }
    else if ($("#marital_status option:selected").text() == 'Live-in') {
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
    var labell = $(this.options[this.selectedIndex]).closest('optgroup').prop('label');
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
    var checkAdd = document.getElementById("sameadd");
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

    if ($("#customer_fname").val() == '') {
        alert('Please fill out First Name');
        document.getElementById('customer_fname').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('customer_fname').style.borderColor = "green";
    }

    /*   else if($("#middle_name").val() == ''){
        alert('Please fill out Middle Name');
    } */
    if ($("#customer_lname").val() == '') {
        alert('Please fill out Last Name');
        document.getElementById('customer_lname').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('customer_lname').style.borderColor = "green";
    }

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

    if (!validateEmail($("#email").val())) {
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

    if ($("#zip_bus").val() == null || $("#zip_bus").val() == '0' || $("#zip_bus").val() == '') {
        alert('Please fill out Zip Code');
        document.getElementById('zip_bus').style.borderColor = "red";
        return false;
    } else {
        document.getElementById('zip_bus').style.borderColor = "green";
    }

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

    if ($("#govtid").val() == 0) {
        alert('Please provide one valid ID');
        return false;
    }
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

function submit() {
    alert('Complaint successfully sent!');
}