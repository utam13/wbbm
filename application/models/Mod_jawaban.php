<?
class mod_jawaban extends CI_Model
{
	public function daftar($start = 0 ,$end = 10, $kode)
	{ 
		return $this->db->query("select * from wbbm.wbbm.spek_nilai where kd_item_penilaian='$kode' order by kd_spek_nilai ASC OFFSET $start ROWS FETCH NEXT $end ROWS ONLY");
	}

	public function jumlah_data($kode = "")
	{
		return $this->db->query("select * from wbbm.wbbm.spek_nilai where kd_item_penilaian='$kode' ")->num_rows();
	}
	
	public function cek_komponen($kode)
	{
		return $this->db->query("select nama_komponen from wbbm.wbbm.komponen where kd_komponen='$kode'");
	}
	
	public function cek_subkomponen($kode)
	{
		return $this->db->query("select nama_sub_komponen from wbbm.wbbm.sub_komponen where kd_sub_komponen='$kode'");
	}
	
	public function cek_itempenilaian($kode)
	{
		return $this->db->query("select nama_item,model_jawaban from wbbm.wbbm.item_penilaian where kd_item_penilaian='$kode'");
	}
	
	public function cek_nama($nama,$kode)
	{
		return $this->db->query("select * from wbbm.wbbm.spek_nilai where nama_nilai='$nama' and kd_spek_nilai='$kode'")->num_rows();
	}
	
	public function simpan($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.spek_nilai(kd_item_penilaian,nama_nilai,nilai) values('$kd_item_penilaian','$nama_nilai','$nilai')");
	}
	
	public function ubah($data)
	{
		extract($data);
		$this->db->query("update wbbm.wbbm.spek_nilai set nama_nilai='$nama_nilai',nilai='$nilai' where kd_spek_nilai='$kd_spek_nilai'");
	}
	
	public function hapus($kode)
	{
		$this->db->query("delete from wbbm.wbbm.spek_nilai where kd_spek_nilai='$kode'");
	}
}
?>