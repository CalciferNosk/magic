<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JobApplicationExamModel extends CI_Model
{
  protected $tblJobAppQuestions = 'tblJobAppQuestions';
  protected $tblJobAppQuestionsChoices = 'tblJobAppQuestionsChoices';
  protected $tblJobAppQuestionGroup = 'tblJobAppQuestionGroup';
  protected $tblJobAppQuestionApplicantTake = 'tblJobAppQuestionApplicantTake';
  protected $tblJobAppQuestionsAnswer = 'tblJobAppQuestionsAnswer';
  protected $tblJobAppEmailLogs = 'tblJobAppEmailLogs';
  protected $tblJobAppControlPanel = 'tblJobAppControlPanel';
  protected $tblJobAppRetakeLogs = 'tblJobAppRetakeLogs';


  public function __construct()
  {
    parent::__construct();

    $this->external = $this->load->database('external', TRUE);
    $this->external->cache_off();
    // $this->load->database('external_jobapp');
  }
  public function getQuestions($group_id)
  {

    $select_sql = "SELECT * FROM {$this->tblJobAppQuestions} WHERE GroupId = {$group_id} AND Deletedflag = 0";
    $query = $this->external->query($select_sql);
    return $query->result_object();
    // return $query->result_object();
  }

  public function getChoices($id)
  {

    $select_choices = "SELECT id,Choices,IsCorrect FROM {$this->tblJobAppQuestionsChoices} WHERE QuestionId = {$id} AND Deletedflag = 0;";
    $query = $this->external->query($select_choices);
    return $query->result_object();
  }

  public function getPartIdsByPartId($part_id)
  {

    $part_sql = "SELECT distinct GroupId FROM {$this->tblJobAppQuestions}  Where Part = {$part_id}";
    $query = $this->external->query($part_sql);
    return $query->result_object();
  }
  public function getGroupDetails($id, $part_id)
  {
    $group_sql = "SELECT * FROM {$this->tblJobAppQuestionGroup}  Where id = {$id} AND PartId = {$part_id}";
    $query = $this->external->query($group_sql);
    // var_dump($this->db->last_query());
    return $query->result_object();
  }
  public function storeApplicantTake($applicant_data)
  {

    $this->external->insert($this->tblJobAppQuestionApplicantTake, $applicant_data);

    if ($this->external->affected_rows() > 0) {
      return 1;
    } else {
      $_SESSION['error'] =  $this->external->error();;
      return 0;
    }
  }

  public function storeAnswer($store_data)
  {

    $this->external->insert_batch($this->tblJobAppQuestionsAnswer, $store_data);
    if ($this->external->affected_rows() > 0) {
      return 1;
    } else {
      $_SESSION['error'] = $this->external->error();;
      return 0;
    }
  }
  public function checkpart_id($part_id, $applicant_id)
  {
    $check_sql = "SELECT count(*) as count_data FROM {$this->tblJobAppQuestionsAnswer} where ApplicantId = {$applicant_id} AND PartId = {$part_id}";

    $query = $this->external->query($check_sql);

    return $query->result_object();
  }

  public function getAllApplicants($date_from = '', $date_to = '')
  {
   
        $this->external->where('deletedflag', 0);
        $this->external->order_by('CreatedDate', 'desc');
        if(!empty($date_from) && !empty($date_to)){
            $this->external->where('CreatedDate >=', $date_from);
            $this->external->where('CreatedDate <=', $date_to);
        }
        // $this->external->cache_on($cache_time);
        $query = $this->external->get($this->tblJobAppQuestionApplicantTake);
        return $query->result_object();
 
  }
  public function getApplicantExamData($applicant_id, $part_id)
  {

    $check_sql = "SELECT count(*) as count_data FROM {$this->tblJobAppQuestionsAnswer} where ApplicantId = {$applicant_id} AND PartId = {$part_id} AND isCorrect = 1";
    $query = $this->external->query($check_sql);

    return $query->result_object();
  }

  public function countQestions($part_id)
  {

    $check_sql = "SELECT count(*) as count_data FROM {$this->tblJobAppQuestions} where Part = {$part_id} AND Deletedflag = 0";
    $query = $this->external->query($check_sql);

    return $query->result_object();
  }
  public function getExamResults($app_id, $part_id)
  {

    $check_sql = "SELECT count(*) as count_data FROM {$this->tblJobAppQuestionsAnswer} where ApplicantId = {$app_id} AND PartId = {$part_id} AND isCorrect = 1";
    $query = $this->external->query($check_sql);
  }

  public function questionPerCount()
  {
    $sql = "SELECT count(*) as q_count,Part FROM {$this->tblJobAppQuestions} group by Part";
    $query = $this->external->query($sql);
    return $query->result_object();
  }

  public function getAllQuestionIds()
  {

    $all_question_sql = "SELECT id,GroupId,Part FROM {$this->tblJobAppQuestions} Where Deletedflag = 0";
    $query = $this->external->query($all_question_sql);
    return $query->result_object();
  }
  public function getresultById($app_id, $q_id)
  {

    $answer_result = "SELECT * FROM {$this->tblJobAppQuestionsAnswer} Where ApplicantId ={$app_id}   AND QuestionId = {$q_id} limit 1";
    $query = $this->external->query($answer_result);

    switch (true):
      case empty($query->row()):
        $result = 'MISSED';
        break;
      case $query->row()->isCorrect == 1:
        $result = 'TRUE';
        break;
      case $query->row()->isCorrect == 0:
        $result = 'FALSE';
        break;
      default:
        $result = '--';
        break;
    endswitch;
    // var_dump($app_id,$q_id ,$result,'<br>');
    return $result;
  }

  public function updateApplicantTake($app_id)
  {

    $update_sql = "UPDATE {$this->tblJobAppQuestionApplicantTake} SET `MovedToEMS` = '1' WHERE (`ApplicantId` = {$app_id})";
    $query = $this->external->query($update_sql);
    if ($this->external->affected_rows() > 0) {
      return 1;
    } else {
      return 0;
    }
  }

  public function checkSentInvite($app_id)
  {

    $check_sql = "SELECT count(*) as count_data FROM {$this->tblJobAppEmailLogs} where ApplicantId = {$app_id} AND IsSent = 1 AND Deletedflag = 0";
    // var_dump($check_sql);die;
    $query = $this->external->query($check_sql);

    return $query->row()->count_data;
  }
  public function getControl($function)
  {
    $control_sql = "SELECT * FROM {$this->tblJobAppControlPanel} Where Deletedflag = 0 AND FunctionName = '{$function}'";
    $query = $this->external->query($control_sql);
    return  $query->num_rows() > 0 ? $query->row() : (object)['Action' => 0];
  }

  public function updateMaintenance($key, $value)
  {
    $update_sql = "UPDATE {$this->tblJobAppControlPanel} SET `Action` = '{$value}' WHERE (`FunctionName` = '{$key}')";
    $query = $this->external->query($update_sql);
    if ($this->external->affected_rows() > 0) {
      return 1;
    } else {
      return 0;
    }
  }

  public function retakeApplicant($app_id)
  {

    $get_data = $this->external->query("SELECT * FROM {$this->tblJobAppQuestionsAnswer} WHERE ApplicantId = $app_id;");

    $retake_data = [
      'ApplicantId' => $app_id,
      'PreviousData' => json_encode($get_data->result_object())
    ];

    $logs =  $this->external->insert($this->tblJobAppRetakeLogs, $retake_data);

    if ($logs == 1) {
      $update = $this->external->query("UPDATE {$this->tblJobAppQuestionApplicantTake} SET `ExamTake` = '2' WHERE (`ApplicantId` = $app_id)");
      $delete = $this->external->query("DELETE FROM {$this->tblJobAppQuestionsAnswer} WHERE ApplicantId = $app_id;");
      if ($delete == 1) {
        echo json_encode(1);
      } else {
        echo json_encode(0);
      }
    } else {
      echo json_encode(0);
    }
  }
  public function checkApplicantTake($app_id)
  {
    $check_sql = "SELECT count(*) as count_data FROM {$this->tblJobAppQuestionApplicantTake} where ApplicantId = {$app_id} AND Deletedflag = 0";
    $query = $this->external->query($check_sql);
    return $query->row()->count_data;
  }

  public function getOtpLogs(){
    $get_logs = "SELECT * FROM tblJobAppOtpLogs order by id desc";
    $query = $this->external->query($get_logs);
    return $query->result_object();
  }
}
