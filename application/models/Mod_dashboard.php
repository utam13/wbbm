<?
class mod_dashboard extends CI_Model
{
	public function daftar_kegiatan()
	{
		return $this->db->query("select * from wbbm.wbbm.kegiatan");
	}
	
	public function kegiatan($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.kegiatan where kd_kegiatan='$kode'");
	}
	
	public function kegiatan_terakhir()
	{
		return $this->db->query("select * from wbbm.wbbm.kegiatan order by kd_kegiatan DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY");
	}
	
	public function komponen()
	{
		return $this->db->query("select * from wbbm.wbbm.komponen");
	}
	
	public function jumlah_proses()
	{
		return $this->db->query("select * from wbbm.wbbm.komponen where kelompok='1'")->num_rows();
	}
	
	public function jumlah_hasil()
	{
		return $this->db->query("select * from wbbm.wbbm.komponen where kelompok='2'")->num_rows();
	}
	
	public function total($kegiatan,$versi)
	{
		return $this->db->query("select coalesce(sum(nilai),0) as total from wbbm.wbbm.nilai_komponen where versi='$versi' and kd_kegiatan='$kegiatan'");
	}
	
	public function cek_nilai_komponen($kegiatan,$versi,$komponen)
	{
		return $this->db->query("select * from wbbm.wbbm.nilai_komponen where versi='$versi' and kd_kegiatan='$kegiatan' and kd_komponen='$komponen'")->num_rows();
	}
	
	public function nilai_komponen($kegiatan,$versi,$komponen)
	{
		return $this->db->query("select nilai,persen from wbbm.wbbm.nilai_komponen where versi='$versi' and kd_kegiatan='$kegiatan' and kd_komponen='$komponen'");
	}

	public function total_nilai_std($kelompok)
	{
		return $this->db->query("select COALESCE(SUM(nilai_std),0) as total from wbbm.wbbm.komponen where kelompok='$kelompok'");
	}
}
