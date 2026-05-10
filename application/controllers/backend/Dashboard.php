<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Dashboard extends CI_Controller { 

    public function __construct() 
    { 
        parent::__construct(); 
        $this->load->helper('url');  

        if ($this->session->userdata('logged_in') !== TRUE) { 
            redirect('login');  
            return;
        }

        $allowed_roles = array('admin', 'mekanik', 'kasir');
        $role = strtolower((string) $this->session->userdata('role'));

        if (!in_array($role, $allowed_roles, TRUE)) {
            $this->session->sess_destroy();
            redirect('login');
            return;
        } 
    } 

    public function index() 
    { 
        $role = strtolower((string) $this->session->userdata('role'));

        if ($role === 'admin') {
            redirect('backend/dashboard/admin');
            return;
        }

        if ($role === 'mekanik') {
            redirect('backend/dashboard/mekanik');
            return;
        }

        if ($role === 'kasir') {
            redirect('backend/dashboard/kasir');
            return;
        }

        $this->session->sess_destroy();
        redirect('login');
    }

    public function admin()
    {
        $this->require_role('admin');
        $data = $this->build_view_data('Dashboard Admin');
        $this->load->view('backend/dashboard/admin', $data);
    }

    public function mekanik()
    {
        $this->require_role('mekanik');
        $data = $this->build_view_data('Dashboard Mekanik');
        $this->load->view('backend/dashboard/mekanik', $data);
    }

    public function kasir()
    {
        $this->require_role('kasir');
        $data = $this->build_view_data('Dashboard Kasir');
        $this->load->view('backend/dashboard/kasir', $data);
    }

    private function build_view_data($title)
    {
        return array(
            'title' => $title,
            'nama' => (string) $this->session->userdata('nama'),
            'username' => (string) $this->session->userdata('username'),
            'role' => strtoupper((string) $this->session->userdata('role')),
        );
    }

    private function require_role($expected_role)
    {
        $current_role = strtolower((string) $this->session->userdata('role'));
        if ($current_role !== $expected_role) {
            redirect('backend/dashboard');
            exit;
        }
    } 

}