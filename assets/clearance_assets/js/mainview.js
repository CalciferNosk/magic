$(document).ready(function () {
	
	$(document).on('click','.helper_question',function(){
		console.log('here')
	$('#helpermodal').modal('toggle')
})
	// $(window).resize(function() {
	// if ($(window).width() < 990) {
	// 	$("#modal-size-comment").css("margin-left", "1px ");
	// 	$("#modal-size-settings").css("width", "100%");
	// } else {
	// 	$("#modal-size-comment").css("margin-left", "66% ");
	// 	$("#modal-size-settings").css("width", "40%");
	// 	// $('.sorting_asc').css('width','0px');
	// }
	// });

	$(document).on('click','.exit_interview_directory',function(){
		var access_id = $(this).data('id');
		window.open(base_url + 'exit-interview?id=' + access_id,'framename')
		// location.href= ;

	})
	
	
	//click row
	$(document).on("click", ".data-tr-td", function () {
		var clearance_id = $(this).data("id");
		var desc = $(this).data("desc") == null ? '--': $(this).data("desc");
		var remarks = $(this).data("remarks") == null ? '--': $(this).data("remarks");
		var title = $(this).data("title") == null ? '--': $(this).data("title");
		var status_name = $(this).data('status');
		var interview = $(this).data('interview')
		// console.log(title.split(" ").includes("Interview"))

		if(title.split(" ").includes("Interview") == true){
				if(interview == 0){
					$('#exit-interview').html('<div class="row"><div class="col-md-5 col-sm-6"><button class="exit_interview_directory btn btn-danger" data-id="' + clearance_id + '" >Exit Interview Form </button></div><div class="col-md-7 col-sm-6"> <i id="interview_mssg" style="color:red;position:relative;right:30px">Please Click the Exit Interview Form Button and accomplish the form to proceed with the clearance.</i></div></div>')
				}
				else{
					$('#exit-interview').html('<button class="done-btn btn btn-secondary"  >Exit Interview Form </button> <i style="color:green;">Already Answered!</i>')
				}
			
		} 
		else{
			$('#exit-interview').html('')
		}

		if($(this).data('status') == 'CLEARED' ){
			$('#comment-text').attr('disabled',true)
			$('#comment-text').attr('placeholder','This chat is disabled....')
		}
		else{
			$('#comment-text').removeAttr('disabled');
		}
		 
		$("#staticBackdropLabel").text(title);
		$("#clearance_id").val(clearance_id);
		$("#comment-section").html("");
		$('#current-status').text(status_name)
		
		if(status_name == "PENDING BY EMPLOYEE"){
			$('#status-comment').show()
		}else{
			$('#status-comment').hide()
		}
		
		$('#desc-comment').text(desc)
		$('#remarks-comment').text(remarks)

		loadComment(clearance_id);
	});
	//click row end

	// close modal
	$('#close-mdl').on('click',function(){
		var comment_reload = localStorage.getItem("reload_comment");
			console.log(comment_reload)
		if(comment_reload == 1){
			location.reload();
		}
		
	})
	// end close modal

	 // change status
	$('#close-change-status').on('click',function(){
		
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
			  confirmButton: 'btn btn-success',
			  cancelButton: 'btn btn-danger'
			},
			buttonsStyling: false
		  })
		 var verify = $('#current-status').text() == "PENDING BY EMPLOYEE" ? 1:0;
		 var acc_id = $(clearance_id).val();
		//  console.log(verify,acc_id)
		  swalWithBootstrapButtons.fire({
			title: 'Change Status',
			text: "Replied by Employee",
			icon: '',
			showCancelButton: true,
			confirmButtonText: 'Change!',
			cancelButtonText: 'cancel!',
			reverseButtons: true
		  }).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + "change-status",
					method: "post",
					data: {
						verify:verify,
						accountability_id:acc_id,
						_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
					},
					dataType: "json",
					success: function (response) {
						// console.log(response)
						if(response.success == 1){
							setTimeout(function(){
								Swal.fire({
									position: 'top-end',
									icon: 'success',
									title: 'Status Change',
									showConfirmButton: false,
									timer: 1500
								  })
								  setTimeout(function(){
									location.reload();
							},1500)
							},1500)
							
						}
						else{
							setTimeout(function(){
								Swal.fire({
									position: 'top-end',
									icon: 'error',
									title: 'Not Change! please Try again.',
									text: "Wrong Status",
									showConfirmButton: false,
									timer: 1500
								  })
								 
							},1500)	
						}
					}, //endsucesss
				});
			}
		  })
		
	})
	//end change status
	//comment send
	$(document).on("click", "#comment-send", function (e) {
		e.preventDefault();

		var badwords = ["amputa","animal ka","bilat","binibrocha","bobo","bogo","boto","brocha","burat","bwesit","bwisit","demonyo","engot","etits","gaga","gagi","gago","habal","hayop ka","hayup","hinampak","hinayupak","hindot","hindutan","hudas","iniyot","inutel","inutil","iyot","kagaguhan","kagang","kantot","kantotan","kantut","kantutan","kaululan","kayat","kiki","kikinginamo","kingina","kupal","leche","leching","lechugas","lintik","nakakaburat","nimal","ogag","olok","pakingshet","pakshet","pakyu","pesteng yawa","poke","poki","pokpok","poyet","pu'keng","pucha","puchanggala","puchangina","puke","puki","pukinangina","puking","punyeta","puta","putang","putang ina","putangina","putanginamo","putaragis","putragis","puyet","ratbu","shunga","sira ulo","siraulo","suso","susu","tae","taena","tamod","tanga","tangina","taragis","tarantado","tete","teti","timang","tinil","tite","titi","tungaw","ulol","ulul","ungas","lul mo"];
		var comment_text = $("#comment-text").val();
		var length;
		var first;
		$.each(badwords, function (k, v) {
			length = v.length;
			first = v.charAt(0);
			comment_text = comment_text.replace(v, "*".repeat(length));
		});

		var c_id = $("#clearance_id").val();
		if ($("#comment-text").val() == "") {
			return false;
		}
		$("#comment-text").val("");
		$("#comment-text").attr("placeholder", "Sending...");
		$.ajax({
			url: base_url + "store-comment",
			method: "post",
			data: {
				c_id: c_id,
				c_text: comment_text,
				_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
			},
			dataType: "json",

			success: function (response) {
				loadComment(c_id);
			}, //endsucesss
		});
	});
	//comment send end

	//click change email
	$(document).on("click", "#btn-change", function (e) {
		e.preventDefault();
		var email = $("#email").val();
		var testEmail =
			/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if (!testEmail.test(email)) {
			$("#email").css("box-shadow", "0px 0px 5px red");
			$(".email-error").css("display", "block");
			return false;
		}
		$("#email-error").css("display", "none");
		if (email == "") {
			$(".email").css("box-shadow", "0px 0px 5px red");
			return false;
		}
		
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				confirmButton: "btn btn-success m-1",
				cancelButton: "btn btn-danger m-1",
			},
			buttonsStyling: false,
		});
		swalWithBootstrapButtons
			.fire({
				title: "Are you sure?",
				text: "This will be your new email:" + email,
				showCancelButton: true,
				confirmButtonText: "Confirm",
				cancelButtonText: "No, cancel!",
				reverseButtons: true,
			})
			.then((result) => {
				if (result.isConfirmed) {
					$("#email").val("");
					$("#email").attr("Placeholder", "Changing...");

					$.ajax({
						url: base_url + "edit-email",
						method: "post",
						data: {
							email: email,
							_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
						},
						dataType: "json",
						success: function (response) {
							$("#email").attr("Placeholder", "Enter Email ...");
							$("#settings-close").click();
							//if done
							Swal.fire({
								title: "Success",
								text: "",
								showCancelButton: false,
								confirmButtonColor: "#3085d6",
								confirmButtonText: "Ok",
							}).then((result) => {
								if (result.isConfirmed) {
									location.reload();
								}
							});
						}, //endsucesss
					});
				} else if (
					/* Read more about handling dismissals below */
					result.dismiss === Swal.DismissReason.cancel
				) {
					swalWithBootstrapButtons.fire("Cancelled");
				}
			});
			
			
	});
	//click change email end

	//load comment
	function loadComment(clearance_id) {
		$.ajax({
			url: base_url + "get-comment",
			method: "post",
			data: {
				clearance_id: clearance_id,
				_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
			},
			dataType: "json",
			success: function (response) {
				if (response.reload == 1) {
					Swal.fire({
						title: "Session Expired",
						text: "Your session has expired, please relogin ",
						showCancelButton: false,
						confirmButtonColor: "#3085d6",
						cancelButtonColor: "#d33",
						confirmButtonText: "ok",
					}).then((result) => {
						if (result.isConfirmed) {
							location.reload();
						}
					});
				} else {
					$("#staticBackdrop").modal("show");
					$("#comment-section").html(response.html);
					$("#comment-text").attr("placeholder", "Write a message...");
					//auto scroll
					$("#comment-section").animate({ scrollTop: 1000000 }, 800);
				}
			},
		});
	}
	//load comment end

	//click tools
	$(document).ready(function () {
		$("#comment-section").scrollTop("#comment-section").prop("scrollHeight");
	});
	$(document).on("click", "#settings-btn", function (e) {
		e.preventDefault();
		$("#mdl-setting").modal("show");
		$("#input-email").css("display", "none");
		$("#email-display").css("display", "block");
		$("#btn-change").css("display", "none");
		$("#email").css("box-shadow", "unset");
	});
	$(document).on("click", ".change-email", function (e) {
		$("#input-email").css("display", "block");
		$("#email-display").css("display", "none");
		$("#btn-change").css("display", "block");
	});
	$(document).on("click", "#cancel-email", function (e) {
		$("#input-email").css("display", "none");
		$("#email-display").css("display", "block");
		$("#btn-change").css("display", "none");
	});

	$(document).on("keypress", "#comment-text", function (e) {
		if (e.which == 13) {
			$("#comment-send").click();
		}
	});
	$(document).on("key", function (e) {
		if (e.which == 27) {
			$("#close-mdl").click();
		}
	});
	//click tools end
});

