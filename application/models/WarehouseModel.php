<?php defined('BASEPATH') or exit('No direct script access allowed');

class WarehouseModel extends CI_Model
{
    protected $tblExternalWarehouseList = 'tblExternalWarehouseList';
    protected $tblExternalWarehouseFile = 'tblExternalWarehouseFile';
    protected $tblExternalWarehouseBrandList = 'tblExternalWarehouseBrandList';
    protected $tblFormWarehouseInventory = 'tblFormWarehouseInventory';
    protected $tblFormWarehouseOrderDetails = 'tblFormWarehouseOrderDetails';
    protected $tblExternalWarehouseDataControl = 'tblExternalWarehouseDataControl';
    protected $tblFormWarehouseInventoryLogs = 'tblFormWarehouseInventoryLogs';
    public function __construct()
    {
        // $this->max_concat = $this->db->query("SET SESSION group_concat_max_len = 18446744073709551615;");
        parent::__construct();
    }

    public function uploadEngine($data, $file_id)
    {
        foreach ($data as $key => $value) {
            $data[$key][7] = $file_id;
            $data[$key][8] = $_SESSION['warehouse_username'];
            $data[$key][9] = $_SESSION['warehouse_username'];
        }
        $newKeys = ['DRNumber', 'MaterialCode', 'EngineNumber', 'SerialNumber', 'ChasisNumber', 'WwcBat', 'RowNumber', 'FileID', 'CreatedBy', 'UpdatedBy'];

        foreach ($data as &$innerArray) {
            $innerArray = array_combine($newKeys, array_values($innerArray));
        }
        $batch = $this->db->insert_batch($this->tblExternalWarehouseList, $data);
        return $batch;
    }

    public function checkEngineNumber($engineNumber)
    {
        $this->db->cache_off();
        $check_sql = "SELECT count(*) as count FROM {$this->tblExternalWarehouseList} WHERE Deletedflag = 0 AND EngineNumber = '$engineNumber'";
        return $this->db->query($check_sql)->row()->count;
    }
    public function getAllFiles()
    {
        $this->db->cache_off();
        $sql = "SELECT * FROM {$this->tblExternalWarehouseFile} WHERE Deletedflag = 0";
        $result =  $this->db->query($sql);
        return  $result->result_object(); # $result->num_rows() > 0 ? $result->result_object() : [];
    }

    public function insertFile($fileName, $post)
    {

        $this->db->cache_off();
        // var_dump($post);die;
        $data = [
            'FileName'          => $fileName . 'csv',
            'DisplayName'       => $post['file_name'],
            'WarehouseCode'     => $post['warehouse_name'],
            'Supplier'          => $post['file_name'],
            'CreatedBy'         => $_SESSION['warehouse_username'],
            'CreatedFullname'   => $_SESSION['warehouse_fullname'],
            'UpdatedBy'         => $_SESSION['warehouse_username'],
        ];

        $this->db->insert($this->tblExternalWarehouseFile, $data);



        return $this->db->insert_id();
    }
    public function getFileId($created_by)
    {
        $this->db->cache_off();
       
        $sql = "SELECT * FROM {$this->tblExternalWarehouseFile} WHERE deletedflag = 0 AND CreatedBy = '$created_by'";
        $result =  $this->db->query($sql);
        return  $result->row()->id; # $result->num_rows() > 0 ? $result->result_object() : [];
    }
    public function getFilterData($file_id,$dr_number)
    {

        #filter data
        $where = '';
        if (!empty($file_id)) {
            $file_id = array_unique($file_id);
            $ids = implode(',', $file_id);
            $where = "AND FileID IN ({$ids}) ";
        }
        $dr_where = '';
        if(!empty($dr_number)){
            $dr_number_array = explode(',', $dr_number);
            $dr_number_array = array_map('trim', $dr_number_array); // remove any whitespace
            $dr_where = "AND DRNumber IN ('" . implode("', '", $dr_number_array) . "')";
        }
        $this->db->cache_off();
        $sql = "SELECT * FROM {$this->tblExternalWarehouseList} WHERE Deletedflag = 0 AND CurrentStatusId = '2208' {$where}  $dr_where ";
        // var_dump($sql);die;
        $result =  $this->db->query($sql);
        return  $result->result_object(); # $result->num_rows() > 0 ? $result->result_object() : [];
    }

