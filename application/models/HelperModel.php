<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HelperModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getBranchNameByCode($code){

        $this->db->cache_off();

        $sql ="SELECT concat(BranchCode , ' - ' , BranchName) as display FROM tbl_tmp_branch_hierarchy WHERE BranchCode = '{$code}'";

        return $this->db->query($sql)->row()->display;
    }

    public function getFullNameByCode($empcode){

        $this->db->cache_off();
        $fullname_sql ="SELECT 
                            CONCAT(emp.code,
                                    ' - ',
                                    emp.lastname,
                                    ', ',
                                    emp.firstname,
                                    ' ',
                                    emp.middlename) AS display_name,
                            emp.corporate_email,
                            emp.ref_value_company_tag,
                            pos.title
                        FROM
                            tbl_tmp_ems_employee emp
                        LEFT JOIN 
                            tbl_tmp_ems_position pos on  emp.position_id = pos.id
                        WHERE 
                            emp.code = '{$empcode}'";
        $result = $this->db->query($fullname_sql)->row();
        return $result;
    }

    public function getWarehouseTotalOrder($order_id){

        $this->db->cache_off();
        $order_count = "SELECT count(1) as count_order FROM tblFormWarehouseOrderDetails WHERE Deletedflag = 0 AND OrderId = '{$order_id}'";

        $result = $this->db->query($order_count)->row()->count_order;
        return $result ;#$this->db->last_query();
    }
   
}
