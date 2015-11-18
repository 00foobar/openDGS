<?php
include('../bootstrap.php');

$ticket = new Ticket();
$support_id = $ticket->getSupportId();

if ( !empty($_POST['from']) && is_numeric($_POST['from']) && $_POST['from'] == $_SESSION['uid'] )
{
	$from_uid = intval($_POST['from']);
}
else
{
	echo json_encode(false);
	exit();
}

if ( !empty($_POST['to']) && is_numeric($_POST['to']) )
{
	if ( $_SESSION['admin'] != 1 )
	{
		$to_uid = $support_id;
	}
	else
	{
		$to_uid = intval($_POST['to']);
	}
}
else
{
	echo json_encode(false);
	exit();
}

if ( !empty($_POST['ticket_id']) && is_numeric($_POST['ticket_id']) )
{
	$reply_to_ticket_id = intval($_POST['ticket_id']);
}
else
{
	$reply_to_ticket_id = false;
}


if ( isset($_POST['subject']) && !empty($_POST['subject']) && strlen($_POST['subject'] <= 255) )
{
	$subject = $_POST['subject'];
}
else
{
	$subject = ' ';
}

if ( !empty($_POST['body']) )
{
	$body = $_POST['body'];
}
else
{
	echo json_encode(false);
	exit();
}

try
{
	if ( $ticket_id = $ticket->createTicket($from_uid, $to_uid, $subject, $body) )
	{
		if ( $reply_to_ticket_id != false )
		{
			$ticket->setTicketReplied($reply_to_ticket_id);
		}
		else
		{
			$ticket->setTicketReplied($ticket_id);
		}
		
		json_encode(true);
		exit();
	}

	echo json_encode(false);
	exit();
}
catch (Exception $e)
{
	// echo $e->getMessage();
	echo json_encode(false);
	exit();
}


?>