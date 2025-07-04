$(document).ready(function() {
   
    $('.mdb-select').select2({
        dropdownCssClass: 'mdb-dropdown-menu'
    });

    $(document).on('click', '.nav-content', function() {
        var data_show = $(this).data('content');
        $('.content-all').hide();
        localStorage.setItem('tab_content_'+username_warehouse, data_show);
        $('.' + data_show).show();
    })

    $(document).on('submit', '#upload_engine', function(e) {
        e.preventDefault();
        if ($('#file_name').val() == null) {
            $('#validation_result').html('<span style="color:red">Please enter supplier name</span>');
            $('#table_body').html('');
            return false;
        }
        if ($('#warehouse_name').val() == null) {
            $('#validation_result').html('<span style="color:red">Please select warehouse</span>');

            return false;
        }
        if ($('#file_upload').val() == '') {
            $('#validation_result').html('<span style="color:red">Please select file</span>');
            $('#table_body').html('');
            return false;
        }
        $('#validation_result').html('');
        $('#validation_result').html('Validating...');
        var formData = new FormData(this);
        formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
        formData.append("action", 'validate');
        $('#table_body').html('');
        showLoadingOverlay();
        uploadFile(formData, 'validate');
    })

    $(document).on('click', '#upload_file', function(e) {
        var formData = new FormData($('#upload_engine')[0]);
        formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
        formData.append("action", 'upload');

        uploadFile(formData, 'upload');
    })

    $(document).on('click', '#upload_new', function(e) {
        location.reload();
    })

    $(document).on('change', '#file_upload', function() {
        $('#validation_result').html('');
        $('#upload_file').hide();
        $('#validate_file').removeAttr('disabled');
        $('#validate_file').css('background', '#3e8e41');
    })

    $(document).on('click', '#checker_content', function() {
        $('#checker_input').focus();
        $('#checker_input').val('');
    })

    $(document).ready(function() {
        $('#print-button').on('click', function() {
            $('#container_content').hide();
            $('#print_content').show();
            $('body').css('background-color', 'white');

            window.print();
            window.orientation = 'landscape';
            $('#container_content').show();
            $('#print_content').hide();

        });
    });

    $(document).on('click', '#search_data', function(e) {
        var formData = new FormData();
        var file_id = $('#file_filter').val();
        var dr_number = $('#dr_number_filter').val();
        var created_file = $('#created_by_filter').val();
        formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
        formData.append("file_id", file_id);
        formData.append("created_by", created_file);
        formData.append("dr_number", dr_number);
        $('#search_event').html('<i class="fas fa-spinner fa-spin"></i> Searching...');
        $('#table_body_view').html(``)
        showLoadingOverlay()
        $.ajax({
            type: 'post',
            url: base_url + 'warehouse-filter-data',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                var table = $('#list_table');
                if (response.filtered_data.length > 0) {
                    $('#generate_barcode_div').show();
                    generateBarCode(response.engines)
                    generateBarCodePrint(response.engines)
                    var tr = '';
                    $.each(response.filtered_data, function(key, value) {
                        tr += `<tr class="data_row">
                        <td>${value.DRNumber}</td>
                        <td>${value.MaterialCode}</td>
                        <td>${value.EngineNumber}</td>
                        <td>${value.SerialNumber}</td>
                        <td>${value.ChasisNumber}</td>
                        <td>${value.WwcBat}</td>
                        </tr>`;
                    })

                    $('#table_body_view').html(tr);
                    if ($('#list_table').hasClass('dataTable') || $('#list_table').hasClass('DataTable')) {} else {
                        $('#list_table').DataTable({
                            "pageLength": 10,
                        });
                    }

                } else {

                    $('#generate_barcode_div').hide();
              
                    $('#barcodes').html('');
                    alert('No data found');
                    if ($('#list_table').hasClass('dataTable') || $('#list_table').hasClass('DataTable')) {

                    } else {
                        $('#list_table').DataTable({
                            "pageLength": 10,
                            "className": "data_row"
                        });
                    }
                }
                $('#search_event').text('');
                hideLoadingOverlay()

            }
        })
    })

    $(document).on('click', '#generate_barcode_btn', function(e) {
        $(this).hide();
        $('#generate_barcode_content').show();
        $('#filtered_data_content').hide();
        $('#generate_table_list_btn').show();
    })

    $(document).on('click', '#generate_table_list_btn', function(e) {
        $(this).hide();
        $('#generate_barcode_content').hide();
        $('#filtered_data_content').show();
        $('#generate_barcode_btn').show();
    })

    $(window).on('load', function() {
        for (var i = 0; i < sessionStorage.length; i++) {
            var key = sessionStorage.key(i);
            if (key.startsWith('en_')) {
                sessionStorage.removeItem(key);
            }
        }
    })

    $(document).on('keypress', '#checker_input', function(event) {
        var barcode = $(this).val();
        if (event.which === 13) {
            $('#engine_numer_scanned').text('checking...');
            $('#chasis_number_scanned').text('checking...');
            $('#serial_number_scanned').text('checking...');
            $('#wwc_bat_scanned').text('checking...');
            $('#material_number_scanned').text('checking...');
            $('#dr_number_scanned').text('checking...');
            $.ajax({
                type: 'post',
                url: base_url + 'check-engine-number',
                data: {
                    _cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
                    engine_number: barcode
                },
                dataType: 'json',
                success: function(response) {
                    $('#engine_numer_scanned').text(response== null ? 'not found' : response.EngineNumber);
                    $('#chasis_number_scanned').text(response == null ? 'not found' : response.EngineNumber);
                    $('#serial_number_scanned').text(response == null ? 'not found' : response.EngineNumber);
                    $('#wwc_bat_scanned').text(response == null ? 'not found' : response.EngineNumber);
                    $('#material_number_scanned').text(response == null ? 'not found' : response.EngineNumber);
                    $('#dr_number_scanned').text(response == null ? 'not found' : response.EngineNumber);
                    $('#checker_input').val('');
                    $('#checker_input').focus();

                    var tr = `<tr class="new_scanned">
                        <td>${response.DRNumber}</td>
                        <td>${response.MaterialCode}</td>
                        <td class="engine_td" data-engine="${response.EngineNumber}"> ${response.EngineNumber}</td>
                        <td>${response.SerialNumber}</td>
                        <td>${response.ChasisNumber}</td>
                        <td>${response.WwcBat}</td>
                        </tr>`;


                    if (sessionStorage.hasOwnProperty('en_' + barcode)) {} else {
                        $('#table_body_checker').prepend(tr);
                        sessionStorage.setItem('en_' + barcode, JSON.stringify(response));
                    }

                }

            })
        }
    });

    $(document).on('click', '.data_row', function() {
        var cartIcon = $('.fa-gear');
        var count = $('.fa-gear').text(); // Replace with actual item count
        var itemCount = parseInt(count) + 1;
        $(this).css({
            "background": "#114aa1",
            "color": "yellow"
        });

        // Create a clone of the cart icon
        var clone = cartIcon.clone();

        // Set the clone's position to the button's position
        clone.css({
            position: 'absolute',
            top: $(this).offset().top,
            left: $(this).offset().left
        });

        // Add the clone to the body
        $('body').append(clone);

        // Animate the clone to the cart icon
        clone.animate({
            top: cartIcon.offset().top,
            left: cartIcon.offset().left,
            opacity: 0.5
        }, 500, function() {
            // Remove the clone
            $(this).remove();

            // Update the cart icon's text
            cartIcon.html(`<span style="color:red">${itemCount}</span>`);
        });
    });

    $(document).on('keyup', '#BranchCode', function() {
        var branch_code = $(this).val();
        if (branch_code.length > 4) {
            $('#branch_code_check_msg').text('Branch code should be 4 digit');
            $(this).val(branch_code.slice(0, 3));
            return false;
        }
        if (branch_code.length == 4) {
            showLoadingOverlay();
            $(this).blur();

            setInterval(function() {
                hideLoadingOverlay();
            }, 1300)

            $.ajax({
                type: 'post',
                url: base_url + 'check-Branch',
                data: {
                    _cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
                    branch_code: branch_code
                },
                dataType: 'json',
                success: function(response) {
                    if (response.result.length == 0 && response.result.length != 'undefined') {

                        $('#BranchCode').css('border', '2px solid red !important');

                        $('#branch_code_check_msg').html(`<span style="color:red">Branch code ${branch_code} not found</span>`);
                        $('#BranchCode').val('');
                        $('#add_to_pick').attr('disabled',true)
                    } else {
                        $('#BranchCode').css('border', '2px solid green !important');
                        $('#branch_code_check_msg').html(`<span style="color:green">Branch code found  (${response.result.BranchCode}) - ${response.result.BranchName}  </span> `);
                        $('#BranchCode').attr('data-branchname', response.result.BranchName);
                        $('#add_to_pick').attr('disabled',false)
                    }
                }
            })
        }

    })

    function uploadFile(formData, action) {
        $.ajax({
            type: 'post',
            url: base_url + 'upload-engine',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {

                if (response.error_code != 200) {
                    alert(response.message);
                    return false;
                }
                if (action == 'upload') {
                    if (response.error_code == 200) {
                        $('#validation_result').html('File uploaded successfully');
                        $('#upload_file').hide();
                        $('#upload_div').hide();
                        $('#upload_new').show();

                    } else {
                        alert(response.message);
                    }
                } else {
                    var table = '';
                    var engine_array = [];
                    $.each(response.result, function(key, value) {
                        table += '<tr>';
                        for (var i = 0; i < value.length; i++) {
                            table += `<td ${ (value[i] == null) ||  ($.inArray(value[6], response.existing_engine) !== -1)  ? 'style="background-color:#e6000078"' : ''}>${ value[i] == null ? '--' : value[i] } </td>`;
                        }
                        table += '</tr>';
                        engine_array.push(value[2]);
                    });
                    var table_data = $('#table_body').html(table);

                    $('#validate_table').DataTable({
                        "pageLength": response.duplicate_engine > 0 ? 100 : 10,
                    });
                    if (response.duplicate_engine == response.row_count) {
                        $('#validation_result').html('Error found:  <br> All engine numbers are already exist in database <br> Please refer to all red rows');
                        $('#validate_file').attr('disabled', 'disabled');
                        $('#validate_file').css('background', 'gray');
                        $('#upload_div').hide();
                        $('#upload_new').show();
                    } else if (response.err_count > 0 || response.duplicate_engine > 0) {
                        var null_cell = response.err_count > 0 ? response.err_count + ' cell' + (response.err_count > 1 ? 's are' : ' is') + ' empty' : '';
                        var duplicate_engine = response.duplicate_engine > 0 ? response.duplicate_engine + ' engine number already exist in database' : '';
                        var br = response.err_count > 0 ? '<br>' : '';
                        $('#file_upload').val('');
                        $('#validation_result').html('Error found:  <br>' + null_cell + br + duplicate_engine + ' <br> Please refer to all red rows');
                        $('#validate_file').attr('disabled', 'disabled');
                        $('#validate_file').css('background', 'gray');
                        $('#upload_new').show();
                    } else {
                        $('#validation_result').html('Validation Successful');
                        $('#upload_file').show();
                        $('#validate_file').attr('disabled', 'disabled');
                        $('#validate_file').css('background', 'gray');
                    }
                }
                hideLoadingOverlay();
            }
        });
    }

    function generateBarCode(data) {
        $('#barcodes').html('');
        // Define the barcode options
        var options = {

            width: 2,
            margin: 0,
            height: 50,
            fontSize: 16,
            format: "code128",


            displayValue: true,
            fontOptions: "",
            font: "monospace",
            textAlign: "center",
            textPosition: "bottom",
            textMargin: 2,

            background: "#ffffff",
            lineColor: "#000000",

        };

        // Define the data to be encoded


        // Loop through the data and generate each barcode
        data.forEach(function(code) {
            // Create a new canvas element for each barcode
            var canvas = document.createElement("canvas");
            canvas.width = 200;
            canvas.height = 150;
            document.getElementById("barcodes").appendChild(canvas);

            // Generate the barcode
            JsBarcode(canvas, code, options);
        });
    }

    function generateBarCodePrint(data) {
        // Define the barcode options
        var options = {
            format: "code128",
            width: 1.2,
            height: 40,
            displayValue: true,
            fontOptions: "",
            font: "monospace",
            textAlign: "center",
            textPosition: "bottom",
            textMargin: 3,
            fontSize: 18,
            background: "#ffffff",
            lineColor: "#000000",
            margin: 0
        };

        // Define the data to be encoded


        // Loop through the data and generate each barcode
        data.forEach(function(code) {
            // Create a new canvas element for each barcode
            var canvas = document.createElement("canvas");
            canvas.width = 200;
            canvas.height = 150;
            document.getElementById("barcodes_print").appendChild(canvas);

            // Generate the barcode
            JsBarcode(canvas, code, options);
        });
    }
})
