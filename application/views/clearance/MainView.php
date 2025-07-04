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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/clearance_assets/css/mainview.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />
</head>
<style>
    html {
        zoom: 85% !important;
    }

    a.fa-user {
        position: relative;
        font-size: 2em;
        color: grey;
        cursor: pointer;
    }

    span.fa-comment {
        position: absolute;
        font-size: 20px;
        top: -8px;
        color: red;
        right: -11px;
    }

    span.num {
        position: absolute;
        font-size: 12px;
        top: -5px;
        color: #fff;
        right: -3px;
    }

    .data-tr {
        border-bottom: unset !important;
    }

    .status-choose {
        background: linear-gradient(currentColor 0 0) bottom left/ var(--underline-width, 0%) 0.1em no-repeat;
        color: #7b7b7be0;
        display: inline-block;
        padding: 0 .5em 0.2em;
        text-decoration: none;
        transition: background-size 0.5s;
        padding: 5px;
        cursor: pointer;
        font-weight: 600;
    }

    .status-choose:hover {
        --underline-width: 100%;
        background-color: #fff;
    }

    .active-choose {
        color: #000cb8;
        background-color: #fff;


    }

    .swal2-cancel {
        margin: 10px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    #modal-size-comment {
        margin-left: 66%;
    }

    #modal-size-settings {
        width: 40% !important;
    }

    .helper_question {

        display: none !important;
    }

    .modal_content {
        width: 50%;
    }

    .last_pay_modal {
        width: 50%
    }

    .comment_profile_row {
        width: 30%;
    }

    #last_pay_comment {
        max-height: 250px
    }

    @media screen and (min-height: 900px) {
        #last_pay_comment {
            max-height: 385px !important;
        }

    }

    @media only screen and (max-width: 920px) {

        .comment_profile_row {
            width: 40%;
        }

        #interview_mssg {
            right: 0px !important;
        }

        .last_pay_modal {
            width: 100%
        }

        #modal-size-comment {
            margin-left: 1px
        }

        #modal-size-settings {
            width: 100% !important;
        }

        .helper_question {

            display: block !important;
        }

        .modal_content {
            width: 100%;
        }
    }

    @media only screen and (min-width: 768px) {

        #id_display {
            background-color: white !important;
        }


    }

    @media only screen and (max-width: 370px) {}

    .images_helper {
        width: -webkit-fill-available;
        border: 1px solid gray;
    }

    #mobile_helper {
        max-height: 130%;
        height: 130%;
        overflow: scroll;
        padding: 20px;
        border: 2px solid gray;
    }

    .data-tr:hover {
        background-color: #d6dcf84d !important;
    }

    @media only screen and (max-width: 900px) {
        .backgrount_img {
            height: 47% !important;
        }

        .title {
            font-size: 12px !important;
        }

        .body_content {
            font-size: 11px !important;
        }

        .third {
            margin-left: 5px !important;

        }

    }
</style>

