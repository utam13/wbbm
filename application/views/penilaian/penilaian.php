		<!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
				<h1>
					WBBM 
					<small><?= $nama_kegiatan;?></small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?= base_url();?>kegiatan"><i class="fa fa-bar-chart"></i> Kegiatan</a></li>
					<li><a href="<?= base_url();?>kegiatan_nilai/index/<?= $kd_kegiatan;?>">Komponen Penilaian</a></li>
					<li class="active">Sub Komponen Penilaian</li>
				</ol>
			</section> 	
				
			<section class="content">
				<?// extract($pesan);?>
				<?//if($kode_pesan != ""){?>
				<!--
				<div class="callout <?//= $jenisbox;?>">
					<h4><?//= $judulmsg;?></h4>
					<?//= str_replace("%7C","<br>", str_replace("%20"," ", $isipesan));?>
				</div>
				-->
				<?//}?>
				<div class="row">
					<div class="col-xs-12">
						<div class="box">  
							<div class="box-header with-border">
								<!--
								<h3 align class="box-title">
									<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_item" ><i class="fa fa-magic"></i> Update Penilaian</a>
									&nbsp;&nbsp; 
									<a href="<?= base_url();?>laporan/chart/<?= $kd_kegiatan;?>" target="_blank" class="btn bg-blue btn-sm" ><i class="fa fa-bar-chart"></i> Laporkan Dalam Bentuk Chart</a>
									<a href="<?= base_url();?>laporan/tabel/<?= $kd_kegiatan;?>" target="_blank" class="btn bg-blue btn-sm" ><i class="fa fa-table"></i> Laporkan Dalam Bentuk Tabel</a>
									
								</h3> 
								
								<div style="float:right">
									<form class="form-inline" method="post" action="<?= base_url();?>komponen/index/<?= $kd_kegiatan;?>" style="float:right;" onsubmit="showloading()">
										<div class="form-group">
											<input type="text" class="form-control" name="cari" required autocomplete="off" value="" placeholder="Isi nama komponen" />
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari</button>
											<a href="<?= base_url();?>komponen/index/<?= $kd_kegiatan;?>" class="btn btn-info btn-sm" ><i class="fa fa-refresh"></i> Segarkan</a>
										</div>
									</form>
								</div>    
								-->
							</div>
							<!-- /.box-header -->
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover table-bordered table-striped" id="mytable">
									<thead>
										<tr>
											<!--<th rowspan=2 width="1%" style="text-align:center;">No</th>-->
											<th rowspan=2 colspan=3 width="20%" style="text-align:center;">Komponen</th>
											<th colspan=2 width="10%" style="text-align:center;">Jawaban</th>
											<th colspan=2 width="10%" style="text-align:center;">Nilai</th>
											<th colspan=2 width="10%" style="text-align:center;">%</th>
											<th colspan=2 width="30%" style="text-align:center;">Program Evaluasi</th>
											<th rowspan=2 width="15%" style="text-align:center;">Keterangan</th>
										</tr>
										<tr>
											<th style="text-align:center;">Self Assesment</th>
											<th style="text-align:center;">Surveyor</th>
											<th style="text-align:center;">Self Assesment</th>
											<th style="text-align:center;">Surveyor</th>
											<th style="text-align:center;">Self Assesment</th>
											<th style="text-align:center;">Surveyor</th>
											<th style="text-align:center;">Self Assesment</th>
											<th style="text-align:center;">Surveyor</th>
										</tr>
									</thead>
									<tbody>
										<?
										//echo print_r($komponen);
										//echo print_r($subkomponen);
										//echo print_r($itempenilaian);
										$number = 1;
										$letters_big = range('A','Z');
										foreach($komponen as $k)
										{ 		
												$nilai_komp1 = 0;
												$persen_komp1 = 0;
												foreach($nilaikomp1 as $nk1)
												{
													if(($nk1->kd_komponen == $k->kd_komponen) && ($nk1->kd_kegiatan == $kd_kegiatan) && ($nk1->versi == 1))
													{
														$nilai_komp1 = $nk1->nilai;
														$persen_komp1 = $nk1->persen;
													}
												}
												
												$nilai_komp2 = 0;
												$persen_komp2 = 0;
												foreach($nilaikomp2 as $nk2)
												{
													if(($nk2->kd_komponen == $k->kd_komponen) && ($nk2->kd_kegiatan == $kd_kegiatan) && ($nk2->versi == 2))
													{
														$nilai_komp2 = $nk2->nilai;
														$persen_komp2 = $nk2->persen;
													}
												}
										?>
										<tr>
											<!--<th style="text-align:center;"><?//= $letters_big[$number-1];?></th>-->
											<th colspan=3 ><?= $k->nama_komponen;?></th>
											<th style="text-align:center;"><?= $k->nilai_std;?></th>
											<th style="text-align:center;"><?= $k->nilai_std;?></th>
											<td style="text-align:center;" id="<?= "k".$k->kd_komponen."n1";?>"><?= number_format($nilai_komp1,2,'.',',');?></td>
											<td style="text-align:center;" id="<?= "k".$k->kd_komponen."n2";?>"><?= number_format($nilai_komp2,2,'.',',');?></td>
											<td style="text-align:center;" id="<?= "k".$k->kd_komponen."p1";?>"><?= number_format($persen_komp1,2,'.',',');?>%</td>
											<td style="text-align:center;" id="<?= "k".$k->kd_komponen."p2";?>"><?= number_format($persen_komp2,2,'.',',');?>%</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?
										$no = 1;
										foreach($subkomponen as $sk)
										{ 
											if($sk->kd_komponen == $k->kd_komponen){
												
												$nilai_sub1 = 0;
												$persen_sub1 = 0;
												foreach($nilaisub1 as $ns1)
												{
													if(($ns1->kd_sub_komponen == $sk->kd_sub_komponen) && ($ns1->kd_kegiatan == $kd_kegiatan) && ($ns1->versi == 1))
													{
														$nilai_sub1 = $ns1->nilai;
														$persen_sub1 = $ns1->persen;
													}
												}
												
												$nilai_sub2 = 0;
												$persen_sub2 = 0;
												foreach($nilaisub2 as $ns2)
												{
													if(($ns2->kd_sub_komponen == $sk->kd_sub_komponen) && ($ns2->kd_kegiatan == $kd_kegiatan) && ($ns2->versi == 2))
													{
														$nilai_sub2 = $ns2->nilai;
														$persen_sub2 = $ns2->persen;
													}
												}
										?>
										<tr>
											<!--<td>&nbsp;</td>-->
											<th style="text-align:center;"><?= $no;?></th>
											<th colspan=2 ><?= $sk->nama_sub_komponen;?></th>
											<th style="text-align:center;"><?= $sk->nilai_std;?></th>
											<th style="text-align:center;"><?= $sk->nilai_std;?></th>
											<td style="text-align:center;" id="<?= "sk".$sk->kd_sub_komponen."n1";?>"><?= number_format($nilai_sub1,2,'.',',');?></td>
											<td style="text-align:center;" id="<?= "sk".$sk->kd_sub_komponen."n2";?>"><?= number_format($nilai_sub2,2,'.',',');?></td>
											<td style="text-align:center;" id="<?= "sk".$sk->kd_sub_komponen."p1";?>"><?= number_format($persen_sub1,2,'.',',');?>%</td>
											<td style="text-align:center;" id="<?= "sk".$sk->kd_sub_komponen."p2";?>"><?= number_format($persen_sub2,2,'.',',');?>%</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<?
										if($k->kelompok == 1)
										{
											$no2 = 1;
											$letters = range('a','z');
											foreach($itempenilaian as $ip)
											{ 
												if($ip->kd_sub_komponen == $sk->kd_sub_komponen){
													
													if($ip->model_jawaban == 2)
													{	
														$jml_pilihan = 1;
														foreach($spek_nilai as $sn)
														{
															if($sn->kd_item_penilaian == $ip->kd_item_penilaian)
															{
																$jml_pilihan ++;
															}
														}
													}
													else
													{
														$jml_pilihan = 0;
													}
													
													if($ip->model_jawaban != 4)
													{
														$jawab_item1 = "Jawab";
													}
													else
													{
														$jawab_item1 = "0.00 %";
													}
													
													$nilai_item1 = 0;
													$evaluasi1 = "";
													$dokumen1 = "";
													foreach($nilaiitem1 as $ni1)
													{
														if(($ni1->kd_item_penilaian == $ip->kd_item_penilaian) && ($ni1->kd_kegiatan == $kd_kegiatan) && ($ni1->versi == 1))
														{
															if($ip->model_jawaban != 4)
															{	
																$jawab_item1 = preg_replace("/\s+/","",$ni1->jawab);
															}
															else
															{
																$jawab_item1 = $ni1->jawab."%";
															}
															$nilai_item1 = $ni1->nilai;
															$evaluasi1 =  $ni1->evaluasi;
															$dokumen1 = $ni1->dokumen;
														}
													}
													if($jawab_item1 == "Jawab"){ $warna_tombol1 = "btn-default"; }else{ $warna_tombol1 = "btn-success"; }
													
													if($ip->model_jawaban != 4)
													{
														$jawab_item2 = "Jawab";
													}
													else
													{
														$jawab_item2 = "0.00 %";
													}
													$nilai_item2 = 0;
													$evaluasi2 = "";
													$dokumen2 = "";
													foreach($nilaiitem2 as $ni2)
													{
														if(($ni2->kd_item_penilaian == $ip->kd_item_penilaian) && ($ni2->kd_kegiatan == $kd_kegiatan) && ($ni2->versi == 2))
														{
															if($ip->model_jawaban != 4)
															{	
																$jawab_item2 = preg_replace("/\s+/","",$ni2->jawab);
															}
															else
															{
																$jawab_item2 = $ni2->jawab."%";
															}
															$nilai_item2 = $ni2->nilai;
															$evaluasi2 =  $ni2->evaluasi;
															$dokumen2 = $ni2->dokumen;
														}
													}
													
													if($jawab_item2 == "Jawab"){ $warna_tombol2 = "btn-default"; }else{ $warna_tombol2 = "btn-success"; }
											?>
											<tr>
												<!--<td>&nbsp;</td>-->
												<td>&nbsp;</td>
												<td style="text-align:center;"><?= $letters[$no2-1];?></td>
												<td><?= $ip->nama_item;?></td>
												<td style="text-align:center;">
													<?if($ip->model_jawaban != 4){?>
														<?if((substr_count($penilaian,"selfass")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
														<button type="button" class="btn btn-block <?= $warna_tombol1; ?> btn-xs" data-toggle="modal" data-target="#form_jawab" id="<?= "ip".$ip->kd_item_penilaian."j1";?>" onclick="jawab('1','<?= base_url();?>penilaian/proses','<?= $ip->nama_item?>','<?= $ip->model_jawaban;?>','<?= $kd_kegiatan;?>','<?= $ip->kd_item_penilaian;?>','<?= $sk->kd_sub_komponen;?>','<?= $k->kd_komponen;?>','<?= $jml_pilihan;?>','<?= preg_replace( "/\r|\n/", " ", $evaluasi1);?>','<?= $jawab_item1;?>')"><?= $jawab_item1;?></button>
														<?if($jawab_item1 != "Jawab"){?>
														<br><br>
														<a href="<?= base_url();?>penilaian/hapus/1/<?= $kd_kegiatan;?>/<?= $kd_komponen;?>/<?= $ip->kd_item_penilaian;?>/<?= $sk->kd_sub_komponen;?>/<?= $k->kelompok;?>" class="btn btn-block btn-danger btn-xs" title="Reset" onclick="return confirm('Menghapus jawaban item penilaian tersebut ?')">Reset</a>
														<?}}else{if($jawab_item1 == "Jawab"){echo "";}else{echo $jawab_item1;}}?>
													<?}else{ echo $jawab_item1; }?>
												</td>
												<td style="text-align:center;">
													<?if($ip->model_jawaban != 4){?>
														<?if((substr_count($penilaian,"survey")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
														<button type="button" class="btn btn-block <?= $warna_tombol2; ?> btn-xs" data-toggle="modal" data-target="#form_jawab" id="<?= "ip".$ip->kd_item_penilaian."j2";?>" onclick="jawab('2','<?= base_url();?>penilaian/proses','<?= $ip->nama_item?>','<?= $ip->model_jawaban;?>','<?= $kd_kegiatan;?>','<?= $ip->kd_item_penilaian;?>','<?= $sk->kd_sub_komponen;?>','<?= $k->kd_komponen;?>','<?= $jml_pilihan;?>','<?= preg_replace( "/\r|\n/", " ", $evaluasi2);?>','<?= $jawab_item2;?>')"><?= $jawab_item2;?></button>
														<?if($jawab_item2 != "Jawab"){?>
														<br><br>
														<a href="<?= base_url();?>penilaian/hapus/2/<?= $kd_kegiatan;?>/<?= $kd_komponen;?>/<?= $ip->kd_item_penilaian;?>/<?= $sk->kd_sub_komponen;?>/<?= $k->kelompok;?>" class="btn btn-block btn-danger btn-xs" title="Reset" onclick="return confirm('Menghapus jawaban item penilaian tersebut ?')">Reset</a>
														<?}}else{if($jawab_item2 == "Jawab"){echo "";}else{echo $jawab_item2;}}?>
													<?}else{ echo $jawab_item2; }?>
												</td>
												<td style="text-align:center;" id="<?= "ip".$ip->kd_item_penilaian."n1";?>"><?= number_format($nilai_item1,2,'.',',');?></td>
												<td style="text-align:center;" id="<?= "ip".$ip->kd_item_penilaian."n2";?>"><?= number_format($nilai_item2,2,'.',',');?></td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td id="<?= "ip".$ip->kd_item_penilaian."pe1";?>">
													<?= $evaluasi1;?>
													<?if($evaluasi1 != ""){?><br><br><?}?>
													<?if((substr_count($penilaian,"selfass")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
													<button type="button" class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#slide_dokumen" onclick="upload_dok('1','<?= $kd_kegiatan;?>','<?= $ip->kd_item_penilaian;?>','<?= $sk->kd_sub_komponen;?>','<?= $k->kd_komponen;?>')">Upload Dok.</button>
													<br><br>
													<?}?>
													
													<div class="btn-group">
													<?
													foreach($daftar_dokumen1 as $dd1)
													{
														if($dd1->kd_item_penilaian == $ip->kd_item_penilaian)
														{
													?>
														<button class="btn bg-olive btn-xs" data-toggle="modal" data-target="#slide_dokumen" onclick="info_dok('<?= $dd1->dokumen;?>','<?= $dd1->deskripsi;?>','<?= $dd1->nama_file;?>')"><?= $dd1->dokumen;?></button>

															<?if((substr_count($penilaian,"selfass")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
																<a href="<?= base_url();?>penilaian/hapus_dok/<?= $kd_kegiatan;?>/<?= $k->kd_komponen;?>/<?= $dd1->kd_item_penilaian;?>/<?= $dd1->kd_dokumen;?>/<?= $dd1->nama_file;?>" class="btn btn-danger btn-xs" title="Hapus Dokumen" onclick="return confirm('Menghapus Dokumen <?= $dd1->dokumen;?> ?')"><i class="fa fa-trash-o"></i></a>
															<?}?>
														<br><br>
													<?
														}
													}
													?>
													</div>   
													
												</td>
												<td id="<?= "ip".$ip->kd_item_penilaian."pe2";?>">
													<?= $evaluasi2;?>
													<?if($evaluasi2 != ""){?><br><br><?}?>
													<?if((substr_count($penilaian,"survey")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
													<button type="button" class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#slide_dokumen" onclick="upload_dok('2','<?= $kd_kegiatan;?>','<?= $ip->kd_item_penilaian;?>','<?= $sk->kd_sub_komponen;?>','<?= $k->kd_komponen;?>')">Upload Dok.</button>
													<br><br>
													<?}?>
													
													<div class="btn-group">
													<?
													foreach($daftar_dokumen2 as $dd2)
													{
														if($dd2->kd_item_penilaian == $ip->kd_item_penilaian)
														{
													?>
														<button class="btn bg-olive btn-xs" data-toggle="modal" data-target="#slide_dokumen" onclick="info_dok('<?= $dd2->dokumen;?>','<?= $dd2->deskripsi;?>','<?= $dd2->nama_file;?>')"><?= $dd2->dokumen;?></button>

															<?if((substr_count($penilaian,"survey")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
																<a href="<?= base_url();?>penilaian/hapus_dok/<?= $kd_kegiatan;?>/<?= $k->kd_komponen;?>/<?= $dd2->kd_item_penilaian;?>/<?= $dd2->kd_dokumen;?>/<?= $dd2->nama_file;?>" class="btn btn-danger btn-xs" title="Hapus Dokumen" onclick="return confirm('Menghapus Dokumen <?= $dd2->dokumen;?> ?')"><i class="fa fa-trash-o"></i></a>
															<?}?>
														<br><br>
													<?
														}
													}
													?>
													</div>
												</td>
												<td><?= nl2br($ip->keterangan);?></td>
											</tr>
											<?
											if($ip->model_jawaban == 4){
												$no3 = 1;
												foreach($subitem as $si){ 

												if($si->kd_item_penilaian == $ip->kd_item_penilaian){
													
													if($si->operasi_item != "Total")
													{
														$jawab_sub1 = "Jawab";
													}
													else
													{
														$jawab_sub1 = 0;
													}
													foreach($nilaisubitem1 as $nsi1)
													{
														if(($nsi1->kd_sub_item == $si->kd_sub_item) && ($nsi1->kd_kegiatan == $kd_kegiatan) && ($nsi1->versi == 1))
														{
															$jawab_sub1 = preg_replace("/\s+/","",$nsi1->nilai);
														}
													}
													if($jawab_sub1 == "Jawab"){ $warna_tombol_sub1 = "btn-default"; }else{ $warna_tombol_sub1 = "btn-success"; }
													
													if($si->operasi_item != "Total")
													{
														$jawab_sub2 = "Jawab";
													}
													else
													{
														$jawab_sub2 = 0;
													}
													foreach($nilaisubitem2 as $nsi2)
													{
														if(($nsi2->kd_sub_item == $si->kd_sub_item) && ($nsi2->kd_kegiatan == $kd_kegiatan) && ($nsi2->versi == 2))
														{
															$jawab_sub2 = preg_replace("/\s+/","",$nsi2->nilai);
														}
													}
													
													if($jawab_sub2 == "Jawab"){ $warna_tombol_sub2 = "btn-default"; }else{ $warna_tombol_sub2 = "btn-success"; }
											?>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td><?= "<b>".$letters[$no3-1].")</b> ".$si->nama_sub_item;?></td>
												<td id="<?= "si".$si->kd_sub_item."si1";?>" align="center">
													<?if($si->operasi_item != "Total"){?>
													
														<?if((substr_count($penilaian,"selfass")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
															<button type="button" class="btn btn-block <?= $warna_tombol_sub1; ?> btn-xs" data-toggle="modal" data-target="#form_jawab_sub" id="<?= "si".$si->kd_sub_item."j1";?>" onclick="jawab_sub('1','<?= base_url();?>penilaian/proses_sub_item','<?= $si->nama_sub_item;?>','<?= $kd_kegiatan;?>','<?= $k->kd_komponen;?>','<?= $sk->kd_sub_komponen;?>','<?= $si->kd_item_penilaian;?>','<?= $si->kd_sub_item;?>','<?= $si->operasi_item;?>','<?= $jawab_sub1;?>')"><?= $jawab_sub1;?></button>
															<?if($jawab_sub1 != "Jawab"){?>
															<br><br>
															<a href="<?= base_url();?>penilaian/hapus_sub_item/1/<?= $kd_kegiatan;?>/<?= $kd_komponen;?>/<?= $sk->kd_sub_komponen;?>/<?= $si->kd_item_penilaian;?>/<?= $si->kd_sub_item;?>/<?= $k->kelompok;?>" class="btn btn-block btn-danger btn-xs" title="Reset" onclick="return confirm('Menghapus jawaban sub item penilaian tersebut ?')">Reset</a>
														<?}
															}else{
																if($jawab_sub1 == "Jawab"){echo "";}else{echo $jawab_sub1;}
															}?>

													<?}else{
														echo $jawab_sub1;
													}?>
												</td>
												<td  id="<?= "si".$si->kd_sub_item."si2";?>"  align="center">
													<?if($si->operasi_item != "Total"){?>
													
														<?if((substr_count($penilaian,"survey")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
															<button type="button" class="btn btn-block <?= $warna_tombol_sub2; ?> btn-xs" data-toggle="modal" data-target="#form_jawab_sub" id="<?= "si".$si->kd_sub_item."j2";?>" onclick="jawab_sub('2','<?= base_url();?>penilaian/proses_sub_item','<?= $si->nama_sub_item;?>','<?= $kd_kegiatan;?>','<?= $k->kd_komponen;?>','<?= $sk->kd_sub_komponen;?>','<?= $si->kd_item_penilaian;?>','<?= $si->kd_sub_item;?>','<?= $si->operasi_item;?>','<?= $jawab_sub2;?>')"><?= $jawab_sub2;?></button>
															<?if($jawab_sub2 != "Jawab"){?>
															<br><br>
															<a href="<?= base_url();?>penilaian/hapus_sub_item/2/<?= $kd_kegiatan;?>/<?= $kd_komponen;?>/<?= $sk->kd_sub_komponen;?>/<?= $si->kd_item_penilaian;?>/<?= $si->kd_sub_item;?>/<?= $k->kelompok;?>" class="btn btn-block btn-danger btn-xs" title="Reset" onclick="return confirm('Menghapus jawaban sub item penilaian tersebut ?')">Reset</a>
														<?}
															}else{
																if($jawab_sub2 == "Jawab"){echo "";}else{echo $jawab_sub2;}
														}?>

													<?}else{
														echo $jawab_sub2;
													}?>
												</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<?
												$no3++;}}}?>
											<?$no2++;}}?>
										<?
										}else{
											$jawab_item1 = "Jawab";
											$nilai_item1 = 0;
											$evaluasi1 = "";
											$dokumen1 = "";
											foreach($nilaiitem1 as $ni1)
											{
												if(($ni1->kd_item_penilaian == $sk->kd_sub_komponen) && ($ni1->kd_kegiatan == $kd_kegiatan) && ($ni1->versi == 1))
												{
													$jawab_item1 = preg_replace("/\s+/","",$ni1->jawab);
													$nilai_item1 = $ni1->nilai;
													$evaluasi1 =  $ni1->evaluasi;
													$dokumen1 = $ni1->dokumen;
												}
													}
													if($jawab_item1 == "Jawab"){ $warna_tombol1 = "btn-default"; }else{ $warna_tombol1 = "btn-success"; }
													
													$jawab_item2 = "Jawab";
													$nilai_item2 = 0;
													$evaluasi2 = "";
													$dokumen2 = "";
													foreach($nilaiitem2 as $ni2)
													{
														if(($ni2->kd_item_penilaian == $sk->kd_sub_komponen) && ($ni2->kd_kegiatan == $kd_kegiatan) && ($ni2->versi == 2))
														{
															$jawab_item2 = preg_replace("/\s+/","",$ni2->jawab);
															$nilai_item2 = $ni2->nilai;
															$evaluasi2 =  $ni2->evaluasi;
															$dokumen2 = $ni2->dokumen;
														}
													}
													
													if($jawab_item2 == "Jawab"){ $warna_tombol2 = "btn-default"; }else{ $warna_tombol2 = "btn-success"; }
										?>
											<tr>
												<!--<td>&nbsp;</td>-->
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td style="text-align:center;">
													<?if((substr_count($penilaian,"selfass")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
													<button type="button" class="btn btn-block <?= $warna_tombol1; ?> btn-xs" data-toggle="modal" data-target="#form_jawab" id="<?= "ip".$sk->kd_sub_komponen."j1";?>" onclick="jawab('1','<?= base_url();?>penilaian/proses','<?= $sk->nama_sub_komponen;?>','3','<?= $kd_kegiatan;?>','<?= $sk->kd_sub_komponen;?>','<?= $sk->kd_sub_komponen;?>','<?= $k->kd_komponen;?>','<?= $sk->nilai_maks;?>','<?= preg_replace( "/\r|\n/", " ", $evaluasi1);?>','<?= $jawab_item1;?>')"><?= $jawab_item1;?></button>
													<?if($jawab_item1 != "Jawab"){?>
													<br><br>
													<a href="<?= base_url();?>penilaian/hapus/1/<?= $kd_kegiatan;?>/<?= $kd_komponen;?>/<?= $sk->kd_sub_komponen;?>/<?= $sk->kd_sub_komponen;?>/<?= $k->kelompok;?>" class="btn btn-block btn-danger btn-xs" title="Reset" onclick="return confirm('Menghapus jawaban item penilaian tersebut beserta dokumen yang di upload ?')">Reset</a>
													<?}}else{if($jawab_item1 == "Jawab"){echo "";}else{echo $jawab_item1;}}?>
												</td>
												<td style="text-align:center;">
													<?if((substr_count($penilaian,"survey")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
													<button type="button" class="btn btn-block <?= $warna_tombol2; ?> btn-xs" data-toggle="modal" data-target="#form_jawab" id="<?= "ip".$sk->kd_sub_komponen."j2";?>" onclick="jawab('2','<?= base_url();?>penilaian/proses','<?= $sk->nama_sub_komponen;?>','3','<?= $kd_kegiatan;?>','<?= $sk->kd_sub_komponen;?>','<?= $sk->kd_sub_komponen;?>','<?= $k->kd_komponen;?>','<?= $sk->nilai_maks;?>','<?= preg_replace( "/\r|\n/", " ", $evaluasi2);?>','<?= $jawab_item2;?>')"><?= $jawab_item2;?></button>
													<?if($jawab_item2 != "Jawab"){?>
													<br><br>
													<a href="<?= base_url();?>penilaian/hapus/2/<?= $kd_kegiatan;?>/<?= $kd_komponen;?>/<?= $sk->kd_sub_komponen;?>/<?= $sk->kd_sub_komponen;?>/<?= $k->kelompok;?>" class="btn btn-block btn-danger btn-xs" title="Reset" onclick="return confirm('Menghapus jawaban item penilaian tersebut beserta dokumen yang di upload ?')">Reset</a>
													<?}}else{if($jawab_item2 == "Jawab"){echo "";}else{echo $jawab_item2;}}?>
												</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td id="<?= "ip".$sk->kd_sub_komponen."pe1";?>">
													<?= $evaluasi1;?>
													<?if($evaluasi1 != ""){?><br><br><?}?>
													<?if((substr_count($penilaian,"selfass")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
													<button type="button" class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#slide_dokumen" onclick="upload_dok('1','<?= $kd_kegiatan;?>','<?= $sk->kd_sub_komponen;?>','<?= $sk->kd_sub_komponen;?>','<?= $k->kd_komponen;?>')">Upload Dok.</button>
													<br><br>
													<?}?>
													
													<div class="btn-group">
													<?
													//echo print_r($daftar_dokumen1);
													foreach($daftar_dokumen1 as $dd1)
													{
														if($dd1->kd_item_penilaian == $sk->kd_sub_komponen)
														{
													?>
														<button class="btn bg-olive btn-xs" data-toggle="modal" data-target="#slide_dokumen" onclick="info_dok('<?= $dd1->dokumen;?>','<?= $dd1->deskripsi;?>','<?= $dd1->nama_file;?>')"><?= $dd1->dokumen;?></button>
															<?if((substr_count($penilaian,"selfass")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
																<a href="<?= base_url();?>penilaian/hapus_dok/<?= $kd_kegiatan;?>/<?= $k->kd_komponen;?>/<?= $dd1->kd_item_penilaian;?>/<?= $dd1->kd_dokumen;?>/<?= $dd1->nama_file;?>" class="btn btn-danger btn-xs" title="Hapus Dokumen" onclick="return confirm('Menghapus Dokumen <?= $dd1->dokumen;?> ?')"><i class="fa fa-trash-o"></i></a>
															<?}?>
														<br><br>
													<?
														}
													}
													?>
													</div>   
													
												</td>
												<td id="<?= "ip".$sk->kd_sub_komponen."pe2";?>">
													<?= $evaluasi2;?>
													<?if($evaluasi2 != ""){?><br><br><?}?>
													<?if((substr_count($penilaian,"survey")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
													<button type="button" class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#slide_dokumen" onclick="upload_dok('2','<?= $kd_kegiatan;?>','<?= $sk->kd_sub_komponen;?>','<?= $sk->kd_sub_komponen;?>','<?= $k->kd_komponen;?>')">Upload Dok.</button>
													<br><br>
													<?}?>
													
													<div class="btn-group">
													<?
													//echo print_r($daftar_dokumen2);
													foreach($daftar_dokumen2 as $dd2)
													{
														if($dd2->kd_item_penilaian == $sk->kd_sub_komponen)
														{
													?>
														<button class="btn bg-olive btn-xs" data-toggle="modal" data-target="#slide_dokumen" onclick="info_dok('<?= $dd2->dokumen;?>','<?= $dd2->deskripsi;?>','<?= $dd2->nama_file;?>')"><?= $dd2->dokumen;?></button>

															<?if((substr_count($penilaian,"survey")>0 || $penilaian=="all") && (substr_count($nilai_komponen,$k->kd_komponen)>0 || $nilai_komponen=="all")){?>
																<a href="<?= base_url();?>penilaian/hapus_dok/<?= $kd_kegiatan;?>/<?= $k->kd_komponen;?>/<?= $dd2->kd_item_penilaian;?>/<?= $dd2->kd_dokumen;?>/<?= $dd2->nama_file;?>" class="btn btn-danger btn-xs" title="Hapus Dokumen" onclick="return confirm('Menghapus Dokumen <?= $dd2->dokumen;?> ?')"><i class="fa fa-trash-o"></i></a>
															<?}?>
														<br><br>
													<?
														}
													}
													?>
													</div>
												</td>
												<td><?= nl2br($sk->keterangan);?></td>
											</tr>
										<?}?>
										<?$no++;}}?>
										<?$number++;}?>
									</tbody>
								</table>
							</div> 
						</div>
					</div>
				</div>
            </section>
			
			<!-- Modal -->
			<!--Formulir Komponen-->
            <div class="modal fade" id="form_jawab" tabindex="-1" role="dialog" aria-labelledby="form_jawab" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="form_komponen_label">Jawaban</h4>
                        </div>
						<form id="frm_jawab" name="frm_jawab" method="post" action="<?= base_url();?>penilaian/proses/<?= $kelompok_komponen;?>" onsubmit="showloading()">
						<input type="hidden" name="versi" id="versi" value="">
						<input type="hidden" name="kd_kegiatan" id="kd_kegiatan" value="">
						<input type="hidden" name="kd_komponen" id="kd_komponen" value="">
						<input type="hidden" name="kd_sub_komponen" id="kd_sub_komponen" value="">
						<input type="hidden" name="kd_item" id="kd_item" value="">
						<input type="hidden" name="model_jawaban" id="model_jawaban" value="">
                        <div class="modal-body">
							<div class="form-group">
								<label id="soal"></label>
								<select class="form-control" name="nilai1" id="nilai1" style="width:20%;">
									<option value="">Pilih...</option>
									<option value="Ya">Ya</option>
									<option value="Tidak">Tidak</option>
								</select>
								<select class="form-control" name="nilai2" id="nilai2" style="width:15%;">
									<option value="">Pilih...</option>
									<option value="A">A</option>
									<option value="B">B</option>
								</select>
								<input type="number" class="form-control" name="nilai3" id="nilai3" value="" autocomplete="off" max=100 step=".01" required style="width:20%;" />
							</div>
							<div class="form-group">
								<label>Deskripsi</label>
								<textarea class="form-control" rows="5" name="evaluasi" id="evaluasi" required style="resize:none;"></textarea>
							</div>
							<!--
							<div class="form-group">
								<label>Dokumen</label>
								<div class="input-group">
									<input type="file" class="form-control" name="dokumen" id="dokumen" value="" accept=".gif,.jpg,.jpeg,.png,.pdf" >
									<div class="input-group-addon">
										(max: 300 kb - GIF/JPG/PNG/PDF)
									</div>
								</div>
							</div>
							-->
                        </div>
                        <div id="savebtn" class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                            <!--<button type="button" class="btn btn-primary" id="btn_simpan" onclick="proses_jawaban()"><i class="fa fa-save"></i> Simpan</button>-->
							<button type="submit" class="btn btn-primary" ><i class="fa fa-save"></i> Simpan</button>
						</div>
						</form>
					</div>
				</div>
			</div>

			<!--Formulir Sub Item-->
            <div class="modal fade" id="form_jawab_sub" tabindex="-1" role="dialog" aria-labelledby="form_jawab_sub" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="form_sub_label">Jawaban Sub Item</h4>
                        </div>
						<form id="frm_jawa_subb" name="frm_jawab_sub" method="post" action="<?= base_url();?>penilaian/proses_sub/<?= $kelompok_komponen;?>" onsubmit="showloading()">
						<input type="hidden" name="versi3" id="versi3" value="">
						<input type="hidden" name="kd_kegiatan3" id="kd_kegiatan3" value="">
						<input type="hidden" name="kd_komponen3" id="kd_komponen3" value="">
						<input type="hidden" name="kd_sub_komponen3" id="kd_sub_komponen3" value="">
						<input type="hidden" name="kd_item3" id="kd_item3" value="">
						<input type="hidden" name="kd_sub_item" id="kd_sub_item" value="">
						<input type="hidden" name="operasi_item" id="operasi_item" value="">
                        <div class="modal-body">
							<div class="form-group">
								<label id="soal_sub"></label>
								<input type="number" class="form-control" name="nilai_sub" id="nilai_sub" value="" autocomplete="off" max=100 step=".01" required style="width:20%;" />
							</div>
                        </div>
                        <div id="savebtn" class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                            <!--<button type="button" class="btn btn-primary" id="btn_simpan" onclick="proses_jawaban()"><i class="fa fa-save"></i> Simpan</button>-->
							<button type="submit" class="btn btn-primary" ><i class="fa fa-save"></i> Simpan</button>
						</div>
						</form>
					</div>
				</div>
			</div>

			<!--Silde Dokumen-->
            <div class="modal fade" id="slide_dokumen" tabindex="-1" role="dialog" aria-labelledby="slide_dokumen" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="slide_dokumen_label">Upload Dokumen</h4>
                        </div>
                        <form id="frm_upload" name="frm_upload" method="post" action="<?= base_url();?>penilaian/upload" enctype="multipart/form-data" onsubmit="showloading()">
						<input type="hidden" name="link_target" id="link_target" value="<?= base_url();?>">
						<input type="hidden" name="versi2" id="versi2" value="">
						<input type="hidden" name="kd_kegiatan2" id="kd_kegiatan2" value="">
						<input type="hidden" name="kd_komponen2" id="kd_komponen2" value="">
						<input type="hidden" name="kd_sub_komponen2" id="kd_sub_komponen2" value="">
						<input type="hidden" name="kd_item2" id="kd_item2" value="">
                        <div class="modal-body">
							<div class="form-group">
								<label>Nama Dokumen</label>
								<input type="text" id="namadok" name="namadok" class="form-control" maxlength=250 required > 
							</div>
							<div class="form-group">
								<label>Deskripsi Dokumen</label>
								<textarea class="form-control" rows="5" name="deskdok" id="deskdok" required style="resize:none;"></textarea>
							</div>
							<div class="form-group" id="uploaddok">
								<div class="input-group">
									<label class="input-group-btn">
									<span class="btn bg-maroon">
										Pilih Dokumen
										<input type="file" name="dokumen" id="dokumen" value="" accept=".gif,.jpg,.png,.pdf" required style="display: none;">
									</span>
									</label>
									<input type="text" id="fileselected" class="form-control" placeholder="Max: 10 Mb - GIF/JPG/PNG/PDF" readonly > 
								</div>
								<span class="help-block pull-right" style="color:red;">Max: 10 Mb - GIF/JPG/PNG/PDF</span>
							</div>
                        </div>
                        <div id="savebtn" class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                            <!--<button type="button" class="btn btn-primary" id="btn_simpan" onclick="proses_jawaban()"><i class="fa fa-save"></i> Simpan</button>-->
							<button type="submit" class="btn btn-primary" id="btn_simpan"><i class="fa fa-upload"></i> Upload</button>
							<a href="#" target="_blank" class="btn btn-primary" id="btn_buka" >Buka Dokumen</a>
						</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /.modal-content -->
        </div>
		<!-- /.content-wrapper -->	