<?php
class Pelanggan_model extends CI_Model {

    public function getAll()
    {
        return $this->db->get('pelanggan')->result();
    }
}