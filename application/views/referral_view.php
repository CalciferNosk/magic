<link rel="icon" href="assets/favicon.ico">
<title>
  Referral Form | Motortrade Group
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
</script>
<p id="demo"></p>
<form action="Referral/submit" method="POST" onsubmit="return validate(this);" autocomplete="off">

  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

  <div class="row">
    <div class="col-md-10 offset-md-1">
      <span class="anchor" id="formComplex"></span>

      <!-- Modal -->

      <!-- form complex example -->
      <div class="card card-outline-secondary">
        <div class="card-header">
          <h3 class="mb-0">Referral Form<span style="font-size: 8pt">v1.1.0
            </span></h3>

        </div>
        <div class="card-body">
          <h5>Inquiry Details</h5>

          <div class="row mt-4">
            <div class="col-sm-8 pb-3">
              <label for="exampleAccount">Referral Name*</label>
              <input class="form-control" id="referral_name" name="referral_name" placeholder="Referral Name" type="text" required>
            </div>
            <div class="col-sm-4 pb-3">
              <label for="exampleSt">Source*</label> <select class="form-control custom-select" name="source_referral" id="source" required>
                <option value="" class="text-white bg-warning">
                  Choose
                </option>
                <?php
                foreach ($source_referral as $referral) {
                  echo '<option value = "' . $referral->grid . '" data-id="' . $referral->grid . '">' . $referral->referencename . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-sm-12 pb-3">
              <label for="exampleFirst">Category*</label>
              <select class="form-control custom-select pull-left" id="inquiry" name="inquiry" required>
                <option value="" class="text-white bg-warning">
                  Choose
                </option>
                <?php
                foreach ($categories as $category) {
                  echo '<option value = "' . $category->catid . '" >' . $category->categoryname . '</option>';
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
                        foreach ($sources as $source) {
                          echo '<option value = "' . $source->grid . '">' . $source->referencename . '</option>';
                        }
                        ?>
<option value="OTHERS">OTHERS</option>
                    </select>
                  </div-->



            <!--div class="col-sm-3 pb-3">
                    <label for="exampleSt">MC Type</label> <select class="form-control custom-select" name="type" id="type">
                     <option value="" class="text-white bg-warning">
                        Choose
                      </option>
 <?php
  foreach ($types as $type) {
    echo '<option value = "' . $type->grid . '">' . $type->referencename . '</option>';
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
                foreach ($brand as $bran) {
                  echo '<option value = "' . $bran->grid . '" data-id="' . $bran->grid . '">' . $bran->referencename . '</option>';
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
                foreach ($colors as $color) {
                  echo '<option value = "' . $color->grid . '" >' . $color->referencename . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-sm-12 pb-3">
              <label for="exampleLast">Please select Branch*</label>
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
            <div class="col-md-9 pb-3">
              <label for="exampleMessage">Inquiry Details</label>
              <textarea class="form-control" id="details" name="details" rows="1"></textarea>
              If you want to apply for a loan, use our Motorcycle Loan Application Form instead.
            </div>
            <div class="col-sm-3 pb-3 ">
              <label for="exampleFirst">Plan Date to Purchase*</label>
              <input class="form-control" id="date_purchase" name="date_purchase" placeholder="Date of Purchase" type="date" required>
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

            <div class="row" style="margin-bottom: 1rem; margin-left: 20px">
              <div class="row ml-0">
                <?php echo '<br/><br/>';
                echo $widget; ?><?php echo $script; ?>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div align="center">
              <button type="submit" id="myCheck" style="display:none">Sign Up</button>
              <button type="button" class="btn btn-lg btn-primary" id="text" onclick="myFunction();">Submit Form</button>
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
<div class="ajax-loader d-flex justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; ">
  <div style="background: linear-gradient(#000, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #FFF, #000); opacity: .5; position: absolute; width: 100%; height: 100%;"></div>
  <img src="assets/loader-1.gif" style="height: 10% !important;" class="align-self-center">
</div>
<script>
  //alert(JSON.stringify(objm));
  //objb.forEach(foreach);
  var model = '<?php echo json_encode($model); ?>';
  var objm = JSON.parse(model);
</script>
<script src="<?= base_url(); ?>assets/js/common.js?1"></script>
<script src="<?= base_url(); ?>assets/js/referral.js?1"></script>