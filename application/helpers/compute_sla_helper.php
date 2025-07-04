<?php
/***
 * Created By Russ
 * 05-23-22
 * Put All codes related SLA/TAT Computation
 * for these ara callable.
 */
    if (!function_exists('apiComputeSLA')):
        function apiComputeSLA ($FormId, $FormRecordId)
        {

            $url = ERS_BASE_URL."/api/compute-tat";
            $ch = curl_init($url);
            $data = [
                "FormId"        => $FormId,
                "FormRecordId"  => $FormRecordId
            ];

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            curl_exec($ch);
            curl_close($ch);
        }
    endif;

?>