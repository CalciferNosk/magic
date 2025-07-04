<?php
defined('BASEPATH') or exit('No direct script access allowed');

class APICurlModel extends CI_Model
{

    protected $tblExternalWarehouseDataControl = 'tblExternalWarehouseDataControl';
    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
    }


    public function emsLoginAPI($system,$username,$password,$redirect){
        $token = $this->_getApiToken ('ERS');
        $_SESSION['token'] = $token;
        $url = EMS_BASE_URL . "/Main/get-user-details?UserID=1&Token={$token}";
        $obj = new stdClass();
        $obj->username = $username;
        $obj->password = $password;

       
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $data['httpcode'] = $httpcode;
        $data['output'] = $output;
        $data['redirect'] = $redirect;
        curl_close($ch);
        // var_dump('<pre>',json_decode($output));die;
        #create session here 
        if ($httpcode == 200) {
            $output_dec = json_decode($output, 1);
            $info = $output_dec['result'];
            $_SESSION['warehouse_logusername'] =$username;
            $_SESSION[$system.'_username'] =  (int) $info['code'];
            $_SESSION[$system.'_empid'] = $info['id'];
            $_SESSION[$system.'_firstname'] = $info['firstName'];
            $_SESSION[$system.'_fullname'] = $info['firstName'].',' . $info['lastName'] . ' ' . $info['middleName'];
            $_SESSION['fetch_result'] =(object)$info;

            if($system == 'warehouse'){
                $result = $this->checkDataControl($username);
              
                if(empty($result)){
                    $data_insert = [
                        "EmployeeCode" => $username,
                        "ChangeStatus" => 0,
                        "Edit"  => 0,
                        "Upload" => 0,
                        "Create" => 0,
                        "ListView" => 0,
                        'System' => 'WAREHOUSE'
                    ];

                   $insert_result=  $this->db->insert($this->tblExternalWarehouseDataControl, $data_insert);
                }
            }
        }
        
       return $data;

    }

    private function checkDataControl($username){

        $this->db->cache_off();
        $control = "SELECT count(1) as count_data FROM  {$this->tblExternalWarehouseDataControl} WHERE EmployeeCode = '{$username}';";
         $fetch = $this->db->query($control);
         return $fetch->row()->count_data > 0 ? true : false;
    }
    public function getCaseNTEList(){
        
        $token = _getApiToken ('CASEMANAGEMENT');
        
        $url = EMS_BASE_URL . "/CaseManagement/get-employee-nte-by-employee-id?UserID=1&Token={$token}&EmployeeID={$_SESSION['casente_empid']}";
        $obj = new stdClass();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $data['httpcode'] = $httpcode;
        $data['output'] = $output;
        curl_close($ch);

        return $data;
    }

    public function updateSeen($case_id){
          $token = _getApiToken ('CASEMANAGEMENT');
        $url = EMS_BASE_URL . "/CaseManagement/update-nte-employee-seen?UserID=1&Token={$token}";
        $obj = new stdClass();
        $obj->nteid = (int) $case_id;
        $obj->isEmployeeSeen = true;
        $obj->employeeSeenDate = date('c');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj)); //json_encode($obj);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $data['httpcode'] = $httpcode;
        $data['output'] = json_encode($output);
        curl_close($ch);

        return $data;
    }
    private function _getApiToken($system){
        return strtoupper(hash ( "sha256", $system.date("m/d/Y") ));
    }

}

?>