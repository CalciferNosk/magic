<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerCareModel extends CI_Model
{
    protected  $table = 'tblformcomplaint';
    protected  $logtable = 'tblLogsStatus';
    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
    }


    public function getCategory(){

        $query  = "SELECT * FROM tbl_globalreference where grgid = 17 AND deletedflag = 0  order by sequence ASC";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getBranches($cluster_codes = null, $branches = null)
    {
        $where_clusters = $cluster_codes ? " AND ClusterCode IN ({$cluster_codes})" : "";
        $where_branches = $branches ? " AND BranchCode IN ({$branches})" : "";
        
        $sql = $this->db->query("
            SELECT
                BranchCode AS code,
                BranchName AS description,
                BranchAddress AS address
            FROM
                tbl_tmp_branch_hierarchy
            WHERE
                IsActive = 1
                {$where_clusters}
                {$where_branches}
            ORDER BY
                BranchCode;
        ");

       return $sql && $sql->num_rows() > 0 ? $sql->result_object() : false;
    }
    public function storeData($data){
    
        $insert_complaint =  $this->db->insert($this->table, $data);
        $id = $this->db->insert_id($insert_complaint);
        return ['last_id' => $id , 'insert_result' => $insert_complaint];
    }

    public function storeLogs($logs){
        $this->db->insert($this->logtable, $logs);
    }

    public function save_customer_info($firstname, $middlename, $lastname, $email, $mobile, $psgc)
    {
        # remove
        $mobile = str_replace("_", "0", str_replace("-", "", $mobile));
        $table  = 'tblcustomerinq';
        $result = $this->db->query("SELECT id FROM tblcustomerinq where 
            FirstName    = '$firstname' AND 
            MiddleName   = '$middlename' AND
            LastName     = '$lastname'   AND
            Email        = '$email'      AND
            MobileNumber = '$mobile'
            ");
        if ($result->num_rows()) {
            $id = $result->row()->id;
        } else {
            $insert = array(
                'FirstName'      =>  $firstname,
                'MiddleName'     =>  $middlename,
                'LastName'       =>  $lastname,
                'Email'          =>  $email,
                'MobileNumber'   =>  $mobile,
                'RegionCode' => $this->get_psgc_by_brgy($psgc, 'regCode'),
                'ProvinceCode' => $this->get_psgc_by_brgy($psgc, 'provCode'),
                'CityCode' => $this->get_psgc_by_brgy($psgc, 'citymunCode'),
                'BarangayCode' => $this->get_psgc_by_brgy($psgc, 'brgyCode')
            );
            $this->db->insert($table, $insert);
            $id = $this->db->insert_id();
        }
        // $this->logs->user_log($_SESSION['username'],'ADD',$table ,$id);  
        return $id;
    }
    public function get_psgc_by_brgy($brgycode, $get)
    {
        $array = explode(',', $brgycode);
        $final = trim($array[3]);
        $this->db->select('*');
        $this->db->from('refbrgy');
        $this->db->join('refcitymun', 'refbrgy.citymunCode = refcitymun.citymunCode', 'inner');
        $this->db->join('refprovince', 'refprovince.provCode = refcitymun.provCode', 'left');
        $this->db->join('refzip', 'refzip.city = refcitymun.citymunDesc AND refprovince.provDesc = refzip.major_area', 'left');
        $this->db->where('brgyCode', $final);
        $query = $this
            ->db
            ->get();
        $ret = $query->row();
        // echo json_encode($ret);
        // echo $final;
        if ($get == 'citymunCode') {
            return $ret->citymunCode;
        }
        if ($get == 'zip_code') {
            return $ret->zip_code;
        }
        if ($get == 'provCode') {
            return $ret->provCode;
        }
        if ($get == 'regCode') {
            return $ret->regCode;
        }
        if ($get == 'brgyCode') {
            return $ret->brgyCode;
        }
    }

}

?>