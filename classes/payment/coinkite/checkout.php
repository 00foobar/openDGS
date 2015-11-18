<?php
require_once('bootstrap.php');

if ( isset($_GET['order_id']) && !empty($_GET['order_id']) && is_numeric($_GET['order_id']) )
{
	$order_id = intval($_GET['order_id']);
}
else
{
	echo 'Error: No order_id set.';
	exit();
}

$order = new Order();

$order_array = $order->getOrder($order_id);

if ( $order->isSessionAuthorized($order_id) )
{
	// yep, he has permissions for this order
}
else
{
	// the user has no permissions for this order
	echo 'Error: No Permissions.';
	exit();
}

	// insert Coinkite checkout-stuff here


	// get the product data
	$product = $products->getProductById(intval($_GET['id']));

	if ( $product != false )
	{
		// @TODO thats shitty
		$key = '';
		$secret = '';

		// initialize coinkite class
		require_once('classes' . DIRECTORY_SEPARATOR . 'payment' . DIRECTORY_SEPARATOR . 'coinkite' . DIRECTORY_SEPARATOR . 'Coinkite.php');
		$coinkite = new Coinkite($key, $secret);
		$coinkite->setAccount('My Bitcoins');
		$coinkite->setReturnURL('http://127.0.0.1/dev/dg/payment_callback.php');
		$coinkite->setCurrency('EUR');
		$coinkite->setPrice($product['price']);
		$coinkite->setDescription($product['description']);
		// $coinkite->setSocks5('');
	}


	try
	{
		$button = $coinkite->showPaymentButtonAnonym();
	}
	catch (Exception $e)
	{
		//echo $e->printMessage();
	}

	echo '<pre>';
	print_r($button);
	echo '</pre>';



/*
	include('coinkite' . DIRECTORY_SEPARATOR . 'CKRequestorODGS.php');
	

	date_default_timezone_set('UTC');
	
	$api_key = '';
	$api_secret = '';
 
 	$coindike = new CKRequestor($api_key, $api_secret);

 	$endpoint = '/v1/new/button';

 	$signature = $coindike->make_signature($endpoint);
 	$headers = $coindike->auth_headers($endpoint);

	$jwt = array(
		'account' => 'My Bitcoins',
		'use_token' => true,
		'description' => trimDescription('foobar goes in all fields!'),
		'price' => round(0.05, 2),
		'price_cct' => 'EUR',
		'return_url' => 'http://127.0.0.1/dev/dg/payment_callback.php', // checks if there is at least one transactionconfirmation in bitcoin_success.php, if yes costumer can get their stuff and order can be closed in db

		'nym' => 'name of nym as string',
		'tracking' => '(string) Your tracking number (free form).',
		'get_email' => true,
		'get_refund_addr' => false,
		'require_refund' => true,
		'get_text' => 'true'

	);

 	$result = $coindike->get($endpoint, $jwt);

 	echo $result;
 
	echo '<pre>';
	print_r($result);
	echo '</pre>';
*/
?>