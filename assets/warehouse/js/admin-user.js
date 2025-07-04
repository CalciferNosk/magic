$(document).ready(function () {
	// $(window).on("load", function () {
	// 	console.log("location loaded");

		fetchUsers();
	// });

	$(document).on("click", "#add_user", function () {});

	$(document).on("click", ".change-access", function () {
		var column = $(this).data("column");
		var checked = $(this).prop("checked");
		var id = $(this).data("controlid");

		Swal.fire({
			title: "Change Access ? Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, change it!",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					url: base_url + "change-access",
					data: {
						_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
						column: column,
						id: id,
						value: checked ? 1 : 0,
					},
					dataType: "json",
					success: function (response) {
						if (response == 1) {
							Swal.fire({
								title: "Success!",
								text: "Access has been changed.",
								icon: "success",
							});
                            setInterval(function () {
                                location.reload();
                            },1500)
						}
					},
				});
			} else {
				return false;
			}
		});
	});

	$(document).on("click", "#supplying_plant_save", function () {
		var supplying_access = [];
		var controlid = $(this).data("controlid");
		$.each($(".supplying_access_check:checked"), function (i, field) {
			supplying_access.push(field.value);
		});
        if(supplying_access.length == 0){
            alert("Please select Supplying Access");
            return false
        }
		Swal.fire({
			title: "Modify Supplying Access ? Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					url: base_url + "change-supplying-access",
					data: {
						_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
						controlid: controlid,
						supplying_access: supplying_access ,
					},
					dataType: "json",
					success: function (response) {
						if (response == 1) {
							Swal.fire({
								title: "Success!",
								text: "Access has been changed.",
								icon: "success",
							});
                            setInterval(function () {
                                location.reload();
                            },1500)
						}
					},
				});
			} else {
				return false;
			}
		});
	});

	$(document).on("click", "#tab_access_save", function () {

		var tab_access = [];
		var controlid = $(this).data("controlid");
		$.each($(".tab_access_check:checked"), function (i, field) {
			tab_access.push(field.value);
		});

		console.log(tab_access,'-',controlid);
        if(tab_access.length == 0){
            alert("Please select tab Access");
            return false
        }

		Swal.fire({
			title: "Modify Tab Access ? Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					url: base_url + "change-tab-access",
					data: {
						_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
						controlid: controlid,
						tab_access: tab_access ,
					},
					dataType: "json",
					success: function (response) {
						if (response == 1) {
							Swal.fire({
								title: "Success!",
								text: "Access has been changed.",
								icon: "success",
							});
                            setInterval(function () {
                                location.reload();
                            },1500)
						}
					},
				});


			} else {
				return false;
			}
		});
	})
	$(document).on("click", ".user-edit", function () {
		//data control
		var datas = JSON.parse(atob($(this).data("datas")));
        console.log(datas);
		$("#supplying_plant_save").attr("data-controlid", datas.id);
		$("#tab_access_save").attr("data-controlid", datas.id);
		$("#userActionModalLabel").text(datas.EmployeeName);

		var content = `
                        <div class="form-check form-switch">
                            <input class="form-check-input change-access" type="checkbox" data-controlid="${
															datas.id
														}" data-column="ChangeStatus" role="switch" id="change_status_function" ${
			datas.ChangeStatus == 1 ? "checked" : ""
		} />
                            <label class="form-check-label" for="change_status">Change Status</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input change-access" type="checkbox" data-controlid="${
															datas.id
														}" data-column="Edit" role="switch" id="edit_function" ${
			datas.Edit == 1 ? "checked" : ""
		} />
                            <label class="form-check-label" for="edit_function">Edit</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input change-access" type="checkbox" data-controlid="${
															datas.id
														}" data-column="Create" role="switch" id="create_function" ${
			datas.Create == 1 ? "checked" : ""
		} />
                            <label class="form-check-label" for="create_function">Create</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input change-access" type="checkbox" data-controlid="${
															datas.id
														}" data-column="Upload" role="switch" id="upload_function" ${
			datas.Upload == 1 ? "checked" : ""
		} />
                            <label class="form-check-label" for="upload_function">Upload</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input change-access" type="checkbox" data-controlid="${
															datas.id
														}" data-column="ListView" role="switch" id="list_view" ${
			datas.ListView == 1 ? "checked" : ""
		} />
                            <label class="form-check-label" for="list_view">ListView</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input change-access" type="checkbox" data-controlid="${
															datas.id
														}" data-column="Deletedflag" role="switch" id="deleted_flag" ${
			datas.Deletedflag == 1 ? "checked" : ""
		} />
                            <label class="form-check-label" for="deleted_flag">Active/Inactive User</label>
                        </div>`;
		$("#user_control_content").html(content);
		//end data control

		//for supplying plant access
		var supplying_array = ["1001","1002","6001","3001","6002","3002"];
		var supplying_access = datas.SupplyingCode;
		var div_supplying = '<div class="row">';
		$.each(supplying_array, function (key, value) {
			div_supplying += `<div class="form-check col-md-4">
                            <input class="form-check-input supplying_access_check" type="checkbox" name="supplying_value[]" value="${value}" id="${value}"  ${
				supplying_access.includes(value) ? "checked" : ""
			}/>
                            <label class="form-check-label" for="flexCheckDefault">${value}</label>
                        </div>`;
		});
		div_supplying += "</div>";
		$("#supplying_plant_content").html(div_supplying);

		//end supplying plant access


		//tab access
		var tab_array = ["1","2","3","4","5"];
		var tab_access = datas.TabView;
		var div_TabView = '<div class="row">';
		$.each(tab_array, function (key, value) {
			div_TabView += `<div class="form-check col-md-4">
                            <input class="form-check-input tab_access_check" type="checkbox" name="supplying_value[]" value="${value}" id="${value}"  ${
								tab_access.includes(value) ? "checked" : ""
			}/>
                            <label class="form-check-label" for="flexCheckDefault">${convertToTabName(value)}</label>
                        </div>`;
		});
		$("#tab_access_content").html(div_TabView);
		//dispaly modal for user control
		$("#userActionModal").modal("show");
	});

	function convertToTabName(id){

		switch(id){
			case "1":
					return "Upload";
				break;
			case "2":
					return "Inventory";
				break;
			case "3":
					return "Barcode Checker";
			case "4":
					return "Pick Release Form";
				break
			case "5":
					return "Release List";
				break
			default:
					return "--";
				break
		}
	}

	function fetchUsers() {
        // fetch all usern in control
		showLoadingOverlay()
		$.ajax({
			type: "post",
			url: base_url + "warehouse-users",
			data: {
				_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
				get: 1,
			},
			dataType: "json",
			success: function (response) {
				var tr = "";
				$.each(response, function (key, value) {
					tr += `<tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="./assets/warehouse/images/default.png" class="rounded-circle" alt="" style="width: 45px; height: 45px" />
                                                <div class="ms-3">
                                                    <p class="fw-bold mb-1">${
																											value.EmployeeName
																										}</p>
                                                    <p class="text-muted mb-0">${
																											value.Email
																										}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="fw-normal mb-1">${
																							value.Position
																						}</p>
                                            <p class="text-muted mb-0">${
																							value.Tag
																						}</p>
                                        </td>
                                        <td>
                                            <span class="badge ${
																							value.Deletedflag == 1
																								? "badge-danger"
																								: "badge-success"
																						} rounded-pill d-inline"> ${
						value.Deletedflag == 1 ? "Inactive" : "Active"
					}</span>
                                        </td>
                                        <td id="supplying_code_${value.id}">${value.SupplyingCode}</td>
                                        <td>
                                            <button data-id="${
																							value.id
																						}" data-datas="${btoa(
						JSON.stringify(value)
					)}"
                                                type="button"
                                                class="btn btn-link btn-rounded btn-sm fw-bold user-edit"
                                                data-mdb-ripple-color="dark">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>`;
				});

				$("#user_list_body").html(tr);
				$("#user_list_table").DataTable();
				hideLoadingOverlay()
			},
		});
	}
});
