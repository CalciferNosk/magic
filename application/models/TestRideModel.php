<?php
class TestRideModel extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->db->cache_off();
  }

  public function getTestRideSchedule($schedule_id_hashed)
  {
    $date = date("Y-m-d");
    return $this->db->query("
      SELECT 
          a.id,
          a.BranchCode,
          a.ModelId,
          a.StartDate,
          a.EndDate,
          a.Slot,
          b.Total_Count
      FROM
          tblFormTRSchedule a
      LEFT JOIN
        (
          SELECT 
            ScheduleId, COUNT(1) as Total_Count
          FROM
            tblFormTRRegistrant
          GROUP BY
            ScheduleId
          ) b ON a.id = b.ScheduleId
      WHERE
        a.id = {$schedule_id_hashed}
        AND a.CurrentStatusId = 849
        AND a.EndDate >= '{$date}'
        AND (
          b.Total_Count IS NULL
          OR a.Slot > b.Total_Count
        )
    ");
  }

  public function getAvailableBranch($branch_ids)
  {
    $sql = $this->db->query("
      SELECT 
          BranchCode AS id,
          CONCAT(BranchCode, ' ', BranchName,' (', BranchAddress, ')') AS displayName
      FROM
          tbl_tmp_branch_hierarchy
      WHERE
        BranchCode IN({$branch_ids})
        AND IsActive = 1
      ORDER BY 
        BranchCode ASC
    ");

    return $sql->result_array();
  }

  public function getModelCodes($model_ids = null)
  {
    $str = $model_ids ? "AND a.id IN ($model_ids)" : "";
    $sql = $this->db->query("
      SELECT 
        a.id as ModelId,
        a.BrandId as BrandId,
        CONCAT(b.Brand, ' - ', a.Model) AS displayName
      FROM
        tblmodel a
      LEFT JOIN
        tblbrand b ON a.BrandId = b.id
      WHERE
        a.deletedflag = 0
        {$str}
      ORDER BY
        b.Brand, a.Model;
    ");

    return $sql->result_array();
  }

  public function insertCustomerInfo($cus_info)
  {
    $this->db->insert("tblcustomerinq", $cus_info);
    return $this->db->insert_id();
  }

  public function insertTestRide($data)
  {
    $table  = "tblFormTRRegistrant";
    $this->db->insert($table, $data);
    return $this->db->insert_id();
  }

  public function insert_status_log($formRecordId)
  {
    $data = [
      "FormId"          => 89,
      "FormRecordId"    => $formRecordId,
      "StatusId"        => 852,
      "createby"        => "EXTERNAL",
      "createDT"        =>  date("Y-m-d H:i:s")
    ];

    $this->db->insert('tblLogsStatus', $data);
  }
}
