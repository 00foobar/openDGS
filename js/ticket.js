// JS part for the login 

	$( document ).ready(function()
	{
		// JS part for the desktop login
		$('#ticket-form').submit(function(event)
		{
			event.preventDefault();

			var from = $('#from-ticket-form').val();
			var ticket_id = $('#id-ticket-form').val();
			var to = $('#to-ticket-form').val();
			var subject = $('#subject-ticket-form').val();
			var body = $('#body-ticket-form').val();

			$.post( 'controller/send_ticket.php', { from: from, to: to, subject: subject, body: body, ticket_id: ticket_id }, function( data )
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
					$('#send-failed-modal').modal();
					$('#send-failed-modal').modal('show'); 

					// @TODO
					location.reload(true);
				}
			}, 'json');
		});

	});