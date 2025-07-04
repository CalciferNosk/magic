<!DOCTYPE html>
<html lang="en">

<link rel="icon" href="assets/favicon.ico">
<title>
    Loan Application | Motortrade Group
</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/inquiry.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/loan.css">
<style>
  
</style>
<body style="background-image: url('<?=base_url()?>assets/forms_image/background-building-light.png'); background-repeat: no-repeat;background-size: auto; background-size: 100% 100%;">
    <div id="result"></div>

    <form action="Loan/submit" id="validateForm" method="POST" enctype='multipart/form-data' autocomplete="off">
        <input type="hidden" name="<?php echo $this
    ->security
    ->get_csrf_token_name(); ?>" value="<?php echo $this
    ->security
    ->get_csrf_hash(); ?>" />
        <input type="hidden" name="sourceparam" id="sourceparam" />
        <input type="hidden" name="sourceid" id="sourceid" value="<?php echo str_replace('"', '', $sourceid) ?>"/>
        <input type="hidden" name="clusterid" id=" clusterid" value="<?php echo str_replace('"', '', $clusterid) ?>"/>
        <input type="hidden" name="clusterparam" id="clusterparam" />
        <input type="hidden" name="sameaddindi" id="sameaddindi" />
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <span class="anchor" id="formComplex"></span>
                <!-- Modal -->
                <div class="modal bd-example-modal-sm fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="testd">
                                <button type="button" class="close daylight" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="color:white;">&times;</span>
                                </button>
                                <h5 align="center"><img src="assets/mopom.jpg" alt=""></h5>
                            </div>
                            <div class="modal-body">
                                <div class="col-sm-12">
                                    <h5>Enter Mobile Number Verification</h5>
                                    We've sent a One Time Password (OTP) to your phone number. Please enter it below
                                    within 5 minutes.
                                    <br /><br />
                                    <b>Enter OTP</b>
                                    <input type="number" oninput="this.value = Math.abs(this.value)"
                                        class="form-control otp-input modal-ku" id="otp-input" placeholder="OTP Code"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        style="text-align:center" maxlength="4" aria-describedby="passwordHelpInline">
                                    <input type="hidden" id="hiddenOTP">
                                    <br />
                                    <button type="button" id="submitModal"
                                        class="btn btn-primary btn-block">Continue</button>
                                    <div align="center" id="modalfin">
                                        <br />
                                        <span id="resending"></span> | <a href="#" class="daylight"
                                            data-dismiss="modal">Cancel</a>
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
                <!-- form complex example -->
                <div class="card card-outline-secondary">
                    <div class="card-header">
                        <h3 class="mb-0">Loan Application<span style="font-size: 8pt">v1.5.3.4
                                <?php
//$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (empty($_GET['cluster']))
{
    echo ' (National)';
}
else
{
    # Revised By Russ: 5-19-21
    // foreach ($clustercodes as $clustercode)
    // {
    //     if ($clustercode->code == base64_decode($_GET['cluster']))
    //     {
    //         echo ' (' . $clustercode->description . ')';
    //     }
    // }
    echo $cluster_code;
} ?></span>
                        </h3>
                        <!--h3 class="mb-0">Complaint Form<span style="font-size: 8pt">v1.5</span></h3>
                  <div style="font-style: italic; color:gray">
                     <br/>
                  <input type="checkbox" id="myChecked" onclick="myFunctions()"> I have provided all the correct information above and I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank">Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a> of Motortrade.
                  </div-->
                    </div>
                    <div class="card-body">

                        <div id="accordion" class="myaccordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button
                                            class="d-flex align-items-center justify-content-between btn btn-link collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne">
                                            A. Loan Information
                                            <span class="fa-stack fa-sm">
                                                <i class="fa fa-circle fa-stack-2x"></i>
                                                <i class="fa fa-minus fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                                    <div class="card-body">
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <!--div class="col-sm-3 pb-3">
                                 <label for="exampleSt">Principal or Co-Borrower*</label> <select class="form-control custom-select" name="gender" id="gender" required>
                                   <option value="" class="text-white bg-warning">
                                     Choose
                                   </option>
                                 <option value="Principal Borrower">Principal Borrower</option>
                                 <option value="Co-Borrower">Co-Borrower</option>
                                 </select>
                                 </div>
                                                                    <div class="col-sm-3 pb-3">
                                 <label for="exampleSt">Loan Type*</label> <select class="form-control custom-select" name="gender" id="gender" required>
                                   <option value="" class="text-white bg-warning">
                                     Choose
                                   </option>
                                 <option value="Brand New">Brand New</option>
                                 <option value="Second-Hand">Second-Hand</option>
                                 </select>
                                 </div-->
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleSt">MC Brand*</label>
                                                <select class="form-control custom-select" name="brand" id="brand">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
foreach ($brand as $bran)
{
    echo '<option value = "' . $bran->grid . '" data-id="' . $bran->grid . '">' . $bran->referencename . '</option>';
}
?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleSt">MC Model*</label>
                                                <select class="form-control custom-select" name="model" id="model">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleSt">MC Color*</label>
                                                <select class="form-control custom-select" name="color" id="color">
                                                    <option value="" class="text-white bg-warning">
                                                        Choose
                                                    </option>
                                                    <?php
