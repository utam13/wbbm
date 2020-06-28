<?
class mod_kegiatan_nilai extends CI_Model
{
	public function daftar($start = 0 ,$end = 10)
	{
		return $this->db->query("select * from wbbm.wbbm.komponen order by kd_komponen ASC OFFSET $start ROWS FETCH NEXT $end ROWS ONLY");
	}

	public function jumlah_data()
	{
		return $this->db->query("select * from wbbm.wbbm.komponen")->num_rows();
	}
	
	public function cek_nilai_sa($kode_komponen,$kode_kegiatan)
	{
		return $this->db->query("select nilai from wbbm.wbbm.nilai_komponen where versi='1' and kd_kegiatan='$kode_kegiatan' and kd_komponen='$kode_komponen'");
	}
	
	public function cek_nilai_sy($kode_komponen,$kode_kegiatan)
	{
		return $this->db->query("select nilai from wbbm.wbbm.nilai_komponen where versi='2' and kd_kegiatan='$kode_kegiatan' and kd_komponen='$kode_komponen'");
	}
	
	public function cek_persen_sa($kode_komponen,$kode_kegiatan)
	{
		return $this->db->query("select persen from wbbm.wbbm.nilai_komponen where versi='1' and kd_kegiatan='$kode_kegiatan' and kd_komponen='$kode_komponen'");
	}
	
	public function cek_persen_sy($kode_komponen,$kode_kegiatan)
	{
		return $this->db->query("select persen from wbbm.wbbm.nilai_komponen where versi='2' and kd_kegiatan='$kode_kegiatan' and kd_komponen='$kode_komponen'");
	}
}
?>