<?php

class Ticket
{
	private $dbh;
	private $config;

	private $support_id;

	public function __construct()
	{
		// initialize configs
		$this->config = new Config();
		
		// set the support user/admin
		$this->support_id = $this->getSupportId();

		// initialize the PDO handler
		try
		{
			$this->dbh = new PDO($this->config->getHostDB(), $this->config->getUserDB(), $this->config->getPassDB(), $this->config->getCharDB());
		}
		catch (Exception $e)
		{
			echo "No connection to database.";
		}
	}

	public function getSupportId()
	{
		return $this->config->support_uid;
	}

	public function getOpenSupportTickets()
	{
		$sql = "SELECT * FROM tickets WHERE to_uid = :to_uid AND replied = :replied";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(':to_uid' => $this->support_id, ':replied' => false));

		if ( $sth->rowCount() >= 1 )
		{
			return $sth->fetchAll();
		}

		return false;
	}

	public function getSupportTickets()
	{
		$sql = "SELECT * FROM tickets WHERE to_uid = :to_uid AND replied = :replied ";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(':to_uid' => $this->support_id, ':replied' => false));

		if ( $sth->rowCount() >= 1 )
		{
			return $sth->fetchAll();
		}

		return false;	
	}

	public function getTickets($uid)
	{
		$sql = "SELECT * FROM tickets WHERE to_uid = :to_uid OR from_uid = :to_uid2 ORDER BY create_date DESC";

		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(':to_uid' => $uid, ':to_uid2' => $uid));

		if ( $sth->rowCount() >= 1 )
		{
			return $sth->fetchAll();
		}

		return false;
	}

	public function getTicket($id)
	{
		$sql = "SELECT * from tickets WHERE id = :id";
		$sth = $this->dbh->prepare($sql);
		
		if ( $sth->execute(array(':id' => $id)) )
		{
			$result = $sth->fetchAll();

			return $result[0];
		}

		return false;
	}

	public function createTicket($from_uid, $to_uid, $subject, $text)
	{
		if ( !is_numeric($from_uid) || !is_numeric($to_uid) )
		{
			throw new Exception("From- and To-UID must be numeric. ", 1);
			return false;
		}
		if ( strlen($subject) > 255 )
		{
			throw new Exception("Subject cant contain more then 255 characters.", 1);
			return false;
		}

		$subject = strip_tags($subject);
		$text = strip_tags($text);

		$sql = "INSERT INTO tickets (from_uid, to_uid, subject, body, create_date ) VALUES (:from_uid, :to_uid, :subject, :body, now())";
		$sth = $this->dbh->prepare($sql);

		if ( $sth->execute(array(':from_uid' => $from_uid, ':to_uid' => $to_uid, ':subject' => $subject, ':body' => $text)) )
		{
			// $result = $sth->fetchAll();
			return $this->dbh->lastInsertId();
			//return true;
		}

		return false;
	}

	public function setTicketReplied($id)
	{
		if ( is_int($id) )
		{
			$sql = "UPDATE tickets SET replied = 1 WHERE id = :id";
			$sth = $this->dbh->prepare($sql);

			if ( $sth->execute(array(':id' => $id)) )
			{
				return true;
			}

			return false;
		}

		return false;
	}

	public function getLastTicketIdFromUid($user_id)
	{
		if ( is_int($user_id) )
		{
			$sql = "SELECT id FROM tickets WHERE from_uid = :from_uid ORDER BY create_date DESC";
			$sth = $this->dbh->prepare($sql);

			if ( $sth->rowCount() > 0 )
			{
				$ticket_id = $sth->fetchColumn();

				return $ticket_id;
			}

			return false;
		}

		return false;
	}

}

?>