foreach ($colors as $color)
{
    echo '<option value = "' . $color->grid . '" >' . $color->referencename . '</option>';
}
?>
                                                </select>
                                            </div>

                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleAccount">Plan Date to Purchase</label>
                                                <input class="form-control" name="datetime" id="datetime" type="date">
                                            </div>
                                                              <?php if ((strpos($source, 'FACEBOOK ADS') !== false) || (strpos($source, 'Facebook Ads') !== false)) { ?>
                    <div class="col-sm-12 pb-3">
                    <label for="exampleLast">Please identify the Branch of concern.</label>
                                        <select class="js-example-basic-multiple-another form-control custom-select branch" multiple="multiple" minimumInputLength="3" name="branch" id="branch">
                                    <?php
                        foreach ($branches as $branch){
                          if($branch->address != null){
                            $address = ' ('.$branch->address.')';
                          }
                          else{
                            $address = '';
                          }
                            echo '<option value = "'.$branch->code.'" data-id="'.$branch->id.'">'.$branch->code.' '.strtoupper($branch->description).' '.strtoupper($address).'</option>';
                          
                          
                        }
?>
                            </select>
                  </div>
                <?php } ?>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleAccount">Loan Purpose</label>
                                                <input class="form-control" name="loan_purpose" id="loan_purpose"
                                                    placeholder="Loan Purpose" type="text">
                                            </div>
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleAccount">Desired Term</label>
                                                <input class="form-control" name="loan_term" id="loan_term"
                                                    placeholder="Term" type="number"
                                                    oninput="this.value = Math.abs(this.value)">
                                            </div>
                                            <div class="col-sm-3 pb-3">
                                                <label for="exampleSt">Loan Type*</label><br />
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="loan_type_1" name="loan_type"
                                                        class="custom-control-input" value="564" checked>
                                                    <label class="custom-control-label" for="loan_type_1">BRAND NEW</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="loan_type_2" name="loan_type"
                                                        class="custom-control-input" value="565">
                                                    <label class="custom-control-label"
                                                        for="loan_type_2">PRE-OWNED</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleAccount">Desired Loan Amount</label>
                                                <input class="form-control" name="loan_amount" id="loan_amount"
                                                     data-type="currency" placeholder="ex: 1,000" type="text"
                                                   >
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleAccount">Desired Downpayment</label>
                                                <input class="form-control" name="downpayment" id="downpayment"
                                                    data-type="currency" placeholder="ex: 1,000" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--div class="card">
                        <div class="card-header" id="headingFive">
                          <h2 class="mb-0">
                            <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                              B. Referral Information
                              <span class="fa-stack fa-sm">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                              </span>
                            </button>
                          </h2>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive">
                          <div class="card-body">
                                            <div class="row mt-4" style="border: 2px #ccc solid;"-->
                                <!--div class="col-sm-3 pb-3">
                        <label for="exampleAccount">Dealer</label>
                                            <input class="form-control" name="referrral_name" id="referral_name" type="text">
                        </div>
                                                          <div class="col-sm-2 pb-3">
                        <label for="exampleAccount">Dealer Code</label>
                                            <input class="form-control" name="referrral_name" id="referral_name" type="text">
                        </div-->
                                <!--div class="col-sm-4 pb-3">
                        <label for="exampleSt">MC Brand*</label> <select class="form-control custom-select" name="brand" id="brand" required>
                          <option value="" class="text-white bg-warning">
                            Choose
                          </option>
                        <?php
foreach ($brand as $bran)
{
    echo '<option value = "' . $bran->grid . '" data-id="' . $bran->grid . '">' . $bran->referencename . '</option>';
}
?>
                        </select>
                        </div>
                                        <div class="col-sm-4 pb-3">
                        <label for="exampleSt">MC Model*</label> <select class="form-control custom-select" name="model" id="model" required>
                          <option value="" class="text-white bg-warning">
                            Choose
                          </option>
                        </select>
                        </div>
                        <div class="col-sm-4 pb-3">
                        <label for="exampleSt">MC Color</label> <select class="form-control custom-select" name="color" id="color" required>
                          <option value="" class="text-white bg-warning">
                            Choose
                          </option>
                         <?php
foreach ($colors as $color)
{
    echo '<option value = "' . $color->grid . '" >' . $color->referencename . '</option>';
}
?>
                        </select>
                        </div>
                                        <div class="col-sm-6 pb-3">
                        <label for="exampleAccount">Desired Downpayment</label>
                                            <input class="form-control" name="desired_down" id="desired_down" type="number" oninput="this.value = Math.abs(this.value)">
                        </div>
                        <div class="col-sm-6 pb-3">
                        <label for="exampleAccount">Desired Monthly Installment</label>
                                            <input class="form-control" name="desired_month" id="desired_month" type="number" oninput="this.value = Math.abs(this.value)">
                        </div-->
                                <!--div class="col-sm-3 pb-3 ">
                        <label for="exampleFirst">Date of Purchase*</label>
                        <input class="form-control" id="date_purchase" name="date_purchase" placeholder="Date of Purchase" type="date" required>
                        </div-->
                                <!--div class="col-sm-2 pb-3">
                        <label for="exampleFirst">Region*</label>
                        <select class="js-example-basic-multiple form-control custom-select" multiple="multiple" name="region" id="region" required>
                                    
                                    <?php
foreach ($regions as $regio)
{
    echo '<option value = "' . $regio->code . '" data-id="' . $regio->id . '">' . strtoupper($regio->description) . '</option>';
}
?>
                                </select>
                        </div>
                        
                                        <div class="col-sm-4 pb-3">
                        <label for="exampleFirst">Area*</label>
                        <select class="js-example-basic-multiple form-control custom-select" multiple="multiple" name="area" id="area" required>
                                    <option value="" class="text-white bg-warning">Choose</option>
                                    <?php
