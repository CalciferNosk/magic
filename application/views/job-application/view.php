<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Careers | Motortrade Group</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
  <!-- Favicons -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url(); ?>assets/images/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url(); ?>assets/images/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url(); ?>assets/images/favicon.ico">
  <link rel="apple-touch-icon-precomposed" href="<?= base_url(); ?>assets/images/favicon.ico">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url(); ?>test_assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url(); ?>test_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>test_assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url(); ?>test_assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>test_assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>test_assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url(); ?>test_assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/JobApp/font-awesome.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url(); ?>test_assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/JobApp/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/JobApp/datatables.min.css" />

  <style>
    #header {
      padding: 0px;
    }

    #header .logo img {
      max-height: none;
    }

    .apply {
      background-color: #1D3494;
    }

    #job_vacancy_table_previous,
    #job_vacancy_table_first {
      margin-top: 10px;
    }

    .forBullet ul {
      list-style: disc !important;
      list-style-position: inside !important;
    }

    .apply:hover {
      background-color: #fae712;
      color: black;
    }

    .hover-underline-animation {
      display: inline-block;
      position: relative;

    }

    .hover-underline-animation:after {
      content: '';
      position: absolute;
      width: 100%;
      transform: scaleX(0);
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: #0087ca;
      transform-origin: bottom right;
      transition: transform 0.25s ease-out;
    }

    .hover-underline-animation:hover:after {
      transform: scaleX(1);
      transform-origin: bottom left;
    }
    @media screen and (min-width: 992px) {
    .responsive {
      width: 15%;
    }
  }
  .nav{
      color:#203aa6 !important;

     }
     .dropdown-item{
      color: #203aa6 !important;
      line-height: 9px !important;
     }
     .section-dropdown:after {
      right: 25px !important;
     }
     .contact-info{
      display: inline;
     }
     .info-link{
      margin: -8px !important;
     }
     p{
      color:black !important;
     }
    
  </style>
</head>

<body>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YJ80PHZR7F"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YJ80PHZR7F');
</script>

  <?php #$this->load->view('job-application/layouts/header'); ?>
  <?php $this->load->view('forms-layout/header'); ?>
  <main id="main">
    <section id="about" class="about" style="background: #f6f8fa">
      <div class="container" data-aos="fade-up" style="padding-top: 2rem;">
        <div class="section-title">
        </div>
        <div class="card mb-3 shadow-lg">
          <div class="card-body">
            <div class="row content" style="padding: 6%;">
              <div class="col-lg-6  container-fluid">
                <span class="" style="font-family: 'PT Sans', Calibri, Tahoma, sans-serif;"><b style="font-size:200%"><?= $values->Position ?></b></span><br>
                <span class="bi bi-building" style='font-size:18px;color:gray;'> &nbsp;<?= $values->Location ?></span><br>
                <span class="bi bi-person-plus-fill" style='font-size:18px;color:gray;'>&nbsp;No. of Applicants: <?= $values->ApplicantCount ?></span>
              </div>
              <div class="col-lg-4">
              </div>
              <div class="col-lg-2" style=" padding-top: 35px;">
                <?php if ($values->ClosedDate == NULL) : ?>
                  <form action="<?= base_url(); ?>jobapplication/apply" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="mrfId" value="<?= $values->MrfId; ?>">
                    <input type="hidden" name="position" value="<?= $values->Position; ?>">
                    <input type="hidden" id="position_id" name="position_id" value="<?= base64_encode($values->positionID)?>">
                    <button class="btn btn-primary apply" id="ja_apply_btn">Apply Now</button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="card shadow-lg">
          <div class="card-body">
            <div class="row content" style="padding: 5%;">
              <div class="col-md mb-2">
                <p class="" style="font-family: 'PT Sans', Calibri, Tahoma, sans-serif;"><b style="font-size:180%">Job Description</b> </p>
                <?= "<span class='forBullet' style='font-size:14px;font-family: 'PT Sans', Calibri, Tahoma, sans-serif;'>" . $values->JobDescription . "</span>"; ?><br />
                <p class=" " style=" font-family: 'PT Sans', Calibri, Tahoma, sans-serif;"><b style="font-size:180%">Job Qualification</b></p>
                <?= "<span class='forBullet '>" . $values->JobQualification . "</span>"; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row content">
          <div class="col-lg-12">
            <div class="">
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?= _getfooterlayout()?>
  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->

  <script src="<?= base_url(); ?>test_assets/vendor/aos/aos.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url(); ?>test_assets/js/main.js"></script>
  <script src="<?= base_url(); ?>assets/JobApp/jquery3-5-1.js"></script>
</body>

</html>