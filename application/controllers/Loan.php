<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Loan extends CI_Controller
{
    public function __construct()
    {
        // die("Under Mainte");
        //die("UNDER MAINTENANCE");
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Complaint_model', 'complaint');
        $this->load->model('Inquiry_model', 'inquiry');
        $this->load->model('Log_model', 'logs');
        $this->load->model('MaintenanceModel','maintenance');

        $isMaintenance = $this->maintenance->getFormMaintenance(39); 
        #check if value is 1
        if(!empty($isMaintenance)){
            redirect('maintenance');
        }
    }

    public function index()
    {

        // $valid_param = ['src'=>1,'cls'=>2,'ci'=>3];
        // # checking valid link
        // foreach($_GET as $key => $param){
        // if(!array_key_exists($key, $valid_param)){
        //     redirect();
        //     }
        // }
       
 
        $this
            ->load
            ->library('recaptcha', 'application\libraries');
        //	$data['branch'] = $this->complaint->get_branch();
        $data['category'] = $this
            ->complaint
            ->get_cat();
        $data['branches'] = $this
            ->inquiry
            ->get_branches();
        $data['clusters'] = $this
            ->inquiry
            ->get_clusters();
        $data['status'] = $this
            ->inquiry
            ->get_status();
        $data['colors'] = $this
            ->inquiry
            ->get_colors();
        $data['educations'] = $this
            ->inquiry
            ->get_education();
        $data['clustercodes'] = $this
            ->inquiry
            ->get_clusterss();
        $data['source_income'] = $this
            ->inquiry
            ->get_source_income();
        $data['source_fund'] = $this
            ->inquiry
            ->get_source_fund();
        $data['source_income_group'] = $this
            ->inquiry
            ->get_source_income_group();
        $data['borrower'] = $this
            ->inquiry
            ->get_borrower(29);
        $data['borrower_nature'] = $this
            ->inquiry
            ->get_borrower(32);
        $data['borrower_size'] = $this
            ->inquiry
            ->get_borrower(31);
        $data['borrower_group'] = $this
            ->inquiry
            ->get_borrower_type_group();
        $data['marital_status'] = $this
            ->inquiry
            ->get_marital_status();
        $data['residence_type'] = $this
            ->inquiry
            ->get_residence_type();
        $data['widget'] = $this
            ->recaptcha
            ->getWidget();
        $data['script'] = $this
            ->recaptcha
            ->getScriptTag();
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
            if (!$campaigndets || ($campaigndets->num_rows() == 0 || empty($campaigndets->row()->BrandId)) ){
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

        # Revised Code By Russ: 5-19-21
        if ($clus_code === false && $src_code === false) :

            return $this->load->view('error');
        else :
            if ($src_code == '') :
                return $this->load->view('error');
            else :

                //$data['repo'] = ;
                $data['source'] = $newcodex;
                $data['cluster_code']   = $this->inquiry->get_tmp_clusters($clus_code);
                $data['sourceid']       = $src_code;
                $data['clusterid']      = $clus_code;
                $data['campaignid'] = $newcodey;
                $this->load->view('newloan_view', $data);
            endif;

        endif;
    
    }

    public function driverslicense()
    {
        if (isset($_FILES['image'])) {
            $value = $this
                ->input
                ->post();
            $result  = $this
                ->inquiry
                ->driverslicense($value);
        }
    }
    public function verify_id()
    {
        if (isset($_FILES['image'])) {
            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];
            move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . "/marketing-forms/images/" . $file_name);
            /*echo "<h3>Image Upload Success</h3>";
            echo '<img src="'.base_url().'images/'.$file_name.'" style="width:100%">'; */

            //$cmd = shell_exec('ls 2>&1');
            shell_exec('C:\Users\H2\AppData\Local\Programs\Tesseract-OCR\tesseract "images/' . $file_name . '" out');
            // /shell_exec('tesseract "images/'.$file_name.'" out');


            /*
            //$cmd = shell_exec('tesseract -v');
            //echo $cmd;
            echo $_SERVER['DOCUMENT_ROOT'];
            //echo ini_get("disable_functions");
            echo 'tesseract "images/'.$file_name.'" out';
            echo "<br><h3>OCR after reading</h3><br><pre>";

            $myfile = fopen("out.txt", "r") or die("Unable to open file!");
            echo fread($myfile,filesize("out.txt"));
            fclose($myfile);
            echo "</pre>";
            */
            if (!function_exists('str_contains')) {
                function str_contains(string $haystack, string $needle): bool
                {
                    return '' === $needle || false !== strpos($haystack, $needle);
                }
            }
            $search = 'NAME';
            $veron = 'REPUBLIC OF THE PHILIPPINES';
            $vertw = 'LAND TRANSPORTATION OFFICE';
            $lines = file('out.txt');
            // Store true when the text is found
            $found = false;
            $deets = false;
            foreach ($lines as $line) {
                if ($deets == true) {
                    echo $line;
                    $deets = false;
                }
                if (strpos($line, $search) !== false || strpos($line, $veron) !== false || strpos($line, $vertw) !== false) {
                    $found = true;
                    // echo $line.'<br>';
                    if (str_contains($line, 'NAME')) {
                        //echo $line;
                        $deets = true;
                    }
                }
            }
            // If the text was not found, show a message
            if (!$found) {
                echo 1;
            }
            /*
            $file = 'out.txt';
            $searchfor = 'NAME';



            // get the file contents, assuming the file to be readable (and exist)
            $contents = file_get_contents($file);
            // escape special characters in the query
            $pattern = preg_quote($searchfor, '/');
            // finalise the regular expression, matching the whole line
            $pattern = "/^.*$pattern.*\$/m";
            // search, and store all matching occurences in $matches
            if(preg_match_all($pattern, $contents, $matches)){
               echo "Found matches:\n";
               echo implode("\n", $matches[0]);
            }
            else{
               echo "No matches found";
            }
            */
        }
    }
    public function find_psgc()
    {
        return $this
            ->inquiry
            ->find_psgc();
    }

    public function get_psgc_select() # PSGC Select Element
    {
        # Init
        $p = $this
            ->input
            ->post();
        //echo json_encode($p['searchTerm']);
        $data = array();
        $termSearch = isset($p['searchTerm']) ? $p['searchTerm'] : null;
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
            ->tabOne($value);
        //echo json_encode($value);
        echo json_encode($result);
    }
    public function getall()
    {
        $value = $this
            ->input
            ->post();
        $result  = $this
            ->inquiry
            ->getall($value);
        foreach ($result as $res) {
            echo json_encode($res);
        }
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
        $result  = $this
            ->inquiry
            ->tabSix($value);
        $this->load->view('complete');
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
            $_SESSION['sms_log'][] = $this->inquiry->sms_log('Loan Application Form', $to_number, 1);
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
        $record_id = $this->inquiry->loanSubmit($value);

        $update_data = [
            'FormId' => 34,
            'FormRecordId' => $record_id
        ];

        $this->logs->storeSMS($this->session->userdata('sms_log'), $update_data);
        $this->session->unset_userdata('sms_log');

        redirect($_SERVER['HTTP_REFERER']);
    }

    /*SELECT OR INSERT BELOW*/
}
