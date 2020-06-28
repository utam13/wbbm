<?
class mod_log extends CI_Model
{
	public function daftar($start = 0 ,$end = 10, $q_cari)
	{
		return $this->db->query("select * from wbbm.wbbm.logs where $q_cari order by waktulog DESC OFFSET $start ROWS FETCH NEXT $end ROWS ONLY");
	}

	public function jumlah_data($q_cari = "")
	{
		return $this->db->query("select * from wbbm.wbbm.logs where $q_cari")->num_rows();
	}
	
	public function laporan()
	{
		return $this->db->query("select * from wbbm.wbbm.logs order by waktulog DESC");
	}

	public function hapus()
	{
		$this->db->query("truncate table wbbm.wbbm.logs");
	}
}
?>