<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->helper(['url_helper', 'form']);
        $this->load->library(['form_validation', 'session']);
        
        $this->check_login();
        if ($this->session->userdata('id_role') != "1") {
            redirect('', 'refresh');
        }
    }

    public function index()
    {
        $data['database'] = $this->auth_model->get_all_data();
        $data['look_up'] = $this->auth_model->get_all_data_look_up();
        $data['detail_tr'] = $this->auth_model->get_all_data_detail_transaksi();
        
		$data['title'] = "Test Dashboard";

		$this->load->view('templates/header', $data);
		$this->load->view('tampildata', $data);
        $this->load->view('templates/footer');
        
    }

    public function formtambah()
	{
		$data['title'] = "Tambah Data transaksi| Test tampil Database";

		$this->load->view('templates/header', $data);
		$this->load->view('formtambah');
		$this->load->view('templates/footer');
    }

    public function formtambahlookup()
	{
		$data['title'] = "Tambah Data look up status | Test tampil Database";

		$this->load->view('templates/header', $data);
		$this->load->view('formtambahlookup');
		$this->load->view('templates/footer');
    }
    
    public function tambahtransaksi()
	{
		$this->form_validation->set_message('is_unique', '{field} sudah terpakai');

		$this->form_validation->set_rules('id', 'kode', ['required', 'is_unique[master_transaksi.kode]']);

		$this->validasi();

		if($this->form_validation->run() === FALSE)
		{
			$this->formtambah();
		}
		else
		{
			$this->auth_model->tambah_transaksi();
			$this->session->set_flashdata('input_sukses','Data berhasil di input');
			redirect(current_url());
		}
    }

    public function tambahtlookupstatus()
	{
		$this->form_validation->set_message('is_unique', '{field} sudah terpakai');

		$this->form_validation->set_rules('id', 'kode_nama', ['required', 'is_unique[lookup_status.kode_nama]']);

		$this->validasilookup();

		if($this->form_validation->run() === FALSE)
		{
			$this->formtambahlookup();
		}
		else
		{
			$this->auth_model->tambah_look_up();
			$this->session->set_flashdata('input_sukses','Data berhasil di input');
			redirect(current_url());
		}
    }
    
    public function validasi()
	{
		$this->form_validation->set_message('required', '{field} tidak boleh kosong');

		$config = [[
					'field' => 'kode',
					'label' => 'Kode',
					'rules' => 'required'
				],
				[
					'field' => 'nama',
					'label' => 'Nama',
					'rules' => 'required'
				],
				[
					'field' => 'id',
					'label' => 'ID',
					'rules' => 'required'
                ]
            ];

		$this->form_validation->set_rules($config);
    }

    public function validasilookup()
	{
		$this->form_validation->set_message('required', '{field} tidak boleh kosong');

		$config = [[
					'field' => 'kode_nama',
					'label' => 'Kode nama',
					'rules' => 'required'
				]
            ];

		$this->form_validation->set_rules($config);
    }


    public function formedit($id)
	{
		$data['title'] = 'Edit Data | Test tampil Database';

		$data['db'] = $this->auth_model->edit_transaksi($id);

		$this->load->view('templates/header', $data);
		$this->load->view('formedit', $data);
		$this->load->view('templates/footer');
	}
    
    public function formeditlookup($id)
	{
		$data['title'] = 'Edit Data Look up| Test tampil Database';

		$data['db'] = $this->auth_model->edit_lookup($id);

		$this->load->view('templates/header', $data);
		$this->load->view('formeditlookup', $data);
		$this->load->view('templates/footer');
    }
    
    public function updatetransaksi($id)
	{
		$this->validasi();

		if($this->form_validation->run() === FALSE)
		{
			$this->formedit($id);
		}
		else
		{
			$this->auth_model->update_transaksi();
			$this->session->set_flashdata('update_sukses', 'Data berhasil diperbaharui');
			redirect('admin/home');
		}
    }

    public function updatelookup($id)
	{
		$this->validasilookup();

		if($this->form_validation->run() === FALSE)
		{
			$this->formeditlookup($id);
		}
		else
		{
			$this->auth_model->update_lookup();
			$this->session->set_flashdata('update_sukses', 'Data berhasil diperbaharui');
			redirect('admin/home');
		}
    }
    
    public function hapusdata($id)
	{
		$this->auth_model->hapus_transaksi($id);
		$this->session->set_flashdata('hapus_sukses','Data berhasil di hapus');
		redirect('admin/home');
    }
    
    public function hapus_lookup($id)
	{
		$this->auth_model->hapus_tr_lookup($id);
		$this->session->set_flashdata('hapus_sukses','Data berhasil di hapus');
		redirect('admin/home');
	}

}
