<?php
require_once('../bootstrap.php');

// get the registration arguments
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];
$conditions = $_POST['conditions'];
$prename = $_POST['prename'];
$lastname = $_POST['lastname'];

$user = new User();

$user->setUsername($username);
$user->setEmail($email);
$user->setPassword($password);
$user->setPasswordRepeat($password_repeat);
$user->setConditions($conditions);
$user->setPrename($prename);
$user->setLastname($lastname);

try
{
	if ( $user->Register() )
	{
		$user->Login();
		
		echo json_encode(true);
		exit();
	}
}
catch (Exception $e)
{
	echo json_encode($e->getMessage());
}

?>