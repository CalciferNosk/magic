<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Motortrade Raffle</title>
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">


    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        bodY {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .center {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 2px !important;
            height: fit-content;
            /* background: #000; */
        }

        .wave {
            width: 5px;
            height: 100px;
            background: linear-gradient(45deg, cyan, #fff);
            margin: 10px;
            animation: wave 1s linear infinite;
            border-radius: 20px;
        }

        .wave:nth-child(2) {
            animation-delay: 0.1s;
        }

        .wave:nth-child(3) {
            animation-delay: 0.2s;
        }

        .wave:nth-child(4) {
            animation-delay: 0.3s;
        }

        .wave:nth-child(5) {
            animation-delay: 0.4s;
        }

        .wave:nth-child(6) {
            animation-delay: 0.5s;
        }

        .wave:nth-child(7) {
            animation-delay: 0.6s;
        }

        .wave:nth-child(8) {
            animation-delay: 0.7s;
        }

        .wave:nth-child(9) {
            animation-delay: 0.8s;
        }

        .wave:nth-child(10) {
            animation-delay: 0.9s;
        }

        @keyframes wave {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1);
            }

            100% {
                transform: scale(0);
            }
        }

        .buttons-excel:hover,
        .buttons-csv:hover,
        .buttons-pdf:hover {
            background-color: #3c8dbc;
            color: yellow;

        }

        .buttons-excel,
        .buttons-csv,
        .buttons-pdf {
            border: 1px solid whitesmoke;
            border-radius: 5px;

        }

        .tr-row {
            background-color: whitesmoke !important;
            font-size: 15px;
        }

        .tr-row:hover {
            background-color: #3c8dbc !important;
            color: yellow;
        }

        #winner-table_filter {
            padding-right: 41px;
            padding-bottom: 5px;
        }

        #winner-table_info {
            padding-left: 41px;
            padding-bottom: 5px;
        }

        #winner-table_paginate {
            padding-right: 40%;
        }

        #winner-table_length {
            padding-left: 41px;
            padding-bottom: 5px;
        }

        .dt-button {
            margin-left: 41px;
            vertical-align: 20px;

        }

        li {
            font-weight: 500;
            line-height: 20px;
        }

        .reset-button {
            width: 200px;
            justify-content: end;
            cursor: not-allowed ! important;
        }

        b {
            font-family: 'Source Sans Pro', sans-serif;
        }
    </style>
</head>

