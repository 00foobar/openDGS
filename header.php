<?php
require_once('bootstrap.php');
$user = new User();
$view = new View();
$config = new Config();
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo $config->shop_name; ?></title>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="css/style.css" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>

	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-full">
			<div class="row">

				<div class="col-sm-1 navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

				<?php
					if ( $user->isLoggedIn() == false )
					{
						echo '<button type="button" class="btn btn-sm login-toggle navbar-toggle" data-toggle="modal" data-target="#mobile-login-modal">Login</button>';
						echo '<button type="button" class="btn btn-sm login-toggle navbar-toggle" data-toggle="modal" data-target="#register-modal">Register</button>';
					}
				?>
					<a class="navbar-brand" href="index.php"><?php echo $config->shop_name; ?></a>
				</div><!-- /.col -->

				<!-- collapse  -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<div class="col-sm-4">
						<?php
							if ( $user->isLoggedIn() )
							{
								$view->showUserMenu();
							}
							else
							{
								$view->showGuestMenu();
							}
						?>
					</div>

					<div class="text-right col-sm-7 form-align">
						<?php
							if ( $user->isLoggedIn() )
							{
								$view->showLogoutForm();
							}
							else
							{
								$view->showLoginForm();
							}
						?>
					</div>

				</div><!-- /.collapse -->
			</div> <!-- /.row -->
		</div><!-- /.container -->
	</nav><!-- /.navigation -->


