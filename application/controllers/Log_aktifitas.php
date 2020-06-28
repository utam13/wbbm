<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_aktifitas extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		
		if($this->session->userdata('stat_log') != "login"){
			redirect(base_url("login"));
		}

		$this->load->model('mod_log');
	}
	
	public function index($page = 1)
	{	
		//cari
		$cari = $this->input->post('cari');
		if($cari != "")
		{
			$q_cari = "infolog like '%$cari%'";
		}
		else
		{
			$q_cari = "waktulog<>''";
		}
		
		//pagination
		$jumlah_data = $this->mod_log->jumlah_data($q_cari);
		
		$limit = 10;
		$limit_start = ($page - 1) * $limit;

		$data['log'] = $this->mod_log->daftar($limit_start,$limit,$q_cari)->result();
		
		$data['page'] = $page;
		$data['limit'] = $limit;
		$data['get_jumlah'] = $jumlah_data;
		$data['jumlah_page'] = ceil($jumlah_data / $limit);
		$data['jumlah_number'] = 3;
		$data['start_number'] = ($page > $data['jumlah_number'])? $page - $data['jumlah_number'] : 1; 
		$data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number']))? $page + $data['jumlah_number'] : $data['jumlah_page']; 
		
		$data['no'] = $limit_start + 1; 
		//end
		
		$data['aktif_dashboard'] = "";
		$data['aktif_wbbm'] = "";
		$data['aktif_komponen'] = "";
		$data['aktif_user'] = "";
		$data['aktif_log'] = "active";

		$data['email_user'] = $this->session->userdata('email');
		$data['setting'] = $this->session->userdata('setting');

		$this->log_lib->log_inf("Akses log aktifitas");
		
		$this->load->view('body/head');
		$this->load->view('body/body',$data);
		$this->load->view('log/log',$data);
		$this->load->view('body/foot');
	}
	
	public function laporan()
	{
		$data['log'] = $this->mod_log->laporan()->result();
		
		$this->load->view('log/laporan',$data);
	}

	public function hapus()
	{
		$this->mod_log->hapus();
		
		redirect("log_aktifitas");
	}
	
}
