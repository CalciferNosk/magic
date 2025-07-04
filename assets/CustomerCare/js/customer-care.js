$(document).ready(function () {
	// select2
	$("#category,#branch").select2({
		theme: "bootstrap-5",
		width: $(this).data("width")
			? $(this).data("width")
			: $(this).hasClass("w-100")
			? "100%"
			: "style",
		placeholder: $(this).data("placeholder"),
	});

	$(".testregion").select2({
		placeholder: "Please select Region, Province, Municipality, Barangay",
		maximumSelectionLength: 1,
		minimumInputLength: 3,
		allowclear: true,
		multiple: true,
		ajax: {
			url: "inquiry/find_psgc",
			type: "post",
			dataType: "json",
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
		},
	});

	// additional deatails
	$(document).on("change", "#category", function () {
		var group = $(this).find(":selected").data("group");

		if (group == "Pre Sales" || group == "Products") {
			$("#additionalDetails").html(`
                <div class="mb-3">
                    <label class="title-label" for="date_applied" class="form-label">Date applied<span style="color:red">*</span></label>
                    <input type="date" class="form-control" name="date_applied" id="date_applied" placeholder="Enter your firstname">
                </div>
            `);
		}
		if (group == "After Sales") {
			$("#additionalDetails").html(`
                <div class="mb-3">
                    <label class="title-label" for="engine" class="form-label">Engine Number<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="engine" id="engine" placeholder="Enter your Engine Number">
                </div>
            `);
		}
	});

	// validate mobile
	$("#mobile_number").on("keyup", function () {
		var input = $("#mobile_number").val();
		if (/[a-zA-Z]/.test(input) == true) {
			showToast("Invalid Format.");
			$("#mobile_number").val("");
			return false;
		}
		if (input.charAt(0) != 9) {
			showToast("Please Check mobile format start with 9XXXXXXXXX");
			$("#mobile_number").val("");
			return false;
		}
	});

	//on submit validation
	$("#customerCareForm").on("submit", function (e) {
		e.preventDefault();
		var mobile = $("#mobile_number").val();
		var category = $("#category").val();
		var branch = $("#branch").val();
		var customerCareDetails = $("#customerCareDetails").val();
		var customer_fname = $("#customer_fname").val();
		var customer_lname = $("#customer_lname").val();
		var email = $("#email").val();
		var group = $("#category").find(":selected").data("group");
		var date_applied = $("#date_applied").val();
		var engine = $("#engine").val();

		if (category == "" || category == null) {
			showToast("Please select Category");
			// alert('Please select Category');
			return false;
		}
		if (branch == "" || branch == null) {
			showToast("Please select Branch");
			return false;
		}
		if (customerCareDetails == "" || customerCareDetails == null) {
			showToast("Please enter Customer Care Details");
			return false;
		}

		if (group == "Pre Sales" || group == "Products") {
			if (date_applied == "" || date_applied == null) {
				showToast("Please enter Date Applied");
				return false;
			}
		} else if (group == "After Sales") {
			if (engine == "" || engine == null) {
				showToast("Please enter Engine Number");
				return false;
			}
		}

		if (customer_fname == "" || customer_fname == null) {
			showToast("Please enter First Name");
			return false;
		}
		if (customer_lname == "" || customer_lname == null) {
			showToast("Please enter Last Name");
			return false;
		}
		if (email == "" || email == null) {
			showToast("Please enter Email");
			return false;
		}

		if (mobile == "" || mobile == null) {
			showToast("Please enter Mobile Number");
			$(this).focus();
			return false;
		}

		if (mobile.length < 10) {
			showToast("Please Check Mobile Number");
			return false;
		}

		//recapcha check and data privacy
		if ($("#data_privacy").is(":checked") == false) {
			showToast("Please check the Privacy Statement to proceed.");
			return false;
		}
		if (isCaptchaChecked()) {
			console.log("recaptcha checked");
		} else {
			showToast("Please validate Captcha to see if you're not a robot");
			return false;
		}

		Swal.fire({
			title: "Proceed To Verification?",
			text: "We will send OTP to your mobile number.",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Proceed!",
		}).then((result) => {
			if (result.isConfirmed) {
				//check if otp is sent
				if (sendOTPCall(mobile) == false) {
					showToast("Invalid Mobile Number");
					return false;
				}
				$("#otp_mobile_display").text("+63" + mobile);
				$("#OTPModal").modal("show");
				$("#otp_style").html(
					`<style> body{background-color:red}.height-100{height:100vh}.card{width:400px;border:none;height:300px;box-shadow: 0px 5px 20px 0px #d2dae3;z-index:1;display:flex;justify-content:center;align-items:center}.card h6{color:red;font-size:20px}.inputs input{width:40px;height:40px}input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button{-webkit-appearance: none;-moz-appearance: none;appearance: none;margin: 0}.card-2{background-color:#fff;padding:10px;width:350px;height:100px;bottom:-50px;left:20px;position:absolute;border-radius:5px}.card-2 .content{margin-top:50px}.card-2 .content a{color:red}.form-control:focus{box-shadow:none;border:2px solid red}.validate{border-radius:20px;height:40px;background-color:red;border:1px solid red;width:140px}</style>`
				);
			}
		});
	});

	// otp validation and save
	$(document).on("click", "#validate_btn", function () {
		var first = $("#first").val();
		var second = $("#second").val();
		var third = $("#third").val();
		var fourth = $("#fourth").val();
		var fifth = $("#fifth").val();
		if (
			first   == "" ||
			second  == "" ||
			third   == "" ||
			fourth  == "" ||
			fifth   == ""
		) {
			showToast("Please Complete OTP");
			return false;
		}
		var otp = first + second + third + fourth + fifth;

		var formData = new FormData($("#customerCareForm").get(0));
		formData.append(`otp`, otp);
		formData.append(`dissatisfied_link`,disatisfied_link)
		formData.append(`option_val`,option_val)
		formData.append(`_cmcToken`, $(`meta[name="_cmcToken"]`).attr("content"));
		$.ajax({
			type: "POST",
			url: base_url + "otp/validate",
			data: formData,
			contentType: false,
			processData: false,
			dataType: "json",
			beforeSend: function () {
				$("#validate_btn").attr("disabled", true);
			},
			success: function (response) {
				if (response.code == 101) {
					showToast(response.result);
					$("#first,#second,#third,#fourth,#fifth").val("");
					$("#validate_btn").attr("disabled", false);
				} else if (response.code == 0) {
					showToast(response.result);
				} else if (response.code == 104) {
					showToast(response.result);
					setInterval(function () {
						window.location.reload();
					}, 3000);
				} else if (response.code == 400) {
					showToast("Error: Please try again. If problem persists, contact support.");
				}
				else if (response.code == 1) {
					showToastSuccess(response.result);
					Swal.fire({
						title: "Thank you for Choosing Motortrade ",
						text: `ID#${response.id} is your reference no.`,
					}).then((result) => {
						/* Read more about isConfirmed, isDenied below */
						$("#OTPModal").modal("hide");
						Swal.fire({
							position: "top-end",
							icon: "success",
							title: "Your work has been saved",
							showConfirmButton: false,
							timer: 1500,
						});
						setInterval(function () {
							// location.href = "http://172.0.0.22:8080/cportal"; // staging testing
							// location.href = "http://172.0.3.98/cportal_support/customer/"; //local testing
							location.href = survey_link + "?branch="+response.branch + 'customercare=1';
						}, 2000);
					});
				}
			},
		});
	});

	// otp auto next if filled
	$(".rounded").on("keyup", function () {
		if ($(this).val().length == 1) {
			$(this).next().focus();
		}
	});

	// resend
	$(document).on("click", "#resend", function () {
		var mobile = $("#mobile_number").val();
		var count = $(this).data("count");
		$(this).attr("data-count", count + 1);
		$(this).text(`Resend(${count + 1}/3)`);
		if (count > 3) {
			return false;
		}
		sendOTPCall(mobile);
	});

	// functions
	function showToast(message) {
		Toastify({
			text: message,
			duration: 2000,
			destination: "https://github.com/apvarun/toastify-js",
			newWindow: true,
			// close: true,
			gravity: "top", // `top` or `bottom`
			position: "right", // `left`, `center` or `right`
			stopOnFocus: true, // Prevents dismissing of toast on hover
			style: {
				background: "linear-gradient(to right, #931c1c, #fb7575)",
			},
			onClick: function () {}, // Callback after click
		}).showToast();
	}
	function showToastSuccess(message) {
		Toastify({
			text: message,
			duration: 2000,
			destination: "https://github.com/apvarun/toastify-js",
			newWindow: true,
			// close: true,
			gravity: "top", // `top` or `bottom`
			position: "right", // `left`, `center` or `right`
			stopOnFocus: true, // Prevents dismissing of toast on hover
			style: {
				background: "linear-gradient(to right, #00811b, #3c894d)",
			},
			onClick: function () {}, // Callback after click
		}).showToast();
	}

	function isCaptchaChecked() {
		return grecaptcha && grecaptcha.getResponse().length !== 0;
	}

	function validatePhoneNumber(input_str) {
		var re = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;

		return re.test(input_str);
	}

	function sendOTPCall(mobile) {
		$("#validate_btn").attr("disabled", false);
		if (mobile == "") {
			return false;
		}
		$.ajax({
			type: "POST",
			url: base_url + "otp/send",
			data: {
				value: mobile,
				_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
			},

			beforeSend: function () {},
			success: function (data, textStatus, error) {},
		});
	}




		$('#customer_fname , #customer_mname , #customer_lname').keydown(function (e) {
		
		  if (e.shiftKey || e.ctrlKey || e.altKey) {
		  
			e.preventDefault();
			
		  } else {
		  
			var key = e.keyCode;
			
			if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
			
			  e.preventDefault();
			  
			}
	  
		  }
		  
		});
		
	  
});
