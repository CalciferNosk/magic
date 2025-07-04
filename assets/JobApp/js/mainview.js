// this code for sidevar
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
	arrow[i].addEventListener("click", (e) => {
		let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
		arrowParent.classList.toggle("showMenu");
	});
}

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
// console.log(sidebarBtn);
sidebarBtn.addEventListener("click", () => {
	sidebar.classList.toggle("close");
});

// end code for side var

// code for events and content
$(document).ready(function () {
	var table_applicant = $(".table").DataTable({
		dom: '<"left">frt<"bottom"ip>',
		searching: true,
	});
	table_applicant.order([ 0, "desc" ]).draw();

	$(document).on("click", ".menu-list", function () {
		$(".menu-list").removeClass("active-list");
		$(this).addClass("active-list");
	});
	$(document).on("click", ".view-applicant-result", function () {
		$("#result_chart").html("");
		var app_id = $(this).data("app_id");
		var name = $(this).data("fullname");
		var position = $(this).data("position");
		var date_created = $(this).data("date_created");

		var url = base_url + "getExamResult/" + btoa(app_id);
		$("#result_app_id").text(": " + app_id);
		$("#result_name").text(": " + name);
		$("#result_position").text(": " + position);
		$("#result_created").text(": " + date_created);
		$("#showExamResult").modal("show");
		$("#result_chart").html(
			'<div id="chartContainer"><div id="chartdiv"></div></div>'
		);
		var formData = new FormData();
		formData.append("app_id", app_id);
		formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
		// ajax here
		$.ajax({
			type: "POST",
			url: url,
			data: formData,
			processData: false, // Prevent jQuery from automatically processing the data
			contentType: false, // Set content type to false
			dataType: "json",
			success: function (result) {
				var display_result = result.results.display_result;
				var percentage = result.results.percentage;
				var total_percentage = 0;
				var count_part = 0;
				$.each(display_result, function (key, value) {
					$("#display_part_" + key).html(value);
				});
				$.each(percentage, function (key, value) {
					count_part++;
					total_percentage += value;
					$("#part_" + key + "_result").html(value + "%");
				});
				var grand_result = total_percentage / count_part;
				grand_result = grand_result.toFixed(2);
				$("#overall_result").html(
					"<b>" + result.results.ovarall_percentage + "%</b>"
				);
				if (grand_result > 0) {
					var over_item = 100 - result.results.ovarall_percentage;
					var pie_data = [
						{
							value: result.results.ovarall_percentage,
							category: "Overall Result",
						},
						{ value: over_item, category: "Item Incorrect" },
					];
					$("#overall_display").show();
					piechart(pie_data);
				} else {
					$("#overall_display").hide();
					$("#chartdiv").html("<center>No data found</center>");
				}
			},
			error: function (xhr, status, error) {
				console.error("Ajax request error:", error);
			},
		});
	});
	$(document).on("click", ".link_name , .icon-tab", function () {
		var show = $(this).data("showbar");
		$(".content-display").hide();
		$("#" + show + "_section").show();
	});
	$(document).on("click", "#legend_eye", function () {
		$(".btn-eye").addClass("shake");
		setTimeout(function () {
			$(".btn-eye").removeClass("shake");
		}, 1000);
	});
	$(document).on("click", ".ems-applicant", function () {
		var app_id = $(this).data("app_id");
		var url = base_url + "transferAdmin/" + btoa(app_id);
		Swal.fire({
			title: "Are you sure?",
			text:
				app_id +
				" : This data will be removed after confirmation and transferred to the EMS database.",
			// icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Transfer it!",
		}).then((result) => {
			if (result.isConfirmed) {
				var formData = new FormData();
				formData.append("app_id", 1);
				formData.append(
					"_cmcToken",
					$(`meta[name="_cmcToken"]`).attr("content")
				);
				// Swal.fire({
				// 	title: "This function is under development.",
				// 	text: "Soon it will be available",
				// 	icon: "info",
				// });
				$.ajax({
					type: "POST",
					url: url,
					data: formData,
					processData: false, // Prevent jQuery from automatically processing the data
					contentType: false, // Set content type to false
					dataType: "json",
					success: function (result) {
						console.log(result);
						// if (result == true) {
						// 	$(".td_action_" + app_id).html(
						// 		`<p style="color:green">Completed</p>`
						// 	);
						// 	Swal.fire({
						// 		title: "Transfered!",
						// 		text: "Your file has been transferred to EMS.",
						// 		icon: "success",
						// 	});
						// }
					},
					error: function (xhr, status, error) {
						console.error("Ajax request error:", error);
					},
				});
			}
		});
	});
	$(document).on("click", ".retake-applicant", function () {
		var app_id = $(this).data("app_id");
		var formData = new FormData();
		formData.append("app_id", app_id);
		formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
		Swal.fire({
			title: "Are you sure?",
			text:
				app_id + " : This data will be delete permanently after confirmation",
			// icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Proceed!",
		}).then((result) => {
			if (result.isConfirmed) {
				// $(".tr_" + app_id).remove();
				$.ajax({
					type: "POST",
					url: base_url + "retakeApplicant",
					data: formData,
					processData: false, // Prevent jQuery from automatically processing the data
					contentType: false, // Set content type to false
					dataType: "json",
					success: function (result) {
						if (result == 1) {
							Swal.fire({
								icon: "success",
								title: "Success!",
								text: "Updated successfully.",
							});
							$(".removed_" + app_id).remove();
						} else {
							Swal.fire({
								icon: "error",
								title: "Oops...",
								text: "Something went wrong!",
							});
						}
					},
				});
				// Swal.fire({
				//   title: "Deleted!",
				//   text: "Your file has been deleted.",
				//   icon: "success"
				// });
			}
		});
	});
	$(document).on("click", "#btn_export", function () {
		var url = base_url + "getExamResultAll";
		var formData = new FormData();

		var dateFrom = $("#report_date_from").val();
		var dateTo = $("#report_date_to").val();
		if(dateFrom == "" || dateTo == ""){
			alert("Please select date range");
			return false;
		}

		var fromDate = new Date(dateFrom);
		var toDate = new Date(dateTo);

		if (fromDate > toDate) {
			alert("Date From cannot be ahead of Date To");
			return false;
		} 
		var diffDays =
			Math.abs(toDate.getTime() - fromDate.getTime()) / (1000 * 3600 * 24);

		if (diffDays > 5) {
			alert("Date range cannot be more than 5 days");
			return false;
		} 


		formData.append("auth_export", 1);
		formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
		formData.append("date_from", dateFrom);
		formData.append("date_to", dateTo);
		// ajax here
		$(this)
			.html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>')
			.attr("disabled", true);
		$.ajax({
			type: "POST",
			url: url,
			data: formData,
			processData: false, // Prevent jQuery from automatically processing the data
			contentType: false, // Set content type to false
			dataType: "json",
			success: function (result) {
				console.log(result.data);
				if (result.result == 1) {
					if(result.data.length != 0){
						exportToExcel(result.data, "exam_report_" + result.date_export);
					}
					else{
						alert("No data found");
					}
					
				}
				$("#btn_export")
					.html('<i class="bx bx-export" style="font-size: 20px;"></i>')
					.attr("disabled", false);
			},
			error: function (xhr, status, error) {
				console.error("Ajax request error:", error);
			},
		});
	});
	$(window).on("load", function (e) {
		e.preventDefault();
		applicant_list_builder();
	});
	$(document).on("click", "#search_applicant", function (e) {
		applicant_list_builder();
	});
	$(document).on("click", ".send_email_invite", function () {
		var email = $(this).data("email");
		var app_id = $(this).data("app_id");

		Swal.fire({
			title: "Send Invitation",
			text: "To: " + email,
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Send it!",
		}).then((result) => {
			if (result.isConfirmed) {
				$(".td_send_email_" + app_id).html(
					`<center><span style="color:orange"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span></center>`
				);
				var formData = new FormData();
				formData.append("email", email);
				formData.append("app_id", app_id);
				formData.append(
					"_cmcToken",
					$(`meta[name="_cmcToken"]`).attr("content")
				);
				$.ajax({
					type: "POST",
					url: base_url + "sendEmailInvite",
					data: formData,
					processData: false, // Prevent jQuery from automatically processing the data
					contentType: false, // Set content type to false
					dataType: "json",

					success: function (result) {
						if (result == 1) {
							Swal.fire({
								icon: "success",
								title: "Sent!",
								text: "Your email has been sent.",
							});
							$(".td_send_email_" + app_id).html(
								`<span style="color:green">Invitation Sent </span>`
							);
						} else {
							Swal.fire({
								icon: "error",
								title: "Oops...",
								text: "Something went wrong!",
							});
							$(".td_send_email_" + app_id).html(
								`<button class="btn btn-primary btn-sm send_email_invite" data-email="hermieiglesia74@gmail.com" data-app_id="6191">Send Email</button>`
							);
						}
					},
				});
			}
		});
	});

	$(document).on("submit", "#maintenance_form", function (e) {
		e.preventDefault();
		var form = $(this).get(0);
		var url = base_url + "auth/admin-login";
		var formData = new FormData(form);
		var Maintenance = $("#Maintenance");
		var jpart_1 = $("#jumble_part_1");
		var jpart_2 = $("#jumble_part_2");
		var jpart_3 = $("#jumble_part_3");
		formData.append("Maintenance", Maintenance.is(":checked") ? 1 : 0);
		formData.append("jumble_part_1", jpart_1.is(":checked") ? 1 : 0);
		formData.append("jumble_part_2", jpart_2.is(":checked") ? 1 : 0);
		formData.append("jumble_part_3", jpart_3.is(":checked") ? 1 : 0);
		formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
		maintenace_uodate(formData);
	});
	async function maintenace_uodate(formData) {
		const { value: password } = await Swal.fire({
			title: "Enter your password",
			input: "password",
			inputLabel: "Password",
			inputPlaceholder: "Enter your password",
			inputAttributes: {
				maxlength: "10",
				autocapitalize: "off",
				autocorrect: "off",
			},
		});
		if (password) {
			if (password == "superadmin") {
				$.ajax({
					type: "POST",
					url: base_url + "exam_maintenance",
					data: formData,
					processData: false, // Prevent jQuery from automatically processing the data
					contentType: false, // Set content type to false
					dataType: "json",
					success: function (result) {
						if (result == 1) {
							Swal.fire({
								icon: "success",
								title: "Success!",
								text: "Updated successfully.",
							});
						} else {
							Swal.fire({
								icon: "error",
								title: "Oops...",
								text: "Something went wrong!",
							});
						}
					},
				});
			} else {
			}
		}
	}

	function applicant_list_builder() {
		var url = base_url + "getAllApplicantAPI";
		var formData = new FormData();
		formData.append("date_from", $("#date_from").val());
		formData.append("date_to", $("#date_to").val());
		formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
		$("#applicant_list_table").html(
			'<p class="text-center">Fetching data please wait  <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></p>'
		);
		// ajax here
		$.ajax({
			type: "POST",
			url: url,
			data: formData,
			processData: false, // Prevent jQuery from automatically processing the data
			contentType: false, // Set content type to false
			dataType: "json",
			success: function (result) {
				var table_html = "";
				var table_html = `<table class="table display table-responsive " id="applicant_list_table_view">
									<thead>
										<tr>
											<th>Applicant ID</th>
											<th>Full Name</th>
											<th>Contact</th>
											<th>Applied Date</th>
											<th>Email</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>`;
				$.each(result.result, function (key, value) {
					var dateStr = value.dateApplied;
					var dateObj = new Date(dateStr);
					var options = { month: "long", day: "numeric", year: "numeric" };
					var formattedDate = dateObj.toLocaleDateString("en-US", options);
					var phoneNumber = value.cellphoneNumber;
					var formattedPhoneNumber = phoneNumber.replace(
						/(\d{4})(\d{4})(\d{3})/,
						"$1-$2-$3"
					);
					var isSent =
						value.inviteSent == 1
							? `<span style="color:green">Invitation Sent</span>`
							: `<button class="btn btn-primary btn-sm send_email_invite" data-email="${value.email}" data-app_id="${value.id}">Send Email</button>`;
					table_html += `<tr>
											<td style="width: 10px">${value.id}</td>
											<td style="font-weight: 700;">${value.name}</td>
											<td>${formattedPhoneNumber}</td>
											<td>${formattedDate}</td>
											<td>${value.email}</td>
											<td class="td_send_email_${value.id}"> ${isSent}</td>
										</tr>`;
				});
				table_html += `</tbody>
									</table>`;
				
				$("#applicant_list_table").html(table_html);
				$('#applicant_list_table_view').DataTable();
				
			},
			error: function (xhr, status, error) {
				$("#applicant_list_table").html(
					'<p class="text-center">Connection Error</p>:' + error
				);
				console.log("Ajax request error:", error);
			},
		});
	}

	function progress(progress) {
		var progress = progress;
		$(".progress-bar")
			.css("width", progress + "%")
			.attr("aria-valuenow", progress);
	}

	function exportToExcel(data, fileName) {
		const worksheet = XLSX.utils.json_to_sheet(data);
		const workbook = XLSX.utils.book_new();
		XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");
		XLSX.writeFile(workbook, fileName + ".xlsx");
	}
	function piechart(data) {
		am5.ready(function () {
			// Create root element
			// https://www.amcharts.com/docs/v5/getting-started/#Root_element
			var root = am5.Root.new("chartdiv");
			root._logo.dispose();

			// Set themes
			// https://www.amcharts.com/docs/v5/concepts/themes/
			root.setThemes([am5themes_Animated.new(root)]);

			// Create chart
			// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
			var chart = root.container.children.push(
				am5percent.PieChart.new(root, {
					layout: root.verticalLayout,
					innerRadius: am5.percent(50),
				})
			);
			chart.creditsPosition = "hidden";

			// Create series
			// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
			var series = chart.series.push(
				am5percent.PieSeries.new(root, {
					valueField: "value",
					categoryField: "category",
					alignLabels: false,
				})
			);
			series.get("colors").set("colors", [
				am5.color("#16b200"), // Green
				am5.color("#ff4040"), // Red
			]);
			series.labels.template.setAll({
				textType: "circular",
				centerX: 0,
				centerY: 0,
			});

			// Set data
			// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
			series.data.setAll(data);

			// Create legend
			// https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
			var legend = chart.children.push(
				am5.Legend.new(root, {
					centerX: am5.percent(50),
					x: am5.percent(50),
					marginTop: 15,
					marginBottom: 15,
				})
			);

			legend.data.setAll(series.dataItems);

			// Play initial series animation
			// https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
			series.appear(1000, 100);
		}); // end am5.ready()
	}
});
