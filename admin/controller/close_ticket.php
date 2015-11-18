<?php
require_once('../../bootstrap.php');

$user = new User();

// checks if user is logged in and is a administrator
if ( !$user->isLoggedIn() || !$user->isAdmin() )
{
	// user is no admin or not logged in
	exit();
}

if ( isset($_POST['ticket_id']) && !empty($_POST['ticket_id']) && is_numeric($_POST['ticket_id']) )
{
	$ticket_id = intval($_POST['ticket_id']);

	$ticket = new Ticket();
	
	if ( $ticket->setTicketReplied($ticket_id) )
	{
		echo json_encode(true);
		exit();
	}

	echo json_encode(false);
	exit();
}

echo json_encode(false);
?>