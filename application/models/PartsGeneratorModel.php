<?php defined('BASEPATH') or exit('No direct script access allowed');

class PartsGeneratorModel extends CI_Model
{
    protected $ExternalRate = 'tblExternalRate'; //'tblExternalRate';
    protected $externalpartgenerator = 'tblExternalPartGenerator'; //tblExternalPartGenerator;
    protected $externalpartgeneratorprice = 'tblExternalPartGeneratorPrice'; // tblExternalPartGeneratorPrice
    public function __construct()
    {
        $this->max_concat = $this->db->query("SET SESSION group_concat_max_len = 18446744073709551615;");
        parent::__construct();
    }

    public function getMCList(){
        $sql = "SELECT MCModel FROM {$this->externalpartgenerator} group by MCModel";

        return $this->db->query($sql)->result_array();
    }
    public function getListPerData($kpr,$mc){
        $sql = "SELECT 
                    *
                FROM
                    (SELECT * FROM {$this->externalpartgenerator} WHERE MCModel = '{$mc}'  ) as a
                LEFT JOIN 
	                (SELECT PartNumber,Price FROM {$this->externalpartgeneratorprice})  b on a.PartNumber = b.PartNumber
                WHERE
                    a.MileageFrom <= {$kpr}
                 AND a.MileageTo >=  {$kpr}";
        $resul =  $this->db->query($sql);
        return $resul == null ? [] : $resul->result_array();
    }

    public function getJobRate($kpr,$category){
        $KM = '';
       if($kpr >= 500 || $kpr <= 6000 ) {
            $KM = 'KM1';
       }
       else if($kpr >= 6001 || $kpr <= 12000){
            $KM = 'KM2';
       }
       else if($kpr >= 12001 || $kpr <= 18000){
            $KM = 'KM3';
        }
        else if($kpr >= 18001 || $kpr <= 24000){
            $KM = 'KM4';
        }
        else if($kpr >= 24001 || $kpr <= 30000){
            $KM = 'KM5';
        }
        else if($kpr >= 30001 || $kpr <= 36000){
            $KM = 'KM6';
        }
        
        if($KM == ''){
            return [];
        }else{
            $sql = "SELECT 
                    JobTitle,
                    {$KM} as Price
                FROM
                    (SELECT * FROM {$this->ExternalRate} WHERE CategoryId = {$category} ) as a
                Where 
                    {$KM} != 0;";
     
            return $this->db->query($sql)->result_array();
        }
    }

public function getByCategory($mc){

    $sql = "SELECT CategoryId FROM {$this->externalpartgenerator} WHERE MCModel = '{$mc}'";

    // var_dump($sql);die;
    return $this->db->query($sql)->result_array()[0]['CategoryId'];
}

}
