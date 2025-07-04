<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ltrs extends CI_Controller {

  public function __construct() {
   // die("UNDER MAINTENANCE");
     parent::__construct();
     $this->load->helper('url');
     $this->load->model('Complaint_model', 'complaint');
          $this->load->model('Inquiry_model', 'inquiry');
  }

	public function index()
	{

        $this->load->library('recaptcha', 'application\libraries');
	//	$data['branch'] = $this->complaint->get_branch();
		$data['category'] = $this->complaint->get_cat();
    $data['brand'] = $this->complaint->get_brand();
 //   $data['areas'] = $this->inquiry->get_areas();
    $data['branches'] = $this->inquiry->get_branches();
 //   $data['clusters'] = $this->inquiry->get_clusters();
    //$data['regions'] = $this->inquiry->get_regions();
    $data['brand'] = $this->inquiry->get_brand();
    $data['model'] = $this->inquiry->get_model();
    $data['colors'] = $this->inquiry->get_colors();
    $data['widget'] = $this->recaptcha->getWidget();
    $data['script'] = $this->recaptcha->getScriptTag();
        $data['licensetype'] = $this->inquiry->get_globalref(128);
        $data['mcexp'] = $this->inquiry->get_globalref(127);
        $data['occupation'] = $this->inquiry->get_globalref(6);
        $data['sourceincome'] = $this->inquiry->get_globalref(22);
		$this->load->view('ltrs_view', $data);
   
	}

    public function submit(){
   $value = $this->input->post();
 //  echo json_encode($value);
  $data['id'] = $this->inquiry->ltrspost($value);
 // $this->load->view('form_sent', $data);
  //redirect($_SERVER['HTTP_REFERER']);
  }

 public function getSubCat(){
      $codes = $this->complaint->getSubCat($_POST['cat_code']);
        
   /*     foreach($engines as $key => $engine){
        
            if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){
        
                unset($engines[$key]); //remove from choices || $engine['status_id'] == 11 
        
            }
        
        }*/

        print_r(json_encode($codes)); 
  }

           public function sms_sending(){
          $api_key = SMS_API_KEY; // see https://telerivet.com/dashboard/api
          $project_id = SMS_PROJECT_ID;

          require_once(APPPATH.'libraries/telerivet.php');

          $to_number = $_POST['value'];
          $content = 'Your OTP Code is '.$_POST['getOTP'].'. Please do not share your code for security purposes.';

          $api = new Telerivet_API($api_key);

          $project = $api->initProjectById($project_id);

          try
          {
            $contact = $project->sendMessage(array(
              'to_number' => $to_number,
              'content' => $content
            ));

          $this->inquiry->sms_log('Customer Care', $to_number, 1);

          }
          catch (Telerivet_Exception $ex)
          {
           // echo $ex;
            //return false;
            // echo "<div class='error'>".htmlentities($ex->getMessage())."</div>";
          }
        } 

                    public function sms_tester(){
          $api_key = SMS_API_KEY; // see https://telerivet.com/dashboard/api
          $project_id = SMS_PROJECT_ID;

          require_once(APPPATH.'libraries/telerivet.php');

          $to_number = '09268423796';
          $content = 'Your OTP Code is';

          $api = new Telerivet_API($api_key);

          $project = $api->initProjectById($project_id);

          try
          {
            $contact = $project->sendMessage(array(
              'to_number' => $to_number,
              'content' => $content
            ));

            echo 'test';
          }
          catch (Telerivet_Exception $ex)
          {
            echo 'tset';
            echo $ex;
            //return false;
            // echo "<div class='error'>".htmlentities($ex->getMessage())."</div>";
          }
        }

      public function getModel(){
      $codes = $this->inquiry->getModel($_POST['reg_code']);
        
   /*     foreach($engines as $key => $engine){
        
            if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){
        
                unset($engines[$key]); //remove from choices || $engine['status_id'] == 11 
        
            }
        
        }*/

        print_r(json_encode($codes)); 
  }
        public function getBranch(){
      $codes = $this->complaint->getBranch($_POST['reg_code']);
        
   /*     foreach($engines as $key => $engine){
        
            if( ($engine['final_status'] >= 1 && $engine['final_status'] <= 7) ){
        
                unset($engines[$key]); //remove from choices || $engine['status_id'] == 11 
        
            }
        
        }*/

        print_r(json_encode($codes)); 

}

}