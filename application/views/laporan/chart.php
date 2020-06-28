<?

?>
<!DOCTYPE html>
<html>

<head>
	<!--style-->
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
			</td>
		</tr>
		<tr>
			<td align="center" colspan=3>
				<hr style="border-top:3px solid #000000;">
			</td>
		</tr>
		<tr>
			<td align="center" colspan=3>
				<div id="dashboard_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			</td>
		</tr>
		<tr>
			<td align="center" colspan=3>
				<hr style="border-top:3px solid #000000;">
			</td>
		</tr>
	</table>

	<!-- jQuery 2.1.3 -->
	<script src="<?= base_url(); ?>assets/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>

	<!-- HighCharts -->
	<script src="<?= base_url(); ?>assets/highcarts/highcharts.js"></script>
	<script src="<?= base_url(); ?>assets/highcarts/modules/exporting.js"></script>
	<script>
		Highcharts.chart('dashboard_chart', {
			chart: {
				type: 'column'
			},
			title: {
				text: <?= "'" . $nama_kegiatan . "'"; ?>
			},
			subtitle: {
				text: <?= "'" . date('d-m-Y', strtotime($dari)) . " sampai " . date('d-m-Y', strtotime($sampai)) . "'"; ?>
			},
			xAxis: {
				categories: [
					<?
					$hasil = json_decode($komponen);

					foreach ($hasil as $h) {
						echo "'" . $h->nama_komponen . "',";
					}
					?>
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Nilai'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td> <td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			colors: [
				<?
				foreach ($hasil as $h) {
					echo "'#3d9970',";
				}
				?>
			],
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				},
				series: {
					colorByPoint: true
				}
			},
			series: [
				<? if ($penilaian == 0 || $penilaian == 1) { ?> {
						name: 'Self Assesment',
						data: [
							<?
								foreach ($hasil as $h) {
									echo $h->persen_sa . ",";
								}
								?>
						]
					},
				<? } ?>
				<? if ($penilaian == 0 || $penilaian == 2) { ?> {
						name: 'Surveyor',
						data: [
							<?
								foreach ($hasil as $h) {
									echo $h->persen_sy . ",";
								}
								?>
						]
					}
				<? } ?>
			]
		});
	</script>
</body>

</html>