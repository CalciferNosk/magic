<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Online Service Appointment Motortrade">
  <meta name="author" content="The company's slogan “Motorsiklo Sigurado, Alaga Ka Dito” sums up its number one priority — Total Customer Satisfaction is what we always guarantee!">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- SELECT2 PLUGIN FOR MORE CUSTOMAZIBLE SELECT ELEMENT -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" /> -->
  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
  <link href="<?= base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- jQuery UI -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery.datetimepicker.css">
  <title>Service Appointment | Motortrade Group</title>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom-main.css">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico" />
  <script>
    var base_url = "<?= base_url(); ?>";
  </script>
  <style>
     html, body {
  overflow-x: hidden;
  }
  #background-building{
      height: 100% !important;
    }
  </style>
</head>

<body>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-8DRKX8L18N"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8DRKX8L18N');
</script>

<?= _getheaderlayout()?>
<div style="background-image: url('<?=base_url()?>assets/forms_image/background-building-light.png'); background-repeat: no-repeat;background-size: auto; background-size: 100% 100%;">

  <div class="container-fluid py-2 px-5" id="main-wrapper">
    <!-- Start Row -->
    <div class="row px-5" id="sub-wrapper">
      <!-- Start Column 12 -->
      <div class="col-sm-12 col-md-12 col-lg-12">
        <!-- Start Card -->
        <div class="card" style="opacity: .85;">
          <!-- Start Form -->
          <form action="<?= base_url() ?>Service/newServiceAppointment" id="service-appoinment-form" name="service-appoinment-form" method="POST" enctype="multipart/form-data" data-formstate="0" data-otptries="3" data-otpstate="0" data-otp-exp-min="5">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
            <div class="card-header">
              <h3 class="mb-0">Service Appointment
              <?php if (isset($_GET['chatbot'])) : ?>
                <span><img src="<?= base_url() ?>assets/chatbot/image/chatbot_2.png" width="20" height="20" alt="" srcset=""></span>
                <?php endif; ?>
              </h3>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="mainformbody">
              <!-- Service Appointment Details -->
              <h5 class="card-title">Service Appointment Details</h5>
              <!-- CATEGORY -->
              <div class="row">
                <div class="form-group col-lg-3">
                  <label for="category_id">Service Request</label>
                  <select class="form-control required-field use-select2" id="category_id" name="category_id" required>
                    <option>- Select -</option>
                  </select>
                </div>
                <div class="form-group col-lg-3">
                  <label for="mc_brand">MC Brand</label>
                  <select class="main-filterer form-control required-field use-select2" id="mc_brand" name="mc_brand" data-target-idelem="#mc_model" data-target-json="mc_models" required>
                    <option>- Select -</option>
                  </select>
                </div>
                <div class="form-group col-lg-3">
                  <label for="mc_model">MC Model</label>
                  <select class="form-control required-field use-select2" id="mc_model" name="mc_model" required>
                    <option>- Select -</option>
                  </select>
                </div>
                <div class="form-group col-lg-3">
                  <label for="chassis_no">Chassis No. <span class="text-muted font-italic">(optional)</span> </label>
                  <input type="text" class="form-control" name="chassis_no" id="chassis_no" min="6" max="20">
                </div>
                <div class="form-group col-lg-3">
                  <label for="mc_bought" class="required-field">MC Bought From Motortrade Group?</label> <br>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="mc_bought_y" name="mc_bought" class="custom-control-input" value="496" required checked>
                    <label class="custom-control-label" for="mc_bought_y">Yes</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="mc_bought_n" name="mc_bought" class="custom-control-input" value="497">
                    <label class="custom-control-label" for="mc_bought_n">No</label>
                  </div>
                </div>
                <div class="form-group col-lg-4 d-none">
                  <label for="mc_color">MC Color</label>
                  <select class="form-control use-select2" id="mc_color" name="mc_color">
                    <option>- Select -</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                  <label for="service_desc">Additional Job Request</label>
                  <textarea class="form-control" name="service_desc" id="service_desc" placeholder="Input your additional job request"></textarea>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-lg-5 col-sm-12 col-md-12 mb-0 pb-0" style="font-size: 13px !important;">
                  <p class="text-muted font-italic">Please choose your preferred Schedule and Branch by filling out details below.</p>
                </div>
              </div>

              <div class="row" style="margin-top: -10px;">
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                  <label for="branch_code">Branch</label>
                  <select class="form-control required-field use-select2" id="branch_code" name="branch_code" style="width:100% !important" required>
                    <!-- <option value="">- Select -</option> -->
                  </select>
                </div>
              </div>

              <!-- <div class="row" style="margin-top: -10px;">
                  <div class="form-group col-lg-3">
                    <label for="b_region">Region</label>
                    <select class="main-filterer form-control required-field use-select2" id="b_region" name="b_region" data-target-idelem="#b_area" data-target-json="b_areas" required>
                      <option value="">- Select -</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="b_area">Area</label>
                    <select class="main-filterer form-control required-field use-select2" id="b_area" name="b_area" data-target-idelem="#branch_code" data-target-json="branchesData" required>
                      <option value="">- Select -</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="branch_code">Branch</label>
                    <select class="form-control required-field use-select2" id="branch_code" name="branch_code" required>
                      <option value="">- Select -</option>
                    </select>
                  </div>
                </div> -->

              <div class="row">
                <div class="form-group col-lg-3">
                  <label for="preferrededatetime">Preferred Appointment</label>
                  <input type="text" class="form-control required-field datetime" name="preferrededatetime" id="preferrededatetime" placeholder="MM-DD-YYYY H:M" required>
                </div>
                <!-- Todo: Make it lookup to global reference and then generate html -->
                <!-- <div class="form-group col-lg-3 col-md-12 col-sm-12">
                    <label for="daystate" class="">Preferred Time Of Day If Desired Appointment Is Not Available?</label> <br>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" name="daystate" id="morning" class="custom-control-input" value="498">
                      <label class="custom-control-label" for="morning">Morning</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" name="daystate" id="midday" class="custom-control-input" value="499">
                      <label class="custom-control-label" for="midday" value="midday">Mid Day</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" name="daystate" id="afternoon" class="custom-control-input" value="507">
                      <label class="custom-control-label" for="afternoon" value="afternoon">Afternoon</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" name="daystate" id="notwilling" class="custom-control-input" value="539">
                      <label class="custom-control-label" for="notwilling">Not Willing</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" name="daystate" id="any" class="custom-control-input" value="508" checked>
                      <label class="custom-control-label" for="any" value="any">Any</label>
                    </div>
                  </div> -->

                <div class="form-group col-lg-6 col-sm-12 col-md-12" style="font-size: 13px !important;">
                  <p class="text-muted font-italic">Our branch representative will give you a confirmation of your appointment. When your selected date is no longer available you will be provided with the available dates and time to schedule your appointment.</p>
                </div>
              </div>

              <hr />

              <!-- Customer Information -->
              <h5 class="card-title">Customer Information</h5>

              <div class="row">
                <div class="form-group col-lg-3">
                  <label for="firstname">First Name</label>
                  <input type="text" class="form-control required-field alp" name="firstname" id="firstname" placeholder="Juan" required>
                </div>
                <div class="form-group col-lg-3">
                  <label for="middlename">Middle Name</label>
                  <input type="text" class="form-control alp" name="middlename" id="middlename" placeholder="Middle Name">
                </div>
                <div class="form-group col-lg-3">
                  <label for="lastname">Last Name</label>
                  <input type="text" class="form-control required-field alp" name="lastname" id="lastname" placeholder="Dela Cruz" required>
                </div>
              </div>

              <!-- <div class="row">
                  <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label for="service_desc">Service Description</label>
                    <textarea class="form-control required-field" name="service_desc" id="service_desc" placeholder="Service Description" required></textarea>
                  </div>
                </div> -->

              <div class="row">
                <div class="form-group col-lg-3">
                  <label for="email_address">Email Address</label>
                  <input type="email" class="form-control" id="email_address" name="email_address" placeholder="juandelacruz@gmail.com" required>
                </div>
                <div class="form-group col-lg-7" style="display:block;">
                  <label for="mobile_no">Mobile Number* <i>(example: 0918-1234567)</i></label>
                  <input type="text" class="form-control required-field mobile col-lg-5" onpaste="return false;" id="mobile_no" name="mobile_no" placeholder="09XX-XXXXXXX" maxlength="12" minlength="12">
                </div>
                <div class="form-group col-lg-1 mt-4 ml-0 pl-0 <?= (ENVIRONMENT == 'development') ? '' : 'd-none'; ?> ">
                  <button type="button" class="sendotp btn btn-md btn-primary" name="sendotp" id="sendotp">SENT OTP</button>
                </div>
              </div>

              <!-- <div class="row">
                  <div class="form-check col-lg-12" style="padding-left: 2.25rem !important">
                    <input type="checkbox" class="form-check-input required-field" id="agreement-checkbox" name="agreement" required>
                    <label class="form-check-label" for="agreement-checkbox">
                      By completing the form below, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> of Motortrade.
                    </label>
                  </div>
                </div> -->


              <!-- agreemnt checkbox -->
              <div class="row ml-0 mb-2">
                <div class="form-check col-lg-12">
                  <input type="checkbox" class="form-check-input required-field" id="agreement-checkbox" name="agreement" required>
                  <label class="form-check-label" for="agreement-checkbox">
                    By completing the form below, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> of Motortrade.
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
            <!-- ./Card Body -->

            <div class="card-footer text-center">
              <div class="row">
                <div class="form-group col-md-12 col-lg-12">
                  <button type="submit" class="btn btn-md btn-primary" name="service_appoinment_form" id="service_appoinment_form">Submit Form<!--<i class="fa fa-sign-in" aria-hidden="true"></i>--></button>
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
  </div>
  <!-- ./end container -->
