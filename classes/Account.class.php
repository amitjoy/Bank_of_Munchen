<?php
require_once 'UserTools.class.php';
require_once 'DB.class.php';


class Account {

	private $userId;
	private $balance;
	private $accountNo;
	private $password;


	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this->userId = (isset($data['userId'])) ? $data['userId'] : "";
		$this->balance = (isset($data['balance'])) ? $data['balance'] : "";
		$this->accountNo = (isset($data['accountNo'])) ? $data['accountNo'] : "";
		$this->password = (isset($data['password'])) ? $data['password'] : "";
	}

	public function save ($isNewAccount = false) {
		//create a new database object.
		$db = DB::getInstance();
		
		if ($isNewAccount) {

			$data = array(
				"userId" => DB::makeSafe("'$this->userId'"),
				"balance" => DB::makeSafe("'$this->balance'"),
				"accountNo" => DB::makeSafe("'$this->accountNo'"),
				"password" => DB::makeSafe("'$this->password'"),
			);
			
			$this->id = $db->insert($data, "ACCOUNTS");
		}
		
		return true;
	}
	
}

?>