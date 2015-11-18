<?php

class User
{
	// the database handler
	private $dbh;
	private $config;

	// user attributes
	private $username;
	private $email;
	private $password;
	private $password_repeat;
	private $conditions;
	private $prename;
	private $lastname;

	private $id = null;

	public function __construct()
	{
		// initialize configs
		$this->config = new Config();

		// initialize the PDO handler
		try
		{
			$this->dbh = new PDO($this->config->getHostDB(), $this->config->getUserDB(), $this->config->getPassDB(), $this->config->getCharDB());
		}
		catch (Exception $e)
		{
			//echo "No connection to database: ",  $e->getMessage(), "\n";
			echo 'No connection to database.';
		}
	}

	// @TODO strip_tags
	// set-methods
	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function setPasswordRepeat($password_repeat)
	{
		$this->password_repeat = $password_repeat;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setConditions($conditions)
	{
		$this->conditions = $conditions;
	}

	public function setPrename($prename)
	{
		$this->prename = $prename;
	}

	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
	}

	// get-methods
	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getId()
	{
		return $this->id;
	}

	// returns an array with user-informations for the given id
	public function getUserArrayById($id)
	{
		$sql = "SELECT * FROM users WHERE id = :id";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();

		if ( $sth->rowCount() == 1 )
		{
			$result = $sth->fetchAll();
			return $result[0];
		}

		return false;
	}

	// register a new user
	public function Register()
	{
		// validate the user inputs
		if ( !Validate::Username($this->username) )
		{
			throw new Exception("Username validation returns false.", 1);
			return false;
		}

		if ( !Validate::Password($this->password) )
		{
			throw new Exception("Password validation returns false.", 1);
			return false;
		}

		if ( !Validate::Email($this->email) )
		{
			throw new Exception("Email validation returns false.", 1);
			return false;
		}

		if ( !Validate::Get($this->prename) )
		{
			throw new Exception("Prename returns false.", 1);
			return false;
		}

		if ( !Validate::Get($this->lastname) )
		{
			throw new Exception("Lastname validation returns false.", 1);
			return false;			
		}

		// check if user is already registered
		if ( $this->existsEmail() )
		{
			throw new Exception("E-mail is already in use.", 1);
			return false;
		}

		if ( $this->existsUsername() )
		{
			throw new Exception("Username is already in use.", 1);
			return false;
		}

		// check if both given asswords are the same
		if ( !$this->equalPasswords() )
		{
			throw new Exception("Passwords are not the same.", 1);
			return false;
		}

		if ( $this->conditions != 'accepted' )
		{
			throw new Exception("You must accept the policy.", 1);
			return false;
		}

		// hash the password
		$password_md5 = md5($this->password);

		// register the user in the MySQL table
		$sql = "INSERT INTO users (username, email, password, active, prename, lastname, regdate) VALUES (:username, :email, :password, :active, :prename, :lastname, now())";
		$sth = $this->dbh->prepare($sql);

		$sth->execute(array(':username' => $this->username, ':email' => $this->email, ':password' => $password_md5, ':active' => 1, ':prename' => $this->prename, ':lastname' => $this->lastname));
		
		if ( $sth->rowCount() == 1 ) return true;
		else return false;
	}

	// compare password and passwort_repeat for registration
	public function equalPasswords()
	{
		if ( !empty($this->password) && !empty($this->password_repeat) && $this->password == $this->password_repeat )
		{
			return true;
		}

		return false;
	}

	// check if email exists
	public function existsEmail()
	{
		// check if email is already in use
		$sql = "SELECT id FROM users WHERE email = :email";
		$sth = $this->dbh->prepare($sql);

		$sth->execute(array(':email' => $this->email));
		
		if ( $sth->rowCount() == 0 ) return false;
		else return true;
	}

	// check if username exists
	public function existsUsername()
	{
		// check if username is already in use
		$sql = "SELECT id FROM users WHERE username = :username";
		$sth = $this->dbh->prepare($sql);

		$sth->execute(array(':username' => $this->username));
		
		if ( $sth->rowCount() != 0 ) return true;
		else return false;
	}

