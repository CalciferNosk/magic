
<?php
    if(!isset($fullname)):
        echo 'please relogin';
    else :
?>
<div class="card" style="margin: unset;">
    
    <div class="row">
        <img src="<?= base_url() ?>assets/clearance_assets/COE_img/<?= $_SESSION['company']?>_header.jpg" alt="" srcset="">
    </div>
    <div class="row " style="margin: 20px;">
        <div class="title" style="font-size: 15px;font-weight:500;text-align:center;">CERTIFICATE OF EMPLOYMENT</div>
        <br>
        <br>
        <br>
        <br>
        <div class="m-5 body_content" style="max-width: 90%;font-size:14px;line-height:25px;">
            <span>
                This is to certify that Mr./Ms. <?= $fullname ?> was an employee of <?= $companyDescription ?> from <?= $dateHired ?> up to <?= $resignedDate?> as <?= $position  ?> assigned at <?=  $orgCode?> - <?= $orgDescription?>.
            </span>
            <br>
            <br>
            
            <?php if($accountabilityStatus == 'CLEARED'): ?>
            <span>
                    Based on the records, Mr./Ms. <?= $lastName ?> has been officially cleared from all company related accountabilities.
            </span>
            <br>
            <br>
            <?php endif; ?>
            <span>
                This certification is being issued upon the request of Mr. <?= $lastName?> for employment requirement purpose/s only.
            </span>
            <br>
            <br>
            <span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Given this <?= date('jS').' day of '.date('F Y') ?> at 105 EDSA Highway Hills 1550 City of Mandaluyong NCR, Second District Philippines.
            </span>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <span>
                <b><u>MYRA O. TEJADA</u></b>
            </span>
            <br>
            <span>
                HR Manager, ER and Compliance
            </span>
        </div>
    </div>
</div>
<div style="position:fixed;bottom:0px;width:100%;">
    <img src="<?= base_url() ?>assets/clearance_assets/COE_img/footer.jpg" alt="" srcset="">
</div>
<?php endif ?>