<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MaintenanceController extends CI_Controller {

  public function __construct() {
  	// die("UNDER MAINTENANCE");
     parent::__construct();
     $this->load->helper('url');
  }

	public function index()
	{
        $this->load->view('maintenance');
    }
}