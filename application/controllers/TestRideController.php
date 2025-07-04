<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestRideController extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('M_service_appointment', 'msa');
    $this->load->model('Complaint_model', 'complaint');
    $this->load->model('Inquiry_model', 'inquiry');
    $this->load->model('TestRideModel', 'tr_model');
    $this->load->model('LtrsModel', 'm_ltrs');
    $this->load->library('recaptcha', 'application\libraries');
    $this->load->model('Log_model', 'logs');
    $this->load->model('MaintenanceModel','maintenance');

    $isMaintenance = $this->maintenance->getFormMaintenance(89); 

    #check if value is 1
    if(!empty($isMaintenance)){
      redirect('maintenance');
    }
  }
  public function redirect(){
    redirect('testride');
  }  
  public function index()
  {
    $data['branchesData'] = $this->msa->get_MncBranches();
    $data['reference_value'] = $this->m_ltrs->getReference([6, 22, 139, 141]);
    $data['models'] =  $this->tr_model->getModelCodes();
    $data['widget'] = $this->recaptcha->getWidget();
    $data['script'] = $this->recaptcha->getScriptTag();
    $this->load->view('testride-view', $data);
  }

  public function store()
  {
    $post = $this->input->post();

    if (!isset($post) || empty($post)) return null;
    
    $mobile_number = _cleanMobileNumber($post['contact_no']);

    if (!$mobile_number):
      echo "Mobile number is invalid";
      return;
    endif;

    $is_customer_exist = $this->m_ltrs->is_customer_exist($post['customer_fname'], $post['customer_lname'], $mobile_number);
    $customer_id = null;
    if ($is_customer_exist && $is_customer_exist->num_rows() > 0):
      $customer_id = $is_customer_exist->row()->customer_id;
    else:
      $cus_info = [
        'FirstName'         =>  ucfirst($post['customer_fname']),
        'MiddleName'        =>  ucfirst($post['customer_mname']),
        'LastName'          =>  ucfirst($post['customer_lname']),
        'Email'             =>  $post['email'],
        'MobileNumber'      =>  $mobile_number,
        'Address'           =>  $post['address'],
        'ZipCode'           =>  $post['psgc_zip_code'] ?? 0,
        'RegionCode'        =>  $post['psgc_region_code'] ?? 0,
        'ProvinceCode'      =>  $post['psgc_prov_code'] ?? 0,
        'CityCode'          =>  $post['psgc_citymun_code'] ?? 0,
        'BarangayCode'      =>  $post['psgc_brgy_code'] ?? 0,
        'OccupationId'      =>  $post['cus_occupation'],
        "GenderId"          =>  $post['cus_gender'],
      ];
      $customer_id = $this->tr_model->insertCustomerInfo($cus_info);
    endif;

    $data = [
      'CustomerId'             =>  $customer_id,
      'BranchCode'             =>  $post['branch_code'],
      'KnowDrive'              =>  $post['know_how_to_drive'],
      'LicenseTypeId'          =>  $post['license_type'],      
      'OwnMotor'               =>  $post['existing_mc'],
      'BuyMotor'               =>  $post['willing_to_buy'],
      'PreferredMC'            =>  isset($post['preferred_mc']) ? $post['preferred_mc'] : null,
      'CreatedDate'            =>  date('Y-m-d H:i:s'),
      'CreatedBy'              =>  'EXTERNAL',
      'UpdatedBy'              =>  'EXTERNAL',
      'UpdatedDate'            =>  date('Y-m-d H:i:s'),
      "CurrentStatusId"        =>  852
    ];
    
    $form_record_id =  $this->tr_model->insertTestRide($data);
    if ($form_record_id) :
      $this->tr_model->insert_status_log($form_record_id);
      $update_data = [
        'FormId' => 89,
        'FormRecordId' => $form_record_id
      ];

      $this->logs->storeSMS($this->session->userdata('sms_log'), $update_data);
      $this->session->unset_userdata('sms_log');

      echo 1;
      return true;
    else :
      echo 'Something went wrong. please try to reload the page';
      return false;
    endif;
  }

  public function getPsgcSelect()
  {
      # Init
      $p = $this->input->post();
      $data = array();
      $termSearch = isset($p['searchTerm']) && strlen($p['searchTerm']) >= 5 ? $p['searchTerm'] : NULL;
      $psgcs = !empty($termSearch) ? $this->m_ltrs->get_psgc_view($termSearch) : array();

      if (empty($psgcs)) {
          echo json_encode($data);
          return false;
      }

      foreach ($psgcs->result() as $p) :
          $data[] = array(
              "id"                =>  $p->brgyCode,
              "text"              =>  $p->psgc_convention_name,
              "psgc_brgy_code"    =>  $p->brgyCode,
              "psgc_citymun_code" =>  $p->citymunCode,
              "psgc_prov_code"    =>  $p->provCode,
              "psgc_region_code"  =>  $p->regCode,
              "psgc_zip_code"     =>  $p->zip_code
          );
      endforeach;

      echo json_encode($data);
      return true;
  }

}
