		<!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
				<h1>
					Jawaban
					<small><?= $nama_komponen." - ".$nama_sub_komponen;?></small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?= base_url();?>itempenilaian/index/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>"><i class="fa fa-list"></i> Item Penilaian</a></li>
					<li class="active">Nilai Jawaban Penilaian</li>
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
								<h3 align class="box-title">Uraian Item Penilaian</h3>
							</div>
							<div class="box-body"><?= $uraian." (".$model_jawaban.")";?></div>
						</div>
					</div>
					
					<div class="col-xs-12">
						<div class="box"> 
							<div class="box-header with-border">
								<?if($model != 1){?>
								<h3 align class="box-title">
									<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_jawaban" onclick="ambil_jawaban('<?= base_url();?>jawaban/proses/1/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/','','','')"><i class="fa fa-plus"></i> Tambah Jawaban</a>
								</h3>
								
								<div style="float:right">
									<form class="form-inline" method="post" action="<?= base_url();?>jawaban/index/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/" style="float:right;" onsubmit="showloading()">
										<div class="form-group">
											<input type="text" class="form-control" name="cari" required autocomplete="off" value="" placeholder="Isi nama item penilaian" />
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari</button>
											<a href="<?= base_url();?>jawaban/index/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/" class="btn btn-info btn-sm" ><i class="fa fa-refresh"></i> Segarkan</a>
										</div>
									</form>
								</div>    
								<?}?>
							</div>
							<!-- /.box-header -->
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-bordered table-striped" id="mytable">
									<thead>
										<tr>
											<th width="2px">No</th>
											<th width="50%">Penilaian</th>
											<th>Skor</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<?
										foreach($jawaban as $k)
										{ 
											$data = "'".
													$k->kd_spek_nilai."','".
													$k->nama_nilai."','".
													$k->nilai
													."'";
										?>
										<tr>
											<td><?= $no;?></td>
											<td><?= $k->nama_nilai;?></td>
											<td><?= $k->nilai;?></td>
											<td>
												<a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#form_jawaban" title="Ubah" onclick="ambil_jawaban('<?= base_url();?>jawaban/proses/2/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/',<?= $data;?>)" ><i class="fa fa-pencil-square-o"></i></a> 
												<?if($model != 1){?>
												<a href="<?= base_url();?>jawaban/proses/3/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/<?= $k->kd_spek_nilai;?>/<?= $k->nama_nilai;?>/<?= $k->nilai;?>" class="btn btn-danger btn-xs" title="Hapus" onclick="return confirm('Menghapus data jawaban penilaian <?= $k->nama_nilai;?> dengan nilai <?= $k->nilai;?>, lanjutkan ?')"><i class="fa fa-trash-o"></i></a> 
												<?}?>
											</td>
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
									<li><a href="<?= base_url();?>jawaban/index/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/1" ><span class="glyphicon glyphicon-fast-backward"></a></li>
									<li><a href="<?= base_url();?>jawaban/index/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/<?= $link_prev;?>" ><span class="glyphicon glyphicon-step-backward"></a></li>
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
											$link_active = base_url()."jawaban/index/$kd_kegiatan/$kd_sub_komponen/$kd_komponen/$kd_item_penilaian/$i";
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
									<li><a href="<?= base_url();?>jawaban/index/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/<?= $link_next;?>" ><span class="glyphicon glyphicon-step-forward"></a></li>
									<li><a href="<?= base_url();?>jawaban/index/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/<?= $jumlah_page;?>" ><span class="glyphicon glyphicon-fast-forward"></a></li>
									<?}?>
								</ul>
								<?}?>
							</div>
						</div>
					</div>
				</div>
            </section>
			
			<!-- Modal -->
			<!--Formulir-->
            <div class="modal fade" id="form_jawaban" tabindex="-1" role="dialog" aria-labelledby="form_jawaban" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="form_jawaban_label">Formulir Jawaban Penilaian</h4>
                        </div>
						<form id="frm_jawaban" name="frm_jawaban" method="post" action="<?= base_url();?>jawaban/proses/1/<?= $kd_komponen;?>/<?= $kd_sub_komponen;?>/<?= $kd_item_penilaian;?>/">
                        <div class="modal-body">
							<div class="form-group">
								<label>Penilaian</label>
								<input type="text" class="form-control" name="nama" id="nama" value="" maxlength=10 autocomplete="off" readonly />
							</div>
							<div class="form-group">
								<label>Skor</label>
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