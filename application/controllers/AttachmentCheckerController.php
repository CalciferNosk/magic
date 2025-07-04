<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AttachmentCheckerController extends CI_Controller
{
    public function __construct()
    {
        // die("UNDER MAINTENANCE");
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Complaint_model', 'complaint');
        $this->load->model('Inquiry_model', 'inquiry');
        $this->load->model('Log_model', 'logs');
    }


    public function index($id = null){
        $data['id'] = $id;
        $data['data'] = [];
        if($id == null){
            $this->load->view('AttachmentCheck/AttachmentCheckView',$data);
        }
        else{
             $dir ='./assets/attachments/'.$id;
        if (is_dir($dir)) {
            $files = scandir($dir);
            $data['data'] =  $files;
            $this->load->view('AttachmentCheck/AttachmentCheckView',$data);
        } else {
            $this->load->view('AttachmentCheck/AttachmentCheckView',$data);
        }
        }

       
        
        
    }
}
