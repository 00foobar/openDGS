<?php
require_once('../bootstrap.php');
$user = new User();
$user->Logout();
echo json_encode(true);
?>