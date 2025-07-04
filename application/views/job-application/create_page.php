<!DOCTYPE html>
<html lang="en">

<head>
  <title>Job Application Form | Motortrade Group</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
  <link rel="icon" href="<?= base_url(); ?>assets/favicon.ico">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/inquiry.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/css/select2.min.css">
  <link href="<?= base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script>
    var base_url = "<?= base_url(); ?>";
  </script>
  <script>
    var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

      for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
          return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
      }
    };
  </script>
  <style>
    .submitForm {
      background-color: #1D3494;
    }

    .submitForm:hover {
      background-color: #fee401 !important;
      color: black;
    }
  </style>
</head>

<body>
  <div id="div_result">
    <p id="demo"></p>
    <form action="<?= base_url(); ?>jobapplication/submit" method="POST" onsubmit="return validate(this);" autocomplete="off" enctype="multipart/form-data">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
      <input type="hidden" name="sourceparam" id="sourceparam" />
      <input type="hidden" name="clusterparam" id="clusterparam" />
      <input type="hidden" name="mrfId" id="mrfId" value="<?= $mrfId; ?>">
      <div class="row">
        <div class="col-md-10 offset-md-1">
          <span class="anchor" id="formComplex"></span>
          <div class="modal bd-example-modal-sm fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="testd">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                  </button>
                  <h5 align="center"><img src="<?= base_url(); ?>assets/mopom.jpg" alt=""></h5>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">
                    <h5>Enter Mobile Number Verification</h5>
                    We've sent a One Time Password (OTP) to your phone number. Please enter it below within 5 minutes.
                    <br /><br />
                    <b>Enter OTP</b>
                    <input type="number" class="form-control otp-input modal-ku" id="otp-input" placeholder="OTP Code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="text-align:center" maxlength="4" aria-describedby="passwordHelpInline" required>
                    <input type="hidden" id="hiddenOTP">
                    <br />
                    <button type="button" id="submitModal" class="btn btn-primary btn-block">Continue</button>
                    <div align="center" id="modalfin">
                      <br />
                      <span id="resending"></span> | <a href="#" data-dismiss="modal">Cancel</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card card-outline-secondary">
            <div class="card-header">
              <h3 class="mb-0">Job Application Form<span style="font-size: 8pt">v1.0.0</span></h3>
            </div>
            <div class="card-body">
              <h5 class="mb-0">Job Applicant Information</h5>
              <div class="row mt-4">
                <div class="col-sm-4 pb-3">
                  <label for="exampleAccount">*First Name</label>
                  <input class="form-control" name="applicant_fname" id="applicant_fname" placeholder="Juan" type="text" required>
                </div>
                <div class="col-sm-3 pb-3">
                  <label for="exampleAccount">Middle Name</label>
                  <input class="form-control" name="applicant_mname" id="applicant_mname" placeholder="Martinez" type="text">
                </div>
                <div class="col-sm-4 pb-3">
                  <label for="exampleAccount">*Last Name</label>
                  <input class="form-control" name="applicant_lname" id="applicant_lname" placeholder="Dela Cruz" type="text" required>
                </div>
                <div class="col-sm-1 pb-3">
                  <label for="exampleAccount">Suffix</label>
                  <input class="form-control" name="applicant_suffix" id="applicant_suffix" placeholder="Jr" type="text" minimumInputLength="2" maxlength="3">
                </div>
                <div class="col-sm-12 pb-3">
                  <label for="exampleSt">*Region | Province | Municipality | Barangay</label>
                  <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" style="width: 100%" minimumInputLength="3" name="psgc" id="psgc">
                    <option value="" class="text-white bg-warning">
                      Choose
                    </option>
                    <?php
                    foreach ($region as $reg) :
                      echo '<option value = "' . $reg->regCode . '" data-id="' . $reg->regCode . '">' . $reg->regDesc . '</option>';
                    endforeach;
                    ?>
                  </select>
                </div>
                <div class="col-sm-12 pb-3">
                  <label for="exampleAccount">*Address (Unit No. / Building / Street) </label>
                  <input class="form-control" id="applicant_address" name="applicant_address" placeholder="Unit No./Building/Street" type="text" required>
                </div>
                <div class="col-sm-5 pb-3 ">
                  <label for="exampleFirst">*Email Address</label>
                  <input class="form-control" id="applicant_email" name="applicant_email" placeholder="juandelacruz@gmail.com" type="email" required>
                </div>
                <div class="col-sm-4 pb-3 ">
                  <label for="exampleFirst">*Mobile Number <i>(example: 0918-1234567)</i></label>
                  <input class="form-control mr-1" id="contact_no" name="contact_no" placeholder="09XX-XXXXXXX" type='tel' maxlength="12" onkeypress="return onlyNumberKey(event)" required>
                </div>
                <div class="col-sm-3 pb-3">
                  <label for="exampleFirst">*Birthdate</label>
                  <input class="form-control" id="applicant_birthdate" name="applicant_birthdate" placeholder="" type="date" required>
                </div>
                <div class="col-sm-4 pb-3">
                  <label for="desired_position">*Course</label>
                  <select class="desired_position form-control required-field use-select2" id="applicant_course" name="applicant_course" required>
                    <?php
                    foreach ($courses as $course) :
                      echo '<option value = "' . $course['value'] . '" data-id="' . $course['value'] . '">' . $course['description'] . '</option>';
                    endforeach;
                    ?>
                  </select>
                  </select>
                </div>
                <div class="col-sm-3 pb-3">
                  <label for="exampleAccount">Desired Position</label>
                  <input class="form-control" id="applicant_desired_position" name="applicant_desired_position" placeholder="IT Consultant" type="text">
                </div>
                <div class="col-sm-3 pb-3">
                  <label for="exampleAccount">Recent Position / Company</label>
                  <input class="form-control" id="applicant_current_position" name="applicant_current_position" placeholder="Marketing" type="text">
                </div>
                <div class="col-sm-2 pb-3">
                  <label for="exampleAccount">Expected Salary</label>
                  <input class="form-control" id="applicant_expected_salary" name="applicant_expected_salary" placeholder="0.00" data-type="currency" type="text">
                </div>
                <div class="row" style="margin-bottom: 1rem; margin-left: 20px">
                  <div class="row ml-0">
                    <div class="row">
                      <div class="col-md-12">
                        <p>Upload Resume <i>(Maximum of 1MB filesize)</i></p>
                      </div>
                    </div>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input upload-file" id="resume" data-max-size="2048" name="resume" accept="image/jpeg, application/pdf, application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document " aria-describedby="resume" required>
                        <label class="custom-file-label" id="resumelab" for="govtid" style="color:gray">Upload one Resume
                        </label>
                      </div>
                      <div class="input-group-append" style="width:90px !important;">
                        <button type="button" id="resumerem"><i class="fa fa-times" aria-hidden="true"></i></button>
                      </div>
                    </div>
                    <br />
                    <div class="mt-3">
                      <h5 class="mb-0">Legal Profile</h5>
                      <?php foreach ($legal as $key => $value) : ?>
                        <div class="mb-2" style="width:90%;">
                          <p><?= $value['description'] ?></p>
                          <input type="radio" name="question<?= $key + 1 ?>" value="<?= $value['value'] ?>" id="question<?= $key + 1 ?>_Yes">Yes
                          <input type="radio" name="question<?= $key + 1 ?>" value="no" id="question<?= $key + 1 ?>_No" checked="true">No
                          <input class="form-control" name="question<?= $key + 1 ?>_answer" placeholder="" id="question<?= $key + 1 ?>_answer" type="text" style="display:none">
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <div class="form-check col-lg-12">
                      <input class="form-check-input required-field" type="checkbox" id="myChecked" onclick="myFunctions()">
                      <label class="form-check-label" for="agreement-checkbox">
                        By completing the form below, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement</a> of Motortrade.<br /><br />
                      </label>
                    </div>
                    <?php echo '<br/><br/>';
                    echo $widget; ?><?php echo $script; ?>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div align="center">
                  <button type="submit" id="myCheck" style="display:none">Sign Up</button>
                  <button type="button" class="btn btn-lg btn-primary submitForm" id="text" onclick="myFunction()">Submit Form</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  </form>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script>
    var province = '<?php echo json_encode($province); ?>';
    var objp = JSON.parse(province);
    var city = '<?php echo  addcslashes(json_encode($city), "'\\/"); ?>';
    var objc = JSON.parse(city);
    var barangay = '<?php echo addcslashes(json_encode($barangay), "'\\/"); ?>';
    var objb = JSON.parse(barangay);
    var model = '<?php echo json_encode($model); ?>';
    var objm = JSON.parse(model);
  </script>
  <script src="<?= base_url(); ?>assets/js/jobapplication.js"></script>
</body>

</html>