<?php
include('admin_header.php');

$ticket = new Ticket();
$tickets = $ticket->getOpenSupportTickets();

$view = new View();


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
					<h1>Tickets</h1>
				</div>

				<div class="col-xs-12">
					show ticket list today, mark unreplied tickets
					<?php
						$view->showTicketList($tickets);
					?>
				</div>

			</div>

		</div> <!-- /.content -->
	</div> <!-- /.page row -->

<?php
include('admin_footer.php');
?>