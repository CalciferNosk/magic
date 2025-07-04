<!DOCTYPE html>
<html lang="en">
<link rel="icon" href="assets/favicon.ico">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Online Service Appointment Motortrade">
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <meta name="author" content="The company's slogan “Motorsiklo Sigurado, Alaga Ka Dito” sums up its number one priority — Total Customer Satisfaction is what we always guarantee!">

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
    <style>
        .left-info {
            width: 150px;

        }

        .instruction {
            font-size: 18px;
        }

        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif !important;
            font-size: 14px !important;
        }

        .answered_display {
            border-left: 4px solid #c7f9c7 !important;
        }

        .unanswed_display {
            border-left: 4px solid #f5f5f5;
        }
    </style>
</head>

<body>
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar brand -->
                    
                    <!-- Left links -->
                </div>
                <div class="d-flex align-items-center">
                    <!-- Avatar -->
                    <div class="dropdown">
                        <a data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                        <i class="fa-solid fa-user-pen icon-tab"  data-showbar="applicant"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                            <li>
                                <a class="dropdown-item" href="#">My profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Settings</a>
                            </li>
                            <li>
                                <a class="dropdown-item applicant_logout" style="color:red" href="#">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Right elements -->
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    <div class="container my-5">
       
        <div class="card p-5 mb-5" id="applicant_info">
            <center>
                <h5>APPLICANT INFORMATION</h5>
            </center>
            <table>
                <tr>
                    <td class="left-info">Applicant Name</td>
                    <td>: <?= $_SESSION['applicant_lname'] . ", " . $_SESSION['applicant_fname']  ?></td>
                </tr>
                <tr>
                    <td class="left-info">Position Applied</td>
                    <td>: <?= $_SESSION['position_applied'] ?></td>
                </tr>
                <tr>
                    <td class="left-info">Contact Number</td>
                    <td>: <?= $_SESSION['applicant_contact'] ?></td>
                </tr>
                <tr>
                    <td class="left-info">Email Address</td>
                    <td>: <?= $_SESSION['applicant_email'] ?> </td>
                </tr>
            </table>
        </div>
        <div class="card p-5 mb-5" id="question_start_btn">
            <?php if ($data_part == 0) : ?>
                <h3>Congratulations! You have completed the exam.</h3>
                <button class="btn btn-primary btn-lg applicant_logout">Logout</button>
            <?php else : ?>
                <div class="mb-3">
                    <center>
                        <h5>PART <?= $part ?></h5>
                    </center>
                    <span class="fw-bold instruction"> Panuto: </span> <span class="text-muted instruction">Bago sagutin ang mga katanungan sa ibaba ay nararapat lamang na sundin ng maigi ang nakasaad sa panutong ito.
                        Mahigpit na ipinagbabawal ang anumang uri ng pandaraya sa pagsusulit. Hindi rin pinapahintulutan ang pag gamit ng cellphone o anumang gadget.
                        Limitado lamang ang nakalaang oras sa eksamen na ito kung kaya pamahalaan ito ng maigi.</span>
                </div>
                <button class="btn btn-primary btn-lg " id="start_exam">Start Exam</button>
            <?php endif; ?>
        </div>
        <div class="card p-5" style="display: none;" id="question_display">
            <!-- <p style="text-align:center;color:red;position:fixed;top:10px;right:150px;font-size:20px;font-weight:bold">Time remaining: <span id="countdown"><?= $time_display ?> </span> </p>
            <p style="text-align:center;color:red;position:fixed;top:10px;left:150px;font-size:20px;font-weight:bold">Item remaining:<span id="item_display">   --/--</span></p> -->
            <div class="card p-3" style="text-align:center;color:red;position:fixed;top:0;right:0;font-size:14px;font-weight:bold">Time remaining: <span id="countdown"><?= $time_display ?> </span> </div>
            <div class="card p-3" style="text-align:center;color:red;position:fixed;top:0;left:0;font-size:14px;font-weight:bold">Item remaining:<span id="item_display"> --/--</span></div>
            <p><i>Warning : Please do not refresh page</i></p>
            <hr>
            <div>
            </div>
            <?php foreach ($all_question as $key_all => $all) : ?>
                <br>
                <h4 style="text-align: center;"><?= $all->part_label ?></h4>

                <div>
                    <span class="fw-bold instruction"> Panuto: </span> <span class="text-muted instruction"><?= $all->instruction ?></span>
                </div>
                <?php foreach ($all->group_question as $key => $ques) : ?>
                    <div class="question p-2 question_color_<?= $ques->question_id ?> unanswed_display">
                        <!-- <?= $ques->question_id ?> -->
                        <h6 class="mb-3 question_display_count" style="font-weight: 700;user-select: none"><?= $key + 1 ?>. <?= $ques->Question ?> </h6>
                        <?php foreach ($ques->AnswerChoices as $choice) : ?>
                            <div class="d-flex my-2 ml-5" style="margin-left: 20px;">
                                <div class="form-check d-flex">
                                    <input class="form-check-input questions_data" type="radio" name="question_<?= $ques->question_id ?>" data-group_id="<?= $all->group_id ?>" data-qid="<?= $ques->question_id ?> " id="question_<?= $ques->question_id ?>_<?= $choice->id ?>" value="<?= $choice->id ?>" data-secret=" <?= $choice->IsCorrect ? 1 : 0 ?>">
                                    <label class="form-check-label" for="question_<?= $ques->question_id ?>_<?= $choice->id ?>">
                                        <?= $choice->Choices ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <br>
        <div class="card p-5 mb-5" style="display: none;" id="times_up_display">
            <center>
                <h5 style="display: none;" id="times_up_message">Time is Up!</h5>
                <button class="btn btn-primary btn-lg " id="submit_exam">Submit Part <?= $part ?> Exam </button>
            </center>
        </div>
    </div>
    <script>
        var base_url = `<?= base_url() ?>`;
    </script>
    <script src="./assets/JobApp/js/mdbbootstrap.min.js"></script>
    <script src="./assets/JobApp/js/jquery_ajax.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var part = `<?= $part ?>`;
            var timer = `<?= $timer ?>`;
            var applicant_id = `<?= isset($_SESSION['applicant_username']) ? $_SESSION['applicant_username'] : '' ?>`;
            // var data_part = `<?= $data_part ?>`;
            //count display

            if (localStorage.getItem("btoa_" + part + "_" + applicant_id) !== null) {
                var timer = localStorage.getItem("btoa_" + part + "_" + applicant_id);
                $("#countdown").text('__:__');
            }

            if (localStorage.getItem("part_" + applicant_id + '_' + part) !== null) {
                var data = JSON.parse(localStorage.getItem("part_" + applicant_id + '_' + part));

                $.each(data, function(key, val) {
                    var qid = val.question_id.replace(/\s/g, '');
                    $('#question_' + qid + '_' + val.value).prop('checked', true);
                });

                // if timer is 1 then display time is up
                if (timer == 1) {
                    $('#times_up_display').show();
                    $('#question_start_btn').hide();
                    $('#times_up_message').hide();
                } else {
                    examTimer(timer);
                    $('#question_display').show();
                    $('#question_start_btn').hide();
                    $('#applicant_info').hide();
                    collectingData()
                }
            }

            $(document).on('click', '.applicant_logout', function(e) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Logout!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = base_url + 'exam-logout/applicant';
                    }
                })

            })
            $(document).on('click', '#start_exam', function(e) {
                $('#question_display').show();
                $('#question_start_btn').hide();
                $('#applicant_info').hide();
                $('#times_up_display').show();
                examTimer(timer);
            })
            $(document).on('click', '#reload', function(e) {
                location.reload();
            })


            $(document).on('click', '.questions_data', function(e) {
                collectingData();
            })

            $(document).on('click', '#submit_exam', function(e) {
                var data = JSON.parse(localStorage.getItem("part_" + applicant_id + '_' + part));
                var check_data = JSON.stringify(data)
                var count = Object.keys(data).length;

                console.log(count)
                if (check_data == '{}' || count < 5) {
                    var answer_count = count == 0 ? 'No' : 'Only ' + count;
                    var answer_display = count == 0 ? 'Answer' : 'Answers';

                    alert(`${answer_count} ${answer_display} found Please retake`);
                    localStorage.removeItem("part_" + applicant_id + '_' + part);
                    localStorage.removeItem("btoa_" + part + "_" + applicant_id);
                    location.reload();
                    return false;
                }

                Swal.fire({
                    title: 'Confirmation',
                    text: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).attr('disabled', 'disabled');
                        $(this).hide();
                        storeAnswer();
                    }
                });
            })

            function examTimer(time) {
                var countdown = time; // Set the countdown duration in seconds (10 minutes)
                // Update the countdown every second
                var interval = setInterval(function() {
                    if (countdown > 0) {
                        var minutes = Math.floor(countdown / 60);
                        var seconds = countdown % 60;

                        localStorage.setItem("btoa_" + part + "_" + applicant_id, countdown);
                        $("#countdown").text(minutes + ":" + (seconds < 10 ? "0" : "") + seconds);
                        countdown--;
                    } else {
                        clearInterval(interval);
                        $('#question_display').hide();

                        collectingData()
                        $('#times_up_message').show();
                        $('#times_up_display').show();
                        // alert('Time is up!');
                    }
                }, 1000);
            }

            function collectingData() {
                var obj = {};
                var count_item = 0;
                var count_answer = 0;
                $('.questions_data').each(function() {
                    var qid_color = $(this).data('qid');
                    if ($(this).is(':checked')) {
                        count_answer++;
                        var secret = $(this).data('secret');
                        var qid = $(this).data('qid');
                        var ans = $(this).val();
                        var group_id = $(this).data('group_id');
                        obj[qid] = {
                            isCorrect: secret,
                            value: ans,
                            question_id: qid,
                            applicant_id: applicant_id,
                            group_id: group_id
                        };
                        $('.question_color_' + qid_color).addClass('answered_display');
                    }
                })
                $('.question_display_count').each(function() {
                    count_item++
                })
                console.log(count_answer, count_item)
                if (count_answer == count_item) {

                    $('#times_up_display').show();
                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 100);
                }
                $('#item_display').text(count_answer + '/' + count_item)
                localStorage.setItem("part_" + applicant_id + '_' + part, JSON.stringify(obj));
            }
            // Function to show loading spinner
            function showLoading() {
                Swal.fire({
                    title: 'Storing Answer Please wait...',
                    html: '<div class="spinner-border" role="status"></div>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
            }

            // Function to send AJAX request
            function sendAjaxRequest(url, data, successCallback, errorCallback) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: successCallback,
                    error: errorCallback,
                });
            }
            // Function to store answer
            function storeAnswer() {
                showLoading(); // Show loading spinner
                var url = base_url + 'store-exam-answer';
                var formData = new FormData();
                var data = JSON.parse(localStorage.getItem("part_" + applicant_id + '_' + part));

                formData.append('data', JSON.stringify(data));
                formData.append('_cmcToken', $(`meta[name="_cmcToken"]`).attr("content"));
                formData.append('part', part);
                sendAjaxRequest(url, formData, function(result) {
                    if (result == 1) {
                        $('#times_up_display').show();
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your message here',
                            icon: 'success',
                        });
                        localStorage.removeItem("part_" + applicant_id + '_' + part);
                        localStorage.removeItem("btoa_" + part + "_" + applicant_id);
                        setInterval(function() {
                            location.reload();
                        }, 1500)
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong',
                            icon: 'error',
                        });
                        $('#submit_exam').removeAttr('disabled');
                    }

                }, function(xhr, status, error) {
                    alert('Problem occurred. Please try to refresh the page.');
                    console.error('Ajax request error:', error);
                });
            }
        });
    </script>

</body>

</html>