<body>
    <div class="">
        <nav class="navbar navbar-expand-lg" style="background-color: #24388e;">
            <div class="container-fluid">
                <img src="<?= base_url() ?>assets/clearance_assets/image/banner.png" alt="" srcset="" width="180" height="50">
            </div>
            <li class="nav-item dropdown" style=" list-style-type: none">
                <a class="nav-link dropdown-toggle pl-3" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <font color="white"><?= $_SESSION['fullname']; ?></font>
                </a>
                <ul class="dropdown-menu pt-3 p-2   " aria-labelledby="navbarDropdownMenuLink">
                    <span class="ml-3 mt-3 " id="settings-btn" title="Settings" style="cursor: pointer;"><i class="fas fa-cog "></i> Profile/Settings</span>
                    <br>
                    <!-- <a class="dropdown-item" href="#">Email :<?= $_SESSION['email'] == '' ? '--' : $_SESSION['email']; ?></a> -->
                    <br>
                    <span class="mr-2 pull-right"><a class="btn btn-danger " href="<?= base_url() ?>logout">Logout</a></span>
                </ul>
            </li>
        </nav>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Employee Action
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body d-flex">
                        <form action="https://elearning.motortrade.com.ph/api-cmc/api/makePdf"  method="POST" target="_blank">
                            <input type="hidden" value="<?= $_SESSION['dateHired']?>" name="date_hired">
                            <input type="hidden" value="<?= $_SESSION['resignedDate']?>" name="resigned_date">
                            <input type="hidden" value="<?= $_SESSION['fullname']?>" name="fullname">
                            <input type="hidden" value="<?= $_SESSION['lastName']?>" name="lastname">
                            <input type="hidden" value="<?= $_SESSION['company']?>" name="company_code">
                            <input type="hidden" value="<?= $_SESSION['companyDescription']?>" name="company_name">
                            <input type="hidden" value="<?= $_SESSION['orgCode']?>" name="org_code">
                            <input type="hidden" value="<?= $_SESSION['orgDescription']?>" name="org_description">
                            <input type="hidden" value="<?=   $_SESSION['position']   ?>" name="position">
                            <input type="hidden" value="<?= $_SESSION['accountabilityStatus'] ==  'CLEARED' ? 1:0 ?>" name="status">
                            <input type="hidden" value="coe" name="template">
                            <!-- <button class="btn btn-info" type="submit">Download COE</button> -->
                        </form>
                        &nbsp; &nbsp; &nbsp;
                        <button type="button" class="btn btn-info" id="back_p" data-bs-toggle="modal">
                                Last Pay
                            </button>
                        <!-- <a href="<?= base_url() ?>download-action" target="_blank" type="button" class="btn btn-info">Download COE</a> -->
                        <!-- <?php if ($_SESSION['accountabilityStatus'] == 'CLEARED') : ?>

                            <button type="button" class="btn btn-info" id="back_p" data-bs-toggle="modal">
                                Last Pay
                            </button>
                        <?php else : ?>
                            <button type="button" class="btn btn-secondary">
                                Last Pay
                            </button>
                        <?php endif; ?> -->
                        <!-- <span id="lastpay_btn"></span> -->
                        <!-- end modal last pay -->
                    </div>
                </div>
            </div>
        </div>

        <!-- modal last pay -->
        <div class="modal fade" id="Back_pay" tabindex="-1" aria-labelledby="Back_payLabel" aria-hidden="true">
            <div class="modal-dialog last_pay_modal" style="height: 95%;">
                <div class="modal-content" style="height: 95%;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Back_payLabel">Computation </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body " style="overflow-y:hidden">

                        <div class="row">
                            <div class="col-10">
                                <h4 id="last_pay_desc"></h4>
                            </div>
                            <div class="col-2">
                                <?php if ($_SESSION['agreed'] == true) : ?>
                                    <button class="btn btn-secondary pull-right" id="last_pay_response">Agree</button>
                                <?php else : ?>
                                    <button class="btn btn-primary pull-right" id="lastpay_agree_btn">Agree</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <div id="computation_display" style="overflow-y:scroll;max-height :290px;">

                            </div>
                        </div>
                        <hr>
                        <h5>Comment Section</h5>
                        <div>
                            <div id="last_pay_comment" style="overflow-y: scroll;">
                                ...
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer d-flex">
                        <form action="" id="LastpayCommentForm" style="display: inline-flex;width:100%" enctype="multipart/form-data" data-formstate="0" data-otptries="3" data-otpstate="0" data-otp-exp-min="5">
                            <input type="text" class="form-control" id="lastpaycomment" name="lastpaycomment" style="width: 88%;" placeholder="Enter Comment">
                            <button class="btn btn-success" type="submit" id="lastpay_send">Send</button>
                            <span id="comment_parent_id"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- accountability page -->
        <div class="container-fluid">
            <span class="information_helper pt-2 pl-2">
                <i class="fa-solid fa-circle-question helper_question " style="color: #79a5f1;font-size:20px;" title="Click here for Mobile help!"></i>
            </span>
            <div class="busquedaSem" style="display: inline-flex;width:100%">
                <label class="control-label">
                    Accountability Status:
                </label><br>
                <!-- <div id="filters-status"></div> -->
                <div style="font-size:15px;font-weight:700" data-active="0" class="status0 status-choose active-choose" data-status="">All</div>
                <div style="font-size:15px;font-weight:700" data-active="1" class="status1 status-choose" data-status="NEW"><span>NEW</span></div><span style="font-weight: 900;">&#x2192;</span>
                <div style="font-size:15px;font-weight:700" data-active="2" class="status2 status-choose" data-status="ACCEPTED">ACCEPTED</div><span style="font-weight: 900;">&#x2192;</span>
                <div style="font-size:15px;font-weight:700" data-active="3" class="status3 status-choose" data-status="FOR CLEARANCE">FOR CLEARANCE</div><span style="font-weight: 900;">&#x2192;</span>
                <div style="font-size:15px;font-weight:700" data-active="4" class="status4 status-choose" data-status="WIP BY CLEARING DEPT">WIP</div><span style="font-weight: 900;">&#x2192;</span>
                <div style="font-size:15px;font-weight:700" data-active="5" class="status5 status-choose" data-status="PENDING BY EMPLOYEE">PENDING BY EMPLOYEE</div><span style="font-weight: 900;"> &#8644;</span>
                <div style="font-size:15px;font-weight:700" data-active="6" class="status6 status-choose" data-status="REPLIED BY EMPLOYEE">REPLIED BY EMPLOYEE</div><span style="font-weight: 900;">&#x2192;</span>
                <div style="font-size:15px;font-weight:700" data-active="7" class="status7 status-choose" data-status="CLEARED">CLEARED</div>

                <div style="font-size:15px;font-weight:700" data-active="8" class="status8 status-choose" data-status="CANCELLED">CANCELLED</div>
                <span id="interview_btn"></span>
                <!-- <div class="status-choose"data-></div> -->
            </div>

            <table id="accountability-table" class="table" style="background-color: white; padding:15px;width:100% !important">
                <thead id="table-head">

                </thead>
                <tbody id="body-table">
                    <center><span style="margin-top: 600px;" id="load"><img src="<?= base_url() ?>assets/clearance_assets/image/loader.gif" style="width: 200px;height:110px;" alt=""></span></center>
                </tbody>
            </table>
        </div>

        <!-- modal for heper -->
        <div class="modal fade" id="helpermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="helpermodalLabel" aria-hidden="true">
            <div class="modal-dialog" style="display:block;margin-top:0px !important; height: 100%;" id="modal-size-comment">
                <div class="modal-content" style="height: 100%;width:100%;">
                    <div class="modal-header">
                        <h3>Helper</h3>
                        <button type="button" class="btn btn-secondary btn-rounded" data-mdb-ripple-color="dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                    <div class="modal-body" id="mobile_helper" style="background-color:white">
                        <h5>Setting and Control</h5>
                        <img class="images_helper" src="<?= base_url() ?>assets/clearance_assets/image/helper_image/settings.jpg" alt="" srcset="">
                        <br>
                        <br>
                        <h5>For Mobile View</h5>
                        If You Click <b>ID</b> Column
                        <img class="images_helper" src="<?= base_url() ?>assets/clearance_assets/image/helper_image/idclick.jpg" alt="" srcset="">
                        <p>Will Collapse all <b>more Columns</b></p>
                        <img class="images_helper" src="<?= base_url() ?>assets/clearance_assets/image/helper_image/idshow.jpg" alt="" srcset="">
                        And If you Click <b>Accountability </b>Colunm
                        <img class="images_helper" src="<?= base_url() ?>assets/clearance_assets/image/helper_image/accountabilityclick.jpg" alt="" srcset="">
                        and the <b>Comment</b> Section will shown
                        <img class="images_helper" src="<?= base_url() ?>assets/clearance_assets/image/helper_image/commentshow.jpg" alt="" srcset="">
                        <br>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for comment -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" style="display:block;margin-top:0px !important; height: 100%;" id="modal-size-comment">
                <div class="modal-content" style="height: 100%;width:100%;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                        <span id="status-comment" style="width: 28%;max-width:30%;margin-right:5px;float:left">
                            <button align="center" id="close-change-status" title="click to change status to Replied by user" class="btn btn-primary" style="font-size:10px;padding:unset;width:100% !important;height:62px;">Close with Change Status</button> </span>
                        <span><button type="button" class="btn btn-secondary btn-rounded" data-mdb-ripple-color="dark" id="close-mdl" data-bs-dismiss="modal" aria-label="Close">Close</button></span>
                    </div>
                    <div style="font-size:smaller;display:inline;border-bottom:1px solid #80808057;padding-bottom:5px;padding-left:10px">

                        <span style="display:inline-flex;"><b>Status: </b><span id="current-status"> </span></span><br>
                        <b>Description:</b> <span id="desc-comment"></span><br>
                        <b>Remarks: </b><span id="remarks-comment"></span><br>
                        <span id="exit-interview"></span>
                    </div>

                    <div class="modal-body" style="background-color:white;max-height: 405px;">
                        <div class="card-body " style="height:95%;max-height:1080px; overflow-y:scroll; padding:0 !important ;" id="comment-section">
                            <!-- comment area -->
                        </div>
                        <div class="card-footer bg-white position-absolute w-100 bottom-0 m-0 p-1">
                            <div class="input-group">
                                <div class="input-group-text bg-transparent border-0">
                                    <!-- <button class="btn btn-light text-secondary">
                                        <i class="fas fa-smile"></i>
                                    </button> -->
                                </div>
                                <input type="text" name="comment-text" id="comment-text" class="form-control border-0" placeholder="Write a message...">
                                <input type="hidden" name="clearance_id" id="clearance_id">

                                <div class="input-group-text bg-transparent border-0">
                                    <button id="comment-send" class="btn btn-light text-secondary">
                                        <i class="fas fa-send"></i>
                                    </button>
                                </div>
                                <div class="input-group-text bg-transparent border-0">
                                    <!-- <button class="btn btn-light text-secondary">
                                        <i class="fas fa-microphone"></i>
                                    </button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Profile / Settings -->
        <div align="center" class="modal fade" id="mdl-setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdl-settingLabel" aria-hidden="true">
            <div class="modal-dialog" style="align-content: center;">

                <div class="modal-content" id="modal-size-settings">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdl-settingLabel"><i class="fas fa-cog"></i></h5>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="settings-close">Close</button>
                    </div>
                    <h4>Profile Information</h4>
                    <form action="">

                        <div class="modal-body" align="left">
                            <span id="email-display">
                                <table>
                                    <tr>
                                        <td style="font-weight: 500;"> Employee ID</td>
                                        <td>:&nbsp;<?= $_SESSION['Empid']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;"> Name</td>
                                        <td>:&nbsp;<?= $_SESSION['fullname']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;">Position</td>
                                        <td>:&nbsp;<?= $_SESSION['position']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;">company</td>
                                        <td>:&nbsp;<?= $_SESSION['company']; ?></td>
                                    </tr>
                                    <!-- <tr>
                                        <td style="font-weight: 500;">Email</td>
                                        <td>:&nbsp;<?= $_SESSION['email'] == '' ? '<i>no email </i>' : $_SESSION['email']; ?></td>
                                    </tr> -->
                                    <tr>
                                        <td style="font-weight: 500;">Email</td>
                                        <td>:&nbsp;<?= $_SESSION['email'] == '' ? '---- <a href="#" class=" border-0 change-email">add email</a>' : $_SESSION['email'] . '<a href="#" id="change-email" class="change-email border-0"> <i class="far fa-edit"></i></a>'; ?></td>
                                    </tr>
                                </table>


                            </span>
                            <hr>
                            <h4>Settings/Control</h4>
                            <span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="reload_comment" />
                                    <label class="form-check-label" for="reload_comment">Reload When Close Comment</label>
                                </div>
                            </span>
                            <span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="show_interview" />
                                    <label class="form-check-label" for="show_interview">Show Exit interview Button</label>
                                </div>
                            </span>
                            <span>
                                <br>
                                <span id="input-email" style="display: none;">
                                    <span for="email" style="font-weight: 500;">Change Email<span class="alert alert-danger email-error" role="alert" style="display:none; position:sticky">
                                            Enter Valid Email
                                        </span>
                                    </span>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email ..." value="<?= $_SESSION['email'] ?>" required>
                                    <a href="#" class="border-0" id="cancel-email">cancel</a>
                                </span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btn-change" style="display: none;">Save Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="fixed-bottom" style="width:100%;">
        <p class="pull-right" style="padding-right:2rem!important;color:lightgray">V1.5.2</p>
    </footer>
    <span id="cred" data-credential="<?= base64_encode($credentials->id) ?>"></span>
    <span id="cred-access" data-access="<?= base64_encode($credentials->systemUserID) ?>"></span>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>
    <script>
        var base_url = "<?= base_url() ?>";
    </script>
    <script src="<?= base_url() ?>assets/clearance_assets/js/mainview.js?refreshTime=<?= date("Ymdhis"); ?>"></script>
    <!-- <script src="<?= base_url() ?>assets/clearance_assets/js/mainview.js?<?= bin2hex(random_bytes(20)); ?>"></script> -->
    <script>
        $(document).ready(function() {


            var comment_reload = localStorage.getItem("reload_comment");
            var interview = localStorage.getItem("show_interview");

            if (comment_reload == 1) {
                $('#reload_comment').prop('checked', true)
            }
            if (interview == 1) {
                $('#show_interview').prop('checked', true)
            }
            $('#reload_comment').on('click', function() {

                if ($(this).is(':checked') == true) {
                    localStorage.setItem("reload_comment", 1);
                } else {
                    localStorage.setItem("reload_comment", 0);
                }
            })

            $('#show_interview').on('click', function() {
                if ($(this).is(':checked') == true) {
                    localStorage.setItem("show_interview", 1);
                } else {
                    localStorage.setItem("show_interview", 0);
                }

            })
            $('#d_ceo').on('click', function() {
                $.ajax({
                    type: "POST",
                    url: `${base_url}download-coe`,
                    data: {
                        confirm: 1,
                        _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                    },
                    // dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $('#coe_template').html(data)
                    }
                });
            })

            $(document).on('click','#back_p', function() {
                getLastPay()
                $('#Back_pay').modal('toggle')
            })

            function getLastPay(condition = 0) {
                $.ajax({
                    type: "POST",
                    url: `${base_url}get-lastpay`,
                    data: {
                        confirm: 1,
                        _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#last_pay_desc').text('Status: ' + data.statusDescription)
                        $('#computation_display').html(data.computation)
                        var last_pay_comment = '';
                        var data_lenght = 0
                        if (condition == 1) {
                            data_lenght = data.clearedEmployeeCommentsOutput.length - 1;
                        } else {
                            data_lenght = data.clearedEmployeeCommentsOutput.length;
                        }

                        $.each(data.clearedEmployeeCommentsOutput, function(k, v) {
                            var slide = data_lenght == k ? 'w3-animate-left' : '';
                            last_pay_comment += `<div class="comments ${slide}">
                                                    <div class="card  shadow-lg ml-3 p-2" style="max-width:60% ;">
                                                        <table>
                                                        <tr>
                                                                <td class="comment_profile_row"><b>${v.name}</b></td>
                                                                <td>: ${v.comments}</td>
                                                            </tr>
                                                        </table> 
                                                    </div>
                                                </div>
                                              
                                                    <i style="color:gray;margin-left:20px"> ${v.createdDate}</i>
                                                <br>`;
                        })

                        $("#last_pay_comment").html(last_pay_comment);
                        $('#comment_parent_id').html(`<input type="hidden" name="comment_Id" id="comment-id" value="${data.id}">`)
                        $("#last_pay_comment").animate({
                            scrollTop: 1000000
                        }, 800);
                    }
                });
            }

            $('#LastpayCommentForm').on('submit', function(e) {
                e.preventDefault();
                console.log('here')

                var formData = new FormData($('#LastpayCommentForm').get(0));
                formData.append(`_cmcToken`, $(`meta[name="_cmcToken"]`).attr("content"))

                if ($('#lastpaycomment').val() == '') {
                    $('#lastpaycomment').css('box-shadow', '0px 0px 10px red')
                    return false;
                }
                $('#lastpaycomment').css('box-shadow', '0px 0px 10px white')
                // $("#last_pay_comment").html('');
                $.ajax({
                    type: "POST",
                    url: `${base_url}lastpay-comment`,
                    processData: false,
                    contentType: false,
                    data: formData,
                    // dataType: 'json',
                    success: function(data) {
                        getLastPay(1)
                        $('#lastpaycomment').val('');
                    }
                });

            })
            $('#lastpay_agree_btn').on('click', function() {
                console.log('here')
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Agree',
                    confirmButtonColor: '#3085d6',
                    denyButtonText: `Maybe Later`,
                    denyButtonColor: '#d1cece',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var last_pay = $('#comment-id').val();
                        $.ajax({
                            type: "POST",
                            url: `${base_url}agree-action`,
                            data: {
                                confirm: 1,
                                id: last_pay,
                                _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                            },
                            // dataType: 'json',
                            success: function(data) {
                                if (data = 1) {
                                    Swal.fire('Success!', '', 'success')
                                    setInterval(function() {
                                        location.reload()
                                    }, 2000);
                                } else {
                                    Swal.fire('Please try Again!', '', 'error')
                                }

                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
            })
            $('#last_pay_response').on('click', function() {

                return false;
            })




        })
    </script>
</body>

</html>