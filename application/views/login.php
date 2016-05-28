<html lang="en" class="bg-dark js no-touch no-android chrome no-firefox no-iemobile no-ie no-ie10 no-ie11 no-ios">
	<head>
		<meta charset="utf-8">
		<title>D Signage 2014</title>
		<meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
		<link rel="stylesheet" href="<?php echo theme_css().'bootstrap.css'?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo theme_css().'animate.css'?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo theme_css().'font-awesome.css'?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo theme_css().'font.css'?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo theme_css().'app.css'?>" type="text/css" />
	</head>
	<body style="">
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
			<div class="container aside-xxl">
				<a class="navbar-brand block">Signage Web Application</a>
				<section class="panel panel-default bg-white m-t-lg">
					<header class="panel-heading text-center">
						<strong>Sign in</strong>
					</header>
					<form id="login-form" action="<?php echo base_url().'dsignage/login' ?>" method="post" class="panel-body wrapper-lg">
						<div class="form-group">
							<label class="control-label">Username</label>
							<input type="text" autocomplete="off" name="username" id="username" class="form-control input-lg">
						</div>
						<div class="form-group">
							<label class="control-label">Password</label>
							<input type="password" name="password" id="password" class="form-control input-lg">
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox"> Keep me logged in
							</label>
						</div>
						<a href="#" class="pull-right m-t-xs"><small>Forgot password?</small></a>
						<button type="submit" id="login-submit" class="btn btn-primary">Sign in</button>
					</form>
				</section>
			</div>
		</section>

		<!-- / footer -->
		<script src="<?php echo theme_js().'jquery.min.js';?>"></script>
		<!-- Bootstrap -->
		<script src="<?php echo theme_js().'bootstrap.js';?>"></script>
		<script src="<?php echo theme_js().'app.js';?>"></script>
		<script src="<?php echo theme_js().'app.plugin.js';?>"></script>
		<script src="<?php echo theme_js().'slimscroll/jquery.slimscroll.min.js';?>">
		</script>

	</body>
</html>