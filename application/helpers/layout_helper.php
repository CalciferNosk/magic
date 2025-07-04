<?php
    #all forms header
     if (!function_exists('_getheaderlayout')) {
        function _getheaderlayout()
        {
            $CI = get_instance();

            return $CI->load->view('forms-layout/header',[],true);
        }
    }
    #all forms footer
    if (!function_exists('_getfooterlayout')) {
        function _getfooterlayout()
        {
            $CI = get_instance();

            return $CI->load->view('forms-layout/footerdefault',[],true);
        }
    }

    if (!function_exists('_getClearanceHelper')) {
        function _getClearanceHelper()
        {
            $CI = get_instance();

            return $CI->load->view('forms-layout/CleranceHelper',[],true);
        }
    }






    # old footer
    // if (!function_exists('_getfooterlayout')) {
    //     function _getfooterlayout()
    //     {
    //         return '<footer style="background-color:#203aa6;height:auto;padding :10px;bottom: 0;z-index: 3000;width:100%" align="center">
    //                 <div class="justify-content-center " style="font-size: 12px !important;">
    //                     <div class="d-flex justify-content-center">
    //                         <h5 style="color:white">www.</h5>
    //                         <h5 style="color:#ffc43b">MOTORTRADE</h4>
    //                         <h5 style="color:white">.com.ph</h5><br>
    //                     </div>
    //                     <img src="'. base_url().'assets/forms_image/foot.png" style="width:30%" alt="" srcset=""><br>
    //                     <div id="version" style=" bottom: 0;right: 0;position: fixed;z-index: 3000;font-size:18px !important;color:#c8c8c829;padding-right:10px">
    //                     </div>
    //                 </div>
    //             </footer>';
    //     }
    // }

?>
