<?php 
class Login_model extends CI_Model { 
 
    public function get_user_for_login($username)
    {
        return $this->db
            ->from('user')
            ->where('username', $username)
            ->limit(1)
            ->get()
            ->row_array();
    }
 
}