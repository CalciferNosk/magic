<footer class="footer justify-content-center">
    <div class="row" style="height:50px;margin-bottom:15px;">
        <span style="color:#154b9c;line-height:96px;"></span>
        <span><a href="" style="color:#154b9c;font-weight:500"></a></span>
    </div>
    <div class="row sub-outer" style="height:86px;background-color:#ffe969;">
        <img class="foot-image-2" style="width:10%;height:125%;position:relative;bottom:50px;left:30px" src="<?=base_url()?>assets/forms_image/sigurado.png" alt="">
        <span class="social-medias" style="width:5%;height:25%;display:inline-flex;align-items:center;position:relative;left:300px;top:35px">
            <a href="http://bit.ly/MotortradeFacebook"><img class="ml-4" style="width:50px" src="<?=base_url()?>assets/forms_image/social_media/fb-logo.png" alt=""></a>
            <a href="http://bit.ly/MotortradeInstagram"><img class="ml-4" style="width:50px" src="<?=base_url()?>assets/forms_image/social_media/insta-logo.png" alt=""></a>
            <a href="http://bit.ly/MotortradeTikTok"><img class="ml-4" style="width:50px" src="<?=base_url()?>assets/forms_image/social_media/tikttok-logo.png" alt=""></a>
            <a href="http://bit.ly/MotortradeYouTube"><img class="ml-4" style="width:50px" src="<?=base_url()?>assets/forms_image/social_media/youtube-logo.png" alt=""></a>
        </span>
        <span class="sub-footer" style="display:block;position:relative;bottom:137%;left:51%">

            <img class="foot-image-1" style="width:63%;" src="<?=base_url()?>assets/forms_image/mt-footer.png" alt="">
        </span>
    </div>
</footer>
<script>
    $(document).ready(function() {

        if ($(window).width() < 990) {
            $(".sub-footer").css({
                "bottom": "111px",
                "left": "42%"
            })
            $(".sub-outer").css("height", "45px")
            $(".foot-image-1").css("width", "56%")
            $(".foot-image-2").css("bottom", "28px");
            $(".social-medias").css("display", "none");
        } else {

        }
    });
</script>