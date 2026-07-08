<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Login_model extends CI_Model 
{
    public function get_valid_login($username, $password)
    {
        // Query sederhana tanpa JOIN dulu untuk debug
        $sql = "SELECT id, username, password, id_peran, aktif
                FROM pengguna
                WHERE username = ?
                AND password = ?
                AND aktif = 1";

        $query = $this->db->query($sql, array($username, $password));
        return $query->row();
    }
    
    public function save_registrasi($data) 
    {
        return $this->db->insert('pengguna', $data);
    }

    public function getperan()
    {
        return $this->db
            ->order_by('id', 'ASC')
            ->get('peran')
            ->result();
    }

    public function get_user_by_username($username) 
    {
        return $this->db
            ->where('username', $username)
            ->get('pengguna')
            ->row();
    }
}

/* End of file Login_model.php | path: application/models/login/Login_model.php */