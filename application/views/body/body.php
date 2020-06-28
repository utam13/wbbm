<body class="hold-transition skin-red sidebar-mini" onload="startTime()">

	<!-- loading page animated until page ready -->
	<div id="dvloading" style="display:none;"></div>

	<div class="wrapper">
		<!-- end at foot.php -->
		<header class="main-header">
			<a href="#" class="logo">
				<span class="logo-mini"><img src="<?= base_url(); ?>assets/img/icon2.png"></span>
				<span class="logo-lg"><b>RSKD WBBM</b></span>
			</a>

			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown messages-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-calendar"></i>
								<span id="txttime"></span>
							</a>
						</li>
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?= base_url(); ?>assets/img/avataruser.jpg" class="user-image" alt="User Image">
								<span class="hidden-xs"><?= $email_user; ?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="<?= base_url(); ?>assets/img/avataruser.jpg" class="img-circle" alt="User Image">

									<p>
										User
									</p>
								</li>
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<a href="<?= base_url(); ?>user/profil/<?= $email_user; ?>" class="btn bg-olive btn-flat btn-sm" onclick="showloading()">Ganti Password</a>
										<a href="<?= base_url(); ?>manual.pdf" class="btn bg-navy btn-flat btn-sm" target="_blank">Manual</a>
									</div>
									<div class="pull-right">
										<a href="<?= base_url(); ?>login/logout" class="btn btn-default btn-flat btn-sm">Log Out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			</nav>
		</header>

		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar" style="height: auto;">
				<!-- Sidebar user panel -->

				<!-- search form -->
				<!-- /.search form -->
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu">
					<li class="<?= $aktif_dashboard; ?>"><a href="<?= base_url(); ?>dashboard" onclick="showloading()"><i class="fa fa-dashboard "></i><span>DASHBOARD</span></a></li>
					<li class="header bg-blue-active">DATA WBBM</li>
					<li class="<?= $aktif_wbbm; ?>"><a href="<?= base_url(); ?>kegiatan" onclick="showloading()"><i class="fa fa-bar-chart"></i><span>Kegiatan WBBM</span></a></li>
					<!--<li><a href="<?= base_url(); ?>dokumen" onclick="showloading()"><i class="fa fa-folder-open"></i><span>Pencarian Dokumen</span></a></li>-->
					<? if ($setting != "") { ?>
						<li class="header bg-blue-active">SETTING</li>
						<? if (substr_count($setting, 'komponen') > 0 || $setting == "all") { ?>
							<li class="<?= $aktif_komponen; ?>"><a href="<?= base_url(); ?>komponen" onclick="showloading()"><i class="fa fa-list"></i><span>Komponen Penilaian</span></a></li>
						<? } ?>
						<? if (substr_count($setting, "user") > 0 || $setting == "all") { ?>
							<li class="<?= $aktif_user; ?>"><a href="<?= base_url(); ?>user" onclick="showloading()"><i class="fa fa-users"></i><span>User</span></a></li>
						<? } ?>
						<? if (substr_count($setting, "log") > 0 || $setting == "all") { ?>
							<li class="<?= $aktif_log; ?>"><a href="<?= base_url(); ?>log_aktifitas" onclick="showloading()"><i class="fa fa-eye"></i><span>Log Aktifitas</span></a></li>
					<? }
					} ?>
				</ul>

				<!--/.nav-list-->
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Right side column. Contains the navbar and content of the page -->
		<!-- Content at content.php	