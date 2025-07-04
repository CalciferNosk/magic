<?php

if (!function_exists('_saveCustomerInfo')) :
    function _saveCustomerInfo($customer_info = null, $db = '')
    {
        if(empty($db)) return false;

        $ci =& get_instance();
        $mdi = $ci->load->database($db, TRUE);
        $table_name = 'tblcustomerinq';

        $has_record = $mdi->query("
                SELECT
                    id
                FROM
                    {$table_name}
                WHERE
                    UPPER(TRIM(FirstName)) = UPPER(TRIM('{$customer_info->firstname}'))
                    AND UPPER(TRIM(LastName)) = UPPER(TRIM('{$customer_info->lastname}'))
                    AND UPPER(TRIM(MobileNumber)) = UPPER(TRIM('{$customer_info->mobile}'))
                ORDER BY
                    id DESC
                LIMIT 1
            ");

        if ($has_record && $has_record->num_rows() > 0) :
            return $has_record->row()->id;
        endif;

        $spouse_id = '';
        $data = [
            'FirstName'         => $customer_info->firstname,
            'MiddleName'        => $customer_info->middlename,
            'LastName'          => $customer_info->lastname,
            'RegionCode'        => $customer_info->region_code,
            'ProvinceCode'      => $customer_info->province_code,
            'CityCode'          => $customer_info->city_code,
            'BarangayCode'      => $customer_info->barangay_code,
            'Email'             => $customer_info->email,
            'MobileNumber'      => $customer_info->mobile,
            'Address'           => $customer_info->address,
            'SpouseId'          => $spouse_id,
            "GeneratedId"       => $customer_info->generate_id
        ];

        $mdi->insert($table_name,$data);
        return $mdi->insert_id();
    }
endif;

if (!function_exists('_storeLogs')):
    function _storeLogs($id, $logs)
    {
        $ci =& get_instance();
        $ci->load->model('LogsModel', 'logs');
        $ci->logs->storeSMS($id, $logs);
    }
endif;


if(!function_exists('_getMDIBranches')):
    function _getMDIBranches()
    {
        $ci =& get_instance();
        $mdi = $ci->load->database('default', TRUE);

        $query = $mdi->query("SELECT BranchCode as mdi_branch FROM tbl_tmp_branch_hierarchy WHERE SUBSTRING(BranchCode, 1, 1) = '8';");
        // var_dump($query->result_array());die;
        return $query && $query->num_rows() > 0 ? array_column($query->result_array(), 'mdi_branch') : false;
    }

endif;


    if(!function_exists('_jobAppOTPLogs')):
        function _jobAppOTPLogs($number,$otp,$content)
        {
            $ci =& get_instance();
            $external = $ci->load->database('external', TRUE);
            $logs = [
                'MobileNumber' => $number,
                'Content' => $content,
                'OTP'=>$otp
            ];

            $external->insert('tblJobAppOtpLogs', $logs);

            return $external->insert_id();
        }

endif;
