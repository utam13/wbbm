<?
class mod_kegiatan extends CI_Model
{
	public function daftar($start = 0 ,$end = 10, $q_cari)
	{
		return $this->db->query("select * from wbbm.wbbm.kegiatan where $q_cari order by kd_kegiatan ASC OFFSET $start ROWS FETCH NEXT $end ROWS ONLY");
	}

	public function jumlah_data($q_cari = "")
	{
		return $this->db->query("select * from wbbm.wbbm.kegiatan where $q_cari")->num_rows();
	}
	
	public function cek_nama($nama)
	{
		return $this->db->query("select * from wbbm.wbbm.kegiatan where nama_kegiatan='$nama'")->num_rows();
	}
	
	public function simpan($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.kegiatan(nama_kegiatan,dari,sampai,total_sa,total_sy) values('$nama_kegiatan','$dari','$sampai','$total_sa','$total_sy')");
	}
	
	public function ubah($data)
	{
		extract($data);
		$this->db->query("update wbbm.wbbm.kegiatan set 
										nama_kegiatan='$nama_kegiatan',
										dari='$dari',
										sampai='$sampai'
								where kd_kegiatan='$kd_kegiatan'");
	}
	
	public function hapus($kode)
	{
		$this->db->query("delete from wbbm.wbbm.kegiatan where kd_kegiatan='$kode'");
	}
}
?>