</div>
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
          <p>We've sent a One Time Password (OTP) to your phone number<!--<span id="m-no" class="text-muted font-italic"></span> -->. Please enter it below within <span class="otp-timer-num">5</span> <span class="otp-timer-lbl"> minutes</span>.</p>
          <div class="form-group col-lg-12">
            <label for="email_address">Enter OTP:</label>
            <input type="text" class="form-control required-field text-center" id="input_otp" name="input_otp" placeholder="OTP Code" maxlength="4" style="font-size: 1.3rem">
          </div>

          <div class="form-group col-lg-12">
            <button type="button" class="btn btn-primary form-control" id="btn-confirmotp">Continue</button>
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

  <!--  Loader -->
  <div class="ajax-loader d-flex justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; ">
    <div style="background: linear-gradient(#000, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #000); opacity: .5; position: absolute; width: 100%; height: 100%;"></div>
    <img src="<?= base_url(); ?>assets/images/loader-1.gif" style="height: 10% !important;" class="align-self-center">
  </div>
  
  <?= _getfooterlayout()?>
  <!-- RUSSEL -->
  <script>
    var categories = <?= $categories; ?>;
    var mc_brand = <?= $mc_brand; ?>;
    var regions = <?= $regions; ?>;
    var b_regions = <?= $b_regions; ?>;
    var b_areas = <?= $b_areas; ?>;
    var branchesData = <?= $branchesData; ?>;
    var mc_models = <?= $mc_models; ?>;
  </script>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="<?= base_url() ?>assets/CDN/js/jquery.min.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script> -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <!-- SWEET ALERT -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="assets/plugins/select2/js/select2.full.min.js"></script>
  <!-- jQuery UI -->
  <script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/build/jquery.datetimepicker.full.min.js"></script>
  <!-- START CUSTOM JS -->
  <script src="<?= base_url(); ?>assets/js/main.js?2"></script>
  <script src="<?= base_url(); ?>assets/js/common.js?2"></script>
    <script> 
      $("#category_id").on("change", function(){
        var categoryname = $("#category_id option:selected").text();
        if(categoryname != ''){
          $(this).data("categoryname", categoryname);
          console.log(categoryname);
        }
        
        
      })
    </script>
  <!-- END RUSSEL -->
  <script>
    $(document).ready(function(){
      $('#version').text('v1.3.7')
   if ($(window).width() < 990) {
      $('#background-building').css('display','none')
      // $('#nav-image').css('width','112%')
      $('.dropdown-menu').css('left','0px')
	} else {
    $('#background-building').css('display','block')
	}
    })
 
  </script>
</body>

</html>