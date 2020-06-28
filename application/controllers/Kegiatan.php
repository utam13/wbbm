<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		
		if($this->session->userdata('stat_log') != "login"){
			redirect(base_url("login"));
		}
		
		$this->load->model('mod_kegiatan');
	}
	
	public function pesan($pesan = "",$isipesan = "")
	{
		//pesan proses
		$datapesan['kode_pesan'] = $pesan;
		$datapesan['isipesan'] = $isipesan;
		$datapesan['judulmsg'] = ""; 
		$datapesan['jenisbox'] = "";
		switch($pesan)
		{
			case "1" :	$datapesan['judulmsg'] = "Penambahan Data Kegiatan"; 
						$datapesan['jenisbox'] = "callout-success";
						break;
			case "2" :	$datapesan['judulmsg'] = "Perubahan Data Kegiatan"; 
						$datapesan['jenisbox'] = "callout-info";
						break;
			case "3" :	$datapesan['judulmsg'] = "Penghapusan Data Kegiatan"; 
						$datapesan['jenisbox'] = "callout-warning";
						break;
			case "4" :	$datapesan['judulmsg'] = "Duplikasi Nama Kegiatan"; 
						$datapesan['jenisbox'] = "callout-danger";
						break;
		}
		
		return $datapesan;
	}
	
	public function index($page = 1, $pesan = "", $isipesan = "")
	{	
		//cari
		$cari = $this->input->post('cari');
		if($cari != "")
		{
			$q_cari = "nama_kegiatan like '%$cari%'";
		}
		else
		{
			$q_cari = "nama_kegiatan <> ''";
		}
		
		$data['pesan'] = $this->pesan($pesan,$isipesan);
		
		//pagination
		$jumlah_data = $this->mod_kegiatan->jumlah_data($q_cari);
		
		$limit = 10;
		$limit_start = ($page - 1) * $limit;

		$data['kegiatan'] = $this->mod_kegiatan->daftar($limit_start,$limit,$q_cari)->result();
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
		$data['aktif_wbbm'] = "active";
		$data['aktif_komponen'] = "";
		$data['aktif_user'] = "";
		$data['aktif_log'] = "";

		$data['email_user'] = $this->session->userdata('email');
		$data['setting'] = $this->session->userdata('setting');
		
		$this->log_lib->log_inf("Akses kegiatan");

		$this->load->view('body/head');
		$this->load->view('body/body',$data);
		$this->load->view('kegiatan/kegiatan',$data);
		$this->load->view('body/foot');
	}
	
	public function proses($a = 1,$kode = "",$nama = "")
	{
		$kd_kegiatan = $kode;
		$nama_kegiatan_awal = $this->input->post('awal');
		$nama_kegiatan = $this->input->post('nama');
		$dari = $this->input->post('dari');
		$sampai = $this->input->post('sampai');
		
		$data = array("kd_kegiatan" => $kd_kegiatan,
							"nama_kegiatan" => $nama_kegiatan,
							"dari" => $dari,
							"sampai" => $sampai,
							"total_sa" => 0,
							"total_sy" => 0);

		$data_log = "kd_kegiatan: ".$kd_kegiatan.", nama_kegiatan: ".$nama_kegiatan.", dari: ".$dari.", sampai: ".$sampai;
		
		$ada_nama_kegiatan = $this->mod_kegiatan->cek_nama($nama_kegiatan);
		
		switch($a)
		{
			case 1 :	if($ada_nama_kegiatan == 0)
						{
							$this->mod_kegiatan->simpan($data);
							$pesan = 1;
							$isipesan = "Data kegiatan baru di tambahkan dengan nama kegiatan $nama_kegiatan";
							$log_info = "Menambahkan kegiatan baru ($data_log)";
						}
						else
						{
							$pesan = 4;
							$isipesan = "Kegiatan dengan nama $nama_kegiatan sudah terdaftar sebelumnya. Silakan gunakan nama lain";
							$log_info = "Menambahkan kegiatan baru gagal karena nama kegiatan sudah terdaftar ($data_log)";
						}
						break;
			case 2 :	if($nama_kegiatan_awal == $nama_kegiatan || $ada_nama_kegiatan == 0)
						{
							$this->mod_kegiatan->ubah($data);
							$pesan = 2;
							$isipesan = "Data kegiatan denga nama $nama_kegiatan diubah. Silakan di cek kembali perubahannya";
							$log_info = "Merubah data kegiatan ($data_log)";
						}
						else
						{
							$pesan = 4;
							$isipesan = "Kegiatan dengan nama $nama_kegiatan sudah terdaftar sebelumnya. Silakan gunakan nama lain";
							$log_info = "Merubah data kegiatan gagal karena nama kegiatan sudah terdaftar ($data_log)";
						}
						break;
			case 3 :	$this->mod_kegiatan->hapus($kode);
						$pesan = 3;
						$isipesan = "Kegiatan dengan nama $nama telah dihapus beserta data penilaiannya";
						$log_info = "Menghapus data kegiatan dengan nama kegiatan $nama";
						break;
		}	

		$this->log_lib->log_inf($log_info);
		
		redirect("kegiatan/index/1/$pesan/$isipesan");
	}
	
}
