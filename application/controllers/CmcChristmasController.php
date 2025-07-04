<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CmcChristmasController extends CI_Controller
{
    public function __construct()
    {
        // die("UNDER MAINTENANCE");
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('recaptcha', 'application\libraries');
        $this->load->model('CmcChristmasModel', 'xmas');
        $this->load->model('APICurlModel', 'api_curl');
    
    }
    public function index(){
        $data['module'] = 'CMC Christmas';
        $data['login_routes'] = 'cmc-xmas';
        $data['widget'] = $this->recaptcha->getWidget(array('data-expired-callback' => 'recaptchaExpired'));
        $data['script'] = $this->recaptcha->getScriptTag();
        $this->load->view('Templates/LoginView.php', $data);
    }
    public function xmasScan(){
        $data['ismobile'] = '50%';
        $user_agent = $this->input->user_agent();
        if ($this->agent->is_mobile()) {
            $data['ismobile'] = '100%';
        } 
        $this->load->view('CMCXmas/MobileScannerView',$data);
    }

    public function authLogin()
    {
    
      $result =   $this->api_curl->emsLoginAPI('cmcxmas',$_POST['username'], $_POST['password'], 'cmcxmas-mainview');
      echo json_encode($result);
    }
    public function mainView(){
      if (!isset($_SESSION['cmcxmas_username'])) {
        redirect('cmc-xmas');
      }
    //   $_SESSION["fetch_result"]->DepartmentCode =  $_SESSION["fetch_result"]->orgGroupCode;
    //   var_dump('<pre>',$_SESSION);die;
      $data['data'] = 0;
      $data['fn_encode'] = base64_encode($_SESSION["cmcxmas_fullname"]);
      $data['u_encode'] = base64_encode($_SESSION['fetch_result']->code);
      $data['ismobile'] = 0;

      $data['all_dept'] = $this->xmas->getAllDepartment();
      $data['all_data'] = $this->xmas->getAllData();


        $user_agent = $this->input->user_agent();
        if ($this->agent->is_mobile()) {
            $data['ismobile'] = 1;
        } 
    //   $result = $this->api_curl->getCmcXmasList();
    //   $data['httpcode'] = $result['httpcode'];
    //   $data['list_data'] = json_decode($result['output']);
      $this->load->view('CMCXmas/CmXmasMainView.php',$data);
    }

    public function attendance(){
        if (!isset($_SESSION['cmcxmas_username'])) {
            redirect('cmc-xmas');
        }

        if (empty($_GET['u_encode']) || empty($_GET['fn_encode']) || empty($_GET['l_encode']) || empty($_GET['t_encode']) || empty($_GET['lati']) || empty($_GET['longi'])) {
            echo "<center>invalid QR Please try to Genarate QR again </center><br>";
        } else {
            $username = base64_decode($_GET['u_encode']);
            $fullname = base64_decode($_GET['fn_encode']);
            $location = base64_decode($_GET['l_encode']);
            $today = base64_decode($_GET['t_encode']);
            $lati = $_GET['lati'];
            $longi = $_GET['longi'];
            $my_lati = $_GET['ml_lati'];
            $my_longi = $_GET['ml_longi'];
            $data['result'] = 0;
            $data['mssg'] = "Something went wrong";
            if ($username == $_SESSION['cmcxmas_username']) {
                $data['mssg'] = 'You can\'t scan your own QR';
                $this->load->view('CMCXmas/ScanResultView', $data);
                exit();
            }
            $isOnRange =  $this->isWithin50Meters($lati, $longi, $my_lati, $my_longi);
            echo "<center>valid QR </center><br>";

            if ($username == 'admin') {
                if (!$isOnRange) {
                    $data['mssg'] = '<center>You are not on range</center>';
                    $this->load->view('CMCXmas/ScanResultView', $data);
                    exit();
                }
                $user_check = $this->xmas->checkUser($_SESSION['cmcxmas_username']);
                if (empty($user_check)) {
                    $data_store = [
                        'EmployeeCode' => $_SESSION['cmcxmas_username'],
                        'EmployeeFullName' => $_SESSION['cmcxmas_fullname'],
                        'Department' => '',
                        'DepartmentCode' => empty($_SESSION["fetch_result"]->departmentCode) ? 'other' : $_SESSION["fetch_result"]->departmentCode,
                        'GeneratedGeoLocation' => $location,
                        'today' => $today,
                        'QrLat' => $lati,
                        'QrLong' => $longi,
                        'IsOnRange' => $isOnRange,
                        'ScanLat' => $my_lati,
                        'ScanLong' => $my_longi,
                        'QrCreatedBy' => $username
                    ];
                    $result = $this->xmas->storeData($data_store);
                    $data['result'] = $result;
                    $data['mssg'] = $result ? 'Successfully Stored' : 'Something went wrong';
                } else {
                    $data['mssg'] = 'Already Timed In';
                }

                #store now
            } else if ($_SESSION['cmcxmas_username'] == 'admin') {

                $user_check = $this->xmas->checkUser($username);
                if (empty($user_check)) {
                    $data_store = [
                        'EmployeeCode' => $username,
                        'EmployeeFullName' =>  $fullname,
                        'Department' => '',
                        'DepartmentCode' =>  isset($_SESSION["fetch_result"]->DepartmentCode) ? $_SESSION["fetch_result"]->DepartmentCode : 'other',
                        'GeneratedGeoLocation' => $location,
                        'today' => $today,
                        'QrLat' => $lati,
                        'QrLong' => $longi,
                        'IsOnRange' => $isOnRange,
                        'ScanLat' => $my_lati,
                        'ScanLong' => $my_longi,
                        'QrCreatedBy' => $username
                    ];
                    #store now
                    $result = $this->xmas->storeData($data_store);
                    $data['result'] = $result;
                    $data['mssg'] = $result ? 'Successfully Stored' : 'Something went wrong';
                } else {
                    $data['mssg'] = 'Already Timed In';
                }
            } else {
                $data['mssg'] = "<center>You cant Scan QR of other Employees</center>";
            }
           $this->load->view('CMCXmas/ScanResultView', $data);
        }
    }

   public function haversineDistance($lat1, $lon1, $lat2, $lon2) {
        $R = 6371000; // Radius of the Earth in meters
        $dLat = deg2rad((int)$lat2 - (int)$lat1);
        $dLon = deg2rad((int)$lon2 - (int)$lon1);
    
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $R * $c;
    
        return $distance; // distance in meters
    }
    
    function isWithin50Meters($lat1, $lon1, $lat2, $lon2) {
        $distance = $this->haversineDistance($lat1, $lon1, $lat2, $lon2);
        return $distance <= 50; // Check if the distance is within 50 meters
    }
    

    public function fetchData(){
        $record = $this->xmas->getRecords();




        $alldata = new stdClass();
        $alldata->total_count = count($record);
        $alldata->ITD = 0;
        $alldata->HRD = 0;
        $alldata->PARTS = 0;
        $alldata->HRD = 0;
        $alldata->BDD = 0;
        $alldata->AUDIT = 0;
        $alldata->BOMD = 0;
        $alldata->CMD = 0;
        $alldata->SOMD = 0;
        $alldata->FINANCE = 0;
        $alldata->CSM = 0;
        $alldata->MKTG = 0;
        $alldata->PUR = 0;
        $alldata->SnD = 0;
        $alldata->LEGAL = 0;

        echo json_encode($alldata);


    }
    public function testSession(){
        echo '<pre>';

        var_dump($_SESSION);die;
    }
}
