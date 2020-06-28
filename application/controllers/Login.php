<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function pesan($pesan = "", $isipesan = "")
	{
		//pesan proses
		$datapesan['kode_pesan'] = $pesan;
		$datapesan['isipesan'] = $isipesan;
		$datapesan['judulmsg'] = "";
		switch ($pesan) {
			case "1":
				$datapesan['judulmsg'] = "Password Anda salah";
				break;
			case "2":
				$datapesan['judulmsg'] = "User tidak terdaftar";
				break;
		}

		return $datapesan;
	}

	public function index($pesan = "", $isipesan = "")
	{
		$data['pesan'] = $this->pesan($pesan, $isipesan);

		$this->load->view('login/login', $data);
	}

	public function proses()
	{
		//$tgl_sekarang = date('Y-m-d');
		//$tgl_expired = date('Y-m-d',strtotime("2019-12-31"));

		//if($tgl_sekarang != $tgl_expired)
		//{
		$this->load->model('mod_login');

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$ada_username = $this->mod_login->cek_username($username);

		$ada_password = $this->mod_login->cek_password($username, $password);

		if ($ada_username > 0 && $ada_password > 0) {
			$data_user = $this->mod_login->ambil($username)->result();

			foreach ($data_user as $du) {
				$user = array(
					"kode_user" => $du->kd_user,
					"email" => $du->email,
					"penilaian" => $du->jawab,
					"setting" => $du->setting,
					"komponen" => $du->komponen,
					"stat_log" => "login"
				);
			}

			$this->session->set_userdata($user);

			redirect("dashboard");
		} else {
			if ($ada_username ==  0) {
				$pesan = "2";
				$isipesan = "Email yang Anda masukkan tidak terdaftar";
			}
			if ($ada_username >  0 && $ada_password == 0) {
				$pesan = "1";
				$isipesan = "Password Anda Salah, coba kembali";
			}
			redirect("login/index/$pesan/$isipesan");
		}
		//}
		//else 
		//{
		//	$pesan="2"; 
		//	$isipesan="Masa trial berakhir, silakan kontak kami";
		//	redirect("login/index/$pesan/$isipesan");
		//}

	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("login");
	}
}
