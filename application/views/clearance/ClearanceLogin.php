
<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="assets/favicon.ico">
  <title>EMS | Clearance</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Online Service Appointment Motortrade">
  <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
  <meta name="author" content="The company's slogan “Motorsiklo Sigurado, Alaga Ka Dito” sums up its number one priority — Total Customer Satisfaction is what we always guarantee!">

  <link rel="stylesheet" type="text/css" href="./assets/clearance_assets/css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>

<body>
  
 
  <div class="container">
    <div class="row px-3">
      <div class="col-lg-12 col-xl-10 card flex-row mt-3 px-0 shadow-lg">
        <div class="row px-3">

        </div>
        <div class="img-left d-none d-md-flex" style="width:50%">
          <!-- <img  class=" "src="<?= base_url() ?>assets/clearance_assets/image/motortrade.jpg" alt=""> -->
        </div>
        <div class="card-body" style="padding: unset !important;padding-top:2rem !important">
          <div style="display:inline" >
              <img class="img-logo " src="./assets/clearance_assets/image/icon-circle.png" style="width:12%"  alt="">
              <span class="title text-center mt-4" style="padding-top: 10px; font-weight:600;font-size:23px;margin-left:5px;margin-top:10px;">
                Clearance Inquiry
          </span>
          </div>
          <br>
          <span class="alert alert-danger" role="alert" style="display: none; position:sticky">
            Account not Found!
          </span>
          <br>
          <form class="form-box px-3" id="login-form" enctype="multipart/form-data" data-formstate="0" data-otptries="3" data-otpstate="0" data-otp-exp-min="5">
            <div class="form-input">
              <span><i class="fa fa-user"></i></span>
              <input class="input" type="text" id="employee_id" name="employee_id" placeholder="New Employee ID" tabindex="10" required>
            </div>
            <div class="form-input">
              <span><i class="fa fa-calendar" for="birthday"></i></span>
              <input class="input" id="birthday" name="birthday" Placeholder="Birthday" type="date" tabindex="10" required>
            </div>
            <div class="form-input">
              <span><i class="fa fa-user"></i></span>
              <input class="input" type="text" id="lastname" name="lastname" placeholder="Lastname" required>
            </div>
            <div class="mb-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="cb1" name="data-privacy" value="1" required>
                <label class="custom-control-label" for="cb1" style="font-size:9px;font-weight:600; max-width:390px;text-align:justify;">
                  I agree to Motortrade's<a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">
                  Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a>.
                  I affirm that the use of this system is for status inquiry and convenience 
                  of coordination between ex-employee and Motortrade representatives.Anycomplex
                  disputes must be coordinated with the HR ES Manager directly.
                  I agree to use the system accordingly and communicate in a professional manner.I am aware that
                  I can be made liable for any misdeclaration or abuse of this system.</label>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-12" id="recaptcha">
                <?php echo $widget; ?><?php echo $script; ?>
              </div>
            </div>
            <div class="mb-3" align="center">
              <button class="btn-customize" type="submit" id="continue-btn">
                <span class="circle">
                  <span class="arrow"></span>
                </span>
                <span class="text" id="text-btn"> Continue</span>
              </button>
            </div>
          </form>
          <img class="img-logo " src="<?= base_url() ?>assets/clearance_assets/image/footer.png" style="width:100%"  alt="">
        </div>
      </div>
    </div>
  </div>
  <footer class="fixed-bottom" style="width:100%;">
    <p class="pull-right" style="padding-right:2rem!important;color:lightgray">V1.0.0</p>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script>
    function isCaptchaChecked() {
      return grecaptcha && grecaptcha.getResponse().length !== 0;
    }
    $('#login-form').on('submit', function(e) {
      e.preventDefault();
      if (!isCaptchaChecked()) {
        alert('Please validate Captcha to see if you\'re not a robot');
        return false;
      }
      if ($('#cb1').is(':checked')) {
        var employee_id = $('#employee_id').val();
        var birthday = $('#birthday').val()
        var lastname = $('#lastname').val()
        var base_url = "<?= base_url() ?>";
        // console.log(formdata)
        $.ajax({
          url: base_url + 'login',
          method: 'post',
          data: {
            'id': employee_id,
            'birthday': birthday,
            'lastname': lastname,
            _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
          },
          dataType: "json",
          success: function(response) {
            $('#text-btn').text('Processing')
            if (response.response == true) {
              location.href = response.redirect;
            } else {
              $('.alert-danger').css('display', 'block')
              $('#text-btn').text('continue')
            }
          }
        }) //end ajax
      } else {
        return false;
      }
    })
  </script>
</body>

</html>