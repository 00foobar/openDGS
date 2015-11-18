<?php
	include('bootstrap.php');
	

$file = './callback.log';

file_put_contents($file, "\n---\nrequest\n");
file_put_contents($file, print_r($_REQUEST, 1) . "\n", FILE_APPEND | LOCK_EX);

?>