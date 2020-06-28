<?
if ($bentuk == 3) {
	$judul = $laporan . "-" . $nama_kegiatan . "-" . $nama_penilaian;

	//echo preg_replace("/[\s+-]/", "_", $judul);

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=" . preg_replace("/[\s+-]/", "_", $judul) . ".xls");
}
?>

<!DOCTYPE html>
<html>

<head>
	<style>
		.rekaman {
			border-collapse: collapse;
			font-family: time;
			font-size: 10pt;
			width: 100%
		}

		.rekaman th,
		.rekaman td {
			border: 1px solid #000000;
		}
	</style>
</head>

<body>
	<table width="100%">
		<tr>
			<td colspan=3 style="font-family:times;font-size:14pt;font-weight:bold;"><u><?= $laporan; ?></u></td>
		</tr>
		<tr>
			<td align="center" colspan=3>
				<hr style="border-top:3px solid #000000;">
			</td>
		</tr>
		<tr>
			<td valign="top">
				<? if ($bentuk == 3) { ?>
					<?= $nama_kegiatan . " - " . $nama_penilaian . " (" . date('d-m-Y', strtotime($dari)) . " sampai " . date('d-m-Y', strtotime($sampai)) . " ) "; ?>
				<? } else { ?>
					<table>
						<tr>
							<td style="font-family:times;font-size:10pt;">Nama Kegiatan</td>
							<td style="font-family:times;font-size:10pt;">:</td>
							<td style="font-family:times;font-size:10pt;"><?= $nama_kegiatan; ?></td>
						</tr>
						<tr>
							<td valign="top" style="font-family:times;font-size:10pt;">Periode</td>
							<td valign="top" style="font-family:times;font-size:10pt;width:5px;">:</td>
							<td style="font-family:times;font-size:10pt;"><?= date('d-m-Y', strtotime($dari)) . " sampai " . date('d-m-Y', strtotime($sampai)); ?></td>
						</tr>
						<tr>
							<td style="font-family:times;font-size:10pt;">Penilaian</td>
							<td style="font-family:times;font-size:10pt;">:</td>
							<td style="font-family:times;font-size:10pt;"><?= $nama_penilaian; ?></td>
						</tr>
					</table>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td align="center" colspan=3>
				<hr style="border-top:3px solid #000000;">
			</td>
		</tr>
		<tr>
			<td align="center" colspan=3>
				<table class="rekaman">
					<tr>
						<th <? if ($penilaian == 0) { ?> rowspan=2 <? } ?> colspan=4 width="20%" align="center" style="background-color:#6495ed;">Komponen</th>
						<th <? if ($penilaian == 0) { ?> colspan=2 <? } ?> width="10%" align="center" style="background-color:#6495ed;">Jawaban</th>
						<th <? if ($penilaian == 0) { ?> colspan=2 <? } ?> width="10%" align="center" style="background-color:#6495ed;">Nilai</th>
						<th <? if ($penilaian == 0) { ?> colspan=2 <? } ?> width="10%" align="center" style="background-color:#6495ed;">%</th>
						<th <? if ($penilaian == 0) { ?> colspan=2 <? } ?> width="30%" align="center" style="background-color:#6495ed;">Program Evaluasi</th>
						<th <? if ($penilaian == 0) { ?> rowspan=2 <? } ?> width="15%" align="center" style="background-color:#6495ed;">Keterangan</th>
					</tr>
					<? if ($penilaian == 0) { ?>
						<tr>
							<th align="center" style="background-color:#6495ed;">Self Assesment</th>
							<th align="center" style="background-color:#6495ed;">Surveyor</th>
							<th align="center" style="background-color:#6495ed;">Self Assesment</th>
							<th align="center" style="background-color:#6495ed;">Surveyor</th>
							<th align="center" style="background-color:#6495ed;">Self Assesment</th>
							<th align="center" style="background-color:#6495ed;">Surveyor</th>
							<th align="center" style="background-color:#6495ed;">Self Assesment</th>
							<th align="center" style="background-color:#6495ed;">Surveyor</th>
						</tr>
					<? } ?>
					<tr>
						<th <? if ($penilaian == 1 || $penilaian == 2) { ?> colspan=9 <? } else { ?> colspan=13 <? } ?> align="left" style="background-color:#00688b;color:#ffffff;">PROSES</th>
					</tr>
					<?
					$number = 1;
					$letters_big = range('A', 'Z');
					foreach ($komponen1 as $k1) {
						//if ($penilaian == 0 || $penilaian == 1) {
						$nilai_komp1 = 0;
						$persen_komp1 = 0;
						foreach ($nilaikomp1 as $nk1) {
							if (($nk1->kd_komponen == $k1->kd_komponen) && ($nk1->kd_kegiatan == $kd_kegiatan) && ($nk1->versi == 1)) {
								$nilai_komp1 = $nk1->nilai;
								$persen_komp1 = $nk1->persen;
							}
						}
						//}

						//if ($penilaian == 0 || $penilaian == 2) {
						$nilai_komp2 = 0;
						$persen_komp2 = 0;
						foreach ($nilaikomp2 as $nk2) {
							if (($nk2->kd_komponen == $k1->kd_komponen) && ($nk2->kd_kegiatan == $kd_kegiatan) && ($nk2->versi == 2)) {
								$nilai_komp2 = $nk2->nilai;
								$persen_komp2 = $nk2->persen;
							}
						}
						//}
						?>
						<tr>
							<th align="center" style="border-right:0px;background-color:#00bfff;"><?= $letters_big[$number - 1]; ?>.&nbsp;</th>
							<th colspan=3 align="left" style="border-left:0px;border-right:0px;border-top:0px;background-color:#00bfff;"><?= $k1->nama_komponen; ?></th>
							<? if ($penilaian == 0 || $penilaian == 1) { ?>
								<td align="center" style="border-left:0px;border-right:0px;background-color:#00bfff;"><?= $k1->nilai_std; ?></td>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 2) { ?>
								<td align="center" style="border-left:0px;border-right:0px;background-color:#00bfff;"><?= $k1->nilai_std; ?></td>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 1) { ?>
								<th style="background-color:#00bfff;" align="center"><?= number_format($nilai_komp1, 2, '.', ','); ?></th>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 2) { ?>
								<th style="background-color:#00bfff;" align="center"><?= number_format($nilai_komp2, 2, '.', ','); ?></th>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 1) { ?>
								<th style="background-color:#00bfff;" align="center"><?= number_format($persen_komp1, 2, '.', ','); ?>%</th>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 2) { ?>
								<th style="background-color:#00bfff;" align="center"><?= number_format($persen_komp2, 2, '.', ','); ?>%</th>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 1) { ?>
								<td style="border-left:0px;border-right:0px;background-color:#00bfff;">&nbsp;</td>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 2) { ?>
								<td style="border-left:0px;border-right:0px;background-color:#00bfff;">&nbsp;</td>
							<? } ?>
							<td style="border-left:0px;background-color:#00bfff;">&nbsp;</td>
						</tr>
						<?
							$no = 1;
							foreach ($subkomponen as $sk) {
								if ($sk->kd_komponen == $k1->kd_komponen) {
									$nilai_sub1 = 0;
									$persen_sub1 = 0;
									foreach ($nilaisub1 as $ns1) {
										if (($ns1->kd_sub_komponen == $sk->kd_sub_komponen) && ($ns1->kd_kegiatan == $kd_kegiatan) && ($ns1->versi == 1)) {
											$nilai_sub1 = $ns1->nilai;
											$persen_sub1 = $ns1->persen;
										}
									}

									$nilai_sub2 = 0;
									$persen_sub2 = 0;
									foreach ($nilaisub2 as $ns2) {
										if (($ns2->kd_sub_komponen == $sk->kd_sub_komponen) && ($ns2->kd_kegiatan == $kd_kegiatan) && ($ns2->versi == 2)) {
											$nilai_sub2 = $ns2->nilai;
											$persen_sub2 = $ns2->persen;
										}
									}
									?>
								<tr>
									<td style="border-right:0px;background-color:#00ced1;">&nbsp;</td>
									<th align="center" valign="top" style="border-left:0px;border-right:0px;background-color:#00ced1;"><?= $no; ?>.&nbsp;</th>
									<th colspan=2 align="left" style="border-left:0px;border-right:0px;background-color:#00ced1;"><?= $sk->nama_sub_komponen; ?></th>
									<? if ($penilaian == 0 || $penilaian == 1) { ?>
										<td align="center" style="border-left:0px;border-right:0px;background-color:#00ced1;"><?= $sk->nilai_std; ?></td>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 2) { ?>
										<td align="center" style="border-left:0px;border-right:0px;background-color:#00ced1;"><?= $sk->nilai_std; ?></td>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 1) { ?>
										<th style="background-color:#00ced1;" align="center"><?= number_format($nilai_sub1, 2, '.', ','); ?></th>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 2) { ?>
										<th style="background-color:#00ced1;" align="center"><?= number_format($nilai_sub2, 2, '.', ','); ?></th>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 1) { ?>
										<th style="background-color:#00ced1;" align="center"><?= number_format($persen_sub1, 2, '.', ','); ?>%</th>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 2) { ?>
										<th style="background-color:#00ced1;" align="center"><?= number_format($persen_sub2, 2, '.', ','); ?>%</th>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 1) { ?>
										<td style="border-left:0px;border-right:0px;background-color:#00ced1;">&nbsp;</td>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 2) { ?>
										<td style="border-left:0px;border-right:0px;background-color:#00ced1;">&nbsp;</td>
									<? } ?>
									<td style="border-left:0px;background-color:#00ced1;">&nbsp;</td>
								</tr>
								<?
											$no2 = 1;
											$letters = range('a', 'z');
											foreach ($itempenilaian as $ip) {

												if ($ip->kd_sub_komponen == $sk->kd_sub_komponen) {
													if ($ip->model_jawaban == 2) {
														$jml_pilihan = 1;
														foreach ($spek_nilai as $sn) {
															if ($sn->kd_item_penilaian == $ip->kd_item_penilaian) {
																$jml_pilihan++;
															}
														}
													} else {
														$jml_pilihan = 0;
													}

													$jawab_item1 = "-";
													$nilai_item1 = 0;
													$evaluasi1 = "-";

													foreach ($nilaiitem1 as $ni1) {
														if (($ni1->kd_item_penilaian == $ip->kd_item_penilaian) && ($ni1->kd_kegiatan == $kd_kegiatan) && ($ni1->versi == 1)) {

															if ($ip->model_jawaban != 4) {
																$jawab_item1 = $ni1->jawab;
															} else {
																$jawab_item1 = $ni1->jawab . "%";
															}
															$nilai_item1 = $ni1->nilai;
															$evaluasi1 =  $ni1->evaluasi;
															$dokumen1 = $ni1->dokumen;
														}
													}

													$jawab_item2 = "-";
													$nilai_item2 = 0;
													$evaluasi2 = "-";

													foreach ($nilaiitem2 as $ni2) {
														if (($ni2->kd_item_penilaian == $ip->kd_item_penilaian) && ($ni2->kd_kegiatan == $kd_kegiatan) && ($ni2->versi == 2)) {

															if ($ip->model_jawaban != 4) {
																$jawab_item2 = $ni2->jawab;
															} else {
																$jawab_item2 =  $ni2->jawab . "%";
															}
															$nilai_item2 = $ni2->nilai;
															$evaluasi2 =  $ni2->evaluasi;
															$dokumen2 = $ni2->dokumen;
														}
													}
													?>
										<tr>
											<td style="border-right:0px;">&nbsp;</td>
											<td style="border-left:0px;border-right:0px;">&nbsp;</td>
											<td align="center" valign="top" style="border-left:0px;border-right:0px;"><?= $letters[$no2 - 1]; ?>.&nbsp;</td>
											<td align="left" valign="top" style="border-left:0px;border-right:0px;"><?= $ip->nama_item; ?></td>
											<? if ($penilaian == 0 || $penilaian == 1) { ?>
												<td align="center"><?= $jawab_item1; ?></td>
											<? } ?>
											<? if ($penilaian == 0 || $penilaian == 2) { ?>
												<td align="center"><?= $jawab_item2; ?></td>
											<? } ?>
											<? if ($penilaian == 0 || $penilaian == 1) { ?>
												<td align="center"><?= number_format($nilai_item1, 2, '.', ','); ?></td>
											<? } ?>
											<? if ($penilaian == 0 || $penilaian == 2) { ?>
												<td align="center"><?= number_format($nilai_item2, 2, '.', ','); ?></td>
											<? } ?>
											<? if ($penilaian == 0 || $penilaian == 1) { ?>
												<td style="border-left:0px;border-right:0px;">&nbsp;</td>
											<? } ?>
											<? if ($penilaian == 0 || $penilaian == 2) { ?>
												<td style="border-left:0px;border-right:0px;">&nbsp;</td>
											<? } ?>
											<? if ($penilaian == 0 || $penilaian == 1) { ?>
												<td><?= $evaluasi1; ?></td>
											<? } ?>
											<? if ($penilaian == 0 || $penilaian == 2) { ?>
												<td><?= $evaluasi2; ?></td>
											<? } ?>
											<td><?= nl2br($ip->keterangan); ?></td>
										</tr>
										<?
															if ($ip->model_jawaban == 4) {
																$no3 = 1;
																foreach ($subitem as $si) {

																	if ($si->kd_item_penilaian == $ip->kd_item_penilaian) {

																		if ($si->operasi_item != "Total") {
																			$jawab_sub1 = "";
																		} else {
																			$jawab_sub1 = 0;
																		}

																		foreach ($nilaisubitem1 as $nsi1) {
																			if (($nsi1->kd_sub_item == $si->kd_sub_item) && ($nsi1->kd_kegiatan == $kd_kegiatan) && ($nsi1->versi == 1)) {
																				$jawab_sub1 = preg_replace("/\s+/", "", $nsi1->nilai);
																			}
																		}

																		if ($si->operasi_item != "Total") {
																			$jawab_sub2 = "";
																		} else {
																			$jawab_sub2 = 0;
																		}

																		foreach ($nilaisubitem2 as $nsi2) {
																			if (($nsi2->kd_sub_item == $si->kd_sub_item) && ($nsi2->kd_kegiatan == $kd_kegiatan) && ($nsi2->versi == 2)) {
																				$jawab_sub2 = preg_replace("/\s+/", "", $nsi2->nilai);
																			}
																		}
																		?>
													<tr>
														<td style="border-right:0px;">&nbsp;</td>
														<td style="border-left:0px;border-right:0px;">&nbsp;</td>
														<td style="border-left:0px;border-right:0px;">&nbsp;</td>
														<td style="border-left:0px;"><?= $letters[$no3 - 1] . ") " . $si->nama_sub_item; ?></td>
														<? if ($penilaian == 0 || $penilaian == 1) { ?>
															<td id="<?= "si" . $si->kd_sub_item . "si1"; ?>" align="center"><?= $jawab_sub1; ?></td>
														<? } ?>
														<? if ($penilaian == 0 || $penilaian == 2) { ?>
															<td id="<?= "si" . $si->kd_sub_item . "si2"; ?>" align="center"><?= $jawab_sub2; ?></td>
														<? } ?>
														<? if ($penilaian == 0 || $penilaian == 1) { ?>
															<td style="border-left:0px;border-right:0px;">&nbsp;</td>
														<? } ?>
														<? if ($penilaian == 0 || $penilaian == 2) { ?>
															<td style="border-left:0px;border-right:0px;">&nbsp;</td>
														<? } ?>
														<? if ($penilaian == 0 || $penilaian == 1) { ?>
															<td style="border-left:0px;border-right:0px;">&nbsp;</td>
														<? } ?>
														<? if ($penilaian == 0 || $penilaian == 2) { ?>
															<td style="border-left:0px;border-right:0px;">&nbsp;</td>
														<? } ?>
														<? if ($penilaian == 0 || $penilaian == 1) { ?>
															<td style="border-left:0px;border-right:0px;">&nbsp;</td>
														<? } ?>
														<? if ($penilaian == 0 || $penilaian == 2) { ?>
															<td style="border-left:0px;border-right:0px;">&nbsp;</td>
														<? } ?>
														<td style="border-left:0px;">&nbsp;</td>
													</tr>
					<?
													$no3++;
												}
											}
										}
										$no2++;
									}
								}
								$no++;
							}
						}

						$number++;
					}
					?>
					<tr>
						<th <? if ($penilaian == 1 || $penilaian == 2) { ?> colspan=5 <? } else { ?> colspan=6 <? } ?> align="right" style="background-color:#cccccc;">Total Pengungkit&nbsp;(<?= $total_nilai_std_proses; ?>)</th>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<th align="center" style="background-color:#cccccc;"><?= number_format($total_nilai_komp_proses1, 2, '.', ','); ?></th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<th align="center" style="background-color:#cccccc;"><?= number_format($total_nilai_komp_proses2, 2, '.', ','); ?></th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<th align="center" style="background-color:#cccccc;"><?= number_format($total_persen_proses1, 2, '.', ','); ?> %</th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<th align="center" style="background-color:#cccccc;"><?= number_format($total_persen_proses2, 2, '.', ','); ?> %</th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#cccccc;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#cccccc;">&nbsp;</td>
						<? } ?>
						<td style="border-left:0px;background-color:#cccccc;">&nbsp;</td>
					</tr>
					<tr>
						<th <? if ($penilaian == 1 || $penilaian == 2) { ?> colspan=5 <? } else { ?> colspan=6 <? } ?> align="right" style="border-right:0px;background-color:#fffff;">&nbsp;</th>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<td style="border-left:0px;background-color:#ffffff;">&nbsp;</td>
					</tr>
					<tr>
						<th <? if ($penilaian == 1 || $penilaian == 2) { ?> colspan=9 <? } else { ?> colspan=13 <? } ?> align="left" style="background-color:#00688b;color:#ffffff;">HASIL</th>
					</tr>
					<?
					$number = 1;
					$letters_big = range('A', 'Z');
					foreach ($komponen2 as $k2) {
						$nilai_komp1 = 0;
						$persen_komp1 = 0;
						foreach ($nilaikomp1 as $nk1) {
							if (($nk1->kd_komponen == $k2->kd_komponen) && ($nk1->kd_kegiatan == $kd_kegiatan) && ($nk1->versi == 1)) {
								$nilai_komp1 = $nk1->nilai;
								$persen_komp1 = $nk1->persen;
							}
						}

						$nilai_komp2 = 0;
						$persen_komp2 = 0;
						foreach ($nilaikomp2 as $nk2) {
							if (($nk2->kd_komponen == $k2->kd_komponen) && ($nk2->kd_kegiatan == $kd_kegiatan) && ($nk2->versi == 2)) {
								$nilai_komp2 = $nk2->nilai;
								$persen_komp2 = $nk2->persen;
							}
						}
						?>
						<tr>
							<th align="center" style="border-right:0px;background-color:#00bfff;"><?= $letters_big[$number - 1]; ?>.&nbsp;</th>
							<th colspan=3 align="left" style="border-left:0px;border-right:0px;border-top:0px;background-color:#00bfff;"><?= $k2->nama_komponen; ?></th>
							<? if ($penilaian == 0 || $penilaian == 1) { ?>
								<td style="border-left:0px;border-right:0px;background-color:#00bfff;">&nbsp;</td>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 2) { ?>
								<td style="border-left:0px;border-right:0px;background-color:#00bfff;">&nbsp;</td>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 1) { ?>
								<th style="background-color:#00bfff;" align="center"><?= number_format($nilai_komp1, 2, '.', ','); ?></th>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 2) { ?>
								<th style="background-color:#00bfff;" align="center"><?= number_format($nilai_komp2, 2, '.', ','); ?></th>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 1) { ?>
								<th style="background-color:#00bfff;" align="center"><?= number_format($persen_komp1, 2, '.', ','); ?>%</th>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 2) { ?>
								<th style="background-color:#00bfff;" align="center"><?= number_format($persen_komp2, 2, '.', ','); ?>%</th>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 1) { ?>
								<td style="border-left:0px;border-right:0px;background-color:#00bfff;">&nbsp;</td>
							<? } ?>
							<? if ($penilaian == 0 || $penilaian == 2) { ?>
								<td style="border-left:0px;border-right:0px;background-color:#00bfff;">&nbsp;</td>
							<? } ?>
							<td style="border-left:0px;background-color:#00bfff;">&nbsp;</td>
						</tr>
						<?
							$no = 1;
							foreach ($subkomponen as $sk) {
								if ($sk->kd_komponen == $k2->kd_komponen) {
									$nilai_sub1 = 0;
									$persen_sub1 = 0;
									$evaluasi1 = "-";
									foreach ($nilaisub1 as $ns1) {
										if (($ns1->kd_sub_komponen == $sk->kd_sub_komponen) && ($ns1->kd_kegiatan == $kd_kegiatan) && ($ns1->versi == 1)) {
											$nilai_sub1 = $ns1->nilai;
											$persen_sub1 = $ns1->persen;
										}
									}

									foreach ($nilaiitem1 as $ni1) {
										if (($ni1->kd_item_penilaian == $sk->kd_sub_komponen) && ($ni1->kd_kegiatan == $kd_kegiatan) && ($ni1->versi == 1)) {
											$evaluasi1 =  $ni1->evaluasi;
										}
									}

									$nilai_sub2 = 0;
									$persen_sub2 = 0;
									$evaluasi2 = "-";
									foreach ($nilaisub2 as $ns2) {
										if (($ns2->kd_sub_komponen == $sk->kd_sub_komponen) && ($ns2->kd_kegiatan == $kd_kegiatan) && ($ns2->versi == 2)) {
											$nilai_sub2 = $ns2->nilai;
											$persen_sub2 = $ns2->persen;
										}
									}

									foreach ($nilaiitem2 as $ni2) {
										if (($ni2->kd_item_penilaian == $sk->kd_sub_komponen) && ($ni2->kd_kegiatan == $kd_kegiatan) && ($ni2->versi == 1)) {
											$evaluasi12 =  $ni2->evaluasi;
										}
									}
									?>
								<tr>
									<td style="border-right:0px;">&nbsp;</td>
									<th align="center" valign="top" style="border-left:0px;border-right:0px;"><?= $no; ?>.&nbsp;</th>
									<th colspan=2 align="left" valign="top" style="border-left:0px;border-right:0px;"><?= $sk->nama_sub_komponen; ?></th>
									<? if ($penilaian == 0 || $penilaian == 1) { ?>
										<td style="border-left:0px;border-right:0px;">&nbsp;</td>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 2) { ?>
										<td style="border-left:0px;border-right:0px;">&nbsp;</td>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 1) { ?>
										<th valign="top" align="center"><?= number_format($nilai_sub1, 2, '.', ','); ?></th>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 2) { ?>
										<th valign="top" align="center"><?= number_format($nilai_sub2, 2, '.', ','); ?></th>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 1) { ?>
										<th valign="top" align="center"><?= number_format($persen_sub1, 2, '.', ','); ?>%</th>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 2) { ?>
										<th valign="top" align="center"><?= number_format($persen_sub2, 2, '.', ','); ?>%</th>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 1) { ?>
										<td valign="top"><?= $evaluasi1; ?></td>
									<? } ?>
									<? if ($penilaian == 0 || $penilaian == 2) { ?>
										<td valign="top"><?= $evaluasi2; ?></td>
									<? } ?>
									<td valign="top"><?= nl2br($sk->keterangan); ?></td>
								</tr>



					<?
								$no++;
							}
						}

						$number++;
					}
					?>
					<tr>
						<th <? if ($penilaian == 1 || $penilaian == 2) { ?> colspan=5 <? } else { ?> colspan=6 <? } ?> align="right" style="background-color:#cccccc;">Total Hasil&nbsp;(<?= $total_nilai_std_hasil; ?>)</th>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<th align="center" style="background-color:#cccccc;"><?= number_format($total_nilai_komp_hasil1, 2, '.', ','); ?></th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<th align="center" style="background-color:#cccccc;"><?= number_format($total_nilai_komp_hasil2, 2, '.', ','); ?> </th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<th align="center" style="background-color:#cccccc;"><?= number_format($total_persen_hasil1, 2, '.', ','); ?> %</th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<th align="center" style="background-color:#cccccc;"><?= number_format($total_persen_hasil2, 2, '.', ','); ?> %</th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#cccccc;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#cccccc;">&nbsp;</td>
						<? } ?>
						<td style="border-left:0px;background-color:#cccccc;">&nbsp;</td>
					</tr>
					<tr>
						<th <? if ($penilaian == 1 || $penilaian == 2) { ?> colspan=5 <? } else { ?> colspan=6 <? } ?> align="right" style="border-right:0px;background-color:#fffff;">&nbsp;</th>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ffffff;">&nbsp;</td>
						<? } ?>
						<td style="border-left:0px;background-color:#ffffff;">&nbsp;</td>
					</tr>
					<tr>
						<th <? if ($penilaian == 1 || $penilaian == 2) { ?> colspan=5 <? } else { ?> colspan=6 <? } ?> align="right" style="background-color:#ff8c00;">NILAI EVALUASI BIROKRASI&nbsp;</th>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<th align="center" style="background-color:#ff8c00;"><?= number_format($grand_total_nilai1, 2, '.', ','); ?></th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<th align="center" style="background-color:#ff8c00;"><?= number_format($grand_total_nilai2, 2, '.', ','); ?></th>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ff8c00;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ff8c00;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 1) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ff8c00;">&nbsp;</td>
						<? } ?>
						<? if ($penilaian == 0 || $penilaian == 2) { ?>
							<td style="border-left:0px;border-right:0px;background-color:#ff8c00;">&nbsp;</td>
						<? } ?>
						<td style="border-left:0px;background-color:#ff8c00;">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="center" colspan=3>
				<hr style="border-top:3px solid #000000;">
			</td>
		</tr>
	</table>
</body>

</html>