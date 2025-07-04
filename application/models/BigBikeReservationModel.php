<?php defined('BASEPATH') or exit('No direct script access allowed');

class BigBikeReservationModel extends CI_Model
{

    public function __construct()
    {
        $this->max_concat = $this->db->query("SET SESSION group_concat_max_len = 18446744073709551615;");
        parent::__construct();
    }

    public function getBigBikeList() # GET MC Unit
    {
        $q = $this->db->query("
            SELECT 
                b.id as id,
                CONCAT(a.Brand, ' - ',b.Model) as displayName, 
                b.BrandId
            FROM 
                tblbrand a 
            LEFT JOIN 
                tblmodel b on b.BrandId = a.id
            WHERE 
                b.TypeId = 1 and b.deletedflag = 0
        ");

        return $q !== FALSE ? json_encode($q->result_object()) : array();
    }

    public function is_customer_exist($firstName, $lastName, $mobileNumber)
    {
        return $this->db->query("
            SELECT
                id AS customer_id
            FROM
                tblcustomerinq
            WHERE
                TRIM(FirstName) = '{$firstName}'
                AND TRIM(LastName) = '{$lastName}'
                AND TRIM(MobileNumber) = '{$mobileNumber}'
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

    public function storeRegistrant($data = array())
    {
        $this->db->insert('tblFormCcodBigBikeReservation', $data);
        return $this->db->insert_id();
    }

    public function insert_status_log($formRecordId)
    {
        $data = array(
            "FormId"          => 40,
            "FormRecordId"    => $formRecordId,
            "StatusId"        => 279,
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

        return $q;
    }

    public function getColors()
    {
        $result = $this->db->query("
            SELECT * FROM tbl_globalreference_group AS a INNER JOIN tbl_globalreference AS b ON a.grgid = b.grgid WHERE groupname = 'MC Color' ORDER BY referencename
        ");

        return $result && $result->num_rows() > 0 ? $result->result_object() : false;
    }

    public function getBigbikeCategory()
    {
        $result = $this->db->query("
            SELECT
                id,
                categoryname
            FROM
                tblcategory
            WHERE
                formid = 40
                AND deletedflag = 0
        ");

        return $result && $result->num_rows() > 0 ? $result->result_object() : false;
    }
}
