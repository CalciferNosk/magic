<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JobApplication extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->token = _getApiToken("JOBAPP");
        $this->load->helper('url');
        $this->load->model('Inquiry_model', 'inquiry');
        $this->load->model('JobApplicationModel', 'job_application');
        $this->load->model('Log_model', 'logs');
        $this->load->library('recaptcha', 'application\libraries');

        
        $this->load->model('MaintenanceModel','maintenance');
        $isMaintenance = $this->maintenance->getFormMaintenance(1); 
        #check if value is 1
        if(!empty($isMaintenance)){
            redirect('maintenance');
        }
    }

    public function index()
    {
        $this->load->view("job-application/index");
        // $this->load->view('forms-layout/footerdefault'); 
        // $this->load->view('job-application/layouts/footer');
    }

    public function getJobsData()
    {
        $jobs = $this->job_application->getJobsData();
        $data = array();
        $num = 1;
        $href = base_url() . 'careers/view/';
        foreach ($jobs->result_array() as $res) :
            $date = new DateTime($res['MrfCreatedDate']);
            $mrf_id = $date->format('Y').'-'.str_pad($res['MrfId'], 4, 0, STR_PAD_LEFT);
            $id = $res['id'];
            $position = ucfirst($res['Position']);
            $location = ucfirst(($res['Location']));
            $date_created = $date->format('F d, Y');
            $status = $res['ClosedDate'] == NULL ?  'OPEN' : 'CLOSED';
            $label = $mrf_id.', '.$status;
           
            $data[] = array(
               "
                    <a class='view-link' data-status='{$label}' style='text-decoration: none; font-weight: bold; font-size: 20px; color: #1D3494;' title='{$position}' href='{$href}{$id}' style='cursor: pointer' id='{$id}'>
                        <i class='bi bi-briefcase-fill' style='font-size: 27px;'></i>
                        <span class='light'>{$position}</span>
                    </a>
                    <span>({$label})</span><br/>
                ",
                "
                <div>
                    <i class='bi bi-geo-alt-fill' style='font-size: 20px;'></i>{$location}
                 </div>
                ",
                "
                <div style='margin:7px'>
                    {$date_created}
                </div>
                "
                
            );

            $num++;
        endforeach;
        echo json_encode(["data" => $data]);
        exit();
    }

    public function view($id)
    {
        $data['values'] = $this->job_application->view_values($id);
        $this->load->view('job-application/view', $data);
        // $this->load->view('job-application/layouts/footer');
    }

    public function apply()
    {
        $url = EMS_BASE_URL . "JobApp/get-legal-profile?Token={$this->token}";
        $data['mrfId'] =isset($_POST['mrfId']) ? $_POST['mrfId'] : 0;

        if (!empty($data['mrfId']) && isset($_POST['position'])) :
            $mrf_created_date = $this->job_application->getMrfCreatedDate($data['mrfId']);
            $mrf_created_date = new DateTime($mrf_created_date->MrfCreatedDate);
            $mrf_created_date = $mrf_created_date->format('Y');
            $position = $_POST['position'];
            $mrf_pad = str_pad($data['mrfId'], 4, 0, STR_PAD_LEFT);
            $title = " ({$mrf_created_date}-{$mrf_pad}, OPEN)";
        endif;
        $data['MrfTitle'] = isset($title) ? $title : '';
        $data['position'] = isset($position) ? $position : '';
        $data['widget'] = $this->recaptcha->getWidget(array('data-expired-callback' => 'recaptchaExpired'));
        $data['script'] = $this->recaptcha->getScriptTag();
        $data['courses'] = $this->getCourse();
        $data['positions'] = $this->getDesiredPosition();
        $data['genSource'] = $this-> getSource("generalSource");
        $data['specSource'] = $this-> getSource("specificSource");

        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data['error'] = $httpcode ;
        if ($httpcode == 200) :
            $data['ko_question'] = $this->getKickoutQuestion(isset($_POST['position_id']) ? base64_decode($_POST['position_id']) : 0);
            $data['legal'] = json_decode($output, 1);
        endif;
        
        $record = array();
        foreach($data['positions'] as $key => $value){
            $record[] = [
                "id" => $value['positionID'],
                "title" => $value['positionTitle'],
                "pLevelId" => $value['positionLevelID']
            ];
        }
       
        $this->load->view('job-application/jobapp-form', $data);
        
    }

    private function getSource($source_name){
        $url = EMS_BASE_URL . "JobApp/get-application-source-list?UserID=1&Token={$this->token}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($httpcode == 200) :
            $res =  json_decode($output, 1);
            return $res[$source_name];
        else:
            return [];
        endif;
       
    }

    public function getKickoutQuestion($position = ''){
        $url = EMS_BASE_URL . "JobApp/kickout-question?Token={$this->token}&PositionID={$position}";
        // var_dump($url);die();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode == 200) :
            // var_dump($output);die();
            return json_decode($output, 1);
        endif;
       
    }

    public function submit()
    {

        // var_dump('<pre>',$this->input->post());die;
        $post = $this->input->post();
        $file = $this->upload_file();
        if (!$file) :
            show_error("Unauthorized", 403, "Denied!");
        endif;

        $url = EMS_BASE_URL . "JobApp/add-applicant-online?Token={$this->token}";

        $ch = curl_init($url);
        $number = str_replace('-', '', $post["mobile_no"]);
        $obj = new stdClass();
        $obj->applicants = new stdClass();
        $obj->applicants->mrfId = intval($post["mrfId"]);
        $obj->applicants->positionRemarks = isset($post["applicant_position"]) ? $post["applicant_position"] : null;
        $obj->applicants->firstName = $post["applicant_fname"];
        $obj->applicants->middleName = $post["applicant_mname"];
        $obj->applicants->lastName = $post["applicant_lname"];
        $obj->applicants->suffix = $post["applicant_suffix"];
        $obj->applicants->psgcRegionCode = $post["psgc_region_code"]."0000000";
        $obj->applicants->psgcProvinceCode = $post["psgc_prov_code"]."00000";
        $obj->applicants->psgcCityMunicipalityCode =  $post["psgc_citymun_code"]."000";
        $obj->applicants->psgcBarangayCode = $post["psgc_brgy_code"];
        $obj->applicants->addressLine1 = $post["applicant_address"];
        $obj->applicants->email = $post["applicant_email"];
        $obj->applicants->cellphoneNumber = $number;
        $obj->applicants->birthDate = $post["applicant_birthdate"];
        $obj->applicants->course = $post["applicant_course"];
        $obj->applicants->currentPosition = $post["applicant_current_position"];
        $obj->applicants->expectedSalary = str_replace(',', '', $post["applicant_expected_salary"]);
        $obj->applicants->resume = $_FILES["resume"]["name"];
        $obj->applicants->resumeAttachment = $file['filename'];
        $obj->applicants->applicationSource = $_POST['app-source'];#"WEBSITE";
        $obj->applicants->applicationSourceSpecific = $_POST['specific-source'];

        $training_list = [];
        if (isset($post['training_name'][0]) && !empty($post['training_name'][0])) {
            foreach ($post['training_name'] as $key => $traning) {
                $list = (object)[
                    "topic"     => $traning,
                    "conductor" => $post['sponsored'][$key],
                    "dateFrom"  => $post['dated_from'][$key],
                    "dateTo"    => $post['dated_to'][$key]
                ];
                array_push($training_list, $list);
            }
        };
        $obj->addApplicantTrainingInputs = $training_list;

        $organization_list = [];
        if (isset($post['orgName'][0]) && !empty($post['orgName'][0])){
            foreach ($post['orgName'] as $key => $org){
                $list = (object)[
                    "organizationName" => $org,
                    "positionHeld"     => $post['positionHeld'][$key],
                    "dateJoined"       => $post['dateJoined'][$key]
                ];
                array_push($organization_list, $list);
            }
        };
        $obj->addApplicantOrganizationInputs = $organization_list;
        $legal = [];
        for ($i = 1; $i <= 4; $i++) :
            if (!isset($post["question{$i}"]) || $post["question{$i}"] != "LEGAL{$i}") continue;
            $legal[] = [
                "legalNumber" =>  $post["question{$i}"],
                "legalAnswer" =>  $post["question{$i}_answer"]
            ];
        endfor;

        #kickout question
        $koq = [];
        $length = count($post);
        for ($i = 1; $i <= $length; $i++) :
            if (!isset($post["koq_{$i}"])) continue;
            $koq[] = [
                "question"=>$i,
                "answer"  =>  $post["koq_{$i}"],
            ];
        endfor;
    
        $obj->addApplicantKickoutQuestionInputs = $koq;
        $obj->addApplicantLegalProfileInputs = $legal;

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $api_result = json_decode($result);
        $link = "";
        $message = "";
        if ($httpcode == 200) :
            $this->logs->user_log('EXTERNAL', 'INSERT', 'ems.tbl_applicant', $api_result->id, "SUCCESS: {$api_result->message}");
            $message = "Thank you for applying at Motortrade";
            $link = base_url()."careers";
        elseif ($httpcode == 400) :
            $this->logs->user_log('EXTERNAL', 'INSERT', 'ems.tbl_applicant', null, "ERROR: {$api_result->message}");
            if (file_exists($file['path']) && !unlink($file['path'])) die( 'Unable to delete ' . $file['path']);
            $message = "Applicant is already exists!";
            $link = base_url()."careers";
        else :
            $this->logs->user_log('EXTERNAL', 'INSERT', 'ems.tbl_applicant', null, "ERROR: {$httpcode}");
            if (file_exists($file['path']) && !unlink($file['path'])) die( 'Unable to delete ' . $file['path']);
            $message = "Sorry for the inconvenience, Something went wrong!";
            $link = base_url()."careers";
        endif;

        $res = [
            "status_code"   => $httpcode,
            "redirect_url"  => $link,
            "message"       => $message,
        ];

        echo json_encode($res);
    }

    public function upload_file()
    {

        if (!isset($_FILES["resume"])) return false;

        $filename = $_FILES["resume"]["name"];
        $tempname = $_FILES["resume"]["tmp_name"];

        $file_ext = explode('.', $filename);
        $file = explode('.', $filename)[0];
        $file_ext = $file_ext[count($file_ext) - 1];

        $date = new DateTime();

        $length = 4;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) :
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        endfor;

        $new_file_name = $date->format('YmdHis') . "_" . $randomString . "_" . $file . ".{$file_ext}";

        $folder = FCPATH . "assets/attachments/applicants_resume/";
        if (!is_dir($folder)) :
            if (!mkdir($folder, 0777)) :
                show_error("Unable to create a folder", 500, "Denied!");
            endif;
        endif;

        if (!move_uploaded_file($tempname, $folder . $new_file_name)) :
            return false;
        endif;

        return [
            "filename" => $new_file_name,
            "path" =>   $folder . $new_file_name
        ];
    }

    public function find_psgc()
    {
        return $this->inquiry->find_psgc();
    }

    public function sms_sending()
    {
        $api_key = SMS_API_KEY; // see https://telerivet.com/dashboard/api
        $project_id = SMS_PROJECT_ID;
        return 1;
        require_once(APPPATH . 'libraries/telerivet.php');

        $to_number = $_POST['value'];
        $content = 'Your OTP Code is ' . $_POST['getOTP'];

        $api = new Telerivet_API($api_key);

        $project = $api->initProjectById($project_id);

        try {
            $contact = $project->sendMessage(array(
                'to_number' => $to_number,
                'content' => $content
            ));
            // _jobAppOTPLogs($to_number, $_POST['getOTP'], $content);
            $_SESSION['sms_log'][] = $this->job_application->sms_log('Job Application', $to_number, 1);
        } catch (Telerivet_Exception $ex) {
            $er = $ex->getMessage();
            $_SESSION['sms_log'][] = $this->job_application->sms_log($er, $to_number, 0);
            echo "<div class='error'>" . htmlentities($ex->getMessage()) . "</div>";
        }
    }

    public function getCourse()
    {
        $url = EMS_BASE_URL . "JobApp/education-attainment?Token={$this->token}";
        $obj = new stdClass();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, 1);
    }

    public function getDesiredPosition()
    {
        $url = EMS_BASE_URL . "JobApp/get-all-positions?Token={$this->token}";
        $obj = new stdClass();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, 1);
    }
}
