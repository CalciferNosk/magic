<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CmcChristmasModel extends CI_Model
{   
    protected $tblExternalCmcChristmasParty = 'tblExternalCmcChristmasParty';
    protected $tblExternalCmcChristmas = 'tblExternalCmcChristmas';

    public function __construct()
    {
        parent::__construct();
    }

    public function getRecords(){
      $result =  $this->db->get($this->tblExternalCmcChristmasParty);
      return $result->result_object();
    }

    public function storeData($data_store){
      $result =  $this->db->insert($this->tblExternalCmcChristmasParty, $data_store);
        // var_dump($this->db->last_query());
      return $result;
    }

    public function checkUser($username){
        $this->db->cache_off();
        $check_user = "SELECT * FROM ers_db.tblExternalCmcChristmasParty WHERE EmployeeCode = '{$username}'";
        $result = $this->db->query($check_user);
        return $result->result_object();
    }

    public function getAllDepartment(){
        $this->db->cache_off();
        $get_dept = "SELECT count(DepartmentCode) as count_dept ,DepartmentCode FROM ers_db.tblExternalCmcChristmasParty group by DepartmentCode";
        $result = $this->db->query($get_dept);
        return $result->result_object();
    }

    public function  getAllData(){

        $this->db->cache_off();
        $get_dept = "SELECT * FROM ers_db.tblExternalCmcChristmasParty ";
        $result = $this->db->query($get_dept);
        return $result->result_object();
    }

   
}
