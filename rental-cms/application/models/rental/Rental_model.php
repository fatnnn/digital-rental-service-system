<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rental_model extends CI_Model
{

    public function getDataAll($data)
    {
        $queryall = $this->db->query("
            SELECT
                ID_Rental,
                ID_Item,
                ID_Anggota,
                Tanggal_Pinjam,
                Tanggal_Kembali,
                Status
            FROM rental
        ");

        $sql = "
            SELECT
                ID_Rental,
                ID_Item,
                ID_Anggota,
                Tanggal_Pinjam,
                Tanggal_Kembali,
                Status
            FROM rental
            WHERE ".$data['filtervalue']." LIKE '%".$data['filtertext']."%'
            LIMIT ".$data['start'].",".$data['length'];

        $query = $this->db->query($sql);

        return array(
            "RecordsTotal"    => $queryall->num_rows(),
            "RecordsFiltered" => $queryall->num_rows(),
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
            'result' => $hasil,
            'message' => $hasil ? 'Data berhasil dihapus.' : 'Data gagal dihapus.'
        );
    }

    public function getAllRental()
    {
        return $this->db->get('rental')->result();
    }

}