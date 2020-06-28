<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan_nilai extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('stat_log') != "login") {
			redirect(base_url("login"));
		}

		$this->load->model('mod_kegiatan_nilai');
	}

	public function index($kode = "", $page = 1)
	{
		$data['kode'] = $kode;
		$data['kd_kegiatan'] = $kode;

		//pagination
		$jumlah_data = $this->mod_kegiatan_nilai->jumlah_data($kode);

		$limit = 10;
		$limit_start = ($page - 1) * $limit;

		$komponen = $this->mod_kegiatan_nilai->daftar($limit_start, $limit)->result();

		$data['page'] = $page;
		$data['limit'] = $limit;
		$data['get_jumlah'] = $jumlah_data;
		$data['jumlah_page'] = ceil($jumlah_data / $limit);
		$data['jumlah_number'] = 3;
		$data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
		$data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

		$data['no'] = $limit_start + 1;
		//end

		$record = array();
		$subrecord = array();
		foreach ($komponen as $k) {
			$nilai_sa = $this->mod_kegiatan_nilai->cek_nilai_sa($k->kd_komponen, $kode)->result();
			$nilai_sy = $this->mod_kegiatan_nilai->cek_nilai_sy($k->kd_komponen, $kode)->result();
			$persen_sa = $this->mod_kegiatan_nilai->cek_persen_sa($k->kd_komponen, $kode)->result();
			$persen_sy = $this->mod_kegiatan_nilai->cek_persen_sy($k->kd_komponen, $kode)->result();

			$subrecord['nama_komponen'] = $k->nama_komponen;
			$subrecord['kd_komponen'] = $k->kd_komponen;
			$subrecord['kd_kegiatan'] = $kode;

			$subrecord['nilai_sa'] = 0;
			foreach ($nilai_sa as $nsa) {
				$subrecord['nilai_sa'] = $nsa->nilai;
			}

			$subrecord['nilai_sy'] = 0;
			foreach ($nilai_sy as $nsy) {
				$subrecord['nilai_sy'] = $nsy->nilai;
			}

			$subrecord['persen_sa'] = 0;
			foreach ($persen_sa as $psa) {
				$subrecord['persen_sa'] = $psa->persen;
			}

			$subrecord['persen_sy'] = 0;
			foreach ($persen_sy as $psy) {
				$subrecord['persen_sy'] = $psy->persen;
			}

			array_push($record, $subrecord);
		}
		$data['komponen'] = json_encode($record);

		$data['aktif_dashboard'] = "";
		$data['aktif_wbbm'] = "active";
		$data['aktif_komponen'] = "";
		$data['aktif_user'] = "";
		$data['aktif_log'] = "";

		$data['email_user'] = $this->session->userdata('email');
		$data['setting'] = $this->session->userdata('setting');

		$this->log_lib->log_inf("Akses komponen penilaian");

		$this->load->view('body/head');
		$this->load->view('body/body', $data);
		$this->load->view('penilaian/komponen', $data);
		$this->load->view('body/foot');
	}
}
