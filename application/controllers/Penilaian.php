<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('stat_log') != "login") {
			redirect(base_url("login"));
		}

		$this->load->model('mod_penilaian');
	}

	public function index($kode_kegiatan = "", $kode_komponen = "", $page = 1, $pesan = "", $isipesan = "")
	{
		$data['komponen'] = $this->mod_penilaian->komponen($kode_komponen)->result();
		$data['subkomponen'] = $this->mod_penilaian->sub_komponen($kode_komponen)->result();
		$data['itempenilaian'] = $this->mod_penilaian->item()->result();
		$data['spek_nilai'] = $this->mod_penilaian->spek_nilai()->result();
		$data['subitem'] = $this->mod_penilaian->sub_item()->result();

		$data['nilaikomp1'] = $this->mod_penilaian->nilaikomp1($kode_kegiatan)->result();
		$data['nilaisub1'] = $this->mod_penilaian->nilaisub1($kode_kegiatan)->result();
		$data['nilaiitem1'] = $this->mod_penilaian->nilaiitem1($kode_kegiatan)->result();
		$data['nilaisubitem1'] = $this->mod_penilaian->nilaisubitem1($kode_kegiatan)->result();

		$data['nilaikomp2'] = $this->mod_penilaian->nilaikomp2($kode_kegiatan)->result();
		$data['nilaisub2'] = $this->mod_penilaian->nilaisub2($kode_kegiatan)->result();
		$data['nilaiitem2'] = $this->mod_penilaian->nilaiitem2($kode_kegiatan)->result();
		$data['nilaisubitem2'] = $this->mod_penilaian->nilaisubitem2($kode_kegiatan)->result();

		$data['daftar_dokumen1'] = $this->mod_penilaian->daftar_dok1($kode_kegiatan)->result();
		$data['daftar_dokumen2'] = $this->mod_penilaian->daftar_dok2($kode_kegiatan)->result();

		$data['aktif_dashboard'] = "";
		$data['aktif_wbbm'] = "active";
		$data['aktif_komponen'] = "";
		$data['aktif_user'] = "";
		$data['aktif_log'] = "";

		$data['email_user'] = $this->session->userdata('email');
		$data['penilaian'] = $this->session->userdata('penilaian');
		$data['setting'] = $this->session->userdata('setting');
		$data['nilai_komponen'] = $this->session->userdata('komponen');

		$data['kd_kegiatan'] = $kode_kegiatan;
		if ($kode_kegiatan != "") {
			$kegiatan = $this->mod_penilaian->cek_kegiatan($kode_kegiatan)->result();

			foreach ($kegiatan as $kg) {
				$data['nama_kegiatan'] = $kg->nama_kegiatan;
			}
		} else {
			$data['nama_kegiatan'] = "";
		}
		$data['kd_komponen'] = $kode_komponen;
		$komponen = $this->mod_penilaian->cek_komponen($kode_komponen)->result();
		foreach ($komponen as $km) {
			$data['kelompok_komponen'] = $km->kelompok;
			$data['nama_komponen'] = $km->nama_komponen;
		};

		$this->log_lib->log_inf("Akses penilaian wbbm untuk kegiatan " . $data['nama_kegiatan']);

		$this->load->view('body/head');
		$this->load->view('body/body', $data);
		$this->load->view('penilaian/penilaian', $data);
		$this->load->view('body/foot');
	}

	public function proses($kelompok)
	{
		$versi = $this->input->post('versi');
		$kd_kegiatan = $this->input->post('kd_kegiatan');
		$kd_komponen = $this->input->post('kd_komponen');
		$kd_sub_komponen = $this->input->post('kd_sub_komponen');
		$kd_item = $this->input->post('kd_item');
		$evaluasi = $this->input->post('evaluasi');
		$model_jawaban = $this->input->post('model_jawaban');

		switch ($model_jawaban) {
			case "1":
				$jawab = $this->input->post('nilai1');
				break;
			case "2":
				$jawab = $this->input->post('nilai2');
				break;
			case "3":
				$jawab = $this->input->post('nilai3');
				break;
		}

		$id = "ip" . $kd_item . "n1";

		if ($kelompok == 1) {
			$cek_nilai = $this->mod_penilaian->cek_nilai($kd_item, $jawab)->result();
			foreach ($cek_nilai as $cn) {
				$nilai = $cn->nilai;
			}
		} else {
			$nilai = $jawab;
		}

		$data = array(
			"versi" => $versi,
			"kd_kegiatan" => $kd_kegiatan,
			"kd_item" => $kd_item,
			"jawab" => $jawab,
			"nilai" => $nilai,
			"evaluasi" => $evaluasi,
			"dokumen" => ""
		);

		$data_log = "versi: " . $versi . ", kd_kegiatan: " . $kd_kegiatan . ", kd_item: " . $kd_item . ", jawab: " . $jawab . ", nilai: " . $nilai . ", evaluasi: " . $evaluasi;

		$this->mod_penilaian->reset_nilai($kd_kegiatan, $kd_item, $versi);
		$this->mod_penilaian->simpan_nilai($data);

		$this->proses_sub_komponen($kd_sub_komponen, $versi, $kd_kegiatan, $kelompok);

		$this->proses_komponen($kd_komponen, $versi, $kd_kegiatan);

		$this->proses_kegiatan($kd_kegiatan);

		$kegiatan = $this->mod_penilaian->cek_kegiatan($kd_kegiatan)->result();
		foreach ($kegiatan as $kg) {
			$nama_kegiatan = $kg->nama_kegiatan;
		}
		$log_info = "Memberikan penilaian untuk kegiatan $nama_kegiatan ($data_log)";
		$this->log_lib->log_inf($log_info);

		redirect("penilaian/index/$kd_kegiatan/$kd_komponen#$id");
	}

	public function proses_sub($kelompok)
	{
		$versi = $this->input->post('versi3');
		$kd_kegiatan = $this->input->post('kd_kegiatan3');
		$kd_komponen = $this->input->post('kd_komponen3');
		$kd_sub_komponen = $this->input->post('kd_sub_komponen3');
		$kd_item = $this->input->post('kd_item3');
		$kd_sub_item = $this->input->post('kd_sub_item');
		$operasi_item = $this->input->post('operasi_item');
		$nilai_sub = $this->input->post('nilai_sub');

		$id = "si" . $kd_sub_item . "si1";

		$data = array(
			"versi" => $versi,
			"kd_kegiatan" => $kd_kegiatan,
			"kd_sub_item" => $kd_sub_item,
			"nilai_sub" => $nilai_sub
		);

		$data_log = "versi: " . $versi . ", kd_kegiatan: " . $kd_kegiatan . ", kd_sub_item: " . $kd_sub_item . ", nilai_sub: " . $nilai_sub;

		$this->mod_penilaian->reset_nilai_sub($kd_kegiatan, $kd_sub_item, $versi);
		$this->mod_penilaian->simpan_nilai_sub($data);

		$nilai_sub_item1 = $this->mod_penilaian->cek_total_sub_item1($kd_item, $versi, $kd_kegiatan)->result();
		foreach ($nilai_sub_item1 as $nsi1) {
			$nilai_sub_item_plus = $nsi1->total;
		}

		$nilai_sub_item2 = $this->mod_penilaian->cek_total_sub_item2($kd_item, $versi, $kd_kegiatan)->result();
		foreach ($nilai_sub_item2 as $nsi2) {
			$nilai_sub_item_minus = $nsi2->total;
		}

		$nilai_sub_item_total = $nilai_sub_item_plus - $nilai_sub_item_minus;

		$sub_item_total = $this->mod_penilaian->sub_item_total($kd_item)->result();
		foreach ($sub_item_total as $sit) {
			$kd_sub_item2 = $sit->kd_sub_item;
		}

		$data2 = array(
			"versi" => $versi,
			"kd_kegiatan" => $kd_kegiatan,
			"kd_sub_item" => $kd_sub_item2,
			"nilai_sub" => $nilai_sub_item_total
		);

		$this->mod_penilaian->reset_nilai_sub($kd_kegiatan, $kd_sub_item2, $versi);
		$this->mod_penilaian->simpan_nilai_sub($data2);


		$jawab = ($nilai_sub_item_total / $nilai_sub_item_plus) * 100;
		$nilai_item = $jawab / 100;

		$data3 = array(
			"versi" => $versi,
			"kd_kegiatan" => $kd_kegiatan,
			"kd_item" => $kd_item,
			"jawab" => $jawab,
			"nilai" => $nilai_item,
			"evaluasi" => "-",
			"dokumen" => ""
		);

		$this->mod_penilaian->reset_nilai($kd_kegiatan, $kd_item, $versi);
		$this->mod_penilaian->simpan_nilai($data3);

		$this->proses_sub_komponen($kd_sub_komponen, $versi, $kd_kegiatan, $kelompok);

		$this->proses_komponen($kd_komponen, $versi, $kd_kegiatan);

		$this->proses_kegiatan($kd_kegiatan);

		$kegiatan = $this->mod_penilaian->cek_kegiatan($kd_kegiatan)->result();
		foreach ($kegiatan as $kg) {
			$nama_kegiatan = $kg->nama_kegiatan;
		}
		$log_info = "Memberikan penilaian untuk kegiatan $nama_kegiatan ($data_log)";
		$this->log_lib->log_inf($log_info);

		redirect("penilaian/index/$kd_kegiatan/$kd_komponen#$id");
	}

	public function upload()
	{
		$versi = $this->input->post('versi2');
		$kd_kegiatan = $this->input->post('kd_kegiatan2');
		$kd_komponen = $this->input->post('kd_komponen2');
		$kd_sub_komponen = $this->input->post('kd_sub_komponen2');
		$kd_item = $this->input->post('kd_item2');
		$namadok = $this->input->post('namadok');
		$deskdok = $this->input->post('deskdok');

		$id = "ip" . $kd_item . "n1";

		$daftar_dok = "";
		$cek_file = $this->mod_penilaian->cek_file($kd_item, $versi, $namadok);
		$cek_upload = $this->mod_penilaian->cek_upload($kd_item, $versi);

		//foreach ($cek_file as $cf) {
		//	$daftar_dok = $cf->dokumen;
		//}

		//$urutan = substr_count($daftar_dok, ",");

		$urutan = $cek_upload;

		if ($cek_file != 0) {
			$dokumen = $namadok . " (" . date('dmYhis') . ")";
		} else {
			$dokumen = $namadok;
		}

		$nama_file = $kd_kegiatan . "_" . $kd_item . "_" . $versi . "_" . ($urutan + 10);

		$hasil = $this->do_upload($nama_file);
		if ($hasil != false) {
			$jml_hasil = count($hasil);
			//echo $jml_hasil;
			//echo "<br>";
			//echo print_r($hasil);
			//echo "<br>";
			//echo $urutan;
			extract($hasil);
			//if ($urutan == 0) {
			//	$daftar_dok = $file_name . ",";
			//} else {
			//	$daftar_dok .= $file_name . ",";
			//}

			$daftar_dok = $file_name;

			$this->mod_penilaian->dokumen($versi, $kd_item, $daftar_dok, $dokumen, $deskdok);
		}

		redirect("penilaian/index/$kd_kegiatan/$kd_komponen#$id");
	}

	public function proses_sub_komponen($kode, $versi, $kd_kegiatan, $kelompok)
	{
		if ($kelompok == 1) {
			//jumlah item penilaian dari sub komponen
			$jml_item = $this->mod_penilaian->cek_jml_item($kode);

			//total item penilaian
			$cek_total = $this->mod_penilaian->cek_total_item($kode, $versi, $kd_kegiatan)->result();
			foreach ($cek_total as $ct) {
				$total = $ct->total;
			}
		} else {
			$jml_item = 0;

			//total item penilaian
			$cek_total = $this->mod_penilaian->cek_total_item2($kode, $versi, $kd_kegiatan)->result();
			foreach ($cek_total as $ct) {
				$total = $ct->total;
			}
		}

		//nilai standart sub komponen
		$cek_subkomp = $this->mod_penilaian->cek_subkomp($kode)->result();
		foreach ($cek_subkomp as $csk) {
			$nilai_std = $csk->nilai_std;
			$nilai_maks = $csk->nilai_maks;
		}

		if ($kelompok == 1) {
			$nilai_subkomp = ($total / $jml_item) * $nilai_std;
		} else {
			$nilai_subkomp = ($total / $nilai_maks) * $nilai_std;
		}

		$persen = ($nilai_subkomp / $nilai_std) * 100;

		$data = array(
			"versi" => $versi,
			"kd_kegiatan" => $kd_kegiatan,
			"kd_sub" => $kode,
			"nilai" => $nilai_subkomp,
			"persen" => $persen
		);

		$this->mod_penilaian->reset_nilai_subkomp($kd_kegiatan, $kode, $versi);
		$this->mod_penilaian->simpan_nilai_subkomp($data);

		echo print_r($data);
		echo "<br>";
		echo $total;
	}

	public function proses_komponen($kode, $versi, $kd_kegiatan)
	{
		//total sub komponen
		$cek_total = $this->mod_penilaian->cek_total_sub($kode, $versi, $kd_kegiatan)->result();
		foreach ($cek_total as $ct) {
			$total = $ct->total;
		}

		//nilai standart sub komponen
		$cek_subkomp = $this->mod_penilaian->cek_komp($kode)->result();
		foreach ($cek_subkomp as $csk) {
			$nilai_std = $csk->nilai_std;
		}

		$persen = ($total / $nilai_std) * 100;

		$data = array(
			"versi" => $versi,
			"kd_kegiatan" => $kd_kegiatan,
			"kd_komponen" => $kode,
			"nilai" => $total,
			"persen" => $persen
		);

		$this->mod_penilaian->reset_nilai_komp($kd_kegiatan, $kode, $versi);
		$this->mod_penilaian->simpan_nilai_komp($data);
	}

	public function proses_kegiatan($kode)
	{
		//total kegiatan versi self assesment
		$cek_total1 = $this->mod_penilaian->cek_total_kegiatan1($kode)->result();
		foreach ($cek_total1 as $ct1) {
			$total1 = $ct1->total;
		}

		//total kegiatan versi surveyor
		$cek_total2 = $this->mod_penilaian->cek_total_kegiatan2($kode)->result();
		foreach ($cek_total2 as $ct2) {
			$total2 = $ct2->total;
		}

		$data = array(
			"kd_kegiatan" => $kode,
			"total_sa" => $total1,
			"total_sy" => $total2
		);

		$this->mod_penilaian->simpan_nilai_kegiatan($data);
	}

	public function do_upload($nama)
	{
		$config['upload_path']		= './upload/';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf';
		$config['file_name']		= $nama;
		$config['overwrite']		= true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('dokumen')) {
			//$error = $this->upload->display_errors();
			$error = "";
			//$this->load->view('upload_form', $error);
			return false;
		} else {
			$data = $this->upload->data();

			//$this->load->view('upload_success', $data);
			return $data;
		}
	}

	public function hapus($versi, $kode_kegiatan, $kode_komponen, $kode_item, $kode_sub, $kelompok)
	{
		$this->mod_penilaian->reset_nilai($kode_kegiatan, $kode_item, $versi);

		$id = "ip" . $kode_item . "n1";

		$this->proses_sub_komponen($kode_sub, $versi, $kode_kegiatan, $kelompok);

		$this->proses_komponen($kode_komponen, $versi, $kode_kegiatan);

		$this->proses_kegiatan($kode_kegiatan);

		redirect("penilaian/index/$kode_kegiatan/$kode_komponen#$id");
	}

	public function hapus_sub_item($versi, $kode_kegiatan, $kode_komponen, $kode_sub_komponen, $kode_item, $kode_sub_item, $kelompok)
	{
		$id = "si" . $kode_sub_item . "si1";

		$this->mod_penilaian->reset_nilai_sub($kode_kegiatan, $kode_sub_item, $versi);

		$nilai_sub_item1 = $this->mod_penilaian->cek_total_sub_item1($kode_item, $versi, $kode_kegiatan)->result();
		foreach ($nilai_sub_item1 as $nsi1) {
			$nilai_sub_item_plus = $nsi1->total;
		}

		$nilai_sub_item2 = $this->mod_penilaian->cek_total_sub_item2($kode_item, $versi, $kode_kegiatan)->result();
		foreach ($nilai_sub_item2 as $nsi2) {
			$nilai_sub_item_minus = $nsi2->total;
		}

		if ($nilai_sub_item_plus == 0) {
			$nilai_sub_item_total = 0;
		} else {
			$nilai_sub_item_total = $nilai_sub_item_plus - $nilai_sub_item_minus;
		}


		$sub_item_total = $this->mod_penilaian->sub_item_total($kode_item)->result();
		foreach ($sub_item_total as $sit) {
			$kd_sub_item2 = $sit->kd_sub_item;
		}

		$data2 = array(
			"versi" => $versi,
			"kd_kegiatan" => $kode_kegiatan,
			"kd_sub_item" => $kd_sub_item2,
			"nilai_sub" => $nilai_sub_item_total
		);

		$this->mod_penilaian->reset_nilai_sub($kode_kegiatan, $kd_sub_item2, $versi);
		$this->mod_penilaian->simpan_nilai_sub($data2);

		if ($nilai_sub_item_total == 0) {
			$jawab = 0;
			$nilai_item = 0;
		} else {
			$jawab = ($nilai_sub_item_total / $nilai_sub_item_plus) * 100;
			$nilai_item = $jawab / 100;
		}

		if ($nilai_item == 0) {
			$this->mod_penilaian->reset_nilai($kode_kegiatan, $kode_item, $versi);
		} else {
			$data3 = array(
				"versi" => $versi,
				"kd_kegiatan" => $kode_kegiatan,
				"kd_item" => $kode_item,
				"jawab" => $jawab,
				"nilai" => $nilai_item,
				"evaluasi" => "-",
				"dokumen" => ""
			);

			$this->mod_penilaian->reset_nilai($kode_kegiatan, $kode_item, $versi);
			$this->mod_penilaian->simpan_nilai($data3);
		}

		$this->proses_sub_komponen($kode_sub_komponen, $versi, $kode_kegiatan, $kelompok);

		$this->proses_komponen($kode_komponen, $versi, $kode_kegiatan);

		$this->proses_kegiatan($kode_komponen);

		redirect("penilaian/index/$kode_kegiatan/$kode_komponen#$id");
	}

	public function hapus_dok($kode_kegiatan, $kode_komponen, $kode_item, $kode_dokumen, $dok)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . "/wbbm/upload/";

		unlink($path . $dok);

		//$cek_file = $this->mod_penilaian->cek_file($kode_kegiatan, $kode_item, $versi)->result();
		//foreach ($cek_file as $cf) {
		//	$daftar_dok = $cf->dokumen;
		//}

		//$nama_file = $dok . ",";
		//$daftar_dok_baru = str_replace($nama_file, "", $daftar_dok);

		//$this->mod_penilaian->reset_dok($daftar_dok_baru, $kode_kegiatan, $kode_item, $versi);

		$id = "ip" . $kode_item . "n1";

		$this->mod_penilaian->hapus_dok($kode_dokumen);

		redirect("penilaian/index/$kode_kegiatan/$kode_komponen#$id");
	}
}
