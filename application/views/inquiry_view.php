<html>
<link rel="icon" href="assets/favicon.ico">
<title>
  Inquiry Form | Motortrade Group
</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/inquiry.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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
  if ((getUrlParameter('src') == null) && (getUrlParameter('cls') == null) && (getUrlParameter('ci') == null)) {
    window.location.href = "FormError";
  }
</script>

 
<style>
  html,
  body {
    overflow-x: hidden !important;

  }

  #line {
    /* font-size: 1rem; */
    position: relative;
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

  #background-building {
    height: 110% !important;
  }
</style>

<body>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-EGW1RJ25F2"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-EGW1RJ25F2');
  </script>

  <?= _getheaderlayout() ?>
  <p id="demo" style="margin: unset;"></p>
  <div style="background-image: url('<?= base_url() ?>assets/forms_image/background-building-light.png'); background-repeat: no-repeat;background-size: auto; background-size: 100% 100%;">

    <form action="Inquiry/submit" method="POST" id="inquiry-form" autocomplete="off" style="min-height: 100%;">

      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
      <input type="hidden" name="sourceid" id="sourceid" value="<?php echo str_replace('"', '', $sourceid) ?>" />
      <input type="hidden" name="campaignid" id="campaignid" value="<?php echo str_replace('"', '', $campaignid) ?>" />
      <input type="hidden" name="clusterid" id=" clusterid" value="<?php echo str_replace('"', '', $clusterid) ?>" />
      <input type="hidden" name="sourceparam" id="sourceparam" />
      <input type="hidden" name="clusterparam" id="clusterparam" />
      <input type="hidden" name="gen_id" value="<?= uniqid(34); ?>">
      <div class="row">
        <!-- <img  id="background-building" class="" src="<?= base_url() ?>assets/forms_image/background-mt.png" style="width:100%;position:absolute;height:900px;pointer-events:none;padding-left:35%;opacity: 0.7;block-size: fit-content;left:0px" alt="" srcset=""> -->
        <div class="col-md-10 offset-md-1">
          <span class="anchor" id="formComplex"></span>

          <!-- Modal -->
          <div class="modal bd-example-modal-sm fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="testd">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                  </button>
                  <h5 align="center"><img src="assets/mopom.jpg" alt=""></h5>
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
          <!-- form complex example -->
          <div class="card card-outline-secondary" style="opacity: .85;margin-top:20px">
            <div class="card-header">
              <h3 class="mb-0">Inquiry Form<span style="font-size: 8pt">
                  <?php if (isset($_GET['chatbot'])) : ?>
                    &nbsp;<span><img style="margin-bottom: 9px;"  src="<?= base_url() ?>assets/chatbot/image/chatbot_2.png" width="20" height="20" alt="" srcset=""></span>
                 
                  <?php
                  else :
                  if (empty($_GET['cls'])) {
                    echo 'National';
                  } else {
                    echo $cluster_code;
                    if ($cluster_code == '') {
                      redirect(base_url() . 'FormError');
                    }
                  }
                  ?>
                 <?php endif ?>  
                </span></h3>

            </div>
            <div class="card-body">
              <div class="row" style="margin-left:5px; ">
                <div class="">
                  <h5 class="card-title" style="">Inquiry Details</h5>
                </div>
                <div class="">
                  <span style="font-size:13px;font-weight:400 ;margin-top:10px;line-height:32px;margin-left:3px;"> Should you wish to apply for a loan, please use our <a href="javascript:void(0)" onclick="myfunc();" id="loanredir">Motorcycle Loan Application Form</a>.</span>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-sm-12 pb-3">

                  <label for="exampleFirst">Category*</label>
                  <select class="form-control custom-select pull-left" id="inquiry" name="inquiry" required>
                    <option value="" class="text-white bg-warning">
                      Choose
                    </option>
                    <?php
                    foreach ($categories as $category) {
                      echo '<option value = "' . $category->catid . '" >' . strtoupper($category->categoryname) . '</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="Mc-purchase-type col-sm-12" style="display:none;">
                  <label style="margin-left:13px;">MC Unit Purchase Type</label>
                  <div class="row" style="width: 15rem;margin:3px;line-height:2px;">
                    <div class="col-sm  ">
                      <!-- <input class="row" name="purchaseType" id="choose1" placeholder="choose" value="1930" type="radio" ><label for="choose1" class="choose-radio">Not Applicable</label>  -->
                      <input class="row" name="purchaseType" id="choose2" placeholder="choose" value="1931" type="radio"><label for="choose2" class="choose-radio">Additional Unit</label>
                      <input class="row" name="purchaseType" id="choose3" placeholder="choose" value="1932" type="radio"><label for="choose3" class="choose-radio">First Motorcycle Unit</label>
                      <input class="row" name="purchaseType" id="choose4" placeholder="choose" value="1933" type="radio"><label for="choose4" class="choose-radio">Replacement of Unit </label>
                    </div>
                  </div>
                  <div class="row mt-4" style="margin-left: 10px;line-height:2px;margin-top: 0.5rem!important;">

                  </div>
                </div>


                <div class="col-sm-3 pb-3" id="hays" style="display:none">
                  <label for="exampleLast">Source (Others)</label>
                  <input class="form-control" name="source_others" id="source_others" placeholder="Source (Others)" type="text">
                </div>

                <div class="col-sm-4 pb-3 mc">
                  <label for="exampleSt">MC Brand</label> <select class="form-control custom-select" name="brand" id="brand">
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
                <div class="col-sm-4 pb-3 mc">
                  <label for="exampleSt">MC Model</label> <select class="form-control custom-select" name="model" id="model">
                    <option value="" class="text-white bg-warning">
                      Choose
                    </option>
                  </select>
                </div>
                <div class="col-sm-4 pb-3 mc">
                  <label for="exampleSt">MC Color</label> <select class="form-control custom-select" name="color" id="color">
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

                <div class="col-sm-12 pb-3" id="preferred_branch" style="display:none">
                  <label for="exampleLast">Preferred Branch</label>
                  <select class="form-control js-example-basic-multiple-another custom-select branch" multiple="multiple" minimumInputLength="3" name="branch" id="branch">
                    <?php
                    foreach ($branches as $branch) :
                      if ($branch->address != null) :
                        $address = ' (' . $branch->address . ')';
                      else :
                        $address = '';
                      endif;
                      echo '<option value = "' . $branch->code . '" data-id="' . $branch->id . '">' . $branch->code . ' ' . strtoupper($branch->description) . ' ' . strtoupper($address) . '</option>';
                    endforeach;
                    ?>
                  </select>
                </div>


                <div class="col-md-12 pb-3">
                  <label for="exampleMessage">Inquiry Details</label>
                  <textarea class="form-control" id="details" name="details" rows="1"></textarea>

                </div>

                <div class="col-sm-4 pb-3 mc">
                  <label for="exampleFirst">Plan Date to Purchase*</label>
                  <input class="form-control" id="date_purchase" name="date_purchase" placeholder="Date of Purchase" type="date" required>
                </div>

                <div class="col-sm-4">
                  <label for="exampleAccount" id="label_budget_from">Budget From</label>
                  <input class="form-control" name="budget_from" id="budget_from" data-type="currency" placeholder="ex: 30,000.00" type="text">
                </div>

                <div class="col-sm-4">
                  <label for="exampleAccount" id="label_budget_to">Budget To</label>
                  <input class="form-control" name="budget_to" id="budget_to" data-type="currency" placeholder="ex: 50,000.00" type="text">
                </div>

                <!-- testing -->
              </div>
              <!-- <hr> -->
              <h5 class="card-title"><span id="line" class="mb-0"> Customer Information</span></h5>
              <div class="row mt-3">
                <div class="form-group form-check" id="first_time_customer" style="display:none;">
                  <label for="isCustomerExist">
                    <font color="red">*</font>First Time Motortrade Customer?
                  </label><br>
                  <span style="margin:10px;padding-left:10px"><input type="radio" value="496" class="form-check-input" name="isCustomerExist" id="yes" required><label> YES </label></span>
                  <span style="margin:10px;"><input type="radio" value="497" class="form-check-input" name="isCustomerExist" id="no"><label> NO</label></span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4 pb-3">
                  <label for="exampleAccount">First Name*</label>
                  <input class="form-control alp" name="customer_fname" id="customer_fname" placeholder="First Name" type="text" required>
                </div>
                <div class="col-sm-4 pb-3">
                  <label for="exampleAccount">Middle Name</label>
                  <input class="form-control alp" name="customer_mname" id="customer_mname" placeholder="Middle Name" type="text">
                </div>
                <div class="col-sm-4 pb-3">
                  <label for="exampleAccount">Last Name*</label>
                  <input class="form-control alp" name="customer_lname" id="customer_lname" placeholder="Last Name" type="text" required>
                </div>
                <div class="col-sm-12 pb-3">
                  <label for="exampleSt">Region | Province | Municipality | Barangay*</label> <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" style="width: 100%" minimumInputLength="3" name="psgc" id="psgc">
                    <option value="" class="text-white bg-warning">
                      Choose
                    </option>
                  </select>
                </div>
                <div class="col-sm-12 pb-3">
                  <label for="exampleAccount">Address (Unit No. / Building / Street) </label>
                  <input class="form-control" id="address" name="address" placeholder="Address" type="text">
                </div>
                <div class="col-sm-6 pb-3 ">
                  <label for="exampleFirst">Email Address</label>
                  <input class="form-control" id="email" name="email" placeholder="Email Address" type="email">
                </div>
                <div class="col-sm-6 pb-3 ">
                  <label for="exampleFirst">Mobile Number* <i>(example: 0918-1234567)</i></label>
                  <input class="form-control mr-1 mobile" id="contact_no" name="contact_no" placeholder="09XX-XXXXXXX" type='tel' maxlength="12" onkeypress="return onlyNumberKey(event)" required>
                </div>
              </div>
              <div class="row ml-0">
                <div class="form-check col-lg-12">
                  <input class="form-check-input required-field" type="checkbox" id="myChecked" onclick="myFunctions()" style="top:3px">
                  <label class="form-check-label" for="myChecked">
                    By completing this form, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> of
                    Motortrade.<br /><br />
                  </label>
                </div>
                <?php echo '<br/><br/>';
                echo $widget; ?><?php echo $script; ?>
              </div>

            </div>

            <!--/card-->
          </div>
          <div class="card-footer" style="background-color:unset !important">
            <div align="center">
              <button type="submit" id="myCheck" style="display:none">Sign Up</button>
              <button type="button" class="btn btn-lg btn-primary" id="text" onclick="myFunction()">Submit Form</button>
            </div>
          </div>
        </div>
        <!--/row-->
      </div>
      <!--/col-->
  </div>
  <!--/row-->
  </div>
  <!--/container-->
  </form>
  </div>
  <div>
    <?= _getfooterlayout() ?>

    <div class="ajax-loader d-flex justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; ">
      <div style="background: linear-gradient(#000, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #000); opacity: .5; position: absolute; width: 100%; height: 100%;"></div>
      <img src="assets/loader-1.gif" style="height: 10% !important;" class="align-self-center">
    </div>
    <span id="brand_query" data-query="<?= isset($brand_query) ? $brand_query : ''; ?>"></span>

    <script>
      var model = '<?php echo json_encode($model); ?>';
      var objm = JSON.parse(model);
      $('.ajax-loader').addClass('d-none').removeClass("d-flex");

      $(document).ajaxStart(function() {
          $('.ajax-loader').removeClass('d-none').addClass("d-flex");
        })
        .ajaxComplete(function() {
          $('.ajax-loader').addClass('d-none').removeClass("d-flex");
        });
      $(document).ready(function() {


        $(".testregion").select2({
          "placeholder": "Please select Region, Province, Municipality, Barangay",

          maximumSelectionLength: 1,
          minimumInputLength: 3,
          allowclear: true,
          multiple: true,
          ajax: {
            url: "inquiry/find_psgc",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
              return {
                searchTerm: params.term, // search term
                '_cmcToken': $(`meta[name="_cmcToken"]`).attr("content"),

              };
            },
            processResults: function(response) {
              return {
                results: response
              };
            }
          }
        });
        $(".branch").select2({
          maximumSelectionLength: 1,
          width: '100%',
          "Placeholder": "Please Select Branch"
          // "placeholder": "Type at least 3 characters",
          // "matcher": matchCustom      
        });
      });

      $('#budget_from').hide();
      $('#budget_to').hide();
      $('#label_budget_from').hide();
      $('#label_budget_to').hide();
      $("#inquiry").change(function() {
        if ($('#inquiry').val() == 151 || $('#inquiry').val() == 152) {
          $('#budget_from').show();
          $('#budget_to').show();
          $('#label_budget_from').show();
          $('#label_budget_to').show();
          $("#preferred_branch").css("display", "block");
        } else {
          $('#branch').val(null).trigger('change');
          $('#budget_from').hide();
          $('#budget_to').hide();
          $('#label_budget_from').hide();
          $('#label_budget_to').hide();
          $("#preferred_branch").css("display", "none");
        }
      })
    </script>
    <script src="<?= base_url(); ?>assets/js/common.js?12"></script>
    <script src="<?= base_url(); ?>assets/js/inquiry.js?1"></script>

    <script>
      $(document).ready(function() {

        $('#version').text('v1.6.4 (National)')
        if ($(window).width() < 990) {
          $('#background-building').css('display', 'none')
          // $('#nav-image').css('width','114%')
          $('.dropdown-menu').css('left', '0px')
        } else {
          $('#background-building').css('display', 'block')
        }
      })
    </script>
</body>

</html>