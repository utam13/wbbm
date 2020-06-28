/*-------------------------------------DETEKSI WINDOW----------------------------------------------------------------------------- */

if (window.matchMedia("(orientation: portrait)").matches) {
	alert("Tampilan akan lebih baik dalam posisi landscape \nSilakan aktifkan rotasi layar Anda dan ubah posisi layar menjadi Landscape");
}

/*-------------------------------------END DETEKSI WINDOW----------------------------------------------------------------------------- */

/* -----------------------------------lihat password----------------------------------------------------------------------------- */
function lihatpassword() {
	var x = document.getElementById("password");
	if (x.type === "password") {
		x.type = "text";
		$("#iconlihat").removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	} else {
		x.type = "password";
		$("#iconlihat").removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}
}
/* -----------------------------------end----------------------------------------------------------------------------- */

/* -----------------------------------loading animation----------------------------------------------------------------------------- */
function showloading() {
	$("#dvloading").css("display", "block");
}
/* -----------------------------------end----------------------------------------------------------------------------- */

/* -----------------------------------pesan proses input edit masih aktif----------------------------------------------------------------------------- */
function pesanprosesdata() {
	alert("Anda masih dalam proses penginputan/perubahan data\nSelesaikan proses tersebut dengan mengklik tombol Simpan/Selesai/Batal (untuk membatalkan penginputan)");
}
/* -----------------------------------end----------------------------------------------------------------------------- */

//file size
$('#dokumen').change(function () {
	var value = $(this).val();

	if (this.files[0].size > 10000000) {
		alert("Ukuran file melebihi 10 Mb!");
		this.value = "";
	} else {
		//$("#fileselected").val(this.files[0].name);
		$("#fileselected").val(value);
	};
});

$(".modal").on('shown.bs.modal', function () {
	$(this).find("input:visible:first").focus();
});

$(".modal").on('shown.bs.modal', function () {
	$(this).find("select:visible:first").focus();
});

$(".modal").on('shown.bs.modal', function () {
	$(this).find("textarea:visible:first").focus();
});

$("#slide_dokumen").on('shown.bs.modal', function () {
	$(this).find("input:visible:first").focus();
});


//kegiatan
function ambil_kegiatan(url, kode, nama, dari, sampai) {
	$("#frm_kegiatan").attr("action", url + kode);

	$("#awal").val(nama);
	$("#nama").val(nama);
	$("#dari").val(dari);
	$("#sampai").val(sampai);
}

//komponen
function ambil_komponen(url, kode, kelompok, nama, nilai) {
	$("#frm_komponen").attr("action", url + kode);

	$("#kelompok").val(kelompok);
	$("#awal").val(nama);
	$("#nama").val(nama);
	$("#nilai").val(nilai);
}

//subkomponen
function set_item(nilai_sub, pilihan) {
	var pilih1 = "";
	var pilih2 = "";

	switch (pilihan) {
		case "0":
			pilih1 = "selected";
			break;
		case "1":
			pilih2 = "selected";
			break;
	}

	switch (nilai_sub) {
		case "0":
			$("#ada_item").attr("required", true);
			$("#ada_item").find('option').remove();
			$('#ada_item').append('<option value="">Pilih...</option>');
			$('#ada_item').append('<option value="1" ' + pilih2 + '>Ya</option>');
			$('#ada_item').append('<option value="0" ' + pilih1 + '>Tidak</option>');
			break;
		case "1":
			$("#ada_item").removeAttr("required");
			$("#ada_item").find('option').remove();
			$('#ada_item').append('<option value="0" selected>Tidak</option>');
			break;
	}
}

function ambil_subkomponen(url, kode, nama, nilai, maks, keterangan, kelompok) {
	$("#frm_subkomponen").attr("action", url + kode);

	$("#kelompok").val(kelompok);
	$("#awal").val(nama);
	$("#nama").val(nama);
	$("#nilai").val(nilai);
	$("#maks").val(maks);
	$("#ket").val(keterangan);

	//set_item(ada_sub2, ada_item);
}

