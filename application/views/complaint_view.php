<html>
<link rel="icon" href="assets/favicon.ico">
<title>
  Customer Care Form | Motortrade Group
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/inquiry.css">
<style>
  html,body{
    overflow-x: hidden;
}

</style>
<body >
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TZSDSVSLR9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TZSDSVSLR9');
</script>

<?= _getheaderlayout()?>
<div style="background-image: url('<?=base_url()?>assets/forms_image/background-building-light.png'); background-repeat: no-repeat;background-size: auto; background-size: 100% 100%;">


<form action="Customercare/submit" method="POST" onsubmit="return validate(this);" autocomplete="off">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <span class="anchor" id="formComplex"></span>
      <!-- Modal -->
      <!--div class="modal-footer">
        <button type="button" id="submitModal" class="btn btn-sm btn-primary">Submit</button>
        <button type="button" id="resend" class="btn btn-sm btn-secondary" onclick="reSend()" data-dismiss="modal">Resend</button>
      </div-->
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
          <h3 class="mb-0">Customer Care Form<span style="font-size: 8pt"></span></h3>

          <!--h3 class="mb-0">Complaint Form<span style="font-size: 8pt">v1.5</span></h3>
                 <div style="font-style: italic; color:gray">
                    <br/>
<input type="checkbox" id="myChecked" onclick="myFunctions()"> I have provided all the correct information above and I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> of Motortrade.
            </div-->
        </div>
        <div class="card-body">
          <h5>Customer Care Details</h5>


          <div class="row mt-4">
            <div class="col-sm-12 pb-3">
              <label for="exampleFirst">Category*</label>
              <select class="form-control custom-select" name="cat" id="cat" required>
                <option value="" class="text-white bg-warning">
                  Choose
                </option>
                <?php
                foreach ($category as $cat) {
                  echo '<option value = "' . $cat->grid . '">' . $cat->referencename . '</option>';
                }
                ?>
              </select>
            </div>
            <!--div class="col-sm-6 pb-3">
                    <label for="exampleLast">Sub Category</label>
                        <select name="subcat" class="form-control custom-select" id="subcat">
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                    </select>
                  </div-->
            <!--div class="col-sm-6 pb-3">
                    <label for="exampleSt">MC Brand</label> <select class="form-control custom-select" name="brand" id="brand">
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                     <?php
                      foreach ($brand as $bran) {
                        echo '<option value = "' . $bran->id . '" data-id="' . $bran->id . '">' . $bran->BrandName . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                                    <div class="col-sm-6 pb-3">
                    <label for="exampleSt">MC Model</label> <select class="form-control custom-select" name="model" id="model">
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                    </select>
                  </div-->

            <!--div class="form-group col-lg-12 col-sm-12 col-md-12 mb-0 pb-0" style="font-size: 13px !important;">
                    <p class="text-muted font-italic">Please identify the Branch of concern.</p>
                  </div-->

            <!--div class="col-sm-2 pb-3">
                    <label for="exampleFirst">Region</label>
<select class="js-example-basic-multiple form-control custom-select" multiple="multiple" name="region" id="region">
                                
                                <?php
                                foreach ($regions as $region) {
                                  echo '<option value = "' . $region->code . '" data-id="' . $region->id . '">' . strtoupper($region->description) . '</option>';
                                }
                                ?>
                            </select>
                  </div>

                                    <div class="col-sm-4 pb-3">
                    <label for="exampleFirst">Area</label>
<select class="js-example-basic-multiple form-control custom-select" multiple="multiple" name="area" id="area">
                                <option value="" class="text-white bg-warning">Choose</option>
                                <?php
                                foreach ($areas as $area) {
                                  //    echo '<option value = "'.$area->code.'" data-id="'.$area->id.'">'.strtoupper($area->description).'</option>';
                                }
                                ?>
                            </select>
                  </div-->
            <div class="col-sm-12 pb-3">
              <label for="exampleLast">Please identify the Branch of concern.</label>
              <select class="js-example-basic-multiple-another form-control custom-select branch" multiple="multiple" minimumInputLength="3" name="branch" id="branch">
                <?php
                foreach ($branches as $branch) {
                  if ($branch->address != null) {
                    $address = ' (' . $branch->address . ')';
                  } else {
                    $address = '';
                  }
                  echo '<option value = "' . $branch->code . '" data-id="' . $branch->id . '">' . $branch->code . ' ' . strtoupper($branch->description) . ' ' . strtoupper($address) . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-md-12 pb-3">
              <label for="exampleMessage">Customer Care Details*</label>
              <textarea class="form-control" id="details" name="details" rows="1" required></textarea>
            </div>
          </div>
          <hr>
          <h5 class="mb-0">Customer Information</h5>

          <div class="row mt-4">
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

            <div class="col-sm-6 pb-3 ">
              <label for="exampleFirst">Email Address</label>
              <input class="form-control" id="email" name="email" placeholder="Email Address" type="email" required>
            </div>
            <div class="col-sm-6 pb-3 ">
              <label for="exampleFirst">Mobile Number* <i>(example: 0918-1234567)</i></label>
              <input class="form-control mr-1 mobile" id="contact_no" name="contact_no" placeholder="09XX-XXXXXXX" type='tel' maxlength="12" onkeypress="return onlyNumberKey(event)" required>
            </div>
            <div class="col-sm-12 pb-3">
              <label for="exampleSt">Region | Province | Municipality | Barangay*</label> <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" style="width: 100%" minimumInputLength="3" name="psgc" id="psgc">
                <option value="" class="text-white bg-warning">
                  Choose
                </option>
              </select>
            </div>
            <!--div class="col-sm-6 pb-3 form-inline">
         <label for="exampleLast ">Mobile Number* <i>(example: 0918-1234567)</i></label>
         <span style=" margin-top:5px;">
        <input class="form-control mr-1" id="contact_no" name="contact_no" placeholder="Mobile Number" type='text' maxlength="12" required>
        <span class="otpbutton">
        <button type="button" class="btn btn-primary get-random" disabled>Send OTP</button>
      </span-->


            <!--input type="text" class="form-control rounded-0" id="validationDefaultUsername" placeholder="Username" aria-describedby="inputGroupPrepend2" required-->
            <!--div class="col-sm-12 pb-3">
                    <label for="exampleCity">Occupation*</label>  <select class="form-control custom-select" name="occupation" id="occupation" required>
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
<?php
foreach ($occupation as $occup) {
  echo '<option value = "' . $occup->grid . '">' . $occup->referencename . '</option>';
}
?>
                    </select>
                  </div-->

            <!--/div>

                <div class="col-sm-2 pb-3 otpdisplay">
                        <label for="validationTooltipUsername">OTP Code</label>
        <input type="number" class="form-control otp-input" id="otp-input" placeholder="OTP Code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" required>
                </div-->



            <!--h5 class="mb-0">Additional Information</h5>

                <div class="row mt-4">
                  <div class="col-sm-8 pb-3">
                    <label for="exampleAccount">Referral Name*</label>
                                        <input class="form-control" id="referral_name" name="referral_name" placeholder="Referral Name" type="text" required>
                  </div>
                  <div class="col-sm-4 pb-3">
                    <label for="exampleCtrl">Budget</label>
                                        <input class="form-control" id="budget" name="budget" placeholder="" type="number">
                  </div>

                  <div class="col-sm-6 pb-3">
                    <label for="exampleFirst">Area*</label>
<select class="js-example-basic-multiple form-control custom-select" multiple="multiple" name="area" id="area" required>
                                <option value="" class="text-white bg-warning">Choose</option>
                                <?php
                                foreach ($areas as $area) {
                                  echo '<option value = "' . $area->description . '" data-id="' . $area->code . '">' . $area->description . '</option>';
                                }
                                ?>
                            </select>
                  </div>
                  <div class="col-sm-6 pb-3">
                    <label for="exampleLast">Branch*</label>
                                        <select class="js-example-basic-multiple-another form-control custom-select" multiple="multiple" name="branch" id="branch" required>
                                <option value="" class="text-white bg-warning">Choose</option>
                            </select>
                  </div>
                </div-->
            <div class="row" style="margin-bottom: 1rem; margin-left: 20px">
              <!--div class="col-sm-6 pb-3 form-inline">
                        <label for="exampleLast ">Mobile Number* <i>(example: 0918-1234567)</i></label>
                        <span style=" margin-top:5px;">
                        <input class="form-control mr-1" id="contact_no" name="contact_no" placeholder="Mobile Number" type='text' maxlength="12" required>
                        <span class="otpbutton">
                        <button type="button" class="btn btn-primary get-random" disabled>Send OTP</button>
                        </span-->
              <!--input type="text" class="form-control rounded-0" id="validationDefaultUsername" placeholder="Username" aria-describedby="inputGroupPrepend2" required-->
              <!--div class="col-sm-12 pb-3">
                        <label for="exampleCity">Occupation*</label>  <select class="form-control custom-select" name="occupation" id="occupation" required>
                          <option value="" class="text-white bg-warning">
                            Choose
                          </option>
                        <?php
                        foreach ($occupation as $occup) {
                          echo '<option value = "' . $occup->grid . '">' . $occup->referencename . '</option>';
                        }
                        ?>
                        </select>
                        </div-->
              <!--/div>
                        <div class="col-sm-2 pb-3 otpdisplay">
                                <label for="validationTooltipUsername">OTP Code</label>
                        <input type="number" oninput="this.value = Math.abs(this.value)" class="form-control otp-input" id="otp-input" placeholder="OTP Code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" required>
                        </div-->
              <!--h5 class="mb-0">Additional Information</h5>
                        <div class="row mt-4">
                          <div class="col-sm-8 pb-3">
                            <label for="exampleAccount">Referral Name*</label>
                                                <input class="form-control" id="referral_name" name="referral_name" placeholder="Referral Name" type="text" required>
                          </div>
                          <div class="col-sm-4 pb-3">
                            <label for="exampleCtrl">Budget</label>
                                                <input class="form-control" id="budget" name="budget" placeholder="" type="number" oninput="this.value = Math.abs(this.value)">
                          </div>
                        
                          <div class="col-sm-6 pb-3">
                            <label for="exampleFirst">Area*</label>
                        <select class="js-example-basic-multiple form-control custom-select" multiple="multiple" name="area" id="area" required>
                                        <option value="" class="text-white bg-warning">Choose</option>
                                        <?php
                                        foreach ($areas as $area) {
                                          echo '<option value = "' . $area->description . '" data-id="' . $area->code . '">' . $area->description . '</option>';
                                        }
                                        ?>
                                    </select>
                          </div>
                          <div class="col-sm-6 pb-3">
                            <label for="exampleLast">Branch*</label>
                                                <select class="js-example-basic-multiple-another form-control custom-select" multiple="multiple" name="branch" id="branch" required>
                                        <option value="" class="text-white bg-warning">Choose</option>
                                    </select>
                          </div>
                        </div-->
              <br />
              <!--input type="checkbox" id="myChecked" onclick="myFunctions()"> I have provided all the correct information above and I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank">Data Privacy Statement</a> of Motortrade.-->
              <div class="row ml-0">
                <div class="form-check col-lg-12">
                  <input class="form-check-input required-field" type="checkbox" id="myChecked" onclick="myFunctions()">
                  <label class="form-check-label" for="agreement-checkbox">
                    By completing this form, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> of Motortrade.<br /><br />
                  </label>
                </div>
                <?php echo '<br/><br/>';
                echo $widget; ?><?php echo $script; ?>
              </div>

            </div>
          </div>
        </div>
        <div class="card-footer">
            <div align="center">
              <button type="submit" id="myCheck" style="display:none">Sign Up</button>
              <button type="button" id="text" class="btn btn-lg btn-primary" onclick="myFunction()">Submit Form</button>
            </div>
          </div>
        <!--/card-->
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
<div class="ajax-loader d-flex justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; ">
  <div style="background: linear-gradient(#000, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #000); opacity: .5; position: absolute; width: 100%; height: 100%;"></div>
  <img src="assets/loader-1.gif" style="height: 10% !important;" class="align-self-center">
</div>

<script>
  var branches = '<?php echo  addcslashes(json_encode($branches), "'\\/"); ?>';
  var objb = JSON.parse(branches);
  //alert(JSON.stringify(obja));
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
            _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
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
      "placeholder": "Type at least 3 characters",
      "matcher": matchCustom
    });
  });
</script>
<script src="<?= base_url(); ?>assets/js/common.js?refresher=<?= date('mdyhis')?>"></script>
<script src="<?= base_url(); ?>assets/js/complaint.js?refresher=<?= date('mdyhis')?>"></script>
<script>
  $(document).ready(function(){
      $('#version').text('v1.6.7')
   if ($(window).width() < 990) {
      $('#background-building').css('display','none')
      // $('#nav-image').css('width','112%')
      $('.dropdown-menu').css('left','0px')
	} else {
    $('#background-building').css('display','block')
	}})
</script>
<?= _getfooterlayout()?>
</body>
</html>