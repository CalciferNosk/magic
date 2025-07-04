<?php defined('BASEPATH') or exit('No direct script access allowed');

class RaffleController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RaffleModel', 'm_raffle');
    }

    public function index()
    {
        if (base64_decode($_GET['auth_id']) != 'hr12345') {
            redirect(base_url());
        }
        $data['result'] = $this->m_raffle->getRaffleCount()->count;

        if ($data['result'] != 0) {
            $data['winner'] = $this->m_raffle->getRaffleResult();
        }
        $data['info'] = $this->m_raffle->getInfo();

        $this->load->view('RaffleView', $data);
    }
    public function drawRaffle()
    {
        $call = $this->m_raffle->runDraw();
        $data['winner'] = $this->m_raffle->getRaffleResult();



        echo json_encode($data);
    }
    public function viewWinner()
    {
        $data['winner'] = $this->m_raffle->getRaffleResult();
        echo json_encode($data);
    }
    public function login($pass)
    {
        // var_dump($pass);die();
        if ($pass == 'Admin') {
            $data['ok'] = 1;
        } else {
            $data['ok'] = 0;
        }


        echo json_encode($data);
    }
}
