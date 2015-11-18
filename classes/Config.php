<?php

class Config
{
	// database
	const DB_HOST = 'mysql:host=localhost;dbname=demo';	// CHANGE ME
	const DB_USER = 'root';								// CHANGE ME
	const DB_PASS = 'password';							// CHANGE ME
	const DB_CHAR = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

	private $dbh;

	// db-settings for request
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_char;

	// username and password settings
	public $user_min = 3;
	public $user_max = 20;
	public $pass_min = 6;
	public $pass_max = 25;

	// shop configs
	public $shop_url = 'https://127.0.0.1';
	public $shop_name = 'openDGS';
	public $shop_currency = '€';
	public $shop_percentfee = 19;
	public $shop_articlepp = 6; // six articles per page
	public $shop_impress = "Foobar Foobarsen\nFoobar-Street 52\n00000 Foobarland\n\nTel.:000000 00000\nE-Mail:foobar@127.0.0.1\n\n";
	public $shop_copyright = '© by Foobar';

	// @TODO to implement
	public $support_uid = 1;

	public function __construct()
	{
		// initialize the PDO handler
		try
		{
			$this->dbh = new PDO(Self::DB_HOST, Self::DB_USER, Self::DB_PASS, Self::DB_CHAR);
		}
		catch (Exception $e)
		{
			echo "No connection to database: ",  $e->getMessage(), "\n";
		}

		// load configuration from the database
		if ( $this->dbh )
		{
			$this->loadConfigFromDatabase();
		}

		// init the db-settings for class requests
		$this->db_host = Self::DB_HOST;
		$this->db_user = Self::DB_USER;
		$this->db_pass = Self::DB_PASS;
		$this->db_char = Self::DB_CHAR;
	}

	public function getHostDB()
	{
		return $this->db_host;
	}

	public function getUserDB()
	{
		return $this->db_user;
	}

	public function getPassDB()
	{
		return $this->db_pass;
	}

	public function getCharDB()
	{
		return $this->db_char;
	}

	// load the configs from the database
	private function loadConfigFromDatabase()
	{
		$sql = "SELECT * FROM configs WHERE id = 1";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		if ( $sth->rowCount() >= 1 )
		{
			$config = $sth->fetchAll();
			$config = $config[0];

			// overwrite the class properties
			if ( !empty($config['user_min']) && !empty($config['user_max']) )
			{
				if ( $config['user_min'] < $config['user_max'] )
				{
					$this->user_min = $config['user_min'];
					$this->user_max = $config['user_max'];
				}
			}

			if ( !empty($config['pass_min']) && !empty($config['pass_max']) )
			{
				if ( $config['pass_min'] < $config['pass_max'] )
				{
					$this->pass_min = $config['pass_min'];
					$this->pass_max = $config['pass_max'];
				}
			}

			if ( !empty($config['shop_url']) )
			{
				$this->shop_url = $config['shop_url'];
			}

			if ( !empty($config['shop_name']) )
			{
				$this->shop_name = $config['shop_name'];
			}

			if ( !empty($config['shop_currency']) )
			{
				$this->shop_currency = $config['shop_currency'];
			}

			if ( !empty($config['shop_percentfee']) )
			{
				$this->shop_percentfee = $config['shop_percentfee'];
			}

			if ( !empty($config['shop_articlepp']) )
			{
				$this->shop_articlepp = $config['shop_articlepp'];
			}

			if ( !empty($config['shop_impress']) )
			{
				$this->shop_impress = $config['shop_impress'];
			}

			if ( !empty($config['shop_copyright']) )
			{
				$this->shop_copyright = $config['shop_copyright'];
			}

			return true;
		}

		return false;
	}

	// save given configs to the database
	public function saveSettings($user_min, $user_max, $pass_min, $pass_max, $shop_url, $shop_name, $shop_currency, $shop_percentfee, $shop_articlepp, $shop_impress, $shop_copyright)
	{
		if ( Validate::issetValidation($user_min) && is_numeric($user_min) && Validate::issetValidation($user_max) && is_numeric($user_max) && Validate::issetValidation($pass_min) && is_numeric($pass_min) && Validate::issetValidation($pass_max) && is_numeric($pass_max) && Validate::issetValidation($shop_url) && Validate::issetValidation($shop_name) && Validate::issetValidation($shop_currency) && Validate::issetValidation($shop_percentfee) && Validate::issetValidation($shop_articlepp) && Validate::issetValidation($shop_impress) && Validate::issetValidation($shop_copyright) )
		{
			$sql = "UPDATE configs SET user_min = :user_min, user_max = :user_max, pass_min = :pass_min, pass_max = :pass_max, shop_url = :shop_url, shop_name = :shop_name, shop_currency = :shop_currency, shop_percentfee = :shop_percentfee, shop_articlepp = :shop_articlepp, shop_impress = :shop_impress, shop_copyright = :shop_copyright WHERE id = 1";

			$sth = $this->dbh->prepare($sql);

			if ( $sth->execute(array(':user_min' => $user_min, ':user_max' => $user_max, ':pass_min' => $pass_min, ':pass_max' => $pass_max, ':shop_url' => $shop_url, ':shop_name' => $shop_name, ':shop_currency' => $shop_currency, ':shop_percentfee' => $shop_percentfee, ':shop_articlepp' => $shop_articlepp, ':shop_impress' => $shop_impress, ':shop_copyright' => $shop_copyright)) )
			{
				return true;	
			}
		}

		return false;
	}

	// get the class properties as an assoc array
	public function getConfigArray()
	{
		$result = array('user_min' => $this->user_min,
						'user_max' => $this->user_max,
						'pass_min' => $this->pass_min,
						'pass_max' => $this->pass_max,
						'shop_url' => $this->shop_url,
						'shop_name' => $this->shop_name,
						'shop_currency' => $this->shop_currency,
						'shop_percentfee' => $this->shop_percentfee,
						'shop_articlepp' => $this->shop_articlepp,
						'shop_impress' => $this->shop_impress,
						'shop_copyright' => $this->shop_copyright);

		return $result;
	}
}
