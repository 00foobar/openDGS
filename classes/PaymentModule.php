<?php

class PaymentModule
{
	private $dbh;
	private $config;

	private $name;
	private $include_path;

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
			// echo "Error: No connection to database: ",  $e->getMessage(), "\n";
			echo 'Error: No connection to database.';
		}
	}

	private function isNameValid($name)
	{
		if ( is_string($name) && strlen($name) < 256 && ctype_alnum($name) )
		{
			return true;
		}

		return false;
	}

	public function addPaymentMethod($name, $active = false)
	{
		if ( $this->isNameValid($name) )
		{
			$name = strip_tags($name);
			$name_directory = strip_tags($name);
			$name_file = strtolower(strip_tags($name));
		}
		else
		{
			echo 'Error: Unvalid payment module name.';
			return false;
		}

		if ( !is_bool($active) )
		{
			echo 'Error: Activation status must be true or false (bool).';
			return false;
		}

		// check if module files exists
		if ( file_exists('payment' . DIRECTORY_SEPERATOR . $name_directory . DIRECTORY_SEPERATOR . $name_file) )
		{
			// make database entry
			$sql = "INSERT INTO payment_modules (name, active) VALUES (:name, :active)";
			$sth = $this->dbh->prepare($sql);

			if ( $sth->execute(array(':name' => $name, ':active' => $active)) )
			{
				return $this->dbh->lastInsertId();
			}
		}
		else
		{
			echo 'Error: Payment module doesnt exists.';
			return false;
		}

		return false;
	}

	public function getPaymentMethods()
	{
		// return the names
		$sql = "SELECT * FROM payment_modules";
		$sth = $this->dbh->prepare($sql);

		$sth->execute(array());

		if ( $sth->rowCount() > 0 )
		{
			$result = $sth->fetchAll();

			return $result;
		}

		return false;
	}

	public function getActivePaymentMethods()
	{
		// return the names
		$sql = "SELECT * FROM payment_modules WHERE active = 1";
		$sth = $this->dbh->prepare($sql);

		$sth->execute(array());

		if ( $sth->rowCount() > 0 )
		{
			$result = $sth->fetchAll();

			return $result;
		}

		return false;
	}


	public function selectPaymentMethod($name)
	{
		// include the 
	}

	public function getIncludePath()
	{
		if ( file_exists(filename) )
	}


	public function existsPaymentModule($name)
	{

		if ( file_exists('payment' . DIRECTORY_SEPERATOR . $name_directory . DIRECTORY_SEPERATOR . $name_file) )
	}

	public function isActive()
	{
		
	}

	public function addNewPayment()
	{

	}

	public function getCheckoutURL()
	{
		// use DIRECTORY_SEPERATOR 
	}
}
?>