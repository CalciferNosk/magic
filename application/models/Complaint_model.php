<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Complaint_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_branch()
    {
        $global = $this->load->database('global', TRUE);

        $query  = <<<SQL
				SELECT *, a.name as b_name FROM tbl_branches AS a INNER JOIN tbl_companies AS b ON a.company = b.cid;
SQL;

        $result = $global->query($query);
        return $result->result_object();
    }

    public function get_cat()
    {
        # remove

        $query  = <<<SQL
                SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Customer Category';
SQL;

        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_brand()
    {
        # remove

        $query  = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Brand' AND referencename ='N/A';
SQL;

        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function post($post)
    {
        # Revised By Russ
        /**
         * Remove Complaint Date Point to Request Date (for convenal purposes)
         * Added CreatedBy, UpdatedBy Default Value
         */
        if (!empty($post['customer_fname']) && !empty($post['customer_lname']) && !empty($post['contact_no'])) {
            $table = 'tblformcomplaint';
            $logtable = 'tblLogsStatus';
            $insert = array(
                'CustomerCategoryId'        => $post['cat'],
                'BranchCode'          => $post['branch'],
                // 'model'          => $post['model'],
                // 'source'         => $post['sourceparam'],
                // 'type'           => $post['type'], 
                // 'color'          => $post['color'], 
                // 'budget'         => $post['budget'],
                // 'referral_name'  => $post['referral_name'],
                // 'branch'         => $post['branch'],
                // 'DocumentNumber' => $post['doc_no'],
                // 'assign_user'    => $post['assigned_to'],
                // 'Createby'       => $_SESSION['username'],
                'Remarks'           => $post['details'],
                // 'ComplaintDate'     => date('Y-m-d'),
                'TypeId'            => '552',
                'CustomerId'        => $this->save_customer_info($post['customer_fname'], $post['customer_mname'], $post['customer_lname'], $post['email'], $post['contact_no'], $post['psgc']),
                'TransactionType'   => 'EXTERNAL',
                'CreatedBy'         => 'EXTERNAL',
                'UpdatedBy'         => 'EXTERNAL',
                'CurrentStatusId'   => 262
            );

            $this->db->insert($table, $insert);
            $id = $this->db->insert_id();
            $logs = array(
                'FormId'         =>  '35',
                'FormRecordId'   =>  $id,
                'StatusId'       =>  '262',
                'createby'       => 'EXTERNAL',
                'createDT'       =>  date('Y-m-d H:i:s'),
                'EffectiveDT'    =>  date('Y-m-d'),
                'deletedflag'    =>  0
            );
            $this->db->insert($logtable, $logs);
            return $id;
        }
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

    public function getSubCat($catCode)
    {
        # remove


        $query  = <<<SQL
          			SELECT * FROM tblcategory AS a INNER JOIN tblsubcategory AS b ON a.id = b.categoryid WHERE categoryname = '$catCode';
SQL;

        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getpost($value)
    {
        # remove


        $query  = <<<SQL
                 INSERT INTO tbl_complaint (branch_code, branch, customer_fname, customer_mname, customer_lname, landline, mobile_prefix, mobile_number, maur_number, account_number, engine_number, brand, model, color, complaint_cat, sub_cat, details)
              VALUES ('1000', 'test', 'test', 'test', 'test', '1234', '0906', '3123213', '', '', '', '', '', '', 'cat', 'subcat', 'details');
SQL;

        $result = $this->db->query($query);
        //   return $result->result_array();
    }

    public function getBranch($catCode)
    {

        $ems = $this->load->database('default', TRUE);


        $query  = <<<SQL
                SELECT * , BranchName AS branchdesc, BranchCode AS branchcode FROM tbl_tmp_branch_hierarchy WHERE AreaCode = '$catCode';
SQL;

        $result = $ems->query($query);
        return $result->result_array();
    }
}
