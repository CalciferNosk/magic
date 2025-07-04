<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_service_appointment extends CI_Model
{

  public function __construct()
  {

    parent::__construct();
    
  }

  public function get_categories() # GET CATEGORIES
  {
    $q = $this->db->query("
      SELECT
        id,
        categoryname AS displayName
      FROM
        tblcategory
      WHERE
        formid = '37' AND id NOT IN(1452,1453,1454,1455)
      ORDER BY
        categoryname ASC
        -- CAST(sequence AS DECIMAL) ASC
    ");

    //var_dump

    if (isset($q)) {
      return json_encode($q->result_object());
    }

    return array();
  }

  # Revised by Russ: 6-3-21 MC Brand & Model Has their own table
  public function get_mcBrand_() # GET MC BRAND
  {
    $q = $this->db->query("
      SELECT
        grid AS id,
        referencename AS displayName
      FROM
        tbl_globalreference
      WHERE
        grgid = 13 AND deletedflag = 0 AND grid != 132
      ORDER BY
        referencename ASC
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }

    return array();
  }

  public function get_mcBrand() # GET MC BRAND
  {
    $q = $this->db->query("
      SELECT
        id,
        Brand AS displayName
      FROM
        tblbrand
      WHERE
        deletedflag = 0
      ORDER BY
        Brand ASC
    ");

    // var_dump($q);
    // die();

    return $q !== FALSE ? json_encode($q->result_object()) : array();
  }

  public function get_branches() # GET BRANCHES
  {
    $global2 = $this->load->database('global2', TRUE);
    $q = $global2->query("
      SELECT
        a.b_code AS id,
        CONCAT(a.b_code, '-', a.name) AS displayName,
        LPAD(a.region, 2, 0) AS isFilter
      FROM
        tbl_branches a
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }

    return array();
  }

  # Revised by Russ: 6-3-21 MC Brand & Model Has their own table
  public function get_mc_models_() # GET MODELS
  {
    $q = $this->db->query("
      SELECT
        grid AS id,
        IF (referencedesc is NULL OR referencedesc = '', referencename, CONCAT(referencename, ' (', referencedesc, ')')) AS displayName,
        parentid AS isFilter
      FROM
        tbl_globalreference
      WHERE
        grgid = 14 AND deletedflag = 0 AND grid != 145
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }
  }

  public function get_mc_models() # GET MODELS
  {
    $q = $this->db->query("
      SELECT
        id,
        Model AS displayName,
        BrandId AS isFilter,
        Category
      FROM
        tblmodel
      WHERE
        deletedflag = 0
    ");


    return $q !== FALSE ? json_encode($q->result_object()) : array();
  }

  public function get_mc_colors() # GET MC COLORS
  {
    $q = $this->db->query("
      SELECT
        grid AS id,
        referencename AS displayName
      FROM
        tbl_globalreference
      WHERE
        grgid = 9 AND deletedflag = 0 AND grid != 449
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }
  }

  public function get_regions() # GET REGIONS
  {
    $q = $this->db->query("
      SELECT
        regCode AS id,
        regDesc AS displayName
      FROM
        refregion
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }
    return array();
  }

  public function get_provinces() # GET PROVINCES
  {
    $q = $this->db->query("
      SELECT
        provCode AS id,
        provDesc AS displayName,
        regCode AS isFilter
      FROM
        refprovince
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }
    return array();
  }

  public function get_cities() # GET CITIES CITY
  {
    $q = $this->db->query("
      SELECT
        citymunCode AS id,
        citymunDesc AS displayName,
        provCode AS isFilter
      FROM
        refcitymun
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }
    return array();
  }

  public function get_barangays() # GET BARANGAYS
  {
    $q = $this->db->query("
      SELECT
        brgyCode AS id,
        brgyDesc AS displayName,
        citymunCode AS isFilter
      FROM
        refbrgy
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }
    return array();
  }

  // CHANGE THE RETURN form AFFECTED ROW TO RECORD ID
  public function newServiceAppointment($dataInsert,$cusId) # Insert New Data Service Appointment
  {
    $q = $this->db->insert("tblformserviceappointment", $dataInsert);
    $last_id = $this->db->insert_id($q);
    if (isset($q) && $q) {
      $this->inserStatus($this->db->insert_id());

      if (!is_int(  $last_id)) {
        $update_data = [
          'FormId' => 37,
          'FormRecordId' =>   $last_id
        ];

        $this->logs->storeSMS($this->session->userdata('sms_log'), $update_data);
        $this->session->unset_userdata('sms_log');

        return  $last_id;
      }
      return $last_id;
    }

    $this->db->query("DELETE FROM tblcustomerinq WHERE id = {$cusId}"); # Delete user if not save the service appointment
    return $last_id;
  }

  public function addCustomer($email = "", $mobile = "", $dataArray = "") # ADD CUSTOMER
  {
    $post = $this->input->post();
    $email = (empty($email)) ? $post['email_address'] : $email;
    $mobile = (empty($mobile)) ? _cleanMobileNumber($post['mobile_no']) : _cleanMobileNumber($mobile);
    $fname = ucwords($post['firstname']);
    $mname = ucwords($post['middlename']);
    $lname = ucwords($post['lastname']);

    if (empty($email) && empty($mobile)) :
      return $this->errorMessage("Email and Mobile No. is empty ");
    endif;

    $is_exists = $this->db->query("
      SELECT
          id
      FROM
          tblcustomerinq
      WHERE
          UPPER(TRIM(FirstName)) = UPPER(TRIM('{$fname}'))
          AND UPPER(TRIM(LastName)) = UPPER(TRIM('{$lname}'))
          AND UPPER(TRIM(MobileNumber)) = UPPER(TRIM('{$mobile}'))
      ORDER BY
          id DESC
      LIMIT 1
    ");

    if ($is_exists !== FALSE && $is_exists->num_rows() > 0) :
      return intval($is_exists->row()->id);
    endif;

    $data = array(
      "FirstName"    => ucfirst(trim($fname)),
      "MiddleName"   => ucfirst(trim($mname)),
      "LastName"     => ucfirst(trim($lname)),
      "Email"        => trim($email),
      "MobileNumber" => $mobile
    );

    $q = $this->db->insert('tblcustomerinq', $data);

    if ($this->db->affected_rows() > 0) :
      return $this->db->insert_id();
    endif;

    return "Not Inserted";
  }

  public function inserStatus($rid = null)
  {
    if (empty($rid)):
      return $this->errorMessage("Customer Record can't find. Pls contact the IT-Admin.");
    endif;

    $data = [
      "FormId"          => 37,
      "FormRecordId"    => $rid,
      "StatusId"        => 270,
      "createby"        => "EXTERNAL",
      "createDT"        =>  date("Y-m-d H:i:s")
    ];

    $this->db->insert('tblLogsStatus', $data);

    return $this->db->affected_rows();
  }

  public function get_MncRegions()
  {
    $ems = $this->load->database('ems', TRUE);

    $q = $ems->query("
      SELECT
        b.id AS id,
        b.description AS displayName
      FROM
        region a
          INNER JOIN
        org_group b ON a.code = b.code
      ORDER BY
        b.description ASC
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }

    return array();
  }

  public function get_MncAreas()
  {
    $ems = $this->load->database('ems', TRUE);

    $q = $ems->query("
      SELECT
        (SELECT group_concat(id SEPARATOR '') FROM org_group x WHERE x.org_type = 'CLUS' AND x.parent_org_id = a.id ORDER BY id ASC) AS id,
        a.description AS displayName,
        a.parent_org_id AS isFilter
      FROM
        org_group a
      WHERE
        a.org_type = 'AREA'
      ORDER BY
        description ASC
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }

    return array();
  }

  public function get_MncBranches($has_service_bay = false)
  {
    $service_bay = $has_service_bay === true ? " AND ServiceBayCount > 0" : "";
    $q = $this->db->query("
      SELECT
        BranchCode AS id,
        CONCAT(
          BranchCode, ' ', BranchName,
          ' (', BranchAddress, ')'
        ) AS displayName,
        BranchCode AS isFilter
      FROM
        tbl_tmp_branch_hierarchy
      WHERE
        IsActive = 1
        {$service_bay}
      ORDER BY
          BranchCode ASC
    ");
          // var_dump($q->result_object());die;
    return $q !== FALSE ? json_encode($q->result_object()) : array();
  }

  public function get_MncBranches_() # Replace by Temporary Branches
  {
    $ems = $this->load->database('ems', TRUE);
    $q = $ems->query("
      SELECT
        a.code AS id,
          CONCAT(a.code, ' ', a.description, ' ', IF(a.address = '' OR a.address IS NULL, '', CONCAT('(', LEFT(a.address, 100), ')')) ) AS displayName,
          (
            SELECT group_concat(x.id SEPARATOR '') FROM org_group x WHERE x.org_type = 'CLUS' AND x.parent_org_id = (SELECT ax.parent_org_id FROM org_group ax WHERE ax.id = a.parent_org_id) ORDER BY x.id ASC
          ) AS isFilter
      FROM
        org_group a
      WHERE
        a.org_type = 'BRN' AND a.service_bay_count > 0 AND a.is_branch_active = 1
      ORDER BY
        a.description DESC
    ");

    if (isset($q)) {
      return json_encode($q->result_object());
    }

    return array();
  }

  public function errorMessage($message = "") # Error Message
  {
    $message = (empty($message)) ? "Error Occured!" : $message;
    die($message);
  }

  public function checkBookDatetime($date = "", $bcode = "")
  {
    if (empty($date)) {
      return false;
    }

    # Appointment is not available. Please choose another date/time.
    $q = $this->db->query("
      SELECT
        a.ConfirmedDateTime
      FROM
        tblformserviceappointment a
          LEFT JOIN
        tblLogsStatus b ON a.id = b.FormRecordId
      WHERE
        a.ConfirmedDateTime BETWEEN '{$date}:00' AND '{$date}:59' AND a.BranchCode = '{$bcode}' AND b.Formid = '37' AND b.StatusId = 272
    ");

    if (isset($q)) {
      return $q;
    }

    return false;
  }
}
# End of Class