<?php
include('header.php');

$user = new User();
$view = new View();
$ticket = new Ticket();

if ( $user->isLoggedIn() )
{
	$tickets = $ticket->getTickets($_SESSION['uid']);
	$last_ticket_id = $ticket->getLastTicketIdFromUid($_SESSION['uid']);
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
						Categories
					</a>
				</li>
					<!-- shows the categories as list elements -->
					<?php
						$view->showCategories();
					?>
			</ul>
		</div> <!-- /.sidebar -->

		<!-- content -->
		<div class="col-sm-10">

			<div class="faq-container">
				<h1>Contact</h1>
				<hr>
				<?php 
					if ( $user->isLoggedIn() )
					{
						if ( !$user->isAdmin() )
						{
							$to_uid = $ticket->getSupportId();

							$view->showTicketForm($to_uid, false, $from_uid = false);
							$view->showTickets($tickets);
						}
					}
					else
					{
						$view->showContactForm();
					}
				?>
			</div>

		</div>
	</div>
</div>

<?php
include('footer.php');
?>