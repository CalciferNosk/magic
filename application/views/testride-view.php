<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
  <title>Test Ride Form | Motortrade Group</title>
  <link rel="icon" href="<?= base_url(); ?>assets/favicon.ico">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/inquiry.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/css/select2.min.css">
  <link href="<?= base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- jQuery UI -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery.datetimepicker.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom-main.css">
</head>
<style>
  
  html, body {
  overflow-x: hidden;
  }

  #line {
    /* font-size: 1rem; */
    position: relative;
  }

  #TableDesign {
    font-family: 'Helvetica';
    border-collapse: collapse;
    width: 100%;
  }

  #TableDesign td,
  #TableDesign th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  #TableDesign tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #TableDesign tr:hover {
    background-color: #ddd;
  }

  #TableDesign th {
    padding-top: 10px;
    padding-bottom: 10px;
    text-align: center;
    background-color: #ccc;
    color: black;
    font-weight: normal;

  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }

  #TableDesign2 {
    font-family: 'Helvetica';
    border-collapse: collapse;
    width: 100%;
  }

  #TableDesign2 td,
  #TableDesign2 th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  #TableDesign2 tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #TableDesign2 tr:hover {
    background-color: #ddd;
  }

  #TableDesign2 th {
    padding-top: 10px;
    padding-bottom: 10px;
    text-align: center;
    background-color: #ccc;
    color: black;
    font-weight: normal;

  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }


  #line span {
    background-color: white;
    padding-right: 10px;
  }

  #line:after {
    content: "";
    display: inline-block;
    /* height: 0.5em; */
    vertical-align: bottom;
    width: 82%;
    margin-right: -100%;
    margin-left: 1px;
    border-top: 1px solid #c9c9c9;
  }

  #choose1,
  #choose2,
  #choose3,
  #choose4 {
    margin-left: 5px;
    margin-bottom: 5px;
    font-size: 10px;
  }

  LABEL.indented-checkbox-text {
    margin-left: -3px;
    display: block;
    position: relative;
    margin-top: -22px;
    /* make this margin match whatever your line-height is */
    line-height: 28px;
    /* can be set here, or elsewehere */
    cursor: pointer;
  }

  input[type=radio] {
    border: 0px;
    /* width: 100%; */
    height: 16px;
  }

  LABEL.choose-radio {
    margin-left: 23px;
    display: block;
    position: relative;
    margin-top: -26px;
    /* make this margin match whatever your line-height is */
    line-height: 23px;
    /* can be set here, or elsewehere */
    cursor: pointer;
  }

  mt-4,
  .my-4 {
    margin-top: 0.5rem !important;
  }

  .input {

    width: 295px;
    height: 30px;
    border: 1px solid #dbdfea;

    border-top-color: white;
    border-left-color: white;
    border-right-color: white;
  }

  .but:hover {
    color: yellow;

  }

  .ui-datepicker .ui-state-default {
    color: blue;
    background: ghostwhite;
  }

  .ui-datepicker td.ui-state-disabled>span {
    color: red;
  }
  #background-building{
      height: 100% !important;
    }
</style>

<body >
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-39K0KG0W7W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-39K0KG0W7W');
</script>

