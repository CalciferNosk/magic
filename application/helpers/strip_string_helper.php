<?php

if (!function_exists('check_mobile_num')) {
    function check_mobile_num($num = "")
    {
        if (empty($num) || (strlen($num) > 12 && strlen($num) < 10)) return false;

        $num = strlen(_removeSpecialChars($num)) == 11 ? $num : "0" . $num;

        return str_replace("-", "", $num);
    }
}

if (!function_exists('_removeSpecialChars')) # Remove Special Character
{
    function _removeSpecialChars($str)
    {
        // Using preg_replace() function  
        // to replace the word  
        $res = preg_replace('/[^a-zA-Z0-9_ ]/s', '', $str);

        // Returning the result  
        return $res;
    }
}

if (!function_exists('_cleanMobileNumber')):
    function _cleanMobileNumber($num = "")
    {
        if (empty($num)) return null;

        // $num = intval(_removeSpecialChars($num));
        // $num = _removeSpecialChars($num);
        $num = _numberOnly($num);

        return $num;
    }
endif;

if (!function_exists('_numberOnly')) # Only Number 
{
  function _numberOnly($str)
  {
    // Using preg_replace() function  
    // to replace the word  
    $res = preg_replace( '/[^0-9]/', '', $str);
      
    // Returning the result  
    return $res; 
  }
}