<?
class mod_itempenilaian extends CI_Model
{
	public function daftar($start = 0 ,$end = 10, $q_cari)
	{
		return $this->db->query("select * from wbbm.wbbm.item_penilaian where $q_cari order by kd_item_penilaian ASC OFFSET $start ROWS FETCH NEXT $end ROWS ONLY");
	}

	public function jumlah_data($q_cari = "")
	{
		return $this->db->query("select * from wbbm.wbbm.item_penilaian where $q_cari")->num_rows();
	}
	
	public function set_nilai($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.spek_nilai where kd_item_penilaian='$kode'");
	}
	
	public function cek_komponen($kode)
	{
		return $this->db->query("select kelompok,nama_komponen from wbbm.wbbm.komponen where kd_komponen='$kode'");
	}
	
	public function cek_subkomponen($kode)
	{
		return $this->db->query("select nama_sub_komponen from wbbm.wbbm.sub_komponen where kd_sub_komponen='$kode'");
	}
	
	public function cek_nama($nama)
	{
		return $this->db->query("select * from wbbm.wbbm.item_penilaian where nama_item='$nama'")->num_rows();
	}
	
	public function simpan($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.item_penilaian(kd_sub_komponen,nama_item,model_jawaban,keterangan,aktif) values('$kd_sub_komponen','$nama_item','$model_jawaban','$keterangan','1')");
	}
	
	public function ubah($data)
	{
		extract($data);
		$this->db->query("update wbbm.wbbm.item_penilaian set nama_item='$nama_item',model_jawaban='$model_jawaban',keterangan='$keterangan' where kd_item_penilaian='$kd_item_penilaian'");
	}
	
	public function hapus($kode)
	{
		$this->db->query("delete from wbbm.wbbm.item_penilaian where kd_item_penilaian='$kode'");
	}
	
	public function cek_kodeitem($nama)
	{
		return $this->db->query("select kd_item_penilaian from wbbm.wbbm.item_penilaian where nama_item='$nama'");
	}
	
	public function jawaban($kode_subkomponen,$nama,$nilai)
	{
		$this->db->query("insert into wbbm.wbbm.spek_nilai(kd_item_penilaian,nama_nilai,nilai) values('$kode_subkomponen','$nama','$nilai')");
	}
	
	public function status($kode,$aktif)
	{
		$this->db->query("update wbbm.wbbm.item_penilaian set aktif='$aktif' where kd_item_penilaian='$kode'");
	}
}
