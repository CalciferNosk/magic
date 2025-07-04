<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Application Form | Motortrade Group</title>
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- SELECT2 PLUGIN FOR MORE CUSTOMAZIBLE SELECT ELEMENT -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/css/select2.min.css">
    <link href="<?= base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>test_assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">    
    <!-- jQuery UI -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom-main.css">
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script>
        var base_url = "<?= base_url(); ?>";
    </script>
    <style>
        .submitForm {
            background-color: #1D3494;
        }

        .submitForm:hover {
            background-color: #fee401 !important;
            color: black;
        }
        th {
            text-align: center;
            color: gray;
        }
        td {
            text-align: center;
        }
        #train{
            margin-top: 25px;
            margin-left: 20px;
        }
        .delete-btn{
            border-radius: 50%;
            width: 37px;
            height: 37px;
        }
    </style>
</head>

<body style="background-image: url('<?=base_url()?>assets/forms_image/background-building-light.png'); background-repeat: no-repeat;background-size: auto; background-size: 100% 100%;">
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZR6XCCTEVV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZR6XCCTEVV');
</script>

<?= _getheaderlayout()?>
    <!-- <div class="container-fluid py-2 px-5"> -->
    <!-- Start Row -->
    <div class="row">
        <!-- Start Column 12 -->
        <div class="col-md-10 offset-md-1">
            <!-- Start Card -->
            <div class="card" style="opacity: .85;margin-top:20px">
                <!-- Start Form -->
                <form action="" id="job-application-form" name="job-application-form" method="POST" enctype="multipart/form-data" data-formstate="0" data-otptries="3" data-otpstate="0" data-otp-exp-min="5">

                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="mrfId" id="mrfId" value="<?= $mrfId; ?>">
                    <div class="card-header">
                        <h3 class="mb-0">Job Application Form <small class="text-muted" style="font-size: 8pt !important"></small></h3>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body" id="mainformbody">
                        <?php if (!empty($MrfTitle)) : ?>
                            <i class='bi bi-briefcase-fill' style='font-size: 27px; color: #1D3494;'></i>
                            <span style="text-decoration:none;font-weight: bold;font-size:20px;color:#1D3494; padding-bottom: 3px;"><?= $position; ?></span><?= $MrfTitle ?>
                            <hr />
                        <?php endif;?>
                        
                        <!-- Customer Information -->
                        <h5 class="card-title">Applicant Information</h5>

                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control required-field alp" name="applicant_fname" id="applicant_fname" placeholder="First Name" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="middlename">Middle Name</label>
                                <input type="text" class="form-control alp" name="applicant_mname" id="applicant_mname" placeholder="Middle Name">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control required-field alp" name="applicant_lname" id="applicant_lname" placeholder="Last Name" required>
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleAccount">Suffix</label>
                                <input class="form-control" name="applicant_suffix" id="applicant_suffix" placeholder="Suffix" type="text" minimumInputLength="2" maxlength="3">
                            </div>
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="cus_psgc">Region | Province | Municipality | Barangay</label>
                                <select class="cus_psgc form-control required-field" id="cus_psgc" name="cus_psgc" data-psgc_brgy_code="" data-psgc_citymun_code="" data-psgc_prov_code="" data-psgc_region_code="" data-psgc_zip_code="" required>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="address">Address (Unit No. / Building / Street)</label>
                                <input type="text" class="form-control required-field" id="applicant_address" name="applicant_address" placeholder="Unit No./Bldg/Street" required>
                            </div>
                        </div>
                        <!-- ./row -->

                        <div class="row">
                            <div class="form-group col-lg-5">
                                <label for="email_address">Email Address</label>
                                <input type="email" class="form-control required-field" id="applicant_email" name="applicant_email" placeholder="juandelacruz@gmail.com" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="mobile_no">Mobile Number <i>(example: 0918-1234567)</i></label>
                                <input type="text" class="form-control required-field mobile" onpaste="return false;" id="mobile_no" name="mobile_no" placeholder="09XX-XXXXXXX" maxlength="12" minlength="12">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="applicant_birthdate">Birth Date</label>
                                <input class="form-control required-field" id="applicant_birthdate" name="applicant_birthdate" placeholder="" type="date" required>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="desired_position">Course</label>
                                <select class="desired_position form-control required-field use-select2" id="applicant_course" name="applicant_course">
                                    <?php
                                    foreach ($courses as $course) :
                                        echo '<option value = "' . $course['value'] . '" data-id="' . $course['value'] . '">' . $course['description'] . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3" id="desired_position">
                                <label for="applicant_desired_position">Desired Position</label>
                                <select class="form-control required-field use-select2" name="applicant_position" id="applicant_position" placeholder=" "></select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="applicant_current_position">Recent Position / Company</label>
                                <input class="form-control required-field" id="applicant_current_position" name="applicant_current_position" placeholder="Marketing" type="text">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="applicant_expected_salary">Expected Salary</label>
                                <input class="form-control required-field" id="applicant_expected_salary" name="applicant_expected_salary" placeholder="0.00" data-type="currency" type="text">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-6">
                            <div class="input-group">
                                <span class="text-danger">*</span>
                            <label for="Source"> Application Source</label>
                            <select  class="form-control required-field use-select2" name="app-source" id="app-source">
                               <?php foreach($genSource as $source) :  ?>
                                <option value="<?= $source['value'] ?>"><?= $source['description'] ?></option>
                               <?php endforeach; ?>
                            </select>
                            </div>
                            
                            </div>
                            <div class="col-md-6">
                            <div class="input-group">
                                <span class="text-danger">*</span>
                            <label for="Source"> Specific Source</label>
                            <select  class="form-control required-field use-select2" name="specific-source" id="specific-source">
                               
                            </select>
                            </div>
                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Upload Resume <i>(Maximum of 1MB filesize)</i></label>
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input upload-file" id="resume" data-max-size="2048" name="resume" accept="image/jpeg, application/pdf, application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document " aria-describedby="resume" required>
                                <label class="custom-file-label" id="resume_label" for="govtid" style="color:gray">Upload one Resume
                                </label>
                            </div>
                            <div class="input-group-append" style="width:90px !important;">
                                <button type="button" id="remove_resume"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="card-title " id="train">Training</h5>
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th>Topic/Subject</th>
                                        <th>Sponsored/Conducted By</th>
                                        <th>Dated From</th>
                                        <th>Dated To</th>
                                        <th>Remove Training</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <tr class="training-table mt-3" >
                                        <td>
                                            <input type="text"  name="training_name[]" class="form-control" id="topic-subject[]">
                                        </td>
                                        <td>
                                            <input type="text"  name="sponsored[]" class="form-control" id="sponsored-by">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="dated_from[]">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="dated_to[]">
                                        </td>
                                        <td >
                                            <button id="DelTraining-btn" class="delete-btn btn btn-danger"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>                      
                            
                            <div>
                                    <button id="AddTraining-btn" class="btn btn-success">Add Training</button>
                                </div>
                        <br />
                        <hr />
                        <div class="row">
                            <h5 class="card-title " id="train">Organizational Membership</h5>
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th>Name of Organization/Club</th>
                                        <th>Position Held</th>
                                        <th>Date Joined</th>
                                        <th>Remove Organization</th>
                                    </tr>
                                </thead>
                                <tbody id="orgTbody">
                                    <tr class="org-table mt-3" >
                                        <td>
                                            <input type="text"  name="orgName[]" class="form-control" id="orgName">
                                        </td>
                                        <td>
                                            <input type="text"  name="positionHeld[]" class="form-control" id="positionHeld">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="dateJoined[]">
                                        </td>
                                        <td >
                                            <button id="delOrg-btn" class="delete-btn btn btn-danger"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>     
                            <div>
                                <button id="addOrg-btn" class="btn btn-success">Add Organization</button>
                            </div>                 
                        <div style="display:none;" id="kickout_div">
                            <h5 class="mb-2">Qualifying Question</h5>
                            <div id="kickout_display"></div>
                            <!-- <div class="form-group form-check ">
                                <?php  foreach ($ko_question as $key => $koq) : ?>
                                    <div>
                                        <p style="font-weight: 500;color:#696969;"><?= $key+1 ?>. <?= $koq['question']?></p>
                                        <?=_getKickaoutQuestion($koq['type'],'koq'.$koq['id']);?>
                                    </div>
                                <?php endforeach; ?>
                            </div> -->
                        </div>
                        <hr>
                        <h5 class="mb-2">Legal Profile</h5>
                        <div class="form-group form-check ">
                            <?php foreach ($legal as $key => $value) : ?>
                                <div>
                                    <label for="">
                                        <font color="red">*</font> <?= $value['description'] ?>
                                    </label><br>
                                    <span style="margin:10px;padding-left:10px"><input class="form-check-input" type="radio" name="question<?= $key + 1 ?>" value="<?= $value['value'] ?>" id="question<?= $key + 1 ?>_Yes"><label> YES </label></span>
                                    <span style="margin:10px;"><input class="form-check-input" type="radio" name="question<?= $key + 1 ?>" value="no" id="question<?= $key + 1 ?>_No" checked="true"><label> NO</label></span>
                                    <input class="form-control pb-2" name="question<?= $key + 1 ?>_answer" placeholder="" id="question<?= $key + 1 ?>_answer" type="text" style="display:none">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <hr />
                        <!-- agreemnt checkbox -->
                        <div class="row ml-0 mb-2">
                            <div class="form-check col-lg-12">
                                <input type="checkbox" class="form-check-input required-field" id="agreement-checkbox" name="agreement" required>
                                <label class="form-check-label" for="agreement-checkbox">
                                    By completing this form, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> of Motortrade.
                                </label>
                            </div>
                        </div>

                        <!-- reCapcha Plugin -->
                        <div class="row">
                            <div class="form-group col-lg-12" id="recaptcha">
                                <?php echo $widget; ?><?php echo $script; ?>
                            </div>
                        </div>
                    </div>

            </div>
            <!-- ./Card Body -->

            <div class="card-footer text-center">
                <div class="row">
                    <div class="form-group col-md-12 col-lg-12">
                        <button type="submit" class="btn btn-lg btn-primary submitForm" name="btn_ltrs_form" id="btn_ltrs_form">Submit Form
                            <!--<i class="fa fa-sign-in" aria-hidden="true"></i>-->
                        </button>
                    </div>
                </div>
            </div>
            <input type="hidden" class="hidden" name="gen_otp" id="gen_otp" value="0" data-resendcount="0">
            <!-- ./end Card Footer -->
            </form>
            <!-- ./End Form -->
        </div>
        <!-- ./End Card -->
    </div>
    <!-- ./end Column12 -->
    </div>
    <!-- ./end Row -->
    <!-- </div> -->
    <!-- ./end container -->

    <!-- Modal Confirm OTP -->
    <div class="modal fade" tabindex="-1" role="dialog" id="confirm-otp-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #1d3494 !important;">
                    <img src="<?= base_url(); ?>assets/images/motortrade-logo.jpg" alt="Motortrade Logo" class="img-responsive mx-auto">
                    <!-- <h5 class="modal-title">Confirm OTP</h5> -->
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding:1rem 2rem !important">
                    <h5>Enter Mobile Number Verification</h5>
                    <p>We've sent a One Time Password (OTP) to your phone number
                        <!--<span id="m-no" class="text-muted font-italic"></span> -->. Please enter it below within <span class="otp-timer-num">5</span> <span class="otp-timer-lbl"> minutes</span>.
                    </p>
                    <div class="form-group col-lg-12">
                        <label for="email_address">Enter OTP:</label>
                        <input type="text" class="form-control required-field text-center" id="input_otp" name="input_otp" placeholder="OTP Code" maxlength="4" style="font-size: 1.3rem">
                    </div>

                    <div class="form-group col-lg-12">
                        <button type="button" class="btn btn-primary form-control" id="btn-confirmotp-jobapp">Continue</button>
                    </div>

                    <div class="form-group col-lg-12">
                        <div class="attempts-div form-group text-center">
                            <p class="small">
                                <a href="#" id="re-otp">Resend OTP (<span id="otp-attempts">2</span> tries left)</span></a> | <a href="#" id="cancenl-submit">Cancel</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary" id="btn-confirmotp">Confirm</button> -->
                </div>
            </div>
        </div>
    </div>
    <?= _getfooterlayout()?>
    <!--  Loader -->
    <div class="ajax-loader d-flex justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; ">
        <div style="background: linear-gradient(#000, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #000); opacity: .5; position: absolute; width: 100%; height: 100%;"></div>
        <img src="<?= base_url(); ?>assets/images/loader-1.gif" style="height: 10% !important;" class="align-self-center">
    </div>
    
    <script> var branchesData = null; </script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- SWEET ALERT -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?= base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
    <!-- jQuery UI -->
    <script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/build/jquery.datetimepicker.full.min.js"></script>
    <!-- START CUSTOM JS -->
    <script src="<?= base_url(); ?>assets/js/main.js?v=<?= rand();?>"></script>
    <script src="<?= base_url(); ?>assets/js/common.js?v=<?= rand();?>"></script>
    <script src="<?= base_url(); ?>assets/js/job-application.js?v=<?= rand();?>"></script>
    <script>
         var error = "<?= $error?>"
        localStorage.setItem('specific_source', `<?= json_encode($specSource) ?>`);
         console.log(error)
        if(error != 200){
            //if Api error to connect
            alert('Error '+error+': Sorry this link not Available this time!')
            $('body').html('return to <a href="'+base_url+'careers">List</a>')
        }
    </script>
    <script>
   $(document).ready(function() {
    // Add Training Row

    $(document).on('change','#app-source',function(){
        var specific_source = localStorage.getItem('specific_source');
        var val = $(this).val();
        var spec_option = '';
        $.each(JSON.parse(specific_source), function(key, value) {
            if(value.appSourceCode == val){
                spec_option += `<option value="${value.value}">${value.description}</option>`;
            }
        })
        $('#specific-source').html(spec_option);
    })


    $(document).on('click', '#AddTraining-btn', function(e) {
        e.preventDefault();
        var row_len = $('.training-table').length;
        var topicSubject = $('#topic-subject').val();
        var sponsoredBy = $('#sponsored-by').val();

        if (topicSubject === '' || sponsoredBy === '') {
            alert('Please fill out Topic/Subject and Sponsored/Conducted By fields first.');
            return false;
        }
        if (row_len >= 3) {
            alert('Maximum of 3 trainings allowed.');
            return false;
        }
        $('#tbody').append(`
            <tr class="training-table mt-3">
                <td><input type="text" name="training_name[]" class="form-control"></td>
                <td><input type="text" name="sponsored[]" class="form-control"></td>
                <td><input type="date" class="form-control" name="dated_from[]"></td>
                <td><input type="date" class="form-control" name="dated_to[]"></td>
                <td><button class="delete-btn btn btn-danger"><i class="fas fa-times"></i></button></td>
            </tr>
        `);
    });

    // Add Organization Row
    $(document).on('click', '#addOrg-btn', function(e) {
        e.preventDefault();
        var row_len = $('.org-table').length;
        var orgName = $('#orgName').val();
        var pHeld = $('#positionHeld').val();

        if (orgName === '' || pHeld === '') {
            alert('Please fill out Organization name/club and Position Held fields first.');
            return false;
        }
        if (row_len >= 3) {
            alert('Maximum of 3 organizations allowed.');
            return false;
        }
        $('#orgTbody').append(`
            <tr class="org-table mt-3">
                <td><input type="text" name="orgName[]" class="form-control"></td>
                <td><input type="text" name="positionHeld[]" class="form-control"></td>
                <td><input type="date" class="form-control" name="dateJoined[]"></td>
                <td><button class="delete-btn btn btn-danger"><i class="fas fa-times"></i></button></td>
            </tr>
        `);
    });

    // Delete Row (Training and Organization)
    $(document).on('click', '.delete-btn', function() {
        $(this).closest('tr').remove();
    });

    // Toggle Radio Container Based on Course Selection
    $('#applicant_course').change(function() {
        if ($(this).val() !== '') {
            $('#radioContainer').show();
        } else {
            $('#radioContainer').hide();
        }
    });

    // Populate Positions Dropdown
    var positions = <?= json_encode($positions); ?>;
    if (positions.length > 0) {
        var options = '';
        $.each(positions, function(index, position) {
            options += `<option value="${position.positionTitle}" data-id="${position.positionID}">${position.positionTitle}</option>`;
        });
        $('#applicant_position').append(options);
    }

    $(document).on('change', '#applicant_position', function() {
        var position_id = $('#applicant_position option:selected').data('id');
        $('#kickout_display').html('');
        $('#kickout_div').hide();
        
        if (position_id == '169') { // BCH
            get_kickout(1, "1");
            get_kickout(2, "2");
            get_kickout(3, "3");
            $('#kickout_div').show();
        }
        if (position_id == '121') { // CH
            get_kickout(1, "1");
            get_kickout(2, "2");
            get_kickout(5, "3");
            $('#kickout_div').show();
        }
        if (position_id == '341') { // BMECH
            get_kickout(6, "1");
            get_kickout(2, "2");
            get_kickout(4, "3");
            $('#kickout_div').show();
        }
        if (position_id == '137') { // BS
            get_kickout(8, "1");
            get_kickout(9, "2");
            get_kickout(10, "3");
            $('#kickout_div').show();
        }
        if (position_id == '345') { // BRMA
            get_kickout(11, "1");
            get_kickout(12, "2");
            get_kickout(5, "3");
            $('#kickout_div').show();
        }
    });

    function get_kickout(qid, qnum) {
        var question = '';
        switch (qid) {
            case 1:
                question = `
                    <div>
                        <label for="">
                            <font color="red">*</font> ${qnum}. Are you a College Graduate?                                
                        </label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_1" value="yes" id="koq_1_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_1" value="no" id="koq_1_no" checked="true">
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            case 2:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Did you have any relevant experience in people management?</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            case 3:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Did you have any experience dealing with customers?</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            case 4:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Did you have a backyard motor shop experience?</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            case 5:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Did you have any experience in sales?</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            case 6:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Are you NCII Certified?</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            case 7:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Did you have a backyard motor shop experience?</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            case 8:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. What is your knowledge in using computer applications (e.g., Microsoft Office)?</label><br>
                       
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="NONE" id="koq_${qid}_none">
                            <label> NONE</label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="BEGINNER" id="koq_${qid}_beginner" checked>
                            <label> BEGINNER</label>
                        </span>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="INTERMEDIATE" id="koq_${qid}_intermediate">
                            <label> INTERMEDIATE </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="ADVANCED" id="koq_${qid}_advanced">
                            <label> ADVANCED </label>
                        </span>
                    </div>`;
                break;
            case 9:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Are you familiar with any inventory systems? If yes, please specify.</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                        <div>
                            <textarea id="koq_${qid}_yes_text" style="display:none"></textarea>
                        </div>
                    </div>`;
                break;
            case 10:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Do you have any experience with data encoding?</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            case 11:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Are you interested in dealing with any type of people?</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            case 12:
                question = `
                    <div>
                        <label><font color="red">*</font> ${qnum}. Are you interested in doing sales?</label><br>
                        <span style="margin:10px;padding-left:10px">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="yes" id="koq_${qid}_yes">
                            <label> YES </label>
                        </span>
                        <span style="margin:10px;">
                            <input class="form-check-input" type="radio" name="koq_${qid}" value="no" id="koq_${qid}_no" checked>
                            <label> NO</label>
                        </span>
                    </div>`;
                break;
            default:
                question = '';
                break;
        }
        $('#kickout_display').append(question);
    }

    // Add Organization Row
    $(document).on('click', '#addOrg-btn', function(e) {
        e.preventDefault();
        var row_len = $('.org-table').length;
        var orgName = $('#orgName').val();
        var pHeld = $('#positionHeld').val();

        if (orgName === '' || pHeld === '') {
            alert('Please fill out Organization name/club and Position Held fields first.');
            return false;
        }
        if (row_len >= 3) {
            alert('Maximum of 3 organizations allowed.');
            return false;
        }
        $('#orgTbody').append(`
            <tr class="org-table mt-3">
                <td><input type="text" name="orgName[]" class="form-control"></td>
                <td><input type="text" name="positionHeld[]" class="form-control"></td>
                <td><input type="date" class="form-control" name="dateJoined[]"></td>
                <td><button class="delete-btn btn btn-danger"><i class="fas fa-times"></i></button></td>
            </tr>
        `);
    });

    // Responsive Display
    var version = '<?= JOB_APP_VERSION; ?>';
    $('#version').text(version);

    function adjustLayout() {
        if ($(window).width() < 990) {
            $('#background-building').hide();
            $('.dropdown-menu').css('left', '0px');
        } else {
            $('#background-building').show().css('height', '154%');
        }
    }

    adjustLayout(); // Initial check
    $(window).resize(adjustLayout); // Check on window resize
});


</script>
</body>

</html>