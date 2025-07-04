<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CaseNTEController extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('recaptcha', 'application\libraries');
    $this->load->model('APICurlModel', 'api_curl');
  }

  public function index()
  {
    $data['module'] = 'case nte';
    $data['login_routes'] = 'casente';
    $data['widget'] = $this->recaptcha->getWidget(array('data-expired-callback' => 'recaptchaExpired'));
    $data['script'] = $this->recaptcha->getScriptTag();
    $this->load->view('Templates/LoginView.php', $data);
  }
  public function authCaseNTE()
  {
    $result =   $this->api_curl->emsLoginAPI('casente',$_POST['username'], $_POST['password'], 'casente-mainview');

    echo json_encode($result);
  }
  public function mainView()
  {
    if (!isset($_SESSION['casente_username'])) {
      redirect('case-nte');
    }
    // var_dump('<pre>',$_SESSION["fetch_result"]);die;
    $result = $this->api_curl->getCaseNTEList();
    $data['httpcode'] = $result['httpcode'];
    $data['list_data'] = json_decode($result['output']);
    // var_dump('<pre>',$data['list_data']);die;
    $this->load->view('casente/CaseNteMainView.php',$data);
  }
  public function caseSeen(){

    $result = $this->api_curl->updateSeen($_POST['case_id']);

    echo json_encode($result);
  }
}
