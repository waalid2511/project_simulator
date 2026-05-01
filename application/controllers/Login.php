<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Login extends CI_Controller { 

    public function __construct() 
    { 
        parent::__construct(); 
        $this->load->model('login_model'); 
    } 

    public function index()
    { 
        if ($this->session->userdata('logged_in') === TRUE) { 
            redirect('backend/dashboard');
            return;
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim'); 
        $this->form_validation->set_rules('password', 'Password', 'required|trim'); 

        if ($this->form_validation->run() === FALSE) { 
            $this->load->view('login'); 
            return;
        }

        $this->proses_login(); 
    } 

    public function proses_login()
    {
        $username = trim((string) $this->input->post('username', TRUE));
        $password = (string) $this->input->post('password');

        $user = $this->login_model->get_user_for_login($username);

        if (!$user) {
            $this->session->set_flashdata('message', '<b>Username tidak ditemukan.</b>');
            redirect('login');
            return;
        }

        if (!password_verify($password, $user['password'])) {
            $this->session->set_flashdata('message', '<b>Password salah.</b>');
            redirect('login');
            return;
        }

        $role = isset($user['role']) ? strtolower((string) $user['role']) : '';
        $allowed_roles = array('admin', 'mekanik', 'kasir');

        if (!in_array($role, $allowed_roles, TRUE)) {
            $this->session->set_flashdata('message', '<b>Role user tidak diizinkan.</b>');
            redirect('login');
            return;
        }

        $this->session->set_userdata(array(
            'id' => $user['id'],
            'nama' => isset($user['nama']) ? $user['nama'] : '',
            'username' => isset($user['username']) ? $user['username'] : $username,
            'role' => $role,
            'logged_in' => TRUE,
        ));

        redirect('backend/dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

}