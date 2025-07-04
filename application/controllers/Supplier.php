<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{

    public function __construct()
    {
        //die("UNDER MAINTENANCE");

        parent::__construct();
        $this
            ->load
            ->helper('url');
        $this
            ->load
            ->helper('form');
        $this
            ->load
            ->model('Complaint_model', 'complaint');
        $this
            ->load
            ->model('Inquiry_model', 'inquiry');
    }

    public function index()
    {
        $this->load->library('recaptcha', 'application\libraries');
        $data['widget'] = $this->recaptcha->getWidget();
        $data['script'] = $this->recaptcha->getScriptTag();
        $data['taxtype'] = $this->inquiry->get_globalref(96);
        $data['businesstype'] = $this->inquiry->get_globalref(95);
        $data['ownertype'] = $this->inquiry->get_globalref(121);

        $this->load->view('supplier', $data);
    }

    public function find_psgc()
    {
        return $this
            ->inquiry
            ->find_psgc();
    }

    public function getall()
    {
        $value = $this->input->post();
        $get_status_id = $this->inquiry->getStatusId($value);
        if (!empty($get_status_id) && $get_status_id->CurrentStatusId == '831') :
            echo json_encode($get_status_id);
            return false;
        endif;
        $result  = $this->inquiry->getallSupplier($value);
        echo json_encode($result);
    }

    public function getfiles()
    {
        $value = $this
            ->input
            ->post();
        $result  = $this
            ->inquiry
            ->getallSupplierFile($value);
        //   foreach ($result as $res){
        echo json_encode($result);
        // }
    }


    public function deleteattach()
    {
        $value = $this
            ->input
            ->post();
        $result  = $this
            ->inquiry
            ->deleteattach($value);
        echo json_encode($result);
    }

    public function get_psgc_select() # PSGC Select Element

    {
        # Init
        $p = $this
            ->input
            ->post();
        //echo json_encode($p['searchTerm']);
        $data = array();
        $termSearch = isset($p['searchTerm']) ? $p['searchTerm'] : NULL;
        $psgcs = !empty($termSearch) ? $this
            ->inquiry
            ->get_psgc_view($termSearch) : array();
        //echo json_encode($termSearch);
        echo json_encode($psgcs);
        // var_dump($psgcs); die();
        if (empty($psgcs)) {
            echo json_encode($data);
            return false;
        }

        foreach ($psgcs->result() as $p) :
            $data[] = array(
                "id" => $p->brgyCode,
                "text" => $p->psgc_convention_name,
                "psgc_brgy_code" => $p->brgyCode,
                "psgc_citymun_code" => $p->citymunCode,
                "psgc_prov_code" => $p->provCode,
                "psgc_region_code" => $p->regCode
            );
        endforeach;

        echo json_encode($data);
        return true;
    }

    public function tabotp()
    {
        $value = $this
            ->input
            ->post();
        $result  = $this
            ->inquiry
            ->suppOne($value);
        echo json_encode($result);
    }
    public function tabtwo()
    {
        $value = $this
            ->input
            ->post();
        $result  = $this
            ->inquiry
            ->tabTwo($value);
        echo $result;
    }
    public function tabthree()
    {
        $value = $this
            ->input
            ->post();
        $result  = $this
            ->inquiry
            ->tabThree($value);
        //echo $result;
    }
    public function tabfour()
    {
        $value = $this
            ->input
            ->post();
        $result  = $this
            ->inquiry
            ->tabFour($value);
        echo $result;
    }
    public function tabfive()
    {
        $value = $this
            ->input
            ->post();
        $result  = $this
            ->inquiry
            ->tabFive($value);
        // echo $result;
    }
    public function tabsix()
    {
        $value = $this
            ->input
            ->post();
        
        $data["result"]  = $this->inquiry->SuppAttachIns($value);
        $this->load->view('complete', $data);
        // echo $result;
    }
    public function test()
    {
        $get = 'citymunCode';
        $this
            ->db
            ->select('*');
        $this
            ->db
            ->from('refbrgy');
        $this
            ->db
            ->where('brgyCode', '013320018');
        $query = $this
            ->db
            ->get();
        $ret = $query->row();
        if ($get = 'citymuncode') {
            return $ret->citymunCode;
        }
        if ($get = 'provcode') {
            return $ret->provCode;
        }
        if ($get = 'regCode') {
            return $ret->regCode;
        }
    }

    public function getSubCat()
    {
        $codes = $this
            ->complaint
            ->getSubCat($_POST['cat_code']);

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
            $this->inquiry->sms_log('Supplier Form', $to_number, 1);
        } catch (Telerivet_Exception $ex) {
            // echo "<div class='error'>".htmlentities($ex->getMessage())."</div>";

        }
    }

    public function getModel()
    {
        $codes = $this
            ->inquiry
            ->getModel($_POST['reg_code']);

        /*     foreach($engines as $key => $engine){
        
            if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){
        
                unset($engines[$key]); //remove from choices || $engine['status_id'] == 11 
        
            }
        
        }*/

        print_r(json_encode($codes));
    }
    public function getBranch()
    {
        $codes = $this
            ->complaint
            ->getBranch($_POST['reg_code']);

        /*     foreach($engines as $key => $engine){
        
            if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){
        
                unset($engines[$key]); //remove from choices || $engine['status_id'] == 11 
        
            }
        
        }*/

        print_r(json_encode($codes));
    }

    public function submit()
    {
        $value = $this
            ->input
            ->post();
        //echo json_encode($value);
        $this
            ->inquiry
            ->loanSubmit($value);
        redirect($_SERVER['HTTP_REFERER']);
    }

    /*SELECT OR INSERT BELOW*/
}
