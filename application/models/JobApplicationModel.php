<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JobApplicationModel extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function getJobsData()
  {
    $external = $this->load->database('external', TRUE);
    $p = $this->input->post();

    $query = "SELECT * FROM tmpMrf WHERE ( ClosedDate IS NULL OR datediff(now(), ClosedDate) < 5 ) ";
    if (isset($p['filter_position'], $p['filter_location']) && $p['filter_position'] != '' && $p['filter_location'] != '') :
      $query .= '
          AND Position like "%' . $p['filter_position'] . '%" AND Location like "%' . $p['filter_location'] . '%"
        ';
    elseif (isset($p['filter_position']) && $p['filter_position'] != '') :
      $query .= '
          AND Position like "%' . $p['filter_position'] . '%"
        ';
    elseif (isset($p['filter_location']) && $p['filter_location']) :
      $query .= '
          AND Location like "%' . $p['filter_location'] . '%"
        ';
    endif;
    $query .= "ORDER BY MrfCreatedDate DESC";

    return $external->query($query);
  }

  public function getMrfCreatedDate($mrfid)
  {
    $external = $this->load->database('external', TRUE);
    return $external->query("SELECT MrfCreatedDate FROM tmpMrf WHERE MrfId = {$mrfid}")->row();
  }

  public function getIdByMrfId($mrfId)
  {
    $external = $this->load->database('external', TRUE);
    $query = $external->query("SELECT id FROM tmpMrf WHERE MrfId = $mrfId")->row();
    return $query;
  }

  public function view_values($id)
  {
    $external = $this->load->database('external', TRUE);
    $query = $external->query("SELECT * FROM tmpMrf WHERE id = $id ");
    return $query->row();
  }

  public function getToken()
  {
    $external = $this->load->database('external', TRUE);
    $query = $external->query("SELECT token FROM tblAPIToken;");
    return $query->row();
  }

  public function sms_log($form, $mobile_no, $isSent)
  {
    $external = $this->load->database('external', TRUE);
    $details = 'One-Time Password - ' . $form;
    $sendDT = date('Y-m-d H:i:s');
    $external->query("INSERT INTO tblLogsSMS (Details, sendby, sendDT, mobileNumber, isSent)
                          VALUES ('$details', 'EXTERNAL', '$sendDT', '$mobile_no', '$isSent')");
  }
}