<body>
    <div>
        <header id="navbar" class="navbar navbar-expand-lg" style="background: #24388e !important;">

            <h4 style="color:yellow;padding-left:20px">e-Raffle (Confidential)</h4>



        </header>
        <div class="card m-2 p-3">
            <div class="row">

                <ul style="list-style-type:none;">
                    <li><b>Qualified Employee:</b> <?= $info->employee ?></li>
                    <li><b>No. of Prizes: </b><?= $info->prize ?></li>
                    <li><b>Last Run: </b><?= $info->date == null ? '--' : $info->date ?></li>
                </ul>
                <?php
                if ($result == 0) : ?>
                    <button type="button" class="btn btn-primary" style="width: 150px;" data-toggle="modal" data-target="#exampleModal" id="resultbtn">
                        Run
                    </button>
                <?php else : ?>
                    <span style="display: inline-flex;">
                        <button class="btn btn-danger reset-button" title="Only Authorized person can Reset result" style="width:100px"> Reset</button>
                        &nbsp;
                        <button type="button" class="btn btn-primary" id="view-result" id="resultbtn">
                            View Result
                        </button>
                        &nbsp;
                        <button type="button" class="btn btn-primary" id="view-table" style="display: none;">view by table</button>
                        <!-- &nbsp;
                        <button type="button" class="btn btn-primary" id="view-list" style="display: none;">view by list</button> -->
                    </span>
                <?php endif; ?>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Enter Authentication Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- view result -->
                            <div class="modal-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
                                    </div>
                                    <input type="password" class="form-control" aria-label="Default" id="password-run" aria-describedby="inputGroup-sizing-default">

                                </div>
                                <p id="pass-error" style="display: none;" class="alert alert-danger mt-1">password incorrect</p>
                            </div>
                            <!-- view result end -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="draw-raffle">proceed</button>
                            </div>
                        </div>
                    </div>
                </div>



                <p id="reset-label" style="display: none;" class="alert alert-danger mt-1">Only Authorized person can reset the result <a href="">x</a></p>
            </div>
        </div>
    </div>
    <div class="row" id="buttons-raffle">
        <center class="loading text-loading" style="display:none;padding-top:15%">GENERATING RAFFLE. . .</center>
        <div class="center loading" style="display:none;">
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
    </div>
    <div class="row card m-5 p-2" style="display:none;" id="data-raffle">
        <h2>Result of Last Run</h2>
        <table id="winner-table" class="table " style="width:95%;background-color: #3c8dbc !important;">
            <thead>
                <tr>
                    <th>Employee Code</th>
                    <th>Name</th>
                    <th>Employment Status</th>
                    <th>Date Hired</th>
                    <th>Prize Name</th>
                    <th>Prize Type</th>
                    <th>Org Group</th>

                </tr>
            </thead>
            <tbody id="winner-data">

            </tbody>

        </table>
    </div>
    <div class="row card p-2 m-5" style="display:none;" id="data-list">
        <h3>list</h3>
    </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var base_url = '<?php echo base_url(); ?>';
        $(document).ready(function() {
            $('#password-run').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    $('#view-result').click();
                }
            })

            $('#draw-raffle').on('click', function(e) {

                e.preventDefault();
                var pass = $('#password-run').val();
                if (pass == 'adminhr') {
                    $('.close').click()
                    $('#resultbtn').text('running...')
                    $('#resultbtn').attr('disabled', true)
                    $('#pass-error').css('display', 'none')
                    $.ajax({
                        url: base_url + 'draw-raffle',
                        method: 'POST',
                        data: {
                            data: 1,
                            _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                        },
                        success: function(data) {
                            $('#buttons-raffle').css('display', 'none')
                            location.reload();
                        }
                    });

                } else {
                    $('#pass-error').css('display', 'block')
                    return false
                }
                $('.loading').css('display', 'inline-flex')
                $('#draw-raffle').css('display', 'none')
                $('.text-loading').css('display', 'block')

            })

            $('#view-result').on('click', function() {
                $('#winner-data').html('')
                var pass = $('#password-run').val();

                getdata();

                $('.reset-button').on('click', function() {
                    $('#reset-label').css('display', 'block')
                })


                function getdata() {
                    $('#resultbtn').attr('disabled', true)
                    $('#view-result').attr('disabled', true)
                    // $('#buttons-raffle').css('display', 'none')
                    $.ajax({
                        url: base_url + 'RaffleController/viewWinner',
                        method: 'POST',
                        data: {
                            data: 1,
                            _cmcToken: $(`meta[name="_cmcToken"]`).attr("content")
                        },
                        dataType: 'json',
                        success: function(data) {

                            var win = data.winner;
                            var tr = [];
                            $.each(win, function(k, v) {
                                tr.push(`<tr class="tr-row">
                                <td>${v.code}</td>
                                <td>${v.name}</td>
                                <td>${v.employmentstatus}</td>
                                <td>${v.datehired}</td>
                                <td>${v.prizename}</td>
                                <td>${v.prizetype}</td>
                                <td>${v.orggroup}</td>
                                </tr>`)
                            })
                            $('#winner-data').html(tr)
                            $('#winner-table').DataTable({
                                dom: 'Bftip',
                                buttons: true,
                                buttons: [

                                    {
                                        extend: 'csvHtml5',
                                        text: 'Download CSV <i class="fa fa-download" style="font-size:24px"></i>',
                                        titleAttr: 'CSV'
                                    }
                                ]
                            });

                            $('#data-raffle').css('display', 'block')
                            $('#view-list').css('display', 'block');




                        }
                    });
                    $('#view-list').on('click', function() {
                        $('#data-list').css('display', 'block')
                        $('#data-raffle').css('display', 'none');
                        $('#view-list').css('display', 'none');
                        $('#view-table').css('display', 'block')

                    })
                    $('#view-table').on('click', function() {
                        $('#data-list').css('display', 'none')
                        $('#data-raffle').css('display', 'block');
                        $('#view-list').css('display', 'block');
                        $('#view-table').css('display', 'none')

                    })




                }


            })
        })
    </script>

</body>

</html>