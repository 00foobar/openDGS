<?php

class Database
{
	private $config;
	private $dbh;



	public function __construct()
	{
		$this->config = new Config();

		try
		{
			$this->dbh = new PDO();
		}
		catch (Exception $e)
		{
			echo 'Error: No database connection.';
		}
	}

	public function select()
	{
		if ( !Validate::Get($this->table) )
		{
			throw new Exception("Error Processing Request", 1);
			return false;
		}
	}

	public function insert($table = null)
	{

	}

	public function update()
	{

	}


	public function delete()
	{

	}
}
