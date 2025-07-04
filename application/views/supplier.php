<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Supplier Portal | Motortrade Group</title>
  <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/newloan.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/inquiryloan.css">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico" />
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


  /* Custom checkbox */
</style>

<body>
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
    <div class="row justify-content-center mt-0">
      <div class="col-11 col-sm-9 col-md-7 col-lg-11 text-center p-0 mt-3 mb-2">
        <div class="card">
          <div class="row">
            <div class="col-md-12 mx-0">
              <form action="Supplier/tabsix" id="msform" method="POST" enctype='multipart/form-data' data-formstate="0">
              <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                <!-- progressbar -->
                <ul id="progressbar">
                  <li style="display:none;" class="active"></li>
                  <li id="account" style="display:none"><strong class="toplab">Supplier Information</strong></li>
                  <li id="confirm" style="display:none"><strong class="toplab">Attachments & Signature</strong></li>
                  <li style="display: none;"><strong>Attachments & Signature</strong></li>
                </ul>
                <fieldset>
                  <div class="form-card-start form-card-logo">
                    <img src="<?= base_url(); ?>/assets/mopom1.jpg" alt="">
                  </div>
                  <div class="form-card-start">

                    <div class="buttons" align="center">
                      <br />
                      <div>
                        <div class="col-sm-10">
                          <b>Enter Supplier Code*</b>
                          <input class="form-control" type="text" id="updateid" class="form-control otp-input modal-ku" style="text-align: center !important;">
                        </div>

                        <div class="col-sm-10">
                          <b>Mobile Number*<br /> <i>(example: 0918-1234567)</i></b>
                          <input class="form-control mobile" id="updateno" name="updateno" placeholder="09XX-XXXXXXX" type="tel" maxlength="12" onkeypress="return onlyNumberKey(event)" style="text-align: center !important;">
                        </div>
                      </div>

                      <button type="button" id="testupdate" class="btn btn-primary btn-block">Continue</button><br />
                      <text class="text-center" style="font-size:0.5em">v1.0.2 &copy; 2021, All Right Reserved.</text>




                    </div>

                  </div>
                  <input type="button" id="proceed" name="next" class="next action-button" style="display:none;" value="Save and Next">
                </fieldset>
                <fieldset>
                  <h2><strong>Motortrade Supplier Portal</strong></h2><label>v1.0.2</label>
                  <div class="form-card">
                    <h2 class="fs-title alignleft">Supplier Information</h2>
                    <!--h5 class="alignright">Form Record ID: 123456</h5-->
                    <div style="clear: both;"></div>
                    <input type="hidden" id="loan_type" name="type_new" value="564" />
                    <div class="row">
                      <div class="col-sm-8 pb-3">
                        <label for="exampleAccount">Supplier Name*</label>
                        <input class="form-control" name="first_name" id="SupplierName" placeholder="SupplierName" pattern="^\D*$" title="Please enter only alphabets" type="text">
                      </div>
                      <div class="col-sm-4 pb-3">
                        <label for="exampleAccount">Supplier Code*</label>
                        <input class="form-control" name="last_name" id="SupplierCode" placeholder="Supplier Code" type="text" disabled>
                      </div>
                      <div class="col-sm-4 pb-3">
                        <label for="exampleAccount">Contact Person*</label>
                        <input class="form-control" name="contact_persons" id="ContactPerson" placeholder="Contact Person" type="text">
                      </div>
                      <div class="col-sm-4 pb-3 ">
                        <label for="exampleFirst">Email Address</label>
                        <input class="form-control" id="Email" name="email" placeholder="Email Address" type="email">
                      </div>
                      <div class="col-sm-4 pb-3">
                        <div>
                          <label for="exampleFirst">
                            Mobile Number*
                            <i>(example: 0918-1234567) </i>
                            <br>

                          </label>
                        </div>


                        <input class="form-control mr-1 mobile" id="ContactNumber" name="contact_no" placeholder="Mobile Number" type="tel" maxlength="12" onkeypress="return onlyNumberKey(event)">
                      </div>
                      <div class="col-sm-4 pb-3">
                        <label>Tax Type*</label>
                        <select class="form-control custom-select" name="brand" id="TaxTypeId">
                          <option value="" class="text-white bg-warning">
                            Choose
                          </option>
                          <?php
                          foreach ($taxtype as $tax) {
                            echo '<option value = "' . $tax['grid'] . '" data-id="' . $tax['grid'] . '">' . $tax['referencename'] . '</option>';
                          }
                          ?>
                        </select>
                      </div>

                      <div class="col-sm-4 pb-3">
                        <label>Owner Type*</label>
                        <select class="form-control custom-select" name="brand" id="TypeOfOwnershipId">
                          <option value="" class="text-white bg-warning">
                            Choose
                          </option>
                          <?php
                          foreach ($ownertype as $owner) {
                            echo '<option value = "' . $owner['grid'] . '" data-id="' . $owner['grid'] . '">' . $owner['referencename'] . '</option>';
                          }
                          ?>
                        </select>
                      </div>

                      <div class="col-sm-4 pb-3">
                        <label for="exampleAccount">TIN*</label>
                        <input class="form-control" name="last_name" id="TIN" placeholder="TIN" type="text">
                      </div>
                      <div class="col-sm-4 pb-3">
                        <label>Nature of Business / Services Offered*</label>
                        <input class="form-control" name="last_name" id="NatureOfBusiness" placeholder="Nature of Business" type="text">
                      </div>
                      <div class="col-sm-4 pb-3">
                        <label>Business Years*</label>
                        <input class="form-control" name="last_name" id="TotalBusinessYears" placeholder="Years of Business" type="number">
                      </div>
                      <div class="col-sm-4 pb-3">
                        <label>Landline No*</label>
                        <input class="form-control" name="last_name" id="LandlineNo" placeholder="Landline No" type="text">
                      </div>


                      <div class="col-sm-8 pb-3">
                        <label for="exampleFirst">Address*</label>
                        <input class="form-control" id="Street" name="Street" type="text">
                      </div>
                      <div class="col-sm-4 pb-3">
                        <label>Official Website Name*</label>
                        <input class="form-control" name="last_name" id="OfficialWebsiteAddress" placeholder="Official Website Name" type="text">
                      </div>
                      <div class="col-sm-12 pb-3" style="margin-left: 2% !important;">
                        <input class="form-check-input required-field" style="width:auto;" type="checkbox" id="psgccheck" checked>
                        <label class="form-check-label" for="agreement-checkbox">
                          No changes regarding Region | Province | Municipality |
                          Barangay | Zip<br />
                        </label>
                      </div>

                      <div class="col-sm-12 pb-3" id="psgcshow" style="display:none;">

                        <label for="exampleSt">Region | Province | Municipality |
                          Barangay | Zip*</label>
                        <select class="js-example-basic-multiple-another form-control custom-select testregion" multiple="multiple" minimumInputLength="3" style="width:100%; border-color:red !important" name="presentaddress" id="presentaddress">
                          <option value="" class="text-white bg-warning">
                            Choose
                          </option>
                        </select>
                      </div>
                      <div class="col-sm-12 pb-3">
                        <label for="exampleFirst">Remarks*</label>
                        <div id="check"></div>
                        <!--input class="form-control" id="Remarks" name="Street" type="text"-->
                        <textarea id="Remarks" class="form-control summernote" name="Street" rows="1"></textarea>
                      </div>



                    </div>
                    <div id="validations" class="row ml-0">
                      <div class="form-check col-lg-12">
                        <input class="form-check-input required-field" style="width:auto;" type="checkbox" id="myChecked" onclick="myFunctions()">
                        <label class="form-check-label" for="agreement-checkbox">
                          By completing this form, I agree to the <a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">Data Privacy Statement</a> of
                          Motortrade.<br /><br />
                        </label>
                      </div>

                      <!-- reCapcha Plugin -->
                      <div class="row">
                        <div class="form-group col-lg-12" id="recaptcha">
                          <?php echo $widget; ?><?php echo $script; ?>
                        </div>
                      </div>


                    </div>
                  </div>
                  <input type="button" id="tabone" class="action-button" value="Save and Next">
                  <input type="button" id="oneproc" name="next" style="display: none;" class="next action-button">
                  <!--input type="button" id="oneproc" name="next"  class="next action-button"-->
                </fieldset>
                <fieldset>
                  <h2><strong>Motortrade Supplier Portal</strong></h2><label>v1.0.2</label>
                  <div class="form-card">
                    <h2 class="fs-title alignleft">Attachments</h2>
                    <h5 class="alignright">Supplier Code: <span class="recid"></span></h5>
                    <div style="clear: both;"></div>
                    <div class="row" style="border: 2px #ccc solid;">
                      <input id="id" name="formid" type="hidden">
                      <input id="AssignedTo" name="AssignedTo" type="hidden">
                      <input id="attcount" name="attcount" type="number" style="display:none;">

                      <div class="refattach" style="width:50% !important">

                        <div style="margin-left: 1em; margin-top: 1em;">

                          <div class="container py-6">
                            <h5>Note: Allowed file extension (JPG, PNG, PDF)</h5>
                            <div><button type="button" class="btn btn-primary" id="attachadd">Add Attachment</button><br /><br /></div>
                            <div id="curatt"></div>
                          </div>
                        </div>
                      </div>
                      <div class="refsigna" style="width:50% !important">
                        <div style="margin-left: 1em; margin-top: 1em;">
                          <div class="container py-6">
                            <div id="addatt"></div>
                            <input type="file" class="custom-file-input upload-file" id="billing" data-max-size="2048" name="billing" accept="image/jpeg, image/png, application/pdf," aria-describedby="billing">
                            <!--div class="input-group" id="grpcoe">
                                            <div class="custom-file">
                                               <input type="file" class="custom-file-input upload-file disabledfile" id="coe" data-max-size="2048" name="coe" accept="image/jpeg, image/png, application/pdf," aria-describedby="coe" disabled>
                                               <label class="custom-file-label" id="coelab" for="coe" style="color:gray">Upload your current Certificate of Employment</label>
                                            </div>
                                            <div class="input-group-append">
                                               <button type="button" id="coerem" class="remove-file"><i class="fa fa-times" aria-hidden="true"></i></button>
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
                                         </div-->
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <input type="button" name="previous" class="previous action-button-previous" value="Previous"> <input type="button" id="proceedform" name="finalbutton" class="action-button proceedform" value="Save as Final"><input type="button" name="draftbutton" class="action-button proceedform" value="Save as Draft">
                  <input type="submit" id="sixproc" name="next" style="display: none;" class="next action-button">
                  <div class="form-card" style="width:80% !important; margin-left:10%; margin-top:10;">
                    <div align="left">
                      <h5>Reference:</h5>
                      <div style="margin-left: 2%;">
                        <b>General Requirements:</b><br />
                        Endorsement Letter (internal-RM/DEPT HEAD)<br />
                        Accreditation Form (Supplier commercial form)<br />
                        Accreditation Questionnaire (page2 must be signed by vendor representative)<br />
                        Company profile (with pictures of accomplished projects)<br />
                        Certificate of registration (BIR 2303) <br />
                        Business Permit (current year) <br />
                        Sample invoice and official receipt (check validity)<br />
                        Sample quotation for MNC<br />
                        Valid ID's (manager/owner/representative)<br />
                        Audited Financial Statement (last 2 years)<br />
                        ITR copy tax filed for Year (previous year)<br />
                        PCAB (for contractor only)<br />
                        PNP Approval to operate (for Security Agency only)
                        <div class="row">
                          <div class="col">
                            <br />
                            <b>For Corporation:</b>
                            <br />Articles of Incorporation
                            <br />By Laws
                            <br />General Information Sheet (GIS)
                          </div>
                          <div class="col">
                            <br />
                            <b>For Partnership:</b>
                            <br />SEC of Partnership
                            <br /> Articles of Partnership
                          </div>
                          <div class="col">
                            <br />
                            <b>For Sole Proprietor:</b>
                            <br />DTI Certification
                          </div>
                        </div>

                      </div>
                    </div>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
  <script>
    //    $("#sourceid").val();
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

    $('#proceedform').click(function() {

      //$("#msform").submit();
    });
    //alert(JSON.stringify(objm));    
  </script>
  <script src="<?= base_url(); ?>assets/js/common.js?1"></script>
  <script src="<?= base_url(); ?>assets/js/main.js?1"></script>
  <script src="<?= base_url(); ?>assets/js/supplier1.js?4"></script>
</body>

</html>