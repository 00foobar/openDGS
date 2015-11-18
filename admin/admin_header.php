<?php
require_once('../bootstrap.php');

$user = new User();
$config = new Config();

// checks if user is logged in and is a administrator
if ( !$user->isLoggedIn() || !$user->isAdmin() )
{
	// user is no admin or not logged in
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo $config->shop_name; ?> Adminpanel</title>

	<!-- Bootstrap Core CSS -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../css/style.css" rel="stylesheet">

	<!-- jQuery -->
	<script src="../js/jquery.js"></script>

	<!-- jQuery.validation -->
	<script src="../js/jquery.validate.js"></script>

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

				<div class="col-xs-6 navbar-header">
					<a class="navbar-brand" href="index.php">Adminpanel</a>
				</div><!-- /.col -->

				<div class="text-right col-xs-6">
					<button id="logout-button" class="btn btn-error btn-sm">Logout</button>
				</div><!-- /.col -->

			</div> <!-- /.row -->
		</div><!-- /.container -->
	</nav><!-- /.navigation -->


