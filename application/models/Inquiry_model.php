<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inquiry_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function get_occupation()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Occupation';
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_occupation_group()
    {


        $query = <<<SQL
        SELECT DISTINCT optiongroup FROM tbl_globalreference WHERE grgid = '6';
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_region()
    {


        $query = <<<SQL
        SELECT * FROM refregion ORDER by regdesc;
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_province()
    {


        $query = <<<SQL
        SELECT * FROM refprovince;
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_city()
    {


        $query = <<<SQL
        SELECT * FROM refcitymun;
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_barangay()
    {


        $query = <<<SQL
        SELECT * FROM refbrgy ORDER BY brgydesc;
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_referral_source()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE referencedesc = 'referral';
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function verify_exist($post)
    {
        $arr = explode("*", $post['model'], 2);
        $model = $arr[0];
        $firstname = $post['first_name'];
        $lastname = $post['last_name'];
        $table = $post['table'];
        $mobile = $post['mobile_no'];
        $mobilealt = str_replace("-", "", $post['mobile_no']);
        if ($table == 'tblformloanapplication') {
            //$mobile = $post['mobile_no'];
            $column = 'a.CreatedDate';
        } else {
            //
            $column = 'a.ActualInquiryDate';
        }
        $query = <<<SQL
            SELECT $column AS recorddate FROM $table AS a INNER JOIN tblcustomerinq AS b ON a.CustomerId = b.id WHERE a.ModelId = '$model' AND b.FirstName = '$firstname' AND b.LastName = '$lastname' AND (MobileNumber = '$mobile' OR MobileNumber = '$mobilealt') LIMIT 1;
SQL;

        $this->db->cache_off();
        $result = $this->db->query($query);
        $this->db->cache_on();
        //var_dump($this->db->last_query());die();
        return $result->num_rows() == 0 ?  'false' : $result->result_object();
        // return $result->result_object();
    }

    public function sms_log($form, $mobile_no, $status = 0)
    {
        $table = "tblLogsSMS";
        $details = 'One-Time Password - ' . $form;
        $sendDT = date('Y-m-d H:i:s');
        $system_name = $form == "Job Application" ? "Careers" : $form;
        $data = [
            "Details" => $details,
            "sendby"  => "EXTERNAL",
            "sendDT"  => $sendDT,
            "mobileNumber" => $mobile_no,
            "SystemName" => $system_name,
            "isSent"     => $status
          ];
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function get_PSGC()
    {


        $query = <<<SQL
        SELECT CONCAT(region.regDesc, " | ", province.provDesc, " | ", citymun.citymunDesc, " | ", brgy.brgyDesc) AS psgc, brgy.brgycode AS brgycode FROM refbrgy AS brgy
        INNER JOIN refregion AS region ON region.regCode = brgy.regCode
        INNER JOIN refcitymun AS citymun ON citymun.citymunCode = brgy.citymunCode
        INNER JOIN refprovince AS province ON province.provCode = brgy.provCode;
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function find_psgc()
    {
        $data = array();
        if (!isset($_POST['searchTerm'])) {
            $data = [];
        } else {
            $search = $_POST['searchTerm'];
            $result = $this
                ->db
                ->query("SELECT 
    UPPER(CONCAT(
    IF(d.regCode      IS NULL or d.regCode      = '', 'NONE'    , d.regCode),
    IF(c.provCode     IS NULL or c.provCode     = '', 'NONE'    , CONCAT(', ',c.provCode)),
    IF(b.citymunCode  IS NULL or b.citymunCode  = '', 'NONE'    , CONCAT(', ',b.citymunCode)),
    IF(a.brgyCode     IS NULL or a.brgyCode     = '', 'NONE'    , CONCAT(', ',a.brgyCode)),
    IF(b.zipCode     IS NULL or b.zipCode    = '', ', NONE'    , CONCAT(', ',b.zipCode))
    )) as value,
    UPPER(CONCAT(
    IF(d.regCode      IS NULL or d.regCode      = '', 'NONE'    , d.regDesc),
    IF(c.provCode     IS NULL or c.provCode     = '', 'NONE'    , CONCAT(',',c.provDesc)),
    IF(b.citymunCode  IS NULL or b.citymunCode  = '', 'NONE'    , CONCAT(', ',b.citymunDesc)),
    IF(a.brgyCode     IS NULL or a.brgyCode     = '', 'NONE'    , CONCAT(', ',a.brgyDesc)),
    IF(b.zipCode     IS NULL or b.zipCode    = '', ''    , CONCAT(', ',b.zipCode))
    )) as display
FROM
    ers_db.refbrgy a
        INNER JOIN
    ers_db.refcitymun b ON b.citymunCode = a.citymunCode
        INNER JOIN
    ers_db.refprovince c ON c.provCode = a.provCode
        INNER JOIN
    ers_db.refregion d ON d.regCode = a.regCode
    where 
    CONCAT(
   d.regDesc,
    CONCAT(', ',c.provDesc),
    CONCAT(', ',b.citymunDesc),
    CONCAT(', ',a.brgyDesc)
    ) LIKE CONCAT('%', '" . $_POST['searchTerm'] . "','%') ORDER BY d.regDesc limit 100;");
            foreach ($result->result_array() as $key => $res) {
                $data[] = array(
                    "id" => $res['value'],
                    "text" => $res['display']
                );
            }
        }

        echo json_encode($data);
    }

    public function validate($code = '')
    {

        # Revised Code By Russel 5-19-21
        if (empty($code)) return FALSE;
        $this->db->query("SET sql_mode = '';");
        $q = $this->db->query("
            SELECT
                ClusterCode
            FROM
                tbl_tmp_branch_hierarchy
            WHERE
                ClusterCode = '{$code}'
        ");

        return $q !== FALSE && !empty($q->row()->ClusterCode) ? json_encode($q->row()->ClusterCode) : FALSE;

        // if ( empty($code) ) return NULL;

        // $ems = $this->load->database('ems', true);

        // $ems->select('code');
        // $ems->from('org_group');
        // $ems->where('org_type', 'CLUS');
        // $ems->where('code', $code);
        // $ems->where('code IS NOT NULL', null, false);
        // $q = $ems->get();

        // if($q !== FALSE && !empty($q->row()->code) )
        // {
        //     $ret = $q->row();
        //     return json_encode($ret->code);
        // }
        // else
        // {
        //     return 'null';
        // }
    }

    public function validatex($src_code)
    {
        # Revised Code By Russ: 5-19-21

        $this->db
            ->select('grid')
            ->from('tbl_globalreference')
            ->where('grid', $src_code)
            // ->where('grgid', 7);
            ->where('parentid', 213);
        // ->where('referencename', $src_code);

        $q = $this->db->get();

        return $q !== FALSE && !empty($q->row()->grid) ? json_encode($q->row()->grid) : FALSE;
    }

    public function get_brand()
    {
        $query = "SELECT id AS grid, Brand as referencename FROM tblbrand WHERE deletedflag = '0' ORDER by Brand ";
        $result = $this->db->query($query);
        $data['result'] = $result->result_object();
        $data['brand_query'] = $this->db->last_query($result);

        return $data;
    }

    public function get_model()
    {

        $query = "SELECT TypeId, a.id AS grid, BrandId AS parentid, UPPER(Model) AS referencename FROM tblmodel AS a INNER JOIN tblmctype AS b ON a.typeid = b.id WHERE a.deletedflag = 0 OR a.deletedflag = '0' GROUP BY Model ORDER by Model";
        
        $result = $this->db->query($query);

        return $result->result_object();
    }

    public function campaigndets($brand = 0)
    {
        if(empty($brand)){
            return false;
        }
        $this->db->cache_off();

        $result = $this->db->query("SELECT BrandId, ModelId FROM tblrefSourceCampaign WHERE id = {$brand} AND isActive = '1'");
        // $this->db->cache_on();
        return $result;
    }

    public function get_brand_spec($brand)
    {


        $query = <<<SQL
         SELECT id AS grid, Brand as referencename FROM tblbrand WHERE Brand = '$brand' AND deletedflag = '0' ORDER by Brand;
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_model_spec($model)
    {


        $query = <<<SQL
        SELECT TypeId, a.id AS grid, BrandId AS parentid, UPPER(Model) AS referencename FROM tblmodel AS a INNER JOIN tblmctype AS b ON a.typeid = b.id WHERE Remarks = '$model' AND (a.deletedflag = 0 OR a.deletedflag = '0') GROUP BY Model ORDER by Model;
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_brand_specnew($brand)
    {
        $this->db->cache_off();
        $searchForValue = ',';
        if (strpos($brand, $searchForValue) !== false) {
            $where = "id IN (" . $brand . ")";
        } else {
            $where = "id = " . $brand;
        }
        $this->db->cache_off();
        $query = <<<SQL
         SELECT id AS grid, Brand as referencename FROM tblbrand WHERE $where AND deletedflag = '0' ORDER by Brand;
SQL;

        $result = $this->db->query($query);

        return $result ? $result->result_object() : (object)[];
    }

    public function get_model_specnew($model)
    {
        $searchForValue = ',';
        if (strpos($model, $searchForValue) !== false) {
            $where = "a.id IN (" . $model . ")";
        } else {
            $where = "a.id = " . $model;
        }
        // $this->db->cache_off();
        $query = <<<SQL
        SELECT TypeId, a.id AS grid, BrandId AS parentid, UPPER(Model) AS referencename FROM tblmodel AS a INNER JOIN tblmctype AS b ON a.typeid = b.id WHERE $where AND (a.deletedflag = 0 OR a.deletedflag = '0') GROUP BY Model ORDER by Model;
SQL;


        $result = $this->db->query($query);
        // $this->db->cache_on();
        return $result ? $result->result_object() : (object)[];
    }

    public function get_education()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Educational Attainment';
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_pays()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Pay Mode';
SQL;


        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_sources()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Source';
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_types()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'MC Type';
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_colors()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'MC Color' ORDER BY referencename;
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_source_fund()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Source of Fund';
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_status()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Employement Status';
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_source_income()
    {


        /*      $query  = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Source of Income';
        SQL; */
        $query = <<<SQL
        SELECT grid,referencename ,optiongroup as option_group FROM tbl_globalreference WHERE CONCAT(",", grgid, ",") REGEXP ",(6)," order by optiongroup,grid asc
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_source_income_group()
    {


        $query = <<<SQL
        SELECT DISTINCT optiongroup as option_group FROM tbl_globalreference WHERE grgid = 6 order by optiongroup asc
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_borrower($number)
    {


        /*      $query  = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Source of Income';
        SQL; */
        $query = <<<SQL
        SELECT grid,referencename ,optiongroup as option_group FROM tbl_globalreference WHERE CONCAT(",", grgid, ",") REGEXP ",($number)," order by optiongroup,grid asc
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_borrower_type_group()
    {


        $query = <<<SQL
        SELECT DISTINCT optiongroup as option_group FROM tbl_globalreference WHERE grgid = 29 order by optiongroup asc
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_marital_status()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Marital Status' AND a.grgid = 38;
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_residence_type()
    {


        $query = <<<SQL
        SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'Residence Ownership';
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_categories($source = '')
    {
        $where = '';
        if ($source == 'FACEBOOK NATIONAL REPO PAGE' || $source == 'Facebook National Repo Page') {
            $where = 'AND (a.id = 151 OR a.id = 152)';
        }
        $query = <<<SQL
        SELECT *, a.id AS catid FROM tblcategory AS a INNER JOIN tblform AS b ON a.formid = b.id WHERE b.form = 'Inquiry Form' $where;
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_reservation_categories()
    {

        $query = <<<SQL
        SELECT *, a.id AS catid FROM tblcategory AS a INNER JOIN tblform AS b ON a.formid = b.id WHERE b.form = 'RESERVATION';
SQL;
        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_regions()
    {
        $ems = $this
            ->load
            ->database('default', true);

        $query = <<<SQL
        SELECT * FROM tbl_tmp_branch_hierarchy GROUP BY RegionCode;
SQL;


        $result = $ems->query($query);
        return $result->result_object();
    }

    public function get_areas()
    {
        $ems = $this
            ->load
            ->database('default', true);

        $query = <<<SQL
        SELECT * FROM tbl_tmp_branch_hierarchy GROUP BY AreaCode;
SQL;


        $result = $ems->query($query);
        return $result->result_object();
    }

    public function get_branches($cluster_codes = null, $branches = null)
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

    public function get_clusters()
    {
        $ems = $this
            ->load
            ->database('default', true);

        $query = <<<SQL
        SELECT BranchCode AS code, BranchName AS description, BranchAddress AS address FROM tbl_tmp_branch_hierarchy ORDER by BranchCode;
SQL;


        $result = $ems->query($query);
        return $result->result_object();
    }

    public function get_clusterss()
    {
        $ems = $this
            ->load
            ->database('default', true);

        $query = <<<SQL
        SELECT * FROM tbl_tmp_branch_hierarchy GROUP BY ClusterCode;
SQL;


        $result = $ems->query($query);
        return $result->result_object();
    }

    public function get_tmp_clusters($clus_code = '')
    {
        // $this->db->query("SET SESSION group_concat_max_len = 18446744073709551615")
        if (empty($clus_code)) return FALSE;

        $q = $this->db->query("
            SELECT
                ClusterName
            FROM
                tbl_tmp_branch_hierarchy
            WHERE
                ClusterCode = {$clus_code}
        ");

        // var_dump($this->db->last_query());die();

        return $q !== FALSE ? $q->row()->ClusterName : FALSE;
    }

    public function postt($value)
    {
        // echo json_encode($value);
        // $result = mb_substr($value['branch'], 0, 4);
        //  $this->db->cache_off();
        $customer_fname = $value['customer_fname'];
        $customer_mname = $value['customer_mname'];
        $customer_lname = $value['customer_lname'];
        $contact_no = $value['contact_no'];
        $address = $value['address'];
        $barangay = $value['barangay'];
        $city = $value['city'];
        $province = $value['province'];
        $region = $value['region'];
        //$occupation = $value['occupation'];
        $inquiry = $value['inquiry'];
        $email = $value['email'];
        $details = $value['details'];
        $brand = $value['brand'];
        $color = $value['color'];
        // $type = $value['type'];
        $source = $value['sourceid'];
        $cluster = $value['clusterparam'];
        if ($source == 'OTHERS') {
            $source = $value['source_others'];
        }
        $model = $value['model'];
        /*$mop = $value['pay'];
        $budget = $value['budget'];
        $branch = $value['branch'];
        $referral_name = $value['referral_name'];*/


        /*        $query  = <<<SQL
              INSERT INTO tbl_complaint (branch_code, branch, customer_fname, customer_mname, customer_lname, landline, mobile_prefix, mobile_number, maur_number, account_number, engine_number, brand_model, color, complaint_cat, sub_cat, details)
              VALUES ('$result', '$value[\'branch\']', '$value[\'fname\']', '$value[\'mname\']', '$value[\'lname\']', '$value[\'landline\']', '$value[\'mobile_prefix\']', '$value[\'mobile_number\']', '$value[\'maur_number\']', '$value[\'account_number\']', '$value[\'engine_number\']', '$value[\'brand_model\']', '$value[\'color\']', '$value[\'cat\']', '$value[\'subcat\']', '$value[\'details\']');
        SQL; */
        $result = $this->db->query("INSERT INTO tbl_inquiry (customer_fname, customer_mname, customer_lname, contact_no, address, barangay, city, province, region, inquiry, details, brand, model, color, source, email, ClusterCode)
              VALUES ('$customer_fname', '$customer_mname', '$customer_lname', '$contact_no', '$address', '$barangay', '$city', '$province', '$region', '$inquiry', '$details', '$brand', '$model', '$color', '$source', '$email', '$cluster');");
    }

    public function checkClient()
    {
        $p = $this->input->post();
        $GenId = $p['gen_id'];

        $result = $this->db->query("
                SELECT
                    id
                FROM
                    tblcustomerinq
                WHERE 
                    GeneratedId = '{$GenId}'
            ");

        if ($result && $result->num_rows() > 0) :
            return true;
        endif;

        return false;
    }

    public function post($data)
    {
    
        $table = 'tblforminquiry';
        $logtable = 'tblLogsStatus';        
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) { 
            $logs = [
                'FormId' => '34',
                'FormRecordId' => $id,
                'StatusId' => '229',
                'createBy'       => 'EXTERNAL',
                'createDT' => date('Y-m-d H:i:s'),
                'EffectiveDT' => date('Y-m-d'),
                'deletedflag' => 0
            ];
            $this->db->insert($logtable, $logs);
            return $id;
            // do whatever you want to do on query success
        }     
        
    }

    public function ltrspost($post)
    {

        if (!empty($post['customer_fname']) && !empty($post['customer_lname']) && !empty($post['contact_no'])) {
            $table = 'tblFormCCODLtrsApplicant';
            $logtable = 'tblLogsStatus';
            $insert = array(
                'NameFirst' => ucfirst($post['customer_fname']),
                'NameMiddle' => ucfirst($post['customer_mname']),
                'NameLast' => ucfirst($post['customer_lname']),
                'Region' => $this->get_psgc_by_brgy($post['psgc'], 'regCode'),
                'Province' => $this->get_psgc_by_brgy($post['psgc'], 'provCode'),
                'City' => $this->get_psgc_by_brgy($post['psgc'], 'citymunCode'),
                'Barangay' => $this->get_psgc_by_brgy($post['psgc'], 'brgyCode'),
                //'BarangayCode'   =>  $post['psgc,
                'Email' => $post['email'],
                'MobileNo' => $post['contact_no'],
                'Address' => ucfirst($post['address']),
                'PrefSched' => $post['PrefSched'],
                'LicenseType' => $post['LicenseType'],
                'MCPref' => $post['MCPref'],
                'MCExp' => $post['MCExp'],
                'IncomeSource' => $post['IncomeSource'],
                'Profession' => $post['occupation'],
                //'ClusterCode' =>  base64_decode($post['clusterparam']),
                //  'type'           => $post['type'],
                //'ColorId' => ucfirst($post['color']) ,
                //'Branch' =>  (!empty($post['branch']) ? $post['branch']: NULL),
                //  'budget'         => $post['budget'],
                //  'referral_name'  => $post['referral_name'],
                //    'branch'         => $post['branch'],
                //   'DocumentNumber' => $post['doc_no'],
                //   'assign_user'    => $post['assigned_to'],
                //'TransactionType'       => 'EXTERNAL',
                //'UpdatedBy'     => 'EXTERNAL',
                //'Remarks' => $post['details'],
                //'DatePurchase' => $date_purchase,
                'Status'   => 229,
                'AppDate' => date('Y-m-d'),
                //  'CustomerId'     => $this->save_customer_info(ucfirst($post['customer_fname']),ucfirst($post['customer_mname']),ucfirst($post['customer_lname']),ucfirst($post['region']),ucfirst($post['province']),ucfirst($post['city']),ucfirst($post['barangay']),ucfirst($post['email']),ucfirst($post['contact_no']), ucfirst($post['address']))
            );
            // $this->save_applicant_info(ucfirst($post['customer_fname']) , ucfirst($post['customer_mname']) , ucfirst($post['customer_lname']) , $post['psgc'] , ucfirst($post['email']) , ucfirst($post['contact_no']) , ucfirst($post['address']));
            $this->db->trans_start();
            $this->db->insert($table, $insert);
            var_dump($this->db->last_query());
            $id = $this->db->insert_id();
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                //   return "Query Failed";
            } else {

                $logs = array(
                    'FormId' => '34',
                    'FormRecordId' => $id,
                    'StatusId' => '229',
                    'createBy'       => 'EXTERNAL',
                    'createDT' => date('Y-m-d H:i:s'),
                    'EffectiveDT' => date('Y-m-d'),
                    'deletedflag' => 0
                );
                $this->db->insert($logtable, $logs);
                return $id;
                // do whatever you want to do on query success
            }


            // print_r($insert);
            //  redirect($_SERVER['HTTP_REFERER']);
        }
    }


    public function referralpost($post)
    {
        if (!empty($post['customer_fname']) && !empty($post['customer_lname']) && !empty($post['contact_no'])) {
            $table = 'tblforminquiry';
            $mobileNumber = _cleanMobileNumber($post['contact_no']);

            if (!$mobileNumber):
                echo "Error, Mobile number is invalid.";
                return false;
            endif;

            $logtable = 'tblLogsStatus';
            if ($post['model'] != '') {
                $arr = explode("*", $post['model'], 2);
                $model = $arr[0];
                $type = $arr[1];
            } else {
                $model = '';
                $type = '';
            }
            $insert = array(
                'CategoryId' => ucfirst($post['inquiry']),
                'BrandId' => ucfirst($post['brand']),
                'ModelId' => $model,
                'MCTypeId' => $type,
                'SourceId' => $post['source_referral'],
                //'ClusterCode' => $post['clusterparam'],
                //  'type'           => $post['type'],
                'ColorId' => ucfirst($post['color']),
                //  'budget'         => $post['budget'],
                'ReferralName'  => $post['referral_name'],
                'Branch'         => $post['branch'],
                //   'DocumentNumber' => $post['doc_no4'],
                //   'assign_user'    => $post['assigned_to'],
                'TransactionType'       => 'EXTERNAL REFERRAL',
                'UpdatedBy' => 'EXTERNAL REFERRAL',
                'CreatedBy' => 'EXTERNAL REFERRAL',
                'Remarks' => $post['details'],
                'DatePurchase' => $post['date_purchase'],
                // 'DateCreated' => date('Y-m-d') ,
                'ActualInquiryDate' => date("Y-m-d H:i:s"),
                //  'CustomerId'     => $this->save_customer_info(ucfirst($post['customer_fname']),ucfirst($post['customer_mname']),ucfirst($post['customer_lname']),ucfirst($post['region']),ucfirst($post['province']),ucfirst($post['city']),ucfirst($post['barangay']),ucfirst($post['email']),ucfirst($post['contact_no']), ucfirst($post['address']))
                'CustomerId' => $this->save_customer_info_inquiry(ucfirst($post['customer_fname']), ucfirst($post['customer_mname']), ucfirst($post['customer_lname']), ucfirst($post['psgc']), ucfirst($post['email']), $mobileNumber, ucfirst($post['address']))
            );
            $this->db->trans_start();
            $this->db->insert($table, $insert);
            //echo $this->db->last_query();
            $id = $this->db->insert_id();
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                //   echo "Query Failed";
            } else {

                $logs = array(
                    'FormId' => '34',
                    'FormRecordId' => $id,
                    'StatusId' => '229',
                    'createby'       => 'EXTERNAL REFERRAL',
                    'createDT' => date('Y-m-d H:i:s'),
                    'EffectiveDT' => date('Y-m-d'),
                    'deletedflag' => 0
                );
                $this->db->insert($logtable, $logs);
                return $id;
            }
        }
        //  redirect($_SERVER['HTTP_REFERER']);
    }

    public function jobpost($post)
    {
        if (!empty($post)) {
            $table = 'tblformjobapplication';
            $logtable = 'tblLogsStatus';
            $insert = array(
                //  'type'           => $post['type'],
                'DesiredPosition' => $post['desired_position'],
                'CurrentPosition' => $post['current_position'],
                'CurrentCompany' => $post['current_company'],
                'CurrentAddress' => $post['current_address'],
                'Resume' => $post['resume'],
                //'DateCreated' => date('Y-m-d'),
                //  'CustomerId'     => $this->save_customer_info(ucfirst($post['customer_fname']),ucfirst($post['customer_mname']),ucfirst($post['customer_lname']),ucfirst($post['region']),ucfirst($post['province']),ucfirst($post['city']),ucfirst($post['barangay']),ucfirst($post['email']),ucfirst($post['contact_no']), ucfirst($post['address']))
                'CustomerId' => $this->save_customer_info_job(ucfirst($post['customer_fname']), ucfirst($post['customer_mname']), ucfirst($post['customer_lname']), ucfirst($post['psgc']), ucfirst($post['email']), ucfirst($post['contact_no']), ucfirst($post['address']))
            );
            $this->db->insert($table, $insert);
            $id = $this->db->insert_id();
            if (!is_dir('assets/attachments/resume/' . $id)) {
                mkdir('./assets/attachments/resume/' . $id, 0777, true);
            }
            $data = array();
            // echo json_encode($_FILES['resume']);
            /*
        $_FILES['file']['name'] = $_FILES['resume']['name'];
        $_FILES['file']['type'] = $_FILES['resume']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['resume']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['resume']['error'];
        $_FILES['file']['size'] = $_FILES['resume']['size'];

        // Set preference
        $config['upload_path'] = 'assets/attachments/resume/' . $id;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $config['max_size'] = '1000'; // max_size in kb
        $config['file_name'] = trim('a' . $_FILES['resume']['name']);
        //$config['encrypt_name'] = TRUE;
        //Load upload library
        $this
            ->load
            ->library('upload', $config);
        $this
            ->upload
            ->initialize($config);

        // File upload
        if ($this
            ->upload
            ->do_upload('file'))
        {
            // Get data about the file
            chmod($config['upload_path'] . '/' . trim('a' . $_FILES['resume']['name']) , 777);
            $uploadData = $this
                ->upload
                ->data();
            $filename = $uploadData['file_name'];

            // Initialize array
            $data['filenames'][] = $filename;
            $this->file_upload_job(trim('a' . $_FILES['resume']['name']) , '40', $id, 'Resume');
        } */
            /* $logs = array(
            'FormId' => '34',
            'FormRecordId' => $id,
            'StatusId' => '229',
            'createDT' => date('Y-m-d H:i:s') ,
            'EffectiveDT' => date('Y-m-d') ,
            'deletedflag' => 0
        );
        $this->db->insert($logtable, $logs); */
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function getProvince($catCode)
    {


        $query = <<<SQL
                SELECT * FROM refprovince WHERE regCode = '$catCode';
SQL;


        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getCity($catCode)
    {


        $query = <<<SQL
                SELECT * FROM refcitymun WHERE provCode = '$catCode';
SQL;


        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getBarangay($catCode)
    {


        $query = <<<SQL
                SELECT * FROM refbrgy WHERE citymunCode = '$catCode';
SQL;


        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getModel($catCode)
    {


        $query = <<<SQL
                SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE parentid = '$catCode';
SQL;


        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function get_globalref($grgid)
    {


        $query = <<<SQL
                SELECT * FROM tbl_globalreference WHERE grgid = $grgid;
SQL;


        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getBranch($catCode)
    {
        $ers = $this
            ->load
            ->database('default', true);

        $query = <<<SQL
                SELECT * , BranchName AS branchdesc, BranchCode AS branchcode FROM tbl_tmp_branch_hierarchy WHERE AreaCode = '$catCode';
SQL;


        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function get_ems_employee($catCode)
    {
        $ems = $this->load->database('ems', true);
        $result = $ems->query("SELECT GROUP_CONCAT(corporate_email, '') AS emails FROM employee WHERE code = '$catCode'");
        // return $result->result_array(); 
        if ($result && !empty($result->row()->emails)) :
            return $result->row()->emails;
        endif;
        return false;
    }

    public function insert_loan_customer_new($post)
    {

        $insert = array(
            'FirstName' => $post['customer_fname'],
            'MiddleName' => $post['customer_mname'],
            'LastName' => $post['customer_lname'],
            'MobileNumber' => $post['contact_no'],
            'Email' => $post['email']
        );
        if ($post['idses'] == '') {
            $this->db->insert('tblcustomerinq', $insert);
            return $this
                ->db
                ->insert_id();
        } else {
            $this->db->update('tblcustomerinq', $insert, ['id' => $post['custses']]);
            return $post['custses'];
        }
    }

    public function getall($post)
    {

        $updateid = $post['updateid'];
        $updatenum = $post['updatenum'];
        $query = <<<SQL
SELECT 
                 '' as blank,
                 loan_application.id AS formid,
                 loan_application.CurrentStatusId AS CurrentStatusId,
                IF(loan_application.PlanDateToPurchase IS NULL or loan_application.PlanDateToPurchase = '', '', loan_application.PlanDateToPurchase) as datetime,
                IF(loan_application.PriorityId IS NULL or loan_application.PriorityId = '', '', loan_application.PriorityId) as 'priority',
                IF(loan_application.LoanTypeId  IS NULL or loan_application.LoanTypeId = '', '', loan_application.LoanTypeId) as loan_type,
                IF(loan_application.LoanTerm  IS NULL or loan_application.LoanTerm = '', '', loan_application.LoanTerm) as loan_term,
                IF(loan_application.LoanAmount   IS NULL or loan_application.LoanAmount  = '', '0.00', FORMAT(loan_application.LoanAmount,2)) AS loan_amount,
                IF(loan_application.DownPayment  IS NULL or loan_application.DownPayment    = '', '0.00', FORMAT(loan_application.DownPayment,2)) AS downpayment,
                IF(loan_application.LoanPurpose  IS NULL or loan_application.LoanPurpose    = '', '', loan_application.LoanPurpose) AS loan_purpose,
                
                IF(loan_application.BrandId IS NULL or loan_application.BrandId = '', '', loan_application.BrandId) AS brand,
                IF(loan_application.ModelId IS NULL or loan_application.ModelId = '', '', loan_application.ModelId) AS model,
                IF(loan_application.MCTypeId IS NULL or loan_application.MCTypeId = '', '', loan_application.MCTypeId),
                IF(loan_application.ColorId IS NULL or loan_application.ColorId = '', '', loan_application.ColorId) AS color,
                IF(loan_application.TelesalesId IS NULL or loan_application.TelesalesId = '', '', loan_application.TelesalesId),
                IF(src.grid IS NULL or src.grid = '', '', src.grid),
                        
                IF(loan_application.ClusterCode IS NULL or loan_application.ClusterCode = '', '', UPPER(CONCAT(loan_application.ClusterCode,' - ',cluster.ClusterName))),
                IF(loan_application.Branch IS NULL or loan_application.Branch = '', '', loan_application.Branch),
                IF(loan_application.AssignUser IS NULL or loan_application.AssignUser = '', '', loan_application.AssignUser),
                
                IF(customer_info.FirstName IS NULL or customer_info.FirstName = '', '', customer_info.FirstName) AS customer_fname,
                IF(customer_info.MiddleName IS NULL or customer_info.MiddleName = '', '', customer_info.MiddleName) AS customer_mname,
                IF(customer_info.LastName IS NULL or customer_info.LastName = '', '', customer_info.LastName) AS customer_lname,
                IF(customer_info.ExtensionName IS NULL or customer_info.ExtensionName = '', '', customer_info.ExtensionName),
                IF(customer_info.GenderId IS NULL or customer_info.GenderId = '', '', customer_info.GenderId) AS gender,
                IF(customer_info.Nationality IS NULL or customer_info.Nationality = '', '', customer_info.Nationality) AS nationality
                ,

                IF(customer_info.BirthPlace IS NULL or customer_info.BirthPlace = '', '', customer_info.BirthPlace) AS birthplace, 
                IF(customer_info.BirthDate IS NULL or customer_info.BirthDate = '', '--', DATE_FORMAT(DATE(customer_info.BirthDate), '%m-%d-%Y') ) AS birthday,
                IF(customer_info.BirthDate IS NULL or customer_info.BirthDate = '', '0', year(curdate())-year(customer_info.BirthDate) - (right(curdate(),5) < right(customer_info.BirthDate,5))) as age,



                IF(customer_info.Telephone IS NULL or customer_info.Telephone = '', '', customer_info.Telephone) AS home_tel,
                IF(customer_info.Fax IS NULL or customer_info.Fax = '', '', customer_info.Fax) AS home_fax,
                IF(customer_info.PostPaidPrepaid IS NULL or customer_info.PostPaidPrepaid = '', '', customer_info.PostPaidPrepaid) AS postpaidprepaid,
                IF(customer_info.MobileNumber IS NULL or customer_info.MobileNumber = '', '', customer_info.MobileNumber) AS contact_no,
                IF(customer_info.Email IS NULL or customer_info.Email = '', '', customer_info.Email) AS email,
                IF(customer_info.Facebook IS NULL or customer_info.Facebook = '', '', customer_info.Facebook) AS facebook,
                IF(customer_info.Instagram IS NULL or customer_info.Instagram = '', '', customer_info.Instagram) AS instagram,
                IF(customer_info.Others IS NULL or customer_info.Others = '', '', customer_info.Others) AS other_social,

                IF(customer_info.TIN IS NULL or customer_info.TIN = '', '', customer_info.TIN) AS tin,
                IF(customer_info.SSSGSIS IS NULL or customer_info.SSSGSIS = '', '', customer_info.SSSGSIS) AS sss_gsis,
                IF(customer_info.MaritalStatusId IS NULL or customer_info.MaritalStatusId = '', '', customer_info.MaritalStatusId) AS marital_status,

                IF(customer_info.WidowYears IS NULL or customer_info.WidowYears = '', '00', customer_info.WidowYears) AS widow_years,
                IF(customer_info.SeparatedYears IS NULL or customer_info.SeparatedYears = '', '00', customer_info.SeparatedYears) AS seperated_years,
                
                IF(spouse_details.SpouseFname IS NULL or spouse_details.SpouseFname = '', '', spouse_details.SpouseFname) AS spousefname,
                IF(spouse_details.SpouseMname IS NULL or spouse_details.SpouseMname = '', '', spouse_details.SpouseMname) AS spousemname,
                IF(spouse_details.SpouseLname IS NULL or spouse_details.SpouseLname = '', '', spouse_details.SpouseLname) AS spouselname,

                IF(spouse_details.SpouseNname IS NULL or spouse_details.SpouseNname = '', '', spouse_details.SpouseNname) AS spousenname,

                IF(spouse_details.SpouseTelNo IS NULL or spouse_details.SpouseTelNo = '', '', spouse_details.SpouseTelNo) AS spouse_telno,
                IF(spouse_details.SpouseMobileNumber IS NULL or spouse_details.SpouseMobileNumber = '', '', spouse_details.SpouseMobileNumber) AS spouse_contact,
                IF(spouse_details.SpouseNationality IS NULL or spouse_details.SpouseNationality = '', '', spouse_details.SpouseNationality) AS spouse_nationality,

                IF(spouse_details.SpouseBirthPlace IS NULL or spouse_details.SpouseBirthPlace = '', '', spouse_details.SpouseBirthPlace) AS spouse_birthplace,

                IF(spouse_details.SpouseBirthDate IS NULL or spouse_details.SpouseBirthDate = '', '', DATE_FORMAT(DATE(spouse_details.SpouseBirthDate), '%m-%d-%Y') ) AS spouse_birthday,
                IF(spouse_details.SpouseBirthDate IS NULL or spouse_details.SpouseBirthDate = '', '0', 
                year(curdate())-year(spouse_details.SpouseBirthDate) - (right(curdate(),5) < right(spouse_details.SpouseBirthDate,5))) as spouse_age,

                IF(customer_info.NumberOfChildrenAndAge IS NULL or customer_info.NumberOfChildrenAndAge = '', '0', customer_info.NumberOfChildrenAndAge) AS no_children,
                IF(customer_info.EducationId IS NULL or customer_info.EducationId = '', '', customer_info.EducationId) AS education_attainment,
                IF(customer_info.MothersName IS NULL or customer_info.MothersName = '', '', customer_info.MothersName) AS maiden_name,
                IF(customer_info.NumberOfDependents IS NULL or customer_info.NumberOfDependents = '', '0', customer_info.NumberOfDependents) AS dependent,
                IF(loan_application.BorrowerTypeId IS NULL or loan_application.BorrowerTypeId = '', '', loan_application.BorrowerTypeId) AS borrower_type,
                IF(loan_application.BusinessSizeId IS NULL or loan_application.BusinessSizeId = '', '', loan_application.BusinessSizeId) AS borrower_size,
                IF(loan_application.BusinessNatureId IS NULL or loan_application.BusinessNatureId = '', '', loan_application.BusinessNatureId) AS borrower_nature,
                
                IF(customer_info.BarangayCode IS NULL or customer_info.BarangayCode = '', '', customer_info.BarangayCode) as presentaddress,
                IF(customer_info.Street IS NULL or customer_info.Street = '', '', customer_info.Street) AS address,
                IF(customer_info.ResidenceId IS NULL or customer_info.ResidenceId = '', '', customer_info.ResidenceId) AS residence_type,
                '' as blank_1,
                IF(customer_info.LengthOfStayYear IS NULL or customer_info.LengthOfStayYear = '', '', customer_info.LengthOfStayYear) AS tenurecountyears,
                IF(customer_info.LengthOfStayMonth IS NULL or customer_info.LengthOfStayMonth = '', '', customer_info.LengthOfStayMonth) AS tenurecountmonths,
                IF(customer_info.ProvincialSame IS NULL or customer_info.ProvincialSame = '', '', customer_info.ProvincialSame) AS sameaddindi,
               
                IF(customer_info.ProvincialBarangayCode IS NULL or customer_info.ProvincialBarangayCode = '', '', customer_info.ProvincialBarangayCode) as permanentaddress,
                IF(customer_info.ProvincialStreet IS NULL or customer_info.ProvincialStreet = '', '', customer_info.ProvincialStreet ) AS address_sub,

                IF(customer_info.PreviousSame IS NULL or customer_info.PreviousSame = '', '', customer_info.PreviousSame),
                
                
                IF(customer_info.PreviousBarangayCode IS NULL or customer_info.PreviousBarangayCode = '', '', customer_info.PreviousBarangayCode)as previousaddress,
                IF(customer_info.PreviousStreet IS NULL or customer_info.PreviousStreet = '', '', customer_info.PreviousStreet) AS address_prev,

                IF(customer_info.SpouseAddress IS NULL or customer_info.SpouseAddress = '', '', customer_info.SpouseAddress) AS spouse_address,
                IF(employement_business.EmployerBusinessName IS NULL or employement_business.EmployerBusinessName = '', '', employement_business.EmployerBusinessName) AS company_name,
                IF(employement_business.NumberOfYearsInBusiness IS NULL or employement_business.NumberOfYearsInBusiness = '', '', employement_business.NumberOfYearsInBusiness) AS years_business,
                IF(employement_business.BarangayCode IS NULL or employement_business.BarangayCode = '', '', employement_business.BarangayCode)as busaddress,
                IF(employement_business.Street IS NULL or employement_business.Street = '', '', employement_business.Street) AS address_bus,
                IF(employement_business.BusinessRegistered IS NULL or employement_business.BusinessRegistered = '', '', employement_business.BusinessRegistered) AS register,
                IF(employement_business.EmploymentStatusId IS NULL or employement_business.EmploymentStatusId = '', '', employement_business.EmploymentStatusId) AS position_status,
                IF(employement_business.EmailAddress IS NULL or employement_business.EmailAddress = '', '', employement_business.EmailAddress) AS previous_email,
                IF(employement_business.NatureOfWork IS NULL or employement_business.NatureOfWork = '', '', employement_business.NatureOfWork) AS nature_work,
                IF(employement_business.TelephoneNumber IS NULL or employement_business.TelephoneNumber = '', '', employement_business.TelephoneNumber) AS telephone_no,
                IF(employement_business.NumberOfYearsInBusiness IS NULL or employement_business.NumberOfYearsInBusiness = '', '', employement_business.NumberOfYearsInBusiness),
                '' as blank_2,
                IF(employement_business.LengthOfYears IS NULL or employement_business.LengthOfYears = '', '', employement_business.LengthOfYears) AS existencelengthyears,
                IF(employement_business.LengthOfMonths IS NULL or employement_business.LengthOfMonths = '', '', employement_business.LengthOfMonths)  AS existencelengthmonths,
                IF(employement_business.RankPosition IS NULL or employement_business.RankPosition = '', '', employement_business.RankPosition) AS position,
                IF(employement_business.PreviousEmployerBusinessName IS NULL or employement_business.PreviousEmployerBusinessName = '', '', employement_business.PreviousEmployerBusinessName) AS previous_employer_name,
                IF(employement_business.PreviousBarangayCode IS NULL or employement_business.PreviousBarangayCode = '', '', employement_business.PreviousBarangayCode) as previous_employer_address,
                IF(employement_business.PreviousStreet IS NULL or employement_business.PreviousStreet = '', '', employement_business.PreviousStreet) AS previous_employer_street,
                IF(employement_business.PreviousTelephoneNumber IS NULL or employement_business.PreviousTelephoneNumber = '', '', employement_business.PreviousTelephoneNumber) AS previous_employer_telno,
                '' as blank_3,
                IF(employement_business.PreviousLengthOfYears IS NULL or employement_business.PreviousLengthOfYears = '', '', employement_business.PreviousLengthOfYears) AS previouslengthyears,
                IF(employement_business.PreviousLengthOfMonths IS NULL or employement_business.PreviousLengthOfMonths = '', '', employement_business.PreviousLengthOfMonths) AS previouslengthmonths,
                IF(employement_business.PreviousRankPosition IS NULL or employement_business.PreviousRankPosition = '', '', employement_business.PreviousRankPosition) AS previous_job,


                IF(loan_application.SourceFundId IS NULL or loan_application.SourceFundId = '', '', loan_application.SourceFundId) AS source_fund,
                IF(loan_application.MonthlySalary IS NULL or loan_application.MonthlySalary = '', '0.00', FORMAT(loan_application.MonthlySalary,2)) AS salary,
                IF(loan_application.BusinessIncome IS NULL or loan_application.BusinessIncome = '', '0.00', FORMAT(loan_application.BusinessIncome,2)) AS business_income,
                IF(loan_application.OtherIncome IS NULL or loan_application.OtherIncome = '', '0.00', FORMAT(loan_application.OtherIncome,2)) AS other_income,
                FORMAT((SUM(loan_application.MonthlySalary)+SUM(loan_application.BusinessIncome)+SUM(loan_application.OtherIncome)),2) AS gross_income,

                IF(ExistingLoan_1.Bank IS NULL or ExistingLoan_1.Bank = '', '', ExistingLoan_1.Bank) AS l1_bank,
                IF(ExistingLoan_1.TypeOfLoan IS NULL or ExistingLoan_1.TypeOfLoan = '', '', ExistingLoan_1.TypeOfLoan) AS l1_type,
                IF(ExistingLoan_1.LoanAmount IS NULL or ExistingLoan_1.LoanAmount = '', '', FORMAT(ExistingLoan_1.LoanAmount,2)) AS l1_amount,
                IF(ExistingLoan_1.MonthlyInstallment IS NULL or ExistingLoan_1.MonthlyInstallment = '', '', FORMAT(ExistingLoan_1.MonthlyInstallment,2)) AS l1_monthly,
                IF(ExistingLoan_1.TermMonths IS NULL or ExistingLoan_1.TermMonths = '', '', ExistingLoan_1.TermMonths) AS l1_terms,
                IF(ExistingLoan_1.DateGranted IS NULL or ExistingLoan_1.DateGranted = '', '', ExistingLoan_1.DateGranted) AS l1_granted,
                IF(ExistingLoan_1.MaturityDate IS NULL or ExistingLoan_1.MaturityDate = '', '', ExistingLoan_1.MaturityDate ) AS l1_maturity,
                IF(ExistingLoan_2.Bank IS NULL or ExistingLoan_2.Bank = '', '', ExistingLoan_2.Bank) AS l2_bank,
                IF(ExistingLoan_2.TypeOfLoan IS NULL or ExistingLoan_2.TypeOfLoan = '', '', ExistingLoan_2.TypeOfLoan) AS l2_type,
                IF(ExistingLoan_2.LoanAmount IS NULL or ExistingLoan_2.LoanAmount = '', '', FORMAT(ExistingLoan_2.LoanAmount,2)) AS l2_amount,
                IF(ExistingLoan_2.MonthlyInstallment IS NULL or ExistingLoan_2.MonthlyInstallment = '', '', FORMAT(ExistingLoan_2.MonthlyInstallment,2)) AS l2_monthly,
                IF(ExistingLoan_2.TermMonths IS NULL or ExistingLoan_2.TermMonths = '', '', ExistingLoan_2.TermMonths) AS l2_terms,
                IF(ExistingLoan_2.DateGranted IS NULL or ExistingLoan_2.DateGranted = '', '', ExistingLoan_2.DateGranted) AS l2_granted,
                IF(ExistingLoan_2.MaturityDate IS NULL or ExistingLoan_2.MaturityDate = '', '', ExistingLoan_2.MaturityDate ) AS l2_maturity,
                IF(ExistingLoan_3.Bank IS NULL or ExistingLoan_3.Bank = '', '', ExistingLoan_3.Bank) AS l3_bank,
                IF(ExistingLoan_3.TypeOfLoan IS NULL or ExistingLoan_3.TypeOfLoan = '', '', ExistingLoan_3.TypeOfLoan) AS l3_type,
                IF(ExistingLoan_3.LoanAmount IS NULL or ExistingLoan_3.LoanAmount = '', '', FORMAT(ExistingLoan_3.LoanAmount,2)) AS l3_amount,
                IF(ExistingLoan_3.MonthlyInstallment IS NULL or ExistingLoan_3.MonthlyInstallment = '', '', FORMAT(ExistingLoan_3.MonthlyInstallment,3)) AS l3_monthly,
                IF(ExistingLoan_3.TermMonths IS NULL or ExistingLoan_3.TermMonths = '', '', ExistingLoan_3.TermMonths) AS l3_terms,
                IF(ExistingLoan_3.DateGranted IS NULL or ExistingLoan_3.DateGranted = '', '', ExistingLoan_3.DateGranted) AS l3_granted,
                IF(ExistingLoan_3.MaturityDate IS NULL or ExistingLoan_3.MaturityDate = '', '', ExistingLoan_3.MaturityDate ) AS l3_maturity,

                IF(Reference_1.FullName IS NULL or Reference_1.FullName = '', '', Reference_1.FullName) AS r1_name,
                IF(Reference_1.Address IS NULL or Reference_1.Address = '', '', Reference_1.Address) AS r1_address,
                IF(Reference_1.MobileNumber IS NULL or Reference_1.MobileNumber = '', '', Reference_1.MobileNumber) AS r1_contact_no,
                IF(Reference_1.Relationship IS NULL or Reference_1.Relationship = '', '', Reference_1.Relationship) AS r1_relationship,
                IF(Reference_2.FullName IS NULL or Reference_2.FullName = '', '', Reference_2.FullName) AS r2_name,
                IF(Reference_2.Address IS NULL or Reference_2.Address = '', '', Reference_2.Address) AS r2_address,
                IF(Reference_2.MobileNumber IS NULL or Reference_2.MobileNumber = '', '', Reference_2.MobileNumber) AS r2_contact_no,
                IF(Reference_2.Relationship IS NULL or Reference_2.Relationship = '', '', Reference_2.Relationship) AS r2_relationship,
                IF(Reference_3.FullName IS NULL or Reference_3.FullName = '', '', Reference_3.FullName) AS r3_name,
                IF(Reference_3.Address IS NULL or Reference_3.Address = '', '', Reference_3.Address) AS r3_address,
                IF(Reference_3.MobileNumber IS NULL or Reference_3.MobileNumber = '', '', Reference_3.MobileNumber) AS r3_contact_no,
                IF(Reference_3.Relationship IS NULL or Reference_3.Relationship = '', '', Reference_3.Relationship) AS r3_relationship,

                '1' as 'RegeralId',
                IF(loan_application.CustomerId IS NULL or loan_application.CustomerId = '', '', loan_application.CustomerId) AS cust_id,
                               
                IF(ExistingLoan_1.id IS NULL or ExistingLoan_1.id = '', '', ExistingLoan_1.id) AS loan1_id,
                IF(ExistingLoan_2.id IS NULL or ExistingLoan_2.id = '', '', ExistingLoan_2.id) AS loan2_id,
                IF(ExistingLoan_3.id IS NULL or ExistingLoan_3.id = '', '', ExistingLoan_3.id) AS loan3_id,
                IF(Reference_1.id IS NULL or Reference_1.id = '', '', Reference_1.id) AS ref1_id,
                IF(Reference_2.id IS NULL or Reference_2.id = '', '', Reference_2.id) AS ref2_id,
                IF(Reference_3.id IS NULL or Reference_3.id = '', '', Reference_3.id) AS ref3_id,
                IF(loan_application.EmploymentBusinessId IS NULL or loan_application.EmploymentBusinessId = '', '',loan_application.EmploymentBusinessId) AS employment_id, 
                IF(customer_info.SpouseId IS NULL or customer_info.SpouseId = '', '', customer_info.SpouseId) AS spouse_id
                from tblformloanapplication loan_application      
                                left join tblcustomerinq customer_info on customer_info.id = loan_application.CustomerId
                left join tbl_globalreference occupation on occupation.grid = customer_info.OccupationId
    left join refbrgy barangay           on barangay.brgyCode = customer_info.BarangayCode
    left join refcitymun city         on city.citymunCode = customer_info.CityCode
  left join refprovince province         on province.provCode = customer_info.ProvinceCode
    left join refregion region        on region.regCode = customer_info.RegionCode
                left  join 
                 (SELECT distinct(ClusterCode),ClusterName FROM tbl_tmp_branch_hierarchy) cluster on loan_application.ClusterCode = cluster.ClusterCode
                left join tblcustomerref Reference_1 on Reference_1.id = loan_application.RefId1
                left join tblcustomerref Reference_2 on Reference_2.id = loan_application.RefId2
                left join tblcustomerref Reference_3 on Reference_3.id = loan_application.RefId3

                left join tblformloanexistingloan ExistingLoan_1 on ExistingLoan_1.id = loan_application.ExistingLoanId1
                left join tblformloanexistingloan ExistingLoan_2 on ExistingLoan_2.id = loan_application.ExistingLoanId2
                left join tblformloanexistingloan ExistingLoan_3 on ExistingLoan_3.id = loan_application.ExistingLoanId3
                left join tblformloanemploymentbusiness employement_business on loan_application.EmploymentBusinessId =employement_business.id
                left join tbl_globalreference src on loan_application.SourceId = src.grid
                left join tblspouse spouse_details on customer_info.SpouseId = spouse_details.id
                WHERE 
                loan_application.id=$updateid AND customer_info.MobileNumber='$updatenum' AND (loan_application.CurrentStatusId BETWEEN 286 AND 289);
SQL;

        $this->db->cache_off();
        $result = $this->db->query($query);
        $this->db->cache_on();
        return $result->result_array();
    }

    public function getallSupplier($post)
    {

        $updateid = $post['updateid'];
        $updatenum = $post['updatenum'];
        $query = "SELECT a.*, b.grid AS TaxTypeId, c.grid AS TypeOfOwnershipId, b.referencename AS TaxType, c.referencename AS TypeOfOwnerShip
                FROM tblFormPurSupplierAccreditation AS a
                INNER JOIN tbl_globalreference AS b ON a.TaxTypeId = b.grid
                INNER JOIN tbl_globalreference AS c ON a.TypeOfOwnershipId = c.grid
                WHERE 
                SupplierCode = '$updateid' AND ContactNumber='$updatenum' AND CurrentStatusId = 658";

        $this->db->cache_off();
        $result = $this->db->query($query)->row();
        $this->db->cache_on();
        return $result;
    }

    public function getStatusId($post)
    {
        $supplier_code = $post['updateid'];
        $mobile_number = $post['updatenum'];
        $query = "SELECT CurrentStatusId FROM tblFormPurSupplierAccreditation WHERE SupplierCode = '{$supplier_code}' AND ContactNumber = '{$mobile_number}'";
        return $this->db->query($query)->row();
    }

    public function getallSupplierFile($post)
    {
        $updateid = $post['formid'];
        $query = <<<SQL
        SELECT * FROM tblAttachments WHERE FormID = 70 AND FormRecordId = '$updateid' AND (deletedflag != 1 OR deletedflag != '1');
SQL;
        $this->db->cache_off();
        $result = $this->db->query($query);
        $this->db->cache_on();
        return $result->result_array();
    }

    public function deleteattach($post)
    {
        $updateid = $post['remfin'];
        $query = <<<SQL
        UPDATE tblAttachments SET deletedflag = '1' WHERE id = '$updateid';
SQL;
        $this->db->cache_off();
        $result = $this->db->query($query);
        $this->db->cache_on();
        return $this->db->last_query();
    }

    public function suppOne($post)
    {
        $table = 'tblFormPurSupplierAccreditation';
        $logtable = 'tblLogsStatus';
        /*$customer_id = $this->insert_loan_customer_new($post);

        $arr = explode("*", $post['model'], 2);
        $model = $arr[0];
        $type = $arr[1]; */
        $insert = array(
            'SupplierName' => $post['SupplierName'],
            'ContactPerson' => $post['ContactPerson'],
            'TaxTypeId' => $post['TaxTypeId'],
            'TIN' => $post['TIN'],
            'Email' => $post['Email'],
            'UpdatedBy' => 'EXTERNAL',
            'ContactNumber' => $post['ContactNumber'],
            'UpdatedDate' => date('Y-m-d  H:i:s'),
            'Street' => $post['Street'],
            'TypeOfOwnershipId' => $post['TypeOfOwnershipId'],
            'PrevCompanyName' => $post['PrevCompanyName'],
            'NatureOfBusiness' => $post['NatureOfBusiness'],
            'TotalBusinessYears' => $post['TotalBusinessYears'],
            'LandlineNo' => $post['LandlineNo'],
            'Remarks' => htmlentities($post['Remarks']),
            'OfficialWebsiteAddress' => $post['OfficialWebsiteAddress']
            /*          
            'BrandId' => $post['brand'],
            'ModelId' => $model,
            'MCTypeId' => $type,
            'ColorId' => $post['color'],
            'LoanTypeId' => $post['loan_type'],
            'LoanAmount' => str_replace(',', '', $post['loan_amount']).'.00',
            'LoanTerm' => $post['loan_term'],
            'DownPayment' => str_replace(',', '', $post['downpayment']).'.00',
            'LoanPurpose' => $post['loan_purpose'],
            'CustomerId' => $customer_id,
            'SignDate' => date('Y-m-d') ,
            'SourceId' => $post['sourceid'],
            'ClusterCode' => (!empty($post['clusterid']) ? $post['clusterid']: NULL),
            'TransactionType' => 'EXTERNAL',
            'UpdatedBy' => 'EXTERNAL' */
        );
        if ($post['presentaddress'] != NULL) {
            $insert +=  array(
                'RegionCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'regCode'),
                'ProvinceCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'provCode'),
                'CityCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'citymunCode'),
                'BarangayCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'brgyCode'),
                'ZipCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'zip_code')
            );
        }
        /*   if($post['clusterid'] == ''){
                   $insert += array(
            'TelesalesId' => 540
        ); 
        }*/

        $this->db->trans_start();
        /* if($post['idses'] == ''){
        $this->db->insert($table, $insert);
        }
        else{*/
        $this->db->update($table, $insert, ['SupplierCode' => $post['SupplierCode']]);
        //  }
        // return $this->db->last_query();
        $id = $this->db->insert_id();
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return $this->db->last_query();
        } else {

            $logs = array(
                'FormId' => '39',
                'FormRecordId' => $id,
                'StatusId' => '286',
                'createby'       => 'EXTERNAL',
                'createDT' => date('Y-m-d H:i:s'),
                'EffectiveDT' => date('Y-m-d'),
                'deletedflag' => false
            );
            $this->db->insert($logtable, $logs);
            // $the_session = array("id" => $id, "customer_id" => $customer_id);
            //$this->session->set_userdata($the_session);
            //return $the_session;
        }
    }

    public function tabOne($post)
    {
        $table = 'tblformloanapplication';
        $logtable = 'tblLogsStatus';
        $customer_id = $this->insert_loan_customer_new($post);

        $arr = explode("*", $post['model'], 2);
        $model = $arr[0];
        $type = $arr[1];
        $insert = array(
            'BrandId' => $post['brand'],
            'ModelId' => $model,
            'MCTypeId' => $type,
            'ColorId' => $post['color'],
            'LoanTypeId' => $post['loan_type'],
            'LoanAmount' => str_replace(',', '', $post['loan_amount']) . '.00',
            'LoanTerm' => $post['loan_term'],
            'DownPayment' => str_replace(',', '', $post['downpayment']) . '.00',
            'LoanPurpose' => $post['loan_purpose'],
            'CustomerId' => $customer_id,
            'SignDate' => date('Y-m-d'),
            'SourceId' => $post['sourceid'],
            'CampaignId' => $post['campaignid'],
            'ClusterCode' => (!empty($post['clusterid']) ? $post['clusterid'] : NULL),
            'TransactionType' => 'EXTERNAL',
            'UpdatedBy' => 'EXTERNAL'
        );
        if ($post['clusterid'] == '') {
            $insert += array(
                'TelesalesId' => 540
            );
        }

        $this->db->trans_start();
        if ($post['idses'] == '') {
            $this->db->insert($table, $insert);
        } else {
            $this->db->update($table, $insert, ['id' => $post['idses']]);
        }
        $id = $this->db->insert_id();
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return $this->db->last_query();
        } else {

            $logs = array(
                'FormId' => '39',
                'FormRecordId' => $id,
                'StatusId' => '286',
                'createby'       => 'EXTERNAL',
                'createDT' => date('Y-m-d H:i:s'),
                'EffectiveDT' => date('Y-m-d'),
                'deletedflag' => false
            );
            $this->db->insert($logtable, $logs);
            $the_session = array("id" => $id, "customer_id" => $customer_id);
            //$this->session->set_userdata($the_session);
            return $the_session;
        }
    }

    public function tabTwo($post)
    {

        $table = 'tblformloanapplication';
        $customer_id = $this->insert_loan_customer_two($post, $post['custses']);
        $emp_business_id = $this->insert_employment_business_update();
        $spouse_id = $this->insert_loan_spouse_update();

        $insert = in_array($post['borrower_type'], array(
            586,
            587,
            588
        )) ? array(
            'BusinessSizeId' => $post['borrower_size'],
            'BusinessNatureId' => $post['borrower_nature']
        ) : array();
        $insert += array(
            'EmploymentBusinessId' => $emp_business_id,
            'SpouseId' => $spouse_id,
            'BorrowerTypeId' => $post['borrower_type']
        );

        $this->db->trans_start();
        $this->db->update($table, $insert, ['id' => $post['idses']]);
        $this->db->trans_complete();
        //echo "<script>console.log('Debug Objects: " . $this->session->userdata('id') . "' );</script>";
    }

    public function tabThree($post)
    {

        $table = 'tblformloanapplication';

        $insert = array(
            'SourceFundId' => $post['source_fund'],
            'MonthlySalary' => str_replace(',', '', $post['salary']),
            'BusinessIncome' => str_replace(',', '', $post['business_income']),
            'OtherIncome' => str_replace(',', '', $post['other_income'])
        );

        $this->db->trans_start();
        $this->db->update($table, $insert, ['id' => $post['idses']]);
        $this->db->trans_complete();
        //echo "<script>console.log('Debug Objects: " . $this->session->userdata('id') . "' );</script>";
    }

    public function tabFour($post)
    {

        $table = 'tblformloanapplication';

        $LoanId1 = $this->insert_existing_loan_update($post['l1_bank'], $post['l1_type'], $post['l1_amount'], $post['l1_monthly'], $post['l1_terms'], $post['l1_granted'], $post['l1_maturity'], $post['l1ses']);
        $LoanId2 = $this->insert_existing_loan_update($post['l2_bank'], $post['l2_type'], $post['l2_amount'], $post['l2_monthly'], $post['l2_terms'], $post['l2_granted'], $post['l2_maturity'], $post['l2ses']);
        $LoanId3 = $this->insert_existing_loan_update($post['l3_bank'], $post['l3_type'], $post['l3_amount'], $post['l3_monthly'], $post['l3_terms'], $post['l3_granted'], $post['l3_maturity'], $post['l3ses']);

        $insert = array(
            'ExistingLoanId1' => $LoanId1,
            'ExistingLoanId2' => $LoanId2,
            'ExistingLoanId3' => $LoanId3
        );

        $this->db->trans_start();
        $this->db->update($table, $insert, ['id' => $post['idses']]);
        $this->db->trans_complete();
        //echo "<script>console.log('Debug Objects: " . $this->session->userdata('id') . "' );</script>";
    }

    public function tabFive($post)
    {

        $table = 'tblformloanapplication';

        $insert = array(
            'RefId1' => $this->save_customer_ref_update(ucfirst($post['r1_name']), ucfirst($post['r1_relationship']), $post['r1_contact_no'], ucfirst($post['r1_address']), $post['r1ses']),
            'RefId2' => $this->save_customer_ref_update(ucfirst($post['r2_name']), ucfirst($post['r2_relationship']), $post['r2_contact_no'], ($post['r2_address']), $post['r2ses']),
            'RefId3' => $this->save_customer_ref_update(ucfirst($post['r3_name']), ucfirst($post['r3_relationship']), $post['r3_contact_no'], ucfirst($post['r3_address']), $post['r3ses'])
        );

        $this->db->trans_start();
        $this->db->update($table, $insert, ['id' => $post['idses']]);
        $this->db->trans_complete();
        //echo "<script>console.log('Debug Objects: " . $this->session->userdata('id') . "' );</script>";
    }

    public function driverslicense($post)
    {
        $id = $post['idses'];
        $location = FCPATH . "assets/attachments/";
        if (!is_dir($location . $id)) {
            if (!mkdir($location . $id, 0777)) {
                die("Something went wrong. please contact the developer");
            }
        }

        $data = array();
        $_FILES['file']['name'] = $_FILES['image']['name'];
        $_FILES['file']['type'] = $_FILES['image']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['image']['error'];
        $_FILES['file']['size'] = $_FILES['image']['size'];

        // Set preference
        $config['upload_path'] = $location . $id;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $config['max_size'] = '1000'; // max_size in kb
        $config['file_name'] = trim('a' . $_FILES['image']['name']);
        //$config['encrypt_name'] = TRUE;
        //Load upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        // File upload
        if ($this->upload->do_upload('file')) {
            // Get data about the file
            // die($config['upload_path'] . '/' . trim('a' . $_FILES['image']['name']));
            // chmod($config['upload_path'] . '/' . trim('a' . $_FILES['image']['name']) , 777);
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];

            // Initialize array
            $data['filenames'][] = $filename;
            $this->file_upload(trim('a' . $_FILES['image']['name']), '39', $id, 'Government ID');
        }
    }
    public function tabSix($post)
    {
        $table = 'tblformloanapplication';

        $insert = array(
            'Signature' => $post['sig-dataUrl']
        );
        $this->db->trans_start();
        $this->db->update($table, $insert, ['id' => $post['idses']]);
        $this->db->trans_complete();
        $record_id = $post['idses'];
        $id =  date('Ymd').'_'.$post['idses'];
        $location = FCPATH . "assets/attachments/";
        if (!is_dir($location . $id)) {
            if (!mkdir($location . $id, 0777)) {
                //die("Something went wrong. please contact the developer");
            }
        }
        // var_dump('<pre>',$_FILES);die;
        $error = 0;
        foreach ($_FILES as $key => $file) {

            if($file['name'] == '') continue;
           
            $config = [];
            // Set the first set of configurations
            $config['upload_path'] = $location . $id;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
            $config['max_size'] = '1000'; // max_size in kb
            $config['file_name'] =  $id . '-' . $key . '_' . $file['name'];

            // Upload the file with the first set of configurations
            $file_path = $config['upload_path'] . '/' . $config['file_name'];
            $upload_result = move_uploaded_file($file['tmp_name'], $file_path);

            switch ($key) {
                case 'valid_id':
                    $key = 'Government ID';
                    break;
                case 'company_id':
                    $key = 'Company ID';
                    break;
                case 'payslip':
                    $key = 'Payslip / Voucher';
                    break;
                case 'cert_of_emp':
                    $key = 'Certificate of Employment';
                    break;
                // case 'voucher':
                //     $key = 'Voucher';
                //     break;
                case 'permit':
                    $key = 'Business Permit';
                    break;
                case 'tran_history';
                    $key = 'Transaction History';
                    break;
                case 'tnvs': 
                    $key = 'TNVS';
                    break;
                case 'remittance':
                    $key = 'Remittance';
                    break;
                case 'statement_account':
                    $key = 'Statement of Account';
                    break;
                 case 'contract':
                    $key = 'Contract';
                    break;
                case 'proof_income':
                    $key = 'Proof of Income ID';
                    break;
                default:
                    $key = $key;
                    break;
                }
            // If upload successful, perform additional actions
            if ($upload_result) {
                $result = $this->file_upload($config['file_name'], '39', $record_id, $key);
                if(empty($result)) {
                    $error++;
                }
            } else {
                $error++;
            }
        }

        return  $error;
        die;
        $data = array();
        $_FILES['file']['name'] = $_FILES['govtid']['name'];
        $_FILES['file']['type'] = $_FILES['govtid']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['govtid']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['govtid']['error'];
        $_FILES['file']['size'] = $_FILES['govtid']['size'];

        // Set preference
        $config['upload_path'] = $location . $id;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $config['max_size'] = '1000'; // max_size in kb
        $config['file_name'] = trim('a' . $_FILES['govtid']['name']);
        //$config['encrypt_name'] = TRUE;
        //Load upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        // File upload
        if ($this->upload->do_upload('file')) {
            // Get data about the file
            // die($config['upload_path'] . '/' . trim('a' . $_FILES['govtid']['name']));
            // chmod($config['upload_path'] . '/' . trim('a' . $_FILES['govtid']['name']) , 777);
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];

            // Initialize array
            $data['filenames'][] = $filename;
            $this->file_upload(trim('a' . $_FILES['govtid']['name']), '39', $id, 'Government ID');
        }

        $_FILES['file']['name'] = $_FILES['coe']['name'];
        $_FILES['file']['type'] = $_FILES['coe']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['coe']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['coe']['error'];
        $_FILES['file']['size'] = $_FILES['coe']['size'];

        // Set preference
        $configb['upload_path'] = $location . $id;
        $configb['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $configb['max_size'] = '1000'; // max_size in kb
        $configb['file_name'] = trim('b' . $_FILES['coe']['name']);
        //$configb['encrypt_name'] = TRUE;
        //Load upload library
        $this->load->library('upload', $configb);
        $this->upload->initialize($configb);
        // File upload
        if ($this->upload->do_upload('file')) {
            // Get data about the file
            // chmod($config['upload_path'] . '/' . $configb['file_name'], 777);
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];

            // Initialize array
            $data['filenames'][] = $filename;
            $this->file_upload($configb['file_name'], '39', $id, 'Certificate of Employment');
        }
        $_FILES['file']['name'] = $_FILES['billing']['name'];
        $_FILES['file']['type'] = $_FILES['billing']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['billing']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['billing']['error'];
        $_FILES['file']['size'] = $_FILES['billing']['size'];

        // Set preference
        $configc['upload_path'] = $location . $id;
        $configc['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $configc['max_size'] = '1000'; // max_size in kb
        $configc['file_name'] = trim('c' . $_FILES['billing']['name']);
        //$configc['encrypt_name'] = TRUE;
        //Load upload library
        $this->load->library('upload', $configc);
        $this->upload->initialize($configc);

        // File upload
        if ($this->upload->do_upload('file')) {
            // Get data about the file
            // chmod($config['upload_path'] . '/' . $configc['file_name'], 777);
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];

            // Initialize array
            $data['filenames'][] = $filename;
            $this
                ->inquiry
                ->file_upload($configc['file_name'], '39', $id, 'Proof of Billing');
        }
        $_FILES['file']['name'] = $_FILES['selfie']['name'];
        $_FILES['file']['type'] = $_FILES['selfie']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['selfie']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['selfie']['error'];
        $_FILES['file']['size'] = $_FILES['selfie']['size'];

        // Set preference
        $configd['upload_path'] = $location . $id;
        $configd['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $configd['max_size'] = '1000'; // max_size in kb
        $configd['file_name'] = trim('d' . $_FILES['selfie']['name']);
        // $configd['encrypt_name'] = TRUE;
        //Load upload library
        $this->load->library('upload', $configd);
        $this->upload->initialize($configd);

        // File upload
        if ($this->upload->do_upload('file')) {
            // Get data about the file
            // chmod($config['upload_path'] . '/' . $configd['file_name'], 777);
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];

            // Initialize array
            $data['filenames'][] = $filename;
            $this->inquiry->file_upload($configd['file_name'], '39', $id, 'Selfie');
        }
        $_FILES['file']['name'] = $_FILES['sketch']['name'];
        $_FILES['file']['type'] = $_FILES['sketch']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['sketch']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['sketch']['error'];
        $_FILES['file']['size'] = $_FILES['sketch']['size'];

        // Set preference
        $confige['upload_path'] = $location . $id;
        $confige['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $confige['max_size'] = '1000'; // max_size in kb
        $confige['file_name'] = trim('e' . $_FILES['sketch']['name']);
        //$confige['encrypt_name'] = TRUE;
        //Load upload library
        $this->load->library('upload', $confige);
        $this->upload->initialize($confige);

        // File upload
        if ($this->upload->do_upload('file')) {
            // Get data about the file
            // chmod($config['upload_path'] . '/' . $confige['file_name'], 777);
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];

            // Initialize array
            $data['filenames'][] = $filename;
            $this->inquiry->file_upload($confige['file_name'], '39', $id, 'Sketch of Home');
        }
    }

    public function SuppAttachIns($post)
    {
        $id         = $post['formid'];
        $table      = 'tblFormPurSupplierAccreditation';
        $tbl_email  = 'tblLogsEmail';
        $count      = $post['attcount'];
        $logtable = 'tblLogsStatus';

        $insert = [
            'CurrentStatusId' => 831
        ];

        $to_email_add = $this->get_ems_employee($post['AssignedTo']);

        $email_data = [
            "CreatedBy"         => $post['first_name'],
            "FormId"            => 70,
            "FormRecordId"      => $post['formid'],
            "CurrentStatusId"   => 831,
            "PreviousStatusId"  => 658,
            "ToEmailAddress"    => !empty($to_email_add) ? implode(",", $to_email_add) : NULL,
            "CCEmailAddress"    => NULL,
            "Title"             => "Supplier Accreditation | " . $post['first_name'] . " | SUBMITTED",
            "FormName"          => "SUPPLIER ACCREDITATION",
            "BranchName"        => null,
            "EmployeeName"      => null,
            "ActionType"        => "CHANGE STATUS",
            "isSent"            => 0,
            "SentStatus"        => 'PENDING',
            "EmailTemplateId"   => 1
        ];

        $location = FCPATH . "assets/attachments/supplier/";
        if (!is_dir($location)) :
            if (!mkdir($location, 0777)) :
                die("Something went wrong. please contact the developer");
            endif;
        endif;

        if (!is_dir($location . $id)) :
            if (!mkdir($location . $id, 0777)) :
                die("Something went wrong. please contact the developer");
            endif;
        endif;

        $count_error = 0;
        $error_upload = [];
        for ($i = 1; $i <= $count; $i++) :
            # validation
            if (!isset($_FILES['add' . $i])) continue;

            $_FILES['file']['name']     = $_FILES['add' . $i]['name'];
            $_FILES['file']['type']     = $_FILES['add' . $i]['type'];
            $_FILES['file']['tmp_name'] = $_FILES['add' . $i]['tmp_name'];
            $_FILES['file']['error']    = $_FILES['add' . $i]['error'];
            $_FILES['file']['size']     = $_FILES['add' . $i]['size'];

            # File Config
            $config['upload_path'] = $location . $id;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
            $config['file_name'] = trim($_FILES['add' . $i]['name']);
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            # File upload
            if ($this->upload->do_upload('file')):
                $uploadData = $this->upload->data();
                $filename = $uploadData['file_name'];

                # Init
                $data['filenames'][] = $filename;
                $result = $this->file_upload_supp(trim($_FILES['add' . $i]['name']), '70', $id, trim($_FILES['add' . $i]['name']), $_FILES['add' . $i]['size']);
            else:
                $count_error++;
                $error_upload[] = $_FILES['file']['name'];
            endif;
        endfor;

        if (!empty($error_upload)) return $error_upload;

        if ($post['buttontype'] == 'finalbutton') :
            $this->db->update($table, $insert, ['id' => $id]);
            if (!empty($email_data)) :
                $this->db->insert($tbl_email, $email_data);
            endif;


            $logs = array(
                'FormId' => '70',
                'FormRecordId' => $id,
                'StatusId' => '831',
                'createby'       => 'EXTERNAL',
                'createDT' => date('Y-m-d H:i:s'),
                'EffectiveDT' => date('Y-m-d'),
                'deletedflag' => false
            );
            $result_log = $this->db->insert($logtable, $logs);
        endif;

        return true;
    }


    public function loanSubmit($post)
    {
        //   $id = '1234';
        if (!empty($post['last_name']) && !empty($post['first_name']) && !empty($post['contact_no'])) {
            $table = 'tblformloanapplication';
            $logtable = 'tblLogsStatus';
            //  $referral_id = $this->insert_loan_referrer($post['name="datetime"']);
            $customer_id = $this->insert_loan_customer();
            //$beneficial_id   = $this->insert_beneficial();
            $emp_business_id = $this->insert_employment_business();
            $spouse_id = $this->insert_loan_spouse();
            $LoanId1 = $this->insert_existing_loan($post['l1_bank'], $post['l1_type'], $post['l1_amount'], $post['l1_monthly'], $post['l1_term'], $post['l1_granted'], $post['l1_maturity']);
            $LoanId2 = $this->insert_existing_loan($post['l2_bank'], $post['l2_type'], $post['l2_amount'], $post['l2_monthly'], $post['l2_term'], $post['l2_granted'], $post['l2_maturity']);
            $LoanId3 = $this->insert_existing_loan($post['l3_bank'], $post['l3_type'], $post['l3_amount'], $post['l3_monthly'], $post['l3_term'], $post['l3_granted'], $post['l3_maturity']);
            /* $RefId1        = $this->insert_referral($post['reference_name_1'], $post['reference_address_1'], $post['reference_contact_1'], $post['reference_rel_1']);
                $RefId2        = $this->insert_referral($post['reference_name_2'], $post['reference_address_2'], $post['reference_contact_2'], $post['reference_rel_2']);
                $RefId3        = $this->insert_referral($post['reference_name_3'], $post['reference_address_3'], $post['reference_contact_3'], $post['reference_rel_3']); */
            $insert = in_array($post['borrower_type'], array(
                586,
                587,
                588
            )) ? array(
                'BusinessSizeId' => $post['borrower_size'],
                'BusinessNatureId' => $post['borrower_nature']
            ) : array();

            $arr = explode("*", $post['model'], 2);
            $model = $arr[0];
            $type = $arr[1];

            $insert += array(
                //'ReferalId'             => $referral_id,
                'BrandId' => $post['brand'],
                'ModelId' => $model,
                'MCTypeId' => $type,
                'ColorId' => $post['color'],
                'LoanTypeId' => $post['loan_type'],
                'LoanAmount' => $post['loan_amount'],
                'LoanTerm' => $post['loan_term'],
                'DownPayment' => $post['downpayment'],
                'LoanPurpose' => $post['loan_purpose'],
                'CustomerId' => $customer_id,
                'BorrowerTypeId' => $post['borrower_type'],
                //'TelesalesId' => 540,
                //'BeneficialId'          => $beneficial_id,
                'Signature' => $post['sig-dataUrl'],
                'SignDate' => date('Y-m-d'),
                'SourceId' => $post['sourceid'],
                'CampaignId' => $post['campaignid'],
                'ClusterCode' => (!empty($post['clusterid']) ? $post['clusterid'] : NULL),
                'EmploymentBusinessId' => $emp_business_id,
                'SourceFundId' => $post['source_fund'],
                'MonthlySalary' => $post['salary'],
                'BusinessIncome' => $post['business_income'],
                'OtherIncome' => $post['other_income'],
                'ExistingLoanId1' => $LoanId1,
                'ExistingLoanId2' => $LoanId2,
                'ExistingLoanId3' => $LoanId3,
                'RefId1' => $this->save_customer_ref(ucfirst($post['r1_name']), ucfirst($post['r1_relationship']), $post['r1_contact_no'], ucfirst($post['r1_address'])),
                'RefId2' => $this->save_customer_ref(ucfirst($post['r2_name']), ucfirst($post['r2_relationship']), $post['r2_contact_no'], ($post['r2_address'])),
                'RefId3' => $this->save_customer_ref(ucfirst($post['r3_name']), ucfirst($post['r3_relationship']), $post['r3_contact_no'], ucfirst($post['r3_address'])),
                'TransactionType' => 'EXTERNAL',
                'UpdatedBy' => 'EXTERNAL'
                //'SpouseId' => $spouse_id
                //'Signature'             => $post['inquiry_id'],
                //'SignateDate'           => $post['inquiry_id'],
                //'Createby'              => $_SESSION['username'],
                //'InquiryId'             => $post['inquiry_id'],
                //'Branch'                => $post['inquiry_id'],
                //'assign_user'           => $post['inquiry_id'],
                //'LosAppId'              => $post['inquiry_id'],
                //'Source'                => $post['inquiryuiry_id'],
                //'ClusterCode'           => $post['inquiry_id'],
                //'SlaDate'               => $post['inquiry_id'],

            );
            if ($post['clusterid'] == '') {
                $insert += array(
                    'TelesalesId' => 540
                );
            }
            $this->db->trans_start();
            $this->db->insert($table, $insert);
            $id = $this->db->insert_id();
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                //return "Query Failed";
            } else {

                $logs = array(
                    'FormId' => '39',
                    'FormRecordId' => $id,
                    'StatusId' => '286',
                    'createby'       => 'EXTERNAL',
                    'createDT' => date('Y-m-d H:i:s'),
                    'EffectiveDT' => date('Y-m-d'),
                    'deletedflag' => false
                );

                $location = FCPATH . "assets/attachments/";
                if (!is_dir($location . $id)) {
                    if (!mkdir($location . $id, 0777)) {
                        // die("Something went wrong. please contact the developer");
                    }
                }

                $data = array();
                $_FILES['file']['name'] = $_FILES['govtid']['name'];
                $_FILES['file']['type'] = $_FILES['govtid']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['govtid']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['govtid']['error'];
                $_FILES['file']['size'] = $_FILES['govtid']['size'];

                // Set preference
                $config['upload_path'] = $location . $id;
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $config['max_size'] = '1000'; // max_size in kb
                $config['file_name'] = trim('a' . $_FILES['govtid']['name']);
                //$config['encrypt_name'] = TRUE;
                //Load upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // File upload
                if ($this->upload->do_upload('file')) {
                    // Get data about the file
                    // die($config['upload_path'] . '/' . trim('a' . $_FILES['govtid']['name']));
                    // chmod($config['upload_path'] . '/' . trim('a' . $_FILES['govtid']['name']) , 777);
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];

                    // Initialize array
                    $data['filenames'][] = $filename;
                    $this->file_upload(trim('a' . $_FILES['govtid']['name']), '39', $id, 'Government ID');
                }

                $_FILES['file']['name'] = $_FILES['coe']['name'];
                $_FILES['file']['type'] = $_FILES['coe']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['coe']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['coe']['error'];
                $_FILES['file']['size'] = $_FILES['coe']['size'];

                // Set preference
                $configb['upload_path'] = $location . $id;
                $configb['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $configb['max_size'] = '1000'; // max_size in kb
                $configb['file_name'] = trim('b' . $_FILES['coe']['name']);
                //$configb['encrypt_name'] = TRUE;
                //Load upload library
                $this->load->library('upload', $configb);
                $this->upload->initialize($configb);
                // File upload
                if ($this->upload->do_upload('file')) {
                    // Get data about the file
                    // chmod($config['upload_path'] . '/' . $configb['file_name'], 777);
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];

                    // Initialize array
                    $data['filenames'][] = $filename;
                    $this->file_upload($configb['file_name'], '39', $id, 'Certificate of Employment');
                }
                $_FILES['file']['name'] = $_FILES['billing']['name'];
                $_FILES['file']['type'] = $_FILES['billing']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['billing']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['billing']['error'];
                $_FILES['file']['size'] = $_FILES['billing']['size'];

                // Set preference
                $configc['upload_path'] = $location . $id;
                $configc['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $configc['max_size'] = '1000'; // max_size in kb
                $configc['file_name'] = trim('c' . $_FILES['billing']['name']);
                //$configc['encrypt_name'] = TRUE;
                //Load upload library
                $this->load->library('upload', $configc);
                $this->upload->initialize($configc);

                // File upload
                if ($this->upload->do_upload('file')) {
                    // Get data about the file
                    // chmod($config['upload_path'] . '/' . $configc['file_name'], 777);
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];

                    // Initialize array
                    $data['filenames'][] = $filename;
                    $this
                        ->inquiry
                        ->file_upload($configc['file_name'], '39', $id, 'Proof of Billing');
                }
                $_FILES['file']['name'] = $_FILES['selfie']['name'];
                $_FILES['file']['type'] = $_FILES['selfie']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['selfie']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['selfie']['error'];
                $_FILES['file']['size'] = $_FILES['selfie']['size'];

                // Set preference
                $configd['upload_path'] = $location . $id;
                $configd['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $configd['max_size'] = '1000'; // max_size in kb
                $configd['file_name'] = trim('d' . $_FILES['selfie']['name']);
                // $configd['encrypt_name'] = TRUE;
                //Load upload library
                $this->load->library('upload', $configd);
                $this->upload->initialize($configd);

                // File upload
                if ($this->upload->do_upload('file')) {
                    // Get data about the file
                    // chmod($config['upload_path'] . '/' . $configd['file_name'], 777);
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];

                    // Initialize array
                    $data['filenames'][] = $filename;
                    $this->inquiry->file_upload($configd['file_name'], '39', $id, 'Selfie');
                }
                $_FILES['file']['name'] = $_FILES['sketch']['name'];
                $_FILES['file']['type'] = $_FILES['sketch']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['sketch']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['sketch']['error'];
                $_FILES['file']['size'] = $_FILES['sketch']['size'];

                // Set preference
                $confige['upload_path'] = $location . $id;
                $confige['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $confige['max_size'] = '1000'; // max_size in kb
                $confige['file_name'] = trim('e' . $_FILES['sketch']['name']);
                //$confige['encrypt_name'] = TRUE;
                //Load upload library
                $this->load->library('upload', $confige);
                $this->upload->initialize($confige);

                // File upload
                if ($this->upload->do_upload('file')) {
                    // Get data about the file
                    // chmod($config['upload_path'] . '/' . $confige['file_name'], 777);
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];

                    // Initialize array
                    $data['filenames'][] = $filename;
                    $this->inquiry->file_upload($confige['file_name'], '39', $id, 'Sketch of Home');
                }
                $this->db->insert($logtable, $logs);
                return $id;
            }
        }
        //  redirect($_SERVER['HTTP_REFERER']);
    }

    public function file_upload($filename, $formid, $formrecordid, $label)
    {
        $updated = str_replace(" ", "_", $filename);
        //$table = 'tblcustomerinq';
        $table = 'tblAttachments';
        $folder = $formid == 39 ? date('Ymd').'_'.$formrecordid : $formrecordid;
        $insert = array(
            'FormId' => $formid,
            'FormRecordId' => $formrecordid,
            'FileName' => base_url('assets/attachments/' . $folder . '/' . $updated),
            'Label' => $label,
            'createDT' => date('Y-m-d H:i:s'),
            'filesize' => 0,
            'createby' => 'EXTERNAL'
        );
        $this->db->cache_off();
        /* $result = $this->db->query("SELECT id FROM tblattachments where 
            FormRecordId    = '$formrecordid' AND 
            Label   = '$label'
            ");*/
        $result = $this->db->select('id');
        $result->from($table);
        $result->where('FormRecordId', $formrecordid);
        $result->where('Label', $label);
        // echo json_encode($result->error()); 
        //echo $this->db->get()->row();
        $num_results = $result->count_all_results();
        /*echo $num_results;
            echo $formrecordid;
            echo $label; */
        // echo $this->db->
        if ($num_results === 1) {
            $this->db->select('id');
            $this->db->from($table);
            $this->db->where('FormRecordId', $formrecordid);
            $this->db->where('Label', $label);

            $id = $this->db->get()->row()->id;
            $this->db->cache_on();
            //  $id = $result->row()->id;
            // echo $this->db->get()->row()->id;
            //echo $id;
            $this->db->update($table, $insert, ['id' => $id]);
        } else {

            $this->db->insert($table, $insert);
            $id = $this->db->insert_id();

            return $id;
        }

        // $this->logs->user_log($_SESSION['username'],'ADD',$table ,$id);
        //return $id;


    }

    public function file_upload_supp($filename, $formid, $formrecordid, $label, $size)
    {
        $updated = str_replace(" ", "_", $filename);
   
        $data = [
            'FormId' => $formid,
            'FormRecordId' => $formrecordid,
            'FileName' => base_url('assets/attachments/supplier/' . $formrecordid . '/' . $updated),
            'Label' => $label,
            'createDT' => date('Y-m-d H:i:s'),
            'filesize' => $size,
            'createby' => 'EXTERNAL'
        ];

        $if_exist = $this->db->query("SELECT id FROM tblAttachments WHERE FormId = 70 AND FormRecordId = {$formrecordid} AND label = '{$label}' ");

        if ($if_exist && $if_exist->num_rows() > 0):
            return $this->db->update("tblAttachments", $data, ['id' => $if_exist->row()->id]);
        else:
            return $this->db->insert("tblAttachments", $data);
        endif;
    }

    public function insert_loan_referrer($datetime)
    {
        $this
            ->db
            ->insert('tblformloanreferral', array(
                //'ReferralName'=> $name,
                //'Dealer'      => $dealer,
                //'DealerCode'  => $code,
                //  'DateTime'    => datetime_format($datetime)

            ));
        return $this
            ->db
            ->insert_id();
    }

    public function insert_loan_spouse()
    {
        $post = $this
            ->input
            ->post();
        $this
            ->db
            ->insert('tblspouse', array(
                'SpouseFname'           => $post['spousefname'],
                'SpouseMname'           => $post['spousemname'],
                'SpouseLname'           => $post['spouselname'],
                'SpouseNname'           => $post['spousenname'],
                'SpouseNationality'     => $post['spouse_nationality'],
                'SpouseAge'             => $post['spouse_age'] ?? 0,
                'SpouseBirthDate'       => $post['spouse_birthday'],
                'SpouseBirthPlace'      => $post['spouse_birthplace'],
                'SpouseMobileNumber'    => $post['spouse_contact'],
                'SpouseTelNo'           => $post['spouse_telno'],
                'SpouseAddress'         => $post['spouse_address']
            ));
        return $this
            ->db
            ->insert_id();
    }

    public function insert_loan_spouse_update()
    {
        $post = $this
            ->input
            ->post();
        $insert = array(
            'SpouseFname'           => $post['spousefname'],
            'SpouseMname'           => $post['spousemname'],
            'SpouseLname'           => $post['spouselname'],
            'SpouseNname'           => $post['spousenname'],
            'SpouseNationality'     => $post['spouse_nationality'],
            'SpouseAge'             => $post['spouse_age'] ?? 0,
            'SpouseBirthDate'       => $post['spouse_birthday'],
            'SpouseBirthPlace'      => $post['spouse_birthplace'],
            'SpouseMobileNumber'    => $post['spouse_contact'],
            'SpouseTelNo'           => $post['spouse_telno'],
            'SpouseAddress'         => $post['spouse_address']
        );
        if ($post['spouses'] == '') {
            $this
                ->db
                ->insert('tblspouse', $insert);
            return $this
                ->db
                ->insert_id();
        } else {
            $this
                ->db
                ->update('tblspouse', $insert, ['id' => $post['spouses']]);
            return $post['spouses'];
        }
    }

    public function insert_loan_customer_two($post, $cust_id)
    {

        $spouse_id = "";
        $insert = array(
            'MaritalStatusId' => $post['marital_status']
        );
        if ($post['marital_status'] == 570) {
            $insert += array(
                'WidowYears' => $post['widow_years']
            );
        } else if ($post['marital_status'] == 638) {
            $insert += array(
                'SeparatedYears' => $post['separated_years']
            );
        } else if ($post['marital_status'] == 569) {
            $spouse_id = $this->insert_loan_spouse();
        } else if ($post['marital_status'] == 645) {
            $spouse_id = $this->insert_loan_spouse();
        }
        if ($post['tin'] != '') {
            $insert += array(
                'TIN' => $post['tin']
            );
        } else {
            $insert += array(
                'TIN' => 'N/A'
            );
        }

        //Previous Address
        $year_months = "";
        if ($post['tenurecountyears'] == 1) {
            $year_months = $post['tenurecountmonths'] + 12;
        }

        if ($post['tenurecountyears'] > 1 || $post['tenurecountmonths'] > 23 || $year_months > 23) {
            $insert += array(
                'PreviousSame' => 1,
            );
        } else {
            if (empty($post['previousaddress'])) {
                $insert += array(
                    'PreviousRegionCode' => NULL,
                    'PreviousProvinceCode' => NULL,
                    'PreviousCityCode' => NULL,
                    'PreviousBarangayCode' => NULL,
                );
            } else {

                $insert += array(
                    'PreviousRegionCode' => $this->get_psgc_by_brgy_new($post['previousaddress'], 'regCode'),
                    'PreviousProvinceCode' => $this->get_psgc_by_brgy_new($post['previousaddress'], 'provCode'),
                    'PreviousCityCode' => $this->get_psgc_by_brgy_new($post['previousaddress'], 'citymunCode'),
                    'PreviousBarangayCode' => $this->get_psgc_by_brgy_new($post['previousaddress'], 'brgyCode'),
                    'PreviousStreet' => $post['address_prev'],
                    'PreviousZipCode' => $this->get_psgc_by_brgy_new($post['previousaddress'], 'zip_code'),
                );
            }
        }

        //Permanent Address
        //var_dump($post['sameaddindi']);
        if ($post['sameaddindi'] == "1") {
            $insert += array(
                'ProvincialSame' => 1,
            );
        } else {
            if (empty($post['permanentaddress'])) {
                $insert += array(
                    'ProvincialRegionCode' => NULL,
                    'ProvincialProvinceCode' => NULL,
                    'ProvincialCityCode' => NULL,
                    'ProvincialBarangayCode' => NULL,
                    'ProvincialZipCode' => NULL,
                    //  'ProvincialStreet' => NULL,
                );
            } else {
                $insert += array(
                    'ProvincialRegionCode' => $this->get_psgc_by_brgy_new($post['permanentaddress'], 'regCode'),
                    'ProvincialProvinceCode' => $this->get_psgc_by_brgy_new($post['permanentaddress'], 'provCode'),
                    'ProvincialCityCode' => $this->get_psgc_by_brgy_new($post['permanentaddress'], 'citymunCode'),
                    'ProvincialBarangayCode' => $this->get_psgc_by_brgy_new($post['permanentaddress'], 'brgyCode'),
                    'ProvincialZipCode' => $this->get_psgc_by_brgy_new($post['permanentaddress'], 'zip_code'),
                    //'ProvincialStreet' => $post['address_sub'] ,
                );
            }
        }
        $insert += array(
            'GenderId' => $post['gender'],
            'Nationality' => $post['nationality'],
            'BirthDate' => $post['birthday'],
            // 'TIN'         => $post['tin'],
            'BirthPlace' => $post['birthplace'],
            'SSSGSIS' => $post['sss_gsis'],
            'NumberOfChildrenAndAge' => $post['no_children'],
            'EducationId' => $post['education_attainment'],
            'MothersName' => $post['maiden_name'],
            'NumberOfDependents' => $post['dependent'],
            //'ZipCode' => $post['zip'],
            'RegionCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'regCode'),
            'ProvinceCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'provCode'),
            'CityCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'citymunCode'),
            'BarangayCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'brgyCode'),
            'ZipCode' => $this->get_psgc_by_brgy_new($post['presentaddress'], 'zip_code'),
            // 'BarangayCode'=> $post['presentaddress'],
            'Street' => $post['address'],
            'ResidenceId' => $post['residence_type'],
            'LengthOfStayYear' => $post['tenurecountyears'],
            'LengthOfStayMonth' => $post['tenurecountmonths'],
            //'PostPaidPrepaid' => $post['numberpaid'],
            'ProvincialStreet' => $post['address_sub'],
            /* 'SpouseName' => $post['spouse_name'],
                'SpouseNationality' => $post['spouse_nationality'],
                'SpouseAge' => $post['spouse_age'],
                'SpouseBirthDate' => $post['spouse_birthday'],
                'SpouseBirthPlace' => $post['spouse_birthplace'],
                'SpouseMobileNumber' => $post['spouse_contact'],
                'SpouseTelNo' => $post['spouse_telno'], */

            'Facebook' => $post['facebook'],
            'Instagram' => $post['instagram'],
            'Others' => $post['other_social'],
            'Telephone' => $post['home_tel'],
            'Fax' => $post['home_fax'],
            'SpouseId' => $spouse_id
        );
        $this->db->update('tblcustomerinq', $insert, ["id" => $cust_id]);
    }

    public function insert_loan_customer()
    {

        $spouse_id = "";

        $post = $this
            ->input
            ->post();
        $insert = array(
            'MaritalStatusId' => $post['marital_status']
        );
        if ($post['marital_status'] == 570) {
            $insert += array(
                'WidowYears' => $post['widow_years']
            );
        } else if ($post['marital_status'] == 638) {
            $insert += array(
                'SeparatedYears' => $post['separated_years']
            );
        } else if ($post['marital_status'] == 569) {
            $spouse_id = $this->insert_loan_spouse();
        } else if ($post['marital_status'] == 645) {
            $spouse_id = $this->insert_loan_spouse();
        }
        if ($post['tin'] != '') {
            $insert += array(
                'TIN' => $post['tin']
            );
        } else {
            $insert += array(
                'TIN' => 'N/A'
            );
        }

        //Previous Address
        $year_months = "";
        if ($post['tenurecountyears'] == 1) {
            $year_months = $post['tenurecountmonths'] + 12;
        }

        if ($post['tenurecountyears'] > 1 || $post['tenurecountmonths'] > 23 || $year_months > 23) {
            $insert += array(
                'PreviousSame' => 1,
            );
        } else {
            if (empty($post['previousaddress'])) {
                $insert += array(
                    'PreviousRegionCode' => NULL,
                    'PreviousProvinceCode' => NULL,
                    'PreviousCityCode' => NULL,
                    'PreviousBarangayCode' => NULL,

                );
            } else {

                $insert += array(
                    'PreviousRegionCode' => $this->get_psgc_by_brgy($post['previousaddress'], 'regCode'),
                    'PreviousProvinceCode' => $this->get_psgc_by_brgy($post['previousaddress'], 'provCode'),
                    'PreviousCityCode' => $this->get_psgc_by_brgy($post['previousaddress'], 'citymunCode'),
                    'PreviousBarangayCode' => $this->get_psgc_by_brgy($post['previousaddress'], 'brgyCode'),
                    'PreviousStreet' => $post['address_prev'],
                    'PreviousZipCode' => $this->get_psgc_by_brgy($post['previousaddress'], 'zip_code'),
                );
            }
        }

        //Permanent Address
        //var_dump($post['sameaddindi']);
        if ($post['sameaddindi'] == "1") {
            $insert += array(
                'ProvincialSame' => 1,
            );
        } else {
            if (empty($post['permanentaddress'])) {
                $insert += array(
                    'ProvincialRegionCode' => NULL,
                    'ProvincialProvinceCode' => NULL,
                    'ProvincialCityCode' => NULL,
                    'ProvincialBarangayCode' => NULL,
                    'ProvincialZipCode' => NULL,
                    //  'ProvincialStreet' => NULL,
                );
            } else {
                $insert += array(
                    'ProvincialRegionCode' => $this->get_psgc_by_brgy($post['permanentaddress'], 'regCode'),
                    'ProvincialProvinceCode' => $this->get_psgc_by_brgy($post['permanentaddress'], 'provCode'),
                    'ProvincialCityCode' => $this->get_psgc_by_brgy($post['permanentaddress'], 'citymunCode'),
                    'ProvincialBarangayCode' => $this->get_psgc_by_brgy($post['permanentaddress'], 'brgyCode'),
                    'ProvincialZipCode' => $this->get_psgc_by_brgy($post['permanentaddress'], 'zip_code'),
                    //'ProvincialStreet' => $post['address_sub'] ,
                );
            }
        }
        //  $insert += ($post['residence_type']==614) ? array('MortgagedId' => $post['Morgaged']) : array();
        $insert += array(
            'FirstName' => $post['first_name'],
            'MiddleName' => $post['middle_name'],
            'LastName' => $post['last_name'],
            'ExtensionName' => $post['ext_name'],
            'GenderId' => $post['gender'],
            'Nationality' => $post['nationality'],
            'BirthDate' => $post['birthday'],
            // 'TIN'         => $post['tin'],
            'BirthPlace' => $post['birthplace'],
            'SSSGSIS' => $post['sss_gsis'],
            'NumberOfChildrenAndAge' => $post['no_children'],
            'EducationId' => $post['education_attainment'],
            'MothersName' => $post['maiden_name'],
            'NumberOfDependents' => $post['dependent'],
            //'ZipCode' => $post['zip'],
            'RegionCode' => $this->get_psgc_by_brgy($post['presentaddress'], 'regCode'),
            'ProvinceCode' => $this->get_psgc_by_brgy($post['presentaddress'], 'provCode'),
            'CityCode' => $this->get_psgc_by_brgy($post['presentaddress'], 'citymunCode'),
            'BarangayCode' => $this->get_psgc_by_brgy($post['presentaddress'], 'brgyCode'),
            'ZipCode' => $this->get_psgc_by_brgy($post['presentaddress'], 'zip_code'),
            // 'BarangayCode'=> $post['presentaddress'],
            'Street' => $post['address'],
            'ResidenceId' => $post['residence_type'],
            'LengthOfStayYear' => $post['tenurecountyears'],
            'LengthOfStayMonth' => $post['tenurecountmonths'],
            'PostPaidPrepaid' => $post['numberpaid'],
            'MobileNumber' => $post['contact_no'],
            'Email' => $post['email'],
            //'ProvincialZipCode' => $post['zip_sub'],
            'ProvincialStreet' => $post['address_sub'],
            /* 'SpouseName' => $post['spouse_name'],
                'SpouseNationality' => $post['spouse_nationality'],
                'SpouseAge' => $post['spouse_age'],
                'SpouseBirthDate' => $post['spouse_birthday'],
                'SpouseBirthPlace' => $post['spouse_birthplace'],
                'SpouseMobileNumber' => $post['spouse_contact'],
                'SpouseTelNo' => $post['spouse_telno'], */

            'Facebook' => $post['facebook'],
            'Instagram' => $post['instagram'],
            'Others' => $post['other_social'],
            'Telephone' => $post['home_tel'],
            'Fax' => $post['home_fax'],
            'SpouseId' => $spouse_id
        );
        // $this
        //     ->db
        //     ->insert('tblcustomerinq', $insert);
        // return $this
        //     ->db
        //     ->insert_id();
        //         'Facebook' => $post['facebook'],
        //         'Instagram' => $post['instagram'],
        //         'Others' => $post['other_social'],
        //         'Telephone' => $post['home_tel'],
        //         'Fax' => $post['home_fax'],
        //         'SpouseId' => $spouse_id
        //     );
        $this
            ->db
            ->insert('tblcustomerinq', $insert);
        return $this
            ->db
            ->insert_id();
    }

    /*  public function insert_beneficial()
    {
        $post = $this->input->post();
        $this->db->insert('tblformloanbeneficialowner',
            array(
        'OwnerId1'   => $this->insert_owners($post['bene_name_1'],$post['bene_address_1'],$post['bene_contact_1'],$post['bene_citizenship_1'],$post['bene_ownership_1']),
        'OwnerId2'   => $this->insert_owners($post['bene_name_2'],$post['bene_address_2'],$post['bene_contact_2'],$post['bene_citizenship_2'],$post['bene_ownership_2']),
        'OwnerId3'   =>  $this->insert_owners($post['bene_name_3'],$post['bene_address_3'],$post['bene_contact_3'],$post['bene_citizenship_3'],$post['bene_ownership_3']),
        'BranchUnit'   => $post['branch_unit'],
        'AccountName'  => $post['account_name'], 
        'AccountNumber'=> $post['account_no'], 
        'CIFNumber'    => $post['cif']
            ) 
        );   
        return $this->db->insert_id();
    } 
    public function insert_owners($name, $place, $contact, $citizenship, $percentage)
    {
        $this->db->insert('tblformloanowners',
            array(
                'Name'                  => $name,
                'BirthPlace'            => $place,
                'ContactNumber'         => $contact,
                'CitizenshipNationality'=> $citizenship, 
                'PercentageOfOwnership' => $percentage
            ) 
        );   
        return $this->db->insert_id();
    } */

    public function get_psgc_view($termSearch = "", $psgc_code = "")
    {
        // $termSearch = !empty($termSearch) ? _removeSpecialChars($termSearch) : NULL;
        $psgc_code = trim($psgc_code);
        $w = "";
        // $w = !empty($termSearch) ? " AND LOWER(searchTerm) LIKE LOWER('%{$termSearch}%')" : $w;
        /*$w = !empty($termSearch) ? " AND (
        TRIM(LOWER(provDesc)) LIKE TRIM(LOWER('%{$termSearch}%'))
        OR TRIM(LOWER(citymunDesc)) LIKE TRIM(LOWER('%{$termSearch}%'))
        OR TRIM(LOWER(brgyDesc)) LIKE TRIM(LOWER('%{$termSearch}%'))
        )" : $w;
        //$w = !empty($psgc_code) ? " AND ( TRIM(brgyCode) = '{$psgc_code}' OR TRIM(citymunCode) = '{$psgc_code}' OR TRIM(provCode) = '{$psgc_code}' OR TRIM(regCode) = '{$psgc_code}') " : $w;*/

        if (!empty($termSearch)) {
            $keyword = explode(',', $termSearch);
            switch (count($keyword)) {
                case 1:
                    $w .= "AND (
            (TRIM(LOWER(regDesc))     LIKE '%" . trim($keyword[0]) . "%')
            OR
            (TRIM(LOWER(provDesc))    LIKE '%" . trim($keyword[0]) . "%')
            OR
            (TRIM(LOWER(citymunDesc)) LIKE '%" . trim($keyword[0]) . "%')
            OR
            (TRIM(LOWER(brgyDesc))    LIKE '%" . trim($keyword[0]) . "%')
          )";
                    break;
                case 2:
                    $w .= "AND (
            (
             (TRIM(LOWER(regDesc))    LIKE '%" . trim($keyword[0]) . "%') AND 
             (TRIM(LOWER(provDesc))   LIKE '%" . trim($keyword[1]) . "%')
            )
            OR
            (
             (TRIM(LOWER(provDesc))    LIKE '%" . trim($keyword[0]) . "%') AND 
             (TRIM(LOWER(citymunDesc)) LIKE '%" . trim($keyword[1]) . "%')
            )
            OR
            (
             (TRIM(LOWER(citymunDesc)) LIKE '%" . trim($keyword[0]) . "%') AND 
             (TRIM(LOWER(brgyDesc))    LIKE '%" . trim($keyword[1]) . "%')
            )
          )";
                    break;
                case 3:
                    $w .= "AND (
            (
             (TRIM(LOWER(regDesc))     LIKE '%" . trim($keyword[0]) . "%') AND 
             (TRIM(LOWER(provDesc))    LIKE '%" . trim($keyword[1]) . "%') AND 
             (TRIM(LOWER(citymunDesc)) LIKE '%" . trim($keyword[2]) . "%')
            )
            OR
            (
             (TRIM(LOWER(provDesc))    LIKE '%" . trim($keyword[0]) . "%') AND 
             (TRIM(LOWER(citymunDesc)) LIKE '%" . trim($keyword[1]) . "%') AND 
             (TRIM(LOWER(brgyDesc))    LIKE '%" . trim($keyword[2]) . "%')
            )
          )";
                    break;
                case 4:
                    $w .= "AND (
            (TRIM(LOWER(regDesc))     LIKE '%" . trim($keyword[0]) . "%') AND 
            (TRIM(LOWER(provDesc))    LIKE '%" . trim($keyword[1]) . "%') AND 
            (TRIM(LOWER(citymunDesc)) LIKE '%" . trim($keyword[2]) . "%') AND 
            (TRIM(LOWER(brgyDesc))    LIKE '%" . trim($keyword[3]) . "%')
          )";
                    break;
            }
        }

        // $w = !empty($termSearch) ? "AND psgc_convention_name LIKE'%$termSearch%'": $w;
        $q = $this
            ->db
            ->query("
      SELECT  
        *
      FROM
        vw_psgc_zip
      WHERE
        1 = 1
        {$w}
    ");

        // var_dump($this->db->last_query()); die();
        return $q;
    }

    function _removeSpecialChars($str)
    {
        // Using preg_replace() function
        // to replace the word
        $res = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $str);

        // Returning the result
        return $res;
    }
    public function insert_employment_business()
    {
        $post = $this
            ->input
            ->post();
        $this
            ->db
            ->insert('tblformloanemploymentbusiness', array(
                'NatureOfBusiness' => $post['borrower_nature'],
                'NumberOfYearsInBusiness' => $post['years_business'],
                //'ZipCode' => $post['zip_bus'],
                'EmailAddress' => $post['previous_email'],
                'RegionCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy($post['busaddress'], 'regCode') : NULL,
                'ProvinceCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy($post['busaddress'], 'provCode') : NULL,
                'CityCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy($post['busaddress'], 'citymunCode') : NULL,
                'BarangayCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy($post['busaddress'], 'brgyCode') : NULL,
                'ZipCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy($post['busaddress'], 'zip_code') : NULL,
                //'BarangayCode'=> $post['busaddress'],
                'EmployeeBusinessAddress' => $post['address_bus'],
                'Street' => $post['address_bus'],
                'BusinessRegistered' => $post['register'],
                'EmploymentStatusId' => $post['position_status'],
                'NatureOfWork' => $post['nature_work'],
                'TelephoneNumber' => $post['telephone_no'],
                'LengthOfYears' => $post['tenurecountyears'],
                'LengthOfMonths' => $post['tenurecountmonths'],
                'EmployerBusinessName' => $post['company_name'],
                'RankPosition' => $post['position'],
                'PreviousEmployerBusinessName' => $post['previous_employer_name'],
                'PreviousTelephoneNumber' => $post['previous_employer_telno'],
                'PreviousLengthOfYears' => $post['previouslengthyears'],
                'PreviousLengthOfMonths' => $post['previouslengthmonths'],
                //'PreviousZipCode' => $post['previous_employer_zip'],
                'PreviousRegionCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy($post['previous_employer_address'], 'regCode') : NULL,
                'PreviousProvinceCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy($post['previous_employer_address'], 'provCode') : NULL,
                'PreviousCityCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy($post['previous_employer_address'], 'citymunCode') : NULL,
                'PreviousBarangayCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy($post['previous_employer_address'], 'brgyCode') : NULL,
                'PreviousZipCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy($post['previous_employer_address'], 'zip_code') : NULL,
                'PreviousStreet' => $post['previous_employer_street'],
                'PreviousRankPosition' => $post['previous_job']
            ));
        return $this
            ->db
            ->insert_id();
    }
    public function insert_employment_business_update()
    {
        $post = $this
            ->input
            ->post();
        $insert = array(
            'NatureOfBusiness' => $post['borrower_nature'],
            'NumberOfYearsInBusiness' => $post['years_business'],
            //'ZipCode' => $post['zip_bus'],
            'EmailAddress' => $post['previous_email'],
            'RegionCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy_new($post['busaddress'], 'regCode') : NULL,
            'ProvinceCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy_new($post['busaddress'], 'provCode') : NULL,
            'CityCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy_new($post['busaddress'], 'citymunCode') : NULL,
            'BarangayCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy_new($post['busaddress'], 'brgyCode') : NULL,
            'ZipCode' => !empty($post['busaddress']) ? $this->get_psgc_by_brgy_new($post['busaddress'], 'zip_code') : NULL,
            //'BarangayCode'=> $post['busaddress'],
            'EmployeeBusinessAddress' => $post['address_bus'],
            'Street' => $post['address_bus'],
            'BusinessRegistered' => $post['register'],
            'EmploymentStatusId' => $post['position_status'],
            'NatureOfWork' => $post['nature_work'],
            'TelephoneNumber' => $post['telephone_no'],
            'LengthOfYears' => $post['tenurecountyears'],
            'LengthOfMonths' => $post['tenurecountmonths'],
            'EmployerBusinessName' => $post['company_name'],
            'RankPosition' => $post['position'],
            'PreviousEmployerBusinessName' => $post['previous_employer_name'],
            'PreviousTelephoneNumber' => $post['previous_employer_telno'],
            'PreviousLengthOfYears' => $post['previouslengthyears'],
            'PreviousLengthOfMonths' => $post['previouslengthmonths'],
            //'PreviousZipCode' => $post['previous_employer_zip'],
            'PreviousRegionCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy_new($post['previous_employer_address'], 'regCode') : NULL,
            'PreviousProvinceCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy_new($post['previous_employer_address'], 'provCode') : NULL,
            'PreviousCityCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy_new($post['previous_employer_address'], 'citymunCode') : NULL,
            'PreviousBarangayCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy_new($post['previous_employer_address'], 'brgyCode') : NULL,
            'PreviousZipCode' => !empty($post['previous_employer_address']) ? $this->get_psgc_by_brgy_new($post['previous_employer_address'], 'zip_code') : NULL,
            'PreviousStreet' => $post['previous_employer_street'],
            'PreviousRankPosition' => $post['previous_job']
        );
        if ($post['busses'] == '') {
            $this
                ->db
                ->insert('tblformloanemploymentbusiness', $insert);
            return $this
                ->db
                ->insert_id();
        } else {
            $this
                ->db
                ->update('tblformloanemploymentbusiness', $insert, ['id' => $post['busses']]);
            return $post['busses'];
        }
    }
    public function insert_existing_loan($bank, $type, $amount, $installment, $term, $date_granted, $date_maturity)
    {
        $this
            ->db
            ->insert('tblformloanexistingloan', array(
                'Bank' => $bank,
                'TypeOfLoan' => $type,
                'LoanAmount' => $amount,
                'MonthlyInstallment' => $installment,
                'TermMonths' => $term,
                'DateGranted' => $date_granted,
                'MaturityDate' => $date_maturity
            ));
        return $this
            ->db
            ->insert_id();
    }

    public function insert_existing_loan_update($bank, $type, $amount, $installment, $term, $date_granted, $date_maturity, $lses)
    {
        $insert = array(
            'Bank' => $bank,
            'TypeOfLoan' => $type,
            'LoanAmount' => $amount,
            'MonthlyInstallment' => $installment,
            'TermMonths' => $term,
            'DateGranted' => $date_granted,
            'MaturityDate' => $date_maturity
        );
        if ($lses == '') {
            $this
                ->db
                ->insert('tblformloanexistingloan', $insert);
            return $this
                ->db
                ->insert_id();
        } else {
            $this
                ->db
                ->update('tblformloanexistingloan', $insert, ['id' => $lses]);
            return $lses;
        }
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

    public function get_psgc_by_brgy_new($brgycode, $get)
    {
        $array = explode(',', $brgycode[0]);
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

    public function loanSubmit_bak($post)
    {

        $table = 'tblformloanapplication';
        $logtable = 'tblLogsStatus';
        $rental = '';
        $amortization = '';
        $relative = '';
        $namerelative = '';
        $spouse_name = '';
        $spouse_address = '';
        $spouse_age = '';
        $spouse_birthday = '';
        $company_name = '';
        $business_name = '';
        $business_nature = '';
        $country_assignment = '';
        $boarding_date = '';
        $sender = '';
        $tenure_length = '';
        $existence_length = '';
        $monthly_income = '';
        $monthly_remittance = '';
        $position = '';
        $position_status = '';
        if ($post['residence_type'] == '516') {
            $rental = $post['rental'];
        }
        if ($post['residence_type'] == '515') {
            $amortization = $post['amortization'];
        }
        if ($post['residence_type'] == '518') {
            $relative = ucfirst($post['relative']);
            $namerelative = ucfirst($post['relative_name']);
        }
        if ($post['marital_status'] == '528') {
            $spouse_name = ucfirst($post['spouse_name']);
            $spouse_address = ucfirst($post['spouse_address']);
            $spouse_age = ucfirst($post['spouse_age']);
            $spouse_birthday = ucfirst($post['spouse_birthday']);
            $spouse_contact = $post['spouse_contact'];
        }
        if ($post['source_income'] == '522') {
            $company_name = ucfirst($post['company_name']);
            $position = ucfirst($post['position']);
            $position_status = ucfirst($post['position_status']);
        }
        if ($post['source_income'] == '523') {
            $business_name = ucfirst($post['business_name']);
            $business_nature = ucfirst($post['business_nature']);
        }
        if ($post['source_income'] == '524') {
            $country_assignment = ucfirst($post['country_assignment']);
            $boarding_date = ucfirst($post['boarding_date']);
        }
        if ($post['source_income'] == '525') {
            $sender = ucfirst($post['sender']);
        }
        //  $tenure_length = ucfirst($post['tenure_length']);
        //  $existence_length = ucfirst($post['existence_length']);
        if ($post['tenurecountyears'] == '') {
            $tenurecountyears = '';
        } else {
            $tenurecountyears = $post['tenurecountyears'] . " years";
        }

        if ($post['tenurecountmonths'] == '') {
            $tenurecountmonths = '';
        } else {
            $tenurecountmonths = $post['tenurecountmonths'] . " months";
        }

        if ($post['tenurelengthyears'] == '') {
            $tenurelengthyears = '';
        } else {
            $tenurelengthyears = $post['tenurelengthyears'] . " years";
        }

        if ($post['tenurelengthmonths'] == '') {
            $tenurelengthmonths = '';
        } else {
            $tenurelengthmonths = $post['tenurelengthmonths'] . " months";
        }

        if ($post['existencelengthyears'] == '') {
            $existencelengthyears = '';
        } else {
            $existencelengthyears = $post['existencelengthyears'] . " years";
        }

        if ($post['existencelengthmonths'] == '') {
            $existencelengthmonths = '';
        } else {
            $existencelengthmonths = $post['existencelengthmonths'] . " months";
        }

        $monthly_income = ucfirst($post['monthly_income']);
        $monthly_remittance = ucfirst($post['monthly_remittance']);

        $insert = array(
            'BrandId' => ucfirst($post['brand']),
            'ModelId' => ucfirst($post['model']),
            'MaidenName' => ucfirst($post['maiden_name']),
            //   'Branch'       => mb_substr($post['branch'], 0, 4),
            'Color' => ucfirst($post['color']),
            'source' => $post['sourceid'],
            'ClusterCode' => $post['clusterid'],
            //    'DatePurchase' => $post['date_purchase'],
            'Birthday' => $post['birthday'],
            'Dependent' => $post['dependent'],
            'ResidenceType' => $post['residence_type'],
            'ResidenceTenure' => $tenurecountyears . " " . $tenurecountmonths,
            'MaritalStatus' => $post['marital_status'],
            'SourceIncome' => $post['source_income'],
            'RelativeName' => $namerelative,
            'Relative' => $relative,
            'CompanyName' => $company_name,
            'BusinessName' => $business_name,
            'BusinessNature' => $business_nature,
            'CountryAssign' => $country_assignment,
            'BoardingDate' => $boarding_date,
            'Sender' => $sender,
            'LengthTenure' => $tenurelengthyears . " " . $tenurelengthmonths,
            'LengthExistence' => $existencelengthyears . " " . $existencelengthmonths,
            'MonthlyIncome' => $monthly_income,
            'MonthlyRemittance' => $monthly_remittance,
            'Position' => $position,
            'Status' => $position_status,
            'SpouseName' => $spouse_name,
            'SpouseAddress' => $spouse_address,
            'SpouseAge' => $spouse_age,
            'SpouseBirthday' => $spouse_birthday,
            'Rental' => $rental,
            'Amortization' => $amortization,
            'Bank' => ucfirst($post['bank']),
            'MonthlyAmortization' => $post['monthly_amortization'],
            'NameUnit' => ucfirst($post['name_of_unit']),
            'RelationshipBorrower' => ucfirst($post['borrower_relation']),
            'Signature' => $post['sig-dataUrl'],
            'DownPayment' => $post['desired_down'],
            'MonthlyPayment' => $post['desired_month'],
            'RefOneId' => $this->save_customer_ref(ucfirst($post['r1_name']), ucfirst($post['r1_relationship']), $post['r1_contact_no'], ucfirst($post['r1_address'])),
            'RefTwoId' => $this->save_customer_ref(ucfirst($post['r2_name']), ucfirst($post['r2_relationship']), $post['r2_contact_no'], ($post['r2_address'])),
            'RefThreeId' => $this->save_customer_ref(ucfirst($post['r3_name']), ucfirst($post['r3_relationship']), $post['r3_contact_no'], ucfirst($post['r3_address'])),
            /* 'R1FirstName' => $post['r1_first_name'],
                'R1MiddleName' => $post['r1_middle_name'],
                'R1LastName' => $post['r1_last_name'],
                'R1Address' => $post['r1_address'],
                'R1Contact' => $post['r1_contact'],
                'R1Relationship' => $post['r1_relationship'],
                                'R3FirstName' => $post['r3_first_name'],
                'R3MiddleName' => $post['r3_middle_name'],
                'R3LastName' => $post['r3_last_name'],
                'R3Address' => $post['r3_address'],
                'R3Contact' => $post['r3_contact'],
                'R3Relationship' => $post['r3_relationship'],
                                'R2FirstName' => $post['r2_first_name'],
                'R2MiddleName' => $post['r2_middle_name'],
                'R2LastName' => $post['r2_last_name'],
                'R2Address' => $post['r2_address'],
                'R2Contact' => $post['r2_contact'],
                'R2Relationship' => $post['r2_relationship'], */
            'CustomerId' => $this->save_customer_info(ucfirst($post['first_name']), ucfirst($post['middle_name']), ucfirst($post['last_name']), $post['regiona'], $post['province'], $post['city'], $post['barangay'], $post['email'], $post['contact_no'], ucfirst($post['address']))
        );
        $this->db->insert($table, $insert);
        $id = $this->db->insert_id();
        $logs = array(
            'FormId' => '39',
            'FormRecordId' => $id,
            'StatusId' => '286',
            'createDT' => date('Y-m-d H:i:s'),
            'EffectiveDT' => date('Y-m-d'),
            'deletedflag' => 0
        );


        $this->db->insert($logtable, $logs);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function save_customer_info($firstname, $middlename, $lastname, $region, $province, $city, $barangay, $email, $mobile, $address = '')
    {

        $table = 'tblcustomerinq';
        $result = $this->db->query("SELECT id FROM tblcustomerinq where 
            FirstName    = '$firstname' AND 
            MiddleName   = '$middlename' AND
            LastName     = '$lastname'   AND
            RegionCode   = '$region'     AND
            ProvinceCode = '$province'   AND
            CityCode     = '$city'       AND
            BarangayCode = '$barangay'   AND
            Email        = '$email'      AND
            MobileNumber = '$mobile'
            ");
        if ($result->num_rows()) {
            $id = $result->row()->id;
        } else {
            $insert = array(
                'FirstName' => ucfirst($firstname),
                'MiddleName' => ucfirst($middlename),
                'LastName' => ucfirst($lastname),
                'RegionCode' => $this->get_psgc_by_brgy($psgc, 'regCode'),
                'ProvinceCode' => $this->get_psgc_by_brgy($psgc, 'provCode'),
                'CityCode' => $this->get_psgc_by_brgy($psgc, 'citymunCode'),
                'BrgyCode' => $this->get_psgc_by_brgy($psgc, 'brgyCode'),
                //'BarangayCode'   =>  $psgc,
                'Email' => $email,
                'MobileNumber' => $mobile,
                'Address' => ucfirst($address),
            );
            $this->db->insert($table, $insert);
            $id = $this->db->insert_id();
        }
        // $this->logs->user_log($_SESSION['username'],'ADD',$table ,$id);
        return $id;
    }
    public function save_customer_info_inquiry($firstname, $middlename, $lastname, $psgc, $email, $mobile, $address = '')
    {
        /**
         * Refactor By Russel 06/27/22
         * Remove All code then rewrite
         */
        $spouse_id = "";

        $table = 'tblcustomerinq';

        $has_record = $this->db->query("
            SELECT
                id
            FROM
                tblcustomerinq
            WHERE
                UPPER(TRIM(FirstName)) = UPPER(TRIM('{$firstname}'))
                AND UPPER(TRIM(LastName)) = UPPER(TRIM('{$lastname}'))
                AND UPPER(TRIM(MobileNumber)) = UPPER(TRIM('{$mobile}'))
            ORDER BY
                id DESC
            LIMIT 1
        ");

        if ($has_record && $has_record->num_rows() > 0) :
            return $has_record->row()->id;
        endif;

        $insert = [
            'FirstName'         => ucfirst(trim($firstname)),
            'MiddleName'        => ucfirst(trim($middlename)),
            'LastName'          => ucfirst(trim($lastname)),
            'RegionCode'        => $this->get_psgc_by_brgy($psgc, 'regCode'),
            'ProvinceCode'      => $this->get_psgc_by_brgy($psgc, 'provCode'),
            'CityCode'          => $this->get_psgc_by_brgy($psgc, 'citymunCode'),
            'BarangayCode'      => $this->get_psgc_by_brgy($psgc, 'brgyCode'),
            'Email'             => $email,
            'MobileNumber'      => $mobile,
            'Address'           => ucfirst($address),
            'Address'           => ucfirst($address),
            'SpouseId'          => $spouse_id,
            "GeneratedId"       => !isset($_POST['gen_id']) ? null : $_POST['gen_id']
        ];

        $this->db->insert($table, $insert);
        return $this->db->insert_id();
    }

    public function save_applicant_info($firstname, $middlename, $lastname, $psgc, $email, $mobile, $address = '')
    {
        $mobile = str_replace("_", "0", str_replace("-", "", $mobile));
        $spouse_id = "";

        $table = 'tblFormCCODLtrsApplicant';
        $result = $this->db->query("SELECT id FROM tblFormCCODLtrsApplicant where 
            NameFirst    = '$firstname' AND 
            NameMiddle   = '$middlename' AND
            NameLast     = '$lastname'   AND
            Barangay = '$psgc'   AND
            Email        = '$email'      AND
            MobileNo = '$mobile'
            ");
        if ($result->num_rows()) {
            $id = $result->row()->id;
        } else {
            $insert = array(
                'NameFirst' => ucfirst($firstname),
                'NameMiddle' => ucfirst($middlename),
                'NameLast' => ucfirst($lastname),
                'Region' => $this->get_psgc_by_brgy($psgc, 'regCode'),
                'Province' => $this->get_psgc_by_brgy($psgc, 'provCode'),
                'City' => $this->get_psgc_by_brgy($psgc, 'citymunCode'),
                'Barangay' => $this->get_psgc_by_brgy($psgc, 'brgyCode'),
                //'BarangayCode'   =>  $psgc,
                'Email' => $email,
                'MobileNo' => $mobile,
                'Address' => ucfirst($address),
            );
            $this->db->insert($table, $insert);
            $id = $this->db->insert_id();
        }
        // $this->logs->user_log($_SESSION['username'],'ADD',$table ,$id);
        //return $id;
    }

    public function save_customer_info_job($firstname, $middlename, $lastname, $psgc, $email, $mobile, $address = '')
    {
        $spouse_id = "";

        $table = 'tblcustomerinq';
        $result = $this->db->query("SELECT id FROM tblcustomerinq where 
            FirstName    = '$firstname' AND 
            MiddleName   = '$middlename' AND
            LastName     = '$lastname'   AND
            BarangayCode = '$psgc'   AND
            Email        = '$email'      AND
            MobileNumber = '$mobile'
            ");
        if ($result->num_rows()) {
            $id = $result->row()->id;
        } else {
            $insert = array(
                'FirstName' => ucfirst($firstname),
                'MiddleName' => ucfirst($middlename),
                'LastName' => ucfirst($lastname),
                'RegionCode' => $this->get_psgc_by_brgy($psgc, 'regCode'),
                'ProvinceCode' => $this->get_psgc_by_brgy($psgc, 'provCode'),
                'CityCode' => $this->get_psgc_by_brgy($psgc, 'citymunCode'),
                'BarangayCode' => $this->get_psgc_by_brgy($psgc, 'brgyCode'),
                //'BarangayCode'   =>  $psgc,
                'Email' => $email,
                'MobileNumber' => $mobile,
                'Address' => ucfirst($address),
                'Address' => ucfirst($address),
                'SpouseId' => $spouse_id
            );
            $this->db->insert($table, $insert);
            $id = $this->db->insert_id();
        }
        // $this->logs->user_log($_SESSION['username'],'ADD',$table ,$id);
        return $id;
    }

    public function save_customer_ref($fullname, $relationship, $mobile, $address)
    {

        $table = 'tblcustomerref';
        $result = $this->db->query("SELECT id FROM tblcustomerref where 
            FullName    = '$fullname' AND 
            Address      = '$address' AND
            Relationship = '$relationship' AND
            MobileNumber = '$mobile'
            ");
        if ($result->num_rows()) {
            $id = $result->row()->id;
        } else {
            $insert = array(
                'FullName' => ucfirst($fullname),
                'Relationship' => $relationship,
                'MobileNumber' => $mobile,
                'Address' => $address,
            );
            $this->db->insert($table, $insert);
            $id = $this->db->insert_id();
        }
        // $this->logs->user_log($_SESSION['username'],'ADD',$table ,$id);
        return $id;
    }

    public function save_customer_ref_update($fullname, $relationship, $mobile, $address, $rses)
    {

        $table = 'tblcustomerref';
        $result = $this->db->query("SELECT id FROM tblcustomerref where 
            FullName    = '$fullname' AND 
            Address      = '$address' AND
            Relationship = '$relationship' AND
            MobileNumber = '$mobile'
            ");
        if ($result->num_rows()) {
            $id = $result->row()->id;
        } else {
            $insert = array(
                'FullName' => ucfirst($fullname),
                'Relationship' => $relationship,
                'MobileNumber' => $mobile,
                'Address' => $address,
            );
            if ($rses == '') {
                $this->db->insert($table, $insert);
                $id = $this->db->insert_id();
            } else {
                $this->db->update($table, $insert, ['id' => $rses]);
                $id = $rses;
            }
        }
        // $this->logs->user_log($_SESSION['username'],'ADD',$table ,$id);
        return $id;
    }
    public function ChatbotLogs($data){

        $sql = "SELECT count(*) as count  FROM tblFormChatBotLogs where ChatBotId = '{$data["ChatBotId"]}' AND `System` = '{$data['System']}'";

        $check_logs = $this->db->query($sql)->row()->count;

        if(empty($check_logs)){
          return  $this->db->insert('tblFormChatBotLogs', $data);
        }
        return 0;
    }
}
