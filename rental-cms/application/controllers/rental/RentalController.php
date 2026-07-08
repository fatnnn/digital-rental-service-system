<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RentalController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('rental/Rental_model', 'model');
    }

    public function index()
    {
        $data['title'] = 'Halaman Rental';
        $this->template->load('rental', 'rental/@rental', $data);
    }

    function getData()
    {
        $data = array(
            'start'       => isset($_POST['start'])       ? $_POST['start']       : 0,
            'length'      => isset($_POST['length'])      ? $_POST['length']      : 10,
            'filtervalue' => isset($_POST['filtervalue']) ? $_POST['filtervalue'] : 'Status',
            'filtertext'  => isset($_POST['filtertext'])  ? $_POST['filtertext']  : '',
        );
        $res = $this->model->getDataAll($data);
        echo json_encode($res);
    }

    function getDataSelect()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $res  = $this->model->getDataId($data['ID_Rental']);
        echo json_encode($res);
    }

    function save()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        unset($data['ID_Rental']); // hapus ID_Rental agar auto increment
        $insert = $this->model->insertData($data);
        $res    = array('result' => $insert);
        echo json_encode($res);
    }

    function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $res  = $this->model->updateData($data);
        echo json_encode($res);
    }

    function delete()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $data = array('ID_Rental' => $data['ID_Rental']);
        $res  = $this->model->deleteData($data);
        echo json_encode($res);
    }
}