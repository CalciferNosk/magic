<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Referral extends CI_Controller
{
    public function __construct()
    {
        // die("Under Maintenance");
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Inquiry_model', 'inquiry');
        $this->load->model('Log_model', 'logs');
    }

    public function index()
    {
        $this->load->library('recaptcha', 'application\libraries');
        $data['occupation'] = $this->inquiry->get_occupation();
        $data['occupation_group'] = $this->inquiry->get_occupation_group();
        $data['brand'] = $this->inquiry->get_brand();
        $data['model'] = $this->inquiry->get_model();
        $data['pays'] = $this->inquiry->get_pays();
        $data['types'] = $this->inquiry->get_types();
        $data['colors'] = $this->inquiry->get_colors();
        $data['sources'] = $this->inquiry->get_sources();
        $data['categories'] = $this->inquiry->get_categories();
        $data['widget'] = $this->recaptcha->getWidget();
        $data['script'] = $this->recaptcha->getScriptTag();
        $data['clusterss'] = $this->inquiry->get_clusterss();
        $data['clustercodes'] = $this->inquiry->get_clusterss();
        $data['source_referral'] = $this->inquiry->get_referral_source();
        $data['branches'] = $this->inquiry->get_branches();

        $this->load->view('referral_view', $data);
    }

    public function submit()
    {
        $value = $this->input->post();
        $data['id'] = $this->inquiry->referralpost($value);
        $update_data = [
            'FormId' => 34,
            'FormRecordId' => $data['id']
        ];

        $this->logs->storeSMS($this->session->userdata('sms_log'), $update_data);
        $this->session->unset_userdata('sms_log');

        $this->load->view('form_sent', $data);
    }

    public function getProvince()
    {
        $codes = $this->inquiry->getProvince($_POST['reg_code']);

        /*     foreach($engines as $key => $engine){

                 if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){

                     unset($engines[$key]); //remove from choices || $engine['status_id'] == 11

                 }

             }*/

        print_r(json_encode($codes));
    }

    public function getCity()
    {
        $codes = $this->inquiry->getCity($_POST['reg_code']);

        /*     foreach($engines as $key => $engine){

                 if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){

                     unset($engines[$key]); //remove from choices || $engine['status_id'] == 11

                 }

             }*/

        print_r(json_encode($codes));
    }

    public function getBarangay()
    {
        $codes = $this->inquiry->getBarangay($_POST['reg_code']);

        /*     foreach($engines as $key => $engine){

                 if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){

                     unset($engines[$key]); //remove from choices || $engine['status_id'] == 11

                 }

             }*/

        print_r(json_encode($codes));
    }

    public function getModel()
    {
        $codes = $this->inquiry->getModel($_POST['reg_code']);

        /*     foreach($engines as $key => $engine){

                 if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){

                     unset($engines[$key]); //remove from choices || $engine['status_id'] == 11

                 }

             }*/

        print_r(json_encode($codes));
    }

    public function getBranch()
    {
        $codes = $this->inquiry->getBranch($_POST['reg_code']);

        /*     foreach($engines as $key => $engine){

                 if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){

                     unset($engines[$key]); //remove from choices || $engine['status_id'] == 11

                 }

             }*/

        print_r(json_encode($codes));
    }

    public function sms_sending()
    {
        $api_key = SMS_API_KEY; // see https://telerivet.com/dashboard/api
        $project_id = SMS_PROJECT_ID;

        require_once(APPPATH . 'libraries/telerivet.php');

        $to_number = $_POST['value'];
        $content = 'Your OTP Code is ' . $_POST['getOTP'] . '. Please do not share your code for security purposes.';

        $api = new Telerivet_API($api_key);

        $project = $api->initProjectById($project_id);

        try {
            $contact = $project->sendMessage(array(
                'to_number' => $to_number,
                'content' => $content
            ));
            $_SESSION['sms_log'][] = $this->inquiry->sms_log('Inquiry Form', $to_number, 1);
        } catch (Telerivet_Exception $ex) {
            echo "<div class='error'>" . htmlentities($ex->getMessage()) . "</div>";
        }
    }
}

//}
