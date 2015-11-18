<?php
require_once('../../bootstrap.php');

$user = new User();

// checks if user is logged in and is a administrator
if ( !$user->isLoggedIn() || !$user->isAdmin() )
{
	// user is no admin or not logged in
	exit();
}

/* USER ACTIONS */
// deactivate a user
if ( isset($_POST['uid']) && is_numeric($_POST['uid']) && $_POST['action'] == 'deactivate' )
{

}

// activate a user
if ( isset($_POST['uid']) && is_numeric($_POST['uid']) && $_POST['action'] == 'activate' )
{

}

// make a user to admin
if ( isset($_POST['uid']) && is_numeric($_POST['uid']) && $_POST['action'] == 'makeadmim' )
{

}

// make a admin to user
if ( isset($_POST['uid']) && is_numeric($_POST['uid']) && $_POST['action'] == 'makeuser' )
{

}

// delete a item from a user
if ( isset($_POST['uid']) && is_numeric($_POST['uid']) && $_POST['action'] == 'deleteitem' && isset($_POST['itemid']) && is_numeric($_POST['itemid']) )
{

}

/* PRODUCT ACTIONS */
// delete a product
if ( isset($_POST['product']) && is_numeric($_POST['product']) && $_POST['action'] == 'delete' )
{

}

// create a product
//if ( isset($_POST['product']) && $_POST['product'] == 'create' && isset($_POST['name']) && is_string($_POST['name']) && isset($_POST['price'] && is_float($_POST['price']) && isset($_POST['category']) && is_string($_POST['category']) && isset($_POST['description']) && is_string($_POST['description']) && isset($_FILE) ) )
//{
//
//}

/* GENERAL SETTINGS */
if ( isset($_POST['user_min']) && is_numeric($_POST['user_min']) && isset($_POST['user_max']) && is_numeric($_POST['user_max']) && isset($_POST['pass_min']) && is_numeric($_POST['pass_min']) && isset($_POST['pass_max']) && is_numeric($_POST['pass_max']) && isset($_POST['shop_url']) && isset($_POST['shop_name']) && isset($_POST['shop_currency']) && isset($_POST['shop_percentfee']) && isset($_POST['shop_articlepp']) && isset($_POST['shop_impress']) && isset($_POST['shop_copyright']) )
{
	$config = new Config();

	if ( $config->saveSettings($_POST['user_min'], $_POST['user_max'], $_POST['pass_min'], $_POST['pass_max'], $_POST['shop_url'], $_POST['shop_name'], $_POST['shop_currency'], $_POST['shop_percentfee'], $_POST['shop_articlepp'], $_POST['shop_impress'], $_POST['shop_copyright']) )
	{
		echo json_encode(true);
	}
	else
	{
		echo json_encode(false);
	}
}

// offene baustellen: neue config klasse integrieren, actions / fileupload, items, orders, sauber machen, kommentieren

?>