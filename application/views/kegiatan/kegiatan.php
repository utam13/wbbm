		<!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
				<h1>
					WBBM 
					<small>Kegiatan</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?= base_url();?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
					<li class="active">Kegiatan</li>
				  </ol>
			</section> 	
				
			<section class="content">
				<? extract($pesan);?>
				<?if($kode_pesan != ""){?>
				<div class="callout <?= $jenisbox;?>">
					<h4><?= $judulmsg;?></h4>
					<?= str_replace("%7C","<br>", str_replace("%20"," ", $isipesan));?>
				</div>
				<?}?>
				<div class="row">
					<div class="col-xs-12">
						<div class="box">  
							<div class="box-header with-border">
								<?if(substr_count($setting, 'kegiatan') > 0 || $setting == "all"){?>
								<h3 align class="box-title">
									<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_kegiatan" onclick="ambil_kegiatan('<?= base_url();?>kegiatan/proses/1/','','','','')"><i class="fa fa-plus"></i> Tambah Kegiatan</a>
								</h3>
								<?}?>
								
								<div style="float:right">
									<form class="form-inline" method="post" action="<?= base_url();?>kegiatan" style="float:right;" onsubmit="showloading()">
										<div class="form-group">
											<input type="text" class="form-control" name="cari" required autocomplete="off" value="" placeholder="Isi nama kegiatan" />
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari</button>
											<a href="<?= base_url();?>kegiatan" class="btn btn-info btn-sm" ><i class="fa fa-refresh"></i> Segarkan</a>
										</div>
									</form>
								</div>    
                        
							</div>
							<!-- /.box-header -->
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-bordered table-striped" id="mytable">
									<thead>
										<tr>
											<th rowspan=2 width="2px" style="text-align:center;" >No</th>
											<th rowspan=2 width="50%" style="text-align:center;" >Kegiatan</th>
											<th rowspan=2 style="text-align:center;">Waktu Kegiatan</th>
											<th colspan=2 style="text-align:center;" >Total Nilai</th>
											<?if(substr_count($setting, 'kegiatan') > 0 || $setting == "all"){?>
											<th rowspan=2 style="text-align:center;" >&nbsp;</th>
											<?}?>
										</tr>
										<tr>
											<th style="text-align:center;" >Self Assesment</th>
											<th style="text-align:center;" >Surveyor</th>
										</tr>
									</thead>
									<tbody>
										<?
										foreach($kegiatan as $k)
										{ 
											$data = "'".
													$k->kd_kegiatan."','".
													$k->nama_kegiatan."','".
													$k->dari."','".
													$k->sampai
													."'";
										?>
										<tr>
											<td style="text-align:center;" ><?= $no;?></td>
											<td><a href="<?= base_url();?>kegiatan_nilai/index/<?= $k->kd_kegiatan;?>" class="btn bg-navy btn-xs"><?= $k->nama_kegiatan;?></a></td>
											<td style="text-align:center;" ><?= date('d-m-Y',strtotime($k->dari))." sampai ".date('d-m-Y',strtotime($k->sampai));?></td>
											<td style="text-align:center;" ><?= number_format($k->total_sa,2,'.',',');?></td>
											<td style="text-align:center;" ><?= number_format($k->total_sy,2,'.',',');?></td>
											<?if(substr_count($setting, 'kegiatan') > 0 || $setting == "all"){?>
											<td>
												<!--<a href="<?= base_url();?>komponen/index/<?= $k->kd_kegiatan;?>" class="btn bg-maroon btn-xs">Komponen Penilaian</a> -->
												<a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#form_kegiatan" title="Ubah" onclick="ambil_kegiatan('<?= base_url();?>kegiatan/proses/2/',<?= $data;?>)" ><i class="fa fa-pencil-square-o"></i></a> 
												<a href="<?= base_url();?>kegiatan/proses/3/<?= $k->kd_kegiatan;?>/<?= $k->nama_kegiatan;?>" class="btn btn-danger btn-xs" title="Hapus" onclick="return confirm('Menghapus data kegiatan dengan nama <?= $k->nama_kegiatan;?> beserta seluruh penilaiannya, lanjutkan ?')"><i class="fa fa-trash-o"></i></a> 
											</td>
											<?}?>
										</tr>
										<?$no++;}?>
									</tbody>
								</table>
							</div> 
							<div class="box-footer with-border">
								<?if($jumlah_page >0){?>
								<ul class="pagination" style="float:right;">
									<?if($page == 1){?>
									<li class="disabled"><a href="#"><span class="glyphicon glyphicon-fast-backward"></a></li>
									<li class="disabled"><a href="#"><span class="glyphicon glyphicon-step-backward"></a></li>
									<?}else{ $link_prev = ($page > 1)? $page - 1 : 1;?>
									<li><a href="<?= base_url();?>kegiatan/index/1" ><span class="glyphicon glyphicon-fast-backward"></a></li>
									<li><a href="<?= base_url();?>kegiatan/index/<?= $link_prev;?>" ><span class="glyphicon glyphicon-step-backward"></a></li>
									<?
									}

									for($i = $start_number; $i <= $end_number; $i++)
									{
										if($page == $i)
										{
											$link_active = "";
											$link_color = "class='disabled'";
										}
										else
										{
											$link_active = base_url()."kegiatan/index/$i";
											$link_color = "";
										}
									?>
									<li <?= $link_color;?>><a href="<?= $link_active;?>" ><?= $i;?></a></li>
									<?
									}
										
									if($page == $jumlah_page){
									?>
									<li class="disabled"><a href="#"><span class="glyphicon glyphicon-step-forward"></a></li>
									<li class="disabled"><a href="#"><span class="glyphicon glyphicon-fast-forward"></a></li>
									<?}else{ $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page; ?>
									<li><a href="<?= base_url();?>kegiatan/index/<?= $link_next;?>" ><span class="glyphicon glyphicon-step-forward"></a></li>
									<li><a href="<?= base_url();?>kegiatan/index/<?= $jumlah_page;?>" ><span class="glyphicon glyphicon-fast-forward"></a></li>
									<?}?>
								</ul>
								<?}?>
							</div>
						</div>
					</div>
				</div>
            </section>
			
			<!-- Modal -->
			<!--Pencarian-->
			<div class="modal fade" id="formcari" tabindex="-1" role="dialog" aria-labelledby="formcari" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="formcari_label">Pencarian</h4>
                        </div>
						<form method="post" action="#" method="post" >
                        <div class="modal-body">
							<div class="form-group">
								<label>Isi Pencarian</label>
								<input type="text" class="form-control" name="cari" required autocomplete="off" value="" />
                            </div>
                        </div>
                        <div id="savebtn" class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
						</div>
						</form>
					</div>
				</div>
			</div>
			
			<!--Formulir-->
            <div class="modal fade" id="form_kegiatan" tabindex="-1" role="dialog" aria-labelledby="form_kegiatan" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="form_kegiatan_label">Formulir Kegiatan</h4>
                        </div>
						<form id="frm_kegiatan" name="frm_kegiatan" method="post" action="<?= base_url();?>kegiatan/proses">
                        <div class="modal-body">
							<div class="form-group">
								<label>Nama Kegiatan</label>
								<input type="hidden" class="form-control" name="awal" id="awal" value="" />
								<input type="text" class="form-control" name="nama" id="nama" value="" autocomplete="off" required />
							</div>
							<div class="form-group">
								<label>Tanggal Mulai</label>
								<input type="date" class="form-control" name="dari" id="dari" value="" autocomplete="off" required style="width:30%;" />
							</div>
							<div class="form-group">
								<label>Tanggal Selesai</label>
								<input type="date" class="form-control" name="sampai" id="sampai" value="" autocomplete="off" required style="width:30%;" />
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