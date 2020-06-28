<?
class mod_penilaian extends CI_Model
{
	public function komponen($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.komponen where kd_komponen='$kode' and aktif='1'");
	}

	public function sub_komponen($kode)
	{
		return $this->db->query("select * from wbbm.wbbm.sub_komponen where kd_komponen='$kode' and aktif='1'");
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
		return $this->db->query("select nilai_std,nilai_maks from wbbm.wbbm.sub_komponen where kd_sub_komponen='$kode'");
	}

	public function cek_komp($kode)
	{
		return $this->db->query("select nilai_std from wbbm.wbbm.komponen where kd_komponen='$kode'");
	}

	public function cek_komponen($kode)
	{
		return $this->db->query("select kelompok,nama_komponen from wbbm.wbbm.komponen where kd_komponen='$kode'");
	}

	public function cek_total_item($kode, $versi, $kegiatan)
	{
		return $this->db->query("select COALESCE(SUM(a.nilai),0) as total from wbbm.wbbm.penilaian a,wbbm.wbbm.item_penilaian b where a.kd_item_penilaian=b.kd_item_penilaian and b.kd_sub_komponen='$kode' and a.versi='$versi' and a.kd_kegiatan='$kegiatan'");
	}

	public function cek_total_item2($kode, $versi, $kegiatan)
	{
		return $this->db->query("select COALESCE(SUM(a.nilai),0) as total from wbbm.wbbm.penilaian a,wbbm.wbbm.sub_komponen b where a.kd_item_penilaian=b.kd_sub_komponen and b.kd_sub_komponen='$kode' and a.versi='$versi' and a.kd_kegiatan='$kegiatan'");
	}

	//sub item
	public function cek_total_sub_item1($kode, $versi, $kegiatan)
	{
		return $this->db->query("select COALESCE(SUM(a.nilai),0) as total from wbbm.wbbm.nilai_sub_item a,wbbm.wbbm.sub_item b where a.kd_sub_item=b.kd_sub_item and b.kd_item_penilaian='$kode' and a.versi='$versi' and a.kd_kegiatan='$kegiatan' and b.operasi_item='Penambahan'");
	}

	public function cek_total_sub_item2($kode, $versi, $kegiatan)
	{
		return $this->db->query("select COALESCE(SUM(a.nilai),0) as total from wbbm.wbbm.nilai_sub_item a,wbbm.wbbm.sub_item b where a.kd_sub_item=b.kd_sub_item and b.kd_item_penilaian='$kode' and a.versi='$versi' and a.kd_kegiatan='$kegiatan' and b.operasi_item='Pengurangan'");
	}

	public function sub_item_total($kode)
	{
		return $this->db->query("select kd_sub_item from wbbm.wbbm.sub_item where kd_item_penilaian='$kode' and operasi_item='Total'");
	}

	//end sub item

	public function cek_total_sub($kode, $versi, $kegiatan)
	{
		return $this->db->query("select COALESCE(SUM(a.nilai),0) as total from wbbm.wbbm.nilai_sub a,wbbm.wbbm.sub_komponen b where a.kd_sub_komponen=b.kd_sub_komponen and b.kd_komponen='$kode' and a.versi='$versi' and a.kd_kegiatan='$kegiatan'");
	}

	public function cek_total_kegiatan1($kode)
	{
		return $this->db->query("select COALESCE(SUM(nilai),0) as total from wbbm.wbbm.nilai_komponen where kd_kegiatan='$kode' and versi='1'");
	}

	public function cek_total_kegiatan2($kode)
	{
		return $this->db->query("select COALESCE(SUM(nilai),0) as total from wbbm.wbbm.nilai_komponen where kd_kegiatan='$kode' and versi='2'");
	}

	//nilai item
	public function reset_nilai($kegiatan, $item, $versi)
	{
		$this->db->query("delete from wbbm.wbbm.penilaian where kd_kegiatan='$kegiatan' and kd_item_penilaian='$item' and versi='$versi'");
	}

