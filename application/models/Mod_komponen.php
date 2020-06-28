<?
class mod_komponen extends CI_Model
{
	public function daftar($start = 0 ,$end = 10, $q_cari)
	{
		return $this->db->query("select * from wbbm.wbbm.komponen where $q_cari order by kd_komponen ASC OFFSET $start ROWS FETCH NEXT $end ROWS ONLY");
	}

	public function jumlah_data($q_cari = "")
	{
		return $this->db->query("select * from wbbm.wbbm.komponen where $q_cari")->num_rows();
	}
	
	public function jumlah_item($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.sub_komponen where kd_komponen='$kode'")->num_rows();
	}
	
	public function jumlah_item_aktif($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.sub_komponen where kd_komponen='$kode' and aktif='1'")->num_rows();
	}
	
	public function jumlah_item_nonaktif($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.sub_komponen where kd_komponen='$kode' and aktif='0'")->num_rows();
	}
	
	public function cek_kegiatan($kode)
	{
		return $this->db->query("select nama_kegiatan from wbbm.wbbm.kegiatan where kd_kegiatan='$nama'");
	}
	
	public function cek_nama($nama)
	{
		return $this->db->query("select * from wbbm.wbbm.komponen where nama_komponen='$nama'")->num_rows();
	}
	
	public function simpan($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.komponen(kelompok,nama_komponen,nilai_std,aktif) values('$kelompok','$nama_komponen','$nilai','1')");
	}
	
	public function ubah($data)
	{
		extract($data);
		$this->db->query("update wbbm.wbbm.komponen set kelompok='$kelompok',nama_komponen='$nama_komponen',nilai_std='$nilai' where kd_komponen='$kd_komponen'");
	}
	
	public function hapus($kode)
	{
		$this->db->query("delete from wbbm.wbbm.komponen where kd_komponen='$kode'");
	}
	
	public function status($kode,$aktif)
	{
		$this->db->query("update wbbm.wbbm.komponen set aktif='$aktif' where kd_komponen='$kode'");
	}
}
?>