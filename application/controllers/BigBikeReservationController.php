<?php defined('BASEPATH') or exit('No direct script access allowed');

class BigBikeReservationController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_service_appointment', 'm_service_app');
        $this->load->model('BigBikeReservationModel', 'm_big_bike');
        $this->load->model('M_service_appointment', 'msa');
        $this->load->model('Log_model', 'logs');
        $this->load->library('recaptcha', 'application\libraries');
        $this->load->model('MaintenanceModel','maintenance');

        $isMaintenance = $this->maintenance->getFormMaintenance(40); 
        #check if value is 1
        if(!empty($isMaintenance)){
            redirect('maintenance');
        }
    }
    public function redirect(){
      redirect('bigbike');
    }  
    public function index()
    {
        $data['widget'] = $this->recaptcha->getWidget(array('data-expired-callback' => 'recaptchaExpired'));
        $data['script'] = $this->recaptcha->getScriptTag();
        $data['bigbike'] = $this->m_big_bike->getBigBikeList();
        $data['branchesData'] = $this->msa->get_MncBranches();
        $data['colors'] = $this->m_big_bike->getColors();
        $data['categories'] = $this->m_big_bike->getBigbikeCategory();

        $this->load->view('big-bike-reservation-view', $data);
        
    }

    public function store()
    {
        $p = $this->input->post();
        if (!isset($p) || empty($p)) return null;

        $mobileNumber = _cleanMobileNumber($p['mobile_no']);

        if (!$mobileNumber):
            echo "Mobile number is invalid";
            return;
          endif;

        $is_customer_exist = $this->m_big_bike->is_customer_exist($p['firstname'], $p['lastname'], $mobileNumber);
        $customer_id = null;

        if ($is_customer_exist && $is_customer_exist->num_rows() > 0) :
            $customer_id = $is_customer_exist->row()->customer_id;
        else :
            $customerData = [
                'FirstName'     =>  $p['firstname'],
                'MiddleName'    =>  $p['middlename'],
                'LastName'      =>  $p['lastname'],
                'ZipCode'       =>  $p['psgc_zip_code'] ?? 0,
                'RegionCode'    =>  $p['psgc_region_code'] ?? 0,
                'ProvinceCode'  =>  $p['psgc_prov_code'] ?? 0,
                'CityCode'      =>  $p['psgc_citymun_code'] ?? 0,
                'BarangayCode'  =>  $p['psgc_brgy_code'] ?? 0,
                'Email'         =>  $p['email_address'],
                'MobileNumber'  =>  $mobileNumber,
                'Address'       =>  $p['address'],
            ];
            $customer_id = $this->m_big_bike->insert_customer($customerData);
        endif;

        $big_bike_data = [
            'RequestedDate'             => date('Y-m-d'),
            'CustomerId'                => $customer_id,
            'CategoryId'                => $p['category'],
            'Branch'                    => $p['branch_code'],
            'BrandId'                   => $p['brand_id'],
            'ModelId'                   => $p['bigbike'],
            'ColorId'                   => $p['color'],
            'CreatedBy'                 => 'EXTERNAL',
            'CurrentStatusId'           => 279,
            'UpdatedBy'                 => 'EXTERNAL',
            'UpdatedDate'               => date('Y-m-d H:i:s'),
            'TransactionType'           => 'EXTERNAL'
        ];



        $registrant_id = $this->m_big_bike->storeRegistrant($big_bike_data);

        if ($registrant_id):
            $this->m_big_bike->insert_status_log($registrant_id);
            $update_data = [
                'FormId' => 40,
                'FormRecordId' => $registrant_id
            ];

            $this->logs->storeSMS($this->session->userdata('sms_log'), $update_data);
            $this->session->unset_userdata('sms_log');

            echo 1;
            return true;
        else:
            echo 'Something went wrong. please try to reload the page';
            return false;
        endif;
    }

    public function get_psgc_select() # PSGC Select Element
    {
        # Init
        $p = $this->input->post();
        $data = array();
        $termSearch = isset($p['searchTerm']) && strlen($p['searchTerm']) >= 5 ? $p['searchTerm'] : NULL;
        $psgcs = !empty($termSearch) ? $this->m_big_bike->get_psgc_view($termSearch) : array();

        // var_dump($psgcs); die();

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
