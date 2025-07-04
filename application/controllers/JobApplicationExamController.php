<?php

defined('BASEPATH') or exit('No direct script access allowed');

class JobApplicationExamController extends CI_Controller
{
    public function __construct()
    {
        // die("UNDER MAINTENANCE");
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('JobApplicationExamModel', 'ja_model');
        $this->load->model('EmailNotifModel', 'email_notif');
    }

    public function index()
    {
        // if(isset($_SESSION['applicant_username'])){
        //     redirect('exam-view');
        // }
        $data = [];
        $this->load->view('job-application/LoginCredentialView', $data);
    }

    public function adminLogin()
    {

        $this->load->view('job-application/adminLoginView');
    }
    public function authAdmin()
    {
       
        $username = $this->input->post('admin_username');
        $password = $this->input->post('admin_password');
        $year = date('Y');
        $concat_pass = 'superadmin' . date('md');
        $_SESSION['login_tries'] = 0;
        $result['result'] = 0;
        $result['mssg'] = 'Invalid username or password';
        if ($_SESSION['login_tries'] > 5) {
            $result['mssg'] = 'Too many login attempts. Please try again later.';
        } else {
            if (in_array($username, ['HR-ADMIN' . $year, 'HRBP-ADMIN' . $year, 'SUPER@DMIN'])) {
                if ($password == $concat_pass) {
                    $_SESSION['jobapp_super_admin'] = $username == 'SUPER@DMIN' ? 1:0;
                    $_SESSION['jobapp_admin_user'] = $username;
                    $_SESSION['jobapp_admin_pass'] = $password;
                    $_SESSION['login_tries'] = 0;
                    $result['result'] = 1;
                    $result['mssg'] = 'Welcome';
                } else {
                    $_SESSION['login_tries'] = $_SESSION['login_tries'] + 1;
                }
            } else {
                $_SESSION['login_tries'] = $_SESSION['login_tries'] + 1;
            }
        }
        echo json_encode($result);
    }
    public function examAdminView()
    {
        if (!isset($_SESSION['jobapp_admin_user'])) {
            redirect('jobapp/admin');
        }
        $this->deleteCachedData('exam-admin-view+index');
        $result = $this->ja_model->getAllApplicants();
        $maintenance = (int)$this->ja_model->getControl('Maintenance')->Action;
        $jumble_part_1 = (int)$this->ja_model->getControl('jumble_part_1')->Action;
        $jumble_part_2 = (int)$this->ja_model->getControl('jumble_part_2')->Action;
        $jumble_part_3 = (int)$this->ja_model->getControl('jumble_part_3')->Action;
        // var_dump('<pre>',$result);die;
        // $data['total_pass_1'] = $result['pass_1'];
        // $data['total_pass_2'] = $result['pass_2'];
        // $data['total_pass_3'] = $result['pass_3'];
        $data['applicants'] =  $result ;#$result['applicant'];
        $data['maintenance'] = $maintenance;
        $data['jumble_part_1'] = $jumble_part_1;
        $data['jumble_part_2'] = $jumble_part_2;
        $data['jumble_part_3'] = $jumble_part_3;
        $this->load->view('job-application/examAdminView', $data);
    }
    public function checkApplicant()
    {
      
        $api_result = $this->getApplicantAPI($_POST['email'], $_POST['applicant_id']);
        $result['result'] = 0;
        if (!empty($api_result)) {
            $_SESSION['applicant_username'] = $_POST['applicant_id'];
            $_SESSION['applicant_fname'] = $api_result["personalInformation"]["firstName"];
            $_SESSION['applicant_lname'] = $api_result["personalInformation"]["lastName"];
            $_SESSION['applicant_mname'] = $api_result["personalInformation"]["middleName"];
            $_SESSION['applicant_email'] = $api_result["personalInformation"]["email"];
            $_SESSION['applicant_contact'] = $api_result["personalInformation"]["cellphoneNumber"];
            $_SESSION['position_applied'] = $api_result["positionRemarks"];
            $result['result'] = 1;
        } else {
            $result['error'] = $api_result;
            unset($_SESSION['applicant_username']);
        }
        echo json_encode($result);
    }
   
