<!DOCTYPE html>
<html>
<head>
	<style>
	.rekaman
	{
		border-collapse:collapse;
		font-family:time;
		font-size:10pt;
		width:100%
	}
	
	.rekaman th,.rekaman td
	{
		border: 1px solid #000000;
	}
	</style>
</head>
<body>
<table width="100%">
<tr>
	<td colspan=3 style="font-family:times;font-size:14pt;font-weight:bold;"><u>Laporan Log Aktifitas Aplikasi WBBM</td>
</tr>
<tr>
	<td align="center" colspan=3><hr style="border-top:3px solid #000000;"></td>
</tr>
<tr>
	<td align="center" colspan=3 >
		<table class="rekaman">
		<tr>
			<th width="3%" align="center" style="background-color:silver;">No</th>
			<th width="12%" align="center" style="background-color:silver;">Waktu Log</th>
			<th width="15%" align="center" style="background-color:silver;">Email User</th>
			<th width="10%" align="center" style="background-color:silver;">Ip Address</th>
			<th width="25%" align="center" style="background-color:silver;">Sistem</th>
			<th width="35%" align="center" style="background-color:silver;">Aktifitas</th>
		</tr>
		<?
		$no = 1;
		foreach($log as $l){ 
		?>
		<tr>
			<td align="center"><?= $no;?></td>
			<td align="center"><?= date('d-m-Y h:i:s A',strtotime($l->waktulog));?></td>
			<td><?= $l->email;?></td>
			<td align="center"><?= $l->iplog;?></td>
			<td align="center"><?= $l->systlog;?></td>
			<td><?= $l->infolog;?></td>
		</tr>
		<?$no++;}?>
		</table>
	</td>
</tr>
<tr>
	<td align="center" colspan=3><hr style="border-top:3px solid #000000;"></td>
</tr>
</table>
</body>
</html>