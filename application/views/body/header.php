		<header class="main-header">
			<a href="#" class="logo">
				<span class="logo-mini"><img src="img/icon2.png"></span>
				<span class="logo-lg"><b>WBBM</b></span>
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
								<img src="<?= base_url();?>assets/img/avataruser.jpg" class="user-image" alt="User Image">	
								<span class="hidden-xs">User Name</span>
							</a>
							<ul class="dropdown-menu">
							  <!-- User image -->
							  <li class="user-header">
								<img src="<?= base_url();?>assets/img/avataruser.jpg" class="img-circle" alt="User Image">

								<p>
								  User
								</p>
							  </li>
							  <!-- Menu Footer-->
							  <li class="user-footer">
								<div class="pull-left">
								  <a href="#" class="btn bg-olive btn-flat" onclick="showloading()">Profil</a>
								  <a href="#" class="btn bg-navy btn-flat" target="_blank">Manual</a>
								</div>
								<div class="pull-right">
								  <a href="#" class="btn btn-default btn-flat">Log Out</a>
								</div>
							  </li>
							</ul>
						</li>
					</ul>
				</div>
				
			</nav>
		</header>