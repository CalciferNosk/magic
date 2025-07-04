<?php defined('BASEPATH') or exit('No direct script access allowed');

class MagicModel extends CI_Model
{

    public function __construct()
    {
        $this->max_concat = $this->db->query("SET SESSION group_concat_max_len = 18446744073709551615;");
        parent::__construct();
    }


    public function logMagic($log){
        $this->db->insert('tblFormMagicLog', $log);
        return 1;
    }

 
}
