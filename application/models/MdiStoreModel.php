<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MdiStoreModel extends CI_Model
{
    private $mdi_db;
    public function __construct()
    {
        parent::__construct();
        $this->mdi_db = $this->load->database('mdi_db', TRUE);
    }
    public function storeInquiry($data)
    {
        $table = 'tblforminquiry';
        $logtable = 'tblLogsStatus';
        $this->mdi_db->trans_start();
        $this->mdi_db->insert($table, $data);
        $id = $this->mdi_db->insert_id();
        $this->mdi_db->trans_complete();
        if ($this->mdi_db->trans_status() === TRUE) {
            $logs = [
                'FormId' => '34',
                'FormRecordId' => $id,
                'StatusId' => '229',
                'createBy'       => 'EXTERNAL',
                'createDT' => date('Y-m-d H:i:s'),
                'EffectiveDT' => date('Y-m-d'),
                'deletedflag' => 0
            ];
            $this->mdi_db->insert($logtable, $logs);

            return $id;
        }
    }

    public function storeService($dataInsert, $cusId)
    {
        $q =  $this->mdi_db->insert("tblformserviceappointment", $dataInsert);

        if (isset($q) && $q) {
            $last_id = $this->mdi_db->insert_id($q);
            $this->inserStatus( $this->mdi_db->insert_id());

            if (!is_int( $this->mdi_db->insert_id())) {
                $update_data = [
                    'FormId' => 37,
                    'FormRecordId' =>  $this->mdi_db->insert_id(),
                ];

                $this->logs->storeSMS($this->session->userdata('sms_log'), $update_data);
                $this->session->unset_userdata('sms_log');

                return  $last_id;
            }

            return $last_id;
        }

         $this->mdi_db->query("DELETE FROM tblcustomerinq WHERE id = {$cusId}"); # Delete user if not save the service appointment
        return true;
    }
    public function inserStatus($rid = null)
    {
        if (empty($rid)) :
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
    public function errorMessage($message = "") # Error Message
    {
        $message = (empty($message)) ? "Error Occured!" : $message;
        die($message);
    }


    public function storeLoan($post)
    {
    }
}
