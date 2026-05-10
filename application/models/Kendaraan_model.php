<?php
class Kendaraan_model extends CI_Model {

    public function getAll()
    {
        return $this->db
            ->select('kendaraan.*, pelanggan.nama')
            ->from('kendaraan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
            ->order_by('id_kendaraan', 'DESC')
            ->get()
            ->result();
    }

    public function getById($id)
    {
        return $this->db->get_where('kendaraan', [
            'id_kendaraan' => $id
        ])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('kendaraan', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_kendaraan', $id)
                        ->update('kendaraan', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('kendaraan', [
            'id_kendaraan' => $id
        ]);
    }
}