<div style="background-image: url('<?=base_url()?>assets/forms_image/background-building-light.png'); background-repeat: no-repeat;background-size: auto; background-size: 100% 100%;">
<?= _getheaderlayout()?>
  <form action="" method="POST" id="testride-form" autocomplete="off" enctype="multipart/form-data" data-formstate="0" data-otptries="3" data-otpstate="0" data-otp-exp-min="5">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <span class="anchor" id="formComplex"></span>
        <!-- form complex example -->
        <div class="card card-outline-secondary" style="opacity: .85;margin-top:20px">
          <div class="card-header">
            <h3 class="mb-0">Test Ride Form
              <span style="font-size: 8pt">
                <?php
                ?></span></small>
            </h3>
          </div>
          <div class="card-body" id="mainformbody">
            <div class="row" style="margin-left:5px; ">
              <div class="">
                <h5 class="card-title">Test Ride Details</h5>
              </div>
              <div class="">
              </div>
            </div>
            <div class="row mt-4">
              <div class="form-group col-sm-4">
                <label for="branch_code">Preferred Branch</label>
                <select class="form-control required-field use-select2" id="branch_code" name="branch_code" style="width:100% !important" required>
                </select>
              </div>
              <div class="form-group col-sm-4">
                <div class="form-group form-check ">
                  <label for="know_how_to_drive">
                    <font color="red">*</font> Know How To Drive A Motorcycle?
                  </label><br>
                  <span style="margin:10px;padding-left:10px"><input type="radio" value="496" class="form-check-input" name="know_how_to_drive" id="yes" required><label> YES </label></span>
                  <span style="margin:10px;"><input type="radio" value="497" class="form-check-input" name="know_how_to_drive" id="no"><label> NO</label></span>
                </div>
              </div>
              <div class="form-group col-sm-4">
                <label for="license_type">License Type</label>
                <select class="form-control required-field use-select2" id="license_type" name="license_type" required>
                  <?php foreach ($reference_value->result() as $d) : ?>
                    <?php if ($d->group_id != 141) continue; ?>
                    <option value="<?= $d->id; ?>"><?= $d->displayValue; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="row mt-4">
              <div class="form-group col-sm-4">
                <div class="form-group form-check ">
                  <label for="existing_mc">
                    <font color="red">*</font> Do you have existing motorcycle?
                  </label><br>
                  <span style="margin:10px;padding-left:10px"><input type="radio" value="496" class="form-check-input" name="existing_mc" id="yes" required><label> YES </label></span>
                  <span style="margin:10px;"><input type="radio" value="497" class="form-check-input" name="existing_mc" id="no"><label> NO</label></span>
                </div>
              </div>
              <div class="form-group col-sm-4">
                <div class="form-group form-check ">
                  <label for="willing_to_buy">
                    <font color="red">*</font> Willing to Buy/Upgrade MC unit?
                  </label><br>
                  <span style="margin:10px;padding-left:10px"><input type="radio" value="496" class="form-check-input willing_to_buy_496" name="willing_to_buy" id="yes" required><label> YES </label></span>
                  <span style="margin:10px;"><input type="radio" value="497" class="form-check-input willing_to_buy_496" name="willing_to_buy" id="no"><label> NO</label></span>
                </div>
              </div>
              <div class="form-group col-sm-4" id="div-preferred_mc" style="display:none">
                <label for="preferred_mc">Preferred Motorcycle Unit to avail/upgrade?</label>
                <select class="form-control required-field use-select2-tag" name="preferred_mc" id="preferred_mc">
                  <?php foreach ($models as $d => $v) : ?>
                    <option value="<?= $v['displayName']; ?>" ><?= $v['displayName']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <hr>
            <h5 class="card-title">Registrant Information</h5>
            <div class="row">
              <div class="form-group col-sm-4 pb-4">
                <label for="customer_fname">First Name</label>
                <input class="form-control alp required-field" name="customer_fname" id="customer_fname" placeholder="First Name" type="text" required>
              </div>
              <div class="form-group col-sm-4 pb-3">
                <label for="customer_mname">Middle Name</label>
                <input class="form-control alp" name="customer_mname" id="customer_mname" placeholder="Middle Name" type="text">
              </div>
              <div class="form-group col-sm-4 pb-3">
                <label for="customer_lname">Last Name</label>
                <input class="form-control alp required-field" name="customer_lname" id="customer_lname" placeholder="Last Name" type="text" required>
              </div>
              <div class="form-group col-sm-4 pb-3">
                <label for="email">Email Address</label>
                <input class="form-control required-field" name="email" id="" placeholder="Email Address" type="email" required>
              </div>
              <div class="form-group col-sm-4 pb-3">
                <label for="contact_no">Mobile Number <i>(example: 0918-1234567)</i></label>
                <input class="form-control mr-1 mobile required-field" id="mobile_no" name="contact_no" placeholder="09XX-XXXXXXX" type='tel' maxlength="12" required>
              </div>              
              <div class="form-group col-sm-4">
                <label for="cus_gender">Gender</label>
                <select class="form-control required-field use-select2 required-field" style="width:100%" id="cus_gender" name="cus_gender" required>
                  <option disabled>- Select -</option>
                  <option value="1864">MALE</option>
                  <option value="1865">FEMALE</option>
                </select>
              </div>
            </div>
            <div class="row mt-2">
              <div class="form-group col-sm">
                <label for="cus_psgc">Region | Province | Municipality | Barangay</label>
                <select class="cus_psgc form-control required-field" id="cus_psgc" name="cus_psgc" data-psgc_brgy_code="" data-psgc_citymun_code="" data-psgc_prov_code="" data-psgc_region_code="" data-psgc_zip_code="" required>
                </select>
              </div>
              <div class="form-group col-sm">
                <label for="address">Address (Unit No. / Building / Street)</label>
                <input type="text" class="form-control required-field" id="address" name="address" placeholder="Unit No./Bldg/Street" required>
              </div>
            </div>
            <div class="row mt-2">
            <div class="form-group col-sm-4">
                <label for="cus_occupation">Occupation</label>
                <select class="form-control required-field use-select2 required-field" style="width:100%" id="cus_occupation" name="cus_occupation" required>
                  <?php foreach ($reference_value->result() as $d) : ?>
                    <?php if ($d->group_id != 6) continue; ?>
                    <option value="<?= $d->id; ?>"><?= $d->displayValue; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
