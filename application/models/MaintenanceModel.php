<?php defined('BASEPATH') or exit('No direct script access allowed');

class MaintenanceModel extends CI_Model
{

    public function __construct()
    {
        $this->max_concat = $this->db->query("SET SESSION group_concat_max_len = 18446744073709551615;");
        parent::__construct();
        
       
    }

    public function getFormMaintenance($formid){
        $this->db->cache_off();
        $get_sql = "SELECT IsMaintenance FROM tblExternalFormMaintenance WHERE formid = {$formid} AND Deletedflag = 0 limit 1;";
        $result = $this->db->query($get_sql);

        if(empty($result)){
            return false;
        }else{
            return (int)$result->result_object()[0]->IsMaintenance;
        }

    }

}
