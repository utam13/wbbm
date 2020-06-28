<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jawaban extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		
		if($this->session->userdata('stat_log') != "login"){
			redirect(base_url("login"));
		}
		
		$this->load->model('mod_jawaban');
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
			case "1" :	$datapesan['judulmsg'] = "Penambahan Data Jawaban"; 
						$datapesan['jenisbox'] = "callout-success";
						break;
			case "2" :	$datapesan['judulmsg'] = "Perubahan Data Jawaban"; 
						$datapesan['jenisbox'] = "callout-info";
						break;
			case "3" :	$datapesan['judulmsg'] = "Penghapusan Data Jawaban"; 
						$datapesan['jenisbox'] = "callout-warning";
						break;
			case "4" :	$datapesan['judulmsg'] = "Duplikasi Nama Jawaban"; 
						$datapesan['jenisbox'] = "callout-danger";
						break;
		}
		
		return $datapesan;
	}
	
	public function index($kode_komponen, $kode_subkomponen, $kode_item, $page = 1, $pesan = "", $isipesan = "")
	{	
		$data['pesan'] = $this->pesan($pesan,$isipesan);
		
		//pagination
		$jumlah_data = $this->mod_jawaban->jumlah_data($kode_item);
		
		$limit = 10;
		$limit_start = ($page - 1) * $limit;

		$data['jawaban'] = $this->mod_jawaban->daftar($limit_start,$limit,$kode_item)->result();
		
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
		$data['aktif_komponen'] = "active";
		$data['aktif_user'] = "";
		$data['aktif_log'] = "";

		$data['email_user'] = $this->session->userdata('email');
		$data['setting'] = $this->session->userdata('setting');
		
		$data['kd_komponen'] = $kode_komponen;
		$komponen = $this->mod_jawaban->cek_komponen($kode_komponen)->result();
		foreach($komponen as $km)
		{
			$data['nama_komponen'] = $km->nama_komponen;
		}
		
		$data['kd_sub_komponen'] = $kode_subkomponen;
		$subkomponen = $this->mod_jawaban->cek_subkomponen($kode_subkomponen)->result();
		foreach($subkomponen as $sk)
		{
			$data['nama_sub_komponen'] = $sk->nama_sub_komponen;
		}
		
		$data['kd_item_penilaian'] = $kode_item;
		$itempenilaian = $this->mod_jawaban->cek_itempenilaian($kode_item)->result();
		foreach($itempenilaian as $ip)
		{
			$data['uraian'] = $ip->nama_item;
			$data['model'] = $ip->model_jawaban;
			
			switch($ip->model_jawaban)
			{
				case 1 : $data['model_jawaban'] = "Ya/Tidak"; break;
				case 2 : $data['model_jawaban'] = "Abjad"; break;
				case 3 : $data['model_jawaban'] = "Angka"; break;
			}
		}

		$this->log_lib->log_inf("Akses pengaturan jawaban penilaian");

		$this->load->view('body/head');
		$this->load->view('body/body',$data);
		$this->load->view('komponen/jawaban',$data);
		$this->load->view('body/foot');
	}
	
	public function proses($a = 1, $kode_komponen, $kode_subkomponen, $kode_item, $kode = "",$nama = "")
	{
		$kd_spek_nilai = $kode;
		$nama_nilai = $this->input->post('nama');
		$nilai = $this->input->post('nilai');
		
		$data = array("kd_spek_nilai" => $kd_spek_nilai,
							"kd_item_penilaian" => $kode_item,
							"nama_nilai" => $nama_nilai,
							"nilai" => $nilai);

		$data_log = "kd_spek_nilai: ".$kd_spek_nilai.", kd_item_penilaian: ".$kode_item.", nama_nilai: ".$nama_nilai.", nilai: ".$nilai;
		
		$ada_item = $this->mod_jawaban->cek_nama($nama_nilai,$kd_spek_nilai);
		
		switch($a)
		{
			case 1 :	if($ada_item == 0)
						{
							$this->mod_jawaban->simpan($data);
							$pesan = 1;
							$isipesan = "Data nilai baru di tambahkan";
							$log_info = "Menambahkan nilai baru ($data_log)";
						}
						else
						{
							$pesan = 4;
							$isipesan = "Nilai sudah terdaftar";
							$log_info = "Menambahkan nilai baru gagal karena sudah terdaftar ($data_log)";
						}
						break;
			case 2 :	$this->mod_jawaban->ubah($data);
						$pesan = 2;
						$isipesan = "Nilai diubah";
						$log_info = "Merubah data nilai ($data_log)";
						break;
			case 3 :	$this->mod_jawaban->hapus($kode);
						$pesan = 3;
						$isipesan = "Nilai dihapus.";
						$log_info = "Menghapus data nilai $nama";
						break;
		}	

		$this->log_lib->log_inf($log_info);
		
		redirect("jawaban/index/$kode_komponen/$kode_subkomponen/$kode_item/1/$pesan/$isipesan");
	}
	
}
