<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AnggotaController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->helper('configsession');
        // cek_login();
        $this->load->model('rental/Anggota_model', 'model');
    }

    public function index()
    {
        $data['title'] = 'Halaman Anggota';
        $this->template->load('rental', 'rental/@anggota', $data);
    }

    function getData()
    {
        $data = array(
            'start'       => $_POST['start'],
            'length'      => $_POST['length'],
            'filtervalue' => $_POST['filtervalue'],
            'filtertext'  => $_POST['filtertext'],
        );
        $res = $this->model->getDataAll($data);
        echo json_encode($res);
    }

    function getDataSelect()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $res  = $this->model->getDataId($data['id']);
        echo json_encode($res);
    }

    function save()
    {
        $data   = json_decode(file_get_contents('php://input'), true);
        $insert = $this->model->insertData($data);
        $res    = array('result' => $insert);
        echo json_encode($res);
    }

    function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        error_log(print_r($data, true));
        $res  = $this->model->updateData($data);
        echo json_encode($res);
    }

    function delete()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $data = array('id' => $data['id']);
        $res  = $this->model->deleteData($data);
        echo json_encode($res);
    }

    function checkNama()
    {
        $data  = json_decode(file_get_contents('php://input'), true);
        $check = $this->model->checkNama($data['nama']);
        $res   = array('res' => $check);
        echo json_encode($res);
    }
}