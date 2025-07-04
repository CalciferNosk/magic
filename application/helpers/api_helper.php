<?php
/***
 * Created By Mgezun
 * 10-11-2022
 * 
 */
    if (!function_exists('_getJobAppApiToken')):
        function _getJobAppApiToken ()
        {
            // return strtoupper(hash ( "sha256", "JOBAPP".date('m/d/Y') ));
             return strtoupper(hash ( "sha256", "JOBAPP".date("Y-m-d")));
        }
    endif;

    #token hash
    if (!function_exists('_getApiToken')):
        function _getApiToken ($system)
        {
            return strtoupper(hash ( "sha256", $system.date("Y-m-d") ));
        }
    endif;

    #Api kickout question converter
    if (!function_exists('_getKickaoutQuestion')):
        function _getKickaoutQuestion ($type,$name)
        {
            $display = '';
            switch($type):
                case 'RADIO':
                    $display = '<div style="padding-left:20px">
                                    <input type="radio" id="yes_'.$name.'" name="'.$name.'" value="yes" >
                                    <label for="yes_'.$name.'">Yes</label>
                                    <input type="radio" id="no_'.$name.'" name="'.$name.'" value="no"> 
                                    <label for="no_'.$name.'">No</label>
                                 </div>';
                    break;
                case 'TEXT':
                    $display = '<div style="padding-left:20px"><input type="text" style="width: 263px;" placeholder="Write here your answer..." class="form-control" name="'.$name.'" ></div>';
                    break;
            endswitch;

            return $display;
        }
    endif;

    if (!function_exists('_getMaterialCount')):
        function _getMaterialCount ($material)
        {
           $CI = & get_instance();
           $CI->load->model('WarehouseModel' ,'warehouse');
           $result = $CI->warehouse->materialCheck($material);

           return count($result);
        }
    endif;

    if (!function_exists('_getBranchNameByCode')):
        function _getBranchNameByCode ($code)
        {
           $CI = & get_instance();
           $CI->load->model('HelperModel' ,'helper_m');
           $result = $CI->helper_m->getBranchNameByCode($code);

           return $result;
        }
    endif;
    if (!function_exists('_getStatusColor')):
        function _getStatusColor ($statusid)
        {
           switch($statusid):
                case 2208:
                    $color = "background-color: #fffabd;color:#af7b35;";#"#5be9ffb3";
                    break;
                case 2209:
                    $color = "background-color: #fbf1dd;color:#896110;";#"#5bff6a9e";
                    break;
                case 2210:
                    $color = "background-color: #e2eaf7;color:#2f5aa2;";#"#5bff6a9e";
                    break;
                case 2211:
                    $color = "background-color: #dcf1e4;color:green;";#"#c4c4c4";
                    break;
                default:
                    $color = "background-color: white";
                    break;
           endswitch;

           return $color;
        }
    endif;

    if(!function_exists('_getBranchNamebyCode')):
        function _getBranchNamebyCode($branch_code)
        {
            $CI = & get_instance();
            $CI->load->model('HelperModel' ,'helper_m');
            $result = $CI->helper_m->getBranchNamebyCode($branch_code);

            return $result;
        }
    endif;

    
    if(!function_exists('_getFullNameByCode')):
        function _getFullNameByCode($empcode)
        {
            $CI = & get_instance();
            $CI->load->model('HelperModel' ,'helper_m');
            $result = $CI->helper_m->getFullNameByCode($empcode);

            return $result;
        }
    endif;

     
    if(!function_exists('_getWarehouseTotalOrder')):
        function _getWarehouseTotalOrder($order_id)
        {
            $CI = & get_instance();
            $CI->load->model('HelperModel' ,'helper_m');
            $result = $CI->helper_m->getWarehouseTotalOrder($order_id);

            return $result;
        }
    endif;


    

?>