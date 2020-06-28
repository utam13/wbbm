<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komponen extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		
		if($this->session->userdata('stat_log') != "login"){
			redirect(base_url("login"));
		}
		
		$this->load->model('mod_komponen');
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
			case "1" :	$datapesan['judulmsg'] = "Penambahan Data Komponen"; 
						$datapesan['jenisbox'] = "callout-success";
						break;
			case "2" :	$datapesan['judulmsg'] = "Perubahan Data Komponen"; 
						$datapesan['jenisbox'] = "callout-info";
						break;
			case "3" :	$datapesan['judulmsg'] = "Penghapusan Data Komponen"; 
						$datapesan['jenisbox'] = "callout-warning";
						break;
			case "4" :	$datapesan['judulmsg'] = "Duplikasi Nama Komponen"; 
						$datapesan['jenisbox'] = "callout-danger";
						break;
			case "5" :	$datapesan['judulmsg'] = "Perubahan Status Sub Komponen"; 
						$datapesan['jenisbox'] = "callout-warning";
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
			$q_cari = "nama_komponen like '%$cari%'";
		}
		else
		{
			$q_cari = "nama_komponen <> ''";
		}
		
		$data['pesan'] = $this->pesan($pesan,$isipesan);
		
		//pagination
		$jumlah_data = $this->mod_komponen->jumlah_data($q_cari);
		
		$limit = 10;
		$limit_start = ($page - 1) * $limit;

		$komponen = $this->mod_komponen->daftar($limit_start,$limit,$q_cari)->result();
		
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

		$this->log_lib->log_inf("Akses komponen penilaian");
		
		$record = array();
		$subrecord = array();
		foreach($komponen as $k)
		{
			$jumlah_item = $this->mod_komponen->jumlah_item($k->kd_komponen);
			$jumlah_item_aktif = $this->mod_komponen->jumlah_item_aktif($k->kd_komponen);
			$jumlah_item_nonaktif = $this->mod_komponen->jumlah_item_nonaktif($k->kd_komponen);
			
			$subrecord['kelompok'] = $k->kelompok;			
			$subrecord['kd_komponen'] = $k->kd_komponen;
			$subrecord['nama_komponen'] = $k->nama_komponen;
			$subrecord['nilai_std'] = $k->nilai_std;
			$subrecord['jml_item'] = $jumlah_item;
			$subrecord['jml_item_aktif'] = $jumlah_item_aktif;
			$subrecord['jml_item_nonaktif'] = $jumlah_item_nonaktif;
			$subrecord['aktif'] = $k->aktif;
			switch($subrecord['aktif'])
			{
				case 0 : $subrecord['simbol_aktif_nonaktif'] = "bg-maroon"; $subrecord['status']= "Non Aktif"; break;
				case 1 : $subrecord['simbol_aktif_nonaktif'] = "bg-purple"; $subrecord['status']= "Aktif"; break;
			}
			
			array_push($record,$subrecord);
		}
		$data['komponen'] = json_encode($record);
		
		$this->load->view('body/head');
		$this->load->view('body/body',$data);
		$this->load->view('komponen/komponen',$data);
		$this->load->view('body/foot');
	}
	
	public function proses($a = 1, $kode = "", $aktif = 0,$nama = "")
	{
		$kd_komponen = $kode;
		$kelompok = $this->input->post('kelompok');
		$nama_komponen_awal = $this->input->post('awal');
		$nama_komponen = $this->input->post('nama');
		$nilai = $this->input->post('nilai');
		
		$data = array("kd_komponen" => $kd_komponen,
							"kelompok" => $kelompok,
							"nama_komponen" => $nama_komponen,
							"nilai" => $nilai);
		
		$data_log = "kd_komponen: ".$kd_komponen.", kelompok: ".$kelompok.", nama_komponen: ".$nama_komponen.", nilai: ".$nilai;

		$ada_nama_komponen = $this->mod_komponen->cek_nama($nama_komponen);
		
		switch($a)
		{
			case 1 :	if($ada_nama_komponen == 0)
						{
							$this->mod_komponen->simpan($data);
							$pesan = 1;
							$isipesan = "Data komponen baru di tambahkan dengan nama komponen $nama_komponen";
							$log_info = "Menambahkan komponen baru ($data_log)";
						}
						else
						{
							$pesan = 4;
							$isipesan = "Komponen dengan nama $nama_komponen sudah terdaftar sebelumnya. Silakan gunakan nama lain";	
							$log_info = "Menambahkan komponen baru gagal karena nama komponen sudah terdaftar ($data_log)";
						}
						break;
			case 2 :	if($nama_komponen_awal == $nama_komponen || $ada_nama_komponen == 0)
						{
							$this->mod_komponen->ubah($data);
							$pesan = 2;
							$isipesan = "Data komponen denga nama $nama_komponen diubah. Silakan di cek kembali perubahannya";
							$log_info = "Merubah data komponen ($data_log)";
						}
						else
						{
							$pesan = 4;
							$isipesan = "Komponen dengan nama $nama_komponen sudah terdaftar sebelumnya. Silakan gunakan nama lain";
							$log_info = "Merubah data komponen gagal karena nama komponen sudah terdaftar ($data_log)";
						}
						break;
			case 3 :	$this->mod_komponen->hapus($kode);
						$pesan = 3;
						$isipesan = "Komponen dengan nama $nama telah dihapus beserta data sub komponen nya dan penilaian yang menggunakan komponen tersebut.";
						$log_info = "Menghapus data komponen dengan nama $nama";
						break;
			case 4 :	if($aktif == 0)
						{
							$nilai = 1;
							$text_pesan = "di aktfikan";
						}
						else
						{
							$nilai = 0;
							$text_pesan = "di nonaktfikan";
						}
						$this->mod_komponen->status($kode,$nilai);
						$pesan = 5;
						$isipesan = "Item penilaian dengan nama $nama telah $text_pesan.";
						$log_info = $isipesan;
						break;
		}	
		
		$this->log_lib->log_inf($log_info);

		redirect("komponen/index/$kode_kegiatan/1/$pesan/$isipesan");
	}
	
}