//itempenilaian
function ambil_itempenilaian(url, kode, nama, model, ket) {
	$("#frm_itempenilaian").attr("action", url + kode);

	$("#awal").val(nama);
	$("#nama").val(nama);
	$("#model").val(model);
	$("#ket").val(ket);
}

//jawaban
function ambil_jawaban(url, kode, nama, nilai) {
	$("#frm_jawaban").attr("action", url + kode);

	if (nama == "") {
		$("#nama").attr("readonly", false);
	} else {
		$("#nama").attr("readonly", true);
	}
	$("#nama").val(nama);
	$("#nilai").val(nilai);
}

//sub item penilaian
function ambil_subitem(url, kode, nama, operasi) {
	$("#frm_subitem").attr("action", url + kode);

	if (nama == "") {
		$("#nama").attr("readonly", false);
	} else {
		$("#nama").attr("readonly", true);
	}
	$("#nama").val(nama);
	$("#operasi").val(operasi);
}

//jawab
function jawab(versi, url, soal, jenis, kegiatan, item, subkomp, komp, jml_pilihan, evaluasi, pilihan) {
	var pilihan;

	//$("#btn_simpan").attr("onclick","proses_jawaban('"+versi+"','"+kegiatan+"','"+item+"','"+jenis+"')");
	//$("#frm_jawab").attr("action",url);

	$("#versi").val(versi);
	$("#kd_kegiatan").val(kegiatan);
	$("#kd_komponen").val(komp);
	$("#kd_sub_komponen").val(subkomp);
	$("#kd_item").val(item);
	$("#model_jawaban").val(jenis);
	$("#evaluasi").val(evaluasi);

	switch (versi) {
		case "1":
			$("#form_komponen_label").html("Jawaban Self Assesment");
			break;
		case "2":
			$("#form_komponen_label").html("Jawaban Surveyor");
			break;
	}

	$("#soal").html(soal);

	switch (jenis) {
		case "1":
			$("#nilai1").show();
			$("#nilai2").hide();
			$("#nilai3").hide();


			$("#nilai1").attr("required", true);
			$("#nilai2").removeAttr("required");
			$("#nilai3").removeAttr("required");

			$("#nilai1").val(pilihan);
			//$("#nilai1").focus();
			break;
		case "2":
			$("#nilai1").hide();
			$("#nilai2").show();
			$("#nilai3").hide();

			$("#nilai1").removeAttr("required");
			$("#nilai2").attr("required", true);
			$("#nilai3").removeAttr("required");

			$("#nilai2").empty();
			$("#nilai2").append("<option value=''>Pilih...</option>");
			for (val_pilihan = 1; val_pilihan < jml_pilihan; val_pilihan++) {
				var huruf = String.fromCharCode(94 + (val_pilihan + 2));
				var pilih = "";
				if (huruf.toUpperCase() == pilihan) {
					pilih = "selected";
				}
				$("#nilai2").append("<option value='" + huruf.toUpperCase() + "' " + pilih + ">" + huruf.toUpperCase() + "</option>");
			}

			//$("#nilai2").val(pilihan);

			//$("#nilai2").focus();
			break;
		case "3":
			$("#nilai1").hide();
			$("#nilai2").hide();
			$("#nilai3").show();

			$("#nilai1").removeAttr("required");
			$("#nilai2").removeAttr("required");
			$("#nilai3").attr("required", true);
			$("#nilai3").val("0");
			$("#nilai3").attr("min", 0);
			$("#nilai3").attr("max", jml_pilihan);

			$("#nilai3").val(pilihan);
			//$("#nilai3").focus();
			break;
	}
}

function jawab_sub(versi, url, soal, kegiatan, komp, sub_komp, item, sub_item, operasi_item, nilai) {
	$("#versi3").val(versi);
	$("#kd_kegiatan3").val(kegiatan);
	$("#kd_komponen3").val(komp);
	$("#kd_sub_komponen3").val(sub_komp);
	$("#kd_item3").val(item);
	$("#kd_sub_item").val(sub_item);
	$("#operasi_item").val(operasi_item);

	switch (versi) {
		case "1":
			$("#form_sub_label").html("Jawaban Sub item Self Assesment");
			break;
		case "2":
			$("#form_sub_label").html("Jawaban Sub item Surveyor");
			break;
	}

	$("#soal_sub").html(soal);
	$("#nilai_sub").html(nilai);
}

