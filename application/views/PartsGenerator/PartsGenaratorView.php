<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parts Generator</title>
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .form-outline {
            border: 1px solid #ced4da;
            border-radius: 7px;
        }

        .parts-details-print {
            font-size: 6px;
        }

        .info-customer {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="container" id="display-parts">
        <div class="d-flex justify-content-center card p-5">
            <div class="row">
                <div>
                    <button class="btn btn-primary" id="btnPrint" style="display: none;">Print</button>
                </div>
                <div class="col-md-6">

                    <div class="row mb-4">
                        <label for="">Customer Information</label>
                        <div class="col">
                            <div data-mdb-input-init class="form-outline">
                                <input type="text" id="fname" class="form-control" />
                                <label class="form-label" for="form3Example1">First Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div data-mdb-input-init class="form-outline">
                                <input type="text" id="lname" class="form-control" />
                                <label class="form-label" for="form3Example2">Last Name</label>
                            </div>
                        </div>
                    </div>
                    <div data-mdb-input-init class="form-outline">
                        <input type="text" id="contact" class="form-control" />
                        <label class="form-label" for="engine">Contact Number</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mt-4">
                        <select name="" id="mc" class="form-control select2" style="border: 1px solid #ced4da;">
                            <option value="" selected disabled>Motorcycle Unit</option>
                            <?php foreach ($mc_list as $key => $mc) : ?>
                                <option value="<?= $mc['MCModel'] ?>"><?= $mc['MCModel'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <br>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="engine" class="form-control" />
                        <label class="form-label" for="">Engine Number</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="service-date" class="form-control" onFocus="this.type='date'" onblur="this.type='text'" />
                        <label class="form-label" for="">Service Date</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="number" id="kpr" class="form-control" />
                        <label class="form-label" for="kpr">Kilometer Per Reading</label>

                    </div>
                </div>
            </div>

            <div class="row m-5">
                <h3>Parts List</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Parts Count</th>
                            <th>PARTS FOR REPLACEMENT</th>
                            <th>PART NUMBER</th>
                            <th>PRICE</th>
                            <th>QTY</th>
                            <th>Total Price</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id='generated-list'>
                        <tr>
                            <td colspan="6" class="text-center">Please Select MC and KPR</td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row m-5">
                <h3>Job Order Rate</h3>
                <table class="table display">
                    <thead>
                        <tr>
                            <th>Job Order</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="jobRateData">
                        <td colspan="6" class="text-center">Please Select MC and KPR</td>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <span id="landscape"></span>
    <div class="container mt-3" id="print-display" style="display: none ;">
        <div class="d-flex justify-content-center">
            <div class="card" style="width: 30rem;">
                <div class="card-body" style="padding: unset">
                    <h5 class="card-title p-3" style="background-color: #23378d;"><img style="width: 100%;" src="<?= base_url() ?>assets/PartsGenerator/img/header.png" alt=""></h5>
                    <table style="width: 100%;margin:5px !important">
                        <tr>
                            <td class="info-customer">Customer Name: <u><span id="customerName"></span></u></td>
                            <td class="info-customer">Engine Number: <u><span id="engineNumber"></span></u></td>
                        </tr>
                        <tr>
                            <td class="info-customer">Contact Number: <u><span id="contactNumber"></span></u></td>
                            <td class="info-customer">Sevice Date: <u><span id="serviceDate"></span></u></td>
                        </tr>
                        <tr>
                            <td class="info-customer">Motorcycle Unit: <u><span id="motorcycleUnit"></span></u></td>
                            <td class="info-customer">Kilometer Per Reading: <u><span id="kilometerPerReading"></span></u></td>
                        </tr>
                    </table>
                    <div style="padding: 5px 5px 5px 5px;">
                        <table class="display" style="width: 100%;  margin:20px !important">
                            <thead>
                                <tr>

                                    <th class="parts-details-print">PARTS FOR REPLACEMENT</th>
                                    <th class="parts-details-print">PART NUMBER</th>
                                    <th class="parts-details-print">PRICE</th>
                                    <th class="parts-details-print">Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="print-parts">

                            </tbody>
                        </table>

                    </div>
                    <div style="padding: 7px 125px 15px 25px;">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="parts-details-print">Job Order</th>
                                    <th class="parts-details-print">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="jobRateData-print">
                                <td colspan="6" class="text-center">Please Select MC and KPR</td>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center" style="padding-left: 40px;padding-right: 40px">
                        <Table style="width: 100%;">
                            <tr>
                                <td class="parts-details-print ">Total Parts Cost</td>
                                <td class="parts-details-print "><u>&nbsp;&nbsp;&nbsp;<span id="totalPartsCost">1111</span>&nbsp;&nbsp;&nbsp;</u></td>
                            </tr>
                            <tr>
                                <td class="parts-details-print ">Total Labor Cost</td>
                                <td class="parts-details-print ';"><u>&nbsp;&nbsp;&nbsp;<span id="totalLaborCost">111</span>&nbsp;&nbsp;&nbsp;</u></td>
                            </tr>
                        </Table>
                    </div>
                    <br>
                    <div style="border-top: 2px solid black;border-bottom: 2px solid black;font-size: 14px">
                        <p style="margin-left: 20px;margin-right: 20px; margin-top: 3px; margin-bottom: 3px;font-weight: bold">TOTAL ESTIMATED COST:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ₱ <span id="totalCost"></span> </p>
                    </div>
                    <div style="margin: 0px 10px 0px 10px;">
                        &nbsp;<span class="parts-details-print" style="white-space: initial; margin-left: 10px">General Remaks :</span>
                        <span class="parts-details-print">
                           ________________________________________________________________________________________________________________________________________
                        </span>
                        <span class="parts-details-print" style="margin-left: 10px;">
                           ____________________________________________________________________________________________________________________________________________________________
                        </span>
                     
                    </div>
                    <div class="m-2 d-flex justify-content-center" style="margin:0px 10px 0px 16px !important">
                        <table style="width: 90%;" >
                            <tr>
                                <td class="parts-details-print ">Recommended by:</td>
                                <td class="parts-details-print ">Noted by:</td>
                                <td class="parts-details-print ">Acknowledged by:</td>
                            </tr>
                        </table>

                    </div>
                    <div class="m-3 d-flex justify-content-center">
                        <table style="width: 100%;">
                            <tr>
                                <td class="parts-details-print">
                                    <center>______________________________</center>
                                </td>
                                <td class="parts-details-print">
                                    <center>______________________________</center>
                                </td>
                                <td class="parts-details-print">
                                    <center>______________________________</center>
                                </td>
                                <td class="parts-details-print"> &nbsp;</td>
                                <td class="parts-details-print">
                                    <center>______________________________</center>
                                </td>
                            </tr>
                            <tr>
                                <td class="parts-details-print">
                                    <center>Service Adviser</center>
                                </td>
                                <td class="parts-details-print">
                                    <center>Mechanic</center>
                                </td>
                                <td class="parts-details-print">
                                    <center>Parts Custodian</center>
                                </td>
                                <td class="parts-details-print">
                                    <center>&nbsp;
                                </td>
                                <td class="parts-details-print">
                                    <center>Customer</center>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="parts-details-print" style="margin:10px;border:1px solid black;border-style: dotted;padding:5px;">
                        <p class="parts-details-print" style="font-weight: bold;margin:unset;">FOR SERVICE APPOINTMENT, YOU MAY CALL OR TEXT:</p>
                        <span class="parts-details-print">Service Adviser: ______________________________</span>
                        <span class="parts-details-print"> Cellphone Number:: ______________________________</span>
                    </div>
                    <div class="parts-details-print m-2">
                        <span>Note that labor and parts cost may be over/under the estimated cost above depending on actual service done. Above quoted prices are subject to change without prior notice. This estimate expires 30 DAYS from date of quotation request.</span>
                    </div>
                    <div style="background-color: #23378d;">
                        <center>
                            <img style="width: 100%;" src="<?= base_url() ?>assets/PartsGenerator/img/footer.png" alt="">
                        </center>
                    </div>
                </div>
            </div>
            <!-- <div class="card " style="width: 30rem; margin-left: 20px;">
                <div class="card-body" style="padding: unset">
                    <h5 class="card-title p-3" style="background-color: #23378d;"><img style="width: 25%;" src="<?= base_url() ?>assets/PartsGenerator/img/header.png" alt=""></h5>
                    <div class="p-3 m-3">
                     
                    </div>

                </div>
            </div> -->
        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            var base_url = '<?= base_url() ?>';
            $('.select2').select2();

            $(document).on('keyup', '#kpr', function() {
                var kpr = $('#kpr').val();
                var len = kpr.length;
                var mc = $('#mc').val();
                if (mc == null) {
                    return false;
                }
                if (len >= 3) {
                    getPartsList(kpr, mc);
                }
            });

            $(document).on('change', '#mc', function() {
                var kpr = $('#kpr').val();
                var len = kpr.length;
                var mc = $('#mc').val();
                if (len == '') return false;
                if (len >= 3) {
                    getPartsList(kpr, mc);
                } else {
                    return false;
                }
            })
            $(document).on('click', '#btnPrint', function() {


                var fname = $('#fname').val();
                var lname = $('#lname').val();
                var kpr = $('#kpr').val();
                var mc = $('#mc').val();
                var servicedate = $('#service-date').val();
                var contact = $('#contact').val();
                var engine = $('#engine').val();

                if (fname == '' || lname == '' || kpr == '' || mc == null || servicedate == '' || contact == '' || engine == '') {
                    alert('Please Fill All Fields');
                    return false
                }
                $('#customerName').text(lname + ', ' + fname);
                $('#contactNumber').text(contact);
                $('#motorcycleUnit').text(mc);
                $('#engineNumber').text(engine);
                $('#serviceDate').text(servicedate);
                $('#kilometerPerReading').text(kpr);
                //$('#landscape').html(`<style type="text/css" media="print">@page { size: landscape; }</style>`)
                $('#display-parts').hide();
                $('#print-display').show();
                $('.parts-details').addClass('parts-details-print', true)
                window.print();
                // $('#landscape').html(``)
                // $('#display-parts').show();
                // $('#print-display').hide();
                // $('.parts-details').addClass('parts-details-print', true)
            })

            function getPartsList(kpr, mc) {

                $.ajax({
                    url: base_url + "get-parts-list",
                    method: "post",
                    data: {
                        kpr: kpr,
                        mc: mc,
                        _cmcToken: $(`meta[name="_cmcToken"]`).attr("content"),
                    },
                    dataType: "json",
                    success: function(response) {
                        var partslist = response.parts;
                        var joborder = response.rate;
                        var jo_tr = '';
                        var jo_total = 0;
                        var tr = '';
                        var total = 0;
                        var full_total = 0;
                        if (partslist != []) {

                            $.each(partslist, function(index, value) {
                                total = value.Price * value.Quantity;
                                full_total += total
                                tr += `<tr>
                                        <td >${index+1}</td>
                                        <td >${value.PartDescription}</td>
                                        <td >${value.PartNumber}</td>
                                        <td >${value.Price}</td>
                                        <td >${value.Quantity}</td>
                                        <td >${total}</td>
                                        <td ><center>--</center></td>
                                        </tr>`;
                            })
                            tr += `<tr>
                                    <td colspan="5" class="text-center"><b>Total</b></td>
                                    <td><b>${full_total}</b></td>
                                    <td><center>--</center></td>
                                   </tr> `

                            $.each(joborder, function(i, v) {
                                jo_total += +v.Price
                                jo_tr += `<tr>
                                            <td>${v.JobTitle}</td>
                                            <td>${v.Price}</td>
                                          </tr>`;
                            })
                            jo_tr += `<tr>
                                            <td  class="text-center"><b>Total</b></td>
                                            <td><b>${jo_total}</b></td>
                                         </tr>`;

                            $('#generated-list').html(tr)
                            $('#jobRateData').html(jo_tr)


                            // print area

                            var tr_print = '';
                            $.each(partslist, function(index_print, value_print) {
                                tr_print += `<tr>
                                       
                                        <td class="parts-details">${value_print.PartDescription}</td>
                                        <td class="parts-details">${value_print.PartNumber}</td>
                                        <td class="parts-details">${value_print.Price}</td>
                                        <td class="parts-details"><center>--</center></td>
                                        </tr>`;
                            })
                            var jo_tr_print = '';
                            $.each(joborder, function(i, v) {

                                jo_tr_print += `<tr>
                                            <td class="parts-details-print">${v.JobTitle}</td>
                                            <td class="parts-details-print">${v.Price}</td>
                                          </tr>`;
                            })
                            $('#totalPartsCost').text('₱ ' + full_total.toFixed(2).toLocaleString());
                            $('#totalLaborCost').text('₱ ' + jo_total.toFixed(2).toLocaleString())
                            $('#print-parts').html(tr_print)
                            $('#jobRateData-print').html(jo_tr_print)
                            $('#totalCost').text((full_total + jo_total).toFixed(2).toLocaleString());

                            $('#btnPrint').show();

                        }
                    }, //endsucesss
                });



            }
        })
    </script>
</body>

</html>