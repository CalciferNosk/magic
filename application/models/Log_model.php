<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Log_model extends CI_Model
{
    protected static $table_sms = 'tblLogsSMS';

    public function __construct()
    {
        parent::__construct();
    }

    public function storeSMS($id, $data)
    {
        if (is_array($id) || is_object($id)) {
            $this->db->where_in('id', $id);
        } else {
            $this->db->where('id', $id);
        }

        return $this->db->update(self::$table_sms, $data);
    }

    public function user_log($username, $action_type, $table = null, $record_id = null, $remarks = null)
    {
        # Init
        $external = $this->load->database('external',TRUE);
        $ua				= $this->getBrowser();
        $platform		= "Browser:[" . $ua['name'] . "]Version:[" . $ua['version'] . "]PC:[" .$ua['platform']."]";
        $action_type 	= strtoupper($action_type);
        $ip				= strtoupper($_SERVER['REMOTE_ADDR'].",".gethostname());

        // $result = $this->db->query("INSERT INTO tblLogs (action_by, action_date, ip_address, action_type, table_name, remarks ,platform) VALUES('$username', now(), '$ip', '$action_type', '$table', '$remarks', '$platform')");

        $logs_data = array(
            "action_by"		=> $username,
            "ip_address"	=> $ip,
            "action_type"	=> $action_type,
            "table_name"	=> $table,
            "RecordId"      => $record_id,
            "remarks"		=> $remarks,
            "platform"		=> $platform
        );

        $external->insert('tblLogs', $logs_data);
    }

    public function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname    = $platform   = 'Unknown';
        $version  = "";

        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/OPR/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $bname = 'Edge';
            $ub = "Edge";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }

        $known   = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
        }
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version= $matches['version'][0];
            } else {
                $version= $matches['version'][1];
            }
        } else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {
            $version="?";
        }

        return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
    	);
    }

    public function logOTP($number,$otp,$content){

       $this->load->database('external', TRUE);
       $data_log = [
        "MobileNumber"=> $number,
        "Content" => $content,
        "OTP" => $otp,
        "CreatedBy" => 'SMS_OTP8'
       ];

       $this->db->insert('tblOTPLogs', $data_log);
    }
}