foreach ($areas as $area)
{
    //    echo '<option value = "'.$area->code.'" data-id="'.$area->id.'">'.strtoupper($area->description).'</option>';
    
}
?>
                                </select>
                        </div>
                        <div class="col-sm-6 pb-3">
                        <label for="exampleLast">Branch*</label>
                                            <select class="js-example-basic-multiple-another form-control custom-select" multiple="multiple" name="branch" id="branch" required>
                                    <option value="" class="text-white bg-warning">Choose</option>
                                </select>
                        </div-->
                                <!--/div>
                        </div>
                        </div>
                        </div-->
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h2 class="mb-0">
                                            <button
                                                class="d-flex align-items-center justify-content-between btn btn-link collapsed"
                                                type="button" data-toggle="collapse" data-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                B. Personal Details
                                                <span class="fa-stack fa-2x">
                                                    <i class="fa fa-circle fa-stack-2x"></i>
                                                    <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo">
                                        <div class="card-body">
                                            <div class="row mt-4" style="border: 2px #ccc solid;">
                                                <div class="col-sm-4 pb-3">
                                                    <label for="exampleAccount">First Name*</label>
                                                    <input class="form-control" name="first_name" id="customer_fname"
                                                        placeholder="First Name" pattern="^\D*$"
                                                        title="Please enter only alphabets" type="text">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleAccount">Middle Name</label>
                                                    <input class="form-control" name="middle_name" id="customer_mname"
                                                        placeholder="Middle Name" type="text">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleAccount">Last Name*</label>
                                                    <input class="form-control" name="last_name" id="customer_lname"
                                                        placeholder="Last Name" type="text">
                                                </div>
                                                <div class="col-sm-2 pb-3">
                                                    <label for="exampleAccount">Extension Name</label>
                                                    <input class="form-control" name="ext_name" id="customer_xname"
                                                        placeholder="Extension Name" type="text">
                                                </div>  
                                                <div class="col-sm-8 pb-3">
                                                    <label for="exampleAccount">Mother's Maiden Name*</label>
                                                    <input class="form-control" name="maiden_name" id="maiden_name"
                                                        placeholder="Mother's Maiden Name" type="text">
                                                </div>
                                                <div class="col-sm-4 pb-3">
                                                    <label for="exampleAccount">Number of Children / Age</label>
                                                    <input class="form-control" name="no_children" id="no_children"
                                                        placeholder="Number of Children / Age" type="text">
                                                </div>
                                                <!--div class="col-sm-2 pb-3">
                                    <label for="exampleSt">Gender*</label> <select class="form-control custom-select" name="gender" id="gender" required>
                                      <option value="" class="text-white bg-warning">
                                        Choose
                                      </option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    </select>
                                    </div-->
                                                <div class="col-sm-2 pb-3">
                                                    <label for="exampleAccount">Nationality</label>
                                                    <input class="form-control" name="nationality" id="nationality"
                                                        placeholder="Nationality" type="text" value="Filipino">
                                                </div>
                                                <div class="col-sm-3 pb-3 ">
                                                    <label for="exampleFirst">Birthday (DD/MM/YYYY)*</label>
                                                    <input class="form-control birthday" id="birthday" name="birthday"
                                                        placeholder="Birthday" type="date">
                                                </div>
                                                <div class="col-sm-1 pb-3">
                                                    <label for="exampleAccount">Age*</label>
                                                    <input class="form-control number" name="age" id="age"
                                                        placeholder="Age" type="number"
                                                        oninput="this.value = Math.abs(this.value)" disabled>
                                                </div>
                                                <div class="col-sm-4 pb-3">
                                                    <label for="exampleAccount">Birthplace*</label>
                                                    <input class="form-control" name="birth_place" id="birthplace"
                                                        placeholder="Birthplace" type="text">
                                                </div>
                                                <div class="col-sm-2 pb-3">
                                                    <label for="exampleSt">Gender*</label><br />
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="gender_1" name="gender"
                                                            class="custom-control-input" value="566" checked>
                                                        <label class="custom-control-label" for="gender_1">Male</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="gender_2" name="gender"
                                                            class="custom-control-input" value="567">
                                                        <label class="custom-control-label"
                                                            for="gender_2">Female</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 pb-3">
                                                    <label for="exampleSt">Educational Attainment*</label>
                                                    <select class="form-control custom-select"
                                                        name="education_attainment" id="education_attainment">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                        <?php