    public function Questionaire()
    {
        if (!isset($_SESSION['applicant_username'])) {
            redirect('jobapp-exam');
        }

        $control = (int)$this->ja_model->getControl('Maintenance')->Action;


        if($control == 1){
            $this->load->view('job-application/MaintenanceView');
            // die;
        }else{
       
        #----check if already answered---


        #---------------------------------
        $this->deleteCachedData();

        # assign default part value
        $part_id = 1;
        $timer = 900;
        $time_display = '--:--';

        #for timer per part
        if (!empty($this->getPartIdsByPartId(1, $_SESSION['applicant_username']))) {
            $part_id = 2;
            $timer = 600;
            // $time_display = '10:00';
        }
        if (!empty($this->getPartIdsByPartId(2, $_SESSION['applicant_username']))) {
            $part_id = 3;
            $timer = 300;
            // $time_display = '5:00';
        }
        if (!empty($this->getPartIdsByPartId(3, $_SESSION['applicant_username']))) {
            $part_id = 0;
        }

        $group_array = $this->ja_model->getPartIdsByPartId($part_id);
        $all_question = [];

        #build all data
        foreach ($group_array as $key_group => $gr) {
            #get all question per part
            $question = $this->ja_model->getQuestions((int)$gr->GroupId, $part_id);
            #set an empty array for questionaire
            $exam_questions = [];
            if (!empty($question)) {
                #shuffle questions before create a object
               if(in_array($gr->GroupId,[1])){
                shuffle($question);
               } 
                #customize questionaire
                foreach ($question as $key => $value) {
                    $exam_object = (object)[
                        'question_id' => $value->id,
                        'Question' => $value->Question,
                        'AnswerChoices' => (object) $this->getChoicesById($value->id), #get answer choices based on question id
                    ];

                    array_push($exam_questions, $exam_object);
                }

                array_push($all_question, (object)[
                    'group_id' => $gr->GroupId,
                    'part_label' => $this->getGroupDetails($gr->GroupId, $part_id)[0]->GroupLabel,
                    'instruction' => $this->getGroupDetails($gr->GroupId, $part_id)[0]->Instruction,
                    'group_question' => $exam_questions
                ]);
            }
        }

        $data['time_display'] = $time_display;
        $data['timer'] = $timer;
        $data['part'] = $part_id;
        $data['data_part'] = empty($all_question) ? 0 : 1;
        $data['all_question'] = $all_question;
        $this->load->view('job-application/QuestionsView', $data);

    }
    }
    public function deleteCachedData($cache_name = 'exam-view+index')
    {
      
        $dir_path = './application/cache/' . $cache_name;
        if (is_dir($dir_path)) {
            $this->recursiveRemoveDirectory($dir_path);
            // echo "Directory deleted successfully.";
        } else {
            // echo "Directory does not exist.";
        }
    }
    public function storeAnswer()
    {
        $data = json_decode($_POST['data']);
        $part = json_decode($_POST['part']);
        $store_data = [];
        foreach ($data as $key => $value) {
            $collect_data = [
                'QuestionId'    => $value->question_id,
                'AnswerId'      => $value->value,
                'isCorrect'     => $value->isCorrect,
                'ApplicantId'   => $value->applicant_id,
                'GroupId'       => $value->group_id,
                'PartId'        => $part
            ];
            array_push($store_data, $collect_data);
        }

        $check_existing = $this->ja_model->checkApplicantTake($_SESSION['applicant_username']);
        if ($part == 1 && empty($check_existing)) {
            $applicant_take = [
                'ApplicantId' => $_SESSION['applicant_username'],
                'Email'        => $_SESSION['applicant_email'],
                'Contact'      => $_SESSION['applicant_contact'],
                'Fname'        => $_SESSION['applicant_fname'],
                'Lname'        => $_SESSION['applicant_lname'],
                'Mname'        => $_SESSION['applicant_mname'],
                'PositionApplied' => $_SESSION['position_applied'],
            ];
            $store = $this->ja_model->storeApplicantTake($applicant_take);
        } else {
            $store = 1;
        }
        $result = 0;
        if ($store == 1) {
            $store_result = $this->ja_model->storeAnswer($store_data);
            if($store_result == 1 && $part == 3){
                $this->getExamResult(base64_encode($_SESSION['applicant_username']),'auto');
            }
            $result = 1;
        } 

        echo json_encode($result);  
    }
    public function transferAdmin($applicant){

        $transfer = $this->getExamResult($applicant,'manual');
        echo json_encode($transfer);
    }
    public function getExamResult($applicant_id,$store_ems = null)
    {
        $this->deleteCachedData('getExamResult+'.$applicant_id);
        $count_question = $this->ja_model->questionPerCount();
        $ems_score = [];
        $all_correct = 0;
        $all_question = 0;
        $question_count = [];
        
        foreach ($count_question as $key => $value) {

            #overwrite part 3,  50 question minus by 10 
            $part_question_count = $value->Part == 3?  (int)$value->q_count - 10 :(int)$value->q_count ;
            $part_question_count = $value->Part == 1?  (int)$value->q_count - 3 : $part_question_count;
            $exam_result =  $this->ja_model->getApplicantExamData( base64_decode($applicant_id), $value->Part)[0]->count_data;
            $exam_result =  $value->Part == 3 &&  $exam_result >= 40 ? 40 : (int)$exam_result;
            $exam_result =  $value->Part == 1 &&  $exam_result >= 27 ? 27 :  $exam_result;
            $percentage[$value->Part] = (float) round(($exam_result / $part_question_count) * 100, 2);
            
            /*
            // $question_count[$value->Part] =  $part_question_count;
            // $result[$value->Part] =  $exam_result;
            */
           
            $question_count[$value->Part] =  $part_question_count;
            array_push($ems_score,(object)[
                'partID' => (int)$value->Part,
                'score' =>  (int)$exam_result,
                'Items' => (int)$part_question_count
            ]);
            $display_result[$value->Part] =  $exam_result . '/' .  $part_question_count;
            $all_correct += $exam_result;
            $all_question += $part_question_count;

        }
        // var_dump('<pre>',$ems_score);die;
        $data['results'] = [
            'percentage' => $percentage,
            'total' => $all_question,
            'question_count' => $question_count,
            'all_correct' => $all_correct,
            'ovarall_percentage_by_score' => (float) round(($all_correct / $all_question) * 100, 2),
            'ovarall_percentage' => (float) round(($all_correct / $all_question) * 100, 2),
            'display_result' => $display_result
        ];

        if(!empty($store_ems)){
            $check_score = 0;
            foreach($data['results']['percentage'] as $key => $value){
                $check_score += $value;
            }
            $result_api = 0;
            $result_total = $check_score / count($data['results']['percentage']);

            #if score is greater than or equal to 65%, then store to EMS
            if($result_total >= 65 || $store_ems == 'manual'){
                $result_api = $this->storeResultToEMS($ems_score, (int)base64_decode($applicant_id));
            }
            return $result_api;
        }else{
            echo json_encode($data);
        }
        
    }
    public function getExamResultAll(){
        $data['result'] = 0;
        $data['data'] = [];
        $data['date_export'] = date('Ymdhis');
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        if(isset($_POST['auth_export'])){
            $all_applicants = $this->ja_model->getAllApplicants($date_from, $date_to);
            $data_all_record = [];
            $all_question_ids = $this->ja_model->getAllQuestionIds();
            $data['result'] = 1;
           
            foreach ($all_applicants as $key_app => $applicant) {
                $applicantData = (object)[
                    'Applicant ID' => $applicant->ApplicantId,
                    'Date Taken' => date('F j, Y', strtotime($applicant->CreatedDate)),
                    'Last Name' => $applicant->Lname,
                    'First Name' => $applicant->Fname,
                    'Middle Name' => $applicant->Mname,
                    'Position Applied' => $applicant->PositionApplied,
                    'Contact' => $applicant->Contact,
                    'Email' => $applicant->Email,
                    'Exam Take count' => $applicant->ExamTake,
                ];
                $correct_data = 0;
                foreach ($all_question_ids as $key => $q) {
                    $group_display = $q->Part == 1 ? '-G'.$q->GroupId : '';
                    $question_key = 'P'.$q->Part.$group_display.'-'.$q->id;
                    $data_isCorrect =  $this->ja_model->getresultById($applicant->ApplicantId, (int)$q->id);
                    if($data_isCorrect == 'TRUE'){
                        $correct_data++;
                    }
                    $applicantData->$question_key = $data_isCorrect ;
                }
                $over_all_column = "Overall average score";
                $applicantData->$over_all_column = (float) round(($correct_data / count($all_question_ids)) * 100, 2).'%';
                array_push($data_all_record, $applicantData);
            }

            $data['data'] = $data_all_record;
           
        }
        

        echo json_encode($data);
    }
    public function getAllApplicant(){
     
        $fetch = $this->getAllAPicantAPI();
        $data_custome = [];
      
        foreach ($fetch as $key => $value) {
            array_push($data_custome,[
                'dateApplied' => $value['dateApplied'],
                'cellphoneNumber' => $value['cellphoneNumber'],
                'id' => $value['id'],
                'name' => $value['name'],
                'email' => $value['email'],
                'inviteSent' => $this->ja_model->checkSentInvite($value['id'])

            ]);
        }
        

         $data['result'] = $data_custome;
        echo json_encode($data);
    }
    public function sendEmailInvite(){

        echo json_encode(0);
    }
    public function examMaintenance(){
        foreach ($_POST as $key => $value) {
            $this->ja_model->updateMaintenance($key, (int)$value);
        }
        echo json_encode(1);
    }

