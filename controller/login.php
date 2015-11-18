<?php
require_once('../bootstrap.php');

$username = $_POST['username'];
$password = $_POST['password'];
$uid = null;


if ( !Validate::Username($username) && !Validate::Password($password) )
{
	echo json_encode(false);
	exit();
}

$user = new User();

$user->setUsername($username);
$user->setPassword($password);

if ( $user->Login() )
{
	//redirect to home
	echo json_encode(true);
	exit();
}

// redirect to home 
echo json_encode(false);

?>