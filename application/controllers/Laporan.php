<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('stat_log') != "login") {
			redirect(base_url("login"));
		}

		$this->load->model('mod_laporan');
	}

	public function proses($kode)
	{
		$bentuk = $this->input->post('bentuk');
		$penilaian = $this->input->post('nilai');

		switch ($bentuk) {
			case "1":
				$this->chart($kode, $penilaian);
				break;
			case "2":
				$this->tabel($kode, $penilaian, $bentuk);
				break;
			case "3":
				$this->tabel($kode, $penilaian, $bentuk);
				break;
		}
	}

	public function chart($kode, $penilaian)
	{
		$kegiatan = $this->mod_laporan->kegiatan($kode)->result();
		foreach ($kegiatan as $k) {
			$data['nama_kegiatan'] = $k->nama_kegiatan;
			$data['dari'] = $k->dari;
			$data['sampai'] = $k->sampai;
		}

		//daftar komponen
		$komponen = $this->mod_laporan->komponen()->result();

		//komponen dengan nilai dari kegiatan terakhir
		$record = array();
		$subrecord = array();
		foreach ($komponen as $k) {
			$subrecord['nama_komponen'] = $k->nama_komponen;

			$ada_nilai_kp = $this->mod_laporan->cek_nilai_komponen($kode, 1, $k->kd_komponen);
			if ($ada_nilai_kp == 0) {
				$subrecord['persen_sa'] = 0;
			} else {
				$persen_kp = $this->mod_laporan->nilai_komponen($kode, 1, $k->kd_komponen)->result();
				foreach ($persen_kp as $pkp) {
					$subrecord['persen_sa'] = $pkp->persen;
					break;
				}
			}

			$ada_nilai_kp2 = $this->mod_laporan->cek_nilai_komponen($kode, 2, $k->kd_komponen);
			if ($ada_nilai_kp2 == 0) {
				$subrecord['persen_sy'] = 0;
			} else {
				$persen_kp2 = $this->mod_laporan->nilai_komponen($kode, 2, $k->kd_komponen)->result();
				foreach ($persen_kp2 as $pkp2) {
					$subrecord['persen_sy'] = $pkp2->persen;
				}
			}

			array_push($record, $subrecord);
		}
		$data['komponen'] = json_encode($record);

		$data['laporan'] = "Laporan Kegiatan WBBM";

		$data['penilaian'] = $penilaian;
		switch ($penilaian) {
			case 0:
				$data['nama_penilaian'] = "Self Assesment & Surveyor";
				break;
			case 1:
				$data['nama_penilaian'] = "Self Assesment";
				break;
			case 2:
				$data['nama_penilaian'] = "Surveyor";
				break;
		}


		$this->log_lib->log_inf("Membuat laporan kegiatan wbbm chart untuk kegiatan " . $data['nama_kegiatan'] . " (" . date('m-d-Y', strtotime($data['dari'])) . " sampai " . date('m-d-Y', strtotime($data['sampai'])) . ")");

		$this->load->view('laporan/chart', $data);
	}

	public function tabel($kode, $penilaian, $bentuk)
	{
		$data['kd_kegiatan'] = $kode;
		$data['bentuk'] = $bentuk;

		$data['penilaian'] = $penilaian;
		switch ($penilaian) {
			case 0:
				$data['nama_penilaian'] = "Self Assesment & Surveyor";
				break;
			case 1:
				$data['nama_penilaian'] = "Self Assesment";
				break;
			case 2:
				$data['nama_penilaian'] = "Surveyor";
				break;
		}

		$kegiatan = $this->mod_laporan->kegiatan($kode)->result();
		foreach ($kegiatan as $k) {
			$data['nama_kegiatan'] = $k->nama_kegiatan;
			$data['dari'] = $k->dari;
			$data['sampai'] = $k->sampai;
		}

		$data['komponen1'] = $this->mod_laporan->komponen2(1)->result();
		$data['komponen2'] = $this->mod_laporan->komponen2(2)->result();
		$data['subkomponen'] = $this->mod_laporan->sub_komponen()->result();
		$data['itempenilaian'] = $this->mod_laporan->item()->result();
		$data['spek_nilai'] = $this->mod_laporan->spek_nilai()->result();
		$data['subitem'] = $this->mod_laporan->sub_item()->result();

		$data['nilaikomp1'] = $this->mod_laporan->nilaikomp1($kode)->result();
		$data['nilaisub1'] = $this->mod_laporan->nilaisub1($kode)->result();
		$data['nilaiitem1'] = $this->mod_laporan->nilaiitem1($kode)->result();
		$data['nilaisubitem1'] = $this->mod_laporan->nilaisubitem1($kode)->result();

		$data['nilaikomp2'] = $this->mod_laporan->nilaikomp2($kode)->result();
		$data['nilaisub2'] = $this->mod_laporan->nilaisub2($kode)->result();
		$data['nilaiitem2'] = $this->mod_laporan->nilaiitem2($kode)->result();
		$data['nilaisubitem2'] = $this->mod_laporan->nilaisubitem2($kode)->result();

		$total_nilai_std1 =  $this->mod_laporan->total_nilai_std(1)->result();
		foreach ($total_nilai_std1 as $tns1) {
			$data['total_nilai_std_proses'] = $tns1->total;
		}

		$total_nilai_std2 =  $this->mod_laporan->total_nilai_std(2)->result();
		foreach ($total_nilai_std2 as $tns2) {
			$data['total_nilai_std_hasil'] = $tns2->total;
		}

		$total_nilai_komponen_proses1 =  $this->mod_laporan->total_nilai_komponen($kode, 1, 1)->result();
		foreach ($total_nilai_komponen_proses1 as $tnkp1) {
			$data['total_nilai_komp_proses1'] = $tnkp1->total;
		}

		$total_nilai_komponen_proses2 =  $this->mod_laporan->total_nilai_komponen($kode, 2, 1)->result();
		foreach ($total_nilai_komponen_proses2 as $tnkp2) {
			$data['total_nilai_komp_proses2'] = $tnkp2->total;
		}

		$total_nilai_komponen_hasil1 =  $this->mod_laporan->total_nilai_komponen($kode, 1, 2)->result();
		foreach ($total_nilai_komponen_hasil1 as $tnkh1) {
			$data['total_nilai_komp_hasil1'] = $tnkh1->total;
		}

		$total_nilai_komponen_hasil2 =  $this->mod_laporan->total_nilai_komponen($kode, 2, 2)->result();
		foreach ($total_nilai_komponen_hasil2 as $tnkh2) {
			$data['total_nilai_komp_hasil2'] = $tnkh2->total;
		}


		$data['total_persen_proses1'] = 0;
		$data['total_persen_proses2'] = 0;
		if ($data['total_nilai_std_proses'] != 0) {
			$data['total_persen_proses1'] = ($data['total_nilai_komp_proses1'] / $data['total_nilai_std_proses']) * 100;
			$data['total_persen_proses2'] = ($data['total_nilai_komp_proses2'] / $data['total_nilai_std_proses']) * 100;
		}

		$data['total_persen_hasil1'] = 0;
		$data['total_persen_hasil2'] = 0;
		if ($data['total_nilai_std_hasil'] != 0) {
			$data['total_persen_hasil1'] = ($data['total_nilai_komp_hasil1'] / $data['total_nilai_std_hasil']) * 100;
			$data['total_persen_hasil2'] = ($data['total_nilai_komp_hasil2'] / $data['total_nilai_std_hasil']) * 100;
		}

		$data['grand_total_nilai1'] = $data['total_nilai_komp_proses1'] + $data['total_nilai_komp_hasil1'];
		$data['grand_total_nilai2'] = $data['total_nilai_komp_proses2'] + $data['total_nilai_komp_hasil2'];

		$data['laporan'] = "Laporan Kegiatan WBBM";

		$this->log_lib->log_inf("Membuat laporan kegiatan wbbm tabel untuk kegiatan " . $data['nama_kegiatan'] . " (" . date('m-d-Y', strtotime($data['dari'])) . " sampai " . date('m-d-Y', strtotime($data['sampai'])) . ")");

		$this->load->view('laporan/tabel', $data);
	}
}