function upload_dok(versi, kegiatan, item, subkomp, komp) {

	$("#slide_dokumen_label").html("Upload Dokumen");
	$("#namadok").removeAttr("readonly");
	$("#namadok").attr("required", true);
	$("#deskdok").removeAttr("readonly");
	$("#deskdok").attr("required", true);
	$("#dokumen").attr("required", true);
	$("#uploaddok").show();
	$("#btn_simpan").show();
	$("#btn_buka").hide();

	$("#versi2").val(versi);
	$("#kd_kegiatan2").val(kegiatan);
	$("#kd_komponen2").val(komp);
	$("#kd_sub_komponen2").val(subkomp);
	$("#kd_item2").val(item);

	$("#namadok").val("");
	$("#deskdok").val("");

	$("#namadok").focus();
}

function info_dok(nama, deskripsi, target) {

	var link_target = $("#link_target").val();

	$("#slide_dokumen_label").html("Info Dokumen");
	$("#namadok").attr("readonly", true);
	$("#namadok").removeAttr("required");
	$("#deskdok").attr("readonly", true);
	$("#deskdok").removeAttr("required");
	$("#dokumen").removeAttr("required");
	$("#uploaddok").hide();
	$("#btn_simpan").hide();
	$("#btn_buka").show();

	$("#namadok").val(nama);
	$("#deskdok").val(deskripsi);
	$("#btn_buka").attr("href", link_target + "/upload/" + target);
}

//user
function ambil_user(url, email, password, penilaian, setting, komponen) {
	var penilaian_menu = penilaian.replace(/-/g, ",");
	var penilaian_menu_temp = new Array();
	penilaian_menu_temp = penilaian_menu.split(",");

	var setting_menu = setting.replace(/-/g, ",");
	var setting_menu_temp = new Array();
	setting_menu_temp = setting_menu.split(",");

	var komponen_menu = komponen.replace(/-/g, ",");
	var komponen_menu_temp = new Array();
	komponen_menu_temp = komponen_menu.split(",");

	$("#frm_user").attr("action", url + email);

	$("#awal").val(email);
	$("#email").val(email);
	$("#password").val(password);
	$("#penilaian").selectpicker('val', penilaian_menu_temp);
	$("#setting_menu").selectpicker('val', setting_menu_temp);
	$("#komponen").selectpicker('val', komponen_menu_temp);
}


//proses jawaban
function proses_jawaban(versi, kode_kegiatan, kode_item, model_jawaban) {
	//alert(kode_kegiatan+" - "+kode_item+" - "+model_jawaban);

	//get jawaban
	var jawaban;
	switch (model_jawaban) {
		case "1":
			jawaban = $("#nilai1").val();
			break;
		case "2":
			jawaban = $("#nilai2").val();
			break;
		case "3":
			jawaban = $("#nilai3").val();
			break;
	}

	//validasi inputan
	if (jawaban == "") {
		alert("Isi atau pilih jawaban terlebih dahulu");

		switch (model_jawaban) {
			case "1":
				$("#nilai1").focus();
				break;
			case "2":
				$("#nilai2").focus();
				break;
			case "3":
				$("#nilai3").focus();
				break;
		}
	} else {
		//simpan data jawaban
		$.ajax({
			url: "http://localhost/wbbm/penilaian/proses",
			method: "POST",
			data: {
				"versi": versi,
				"kd_kegiatan": kode_kegiatan,
				"kd_item": kode_item,
				"jawab": jawaban
			},
		}).done(function (response) {
			// do something
			//refresh tabel
			alert("Proses penilaian berhasil");

		}).fail(function (jqXHR, textStatus) {
			// do something
			alert("Proses penilaian gagal");

		});
	}
}
