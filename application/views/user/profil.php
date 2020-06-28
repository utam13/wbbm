		<!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
				<h1>
					Profil User
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
					<div class="col-xs-6">
						<div class="box"> 
							<!-- /.box-header -->
							<div class="box-body">
								<form id="frm_user" name="frm_user" method="post" action="<?= base_url();?>user/ubah_password/<?= $email;?>">
								<div class="modal-body">
									<div class="form-group">
										<label>Email</label>
										<input type="email" class="form-control" name="email" id="email" value="<?= $email;?>" maxlength=200 autocomplete="off" required readonly />
									</div>
									<div class="form-group">
										<label>Password Lama</label>
										<input type="password" class="form-control" name="lama" id="lama" value="" maxlength=100 autocomplete="off" required />      
									</div>
									<div class="form-group">
										<label>Password Baru</label>
										<div class="input-group" style="width:50%;">
											<input type="password" class="form-control" name="password" id="password" value="" maxlength=100 autocomplete="new-password" required />      
											<span class="input-group-btn">
												<button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
											</span>
										</div>
									</div>
								</div>
								<div id="savebtn" class="modal-footer">
									<button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> Ubah Password</button>
								</div>
								</form>
							</div> 
						</div>
					</div>
				</div>
            </section>
        </div>
		<!-- /.content-wrapper -->	