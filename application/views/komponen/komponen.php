		<!-- Right side column. Contains the navbar and content of the page -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Komponen Penilaian
				</h1>
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
									<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_komponen" onclick="ambil_komponen('<?= base_url(); ?>komponen/proses/1/','','','')"><i class="fa fa-plus"></i> Tambah Komponen</a>
								</h3>

								<div style="float:right">
									<form class="form-inline" method="post" action="<?= base_url(); ?>komponen/index/" style="float:right;" onsubmit="showloading()">
										<div class="form-group">
											<input type="text" class="form-control" name="cari" required autocomplete="off" value="" placeholder="Isi nama komponen" />
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari</button>
											<a href="<?= base_url(); ?>komponen/index/" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i> Segarkan</a>
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
											<th width="10%">Kelompok</th>
											<th width="50%">Komponen</th>
											<th>Nilai Standart</th>
											<th>Jumlah Item Sub Komponen</th>
											<th>Status</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<?
										$hasil = json_decode($komponen);
										foreach ($hasil as $k) {
											$data = "'" .
												$k->kd_komponen . "','" .
												$k->kelompok . "','" .
												$k->nama_komponen . "','" .
												$k->nilai_std
												. "'";

											$link = "#";
											$alert_link = "alert('Nilai Standart dari komponen belum di set, silakan set terlebih dahulu !!!')";
											switch ($k->kelompok) {
												case 1:
													$nama_kelompok = "Proses";
													if($k->nilai_std > 0)
													{
														$link = base_url() . "subkomponen/index/" . $k->kd_komponen;
														$alert_link = "";
													}
													
													break;
												case 2:
													$nama_kelompok = "Hasil";
													if($k->nilai_std > 0)
													{
														//$link = base_url() . "itempenilaian/index/" . $k->kd_komponen . "/" . $k->kd_komponen . "2";
														$link = base_url() . "subkomponen/index/" . $k->kd_komponen;
														$alert_link = "";
													}
													break;
												default:
													$nama_kelompok = "";
													break;
											}
											?>
												<tr>
													<td><?= $no; ?></td>
													<th><?= $nama_kelompok; ?></th>
													<td><a href="<?= $link; ?>" class="btn bg-navy btn-xs" onclick="<?= $alert_link;?>"><?= $k->nama_komponen; ?></a></td>
													<th><?= $k->nilai_std; ?></th>
													<th><?= $k->jml_item; ?> item <small>(Aktif: <?= $k->jml_item_aktif; ?>, Non Aktif: <?= $k->jml_item_nonaktif; ?>)</small></th>
													<td><a href="<?= base_url(); ?>komponen/proses/4/<?= $k->kd_komponen; ?>/<?= $k->aktif; ?>/<?= $k->nama_komponen; ?>" class="btn <?= $k->simbol_aktif_nonaktif; ?> btn-xs" title="Status" onclick="return confirm('Menonaktifkan data komponen dengan nama <?= $k->nama_komponen; ?>, lanjutkan ?')"><?= $k->status; ?></td>
													<td>
														<!-- <a href="<?= base_url(); ?>subkomponen/index//<?= $k->kd_komponen; ?>" class="btn bg-maroon btn-xs">Sub Komponen</a>  -->
														<a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#form_komponen" title="Ubah" onclick="ambil_komponen('<?= base_url(); ?>komponen/proses/2//',<?= $data; ?>)"><i class="fa fa-pencil-square-o"></i></a>
														<a href="<?= base_url(); ?>komponen/proses/3/<?= $k->kd_komponen; ?>/<?= $k->aktif; ?>/<?= $k->nama_komponen; ?>" class="btn btn-danger btn-xs" title="Hapus" onclick="return confirm('Menghapus data komponen dengan nama <?= $k->nama_komponen; ?> beserta seluruh sub komponennya dan data penilaian yang mengguanakan komponen tersebut, lanjutkan ?')"><i class="fa fa-trash-o"></i></a>
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
											<li><a href="<?= base_url(); ?>komponen/index//1"><span class="glyphicon glyphicon-fast-backward"></a></li>
											<li><a href="<?= base_url(); ?>komponen/index//<?= $link_prev; ?>"><span class="glyphicon glyphicon-step-backward"></a></li>
										<?
											}

											for ($i = $start_number; $i <= $end_number; $i++) {
												if ($page == $i) {
													$link_active = "";
													$link_color = "class='disabled'";
												} else {
													$link_active = base_url() . "komponen/index/$kd_kegiatan/$i";
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
											<li><a href="<?= base_url(); ?>komponen/index//<?= $link_next; ?>"><span class="glyphicon glyphicon-step-forward"></a></li>
											<li><a href="<?= base_url(); ?>komponen/index//<?= $jumlah_page; ?>"><span class="glyphicon glyphicon-fast-forward"></a></li>
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
			<div class="modal fade" id="form_komponen" tabindex="-1" role="dialog" aria-labelledby="form_komponen" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="form_komponen_label">Formulir Komponen</h4>
						</div>
						<form id="frm_komponen" name="frm_komponen" method="post" action="<?= base_url(); ?>komponen/proses/1/">
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
			<!-- /.modal-content -->
		</div>
		<!-- /.content-wrapper -->