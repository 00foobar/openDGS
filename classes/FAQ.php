<?php

class FAQ
{
	private $dbh;
	private $config;

	public function __construct()
	{
		// initialize configs
		$this->config = new Config();

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

	public function getFAQ()
	{
		$sql = "SELECT * FROM faq";

		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		if ( $sth->rowCount() >= 1 )
		{
			$result = $sth->fetchAll();	
			return $result;
		}

		return false;
	}

	public function getFAQJSON()
	{
		if ( $this->getFAQ() != false )
		{
			return json_encode($this->getFAQ());	
		}
		
		return false;
	}

	public function addFAQ($question, $answer)
	{
		if ( Validate::issetValidation($question) && Validate::issetValidation($answer) )
		{
			$sql = "INSERT INTO faq (question, answer) VALUES (:question, :answer)";

			$sth = $this->dbh->prepare($sql);

			if ( $sth->execute(array(':question' => $question, ':answer' => $answer)) )
			{
				return true;
			}

			return false;
		}
		
		return false;
	}

	public function editFAQ($id, $question, $answer)
	{
		if ( is_int($id) && Validate::issetValidation($question) && Validate::issetValidation($answer) )
		{
			$sql = "UPDATE faq SET question = :question, answer = :answer WHERE id = :id";

			$sth = $this->dbh->prepare($sql);

			if ( $sth->execute(array(':question' => $question, ':answer' => $answer, ':id' => $id)) )
			{
				return true;
			}

			return false;
		}

		return false;
	}

	public function deleteFAQ($id)
	{
		if ( is_int($id) )
		{
			$sql = "DELETE FROM faq WHERE id = :id";
			$sth = $this->dbh->prepare($sql);

			if ( $sth->execute(array(':id' => $id)) )
			{
				return true;
			}

			return false;
		}

		return false;
	}
}

?>