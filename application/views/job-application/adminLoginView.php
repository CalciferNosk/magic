<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Online Service Appointment Motortrade">
  <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
  <meta name="author" content="The company's slogan “Motorsiklo Sigurado, Alaga Ka Dito” sums up its number one priority — Total Customer Satisfaction is what we always guarantee!">
<link rel="icon" href="assets/favicon.ico">
    <title>CMC Online Exam</title>
    <!-- <link rel="stylesheet" href="./assets/css/mdbootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/mdb_font.css">
    <link rel="stylesheet" href="./assets/css/mdb_ui_kit.min.css"> -->
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <section class="vh-100" style="background-color: #fff4dd;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="<?= base_url()?>assets/images/recruitment_logo.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form id="admin-login-form" method="post" enctype="multipart/form-data" action=""  data-formstate="0" data-otptries="3" data-otpstate="0" data-otp-exp-min="5">

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-pencil fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Admin Login</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign in </h5>

                                       
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="app_email" name="admin_username" class="form-control form-control-lg" />
                                            <label class="form-label" for="app_email">Admin Username</label>
                                        </div>
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="password" id="app_id" name="admin_password" class="form-control form-control-lg" />
                                            <label class="form-label" for="app_id">Admin Password</label>
                                        </div>
                                        <!-- <div class="pt-1 mb-4"> -->
                                            <button  class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                        <!-- </div> -->
                                        <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                                        <!-- <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="#!" style="color: #393f81;">Register here</a></p> -->
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var base_url = `<?= base_url() ?>`;
    </script>
    <script src="<?= base_url() ?>assets/JobApp/js/mdbbootstrap.min.js"></script>
    <script src="<?= base_url()?>assets/JobApp/js/jquery_ajax.min.js"></script>
    
    <script src="<?= base_url() ?>assets/JobApp/js/login.js?refresh=<?= date('YmdHis') ?>"></script>
</body>

</html>