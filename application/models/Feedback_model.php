<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Feedback_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        $table = 'tblattachments';
        $formrecordid = '594';
        $label = 'Government ID';
        $this->db->cache_off();
        $this->db->select('id');
        $this->db->from($table);
        $this->db->where('FormRecordId', $formrecordid);
        $this->db->where('Label', $label);
        //echo $this->db->get()->row();
        $num_results = $this->db->count_all_results();
        $this->db->select('id');
        $this->db->from($table);
        $this->db->where('FormRecordId', $formrecordid);
        $this->db->where('Label', $label);

        $id = $this->db->get()->row()->id;
        $this->db->cache_on();
        echo $num_results;
        echo $id;
    }

    public function get_survey_categories() // added by Arwin 22/07/2021
    {
        $query = "SELECT * FROM tbl_globalreference WHERE grgid = 85 AND deletedflag = 0";

        $result = $this->db->query($query);
        return $result->result_object();
    }

    public function get_branches()
    {
        $ems = $this
            ->load
            ->database('default', true);

        $query = "SELECT BranchCode AS code, BranchName AS description, BranchAddress AS address FROM tbl_tmp_branch_hierarchy ORDER by BranchCode";

        $result = $ems->query($query);
        return $result->result_object();
    }

    public function getBranchData($id)
    {
        $ems = $this
            ->load
            ->database('default', true);

        $query = "SELECT BranchCode AS code, BranchName AS description, BranchAddress AS address FROM tbl_tmp_branch_hierarchy WHERE BranchCode = '{$id}'";

        $result = $ems->query($query);
        return $result->result_object();
    }

    public function feedbackSubmit($post)
    {
        $table = 'tblformsurvey';
        $customerid = base64_decode($post['customerid']);

        $data = [
            'rating'        => $post['rate'],
            'remarks'       => $post['reviewComments'],
            'datereplied'   => date("Y-m-d H:i:s")
        ];

        $this->db->where('id', $post['pid']);
        $this->db->update($table, $data);
        redirect('https://motortrade.com.ph/');
    }

    public function feedbackManSubmit($post)
    {
        $table = 'tblformsurvey';
        if ($post['service'] == 'ORCR / Plate') {
            $branch = $post['enginenumber'];

            #Update Survey in tblcustomer
            
            $orcr_db = $this->load->database('orcr', true);
             $sql = "update tbl_customer set survey_conf = 1 Where engine_no = '{$post['enginenumber']}'";
            $result = $orcr_db->query($sql);
           
        } else {
            $branch = '';
        }

        $data = [
            'mobileno'      => $post['mobileno'],
            'rating'        => $post['rate'],
            'remarks'       => $post['reviewComments'],
            'service'       => $post['service'],
            'Branch'        => $post['branch'],
            'EngineNo'      => $branch,
            'datereplied'   => date("Y-m-d H:i:s")
        ];

        $this->db->insert($table, $data);
        redirect('https://motortrade.com.ph/');
    }

    public function getData($id, $dataNeed)
    {
        $this
            ->db
            ->cache_off();
        $this
            ->db
            ->select('*');
        $this
            ->db
            ->from('tblformsurvey');
        $this
            ->db
            ->where('id', $id);
        $this
            ->db
            ->where('customerid IS NOT NULL', null, false);
        $query = $this
            ->db
            ->get();
        $ret = $query->row();
        $this
            ->db
            ->cache_on();
        if ($dataNeed == 'mobileno' && json_encode($ret) != 'null' && $id != NULL) {
            return $ret->mobileno;
        }
        if ($dataNeed == 'service' && json_encode($ret) != 'null' && $id != NULL) {
            return $ret->service;
        }
        if ($dataNeed == 'branch' && json_encode($ret) != 'null' && $id != NULL) {
            return $ret->branch;
        }
    }

    public function validate($id, $mobileno, $service)
    {
        $this
            ->db
            ->cache_off();
        $this
            ->db
            ->select('*');
        $this
            ->db
            ->from('tblformsurvey');
        $this
            ->db
            ->where('id', $id);
        $this
            ->db
            ->where('mobileno', $mobileno);
        $this
            ->db
            ->where('service', $service);
        $this
            ->db
            ->where('customerid IS NOT NULL', null, false);
        $this
            ->db
            ->where('datereplied IS NOT NULL', null, false);
        $query = $this
            ->db
            ->get();
        $ret = $query->row();
        $this
            ->db
            ->cache_on();
        return json_encode($ret);
    }
}
