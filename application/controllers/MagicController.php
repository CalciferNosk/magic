<?php defined('BASEPATH') or exit('No direct script access allowed');

class MagicController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MagicModel', 'ma_del');
      
        $this->load->library('recaptcha', 'application\libraries');
        $this->load->model('MaintenanceModel', 'maintenance');

        $isMaintenance = $this->maintenance->getFormMaintenance(82);
        #check if value is 1
        if (!empty($isMaintenance)) {
            redirect('maintenance');
        }
    }

    public function index()
    {
        $data['data'] = 0;
        // $data['test'] = $this->test();
        $this->load->library('user_agent');
        $data['is_mobile'] = $this->agent->is_mobile();
        $this->load->view('MagicModule/MagicView', $data);
    }

    public function now()
    {
        $date = $_POST['date'];
        $hours = $_POST['hours'];
        $minutes = $_POST['minutes'];
        $sec = rand(1, 59);
        $data['display'] =  date('F j, Y H:i:s A', strtotime($date . ' ' . $hours . ':' . $minutes . ':' . $sec));

        $obj = new stdClass();
        $obj->ipAddress = "172.0.0.32";
        $obj->port = "4370";
        $obj->commKey = "93358";
        $obj->machineNumber = 1;

        $date = new DateTime($_POST['date']);
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        $url = "http://172.0.3.72:7000/Expecto-Patronum/use-customizable-magic-spell?Year={$year}&Month={$month}&Day={$day}&Hour={$hours}&Minute={$minutes}&Second={$sec}";
        $data['url'] = $url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode != 200):
            $res = [
                'response' => false,
                'message' => 'Error in updating, please Contact IT Developer Team'
            ];
            echo json_encode($res);
        else:
            $log = [
                'Date' => $_POST['date'],
                'Hours' => $hours,
                'Minutes' => $minutes,
                'Seconds' => $sec,
                'Action'  => 'Magic',
                'CreatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->ma_del->logMagic($log);
            echo "ConnectedSuccessfully <br> time :";
            echo json_encode($response);
        endif;


        echo json_encode($data);
    }

    public function reset(){
        $obj = new stdClass();
        $obj->ipAddress = "172.0.0.32";
        $obj->port = "4370";
        $obj->commKey = "93358";
        $obj->machineNumber = 1;

        $url = "http://172.0.3.72:7000/Expecto-Patronum/undo-magic";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode != 200):
            $res = [
                'response' => false,
                'message' => 'Error in updating, please Contact IT Developer Team'
            ];
            echo json_encode($res);
        else:
             $log = [
                'Date' => date('Y-m-d H:i:s'),
                'Hours' => date('H'),
                'Minutes' => date('i'),
                'Seconds' => date('s'),
                'Action'  => 'Reset Magic',
                'CreatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->ma_del->logMagic($log);
            echo "ConnectedSuccessfully <br> time :";
            echo json_encode($response);
        endif;
    }

    public function test()
    {
        $obj = new stdClass();
        $obj->ipAddress = "172.0.0.32";
        $obj->port = "4370";
        $obj->commKey = "93358";
        $obj->machineNumber = 1;

        $url = "http://172.0.3.72:7000/Expecto-Patronum/get-device-time";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode != 200):
            $res = [
                'response' => false,
                'message' => 'Error in updating, please Contact IT Developer Team'
            ];
            $data['display'] = "";
            $data['mssg'] = 0;
            echo json_encode($res);
        else:
              $log = [
                'Date' => date('Y-m-d H:i:s'),
                'Hours' => date('H'),
                'Minutes' => date('i'),
                'Seconds' => date('s'),
                'Action'  => 'Test Magic',
                'CreatedDate' => date('Y-m-d H:i:s'),
            ];
            $this->ma_del->logMagic($log);
            $data['display'] = "ConnectedSuccessfully <br> time :";
            $data['mssg'] = '<i style="color:green;font-weight:bold">'.$response.'</i>';
            echo json_encode($data);
            // return $response;
        endif;
    }
}
