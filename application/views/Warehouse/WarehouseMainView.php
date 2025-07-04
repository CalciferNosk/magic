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
    <title>LIST | WAREHOUSE</title>

    <link href="<?= base_url() ?>assets/template_cdn/css/warehouse-mdb.kit.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/template_cdn/css/warehouse-fontawesone-all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/template_cdn/css/warehouse-select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/template_cdn/css/warehouse-toastify.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template_cdn/css/warehouse-datatables.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template_cdn/css/warehouse-datatables-responsive.min.css">
    <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-JsBarcode.all.min.js"></script>
    <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-toastify.min.js"></script>

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" /> -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            /* zoom: 85%; */
        }

        #upload_engine {
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #upload_engine input[type="file"] {
            width: 100%;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        #upload_engine button[type="submit"] {
            width: 100%;
            height: 40px;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #upload_engine button[type="submit"]:hover {
            background-color: #3e8e41;
        }

        .nav-link {
            color: white !important;
        }

        canvas {
            border: 1px solid #ccc;
            padding: 20px;
            width: 230px;
            /* add spacing between barcodes */
        }

        #barcodes,
        #barcodes_print {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            height: auto;
        }

        @media print {
            #barcodes {
                width: 70%;
                height: 200px;
                margin: 0;
                padding: 0;
            }

            @page {
                size: landscape;
                margin-top: 0.5in;
                /* top margin */
                margin-bottom: 0.5in;
                /* bottom margin */
                margin-left: 0.5in;
                /* left margin */
                margin-right: 0.5in;
                /* right margin */
            }

            .barcode {
                width: 70%;
                height: 200px;
                margin: 0;
                padding: 0;
            }
        }

        .select2 {
            width: 100% !important;
        }

        .checker_label {
            font-weight: 700;
        }

        .checker_data {
            font-weight: 300 !important;
        }

        .new_scanned {
            background-color: gray;
        }

        .data_row:hover {
            background-color: #ccc;

        }

        .fa-gear {
            position: relative;
            width: 20px;
            height: 20px;
            background-color: #333;
            border-radius: 50%;
            display: inline-block;
            margin-left: 10px;
        }

        li {
            border-left: 1px solid gray;
        }

        li:hover {
            background-color: #5072a7;
        }

        #alocate_engine:focus {
            border-color: greenyellow;
            background-color: green;
            /* change the border color to blue */
        }

        button {
            background-color: #114aa1 !important;
        }

        canvas {
            height: 125px;
        }

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

        .nav-link {
            font-size: 12px;
            font-weight: 700;
        }

        #scan_input:focus::placeholder,
        #scan_input {
            outline: none;
            border: none;
            box-shadow: none;
            color: #4CAF50 !important;
        }

        #scan_input[placeholder] {
            color: #4CAF50 !important;
        }

        input::-webkit-input-placeholder {
            color: #ccc !important;
            /* or any other color you prefer */
        }

        /* input:-moz-placeholder {
            color: #4CAF50 !important;
        }

        input::-moz-placeholder {
            color: #4CAF50 !important;
        }

        input:-ms-input-placeholder {
            color: #4CAF50 !important;
        } */
        .hover_tr:hover {
            background-color: #f0f0f0;
        }

        .status_filter {
            color: #333;
            font-weight: bolder;
        }

        .status_filter:hover {
            color: #114aa1
        }

        .status_active {
            color: #114aa1
        }
    </style>
    <style>
        /* .container {
            margin: unset;
            /* width: 600px; */
        /* margin: 0 auto; */
        /* border-collapse: collapse; */
        }

        */ .order_print_table {
            width: 85%;
            /* border-collapse: collapse; */
            border: 1px solid black;
            /* table-layout: fixed; */
        }


        .print_data {
            margin: unset;
            line-height: 21px;

        }

        .print_data-left {
            text-align: center;
            margin-right: 10px;
            /* border-bottom: .5px double black; */

        }

        .print_data-right {
            padding-left: 25px;
            /* border-bottom: .5px double black; */
        }
    </style>
</head>