	public function simpan_nilai($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.penilaian(versi,kd_kegiatan,kd_item_penilaian,jawab,nilai,evaluasi,dokumen) values('$versi','$kd_kegiatan','$kd_item','$jawab','$nilai','$evaluasi','$dokumen')");
	}

	//nilai sub item
	public function reset_nilai_sub($kegiatan, $sub_item, $versi)
	{
		$this->db->query("delete from wbbm.wbbm.nilai_sub_item where kd_kegiatan='$kegiatan' and kd_sub_item='$sub_item' and versi='$versi'");
	}

	public function simpan_nilai_sub($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.nilai_sub_item(versi,kd_kegiatan,kd_sub_item,nilai) values('$versi','$kd_kegiatan','$kd_sub_item','$nilai_sub')");
	}

	//nilai sub komponen
	public function reset_nilai_subkomp($kegiatan, $sub, $versi)
	{
		$this->db->query("delete from wbbm.wbbm.nilai_sub where kd_kegiatan='$kegiatan' and kd_sub_komponen='$sub' and versi='$versi'");
	}

	public function simpan_nilai_subkomp($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.nilai_sub(versi,kd_kegiatan,kd_sub_komponen,nilai,persen) values('$versi','$kd_kegiatan','$kd_sub','$nilai','$persen')");
	}

	//nilai komp
	public function reset_nilai_komp($kegiatan, $komp, $versi)
	{
		$this->db->query("delete from wbbm.wbbm.nilai_komponen where kd_kegiatan='$kegiatan' and kd_komponen='$komp' and versi='$versi'");
	}

	public function simpan_nilai_komp($data)
	{
		extract($data);
		$this->db->query("insert into wbbm.wbbm.nilai_komponen(versi,kd_kegiatan,kd_komponen,nilai,persen) values('$versi','$kd_kegiatan','$kd_komponen','$nilai','$persen')");
	}

	//nilai kegiatan
	public function simpan_nilai_kegiatan($data)
	{
		extract($data);
		$this->db->query("update wbbm.wbbm.kegiatan set total_sa='$total_sa',total_sy='$total_sy' where kd_kegiatan='$kd_kegiatan'");
	}

	//dokumen upload
	public function cek_file($item, $versi, $nama)
	{
		return $this->db->query("select dokumen from wbbm.wbbm.dokumen where dokumen='$nama' and kd_item_penilaian='$item' and versi='$versi'")->num_rows();
	}

	public function cek_upload($item, $versi)
	{
		return $this->db->query("select * from wbbm.wbbm.dokumen where kd_item_penilaian='$item' and versi='$versi'")->num_rows();
	}

	public function dokumen($versi, $item, $nama_file, $nama_dok, $deskripsi)
	{
		//$this->db->query("update wbbm.wbbm.dokumen set dokumen='$nama_dok' where kd_kegiatan='$kegiatan' and kd_item_penilaian='$item' and versi='$versi'");
		$this->db->query("insert into wbbm.wbbm.dokumen(versi,kd_item_penilaian,nama_file,dokumen,deskripsi) values('$versi','$item','$nama_file','$nama_dok','$deskripsi')");
	}

	//reset dokumen
	public function reset_dok($nama_dok, $kegiatan, $item, $versi)
	{
		$this->db->query("update wbbm.wbbm.penilaian set dokumen='$nama_dok' where kd_kegiatan='$kegiatan' and kd_item_penilaian='$item' and versi='$versi'");
	}

	//hapus dokumen
	public function hapus_dok($kode)
	{
		$this->db->query("delete from wbbm.wbbm.dokumen where kd_dokumen='$kode'");
	}

	//ambil dokumen
	public function daftar_dok1($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.dokumen where nama_file like '$kegiatan%' and versi='1'");
	}

	public function daftar_dok2($kegiatan)
	{
		return $this->db->query("select * from wbbm.wbbm.dokumen where nama_file like '$kegiatan%' and versi='2'");
	}
}
