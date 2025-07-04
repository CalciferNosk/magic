
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="assets/favicon.ico">
    <title>LIST | CASE NTE</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Online Service Appointment Motortrade">
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <meta name="author" content="The company's slogan “Motorsiklo Sigurado, Alaga Ka Dito” sums up its number one priority — Total Customer Satisfaction is what we always guarantee!">
    <link rel="icon" href="assets/favicon.ico">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" /> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" /> -->
    <link href="<?= base_url() ?>assets/template_cdn/css/warehouse-mdb.kit.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/template_cdn/css/warehouse-select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/template_cdn/css/warehouse-toastify.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template_cdn/css/warehouse-datatables.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template_cdn/css/warehouse-datatables-responsive.min.css">
    <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-JsBarcode.all.min.js"></script>
    <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-toastify.min.js"></script>
    <style>
        #custom_modal {
            margin: 0 5px 0 0;
            float: inline-end;
            width: 50%;
            height: 99%;
        }
        .unseen_case {
            /* background-color: #dfe2ec !important; */
            font-weight: bold !important;
        }

        /* Create the blue navigation bar */
        .navbar {
            background-color: #3b5998;
            font-size: 22px;
            padding: 5px 10px;
        }

        /* Define what each icon button should look like */
        .button {
            color: black;
            display: inline-block;
            /* Inline elements with width and height. TL;DR they make the icon buttons stack from left-to-right instead of top-to-bottom */
            position: relative;
            /* All 'absolute'ly positioned elements are relative to this one */
            padding: 2px 5px;
            /* Add some padding so it looks nice */
        }

        /* Make the badge float in the top right corner of the button */
        .button__badge {
            /* background-color: blue; */
            border-radius: 2px;
            color: #114aa1;
            /* text-shadow: 0px 0px 1px  black; */
            padding: 1px 3px;
            font-size: 12px;

            position: absolute;
            /* Position the badge within the relatively positioned button */
            top: -4px;
            right: -12px;
        }

        @media screen and (max-width: 768px) {
            #custom_modal {
                width: 100% !important;

                /* background-color: #114aa1; */
            }

            #DataTables_Table_0 {
                width: 100% !important;
            }
        }

        @media screen and (min-width: 990px) {
            #DataTables_Table_0 {
                width: 100% !important;
            }
            #DataTables_Table_0_paginate{
                position: relative;
                right: 45%;
            }
        }

        .card-header {
            background-color: #95b8d1;
            border: 1px solid #AEC6CF;
            color: #114aa1;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f5f5f5;
            text-align: center;
            padding: 10px;
        }
        .btn-circle{
            border-radius: 14px;
        }
        .tr_row:hover{
            background-color: #e1e9e7b5 !important;
            cursor: pointer;
            color: #95b8d1 !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid" style="padding: unset">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #114aa1  !important;;width: 100%;">
            <a class="navbar-brand ml-2" style="margin-left: 25px;color:#fedd02;" href="#">CASE NTE</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <!-- <a class="nav-link" id="nte_list" href="#">NTE List</a> -->
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a style="color:white" data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                        <?= $_SESSION['casente_firstname'] ?>
                        &nbsp;
                        <!-- <i class="fa-solid fa-user-pen icon-tab" data-showbar="applicant"></i> -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                        <li>
                            <a class="dropdown-item" href="#">My profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Settings</a>
                        </li>
                        <li>
                            <a class="dropdown-item casente_logout" style="color:red" href="#">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="justify-content-center p-3">
            <div class="card box-shadow-lg" style="border: 1px solid #d9d9d9; border-radius: 5px;padding: unset">
                <div class="card-header">
                    <h5>NTE List</h5>
                </div>
                <br>
                <div class="card-body ">
                    <table id="" class="table responsive nowrap table-striped m-2">
                        <thead>
                            <th>CASE ID</th>
                            <th>CASE TYPE</th>
                            <th>REASON</th>
                            <th>DETAILS</th>
                            <th>FREQUENCY</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($list_data as $key => $case):  ?>
                                <tr class="tr_row">
                                    <td style="align-text: center;"> <?=   str_pad($case->caseID, 6, '0', STR_PAD_LEFT)?></td>
                                    <td style="font-weight: 700;">
                                        <div class="button">
                                            <?= $case->caseType ?>
                                            <span class="button__badge unseen_case rem_<?= $case->id ?>"><?= empty($case->isEmployeeSeen) ? 'NEW' : '' ?></span>
                                        </div>
                                    </td>
                                    <td><?= $case->reason ?></td>
                                    <td><?= $case->details ?></td>
                                    <td><?= $case->frequency ?></td>
                                    <td>
                                        <button class="btn  btn-circle btn-outline-primary view-nte" data-casetype="<?= $case->caseType ?>" data-id="<?= $case->id ?>" data-seen="<?= empty($case->isEmployeeSeen) ? 0 : 1  ?>">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="button" class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#ViewModal" hidden>
            </button>
            <!-- Modal -->
            <div class="modal fade" id="ViewModal" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1" aria-labelledby="ViewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" id="custom_modal">
                    <div class="modal-content" style="height: 100%;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ViewModalLabel">...</h5>
                            <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                <table style="width: 100%;color:#395B77 !important;font-size: 16px !important;font-weight: 500">
                                    <tr>
                                        <td><b>Name of Concerned Employee</b></td>
                                        <td>: <?= $_SESSION['casente_fullname'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Company</b></td>
                                        <td>: <?= $_SESSION["fetch_result"]['company'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Branch Assignment</td>
                                        <td>: <?= $_SESSION["fetch_result"]['orgGroupConcatenated'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Position</td>
                                        <td>: <?= $_SESSION["fetch_result"]['positionConcatenated'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Subject to Preventive Suspension &nbsp; <input type="checkbox"></td>
                                        <td></td>
                                    </tr>
                                </table>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label style="color:#395B77 !important;font-size: 16px;font-weight: 500" for="">Alleged Violations: (please indicate Article's in the Code of Discipline)</label>
                                    <textarea name="" style="width: 100%; min-height: 300px;background-color: #e6e7e8;border-radius: 5px"  id="" disabled>This is Sample</textarea>
                                </div>
                                <div class="col-md-12 mt-4">
                                <table style="width: 100%;color:#395B77 !important;font-size: 16px;font-weight: 500">
                                    <tr>
                                        <td>FREQUENCY</td>
                                        <td>: <input id="view_frequency" value="1" disabled/></td>
                                    </tr>
                                    <tr>
                                        <td>Cut-off(MM/DD/YYYY)</td>
                                        <td>: <span id="view_cutoff">May 29, 2024 to june 27, 2024</span></td>
                                    </tr>
                                    <tr>
                                        <td>Minutes of Late</td>
                                        <td>:  <span id="view_branch">120 </span> min</td>
                                    </tr>
                                   
                                </table>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-mdb-ripple-init>Understood</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; <?= date('Y') ?> MOTORTRADE</p>
    </footer>
    <script src="./assets/JobApp/js/jquery_ajax.min.js"></script>
    <script src="./assets/JobApp/js/mdbbootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var base_url = '<?= base_url() ?>';
        $(document).ready(function() {
            // $('table').DataTable({
            //     // "dom": 'Brftip',
            //     // responsive: true,
            //     // rowReorder: {
            //     //     // selector: 'td:nth-child(2)'
            //     // },
            //     // "buttons": [{
            //     //     "text": 'Custom Button',
            //     //     "className": 'btn btn-primary',
            //     //     "action": function() {
            //     //         alert('Custom button clicked!');
            //     //     }
            //     // }]
            // });

            $(document).on('click', '.view-nte','', function() {
                var case_type = $(this).data('casetype');
                var id = $(this).data('id');
                var is_seen = $(this).data('seen');
                $('#ViewModalLabel').text(case_type)
                $('#ViewModal').modal('show');

                if (is_seen == 0) {
                    var formData = new FormData();
                    formData.append('case_id', id);
                    formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
                    $.ajax({
                        type: 'post',
                        url: base_url + 'case-seen',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.http == 200) {
                                $('.rem_' + id).text('')
                            }
                        }
                    })
                }
            })
        })
    </script>
</body>

</html>