<body style="orientation: landscape;">
    <div class="containe-fluid print-hide">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #114aa1  !important;;width: 100%;">
            <a class="navbar-brand ml-2" style="margin-left: 25px;color:#fedd02;" href="#">Warehouse</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <?php if ($control_user == 1): ?>
                        <li class="nav-item" id="itadmin">
                            <a class="nav-link nav-content" data-content="admin-list" href="#">USER CONTROL</i></a>
                        </li>
                    <?php else: ?>
                    <?php if(in_array("1",$tab_access)): ?>
                    <li class="nav-item active">
                        <a class="nav-link nav-content" id="upload_view" data-content="upload-file" href="#">UPLOAD</a>
                    </li>
                    <?php endif;
                    if(in_array("2",$tab_access)):
                    ?>
                    <li class="nav-item">
                        <a class="nav-link nav-content" id="list_view" data-content="inventory-list" href="#">INVENTORY</a>
                    </li>
                    <?php endif;
                    if(in_array("3",$tab_access)):
                    ?>
                    <li class="nav-item">
                        <a class="nav-link nav-content" href="#" data-content="barcode-checker" id="checker_view">
                            BARCODE CHECKER
                        </a>
                    </li>
                    <?php endif;
                    if(in_array("4",$tab_access)):
                    ?>
                    <li class="nav-item" id="pick_release">
                        <a class="nav-link nav-content" data-content="pick-release-form" href="#">PICK RELEASE FORM</i></a>
                    </li>
                    <?php endif;
                    if(in_array("5",$tab_access)):
                    ?>
                    <li class="nav-item" id="release_list">
                        <a class="nav-link nav-content" data-content="release-list" href="#">RELEASE LIST</i></a>
                    </li>
                    <?php 
                    endif; #end tab access
                    
                    endif ?>
                </ul>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a style="color:white" data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                        <?= !empty($_SESSION['warehouse_firstname']) ? $_SESSION['warehouse_firstname'] : $_SESSION['warehouse_logusername'] ?>
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
                            <a class="dropdown-item warehouse_logout" style="color:red" href="#">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
    <?php if ($control_user == 1):  ?>
        <div class="content-all admin-list" >
            <div class=" d-flex justify-content-center">
                <div class="container  m-3">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5>USER CONTROL</h5>
                        </div>
                        <div class="card-body">

                            <table class="table align-middle mb-0 bg-white" id="user_list_table">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th>Supplying Plant Access</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="user_list_body">
                                   
                                </tbody>
                            </table>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#userActionModal" hidden>
                                
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="userActionModal" tabindex="-1" aria-labelledby="userActionModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="userActionModalLabel"></h5>
                                            <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <!-- Tabs navs -->
                                            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a data-mdb-tab-init class="nav-link active" style="color:#114aa1 !important;" id="ex1-tab-1" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">Data Control</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a data-mdb-tab-init class="nav-link" style="color:#114aa1 !important;" id="ex1-tab-2" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Supplying Plant Access</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a data-mdb-tab-init class="nav-link" style="color:#114aa1 !important;" id="ex1-tab-3" href="#ex1-tabs-3" role="tab" aria-controls="ex1-tabs-3" aria-selected="false">Tab Access</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="ex1-content">
                                                <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                              
                                                    <div id="user_control_content">
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                                                    <div id="supplying_plant_content" class="m-3">
                                                    </div>
                                                    <button class="btn btn-primary" id="supplying_plant_save" style="float: right;">Save Changes</button>
                                                </div>
                                                <div class="tab-pane fade" id="ex1-tabs-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                                                    <div id="tab_access_content" class="m-3">

                                                    </div>
                                                    <button class="btn btn-primary" id="tab_access_save" style="float: right;">Save Changes</button>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" data-mdb-ripple-init>Save changes</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="content-all pick-release-form">
                <center>Warehouse Inventory System</center>

        </div>

    <div id="container_content">
        <div id="upload_content" class="content-all upload-file">
            <?php if ($upload == 1): ?>
                <div class="container-fluid m-2">
                    <div class="row">
                        <div class="card" style="padding: 0px">
                            <div id="upload_div">
                                <form action="#" id="upload_engine" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="file_filter">Supplier</label>
                                        <select class="mdb-select" name="file_name" id="file_name">
                                            <option value="" disabled selected>--Select Supplier --</option>
                                            <?php foreach ($suppliers as $supplier): ?>
                                                <option value="<?= $supplier->brand_name ?>"><?= $supplier->brand_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="file_filter">Warehouse</label>
                                        <select class="mdb-select" name="warehouse_name" id="warehouse_name">
                                            <option value="" disabled selected>--Select Warehouse --</option>
                                            <option value="1001">1001 - MNC WAREHOUSE</option>
                                            <option value="1002">1002 - MNC WAREHOUSE 2</option>
                                            <!-- <option value="1203" disabled>MNC Warehouse (Taguig)</option>
                                        <option value="1304" disabled>MNC WAREHOUSE TARLAC</option>
                                        <option value="1606" disabled>MNC WAREHOUSE DAET</option>
                                        <option value="1703" disabled>MNC WAREHOUSE LUCENA</option> -->
                                        </select>
                                    </div>
                                    <br>
                                    <input class="form-control" type="file" name="excel_file" id="file_upload" accept=".csv">

                                    <button type="submit" id="validate_file">Validate File</button>
                                    <center><a href="<?= base_url() ?>assets/Template/warehouse_brcode_template.csv" target="_blank" download="warehouse_brcode_template.csv">Download Template</a></center>

                                </form>
                            </div>
                            <div style="padding:5px;">
                                <center><button class="btn btn-primary" id="upload_new" style="display: none;">Upload New File</button></center>
                            </div>
                            <center><button class="btn btn-primary" id="upload_file" style="display: none;">Insert File Data</button></center>
                            <br>
                            <center>
                                <h2 id="validation_result"></h2>
                            </center>
                        </div>
                    </div>
                    <br>
                    <div class="row card p-3">
                        <div id="table_upload">
                            <table class="table display mt-3" id="validate_table">
                                <thead>
                                    <tr>
                                        <th>DR number</th>
                                        <th>MODEL CODE / material number</th>
                                        <th>Engine number</th>
                                        <th>Serial Number</th>
                                        <th>Chasis Number</th>
                                        <th>WWC/BAT</th>
                                        <th>Row Number</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <br>

                <center>Sorry, you don't have permission to upload</center>
            <?php endif;  ?>
        </div>
        <div id="list_content" style="display: none;" class="content-all inventory-list">
            <div class="card m-3 p-3">

                <div class="card-header">
                    <h5>INVENTORY</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="file_filter">Supplier</label>
                                <select class="mdb-select" id="file_filter">
                                    <?php if (!empty($files)) : ?>
                                        <option value="0">ALL</option>
                                        <?php foreach ($files as $file) : ?>
                                            <option value="<?= $file->id ?>"><?= $file->DisplayName ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_by_filter">Upload By</label>
                                <select class="mdb-select" id="created_by_filter">
                                    <?php if (!empty($files)) : ?>
                                        <option value="0">ALL</option>
                                        <?php
                                        $createdBy = array();
                                        foreach ($files as $file) :
                                            if (!in_array($file->CreatedBy, $createdBy)) {
                                                $createdBy[] = $file->CreatedBy;
                                        ?>
                                                <option value="<?= $file->CreatedBy ?>"><?= $file->CreatedBy . ' - ' . $file->CreatedFullname ?></option>
                                            <?php } ?>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="file_filter">DR Number</label>
                                <input type="text" class="form-control" name="dr_number_filter" id="dr_number_filter">
                                <span><i>Separate multiple DR numbers with a comma, for example: (1001, 1002).</i></span>
                            </div>
                        </div>
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <label for="file_filter">Supplier</label>
                                <select class="mdb-select" name="" id="">
                                    <option value="">ALL</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-md-2">
                            <label for="search">&nbsp;</label>
                            <div class="d-flex justify-content-center">
                                <?php if (!empty($files) ||  count($files) > 0) : ?>
                                    <button class="btn btn-primary" id="search_data" style="width: 40%;"><i class="fas fa-search"></i>&nbsp; Search</button>
                                <?php else : ?>
                                    no data
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-2" id="generate_barcode_div" style="display: none;">
                            <label for="search">&nbsp;</label>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary" id="generate_barcode_btn" style="width: 60%;"><i class="fas fa-barcode"></i> &nbsp;Generated BarCode</button>
                                <button class="btn btn-primary" id="generate_table_list_btn" style="width: 40%;display: none;"> <i class="fas fa-table"></i>&nbsp; Table List</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row m-3" id="filtered_data_content">
                <div class="card p-3">
                    <center><span id="search_event" style="font-weight: 800;"></span></center>
                    <table class=" mt-3" id="list_table">
                        <thead>
                            <tr>
                                <th>DR number</th>
                                <th>MODEL CODE / material number</th>
                                <th>Engine number</th>
                                <th>Serial Number</th>
                                <th>Chasis Number</th>
                                <th>WWC/BAT</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_view">

                        </tbody>

                    </table>
                </div>
            </div>

            <div class="row m-3 p-3" style="display: none;" id="generate_barcode_content">
                <div class="card p-3">
                    <div>
                        <button id="print-button" class="btn btn-primary" style="float: right;">Print</button>
                    </div>

                    <br>
                    <div class=" container d-flex justify-content-right" id="barcodes"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="checker_content" style="display: none;" class="content-all barcode-checker">
        <div class="card m-3">
            <div class="container d-flex justify-content-center p-5">
                <input class="form-control" type="text" id="checker_input" placeholder="Enter/scan Barcode">
            </div>
            <div class="container justify-content-right">
                <p class="checker_label">Engine Number: <span class="checker_data" id="engine_numer_scanned"></span> </p>
                <p class="checker_label">Chasis Number: <span class="checker_data" id="chasis_number_scanned"></span> </p>
                <p class="checker_label">Serial Number: <span class="checker_data" id="serial_number_scanned"></span> </p>
                <p class="checker_label">WWC/BAT: <span class="checker_data" id="wwc_bat_scanned"></span> </p>
                <p class="checker_label">Material Number: <span class="checker_data" id="material_number_scanned"></span> </p>
                <p class="checker_label">DR Number: <span class="checker_data" id="dr_number_scanned"></span> </p>
            </div>
            <hr>
            <br>
            <div class="m-4">
                <table class="table display mt-3" id="checker_table">
                    <thead>
                        <tr>
                            <th>DR number</th>
                            <th>MODEL CODE / material number</th>
                            <th>Engine number</th>
                            <th>Serial Number</th>
                            <th>Chasis Number</th>
                            <th>WWC/BAT</th>
                        </tr>
                    </thead>
                    <tbody id="table_body_checker">

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- release form -->
    <div id="pick_release_content" style="display: none;" class="content-all pick-release-form">

        <?php if ($create == 1): ?>
            <div class="card m-5" id="pick_filter_div">
                <div class="card-header p-2" style="border: 1px solid #d9d9d9; border-radius: 5px;padding: unset">
                    <h5>PICK RELEASE FORM</h5>
                </div>
                <div class="card-body p-5">
                    <div class="row">

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <label for="supplier-select">Trucking :</label>
                            <div class="form-group">
                                <input class="form-control" type="text" name="Trucking" id="Trucking" placeholder="Enter trunking name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="supplier-select">Driver:</label>
                            <div class="form-group">
                                <input class="form-control" type="text" name="Driver" id="Driver" placeholder="Enter driver name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplying">Supplying Plant:</label>
                                <select class=" form-control mdb-select" id="supplying">
                                    <option value="0" selected disabled>SELECT SUPPLYING PLANT</option>
                                    <option value="1001">1001</option>
                                    <option value="1002">1002</option>
                                    <option value="3001">3001</option>
                                    <option value="3002">3002</option>
                                    <option value="6001">6001</option>
                                    <option value="6002">6002</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="supplier-select">Branch Code:</label>
                            <div class="form-group">
                                <input class="form-control" type="text" name="BranchCode" id="BranchCode" placeholder="Enter Branch Code">
                                <span id="branch_code_check_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="model-code-select">Material Code:</label>
                                <select class=" form-control mdb-select" id="model-code-select">
                                    <option value="0" selected disabled>SELECT MATERIAL CODE</option>
                                    <?php foreach ($material_codes as $material_code) : ?>
                                        <option value="<?= $material_code->material_number ?>" data-count="<?= _getMaterialCount($material_code->material_number) ?>" <?= _getMaterialCount($material_code->material_number) == 0 ? '  disabled' : '' ?>><?= $material_code->material_number . ' |  ' . _getMaterialCount($material_code->material_number) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="available_qty"></span>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="supplier-select">Quantity:</label>
                            <div class="input-group">
                                <input type="number" class="form-control input-number" id="quantity" value="1">
                                <div class="input-group-append">
                                    <button class="btn btn-primary mdb-btn" type="button" id="decrement">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button class="btn btn-primary mdb-btn" type="button" id="increment">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="col-md-2">
                        <div class="form-group">
                            <label for="supplier-select">Supplier:</label>
                            <select class="mdb-select form-control" id="supplier-select">
                                <option value="0">SELECT SUPPLIER</option>
                                <?php foreach ($suppliers as $supplier) : ?>
                                    <option value="<?= $supplier->brand_name ?>"><?= $supplier->brand_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="model-select">Model:</label>
                            <select class="mdb-select" id="model-select">
                                <option value="0">SELECT MODEL</option>
                                <?php foreach ($models as $model) : ?>
                                    <option value="<?= $model->main_model ?>"><?= $model->main_model . ' - ' . $model->model_code . '' ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> -->

                        <div class="col-md-4">
                            <br>
                            <div class="form-group">
                                <button class="btn btn-primary" id="add_to_pick">ADD TO PICK</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <center>
                        <span id="inventory-count-msg" style="color: red;"></span>
                    </center>
                </div>
            </div>

            <div class="card m-5 p-5" id="pick_recipt">
                <form action="#" id="pick_release_form" method="post" enctype="multipart/form-data">
                    <div class=" container justify-content-center">
                        <center>
                            <h5>PREPARING ORDER</h5>
                        </center>

                        <table class="table display mt-3">
                            <thead>
                                <tr>
                                    <th>Quantity</th>
                                    <th>Branch</th>
                                    <!-- <th>Supplier</th> -->
                                    <!-- <th>Model</th> -->
                                    <th>Material Code</th>
                                    <th>Inventory Count</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="pick_table_body">

                            </tbody>
                        </table>
                    </div>
                    <div class="m-5 p-5 d-flex justify-content-center">
                        <button class="btn btn-primary" id="insert_pick" type="submit">SAVE PICK ORDER</button>
                    </div>
                </form>

            </div>
        <?php else : ?>
            <br>
            <center>Sorry, you don't have permission to access this page</center>
        <?php endif; ?>
    </div>
    <div class="content-all release-list print-hide" style="display: none;">
        <?php if ($list_view == 1):  ?>
            <div class="card m-5 p-3">
                <center>
                    <h5>RELEASE LIST</h5>
                </center>
                <div style="background-color: #d9d9d95c;padding:5px;margin: 5px;">
                    <a href="#" class="status_filter status_active" data-val="">ALL</a> &nbsp;| &nbsp;
                    <a href="#" class="status_filter" data-val="PREPARING">PREPARING</a> &nbsp;| &nbsp;
                    <a href="#" class="status_filter" data-val="ENDORSE TO PROCESSOR">ENDORSE TO PROCESSOR</a>&nbsp;| &nbsp;
                    <a href="#" class="status_filter" data-val="FOR DELIVERY">FOR DELIVERY</a> &nbsp;| &nbsp;
                    <a href="#" class="status_filter" data-val="DELIVERED">DELIVERED</a>
                </div>
                <table class="" id="release_list_table" style="width: 100%;">
                    <thead>
                        <tr>
                            <!-- <td><input type="checkbox" id="check_all" name="check_all"></td> -->
                            <th>ORDER ID</th>
                            <th>ORDER DATE</th>
                            <th>BRANCH</th>
                            <th>Total Qty</th>
                            <th>TRUCKING</th>
                            <th>DRIVER</th>
                            <th>STATUS</th>
                            <th style="text-align: center;">Order View | Edit Order | Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($release_list as $key => $value): ?>
                            <tr class="hover_tr" data-checkid="<?= $value->OrderId ?>">
                                <!-- <td><input type="checkbox" id="id_<?= $value->id ?>" class="check c_<?= $value->id ?>" name="check" data-id="<?= $value->id ?>"></td> -->
                                <td style="width: 10%;"><?= str_pad($value->id, 6, '0', STR_PAD_LEFT) ?></td>
                                <td style="width: 15%;"><?= date('F j, Y', strtotime($value->CreatedDate));  ?></td>
                                <td style="width: 15%;"> <b><?= _getBranchNamebyCode($value->BranchCode) ?></b></td>
                                <td style="width: 10%;"><center> <?= _getWarehouseTotalOrder($value->OrderId) ?></center></td>
                                <td style="width: 10%;"> <?= $value->Trucking ?></td>
                                <td style="width: 10%;"> <?= $value->DriverName ?></td>
                                <td style="width: 15%;"> <span class="status_colored" style="font-size: 11px;padding: 7px;font-weight: bold;border-radius: 14px;<?= _getStatusColor($value->CurrentStatusId) ?>"><?= empty($value->status) ? '--' : $value->status ?></span></td>
                                <td style="width: 25%;">
                                    <center>
                                        <button class="btn btn-primary add_engine" data-branch="<?= $value->BranchCode ?>" data-statusid="<?= $value->CurrentStatusId ?>" data-genid="<?= $value->OrderId ?>" id="add_engine"><?= $value->CurrentStatusId == 2208 ? '&nbsp;<i class="fa-solid fa-plus" data-mdb-tooltip-init title="Add Engine" ></i>&nbsp;' : '<i class="fa-solid fa-eye" data-mdb-tooltip-init title="View Engine" ></i>' ?></button>
                                        <?php if (in_array($value->CurrentStatusId, [2208, 2209]) && $edit == 1):  ?>
                                            <button data-mdb-tooltip-init title="Edit Order" class="btn btn-danger" id="edit_order" data-id="<?= $value->id ?>" data-supplying="<?= $value->SupplyingPlant ?>" data-branch="<?= $value->BranchCode ?>" data-statusid="<?= $value->CurrentStatusId ?>" data-genid="<?= $value->OrderId ?>" id="add_engine"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <?php elseif ($edit == 0): ?>
                                            <button data-mdb-tooltip-init title="No access for editing" style="cursor: not-allowed;background-color: #a9a8a8b3 !important;" class="btn btn-danger" id="edit_not_allowed" data-genid="<?= $value->OrderId ?>" ><i class="fa-solid fa-pen-to-square"></i></button>
                                            <?php else: ?>
                                            <button data-mdb-tooltip-init title="Can't edit with the status" style="cursor: not-allowed;" class="btn btn-danger" id="edit_order_disabled" data-genid="<?= $value->OrderId ?>" disabled><i class="fa-solid fa-pen-to-square"></i></button>
                                        <?php endif; ?>
                                        <button data-mdb-tooltip-init title="Print Order" class="btn btn-primary" id="print_order" data-genid="<?= $value->OrderId ?>"><i class="fa-solid fa-print"></i></button>
                                    </center>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#addEngineModal" hidden>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addEngineModal" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1" aria-labelledby="addEngineModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addEngineModalLabel">Scan Engine</h5>
                                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <!-- Tabs navs -->
                                <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a data-mdb-tab-init style="color:#114aa1 !important;"
                                            class="nav-link active"
                                            id="ex1-tab-1"
                                            href="#ex1-tabs-1"
                                            role="tab"
                                            aria-controls="ex1-tabs-1"
                                            aria-selected="true">ORDER LIST</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a
                                            data-mdb-tab-init style="color:#114aa1 !important;"
                                            class="nav-link"
                                            id="ex1-tab-2"
                                            href="#ex1-tabs-2"
                                            role="tab"
                                            aria-controls="ex1-tabs-2"
                                            aria-selected="false">LOGS</a>
                                    </li>

                                </ul>
                                <!-- Tabs navs -->

                                <!-- Tabs content -->
                                <div class="tab-content" id="ex1-content">
                                    <div
                                        class="tab-pane fade show active"
                                        id="ex1-tabs-1"
                                        role="tabpanel"
                                        aria-labelledby="ex1-tab-1">
                                        <div class="scan-area">
                                            <button class="btn btn-primary">Scan Barcode</button>
                                            <input type="text" id="scan_input" placeholder="Scanner not yet Ready">
                                        </div>
                                        <div id="scan_engine">
                                            <table class="" style="width: 100%;">
                                                <thead>
                                                    <th style="text-align: center;">Supplying</th>
                                                    <th style="text-align: center;">Company Code</th>
                                                    <th style="text-align: center;">Branch Code</th>
                                                    <th style="text-align: center;">Material Code</th>
                                                    <th style="text-align: center;">Qty</th>
                                                    <th style="text-align: center;">Engine Number</th>
                                                    <th style="text-align: center;">Action</th>
                                                </thead>
                                                <tbody id="scan_engine_list">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                                        <Table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Material Number</th>
                                                    <th>Updated By</th>
                                                    <th>Updated Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="logs_data" style="font-weight: 700;">

                                            </tbody>

                                        </Table>
                                    </div>

                                </div>
                                <!-- Tabs content -->



                            </div>
                            <?php if($change_status == 1): ?>
                            <div class="modal-footer" id="btn_action_status">
                                <!-- <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Close</button> -->
                                <button type="button" class="btn btn-primary" id="save_engines" data-mdb-ripple-init>Save Engines</button>
                            </div>
                            <?php else: ?>
                                <div style="text-align: right;" class="m-3"><i>No Access to Change Status</i></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#editEngineModal" hidden>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="editEngineModal" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1" aria-labelledby="editEngineModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editEngineModalLabel">Edit Record</h5>
                                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="scan_engine">
                                    <h5>Edit Record</h5>
                                    <table class="table">
                                        <thead>
                                            <th>Supplying</th>
                                            <th>Company Code</th>
                                            <th>Branch Code</th>
                                            <th>Material Code</th>
                                            <th>Qty</th>
                                            <th>Engine Number</th>
                                            <th>Remove Engine | Delete Material</th>
                                        </thead>
                                        <tbody id="edit_engine_list">
                                        </tbody>
                                    </table>
                                    <hr>
                                    <form action="#" id="add_new_material_form" method="POST" enctype="multipart/form-data">
                                        <table class="table">
                                            <tbody id="add_new_material_list">

                                            </tbody>
                                        </table>
                                    </form>
                                    <br>
                                    <div>
                                        <button class="btn btn-primary" id="add_new_material">Add New Material</button>
                                        <button class="btn btn-success" style="float: right;display: none" id="save_new_material">save new Material</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" id="btn_action_status">
                                <!-- <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Close</button> -->
                                <!-- <button type="button" class="btn btn-primary" id="save_engines" data-mdb-ripple-init>Save Engines</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <br>
            <center>Sorry, you don't have permission to view</center>
        <?php endif; ?>
    </div>


    <div id="print_order_content" style="display: none">
        <div class="" style="width:44%">
            <table class="order_print_table" style="width: 69%;">
                <tr>
                    <td colspan="4" style="text-align: center;border: 1px solid black"><span id="print_supplying"></span></td>
                    <td colspan="5" style="padding-left: 20px;">
                        <p class="print_data" style="text-align: right;width:175%;">Date:<span id="print_date"></span></p>
                        <p class="print_data" style="text-align: center ;font-weight: bold"><span id="print_company"></span></p>
                        <p class="print_data" style="text-align: center ;font-weight: bold">Packing List</p>
                        <p class="print_data">Trucking: <span id="print_trucking"></span> </p>
                        <p class="print_data">Driver: <span id="print_driver"></span></p>
                    </td>
                <tr>
                    <td colspan="9" style="padding-left : 20px"> Branch : <span id="print_branch"></span></td>
                </tr>
                <tr>
                    <td colspan="9">
                        <div style="min-height: 340px;max-height: 380px">
                            <table style="margin: 20px;">
                                <thead>
                                    <tr>
                                        <th colspan="2">Qty</th>
                                        <th colspan="3" style="text-align: center;">Models</th>
                                    </tr>
                                </thead>
                                <tbody id="print_order_tbody">

                                </tbody>
                                <tfoot>
                                    <tr style="border-top: 1px solid black">
                                        <td colspan="2" style="text-align: center;margin-right:10px;"><span id="print_qty_total"></span></td>
                                        <td colspan="3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center">Prepared By:</td>
                    <td colspan="4" style="text-align: center">Checked By: </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center">Received By</td>
                    <td colspan="4" style="text-align: center">Plate No.</td>
                </tr>

            </table>
        </div>
    </div>
    <div id="print_content" style="background-color: white;display: none">
        <div class="" id="barcodes_print"></div>
    </div>
   
    <?php endif; ?>
    <div id="loading-overlay" style="display: none;">
        <div class="loading-spinner">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
  

    <script src="./assets/JobApp/js/mdbbootstrap.min.js"></script>
    <script src="./assets/JobApp/js/jquery_ajax.min.js"></script>
    <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-sweetalert.min.js"></script>
    <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-datatables.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.0/JsBarcode.all.min.js"></script> -->
    <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-select2.min.js"></script>

    <script>
        var base_url = '<?php echo base_url(); ?>';
        var username_warehouse = '<?= $_SESSION['warehouse_logusername'] ?>'
        // Show loading overlay
        function showLoadingOverlay() {
            document.getElementById('loading-overlay').style.display = 'block';
        }
        // Hide loading overlay
        function hideLoadingOverlay() {
            document.getElementById('loading-overlay').style.display = 'none';
        }
        $(document).ready(function() {
            var tab_content = localStorage.getItem('tab_content_'+username_warehouse);

            $('.content-all').hide();
            $('.' + tab_content).show();



            $(document).on('click', '#edit_order_disabled', function() {
                Toastify({
                    text: `Sorry you can't edit order to this status`,
                    duration: 3000,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: 'orange'
                }).showToast();
            })

            $(document).on('change', '.additional_material', function() {
                var material_count = $(this).find('option:selected').data('count');

                if (material_count == 0) {
                    $('#save_new_material').attr('disabled', true);
                    $(this).css('border', '1px solid red');
                } else {
                    $('#save_new_material').attr('disabled', false);
                    $(this).css('border', '1px solid white');
                }
            })
            $(document).on('click', '.rm_material', function() {
                var id = $(this).data('id');
                var genid = $(this).data('genid');
                Swal.fire({
                    title: "Remove Order Material?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, remove it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: base_url + 'remove-order-material',
                            type: 'POST',
                            data: {
                                id: id,
                                genid: genid,
                                _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")

                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if (data == 1) {
                                    Toastify({
                                        text: `Materual Order has been removed`,
                                        duration: 3000,
                                        gravity: 'top',
                                        position: 'right',
                                        backgroundColor: '#11a167'
                                    }).showToast();
                                    $('#editEngineModal').modal('hide');
                                } else {
                                    Toastify({
                                        text: `Error removing material order. Please try again`,
                                        duration: 3000,
                                        gravity: 'top',
                                        position: 'right',
                                        backgroundColor: '#ff5722'
                                    }).showToast();
                                }

                            }
                        })
                    }
                });
            })
            $(document).on('click', '.rm_engine', function() {
                var id = $(this).data('id');
                var genid = $(this).data('genid');
                Swal.fire({
                    title: "Remove Engine Number?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, remove it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: base_url + 'remove-engine',
                            type: 'POST',
                            data: {
                                id: id,
                                genid: genid,
                                _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")

                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if (data == 1) {
                                    Toastify({
                                        text: `Engine number has been removed`,
                                        duration: 3000,
                                        gravity: 'top',
                                        position: 'right',
                                        backgroundColor: '#11a167'
                                    }).showToast();
                                    $('#editEngineModal').modal('hide');
                                } else {
                                    Toastify({
                                        text: `Error removing engine number. Please try again`,
                                        duration: 3000,
                                        gravity: 'top',
                                        position: 'right',
                                        backgroundColor: '#ff5722'
                                    }).showToast();
                                }

                            }
                        })
                    }
                });
            })
            $(document).on('click', '#save_new_material', function() {
                var branch = $(this).data('branch');
                var supplying = $(this).data('supplying');
                var genid = $(this).data('genid');
                var inventory_id = $(this).data('id');
                var formData = new FormData($('#add_new_material_form')[0]);
                formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
                formData.append("genid", genid);
                formData.append("branch", branch);
                formData.append("supplying", supplying);
                formData.append("inventory_id", inventory_id);
                showLoadingOverlay()
                $.each($('.additional_material'), function(key, value) {
                    var val = $(value).val();
                    if (val == null) {
                        $(value).css('border', '1px solid red');
                        alert('Please choose additional material');
                        hideLoadingOverlay()
                        return false;
                    } else {
                        $(value).css('border', '1px solid white');
                    }
                })
                Swal.fire({
                    title: "Add Material in this Order?",
                    text: "Click 'Yes' to proceed!",
                    // icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: base_url + 'add-new-material',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            cache: false,
                            dataType: 'json',
                            success: function(data) {
                                showLoadingOverlay()
                                if (data.err == 0) {
                                    Toastify({
                                        text: `Material successfully added`,
                                        duration: 3000,
                                        gravity: 'top',
                                        position: 'right',
                                        backgroundColor: 'green'
                                    }).showToast();
                                    setTimeout(function() {
                                        location.reload();
                                    }, 3000);
                                } else {
                                    Toastify({
                                        text: data.err_mssg,
                                        duration: 3000,
                                        gravity: 'top',
                                        position: 'right',
                                        backgroundColor: '#03a9f4'
                                    }).showToast();
                                }

                            }
                        })
                    }
                });

            })

            $(document).on('click', '#print_order', function() {
                var genid = $(this).data('genid');
                var formData = new FormData();
                formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
                formData.append("genid", genid);
                // showLoadingOverlay()
                $.ajax({
                    url: base_url + 'get-check-order',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    dataType: 'json',
                    success: function(data) {

                        console.log(data)
                        $('#print_branch').text(data.BranchName);
                        $('#print_date').text(data.CreatedDate);
                        $('#print_trucking').text(data.Trucking);
                        $('#print_driver').text(data.DriverName);
                        $('#print_company').text(data.Company);
                        $('#print_supplying').text(data.SupplyingPlant);

                        var tr = '';
                        var order = data.Orders
                        var len = order.length
                        var remaining = 9 - len
                        var total = 0;
                        $.each(order, function(index, value) {
                            total += parseInt(value.qty);
                            tr += `<tr>
                                <td colspan="2" class="print_data-left">${value.qty}</td>
                                <td colspan="3" class="print_data-right">${value.MaterialCode}</td>
                            </tr>`
                        })

                        for (var i = 0; i < remaining; i++) {
                            tr += `<tr>
                                    <td colspan="2" class="print_data-left">&nbsp;</td>
                                    <td colspan="3" class="print_data-right">&nbsp;</td>
                                </tr>`;
                        }
                        $('#print_qty_total').text(total);
                        $('#print_order_tbody').html(tr);

                        $('.print-hide').hide();
                        $('#print_order_content').show();
                        $('body').css('background-color', '#fff');
                        window.print();
                        // $('#print_order_content').hide();
                        // $('.print-hide').show();
                        // $('body').css('background-color', '#f0f0f0');
                    }

                });
            })

            $(document).ready(function() {
                $(document).on('click', '#save_engines', function() {
                    var check_engines = 0;
                    var insert_data = [];
                    var len = 0;

                    $.each($('.scan_engine_barcode'), function() {
                        len++;
                        var val = $(this).val();
                        var id = $(this).data('id');
                        var genid = $(this).data('genid');
                        if (val == '') {
                            check_engines++;
                            $(this).css('border', '1px solid #ed5976')
                        } else {
                            $(this).css('border', '1px solid #52cfbc')
                            insert_data.push({
                                val: val,
                                id: id,
                                genid: genid
                            });
                        }
                    })
                    // if (check_engines > 0) {
                    //     Toastify({
                    //         text: 'All engine numbers are required',
                    //         duration: 5000, // Duration in milliseconds
                    //         close: false, // Show close button
                    //         gravity: "top", // `top` or `bottom`
                    //         position: "right", // `left`, `center` or `right`   
                    //         backgroundColor: "#ffa500",
                    //         style: {
                    //             color: "#114aa1",
                    //             "border-radius": "10px", // Border radius
                    //         }, // Background color 
                    //         stopOnFocus: true, // Prevents dismissing of toast on hover
                    //     }).showToast();
                    //     return false;
                    // } else {



                    // }
                    if (len == check_engines) {
                        Toastify({
                            text: 'No Changes Made, Please scan Engine Numbers',
                            duration: 5000, // Duration in milliseconds
                            close: false, // Show close button
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`   
                            backgroundColor: "#ffa500",
                            style: {
                                color: "#114aa1",
                                "border-radius": "10px", // Border radius
                            }, // Background color 
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                        }).showToast();
                        return false;
                    }

                    var title_swal = check_engines > 0 ? 'Some fields are missing, Do you want to Proceed?' : 'Do you want to save all Engine Numbers?'

                    Swal.fire({
                        title: title_swal,
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Save",
                        denyButtonText: `Don't save`
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            showLoadingOverlay()
                            $.ajax({
                                type: 'post',
                                url: base_url + 'save-engines',
                                data: {
                                    _cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
                                    insert_data: insert_data
                                },
                                dataType: 'json',
                                success: function(response) {
                                    hideLoadingOverlay()
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Your work has been saved",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    setInterval(function() {
                                        location.reload();
                                    }, 1500)
                                }

                            })

                        } else if (result.isDenied) {
                            Swal.fire("Changes are not saved", "", "info");
                        }
                    });

                })
                $(document).on('click', '#addEngineModal', function() {
                    $('#scan_input').val('')
                    $('#scan_input').attr('Placeholder', 'Scanner is Ready')
                    $('#scan_input').focus();

                })

            })

            $(document).on('keypress', '#scan_input', function(event) {
                // event.preventDefault();
                var barcode = $(this).val();

                if (event.which === 13) {

                    $('#scan_input').val('')
                    $.ajax({
                        type: 'post',
                        url: base_url + 'check-engine-number',
                        data: {
                            _cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
                            engine_number: barcode
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response == null) {
                                Toastify({
                                    text: 'Engine Number :' + barcode + ' not found',
                                    duration: 5000, // Duration in milliseconds
                                    close: true, // Show close button
                                    gravity: "top", // `top` or `bottom`
                                    position: "center", // `left`, `center`, or `right`
                                    backgroundColor: "#3498db", // Background color
                                    stopOnFocus: true, // Stop the toast from hiding on hover
                                }).showToast();
                                $(this).focus('');
                                $('#ready_for_alocate').html('<span style="color:green">Scanner is ready</span>');
                            } else {
                                var seq = [];
                                var existing_engine = 0;
                                var value_count = 0;
                                var material_input_count = 0;
                                // do mapping here
                                $.each($('.scan_engine_barcode'), function() {
                                    var material_code = $(this).data('material');
                                    var val = $(this).val();
                                    var sequence = $(this).data('sequence');

                                    if (material_code == response.MaterialCode) {
                                        material_input_count++
                                        if (val == response.EngineNumber) {
                                            Toastify({
                                                text: 'Engine number already exist',
                                                duration: 5000, // Duration in milliseconds
                                                close: true, // Show close button
                                                gravity: "top", // `top` or `bottom`
                                                position: "center", // `left`, `center`, or `right`
                                                backgroundColor: "#3498db", // Background color
                                                stopOnFocus: true, // Stop the toast from hiding on hover
                                            }).showToast();
                                            existing_engine++
                                        }
                                        if (val == '') {

                                            seq.push(sequence);


                                        } else {
                                            value_count++
                                        }
                                    }
                                })
                                console.log(material_input_count);
                                if (seq.length > 0) {
                                    if (existing_engine == 0) {
                                        var input_class = '.add_' + response.MaterialCode.replace(/\s+/g, "") + '_' + seq[0];
                                        $(input_class).val(response.EngineNumber);
                                        $(input_class).css('border', '1px solid #52cfbc')
                                    }
                                    $(this).focus('');
                                } else if (seq.length == 0 && material_input_count == value_count) {
                                    Toastify({
                                        text: 'No Space for new engine number',
                                        duration: 5000, // Duration in milliseconds
                                        close: true, // Show close button
                                        gravity: "top", // `top` or `bottom`
                                        position: "center", // `left`, `center`, or `right`
                                        backgroundColor: "#3498db", // Background color
                                        stopOnFocus: true, // Stop the toast from hiding on hover
                                    }).showToast();
                                } else {
                                    Toastify({
                                        text: response.MaterialCode + ' not found in pick list',
                                        duration: 5000, // Duration in milliseconds
                                        close: true, // Show close button
                                        gravity: "top", // `top` or `bottom`
                                        position: "center", // `left`, `center`, or `right`
                                        backgroundColor: "#3498db", // Background color
                                        stopOnFocus: true, // Stop the toast from hiding on hover
                                    }).showToast();
                                }
                                setInterval(function() {
                                    $(this).focus('');
                                    // $('#ready_for_alocate').html('<span style="color:green">Scanner is ready</span>');
                                }, 1200)
                            }
                        }

                    })
                }
            })

            $(document).on('click', '#change_status', function() {

                var genid = $(this).data('genid');
                var statusid = $(this).data('statusid');
                var statusname = $(this).data('statusname');
                var null_engine = 0;


                $.each($('.scan_engine_barcode'), function(k, v) {
                    if ($(this).val() == '') {
                        null_engine++;
                    }
                })
                console.log(null_engine);
                if (null_engine > 0) {
                    Toastify({
                        text: 'Please fill all engine number, before change status',
                        duration: 5000, // Duration in milliseconds
                        close: true, // Show close button
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center`, or `right`
                        backgroundColor: "#3498db", // Background color
                        stopOnFocus: true, // Stop the toast from hiding on hover
                    }).showToast();
                    return false;
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "Change status for " + statusname,
                    // icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Change!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoadingOverlay()
                        var formData = new FormData();
                        formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
                        formData.append("genid", genid);
                        formData.append("statusid", statusid);
                        $.ajax({
                            url: base_url + 'order-change-status',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            cache: false,
                            dataType: 'json',
                            success: function(data) {
                                hideLoadingOverlay()
                                if (data == 1) {
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Your work has been saved",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1500);
                                }
                            }

                        });
                    }
                });
            })

            $(document).on('click', '#add_new_material', function() {
                var material = $('#model-code-select').html();
                var branch = $(this).data('branch');
                var supplying = $(this).data('supplying');
                var genid = $(this).data('genid');
                var inventory_id = $(this).data('id');
                var new_tr = `<tr>
                            <td  style="padding:unset;width:10%;"><center>${supplying}</center></td>
                            <td  style="padding:unset;width:10%;"><center>1000</center></td>
                            <td  style="padding:unset;width:11%;"><center>${branch}</center></td>
                            <td  style="padding:unset;width:12%;"><center><select class="form-control mdb-select additional_material" name="material[]">${material}</select></center></td>
                            <td  style="padding:unset;width:3%;"><center>1</center></td>
                            <td  style="padding:unset;width:20%;"> <center> -- </center></td>
                            <td  style="padding:unset;width:20%;text-align:center"><center> <button class="btn btn-primary rm_new_material"><i class="fa-solid fa-xmark"></i></button></center></td>
                          </tr>`;
                $('#add_new_material_list').append(new_tr);
                $('#save_new_material').show();
                $('#save_new_material').attr('data-genid', genid);
                $('#save_new_material').attr('data-branch', branch);
                $('#save_new_material').attr('data-id', inventory_id);
                $('#save_new_material').attr('data-supplying', supplying);

            })

            $(document).on('click', '.rm_new_material', function() {
                var parent = $(this).parent().parent().parent();

                parent.remove();
                var count = $('.additional_material').length;
                console.log(count);
                if (count == 0) {
                    $('#save_new_material').hide();
                }
            })

            $(document).on('click', '#edit_order', function() {
                var genid = $(this).data('genid');
                var branch = $(this).data('branch');
                var statusid = $(this).data('statusid');
                var supplying = $(this).data('supplying');
                var inventory_id = $(this).data('id');
                var formData = new FormData();
                formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
                formData.append("genid", genid);
                formData.append("branch", branch);
                formData.append("statusid", statusid);
                showLoadingOverlay()
                $('#add_new_material_list').html(``);
                $('#save_new_material').hide();

                $('#add_new_material').attr('data-genid', genid);
                $('#add_new_material').attr('data-branch', branch);
                $('#add_new_material').attr('data-supplying', supplying);
                $('#add_new_material').attr('data-id', inventory_id);
                getEngines(formData, statusid, branch, genid, 'edit_engine_list', 'editEngineModal');
            })

            $(document).on('click', '.add_engine', function() {
                var genid = $(this).data('genid');
                var branch = $(this).data('branch');
                var statusid = $(this).data('statusid');
                var formData = new FormData();
                formData.append("_cmcToken", $(`meta[name="_cmcToken"]`).attr("content"));
                formData.append("genid", genid);
                formData.append("branch", branch);
                formData.append("statusid", statusid);
                showLoadingOverlay()

                getEngines(formData, statusid, branch, genid, 'scan_engine_list', 'addEngineModal');
            })

            function getEngines(formData, statusid, branch, genid, tablename, modalid) {
                $.ajax({
                    url: base_url + 'get-inventory',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    dataType: 'json',
                    success: function(data) {

                        if (statusid == 2209) {
                            $('#btn_action_status').html(`<button type="button" class="btn btn-primary" data-genid="${genid}" data-statusid="2210" data-statusname="For Delivery"  id="change_status" data-mdb-ripple-init>For Delivery</button>`);
                        }
                        if (statusid == 2210) {
                            $('#btn_action_status').html(`<button type="button" class="btn btn-primary" data-genid="${genid}" data-statusid="2211" data-statusname="Delivered"  id="change_status" data-mdb-ripple-init>Delivered</button>`);
                        }
                        if (statusid == 2208) {
                            $('#btn_action_status').html(`<button type="button" class="btn btn-primary" id="save_engines" data-mdb-ripple-init="" style="">Save Engines</button>`);
                        }
                        if (statusid != 2208) {
                            console.log(statusid);
                            $('.scan-area').hide();
                            $('#save_engines').hide();
                        } else {
                            $('.scan-area').show();
                            $('#save_engines').show();
                        }

                        $('#addEngineModalLabel , #editEngineModalLabel').html('Branch : ' + branch + ' | REFERENCE ID : ' + genid);
                        $('#' + modalid).modal('show');
                        var scan_tr = '';
                        $.each(data.result, function(key, value) {
                            var modal_engine = modalid == 'editEngineModal' ? 'no engine' : 'scan engine';
                            var engine_nember = value.EngineNumber == null && value.Deletedflag == 0 ? '<input placeholder="' + modal_engine + '" data-genid="' + genid + '" type="text" data-material="' + value.MaterialCode + '" data-sequence="' + key + '" data-id="' + value.id + '" class="form-control scan_engine_barcode  add_' + value.MaterialCode.replace(/\s+/g, "") + '_' + key + '" value="" readonly="readonly" />' : '<span style="font-weight:bold">' + value.EngineNumber + '</span>';
                            var remove_btn = statusid != 2208 ? '--' : '<button class="btn btn-primary scan_engine "  data-id="' + value.id + '" >X</button>';
                            var disable_edit = value.EngineNumber == null ? 'disabled' : '';
                            //overwrite when edit engine
                            remove_btn = modalid == 'editEngineModal' ? '<button class="btn btn-primary rm_engine " data-removeid="' + modalid + '_rmengine_' + value.id + '"  data-genid="' + genid + '" title="Remove Engine Number"  data-id="' + value.id + '" ' + disable_edit + '><i class="fa-solid fa-circle-minus"></i></button> <button title="delete Material" style="background:#ff0000bf !important;"  class="btn btn-primary rm_material "  data-genid="' + genid + '"  data-id="' + value.id + '" ><i class="fa-solid fa-trash" ></i></button>' : remove_btn;
                            var tr_color = value.OrderStatus == 1 ? 'style="background:#b4ffb77d;font-weight:bold !important;"' : 'white';
                            // var tr_color = value.Deletedflag == 1 ? 'style="background:#ffb3b3;"' : tr_color;

                            scan_tr += '<tr ' + tr_color + '>';
                            // scan_tr += '<td style="padding:2px 2px 2px 0px">' + String(value.id).padStart(6, '0') + '</td>';
                            scan_tr += '<td style="padding:2px 2px 2px 0px;text-align:center;">' + value.SupplyingPlant + '</td>';
                            scan_tr += '<td style="padding:2px 2px 2px 0px;text-align:center;">' + value.Company + '</td>';
                            scan_tr += '<td style="padding:2px 2px 2px 0px;text-align:center;">' + value.BranchCode + '</td>';
                            scan_tr += '<td style="padding:2px 2px 2px 0px;text-align:center;">' + value.MaterialCode + '</td>';
                            scan_tr += '<td style="padding:2px 2px 2px 0px;text-align:center;">1</td>';
                            scan_tr += '<td style="padding:2px 2px 2px 0px;text-align:center;" class="' + modalid + '_rmengine_' + value.id + '"> ' + engine_nember + '</td>';
                            scan_tr += '<td style="padding:2px 0px 2px 0px;text-align:center;">' + remove_btn + '</td>';
                            scan_tr += '</tr>';
                        });
                        hideLoadingOverlay()
                        $('#' + tablename).html(scan_tr);
                        var logs_data = '';

                        $.each(data.logs, function(key, value) {
                            var color = value.Action == 'INSERT NEW ORDER' ? 'green' : 'red';
                            logs_data += '<tr>';
                            logs_data += '<td style="color:' + color + '">' + value.Action + '</td>';
                            logs_data += '<td>' + value.MaterialCode + '</td>';
                            logs_data += '<td>' + value.CreatedBy + '</td>';
                            logs_data += '<td>' + value.CreatedDate + '</td>';
                            logs_data += '</tr>';
                        });

                        $('#logs_data').html(logs_data);

                    }
                })
            }

        }) //end document ready
    </script>


    <script src="<?= base_url() ?>assets/warehouse/js/warehouse.pick-release.js?refresh=<?= date("Y-m-d H:i:s") ?>"></script>
    <script src="<?= base_url() ?>assets/warehouse/js/warehouse.nav.js?refresh=<?= date("Y-m-d H:i:s") ?>"></script>

    <?php if ($control_user == 1):  ?>
        <script src="<?= base_url() ?>assets/warehouse/js/admin-user.js?refresh=<?= date("Y-m-d H:i:s") ?>"></script>
    <?php endif; ?>

</html>