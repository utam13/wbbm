		<!-- Right side column. Contains the navbar and content of the page -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Sub Komponen Penilaian
					<small><?= $nama_komponen; ?></small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?= base_url(); ?>komponen"><i class="fa fa-list"></i> Komponen Penilaian</a></li>
					<li class="active">Sub Komponen Penilaian</li>
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
									<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_subkomponen" onclick="ambil_subkomponen('<?= base_url(); ?>subkomponen/proses/1/<?= $kd_komponen; ?>/','','','','','','<?= $kelompok_komponen;?>')"><i class="fa fa-plus"></i> Tambah Sub Komponen</a>
								</h3>

								<div style="float:right">
									<form class="form-inline" method="post" action="<?= base_url(); ?>subkomponen/index/<?= $kd_komponen; ?>/" style="float:right;" onsubmit="showloading()">
										<div class="form-group">
											<input type="text" class="form-control" name="cari" required autocomplete="off" value="" placeholder="Isi nama sub komponen" />
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari</button>
											<a href="<?= base_url(); ?>subkomponen/index/<?= $kd_komponen; ?>/" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i> Segarkan</a>
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
											<th <? if ($kelompok_komponen == 1) { ?> width="50%" <? } else { ?> width="40%" <?}?> >Sub Komponen</th>
											<th>Nilai Standart</th>
											<? if ($kelompok_komponen == 1) { ?>
												<th>Jumlah Item Penilaian</th>
											<? } else { ?>
												<th>Batas Penilaian</th>
												<th width="20%">Keterangan</th>
											<? } ?>
											<th>Status</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<?
										$hasil = json_decode($subkomponen);
										foreach ($hasil as $k) {
											$data = "'" .
												$k->kd_sub_komponen . "','" .
												$k->nama_sub_komponen . "','" .
												$k->nilai_std . "','" .
												$k->nilai_maks . "','" .
												$k->keterangan . "','" .
												$kelompok_komponen 
												. "'";
											?>
											<tr>
												<td><?= $no; ?></td>
												<? if ($kelompok_komponen == 1) { ?>
													<td><a href="<?= base_url(); ?>itempenilaian/index/<?= $kd_komponen; ?>/<?= $k->kd_sub_komponen; ?>" class="btn bg-navy btn-xs"><?= $k->nama_sub_komponen; ?></a></td>
												<? } else { ?>
													<td><?= $k->nama_sub_komponen; ?></td>
												<? } ?>
												<th><?= $k->nilai_std; ?></th>
												<? if ($kelompok_komponen == 1) { ?>
													<th><?= $k->jml_item; ?> item <small>(Aktif: <?= $k->jml_item_aktif; ?>, Non Aktif: <?= $k->jml_item_nonaktif; ?>)</small></th>
												<? } else { ?>
													<th>0 - <?= $k->nilai_maks; ?></th>
													<td><?= $k->keterangan; ?></td>
												<? } ?>	
												<td><a href="<?= base_url(); ?>subkomponen/proses/4/<?= $kd_komponen; ?>/<?= $k->kd_sub_komponen; ?>/<?= $k->aktif; ?>/<?= $k->nama_sub_komponen; ?>" class="btn <?= $k->simbol_aktif_nonaktif; ?> btn-xs" title="Status" onclick="return confirm('Menonaktifkan data subkomponen dengan nama <?= $k->nama_sub_komponen; ?>, lanjutkan ?')"><?= $k->status; ?></td>
												<td>
													<!-- <a href="<?= base_url(); ?>itempenilaian/index/<?= $kd_komponen; ?>/<?= $k->kd_sub_komponen; ?>" class="btn bg-maroon btn-xs">Item Penilaian</a>  -->
													<a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#form_subkomponen" title="Ubah" onclick="ambil_subkomponen('<?= base_url(); ?>subkomponen/proses/2/<?= $kd_komponen; ?>/',<?= $data; ?>)"><i class="fa fa-pencil-square-o"></i></a>
													<a href="<?= base_url(); ?>subkomponen/proses/3/<?= $kd_komponen; ?>/<?= $k->kd_sub_komponen; ?>/<?= $k->aktif; ?>/<?= $k->nama_sub_komponen; ?>" class="btn btn-danger btn-xs" title="Hapus" onclick="return confirm('Menghapus data subkomponen dengan nama <?= $k->nama_sub_komponen; ?> beserta seluruh item penilaiannya dan data penilaian yang mengguanakan sub komponen tersebut, lanjutkan ?')"><i class="fa fa-trash-o"></i></a>
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
											<li><a href="<?= base_url(); ?>subkomponen/index/<?= $kd_komponen; ?>/1"><span class="glyphicon glyphicon-fast-backward"></a></li>
											<li><a href="<?= base_url(); ?>subkomponen/index/<?= $kd_komponen; ?>/<?= $link_prev; ?>"><span class="glyphicon glyphicon-step-backward"></a></li>
										<?
											}

											for ($i = $start_number; $i <= $end_number; $i++) {
												if ($page == $i) {
													$link_active = "";
													$link_color = "class='disabled'";
												} else {
													$link_active = base_url() . "subkomponen/index/$kd_kegiatan/$kd_komponen/$i";
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
											<li><a href="<?= base_url(); ?>subkomponen/index/<?= $kd_komponen; ?>/<?= $link_next; ?>"><span class="glyphicon glyphicon-step-forward"></a></li>
											<li><a href="<?= base_url(); ?>subkomponen/index/<?= $kd_komponen; ?>/<?= $jumlah_page; ?>"><span class="glyphicon glyphicon-fast-forward"></a></li>
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
			<div class="modal fade" id="form_subkomponen" tabindex="-1" role="dialog" aria-labelledby="form_subkomponen" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="form_subkomponen_label">Formulir Sub Komponen</h4>
						</div>
						<form id="frm_subkomponen" name="frm_subkomponen" method="post" action="<?= base_url(); ?>subkomponen/proses/1/<?= $kd_komponen; ?>/">
						<input type="hidden" class="form-control" name="kelompok" id="kelompok" value="" />
							<div class="modal-body">
								<div class="form-group">
									<label>Nama Sub Komponen</label>
									<input type="hidden" class="form-control" name="awal" id="awal" value="" />
									<input type="text" class="form-control" name="nama" id="nama" value="" autocomplete="off" required />
								</div>
								<div class="form-group">
									<label>Nilai Standart</label>
									<input type="number" class="form-control" name="nilai" id="nilai" value="" autocomplete="off" max=100 step=".01" required style="width:20%;" />
								</div>
								<? if ($kelompok_komponen == 2) { ?>
									<div class="form-group">
										<label>Batas Penilaian</label>
										<input type="number" class="form-control" name="maks" id="maks" value="" autocomplete="off" max=100  required style="width:20%;" />
									</div>
									<div class="form-group">
										<label>Keterangan</label>
										<textarea class="form-control" rows="5" name="ket" id="ket" required style="resize:none;"></textarea>
									</div>
								<? } ?>
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