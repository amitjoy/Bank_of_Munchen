<?php
require_once 'User.class.php';
require_once 'DB.class.php';

class UserTools {

	//Log the user in. First checks to see if the 
	//username and password match a row in the database.
	//If it is successful, set the session variables
	//and store the user object within.
	public function login ($username, $password)
	{
		$username = DB::makeSafe ($username);
		$password = DB::makeSafe ($password);

		//$hashedPassword = hash('sha512', $password);
		$result = mysql_query("SELECT * FROM ACCOUNTS WHERE userId = '$username' AND password = '$password'");

		if(mysql_num_rows($result) == 1)
		{
			$result = mysql_query("SELECT * FROM USERS WHERE emailId = '$username' AND isActive = 1");

			if (mysql_num_rows($result) == 1) {

				$row = mysql_fetch_object($result);

				$_SESSION["user"] = serialize(new User(mysql_fetch_assoc($result)));
				$_SESSION["emailId"] = $row->emailId;
				$_SESSION["login_time"] = time();
				$_SESSION["logged_in"] = 1;
				return true;
			}
			return false;
		} else {
			return false;
		}
	}
	
	//Log the user out. Destroy the session variables.
	public function logout () {
		unset($_SESSION["user"]);
		unset($_SESSION["emailId"]);
		unset($_SESSION["login_time"]);
		unset($_SESSION["logged_in"]);
		session_destroy();
	}

	//Check to see if a email already exists.
	//This is called during registration to make sure all user names are unique.
	public function checkEmailExists ($username) {
		$username = DB::makeSafe ($username);

		$query = "SELECT * FROM USERS WHERE emailId = '$username'";
		
		$result = mysql_query($query);

    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	} else {
	   		return true;
		}
	}
	
	//get a user
	//returns a User object. Takes the users id as an input
	public function get ($emailId)
	{
		$db = DB::getInstance();
		$emailId = DB::makeSafe ($emailId);
		
		$result = $db->select('USERS', "emailId = '$emailId' AND isActive = 1");

		$user = new User($result);
		
		return $user;
	}

	public function isAdmin ($emailId)
	{
		$db = DB::getInstance();
		$emailId = DB::makeSafe ($emailId);
		
		$result = $db->select('USERS', "emailId = '$emailId' AND isActive = 1");

		if ($result["isAdmin"] == 1)
		{
			return true;
		}

		return false;
	}

	public function getAccountNo ($emailId) {
		$db = DB::getInstance();
		$emailId = DB::makeSafe ($emailId);

		$result = $db->select('ACCOUNTS', "userId = '$emailId'");

		return $result["accountNo"];
	}
	
	public function isRejected ($emailId)
	{
		$db = DB::getInstance();
		$emailId = DB::makeSafe ($emailId);
		
		$result = $db->select('USERS', "emailId = '$emailId'");

		if ($result["isActive"] == 2)
		{
			return true;
		}

		return false;
	} 
	
}

?>
