<?php 
    if(!$is_mobile){
        echo "<center><h1>charaannnnnn!!! Magic</h1></center>";
        exit;
    }
?>

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
    <link href="<?= base_url() ?>assets/template_cdn/css/warehouse-mdb.kit.min.css" rel="stylesheet" />
    <title>Document</title>
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            margin: 30px auto;
            padding: 24px 18px;
            max-width: 420px;
        }

        h3 {
            color: #3b82f6;
            font-weight: 700;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
        }

        td {
            padding: 8px 0;
        }

        label {
            font-weight: 500;
            color: #374151;
        }

        input[type="date"],
        input[type="number"] {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 8px;
            margin-top: 4px;
        }

        #magic-message {
            display: inline-block;
            margin-top: 10px;
            color: #10b981;
            font-weight: 600;
        }

        .btn {
            min-width: 90px;
            margin: 4px 2px;
            border-radius: 8px;
            font-size: 1rem;
        }

        .btn-primary {
            background: #3b82f6;
            border: none;
        }

        .btn-danger {
            background: #ef4444;
            border: none;
        }

        .btn-info {
            background: #06b6d4;
            border: none;
        }

        .mt-2 {
            margin-top: 8px !important;
        }

        @media (max-width: 600px) {
            .container {
                max-width: 98vw;
                padding: 12px 4vw;
                margin: 16px auto;
            }

            table,
            tr,
            td {
                display: block;
                width: 100%;
            }

            td {
                padding: 6px 0;
            }

            .btn {
                width: 100%;
                margin: 6px 0;
            }

            .hour_click,
            .minute_click {
                width: 30vw;
                min-width: unset;
            }
        }

        /* Extra touch for mobile */
        .hour_click,
        .minute_click {
            font-size: 1.05rem;
            font-weight: 500;
        }

        #test-message {
            font-size: 0.95rem;
            color: #6366f1;
        }
    </style>
</head>

<body>

<div>
    <input type="text" class=   "form-control" id="magic_token" placeholder="Enter Token">
</div>