    public function retakeApplicant(){
        // var_dump($_POST);die;
        $this->ja_model->retakeApplicant($_POST['app_id']);
    }
    private function getAllAPicantAPI(){
        $token =  _getApiToken("ONLINEEXAM");
        $url = EMS_BASE_URL . "/OnlineExam/get-applicants-without-exam?UserID=1&Token={$token}";
        $obj = new stdClass();
        $obj->dateFrom = $_POST['date_from'];
        $obj->dateTo = $_POST['date_to'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode == 200) {
            return json_decode($output, 1);
        } else {
            return 0;
        }
    }
    private function getApplicantAPI($email, $applicant_id)
    {

        $token =  _getApiToken("ONLINEEXAM");
        
        $url = EMS_BASE_URL . "OnlineExam/get-applicant-by-id-email?UserID=1&Token={$token}&Email={$email}&ApplicantID={$applicant_id}";
        $obj = new stdClass();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode == 200) {
            return json_decode($output, 1);
        } else {
            echo json_encode([
                'url'       => $url,
                'httpcode'  => $httpcode,
                'output'    => $output
            ]);
            return 0;
        }
    }
    private function getApplicantExamData()
    {
        $applicant = $this->ja_model->getAllApplicants();
        $question_cont_1 = (int)$this->ja_model->countQestions(1)[0]->count_data;
        $question_cont_2 = (int) $this->ja_model->countQestions(2)[0]->count_data;
        $question_cont_3 = (int) $this->ja_model->countQestions(3)[0]->count_data;
        $count_pass_1 = 0;
        $count_pass_2 = 0;
        $count_pass_3 = 0;
        foreach ($applicant as $key => $value) {
            $part1 = (int) $this->ja_model->getApplicantExamData($value->ApplicantId, 1)[0]->count_data;
            $part2 = (int) $this->ja_model->getApplicantExamData($value->ApplicantId, 2)[0]->count_data;
            $part3 =  (int)$this->ja_model->getApplicantExamData($value->ApplicantId, 3)[0]->count_data;

            $result_part_1 =  round(($part1 / $question_cont_1) * 100, 2);
            $result_part_2 =  round(($part2 / $question_cont_2) * 100, 2);
            $result_part_3 =  round(($part3 / $question_cont_3) * 100, 2);

            if ($result_part_1 > 78) {
                $count_pass_1++;
            }
            if ($result_part_2 > 78) {
                $count_pass_2++;
            }
            if ($result_part_3 > 78) {
                $count_pass_3++;
            }
        }

        $data['pass_1'] =  $count_pass_1;
        $data['pass_2'] =  $count_pass_2;
        $data['pass_3'] =  $count_pass_3;

        $data['part1'] =   $question_cont_1;
        $data['part2'] =   $question_cont_2;
        $data['part3'] =   $question_cont_3;
        $data['applicant'] = $applicant;
        return  $data;
    }
    private function getPartIdsByPartId($part_id, $applicant_id)
    {
        return (int)$this->ja_model->checkpart_id($part_id, $applicant_id)[0]->count_data;
    }
    private function getChoicesById($id)
    {
        $choices = $this->ja_model->getChoices($id);
        return $choices;
    }
    private function getGroupDetails($id, $part_id)
    {
        $group = $this->ja_model->getGroupDetails($id, $part_id);
        return $group;
    }
    private function recursiveRemoveDirectory($dir_path)
    {
        if ($handle = opendir($dir_path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != '.' && $entry != '..') {
                    if (is_dir($dir_path . '/' . $entry)) {
                        $this->recursiveRemoveDirectory($dir_path . '/' . $entry);
                    } else {
                        unlink($dir_path . '/' . $entry);
                    }
                }
            }
            closedir($handle);
        }
        rmdir($dir_path);
    }
    private function storeResultToEMS($data, $applicant_id)
    {
        $token =  _getApiToken("ONLINEEXAM");
        
        $url = EMS_BASE_URL . "/OnlineExam/add-applicant-online-exam?UserID=1&Token={$token}";
        $obj = new stdClass();
        $obj->applicantID = $applicant_id;
        $obj->addApplicantOnlineExam = $data;

       
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
       
        if ($httpcode == 200) {
           $reult_update = $this->ja_model->updateApplicantTake($applicant_id);
            return $reult_update ;
        } else {
            return 0;
        }
    }
    public function logout($desination) {
        // $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();

        if($desination == 'admin'){
        redirect('jobapp/admin');
        }
        else{
            redirect('jobapp-exam');
        }
        
    }

    public function getOtpLogs(){
       
        $data['logs'] = $this->ja_model->getOtpLogs();

        echo json_encode($data);
    }

    public function sendEmailIOtp(){
        // var_dump($_POST);die;
        $otp = $_POST['otp'];
        $email = $_POST['email'];
        $Subject = 'MOTORTRADE | One Time Password';
         $content = "Your OTP Code is {$otp}. Please do not share your code for security purposes. <br><br><br>
                    <i>This is an auto generated email. Please do not reply to this email.</i>";
        $send_data = $this->email_notif->sendOtp($email, $content, $Subject, $cc = []);
                    $this->email_notif->monitorOTP($email, $content,$_POST['otp']);

        echo json_encode(1);
    }
    public function monitorOtp(){

        $result = $this->email_notif->monitorOTP('clemisten@gmail.com','Sample send','Test Email', $cc = [],true);

        var_dump($result);
    }
}
