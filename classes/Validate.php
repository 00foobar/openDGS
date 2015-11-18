<?php

// a simple collection of static validation methods
// example: Validate::Username('franz');
class Validate
{
	// checks if a given parameter is not empty
	// returns true or false
	public static function issetValidation($var)
	{
		if ( isset($var) && !empty($var) )
		{
			return true;
		}

		return false;
	}

	// validate method for GET or POST arguments
	// checks: not empty, is alphanumeric, string lenght not over 255
	// returns true or false
	public static function Get($var)
	{
		if ( Validate::issetValidation($var) == true && ctype_alnum($var) && strlen($var) <= 255 )
		{
			return true;
		}

		return false;
	}

	// validate method for username
	// checks: not empty, is alphanumeric, string lenght not over 255, string length not under minimum length, string length not over maximum length
	// returns true or false
	public static function Username($var)
	{
		$config = new Config();

		if ( Validate::Get($var) == true )
		{
			$var_length = strlen($var);

			if ( $var_length >= $config->user_min && $var_length <= $config->user_max )
			{
				return true;
			}
		}

		return false;
	}

	// validate method for password
	// checks: not empty, is alphanumeric, string lenght not over 255, string length not under minimum length, string length not over maximum length
	// returns true or false
	public static function Password($var)
	{
		$config = new Config();

		if ( Validate::Get($var) == true )
		{
			$var_length = strlen($var);

			if ( $var_length >= $config->pass_min && $var_length <= $config->pass_max )
			{
				return true;
			}
		}

		return false;
	}

	// validate method for emailaddress
	// checks: not empty, string length not under 5 chars, string length not over 255 chars, PHP filter function for email
	// returns true or false
	public static function Email($var)
	{
		if ( Validate::issetValidation($var) && strlen($var) >= 5 && strlen($var) <= 255 )
		{
			if ( filter_var($var, FILTER_VALIDATE_EMAIL) )
			{
				return true;
			}
		}

		return false;
	}

}

?>