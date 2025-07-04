<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WarehouseController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('recaptcha', 'application\libraries');
        $this->load->model('WarehouseModel', 'warehouse');
        $this->load->model('APICurlModel', 'api_curl');

       
    }

    public function index()
    {
        $data['module'] = 'warehouse';
        $data['login_routes'] = 'warehouse';
        $data['widget'] = $this->recaptcha->getWidget(array('data-expired-callback' => 'recaptchaExpired'));
        $data['script'] = $this->recaptcha->getScriptTag();
        $this->load->view('Templates/LoginView.php', $data);
        # NOTE : Login View is using other module 

    }

    public function authWarehouse()
    {
        $result =   $this->api_curl->emsLoginAPI('warehouse',$_POST['username'], $_POST['password'], 'warehouse-main-view');
        echo json_encode($result);
    }

    public function mainView()
    {
       
    if (!isset($_SESSION['warehouse_username'])) {
            redirect('warehouse');
        }
     
        // var_dump(_getFullNameByCode(912739));die;
        // var_dump($_SESSION);die;
        # control data here
        $data['files'] = $this->warehouse->getAllFiles();
        $data['suppliers'] = $this->warehouse->getFilerDate('brand_name');
        // $data['models'] = $this->warehouse->getFilerDate('main_model,model_code');
        $data['material_codes'] = $this->warehouse->getFilerDate('material_number');
        // $data['brand_list'] = $this->warehouse->getallBrandList();
        $data['release_list'] = [];
        $data['edit']   = 0;
        $data['change_status'] = 0;
        $data['upload'] = 0;
        $data['create'] = 0;
        $data['list_view'] = 0;
        $data['control_user'] = in_array($_SESSION['warehouse_logusername'],['WHAdmin','itadmin']) ? 1 : 0;

        $control = $this->warehouse->getDataControl($_SESSION['warehouse_logusername'],'WAREHOUSE');
        
       if(!empty($control)){
             $data['release_list'] = $this->warehouse->getallReleaseList($control->SupplyingCode);
             $data['edit']   = $control->Edit;
             $data['change_status'] = $control->ChangeStatus;
             $data['upload'] = $control->Upload;
             $data['create'] = $control->Create;
             $data['list_view'] = $control->ListView;
             $data['tab_access'] = explode( ',',$control->TabView);
       }

      
        # end control data
        $this->load->view('Warehouse/WarehouseMainView.php', $data);
    }

    public function filterData()
    {
        // var_dump($_POST);die;
        $file_id = empty($_POST['file_id']) ? [] : [$_POST['file_id']];
        if (!empty($_POST['created_by']) && !empty($_POST['file_id'])) {
            array_push($file_id, $this->warehouse->getFileId($_POST['created_by']));
        }
        $engine_numbers = [];
        $filtered_data = $this->warehouse->getFilterData($file_id,$_POST['dr_number']);

        foreach ($filtered_data as $key => $value) {
            array_push($engine_numbers, $value->EngineNumber);
        }
        $data['engines'] = $engine_numbers;
        $data['filtered_data'] = $filtered_data;
        echo json_encode($data);
    }

    public function checkEngineNumberData()
    {
        $engine_number = $_POST['engine_number'];
        $engine_data = $this->warehouse->checkEngineNumberData($engine_number);

        echo json_encode($engine_data);
    }
    public function getallBrandList()
    {
        $column = $_POST['selected'];
        $value = $_POST['value'];
        $result = $this->warehouse->getFilteredBySelected($column, $value);
        echo json_encode($result);
    }


    public function addPickList()
    {
        // var_dump('<pre>',$_POST);die;
        if (!empty($_POST)) {
            $data = [];
            $order_id = (int)$_POST['branch'][0] . '_' . date('YmdHis');
            $str_number = (string)$_POST['branch'][0];
            $company_code = (int) (substr($str_number, 0, 1) . '000');

            $order_data = [
                'OrderId'           => $order_id,
                'BranchCode'        => $_POST['branch'][0],
                'CurrentStatusId'   => 2208,
                'Company'           => $company_code,
                'DriverName'        =>  $_POST['driver'],
                'Trucking'          => $_POST['trucking'],
                'SupplyingPlant'    => $_POST['supplying'],
                'EmployeeCode'      => $_SESSION['warehouse_username'],
                'CreatedBy'         => $_SESSION['warehouse_username'],
            ];
            $store_order = $this->warehouse->storeOrder($order_data);

            foreach ($_POST['material_code'] as $key => $value) {
                for ($index = 0; $index < $_POST['quantity'][$key]; $index++) {
                    array_push($data, [
                        'OrderId'        => $order_id,
                        'InventoryId'    =>  $store_order,
                        'MaterialCode'   => $value,
                        'BranchCode'     => $_POST['branch'][$key],
                        'CreatedBy'          => $_SESSION['warehouse_username'],
                    ]);
                }
            }
          
            $result =  $this->warehouse->addPickList($data);
            // var_dump('<pre>',$data);die;

         
            echo json_encode($result);
        } else {
            echo json_encode(0);
        }
    }

    public function addEngineNumber()
    {

        $branch_code = $_POST['branch_code'];
        $this->db->trans_start(); // Start transaction
        $update_count = 0;
        $insert_count = 0;
        $engine_count = 0;
        foreach ($_POST['engine_number'] as $key => $value) {
            $engine_count++;
            $update_count +=  $this->warehouse->updateWarehouseList($value);
            $insert_count += $this->warehouse->insertInventoryList($value, $branch_code);
        }

        $this->db->trans_complete(); // Complete transaction

        if ($update_count != $engine_count || $insert_count != $engine_count) {
            $this->db->trans_rollback();
            echo json_encode(0);
        } else {
            $this->db->trans_commit();
            echo json_encode(1);
        }
    }

    public function checkBranch()
    {
        $data['result'] = $this->warehouse->checkBranch($_POST['branch_code']);
        echo json_encode($data);
    }
    #this code id for php 7.4
    public function uploadEngine($store = null)
    {
        // var_dump($_POST);die;
        if (phpversion() < '7.4') {
            #this code id for php 7.3 below
            require_once 'Php7_0_33OfficeVendor/autoload.php';

            // Replace PhpSpreadsheet with PHPExcel if necessary
            $reader = PHPExcel_IOFactory::createReader('CSV');

            $data_result['error_code'] = 400;
            if ($_FILES['excel_file']['type'] !== 'text/csv') {
                $data_result['message'] = "Invalid file type!";
                echo json_encode($data_result);
                exit;
            }

            $creator = $_SESSION['warehouse_username']; // change this to session id
            $date_file = $_POST['warehouse_name'] . '_' . date('Ymd');
            $fileName = $date_file . '_' . $creator . '_' . $_POST['file_name'];
            $fileType = $_FILES['excel_file']['type'];
            $uploadDir = './assets/warehouse_attachments/' . $date_file;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $newFileName = $uploadDir . '/' . $fileName;
            if (file_exists($newFileName)) {
                $data_result['message'] = "File already exists!";
                echo json_encode($data_result);
                exit;
            }

            try {
                $objPHPExcel = $reader->load($_FILES['excel_file']['tmp_name']);
                $sheet = $objPHPExcel->getActiveSheet();

                $header = [];
                $data = array();
                $rowIterator = $sheet->getRowIterator();
                $chunk = array();
                $rowCount = 0;
                $col_count = 0;
                $err_count = 0;
                $q = [];
                $err_engine = [];
                $duplicate_engine = 0;
                foreach ($rowIterator as $key => $row) {
                    if ($key == 1) {
                        continue;
                    }
                    $rowCount++;
                    $cellIndex = 0;
                    $rowData = array();
                    foreach ($row->getCellIterator() as $key_col => $cell) {
                        if ($key_col == 'C') { // 3rd column
                            $validate_engine = $this->warehouse->checkEngineNumber($cell->getValue());
                            array_push($q, [
                                'engine_number' => $cell->getValue(),
                                'count' => $validate_engine,
                                'row' => $key
                            ]);
                            if (!empty($validate_engine)) {
                                $duplicate_engine++;
                                array_push($err_engine, $key);
                            }
                        }
                        if (empty($cell->getValue())) {
                            $err_count++;
                        }
                        $rowData[] = $cell->getValue();
                    }
                    $rowData[6] = $key;
                    $data[] = $rowData;
                }

                if ($_POST['action'] == 'upload') {
                    $this->db->trans_start(); // start transaction
                    $inser_file = $this->warehouse->insertFile($fileName, $_POST);
                    $store_result = $this->warehouse->uploadEngine($data, $inser_file);
                    if ($store_result > 0) {
                        if (move_uploaded_file($_FILES['excel_file']['tmp_name'], $newFileName . '.csv')) {
                            $data_result['message'] = "File uploaded successfully!";
                        } else {
                            $this->db->trans_rollback(); // rollback transaction
                            $data_result['message'] = "Error uploading file!";
                            echo json_encode($data_result);
                            exit;
                        }
                    } else {
                        $this->db->trans_rollback(); // rollback transaction
                        $data_result['message'] = "Error uploading file!";
                        echo json_encode($data_result);
                        exit;
                    }
                    $this->db->trans_complete(); // complete transaction
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback(); // rollback transaction
                        $data_result['message'] = "Error uploading file. Transaction failed.";
                        echo json_encode($data_result);
                        exit;
                    }

                    $data_result['error_code'] = 200;
                } else {
                    $data_result['result'] = $data;
                    $data_result['error_code'] = 200;
                    $data_result['err_count'] = $err_count;
                    $data_result['duplicate_engine'] = $duplicate_engine;
                    $data_result['engine_data'] = implode(',', $err_engine);
                    $data_result['existing_engine'] = $err_engine;
                    $data_result['row_count'] = $rowCount;
                }
            } catch (Exception $e) {
                $data_result['error_msg'] = $e->getMessage();
                $data_result['error_code'] = 400;
            }

            echo json_encode($data_result);
        } else {
            // var_dump($_POST);die;
            require_once 'vendor/autoload.php';

            $reader = new PhpOffice\PhpSpreadsheet\Reader\Csv();

            // var_dump($_FILES);die;
            // Check the file type
            $data_result['error_code'] = 400;
            if ($_FILES['excel_file']['type'] !== 'text/csv') {
                $data_result['message'] =  "Invalid file type!";
                echo json_encode($data_result);
                exit;
            }

            $creator = $_SESSION['warehouse_username']; #change this to session id
            $date_file = date('Ymd');
            // Get the file name and type
            $fileName =  $date_file . '_' .  $creator . '_' . $_POST['file_name'];
            $fileType = $_FILES['excel_file']['type'];
            // Move the file to a new location
            $uploadDir = './assets/warehouse_attachments/' . $date_file;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            // Add a slash before the filename to ensure it's in the correct directory
            $newFileName = $uploadDir . '/' . $fileName;
            if (file_exists($newFileName)) {
                $data_result['message'] =  "File already exists!";
                echo json_encode($data_result);
                exit;
            }

            try {
                $objPHPExcel = $reader->load($_FILES['excel_file']['tmp_name']);
                // Get the first sheet
                $sheet = $objPHPExcel->getActiveSheet();

                // Read the data from the sheet
                $header = [];
                $data = array();
                $rowIterator = $sheet->getRowIterator();
                $chunk = array();
                $rowCount = 0;
                $col_count = 0;
                $err_count = 0;
                $q = [];
                $err_engine = [];
                $duplicate_engine = 0;
                foreach ($rowIterator as $key => $row) {

                    if ($key == 1) {
                        continue;
                    }
                    $rowCount++;
                    $cellIndex = 0;

                    $rowData = array();
                    foreach ($row->getCellIterator() as $key_col => $cell) {

                        if ($key_col == 'C') { // 3rd column
                            $validate_engine =  $this->warehouse->checkEngineNumber($cell->getValue());
                            array_push($q, [
                                'engine_number' => $cell->getValue(),
                                'count' => $validate_engine,
                                'row' => $key
                            ]);
                            if (!empty($validate_engine)) {
                                $duplicate_engine++;
                                array_push($err_engine, $key);
                            }
                        }

                        if (empty($cell->getValue())) {
                            $err_count++;
                        }
                        $rowData[] = $cell->getValue();
                    }
                    $rowData[6] =  $key;
                    $data[] = $rowData;
                }

                if ($_POST['action'] == 'upload') {
                    $this->db->trans_start(); // start transaction
                    $inser_file = $this->warehouse->insertFile($fileName, $_POST);
                    $store_result = $this->warehouse->uploadEngine($data, $inser_file);
                    if ($store_result > 0) {
                        if (move_uploaded_file($_FILES['excel_file']['tmp_name'], $newFileName . '.csv')) {
                            $data_result['message'] = "File uploaded successfully!";
                        } else {
                            $this->db->trans_rollback(); // rollback transaction
                            $data_result['message'] = "Error uploading file!";
                            echo json_encode($data_result);
                            exit;
                        }
                    } else {
                        $this->db->trans_rollback(); // rollback transaction
                        $data_result['message'] = "Error uploading file!";
                        echo json_encode($data_result);
                        exit;
                    }
                    $this->db->trans_complete(); // complete transaction
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback(); // rollback transaction
                        $data_result['message'] = "Error uploading file. Transaction failed.";
                        echo json_encode($data_result);
                        exit;
                    }
                    $data_result['error_code'] =  200;
                } else {
                    $data_result['result'] = $data;
                    $data_result['error_code'] = 200;
                    $data_result['err_count'] = $err_count;
                    $data_result['duplicate_engine'] = $duplicate_engine;
                    $data_result['engine_data'] = implode(',', $err_engine);
                    $data_result['existing_engine'] = $err_engine;
                    $data_result['row_count'] = $rowCount;
                }
            } catch (PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                // throw new Exception('Error reading CSV file: ' . $e->getMessage());

                $data_result['error_msg'] = $e->getMessage();
                $data_result['error_code'] = 400;
            }
            // Do something with the data
            echo json_encode($data_result);
        }
    }

    public function materialCount(){
        $result =  $this->warehouse->materialCheck($_POST['material_code']);
        echo json_encode(count($result));
        
    }
    public function materialCheck()
    {
        $result =  $this->warehouse->materialCheck($_POST['material_code']);
        $check_inventory = $this->warehouse->checkInventory($_POST['material_code'], (int)$_POST['branch']);

        //    var_dump($check_inventory);die;
        $data['result'] = $result;
        $data['check_inventory'] = count($check_inventory);
        $data['count']  = count($result);
        echo json_encode($data);
    }
    public function getInventory()
    {
        $data_post =  (object) $_POST;
        $data['result'] = $this->warehouse->getInventory($data_post->genid, $data_post->branch, (int)$data_post->statusid);
        $data['logs']   = $this->warehouse->getLogs($data_post->genid);
  
        echo json_encode($data);
    }
    public function saveEngines()
    {
        $data_post = $_POST["insert_data"];
        $success_count = 0;
        


        #for each engine number 
        foreach ($data_post as $key => $value) {
            $result = $this->warehouse->updateOrderWithEngine($value['val'], $value['id'], $value['genid']);
            if ($result > 0) {
                $success_count++;
            }
        }

        #check if all engine number is filled this checking for engine number null value
        $check_order_engine = $this->warehouse->checkOrdeEngine($value['genid']);
        if($check_order_engine == 0){
            #if all engine number is filled, update list status
            $this->warehouse->updateListStatus($data_post[0]['genid']);
        }
       
        echo json_encode(1);
    }
    public function changeStatus(){

        $genid = $_POST['genid'];
        $status = $_POST['statusid'];
        // var_dump($genid, $status);die;

        
        $change_status = $this->warehouse->changeStatus($genid, $status);

        if($status == 2210){
            $this->warehouse->updateInventoryEngineStatus($genid);
        }
        echo json_encode($change_status);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('warehouse'); // or wherever you want to redirect after logout
    }
    public function mobileQr(){
        $this->load->view('Warehouse/QRMobile');
    }
    public function redirect(){
        var_dump($_GET);die;
    }

    public function getCheckOrder(){
        $genid = $_POST['genid'];

        $result = $this->warehouse->getCheckOrder($genid);
        $result[0]->BranchName = _getBranchNameByCode ($result[0]->BranchCode) ;
        $result[0]->CreatedDate =  date('d/m/y', strtotime($result[0]->CreatedDate)); 
        $result[0]->Orders      =  $this->warehouse->getCheckOrderModels($genid);
       echo json_encode($result[0]);
    }
    public function addNewMaterial(){
        // var_dump('<pre>',$_POST);die;
        $array = $_POST['material'];
        $content_count = array_count_values($array);
        $err = 0;
        $data['err_mssg'] = '';

        #validate if material code available 
        foreach ($content_count as $key => $value) {
           $check_material = $this->warehouse->materialCheck($key);
           if(count($check_material) < $value){
               $err++;
               $data['err_mssg'] .= 'Material Code '.$key.' available '.$value.' times<br>';
           }
        }
        $data['err'] = $err;
        if($err == 0){
            $add_material = [];
            foreach($_POST["material"] as $key => $value){
                array_push($add_material, [
                    'OrderId'        => $_POST['genid'],
                    'InventoryId'    =>  $_POST['inventory_id'],
                    'MaterialCode'   => $value,
                    'BranchCode'     => $_POST['branch'],
                    'OrderStatus'    => 1,
                    'CreatedBy'          => $_SESSION['warehouse_username'],
                ]);
            }
            $result_insert  = $this->warehouse->addPickList($add_material);
           
            if($result_insert  > 0) {
                $this->warehouse->UpdateOrderStatus($_POST['inventory_id'],$_POST['genid']);
                $data['err_mssg'] = 'Success';
            } else {
                $data['err'] = $err + 1;
                $data['err_mssg'] = 'Failed to add material. Please try again.';
            };
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }

      
    }

    public function removeEngine(){
        $order_list_id = $_POST['id'];
        $genid = $_POST['genid'];

        $result_delete = $this->warehouse->removeEngine($order_list_id,$genid);
        $inventory_id= $this->getInventoryId($genid);
        $this->warehouse->UpdateOrderStatus($inventory_id, $genid);
        echo json_encode($result_delete);
    }
    public function removeOrderMaterial(){
        $order_list_id = $_POST['id'];
        $genid = $_POST['genid'];
        $result_delete = $this->warehouse->deleteOrderList($order_list_id,$genid);

        // var_dump('<pre>',$result_delete);die;
        // $this->warehouse->UpdateOrderStatus($_POST['inventory_id'],$_POST['genid']);
        echo json_encode($result_delete);
    }
    public function warehouseUsers(){

        $result = $this->warehouse->warehouseUsers();
        foreach ($result as $key => $value) {
            $value->EmployeeName = empty(_getFullNameByCode($value->EmployeeCode)) ? $value->EmployeeCode: _getFullNameByCode($value->EmployeeCode)->display_name;
            $value->Email =   empty(_getFullNameByCode($value->EmployeeCode)) ? '--' : _getFullNameByCode($value->EmployeeCode)->corporate_email;
            $value->Tag  =  empty(_getFullNameByCode($value->EmployeeCode)) ? '--' : _getFullNameByCode($value->EmployeeCode)->ref_value_company_tag;
            $value->Position  =  empty(_getFullNameByCode($value->EmployeeCode)) ? '--' : _getFullNameByCode($value->EmployeeCode)->title;
            $value->SupplyingCode = explode(',', $value->SupplyingCode);
            $value->TabView     = explode(',', $value->TabView);
        }
   
        echo json_encode($result);
    }
    public function changeAccess(){
        $column = $_POST['column'];
        $value = $_POST['value'];
        $id = $_POST['id'];

        $result = $this->warehouse->changeAccess($column, $value, $id);
        echo json_encode($result);
    }
    public function changeSupplyingAccess(){
        $supplying = empty($_POST['supplying_access']) ? NULL : implode(',', $_POST['supplying_access']);
        $controlid = $_POST['controlid'];

        $result = $this->warehouse->changeSupplyingAccess($supplying, $controlid);
        echo json_encode($result);
    }

    public function tabAccess(){
        $tab = empty($_POST['tab_access']) ? NULL : implode(',', $_POST['tab_access']);
        $controlid = $_POST['controlid'];
        $result = $this->warehouse->changeTabAccess($tab, $controlid);
        echo json_encode($result);
    }

    private function getInventoryId($genid){

        $result = $this->warehouse->getInventoryId($genid);

        return $result;
    }
}
