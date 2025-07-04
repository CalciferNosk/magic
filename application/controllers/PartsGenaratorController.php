<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PartsGenaratorController extends CI_Controller
{
    public function __construct()
    {
        //die("UNDER MAINTENANCE");
        // die("Under Mainte");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('PartsGeneratorModel', 'parts_m');
    }

    public function index()
    {
        $data['parts'] = '';
        $data['mc_list'] = $this->parts_m->getMCList();
        // var_dump( $data['mc_list']);die;
        $this->load->view('PartsGenerator/PartsGenaratorView',$data);
    }

    public function getPartsList(){

        $data['parts'] =  $this->parts_m->getListPerData($_POST['kpr'],$_POST['mc']);
        $category = $this->parts_m->getByCategory($_POST['mc']);
        $data['rate'] =  $this->parts_m->getJobRate($_POST['kpr'],$category);

        echo json_encode($data);
    }
}