	// login a user
	public function Login()
	{
		// hash the password as md5
		$password_md5 = md5($this->password);

		$sql = "SELECT * FROM users WHERE username = :username AND password = :password";
		$sth = $this->dbh->prepare($sql);

		$sth->execute(array(':username' => $this->username, ':password' => $password_md5));

		if ( $sth->rowCount() != 0 )
		{
			$result = $sth->fetchAll();

			// if user is banned return false
			if ( $result[0]['active'] != 1 )
			{
				return false;
			}

			// set the id in instance
			$this->id = $result[0]['id'];

			// save id in $_SESSION
			$_SESSION['uid'] = $result[0]['id'];
			$_SESSION['email'] = $result[0]['email'];
			$_SESSION['username'] = $result[0]['username'];

			// check if user is a admin
			if ( $result[0]['admin'] == 1 ) $_SESSION['admin'] = true;
			else $_SESSION['admin'] = false;
			
			return true;
		}

		return false;
	}

	// logout current user
	public function Logout()
	{
		session_destroy();
	}

	// ban user with the given id
	public function banUser($id)
	{
		$sql = "UPDATE users SET active = 0 WHERE id = :id";

		$sth = $this->dbh->prepare($sql);

		if ( $sth->execute(array(':id' => $id)) )
		{
			return true;
		}

		return false;
	}

	// (re)activate user with the given id
	public function activateUser($id)
	{
		$sql = "UPDATE users SET active = 1 WHERE id = :id";

		$sth = $this->dbh->prepare($sql);

		if ( $sth->execute(array(':id' => $id)) )
		{
			return true;
		}

		return false;
	}

	// make user with given id to admin
	public function setAdmin($id)
	{
		$sql = "UPDATE users SET admin = 1 WHERE id = :id";

		$sth = $this->dbh->prepare($sql);

		if ( $sth->execute(array(':id' => $id)) )
		{
			return true;
		}

		return false;
	}

	// make user with given id to a user
	public function setUser($id)
	{
		$sql = "UPDATE users SET admin = 0 WHERE id = :id";

		$sth = $this->dbh->prepare($sql);

		if ( $sth->execute(array(':id' => $id)) )
		{
			return true;
		}

		return false;
	}

	// get an array with the new registrations today
	public function getNewUsersToday()
	{
		$today = date("Y-m-d");

		$sql = "SELECT * FROM users WHERE regdate = :today";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(':today' => $today));

		if ( $sth->rowCount() >= 1 )
		{
			$result = $sth->fetchAll();
			return array_reverse($result);
		}

		return false;
	}

	// get the username to a given uid
	public function getUsernameById($uid)
	{
		if ( is_numeric($uid) )
		{
			$sql = "SELECT username FROM users WHERE id = :uid";
			$sth = $this->dbh->prepare($sql);
			$sth->execute(array('uid' => $uid));

			if ( $sth->rowCount() == 1 )
			{
				return $sth->fetchColumn();
			}
		}

		return false;
	}

	public function getSessionUid()
	{
		if ( isset($_SESSION['uid']) && !empty($_SESSION['uid']) && is_numeric($_SESSION['uid']) )
		{
			return intval($_SESSION['uid']);
		}

		return false;
	}

	// check if user is logged in current
	public function isLoggedIn()
	{
		if ( isset($_SESSION['uid']) && Validate::issetValidation($_SESSION['uid']) )
		{
			return true;
		}

		return false;
	}

	// check if user is a admin
	public function isAdmin()
	{
		if ( isset($_SESSION['admin']) && Validate::issetValidation($_SESSION['admin']) )
		{
			if ( $_SESSION['admin'] == true )
			{
				return true;
			}
		}

		return false;
	}

	public function isAdminPasswordChanged()
	{
		$sql = "SELECT password FROM users WHERE id = 1";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		if ( $sth->rowCount() > 0 )
		{
			$admin_password = $sth->fetchColumn();
			$standard_admin_password = md5('password');

			if ( $admin_password == $standard_admin_password )
			{
				return false;
			}
			else
			{
				return true;
			}
		}

		return true;
	}
}

?>