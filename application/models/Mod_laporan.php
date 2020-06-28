<?
class mod_laporan extends CI_Model
{
	public function komponen()
	{
		return $this->db->query("select * from wbbm.wbbm.komponen");
	}

	public function kegiatan($kode)
	{
		return $this->db->query("select nama_kegiatan,dari,sampai from wbbm.wbbm.kegiatan where kd_kegiatan='$kode'");
	}

	public function cek_nilai_komponen($kode, $versi, $komponen)
	{
		return $this->db->query("select * from wbbm.wbbm.nilai_komponen where versi='$versi' and kd_kegiatan='$kode' and kd_komponen='$komponen'")->num_rows();
	}

	public function nilai_komponen($kode, $versi, $komponen)
	{
		return $this->db->query("select * from wbbm.wbbm.nilai_komponen where versi='$versi' and kd_kegiatan='$kode' and kd_komponen='$komponen'");
	}



	/*------------------------------------------------------------- laporan tabel -------------------------------------------------------------------*/

	public function komponen2($kelompok)
	{
		return $this->db->query("select * from wbbm.wbbm.komponen where kelompok='$kelompok' and aktif='1'");
	}

	public function sub_komponen()
	{
		return $this->db->query("select * from wbbm.wbbm.sub_komponen where aktif='1'");
	}

	public function item()
	{
		return $this->db->query("select * from wbbm.wbbm.item_penilaian where aktif='1'");
	}

	public function spek_nilai()
	{
		return $this->db->query("select * from wbbm.wbbm.spek_nilai");
	}

	public function sub_item()
	{
		return $this->db->query("select * from wbbm.wbbm.sub_item");
	}

	//nilai komponen versi self assement
	public function nilaikomp1($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.nilai_komponen where kd_kegiatan='$kegiatan' and versi='1'");
	}

	//nilai sub komponen versi self assement
	public function nilaisub1($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.nilai_sub where kd_kegiatan='$kegiatan' and versi='1'");
	}

	//nilai item versi self assement
	public function nilaiitem1($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.penilaian where kd_kegiatan='$kegiatan' and versi='1'");
	}

	//nilai sub item versi self assement
	public function nilaisubitem1($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.nilai_sub_item where kd_kegiatan='$kegiatan' and versi='1'");
	}

	//nilai komponen versi surveyor
	public function nilaikomp2($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.nilai_komponen where kd_kegiatan='$kegiatan' and versi='2'");
	}

	//nilai sub komponen versi surveyor
	public function nilaisub2($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.nilai_sub where kd_kegiatan='$kegiatan' and versi='2'");
	}

	//nilai item versi surveyor
	public function nilaiitem2($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.penilaian where kd_kegiatan='$kegiatan' and versi='2'");
	}

	//nilai sub item versi surveyor
	public function nilaisubitem2($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.nilai_sub_item where kd_kegiatan='$kegiatan' and versi='2'");
	}

	public function cek_kegiatan($kode)
	{
		return $this->db->query("select nama_kegiatan from wbbm.wbbm.kegiatan where kd_kegiatan='$kode'");
	}

	public function cek_nilai($kode, $jawab)
	{
		return $this->db->query("select nilai from wbbm.wbbm.spek_nilai where kd_item_penilaian='$kode' and nama_nilai='$jawab'");
	}

	public function cek_jml_item($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.item_penilaian where kd_sub_komponen='$kode'")->num_rows();
	}

	public function cek_subkomp($kode)
	{
		return $this->db->query("select nilai_std from wbbm.wbbm.sub_komponen where kd_sub_komponen='$kode'");
	}

	public function cek_komp($kode)
	{
		return $this->db->query("select nilai_std from wbbm.wbbm.komponen where kd_komponen='$kode'");
	}

	public function cek_total_item($kode, $versi)
	{
		return $this->db->query("select COALESCE(SUM(a.nilai),0) as total from wbbm.wbbm.penilaian a,wbbm.wbbm.item_penilaian b where a.kd_item_penilaian=b.kd_item_penilaian and b.kd_sub_komponen='$kode' and a.versi='$versi'");
	}

	public function cek_total_sub($kode, $versi)
	{
		return $this->db->query("select COALESCE(SUM(a.nilai),0) as total from wbbm.wbbm.nilai_sub a,wbbm.wbbm.sub_komponen b where a.kd_sub_komponen=b.kd_sub_komponen and b.kd_komponen='$kode' and a.versi='$versi'");
	}

	public function cek_total_kegiatan1($kode)
	{
		return $this->db->query("select COALESCE(SUM(nilai),0) as total from wbbm.wbbm.nilai_komponen where kd_kegiatan='$kode' and versi='1'");
	}

	public function cek_total_kegiatan2($kode)
	{
		return $this->db->query("select COALESCE(SUM(nilai),0) as total from wbbm.wbbm.nilai_komponen where kd_kegiatan='$kode' and versi='2'");
	}

	public function total_nilai_std($kelompok)
	{
		return $this->db->query("select COALESCE(SUM(nilai_std),0) as total from wbbm.wbbm.komponen where kelompok='$kelompok'");
	}

	public function total_nilai_komponen($kode, $versi, $kelompok)
	{
		return $this->db->query("select COALESCE(SUM(a.nilai),0) as total from wbbm.wbbm.nilai_komponen a, wbbm.wbbm.komponen b where a.kd_komponen=b.kd_komponen and b.kelompok='$kelompok' and a.kd_kegiatan='$kode' and a.versi='$versi'");
	}
}
