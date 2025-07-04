<?php

use phpDocumentor\Reflection\Types\Null_;

defined('BASEPATH') or exit('No direct script access allowed');

class CustomerCareController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('CustomerCareModel', 'cuscare_m');
        $this->load->model('Log_model', 'logs');
        $this->load->library('recaptcha', 'application\libraries');
        $this->load->model('Inquiry_model', 'inquiry');
        $this->load->model('MaintenanceModel','maintenance');
        $isMaintenance = $this->maintenance->getFormMaintenance(35); 
        #check if value is 1
        if(!empty($isMaintenance)){
            redirect('maintenance');
        }
    }

    public function index(){


        $data['category'] = $this->cuscare_m->getCategory();
        $data['braches'] = $this->cuscare_m->getBranches();
        $data['widget'] = $this->recaptcha->getWidget();
        $data['script'] = $this->recaptcha->getScriptTag();

        $this->load->view('CustomerCare/CustomerCareView',$data);
    }
    public function sms_sending()
    {
      

        $otp = random_int(10000, 99999);
        $_SESSION['getOTP'] = password_hash($otp, PASSWORD_DEFAULT);
        $_SESSION['getDateTime'] = date('Y-m-d H:i:s');
        $_SESSION['otpMobile'] = $_POST['value'];

        $to_number = $_POST['value'];
        $content = 'Your OTP Code is ' .  $otp . '. Please do not share your code for security purposes.';

        $this->sendSMS($to_number,$content);

        echo '1';
    }

    public function validateStore(){
        $session_otp = isset($_SESSION['getOTP']) ? $_SESSION['getOTP'] : NULL;
        $session_date = isset($_SESSION['getDateTime']) ? $_SESSION['getDateTime'] : NULL;
        $now       = time();
        $timestamp = strtotime($session_date);
        $timediff  = $now - $timestamp;
        
        /*
            result code
            0 => expired OTP
            1 => success OTP and saved
            101=> OTP not match
            104=> OTP error is null or empty or not found
            400=> not saved
        */

        if (floor($timediff/60) > 10.0) {
            $data['result'] = 'OTP is expired please resend OTP';
            $data['code']   = 0;
        }
        else {
            if(!empty($session_otp)){
                if (password_verify($_POST['otp'],  $session_otp)) {
                    $post = $_POST;
                    $middlename = isset($post['customer_mname']) ? $post['customer_mname'] : '';
                    $customer_check = $this->cuscare_m->save_customer_info($post['customer_fname'],$middlename, $post['customer_lname'],  $post['email'], $post['mobile_number'], $post['psgc']);
                    $data['customer_id'] = $customer_check;
                    $data['code']   = 400;
                    $data['branch'] = $post['branch'];

                    $data_list = [
                        'CustomerCategoryId'=> $post['category'],
                        'BranchCode'        => $post['branch'],
                        'Remarks'           => $post['customerCareDetails'],
                        'EngineNumber'      => isset($post['engine']) ? $post['engine'] : null,
                        'DateApplied'       => isset($post['date_applied']) ? $post['date_applied'] : null,
                        'TypeId'            => '552',
                        'CustomerId'        => $customer_check,
                        'TransactionType'   => 'EXTERNAL',
                        'CreatedBy'         => 'EXTERNAL',
                        'UpdatedBy'         => 'EXTERNAL',
                        'CurrentStatusId'   => 262
                    ];
                    
                    $data_result = $this->cuscare_m->storeData($data_list);
                 
                    if ($data_result['insert_result'] == true) {
                        $logs = array(
                            'FormId'         =>  '35',
                            'FormRecordId'   => $data_result['last_id'],
                            'StatusId'       =>  '262',
                            'createby'       => 'EXTERNAL',
                            'createDT'       =>  date('Y-m-d H:i:s'),
                            'EffectiveDT'    =>  date('Y-m-d'),
                            'deletedflag'    =>  0
                        );
                        $this->cuscare_m->storeLogs($logs);
                        if (!empty($post['dissatisfied_link']) == true) {

                            $ip = $this->input->ip_address();
                            $device = $this->agent->is_mobile() == true ? 'mobile' : 'desktop';
                            $data_survey = [
                                'SurveyDate'             => date('Y-m-d'),
                                'CustomerSatisfactory'   => $post['dissatisfied_link'],
                                'BranchCode'              => $post['branch'],
                                'ERSNumber'              => $data_result['last_id'],
                                'SurveyOption'          => $post['option_val'],
                                'CustomerNumber'        => $post['mobile_number'],
                                'CustomerName'          => $post['customer_fname'] . ' ' . $post['customer_lname'],
                                'IPAdress'              => $ip,
                                'DeviceFlatform'        => $device,
                                'CreatedDate'           => date('Y-m-d H:i:s'),
                                'CreatedBy'             => 'EXTERNAL'
                            ];
                            $this->db->insert('tblFormCustomerCareSurvey', $data_survey);

                        $data['code']   = 1;
                        }
                        $data['id']     = $data_result['last_id'];
                        $data['result'] = 'Success saved';
                       
                    }

                } else {
                    $data['result'] = 'OTP is Not Match.Try again!';
                    $data['code']   = 101;
                }
            }
            else{
                $data['result'] = 'OTP error! Please Try Again. Window will be refresh in 3 seconds';
                $data['code']   = 104;
            }
        }

        echo json_encode($data);
    }

    public function sendSMS($mobile,$content){
        require_once(APPPATH . 'libraries/telerivet.php');
        $api_key = SMS_API_KEY; // see https://telerivet.com/dashboard/api
        $project_id = SMS_PROJECT_ID;

        // var_dump('0'.$mobile);die;
        $api = new Telerivet_API($api_key);

        $project = $api->initProjectById($project_id);

        try {
            $contact = $project->sendMessage(array(
                'to_number' => '0'.$mobile,
                'content' => $content
            ));

            $this->inquiry->sms_log('Customer Care', '0'.$mobile, 1);
        } catch (Telerivet_Exception $ex) {
            // echo $ex;
            //return false;
            // echo "<div class='error'>".htmlentities($ex->getMessage())."</div>";
        }
    }

  

}


?>