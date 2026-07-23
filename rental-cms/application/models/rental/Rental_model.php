<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rental_model extends CI_Model
{
    public function getDataAll($data)
    {
        $filter = [
            'Status',
            'Tanggal_Pinjam'
        ];

        $filtervalue = in_array($data['filtervalue'], $filter)
            ? $data['filtervalue']
            : 'Status';

        // Total Data
        $queryTotal = $this->db->select('ID_Rental')
                               ->from('rental')
                               ->get();

        // Data
        $this->db->select('
            ID_Rental,
            ID_Item,
            ID_Anggota,
            Tanggal_Pinjam,
            Tanggal_Kembali,
            Status
        ');

        $this->db->from('rental');

        if ($data['filtertext'] != '') {
            $this->db->like($filtervalue, $data['filtertext']);
        }

        $this->db->limit($data['length'], $data['start']);

        $query = $this->db->get();

        // Records Filtered
        $this->db->from('rental');

        if ($data['filtertext'] != '') {
            $this->db->like($filtervalue, $data['filtertext']);
        }

        $filtered = $this->db->count_all_results();

        return array(
            "RecordsTotal"    => $queryTotal->num_rows(),
            "RecordsFiltered" => $filtered,
            "Data"            => $query->result()
        );
    }

    public function getDataId($id)
    {
        return $this->db->where('ID_Rental', $id)
                        ->get('rental')
                        ->result();
    }

    public function insertData($data)
    {
        return $this->db->insert('rental', $data);
    }

    public function updateData($data)
    {
        $this->db->where('ID_Rental', $data['ID_Rental']);

        return array(
            'result' => $this->db->update('rental', $data)
        );
    }

    public function deleteData($data)
    {
        $this->db->where('ID_Rental', $data['ID_Rental']);

        $hasil = $this->db->delete('rental');

        return array(
            'result'  => $hasil,
            'message' => $hasil ? 'Data berhasil dihapus.' : 'Data gagal dihapus.'
        );
    }

    public function getAllRental()
    {
        return $this->db->get('rental')->result();
    }
}