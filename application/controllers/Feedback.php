<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Feedback extends CI_Controller
{
    public function __construct()
    {
        //die("UNDER MAINTENANCE");
        // die("Under Mainte");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Inquiry_model', 'inquiry');
        $this->load->model('Log_model', 'logs');
    }

    public function index()
    {
        $this->load->library('recaptcha', 'application\libraries');
        $id = $this->input->get('sc');
        $data['ad'] = $this->input->get('ad');
        $data['en'] = $this->input->get('en');
        $data['br'] = $this->input->get('br');
        $newid = base64_decode($id);
        $data['mobileno'] = $this->feedback->getData($newid, 'mobileno');
        $data['service'] = $this->feedback->getData($newid, 'service');
        $branchData = $this->feedback->getData($newid, 'branch');
        $data['pid'] = $newid;

        $data['specificBranch'] = $this->feedback->getBranchData($branchData);
        //  echo $data['specificBranch'][0]->description;
        $data['branches'] = $this->feedback->get_branches();
        $validate = $this->feedback->validate($newid, $data['mobileno'], $data['service']);
        $data['widget'] = $this->recaptcha->getWidget();
        $data['script'] = $this->recaptcha->getScriptTag();
        $data['survey_categories'] = $this // updated by Arwin 22/07/2021
        ->feedback
        ->get_survey_categories();
        if ($validate != 'null') {
            $this
                ->load
                ->view('error');
        } else {
            // echo $validate;
            // echo $newid;
            // echo $data['mobileno'];
            // echo $data['service'];
            if ($data['mobileno'] != null && $data['service'] != null) {
                $data['setting'] = 'Auto';
                $this->load->view('feedback', $data);
            } else {
                if ($id == '') {
                    $data['setting'] = 'Manual';
                    $this->load->view('feedback', $data);
                } else {
                    $this
                    ->load
                    ->view('error');
                }
            }
        }
    }

    public function submit()
    {
        $value = $this->input->post();
        // echo json_encode($value);
        $this->feedback->feedbackSubmit($value);
        $update_data = [
            'FormId' => 46,
            'FormRecordId' => $value['pid']
        ];

        $this->logs->storeSMS($this->session->userdata('sms_log'), $update_data);
        $this->session->unset_userdata('sms_log');
        // redirect($_SERVER['HTTP_REFERER']);
    }

    public function mansubmit()
    {
        $value = $this
            ->input
            ->post();
        //  echo json_encode($value);
        $this
            ->feedback
            ->feedbackManSubmit($value);
        // redirect($_SERVER['HTTP_REFERER']);
    }

    public function sms_sending()
    {
        $api_key = SMS_API_KEY; // see https://telerivet.com/dashboard/api
        $project_id = SMS_PROJECT_ID;

        require_once(APPPATH.'libraries/telerivet.php');

        $to_number = $_POST['value'];
        $content = 'Your OTP Code is '.$_POST['getOTP'].'. Please do not share your code for security purposes.';

        $api = new Telerivet_API($api_key);

        $project = $api->initProjectById($project_id);

        try {
            $contact = $project->sendMessage(array(
              'to_number' => $to_number,
              'content' => $content
            ));
            $_SESSION['sms_log'][] = $this->inquiry->sms_log('Survey Form', $to_number, 1);
        } catch (Telerivet_Exception $ex) {
            echo "<div class='error'>".htmlentities($ex->getMessage())."</div>";
        }
    }
}
