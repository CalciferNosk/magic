<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormError extends CI_Controller {

public function index(){
	$this->load->view('error');
}

}