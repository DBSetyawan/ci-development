<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public $table       = 'user';
    public $id          = 'user.id';

    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        $query = $this->db->get_where($this->table, array('username'=>$username, 'password'=>$password));
        return $query->row_array();
    }

    public function check_account($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get($this->table)->row();
        print_r($query);
        if (!$query) {
            return 1;
        }
        if ($query->activated == 0) {
            return 2;
        }
        if ($query->activated == 2) {
            return 3;
        }
     
        return $query;
	}
	
	public function get_by_id()
    {
        $id = $this->session->userdata('id');
        $this->db->select('
            tbl_user.*, tbl_role.id AS id_role, tbl_role.name, tbl_role.description,
        ');
        $this->db->join('tbl_role', 'tbl_user.id_role = tbl_role.id');
        $this->db->from($this->table);
        $this->db->where($this->id, $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function logout($date, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $date);
    }

    public function get_all_data()
	{
		$query = $this->db->get('master_transaksi');
		return $query->result();
    }

    public function get_all_data_detail_transaksi()
	{

        $query = $this->db->select('*')
                  ->from('detail_transaksi')
                  ->join('master_transaksi', 'master_transaksi.id = detail_transaksi.id_master')
                  ->get();

		return $query->result();
    }

    public function get_all_data_look_up()
	{
		$query = $this->db->get('lookup_status');
		return $query->result();
    }
    
    public function tambah_transaksi()
	{
		$data = [
					'id' => $this->input->post('id'),
					'kode' => $this->input->post('kode'),
					'nama' => $this->input->post('nama'),
					'tanggal' => $this->input->post('tanggal'),
					'keterangan' => $this->input->post('keterangan'),
				];

		$this->db->insert('master_transaksi', $data);
    }

    public function tambah_look_up()
	{
		$data = [
					'id' => $this->input->post('id'),
					'kode_nama' => $this->input->post('kode_nama'),
					'keterangan' => $this->input->post('keterangan')
				];

		$this->db->insert('lookup_status', $data);
    }

    public function hapusdata($id)
	{
		$this->auth_model->hapus_transaksi($id);
		$this->session->set_flashdata('hapus_sukses','Data berhasil di hapus');
		redirect('/home/lihatdata');
	}
    
    public function edit_transaksi($id)
	{
		$query = $this->db->get_where('master_transaksi', ['id' => $id]);
		return $query->row();
    }

    public function edit_lookup($id)
	{
		$query = $this->db->get_where('lookup_status', ['id' => $id]);
		return $query->row();
    }
    
    public function update_transaksi()
	{
		$kondisi = ['id' => $this->input->post('id')];
		
		$data = [
					'kode' => $this->input->post('kode'),
					'nama' => $this->input->post('nama'),
					'tanggal' => $this->input->post('tanggal'),
					'keterangan' => $this->input->post('keterangan'),
				];

		$this->db->update('master_transaksi', $data, $kondisi);
    }

    public function update_lookup()
	{
		$kondisi = ['id' => $this->input->post('id')];
		
		$data = [
					'kode_nama' => $this->input->post('kode_nama'),
					'keterangan' => $this->input->post('keterangan')
				];

		$this->db->update('lookup_status', $data, $kondisi);
    }
    
    public function hapus_transaksi($id)
	{
		$this->db->delete('master_transaksi', ['id' => $id]);
    }
    
    public function hapus_tr_lookup($id)
	{
		$this->db->delete('lookup_status', ['id' => $id]);
	}
}
