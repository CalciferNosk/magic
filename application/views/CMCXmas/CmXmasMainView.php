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
    <title>CMC Chistmass</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
     <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/mdb/css/mdb.min.css" />
    <!-- Custom styles -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/mdb/css/admin.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
        crossorigin="anonymous"></script>
   
    <style>
        .card:hover {
            transform: scale(1.08);
            cursor: pointer;
        }
        .active-time{
            color: green !important;
            font-weight: bold !important;
        }
    </style>
</head>

<body>
    <!--Main Navigation-->
    <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="#" class="list-group-item list-group-item-action py-2 active nav-list-tab" data-content="dashboard" data-mdb-ripple-init aria-current="true">
                        <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>dashboard</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-2 nav-list-tab" data-content="attendance" data-mdb-ripple-init><i
                            class="fas fa-users fa-fw me-3"></i><span>Attendance</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 nav-list-tab" data-content="program" data-mdb-ripple-init><i
                            class="fas fa-lock fa-fw me-3"></i><span>Programs</span></a>
                </div>
            </div>
        </nav>
        <!-- Sidebar -->

        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-collapse-init data-mdb-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Brand -->
                <a class="navbar-brand" href="#">
                    <img src="<?= base_url() ?>assets/cmc.gif" height="25" alt="" loading="lazy" />
                </a>
                | CMC Chistmas

                <!-- Right links -->
                <ul class="navbar-nav ms-auto d-flex flex-row">

                    <!-- Avatar -->
                    <?= $_SESSION["fetch_result"]->firstName ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
                            id="navbarDropdownMenuLink" role="button" data-mdb-dropdown-init aria-expanded="false">
                            <img src="<?= base_url() ?>assets/icon-circle.png" class="rounded-circle" height="22"
                                alt="" loading="lazy" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">My profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main style="margin-top: 58px">
        <div class="container pt-4 content" id="dashboard">
            <!--Section: Minimal statistics cards-->
            <section>
                <div class="row ">
                    <?php foreach ($all_dept as $key => $dept): ?>
                        <div class="col-xl-3 col-sm-6 col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between px-md-1">
                                        <div>
                                            <h3 class="text-success" id="itd_count">
                                                <!-- <i class="fas fa-circle-notch fa-spin"></i> -->
                                                <?= $dept->count_dept ?>
                                            </h3>
                                            <p class="mb-0"><?= $dept->DepartmentCode ?></p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="far fa-user text-success fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <!--Section: Minimal statistics cards-->

            <!--Section: Statistics with subtitles-->
            <!-- <section>
                <div class="row">
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <i class="fas fa-pencil-alt text-info fa-3x me-4"></i>
                                        </div>
                                        <div>
                                            <h4>Total Posts</h4>
                                            <p class="mb-0">Monthly blog posts</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="h1 mb-0">18,000</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <i class="far fa-comment-alt text-warning fa-3x me-4"></i>
                                        </div>
                                        <div>
                                            <h4>Total Comments</h4>
                                            <p class="mb-0">Monthly blog posts</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="h1 mb-0">84,695</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <h2 class="h1 mb-0 me-4">$76,456.00</h2>
                                        </div>
                                        <div>
                                            <h4>Total Sales</h4>
                                            <p class="mb-0">Monthly Sales Amount</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="far fa-heart text-danger fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <h2 class="h1 mb-0 me-4">$36,000.00</h2>
                                        </div>
                                        <div>
                                            <h4>Total Cost</h4>
                                            <p class="mb-0">Monthly Cost</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-wallet text-success fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
            <!--Section: Statistics with subtitles-->
        </div>

        <div class="container pt-4 content" id="attendance" style="display: none;">
            <button class="btn btn-primary" id="generate_btn">Generate QR</button>
            <button class="btn btn-primary" id="scan_btn">Scan</button>
            <div id="qr_div" class="justify-content-center" style="width: 100%;">
                <center style="align-items: center;">Generate Motortrade QR Code</center>
            </div>
            <input type="hidden" id="geo_loc" value="">
            <input type="hidden" id="lat">
            <input type="hidden" id="long">
            <br>
            <br>
            <div class="row">
                <table class="" id="attendance_table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Location</th>
                            <th>Time In</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_data as $key => $value) : ?>
                            <tr class="<?= $value->EmployeeCode == $_SESSION['cmcxmas_username'] ? 'active-time' : ''; ?>">
                                <td>(<?= $value->EmployeeCode ?>) - <?= $value->EmployeeFullName ?></td>
                                <td><?= $value->DepartmentCode ?></td>
                                <td><a target="_blank" href="<?= $value->GeneratedGeoLocation ?>">view location</a></td>
                                <td><?= empty($value->today) ? date('M j, Y H:i:s', strtotime($value->CreatedDate)): date('M j, Y H:i:s', strtotime($value->today)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container pt-4 content" id="program" style="display: none;">
            <button onclick="getLocation()">Get Location</button>
                            
            <p id="status"></p>
            <center>no program yet</center>
        </div>
    </main>
    <!--Main layout-->
    <!-- MDB -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#ScannerModal" hidden>
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="ScannerModal" tabindex="-1" aria-labelledby="ScannerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ScannerModalLabel">Choose Scanner</h5>
                    <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="card col-md-5 col-sm-5" id="mobile_scan" style="height: 200px;background-color: #e8fbff;border: 1px solid #a3a3a3">
                            <img src="<?= base_url() ?>assets/mdb/img/mobilescan.png" alt="" style="height: 200px;">
                            <!-- <center> Mobile Camera</center> -->
                            <br>
                        </div>
                        <div class="col-md-1 col-sm-1"></div>
                        <div class="card col-md-5 col-sm-5" style="height: 200px;background-color: #e8fbff;border: 1px solid #a3a3a3">
                            <img src="<?= base_url() ?>assets/mdb/img/scanner.png" alt="" style="height: 200px;">
                            <!-- <center> Scanner Device</center> -->
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url() ?>assets/mdb/js/mdb.umd.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/mdb/js/admin.js"></script>
    <script src="./assets/JobApp/js/jquery_ajax.min.js"></script>
    <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-sweetalert.min.js"></script>
    <!-- <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-datatables.min.js"></script>
      -->

      <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/template_cdn/js/warehouse-toastify.min.js"></script>
    <script src="https://unpkg.com/@bitjson/qr-code@1.0.2/dist/qr-code.js"></script>
    <script>
        const isMobile = parseInt("<?= $ismobile ?>");
        const base_url = `<?= base_url() ?>`;
        const u_encode = `<?= $u_encode ?>`;
        const fn_encode = `<?= $fn_encode ?>`;

        getLocation();
        // fetchData()
        $('#attendance_table').DataTable();

        $(document).ready(function() {
            $(document).on('click', '.nav-list-tab', function() {
                var content = $(this).data('content');
                $('.nav-list-tab').removeClass('active');
                $(this).addClass('active');
                $('.content').hide();
                $('#' + content).show();

                if (isMobile) {
                    $('.navbar-toggler ').trigger('click')
                }
            })
            $(document).on('click', '#scan_btn', function() {

                if (isMobile) {
                    location.href = base_url + 'xmas-scan';
                } else {
                    alert('This feature not yet available');
                    return false;
                    $('#ScannerModal').modal('show')
                }

            })
            $(document).on('click', '#mobile_scan', function() {

                location.href = base_url + 'xmas-scan';
            })
            $("#generate_btn").click(function() {
                const today = new Date().toISOString();
                var loc = $("#geo_loc").val();
                var lati = $("#lat").val();
                var longi = $("#long").val();
                var l_encode = btoa(loc);

                var link = base_url + `attendance-xmas?u_encode=${u_encode}&fn_encode=${fn_encode}&l_encode=${l_encode}&t_encode=${btoa(today)}&lati=${lati}&longi=${longi}`;
                console.log(link);
                $("#qr_div").html(`
                            <center>
                                <qr-code id="qr1" contents="${link}" module-color="black" position-ring-color="black" position-center-color="black" style="width: 500px;height: 500px;background-color: #fff;">
                                    <img style="width: 100px" src="<?= base_url() ?>assets/icon-circle.png" slot="icon" />
                                </qr-code>
                            </center>`);
                var animation = 'FadeInTopDown';

                $.each($('input[name="animation"]'), function() {
                    if ($(this).is(':checked')) {
                        animation = $(this).val();
                    }
                })
                console.log(animation)
                genereteQRCode(animation);

            })


            function genereteQRCode(animation) {
                document.getElementById('qr1').addEventListener('codeRendered', () => {
                    // document.getElementById('qr1').animateQRCode(animation);
                    // document.getElementById('qr1').animateQRCode('FadeInTopDown');
                    // document.getElementById('qr1').animateQRCode('RadialRipple');
                    document.getElementById('qr1').animateQRCode('FadeInCenterOut');
                    // document.getElementById('qr1').animateQRCode('MaterializeIn');
                    // document.getElementById('qr1').animateQRCode('RadialRippleIn');

                });
                document
                    .getElementById('qr1')
                    .animateQRCode((targets, _x, _y, _count, entity) => ({
                        targets,
                        from: entity === 'module' ? Math.random() * 200 : 200,
                        duration: 500,
                        easing: 'cubic-bezier(.5,0,1,1)',
                        web: {
                            opacity: [1, 0],
                            scale: [1, 1.1, 0.5]
                        },
                    }));
            }


        });

        function fetchData() {
            $.ajax({
                type: 'post',
                url: base_url + 'xmas-fetch-data',
                data: {
                    _cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
                    get: 1
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                }
            });

        }

        function getLocation() {
            const status = document.getElementById("status");

            if (!navigator.geolocation) {
                status.textContent = "Geolocation is not supported by this browser.";
                return null;
            }

            status.textContent = "Getting location...";

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const {
                        latitude,
                        longitude
                    } = position.coords;
                    const googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;

                    status.textContent = "Location found! Opening Google Maps...";
                    // window.open(googleMapsUrl, "_blank");
                    $('#geo_loc').val(googleMapsUrl);
                    $('#lat').val(latitude);
                    $('#long').val(longitude);
                    // alert(googleMapsUrl);
                    return googleMapsUrl;
                },
                (error) => {
                    const errorMessages = {
                        PERMISSION_DENIED: "Permission denied. Please allow location access.",
                        POSITION_UNAVAILABLE: "Location information is unavailable.",
                        TIMEOUT: "Location request timed out.",
                    };

                    status.textContent = errorMessages[error.code] || "An unknown error occurred.";
                }
            );
        }
    </script>
</body>

</html>