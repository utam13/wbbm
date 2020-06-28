		<!-- Right side column. Contains the navbar and content of the page -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>DASHBOARD</h1>
			</section>

			<section class="content">
				<div class="row">
					<div class="col-lg-12 col-xs-12">
						<div class="box">
							<div class="box-body">
								<form class="form-horizontal" method="post" action="<?= base_url(); ?>dashboard" method="post">
									<div class="form-group">
										<label class="col-sm-1 control-label">Kegiatan:</label>
										<div class="col-sm-6">
											<select class="form-control" name="kegiatan">
												<option value="">Pilih...</option>
												<?
												foreach ($kegiatan as $k) {
													echo "<option value='" . $k->kd_kegiatan . "'>" . $k->nama_kegiatan . " (" . date('d-m-Y', strtotime($k->dari)) . " sampai " . date('d-m-Y', strtotime($k->sampai)) . ")</option>";
												}
												?>
											</select>
										</div>
										<label class="col-sm-1 control-label">Versi:</label>
										<div class="col-sm-2">
											<select class="form-control" name="versi">
												<option value="">Pilih...</option>
												<option value="1">Self Assesment</option>
												<option value="2">Surveyor</option>
											</select>
										</div>
										<div class="col-sm-2">
											<button type="submit" class="btn btn-success"><i class="fa fa-search "></i></button>
											<a href="<?= base_url(); ?>dashboard" class="btn btn-default pull-right"><i class="fa fa-refresh "></i></a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header with-border">
								<h3 align class="box-title">Komponen Proses dari <?= $nama_kegiatan; ?> versi <?= $versi; ?></h3>
							</div>
							<div class="box-body">
								<? if ($jumlah_proses < 3) { ?>
									<div class="col-lg-2 col-xs-6"></div>
								<? } ?>
								<? $hasil1 = json_decode($komponen_proses); ?>
								<? foreach ($hasil1 as $kp) { ?>
									<div class="col-lg-4 col-xs-6">
										<div class="small-box bg-olive">
											<div class="inner">
												<h3>
													<?= number_format($kp->persen, 2, '.', ','); ?>%
												</h3>
												<p><?= $kp->nama_komponen; ?></p>
											</div>
											<div class="icon">
												<i class="fa fa-check"></i>
											</div>
											<a href="<?= base_url(); ?>penilaian/index/<?= $kode_kegiatan; ?>/<?= $kp->kd_komponen; ?>" class="small-box-footer">Detil <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								<? } ?>
								<!--
								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-green">
										<div class="inner">
											<h3> 
												0
											</h3> 
											<p>Komponen</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
										<a href="#" class="small-box-footer">Detil <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
							
								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-yellow">
										<div class="inner">
											<h3> 
												0
											</h3> 
											<p>Komponen</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
										<a href="#" class="small-box-footer">Detil <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
							
								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-red">
										<div class="inner">
											<h3> 
												0
											</h3> 
											<p>Komponen</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
										<a href="#" class="small-box-footer">Detil <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
							
								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-navy">
										<div class="inner">
											<h3> 
												0
											</h3> 
											<p>Komponen</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
										<a href="#" class="small-box-footer">Detil <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
						
								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-maroon">
										<div class="inner">
											<h3> 
												0
											</h3> 
											<p>Komponen</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
										<a href="#" class="small-box-footer">Detil <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
								-->
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-xs-12">
						<div class="box">
							<div class="box-header with-border">
								<h3 align class="box-title">Komponen Hasil dari <?= $nama_kegiatan; ?> versi <?= $versi; ?></h3>
							</div>
							<div class="box-body">
								<? if ($jumlah_hasil < 3) { ?>
									<div class="col-lg-2 col-xs-6"></div>
								<? } ?>
								<? $hasil2 = json_decode($komponen_hasil); ?>
								<? foreach ($hasil2 as $kh) { ?>
									<div class="col-lg-4 col-xs-6">
										<div class="small-box bg-purple">
											<div class="inner">
												<h3>
													<?= number_format($kh->persen, 2, '.', ','); ?>%
												</h3>
												<p><?= $kh->nama_komponen; ?></p>
											</div>
											<div class="icon">
												<i class="fa fa-check"></i>
											</div>
											<a href="<?= base_url(); ?>penilaian/index/<?= $kode_kegiatan; ?>/<?= $kh->kd_komponen; ?>" class="small-box-footer">Detil <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								<? } ?>

								<!--
								<div class="col-lg-2 col-xs-6"></div>
								
								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-olive">
										<div class="inner">
											<h3> 
												0
											</h3> 
											<p>Komponen</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
										<a href="#" class="small-box-footer">Detil <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
								
								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-purple">
										<div class="inner">
											<h3> 
												0
											</h3> 
											<p>Komponen</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
										<a href="#" class="small-box-footer">Detil <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
								
								<div class="col-lg-2 col-xs-6"></div>
								-->
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-xs-12">
						<div class="box">
							<div class="box-header with-border">
								<h3 align class="box-title">Total Penilaian dari <?= $nama_kegiatan; ?> versi <?= $versi; ?></h3>
							</div>
							<div class="box-body">
								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-blue">
										<div class="inner">
											<h3>
												<?= number_format($total_persen_nilai_proses, 2, ',', '.'); ?>%
											</h3>
											<p>Total Pengungkit</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
									</div>
								</div>

								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-blue">
										<div class="inner">
											<h3>
												<?= number_format($total_persen_nilai_hasil, 2, ',', '.'); ?>%
											</h3>
											<p>Total Hasil</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
									</div>
								</div>

								<div class="col-lg-4 col-xs-6">
									<div class="small-box bg-blue">
										<div class="inner">
											<h3>
												<?= number_format($total_keseluruhan, 2, ',', '.'); ?>
											</h3>
											<p>Total Nilai Keseluruhan</p>
										</div>
										<div class="icon">
											<i class="fa fa-check"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-xs-12">
						<div class="box">
							<div class="box-body">
								<div class="col-xs-12">
									<div id="dashboard_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</section>
		</div>
		<!-- /.content-wrapper -->