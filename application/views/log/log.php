		<!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
				<h1>
					Log Aktifitas
				</h1>
			</section> 	
				
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box"> 
							<div class="box-header with-border">
								<h3 align class="box-title">
									<a href="<?= base_url();?>log_aktifitas/laporan" class="btn btn-primary btn-sm" target="_blank" ><i class="fa fa-eye"></i> Laporan Log Aktifitas</a>
									<a href="<?= base_url();?>log_aktifitas/hapus" class="btn btn-danger btn-sm" onclick="return confirm('Hapus semua log aktifitas dari aplikasi wbbm ?')" ><i class="fa fa-recycle"></i> Bersihkan Log Aktifitas</a>
								</h3>
								
								<div style="float:right">
									<form class="form-inline" method="post" action="<?= base_url();?>log_aktifitas/" style="float:right;" onsubmit="showloading()">
										<div class="form-group">
											<input type="text" class="form-control" name="cari" required autocomplete="off" value="" placeholder="Isi aktifitas log" />
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari</button>
											<a href="<?= base_url();?>log_aktifitas/" class="btn btn-info btn-sm" ><i class="fa fa-refresh"></i> Segarkan</a>
										</div>
									</form>
								</div>    
							</div>
							<!-- /.box-header -->
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-bordered table-striped" id="mytable">
									<thead>
										<tr>
											<th>No</th>
											<th width="15%">Waktu Log</th>
											<th width="20%">Email User</th>
											<th width="12%">Ip Address</th>
											<th width="20%">Sistem</th>
											<th width="30%">Aktifitas</th>
										</tr>
									</thead>
									<tbody>
										<?foreach($log as $l){ ?>
										<tr>
											<td><?= $no;?></td>
											<td><?= date('d-m-Y h:i:s A',strtotime($l->waktulog));?></td>
											<td><?= $l->email;?></td>
											<td><?= $l->iplog;?></td>
											<td><?= $l->systlog;?></td>
											<td><?= $l->infolog;?></td>
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
									<li><a href="<?= base_url();?>log_aktifitas/index/1" ><span class="glyphicon glyphicon-fast-backward"></a></li>
									<li><a href="<?= base_url();?>log_aktifitas/index/<?= $link_prev;?>" ><span class="glyphicon glyphicon-step-backward"></a></li>
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
											$link_active = base_url()."log_aktifitas/index/$i";
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
									<li><a href="<?= base_url();?>log_aktifitas/index/<?= $link_next;?>" ><span class="glyphicon glyphicon-step-forward"></a></li>
									<li><a href="<?= base_url();?>log_aktifitas/index/<?= $jumlah_page;?>" ><span class="glyphicon glyphicon-fast-forward"></a></li>
									<?}?>
								</ul>
								<?}?>
							</div>
						</div>
					</div>
				</div>
            </section>
		</div>
		<!-- /.content-wrapper -->	