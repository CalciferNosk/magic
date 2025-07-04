<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="assets/favicon.ico">
    <title>
        Customer Care Form | Motortrade Group
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        .title-label {
            color: #878787;
        }

        body {
            overflow-x: hidden;
        }

        .otp-field {
            display: flex;
        }

        .otp-field input {
            width: 65px;
            font-size: 32px;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin: 2px;
            border: 2px solid #55525c;
            background: #21232d;
            font-weight: bold;
            color: #fff;
            outline: none;
            transition: all 0.1s;
        }

        .otp-field input:focus {
            border: 2px solid #203aa6;
            box-shadow: 0 0 2px 2px #203aa6;
        }

        .disabled {
            opacity: 0.5;
        }

        .space {
            margin-right: 1rem !important;
        }
    </style>
</head>

<body>
    <div style="background-image: url('<?= base_url() ?>assets/forms_image/background-building-light.png'); background-repeat: no-repeat;background-size: auto; background-size: 100% 100%;">
        <?= _getheaderlayout() ?>
        <div class="container">
            <form action="" id="customerCareForm" method="POST" enctype="multipart/form-data" data-formstate="0" data-otptries="3" data-otpstate="0" data-otp-exp-min="5">
                <div class="card justify-content-center mt-5" style="opacity: .9;">
                    <div class="card-header ">
                        <h4>Customer Care Form</h4>
                    </div>
                    <div class="row p-4">
                        <h5>Customer Care Details</h5>
                        <div class="col-md-12 mb-3">
                            <label class="title-label" for="category">Category<span style="color:red">*</span></label>
                            <select class="form-select" id="category" name="category" data-placeholder="Select Category">
                                <option></option>
                                <?php foreach ($category as $key => $cat) : ?>
                                    <option value="<?= $cat['grid'] ?>" data-group="<?= $cat['optiongroup'] ?>"><?= $cat['referencename'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="branch_select" >
                            <label class="title-label" for="category">Please identify the Branch of concern<span style="color:red">*</span></label>
                            <select class="form-select" id="branch" name="branch" data-placeholder="Select Branch" i>
                                <option></option>
                                <?php foreach ($braches as $key => $branch) : ?>
                                    <option value="<?= $branch->code ?>"><?= $branch->code . ' ' . $branch->description . ' (' . $branch->address . ')' ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="branch_display" style="display: none;">
                            <label class="title-label" for="category">Please identify the Branch of concern<span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="branch_display_name" placeholder="" style=" cursor: not-allowed;" readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="title-label" for="">Customer Care Details<span style="color:red">*</span></label>
                            <div class="form-floating">
                                <textarea class="form-control" name="customerCareDetails" placeholder="Leave a comment here" id="customerCareDetails"></textarea>
                                <label class="title-label" for="customerCareDetails">Type here</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="title-label" for="account_number" class="form-label">Account Number (if applicable)</label>
                            <input type="text" class="form-control" id="account_number" placeholder="Enter your account number (if applicable)">
                        </div>
                        <div class="col-md-12 mb-3" id="additionalDetails">
                        </div>
                    </div>
                    <hr>
                    <div class="row p-4">
                        <h5>Customer Information</h5>
                        <div class="col-md-12 row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="title-label" for="customer_fname"  class="form-label">First Name<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" pattern="[a-zA-Z]*" name="customer_fname" id="customer_fname" placeholder="Enter your firstname">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="title-label" for="customer_mname" class="form-label">Middle Name (Optional)</label>
                                    <input type="text" class="form-control" pattern="[a-zA-Z]*" name="customer_mname" id="customer_mname" placeholder="Enter your middlename">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="title-label" for="customer_lname" class="form-label">Last Name<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="customer_lname" pattern="[a-zA-Z]*" name="customer_lname" placeholder="Enter your lastname">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="title-label" for="email" class="form-label">Email address<span style="color:red">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="name@domain.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="title-label" for="mobile_number" class="form-label">Mobile Number<span style="color:red">*</span></label>
                                <div class="input-group mb-3">

                                    <span class="input-group-text" id="basic-addon1">+63</span>
                                    <input type="tel" class="form-control" id="mobile_number" name="mobile_number" minlength="10" maxlength="10" inputmode="numeric" pattern="[0-9]*" placeholder="9XXXXXXXXX">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="title-label" for="mobile_number" class="form-label">Region | Province | Municipality | Barangay<span style="color:red">*</span></label>
                                <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" style="width: 100%" minimumInputLength="3" name="psgc" id="psgc">
                                    <option value="" class="text-white bg-warning">
                                        Choose
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="title-label" for="mobile_number" class="form-label">Address<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Unit No. House No. | Building | Street">
                            </div>
                        </div>
                    </div>
                    <div class="row p-4">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="data_privacy">
                                <label class="form-check-label" for="data_privacy">
                                    By completing this form, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> Statement of Motortrade.
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <?php
                            echo $widget; ?><?php echo $script;
                                            ?>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" style="background-color: #1c3393;">
                            SUBMIT
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <!-- Modal -->
            <div class="modal fade" id="OTPModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OTPModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="OTPModalLabel">Motortrade OTP Confirmation</h5>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <span id="otp_style></span>
                            <div style=" width: 100%;">
                                <center>
                                    <div class="position-relative">
                                        <div class="card p-2 text-center">
                                            <h6>Please enter the one time password <br> to verify your account</h6>
                                            <div> <span>A code has been sent to</span> <small id="otp_mobile_display"></small> </div>
                                            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                                <input class="m-2 text-center form-control rounded" type="number" id="first" maxlength="1" />
                                                <input class="m-2 text-center form-control rounded" type="number" id="second" maxlength="1" />
                                                <input class="m-2 text-center form-control rounded" type="number" id="third" maxlength="1" />
                                                <input class="m-2 text-center form-control rounded" type="number" id="fourth" maxlength="1" />
                                                <input class="m-2 text-center form-control rounded" type="number" id="fifth" maxlength="1" />
                                            </div>
                                            <div class="mt-4"> <button class="btn btn-primary px-4 validate" id="validate_btn" style="background-color: #1c3393;">Validate</button> </div>
                                        </div>
                                        <div class="card-2">
                                            <div class="content d-flex justify-content-center align-items-center"> <span>Didn't get the code</span> <a href="#" id="resend" data-count="1" class="text-decoration-none ms-3">Resend(1/3)</a> </div>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/CDN/js/jquery.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->

    <!-- Scripts -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url() ?>assets/CustomerCare/js/customer-care.js?refresher=<?= date('YmdHis') ?>"></script>
    <script>
           var base_url = '<?= base_url() ?>';
           var branch = '<?= isset($_GET["branch"]) ? $_GET["branch"]  : 0 ?>';
           var disatisfied_link = '<?= isset($_GET["satisfactory"]) ? $_GET["satisfactory"]  : null ?>';
           var option_val   = '<?= isset($_GET["option"]) ? $_GET["option"]  : null ?>';

           var survey_link = `<?= SURVEY_LINK ?>`

           if(branch != 0 && branch.length == 4){
               $('#branch').val(branch);
               $('#branch_select').hide();
                var display_branch = $('#branch').find('option:selected').text()
                $('#branch_display').show();
               $('#branch_display_name').val(display_branch);
            //    $('#branch').attr('disabled', 'disabled');
           }
    </script>
    <?= _getfooterlayout() ?>
</body>

</html>