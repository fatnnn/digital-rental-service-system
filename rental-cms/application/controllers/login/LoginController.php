<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(array('url', 'encryption' ));
        $this->load->model('login/Login_model');
    }

    public function index()
    {
        $data['title'] = 'Halaman Login';
        $data['contents'] = $this->load->view('login/@login', $data, true);
        $this->load->view('login_template', $data);
    }

    public function get_valid_login()
    {
        $data     = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'];
        $password = $data['password'];

        $password_encrypt = encrypt_password($password);
        $user = $this->Login_model->get_valid_login($username, $password_encrypt);

        if ($user) {
            $this->session->set_userdata([
                'is_login' => true,
                'id'       => $user->id,
                'username' => $user->username,
                'id_peran' => $user->id_peran,
            ]);
            echo json_encode(['result' => true, 'message' => 'Login berhasil']);
        } else {
            echo json_encode(['result' => false, 'message' => 'Username atau password salah']);
        }
    }

    public function registrasi()
    {
        $data['title'] = 'Halaman Registrasi';
        $data['contents'] = $this->load->view('login/@registrasi', $data, true);
        $this->load->view('login_template', $data);
    }

    public function save_registrasi()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $insert = [
            'username' => $data['username'],
            'password' => encrypt_password($data['password']),
            'id_peran' => $data['id_peran'],
            'aktif'    => 1,
        ];

        $result = $this->Login_model->save_registrasi($insert);
        echo json_encode(['result' => $result]);
    }

    public function getperan()
    {
        $data = $this->db->get('peran')->result();
        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'value' => $row->id,
                'name'  => $row->nama_peran,
            ];
        }
        echo json_encode($result);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login/LoginController');
    }
}

/* End of file LoginController.php | path: application/controllers/login/LoginController.php */