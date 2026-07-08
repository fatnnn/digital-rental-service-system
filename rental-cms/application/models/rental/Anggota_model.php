<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_model extends CI_Model
{
    // Kolom yang boleh dipakai untuk filter (whitelist, jaga-jaga dari SQL Injection)
    private $allowedFilter = ['nama', 'alamat', 'nomor_telepon'];

    public function getDataAll($data)
    {
        $total = $this->db->count_all('anggota');

        $filterValue = in_array($data['filtervalue'], $this->allowedFilter)
            ? $data['filtervalue']
            : 'nama';

        $this->db->select('id_anggota, nama, alamat, nomor_telepon');
        $this->db->from('anggota');

        if (!empty($data['filtertext'])) {
            $this->db->like($filterValue, $data['filtertext']);
        }

        $this->db->limit($data['length'], $data['start']);
        $query  = $this->db->get();
        $result = $query->result();

        // Hitung total setelah filter (untuk RecordsFiltered yang benar)
        $this->db->select('id_anggota');
        $this->db->from('anggota');
        if (!empty($data['filtertext'])) {
            $this->db->like($filterValue, $data['filtertext']);
        }
        $filtered = $this->db->count_all_results();

        return array(
            "RecordsTotal"    => $total,
            "RecordsFiltered" => $filtered,
            "Data"            => $result,
        );
    }

    public function getDataId($id)
    {
        $this->db->where('id_anggota', $id);
        $query = $this->db->get('anggota');
        return $query->result();
    }

    public function insertData($data)
    {
        $insert = array(
            'nama'          => $data['nama'],
            'alamat'        => $data['alamat'],
            'nomor_telepon' => $data['nomor_telepon'],
        );
        return $this->db->insert('anggota', $insert);
    }

    public function updateData($data)
    {
        $update = array(
            'nama'          => $data['nama'],
            'alamat'        => $data['alamat'],
            'nomor_telepon' => $data['nomor_telepon'],
        );
        $this->db->where('id_anggota', $data['id_anggota']);
        $query = $this->db->update('anggota', $update);
        return array('result' => $query);
    }

    public function deleteData($data)
    {
        $this->db->where('id_anggota', $data['id']);
        $success = $this->db->delete('anggota');
        return array(
            'result'  => $success,
            'message' => $success ? 'Data berhasil dihapus.' : 'Gagal menghapus data.',
        );
    }

    public function checkNama($nama)
    {
        $this->db->where('nama', $nama);
        $query = $this->db->get('anggota');
        return $query->num_rows() > 0 ? "Data Sama" : "OK";
    }

    public function getAllAnggota()
    {
        return $this->db->get('anggota')->result();
    }
}