<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kendaraan_model');
        $this->load->model('Pelanggan_model');
    }

    public function index()
    {
        $data['kendaraan'] = $this->Kendaraan_model->getAll();
        $this->load->view('kendaraan/index', $data);
    }

    public function tambah()
    {
        $data['pelanggan'] = $this->Pelanggan_model->getAll();
        $this->load->view('kendaraan/tambah', $data);
    }

    public function simpan()
    {
        $data = [
            'id_pelanggan' => $this->input->post('id_pelanggan'),
            'merk' => $this->input->post('merk'),
            'tipe' => $this->input->post('tipe'),
            'no_polisi' => strtoupper($this->input->post('no_polisi'))
        ];

        $this->Kendaraan_model->insert($data);
        redirect('kendaraan');
    }

    public function edit($id)
    {
        $data['kendaraan'] = $this->Kendaraan_model->getById($id);
        $data['pelanggan'] = $this->Pelanggan_model->getAll();
        $this->load->view('kendaraan/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'id_pelanggan' => $this->input->post('id_pelanggan'),
            'merk' => $this->input->post('merk'),
            'tipe' => $this->input->post('tipe'),
            'no_polisi' => strtoupper($this->input->post('no_polisi'))
        ];

        $this->Kendaraan_model->update($id, $data);
        redirect('kendaraan');
    }

    public function hapus($id)
    {
        $this->Kendaraan_model->delete($id);
        redirect('kendaraan');
    }
}