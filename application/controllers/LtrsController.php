<?php defined('BASEPATH') or exit('No direct script access allowed');

class LtrsController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_service_appointment', 'm_service_app');
        $this->load->model('LtrsModel', 'm_ltrs');
        $this->load->model('M_service_appointment', 'msa');
        $this->load->model('Log_model', 'logs');
        $this->load->library('recaptcha', 'application\libraries');
        $this->load->model('MaintenanceModel','maintenance');

        $isMaintenance = $this->maintenance->getFormMaintenance(82); 
        #check if value is 1
        if(!empty($isMaintenance)){
             redirect('maintenance');
        }
    }

    public function index()
    {
       
        $data['widget'] = $this->recaptcha->getWidget(array('data-expired-callback' => 'recaptchaExpired'));
        $data['script'] = $this->recaptcha->getScriptTag();
        $data['reference_value'] = $this->m_ltrs->getReference([6, 22, 139, 141]);
        $data['branchesData'] = $this->msa->get_MncBranches();

        $this->load->view('ltrs-view', $data);
        
    }

    public function store()
    {
        $p = $this->input->post();
        if (!isset($p) || empty($p)) return null;
        /**
         * 1. Check if customer is already registered via Fname, Lname, Mobile Num
         * 2. if yes get customer_id otherwise validate record & mobile number
         * 3. insert record customer & get customer_id
         * 4. insert record to ltrs_applicant with status new
         */

        $mobileNumber = _cleanMobileNumber($p['mobile_no']);

        if (!$mobileNumber):
            echo "Error, Mobile number is invalid.";
            return false;
        endif;

        $is_customer_exist = $this->m_ltrs->is_customer_exist($p['firstname'], $p['lastname'], $mobileNumber);
        $customer_id = null;
        $preferrededatetime = DateTime::createFromFormat('m-d-Y H:i', $p['preferrededatetime'])->format('Y-m-d H:');

        if ($is_customer_exist && $is_customer_exist->num_rows() > 0):
            $customer_id = $is_customer_exist->row()->customer_id;
        else:
            $customerData = [
                'FirstName'     =>  ucfirst(trim($p['firstname'])),
                'MiddleName'    =>  ucfirst(trim($p['middlename'])),
                'LastName'      =>  ucfirst(trim($p['lastname'])),
                'ZipCode'       =>  $p['psgc_zip_code'] ?? 0,
                'RegionCode'    =>  $p['psgc_region_code'] ?? 0,
                'ProvinceCode'  =>  $p['psgc_prov_code'] ?? 0,
                'CityCode'      =>  $p['psgc_citymun_code'] ?? 0,
                'BarangayCode'  =>  $p['psgc_brgy_code'] ?? 0,
                'Email'         =>  $p['email_address'],
                'MobileNumber'  =>  $mobileNumber,
                'Address'       =>  $p['address'],
                'OccupationId'  =>  $p['cus_prefession']
            ];
            $customer_id = $this->m_ltrs->insert_customer($customerData);
        endif;
        
        $p['choice'] == 496 ? $accountno = $p['Account'] : $accountno = '';
        
        $ltrsApplicantData = [
            'CustomerId'                => $customer_id,
            'LicenseTypeId'             => $p['license_type'],
            'MotorcyclePreferredId'     => $p['mc_preference'],
            'CreatedBy'                 => 'EXTERNAL',
            'CurrentStatusId'           => 771,
            'UpdatedBy'                 => 'EXTERNAL',
            // 'SourceOfIncome'            => $p['cus_src_of_income'],
            'MotorCyclePreferred'       => $p['mc_preferred'],
            'PreferredDate'             => $preferrededatetime.'00',
            'UpdatedDate'               => date('Y-m-d H:i:s'),
            'BranchCode'                => $p['branch_code'],
            'TransactionType'           => 'EXTERNAL',
            'CustomerAccntNo'           => $accountno,
            'IsBought'                  => $p['choice']
        ];
       
        $ltrsApplicantId = $this->m_ltrs->insert_ltrs_applicant($ltrsApplicantData);

        if ($ltrsApplicantId) {
            $this->m_ltrs->insert_status_log ($ltrsApplicantId);
            $update_data = [
                'FormId' => 82,
                'FormRecordId' => $ltrsApplicantId
            ];
    
            $this->logs->storeSMS($this->session->userdata('sms_log'), $update_data);
            $this->session->unset_userdata('sms_log');

            echo 1;
            return true;
        } else {
            echo 'Something went wrong. please try to reload the page';
            return false;
        }
    }

    public function get_psgc_select() # PSGC Select Element
    {
        # Init
        $p = $this->input->post();
        $data = array();
        $termSearch = isset($p['searchTerm']) && strlen($p['searchTerm']) >= 5 ? $p['searchTerm'] : NULL;
        $psgcs = !empty($termSearch) ? $this->m_ltrs->get_psgc_view($termSearch) : array();

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
