		<!-- Right side column. Contains the navbar and content of the page -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Komponen Penilaian
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?= base_url(); ?>kegiatan"><i class="fa fa-bar-chart"></i> Kegiatan</a></li>
					<li class="active">Komponen</li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header with-border">
								<!--<a href="<?= base_url(); ?>laporan/chart/<?= $kd_kegiatan; ?>" target="_blank" class="btn bg-blue btn-sm"><i class="fa fa-bar-chart"></i> Laporkan Dalam Bentuk Chart</a>
								<a href="<?= base_url(); ?>laporan/tabel/<?= $kd_kegiatan; ?>" target="_blank" class="btn bg-blue btn-sm"><i class="fa fa-table"></i> Laporkan Dalam Bentuk Tabel</a>-->
								<a href="#" class="btn bg-blue btn-sm" data-toggle="modal" data-target="#form_laporan"><i class="fa fa-bar-chart"></i> Laporan</a>

								<div style="float:right">
									<form class="form-inline" method="post" action="<?= base_url(); ?>kegiatan_nilai/index/<?= $kode; ?>" style="float:right;" onsubmit="showloading()">
										<div class="form-group">
											<input type="text" class="form-control" name="cari" required autocomplete="off" value="" placeholder="Isi nama komponen" />
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari</button>
											<a href="<?= base_url(); ?>kegiatan_nilai/index/<?= $kode; ?>" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i> Segarkan</a>
										</div>
									</form>
								</div>

							</div>
							<!-- /.box-header -->
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-bordered table-striped" id="mytable">
									<thead>
										<tr>
											<th rowspan=2 width="5%" style="text-align:center;">No</th>
											<th rowspan=2 width="80%" style="text-align:center;">Komponen</th>
											<th colspan=2 style="text-align:center;">Self Assesment</th>
											<th colspan=2 style="text-align:center;">Surveyor</th>
										</tr>
										<tr>
											<th style="text-align:center;">Nilai</th>
											<th style="text-align:center;">Persen</th>
											<th style="text-align:center;">Nilai</th>
											<th style="text-align:center;">Persen</th>
										</tr>
									</thead>
									<tbody>
										<?
										$hasil = json_decode($komponen);
										foreach ($hasil as $k) {
											?>
											<tr>
												<td style="text-align:center;"><?= $no; ?></td>
												<td><a href="<?= base_url(); ?>penilaian/index/<?= $k->kd_kegiatan; ?>/<?= $k->kd_komponen; ?>" class="btn bg-navy btn-xs"><?= $k->nama_komponen; ?></a></td>
												<td style="text-align:center;"><?= number_format($k->nilai_sa, 2, '.', ','); ?></td>
												<td style="text-align:center;"><?= number_format($k->persen_sa, 2, '.', ','); ?>%</td>
												<td style="text-align:center;"><?= number_format($k->nilai_sy, 2, '.', ','); ?></td>
												<td style="text-align:center;"><?= number_format($k->persen_sy, 2, '.', ','); ?>%</td>
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
											<li><a href="<?= base_url(); ?>kegiatan_nilai/index//1"><span class="glyphicon glyphicon-fast-backward"></a></li>
											<li><a href="<?= base_url(); ?>kegiatan_nilai/index//<?= $link_prev; ?>"><span class="glyphicon glyphicon-step-backward"></a></li>
										<?
											}

											for ($i = $start_number; $i <= $end_number; $i++) {
												if ($page == $i) {
													$link_active = "";
													$link_color = "class='disabled'";
												} else {
													$link_active = base_url() . "kegiatan_nilai/index/$kd_kegiatan/$i";
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
											<li><a href="<?= base_url(); ?>kegiatan_nilai/index//<?= $link_next; ?>"><span class="glyphicon glyphicon-step-forward"></a></li>
											<li><a href="<?= base_url(); ?>kegiatan_nilai/index//<?= $jumlah_page; ?>"><span class="glyphicon glyphicon-fast-forward"></a></li>
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
			<div class="modal fade" id="form_kegiatan_nilai" tabindex="-1" role="dialog" aria-labelledby="form_kegiatan_nilai" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="form_kegiatan_nilai_label">Formulir Komponen</h4>
						</div>
						<form id="frm_kegiatan_nilai" name="frm_kegiatan_nilai" method="post" action="<?= base_url(); ?>kegiatan_nilai/proses/1/">
							<div class="modal-body">
								<div class="form-group">
									<label>Kelompok Komponen</label>
									<select class="form-control" name="kelompok" id="kelompok" style="width:20%;" required>
										<option value="">Pilih...</option>
										<option value="1">Proses</option>
										<option value="2">Hasil</option>
									</select>
								</div>
								<div class="form-group">
									<label>Nama Komponen</label>
									<input type="hidden" class="form-control" name="awal" id="awal" value="" />
									<input type="text" class="form-control" name="nama" id="nama" value="" autocomplete="off" required />
								</div>
								<div class="form-group">
									<label>Nilai Standart</label>
									<input type="number" class="form-control" name="nilai" id="nilai" value="" autocomplete="off" max=100 step=".01" required style="width:20%;" />
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

			<div class="modal fade" id="form_laporan" tabindex="-1" role="dialog" aria-labelledby="form_laporan" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="form_laporan_label">Formulir Laporan</h4>
						</div>
						<form class="form-horizontal" id="frm_laporan" name="frm_laporan" method="post" target="_blank" action="<?= base_url(); ?>laporan/proses/<?= $kd_kegiatan; ?>">
							<div class="modal-body">
								<div class="form-group">
									<label class="col-sm-3 control-label">Jenis</label>
									<div class="col-sm-5">
										<select class="form-control" name="bentuk" id="bentuk" required>
											<option value="">Pilih...</option>
											<option value="1">Chart</option>
											<option value="2">Tabel</option>
											<option value="3">Excel</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Penilaian</label>
									<div class="col-sm-9">
										<select class="form-control" name="nilai" id="nilai" required>
											<option value="">Pilih...</option>
											<option value="0">Semua</option>
											<option value="1">Self Assesment</option>
											<option value="2">Surveyor</option>
										</select>
									</div>
								</div>
							</div>
							<div id="savebtn" class="modal-footer">
								<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Proses</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.content-wrapper -->