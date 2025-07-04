<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inquiry extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Inquiry_model', 'inquiry');
        $this->load->model('MdiStoreModel', 'm_mdi');
        $this->load->model('Log_model', 'logs');
        $this->load->model('MaintenanceModel','maintenance');
        
       $isMaintenance = $this->maintenance->getFormMaintenance(34); 
       #check if value is 1
       if(!empty($isMaintenance)){
        redirect('maintenance');

       }
    }

    public function index()
    {

       

    //    var_dump($isMaintenance);die;
        // $valid_param = ['src'=>1,'cls'=>2,'ci'=>3,''];
        // # checking valid link
        // foreach($_GET as $key => $param){
        // if(!array_key_exists($key, $valid_param)){
        //     redirect();
        //     }
        // }
      if(isset($_GET['chatbot']) && $_GET['chatbot'] == 'inquiry'){
        $_SESSION['chatbot_inquiry'] = $_GET['chatbot'];
      }
      else{
        $_SESSION['chatbot_inquiry'] = '';
      }

        $this->load->library('recaptcha', 'application\libraries');
        $data['occupation'] = $this->inquiry->get_occupation();
        $data['occupation_group'] = $this->inquiry->get_occupation_group();
        //$data['region'] = $this->inquiry->get_region();

        $data['pays'] = $this->inquiry->get_pays();
        $data['types'] = $this->inquiry->get_types();
        $data['colors'] = $this->inquiry->get_colors();
        $data['sources'] = $this->inquiry->get_sources();
        // $data['areas'] = $this->inquiry->get_areas();
        /*$data['province'] = $this->inquiry->get_province();
        $data['city'] = $this->inquiry->get_city();
        $data['barangay'] = $this->inquiry->get_barangay(); */
        $data['widget'] = $this->recaptcha->getWidget();
        $data['script'] = $this->recaptcha->getScriptTag();
        $data['clusterss'] = $this->inquiry->get_clusterss();
        $data['branches'] = $this->inquiry->get_branches();
        # $data['clustercodes'] = $this->inquiry->get_clusterss(); Remove by Russ
        // $data['get_pgsc'] = $this->inquiry->get_PSGC();

        # Init
        $code       = $this->input->get('cls');
        $newcode    = base64_decode($code);
        $codex      = $this->input->get('src');
        $newcodex   = base64_decode($codex);
        $codey = $this->input->get('ci');
        $newcodey = base64_decode($codey);

        $src_code   = $this->inquiry->validatex($newcodex);
        $clus_code  = $this->inquiry->validate($newcode);
        if ($codey != '' || empty($codey)) {
            $campaigndets = $this->inquiry->campaigndets($newcodey);
           
            if ( !$campaigndets || ($campaigndets->num_rows() == 0 || empty($campaigndets->row()->BrandId)) ){
                
                $res = $this->inquiry->get_brand();
                $data['brand'] =  $res['result'];
                $data['brand_query'] = $res['brand_query'];
                $data['model'] = $this->inquiry->get_model();
                
            } else {
                //echo json_encode($campaigndets);
                $data['brand'] = $this->inquiry->get_brand_specnew($campaigndets[0]->BrandId);
                $data['model'] = $this->inquiry->get_model_specnew($campaigndets[0]->ModelId);
            }

            
            // return false;

        } else {
            if ($newcodex == 'HONDA FACEBOOK ADS') {
                $data['brand'] = $this->inquiry->get_brand_spec('HONDA');
                $data['model'] = $this->inquiry->get_model_spec('HA');
            } elseif ($newcodex == 'YAMAHA FACEBOOK ADS') {
                $data['brand'] = $this->inquiry->get_brand_spec('Yamaha');
                $data['model'] = $this->inquiry->get_model_spec('FB-YAMAHA');
            } elseif ($newcodex == 'SUZUKI FACEBOOK ADS') {
                $data['brand'] = $this->inquiry->get_brand_spec('Suzuki');
                $data['model'] = $this->inquiry->get_model_spec('FB-SUZUKI');
            } elseif ($newcodex == 'KAWASAKI FACEBOOK ADS') {
                $data['brand'] = $this->inquiry->get_brand_spec('Kawasaki');
                $data['model'] = $this->inquiry->get_model_spec('FB-KAWASAKI');
            } else {
                $data['brand'] = $this->inquiry->get_brand();
                $data['model'] = $this->inquiry->get_model();
            }
        }

        if (($src_code === false  && $clus_code === false && $codey == '') || ($src_code == '')) :
            return $this->load->view('error');
        else :
            $data['categories'] = $this->inquiry->get_categories($newcodex);
            $data['cluster_code']   = $this->inquiry->get_tmp_clusters($clus_code);
            $data['sourceid']       = $src_code;
            $data['clusterid']      = $clus_code;
            if ($clus_code) :
                $data['branches'] = $this->inquiry->get_branches($clus_code); 
            endif;
            $data['campaignid'] = $newcodey;
            $data['source'] = $newcodex;
            $this->load->view('inquiry_view', $data);
        endif;
    }

    public function submit()
    {
        $p = $this->input->post();
        // var_dump($this->input->post('purchaseType'));
        if (!isset($p['gen_id']) || !isset($p['g-recaptcha-response'])) :
            echo json_encode([
                "response"  => "false",
                "id"        => 0,
                "message"   => "unauthorized"
            ]);
            return false;
        endif;

        if ($this->inquiry->checkClient()) :
            echo json_encode([
                "response"  => "false",
                "id"        => 0,
                "message"   => "Existing Record"
            ]);
            return false;
        endif;

        if (isset($p) && !isset($p['branch']) && in_array($p['inquiry'], [151,152])) :
            echo json_encode("Preferred Branch is required");
            return false;
        endif;

        #get region in psgc
        #all region in MDI 
        $region_mdi_array = [9,10,11,12,15,16];
        
        $arr = explode("*", $p['model'], 2);
        $model = $arr[0];
        $type = $arr[1];
        $inquiry = $p['inquiry'];

        $customer_info = new stdClass();
        $customer_info->firstname = ucfirst($p['customer_fname']);
        $customer_info->lastname = ucfirst($p['customer_lname']);
        $customer_info->middlename = ucfirst($p['customer_mname']);
        $customer_info->region_code = $region = $this->inquiry->get_psgc_by_brgy( $p['psgc'], 'regCode');
        $customer_info->province_code = $this->inquiry->get_psgc_by_brgy( $p['psgc'], 'provCode');
        $customer_info->city_code = $this->inquiry->get_psgc_by_brgy( $p['psgc'], 'citymunCode');
        $customer_info->barangay_code = $this->inquiry->get_psgc_by_brgy( $p['psgc'], 'brgyCode');
        $customer_info->email = $p['email'];
        $customer_info->mobile = $p['contact_no'];
        $customer_info->address = ucfirst($p['address']);
        $customer_info->generate_id = !isset($p['gen_id']) ? null : $p['gen_id'];
        
        $data = [
            'CategoryId'        => $p['inquiry'],
            'BrandId'           =>  $inquiry == 167 ? '' : $p['brand'],
            'ModelId'           =>  $inquiry == 167 ? '' : $model,
            'MCTypeId'          =>  $inquiry == 167 ? '' : $type,
            'SourceId'          => $p['sourceid'],
            'CampaignId'        => $p['campaignid'],
            'ClusterCode'       =>  $p['clusterid'],
            'ColorId'           => $p['color'],
            'Branch'            => (isset($p['branch']) && !empty($p['branch']) ? $p['branch'] : NULL),
            'TransactionType'   => 'EXTERNAL',
            'UpdatedBy'         => 'EXTERNAL',
            'Remarks'           => $p['details'],
            'DatePurchase'      => $inquiry == 167 ? '' : $p['date_purchase'],
            'CurrentStatusId'   => 229,
            'ActualInquiryDate' => date("Y-m-d H:i:s"),
            'IsCustomerExists'  => isset($p['isCustomerExist']) ? $p['isCustomerExist'] : null,
            'BuyerType'         => $p['purchaseType'],
            'CustomerId'        => in_array($region, $region_mdi_array)
                                    ? 
                                    _saveCustomerInfo($customer_info,'mdi_db') 
                                    : 
                                    _saveCustomerInfo($customer_info,'default') 
        ];

        if (isset($_SESSION['chatbot_inquiry'])) {
            if ($_SESSION['chatbot_inquiry'] == 'inquiry') {

                $company = in_array($region, $region_mdi_array) ? 8000 : 9000;
                $unique_customer_id = date('YmdH') . '-' . $_SESSION['chatbot_inquiry'] . '-' . $data['CustomerId'];
                $chatbot_data = [
                    'System' => $_SESSION['chatbot_inquiry'],
                    'CustomerId' => $data['CustomerId'],
                    'ChatBotId' => $unique_customer_id,
                    'CreatedBy' => 'SYSTEM',
                    'UpdatedBy' => 'SYSTEM',
                    'CompanyId' => $company
                ];
                $result = $this->inquiry->ChatbotLogs($chatbot_data);
                $_SESSION['chatbot_inquiry'] = '';
            }
        }
      

        if ($p['inquiry'] == 151 || $p['inquiry'] == 152) :
            $data += [
                'BudgetFrom'    => str_replace(',', '', $p['budget_from']),
                'BudgetTo'      => str_replace(',', '', $p['budget_to'])
            ];
        endif;  

        if (empty(trim($p['clusterid'])) && !in_array($p['inquiry'], [151, 152])) :
            $data += array(
                'Telesales' => in_array($region, $region_mdi_array) ? 2125 : 540
            );
        endif;


        #checking region 
        if (in_array($region, $region_mdi_array)) :
            $record_id = $this->m_mdi->storeInquiry($data);

            
        else:
            $record_id = $this->inquiry->post($data);

            if (empty($record_id)) :
                echo json_encode([
                    "response"  => "false",
                    "id"        => 0,
                    "message"   => "Unable Save Record"
                ]);
                return false;
            endif;

            $logs_data = [
                'FormId' => 34,
                'FormRecordId' => $record_id
            ];

            _storeLogs($this->session->userdata('sms_log'), $logs_data);
            $this->session->unset_userdata('sms_log');           
            
        endif;
      
        echo json_encode([
            "response"  => "true",
            "id"        => $record_id
        ]);
        return true;
    }


    public function find_psgc()
    {
        return $this
            ->inquiry
            ->find_psgc();
    }

    public function verify_exist()
    {
        $value = $this->input->post();
        $codes = $this->inquiry->verify_exist($value);
        if ($codes == 'false') {
            echo 'false';
        } else {
            if ($codes[0]->recorddate == date('Y-m-d')) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    public function dump()
    {
        $mdi = $this->load->database('mdi', TRUE);
        $databaseName = $mdi->database;
        var_dump($databaseName);
    }

    public function sms_sending()
    {

      
        $api_key = SMS_API_KEY; // see https://telerivet.com/dashboard/api
        $project_id = SMS_PROJECT_ID;
        // echo 1;
        // return;
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
