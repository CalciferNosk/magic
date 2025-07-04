<?php defined('BASEPATH') or exit('No direct script access allowed');

class LtrsModel extends CI_Model
{

    public function __construct()
    {
        $this->max_concat = $this->db->query("SET SESSION group_concat_max_len = 18446744073709551615;");
        parent::__construct();
    }

    public function getReference($grgid)
    {
        $grgid = implode(',', $grgid);
        return $this->db->query("
        SELECT
            grid AS id,
            UPPER(referencename) AS displayValue,
            grgid AS group_id
        FROM
            tbl_globalreference
        WHERE
            deletedflag = 0
            AND grgid IN ({$grgid})
      ");
    }

    public function is_customer_exist($firstName, $lastName, $mobileNumber)
    {
        return $this->db->query("
            SELECT
                id AS customer_id
            FROM
                tblcustomerinq
            WHERE
                UPPER(TRIM(FirstName)) = UPPER(TRIM('{$firstName}'))
                AND UPPER(TRIM(LastName)) = UPPER(TRIM('{$lastName}'))
                AND UPPER(TRIM(MobileNumber)) = UPPER(TRIM('{$mobileNumber}'))
            ORDER BY
                id DESC
            LIMIT 1
        ");
    }

    public function insert_customer($data = array())
    {
        $this->db->insert('tblcustomerinq', $data);

        return $this->db->insert_id();
    }

    public function insert_ltrs_applicant($data = array())
    {
        $this->db->insert('tblFormCCODLtrsApplicant', $data);
        return $this->db->insert_id();
    }

    public function insert_status_log ($formRecordId)
    {
        $data = array(
            "FormId"          => 82,
            "FormRecordId"    => $formRecordId,
            "StatusId"        => 771,
            "createby"        => "EXTERNAL",
            "createDT"        =>  date("Y-m-d H:i:s")
          );
      
          $this->db->insert('tblLogsStatus', $data);
    }

    public function get_psgc_view($termSearch = "", $psgc_code = "")
    {
        # Init
        $psgc_code = trim($psgc_code);
        $w = "";

        # Searching thru psgc
        if (!empty($termSearch) && empty($psgc_code)) :
            $keyword = explode(',', $termSearch);
            switch (count($keyword)):
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
						(TRIM(LOWER(regDesc))  	  LIKE '%" . trim($keyword[0]) . "%') AND 
						(TRIM(LOWER(provDesc))    LIKE '%" . trim($keyword[1]) . "%') AND 
						(TRIM(LOWER(citymunDesc)) LIKE '%" . trim($keyword[2]) . "%') AND 
						(TRIM(LOWER(brgyDesc)) 	  LIKE '%" . trim($keyword[3]) . "%')
					)";
                    break;
            endswitch;
        endif;

        # get psgc
        $w = !empty($psgc_code) && empty($termSearch) ?
            " AND ( TRIM(brgyCode) = '{$psgc_code}'
				OR TRIM(citymunCode) = '{$psgc_code}'
				OR TRIM(provCode) = '{$psgc_code}'
				OR TRIM(regCode) = '{$psgc_code}') "
            : $w;

        $this->max_concat;
        $q = $this->db->query("
			SELECT	
				*
			FROM
				vw_psgc_
			WHERE
				1 = 1
				{$w}
		");

        # put here your var_dump/print_r before return
        # to debug

        return $q;
    }
}
