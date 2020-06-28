<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subkomponen extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('stat_log') != "login") {
			redirect(base_url("login"));
		}

		$this->load->model('mod_subkomponen');
	}

	public function pesan($pesan = "", $isipesan = "")
	{
		//pesan proses
		$datapesan['kode_pesan'] = $pesan;
		$datapesan['isipesan'] = $isipesan;
		$datapesan['judulmsg'] = "";
		$datapesan['jenisbox'] = "";
		switch ($pesan) {
			case "1":
				$datapesan['judulmsg'] = "Penambahan Data Sub Komponen";
				$datapesan['jenisbox'] = "callout-success";
				break;
			case "2":
				$datapesan['judulmsg'] = "Perubahan Data Sub Komponen";
				$datapesan['jenisbox'] = "callout-info";
				break;
			case "3":
				$datapesan['judulmsg'] = "Penghapusan Data Sub Komponen";
				$datapesan['jenisbox'] = "callout-warning";
				break;
			case "4":
				$datapesan['judulmsg'] = "Duplikasi Nama Sub Komponen";
				$datapesan['jenisbox'] = "callout-danger";
				break;
			case "5":
				$datapesan['judulmsg'] = "Perubahan Status Sub Komponen";
				$datapesan['jenisbox'] = "callout-warning";
				break;
		}

		return $datapesan;
	}

	public function index($kode_komponen, $page = 1, $pesan = "", $isipesan = "")
	{
		//cari
		$cari = $this->input->post('cari');
		if ($cari != "") {
			$q_cari = "kd_komponen='$kode_komponen' and nama_sub_komponen like '%$cari%'";
		} else {
			$q_cari = "kd_komponen='$kode_komponen'";
		}

		$data['pesan'] = $this->pesan($pesan, $isipesan);

		//pagination
		$jumlah_data = $this->mod_subkomponen->jumlah_data($q_cari);

		$limit = 10;
		$limit_start = ($page - 1) * $limit;

		$subkomponen = $this->mod_subkomponen->daftar($limit_start, $limit, $q_cari)->result();

		$data['page'] = $page;
		$data['limit'] = $limit;
		$data['get_jumlah'] = $jumlah_data;
		$data['jumlah_page'] = ceil($jumlah_data / $limit);
		$data['jumlah_number'] = 3;
		$data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
		$data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

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
		$komponen = $this->mod_subkomponen->cek_komponen($kode_komponen)->result();
		foreach ($komponen as $km) {
			$data['kelompok_komponen'] = $km->kelompok;
			$data['nama_komponen'] = $km->nama_komponen;
		}

		$record = array();
		$subrecord = array();
		foreach ($subkomponen as $sk) {
			$jumlah_item = $this->mod_subkomponen->jumlah_item($sk->kd_sub_komponen);
			$jumlah_item_aktif = $this->mod_subkomponen->jumlah_item_aktif($sk->kd_sub_komponen);
			$jumlah_item_nonaktif = $this->mod_subkomponen->jumlah_item_nonaktif($sk->kd_sub_komponen);

			$subrecord['kd_sub_komponen'] = $sk->kd_sub_komponen;
			$subrecord['nama_sub_komponen'] = $sk->nama_sub_komponen;
			$subrecord['nilai_std'] = $sk->nilai_std;
			$subrecord['nilai_maks'] = $sk->nilai_maks;
			$subrecord['keterangan'] = $sk->keterangan;
			$subrecord['jml_item'] = $jumlah_item;
			$subrecord['jml_item_aktif'] = $jumlah_item_aktif;
			$subrecord['jml_item_nonaktif'] = $jumlah_item_nonaktif;
			$subrecord['aktif'] = $sk->aktif;
			switch ($subrecord['aktif']) {
				case 0:
					$subrecord['simbol_aktif_nonaktif'] = "bg-maroon";
					$subrecord['status'] = "Non Aktif";
					break;
				case 1:
					$subrecord['simbol_aktif_nonaktif'] = "bg-purple";
					$subrecord['status'] = "Aktif";
					break;
			}

			array_push($record, $subrecord);
		}
		$data['subkomponen'] = json_encode($record);

		$this->log_lib->log_inf("Akses sub komponen penilaian");

		$this->load->view('body/head');
		$this->load->view('body/body', $data);
		$this->load->view('komponen/sub_komponen', $data);
		$this->load->view('body/foot');
	}

	public function proses($a = 1, $kode_komponen, $kode = "", $aktif = 0, $nama = "")
	{
		$kd_subkomponen = $kode;
		$nama_subkomponen_awal = $this->input->post('awal');
		$nama_subkomponen = $this->input->post('nama');
		$nilai = $this->input->post('nilai');
		if($this->input->post('kelompok') == 2)
		{
			$maks = $this->input->post('maks');
			$keterangan = html_entity_decode($this->input->post('ket'));
		}
		else{
			$maks = 0;
			$keterangan = "";
		}
		

		$data = array(
			"kd_sub_komponen" => $kd_subkomponen,
			"kd_komponen" => $kode_komponen,
			"nama_sub_komponen" => $nama_subkomponen,
			"nilai" => $nilai,
			"maks" => $maks,
			"ket" => $keterangan
		);

		$data_log = "kd_sub_komponen: " . $kd_subkomponen . ", kd_komponen: " . $kode_komponen . ", nama_sub_komponen: " . $nama_subkomponen . ", nilai: " . $nilai . ", maks: " . $maks;

		$ada_nama_subkomponen = $this->mod_subkomponen->cek_nama($nama_subkomponen);

		switch ($a) {
			case 1:
				if ($ada_nama_subkomponen == 0) {
					$this->mod_subkomponen->simpan($data);
					$pesan = 1;
					$isipesan = "Data sub komponen baru di tambahkan dengan nama sub komponen $nama_subkomponen";
					$log_info = "Menambahkan sub komponen baru ($data_log)";
				} else {
					$pesan = 4;
					$isipesan = "Sub komponen dengan nama $nama_subkomponen sudah terdaftar sebelumnya. Silakan gunakan nama lain";
					$log_info = "Menambahkan sub komponen baru gagal karena nama komponen sudah terdaftar ($data_log)";
				}
				break;
			case 2:
				if ($nama_subkomponen_awal == $nama_subkomponen || $ada_nama_subkomponen == 0) {
					$this->mod_subkomponen->ubah($data);
					$pesan = 2;
					$isipesan = "Data sub komponen denga nama $nama_subkomponen diubah. Silakan di cek kembali perubahannya";
					$log_info = "Merubah sub komponen ($data_log)";
				} else {
					$pesan = 4;
					$isipesan = "Sub komponen dengan nama $nama_subkomponen sudah terdaftar sebelumnya. Silakan gunakan nama lain";
					$log_info = "Merubah sub komponen gagal karena nama komponen sudah terdaftar ($data_log)";
				}
				break;
			case 3:
				$this->mod_subkomponen->hapus($kode);
				$pesan = 3;
				$isipesan = "Sub komponen dengan nama $nama telah dihapus beserta data item penilaiannya dan penilaian yang menggunakan sub komponen tersebut.";
				$log_info = "Menghapus sub komponen dengan nama $nama";
				break;
			case 4:
				if ($aktif == 0) {
					$nilai = 1;
					$text_pesan = "di aktfikan";
				} else {
					$nilai = 0;
					$text_pesan = "di nonaktfikan";
				}
				$this->mod_subkomponen->status($kode, $nilai);
				$pesan = 5;
				$isipesan = "Item penilaian dengan nama $nama telah $text_pesan.";
				$log_info = $isipesan;
				break;
		}

		$this->log_lib->log_inf($log_info);

		redirect("subkomponen/index/$kode_komponen/1/$pesan/$isipesan");
	}
}
