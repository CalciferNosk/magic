<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Careers | Motortrade Group</title>
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
  <!-- Favicons -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    .article,
    aside,
    figcaption,
    figure,
    /* footer, */
    /* header, */
    hgroup,
    main,
    nav,
    section {
      display: contents;
    }

    .has-search .form-control {
      padding-left: 2.375rem;
    }

    .has-search .form-control-feedback {
      position: absolute;
      z-index: 2;
      display: block;
      width: 8.375rem;
      height: 8.375rem;
      line-height: 1.375rem;
      text-align: center;
      pointer-events: none;
      color: #aaa;
    }

    #header {
      padding: 0px;
    }

    #header .logo img {
      max-height: none;
    }

    #job_vacancy_table_previous,
    #job_vacancy_table_first {
      margin-top: 10px;
    }

    .search {
      background-color: #1D3494;
    }

    .search:hover {
      background-color: #fee401;
      color: black;
    }

    .hover-table-tow:last-child {
      cursor: default !important;
    }

    .dataTables_wrapper .dataTables_info {
      clear: none;
      float: left;
      padding-top: 0.755em;
    }

    .row {
      padding: 10px;
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
      height: 100%;
      bottom: 0;
      opacity: .2;
      left: 0;
      background-color: #0087ca;
      transform-origin: bottom right;
      transition: transform 0.25s ease-out;
    }

    .hover-underline-animation:hover:after {
      transform: scaleX(1);
      transform-origin: bottom left;
    }

    .about .content ul li {
      padding-left: 3px !important;
      position: relative;
    }

    /* .dataTables_wrapper .dataTables_info {
      float: none;

    }
     */
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
    
  </style>
</head>

<body>
  <?php $this->load->view('forms-layout/header'); ?>
  
  <main id="main">
    <section id="about" class="about">
      <?php $this->load->view("job-application/layouts/carousel"); ?>
      <div class="container" data-aos="fade-up">
        <div class="section-title">
        </div>
        <div class="row content shadow-lg mt-2 mb-2" style=" padding-top: 20px;">
          <div class="col-lg-12 mb-3">
            <div class="row content" style="margin-left:0;width:100%;background:rgb(238, 238, 238);">
              <div class="form-group has-search col-lg-5">
                <span class="bi bi-search form-control-feedback" style="padding-top:.4em; padding-right:6em; color:blue;"></span>
                <input type="text" name="filter_position" style="height: calc(1.2em + 1rem + 2px);" id="filter_position" placeholder="Job Title" class="form-control" autocomplete="off" required>
              </div>
              <div class="form-group has-search col-lg-5">
                <span class="bi bi-geo-alt-fill" style="position: absolute; padding-left: 1rem; padding-top:6px; color:blue"></span>
                <input type="text" name="filter_location" style="height: calc(1.2em + 1em + 2px);" id="filter_location" placeholder="Location" class="form-control" autocomplete="off" required>
              </div>
              <div class="col-lg-2">
                <div class="form-group">
                  <center><button type="button" name="filter" id="filter" style="width:100%" class="btn btn-primary search">Search</button></center>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="table-responsive">
              <table id="job_vacancy_table" class="table dt-responsive display nowrap hover" style="width:100%">
                <thead>
                  <tr style="background-color:#f4f4f4;">
                    <th>Job Title</th>
                    <th>Location</th>
                    <th>Posted Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr style="background-color:#68BBE3;" class="">
                    <td colspan="6" style="text-align:center">No data available in table</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div>
            <label>
              <font color="black"> Cannot find a position for you? You may still send your resume through this
                <a style="color:blue" href="<?= base_url(); ?>jobapplication/apply" target="_blank"> link!</a>
              </font>
            </label>
          </div>
        </div>
      </div>
      <?= _getfooterlayout()?>
    </section>
  </main>
 
  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <script src="<?= base_url(); ?>test_assets/vendor/aos/aos.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="<?= base_url(); ?>test_assets/vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url(); ?>test_assets/js/main.js"></script>
  <script src="<?= base_url(); ?>assets/JobApp/jquery3-5-1.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/JobApp/datatables.min.js"></script>  
  <script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/build/jquery.datetimepicker.full.min.js"></script>
  <script src="assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?= base_url(); ?>assets/JobApp/kit-font-awesome.js"></script>
  <script src="<?= base_url(); ?>assets/js/main.js"></script>
  <script type="text/javascript">
    var branchesData = null;
    $(document).ready(function() {

      load_jobs_data(filter_position = '', filter_location = '')

      function load_jobs_data(filter_position, filter_location) {
        var tbljobs = $('#job_vacancy_table');
        if ($.fn.dataTable.isDataTable("#job_vacancy_table")) {
          tbljobs.DataTable().clear().destroy();
        }
        tbljobs.DataTable({
          responsive: true,
          "dom":
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'l><'col-sm-7'p>>" ,
          lengthMenu: [
            [10, 20, 50, -1],
            ['10', '20', '50', 'Show all']
          ],
          "ajax": {
            url: '<?= base_url(); ?>jobapplication/getJobsData',
            type: 'POST',
            timeout: 600000,
            data: {
              filter_position: filter_position,
              filter_location: filter_location,
              _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
            },
            dataType: "json",
            error: function(xhr, textStatus, thr) {
              if (textStatus === 'timeout') {
                return error('Loading Timeout for 10 minutes. \n please retry');
              }
            },
            complete: function(xhr, textStatus) {
              if (textStatus === 'success') {
                $('#job_vacancy_table').html(xhr.data)
              }
            }
          },
          "order": []
        });
      }

      $('#filter').click(function() {
        var value = $('#filter_position').val()
        value = value.replace(/\s+/g, ' ').trim()
        document.getElementById("filter_position").value = value;
        var value = $('#filter_location').val()
        value = value.replace(/\s+/g, ' ').trim()
        document.getElementById("filter_location").value = value;
        var filter_position = $('#filter_position').val();
        var filter_location = $('#filter_location').val();
        load_jobs_data(filter_position, filter_location)
      })
    });
  </script>
</body>
</html>