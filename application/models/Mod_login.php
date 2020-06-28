<?
class mod_login extends CI_Model
{
	public function cek_username($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.users where email='$kode'")->num_rows();
	}
	
	public function cek_password($kode,$pass)
	{
		return $this->db->query("select * from wbbm.wbbm.users where email='$kode' and password='$pass'")->num_rows();
	}
	
	public function ambil($kode)
	{
		$user  = $this->db->query("select * from wbbm.wbbm.users where email='$kode'");
		return $user;
	}
}
?>