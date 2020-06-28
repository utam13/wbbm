<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Itempenilaian extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('stat_log') != "login") {
			redirect(base_url("login"));
		}

		$this->load->model('mod_itempenilaian');
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
				$datapesan['judulmsg'] = "Penambahan Data Item Penilaian";
				$datapesan['jenisbox'] = "callout-success";
				break;
			case "2":
				$datapesan['judulmsg'] = "Perubahan Data Item Penilaian";
				$datapesan['jenisbox'] = "callout-info";
				break;
			case "3":
				$datapesan['judulmsg'] = "Penghapusan Data Item Penilaian";
				$datapesan['jenisbox'] = "callout-warning";
				break;
			case "4":
				$datapesan['judulmsg'] = "Duplikasi Nama Item Penilaian";
				$datapesan['jenisbox'] = "callout-danger";
				break;
			case "5":
				$datapesan['judulmsg'] = "Perubahan Status Item Penilaian";
				$datapesan['jenisbox'] = "callout-warning";
				break;
		}

		return $datapesan;
	}

	public function index($kode_komponen, $kode_subkomponen, $page = 1, $pesan = "", $isipesan = "")
	{
		//cari
		$cari = $this->input->post('cari');
		if ($cari != "") {
			$q_cari = "kd_sub_komponen='$kode_subkomponen' and nama_item like '%$cari%'";
		} else {
			$q_cari = "kd_sub_komponen='$kode_subkomponen'";
		}

		$data['pesan'] = $this->pesan($pesan, $isipesan);

		//pagination
		$jumlah_data = $this->mod_itempenilaian->jumlah_data($q_cari);

		$limit = 10;
		$limit_start = ($page - 1) * $limit;

		$itempenilaian = $this->mod_itempenilaian->daftar($limit_start, $limit, $q_cari)->result();

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
		$komponen = $this->mod_itempenilaian->cek_komponen($kode_komponen)->result();
		foreach ($komponen as $km) {
			$data['kelompok_komponen'] = $km->kelompok;
			$data['nama_komponen'] = $km->nama_komponen;
		}

		$data['kd_sub_komponen'] = $kode_subkomponen;
		$subkomponen = $this->mod_itempenilaian->cek_subkomponen($kode_subkomponen)->result();
		if (count($subkomponen) > 0) {
			foreach ($subkomponen as $sk) {
				$nama_sub_komponen = $sk->nama_sub_komponen;
				if (strlen($sk->nama_sub_komponen) > 50) {
					$data['nama_sub_komponen'] = substr($sk->nama_sub_komponen, 0, 50) . "...";
				} else {
					$data['nama_sub_komponen'] = $sk->nama_sub_komponen;
				}
			}
		} else {
			$data['nama_sub_komponen'] = $data['nama_komponen'];
		}


		$record = array();
		$subrecord = array();
		foreach ($itempenilaian as $ip) {
			$subrecord['nilai'] = "";
			$set_nilai = $this->mod_itempenilaian->set_nilai($ip->kd_item_penilaian)->result();
			if (count($set_nilai) > 0) {
				$subrecord['nilai'] = "(";
				foreach ($set_nilai as $sn) {
					$subrecord['nilai'] .= $sn->nama_nilai . " = " . round($sn->nilai, 2) . ", ";
				}
				$subrecord['nilai'] .= ")";
			}

			$subrecord['kd_item_penilaian'] = $ip->kd_item_penilaian;
			$subrecord['nama_item'] = $ip->nama_item;
			$subrecord['model_jawaban'] = $ip->model_jawaban;
			$subrecord['keterangan'] = $ip->keterangan;

			switch ($ip->model_jawaban) {
				case 1:
					$subrecord['nama_model'] = "Ya/Tidak";
					break;
				case 2:
					$subrecord['nama_model'] = "Abjad";
					break;
				case 3:
					$subrecord['nama_model'] = "Angka";
					break;
				case 4:
					$subrecord['nama_model'] = "Sub Item";
					break;
			}

			$subrecord['aktif'] = $ip->aktif;
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
		$data['itempenilaian'] = json_encode($record);

		$this->log_lib->log_inf("Akses item penilaian");

		$this->load->view('body/head');
		$this->load->view('body/body', $data);
		$this->load->view('komponen/item_penilaian', $data);
		$this->load->view('body/foot');
	}

	public function proses($a = 1, $kode_komponen, $kode_subkomponen, $kode = "", $aktif = 0, $nama = "")
	{
		$kd_item_penilaian = $kode;
		$nama_item_awal = $this->input->post('awal');
		$nama_item = preg_replace("~[\r\n]+~", " ", $this->input->post('nama'));
		$model_jawaban = $this->input->post('model');
		$keterangan = html_entity_decode($this->input->post('ket'));

		$data = array(
			"kd_item_penilaian" => $kd_item_penilaian,
			"kd_sub_komponen" => $kode_subkomponen,
			"nama_item" => $nama_item,
			"model_jawaban" => $model_jawaban,
			"keterangan" => $keterangan
		);

		$data_log = "kd_item_penilaian: " . $kd_item_penilaian . ", kd_sub_komponen: " . $kode_subkomponen . ", nama_item: " . $nama_item
			. ", model_jawaban: " . $model_jawaban . ", keterangan: " . $keterangan;

		$ada_item = $this->mod_itempenilaian->cek_nama($nama_item);

		switch ($a) {
			case 1:
				if ($ada_item == 0) {
					$this->mod_itempenilaian->simpan($data);

					$cek_kode_item = $this->mod_itempenilaian->cek_kodeitem($nama_item)->result();
					foreach ($cek_kode_item as $cki) {
						$kd_item_penilaian = $cki->kd_item_penilaian;
					}

					switch ($model_jawaban) {
						case 1:
							$this->mod_itempenilaian->jawaban($kd_item_penilaian, "Ya", 0);
							$this->mod_itempenilaian->jawaban($kd_item_penilaian, "Tidak", 0);
							break;
						case 2:
							$this->mod_itempenilaian->jawaban($kd_item_penilaian, "A", 0);
							$this->mod_itempenilaian->jawaban($kd_item_penilaian, "B", 0);
							$this->mod_itempenilaian->jawaban($kd_item_penilaian, "C", 0);
							break;
					}
					$pesan = 1;
					$isipesan = "Data item penilaian baru di tambahkan dengan uraian item penilaian $nama_item";
					$log_info = "Menambahkan item penilaian baru ($data_log)";
				} else {
					$pesan = 4;
					$isipesan = "Item penilaian dengan uraian $nama_item sudah terdaftar sebelumnya. Silakan gunakan uraian lain";
					$log_info = "Menambahkan item penilaian gagal karena nama item sudah terdaftar ($data_log)";
				}
				break;
			case 2:
				if ($nama_item_awal == $nama_item || $ada_item == 0) {
					$this->mod_itempenilaian->ubah($data);
					$pesan = 2;
					$isipesan = "Data item penilaian dengan uraian $nama_item diubah. Silakan di cek kembali perubahannya";
					$log_info = "Merubah item penilaian ($data_log)";
				} else {
					$pesan = 4;
					$isipesan = "Item penilaian dengan uraian $nama_item sudah terdaftar sebelumnya. Silakan gunakan uraian lain";
					$log_info = "Merubah item penilaian gagal karena nama item sudah terdaftar ($data_log)";
				}
				break;
			case 3:
				$this->mod_itempenilaian->hapus($kode);
				$pesan = 3;
				$isipesan = "Item penilaian dengan uraian $nama telah dihapus dan penilaian yang menggunakan item penilaian tersebut.";
				$log_info = "Menghapus item penilaian dengan uraian $nama";
				break;
			case 4:
				if ($aktif == 0) {
					$nilai = 1;
					$text_pesan = "di aktfikan";
				} else {
					$nilai = 0;
					$text_pesan = "di nonaktfikan";
				}
				$this->mod_itempenilaian->status($kode, $nilai);
				$pesan = 5;
				$isipesan = "Item penilaian dengan uraian $nama telah $text_pesan.";
				$log_info = $isipesan;
				break;
		}

		$this->log_lib->log_inf($log_info);

		redirect("itempenilaian/index/$kode_komponen/$kode_subkomponen/1/$pesan/$isipesan");
	}
}
