<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico" />
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <title>Loan Application | Motortrade Group</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/newloan.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/inquiryloan.css">
</head>
<style>
    #sig-canvas {
        border: 2px dotted #CCCCCC;
        border-radius: 15px;
        cursor: crosshair;
    }

    .action-button {
        width: 15% !important;

    }

    .btn-block {
        width: 50% !important;
    }

    @media only screen and (max-width: 768px) {

        /* For mobile phones: */
        .toplab {
            display: none !important;
        }

        .btn-block {
            width: 100% !important;
        }

        .action-button {
            width: 30% !important;

        }
    }

    /* Custom radio buttons */

    .upload-wrapper {
        position: relative;
        margin-bottom: 10px;
    }

    .fileInput {
        display: none;
    }

    .custom-file-upload {
        background-color: #3498db;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 4px;
        /* width: 224px; */
        text-align: center;

    }

    #fileName {
        /* margin-left: 120px; */
        line-height: 40px;
        color: #555;
    }


    #filePreview {
        margin-top: 20px;
    }

    #preview {
        max-width: 100%;
        height: auto;
    }

    .upload-display {
        display: none;
    }

    /* Custom checkbox */
</style>

<body>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KEBMX9WXGD"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-KEBMX9WXGD');
    </script>

    <!-- <body style="background-image: url('<?= base_url() ?>assets/forms_image/background-building-light.png'); background-repeat: no-repeat;background-size: auto; background-size: 100% 100%;"> -->
    <?= _getheaderlayout() ?>
    <div class="modal bd-example-modal-sm fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="testd">
                    <h5 align="center"><img src="assets/mopom.jpg" alt=""></h5>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12">

                        <h5>Enter Mobile Number Verification</h5>
                        We've sent a One Time Password (OTP) to your phone number. Please enter it below within 5 minutes.
                        <br /><br />
                        <b>Enter OTP</b>
                        <input type="number" class="form-control otp-input modal-ku" id="otp-input" placeholder="OTP Code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="text-align:center" maxlength="4" aria-describedby="passwordHelpInline">

                        <input type="hidden" id="hiddenOTP">
                        <br />
                        <div align="center">
                            <button type="button" id="submitModal" class="btn btn-primary btn-block next">Continue</button>
                        </div>
                        <div align="center" id="modalfin">
                            <br />
                            <span id="resending"></span> | <a href="#" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>

                <!--div class="modal-footer">
        <button type="button" id="submitModal" class="btn btn-sm btn-primary">Submit</button>
        <button type="button" id="resend" class="btn btn-sm btn-secondary" onclick="reSend()" data-dismiss="modal">Resend</button>
      </div-->
            </div>
        </div>
    </div>
    <!-- Modal -->
    <!-- MultiStep Form -->
    <div class="container-fluid" id="grad1">
        <div class="row justify-content-center mt-0" style="opacity:.8">
            <div class="col-11 col-sm-9 col-md-7 col-lg-11 text-center p-0 mt-3 mb-2">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                    <h2><strong>Motortrade Loan Applications</strong></h2>
                    <label>
                        <?php
                        //$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        if (empty($_GET['cls'])) {
                            echo '';
                        } else {
                            # Revised By Russ: 5-19-21
                            // foreach ($clustercodes as $clustercode)
                            // {
                            //     if ($clustercode->code == base64_decode($_GET['cluster']))
                            //     {
                            //         echo ' (' . $clustercode->description . ')';
                            //     }
                            // }
                            echo $cluster_code;
                            if ($cluster_code == '') {
                                redirect('/FormError');
                            }
                        } ?></label>
                    <div class="row">
                        <div class="col-md-12 mx-0">
                            <form action="Loan/tabsix" id="msform" method="POST" enctype='multipart/form-data'>
                                <!-- progressbar -->
                                <input type="hidden" name="sourceparam" id="sourceparam" />
                                <input type="hidden" name="sourceid" id="sourceid" value="<?php echo str_replace('"', '', $sourceid) ?>" />
                                <input type="hidden" name="campaignid" id="campaignid" value="<?php echo str_replace('"', '', $campaignid) ?>" />
                                <input type="hidden" name="clusterid" id="clusterid" value="<?php echo str_replace('"', '', $clusterid) ?>" />
                                <input type="hidden" name="clusterparam" id="clusterparam" />
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <ul id="progressbar">
                                    <li style="display:none;" class="active"></li>
                                    <li id="account"><strong class="toplab">Loan Information</strong></li>
                                    <li id="personal"><strong class="toplab">Personal Details</strong></li>
                                    <li id="payment"><strong class="toplab">Monthly Income Computation</strong></li>
                                    <li id="payment"><strong class="toplab">Existing Loans</strong></li>
                                    <li id="payment"><strong class="toplab">References</strong></li>
                                    <li id="confirm"><strong class="toplab">Attachments & Signature</strong></li>
                                    <li style="display: none;"><strong>Attachments & Signature</strong></li>
                                </ul>
                                <fieldset>
                                    <div class="form-card">

                                        <div class="buttons" align="center">
                                            <br />
                                            <button type="button" id="create" class="btn btn-primary btn-block">CREATE NEW RECORD</button>
                                            <br />
                                            <h6>OR</h6>
                                            <br />
                                            <div class="row justify-content-md-center">
                                                <div class="col-sm-2">
                                                    <b>Enter Record ID*</b>
                                                    <input class="form-control" type="number" id="updateid" class="form-control otp-input modal-ku">
                                                </div>
                                                <div class="col-sm-4">
                                                    <b>Mobile Number* <i>(example: 0918-1234567)</i></b>
                                                    <input class="form-control mobile" id="updateno" name="updateno" placeholder="09XX-XXXXXXX" type="tel" maxlength="12" onkeypress="return onlyNumberKey(event)">
                                                </div>
                                            </div>
                                            <button type="button" id="testupdate" class="btn btn-primary btn-block">Continue</button>
                                        </div>
                                    </div>
                                    <input type="button" id="proceed" name="next" class="next action-button" style="display:none;" value="Save and Next">
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title alignleft">Loan Information</h2>
                                        <h5 class="alignright">
                                            <div class="button-wrapper-dl">
                                                <span class="labeldl">
                                                    Upload Driver's License
                                                </span>

                                                <input type="file" name="image" id="uploaddl" class="upload-box" placeholder="Upload File">

                                            </div>
                                        </h5>
                                        <div style="clear: both;"></div>
                                        <input type="hidden" id="loan_type" name="type_new" value="564" />
                                        <div class="row">
                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleAccount">First Name*</label>
                                                <input class="form-control alp" name="first_name" id="customer_fname" placeholder="First Name" pattern="^\D*$" title="Please enter only alphabets" type="text">
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleAccount">Middle Name</label>
                                                <input class="form-control alp" name="middle_name" id="customer_mname" placeholder="Middle Name" type="text">
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleAccount">Last Name*</label>
                                                <input class="form-control alp" name="last_name" id="customer_lname" placeholder="Last Name" type="text">
                                            </div>
                                            <div class="col-sm-6 pb-3 ">
                                                <label for="exampleFirst">Email Address</label>
                                                <input class="form-control" id="email" name="email" placeholder="Email Address" type="email">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <div>
                                                    <label for="exampleFirst">
                                                        Mobile Number*
                                                        <i>(example: 0918-1234567) </i>
                                                        <br>

                                                    </label>
                                                </div>


                                                <div class="alignleft">
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="inlineRadio1" name="inlineRadioOptions" class="custom-control-input" value="option1" checked>
                                                        <label class="custom-control-label" for="inlineRadio1">Prepaid</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="inlineRadio2" name="inlineRadioOptions" class="custom-control-input" value="565">
                                                        <label class="custom-control-label" for="inlineRadio2">Postpaid</label>
                                                    </div>
                                                </div>

                                                <input class="form-control mr-1 mobile" style="width:80% !important" id="contact_no" name="contact_no" placeholder="Mobile Number" type="tel" maxlength="12" onkeypress="return onlyNumberKey(event)">

                                                <div style="clear: both;"></div>
                                            </div>
                                            <div class="col-sm">
                                                <label>MC Brand *</label>
                                                <select class="form-control custom-select" name="brand" id="brand">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
                                                    foreach ($brand as $bran) {
                                                        echo '<option value = "' . $bran->grid . '" data-id="' . $bran->grid . '">' . $bran->referencename . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm">
                                                <label>MC Model *</label>
                                                <select class="form-control custom-select" name="model" id="model">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-sm">
                                                <label>MC Color *</label>
                                                <select class="custom-select" name="color" id="color">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
                                                    foreach ($colors as $color) {
                                                        echo '<option value = "' . $color->grid . '" >' . $color->referencename . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <label>Plan Date To Purchase</label>
                                                <input class="form-control" name="datetime" id="datetime" type="date">
                                            </div>
                                            <div class="col-md">
                                                <label>Loan Purpose</label>
                                                <input class="form-control" name="loan_purpose" id="loan_purpose" placeholder="Loan Purpose" type="text">
                                            </div>
                                        </div>
                                        <div class="row">


                                            <div class="col-sm">
                                                <label>Loan Type *</label>

                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="loan_type_1" name="loan_type" class="custom-control-input" value="564" checked>
                                                    <label class="custom-control-label" for="loan_type_1">Brand New</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="loan_type_2" name="loan_type" class="custom-control-input" value="565">
                                                    <label class="custom-control-label" for="loan_type_2">Second-Hand</label>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <label for="exampleAccount">Desired Loan Amount*</label>
                                                <input class="form-control" name="loan_amount" id="loan_amount" data-type="currency" placeholder="ex: 1,000" type="text">
                                            </div>
                                            <div class="col-sm">
                                                <label for="exampleAccount">Desired Downpayment*</label>
                                                <input class="form-control" name="downpayment" id="downpayment" data-type="currency" placeholder="ex: 1,000" type="text">
                                            </div>
                                            <div class="col-sm">
                                                <label>Desired Term *</label>
                                                <input class="form-control" name="loan_term" id="loan_term" placeholder="Term" type="number">
                                            </div>
                                        </div>
                                        <div id="validations" class="row ml-0">
                                            <div class="form-check col-lg-12">
                                                <input class="form-check-input required-field" style="width:auto;" type="checkbox" id="myChecked" onclick="myFunctions()">
                                                <label class="form-check-label" for="agreement-checkbox">
                                                    By completing the form below, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement</a> of
                                                    Motortrade.<br /><br />
                                                </label>
                                            </div>
                                            <?php echo '<br/><br/>';
                                            echo $widget; ?><?php echo $script; ?>
                                        </div>
                                    </div>
                                    <input type="button" id="tabone" class="action-button" value="Save and Next">
                                    <input type="button" id="oneproc" name="next" style="display: none;" class="next action-button">
                                    <!--input type="button" id="oneproc" name="next"  class="next action-button"-->
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Personal Details</h2>
                                        <h5 class="alignright">Form Record ID: <span class="recid"></span></h5>
                                        <div style="clear: both;"></div>
                                        <input type="hidden" id="idses" name="idses" />
                                        <input type="hidden" id="custses" />
                                        <input type="hidden" id="busses" />
                                        <input type="hidden" id="spouses" />
                                        <input type="hidden" id="l1ses" />
                                        <input type="hidden" id="l2ses" />
                                        <input type="hidden" id="l3ses" />
                                        <input type="hidden" id="r1ses" />
                                        <input type="hidden" id="r2ses" />
                                        <input type="hidden" id="r3ses" />
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-8 pb-3">
                                                <label for="exampleAccount">Mother's Maiden Name</label>
                                                <input class="form-control alp" name="maiden_name" id="maiden_name" placeholder="Mother's Maiden Name" type="text">
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleAccount">Number of Children / Age</label>
                                                <input class="form-control" name="no_children" id="no_children" placeholder="Number of Children / Age" type="text">
                                            </div>
                                            <div class="col-sm-2 pb-3">
                                                <label for="exampleAccount">Nationality</label>
                                                <input class="form-control" name="nationality" id="nationality" placeholder="Nationality" type="text" value="Filipino">
                                            </div>
                                            <div class="col-sm-3 pb-3 ">
                                                <label for="exampleFirst">Birthday (MM/DD/YYYY)*</label>
                                                <input class="form-control birthday" id="birthday" name="birthday" placeholder="Birthday" type="date" max="2021-01-29">
                                            </div>
                                            <div class="col-sm-1 pb-3">
                                                <label for="exampleAccount">Age*</label>
                                                <input class="form-control dis" name="age" id="age" placeholder="Age" type="number">
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleAccount">Birthplace*</label>
                                                <input class="form-control" name="birth_place" id="birthplace" placeholder="Birthplace" type="text">
                                            </div>
                                            <div class="col-sm-2 pb-3">
                                                <input type="hidden" id="gender" name="type_new" value="566" />
                                                <label for="exampleSt">Gender*</label>
                                                <br>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="gender_1" name="gender" class="custom-control-input" value="566" checked>
                                                    <label class="custom-control-label" for="gender_1">Male</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="gender_2" name="gender" class="custom-control-input" value="567">
                                                    <label class="custom-control-label" for="gender_2">Female</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleSt">Educational Attainment*</label>
                                                <select class="form-control custom-select" name="education_attainment" id="education_attainment">
                                                    <option value="" class="text-white bg-warning">Choose</option>
                                                    <option value="580">Elementary Graduate</option>
                                                    <option value="581">Highschool Graduate</option>
                                                    <option value="582">College Undergraduate</option>
                                                    <option value="583">College Graduate</option>
                                                    <option value="584">Vocational</option>
                                                    <option value="585">Post Graduate/ Doctorate</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleAccount">TIN</label>
                                                <input class="form-control mr-1 tin" id="tin" name="tin" placeholder="TIN" type="tel" maxlength="15">
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleAccount">SSS / GSIS NO.</label>
                                                <input class="form-control" name="sss_gsis" id="sss_gsis" placeholder="SSS / GSIS NO." type="text" maxlength="15">
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade">Present Address</b>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleSt">Region | Province | Municipality |
                                                    Barangay | Zip*</label>
                                                <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" minimumInputLength="3" style="width:100%; border-color:red !important" name="presentaddress" id="presentaddress">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                </select>
                                            </div>

                                            <!--div class="col-sm-3 pb-3">
                                    <label for="exampleSt">Region*</label> <select class="form-control custom-select" name="regiona" id="regiona" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    <?php
                                    foreach ($region as $reg) {
                                        echo '<option value = "' . $reg->regCode . '" data-id="' . $reg->regCode . '">' . $reg->regDesc . '</option>';
                                    }
                                    ?>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3">
                                    <label for="exampleSt">Province*</label> <select class="form-control custom-select" name="province" id="province" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3">
                                    <label for="exampleSt">Municipality/City*</label> <select class="form-control custom-select" name="city" id="city" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3">
                                    <label for="exampleSt">Barangay*</label> <select class="form-control custom-select" name="barangay" id="barangay" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div-->
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleAccount">Address (Unit No. / Building / Street)*
                                                </label>
                                                <input class="form-control" id="address" name="address" placeholder="Address" type="text">
                                            </div>
                                            <!--div class="col-sm-2 pb-3">
                                                    <label for="exampleAccount">Zip Code* </label>
                                                    <input class="form-control number" id="zip" name="zip"
                                                        placeholder="Zip Code" type="number"
                                                        oninput="this.value = Math.abs(this.value)">
                                                </div-->
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleSt">Residence Tenure (Length of Stay) <i>(ex: 2
                                                        years and 9 months)</i>*</label>
                                                <div class="form-inline">
                                                    <input class="form-control number" style="width:30%;" name="tenurecountyears" id="tenurecountyears" type="number" oninput="this.value = Math.abs(this.value)" onkeyup="stayTrigger()" />
                                                    <input class="form-control dis" style="width:20%;" type="text" value="Years">
                                                    <input class="form-control number" style="width:30%;" name="tenurecountmonths" id="tenurecountmonths" type="number" oninput="this.value = Math.abs(this.value)" onkeyup="stayTrigger()" />
                                                    <input class="form-control dis" style="width:20%;" type="text" value="Months">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <div class="form-check col-lg-12">
                                                    <input style="width:auto !important" class="form-check-input required-field" type="checkbox" name="sameadd" id="sameaddindi" onclick="sameaddress()">
                                                    <label class="form-check-label" for="agreement-checkbox">
                                                        Check this box if Present Address is the same as with
                                                        Permanent Address.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade permanentsub">Permanent Address</b>
                                            </div>
                                            <div class="col-sm-12 pb-3 permanentsub">
                                                <label for="exampleSt">Region | Province | Municipality |
                                                    Barangay | Zip*</label>
                                                <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" minimumInputLength="3" style="width:100%" name="permanentaddress" id="permanentaddress">
                                                    <option class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                </select>
                                            </div>
                                            <!--div class="col-sm-3 pb-3 permanentsub">
                                    <label for="exampleSt">Region*</label> <select class="form-control custom-select" name="region_sub" id="region_sub">
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    <?php
                                    foreach ($region as $reg) {
                                        echo '<option value = "' . $reg->regCode . '" data-id="' . $reg->regCode . '">' . $reg->regDesc . '</option>';
                                    }
                                    ?>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3 permanentsub">
                                    <label for="exampleSt">Province*</label> <select class="form-control custom-select" name="province_sub" id="province_sub">
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3 permanentsub">
                                    <label for="exampleSt">Municipality/City*</label> <select class="form-control custom-select" name="city_sub" id="city_sub" >
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3 permanentsub">
                                    <label for="exampleSt">Barangay*</label> <select class="form-control custom-select" name="barangay_sub" id="barangay_sub">
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div-->
                                            <div class="col-sm-12 pb-3 permanentsub">
                                                <label for="exampleAccount">Address (Unit No. / Building / Street)*
                                                </label>
                                                <input class="form-control" id="address_sub" name="address_sub" placeholder="Address" type="text">
                                            </div>
                                            <!--div class="col-sm-2 pb-3 permanentsub">
                                                    <label for="exampleAccount">Zip Code* </label>
                                                    <input class="form-control number" id="zip_sub" name="zip_sub"
                                                        placeholder="Zip Code" type="number"
                                                        oninput="this.value = Math.abs(this.value)">
                                                </div-->
                                            <!--div class="col-sm-3 pb-3 permanentadd" style="display:none;">
                                    <label for="exampleSt">Region*</label> <select class="form-control custom-select" name="region_per" id="region_per" disabled>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    <?php
                                    foreach ($region as $reg) {
                                        echo '<option value = "' . $reg->regCode . '" data-id="' . $reg->regCode . '">' . $reg->regDesc . '</option>';
                                    }
                                    ?>
                                    </select>
                                    </div>
                                                     <div class="col-sm-3 pb-3 permanentadd" style="display:none;">
                                    <label for="exampleSt">Province*</label> <select class="form-control custom-select" name="province_per" id="province_per" disabled>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    <?php
                                    foreach ($province as $prov) {
                                        echo '<option value = "' . $prov->provCode . '" data-id="' . $prov->provCode . '">' . $prov->provDesc . '</option>';
                                    }
                                    ?>
                                    </select>
                                    </div>
                                                     <div class="col-sm-3 pb-3 permanentadd" style="display:none;">
                                    <label for="exampleSt">Municipality/City*</label> <select class="form-control custom-select" name="city_per" id="city_per" disabled>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    <?php
                                    foreach ($city as $cit) {
                                        echo '<option value = "' . $cit->citymunCode . '" data-id="' . $cit->citymunCode . '">' . $cit->citymunDesc . '</option>';
                                    }
                                    ?>
                                    </select>
                                    </div>
                                                      <div class="col-sm-3 pb-3 permanentadd" style="display:none;">
                                    <label for="exampleSt">Barangay*</label> <select class="form-control custom-select" name="barangay_per" id="barangay_per" disabled>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    <?php
                                    foreach ($barangay as $brgy) {
                                        echo '<option value = "' . $brgy->brgyCode . '" data-id="' . $brgy->brgyCode . '">' . $brgy->brgyDesc . '</option>';
                                    }
                                    ?>
                                    </select>
                                    </div-->
                                            <div class="col-sm-12 pb-3 prev" style="">
                                                <b class="motortrade">Previous Address (If less than 2 years in
                                                    present address)</b>
                                            </div>
                                            <!--div class="col-sm-3 pb-3">
                                    <label for="exampleSt">Region*</label> <select class="form-control custom-select" name="region_prev" id="region_prev" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    <?php
                                    foreach ($region as $reg) {
                                        echo '<option value = "' . $reg->regCode . '" data-id="' . $reg->regCode . '">' . $reg->regDesc . '</option>';
                                    }
                                    ?>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3">
                                    <label for="exampleSt">Province*</label> <select class="form-control custom-select" name="province_prev" id="province_prev" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3">
                                    <label for="exampleSt">Municipality/City*</label> <select class="form-control custom-select" name="city_prev" id="city_prev" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3">
                                    <label for="exampleSt">Barangay*</label> <select class="form-control custom-select" name="barangay_prev" id="barangay_prev" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div-->
                                            <div class="col-sm-12 pb-3 prev">
                                                <label for="exampleSt">Region | Province | Municipality |
                                                    Barangay | Zip</label>
                                                <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" minimumInputLength="3" style="width:100%" name="previousaddress" id="previousaddress">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 pb-3 prev">
                                                <label for="exampleAccount">Address (Unit No. / Building / Street)
                                                </label>
                                                <input class="form-control" id="address_prev" name="address_prev" placeholder="Address" type="text">
                                            </div>
                                            <!--div class="col-sm-2 pb-3 prev">
                                                    <label for="exampleAccount">Zip Code </label>
                                                    <input class="form-control number" id="zip_prev" name="zip_prev"
                                                        placeholder="Zip Code" type="number"
                                                        oninput="this.value = Math.abs(this.value)">
-->
                                            <div class="col-sm-4 pb-3 ">
                                                <label for="exampleFirst">Facebook</label>
                                                <input class="form-control" id="facebook" name="facebook" placeholder="Facebook">
                                            </div>
                                            <div class="col-sm-4 pb-3 ">
                                                <label for="exampleFirst">Instagram</label>
                                                <input class="form-control" id="instagram" name="instagram" placeholder="Instagram">
                                            </div>
                                            <div class="col-sm-4 pb-3 ">
                                                <label for="exampleFirst">Others</label>
                                                <input class="form-control" id="other_social" name="other_social" placeholder="Others">
                                            </div>
                                            <div class="col-sm-5 pb-3 ">
                                                <label for="exampleFirst">Home Tel No.</label>
                                                <input class="form-control" id="home_tel" name="home_tel" placeholder="Home Tel No." type="home_tel">
                                            </div>
                                            <div class="col-sm-5 pb-3 ">
                                                <label for="exampleFirst">Home Fax No.</label>
                                                <input class="form-control" id="home_fax" name="home_fax" placeholder="Home Fax No." type="home_fax">
                                            </div>
                                            <div class="col-sm-2 pb-3 ">
                                                <label for="exampleFirst">No. of Dependent</label>
                                                <input class="form-control number" id="dependent" name="dependent" type="number" oninput="this.value = Math.abs(this.value)">
                                            </div>
                                        </div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleSt">Residence Type*</label>
                                                <select class="form-control custom-select" name="residence_type" id="residence_type">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
                                                    foreach ($residence_type as $residence) {
                                                        echo '<option value = "' . $residence->grid . '" data-id="' . $residence->grid . '">' . $residence->referencename . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!--div class="col-sm-12 pb-3 Mortgaged" style="display: none;">
                                    <label for="exampleFirst">Monthly Amortization (amount in Peso)*</label>
                                    <input class="form-control" id="amortization" name="amortization" type="number" oninput="this.value = Math.abs(this.value)">
                                    </div> 
                                                             <div class="col-sm-12 pb-3 Renting" style="display: none;">
                                    <label for="exampleFirst">Monthly Rental (amount in Peso)*</label>
                                    <input class="form-control" id="rental" name="rental" type="number" oninput="this.value = Math.abs(this.value)">
                                    </div>  
                                    <div class="col-sm-6 pb-3 Living With Relatives" style="display: none;">
                                    <label for="exampleFirst">Relative*</label>
                                    <input class="form-control" id="relative" name="relative" type="text">
                                    </div>  
                                    <div class="col-sm-6 pb-3 Living With Relatives" style="display: none;">
                                    <label for="exampleFirst">Name of Relative*</label>
                                    <input class="form-control" id="relative_name" name="relative_name" type="text">
                                    </div-->
                                        </div>
                                        <!--select name="tenureduration" style="width:50%;" id="tenureduration" class="form-control">
                                 <option>years</option>
                                 <option>months</option>
                                 </select-->
                                        <!--div class="row mt-4" style="border: 2px #ccc solid;">
                                 </div-->
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleSt">Marital Status*</label>
                                                <select class="form-control custom-select" name="marital_status" id="marital_status">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
                                                    foreach ($marital_status as $marital) {
                                                        echo '<option value = "' . $marital->grid . '" data-id="' . $marital->grid . '">' . $marital->referencename . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 pb-3 Divorced" style="display: none;">
                                                <label for="exampleFirst">Legally seperated for how many
                                                    years*</label>
                                                <input class="form-control" id="seperated_years" name="seperated_years" type="text">
                                            </div>
                                            <div class="col-sm-12 pb-3 Widowed" style="display: none;">
                                                <label for="exampleFirst">Widowed for how many years*</label>
                                                <input class="form-control" id="widow_years" name="widow_years" type="text">
                                            </div>
                                            <div class="col-sm-4 pb-3 Married">
                                                <label for="exampleFirst">Spouse / Live-In First Name*</label>
                                                <input class="form-control alp" id="spousefname" name="spousefname" type="text">
                                            </div>
                                            <div class="col-sm-4 pb-3 Married">
                                                <label for="exampleFirst">Spouse / Live-In Middle Name*</label>
                                                <input class="form-control alp" id="spousemname" name="spousemname" type="text">
                                            </div>
                                            <div class="col-sm-4 pb-3 Married">
                                                <label for="exampleFirst">Spouse / Live-In Last Name*</label>
                                                <input class="form-control alp" id="spouselname" name="spouselname" type="text">
                                            </div>
                                            <div class="col-sm-3 pb-3 Married">
                                                <label for="exampleAccount">Spouse / Live-In Nickname</label>
                                                <input class="form-control" name="spousenname" id="spousenname" type="text">
                                            </div>
                                            <div class="col-sm-3 pb-3 Married">
                                                <label for="exampleAccount">Spouse / Live-In Nationality</label>
                                                <input class="form-control" name="spouse_nationality" id="spouse_nationality" placeholder="Spouse Nationality" type="text" value="Filipino">
                                            </div>
                                            <div class="col-sm-4 pb-3 Married">
                                                <label for="exampleFirst">Spouse / Live-In Birthday (DD/MM/YYYY)* </label>
                                                <input class="form-control birthday" id="spouse_birthday" name="spouse_birthday" type="date">
                                            </div>
                                            <div class="col-sm-2 pb-3 Married">
                                                <label for="exampleFirst">Spouse / Live-In Age*</label>
                                                <input class="form-control number dis" id="spouse_age" name="spouse_age" type="number" oninput="this.value = Math.abs(this.value)">
                                            </div>
                                            <div class="col-sm-6 pb-3 Married">
                                                <label for="exampleFirst">Spouse / Live-In Contact Number*</label>
                                                <input class="form-control mobile" autocomplete="new-password" id="spouse_contact" name="spouse_contact" type='tel' placeholder="09XX-XXXXXXX" maxlength="12" onkeypress="return onlyNumberKey(event)">
                                            </div>
                                            <div class="col-sm-6 pb-3 Married">
                                                <label for="exampleFirst">Spouse / Live-In Tel No.</label>
                                                <input class="form-control" id="spouse_telno" name="spouse_telno" type='number'>
                                            </div>

                                            <div class="col-sm-6 pb-3 Married">
                                                <label for="exampleFirst">Spouse Address*</label>
                                                <input class="form-control" id="spouse_address" name="spouse_address" type="text">
                                            </div>
                                            <div class="col-sm-6 pb-3 Married">
                                                <label for="exampleFirst">Spouse Birthplace*</label>
                                                <input class="form-control" id="spouse_birthplace" name="spouse_birthplace" type="text">
                                            </div>
                                        </div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleSt">Borrower Type*</label>
                                                <select class="form-control custom-select" name="borrower_type" id="borrower_type">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
                                                    foreach ($borrower_group as $borrower_grou) {
                                                        echo '<optgroup label="---' . $borrower_grou->option_group . '---">';
                                                        foreach ($borrower as $borrow) {
                                                            if ($borrower_grou->option_group == $borrow->option_group) {
                                                                echo '<option value = "' . $borrow->grid . '" data-id="' . $borrow->grid . '">' . $borrow->referencename . '</option>';
                                                            }
                                                        }
                                                        echo '</optgroup>';
                                                    }
                                                    /*  foreach ($source_income as $source_incom){
                                                echo '<option value = "'.$source_incom->grid.'" data-id="'.$source_incom->grid.'">'.$source_incom->referencename.'</option>';
                                            } */
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade">Present Employer / Business</b>
                                            </div>

                                            <div class="col-sm-8 pb-3 borrowbusiness">
                                                <label for="exampleSt">Nature of Work / Business*</label>
                                                <select class="form-control custom-select" name="borrower_nature" id="borrower_nature">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
                                                    foreach ($borrower_nature as $borrower_natur) {
                                                        echo '<option value = "' . $borrower_natur->grid . '" >' . $borrower_natur->referencename . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 pb-3 borrowbusiness">
                                                <label for="exampleSt">Size of Business*</label>
                                                <select class="form-control custom-select" name="borrower_size" id="borrower_size">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
                                                    foreach ($borrower_size as $borrower_siz) {
                                                        echo '<option value = "' . $borrower_siz->grid . '" >' . $borrower_siz->referencename . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!--div class="col-sm-12 pb-3">
                                    <label for="exampleSt">Source of Income*</label> <select class="form-control custom-select" name="source_income" id="source_income" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                      <?php
                                        foreach ($source_income_group as $source_income_grou) {
                                            echo '<optgroup label="---' . $source_income_grou->option_group . '---">';
                                            foreach ($source_income as $source_incom) {
                                                if ($source_income_grou->option_group == $source_incom->option_group) {
                                                    echo '<option value = "' . $source_incom->grid . '" data-id="' . $source_incom->grid . '">' . $source_incom->referencename . '</option>';
                                                }
                                            }
                                            echo '</optgroup>';
                                        }
                                        /*  foreach ($source_income as $source_incom){
                                             echo '<option value = "'.$source_incom->grid.'" data-id="'.$source_incom->grid.'">'.$source_incom->referencename.'</option>';
                                         } */
                                        ?>
                                    </select>
                                    </div-->
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Company Name/ Business Name/ Others
                                                    (if-self employed)*</label>
                                                <input class="form-control" id="company_name" name="company_name" type="text">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Length of Existence <i>(ex: 2 years and 9
                                                        months)</i>*</label>
                                                <div class="form-inline">
                                                    <input class="form-control number" style="width:30%;" name="existencelengthyears" id="existencelengthyears" type="number" oninput="this.value = Math.abs(this.value)" />
                                                    <input class="form-control dis" style="width:20%;" type="text" value="Years">
                                                    <input class="form-control number" style="width:30%;" name="existencelengthmonths" id="existencelengthmonths" type="number" oninput="this.value = Math.abs(this.value)" />
                                                    <input class="form-control dis" style="width:20%;" type="text" value="Months">
                                                </div>
                                                <!--input class="form-control" id="existence_length" name="existence_length" type="number" oninput="this.value = Math.abs(this.value)"-->
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleFirst">Rank / Position in Current Job*</label>
                                                <input class="form-control" id="position" name="position" type="text">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Status*</label>
                                                <select class="form-control custom-select" name="position_status" id="position_status">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
                                                    foreach ($status as $stat) {
                                                        echo '<option value = "' . $stat->grid . '" >' . $stat->referencename . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleSt">Is Your Business Registered?*</label><br />
                                                <input type="hidden" id="register" name="type_new" value="561" />
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="register_1" name="register" class="custom-control-input" value="561" checked>
                                                    <label class="custom-control-label" for="register_1">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="register_2" name="register" class="custom-control-input" value="562">
                                                    <label class="custom-control-label" for="register_2">No</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label>Company / Business Address:</label>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleSt">Region | Province | Municipality |
                                                    Barangay | Zip*</label>
                                                <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" minimumInputLength="3" style="width:100%" name="busaddress" id="busaddress">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                </select>
                                            </div>
                                            <!--div class="col-sm-3 pb-3 businessadd">
                                    <label for="exampleSt">Region*</label> <select class="form-control custom-select" name="region_bus" id="region_bus" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    <?php
                                    foreach ($region as $reg) {
                                        echo '<option value = "' . $reg->regCode . '" data-id="' . $reg->regCode . '">' . $reg->regDesc . '</option>';
                                    }
                                    ?>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3 businessadd">
                                    <label for="exampleSt">Province*</label> <select class="form-control custom-select" name="province_bus" id="province_bus" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3 businessadd">
                                    <label for="exampleSt">Municipality/City*</label> <select class="form-control custom-select" name="city_bus" id="city_bus" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div>
                                                    <div class="col-sm-3 pb-3 businessadd">
                                    <label for="exampleSt">Barangay*</label> <select class="form-control custom-select" name="barangay_bus" id="barangay_bus" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    </select>
                                    </div-->
                                            <div class="col-sm-12 pb-3 businessadd">
                                                <label for="exampleAccount">Address (Unit No. / Building / Street)*
                                                </label>
                                                <input class="form-control" id="address_bus" name="address_bus" placeholder="Address" type="text">
                                            </div>
                                            <!--div class="col-sm-2 pb-3 businessadd">
                                                    <label for="exampleAccount">Zip Code* </label>
                                                    <input class="form-control number" id="zip_bus" name="zip_bus"
                                                        placeholder="Zip Code" type="number"
                                                        oninput="this.value = Math.abs(this.value)">
                                                </div-->
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleFirst">Nature of Work</label>
                                                <input class="form-control" id="nature_work" name="nature_work" type="text">
                                            </div>
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleFirst">Tel / Fax No</label>
                                                <input class="form-control number" id="telephone_no" name="telephone_no" type="number" oninput="this.value = Math.abs(this.value)">
                                            </div>
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleFirst">Email Address</label>
                                                <input class="form-control" id="previous_email" name="previous_email" type="email">
                                            </div>
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleFirst">No. of Years in Business*</label>
                                                <input class="form-control number" id="years_business" name="years_business" type="number" oninput="this.value = Math.abs(this.value)">
                                            </div>

                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade">Previous Employer</b>
                                            </div>

                                            <div class="col-sm-8 pb-3">
                                                <label for="exampleFirst">Name of Previous Employer</label>
                                                <input class="form-control" id="previous_employer_name" name="previous_employer_name" type="text">
                                            </div>

                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleFirst">Tel No</label>
                                                <input class="form-control" id="previous_employer_telno" name="previous_employer_telno" type="text">
                                            </div>



                                            <div class="col-sm-12 pb-3">
                                                <label>Previous Employer Address:</label>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleSt">Region | Province | Municipality |
                                                    Barangay | Zip</label>
                                                <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" minimumInputLength="3" style="width:100%" name="previous_employer_address" id="previous_employer_address">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 pb-3 businessadd">
                                                <label for="exampleAccount">Address (Unit No. / Building / Street)
                                                </label>
                                                <input class="form-control" id="previous_employer_street" name="previous_employer_street" placeholder="Address" type="text">
                                            </div>
                                            <!--div class="col-sm-2 pb-3 businessadd">
                                                    <label for="exampleAccount">Zip Code* </label>
                                                    <input class="form-control number" id="previous_employer_zip"
                                                        name="previous_employer_zip" placeholder="Zip Code"
                                                        type="number" oninput="this.value = Math.abs(this.value)">
                                                </div-->


                                            <div class="col-sm-4 pb-3">
                                                <label for="exampleFirst">Rank / Position in Previous Job</label>
                                                <input class="form-control" id="previous_job" name="previous_job" type="text">
                                            </div>
                                            <div class="col-sm-8 pb-3">
                                                <label for="exampleFirst">Length of Existence <i>(ex: 2 years and 9
                                                        months)</i></label>
                                                <div class="form-inline">
                                                    <input class="form-control number" style="width:30%;" name="previouselengthyears" id="previouslengthyears" type="number" oninput="this.value = Math.abs(this.value)" />
                                                    <input class="form-control dis" style="width:20%;" type="text" value="Years">
                                                    <input class="form-control number" style="width:30%;" name="previouslengthmonths" id="previouslengthmonths" type="number" oninput="this.value = Math.abs(this.value)" />
                                                    <input class="form-control dis" style="width:20%;" type="text" value="Months">
                                                </div>
                                            </div>

                                            <!--div class="col-sm-6 pb-3 selfemployed" style="display: none;">
                                    <label for="exampleFirst">Business Name*</label>
                                    <input class="form-control" id="business_name" name="business_name" type="text">
                                    </div> 
                                    
                                                      <div class="col-sm-6 pb-3 selfemployed" style="display: none;">
                                    <label for="exampleFirst">Business Nature*</label>
                                    <input class="form-control" id="business_nature" name="business_nature" type="text">
                                    </div> 
                                    
                                    <div class="col-sm-12 pb-3 ofw" style="display: none;">
                                    <label for="exampleFirst">Country of Origin*</label>
                                    <input class="form-control" id="country_assignment" name="country_assignment" type="text">
                                    </div> 
                                    
                                                      <div class="col-sm-6 pb-3 xofw" style="display: none;">
                                    <label for="exampleFirst">Boarding Date*</label>
                                    <input class="form-control" id="boarding_date" name="boarding_date" type="date">
                                    </div> 
                                    <div class="col-sm-12 pb-3 recipient" style="display: none;">
                                    <label for="exampleFirst">Name of Provider*</label>
                                    <input class="form-control" id="sender" name="sender" type="text">
                                    </div> 
                                    
                                    <div class="col-sm-6 pb-3 tenurelength" style="display: none;">
                                    <label for="exampleFirst">Length of Tenure*</label>
                                                        <div class="form-inline">
                                      <input class="form-control" style="width:30%;" name="tenurelengthyears" id="tenurelengthyears" type="number" oninput="this.value = Math.abs(this.value)" />
                                      <input class="form-control" style="width:20%;" type="text" value="Years" disabled/>
                                      <input class="form-control" style="width:30%;" name="tenurelengthmonths" id="tenurelengthmonths" type="number" oninput="this.value = Math.abs(this.value)" />
                                      <input class="form-control" style="width:20%;" type="text" value="Months" disabled/>
                                    </div-->
                                            <!--input class="form-control" id="tenure_length" name="tenure_length" type="number" oninput="this.value = Math.abs(this.value)"-->

                                            <div class="col-sm-6 pb-3 monthlyincome" style="display: none;">
                                                <label for="exampleFirst">Monthly Income*</label>
                                                <input class="form-control number" id="monthly_income" name="monthly_income" type="number" oninput="this.value = Math.abs(this.value)">
                                            </div>
                                            <div class="col-sm-6 pb-3 monthlyremittance" style="display: none;">
                                                <label for="exampleFirst">Monthly Provision*</label>
                                                <input class="form-control number" id="monthly_remittance" name="monthly_remittance" type="number" oninput="this.value = Math.abs(this.value)">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"> <input type="button" id="tabtwo" class="action-button" value="Save and Next">
                                    <input type="button" id="twoproc" name="next" style="display: none;" class="next action-button">
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Monthly Income Computation</h2>
                                        <h5 class="alignright">Form Record ID: <span class="recid"></span></h5>
                                        <div style="clear: both;"></div>
                                        <div id="div_selector">
                                            <div class="row mt-4" style="border: 2px #ccc solid;">
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleSt">Sources of Fund*</label>
                                                    <select class="form-control custom-select" name="source_fund" id="source_fund">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                        <option value="633" data-id="633">Employment</option>
                                                        <option value="634" data-id="634">Business/Self-Employed</option>
                                                        <option value="635" data-id="635">Remittance</option>
                                                        <option value="636" data-id="636">Pension</option>
                                                        <option value="2139" data-id="2139">OFW/Seaman</option>
                                                        <option value="637" data-id="637">Others(Please Specify)</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Salary</label>
                                                    <input class="form-control" id="salary" name="salary" data-type="currency" placeholder="ex: 1,000" type="text" onkeyup="compute()">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Business Income</label>
                                                    <input class="form-control" id="business_income" name="business_income" data-type="currency" placeholder="ex: 1,000" type="text" onkeyup="compute()">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Other Income</label>
                                                    <input class="form-control" id="other_income" name="other_income" data-type="currency" placeholder="ex: 1,000" type="text" onkeyup="compute()">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Gross Income (Salary + Business + Other)</label>
                                                    <input class="form-control dis" id="gross_income" name="gross_income" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"> <input type="button" id="tabthree" class="action-button" value="Save and Next">
                                    <input type="button" id="threeproc" name="next" style="display: none;" class="next action-button">
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Existing Loans</h2>
                                        <h5 class="alignright">Form Record ID: <span class="recid"></span></h5>
                                        <div style="clear: both;"></div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade">Existing Loan # 1</b>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleAccount">Bank / Financial Institution</label>
                                                <input class="form-control" name="l1_bank" id="l1_bank" type="text">
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleFirst">Loan Type</label>
                                                <input class="form-control" id="l1_type" name="l1_type" type="text">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleLast ">Loan Amount</label>
                                                <input class="form-control" id="l1_amount" name="l1_amount" type="number">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Monthly Installment</label>
                                                <input class="form-control" id="l1_monthly" name="l1_monthly" type="text">
                                            </div>
                                            <div class="col-sm-2 pb-3">
                                                <label for="exampleFirst">Terms</label>
                                                <input class="form-control" id="l1_terms" name="l1_term" type="number">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Date Granted</label>
                                                <input class="form-control" id="l1_granted" name="l1_granted" type="date">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Maturity Date</label>
                                                <input class="form-control" id="l1_maturity" name="l1_maturity" type="date">
                                            </div>
                                        </div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade">Existing Loan # 2</b>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleAccount">Bank / Financial Institution</label>
                                                <input class="form-control" name="l2_bank" id="l2_bank" type="text">
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleFirst">Loan Type</label>
                                                <input class="form-control" id="l2_type" name="l2_type" type="text">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleLast ">Loan Amount</label>
                                                <input class="form-control" id="l2_amount" name="l2_amount" type="number">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Monthly Installment</label>
                                                <input class="form-control" id="l2_monthly" name="l2_monthly" type="text">
                                            </div>
                                            <div class="col-sm-2 pb-3">
                                                <label for="exampleFirst">Terms</label>
                                                <input class="form-control" id="l2_terms" name="l2_term" type="number">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Date Granted</label>
                                                <input class="form-control" id="l2_granted" name="l2_granted" type="date">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Maturity Date</label>
                                                <input class="form-control" id="l2_maturity" name="l2_maturity" type="date">
                                            </div>
                                        </div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade">Existing Loan # 3</b>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleAccount">Bank / Financial Institution</label>
                                                <input class="form-control" name="l3_bank" id="l3_bank" type="text">
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleFirst">Loan Type</label>
                                                <input class="form-control" id="l3_type" name="l3_type" type="text">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleLast ">Loan Amount</label>
                                                <input class="form-control" id="l3_amount" name="l3_amount" type="number">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Monthly Installment</label>
                                                <input class="form-control" id="l3_monthly" name="l3_monthly" type="text">
                                            </div>
                                            <div class="col-sm-2 pb-3">
                                                <label for="exampleFirst">Terms</label>
                                                <input class="form-control" id="l3_terms" name="l3_term" type="number">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Date Granted</label>
                                                <input class="form-control" id="l3_granted" name="l3_granted" type="date">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Maturity Date</label>
                                                <input class="form-control" id="l3_maturity" name="l3_maturity" type="date">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"> <input type="button" id="tabfour" class="action-button" value="Save and Next">
                                    <input type="button" id="fourproc" name="next" style="display: none;" class="next action-button">
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">References</h2>
                                        <h5 class="alignright">Form Record ID: <span class="recid"></span></h5>
                                        <div style="clear: both;"></div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade">Reference # 1</b>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleAccount">Full Name*</label>
                                                <input class="form-control alp" name="r1_name" id="r1_name" placeholder="Full Name" type="text">
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleFirst">Address*</label>
                                                <input class="form-control" id="r1_address" name="r1_address" type="text">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleLast ">Mobile Number* <i>(example: 0918-1234567)</i></label>
                                                <input class="form-control mobile" id="r1_contact_no" placeholder="09XX-XXXXXXX" name="r1_contact_no" type="tel" maxlength="12" onkeypress="return onlyNumberKey(event)">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Relationship*</label>
                                                <input class="form-control" id="r1_relationship" name="r1_relationship" type="text">
                                            </div>
                                        </div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade">Reference # 2</b>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleAccount">Full Name*</label>
                                                <input class="form-control alp" name="r2_name" id="r2_name" placeholder="Full Name" type="text">
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleFirst">Address*</label>
                                                <input class="form-control" id="r2_address" name="r2_address" type="text">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleLast ">Mobile Number* <i>(example: 0918-1234567)</i></label>
                                                <input class="form-control mobile" id="r2_contact_no" name="r2_contact_no" placeholder="09XX-XXXXXXX" type="tel" maxlength="12" onkeypress="return onlyNumberKey(event)">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Relationship*</label>
                                                <input class="form-control" id="r2_relationship" name="r2_relationship" type="text">
                                            </div>
                                        </div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="col-sm-12 pb-3">
                                                <b class="motortrade">Reference # 3</b>
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleAccount">Full Name*</label>
                                                <input class="form-control alp" name="r3_name" id="r3_name" placeholder="Full Name" type="text">
                                            </div>
                                            <div class="col-sm-12 pb-3">
                                                <label for="exampleFirst">Address*</label>
                                                <input class="form-control" id="r3_address" name="r3_address" type="text">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleLast ">Mobile Number* <i>(example: 0918-1234567)</i></label>
                                                <input class="form-control mobile" id="r3_contact_no" name="r3_contact_no" type="tel" maxlength="12" placeholder="09XX-XXXXXXX" onkeypress="return onlyNumberKey(event)">
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Relationship*</label>
                                                <input class="form-control" id="r3_relationship" name="r3_relationship" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"> <input type="button" id="tabfive" class="action-button" value="Save and Next">
                                    <input type="button" id="fiveproc" name="next" style="display: none;" class="next action-button">
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Attachments & Signature</h2>
                                        <h5 class="alignright">Form Record ID: <span class="recid"></span></h5>
                                        <div style="clear: both;"></div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <div class="refattach" style="display: none;">
                                                <div style="margin-left: 1em">
                                                    <div class="container py-3">
                                                        <div class="input-group" style="display:none;">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input upload-file" id="govtid" data-max-size="2048" name="govtid" accept="image/jpeg, image/png, application/pdf," aria-describedby="govtid">
                                                                <label class="custom-file-label" id="govtidlab" for="govtid" style="color:gray">Upload one valid ID (Government ID, Driver's License, etc) *</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" id="govtidrem"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input upload-file" id="coe" data-max-size="2048" name="coe" accept="image/jpeg, image/png, application/pdf," aria-describedby="coe">
                                                                <label class="custom-file-label" id="coelab" for="coe" style="color:gray">Upload your current Certificate of Employment</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" id="coerem"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input upload-file" id="billing" data-max-size="2048" name="billing" accept="image/jpeg, image/png, application/pdf," aria-describedby="billing">
                                                                <label class="custom-file-label" id="billinglab" for="billing" style="color:gray">Proof of billing</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" id="billingrem"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input upload-file" id="selfie" data-max-size="2048" name="selfie" accept="image/jpeg, image/png, application/pdf," aria-describedby="selfie">
                                                                <label class="custom-file-label" id="selfielab" for="selfie" style="color:gray">Selfie</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" id="selfierem"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input upload-file" id="sketch" data-max-size="2048" name="sketch" accept="image/jpeg, image/png, application/pdf," aria-describedby="sketch">
                                                                <label class="custom-file-label" id="sketchlab" for="sketch" style="color:gray">Sketch of home</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" id="sketchrem"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="attachments col-md-6 pt-3">
                                                <div class="upload-display" id="attach_company_id">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">Company ID</p>
                                                        <input type="file" class="fileinput" data-name="company_id" id="company_id" name="company_id" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="company_id" class="custom-file-upload">Attach file</label>
                                                        <span id="name_company_id"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_valid_id">
                                                    <div class="upload-wrapper">
                                                        <p style="color:black !important;margin:unset">Goverment ID</p>
                                                        <input type="file" class="fileinput" data-name="valid_id" id="valid_id" name="valid_id" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="valid_id" class="custom-file-upload">Attach file</label>
                                                        <span id="name_valid_id"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="" id="attach_selfiepic">
                                                    <div class="upload-wrapper">
                                                        <p style="color:black !important;margin:unset">Selfie Photo</p>
                                                        <input type="file" class="fileinput" data-name="selfiepic" id="selfiepic" name="selfiepic" accept=".txt, .pdf, .doc, .docx ,.png, .jpg" required>
                                                        <label for="selfiepic" class="custom-file-upload">Attach file</label>
                                                        <span id="name_selfiepic"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="" id="attach_holding_id">
                                                    <div class="upload-wrapper">
                                                        <p style="color:black !important;margin:unset">Selfie w/ Holding 2 valid ID's</p>
                                                        <input type="file" class="fileinput" data-name="holding_id" id="holding_id" name="holding_id" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="holding_id" class="custom-file-upload">Attach file</label>
                                                        <span id="name_holding_id"></span>
                                                        <hr>
                                                    </div>
                                                </div>


                                                <div class="upload-display" id="attach_payslip">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">1 Month Payslip or Vouncher at least 2 months </p>
                                                        <input type="file" class="fileinput" data-name="payslip" id="payslip" name="payslip" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="payslip" class="custom-file-upload">Attach file</label>
                                                        <span id="name_payslip"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_coe">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">Certificate of Employment with Compensation</p>
                                                        <input type="file" class="fileinput" data-name="cert_of_emp" id="cert_of_emp" name="cert_of_emp" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="cert_of_emp" class="custom-file-upload">Attach file</label>
                                                        <span id="name_cert_of_emp"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_voucher">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">Voucher at least 2 months</p>
                                                        <input type="file" class="fileinput" data-name="voucher" id="voucher" name="voucher" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="voucher" class="custom-file-upload">Attach file</label>
                                                        <span id="name_voucher"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_permit">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">Business/Barangay/Mayor's Permit</p>
                                                        <input type="file" class="fileinput" data-name="permit" id="permit" name="permit" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="permit" class="custom-file-upload">Attach file</label>
                                                        <span id="name_permit"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_transaction_history">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">Transaction History At least 1 months</p>
                                                        <input type="file" class="fileinput" data-name="tran_history" id="tran_history" name="tran_history" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="tran_history" class="custom-file-upload">Attach file</label>
                                                        <span id="name_tran_history"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_tnvs">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">Screenshot of tnvs profile</p>
                                                        <input type="file" class="tnvs" data-name="tnvs" id="tnvs" name="tnvs" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="tnvs" class="custom-file-upload">Attach file</label>
                                                        <span id="name_tnvs"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_remittance">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">At least 3 months latest remittance/statement of account</p>
                                                        <input type="file" class="fileinput" data-name="remittance" id="remittance" name="remittance" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="remittance" class="custom-file-upload">Attach file</label>
                                                        <span id="name_remittance"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_statement_account">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">Statement of account</p>
                                                        <input type="file" class="fileinput" data-name="statement_account" id="statement_account" name="statement_account" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="statement_account" class="custom-file-upload">Attach file</label>
                                                        <span id="name_statement_account"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_contract">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">Latest Contract/Return ticket</p>
                                                        <input type="file" class="fileinput" data-name="contract" id="contract" name="contract" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="contract" class="custom-file-upload">Attach file</label>
                                                        <span id="name_contract"></span>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="upload-display" id="attach_proof_income">
                                                    <div class="upload-wrapper" id="">
                                                        <p style="color:black !important;margin:unset">Proof of Income</p>
                                                        <input type="file" class="fileinput" data-name="proof_income" id="proof_income" name="proof_income" accept=".txt, .pdf, .doc, .docx">
                                                        <label for="proof_income" class="custom-file-upload">Attach file</label>
                                                        <span id="name_proof_income"></span>
                                                        <hr>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="refsigna col-md-6 pt-3" hidden>
                                                <div style="margin-left: 1em">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p style="color:black !important">Please sign the field below.</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <canvas id="sig-canvas" width="593.6700000000001" height="160">
                                                                    Get a better browser, bro.
                                                                </canvas>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                
                                                                <button id="sig-clearBtn" type="button">Clear Signature</button>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <textarea id="sig-dataUrl" class="form-control" name="sig-dataUrl" rows="5" style="display: none !important;"></textarea>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1em">
                                            <br>
                                            <!--input type="checkbox" id="myChecked" onclick="myFunctions()"> I have provided all the correct information above and I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank">Data Privacy Statement</a> of Motortrade.-->
                                            <!--div class="g-recaptcha" data-sitekey="6LfXVKsZAAAAAIkD1-AyIouCrO-uiey9uhXBwc_K" data-theme="light" data-type="image" data-size="normal" data-callback="recaptchaCallback">
                                   <div style="width: 304px; height: 78px;">
                                      <div><iframe src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LfXVKsZAAAAAIkD1-AyIouCrO-uiey9uhXBwc_K&amp;co=aHR0cDovLzE3Mi4xOC4wLjIyOjgwODA.&amp;hl=en&amp;type=image&amp;v=-nejAZ5my6jV0Fbx9re8ChMK&amp;theme=light&amp;size=normal&amp;cb=n1vrxkdx17yn" width="304" height="78" role="presentation" name="a-86vf2o6lwdqi" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div>
                                      <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                                   </div>
                                   <iframe style="display: none;"></iframe>
                                </div-->
                                            <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?render=onload&amp;hl=en" async="" defer=""></script>
                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"> <input type="button" id="proceedform" class="action-button" value="Confirm">
                                    <input type="submit" id="sixproc" name="next" style="display: none;" class="next action-button">
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Finish:</h2>
                                            </div>
                                        </div> <br><br>
                                        <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>
                                        <div class="row justify-content-center">
                                            <div class="col-3"> <img src="https://i.imgur.com/GwStPmg.png" class="fit-image"> </div>
                                        </div> <br><br>
                                        <div class="row justify-content-center">
                                            <div class="col-7 text-center">
                                                <h5 class="purple-text text-center">You Have Successfully Created Loan Application</h5>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ajax-loader d-flex justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; ">
        <div style="background: linear-gradient(#000, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #000); opacity: .5; position: absolute; width: 100%; height: 100%;">
        </div>
        <img src="assets/loader-1.gif" style="height: 10% !important;" class="align-self-center">
    </div>
    <script language="JavaScript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $('#uploaddl').change(function() {
            //alert('test');
            var form = new FormData(document.getElementById('msform'));
            form.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
            //append files
            var file = document.getElementById('uploaddl').files[0];
            if (file) {
                form.append('uploaddl', file);
            }
            $.ajax({
                type: "POST",
                url: "Loan/verify_id",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {}
            });

        });
        $("#sourceid").val();
        $('input[type="file"]').change(function() {
            var fileExtension = ['jpeg', 'jpg', 'png', 'pdf'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only formats are allowed : " + fileExtension.join(', '));
                $(this).val('');
            }
            if (this.files[0].size > 1000000) {
                alert("File size must not be greater than 1 mb.");
                $(this).val('');
            }
        });
        var branches = '<?php echo addcslashes(json_encode($branches), "'\\/"); ?>';
        var objbr = JSON.parse(branches);
        var model = '<?php echo json_encode($model); ?>';
        var objm = JSON.parse(model);
        var clusters = '<?php echo addcslashes(json_encode($clusters), "'\\/"); ?>';
        var objcl = JSON.parse(clusters);
        //alert(JSON.stringify(objm));    
    </script>
    <script src="<?= base_url(); ?>assets/js/common.js?1"></script>
    <script src="<?= base_url(); ?>assets/js/newloan1.js?8"></script>
    <?= _getfooterlayout() ?>
    <script>
        $('#version').text('v2.1.1 (National)')
        $('#background-building').css('display', 'none')
        if ($(window).width() < 990) {
            // $('#nav-image').css('width', '112%')
            $('.dropdown-menu').css('left', '0px')
        } else {

            $('#background-building').css('height', '117%')
        }

        $('.fileInput').change(function() {
            var name = $(this).data('name');
            var file = this.files[0];
            $('#name_' + name).text('File Name: ' + file.name);
            $('#fileSize').text('File Size: ' + getFileSize(file.size));

            var fileType = file.type.split('/')[0];
            if (fileType === 'image') {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').html('<img src="' + e.target.result + '" alt="Preview">');
                }
                reader.readAsDataURL(file);
            } else {
                $('#preview').html('<p>File type not supported for preview.</p>');
            }
        });
    </script>

</body>

</html>