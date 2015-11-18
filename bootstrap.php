<?php
session_start(); // starts a session for user-management

// simple autoloader
function __autoload($className)
{
	if ( file_exists('classes/' . $className . '.php') )
	{
		require_once 'classes/' . $className . '.php';
		return true;
	}
	elseif ( file_exists('../classes/' . $className . '.php') )
	{
		require_once '../classes/' . $className . '.php';
		return true;
	}

	return false;
} 

?>