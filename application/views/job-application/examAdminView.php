<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Online Service Appointment Motortrade">
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <meta name="author" content="The company's slogan “Motorsiklo Sigurado, Alaga Ka Dito” sums up its number one priority — Total Customer Satisfaction is what we always guarantee!">
    <link rel="icon" href="assets/favicon.ico">
    <title> Admin View</title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/JobApp/css/mainview.css">
    <!-- Boxiocns CDN Link -->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/JobApp/css/mdbootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/JobApp/css/mdb_font.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/JobApp/css/mdb_ui_kit.min.css"> -->
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <style>
        .content-hide {
            display: none;
        }

        .active {
            display: block;
        }

        .progress {
            width: 100%;
            background-color: #f1f1f1;
        }

        .progress-bar {
            height: 20px;
            background-color: #4caf50;
            text-align: center;
            line-height: 20px;
            color: white;
        }

        .box-margin {
            margin: 5px;
        }

        .text-left {
            width: 20%;
            font-weight: 800;
        }

        .result-left {
            /* width: 50%; */
        }

        .result-right {
            text-align: right;
            width: 10%;

        }

        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            zoom: 90%;
        }

        .active-list {
            background-color: #1d1b31;
        }

        .button.shake {
            animation: shake 0.8s cubic-bezier(.36, .07, .19, .97) both;
        }

        @keyframes shake {

            10%,
            90% {
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                transform: translate3d(4px, 0, 0);
            }
        }

        .legend_pointer {
            cursor: pointer;
        }

        #chartdiv,
        #result_chart {
            width: 100%;
            height: 500px;
        }
    </style>
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-pencil'></i>
            <span class="logo_name">Online Exam</span>
        </div>
        <ul class="nav-links">
            <li class="menu-list  active-list">
                <a href="#">
                    <i class='bx bx-grid-alt icon-tab' data-showbar="dashboard"></i>
                    <span class="link_name" data-showbar="dashboard">Dashboard</span>
                </a>
                <ul class="sub-menu blank icon-tab" data-showbar="dashboard">
                    <li><a class="link_name" href="#" data-showbar="dashboard">Dashboard</a></li>
                </ul>
            </li>
            <li class="menu-list">
                <a href="#">
                    <i class='bx bx-user icon-tab' data-showbar="applicant_list"></i>
                    <span class="link_name" data-showbar="applicant_list">Applicant Lists </span>
                </a>
                <ul class="sub-menu blank icon-tab" data-showbar="applicant_list">
                    <li><a class="link_name" href="#" data-showbar="applicant_list">Applicant lists </a></li>
                </ul>
            </li>
            <li class="menu-list">
                <a href="#">
                    <i class="fa-solid fa-user-pen icon-tab" data-showbar="applicant"></i>
                    <span class="link_name" data-showbar="applicant">Applicants Exam Data</span>
                </a>
                <ul class="sub-menu blank icon-tab" data-showbar="applicant">
                    <li><a class="link_name" href="#" data-showbar="applicant">Applicants Exam Data</a></li>
                </ul>
            </li>
            <?php if ($_SESSION['jobapp_super_admin'] == 1): ?>
                <li class="menu-list">
                    <a href="#">
                        <i class="fa-solid fa-envelope icon-tab" data-showbar="otp_logs"></i>
                        <span class="link_name" data-showbar="applicant">OTP LOGS</span>
                    </a>
                    <ul class="sub-menu blank icon-tab" data-showbar="otp_logs">
                        <li><a class="link_name" href="#" data-showbar="otp_logs">OTP LOGS</a></li>
                    </ul>
                </li>
                <li class="menu-list">
                    <div class="iocn-link ">
                        <a href="#">
                            <i class='bx bx-cog icon-tab' data-showbar="maintenance"></i>
                            <span class="link_name" data-showbar="maintenance">Maintenance</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#" data-showbar="maintenance">Maintenance</a></li>
                        <li><a class="link_name" href="#" data-showbar="add_question" href="#">Add Question</a></li>
                        <li><a class="link_name" href="#" data-showbar="add_part" href="#">Add Part</a></li>
                        <li><a class="link_name" href="#" data-showbar="add_exam" href="#">Add Exam</a></li>

                    </ul>
                </li>
            <?php endif;  ?>
            <li class="menu-list">
                <div class="profile-details">
                    <div class="profile-content">
                        <!-- <img src="image/profile.jpg" alt="profileImg"> -->
                    </div>
                    <div class="name-job">
                        <div class="profile_name">Admin</div>
                        <div class="job">Maintenance</div>
                    </div>
                    <i class='bx bx-log-out '></i>
                </div>
            </li class="menu-list">
        </ul>
    </div>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Admin View</span>
        </div>
        <div class="main-content content-display justify-content-left container-fluid row" id="dashboard_section" style="margin-left: 50px;">
            <div class="card p-3 col-md-3 box-margin">
                <div class="content-hide active" id="dashboard">
                    <div>
                        <center>
                            <h6> <i class='bx bx-user'></i> Total Applicant Take</h6>
                        </center>
                    </div>
                    <div>
                        <center>
                            <h4><?= count($applicants) ?></h4>
                        </center>
                    </div>
                </div>
            </div>
            <div class="card p-3 col-md-3  box-margin">
                <div class="content-hide active" id="dashboard">
                    <div>
                        <center>
                            <h6> <i class='bx bx-user'></i> Total Applicant Part I Passed</h6>
                        </center>
                    </div>
                    <div>
                        <center>
                            <h4><?= !isset($total_pass_1) ? '<span style="color: #80808082;font-size: 13px">display not available</span>' : $total_pass_1 ?></h4>
                        </center>
                    </div>
                </div>
            </div>
            <div class="card p-3 col-md-3  box-margin">
                <div class="content-hide active" id="dashboard">
                    <div>
                        <center>
                            <h6 style="user-select: none;"> <i class='bx bx-user'></i> Total Applicant Part II Passed</h6>
                        </center>
                    </div>
                    <div>
                        <center>
                            <h4><?= !isset($total_pass_2) ? '<span style="color: #80808082;font-size: 13px">display not available</span>' : $total_pass_2  ?></h4>
                        </center>
                    </div>
                </div>
            </div>
            <div class="card p-3 col-md-3  box-margin">
                <div class="content-hide active" id="dashboard">
                    <div>
                        <center>
                            <h6> <i class='bx bx-user'></i> Total Applicant Part III Passed</h6>
                        </center>
                    </div>
                    <div>
                        <center>
                            <h4><?= !isset($total_pass_3) ? '<span style="color: #80808082;font-size: 13px">display not available</span>' : $total_pass_3 ?></h4>
                        </center>
                    </div>
                </div>
            </div>
            <div class="card p-3 col-md-3  box-margin">
                <div class="content-hide active" id="dashboard">
                    <div>
                        <center>
                            <h6> <i class='bx bx-user'></i> Total Applicant Failed</h6>
                        </center>
                    </div>
                    <div>
                        <center>
                            <h4>0</h4>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-display" id="applicant_section" style="display: none;">
            <div class="card p-3  box-margin">
                <div class="row">


                    <div class="col-md-6 row d-flex" style="display: block;">
                        <h6>Legend</h6>
                        <div class="col-md-6">
                            <div class="legend_pointer" id="legend_eye">
                                <i class='fa fa-eye' style="font-size: 20px;color:#14a44d"></i> = <span>View Applicant Result</span>
                            </div>
                            <div>
                                <i class='bx bx-repeat' style="font-size: 20px;color:#3b71ca"></i> = <span>Retake Applicant Exam</span>
                            </div>
                            <div>
                                <i class='bx bx-transfer' style="font-size: 20px;color:#3b71ca"></i> = <span>Transfer Result to EMS</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <i class='bx bx-export' style="font-size: 20px;color:#3b71ca"></i> = <span>Export Report</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <!-- <i>Report is not available </i> -->


                        <button class="btn btn-primary float-right" id="btn_export" title="Export Report"> <i class='bx bx-export' style="font-size: 20px;"></i></button>
                    </div>
                    <div class="col-md-2">
                        <h6>Date Range</h6>
                        <div class="input-group">
                            <label>From:</label>
                            <input type="date" class="form-control" id="report_date_from" name="date_from">
                        </div>
                        <div class="input-group">
                            <label>To:</label>
                            <input type="date" class="form-control" id="report_date_to" name="date_to">
                        </div>
                    </div>

                </div>
            </div>
            <div class="card p-3 row box-margin">
                <table class="table display table-responsive" style="width: 100%;">
                    <thead>
                        <tr>
                        <td class="text-center">System ID</td>
                            <td class="text-center" style="width: 20px;">Applicant ID</td>
                            <td class="text-center">Applicant Name</td>
                            <td class="text-center" style="width: 40px !important;">Applicant Email</td>
                            <td class="text-center">Contact Number</td>
                            <td class="text-center">Date Taken</td>
                            <td class="text-center">Pass/Fail</td>
                            <td class="text-center">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applicants as $key => $value) : ?>
                            <tr class="tr_<?=$value->CreatedDate?>">
                                <td class="text-center"><?= $value->id?></td>
                                <td class="text-center"><?= str_pad($value->ApplicantId, 6, "0", STR_PAD_LEFT) ?></td>
                                <td class="text-center" style="font-weight: 700;"><?= $value->Fname . ", " . $value->Lname . ' ' . substr($value->Mname, 0, 1) . '.' ?></td>
                                <td class="text-center"><?= $value->Email ?></td>
                                <td class="text-center"><?= $value->Contact ?></td>
                                <td class="text-center"><?= date("F d, Y", strtotime($value->CreatedDate)) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-success view-applicant-result btn-eye button btn-rounded" data-fullname="<?= $value->Fname . " " . $value->Lname . ', ' . $value->Mname . '.' ?>" data-position="<?= $value->PositionApplied ?>" data-date_created="<?= date("F d, Y", strtotime($value->CreatedDate))  ?>" data-app_id="<?= str_pad($value->ApplicantId, 6, "0", STR_PAD_LEFT) ?>">
                                        <i class='fa fa-eye' style="font-size: 16px;"></i>
                                    </button>
                                </td>
                                <td class="row text-center td_action_<?= $value->ApplicantId ?>">
                                    <?php if ($value->MovedToEMS == 1) : ?>
                                        <p style="color:green">Completed</p>
                                    <?php else : ?>


                                        <div class="col-md-6">
                                            <?php if ($value->ExamTake == 1) : ?>
                                                <button class="btn btn-primary retake-applicant button btn-repeat btn-rounded removed_<?= $value->ApplicantId ?>" title="applicant retake exam" data-app_id="<?= $value->ApplicantId ?>"><i class='bx bx-repeat' style="font-size: 16px;"></i></button>
                                            <?php endif ?>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary ems-applicant btn-rounded" title="Transfer data to EMS" data-app_id="<?= $value->ApplicantId ?>"><i class='bx bx-transfer' style="font-size: 16px;"></i></button>
                                        </div>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#showExamResult" hidden>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="showExamResult" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1" aria-labelledby="showExamResultLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="showExamResultLabel">SUMMARY OF RESULT</h5>
                                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="result_full_content">
                                <button class="btn btn-primary" style=" float:right" id="print_result">Print Result</button>
                                <table style="width: 100%;margin-left:26px">
                                    <tr>
                                        <td class="text-left">Applicant ID</td>
                                        <td class="text-right" id="result_app_id"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Date Taken</td>
                                        <td class="text-right" id="result_created"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Complete Name</td>
                                        <td class="text-right" id="result_name"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Position Applied</td>
                                        <td class="text-right" id="result_position"></td>
                                </table>
                                <br>
                                <br>
                                <div class="m-4">
                                    <h5>Summary Per Part</h5>
                                    <table style="width: 60%;">
                                        <tr>
                                            <td class="result-left"><b>PART 1</b>: GAWAIN I (PANGKALAHATAN)</td>
                                            <td class="result-right">&nbsp;&nbsp;<span id="part_1_result"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>&nbsp;&nbsp;</td>
                                            <td class="result-right">&nbsp;&nbsp;<span id="display_part_1"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>&nbsp;&nbsp;</td>

                                        </tr>
                                        <tr>
                                            <td class="result-left"><b>PART 2</b>: NUMERICAL REASONING</td>
                                            <td class="result-right">&nbsp;&nbsp;<span id="part_2_result"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>&nbsp;&nbsp;</td>
                                            <td class="result-right">&nbsp;&nbsp;<span id="display_part_2"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>&nbsp;&nbsp;</td>

                                        </tr>
                                        <tr>
                                            <td class="result-left"><b>PART 3</b>: DO (PAGHAHAMBING)</td>
                                            <td class="result-right" style="border-bottom: 1px solid black;">&nbsp;&nbsp;<span id="part_3_result"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>&nbsp;&nbsp;</u></td>
                                            <td class="result-right" style="border-bottom: 1px solid black;">&nbsp;&nbsp;<span id="display_part_3"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>&nbsp;&nbsp;</td>

                                        </tr>
                                        <tr>
                                            <td class="result-left"><b>Overall Total</b></td>

                                            <td class="result-right">
                                                &nbsp;&nbsp;<span id="overall_result"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>&nbsp;&nbsp;
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="overall_display" style="display: none;">
                                    <h4>
                                        <center>Overall Result</center>
                                    </h4>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <span id="result_chart">sample</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Close</button>
                                <!-- <button type="button" class="btn btn-primary" data-mdb-ripple-init>Understood</button> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
        <div class="content-display" id="maintenance_section" style="display: none;">
            <div class="card p-3  box-margin ">
                <div class="d-flex">
                    <a class="link_name btn btn-success m-2" href="#" data-showbar="add_question" href="#">Add Question</a>
                    <a class="link_name btn btn-success m-2" href="#" data-showbar="add_part" href="#">Add Part</a>
                    <a class="link_name btn btn-success m-2" href="#" data-showbar="add_exam" href="#">Add Exam</a>
                </div>

                <div class="row m-5">
                    <hr>
                    <h5>Control Panel</h5>
                    <form id="maintenance_form" method="post" enctype="multipart/form-data" action="" data-formstate="0" data-otptries="3" data-otpstate="0" data-otp-exp-min="5">
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="Maintenance" <?= $maintenance == 1 ? 'checked' : '' ?> />
                                <label class="form-check-label" for="Maintenance">Maintenance</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="jumble_part_1" <?= $jumble_part_1 == 1 ? 'checked' : '' ?> />
                                <label class="form-check-label" for="jumble_part_1">Jumble Part 1</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="jumble_part_2" <?= $jumble_part_2 == 1 ? 'checked' : '' ?> />
                                <label class="form-check-label" for="jumble_part_2">Jumble Part 2</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="jumble_part_3" <?= $jumble_part_3 == 1 ? 'checked' : '' ?> />
                                <label class="form-check-label" for="jumble_part_3">Jumble Part 3</label>
                            </div>
                        </div>
                        <div>
                            <button type="submit" style="float: right;" class="btn btn-primary m-2 pull-right">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="content-display" id="otp_logs_section" style="display: none;">
                               
            <div class="card p-3  box-margin">
            <center>Display not available</center>
                <div class="row ">
                    <div>
                        <button class="btn btn-primary" id="refesh_otp_logs">Refresh</button>
                    </div>
                </div>
                <div>
                    <table id="otp_logs_table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>OTP</th>
                                <th>Content</th>
                            </tr>
                        </thead>
                        <tbody id="body_otp"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="content-display" id="applicant_list_section" style="display: none;">
            <div class="card p-3  box-margin">
                <h5>Applicant List</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">Date Range</span>
                            <?php
                            // Get the current date
                            $today = date('Y-m-d');
                            // Subtract one month from the current date
                            $oneMonthAgo = date('Y-m-d', strtotime('-1 month', strtotime($today)));

                            ?>
                            <input type="date" aria-label="First name" id="date_from" class="form-control" value="<?= $oneMonthAgo ?>" placeholder="Date From" />
                            <input type="date" aria-label="Last name" id="date_to" class="form-control" value="<?= date('Y-m-d') ?>" placeholder="Date To" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary" id="search_applicant"> Search</button>
                    </div>
                </div>
                <br>
                <div id="applicant_list_table" style="overflow-x: hidden;overflow-y: scroll;max-height: 900px">
                    <center>Loading data <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></center>
                </div>

            </div>
        </div>

        <div class="content-display" id="add_question_section" style="display: none;">
            <div class="card p-3  box-margin">
                <center>2:This feature is not available</center>
            </div>
        </div>
        <div class="content-display" id="add_part_section" style="display: none;">
            <div class="card p-3  box-margin">
                <center>3:This feature is not available</center>
            </div>
        </div>
        <div class="content-display" id="add_exam_section" style="display: none;">
            <div class="card p-3  box-margin">
                <center>4:This feature is not available</center>
            </div>
        </div>

    </section>

    <script>
        var base_url = `<?= base_url() ?>`;
    </script>
    <script src="<?= base_url() ?>assets/JobApp/js/mdbbootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/JobApp/js/jquery_ajax.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="<?= base_url() ?>assets/JobApp/js/mainview.js?refresh=<?= date('YmdHis') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#print_result', function() {

                printDiv('result_full_content')
            });

            function printDiv(divId) {
                var div = document.getElementById(divId);
                var printWindow = window.open('', '', 'height=500,width=800');
                printWindow.document.write('<html><head><title></title></head><body>');
                printWindow.document.write(div.innerHTML);
                printWindow.document.write('</body></html>');
                printWindow.print();
                //   printWindow.close();
            }
            $(document).on('click', '#refesh_otp_logs', function() {
                console.log('here')
                var formData = new FormData();
                var url_otp = `<?= base_url() ?>get-otp-logs`;
                formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
                $.ajax({
                    type: "POST",
                    url: url_otp,
                    data: formData,
                    processData: false, // Prevent jQuery from automatically processing the data
                    contentType: false, // Set content type to false
                    dataType: "json",
                    success: function(result) {
                       var log = '';

                       $.each(result.logs, function(key, value) {
                           log += `<tr>
                                        <td>${value.MobileNumber == null ? '--' : value.MobileNumber}</td>
                                        <td>${value.EmailAddress}</td>
                                        <td>${value.CreatedDate}</td>
                                        <td>${value.OTP}</td>
                                        <td>${value.Content}</td>
                                   </tr>
                                  `;
                       })
                       $('#body_otp').html(log);
                     
                    },
                    error: function(xhr, status, error) {
                        console.error("Ajax request error:", error);
                    },
                });
            })

        })
    </script>

</body>

</html>