<div id="content_mag" style="display: none;">


    <div class="container" style="box-shadow:none;background:transparent;padding:0;">
        <button class="btn btn-primary" id="test-connect">Test</button>
        <span id="test-message"></span>
    </div>
    <div class="container">
        <center>
            <button class="btn btn-danger" id="magic_reset">Magic Reset</button>
        </center>
    </div>

    <!-- Tabs navs -->
    <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
            <a
                data-mdb-tab-init
                class="nav-link active"
                id="ex2-tab-1"
                href="#ex2-tabs-1"
                role="tab"
                aria-controls="ex2-tabs-1"
                aria-selected="true">HOME</a>
        </li>
        <li class="nav-item" role="presentation">
            <a
                data-mdb-tab-init
                class="nav-link"
                id="ex2-tab-2"
                href="#ex2-tabs-2"
                role="tab"
                aria-controls="ex2-tabs-2"
                aria-selected="false">Set Appointment</a>
        </li>

    </ul>
    <!-- Tabs navs -->

    <!-- Tabs content -->
    <div class="tab-content" id="ex2-content">
        <div
            class="tab-pane fade show active"
            id="ex2-tabs-1"
            role="tabpanel"
            aria-labelledby="ex2-tab-1">
            <div class="container">
                <center>
                    <h3>hokus pokus</h3>
                </center>
                <div style="display: flex; gap: 12px; justify-content: center; align-items: flex-end; flex-wrap: wrap;">
                    <div style="flex: 1 1 100px; min-width: 90px;">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div style="flex: 1 1 70px; min-width: 70px;">
                        <label for="hours">Hour</label>
                        <input type="number" id="hours" placeholder="Enter hours" min="0" max="23">
                    </div>
                    <div style="flex: 1 1 70px; min-width: 70px;">
                        <label for="minutes">Min</label>
                        <input type="number" name="min" id="minutes" placeholder="Enter minutes" min="0" max="59">
                    </div>
                </div>

                <br>
                <center>
                    <button class="btn btn-primary" id="magic_now">Magic</button>
                    <div>
                        <span id="magic-message">magic message</span>
                    </div>
                </center>
            </div>

            <div class="container">
                <div style="max-width: 260px; margin: 0 auto;">
                    <label style="font-weight:600;">Remote Control</label>
                    <div style="background:#f1f5f9;border-radius:18px;padding:18px 12px;box-shadow:0 2px 12px rgba(0,0,0,0.07);display:flex;flex-direction:column;align-items:center;gap:16px;">
                        <!-- Hour Buttons -->
                        <div>
                            <label style="font-size:0.98rem;">Hour</label>
                            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:6px;">
                                <button class="hour_click btn btn-info" data-hrs="06">6 AM</button>
                                <button class="hour_click btn btn-info" data-hrs="07">7 AM</button>
                                <button class="hour_click btn btn-info" data-hrs="08">8 AM</button>
                                <button class="hour_click btn btn-info" data-hrs="17">5 PM</button>
                                <button class="hour_click btn btn-info" data-hrs="18">6 PM</button>
                                <button class="hour_click btn btn-info" data-hrs="19">7 PM</button>
                            </div>
                        </div>
                        <!-- Minute Buttons -->
                        <div>
                            <label style="font-size:0.98rem;">Minute</label>
                            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:6px;">
                                <button class="minute_click btn btn-info" data-min="02">02</button>
                                <button class="minute_click btn btn-info" data-min="03">03</button>
                                <button class="minute_click btn btn-info" data-min="04">04</button>
                                <button class="minute_click btn btn-info" data-min="05">05</button>
                                <button class="minute_click btn btn-info" data-min="06">06</button>
                                <button class="minute_click btn btn-info" data-min="07">07</button>
                                <button class="minute_click btn btn-info" data-min="08">08</button>
                                <button class="minute_click btn btn-info" data-min="30">30</button>
                                <button class="minute_click btn btn-info" data-min="31">31</button>
                                <button class="minute_click btn btn-info" data-min="32">32</button>
                                <button class="minute_click btn btn-info" data-min="33">33</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div
            class="tab-pane fade"
            id="ex2-tabs-2"
            role="tabpanel"
            aria-labelledby="ex2-tab-2">
            <div class="container">
                <center>
                    <h3>Set Appointment</h3>
                </center>
                <form id="appointment-form">
                    <table>
                        <tr>
                            <td><label for="app_date">Date</label></td>
                            <td><input type="date" class="form-control" id="app_date" name="app_date" value="<?= date('Y-m-d') ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="app_hour">Hour</label></td>
                            <td><input type="number" class="form-control" id="app_hour" name="app_hour" min="0" max="23" placeholder="Hour"></td>
                        </tr>
                        <tr>
                            <td><label for="app_minute">Minute</label></td>
                            <td><input type="number" class="form-control" id="app_minute" name="app_minute" min="0" max="59" placeholder="Minute"></td>
                        </tr>
                    </table>
                    <br>
                    <center>
                        <button type="button" class="btn btn-primary" id="generate-btn">Generate</button>
                        <hr>
                        <h3>GENERATED APPOINTMENT</h3>
                        <div id="generate-div">

                        </div>
                    </center>
                </form>
            </div>

        </div>

    </div>
    <!-- Tabs content -->
    </div>
    <script src="./assets/JobApp/js/mdbbootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var base_url = "<?= base_url(); ?>";
        $(document).ready(function() {
            $(document).on('blur','#magic_token', function() {
                var m_token = $(this).val();
                if (validateToken(m_token)) {
                    $('#content_mag').show();
                } else {
                    $('#content_mag').hide();
                }
            });
            $(document).on('click', '.hour_click', function() {
                var hours = $(this).attr('data-hrs');
                $('#hours').val(hours);
            })
            $(document).on('click', '.minute_click', function() {
                var minutes = $(this).attr('data-min');
                $('#minutes').val(minutes);
            })
            $(document).on('click', '#magic_now', function() {
                  var m_token = $('#magic_token').val();
                var valid = validateToken(m_token);
                if (!valid) {
                    $('#magic-message').text('Invalid Token');
                    return false;
                }
                
                var date = $('#date').val();
                var hours = $('#hours').val();
                var minutes = $('#minutes').val();
                // alert(hours, minutes);
                if (hours == '' || minutes == '') {
                    $('#magic-message').text('Please enter hours and minutes');
                    return false;
                }
                $('#magic-message').text('Please wait...');
                $.ajax({
                    url: base_url + 'magic-now',
                    method: "POST",
                    data: {
                        date: date,
                        hours: hours,
                        minutes: minutes,
                        _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                    },
                    dataType: "JSON",
                    success: function(data) {
                        location.reload();
                        // $('#magic-message').text(data.display);
                    }
                })
            })
            $(document).on('click', '#magic_reset', function() {
                
                $.ajax({
                    url: base_url + 'magic-reset',
                    method: "POST",
                    data: {
                        reset: 1,
                        _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                    },
                    dataType: "JSON",
                    success: function(data) {
                        location.reload();
                    }
                })
            })
            $(document).on('click', '#test-connect', function() {
                  var m_token = $('#magic_token').val();
                 var valid = validateToken(m_token);
                 console.log(valid);
                if (!valid) {
                     $('#test-message').html('Invalid Token');
                    return false;
                }
                $('#test-message').html("Connecting Please wait...");
                $.ajax({
                    url: base_url + 'magic-test',
                    method: "POST",
                    data: {
                        _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('#test-message').html(data.mssg);
                    }
                })
            })

            $('#generate-btn').on('click', function() {
                var date = $('#app_date').val();
                var hr = $('#app_hour').val();
                var min = $('#app_minute').val();
                if (date == '' || min == '' || hr == '') {
                    return false;
                }
                var button = `<buttontype="button" class="btn btn-primary generate_app" data-date="${date}" data-hr="${hr}" data-min="${min}"  >${date} ${hr}:${min}</button>`;
                $('#generate-div').append(button);
            });

            function validateToken(token){
            token = token.toLowerCase();
            if(token == ''){
                return false;
            }
            token = btoa(token);
            console.log(token);

            if(token == 'c3BlY3Rv' || token == 'bWFnaWNhZGFkbWlu'){
                return true;
            }
            else{
                return false;
            }
        }
            $(document).on('click', '.generate_app', function() {
                var date = $(this).attr('data-date');
                var hr = $(this).attr('data-hr');
                var min = $(this).attr('data-min');
                if (date == '' || min == '' || hr == '') {
                    return false;
                }
                $('#app_date').val(date);
                $('#app_hour').val(hr);
                $('#app_minute').val(min);

                $.ajax({
                    url: base_url + 'magic-now',
                    method: "POST",
                    data: {
                        date: date,
                        hours: hr,
                        minutes: min,
                        _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                    },
                    dataType: "JSON",
                    success: function(data) {
                        location.reload();
                        // $('#magic-message').text(data.display);
                    }
                })
            });
        })
    </script>
</body>

</html>