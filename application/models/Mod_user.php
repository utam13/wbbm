<?
class mod_user extends CI_Model
{
	public function daftar($start = 0 ,$end = 10, $q_cari)
	{
		return $this->db->query("select * from wbbm.wbbm.users where $q_cari order by kd_user ASC OFFSET $start ROWS FETCH NEXT $end ROWS ONLY");
	}

	public function jumlah_data($q_cari = "")
	{
		return $this->db->query("select * from wbbm.wbbm.users where $q_cari")->num_rows();
	}
	
	public function komponen()
	{
		return $this->db->query("select * from wbbm.wbbm.komponen");
	}
	
	public function cek_komponen($kode)
	{
		return $this->db->query("select nama_komponen from wbbm.wbbm.komponen where kd_komponen='$kode'");
	}
	
	public function cek_email($email)
	{
		return $this->db->query("select * from wbbm.wbbm.users where email='$email'")->num_rows();
	}

	public function cek_user($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.users where kd_user='$kode'");
	}

	public function cek_user2($email,$password)
	{
		return $this->db->query("select * from wbbm.wbbm.users where email='$email' and password='$password'")->num_rows();
	}
	
	public function simpan($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.users(email,password,jawab,setting,komponen) values('$email','$password','$daftar_penilaian','$daftar_setting','$daftar_komponen')");
	}
	
	public function ubah($data)
	{
		extract($data);
		$this->db->query("update wbbm.wbbm.users set email='$email',password='$password',jawab='$daftar_penilaian',setting='$daftar_setting',komponen='$daftar_komponen' where kd_user='$kode'");
	}
	
	public function hapus($kode)
	{
		$this->db->query("delete from wbbm.wbbm.users where kd_user='$kode'");
	}

	public function ubah_password($email,$password)
	{
		$this->db->query("update wbbm.wbbm.users set password='$password' where email='$email'");
	}
}
?>