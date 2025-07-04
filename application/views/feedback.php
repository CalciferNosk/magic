<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/inquiry.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

    for (i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');

      if (sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  };
</script>
<style>
  @import url('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

  .review_section {
    box-sizing: border-box;
    font-family: 'Raleway', sans-serif !important;
    width: 80vw;
    margin: 0 auto;
  }

  .review_section *,
  .review_section *::before,
  .review_section *::after {
    box-sizing: inherit;
  }

  .review_section *:focus,
  .review_section *:active {
    outline: 0 !important;
  }

  .review_section * {
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0) !important;
  }

  .review_section body,
  .review_section td,
  .review_section th,
  .review_section p {
    color: #333;
    font-family: 'Raleway', sans-serif;
  }

  .review_section body {

    margin: 0;
    position: relative;
  }

  .review_section h2 {
    display: inline-block;
  }

  .review_section #review-add-btn {
    padding: 0;
    font-size: 1.6em;
    cursor: pointer;
  }

  /* ====================== Review Form ====================== */
  .review_section #modal {
    /* position: absolute;
  left: 10vh;
  top: 10vh; */
    /* fix exactly center: https://css-tricks.com/considerations-styling-modal/ */
    /* begin css tricks */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    /* end css tricks */
    /* z-index: -10; */
    z-index: 3;
    display: flex;
    flex-direction: column;
    /* width: 80vw; */
    /* height: 80vh; */
    border: 1px solid #666;
    border-radius: 10px;
    opacity: 0;
    transition: all .3s;
    overflow: hidden;
    background-color: #eee;
    /* visibility: hidden; */
    display: none;
  }

  .review_section #modal.show {
    /* visibility: visible;   */
    opacity: 1;
    /* z-index: 10; */
    display: flex;
  }

  .review_section .modal-overlay {
    width: 100%;
    height: 100%;
    z-index: 2;
    /* places the modalOverlay between the main page and the modal dialog */
    background-color: #000;
    opacity: 0;
    transition: all .3s;
    position: fixed;
    top: 0;
    left: 0;
    display: none;
    margin: 0;
    padding: 0;
  }

  .review_section .modal-overlay.show {
    display: block;
    opacity: 0.5;
  }

  .review_section #modal .close-btn {
    align-self: flex-end;
    font-size: 1.4em;
    margin: 8px 8px 0;
    padding: 0 8px;
    cursor: pointer;
  }

  .review_section form {

    padding: 0 20px 20px 20px;
  }

  .review_section input,
  /* input:not(input[type='radio']), */
  /* input:not(type='radio'), */
  .review_section select,
  .review_section .rate,
  .review_section textarea,
  .review_section button {
    background: #f9f9f9;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    box-shadow: inset 0 1px 1px #e1e1e1;
    font-size: 16px;
    padding: 8px;
  }

  .review_section input[type="radio"] {
    box-shadow: none;
    outline: 0 !important;
  }

  .review_section button {
    min-width: 48px;
    min-height: 48px;
  }

  .review_section button:hover {
    border: 1px solid #ccc;
    background-color: #fff;
  }

  .review_section button#review-add-btn,
  .review_section button.close-btn,
  .review_section button#submit-review-btn {
    min-height: 40px;
  }

  .review_section button#submit-review-btn {
    font-weight: bold;
    cursor: pointer;
    padding: 0 16px;
  }

  .review_section .fieldset {
    margin-top: 20px;
  }

  .review_section .right {
    align-self: center;
  }

  .review_section #review-form-container {
    width: 100%;
    /* background-color: #eee; */
    padding: 0 20px 26px;
    color: #333;
    overflow-y: auto;
  }

  .review_section #review-form-container h2 {
    margin: 0 0 0 6px;
  }

  .review_section #review-form {
    display: flex;
    flex-direction: column;
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 4px;
  }

  .review_section #review-form label,
  .review_section #review-form input {
    display: block;
    /* width: 100%; */
  }

  .review_section #review-form label {
    font-weight: bold;
    margin-bottom: 5px;
  }

  .review_section #review-form .rate label,
  .review_section #review-form .rate input,
  .review_section #review-form .rate1 label,
  .review_section #review-form .rate1 input {
    display: inline-block;
  }

  /* Modified from: https://codepen.io/tammykimkim/pen/yegZRw */
  .review_section .rate {
    height: 36px;
    display: inline-flex;
    flex-direction: row-reverse;
    align-items: flex-start;
    justify-content: flex-end;
  }

  .review_section #review-form .rate>label {
    margin-bottom: 0;
    margin-top: -5px;
    height: 30px;
  }

  .review_section .rate:not(:checked)>input {
    /* position: absolute; */
    top: -9999px;
    margin-left: -24px;
    width: 20px;
    padding-right: 14px;
    z-index: -10;
  }

  .review_section .rate:not(:checked)>label {
    float: right;
    width: 1em;
    overflow: hidden;
    white-space: nowrap;
    cursor: pointer;
    font-size: 30px;
    color: #ccc;
  }

  /* #star1:focus{

} */
  .review_section .rate2 {
    float: none;
  }

  .review_section .rate:not(:checked)>label::before {
    content: '★ ';
    position: relative;
    top: -10px;
    left: 2px;
  }

  .review_section .rate>input:checked~label {
    color: #ffc700;
    /* outline: -webkit-focus-ring-color auto 5px; */
  }

  .review_section .rate>input:checked:focus+label,
  .review_section .rate>input:focus+label {
    outline: -webkit-focus-ring-color auto 5px;
  }

  .review_section .rate:not(:checked)>label:hover,
  .review_section .rate:not(:checked)>label:hover~label {
    color: #deb217;
    /* outline: -webkit-focus-ring-color auto 5px; */
  }

  .rate>input:checked+label:hover,
  .rate>input:checked+label:hover~label,
  .rate>input:checked~label:hover,
  .rate>input:checked~label:hover~label,
  .rate>label:hover~input:checked~label {
    color: #c59b08;
  }

  .review_section #submit-review {
    align-self: flex-end;
  }

  .review_section input,
  .review_section textarea {
    width: 100%;
    font-family: 'Raleway', sans-serif;
    font-size: 14px;
  }

  @media only screen and (min-width: 550px) {}





  /*PEN STYLES*/
  .review_section * {
    box-sizing: border-box;
  }

  .blog-card {
    display: flex;
    flex-direction: column;
    margin: 5px 0;
    box-shadow: 0 3px 7px -1px rgba(0, 0, 0, .1);
    margin-bottom: 1.6%;
    background: #fff;
    line-height: 1.4;
    font-family: 'Raleway', sans-serif;
    border-radius: 5px;
    overflow: hidden;
    z-index: 0;
  }

  .blog-card a {
    color: inherit;
  }

  .blog-card .meta {
    position: relative;
    z-index: 0;
    height: 180px;
  }

  .blog-card .photo {
    height: 200px;
    width: 200px;
    margin: 0;
  }


  .blog-card .description {
    padding: 1rem;
    background: #fff;
    position: relative;
    z-index: 1;
  }

  .blog-card .description h1,
  .blog-card .description h2 {
    font-family: 'Raleway', sans-serif;
  }

  .blog-card .description h1 {
    line-height: 1;
    margin: 0;
    font-size: 1.7rem;
  }

  .blog-card .description h2 {
    font-size: 1rem;
    font-weight: 300;
    text-transform: uppercase;
    color: #a2a2a2;
    margin-top: 5px;
  }


  .blog-card p:first-of-type {
    margin-top: 1.25rem;
  }

  .blog-card p:first-of-type:before {
    content: "";
    position: absolute;
    height: 5px;
    background: #5ad67d;
    width: 35px;
    margin-top: -1rem;
    border-radius: 3px;
  }

  @media (min-width: 640px) {
    .blog-card {
      flex-direction: row;
      max-width: 700px;
    }

    .blog-card .meta {
      flex-basis: 0%;
      height: 200px;
    }

    .blog-card .description {
      flex-basis: 95%;
    }

    .blog-card .description:before {
      content: "";
      background: #fff;
      width: 30px;
      position: absolute;
      left: -10px;
      top: 0;
      bottom: 0;
      z-index: -1;
    }

    .blog-card.alt {
      flex-direction: row-reverse;
    }

    .blog-card.alt .details {
      padding-left: 25px;
    }
  }


  .checked {
    color: orange;
  }

  .pure-material-radio {
    z-index: 0;
    position: relative;
    display: inline-block;
    color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
    font-family: var(--pure-material-font, "Roboto", "Segoe UI", BlinkMacSystemFont, system-ui, -apple-system);
    font-size: 16px;
    line-height: 1.5;
  }

  /* Input */
  .pure-material-radio>input {
    appearance: none;
    -moz-appearance: none;
    -webkit-appearance: none;
    z-index: -1;
    position: absolute;
    left: -10px;
    top: -8px;
    display: block;
    margin: 0;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
    outline: none;
    opacity: 0;
    transform: scale(1);
    pointer-events: none;
    transition: opacity 0.3s, transform 0.2s;
  }

  /* Span */
  .pure-material-radio>span {
    display: inline-block;
    width: 100%;
    cursor: pointer;
  }

  /* Circle */
  .pure-material-radio>span::before {
    content: "";
    display: inline-block;
    box-sizing: border-box;
    margin: 2px 10px 2px 0;
    border: solid 2px;
    /* Safari */
    border-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
    border-radius: 50%;
    width: 20px;
    height: 20px;
    vertical-align: top;
    transition: border-color 0.2s;
  }

  /* Check */
  .pure-material-radio>span::after {
    content: "";
    display: block;
    position: absolute;
    top: 2px;
    left: 0;
    border-radius: 50%;
    width: 10px;
    height: 10px;
    background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
    transform: translate(5px, 5px) scale(0);
    transition: transform 0.2s;
  }

  /* Checked */
  .pure-material-radio>input:checked {
    background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
  }

  .pure-material-radio>input:checked+span::before {
    border-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
  }

  .pure-material-radio>input:checked+span::after {
    transform: translate(5px, 5px) scale(1);
  }

  /* Hover, Focus */
  .pure-material-radio:hover>input {
    opacity: 0.04;
  }

  .pure-material-radio>input:focus {
    opacity: 0.12;
  }

  .pure-material-radio:hover>input:focus {
    opacity: 0.16;
  }

  /* Active */
  .pure-material-radio>input:active {
    opacity: 1;
    transform: scale(0);
    transition: transform 0s, opacity 0s;
  }

  .pure-material-radio>input:active+span::before {
    border-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
  }

  /* Disabled */
  .pure-material-radio>input:disabled {
    opacity: 0;
  }

  .pure-material-radio>input:disabled+span {
    color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38);
    cursor: initial;
  }

  .pure-material-radio>input:disabled+span::before {
    border-color: currentColor;
  }

  .pure-material-radio>input:disabled+span::after {
    background-color: currentColor;
  }

  .responsive {
    width: 10%;
    height: auto;
  }

  @media screen and (max-width: 992px) {
    .responsive {
      width: 15%;
    }
  }

  /* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
  @media screen and (max-width: 600px) {
    .responsive {
      width: 20%;
    }
  }
</style>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TZSDSVSLR9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TZSDSVSLR9');
</script>

<div style="text-align:center">
  <img class="responsive" align="center" src="<?= base_url(); ?>assets/images/survey.png">
  <h2>Customer Feedback<span style="font-size: 8pt">v1.6.2</span></h2>
</div>
<div class="review_section">



  <?php if ($setting == 'Auto') { ?>
    <form id="review-form" action="Feedback/submit" method="POST" onsubmit="sessionStorage.setItem('ok', '1'); alert('Your feedback has been submitted. Thank you for choosing Motortrade Group. Alaga ka dito!'); window.open('https://motortrade.com.ph/', '_self', '');">
      <input type="hidden" id="customerid" name="customerid">
      <input type="hidden" name="m" value="<?php echo $mobileno; ?>">
      <input type="hidden" name="s" value="<?php echo $service; ?>">
      <input type="hidden" name="pid" value="<?php echo $pid; ?>">

      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
      <div class="fieldset">
        <label for="reviewName">Mobile Number</label>
        <input type="text" class="mobile" name="mobileno" id="contact_no" value="<?php echo $mobileno; ?>" disabled>
      </div>
      <div class="fieldset">
        <label for="reviewName">Category</label>
        <input type="text" name="service" id="service" value="<?php echo $service; ?>" disabled>
      </div>
      <div class="fieldset">
        <label for="reviewName">Branch</label>
        <input type="text" name="service" id="service" value="<?php echo $specificBranch[0]->code . ' ' . $specificBranch[0]->description . ' (' . $specificBranch[0]->description . ')'; ?>" disabled>
      </div>
     
    <?php } else { ?>

      <form id="review-form" action="Feedback/mansubmit" method="POST" onsubmit="alert('Your feedback has been submitted. Thank you for choosing Motortrade Group. Alaga ka dito!'); window.open('https://motortrade.com.ph/', '_self', '');">
        <input type="hidden" id="customerid" name="customerid">
        <input type="hidden" name="m" value="<?php echo $mobileno; ?>">
        <input type="hidden" name="s" value="<?php echo $service; ?>">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
        <div class="fieldset">
          <label for="reviewName">Mobile Number</label>
          <input class="form-control mr-1 number" id="contact_no" name="mobileno" placeholder="09XX-XXXXXXX" type='tel' maxlength="12" onkeypress="return onlyNumberKey(event)" required>
        </div>
        <div class="fieldset">
          <label for="reviewName">Category</label>
          <!-- <input type="text" name="service" id="service" value="Customer Payment" disabled> -->
          <?php if ($ad == 'orcr') { ?>
            <input type="text" name="service" id="service" value="ORCR / Plate" disabled>
            <div class="fieldset">
              <label for="reviewName">Engine Number</label>
              <input type="text" name="enginenumber" value="<?php echo $en; ?>" disabled>
            </div>
          <?php } else { ?>
            <select class="form-control custom-select" name="service" id="service">
              <option value="" class="text-white bg-warning">
                Choose
              </option>
              <?php
              foreach ($survey_categories as $category) {
                echo '<option value = "' . $category->referencename . '" >' . $category->referencename . '</option>';
              }
              ?>
            </select>
          <?php } ?>
          <label for="exampleLast">Please identify the Branch of concern.</label>
          <?php if ($ad == 'orcr') { ?>
            <input type="text" name="branch" value="<?php echo $br; ?>" disabled>
          <?php } else { ?>

            <select class="js-example-basic-multiple-another form-control custom-select branch" multiple="multiple" minimumInputLength="3" name="branch" id="branch">
              <?php
              foreach ($branches as $branch) {
                if ($branch->address != null) {
                  $address = ' (' . $branch->address . ')';
                } else {
                  $address = '';
                }
                echo '<option value = "' . $branch->code . '" data-id="' . $branch->id . '">' . $branch->code . ' ' . strtoupper($branch->description) . ' ' . strtoupper($address) . '</option>';
              }
              ?>
            </select>
          <?php } ?>

        </div>
      <?php } ?>
      <div class="fieldset">
        <label for="reviewName">Naramdaman mo ba ang ALAGAng MOTORTRADE? (Nasiyahan ka ba sa Alagang Motortrade?)</label>
        <label class="pure-material-radio">
          <input type="radio" id="Yes" name="rate" value="Oo" checked>
          <span style="font-weight:normal !important">Oo</span>
        </label>
        <label class="pure-material-radio">
          <input type="radio" id="No" name="rate" value="Hindi">
          <span style="font-weight:normal !important">Hindi</span>
        </label>
      </div>
      <div class="fieldset">
        <label for="reviewComments" id="commentLabel">Kung OO, sa paanong paraan ka namin naALAGAang mabuti?</label>
        <textarea name="reviewComments" id="reviewComments" cols="20" rows="5" required=""></textarea>
      </div>
      <?php echo '<br/>';
      echo $widget; ?><?php echo $script; ?>
      <div class="fieldset right">
        <button type="submit" id="myCheck" style="display:none">Sign Up</button>
        <button type="button" class="btn btn-lg btn-primary" id="text" onclick="myFunction()">Submit</button>
      </div>
      <!--div class="modal-footer">
               <button type="button" id="submitModal" class="btn btn-sm btn-primary">Submit</button>
               <button type="button" id="resend" class="btn btn-sm btn-secondary" onclick="reSend()" data-dismiss="modal">Resend</button>
               </div-->
      <div class="modal bd-example-modal-sm fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="testd">
              <h5 align="center"><img src="assets/mopom.jpg" alt=""></h5>
            </div>
            <div class="modal-body">
              <div class="col-sm-12">
                <h5>Enter Mobile Number Verification</h5>
                We've sent a One Time Password (OTP) to your phone number. Please enter it below within 5 minutes.
                <br /><br />
                <b>Enter OTP</b>
                <input type="number" class="form-control otp-input modal-ku" id="otp-input" placeholder="OTP Code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="text-align:center" maxlength="4" aria-describedby="passwordHelpInline" required>
                <input type="hidden" id="hiddenOTP">
                <br />
                <button type="button" id="submitModal" class="btn btn-primary btn-block">Continue</button>
                <div align="center" id="modalfin">
                  <br />
                  <span id="resending"></span> | <a href="#" data-dismiss="modal">Cancel</a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      </form>
</div>

<script type="text/javascript">
  //   alert('test');
  $('input:radio[name="rate"]').change(
    function() {
      //     alert('adad');
      if ($('#Yes').is(':checked')) {
        //   alert('test');
        $('#commentLabel').text('Kung OO, sa paanong paraan ka namin naALAGAang mabuti?');
      } else {
        // alert('testy');
        $('#commentLabel').text('Kung HINDI, sa paanong paraan ka namin mas maaALAGAan?');
      }
    });
</script>
<script src="<?= base_url(); ?>assets/js/common.js?1"></script>
<script src="<?= base_url(); ?>assets/js/feedback.js?1"></script>