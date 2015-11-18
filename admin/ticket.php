<?php
include('admin_header.php');

$user = new User();

$view = new View();

$ticket = new Ticket();

$support_id = $ticket->getSupportId();
$uid = intval($_GET['uid']);
$ticket_id = intval($_GET['ticket_id']);

$selected_ticket = $ticket->getTicket($ticket_id);
$tickets = $ticket->getTickets($uid);

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
					<?php
						$view->showTicketForm($uid, $ticket_id, $support_id);
					?>
					<br>
					<hr>
					<br>
					<?php
						$view->showTicket($selected_ticket);

						if ( $selected_ticket['replied'] == false )
						{
							echo '<button id="close-ticket-button" type="button">Close Ticket</button>';
						}
						else
						{
							echo '<div class="alert alert-success"><strong>Closed!</strong> This ticket is already marked as closed.</div>';
						}
					?>
					<hr>
					<?php
						$view->showTickets($tickets);
					?>
				</div>

			</div>

		</div> <!-- /.content -->

		<!-- login-failed modal -->
		<div id="send-failed-modal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">

				<!-- modal content-->
				<div class="modal-content">
					
					<!-- modal header -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Sorry</h4>
					</div>
					
					<!-- modal body -->
					<div class="modal-body">
						<div class="text-center">
							<span style="font-size:5.5em;" class="glyphicon glyphicon-warning-sign"></span>
						</div>
						<p>Error: Can't send Ticket.</p>
					</div> <!-- /.modal body -->
				
					<!-- modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div> <!-- /.modal body -->

				</div> <!-- /.modal content -->
			</div> <!-- /.modal dialog -->
		</div> <!-- /.login-failed modal -->

	</div> <!-- /.page row -->

	<script type="text/javascript">
		
		$( document ).ready(function()
		{
			// JS part for the desktop login
			$('#close-ticket-button').click(function(event)
			{
				event.preventDefault();

				var ticket_id = <?php echo $ticket_id; ?>

				$.post( 'close_ticket.php', { ticket_id: ticket_id }, function( data )
				{
					// send ticket successfull?
					if ( data == true )
					{
						// refresh communication
						location.reload(true);
					}
					else
					{
						// send ticket failed
						console.log('Failed to close ticket.');
					}

				}, 'json');
			});

		});
	</script>

	<!-- Ticket JS -->
	<script src="../js/ticket.js"></script>

	<script type="text/javascript">
		
		$( document ).ready(function()
		{
			// JS part for the desktop login
			$('#close-ticket-button').submit(function(event)
			{
				event.preventDefault();

				$.post( 'close_ticket.php', { ticket_id: ticket_id }, function( data )
				{

					// closed successfully
					if ( data == true )
					{
						// refresh communication
						location.reload(true);
					}
					else
					{
						// failed to close ticket
						console.log('Failed to close ticket.'); 
					}

				}, 'json');
			});

		});
	</script>

<?php
include('admin_footer.php');
?>