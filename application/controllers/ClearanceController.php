<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class ClearanceController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('recaptcha', 'application\libraries');
        if(isset($_SESSION['expire'])):

          $now = time();
          // echo json_encode($now. '   ' );
          // echo json_encode($_SESSION['expire']);
      
          if($now > $_SESSION['expire']):
          // $this->logout();
          else:
            // $this->extendMe();
          endif;

        endif;
      

    }

    public function index()
    {
       
        if(isset($_SESSION['systemAccessId'])):
            redirect('mainview');
          endif;
          $data['widget'] = $this->recaptcha->getWidget(array('data-expired-callback' => 'recaptchaExpired'));
          $data['script'] = $this->recaptcha->getScriptTag();
        $this->load->view('clearance/ClearanceLogin',$data);
    }

    public function logIn(){

      $post = $this->input->post();
      $obj = new stdClass();
      $obj->employeeid =  trim($post['id']);
      $obj->lastname = trim($post['lastname']);
      $obj->birthDate = trim($post['birthday']);
      $token = _getApiToken("CLEARANCE");
      
     
      $url = EMS_BASE_URL."Clearance/employee-login?TOKEN=". $token;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      $response = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      if($httpcode != 200):
        // $_SESSION['attempt'] += 1;
        // if($_SESSION['attempt'] == 5): //set the time to allow login if third attempt is reach
        //   $_SESSION['attempt_again'] = time() + (2*60);
        //   $_SESSION['timer'] = 1*60; //note 5*60 = 5mins, 60*60 = 1hr, to set to 2hrs change it to 2*60*60
          
        // endif;
        $res = [
          'response' => false,
          'message' => 'Connection Error!',
          'redirect' => ''
        ];
        echo json_encode($res);
        return FALSE;
      endif;
      
      $_SESSION['success'] = 'Login successful';

      // $this->extendMe();

      $response = json_decode($response);
      $_SESSION['credentials'] = $response;
      
      #set Session
      $this->setSession($response);
      
    //   $_SESSION['username'] = $_SESSION['credentials']['employeeId'];

      $res = [
        'response' => true,
        'message'  => '',
        'redirect' => base_url() ."mainview"
      ];
      echo json_encode($res); 
    }

    public function extendMe(){
      $_SESSION['start'] = time(); 
      $_SESSION['expire'] = time() + (300) ; 

    }

    public function mainView(){
      if(!isset($_SESSION['systemAccessId'])):
        redirect('clearance');
      endif;

      // $this->extendMe();
      $data['credentials'] = $_SESSION['credentials'];
      $this->load->view('clearance/MainView',$data);
    
    }
    public function getAllClearance(){

      $post = $this->input->post();
      $obj = new stdClass();
    //   $obj->empId =  trim($post['id']);
      $token = _getApiToken("CLEARANCE");

      // $this->extendMe();
      
      $url = EMS_BASE_URL."Clearance/employee-accountability-by-id?Token=". $token .'&EmpId='.trim($post['id']);
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      $response = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);

     $data['Accountability'] = json_decode($response)[0]->employeeAccountability;
    
      $account_count = count($data['Accountability']);
     $data['interview'] =  $this->getInterviewResult();

     $cleared_count = 0;
     foreach( $data['Accountability'] as $account){
        if($account->status == 'CLEARED' || $account->status == 'CANCELLED'){
          $cleared_count ++;
        }
     }
     $data['cleared_all']  = $cleared_count == $account_count ? 1:0;
     # add to session for monitoring
     $_SESSION['accountability'] = $data['Accountability'];
     $_SESSION['account_count']  =  $account_count;
     $_SESSION['clear_count'] =  $cleared_count;

     echo json_encode($data);
    }


    private function getInterviewResult(){

        $obj = new stdClass();
        $obj = (int) $_SESSION['Exit_clearance_employee_id'] ;
        $token = _getApiToken("CLEARANCE");
        
        $url = EMS_BASE_URL."Clearance/get-employee-accountability-exit-clearance?UserID=".$_SESSION["systemAccessId"]."&Token=". $token;

        // var_dump($obj);die();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
      
       return json_decode($response) == true ? 1 :0;
        

    }
    private function setSession($response){
      // var_dump($response);die;
      #system data
      $_SESSION['Empid']                      =$response->id;
      $_SESSION['systemAccessId']             =$response->systemUserID;
      $_SESSION['EmpCode']                    =$response->code;
      $_SESSION['Exit_clearance_employee_id'] =$response->id;

      #company data
      $_SESSION['position']                   =$response->positionTitle;
      $_SESSION['positionID']                 =$response->positionID;
      $_SESSION['positionCode']               =$response->positionCode;
      $_SESSION['company']                    =$response->companyCode;
      $_SESSION['dateHired']                  =$response->dateHired;
      $_SESSION['resignedDate']               =$response->resignedDate;
      $_SESSION['orgGroupID']                 =$response->orgGroupID;
      $_SESSION['orgCode']                    =$response->orgCode;
      $_SESSION['orgDescription']             =$response->orgDescription;
      $_SESSION['companyDescription']         =$response->companyDescription;
      $_SESSION['accountabilityStatus']       =$response->accountabilityStatus;
      $_SESSION['totalAccountability']        =$response->totalAccountability;
      $_SESSION['agreed']                     =$response->agreed;
      $_SESSION['agreedDate']                 =$response->agreedDate;

      #employee data
      $_SESSION['fullname']                   =$response->fullName;
      $_SESSION['firstname']                  =$response->firstName;
      $_SESSION['middlename']                 =$response->middleName;
      $_SESSION['lastName']                   =$response->lastName;
      $_SESSION['email']                      =$response->email;
      $_SESSION['number']                     =$response->number;
      
      
    }

    public function getComment(){
       $reload = !isset($_SESSION['systemAccessId']) ?1:0;
      //  $this->extendMe();
      $id = $this->input->post('clearance_id');
      $obj = new stdClass();
      $obj->ID = (int)$id;
      $token = _getApiToken("CLEARANCE");
      $url = EMS_BASE_URL."Clearance/get-accountability-comment?Token=". $token;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      $response = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      $response = json_decode($response);
      // krsort($response);
      $data['response'] = $response;
      $lastcomment =end($response);
      // var_dump(end($response));die();
      $html = $this->load->view('clearance/CommentView', $data, true);

      // var_dump($html);die();
      echo json_encode([
        'html'=> $html,
        'lastcomment'=> $lastcomment,
        'clearance_id' => $id,
        'reload'=>$reload
      ]);
    }
    
    public function storeComment(){

      // $this->extendMe();

      $id = $this->input->post('c_id');
      $comment = $this->input->post('c_text');
      $obj = new stdClass();
      $obj->employeeAccountabilityID = (int)$id;
      $obj->comments = $comment;
      $obj->createdBy = (int) $_SESSION['systemAccessId'];
      $token = _getApiToken("CLEARANCE");

      $url = EMS_BASE_URL."Clearance/add-accountability-comment?Token=". $token;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      $response = curl_exec($ch);
      // var_dump($response);die();
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);

      echo json_encode([
        'response'  => true,
        'message' => $response
      ]);
    
    }

    public function logOut(){

      $user_data = $this->session->all_userdata();
      foreach ($user_data as $key => $value) {
          if ($key != 'Empid' && $key != 'fullname' && $key != 'firstname' && $key != 'middlename' && $key != 'lastName'&& $key != 'email'&& $key != 'position' && $key != 'company'&& $key != 'systemAccessId' ) {
              $this->session->unset_userdata($key);
          }
      }
      $this->session->sess_destroy();
      redirect('clearance');

    }
    public function editEmail(){
      // $this->extendMe();
      $post = $this->input->post();
      $obj = new stdClass();
      $obj->id = (int) $_SESSION['Empid'] ;
      $obj->email = $post['email'];
      // var_dump($_SESSION['Empid']);die();
      $token = _getApiToken("CLEARANCE");

      $url = EMS_BASE_URL."Clearance/edit-employee-email?Token=". $token;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      $response = curl_exec($ch);

      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      if($httpcode != 200):
         $res = [
          'response' => false,
          'message' => 'Error in updating, please Contact IT Developer Team'          
        ];
        echo json_encode($res);
        
        return FALSE;
      endif;
      
      $_SESSION['email'] = $post['email'];
      

      echo json_encode([
        'response'  => true,
        'message' => $response
      ]);
    }
    public function changeStatus(){
      
      if($_POST['verify'] == 1){
        $obj = new stdClass();
        $obj = (int) $_POST['accountability_id'] ;
        $token = _getApiToken("CLEARANCE");
        
        $url = EMS_BASE_URL."Clearance/change-status?UserID=".$_SESSION["systemAccessId"]."&Token=". $token;

        // var_dump($obj);die();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpcode == 200):
          echo json_encode([
            'success'=> 1
          ]);
        else:
          echo json_encode([
            'success'=> 0
          ]);
        endif;
       
      }
      else{
        echo json_encode([
          'success'=> 0
        ]);
      }
    }

    public function exitInterview(){
      $checker = $this->getInterviewResult();
      if( $checker == 1){
        redirect('clearance');
      }
        
      $obj = new stdClass();
      if(!isset($_SESSION['Exit_clearance_employee_id'])){
        redirect('clearance');
      };

      $obj->ID = (int)$_SESSION['Exit_clearance_employee_id'];
      $token = _getApiToken("CLEARANCE");

      
      $url = EMS_BASE_URL."Clearance/get-exit-clearance-question?Token=". $token;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      $response = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);


      // $response = $this->getSampleData();
      $data['exit_question'] = json_decode($response);
    
      $this->load->view('clearance/ExitQuestionView',$data);

    }
    public function storeInterview()
    {
      // echo json_encode($_POST);die;
      $data = [];
      #for letter A
      if(isset($_POST['third17'])){
        $obj1 = new stdClass();
        $obj1->employeeID = $_SESSION['Exit_clearance_employee_id'];
        $obj1->questionID = 17;
        $obj1->answerID = (int)$_POST['third17'];
        $obj1->answerDetails = null;

      }
      if(isset($_POST['third18'])){
        $obj2 = new stdClass();
        $obj2->employeeID = $_SESSION['Exit_clearance_employee_id'];
        $obj2->questionID = 18;
        $obj2->answerID =(int) $_POST['third18'];
        $obj2->answerDetails = null;
      }
      if(isset($_POST['second4'])){
        $obj3 = new stdClass();
        $obj3->employeeID = $_SESSION['Exit_clearance_employee_id'];
        $obj3->questionID = 19;
        $obj3->answerID = 0;
        $obj3->answerDetails = null;
      }

      if(isset($obj1)){
       array_push($data,$obj1);
      }elseif(isset($obj2)){
       array_push($data,$obj2);
      }elseif(isset($obj3)){
       array_push($data,$obj3);
      }
      # end letter A

      #letter B
      if(isset($_POST['question-5'])){
        $obj4 = new stdClass();
        $obj4->employeeID = $_SESSION['Exit_clearance_employee_id'];
        $obj4->questionID = 5;
        $obj4->answerID = (int)$_POST['question-5'];
        $obj4->answerDetails = isset($_POST['remarks_13']) ? $_POST['remarks_13'] : null;
      }
        isset($obj4) ? array_push($data,$obj4) : null;
      #letter C
      if(isset($_POST['question-6'])){
        $obj5 = new stdClass();
        $obj5->employeeID = $_SESSION['Exit_clearance_employee_id'];
        $obj5->questionID = 6;
        $obj5->answerID = (int)$_POST['question-6'];
        $obj5->answerDetails = isset($_POST['remarks_17']) ? $_POST['remarks_17'] : null;
      }
        isset($obj5) ?  array_push($data,$obj5) : null;
      
      #mobile number
      if(isset($_POST['mobile_number'])){
        $number = '09'.$_POST['mobile_number'];
        $objnum = new stdClass();
        $objnum->employeeID = $_SESSION['Exit_clearance_employee_id'];
        $objnum->questionID = 21;
        $objnum->answerID = 0;
        $objnum->answerDetails = $number;
      }
      isset($objnum) ?  array_push($data,$objnum) : null;

      #mobile number
      if(isset($_POST['suggestion_13'])){
        
        $objsuggestion = new stdClass();
        $objsuggestion->employeeID = $_SESSION['Exit_clearance_employee_id'];
        $objsuggestion->questionID = 13;
        $objsuggestion->answerID = 0;
        $objsuggestion->answerDetails = $_POST['suggestion_13'];
      }
      isset($objsuggestion) ?  array_push($data,$objsuggestion) : null;

        $questions =[];
        for( $i = 4  ;$i<100;$i++){
          $questions[$i] =  isset($_POST['subAnswer-'.$i]) ? $_POST['subAnswer-'.$i] : null;
        }

        foreach($questions as $key =>  $answer ){
          if($answer == null) continue;
          $obj = new stdClass();
          $obj->employeeID = $_SESSION['Exit_clearance_employee_id'];
          $obj->questionID = $key;
          $obj->answerID = (int)$answer;
          $obj->answerDetails = isset($_POST['remarks_'.$answer]) ? $_POST['remarks_'.$answer] : null ;
          array_push($data,$obj);
          
        }

       $count = count($_POST['name']);
       $answerDetails = '';
        for($n = 0 ;$n < $count;$n++){
         $and = $n == $count-1 ? '': '&&';
           $answerDetails .= $_POST['name'][$n].'|'.$_POST['branch'][$n].'|'.$_POST['datefrom'][$n].'|'.$_POST['dateto'][$n].$and ;
        }

        if(isset($_POST['name'])){
          $object = new stdClass();
          $object->employeeID = $_SESSION['Exit_clearance_employee_id'];
          $object->questionID = 14;
          $object->answerID = 0;
          $object->answerDetails = $answerDetails;
          array_push($data,$object);

        }
        $token = _getApiToken("CLEARANCE");
        $url = EMS_BASE_URL."/Clearance/add-question-employee-answer?UserID=".$_SESSION["systemAccessId"]."&Token=". $token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
       
    if($httpcode == 200){
      echo json_encode([
        'response'  => true,
        'message' => $response,
        'http'    => $httpcode,
        'object'    => json_encode($data)
      ]);
    }
    else{
      echo json_encode([
        'response'  => false,
        'message'   => $response,
        'http'      => $httpcode,
        'object'    => json_encode($data)
      ]);

    }
    
       
    }
   

   public function getLastPay(){
      $obj = new stdClass();
      $obj = (int)$_SESSION['Empid'];
      $token = _getApiToken("CLEARANCE");
      $url = EMS_BASE_URL."Clearance/get-employee-last-pay-details?Token=". $token;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $obj);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      $response = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      
      curl_close($ch);
     echo $response;

   }
   public function lastPayComment(){
    $obj = new stdClass();
    $obj->clearedEmployeeID = (int)$_POST['comment_Id'];
    $obj->comments = $_POST['lastpaycomment'];

    $token = _getApiToken("CLEARANCE");

    $url = EMS_BASE_URL."Clearance/add-cleared-employee-comment?UserID=".$_SESSION["systemAccessId"]."&Token=". $token;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
   echo $response;

 }
  
  public function downloadCoe()
  {
    $response = $this->load->view('clearance/CoeTemplateView');
    echo json_encode($response);
  }

  public function DownloadAction()
  {
    if(!isset($_SESSION['fullname'])) {
      redirect('clearance');
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    echo '<link rel="icon" href="assets/favicon.ico"><title>EMS | Clearance</title>';

    require FCPATH . 'Mpdfvendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf(['margin_footer' => 0]);
    $stylesheet = base_url() . 'assets/clearance_assets/COE_css/coe.css';
    $data['fullname'] = $_SESSION['fullname'] ;
    $data['companyDescription'] = $_SESSION['companyDescription'] ;
    $data['dateHired'] = $_SESSION['dateHired'] ;
    $data['resignedDate'] = $_SESSION['resignedDate'];
    $data['position'] = $_SESSION['position'];
    $data['orgCode'] = $_SESSION['orgCode'];
    $data['orgDescription'] = $_SESSION['orgDescription'];
    $data['accountabilityStatus'] = $_SESSION['accountabilityStatus'];
    $data['lastName'] = $_SESSION['lastName'];

    $html = $this->load->view('clearance/CoeTemplateView', $data, true);
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, 2);
    $mpdf->SetHTMLFooter('<i style="color:gray;font-size:12px;padding-bottom:5px;"> This is system generated, signature is not required. </i>');
    $mpdf->OutputHttpDownload($_SESSION['lastName'].'.pdf'); #view pdf

    // $file= $_SESSION['lastName'].'_'.$_SESSION['firstname'].'_COE.pdf';
    // $mpdf->OutputHttpDownload($file); #download
  }

  public function agreeAction()
  {
    $obj = new stdClass();
    $obj = (int)$_POST['id'];
    $token = _getApiToken("CLEARANCE");

    $url = EMS_BASE_URL . "/Clearance/add-cleared-employee-agreed?Token=" . $token;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $obj);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($httpcode == 200){
        $_SESSION['agreed'] = 1;
        echo 1;
    }
    else{
        echo 0;
    }
   
  }

  # this data for offline
  public function getSampleData()
  {

    return '[{"id":1,"category":"EXITINTERVIEW","code":"Q1","question":"1. What is your reason for leaving? (Dahilan ng paglisan sa kumpanya?) ","questionType":"CHECKBOX","answerType":"CHECKBOX","parentQuestionID":0,"tab":0,"order":1,"isRequired":true,"subQuestion":[{"id":4,"category":"EXITINTERVIEW","code":"Q2","question":"A. Compensation and Benefits","questionType":"CHECKBOX","answerType":"RADIO","parentQuestionID":1,"tab":1,"order":2,"isRequired":true,"subQuestion":[{"id":19,"category":"EXITINTERVIEW","code":"Q13","question":"a. Salary/ Greener pasture","questionType":"RADIO","answerType":"RADIO","parentQuestionID":4,"tab":2,"order":3,"isRequired":true,"subQuestion":null,"answer":null},{"id":17,"category":"EXITINTERVIEW","code":"Q14","question":"b. HMO (if yes, please choose the reason below):","questionType":"RADIO","answerType":"RADIO","parentQuestionID":4,"tab":2,"order":4,"isRequired":true,"subQuestion":null,"answer":[{"id":37,"questionID":17,"answer":"i. Given upon hire","addReason":false},{"id":38,"questionID":17,"answer":"ii. With coverage of dependents","addReason":false},{"id":39,"questionID":17,"answer":"iii. Outpatient coverage","addReason":false}]},{"id":18,"category":"EXITINTERVIEW","code":"Q15","question":"c. Leave Credits (Choose only one below):","questionType":"RADIO","answerType":"RADIO","parentQuestionID":4,"tab":2,"order":5,"isRequired":true,"subQuestion":null,"answer":[{"id":40,"questionID":18,"answer":"i. Available upon hire or upon regularization","addReason":false},{"id":41,"questionID":18,"answer":"ii. Higher leave credits","addReason":false}]}],"answer":null},{"id":5,"category":"EXITINTERVIEW","code":"Q3","question":"B. Other opportunity","questionType":"CHECKBOX","answerType":"RADIO","parentQuestionID":1,"tab":1,"order":6,"isRequired":true,"subQuestion":null,"answer":[{"id":10,"questionID":5,"answer":"A. Work abroad","addReason":false},{"id":11,"questionID":5,"answer":"B. Practicing profession","addReason":false},{"id":12,"questionID":5,"answer":"C. LGU/NGU","addReason":false},{"id":13,"questionID":5,"answer":"D. Others (Please specify):","addReason":true}]},{"id":6,"category":"EXITINTERVIEW","code":"Q4","question":"C. Work set-up","questionType":"CHECKBOX","answerType":"RADIO","parentQuestionID":1,"tab":1,"order":7,"isRequired":true,"subQuestion":null,"answer":[{"id":14,"questionID":6,"answer":"A. Homebased","addReason":false},{"id":15,"questionID":6,"answer":"B. Hybrid (Combination of Homebased and Site based)","addReason":false},{"id":16,"questionID":6,"answer":"C. Monday to Friday ","addReason":false},{"id":17,"questionID":6,"answer":"D. Others (Please specify):","addReason":true}]}],"answer":null},{"id":7,"category":"EXITINTERVIEW","code":"Q5","question":"2. What company or industry are you joining? (Pangalan ng kumpanyang lilipatan? Anong uri ng industria?)","questionType":"RADIO","answerType":"RADIO","parentQuestionID":0,"tab":0,"order":8,"isRequired":true,"subQuestion":null,"answer":[{"id":18,"questionID":7,"answer":"A. Name of Company (Optional):","addReason":true},{"id":19,"questionID":7,"answer":"B. Industry:","addReason":true}]},{"id":8,"category":"EXITINTERVIEW","code":"Q6","question":"3. How was your development with Motortrade? (Kumusta ang iyong mga naging kalinangan sa Motortrade?)","questionType":"RADIO","answerType":"RADIO","parentQuestionID":0,"tab":0,"order":9,"isRequired":true,"subQuestion":null,"answer":[{"id":21,"questionID":8,"answer":"A. Above expectation","addReason":false},{"id":22,"questionID":8,"answer":"B. Average","addReason":false},{"id":23,"questionID":8,"answer":"C. Below expectation If below expectation, why?","addReason":true}]},{"id":9,"category":"EXITINTERVIEW","code":"Q7","question":"4. During your employment, were your duties and responsibilities clear with you? (Naging malinaw ba saiyo ang iyong mga Gawain at responsibilidad na dapat gampanan sa iyong panunungkulan?)","questionType":"RADIO","answerType":"RADIO","parentQuestionID":0,"tab":0,"order":10,"isRequired":true,"subQuestion":null,"answer":[{"id":26,"questionID":9,"answer":"A. YES","addReason":false},{"id":27,"questionID":9,"answer":"B. NO","addReason":true}]},{"id":10,"category":"EXITINTERVIEW","code":"Q8","question":"5. Where you satisfied with the working condition in Motortrade, such as but not limited to, salary, benefits, hours of work, etc. (Naging katangap-tangap ba sa iyo ang iyong naging kundisyon o karanasan sa Motortrade, gaya ng sweldo, benepisyo, oras ng trabaho at iba pa.)","questionType":"RADIO","answerType":"RADIO","parentQuestionID":0,"tab":0,"order":11,"isRequired":true,"subQuestion":null,"answer":[{"id":28,"questionID":10,"answer":"A. YES","addReason":false},{"id":29,"questionID":10,"answer":"B. NO","addReason":true}]},{"id":11,"category":"EXITINTERVIEW","code":"Q9","question":"6. When you needed information to do your job, were you able to get it easily? (Sa mga pagkakataong ikaw ay nangailangan ng tulong o impormasyon ukol sa iyong gawain, madali ba itong matugunan?)","questionType":"RADIO","answerType":"RADIO","parentQuestionID":0,"tab":0,"order":12,"isRequired":true,"subQuestion":null,"answer":[{"id":30,"questionID":11,"answer":"A. YES","addReason":false},{"id":31,"questionID":11,"answer":"B. NO","addReason":true}]},{"id":12,"category":"EXITINTERVIEW","code":"Q10","question":"7. When you have suggestion/s about doing your work, where you able to discuss them with your immediate superior? (Sa mga pagkakataong ikaw ay may mungkahi o puna patungkol sa mga gawaing ginampanan, ito ba ay napag­usapan at natugunan ng iyong immediate superior?) ","questionType":"RADIO","answerType":"RADIO","parentQuestionID":0,"tab":0,"order":13,"isRequired":true,"subQuestion":null,"answer":[{"id":32,"questionID":12,"answer":"A. YES","addReason":false},{"id":33,"questionID":12,"answer":"B. NO","addReason":true}]},{"id":13,"category":"EXITINTERVIEW","code":"Q11","question":"8. What comment/s or suggestion/s would you give on areas for improvement of the company? (Mayroon ka bang puna o mga mungkahi na maari mong maibigaysa higit pang ikauunlad at ikakaayos ng pamamaklakad ng kumpanya? Maari lamang na isulat sa mga sumusunod na puwang)","questionType":"RADIO","answerType":"RADIO","parentQuestionID":0,"tab":0,"order":14,"isRequired":true,"subQuestion":null,"answer":[{"id":34,"questionID":13,"answer":"A. YES","addReason":false},{"id":35,"questionID":13,"answer":"B. NO","addReason":true}]},{"id":14,"category":"EXITINTERVIEW","code":"Q12","question":"9. List the supervisors/ Managers whom you have worked with (Ilista at ibigay ang mga pangngalan ng mga taong nakatataas/ Tagapangasiwa sa Sangay kung saan ikaw ay naglingkod.)","questionType":"TEXT","answerType":"TEXT","parentQuestionID":0,"tab":0,"order":15,"isRequired":true,"subQuestion":null,"answer":null}]';
  }
  
  public function session_data(){
    if(isset($_SESSION['credentials'])){
      echo '<pre>';
     var_dump($_SESSION['credentials']);
     echo '<br><hr> <h2>Accountability Count</h2>';
     var_dump($_SESSION['account_count'] );
      echo '<br><hr> <h2>Accountability Clear Count</h2>';
     var_dump($_SESSION['clear_count']);
      echo '<br><hr> <h2>Accountability</h2>';
     var_dump($_SESSION['accountability']);
    
      
    }
    else{
      echo 'no data';
    }
    die;
   }
 

}
