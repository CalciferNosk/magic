
<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="assets/favicon.ico">
    <title>LOGIN | <?=  strtoupper($module)?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Online Service Appointment Motortrade">
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <meta name="author" content="The company's slogan “Motorsiklo Sigurado, Alaga Ka Dito” sums up its number one priority — Total Customer Satisfaction is what we always guarantee!">
    <link rel="icon" href="assets/favicon.ico">
    <link rel="stylesheet" type="text/css" href="./assets/clearance_assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/template_cdn/css/login-booststrap.min.css">
    <link href="<?= base_url() ?>assets/template_cdn/css/login-fontawesome.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <style>
        
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 1000;
        }

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        .spinner-border {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
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
                    <div style="display:inline">
                        <img class="img-logo " src="./assets/clearance_assets/image/icon-circle.png" style="width:12%" alt="">
                        <span class="title text-center mt-4" style="padding-top: 10px; font-weight:600;font-size:23px;margin-left:5px;margin-top:10px;">
                            <?= strtoupper($module) ?> LOGIN
                        </span>
                    </div>
                    <br>
                    <span class="alert alert-danger" role="alert" style="display: none; position:sticky">
                       
                    </span>
                    <br>
                    <form class="form-box px-3" enctype="multipart/form-data" data-formstate="0" data-otptries="3" data-otpstate="0" data-otp-exp-min="5">
                        <div class="form-input">
                            <span><i class="fa fa-user"></i></span>
                            <input class="input" type="text" id="username" name="username" placeholder="username" tabindex="10" required>
                        </div>
                        <div class="form-input">
                            <span><i class="fa fa-key"></i></span>
                            <input class="input" type="password" id="password" name="password" placeholder="password" required>
                        </div>
                        <div class="mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="cb1" name="data-privacy" value="1" required>
                                <label class="custom-control-label" for="cb1" style="font-size:9px;font-weight:600; max-width:390px;text-align:justify;">
                                    I agree to Motortrade's<a href="https://motortrade.com.ph/privacy-page/" target="_blank" title="Data Privacy">
                                        Data Privacy Statement <i class="fa fa-external-link" aria-hidden="true"></i></a>.
                                    <?php if ($module == 'case nte'):  ?>
                                        I affirm that the use of this system is for status inquiry and convenience
                                        of coordination between ex-employee and Motortrade representatives.Anycomplex
                                        disputes must be coordinated with the HR ES Manager directly.
                                        I agree to use the system accordingly and communicate in a professional manner.I am aware that
                                        I can be made liable for any misdeclaration or abuse of this system.
                                    <?php endif; ?>
                                </label>
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
                                <span class="text" id="text-btn" type="submit"> Continue</span>
                            </button>
                        </div>
                    </form>
                    <img class="img-logo " src="<?= base_url() ?>assets/clearance_assets/image/footer.png" style="width:100%" alt="">
                </div>
            </div>
        </div>
    </div>
    <div id="loading-overlay" style="display: none;">
        <div class="loading-spinner">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <footer class="fixed-bottom" style="width:100%;">
        <p class="pull-right" style="padding-right:2rem!important;color:lightgray">V1.0.0</p>
    </footer>
    <script src="<?= base_url() ?>assets/template_cdn/js/login-jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/template_cdn/js/login-bootstrap.min.js" ></script>
    <script>
        $(document).ready(function() {
            var base_url = "<?= base_url() ?>";
            var routes = "<?= $login_routes ?>-login";

            function isCaptchaChecked() {
                return grecaptcha && grecaptcha.getResponse().length !== 0;
            }

            function showLoadingOverlay() {
                document.getElementById('loading-overlay').style.display = 'block';
            }
            // Hide loading overlay
            function hideLoadingOverlay() {
                document.getElementById('loading-overlay').style.display = 'none';
            }

            $(document).on('submit', 'form', function(e) {
                e.preventDefault();
                // if (!isCaptchaChecked()) {
                //     alert('Please validate Captcha to see if you\'re not a robot');
                //     return false;
                // }
                if ($('#cb1').is(':checked')) {
                    var formData = new FormData(this);
                    formData.append('_cmcToken', $(`meta[name="_cmcToken"]`).attr("content"))
                    formData.append('module', `<?= $module ?>`)
                    $('#text-btn').text('Processing')
                    $('#continue-btn').attr('disabled', 'disabled')
                    showLoadingOverlay()
                    // console.log(formdata)
                    $.ajax({
                        url: base_url + routes,
                        method: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            console.log(JSON.parse(response.output).message)
                            if (response.httpcode == 200) {
                                location.href = response.redirect;
                            } else {
                                var output_result = JSON.parse(response.output)
                                $('.alert-danger').css('display', 'block').text(output_result.message)
                                $('#text-btn').text('continue')
                                $('#continue-btn').removeAttr('disabled')
                            }
                            hideLoadingOverlay() 
                        }
                    }) //end ajax
                } else {
                    return false;
                }
            })
        })
    </script>
</body>

</html>