<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		
		if($this->session->userdata('stat_log') != "login"){
			redirect(base_url("login"));
		}
		
		$this->load->model('mod_user');
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
			case "1" :	$datapesan['judulmsg'] = "Penambahan Data User"; 
						$datapesan['jenisbox'] = "callout-success";
						break;
			case "2" :	$datapesan['judulmsg'] = "Perubahan Data User"; 
						$datapesan['jenisbox'] = "callout-info";
						break;
			case "3" :	$datapesan['judulmsg'] = "Penghapusan Data User"; 
						$datapesan['jenisbox'] = "callout-warning";
						break;
			case "4" :	$datapesan['judulmsg'] = "Duplikasi User Name"; 
						$datapesan['jenisbox'] = "callout-danger";
						break;
			case "5" :	$datapesan['judulmsg'] = "Perubahan Password Berhasil"; 
						$datapesan['jenisbox'] = "callout-success";
						break;	
			case "6" :	$datapesan['judulmsg'] = "Perubahan Password Gagal"; 
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
			$q_cari = "email<>'administrator' and email like '%$cari%'";
		}
		else
		{
			$q_cari = "email<>'administrator'";
		}
		
		$data['pesan'] = $this->pesan($pesan,$isipesan);
		
		//pagination
		$jumlah_data = $this->mod_user->jumlah_data($q_cari);
		
		$limit = 10;
		$limit_start = ($page - 1) * $limit;

		$user = $this->mod_user->daftar($limit_start,$limit,$q_cari)->result();
		
		$data['page'] = $page;
		$data['limit'] = $limit;
		$data['get_jumlah'] = $jumlah_data;
		$data['jumlah_page'] = ceil($jumlah_data / $limit);
		$data['jumlah_number'] = 3;
		$data['start_number'] = ($page > $data['jumlah_number'])? $page - $data['jumlah_number'] : 1; 
		$data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number']))? $page + $data['jumlah_number'] : $data['jumlah_page']; 
		
		$data['no'] = $limit_start + 1; 
		//end
		
		$record = array();
		$subrecord = array();
		foreach($user as $u)
		{
			$subrecord['kd_user'] = $u->kd_user;
			$subrecord['awal'] = $u->email;
			$subrecord['email'] = $u->email;
			$subrecord['password'] = $u->password;
			$subrecord['penilaian'] = $u->jawab;
			$subrecord['setting'] = $u->setting;
			$subrecord['komponen'] = $u->komponen;
			
			$subrecord['setting_menu_pilih'] = str_replace(",","-",$u->setting);
			if($u->setting != "all")
			{
				$setting_menu = explode(",",$u->setting);
				$hit_set_menu = count($setting_menu);
				$subrecord['list_set_menu'] = "";
				for($hsm = 0; $hsm<$hit_set_menu; $hsm++)
				{
					switch($setting_menu[$hsm])
					{
						case "kegiatan" : $subrecord['list_set_menu'] .= "Kelola Kegiatan<br>"; break;
						case "komponen" : $subrecord['list_set_menu'] .= "Komponen Penilaian<br>"; break;
						case "user" : $subrecord['list_set_menu'] .= "User<br>"; break;
						case "log" : $subrecord['list_set_menu'] .= "Log Aktifitas<br>"; break;
					}
				}
			}
			else
			{
				$subrecord['setting_menu_pilih'] = "kegiatan,komponen,user,log";
				$subrecord['list_set_menu'] = "Semua Menu Setting";
			}
			
			$subrecord['penilaian_pilih'] = str_replace(",","-",$u->jawab);
			if($u->jawab != "all")
			{
				$penilaian = explode(",",$u->jawab);
				$hit_set_penilaian = count($penilaian);
				$subrecord['list_set_penilaian'] = "";
				for($hsp = 0; $hsp<$hit_set_penilaian; $hsp++)
				{
					switch($penilaian[$hsp])
					{
						case "selfass" : $subrecord['list_set_penilaian'] .= "Self Assesment<br>"; break;
						case "survey" : $subrecord['list_set_penilaian'] .= "Surveyor<br>"; break;
					}
				}
			}
			else
			{	
				$subrecord['penilaian_pilih'] = "selfass,survey";
				$subrecord['list_set_penilaian'] = "Semua Penilaian";
			}
			
			$subrecord['komponen_akses_pilih'] = str_replace(",","-",$u->komponen);
			$komponen_akses = explode(",",$u->komponen);
			$hit_komponen_akses = count($komponen_akses);
			$subrecord['list_komponen_akses'] = "";
			for($hka = 0; $hka<$hit_komponen_akses; $hka++) 
			{
				$cek_komponen = $this->mod_user->cek_komponen($komponen_akses[$hka])->result();
				foreach($cek_komponen as $ck)
				{
					$subrecord['list_komponen_akses'] .= $ck->nama_komponen."<br>";
				}
			}
			
			array_push($record,$subrecord);
		}
		$data['user'] = json_encode($record);
		
		$data['aktif_dashboard'] = "";
		$data['aktif_wbbm'] = "";
		$data['aktif_komponen'] = "";
		$data['aktif_user'] = "active";
		$data['aktif_log'] = "";

		$data['email_user'] = $this->session->userdata('email');
		$data['setting'] = $this->session->userdata('setting');
		
		$data['komponen'] = $this->mod_user->komponen()->result();

		$this->log_lib->log_inf("Akses user");
		
		$this->load->view('body/head');
		$this->load->view('body/body',$data);
		$this->load->view('user/user',$data);
		$this->load->view('body/foot');
	}
	
	public function proses($a = 1, $kode = "")
	{
		$email_awal = $this->input->post('awal');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$penilaian = $this->input->post('penilaian');
		$setting = $this->input->post('setting_menu');
		$komponen = $this->input->post('komponen');
		
		if($penilaian != null)
		{
			switch(count($penilaian))
			{
				case 0 : 	$daftar_penilaian = ""; break;
				case 1 : 	$daftar_penilaian = "";
							foreach($penilaian as $p)
							{
								$daftar_penilaian .= $p.",";
							}
							break;
				case 2 : 	$daftar_penilaian= "all"; break;
			}
		}else{$daftar_penilaian = "";}

		if($setting != null)
		{
			switch(count($setting))
			{
				case 0 : 	$daftar_setting = ""; break;
				case 1 :
				case 2 :
				case 3 : 	$daftar_setting = "";
							foreach($setting as $s)
							{
								$daftar_setting .= $s.",";
							}
							break;
				case 4 : 	$daftar_setting = "all"; break;
			}
		}else{$daftar_setting = "";}
		
		if($komponen != null)
		{
			$daftar_komponen = "";
			foreach($komponen as $k)
			{
				$daftar_komponen .= $k.",";
			}
		}else{$daftar_komponen = "";}
	
		$data = array("kode" => $kode,
							"email" => $email,
							"password" => $password,
							"daftar_penilaian" => $daftar_penilaian,
							"daftar_setting" => $daftar_setting,
							"daftar_komponen" => $daftar_komponen);	

		$data_log = "email: ".$email.", password: ".$password.", daftar_penilaian: ".$daftar_penilaian.", daftar_setting: ".$daftar_setting.", daftar_komponen: ".$daftar_komponen;
		
		$ada_email = $this->mod_user->cek_email($email);
		
		switch($a)
		{
			case 1 :	if($ada_email == 0)
						{
							$this->mod_user->simpan($data);
							$pesan = 1;
							$isipesan = "Data user baru di tambahkan dengan email $email";
							$log_info = "Menambahkan user baru ($data_log)";
						}
						else
						{
							$pesan = 4;
							$isipesan = "User dengan email $email sudah terdaftar sebelumnya. Silakan gunakan email lain";
							$log_info = "Gagal menambahkan user baru karena email sudah terdaftar ($data_log)";
						}
						break;
			case 2 :	if($email_awal == $email || $ada_email == 0)
						{
							$this->mod_user->ubah($data);
							$pesan = 2;
							$isipesan = "Data user denga email $email diubah. Silakan di cek kembali perubahannya";
							$log_info = "Merubah data user ($data_log)";
						}
						else
						{
							$pesan = 4;
							$isipesan = "User dengan email $email sudah terdaftar sebelumnya. Silakan gunakan email lain";
							$log_info = "Gagal merubah data user karena email sudah terdaftar ($data_log)";
						}
						break;
			case 3 :	$cek_user = $this->mod_user->cek_user($kode)->result();

						$this->mod_user->hapus($kode);
						$pesan = 3;

						foreach($cek_user as $cu)
						{
							$email = $cu->email;
						}
						$isipesan = "User dengan email $email telah dihapus.";
						$log_info = "Menghapus data user dengan email $email";
						break;
		}	

		$this->log_lib->log_inf($log_info);
		
		redirect("user/index/1/$pesan/$isipesan");
	}
	
	public function profil($email, $pesan = "", $isipesan = "")
	{	
		$data['pesan'] = $this->pesan($pesan,$isipesan);
		
		$data['email'] = $this->session->userdata('email');
		
		$data['aktif_dashboard'] = "";
		$data['aktif_wbbm'] = "";
		$data['aktif_komponen'] = "";
		$data['aktif_user'] = "";
		$data['aktif_log'] = "";
		
		$data['email_user'] = $this->session->userdata('email');
		$data['setting'] = $this->session->userdata('setting');
	
		$this->log_lib->log_inf("Akses profil user");
		
		$this->load->view('body/head');
		$this->load->view('body/body',$data);
		$this->load->view('user/profil',$data);
		$this->load->view('body/foot');
	}

	public function ubah_password($email)
	{
		$lama = $this->input->post('lama');
		$password = $this->input->post('password');
		
		$ada_user = $this->mod_user->cek_user2($email,$lama);

		if($ada_user > 0)
		{
			$this->mod_user->ubah_password($email,$password);
			$pesan = 5;
			$isipesan = "Perubahan password dengan email user $email";
			$log_info = "Merubah password dengan email user $email";
		}
		else
		{
			$pesan = 6;
			$isipesan = "Perubahan password dengan email user $email gagal karena password lama tidak sesuai";
			$log_info = $isipesan;
		}

		$this->log_lib->log_inf($log_info);

		redirect("user/profil/$email/$pesan/$isipesan");
	}
}
