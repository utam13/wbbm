<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('stat_log') != "login") {
			redirect(base_url("login"));
		}

		$this->load->model('mod_dashboard');
	}

	public function index()
	{
		//$this->mod_dashboard->delkosong();

		//cari
		$kegiatan = $this->input->post('kegiatan');
		$versi = $this->input->post('versi');

		$data['kegiatan'] = $this->mod_dashboard->daftar_kegiatan()->result();

		//kegiatan terakhir
		if ($kegiatan == "") {
			$kegiatan_terakhir = $this->mod_dashboard->kegiatan_terakhir()->result();
			foreach ($kegiatan_terakhir as $kt) {
				$kode_kegiatan = $kt->kd_kegiatan;
				$data['nama_kegiatan'] = $kt->nama_kegiatan;
				$data['dari'] = $kt->dari;
				$data['sampai'] = $kt->sampai;
			}
		} else {
			$data_kegiatan = $this->mod_dashboard->kegiatan($kegiatan, $versi)->result();

			$kode_kegiatan = $kegiatan;
			foreach ($data_kegiatan as $dt) {
				$data['nama_kegiatan'] = $dt->nama_kegiatan;
				$data['dari'] = $dt->dari;
				$data['sampai'] = $dt->sampai;
			}
		}

		$data['kode_kegiatan'] = $kode_kegiatan;

		switch ($versi) {
			case "":
			case 1:
				$vs = 1;
				$data['versi'] = "Self Assement";
				break;
			case 2:
				$vs = 2;
				$data['versi'] = "Surveyor";
				break;
		}

		//daftar komponen
		$komponen = $this->mod_dashboard->komponen()->result();

		//jumlah komponen proses
		$data['jumlah_proses'] = $this->mod_dashboard->jumlah_proses();

		//jumlah komponen hasil
		$data['jumlah_hasil'] = $this->mod_dashboard->jumlah_hasil();

		//komponen dengan nilai dari kegiatan terakhir
		$total_nilai_proses = 0;
		$total_nilai_hasil = 0;

		$record_kp = array();
		$subrecord_kp = array();
		$record_kh = array();
		$subrecord_kh = array();
		foreach ($komponen as $k) {
			if ($k->kelompok == 1) {
				$subrecord_kp['kd_komponen'] = $k->kd_komponen;
				$subrecord_kp['nama_komponen'] = $k->nama_komponen;

				$ada_nilai_kp = $this->mod_dashboard->cek_nilai_komponen($kode_kegiatan, $vs, $k->kd_komponen);
				if ($ada_nilai_kp == 0) {
					$subrecord_kp['persen'] = 0;
				} else {
					$persen_kp = $this->mod_dashboard->nilai_komponen($kode_kegiatan, $vs, $k->kd_komponen)->result();
					foreach ($persen_kp as $pkp) {
						$subrecord_kp['persen'] = $pkp->persen;
						$total_nilai_proses += $pkp->nilai;
					}
				}

				array_push($record_kp, $subrecord_kp);
			} else {
				$subrecord_kh['kd_komponen'] = $k->kd_komponen;
				$subrecord_kh['nama_komponen'] = $k->nama_komponen;

				$ada_nilai_kh = $this->mod_dashboard->cek_nilai_komponen($kode_kegiatan, $vs, $k->kd_komponen);
				if ($ada_nilai_kh == 0) {
					$subrecord_kh['persen'] = 0;
				} else {
					$persen_kh = $this->mod_dashboard->nilai_komponen($kode_kegiatan, $vs, $k->kd_komponen)->result();
					foreach ($persen_kh as $pkh) {
						$subrecord_kh['persen'] = $pkh->persen;
						$total_nilai_hasil += $pkh->nilai;
					}
				}

				array_push($record_kh, $subrecord_kh);
			}
		}
		$data['komponen_proses'] = json_encode($record_kp);
		$data['komponen_hasil'] = json_encode($record_kh);

		$data['total_nilai_proses'] = $total_nilai_proses;
		$data['total_nilai_hasil'] = $total_nilai_hasil;
		$data['total_keseluruhan'] =  $total_nilai_proses + $total_nilai_hasil;

		$total_nilai_std1 =  $this->mod_dashboard->total_nilai_std(1)->result();
		foreach ($total_nilai_std1 as $tns1) {
			$data['total_nilai_std_proses'] = $tns1->total;
		}

		$total_nilai_std2 =  $this->mod_dashboard->total_nilai_std(2)->result();
		foreach ($total_nilai_std2 as $tns2) {
			$data['total_nilai_std_hasil'] = $tns2->total;
		}

		$data['total_persen_nilai_proses'] = ($data['total_nilai_proses'] / $data['total_nilai_std_proses']) * 100;
		$data['total_persen_nilai_hasil'] = ($data['total_nilai_hasil'] / $data['total_nilai_std_hasil']) * 100;

		//total komponen
		/*
		$total = $this->mod_dashboard->total($kode_kegiatan, $vs)->result();
		foreach ($total as $t) {
			//total keseluruhan
			$data['total_keseluruhan'] = $t->total;
		}
		*/

		$data['aktif_dashboard'] = "active";
		$data['aktif_wbbm'] = "";
		$data['aktif_komponen'] = "";
		$data['aktif_user'] = "";
		$data['aktif_log'] = "";

		$data['email_user'] = $this->session->userdata('email');
		$data['setting'] = $this->session->userdata('setting');

		$this->log_lib->log_inf("Akses dashboard");

		$this->load->view('body/head');
		$this->load->view('body/body', $data);
		$this->load->view('body/content');
		$this->load->view('body/foot');
	}
}
