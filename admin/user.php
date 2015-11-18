<?php
include('admin_header.php');

$view = new View();
$user = new User();

if ( isset($_GET['id']) && is_numeric($_GET['id']) )
{
	$uid = $_GET['id'];
	$user_array = $user->getUserArrayById($uid);
}
?>

<!-- content wrapper -->
<div class="container-full">

	<!-- page row -->
	<div class="row"> 

		<!-- sidebar -->
		<div class="col-sm-2 sidebar-wrapper">
			<ul class="sidebar-nav">
				<li class="sidebar-brand">
					<a href="#">
						Admin
					</a>
				</li>
				<!-- shows the categories as list elements -->
				<?php
					$view->showAdminMenu();
				?>
			</ul>
		</div> <!-- /.sidebar -->

		<!-- content -->
		<div class="col-sm-10">

			<div class="row overview-row">

				<div class="col-xs-12">
					<h1>
						Username:
						<strong>
							<?php
								echo $user_array['username'];
							?>
						</strong>
					</h1>
					<br>
					<div class="well">

						<div class="row">

							<div class="col-xs-12">
								<h2>Personal</h2>
							</div>

							<div class="col-xs-6 col-sm-3">
								<p>Prename:</p>
								<p>Lastname:</p>
								<br>
								<p>Registration:</p>
								<p>Active:</p>
								<p>Admin:</p>
								<br>
								<p>E-Mail:</p>
								<br>
								<p>Orders:</p>
								<p>Money spent:</p>
							</div>

							<div class="col-xs-6 col-sm-9">
								<p><i><?php echo $user_array['prename']; ?> </i></p>
								<p><i><?php echo $user_array['lastname']; ?> </i></p>
								<br>
								<p><i><?php echo $user_array['regdate']; ?> </i></p>
								<p><i><?php echo $user_array['active']; ?> </i></p>
								<p><i><?php echo $user_array['admin']; ?> </i></p>
								<br>
								<p><i><?php echo $user_array['email']; ?> </i></p>
							</div>

						</div>

						<br><br>

						<div class="row">

							<div class="col-xs-12">
								<h2>Items</h2>
							</div>

							<div class="col-xs-6 col-sm-3">
								<p>Item:</p>
							</div>

							<div class="col-xs-6 col-sm-9">
								<p><i>Itemname</i> <button>X</button></p>
							</div>

						</div>

					</div>
				</div>

				<div class="col-xs-12">
					<?php
						if ( $user_array['active'] == 0 )
						{
							echo '<button>Activate</button>';
						}
						else
						{
							echo '<button>Ban</button>';
						}

						if ( $user_array['admin'] == 0 )
						{
							echo '<button>Set to Admin</button>';
						}
						else
						{
							echo '<button>Set to User</button>';
						}
					?>
				</div>

			</div>

		</div> <!-- /.content -->
	</div> <!-- /.page row -->

<?php
include('admin_footer.php');
?>