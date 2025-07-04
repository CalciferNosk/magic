$(document).ready(function () {
	var third_17 = $(".t_17");
	var third_18 = $(".t_18");
	var second_5 = $(".s_5");
	var second_6 = $(".s_6");
	var second_19 = $(".s_19");
	var second_18 = $(".s_18");
	var second_17 = $(".s_17");
	var parent_check_a = $(".nns-0");
    var parent_check_b = $(".nns-1");
    var parent_check_c = $(".nns-2");

// for letter A
	$(third_17).on("click", function () {
		if (third_17.is(":checked") == false) {
			third_17.prop("checked", false);
		} else {
			second_17.prop("checked", true);
			third_18.prop("checked", false);
			parent_check_a.prop("checked", true);
		}
	});
	$(third_18).on("click", function () {
		if (third_18.is(":checked") == false) {
			third_18.prop("checked", false);
		} else {
			third_17.prop("checked", false);
			second_18.prop("checked", true);
			parent_check_a.prop("checked", true);
		}
	});
    $(second_17).on("click", function () {
		third_18.prop("checked", false);
		parent_check_a.prop("checked", true);
	});
	$(second_19).on("click", function () {
		$(".s_17").prop("checked", false);
		$(third_17).prop("checked", false);
		$(third_18).prop("checked", false);
		parent_check_a.prop("checked", true);
	});

	$(second_18).on("click", function () {
		$(".s_17").prop("checked", false);
		$(third_17).prop("checked", false);
		parent_check_a.prop("checked", true);
	});

	parent_check_a.on("click", function () {
		if (parent_check_a.is(":checked") == false) {
			third_17.prop("checked", false);
			third_18.prop("checked", false);
			second_17.prop("checked", false);
			second_18.prop("checked", false);
			second_19.prop("checked", false);
		}
	});
// end letter A

// for letter B
    $(second_5).on('click',function(){
        if (second_5.is(":checked") == true) {

            parent_check_b.prop("checked", true);
        }
    })
    $(parent_check_b).on('click',function(){
        if (parent_check_b.is(":checked") == false) {

            second_5.prop("checked", false);
        }
    })
// end letter B 
// for letter B
$(second_6).on('click',function(){
    if (second_6.is(":checked") == true) {

        parent_check_c.prop("checked", true);
    }
})
$(parent_check_c).on('click',function(){
    if (parent_check_c.is(":checked") == false) {

        second_6.prop("checked", false);
    }
})

// end letter B 
$(document).on('click','.no_1',function(){
        var parent = $(this).parent('span')
        var child = parent.parent('.container').find('.underline')
        
        child.prop('required',true)
})

// for letter Q-B if D is choose
$(document).on('click','.s_5',function(){
    console.log($(this).val())
   
    if($(this).val() == 13){
       $('.specific_13').prop('required',true)
    }
    else{
        $('.specific_13').prop('required',false)
    }  
})
// for letter Q-C if D is choose
$(document).on('click','.s_6',function(){
    console.log($(this).val())
   
    if($(this).val() == 17){
       $('.specific_17').prop('required',true)
    }
    else{
        $('.specific_17').prop('required',false)
    }  
})



$(document).on('click','.second_q',function(){
    var id = $(this).data('no')
    var specific = $(this).data('specific')
    // console.log(id)
    // console.log($('.id_'+id).is(':checked'))
   if($('.id_'+id).is(':checked') == false){
    
    
    $('.req_'+id).prop('required',false)
   }
   
    if(specific == 18){
        if($('.id_18').is(':checked') == false){
            $('.specific_19').prop('required',false)
        }
    }
    if(specific == 19){
        if($('.id_19').is(':checked') == false){
        
            $('.specific_18').prop('required',false)
        }
}
   //checking if not check undeline clear
   ifcheck();

})

function ifcheck(){

    if($('.all_18').is(':checked') == true){
        $('.specific_19').val('');
    }
    if($('.all_19').is(':checked') == true){
        $('.specific_18').val('');
    }
    //3
    if($('.all_21').is(':checked') == true || $('.all_22').is(':checked') == true ){
        $('.specific_23').val('');
    }
    //4
    if($('.all_26').is(':checked') == true){
        $('.specific_27').val('');
    }
    //5
    if($('.all_28').is(':checked') == true){
        $('.specific_29').val('');
    }
    //6
    if($('.all_30').is(':checked') == true){
        $('.specific_31').val('');
    }
    //7
    if($('.all_32').is(':checked') == true){
        $('.specific_33').val('');
    }
    //8
    if($('.all_34').is(':checked') == true){
        $('.specific_35').val('');
    }

}
   


// Store Answer
	// $("#submit-interview").on("click", function (e) {
$("#exit_interview_form").submit(function (e){
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger m-2'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: '',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save Answer!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              
           
		var checkboxs = $(".not-null-subquestion");
		var okay = false;
        
        
		for (var i = 0, l = checkboxs.length; i < l; i++) {
			if (checkboxs[i].checked) {
				okay = true;
				break;
			}
		}
		if (okay == false) {
			alert("Please Select on Question 1");
			checkboxs.css("box-shadow", "0px 0px 5px red");
			checkboxs.focus();
			return false;
		} else {
			checkboxs.css("box-shadow", "0px 0px 0px white");
		}

        //check letter A if have answer 
        if (parent_check_a.is(":checked") == true) {

            if($('.sec').is(":checked") == false){
                alert('please select Answer on question 1 Letter A')
                $('.sec').parent().css("box-shadow", "0px 0px 5px red");
                $('.sec').focus();
                return false;
            }
            else{
                $('.sec').parent().css("box-shadow", "0px 0px 5px white");
            }
        }

        //check letter A if have answer 
        if (parent_check_b.is(":checked") == true) {

            if(second_5.is(":checked") == false){
                alert('please select Answer on question 1 Letter B')
                second_5.parent().css("box-shadow", "0px 0px 5px red");
                second_5.focus();
                return false;
            }
            else{
                second_5.parent().css("box-shadow", "0px 0px 5px white");
            }
        }

        //check letter A if have answer 
        if (parent_check_c.is(":checked") == true) {

            if(second_6.is(":checked") == false){
                alert('please select Answer on question 1 Letter C')
                second_6.parent().css("box-shadow", "0px 0px 5px red");
                second_6.focus();
                return false;
            }
            else{
                second_6.parent().css("box-shadow", "0px 0px 5px white");
            }
        }


        //guard reset  shadow
        third_17.parent().css("box-shadow", "0px 0px 5px white");
        third_18.parent().css("box-shadow", "0px 0px 5px white");
        //reset shadow

        //cheking question 1 subquestion
        if (second_17.is(":checked") == true) {

            if(third_17.is(":checked") == false){
                alert('please select Answer Sub-question Letter b')
                third_17.parent().css("box-shadow", "0px 0px 5px red");
                third_17.focus();
                return false;
            }
            else{
                third_17.parent().css("box-shadow", "0px 0px 5px white");
            }
        }
        if (second_18.is(":checked") == true) {

            if(third_18.is(":checked") == false){
                alert('please select Answer Sub-question  Letter c')
                third_18.parent().css("box-shadow", "0px 0px 5px red");
                third_18.focus();
                return false;
            }
            else{
                third_18.parent().css("box-shadow", "0px 0px 5px white");
            }
        }


        for(var i = 7;i < 13 ;i++){
            if($('.qid'+i).is(':checked') == false){
                $('.qid'+i).css("box-shadow", "0px 0px 5px red");
                $('.qid'+i).focus();
                return false;
            }

        }

		//storing data
		var formData = new FormData($("#exit_interview_form").get(0));
		formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
        console.log('here')
		$.ajax({
			url: base_url + "store-interview", 
			method: "post",
			processData: false,
			contentType: false,
			data: formData,
			dataType: "json",
			success: function (response) {
                // localStorage.setItem("object_data",response.object);
                if(response.response == 1){
               
                    Swal.fire({
                        title: 'Success!',
                        text: "Your Answer has been saved!",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                      }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = base_url+'clearance'
                            
                        }
                      })
                }
                else{
                    alert(`${response.http}:${response.message}`)
                }
            }, //endsucesss
		});

       
        function validate(){
            if($('.all_19').is(':checked') == true){
              
                if($('.specific_19').val() == ''){
                    $('.specific_19').focus();
                    
                    alert('Please Fill out required Field');
                    return false;
                }
            }else
            if($('.all_18').is(':checked') == true){
               
                if($('.specific_18').val() == ''){
                    $('.specific_18').focus();
                    alert('Please Fill out required Field');
                    return false;
                }
            }
    
    
            if($('.all_23').is(':checked') == true){
               
                if($('.specific_23').val() == ''){
                    $('.specific_23').focus();
                    alert('Please Fill out required Field');
                    return false;
                }
            }
    
            if($('.all_27').is(':checked') == true){
               
                if($('.specific_27').val() == ''){
                    $('.specific_27').focus();
                    alert('Please Fill out required Field');
                    return false;
                }
            }
    
            if($('.all_29').is(':checked') == true){
               
                if($('.specific_29').val() == ''){
                    $('.specific_29').focus();
                    alert('Please Fill out required Field');
                    return false;
                }
            }
            if($('.all_31').is(':checked') == true){
               
                if($('.specific_31').val() == ''){
                    $('.specific_31').focus();
                    alert('Please Fill out required Field');
                    return false;
                }
            }
    
            if($('.all_33').is(':checked') == true){
               
                if($('.specific_33').val() == ''){
                    $('.specific_33').focus();
                    alert('Please Fill out required Field');
                    return false;
                }
            }
    
            if($('.all_35').is(':checked') == true){
               
                if($('.specific_35').val() == ''){
                    $('.specific_35').focus();
                    alert('Please Fill out required Field');
                    return false;
                }
            }
            
           
        }


    } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
       return false;
      }
    })
	});

   
});