    public function checkEngineNumberData($engine_number)
    {
        $this->db->cache_off();
        $check_sql = "SELECT * FROM {$this->tblExternalWarehouseList} WHERE Deletedflag = 0 AND EngineNumber = '$engine_number' OR ChasisNumber = '$engine_number'";
        return $this->db->query($check_sql)->row();
    }
    public function getFilerDate($column_name)
    {
        $this->db->cache_off();
        $sql = "SELECT DISTINCT {$column_name} FROM {$this->tblExternalWarehouseBrandList} WHERE Deletedflag = 0";
        $result =  $this->db->query($sql);
        return  $result->result_object();
    }
    public function getallBrandList()
    {

        $this->db->cache_on();
        $sql = "SELECT * FROM {$this->tblExternalWarehouseBrandList} WHERE Deletedflag = 0";
        $result =  $this->db->query($sql);
        return  $result->result_object();
    }
    public function getFilteredBySelected($column, $value)
    {

        $this->db->cache_on();
        $sql = "SELECT * FROM {$this->tblExternalWarehouseBrandList} WHERE Deletedflag = 0 AND {$column} = '{$value}'";
        $result =  $this->db->query($sql);
        return  $result->result_object();
    }
    public function updateWarehouseList($engine)
    {

        $this->db->cache_off();
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE  {$this->tblExternalWarehouseList} SET `CurrentStatusId` = '2209',  `UpdatedDate` = '{$date}', `UpdatedBy` = '{$_SESSION['warehouse_username']}' WHERE (`EngineNumber` = '{$engine}')";
        $result =  $this->db->query($sql);

        if ($result) {
            $data_logs = [
                'CurrentStatusId' => '2209',
                'InventoryId' => 0,
                'OrderDetailsId' => 0,
                'Action' => 'Update Engine Number',
                'Description' => 'Update Engine Number : ' . $engine . ' in inventory table',
                'UpdatedBy' => $_SESSION['warehouse_username'],
                'UpdatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->logOrder($data_logs);
        }
        return $result;
    }
    public function insertInventoryList($engine, $branch_code)
    {
        $data = [
            'EngineNumber'  => $engine,
            'CreatedDate'   => date('Y-m-d H:i:s'),
            'BranchCode'    =>  $branch_code,
            'CreatedBy'     => $_SESSION['warehouse_username'],
        ];

        $result = $this->db->insert($this->tblFormWarehouseInventory, $data);
        return $result;
    }
    public function checkBranch($branch_code)
    {
        $this->db->cache_off();
        $sql = "SELECT * FROM tbl_tmp_branch_hierarchy WHERE BranchCode = '{$branch_code}'";
        $result =  $this->db->query($sql);
        return  $result->num_rows() > 0 ? $result->row() : [];
    }
    public function materialCheck($material_code)
    {
        $this->db->cache_off();
        $sql = "SELECT * FROM {$this->tblExternalWarehouseList} WHERE MaterialCode = '{$material_code}' AND CurrentStatusId = '2208'";
        $result =  $this->db->query($sql);
        return  $result->num_rows() > 0 ? $result->result_object() : [];
    }

    public function addPickList($data)
    {

        // $result = $this->db->insert_batch($this->tblFormWarehouseOrderDetails, $data);
        // if($result){
        $store = 0;
        foreach ($data as $key => $value) {
            $result = $this->db->insert($this->tblFormWarehouseOrderDetails, $value);
            $last_id = $this->db->insert_id();
            $store += $result;
            $data_logs = [
                'CurrentStatusId' => 2208,
                'InventoryId' => $value['InventoryId'],
                'OrderId' => $value['OrderId'],
                'OrderDetailsId' =>  $last_id,
                'Action' => 'INSERT NEW ORDER',
                'Description' => "Insert new order : {$this->db->insert_id()} in inventory table",
                'CreatedBy' => $_SESSION['warehouse_username'],
            ];
            $this->logOrder($data_logs);
        }
        // }
        return   $store;
    }
    public function getallReleaseList($SupplyingCode)
    {

        if (empty($SupplyingCode)) {
            return [];
        }
        // $this->db->cache_off();
        $sql = "SELECT 
                        wi.id,
                        wi.Trucking,
                        wi.DriverName,
                        s.status,
                        wi.SupplyingPlant,
                        wi.CreatedDate,
                        wi.BranchCode,
                        wi.OrderId,
                        wi.CurrentStatusId
                        
                FROM    
                    {$this->tblFormWarehouseInventory} wi
                LEFT JOIN 
	                 tblstatus s on wi.CurrentStatusId = s.ID
                WHERE 
                    wi.SupplyingPlant in ($SupplyingCode)
                AND wi.Deletedflag = 0
                group by wi.OrderId ";

        $result =  $this->db->query($sql);
        // echo $this->db->last_query();
        // var_dump('<pre>',$result->result_object());die;
        return  $result->result_object();
    }
    public function checkInventory($material, $branch)
    {

        $this->db->cache_off();
        $sql = "SELECT * FROM {$this->tblFormWarehouseOrderDetails} WHERE deletedflag = 0 AND MaterialCode = '{$material}' AND BranchCode = '{$branch}'";
        $result =  $this->db->query($sql);
        // return $this->db->last_query();
        return  $result->num_rows() > 0 ? $result->result_object() : [];
    }
    public function storeOrder($order_data)
    {

        $result  =   $this->db->insert($this->tblFormWarehouseInventory, $order_data);
        if ($result) {
            $data_logs = [
                'CurrentStatusId' => '2208',
                'InventoryId' => $this->db->insert_id(),
                'OrderDetailsId' => 0,
                'Action' => 'INSERT INVENTORY',
                'Description' => "Insert inventory : {$this->db->insert_id()} in inventory table",
                // 'UpdatedBy' => $_SESSION['warehouse_username'],
                // 'UpdatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->logOrder($data_logs);
        }
        return $this->db->insert_id();
    }

    public function getInventory($genid, $branch, $statusid)
    {

        $this->db->cache_off();

        $sql = "SELECT 
                    a.* ,
                    b.brand_name as SupplierName,
                    b.main_model as ModelCode,
                    c.DriverName,
                    c.Trucking,
                    c.SupplyingPlant,
                    c.Company
              FROM
                    {$this->tblFormWarehouseOrderDetails} a
                LEFT JOIN 
	                {$this->tblExternalWarehouseBrandList} b on b.material_number = a.MaterialCode
             LEFT JOIN
                    {$this->tblFormWarehouseInventory}  c on c.OrderId = a.OrderId
              WHERE 
                  a.OrderId = '{$genid}' 
                AND a.BranchCode = '{$branch}'
                AND a.Deletedflag = 0";
        $result = $this->db->query($sql);
        return $result->result_object();
    }
    public function updateOrderWithEngine($engine, $id, $genid)
    {

        $this->db->cache_off();
        $sql = "    UPDATE {$this->tblFormWarehouseOrderDetails} SET `EngineNumber` = '{$engine}' WHERE  `id` = '{$id}' AND OrderId = '{$genid}' AND OrderStatus = 0";
        $result = $this->db->query($sql);
        if ($result) {
            $data_logs = [
                'CurrentStatusId' => '2209',
                'OrderId' => $genid,
                'OrderDetailsId' => $id,
                'Action' => 'UPDATE Engine Number',
                'Description' => "Update Order engine : NULL to {$engine} in order table",
                'UpdatedBy' => $_SESSION['warehouse_username'],
                'UpdatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->logOrder($data_logs);
        }
       
        return $result;
    }
    public function updateListStatus($genid)
    {

        $this->db->cache_off();
        $sql = "    UPDATE {$this->tblFormWarehouseInventory} SET `CurrentStatusId` = '2209' WHERE `OrderId` = '{$genid}'";
        $result = $this->db->query($sql);

        if ($result) {
            $data_logs = [
                'CurrentStatusId' => '2209',
                'OrderId' => $genid,
                'OrderDetailsId' => 0,
                'Action' => 'UPDATE STATUS',
                'Description' => "Update status to 2209 in inventory table",
                'UpdatedBy' => $_SESSION['warehouse_username'],
                'UpdatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->logOrder($data_logs);
        }

        return $result;
    }


    public function checkOrdeEngine($genid){

        $this->db->cache_off();
        $count_null = "SELECT count(1) as count FROM {$this->tblFormWarehouseOrderDetails} WHERE OrderId = '{$genid}' AND EngineNumber is null AND deletedflag = 0 ;";
        $result = $this->db->query($count_null);
        return $result->row()->count;
    }

    public function changeStatus($genid, $status)
    {
        $this->db->cache_off();
        $this->db->query("UPDATE {$this->tblFormWarehouseOrderDetails} SET `OrderStatus` = '0' WHERE OrderId = '{$genid}'");
        $result = $this->db->query("UPDATE {$this->tblFormWarehouseInventory} SET `CurrentStatusId` = '{$status}' WHERE OrderId = '{$genid}'");
        if ($result) {
            $data_logs = [
                'CurrentStatusId' => $status,
                'OrderId' => $genid,
                'OrderDetailsId' => 0,
                'Action' => 'UPDATE STATUS',
                'Description' => "Update status to {$status} in inventory table",
                'UpdatedBy' => $_SESSION['warehouse_username'],
                'UpdatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->logOrder($data_logs);
        }
        return $result;
    }
    public function getCheckOrder($order_id)
    {
        $this->db->cache_off();
        $sql = "SELECT BranchCode,DriverName,Company,Trucking,SupplyingPlant,CreatedBy,CreatedDate FROM {$this->tblFormWarehouseInventory} WHERE OrderId = '{$order_id}' AND Deletedflag = 0";;
        $result =  $this->db->query($sql);


        return  $result->result_object();
    }
    public function getCheckOrderModels($genid)
    {

        $this->db->cache_off();

        $sql = "SELECT count(MaterialCode) as qty , MaterialCode FROM {$this->tblFormWarehouseOrderDetails} WHERE Deletedflag = 0 AND OrderId = '{$genid}' group by MaterialCode";
        return $this->db->query($sql)->result_object();
    }
    public function getDataControl($EmployeeCode, $System)
    {

        $this->db->cache_off();
        $sql = "SELECT * FROM {$this->tblExternalWarehouseDataControl} WHERE EmployeeCode = '{$EmployeeCode}' AND `System` = '{$System}' AND Deletedflag = 0";
        $result =  $this->db->query($sql);
        return  $result->row();
    }

    public function removeEngine($order_list_id,$genid)
    {

        $this->db->cache_off();

        $remove_engine = "UPDATE {$this->tblFormWarehouseOrderDetails} SET `EngineNumber` = NULL, `UpdatedBy` = '{$_SESSION['warehouse_username']}' WHERE (`id` = '{$order_list_id}')";
        $res = $this->db->query($remove_engine);

        if ($res) {
            $data_logs = [
                'CurrentStatusId' => 0,
                'OrderId' => $genid,
                'OrderDetailsId' => $order_list_id,
                'Action' => 'REMOVE ENGINE',
                'Description' => "Remove Engine Number: {$order_list_id} in order table",
                'Createdby' => $_SESSION['warehouse_username'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->logOrder($data_logs);
        }
        return $res;
    }

    public function deleteOrderList($order_list_id, $genid)
    {

        $this->db->cache_off();

        $update_delete_sql = "UPDATE {$this->tblFormWarehouseOrderDetails} SET `EngineNumber` = 'Removed from Order List', `Deletedflag` = '1', `UpdatedBy` = '{$_SESSION['warehouse_username']}' WHERE (`id` = '{$order_list_id}')";
        $res = $this->db->query($update_delete_sql);

        // var_dump($update_delete_sql);die;
        if ($res) {
            $data_logs = [
                'CurrentStatusId' => 0,
                'OrderId' => $genid,
                'OrderDetailsId' => $order_list_id,
                'Action' => 'REMOVE ORDER',
                'Description' => "Remove ORDER: {$order_list_id} in order table",
                'CreatedBy' => $_SESSION['warehouse_username'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->logOrder($data_logs);
        }
        return $res;
    }

    public function UpdateOrderStatus($inventory_id, $genid)
    {

        $this->db->cache_off();

        $revert_status = "UPDATE {$this->tblFormWarehouseInventory} SET `CurrentStatusId` = '2208' WHERE `OrderId` = '{$genid}' AND id = '{$inventory_id}'";
        $res = $this->db->query($revert_status);
        if ($res) {
            $data_logs = [
                'CurrentStatusId' => 0,
                'InventoryId' => $inventory_id,
                'OrderId' => $genid,
                'OrderDetailsId' => 0,
                'Action' => 'REVERT STATUS',
                'Description' => "revert status: {$inventory_id} in inventory table",
                'CreatedBy' => $_SESSION['warehouse_username'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->logOrder($data_logs);
        }
        return $res;
    }
    public function getLogs($genid)
    {

        $this->db->cache_off();

        $sql = "SELECT 
                    log.*,
                    ord.id as order_id,
                    ord.*
                FROM
                    {$this->tblFormWarehouseInventoryLogs} log
                LEFT JOIN
                    (SELECT 
                        id, OrderId, MaterialCode
                    FROM
                        {$this->tblFormWarehouseOrderDetails}
                        ) ord ON ord.id = log.OrderDetailsId
                WHERE
                    ord.OrderId = '{$genid}' AND
                    log.Action IN ('REMOVE ORDER' , 'INSERT NEW ORDER','REMOVE ENGINE')";

            $result =  $this->db->query($sql);
        return  $result->result_object();
    }

    private function logOrder($data)
    {

        $this->db->insert($this->tblFormWarehouseInventoryLogs, $data);
    }
    public function getInventoryId($genid){

        $this->db->cache_off();
        $sql ="SELECT InventoryId,OrderId  FROM {$this->tblFormWarehouseOrderDetails} WHERE OrderId = '{$genid}' LIMIT 1;";
        
        $result =  $this->db->query($sql);
        return  $result->row()->InventoryId;
    }

    public function warehouseUsers()
    {
        $this->db->cache_off();
       $control = "SELECT * FROM  {$this->tblExternalWarehouseDataControl};";
        $fetch = $this->db->query($control);
        return $fetch->result_object();
    }

    public function updateInventoryEngineStatus($genid){

        $this->db->cache_off();
        $select_engine = $this->db->query("SELECT * FROM {$this->tblFormWarehouseOrderDetails} WHERE Deletedflag = 0 AND OrderId ='{$genid}';");

        foreach ($select_engine->result() as $key => $value) {
            $this->db->query("UPDATE {$this->tblExternalWarehouseList} SET `CurrentStatusId` = '2209', `Deletedflag` = '1'  WHERE `EngineNumber` = '{$value->EngineNumber}'");
        }
       
    }
    public function changeAccess($column, $value, $id){

        $this->db->cache_off();
        $data_today = date('Y-m-d H:i:s');
        $update_access = "UPDATE {$this->tblExternalWarehouseDataControl} SET `{$column}` = '{$value}', `UpdatedDate` = '{$data_today}' WHERE (`id` = '{$id}');";
        // var_dump($update_access);die;
        $res = $this->db->query($update_access);
        return $res;
    }
    public function changeSupplyingAccess($supplying, $controlid){
        $data_today = date('Y-m-d H:i:s');
        $update_supplying = "UPDATE {$this->tblExternalWarehouseDataControl} SET `SupplyingCode` = '{$supplying}', `UpdatedDate` = '{$data_today}' WHERE (`id` = '{$controlid}');";
        $res = $this->db->query($update_supplying);

        return $res;

    }

    public function changeTabAccess($tab , $controlid){
        $data_today = date('Y-m-d H:i:s');
        $update_tab = "UPDATE {$this->tblExternalWarehouseDataControl} SET `TabView` = '{$tab}', `UpdatedDate` = '{$data_today}' WHERE (`id` = '{$controlid}');";
        $res = $this->db->query($update_tab);

        return $res;
    }
}
