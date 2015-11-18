<?php

class Order
{	
	private $dbh;
	private $user;
	private $product;

	private $status_open = 0;
	private $status_finished = 1;

	private $order_timeout = 60 * 60; // 1 hour in seconds

	public function __construct()
	{
		// initialize configs
		$this->config = new Config();

		// initialize product class
		$this->product = new Product();

		// initialize the PDO handler
		try
		{
			$this->dbh = new PDO($this->config->getHostDB(), $this->config->getUserDB(), $this->config->getPassDB(), $this->config->getCharDB());
		}
		catch (Exception $e)
		{
			// echo "No connection to database: ",  $e->getMessage(), "\n";
			echo 'No connection to database.';
		}
	}

	public function isSessionAuthorized($order_id)
	{
		$user_id = $this->user->getSessionUid();
		
		if ( $user_id != false )
		{
			if ( $user_id == $oder_id )
			{
				return true;
			}
		}

		return false;
	}

	public function getAllOpenOrdersByUid()
	{

	}

	public function getAllFinishedOrdersByUid()
	{

	}

	public function getAllCancelledOrdersByUid()
	{

	}

	public function getAllOrdersToday()
	{

	}

	public function getTodayNet()
	{

	}

	public function getTodayGross()
	{

	}

	public function addNewOrder($user_id, $product_id)
	{
		// status of an open order
		$status = $this->status_open;

		if ( is_array($product_id) )
		{
			// if there is a array full of product ids it was a shopping cart
			$product_ids = $product_id;

			foreach ($product_ids as $product_id)
			{
				
			}
		}
		elseif ( is_numeric($product_id) )
		{
			
			$sql = "INSERT INTO orders (user_id, payments_id, status, date_time) VALUES (:user_id, :payments_id, :status, now())";
			$sth = $this->dbh->prepare($sql);

			$sth_reponse = $sth->execute(array(	':user_id' => $user_id,
												':payments_id' => $payment_id,
												':status' => $status));

			if ( $sth_reponse )
			{
				$order_id = $sth->lastInsertId();

				return $order_id;
			}
			else
			{
				return false;
			}
		}

		return false;
	}

	public function updateOrder()
	{

	}

	public function getOrderById()
	{

	}

	public function getOrdersByUsername()
	{
		
	}

	public function printInvoice()
	{

	}

	public function getInvoicePDF()
	{
		
	}

	public function getNewOrdersToday()
	{
		$today = date("Y-m-d");

		$sql = "SELECT * FROM orders WHERE orderdate = :today";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(':today' => $today));

		if ( $sth->rowCount() >= 1 )
		{
			$result = $sth->fetchAll();
			return $result;
		}

		return false;
	}
}

?>