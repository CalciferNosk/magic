<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Service extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_service_appointment', 'msa');
    $this->load->library('recaptcha', 'application\libraries');
    $this->load->model('Inquiry_model', 'inquiry');
    $this->load->model('MdiStoreModel', 'm_mdi');
    $this->load->model('Log_model', 'logs');
    $this->load->model('MaintenanceModel','maintenance');
    $isMaintenance = $this->maintenance->getFormMaintenance(34); 
    if(!empty($isMaintenance)){
      redirect('maintenance');
    }
  }

	public function index()
	{
   
    if(isset($_GET['chatbot']) && $_GET['chatbot'] == 'service'){
      $_SESSION['chatbot_service'] = $_GET['chatbot'];
    }
    else{
      $_SESSION['chatbot_service'] = '';
    }

    // var_dump( $_SESSION['chatbot_service']);die;
    $data['mc_brand'] = $this->msa->get_mcBrand();
    $data['categories'] = $this->msa->get_categories();
    $data['mc_models'] = $this->msa->get_mc_models();
    $data['mc_colors'] = $this->msa->get_mc_colors();
    $data['regions'] = $this->msa->get_regions();
    $data['provinces'] = $this->msa->get_provinces();
    $data['cities'] = $this->msa->get_cities();
    $data['barangays'] = $this->msa->get_barangays();
    $data['b_regions'] = $this->msa->get_MncRegions();
    $data['b_areas'] = $this->msa->get_MncAreas();
    $data['branchesData'] = $this->msa->get_MncBranches($has_service_bay = true);


    $data['widget'] = $this->recaptcha->getWidget(array('data-expired-callback' => 'recaptchaExpired'));
    $data['script'] = $this->recaptcha->getScriptTag();

    $this->load->view('service-appoinment', $data);
  
  }
  

  #store data service
  public function newServiceAppointment()
  {
   

     $p = $this->input->post();
     # Init
     $post = $this->input->post();
     $preferrededatetime = DateTime::createFromFormat('m-d-Y H:i', $this->input->post('preferrededatetime'))->format('Y-m-d H:');
     $cb = $this->checkBookDatetime($preferrededatetime, $post['branch_code']);
 
     # Check Booking
     if ($cb && ($cb->num_rows()) > 0):
       return $this->errorMessage("Appointment is not available. Please choose another schedule.");
     endif;
 
     # Checking if the user already exist in the database
    //  $cusId = $this->addCustomer();
    //  if (!is_numeric($cusId)) { # this is not customerID
    //    return $this->errorMessage("Something went wrong! Pls try again or reload the web page");
    //  }
     
      # MDI Branches
      $MDI_branch = _getMDIBranches();

     #customer information 
     $customer_info = new stdClass();
     $customer_info->firstname = ucfirst($p['firstname']);
     $customer_info->lastname = ucfirst($p['lastname']);
     $customer_info->middlename = ucfirst($p['middlename']);
     $customer_info->region_code = empty($p['psgc']) ? '' : $this->inquiry->get_psgc_by_brgy( $p['psgc'], 'regCode');
     $customer_info->province_code =  empty($p['psgc']) ? 'null' : $this->inquiry->get_psgc_by_brgy( $p['psgc'], 'provCode');
     $customer_info->city_code = empty($p['psgc']) ? '' : $this->inquiry->get_psgc_by_brgy( $p['psgc'], 'citymunCode');
     $customer_info->barangay_code =  empty($p['psgc']) ? '' : $this->inquiry->get_psgc_by_brgy( $p['psgc'], 'brgyCode');
     $customer_info->email = $p['email_address'];
     $customer_info->mobile = $p['mobile_no'];
     $customer_info->address = empty($p['address']) ? '' : ucfirst($p['address']);
     $customer_info->generate_id = !isset($p['gen_id']) ? '' : $p['gen_id'];

      $customer_id = in_array($post['branch_code'], $MDI_branch)? _saveCustomerInfo($customer_info,'mdi_db') :  _saveCustomerInfo($customer_info,'default');
     # "DayState"          =>  ( isset($post['daystate']) ) ? strtoupper($post['daystate']) : "", 
     $dataInsert = array(
       "CategoryId"        =>  1452,
       "CustomerName"      =>strtoupper($post['lastname']) . ", " . strtoupper($post['firstname']) . " " . strtoupper($post['middlename']),
       "MCBought"          =>  $post['mc_bought'],
       "PreferredDateTime" =>  $preferrededatetime . '00',
       "McBrandId"         =>  $post['mc_brand'],
       "McModelId"         =>  $post['mc_model'],
       "BranchCode"        =>  $post['branch_code'],
       "agreement"         => (isset($post['agreement'])) ? 1 : 0,
       "CustomerId"        =>  $customer_id,
       "RequestedService"  =>  $post['service_desc'],
       "TypeId"            =>  552,
       "chassis_no"        =>  $post['chassis_no'],
       "CurrentStatusId"   =>  270,
       "CreatedBy"         => "EXTERNAL",
       "UpdatedBy"         => "EXTERNAL",
       "TransactionType"   => "EXTERNAL",
       "CategoryId_Old"    => $post['category_id'],
       "RequestedService"  => $post['categoryname'],
       "MCCategory"      => $post['mccategory']
     );

     if (isset($_SESSION['chatbot_service'])) {
      if ($_SESSION['chatbot_service'] == 'service') {
          $company =  in_array($post['branch_code'], $MDI_branch) ? 8000 : 9000;
          $unique_customer_id = date('YmdHi') . '-' . $_SESSION['chatbot_service'] . '-' .   $customer_id;
          $chatbot_data = [
              'System' => $_SESSION['chatbot_service'],
              'CustomerId' => $customer_id,
              'ChatBotId' => $unique_customer_id,
              'CreatedBy' => 'SYSTEM',
              'UpdatedBy' => 'SYSTEM',
              'CompanyId' => $company
          ];

          $this->inquiry->ChatbotLogs($chatbot_data);
          $_SESSION['chatbot_service'] = '';
      }
  }


    if (in_array($post['branch_code'], $MDI_branch)) {
        $result['last_id'] = $this->m_mdi->storeService($dataInsert,$customer_id);
        $result['res'] = 1;

        
    } else {
        $result['last_id'] = $this->msa->newServiceAppointment($dataInsert, $customer_id);
        $result['res'] = 1;
    }
        echo 1;
        return;
  //  echo json_encode($result);
    exit(0);
  }
  public function errorMessage($message = "") # Error Message
  {
    $message = (empty($message)) ? "Error Occured!" : $message;
    die($message);
  }
 public function sendOTP () # send OTP via SMS
  { 

    // echo 1;
    // return;
    // exit();

    if ( ENVIRONMENT == 'development' ) { # Only Allow to my Local for Debugging purposes
      echo 1;
      return;
    }
    
    $api_key = SMS_API_KEY; // see https://telerivet.com/dashboard/api
    $project_id = SMS_PROJECT_ID;

    require_once(APPPATH.'libraries/telerivet.php');

    $to_number = $_POST['m_no'];
    $content = 'Your OTP Code is '.$_POST['getOTP'].'. Please do not share your code for security purposes.';

    $api = new Telerivet_API($api_key);

    $project = $api->initProjectById($project_id);

    $form_names = [
      "service" => "Service Appointment",
      "ltrs"    => "LTRS Applicant",
      "test_ride" => "Test Ride",
      "job_app"  =>  "Job Application"
    ];
    
    // $form_name = $this->input->post('form_name') == 'service' ? 'Service Appointment' : 'LTRS Applicant';
    $form_name = isset($form_names[$this->input->post('form_name')]) ? $form_names[$this->input->post('form_name')] : "";

    if($form_name == "Job Application") {
      $this->logs->logOTP($_POST['m_no'], $_POST['getOTP'], $content);
    }

    try
    {
      $contact = $project->sendMessage(array(
        'to_number' => $to_number,
        'content' => $content
      ));
      $_SESSION['sms_log'][] = $this->inquiry->sms_log($form_name, $to_number, 1);


      echo 1;
    }
    catch (Telerivet_Exception $ex)
    {
      echo "<pre>";
      $er = $ex->getMessage();
      var_dump($ex);
      echo "error, ".$er;
      echo "error, Something went wrong! We cannot process your Appointment at this moment";
    }

  }

  public function checkBookDatetime()
  {
    $post = $this->input->post();
    $preferrededatetime = DateTime::createFromFormat('m-d-Y H:i', $this->input->post('preferrededatetime'))->format('Y-m-d H:');
    $d = DateTime::createFromFormat('m-d-Y H:i', $this->input->post('preferrededatetime'))->format('Y-m-d H:00');
    $rqd = new DateTime($d);
    $dnow = new DateTime();

    if ( $rqd < $dnow->modify('+1 day') ) {
      echo "Earliest booking should be 24 hours prior to desired appointment.";
      return;
    }

    $r = $this->msa->checkBookDatetime($preferrededatetime, $post['branch_code'][0]);

    echo ( $r && ($r)->num_rows() > 0 ) ? "Appointment is not available. Please choose another date/time." : 0;
    return;
  }
}
# End of Class