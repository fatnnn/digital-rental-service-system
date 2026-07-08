<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_model extends CI_Model
{
    // Kolom yang boleh dipakai untuk filter (whitelist, jaga-jaga dari SQL Injection)
    private $allowedFilter = ['nama_item', 'stok'];

    public function getDataAll($data)
    {
        $total = $this->db->count_all('item');

        $filterValue = in_array($data['filtervalue'], $this->allowedFilter)
            ? $data['filtervalue']
            : 'nama_item';

        $this->db->select('id_item, nama_item, stok');
        $this->db->from('item');

        if (!empty($data['filtertext'])) {
            $this->db->like($filterValue, $data['filtertext']);
        }

        $this->db->limit($data['length'], $data['start']);
        $query  = $this->db->get();
        $result = $query->result();

        // Hitung total setelah filter (untuk RecordsFiltered yang benar)
        $this->db->select('id_item');
        $this->db->from('item');
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
        $this->db->where('id_item', $id);
        $query = $this->db->get('item');
        return $query->result();
    }

    public function insertData($data)
    {
        $insert = array(
            'nama_item'     => $data['nama_item'],
            'stok'          => $data['stok'],
        );
        return $this->db->insert('item', $insert);
    }

    public function updateData($data)
    {
        $update = array(
            'nama_item'     => $data['nama_item'],
            'stok'          => $data['stok'],
        );
        $this->db->where('id_item', $data['id_item']);
        $query = $this->db->update('item', $update);
        return array('result' => $query);
    }

    public function deleteData($data)
    {
        $this->db->where('id_item', $data['id']);
        $success = $this->db->delete('item');
        return array(
            'result'  => $success,
            'message' => $success ? 'Data berhasil dihapus.' : 'Gagal menghapus data.',
        );
    }

    public function checkNama($nama)
    {
        $this->db->where('nama_item', $nama);
        $query = $this->db->get('item');
        return $query->num_rows() > 0 ? "Data Sama" : "OK";
    }

    public function getAllAnggota()
    {
        return $this->db->get('item')->result();
    }
}