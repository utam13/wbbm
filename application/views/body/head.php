<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cache-control" content="max-age=1" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="1" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1900 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	
	<title>RSKD WBBM</title>
	
	<link href="<?= base_url();?>assets/img/icon.png" rel="shortcut icon" type="image/x-icon"/>
    
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
	<!-- bootstrap 3.3.2 -->        
    <link href="<?= base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" >
	
    <!-- font Awesome -->
    <link href="<?= base_url();?>assets/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet">
	
    <!-- Ionicons -->
    <link href="<?= base_url();?>assets/css/ionicons.min.css" rel="stylesheet">
	
    <!-- DATA TABLES -->    
    <link href="<?= base_url();?>assets/js/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">   
	
	<!-- Bootstrap Select Css -->
    <link href="<?= base_url();?>assets/css/bootstrap-select.css" rel="stylesheet" />
	
    <!-- Theme style -->
    <link href="<?= base_url();?>assets/css/AdminLTE.min.css" rel="stylesheet">
	
    <!-- AdminLTE Skins. Choose a skin from the css/skins -->
    <link href="<?= base_url();?>assets/css/skins/skin-red.min.css" rel="stylesheet">
	
	<!-- daterange picker -->
	<link rel="stylesheet" href="<?= base_url();?>assets/js/plugins/daterangepicker/daterangepicker-bs3.css">
	
	<!-- Select2 -->
	<link rel="stylesheet" href="<?= base_url();?>assets/js/plugins/select2/dist/css/select2.min.css">
	
	<!-- Multi Select Css -->
    <link href="<?= base_url();?>assets/css/multi-select.css" rel="stylesheet">
	
    <!-- jvectormap -->
    <link href="<?= base_url();?>assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" >
	
	<!-- Morris charts -->
	<link rel="stylesheet" href="<?= base_url();?>assets/js/plugins/morris.js/morris.css">
	
	<!-- time -->
	<script>
	function startTime() {
		var today = new Date();
		var date = today.getDate();
		var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var month = months[today.getMonth()];
		var year = today.getFullYear();
		var h = today.getHours();
		var m = today.getMinutes();
		var s = today.getSeconds();
		m = checkTime(m);
		s = checkTime(s);
		document.getElementById('txttime').innerHTML = date + " " + month + " " + year + " " + h + ":" + m + ":" + s;
		var t = setTimeout(startTime, 500);
	}
	function checkTime(t) {
		if (t < 10) {t = "0" + t};  // add zero in front of numbers < 10
		return t;
	}
	</script>
	
	<link href="<?= base_url();?>assets/css/style_tambahan.css" rel="stylesheet" >
</head>