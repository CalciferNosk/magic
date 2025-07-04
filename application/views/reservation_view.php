<link rel="icon" href="assets/favicon.ico">
<title>
  Reservation Form | Motortrade Group
</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
  </script>
  <p id="demo"></p>
  <form action="Inquiry/submit" method="POST" onsubmit="return validate(this);">

    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
     <input type ="hidden" name="sourceparam" id="sourceparam"/>
     <input type ="hidden" name="clusterparam" id="clusterparam"/>
  <div class="row">
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
      <div class="modal-body" >
               <div class="col-sm-12">

           <h5>Enter Mobile Number Verification</h5>
      We've sent a One Time Password (OTP) to your phone number. Please enter it below within 5 minutes.
      <br/><br/>
      <b>Enter OTP</b>
        <input type="number" class="form-control otp-input modal-ku" id="otp-input" placeholder="OTP Code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="text-align:center" maxlength="4" aria-describedby="passwordHelpInline"  required>

                <input type="hidden" id="hiddenOTP">
                <br/>
                <button type="button" id="submitModal" class="btn btn-primary btn-block">Continue</button>
                <div align="center"  id="modalfin">
                  <br/>
        <span id="resending"></span> | <a href="#" data-dismiss="modal">Cancel</a> </div>
             </div>
      </div>

      <!--div class="modal-footer">
        <button type="button" id="submitModal" class="btn btn-sm btn-primary">Submit</button>
        <button type="button" id="resend" class="btn btn-sm btn-secondary" onclick="reSend()" data-dismiss="modal">Resend</button>
      </div-->
    </div>
  </div>
</div>
            <!-- form complex example -->
            <div class="card card-outline-secondary">
              <div class="card-header">
                <h3 class="mb-0">Reservation Form<span style="font-size: 8pt">v1.0.0
  <?php 
  //$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if(empty($_GET['cluster'])){
    echo ' (National)';
  }
  else{
  foreach($clustercodes as $clustercode){
    if($clustercode->code == base64_decode($_GET['cluster'])){
      echo ' ('.$clustercode->description.')';
    }
 }
}?></span></h3>

 <!--h3 class="mb-0">Complaint Form<span style="font-size: 8pt">v1.5</span></h3>
                 <div style="font-style: italic; color:gray">
                    <br/>
<input type="checkbox" id="myChecked" onclick="myFunctions()"> I have provided all the correct information above and I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> of Motortrade.
            </div-->
                <!--span class="form-inline">
                <div class="col-sm-4 pt-1">
 <select class="custom-select" name="brand" id="brand">
                      <option value="" class="text-white bg-warning">
                        Inquiry Form
                      </option>
                    </select>

                  </div>
 <a class="btn btn-primary">Change Form</a>
</span-->
              </div>
              <div class="card-body">
 <h5>Reservation Details</h5>

                <div class="row mt-4">
                  <div class="col-sm-12 pb-3">
                    <label for="exampleFirst">Category*</label>
                                       <select class="form-control custom-select pull-left" id="inquiry" name="inquiry" required>
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                      <?php
                        foreach ($categories as $category){
                            echo '<option value = "'.$category->catid.'" >'.$category->categoryname.'</option>';
                        }
?>
                    </select>
                  </div>
                  <!--div class="col-sm-6 pb-3">
                    <label for="exampleLast">Source*</label>
                                        <select class="form-control custom-select" name="source" id="source" required>
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                       <?php
                        foreach ($sources as $source){
                            echo '<option value = "'.$source->grid.'">'.$source->referencename.'</option>';
                        }
?>
<option value="OTHERS">OTHERS</option>
                    </select>
                  </div-->

                  <div class="col-sm-3 pb-3" id="hays" style="display:none">
                    <label for="exampleLast">Source (Others)</label>
                                         <input class="form-control" name="source_others" id="source_others" placeholder="Source (Others)" type="text" >
                  </div>

                                  <!--div class="col-sm-3 pb-3">
                    <label for="exampleSt">MC Type</label> <select class="form-control custom-select" name="type" id="type">
                     <option value="" class="text-white bg-warning">
                        Choose
                      </option>
 <?php
                        foreach ($types as $type){
                            echo '<option value = "'.$type->grid.'">'.$type->referencename.'</option>';
                        }
?>
                    </select>
                  </div-->
                                    <div class="col-sm-4 pb-3">
                    <label for="exampleSt">MC Brand</label> <select class="form-control custom-select" name="brand" id="brand">
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                     <?php
                        foreach ($brand as $bran){
                            echo '<option value = "'.$bran->grid.'" data-id="'.$bran->grid.'">'.$bran->referencename.'</option>';
                        }
?>
                    </select>
                  </div>
                                    <div class="col-sm-4 pb-3">
                    <label for="exampleSt">MC Model</label> <select class="form-control custom-select" name="model" id="model">
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                    </select>
                  </div>
                                    <div class="col-sm-4 pb-3">
                    <label for="exampleSt">MC Color</label> <select class="form-control custom-select" name="color" id="color">
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                     <?php
                        foreach ($colors as $color){
                            echo '<option value = "'.$color->grid.'" >'.$color->referencename.'</option>';
                        }