//load data to table
$(window).on("load", function (e) {
	e.preventDefault();
	$('#dropdown-clearance').html(`
		<option value="NOT_CLEARED">NOT_CLEARED</option>
		<option value="">ALL</option>
		<option value="NEW">NEW</option>
		<option value="FOR_CLEARANCE">FOR_CLEARANCE</option>
		<option value="CLEARED">CLEARED</option>
	`)


	var account_id = $("#cred").data("credential");
	$.ajax({
		url: base_url + "get-clearance",
		method: "post",
		data: {
			id: atob(account_id),
			_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
		},
		dataType: "json",
		success: function (result) {
			if(result.cleared_all == 1){
				$('#lastpay_btn').html(`<button type="button" class="btn btn-info" id="back_p" data-bs-toggle="modal">  
					 Last Pay
				</button>`);
			}
			else{
				$('#lastpay_btn').html(`<button type="button" class="btn btn-secondary">
					Last Pay
				</button>`);
			}
			var response = result.Accountability; 
			var answerd_interview = result.interview ;
			
			tb = "";
			th = "";
			count = 0;
			status = "";
		
			var filter = ` <div class="status-choose active-choose"  data-status="">All</div>`;

			
			$.each(response, function (k, v) {
				//create ledgend
				

				// Add Class 
				var lastcomment =v.lastComment == null
								? '<i style="font-weight:400">  no comments</i>'
								: v.lastComment.substring(0, 10) +
								(v.lastComment.length > 10 ? ". . ." : "");

				// getting session user
				var user = atob($("#cred-access").data("access"));

				// create a icon for last comment
				var chat_icon = `<a class="fa fa-user" style="font-size:25px">
									<span class="fa fa-comment" ></span>
									<span class="num">!</span>
								</a>`;
				// this is defalt icon
				var chat_icon2 = `<a class="fa fa-user" style="font-size:25px"></a>`;

				//build comment
				var lastcomment_icon =`${chat_icon2}&nbsp; ${lastcomment}`;

					// uncomment this when lastcomment by  added to data response
					// user == v.lastCommentBy || v.lastComment == null
					// 	? `${chat_icon2}&nbsp; ${lastComment}`
					// 	: `${chat_icon}&nbsp;<b>${lastComment}</b>`;

				var comment_click = `class="data-tr-td" data-interview = ${answerd_interview} data-id="${v.id}" data-title="${v.title}" data-status="${v.statusDescription}" data-desc="${v.description}" data-remarks="${v.statusRemarks}"`;
				tb += `<tr class="data-tr" >
                <td style="border-left: 5px solid ${v.statusColor}"><a >${v.id.toString().padStart(6, "0")}</a></td>
				<td ${comment_click}  style="min-width:280px;">${
					v.orgGroupDescription == ""
						? "<center>--</center>"
						: v.orgGroupDescription
				}</td>
                <td ${comment_click} id="title-td" >${v.title}</td>
                 <td ${comment_click} style="min-width:180px;"><p style="width:	100%;background-color:${v.statusColor}" class="all-status" >${v.statusDescription}</p></td>
				 <td ${comment_click} style="min-width:135px;">${v.statusUpdatedDate}</td>
				<td ${comment_click} style="min-width:130px;"><span ${comment_click}>${lastcomment_icon}</span></td>
				<td ${comment_click}>${v.lastCommentDate == null ?'<i>   --</i>':v.lastCommentDate}</td>
           </tr>`;

				// filter += ` <div class="status-choose"  data-status="${v.status}">${v.status}</div>`;
			}); //end .each
			
			//for  filter
			// $('#filters-status').html(filter)
			// <th>Action</th>
			th = `<tr>
                    <th>ID</th>
					<th>Clearing Department</th>
                    <th>Accountability</th>
                    <th>Status</th>
					<th>Status Updated Date</th>
					<th>Last Comment</th>
					<th>Last Comment Date</th>
                </tr>`;
			$("#body-table").html(tb);
			$("#table-head").html(th);
			$("#load").hide();


			
			var table1 = $("#accountability-table").DataTable({
				dom:
					"<'row' <'col-md-8 col-sm-12 toolbar'> <'col-sm-12 col-md-4'f> >" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'li><'col-sm-12 col-md-7'p>>",
				language: {
					lengthMenu: "Display _MENU_ records per page",
					zeroRecords: "No Record for this Status",
					// "info": "Showing page _PAGE_ of _PAGES_",
					infoEmpty: "No records  for this Status",
					infoFiltered: "(filtered from _MAX_ total Accountability)",
					search: "_INPUT_",
					searchPlaceholder: "Quick Search",
				},
				responsive: true
				// { // for add class
				// 	details: {
				// 		renderer: function ( api, rowIdx, columns ) {
				// 			var data = $.map( columns, function ( col, i ) {
				// 				var class_id =parseInt(columns[0].data.match(/\d+/))
				// 				return col.hidden ?
				// 					'<tr class="tr-comment " data-cid="'+class_id+'" data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
				// 						'<td>'+col.title+':'+'</td> '+
				// 						'<td>'+col.data+'</td>'+
				// 					'</tr>' :
				// 					'';
				// 			} ).join('');
		 
				// 			return data ?
				// 				$('<table/>').append( data ) :
				// 				false;
				// 		}
				// 	}
				// }
				,
				columnDefs: [
					{ responsivePriority: 1, targets:0 },
					{ responsivePriority: 2, targets: 2 }
				]
			});
			
			$("div.toolbar").html("<div>" + $(".busquedaSem").html() + "</div>");
			//se elimina el elemento clonado
			$(".busquedaSem").remove();
			//se agrega clase para filtro
			$(".fill").addClass("fs");

			$('.status-choose').on('click',function(){
				var status_value = $(this).data('status');
				$('.status-choose').removeClass('active-choose');

				var filter_status = $(this).data("active")
                localStorage.setItem('filter-status', filter_status);
				$(this).addClass('active-choose');
				// console.log(status_value);
				table1.columns(3).search(status_value,true,false).draw();
			})

		
			//for filter cache
			var filter_data =  localStorage.getItem('filter-status') == null ? 0 :localStorage.getItem('filter-status');
			$('.status'+filter_data).click();
			// end filter cache


			//Event Listener for custom radio buttons to filter datatable
			// $(".fs").change(function () {
			// 	$.ajax({
			// 		url: base_url + "ClearanceController/extendMe",
			// 		method: "post",
			// 		data: {
			// 			_cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
			// 		},
			// 		dataType: "json",
			// 		success: function (response) {
						
			// 		},
			// 	});
			// 	var search = this.value == '' ? this.value :"^"+this.value+"$"
			// 	table1.columns(3).search(search,true,false).draw();
			// });
			


			$("#dropdown-clearance").change(function(){
				var search = this.value == '' ? this.value :"^"+this.value+"$"
				table1.columns(3).search(search,true,false).draw();
			})
			// $("#customRadioInline1").click();
		},
	});
		


});
