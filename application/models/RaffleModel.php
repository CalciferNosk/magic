<?php defined('BASEPATH') or exit('No direct script access allowed');

class RaffleModel extends CI_Model
{

    public function __construct()
    {
        // $this->max_concat = $this->db->query("SET SESSION group_concat_max_len = 18446744073709551615;");
        parent::__construct();
    }

    public function getRaffleCount()
    {
        $external = $this->load->database('ems', TRUE);
        $q = $external->query("SELECT
                                    count(*) as `count` 
                                FROM 
                                     ems_plantilla.raffle 
                                WHERE 
                                    prizeids is not null");
        return $q->row();
    }
    public function runDraw()
    {
        //    die('naok');
        $external = $this->load->database('ems', TRUE);
        $q =     $external->query("CALL ems_plantilla.randomizerbeta()");

        return $q;
    }
    public function getRaffleResult()
    {
        $external = $this->load->database('ems', TRUE);
        $q = $external->query("SELECT 
                                    a.code,
                                    a.name,
                                    a.employmentstatus,
                                    a.datehired,
                                    b.prizename,
                                    b.prizetype,
                                    CONCAT(c.code, ' - ', c.description) `orggroup`
                                FROM
                                    (SELECT 
                                        *
                                    FROM
                                    ems_plantilla.raffle
                                    WHERE
                                        prizeids IS NOT NULL) a
                                        LEFT JOIN
                                    (SELECT 
                                        *
                                    FROM
                                    ems_plantilla.raffleprize) b ON a.prizeids = b.id
                                        LEFT JOIN
                                    (SELECT 
                                        *
                                    FROM
                                    ems_plantilla.org_group) c ON a.org_id = c.id
                                ORDER BY b.prizename;
                                ");
        return $q->result_array();
    }
    public function getInfo()
    {
        $external = $this->load->database('ems', TRUE);
        $q = $external->query("SELECT 
        (SELECT 
                COUNT(*)
            FROM
                ems_plantilla.raffle) employee,
        (SELECT 
                SUM(prizecount)
            FROM
                ems_plantilla.raffleprize) prize,
        (SELECT 
                DATE_FORMAT(createddate, '%b-%d-%Y %h:%i')
            FROM
                ems_plantilla.raffle
            WHERE
                prizeids IS NOT NULL
            GROUP BY DATE_FORMAT(createddate, '%b-%d-%Y')) date");
        return $q->row();
    }
}