?>
                    </select>
                  </div>
 <div class="col-sm-7 pb-3">
                    <label for="exampleAccount">AR Number*</label>
                                        <input class="form-control" name="ar_number" id="ar_number" placeholder="AR Number" type="text"required>
                  </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleAccount">Desired Downpayment</label>
                                                <input class="form-control" name="downpayment" id="downpayment"
                                                    data-type="currency" placeholder="ex: 1,000" type="text">
                                            </div>
                </div>
                <hr>
                                <h5 class="mb-0">Customer Information</h5>

                <div class="row mt-4">
                  <div class="col-sm-4 pb-3">
                    <label for="exampleAccount">First Name*</label>
                                        <input class="form-control" name="customer_fname" id="customer_fname" placeholder="First Name" type="text"required>
                  </div>
                  <div class="col-sm-4 pb-3">
                    <label for="exampleAccount">Middle Name</label>
                                        <input class="form-control" name="customer_mname" id="customer_mname" placeholder="Middle Name" type="text">
                  </div>
                    <div class="col-sm-4 pb-3">
                    <label for="exampleAccount">Last Name*</label>
                                        <input class="form-control" name="customer_lname" id="customer_lname" placeholder="Last Name" type="text" required>
                  </div>
                                              <div class="col-sm-12 pb-3">
                    <label for="exampleSt">Region | Province | Municipality | Barangay*</label> <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" style="width: 100%" minimumInputLength="3" name="psgc" id="psgc">
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                    </select>
                  </div>  
                   <!--div class="col-sm-3 pb-3">
                    <label for="exampleSt">Region*</label> <select class="form-control custom-select" name="region" id="region" required>
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
                    <?php
                        foreach ($region as $reg){
                            echo '<option value = "'.$reg->regCode.'" data-id="'.$reg->regCode.'">'.$reg->regDesc.'</option>';
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
                    <label for="exampleAccount">Address (Unit No. / Building / Street) </label>
                                        <input class="form-control" id="address" name="address" placeholder="Address" type="text">
                  </div>
                  <div class="col-sm-6 pb-3 ">
                    <label for="exampleFirst">Email Address*</label>
 <input class="form-control" id="email" name="email" placeholder="Email Address" type="email" required>
                  </div>
                   <div class="col-sm-6 pb-3 ">
                    <label for="exampleFirst">Mobile Number* <i>(example: 0918-1234567)</i></label>
 <input class="form-control mr-1" id="contact_no" name="contact_no" placeholder="09XX-XXXXXXX" type='tel' maxlength="12" onkeypress="return onlyNumberKey(event)" required>
                  </div>
                  <!--div class="col-sm-6 pb-3 form-inline">
         <label for="exampleLast ">Mobile Number* <i>(example: 0918-1234567)</i></label>
         <span style=" margin-top:5px;">
        <input class="form-control mr-1" id="contact_no" name="contact_no" placeholder="Mobile Number" type='text' maxlength="12" required>
        <span class="otpbutton">
        <button type="button" class="btn btn-primary get-random" disabled>Send OTP</button>
      </span-->


      <!--input type="text" class="form-control rounded-0" id="validationDefaultUsername" placeholder="Username" aria-describedby="inputGroupPrepend2" required-->
                                    <div class="col-sm-12 pb-3">
                    <label for="exampleCity">Occupation*</label>  <select class="form-control custom-select" name="occupation" id="occupation" required>
                      <option value="" class="text-white bg-warning">
                        Choose
                      </option>
<?php
                      foreach ($occupation_group as $occup_group){
                        echo '<optgroup label="'.$occup_group->optiongroup.'">';
                        foreach ($occupation as $occup){
                          if($occup_group->optiongroup == $occup->optiongroup){
                            echo '<option value = "'.$occup->grid.'">'.$occup->referencename.'</option>';
                          }
                        }
                        echo '</optgroup>';
                      }
?>
                    </select>
                  </div>

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
                        foreach ($areas as $area){
                            echo '<option value = "'.$area->description.'" data-id="'.$area->code.'">'.$area->description.'</option>';
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
                                    <div class="row ml-0">
                  <div class="form-check col-lg-12">
                     <input class="form-check-input required-field" type="checkbox" id="myChecked" onclick="myFunctions()">
                     <label class="form-check-label" for="agreement-checkbox">
                     By completing the form below, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement</a> of Motortrade.<br/><br/>
                     </label>
                  </div>
                   <?php echo '<br/><br/>';echo $widget;?><?php echo $script;?> 
               </div>
                     </div>
                  </div>
               
              <div class="card-footer">
                <div align="center">
                  <button type="submit" id="myCheck" style="display:none">Sign Up</button>
                                   <button type="button" class="btn btn-lg btn-primary" id="text" onclick="myFunction()">Submit Form</button>
                </div>
              </div>
            </div><!--/card-->
          </div>
        </div><!--/row-->
      </div><!--/col-->
    </div><!--/row-->
  </div><!--/container-->
</form>
    <div class="ajax-loader d-flex justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; ">
      <div style="background: linear-gradient(#000, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #000); opacity: .5; position: absolute; width: 100%; height: 100%;"></div>
      <img src="assets/loader-1.gif" style="height: 10% !important;" class="align-self-center">
    </div>
<script>
var province = '<?php echo json_encode($province); ?>';
var objp = JSON.parse(province);
//alert(JSON.stringify(objp[0]));
var city = '<?php echo  addcslashes(json_encode($city), "'\\/"); ?>';
var objc = JSON.parse(city);
var barangay = '<?php echo addcslashes(json_encode($barangay), "'\\/"); ?>';
var objb = JSON.parse(barangay);
var model = '<?php echo json_encode($model); ?>';
var objm = JSON.parse(model);
//alert(JSON.stringify(objm));
//objb.forEach(foreach);
</script>
    <script src="<?= base_url(); ?>assets/js/reservation.js"></script>

