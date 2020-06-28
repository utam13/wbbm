		<!-- Right side column. Contains the navbar and content of the page -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Item Penilaian
					<? if ($kelompok_komponen == 1) { ?>
						<small><?= $nama_komponen . " - " . $nama_sub_komponen; ?></small>
					<? } else { ?>
						<small><?= $nama_komponen; ?></small>
					<? } ?>
				</h1>
				<ol class="breadcrumb">
					<? if ($kelompok_komponen == 1) { ?>
						<li><a href="<?= base_url(); ?>subkomponen/index/<?= $kd_komponen; ?>"><i class="fa fa-list"></i> Sub Komponen Penilaian</a></li>
					<? } else { ?>
						<li><a href="<?= base_url(); ?>komponen"><i class="fa fa-list"></i> Komponen Penilaian</a></li>
					<? } ?>
					<li class="active">Item Penilaian</li>
				</ol>
			</section>

			<section class="content">
				<? extract($pesan); ?>
				<? if ($kode_pesan != "") { ?>
					<div class="callout <?= $jenisbox; ?>">
						<h4><?= $judulmsg; ?></h4>
						<?= str_replace("%7C", "<br>", str_replace("%20", " ", $isipesan)); ?>
					</div>
				<? } ?>
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header with-border">
								<h3 align class="box-title">
									<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_item" onclick="ambil_itempenilaian('<?= base_url(); ?>itempenilaian/proses/1/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/','','','','')"><i class="fa fa-plus"></i> Tambah Item Penilaian</a>
								</h3>

								<div style="float:right">
									<form class="form-inline" method="post" action="<?= base_url(); ?>itempenilaian/index/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/" style="float:right;" onsubmit="showloading()">
										<div class="form-group">
											<input type="text" class="form-control" name="cari" required autocomplete="off" value="" placeholder="Isi nama item penilaian" />
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari</button>
											<a href="<?= base_url(); ?>itempenilaian/index/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i> Segarkan</a>
										</div>
									</form>
								</div>

							</div>
							<!-- /.box-header -->
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-bordered table-striped" id="mytable">
									<thead>
										<tr>
											<th width="2px">No</th>
											<th width="40%">Uraian Item Penilaian</th>
											<th>Model Jawaban</th>
											<th width="20%">Keterangan</th>
											<th>Status</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<?
										$hasil = json_decode($itempenilaian);
										foreach ($hasil as $k) {
											$data = "'" .
												$k->kd_item_penilaian . "','" .
												preg_replace("/\r|\n/", " ", $k->nama_item) . "','" .
												$k->model_jawaban . "','" .
												preg_replace("/\r|\n/", "", $k->keterangan)
												. "'";
											?>
											<tr>
												<td><?= $no; ?></td>
												<td><?= $k->nama_item; ?></td>
												<? if ($k->nama_model == "Sub Item") { ?>
													<td><a href="<?= base_url(); ?>subitempenilaian/index/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/<?= $k->kd_item_penilaian; ?>/" class="btn bg-navy btn-xs" title="Sub Item Penilaian">Sub Item</a></td>
												<? } else { ?>
													<td><a href="<?= base_url(); ?>jawaban/index/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/<?= $k->kd_item_penilaian; ?>/" class="btn bg-navy btn-xs" title="Model Jawaban"><?= $k->nama_model; ?></a><br><?= $k->nilai; ?></td>
												<? } ?>
												<td><?= nl2br($k->keterangan); ?></td>
												<td><a href="<?= base_url(); ?>itempenilaian/proses/4/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/<?= $k->kd_item_penilaian; ?>/<?= $k->aktif; ?>/<?= $k->nama_item; ?>" class="btn <?= $k->simbol_aktif_nonaktif; ?> btn-xs" title="Status" onclick="return confirm('Menonaktifkan data item penilaian tersebut, lanjutkan ?')"><?= $k->status; ?></td>
												<td>
													<a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#form_item" title="Ubah" onclick="ambil_itempenilaian('<?= base_url(); ?>itempenilaian/proses/2/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/',<?= $data; ?>)"><i class="fa fa-pencil-square-o"></i></a>
													<a href="<?= base_url(); ?>itempenilaian/proses/3/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/<?= $k->kd_item_penilaian; ?>/<?= $k->aktif; ?>/<?= $k->nama_item; ?>" class="btn btn-danger btn-xs" title="Hapus" onclick="return confirm('Menghapus data item penilaian dengan nama <?= $k->nama_item; ?> beserta data penilaian yang mengguanakan item penilaian tersebut, lanjutkan ?')"><i class="fa fa-trash-o"></i></a>
												</td>
											</tr>
										<? $no++;
										} ?>
									</tbody>
								</table>
							</div>
							<div class="box-footer with-border">
								<? if ($jumlah_page > 0) { ?>
									<ul class="pagination" style="float:right;">
										<? if ($page == 1) { ?>
											<li class="disabled"><a href="#"><span class="glyphicon glyphicon-fast-backward"></a></li>
											<li class="disabled"><a href="#"><span class="glyphicon glyphicon-step-backward"></a></li>
										<? } else {
												$link_prev = ($page > 1) ? $page - 1 : 1; ?>
											<li><a href="<?= base_url(); ?>itempenilaian/index/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/1"><span class="glyphicon glyphicon-fast-backward"></a></li>
											<li><a href="<?= base_url(); ?>itempenilaian/index/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/<?= $link_prev; ?>"><span class="glyphicon glyphicon-step-backward"></a></li>
										<?
											}

											for ($i = $start_number; $i <= $end_number; $i++) {
												if ($page == $i) {
													$link_active = "";
													$link_color = "class='disabled'";
												} else {
													$link_active = base_url() . "itempenilaian/index/$kd_kegiatan/$kd_sub_komponen/$kd_komponen/$i";
													$link_color = "";
												}
												?>
											<li <?= $link_color; ?>><a href="<?= $link_active; ?>"><?= $i; ?></a></li>
										<?
											}

											if ($page == $jumlah_page) {
												?>
											<li class="disabled"><a href="#"><span class="glyphicon glyphicon-step-forward"></a></li>
											<li class="disabled"><a href="#"><span class="glyphicon glyphicon-fast-forward"></a></li>
										<? } else {
												$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page; ?>
											<li><a href="<?= base_url(); ?>itempenilaian/index/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/<?= $link_next; ?>"><span class="glyphicon glyphicon-step-forward"></a></li>
											<li><a href="<?= base_url(); ?>itempenilaian/index/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/<?= $jumlah_page; ?>"><span class="glyphicon glyphicon-fast-forward"></a></li>
										<? } ?>
									</ul>
								<? } ?>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!-- Modal -->
			<!--Formulir-->
			<div class="modal fade" id="form_item" tabindex="-1" role="dialog" aria-labelledby="form_item" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="form_item_label">Formulir Item Penilaian</h4>
						</div>
						<form id="frm_itempenilaian" name="frm_itempenilaian" method="post" action="<?= base_url(); ?>itempenilaian/proses/1/<?= $kd_komponen; ?>/<?= $kd_sub_komponen; ?>/">
							<div class="modal-body">
								<div class="form-group">
									<label>Uraian Item Penilaian</label>
									<input type="hidden" class="form-control" name="awal" id="awal" value="" />
									<textarea class="form-control" rows="5" name="nama" id="nama" maxlength=250 required style="resize:none;"></textarea>
								</div>
								<div class="form-group">
									<label>Model Jawaban</label>
									<select class="form-control" name="model" id="model" style="width:20%;">
										<option value="">Pilih...</option>
										<option value="1">Ya/Tidak</option>
										<option value="2">Abjad</option>
										<!--<option value="3">Angka</option>-->
										<option value="4">Sub Item</option>
									</select>
								</div>
								<div class="form-group">
									<label>Keterangan</label>
									<textarea class="form-control" rows="5" name="ket" id="ket" required style="resize:none;"></textarea>
								</div>
							</div>
							<div id="savebtn" class="modal-footer">
								<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.content-wrapper -->