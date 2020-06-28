		<!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
				<h1>
					User
				</h1>
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
								<h3 align class="box-title">
									<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_user" onclick="ambil_user('<?= base_url();?>user/proses/1/','','','','','')"><i class="fa fa-plus"></i> Tambah User</a>
								</h3>
								
								<div style="float:right">
									<form class="form-inline" method="post" action="<?= base_url();?>user/" style="float:right;" onsubmit="showloading()">
										<div class="form-group">
											<input type="text" class="form-control" name="cari" required autocomplete="off" value="" placeholder="Isi email user" />
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari</button>
											<a href="<?= base_url();?>user/" class="btn btn-info btn-sm" ><i class="fa fa-refresh"></i> Segarkan</a>
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
											<th width="20%">Email</th>
											<th width="15%">Penilaian</th>
											<th width="20%">Setting Menu</th>
											<th width="35%">Komponen Penilaian</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<?
										$hasil = json_decode($user);
										foreach($hasil as $u)
										{ 
											$data = "'".
													$u->email."','".
													$u->password."','".
													$u->penilaian_pilih."','".
													$u->setting_menu_pilih."','".
													$u->komponen_akses_pilih
													."'";
										?>
										<tr>
											<td><?= $no;?></td>
											<td><?= $u->email;?></td>
											<td><?= $u->list_set_penilaian;?></td>
											<td><?= $u->list_set_menu;?></td>
											<td><?= $u->list_komponen_akses;?></td>
											<td>
												<a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#form_user" title="Ubah" onclick="ambil_user('<?= base_url();?>user/proses/2/<?= $u->kd_user;?>/',<?= $data;?>)" ><i class="fa fa-pencil-square-o"></i></a> 
												<a href="<?= base_url();?>user/proses/3/<?= $u->kd_user;?>" class="btn btn-danger btn-xs" title="Hapus" onclick="return confirm('Menghapus data user dengan email <?= $u->email;?>, lanjutkan ?')"><i class="fa fa-trash-o"></i></a> 
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
									<li><a href="<?= base_url();?>user/index/1" ><span class="glyphicon glyphicon-fast-backward"></a></li>
									<li><a href="<?= base_url();?>user/index/<?= $link_prev;?>" ><span class="glyphicon glyphicon-step-backward"></a></li>
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
											$link_active = base_url()."user/index/$i";
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
									<li><a href="<?= base_url();?>user/index/<?= $link_next;?>" ><span class="glyphicon glyphicon-step-forward"></a></li>
									<li><a href="<?= base_url();?>user/index/<?= $jumlah_page;?>" ><span class="glyphicon glyphicon-fast-forward"></a></li>
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
            <div class="modal fade" id="form_user" tabindex="-1" role="dialog" aria-labelledby="form_user" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="form_user_label">Formulir User</h4>
                        </div>
						<form id="frm_user" name="frm_user" method="post" action="<?= base_url();?>user/proses/1/">
                        <div class="modal-body">
							<div class="form-group">
								<label>Email</label>
								<input type="hidden" name="awal" id="awal" value="" />
								<input type="email" class="form-control" name="email" id="email" value="" maxlength=200 autocomplete="off" required />
							</div>
							<div class="form-group">
								<label>Password</label>
								<div class="input-group" style="width:50%;">
									<input type="password" class="form-control" name="password" id="password" value="" maxlength=100 autocomplete="new-password" required />      
									<span class="input-group-btn">
										<button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label>Penilaian</label>
								<select id="penilaian" name="penilaian[]" class="selectpicker dropup form-control" data-size="10" multiple data-hide-disabled="true" title="Pilih Penilaian..." required >
									<option value="selfass">Self Assesment</option>
									<option value="survey">Surveyor</option>
								</select>
							</div>
							<div class="form-group">
								<label>Setting Menu</label>
								<select id="setting_menu" name="setting_menu[]" class="selectpicker dropup form-control" data-size="10" multiple data-hide-disabled="true" title="Pilih Menu Setting..." >
									<option value="kegiatan">Kelola Kegiatan</option>
									<option value="komponen">Komponen Penilaian</option>
									<option value="user">User</option>
									<option value="log">Log Aktifitas</option>
								</select>
							</div>
							<div class="form-group">
								<label>Komponen Peniliaan</label>
								<select id="komponen" name="komponen[]" class="selectpicker dropup form-control" data-size="10" multiple data-hide-disabled="true" title="Pilih Komponen Penilaian..." required >
									<?foreach($komponen as $k){?>
										<option value="<?= $k->kd_komponen;?>"><?= $k->nama_komponen;?></option>
									<?}?>
								</select>
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