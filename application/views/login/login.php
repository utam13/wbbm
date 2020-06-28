<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>RSKD WBBM | Log In</title>
	<link href="<?= base_url();?>assets/img/icon.png" rel="shortcut icon" type="image/x-icon"/>
  
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url();?>assets/font-awesome-4.4.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?= base_url();?>assets/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url();?>assets/css/AdminLTE2.min.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
	<style>
	.login-page
	{
		background: url("<?= base_url();?>assets/img/login-bg.png") no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;;
	}
	
	#dvloading
	{
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('<?= base_url();?>assets/img/page-loader.gif') 50% 50% no-repeat rgb(249,249,249);
		opacity: .8;
	}
	</style>
</head>
<body class="hold-transition login-page">
	
<div class="login-box" style="margin-top:250px;">
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">
	Log In untuk memulai sesi Anda
	</p>
	
	<?
	extract($pesan);
	
	if($kode_pesan != "")
	{
		$isialert = str_replace("%20"," ", $isipesan);
		echo "<script>alert('$judulmsg ($isialert)');</script>";
	}
	?>
	
    <form method="post" action="<?= base_url();?>login/proses">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Email" required >
		<span class="fa fa-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
		<div class="input-group">
			<input type="password" id="password" name="password" class="form-control" autocomplete="new-password" placeholder="Password" required >
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
			</span>
		</div>
		<span class="fa fa-key form-control-feedback" style="margin-right:40px;"></span>
      </div>
      <div class="row">
        <div class="col-xs-4" style="float:right;">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?= base_url();?>assets/js/jquery-1.12.0.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url();?>assets/js/bootstrap.min.js"></script>

<script>
//lihat password
function lihatpassword() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
	$("#iconlihat").removeClass('fa fa-eye').addClass('fa fa-eye-slash');
  } else {
    x.type = "password";
	$("#iconlihat").removeClass('fa fa-eye-slash').addClass('fa fa-eye');
  }
}
</script>

</body>
</html>
