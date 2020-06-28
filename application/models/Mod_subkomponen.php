<?
class mod_subkomponen extends CI_Model
{
	public function daftar($start = 0, $end = 10, $q_cari)
	{
		return $this->db->query("select * from wbbm.wbbm.sub_komponen where $q_cari order by kd_sub_komponen ASC OFFSET $start ROWS FETCH NEXT $end ROWS ONLY");
	}

	public function jumlah_data($q_cari = "")
	{
		return $this->db->query("select * from wbbm.wbbm.sub_komponen where $q_cari")->num_rows();
	}

	public function jumlah_item($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.item_penilaian where kd_sub_komponen='$kode'")->num_rows();
	}

	public function jumlah_item_aktif($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.item_penilaian where kd_sub_komponen='$kode' and aktif='1'")->num_rows();
	}

	public function jumlah_item_nonaktif($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.item_penilaian where kd_sub_komponen='$kode' and aktif='0'")->num_rows();
	}

	public function cek_komponen($kode)
	{
		return $this->db->query("select kelompok,nama_komponen from wbbm.wbbm.komponen where kd_komponen='$kode'");
	}

	public function cek_nama($nama)
	{
		return $this->db->query("select * from wbbm.wbbm.sub_komponen where nama_sub_komponen='$nama'")->num_rows();
	}

	public function simpan($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.sub_komponen(kd_komponen,nama_sub_komponen,nilai_std,nilai_maks,keterangan,aktif) values('$kd_komponen','$nama_sub_komponen','$nilai','$maks','$ket','1')");
	}

	public function ubah($data)
	{
		extract($data);
		$this->db->query("update wbbm.wbbm.sub_komponen set nama_sub_komponen='$nama_sub_komponen',nilai_std='$nilai',nilai_maks='$maks',keterangan='$ket' where kd_sub_komponen='$kd_sub_komponen'");
	}

	public function hapus($kode)
	{
		$this->db->query("delete from wbbm.wbbm.sub_komponen where kd_sub_komponen='$kode'");
	}

	public function status($kode, $aktif)
	{
		$this->db->query("update wbbm.wbbm.sub_komponen set aktif='$aktif' where kd_sub_komponen='$kode'");
	}
}
