<?php
require_once 'UserTools.class.php';
require_once 'DB.class.php';


class Account {

	private $userId;
	private $balance;
	private $accountNo;
	private $password;
	private $sectype;


	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this->userId = (isset($data['userId'])) ? $data['userId'] : "";
		$this->balance = (isset($data['balance'])) ? $data['balance'] : "";
		$this->accountNo = (isset($data['accountNo'])) ? $data['accountNo'] : "";
		$this->password = (isset($data['password'])) ? $data['password'] : "";
		$this->sectype = (isset($data['securitytype'])) ? $data['securitytype'] : "";
	}

	public function save ($isNewAccount = false) {
		//create a new database object.
		$db = DB::getInstance();
		
		if ($isNewAccount) {

			$data = array(
				"userId" => Validation::xss_clean(DB::makeSafe("'$this->userId'")),
				"balance" => Validation::xss_clean(DB::makeSafe("'$this->balance'")),
				"accountNo" => Validation::xss_clean(DB::makeSafe("'$this->accountNo'")),
				"password" => Validation::xss_clean(DB::makeSafe("'$this->password'")),
				"securitytype" => Validation::xss_clean(DB::makeSafe("'$this->sectype'")),
			);
			
			$this->id = $db->insert($data, "ACCOUNTS");
		}
		
		return true;
	}
	
}

?>