<!-- 
              
              <div class="form-group col-lg-3">
                <label for="own_motor" class="required-field">Do you have existing motorcycle?</label> <br>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="own_motor_y" name="own_motor" class="custom-control-input" value="496" required checked>
                  <label class="custom-control-label" for="own_motor_y">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="own_motor_n" name="own_motor" class="custom-control-input" value="497">
                  <label class="custom-control-label" for="own_motor_n">No</label>
                </div>
              </div> -->
            </div>

            <div class=" row ml-2 ">
              <div class="form-check col-sm">
                <input type="checkbox" class="form-check-input required-field" id="agreement-checkbox" name="agreement" required>
                <label class="form-check-label" for="agreement-checkbox">
                  By completing this form, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> of Motortrade.
                </label>
              </div>
            </div>
            <div class=" row ml-2 pt-2 ">
              <?php echo '<br/><br/>';
              echo $widget; ?><?php echo $script; ?>
            </div>
            <!--/card-->
          </div>
        </div>
        <!--/row-->
        <!--Card Footer -->
        <div class="card-footer">
          <div class="row">
            <div class="form-group col-sm" align="center">
              <button type="submit" class="btn btn-md btn-primary" name="btn_testride_form" id="btn_testride_form">Submit Form
                <!--<i class="fa fa-sign-in" aria-hidden="true"></i>-->
              </button>
            </div>
          </div>
        </div>
        <!-- ./end Card Footer -->
      </div>
      <input type="hidden" class="hidden" name="gen_otp" id="gen_otp" value="0" data-resendcount="0">

  </form>
  </div>
  <!--/row-->
  </div>

  <!-- Modal Confirm OTP -->
  <div class="modal fade" tabindex="-1" role="dialog" id="confirm-otp-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1d3494 !important;">
          <img src="<?= base_url(); ?>assets/images/motortrade-logo.jpg" alt="Motortrade Logo" class="img-responsive mx-auto">
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
            <button type="button" class="btn btn-primary form-control" id="btn-confirmotp-testride">Continue</button>
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
        </div>
      </div>
    </div>
  </div>
  </form>
  </div>
  <?= _getfooterlayout()?>
  <div class="ajax-loader d-flex justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; ">
    <div style="background: linear-gradient(#000, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #000); opacity: .5; position: absolute; width: 100%; height: 100%;"></div>
    <img src="<?= base_url(); ?>assets/loader-1.gif" style="height: 10% !important;" class="align-self-center">
  </div>
  <!-- jQuery UI -->
  <script>
    var base_url = "<?= base_url(); ?>";
    var branchesData = <?= $branchesData; ?>;
    var version = "<?= TESTRIDE_VERSION; ?>";
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/build/jquery.datetimepicker.full.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/common.js?12"></script>
  <!-- START CUSTOM JS -->
  <script src="<?= base_url(); ?>assets/js/main.js?2"></script>
  <script src="<?= base_url(); ?>assets/js/common.js?2"></script>
  <script src="<?= base_url(); ?>assets/js/test-ride.js"></script>
  <script>
  $(document).ready(function(){
      $('#version').text(version)
   if ($(window).width() < 990) {
      $('#background-building').css('display','none')
      // $('#nav-image').css('width','107%')
      $('.dropdown-menu').css('left','0px')
	} else {
    $('#background-building').css('display','block')
   
	}})
</script>
</body>

</html>