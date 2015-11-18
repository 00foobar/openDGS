<?php
include('admin_header.php');

$view = new View();
$user = new User();
$ticket = new Ticket();
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
					<h1>News</h1>
					<div class="well">
						<?php
							if ( $user->isAdminPasswordChanged() == false )
							{
								$view->showChangePasswordAlert();
							}
							//$update->isUpdateAvailable();
						?>
					</div>
				</div>				

				<div class="col-xs-12">
					<h1>New Tickets</h1>
					<div class="well">
						<?php
							$unreplied_tickets = $ticket->getOpenSupportTickets();
							$view->showTicketList($unreplied_tickets);
						?>
					</div>
				</div>

				<div class="col-xs-12">
					<h1>New Orders</h1>
					<div class="well">
						<p>show all orders OR not as completed marked orders</p>
					</div>
				</div>

				<div class="col-xs-12">
					<h1>New Users</h1>
					<div class="well">
						<ul class="list-group">
						<?php
							if ( $new_users = $user->getNewUsersToday() )
							{
								$view->showNewUsers($new_users);
							}
						?>
						</ul>
					</div>
				</div>

			</div>

		</div> <!-- /.content -->
	</div> <!-- /.page row -->

<?php
include('admin_footer.php');
?>