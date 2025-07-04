$(document).ready(function() {
    // var base_url = '<?= base_url() ?>';
    

    var release_table = $('#release_list_table').DataTable({
        dom: '<"left"Bf>rt<"bottom"lp><"clear">',
        language: {
            lengthMenu: "Display _MENU_ records per page",
            zeroRecords: "No Record for this Status",
            "info": "Showing page _PAGE_ of _PAGES_",
            infoEmpty: "No records  for this Status",
            infoFiltered: "(filtered from _MAX_ total Accountability)",
            search: "_INPUT_",
            searchPlaceholder: "Quick Search",
        },
    
    });

    $(document).on('click','.status_filter',function(){
        var data_val = $(this).data('val');
        $('.status_filter').removeClass('status_active');
        $(this).addClass('status_active');

        release_table.columns(6).search(data_val,true,false).draw();
    })

    $(document).on('change','#model-code-select',function(){
        var data_val = $(this).val();
        var data_count = $(this).find('option:selected').data('count');

        showLoadingOverlay()

        if(data_count > '0'){
            $('#available_qty').html(`<span style="color:green">Available stock : ${data_count} </span>`);
            $('#add_to_pick').attr('disabled',false)
        }
        else{
            $('#available_qty').html(`<span style="color:red">Available stock : ${data_count} </span>`);
            $('#add_to_pick').attr('disabled',true)
        }
        hideLoadingOverlay()

    })
    // $(document).on('change', '#supplier-select', function() {
    //     var searchValue = $(this).val();
    //     if ($('#model-select') != 0) {
    //         $('#model-select').attr('disabled', true);
    //         showLoadingOverlay()
    //         fetchBrandList(searchValue, 'brand_name', 'model-select', 'MODEL');
    //     }
    // });

   

    // $(document).on('change', '#model-select', function() {
    //     var searchValue = $(this).val();
    //     showLoadingOverlay()
    //     $(`#model-code-select`).attr('disabled', true);
    //     fetchBrandList(searchValue, 'model_code', 'model-code-select', 'MATERIAL CODE');
    // });

    $(document).on('click', '.warehouse_logout', function() {

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `${base_url}warehouse-logout`;
            }
        })
    })
    // })

    $(document).on('click', '#save_button', function() {
        $('#pick_list_form').submit();
    })

    $(document).on('submit', '#pick_list_form', function(event) {
        event.preventDefault();

        var branch_code = $('#BranchCode').val();

        var count = 0;
        var null_val = 0;
        if (branch_code == '') {
            alert('Please select branch');
            return false;
        }
        $.each($('.autocomplete_engine'), function(key, value) {
            var value = $(this).val();
            if (value == '') {
                null_val++;

            }
            count++;
        })
        if (count == 0) {
            alert('Please add pick list');
            return false;
        }
        if (null_val > 0) {
            alert('Please fill all engine number');
            return false;
        }

        var formData = new FormData(this);
        formData.append('_cmcToken', $('meta[name="_cmcToken"]').attr('content'));
        formData.append('branch_code', branch_code);
        Swal.fire({
                title: "Save Inventory?",
                text: "Are you sure you want to save this data?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, save it!",
                cancelButtonText: "No!",
            })
            .then((result) => {
                if (result.value) {
                    showLoadingOverlay()
                    $.ajax({
                        type: "POST",
                        url: `${base_url}add_pick_list`,
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if (data == 1) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: "Data saved successfully",
                                    confirmButtonText: "Okay",
                                }).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                })
                                hideLoadingOverlay();
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error Saving",
                                    text: "Failed to save data",
                                    confirmButtonText: "Okay",
                                }).then((result) => {
                                    if (result.value) {
                                        return false;
                                    }
                                })
                                hideLoadingOverlay();
                            }
                        }
                    });
                }
            });
    })

    $(document).on('click', '#increment', function() {
        var currentValue = parseInt($('#quantity').val());
        $('#quantity').val(currentValue + 1);
    });

    // $(document).on('keypress', '#alocate_engine', function(event) {
    //     // event.preventDefault();
    //     var barcode = $(this).val();

    //     if (event.which === 13) {
    //         // alert('Barcode: ' + barcode);
    //         var count_pick = 0;
    //         $.each($('.pick_row'), function() {

    //             count_pick++;

    //         })
    //         if (count_pick == 0) {
    //             Toastify({
    //                 text: "Please add item to pick list",
    //                 duration: 3000, // Duration in milliseconds
    //                 close: true, // Show close button
    //                 gravity: "top", // `top` or `bottom`
    //                 position: "center", // `left`, `center`, or `right`
    //                 backgroundColor: "#3498db", // Background color
    //                 stopOnFocus: true, // Stop the toast from hiding on hover
    //             }).showToast();
    //             return false;
    //         }
    //         $('#ready_for_alocate').html(`<span style="color:orange">Scanning Engine ${barcode}...</span>`);
    //         $('#alocate_engine').val('');

    //         $.ajax({
    //             type: 'post',
    //             url: base_url + 'check-engine-number',
    //             data: {
    //                 _cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
    //                 engine_number: barcode
    //             },
    //             dataType: 'json',
    //             success: function(response) {
    //                 if (response == null) {
    //                     Toastify({
    //                         text: barcode + ' not found',
    //                         duration: 5000, // Duration in milliseconds
    //                         close: true, // Show close button
    //                         gravity: "top", // `top` or `bottom`
    //                         position: "center", // `left`, `center`, or `right`
    //                         backgroundColor: "#3498db", // Background color
    //                         stopOnFocus: true, // Stop the toast from hiding on hover
    //                     }).showToast();
    //                     $(this).focus('');
    //                     $('#ready_for_alocate').html('<span style="color:green">Scanner is ready</span>');
    //                 } else {
    //                     var seq = [];
    //                     var existing_engine = 0;
    //                     var value_count = 0;
    //                     // do mapping here
    //                     $.each($('.autocomplete_engine'), function() {
    //                         var material_code = $(this).data('material');
    //                         var val = $(this).val();
    //                         var sequence = $(this).data('sequence');
    //                         var material_input_count = 0;
    //                         if (material_code == response.MaterialCode) {
    //                             material_input_count++
    //                             if (val == response.EngineNumber) {
    //                                 Toastify({
    //                                     text: 'Engine number already exist',
    //                                     duration: 5000, // Duration in milliseconds
    //                                     close: true, // Show close button
    //                                     gravity: "top", // `top` or `bottom`
    //                                     position: "center", // `left`, `center`, or `right`
    //                                     backgroundColor: "#3498db", // Background color
    //                                     stopOnFocus: true, // Stop the toast from hiding on hover
    //                                 }).showToast();
    //                                 existing_engine++
    //                             }
    //                             if (val == '') {

    //                                 seq.push(sequence);


    //                             } else {
    //                                 value_count++
    //                             }
    //                         }
    //                     })
    //                     if (seq.length > 0) {
    //                         if (existing_engine == 0) {
    //                             $(`.add_${response.MaterialCode}_${seq[0]}`).val(response.EngineNumber);
    //                         }
    //                         $(this).focus('');
    //                     } else if (seq.length < 0 && material_input_count == value_count) {
    //                         Toastify({
    //                             text: 'No Space for new engine number',
    //                             duration: 5000, // Duration in milliseconds
    //                             close: true, // Show close button
    //                             gravity: "top", // `top` or `bottom`
    //                             position: "center", // `left`, `center`, or `right`
    //                             backgroundColor: "#3498db", // Background color
    //                             stopOnFocus: true, // Stop the toast from hiding on hover
    //                         }).showToast();
    //                     } else {
    //                         Toastify({
    //                             text: barcode + ' not found in pick list',
    //                             duration: 5000, // Duration in milliseconds
    //                             close: true, // Show close button
    //                             gravity: "top", // `top` or `bottom`
    //                             position: "center", // `left`, `center`, or `right`
    //                             backgroundColor: "#3498db", // Background color
    //                             stopOnFocus: true, // Stop the toast from hiding on hover
    //                         }).showToast();
    //                     }
    //                     setInterval(function() {
    //                         $(this).focus('');
    //                         $('#ready_for_alocate').html('<span style="color:green">Scanner is ready</span>');
    //                     }, 1200)
    //                 }
    //             }

    //         })



    //     }

    // })

    $(document).on('click', '#decrement', function() {
        var currentValue = parseInt($('#quantity').val());
        if (currentValue > 1) {
            $('#quantity').val(currentValue - 1);
        }
    });

    $(document).on('click', '.remove_pick', function() {
        var remove_div = $(this).parent().parent();
        var parent_div = $(this).parent();
        parent_div.text('Removing...')
        remove_div.css('background-color', '#dc4c6482');
        remove_div.fadeOut(1000, function() {
            $(this).remove();
        });
    })

    $(document).on('click', '.scan_engine_remove', function() {
        var remove_div = $(this).data('removeid');
        $('.' + remove_div).val('');
    })

    $(document).on('click', '#add_to_pick', function() {
        console.log('add to pick clicked')
        var model_code = $('#model-select').val();
        var supplier = $('#supplier-select').val();
        var material_code = $('#model-code-select').val();
        var quantity = $('#quantity').val();
        var branch = $('#BranchCode').val();
        var trucking = $('#Trucking').val();
        var driver = $('#Driver').val();
        var supplying = $('#supplying').val();
        if (branch == '') {
            error_pick("Please add Branch Code","#ffa500","#114aa1")
            return false;
        }
        var branch_name = $('#BranchCode').data('branchname');
        // $('#alocate_engine').blur();

        if (trucking == '') {
            error_pick("Please add Trucking ","#ffa500","#114aa1")
            return false;
        }

        if (driver == '') {
            error_pick("Please add Driver ","#ffa500","#114aa1")
            return false;
        }

        if (supplying == null) {
            error_pick("Please Select Supplying Plant ","#ffa500","#114aa1") 
            return false;
        }

        // if (supplier == '0') {
        //     error_pick("Please Select Supplier ","#ffa500","#114aa1")
        //     return false;
        // }
        // if (model_code == '0') {
        //     error_pick("Please select model code ","#ffa500","#114aa1")
        //     return false;
        // }
        if (material_code == null) {
            error_pick("Please Select Material Code ","#ffa500","#114aa1")
            return false;
        }
        if (quantity == '') {
            error_pick("Please add quantity ","#ffa500","#114aa1")
            return false;
        }
        if (quantity > 10) {
            error_pick("Quantity max limit is 10","#ffa500","#114aa1")
            return false;
        }

        console.log(quantity)
        $('#BranchCode').attr('disabled', 'disabled')
        var formData = new FormData();
        formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
        formData.append("material_code", material_code);
        formData.append("branch", branch);

        $.ajax({
            url: base_url + 'material-check',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            success: function(data) {
                if (data.count > 0) {
                    var count_pick = 0;
                    $.each($('.pick_row'), function() {
                        var material = $(this).data('material');
                        if (material == material_code) {
                            $(this).css('border', '1px solid #ed5976');
                            count_pick++;
                        }
                    })
                    if (count_pick > 0) {
                        Toastify({
                            text: "Model already picked!",
                            duration: 3000, // Duration in milliseconds
                            close: true, // Show close button
                            gravity: "top", // `top` or `bottom`
                            position: "center", // `left`, `center`, or `right`
                            "backgtround-color": "#3498db", // Background color
                            stopOnFocus: true, // Stop the toast from hiding on hover
                        }).showToast();

                        setInterval(function() {
                            $('.pick_row').css('border', 'none');
                        }, 3000)
                        return false;
                    }
                    // console.log( data.count < ++quantity )
                    var available_count = data.count < parseInt(quantity) ? 1 : 0;
                    var check_inventory = data.check_inventory;
                    
                    //check stock if available
                    var inventory_count  = check_inventory > 0 ? 'This material code already have record for this branch' : '';
                    if (available_count == 1 ) {
                        console.log(data.count)
                        error_pick(`Material ${material_code}  Available stock :  ${data.count} `,"#3498db")
                        $('#inventory-count-msg').html()
                    } else {
                        $('#inventory-count-msg').html('')
                    }
                    if(check_inventory > 0){
                        error_pick(inventory_count)
                    }
                    console.log(quantity+'-new')
                    // add to pick list
                    var pick_tr = `
                        <tr class="pick_row"  data-material="${material_code}">
                            <td><input style="cursor:pointer;" class="form-control" type="text" name="quantity[]" value="${ available_count == 1 ? data.count : quantity }" readonly></td>
                            <td><input style="cursor:pointer" class="form-control" type="text" name="branch[]" value="${ branch+ ' - ' + branch_name}" readonly></td>
                          
                            <td><input style="cursor:pointer" class="form-control" type="text" name="material_code[]" value="${ material_code }" readonly></td>
                            <td><input style="cursor:pointer;" class="form-control" type="text" value="${ data.count }" readonly></td>
                            <td><button class="remove_pick" style="border-radius: 43%;width: 35px;height: 35px;background-color: #ed5976 !important;border:1px solid white;" ><i class="fa fa-trash" style="color:white"></i></button></td>
                        </tr>`;
                    $('#pick_table_body').append(pick_tr);
                } else {
                    error_pick("Insufficient inventory stock!")
                    // $('#inventory-count-msg').text('Insufficient inventory stock!')
                }
            }
        })

        // }
        $('#model-select').select2('val', null);
        $('#supplier-select').select2('val', null);
        $('#quantity').val('1');
    })

    $(document).on('submit', '#pick_release_form', function(event) {
        event.preventDefault();
        var count_pick = 0;
        var trucking =  $('#Trucking').val();
        var driver =  $('#Driver').val();
        var supplying =  $('#supplying').val();
        $.each($('.pick_row'), function() {
            count_pick++;
        })

        if (count_pick == 0) {
            error_pick("Please add order")
            return false;
        }

        var formData = new FormData(this);
        formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
        formData.append("trucking", trucking)
        formData.append("driver", driver)
        formData.append("supplying", supplying)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            // icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Save!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoadingOverlay();
                $('#insert_pick').attr('disabled', true)
                $.ajax({
                    type: 'post',
                    url: base_url + 'add_pick_list',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response == 0) {
                            hideLoadingOverlay();
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                footer: '<a href="#">Why do I have this issue?</a>'
                            });
                            $('#insert_pick').attr('disabled', false)
                        } else {
                            hideLoadingOverlay();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Your work has been saved",
                                showConfirmButton: false,
                                timer: 1500
                            });
                          
                            setInterval(function() {
                                location.reload();
                            }, 1600)
                        }
                    }
                })

            }
        })
    })

    function fetchBrandList(value, selected, targetId, targetName) {
        $.ajax({
            type: "POST",
            url: `${base_url}getBrandList`,
            data: {
                value,
                selected,
                _cmcToken: $('meta[name="_cmcToken"]').attr('content')
            },
            dataType: "json",
            success: function(data) {
                var model = `<option value="0">SELECT ${targetName}</option>`;
                var material = `<option value="0">SELECT ${targetName}</option>`;

                $.each(data, function(key, value) {
                    model += `<option value="${value.model_code}">${value.main_model} - ${value.model_code}</option>`;
                    material += `<option value="${value.material_number}">${value.material_number}</option>`;

                });
                if (targetId == 'model-select') {
                    $(`#model-select`).html(model);
                    $('#model-select').removeAttr('disabled');
                }
                if (targetId == 'model-code-select') {
                    $(`#model-code-select`).html(material);
                    $('#model-code-select').removeAttr('disabled');
                }
                hideLoadingOverlay();
            }
        });
    }


    function error_pick(msg,color = "#ff3333" ,font = "white") {
        Toastify({
            text: msg,
            duration: 4000, // Duration in milliseconds
            close: false, // Show close button
            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center`, or `right`
            backgroundColor: color, // Background color
            style: {
                color: font, // Font color
                "border-radius": "10px", // Border radius
              },
            stopOnFocus: true, // Stop the toast from hiding on hover
        }).showToast();
    }
    // function active_focus() {
    //     // if ($('#alocate_engine').focus()) {
    //     //     $('#ready_for_alocate').html('<span style="color:green">Scanner is ready</span>');
    //    
    //     // } else {
    //     //     $('#ready_for_alocate').html('<span style="color:gray">Scanner is busy</span>');
    //  
    //     // }
    //     if ($(document.activeElement).is('#alocate_engine')) {
    //         $('#ready_for_alocate').html('<span style="color:green">Scanner is ready</span>');
    //     } else {
    //         $('#ready_for_alocate').html('<span style="color:gray">Scanner is busy</span>');
    //     }
    // }

});
