<?php
include('../bootstrap.php');

// initialize the user class
$user = new User();
	
// checks if user is logged
if ( !$user->isLoggedIn() )
{
	// user is no admin or not logged in
	exit();
}

// initialize the view class
$view = new View();

// initialize the config class
$config = new Config();

// initialize the product class
$products = new Product();

// initialize the payment class
$payment = new Payment();

// initialite the order class
$order = new Order();

// get the order values for the payment-module

if ( isset($_POST['payment_method']) && !empty($_POST['payment_method']) && strlen($_POST['payment_method']) < 256 )
{
	$payment_method = strip_tags($_POST['payment_method']);

	if ( $payment->existsPaymentMethod($payment_method) )
	{
		$checkout_url = $payment->getCheckoutURL();

		$user_id = $user->getSessionUid();

		$payment_id = $payment->addNewPayment();

		if ( $payment_id != false )
		{
			$order_id = $order->addNewOrder($user_id, $product_id, $payment_id);

			if ( $order_id != false )
			{
				header('Location: ' . $checkout_url . '?order_id=' . $order_id);
				exit();
			}
		}
	}
	else
	{

	}

	header('Location: index.php');
	exit();
}
?>