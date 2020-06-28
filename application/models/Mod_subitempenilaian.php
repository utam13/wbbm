<?
class mod_subitempenilaian extends CI_Model
{
	public function daftar($start = 0 ,$end = 10, $kode)
	{ 
		return $this->db->query("select * from wbbm.wbbm.sub_item where kd_item_penilaian='$kode' order by kd_sub_item ASC OFFSET $start ROWS FETCH NEXT $end ROWS ONLY");
	}

	public function jumlah_data($kode = "")
	{
		return $this->db->query("select * from wbbm.wbbm.sub_item where kd_item_penilaian='$kode' ")->num_rows();
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
		return $this->db->query("select * from wbbm.wbbm.sub_item where nama_sub_item='$nama' and kd_sub_item='$kode'")->num_rows();
	}
	
	public function simpan($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.sub_item(kd_item_penilaian,nama_sub_item,operasi_item) values('$kd_item_penilaian','$nama_sub_item','$operasi_item')");
	}
	
	public function ubah($data)
	{
		extract($data);
		$this->db->query("update wbbm.wbbm.sub_item set nama_sub_item='$nama_sub_item',operasi_item='$operasi_item' where kd_sub_item='$kd_sub_item'");
	}
	
	public function hapus($kode)
	{
		$this->db->query("delete from wbbm.wbbm.sub_item where kd_sub_item='$kode'");
	}
}
?>