foreach ($educations as $education)
{
    echo '<option value = "' . $education->grid . '" >' . $education->referencename . '</option>';
}
?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 pb-3">
                                                    <label for="exampleAccount">TIN</label>
                                                    <input class="form-control mr-1 tin" id="tin" name="tin"
                                                        placeholder="N/A" type='tel' maxlength="15">
                                                </div>
                                                <div class="col-sm-4 pb-3">
                                                    <label for="exampleAccount">SSS / GSIS NO.</label>
                                                    <input class="form-control" name="sss_gsis" id="sss"
                                                        placeholder="N/A" value="N/A" type="text" maxlength="15">
                                                </div>
                                                <div class="col-sm-12 pb-3">
                                                    <b class="motortrade">Present Address</b>
                                                </div>
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleSt">Region | Province | Municipality |
                                                        Barangay | Zip*</label>
                                                    <select
                                                        class="js-example-basic-multiple-another form-control custom-select testregion"
                                                        multiple="multiple" minimumInputLength="3"
                                                        style="width:100%; border-color:red !important"
                                                        name="presentaddress" id="presentaddress">
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
foreach ($region as $reg)
{
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
                                                    <input class="form-control" id="address" name="address"
                                                        placeholder="Address" type="text">
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
                                                        <input class="form-control number" style="width:30%;"
                                                            name="tenurecountyears" id="tenurecountyears" type="number"
                                                            oninput="this.value = Math.abs(this.value)"
                                                            onkeyup="stayTrigger()" />
                                                        <input class="form-control" style="width:20%;" type="text"
                                                            value="Years" disabled />
                                                        <input class="form-control number" style="width:30%;"
                                                            name="tenurecountmonths" id="tenurecountmonths"
                                                            type="number" oninput="this.value = Math.abs(this.value)"
                                                            onkeyup="stayTrigger()" />
                                                        <input class="form-control" style="width:20%;" type="text"
                                                            value="Months" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 pb-3">
                                                    <div class="form-check col-lg-12">
                                                        <input class="form-check-input required-field" type="checkbox"
                                                            name="sameadd" id="sameadd" onclick="sameaddress()">
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
                                                    <select
                                                        class="js-example-basic-multiple-another form-control custom-select testregion"
                                                        multiple="multiple" minimumInputLength="3" style="width:100%"
                                                        name="permanentaddress" id="permanentaddress">
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
foreach ($region as $reg)
{
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
                                                    <input class="form-control" id="address_sub" name="address_sub"
                                                        placeholder="Address" type="text">
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
foreach ($region as $reg)
{
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
foreach ($province as $prov)
{
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
foreach ($city as $cit)
{
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
foreach ($barangay as $brgy)
{
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
foreach ($region as $reg)
{
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
                                                    <select
                                                        class="js-example-basic-multiple-another form-control custom-select testregion"
                                                        multiple="multiple" minimumInputLength="3" style="width:100%"
                                                        name="previousaddress" id="previousaddress">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 pb-3 prev">
                                                    <label for="exampleAccount">Address (Unit No. / Building / Street)
                                                    </label>
                                                    <input class="form-control" id="address_prev" name="address_prev"
                                                        placeholder="Address" type="text">
                                                </div>
                                                <!--div class="col-sm-2 pb-3 prev">
                                                    <label for="exampleAccount">Zip Code </label>
                                                    <input class="form-control number" id="zip_prev" name="zip_prev"
                                                        placeholder="Zip Code" type="number"
                                                        oninput="this.value = Math.abs(this.value)">
                                                </div-->
                                                <div class="col-sm-6 pb-3 ">
                                                    <label for="exampleFirst">Email Address</label>
                                                    <input class="form-control" id="email" name="email"
                                                        placeholder="Email Address" type="email">
                                                </div>
                                                <div class="col-sm-6 pb-3 ">
                                                    <label for="exampleFirst">
                                                        Mobile Number <i>(example: 0918-1234567) </i> <br />
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="customRadioInline1"
                                                                name="numberpaid" class="custom-control-input"
                                                                value="623" checked>
                                                            <label class="custom-control-label"
                                                                for="customRadioInline1">Postpaid</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="customRadioInline2"
                                                                name="numberpaid" value="624"
                                                                class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                for="customRadioInline2">Prepaid</label>
                                                        </div>
                                                    </label>
                                                    <input class="form-control mr-1 mobile" id="contact_no" autocomplete="new-password" name="contact_no" placeholder="09XX-XXXXXXX" type='tel'
                                                        maxlength="12" onkeypress="return onlyNumberKey(event)">
                                                </div>
                                                <div class="col-sm-4 pb-3 ">
                                                    <label for="exampleFirst">Facebook</label>
                                                    <input class="form-control" id="facebook" name="facebook"
                                                        placeholder="Facebook">
                                                </div>
                                                <div class="col-sm-4 pb-3 ">
                                                    <label for="exampleFirst">Instagram</label>
                                                    <input class="form-control" id="instagram" name="instagram"
                                                        placeholder="Instagram">
                                                </div>
                                                <div class="col-sm-4 pb-3 ">
                                                    <label for="exampleFirst">Others</label>
                                                    <input class="form-control" id="other_social" name="other_social"
                                                        placeholder="Others">
                                                </div>
                                                <div class="col-sm-5 pb-3 ">
                                                    <label for="exampleFirst">Home Tel No.</label>
                                                    <input class="form-control" id="home_tel" name="home_tel"
                                                        placeholder="Home Tel No." type="home_tel">
                                                </div>
                                                <div class="col-sm-5 pb-3 ">
                                                    <label for="exampleFirst">Home Fax No.</label>
                                                    <input class="form-control" id="home_fax" name="home_fax"
                                                        placeholder="Home Fax No." type="home_fax">
                                                </div>
                                                <div class="col-sm-2 pb-3 ">
                                                    <label for="exampleFirst">No. of Dependent</label>
                                                    <input class="form-control number" id="dependent" name="dependent"
                                                        type="number" oninput="this.value = Math.abs(this.value)">
                                                </div>
                                            </div>
                                            <div class="row mt-4" style="border: 2px #ccc solid;">
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleSt">Residence Type*</label>
                                                    <select class="form-control custom-select" name="residence_type"
                                                        id="residence_type">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                        <?php
foreach ($residence_type as $residence)
{
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
                                                    <select class="form-control custom-select" name="marital_status"
                                                        id="marital_status">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                        <?php
foreach ($marital_status as $marital)
{
    echo '<option value = "' . $marital->grid . '" data-id="' . $marital->grid . '">' . $marital->referencename . '</option>';
}
?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 pb-3 Divorced" style="display: none;">
                                                    <label for="exampleFirst">Legally seperated for how many
                                                        years*</label>
                                                    <input class="form-control" id="seperated_years"
                                                        name="seperated_years" type="text">
                                                </div>
                                                <div class="col-sm-12 pb-3 Widowed" style="display: none;">
                                                    <label for="exampleFirst">Widowed for how many years*</label>
                                                    <input class="form-control" id="widow_years" name="widow_years"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-4 pb-3 Married" style="display: none;">
                                                    <label for="exampleFirst">Spouse / Live-In First Name*</label>
                                                    <input class="form-control" id="spousefname" name="spousefname"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-4 pb-3 Married" style="display: none;">
                                                    <label for="exampleFirst">Spouse / Live-In Middle Name*</label>
                                                    <input class="form-control" id="spousemname" name="spousemname"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-4 pb-3 Married" style="display: none;">
                                                    <label for="exampleFirst">Spouse / Live-In Last Name*</label>
                                                    <input class="form-control" id="spouselname" name="spouselname"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-3 pb-3 Married" style="display: none;">
                                                    <label for="exampleAccount">Spouse / Live-In Nickname</label>
                                                    <input class="form-control" name="spousenname" id="spousenname"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-3 pb-3 Married" style="display: none;">
                                                    <label for="exampleAccount">Spouse / Live-In Nationality</label>
                                                    <input class="form-control" name="spouse_nationality"
                                                        id="spouse_nationality" placeholder="Spouse Nationality"
                                                        type="text" value="Filipino">
                                                </div>
                                                <div class="col-sm-4 pb-3 Married" style="display: none;">
                                                    <label for="exampleFirst">Spouse / Live-In Birthday (DD/MM/YYYY)* </label>
                                                    <input class="form-control birthday" id="spouse_birthday"
                                                        name="spouse_birthday" type="date">
                                                </div>
                                                <div class="col-sm-2 pb-3 Married" style="display: none;">
                                                    <label for="exampleFirst">Spouse / Live-In Age*</label>
                                                    <input class="form-control number" id="spouse_age" name="spouse_age"
                                                        type="number" oninput="this.value = Math.abs(this.value)"
                                                        disabled>
                                                </div>
                                                <div class="col-sm-6 pb-3 Married" style="display: none;">
                                                    <label for="exampleFirst">Spouse / Live-In Contact Number*</label>
                                                    <input class="form-control mobile" autocomplete="new-password" id="spouse_contact"
                                                        name="spouse_contact" type='tel' placeholder="09XX-XXXXXXX" maxlength="12"
                                                        onkeypress="return onlyNumberKey(event)">
                                                </div>
                                                <div class="col-sm-6 pb-3 Married" style="display: none;">
                                                    <label for="exampleFirst">Spouse / Live-In Tel No.</label>
                                                    <input class="form-control" id="spouse_telno" name="spouse_telno"
                                                        type='number'>
                                                </div>

                                                <div class="col-sm-6 pb-3 Married" style="display: none;">
                                                    <label for="exampleFirst">Spouse Address*</label>
                                                    <input class="form-control" id="spouse_address"
                                                        name="spouse_address" type="text">
                                                </div>
                                                <div class="col-sm-6 pb-3 Married" style="display: none;">
                                                    <label for="exampleFirst">Spouse Birthplace*</label>
                                                    <input class="form-control" id="spouse_birthplace"
                                                        name="spouse_birthplace" type="text">
                                                </div>
                                            </div>
                                            <div class="row mt-4" style="border: 2px #ccc solid;">
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleSt">Borrower Type*</label>
                                                    <select class="form-control custom-select" name="borrower_type"
                                                        id="borrower_type">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                        <?php
foreach ($borrower_group as $borrower_grou)
{
    echo '<optgroup label="---' . $borrower_grou->option_group . '---">';
    foreach ($borrower as $borrow)
    {
        if ($borrower_grou->option_group == $borrow->option_group)
        {
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
                                                    <select class="form-control custom-select" name="borrower_nature"
                                                        id="borrower_nature">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                        <?php
foreach ($borrower_nature as $borrower_natur)
{
    echo '<option value = "' . $borrower_natur->grid . '" >' . $borrower_natur->referencename . '</option>';
}
?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 pb-3 borrowbusiness">
                                                    <label for="exampleSt">Size of Business*</label>
                                                    <select class="form-control custom-select" name="borrower_size"
                                                        id="borrower_size">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                        <?php
foreach ($borrower_size as $borrower_siz)
{
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
foreach ($source_income_group as $source_income_grou)
{
    echo '<optgroup label="---' . $source_income_grou->option_group . '---">';
    foreach ($source_income as $source_incom)
    {
        if ($source_income_grou->option_group == $source_incom->option_group)
        {
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
                                                    <input class="form-control" id="company_name" name="company_name"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-6 pb-3">
                                                    <label for="exampleFirst">Length of Existence <i>(ex: 2 years and 9
                                                            months)</i>*</label>
                                                    <div class="form-inline">
                                                        <input class="form-control number" style="width:30%;"
                                                            name="existencelengthyears" id="existencelengthyears"
                                                            type="number" oninput="this.value = Math.abs(this.value)" />
                                                        <input class="form-control" style="width:20%;" type="text"
                                                            value="Years" disabled />
                                                        <input class="form-control number" style="width:30%;"
                                                            name="existencelengthmonths" id="existencelengthmonths"
                                                            type="number" oninput="this.value = Math.abs(this.value)" />
                                                        <input class="form-control" style="width:20%;" type="text"
                                                            value="Months" disabled />
                                                    </div>
                                                    <!--input class="form-control" id="existence_length" name="existence_length" type="number" oninput="this.value = Math.abs(this.value)"-->
                                                </div>
                                                <div class="col-sm-4 pb-3">
                                                    <label for="exampleFirst">Rank / Position in Current Job*</label>
                                                    <input class="form-control" id="position" name="position"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-5 pb-3">
                                                    <label for="exampleFirst">Status*</label>
                                                    <select class="form-control custom-select" name="position_status"
                                                        id="position_status">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                        <?php
foreach ($status as $stat)
{
    echo '<option value = "' . $stat->grid . '" >' . $stat->referencename . '</option>';
}
?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleSt">Is Your Business Registered?*</label><br />
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="register_1" name="register"
                                                            class="custom-control-input" value="561" checked>
                                                        <label class="custom-control-label" for="register_1">Yes</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="register_2" name="register"
                                                            class="custom-control-input" value="562">
                                                        <label class="custom-control-label" for="register_2">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 pb-3">
                                                    <label>Company / Business Address:</label>
                                                </div>
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleSt">Region | Province | Municipality |
                                                        Barangay | Zip*</label>
                                                    <select
                                                        class="js-example-basic-multiple-another form-control custom-select testregion"
                                                        multiple="multiple" minimumInputLength="3" style="width:100%"
                                                        name="busaddress" id="busaddress">
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
foreach ($region as $reg)
{
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
                                                    <input class="form-control" id="address_bus" name="address_bus"
                                                        placeholder="Address" type="text">
                                                </div>
                                                <!--div class="col-sm-2 pb-3 businessadd">
                                                    <label for="exampleAccount">Zip Code* </label>
                                                    <input class="form-control number" id="zip_bus" name="zip_bus"
                                                        placeholder="Zip Code" type="number"
                                                        oninput="this.value = Math.abs(this.value)">
                                                </div-->
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Nature of Work</label>
                                                    <input class="form-control" id="nature_work" name="nature_work"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Tel / Fax No</label>
                                                    <input class="form-control number" id="telephone_no"
                                                        name="telephone_no" type="number"
                                                        oninput="this.value = Math.abs(this.value)">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Email Address</label>
                                                    <input class="form-control number" id="previous_email"
                                                        name="previous_email" type="email">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">No. of Years in Business*</label>
                                                    <input class="form-control number" id="years_business"
                                                        name="years_business" type="number"
                                                        oninput="this.value = Math.abs(this.value)">
                                                </div>

                                                <div class="col-sm-12 pb-3">
                                                    <b class="motortrade">Previous Employer</b>
                                                </div>

                                                <div class="col-sm-8 pb-3">
                                                    <label for="exampleFirst">Name of Previous Employer</label>
                                                    <input class="form-control" id="previous_employer_name"
                                                        name="previous_employer_name" type="text">
                                                </div>

                                                <div class="col-sm-4 pb-3">
                                                    <label for="exampleFirst">Tel No</label>
                                                    <input class="form-control" id="previous_employer_telno"
                                                        name="previous_employer_telno" type="text">
                                                </div>

 

                                                <div class="col-sm-12 pb-3">
                                                    <label>Previous Employer Address:</label>
                                                </div>
                                                <div class="col-sm-12 pb-3 businessadd">
                                                    <label for="exampleAccount">Address (Unit No. / Building / Street)
                                                    </label>
                                                    <input class="form-control" id="previous_employer_street"
                                                        name="previous_employer_street" placeholder="Address"
                                                        type="text">
                                                </div>
                                                <!--div class="col-sm-2 pb-3 businessadd">
                                                    <label for="exampleAccount">Zip Code* </label>
                                                    <input class="form-control number" id="previous_employer_zip"
                                                        name="previous_employer_zip" placeholder="Zip Code"
                                                        type="number" oninput="this.value = Math.abs(this.value)">
                                                </div-->
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleSt">Region | Province | Municipality |
                                                        Barangay | Zip</label>
                                                    <select
                                                        class="js-example-basic-multiple-another form-control custom-select testregion"
                                                        multiple="multiple" minimumInputLength="3" style="width:100%"
                                                        name="previous_employer_address" id="previous_employer_address">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-sm-4 pb-3">
                                                    <label for="exampleFirst">Rank / Position in Previous Job</label>
                                                    <input class="form-control" id="previous_job" name="previous_job"
                                                        type="text">
                                                </div>
                                                                                               <div class="col-sm-8 pb-3">
                                                    <label for="exampleFirst">Length of Existence <i>(ex: 2 years and 9
                                                            months)</i></label>
                                                    <div class="form-inline">
                                                        <input class="form-control number" style="width:30%;"
                                                            name="previouselengthyears" id="previouslengthyears"
                                                            type="number" oninput="this.value = Math.abs(this.value)" />
                                                        <input class="form-control" style="width:20%;" type="text"
                                                            value="Years" disabled />
                                                        <input class="form-control number" style="width:30%;"
                                                            name="previouslengthmonths" id="previouslengthmonths"
                                                            type="number" oninput="this.value = Math.abs(this.value)" />
                                                        <input class="form-control" style="width:20%;" type="text"
                                                            value="Months" disabled />
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
                                            </div>
                                            <div class="col-sm-6 pb-3 monthlyincome" style="display: none;">
                                                <label for="exampleFirst">Monthly Income*</label>
                                                <input class="form-control number" id="monthly_income"
                                                    name="monthly_income" type="number"
                                                    oninput="this.value = Math.abs(this.value)">
                                            </div>
                                            <div class="col-sm-6 pb-3 monthlyremittance" style="display: none;">
                                                <label for="exampleFirst">Monthly Provision*</label>
                                                <input class="form-control number" id="monthly_remittance"
                                                    name="monthly_remittance" type="number"
                                                    oninput="this.value = Math.abs(this.value)">
                                            </div>
                                            <!--div class="col-sm-6 pb-3">
                                 <label for="exampleFirst">Bank / Financing*</label>
                                 <select class="form-control custom-select" name="bank" id="bank">
                                   <option value="" class="text-white bg-warning">
                                     Choose
                                   </option>
                                  <option value="546">BANK OF MAKATI</option>
                                  <option value="547">FUND LINE</option>
                                 </select>
                                 </div> 
                                 
                                 <div class="col-sm-6 pb-3">
                                 <label for="exampleFirst">Monthly Amortization*</label>
                                 <input class="form-control" id="monthly_amortization" name="monthly_amortization" type="number" oninput="this.value = Math.abs(this.value)">
                                 </div> 
                                 
                                 <div class="col-sm-6 pb-3">
                                 <label for="exampleFirst">User / Name of Unit*</label>
                                 <input class="form-control" id="name_of_unit" name="name_of_unit" type="text">
                                 </div> 
                                 
                                 <div class="col-sm-6 pb-3">
                                 <label for="exampleFirst">Relationship to Borrower*</label>
                                 <input class="form-control" id="borrower_relation" name="borrower_relation" type="text">
                                 </div-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingSix">
                                    <h2 class="mb-0">
                                        <button
                                            class="d-flex align-items-center justify-content-between btn btn-link collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseSix"
                                            aria-expanded="false" aria-controls="collapseSix">
                                            C. Monthly Income Computation
                                            <span class="fa-stack fa-2x">
                                                <i class="fa fa-circle fa-stack-2x"></i>
                                                <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix">
                                    <div class="card-body">
                                        <div id="div_selector">
                                            <div class="row mt-4" style="border: 2px #ccc solid;">
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleSt">Sources of Fund*</label>
                                                    <select class="form-control custom-select" name="source_fund"
                                                        id="source_fund">
                                                        <option value="" class="text-white bg-warning">
                                                            Choose
                                                        </option>
                                                        <?php
foreach ($source_fund as $fund)
{
    echo '<option value = "' . $fund->grid . '" data-id="' . $fund->grid . '">' . $fund->referencename . '</option>';
}
?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Salary</label>
                                                    <input class="form-control number" id="salary" name="salary"
                                                        type="number" oninput="this.value = Math.abs(this.value)"
                                                        onkeyup="compute()">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Business Income</label>
                                                    <input class="form-control number" id="business_income"
                                                        name="business_income" type="number"
                                                        oninput="this.value = Math.abs(this.value)" onkeyup="compute()">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Other Income</label>
                                                    <input class="form-control number" id="other_income"
                                                        name="other_income" type="number"
                                                        oninput="this.value = Math.abs(this.value)" onkeyup="compute()">
                                                </div>
                                                <div class="col-sm-3 pb-3">
                                                    <label for="exampleFirst">Gross (Salary + Business + Other) </label>
                                                    <input class="form-control number" id="gross_income"
                                                        name="gross_income" type="number"
                                                        oninput="this.value = Math.abs(this.value)" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFive">
                                    <h2 class="mb-0">
                                        <button
                                            class="d-flex align-items-center justify-content-between btn btn-link collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseFive"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            D. Existing Loans
                                            <span class="fa-stack fa-sm">
                                                <i class="fa fa-circle fa-stack-2x"></i>
                                                <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive">
                                    <div class="card-body">
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <b class="motortrade" style="margin: 5px">Existing Loan # 1</b>
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
                                                <input class="form-control" id="l1_amount" name="l1_amount"
                                                    type='number'>
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Monthly Installment</label>
                                                <input class="form-control" id="l1_monthly" name="l1_monthly"
                                                    type="text">
                                            </div>
                                            <div class="col-sm-2 pb-3">
                                                <label for="exampleFirst">Terms</label>
                                                <input class="form-control number" id="l1_terms" name="l1_term"
                                                    type="number" oninput="this.value = Math.abs(this.value)">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Date Granted</label>
                                                <input class="form-control" id="l1_granted" name="l1_granted"
                                                    type="date">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Maturity Date</label>
                                                <input class="form-control" id="l1_maturity" name="l1_maturity"
                                                    type="date">
                                            </div>
                                        </div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <b class="motortrade" style="margin: 5px">Existing Loan # 2</b>
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
                                                <input class="form-control" id="l2_amount" name="l2_amount"
                                                    type='number'>
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Monthly Installment</label>
                                                <input class="form-control" id="l2_monthly" name="l2_monthly"
                                                    type="text">
                                            </div>
                                            <div class="col-sm-2 pb-3">
                                                <label for="exampleFirst">Terms</label>
                                                <input class="form-control number" id="l2_terms" name="l2_term"
                                                    type="number" oninput="this.value = Math.abs(this.value)">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Date Granted</label>
                                                <input class="form-control" id="l2_granted" name="l2_granted"
                                                    type="date">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Maturity Date</label>
                                                <input class="form-control" id="l2_maturity" name="l2_maturity"
                                                    type="date">
                                            </div>
                                        </div>
                                        <div class="row mt-4" style="border: 2px #ccc solid;">
                                            <b class="motortrade" style="margin: 5px">Existing Loan # 3</b>
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
                                                <input class="form-control" id="l3_amount" name="l3_amount"
                                                    type='number'>
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="exampleFirst">Monthly Installment</label>
                                                <input class="form-control" id="l3_monthly" name="l3_monthly"
                                                    type="text">
                                            </div>
                                            <div class="col-sm-2 pb-3">
                                                <label for="exampleFirst">Terms*</label>
                                                <input class="form-control number" id="l3_terms" name="l3_term"
                                                    type="number" oninput="this.value = Math.abs(this.value)">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Date Granted</label>
                                                <input class="form-control" id="l3_granted" name="l3_granted"
                                                    type="date">
                                            </div>
                                            <div class="col-sm-5 pb-3">
                                                <label for="exampleFirst">Maturity Date</label>
                                                <input class="form-control" id="l3_maturity" name="l3_maturity"
                                                    type="date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button
                                            class="d-flex align-items-center justify-content-between btn btn-link collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">
                                            E. References
                                            <span class="fa-stack fa-2x">
                                                <i class="fa fa-circle fa-stack-2x"></i>
                                                <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree">
                                    <div class="card-body">
                                        <div id="div_selector">
                                            <div class="row mt-4" style="border: 2px #ccc solid;">
                                                <b class="motortrade" style="margin: 5px">Reference # 1</b>
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleAccount">Full Name*</label>
                                                    <input class="form-control" name="r1_name" id="r1_customer_name"
                                                        placeholder="Full Name" type="text">
                                                </div>
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleFirst">Address*</label>
                                                    <input class="form-control" id="r1_address" name="r1_address"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-6 pb-3">
                                                    <label for="exampleLast ">Mobile Number* <i>(example:
                                                            0918-1234567)</i></label>
                                                    <input class="form-control mobile" id="r1_contact_no" autocomplete="new-password"
                                                        name="r1_contact_no" type='tel' placeholder="09XX-XXXXXXX" maxlength="12"
                                                        onkeypress="return onlyNumberKey(event)">
                                                </div>
                                                <div class="col-sm-6 pb-3">
                                                    <label for="exampleFirst">Relationship*</label>
                                                    <input class="form-control" id="r1_relationship"
                                                        name="r1_relationship" type="text">
                                                </div>
                                            </div>
                                            <div class="row mt-4" style="border: 2px #ccc solid;">
                                                <b class="motortrade" style="margin: 5px">Reference # 2</b>
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleAccount">Full Name*</label>
                                                    <input class="form-control" name="r2_name" id="r2_customer_name"
                                                        placeholder="Full Name" type="text">
                                                </div>
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleFirst">Address*</label>
                                                    <input class="form-control" id="r2_address" name="r2_address"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-6 pb-3">
                                                    <label for="exampleLast ">Mobile Number* <i>(example:
                                                            0918-1234567)</i></label>
                                                    <input class="form-control mobile" id="r2_contact_no" autocomplete="new-password"
                                                        name="r2_contact_no" type='tel' placeholder="09XX-XXXXXXX" maxlength="12"
                                                        onkeypress="return onlyNumberKey(event)">
                                                </div>
                                                <div class="col-sm-6 pb-3">
                                                    <label for="exampleFirst">Relationship*</label>
                                                    <input class="form-control" id="r2_relationship"
                                                        name="r2_relationship" type="text">
                                                </div>
                                            </div>
                                            <div class="row mt-4" style="border: 2px #ccc solid;">
                                                <b class="motortrade" style="margin: 5px">Reference # 3</b>
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleAccount">Full Name*</label>
                                                    <input class="form-control" name="r3_name" id="r3_customer_name"
                                                        placeholder="Full Name" type="text">
                                                </div>
                                                <div class="col-sm-12 pb-3">
                                                    <label for="exampleFirst">Address*</label>
                                                    <input class="form-control" id="r3_address" name="r3_address"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-6 pb-3">
                                                    <label for="exampleLast ">Mobile Number* <i>(example:
                                                            0918-1234567)</i></label>
                                                    <input class="form-control mobile" id="r3_contact_no" autocomplete="new-password"
                                                        name="r3_contact_no" type='tel' placeholder="09XX-XXXXXXX" maxlength="12"
                                                        onkeypress="return onlyNumberKey(event)">
                                                </div>
                                                <div class="col-sm-6 pb-3">
                                                    <label for="exampleFirst">Relationship*</label>
                                                    <input class="form-control" id="r3_relationship"
                                                        name="r3_relationship" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h2 class="mb-0">
                                        <button
                                            class="d-flex align-items-center justify-content-between btn btn-link collapsed"
                                            type="button">
                                            F. Attachments and Signature
                                        </button>
                                        <!--button class="d-flex align-items-center justify-content-between btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                              A. Loan Application Details
                              <span class="fa-stack fa-sm">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-minus fa-stack-1x fa-inverse"></i>
                              </span>
                              </button-->
                                    </h2>
                                </div>
                                <!--div id="collapseFour" class="collapse" aria-labelledby="headingFour"-->
                                <div>
                                    <div class="card-body">
                                        <div class="row mt-4" style="border: 2px #ccc solid;margin-top:5px">
                                            <div class="refattach">
                                                <div style="margin-left: 1em">
                                                    <div class="container py-3">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p>Upload Attachments <i>(Maximum of 1MB filesize per attachment)</i></p>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="custom-file" >
                                                                <input type="file" class="custom-file-input upload-file"
                                                                    id="govtid" data-max-size="2048" name="govtid"
                                                                    accept="image/jpeg, image/png, application/pdf,"
                                                                    aria-describedby="govtid">
                                                                <label class="custom-file-label" id="govtidlab"
                                                                    for="govtid" style="color:gray">Upload one valid ID
                                                                    (Government ID, Driver's License, etc) *</label>
                                                                </div>
                                                                     <div class="input-group-append">
                                                                <button type="button" id="govtidrem"><i
                                                                        class="fa fa-times"
                                                                        aria-hidden="true"></i></button>
                                                            </div>
                                                            </div>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input upload-file"
                                                                    id="coe" data-max-size="2048" name="coe"
                                                                    accept="image/jpeg, image/png, application/pdf,"
                                                                    aria-describedby="coe">
                                                                <label class="custom-file-label" id="coelab" for="coe"
                                                                    style="color:gray">Upload your current Certificate
                                                                    of Employment</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" id="coerem"><i class="fa fa-times"
                                                                        aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input upload-file"
                                                                    id="billing" data-max-size="2048" name="billing"
                                                                    accept="image/jpeg, image/png, application/pdf,"
                                                                    aria-describedby="billing">
                                                                <label class="custom-file-label" id="billinglab"
                                                                    for="billing" style="color:gray">Proof of
                                                                    billing</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" id="billingrem"><i
                                                                        class="fa fa-times"
                                                                        aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input upload-file"
                                                                    id="selfie" data-max-size="2048" name="selfie"
                                                                    accept="image/jpeg, image/png, application/pdf,"
                                                                    aria-describedby="selfie">
                                                                <label class="custom-file-label" id="selfielab"
                                                                    for="selfie" style="color:gray">Upload a selfie so
                                                                    that we can recognize you</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" id="selfierem"><i
                                                                        class="fa fa-times"
                                                                        aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input upload-file"
                                                                    id="sketch" data-max-size="2048" name="sketch"
                                                                    accept="image/jpeg, image/png, application/pdf,"
                                                                    aria-describedby="sketch">
                                                                <label class="custom-file-label" id="sketchlab"
                                                                    for="sketch" style="color:gray">Take a photo of the
                                                                    sketch of your home</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" id="sketchrem"><i
                                                                        class="fa fa-times"
                                                                        aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--label for="myfile">Upload one valid ID (Government ID, Driver's License, etc) *</label>
                                       <input type="file" id="govtid" class="upload-file" data-max-size="2048" name="govtid" accept="image/jpeg, image/png, application/pdf,">
                                       <br/>
                                                           <label for="myfile">Upload your current Certificate of Employment</label>
                                       <input type="file" id="coe" class="upload-file" data-max-size="2048" name="coe" accept="image/jpeg, image/png, application/pdf,">
                                         <br/>
                                                           <label for="myfile">Proof of billing *</label>
                                       <input type="file" id="billing" class="upload-file" data-max-size="2048" name="billing" accept="image/jpeg, image/png, application/pdf,">
                                         <br/>
                                                           <label for="myfile">Upload a selfie so that we can recognize you *</label>
                                       <input type="file" id="selfie"  class="upload-file" data-max-size="2048" name="selfie" accept="image/jpeg, image/png, application/pdf,">
                                         <br/>
                                                           <label for="myfile">Take a photo of the sketch of your home</label>
                                       <input type="file" id="sketch" class="upload-file" data-max-size="2048" name="sketch" accept="image/jpeg, image/png, application/pdf,"-->
                                                </div>
                                            </div>
                                            <div class="refsigna">
                                                <div style="margin-left: 1rem; margin-bottom: 1rem">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-12" style="margin-top: 1rem">
                                                                <p>Please sign the field below.</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <canvas id="sig-canvas" width="620" height="160">
                                                                    Get a better browser, bro.
                                                                </canvas>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <!--button id="sig-submitBtn" style="display: none;">Submit Signature</button-->
                                                                <button id="sig-clearBtn" type="button">Clear
                                                                    Signature</button>
                                                            </div>
                                                        </div>
                                                        <br />
                                                        <textarea id="sig-dataUrl" style="display:none;"
                                                            class="form-control" name="sig-dataUrl" rows="5"></textarea>
                                                        <br />
                                                        <!--div class="row">
                                          <div class="col-md-12">
                                            <img id="sig-image" src="" alt="Your signature will go here!"/>
                                          </div>
                                          </div-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 1rem; margin-left: 5px">
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
foreach ($occupation as $occup)
{
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
foreach ($areas as $area)
{
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
                                        <input class="form-check-input required-field" type="checkbox" id="myChecked"
                                            onclick="myFunctions()">
                                        <label class="form-check-label" for="agreement-checkbox">
                                            By completing the form below, I agree to the <a
                                                href="https://motortrade.com.ph/privacy-page/" target="_blank"
                                                title="Data Privacy">Data Privacy Statement</a> of
                                            Motortrade.<br /><br />
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
                                <button type="button" id="text" class="btn btn-lg btn-primary"
                                    onclick="myFunction()">Submit Form</button>
                            </div>
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
    <div class="ajax-loader d-flex justify-content-center"
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; ">
        <div
            style="background: linear-gradient(#000, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #000); opacity: .5; position: absolute; width: 100%; height: 100%;">
        </div>
        <img src="assets/loader-1.gif" style="height: 10% !important;" class="align-self-center">
    </div>
</body>

</html>
<script language="JavaScript" type="text/javascript"
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script language="JavaScript" type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script language="JavaScript" type="text/javascript"
    src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
   
      $("#sourceid").val();
          $('input[type="file"]').change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+fileExtension.join(', '));
            $(this).val('');
        }
        if(this.files[0].size > 1000000){
           alert("File size must not be greater than 1 mb.");
            $(this).val('');
        }
    });
    var branches = '<?php echo addcslashes(json_encode($branches) , "'\\/"); ?>';
var objbr = JSON.parse(branches);
var areas = '<?php echo addcslashes(json_encode($areas) , "'\\/"); ?>';
var obja = JSON.parse(areas);
var model = '<?php echo json_encode($model); ?>';
var objm = JSON.parse(model);
var province = '<?php echo json_encode($province); ?>';
var objp = JSON.parse(province);
//alert(JSON.stringify(objp[0]));
var city = '<?php echo addcslashes(json_encode($city) , "'\\/"); ?>';
var objc = JSON.parse(city);
var barangay = '<?php echo addcslashes(json_encode($barangay) , "'\\/"); ?>';
var objb = JSON.parse(barangay);
var clusters = '<?php echo addcslashes(json_encode($clusters) , "'\\/"); ?>';
var objcl = JSON.parse(clusters);
//alert(JSON.stringify(objm));    
    </script>
    <script src="<?= base_url(); ?>assets/js/loan1.js?1"></script>