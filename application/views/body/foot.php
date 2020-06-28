			<footer class="main-footer">
                <div class="pull-right hidden-xs" style="text-align:right;">
                    <i style="font-size:10pt;color:red;">Gunakan Chrome atau Opera untuk tampilan lebih baik</i><br><b>[Ver. 1 | Thn. 2019]</b>
                </div>
                <strong>RSKD WBBM<br><a href="#" style="font-style:italic;">Created by Rustam &amp; Setio Budi</a></strong>
            </footer>

        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

		<!-- jQuery 2.1.3 -->
        <script src="<?= base_url();?>assets/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>

        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?= base_url();?>assets/js/bootstrap.min.js"></script>
		
		<!-- Select Plugin Js -->
		<script src="<?= base_url();?>assets/js/bootstrap-select.js"></script>
		
		<!-- Multi Select Plugin Js -->
		<script src="<?= base_url();?>assets/js/jquery.multi-select.js"></script>	
		
        <!-- DATA TABES SCRIPT -->
        <script src="<?= base_url();?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url();?>assets/js/plugins/datatables/dataTables.bootstrap.js"></script>
		<script src="<?= base_url();?>assets/js/datatables.custom.js"></script>
		
        <!-- SlimScroll -->
        <script src="<?= base_url();?>assets/js/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		
        <!-- AdminLTE App -->
        <script src="<?= base_url();?>assets/js/AdminLTE/app.min.js"></script>
		
        <!-- AdminLTE for demo purposes -->
        <script src="<?= base_url();?>assets/js/AdminLTE/demo.js"></script>
		
		<!-- date-range-picker -->
		<script src="<?= base_url();?>assets/js/plugins/daterangepicker/daterangepicker.js"></script>
		
		<!-- Select2 -->
		<script src="<?= base_url();?>assets/js/plugins/select2/dist/js/select2.full.min.js"></script>
		
        <!-- treeview -->
        <script src="<?= base_url();?>assets/js/plugins/tree-view/jquery.cookie.js"></script>  
        <script src="<?= base_url();?>assets/js/plugins/tree-view/jquery.treeview.js"></script>  
        <script src="<?= base_url();?>assets/js/plugins/tree-view/demo.js" type="text/javascript" ></script>    
        <script type="<?= base_url();?>assets/text/javascript" src="js/bootstrap-combobox.js"></script>

		<!-- JS Tambahan -->
		<script src="<?= base_url();?>assets/js/aksi.js"></script>
		
		<!-- Date range picker -->
		<script>
			$('#tgl_pelaporan').daterangepicker();
		</script>
		
		<!-- Initialize Select2 Elements -->
		<script>
			$('.select2').select2();
		</script>
		
		<?if($aktif_dashboard != ""){?>
		<!-- HighCharts -->
		<script src="<?= base_url();?>assets/highcarts/highcharts.js"></script>
		<script src="<?= base_url();?>assets/highcarts/modules/exporting.js"></script>
		<!---<script src="<?= base_url();?>assets/highcarts/highcharts_build.js"></script>-->
		
		<script>
		Highcharts.chart('dashboard_chart', {
			chart: {
				type: 'column'
			},
			title: {
				text: <?= "'".$nama_kegiatan."'";?>
			},
			subtitle: {
				text: <?= "'".date('d-m-Y',strtotime($dari))." sampai ".date('d-m-Y',strtotime($sampai))."'";?>
			},
			xAxis: {
				categories: [
							<?
							$hasil1 = json_decode($komponen_proses);
							foreach($hasil1 as $kp_chart)
							{
								echo "'".$kp_chart->nama_komponen."',";
							}
							
							$hasil2 = json_decode($komponen_hasil);
							foreach($hasil2 as $kh_chart)
							{
								echo "'".$kh_chart->nama_komponen."',";
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
				pointFormat: '<tr><td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			colors: [
					<?
					foreach($hasil1 as $kp_chart)
					{
						echo "'#3d9970',";
					}
							
					foreach($hasil2 as $kh_chart)
					{
						echo "'#605ca8',";
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
			series: [{
							//name: 'Tokyo',
							name: 'Komponen',
							data: [
								<?
								foreach($hasil1 as $kp_chart)
								{
									echo $kp_chart->persen.",";
								}
								
								foreach($hasil2 as $kh_chart)
								{
									echo $kh_chart->persen.",";
								}
								?>
							]

						/*}, {
							name: 'New York',
							data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

						}, {
							name: 'London',
							data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

						}, {
							name: 'Berlin',
							data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1] */

			}]
		});
		</script>
		<?}?>
    </body>
</html>