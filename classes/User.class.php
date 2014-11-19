<?php
require_once 'UserTools.class.php';
require_once 'DB.class.php';


class User {

	private $firstName;
	private $lastName;
	private $middleName;
	private $createdDate;
	private $isActive;
	private $emailId;
	private $mobileNo;
	private $isAdmin;


	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this->emailId = (isset($data['emailId'])) ? $data['emailId'] : "";
		$this->firstName = (isset($data['firstName'])) ? $data['firstName'] : "";
		$this->lastName = (isset($data['lastName'])) ? $data['lastName'] : "";
		$this->middleName = (isset($data['middleName'])) ? $data['middleName'] : "";
		$this->createdDate = (isset($data['createdDate'])) ? $data['createdDate'] : "";
		$this->isActive = (isset($data['isActive'])) ? $data['isActive'] : "";
		$this->mobileNo = (isset($data['mobileNo'])) ? $data['mobileNo'] : "";
		$this->isAdmin = (isset($data['isAdmin'])) ? $data['isAdmin'] : "";
	}

	function getEmailId() {
		return $this->emailId;
	}

	function getFirstName() {
		return $this->firstName;
	}

	function getLastName() {
		return $this->lastName;
	}

	function getMiddleName() {
		return $this->middleName;
	}

	function getCreatedDate() {
		return $this->createdDate;
	}

	function getIsActive() {
		return $this->isActive;
	}

	function getMobileNo() {
		return $this->mobileNo;
	}

	function getIsAdmin() {
		return $this->isAdmin;
	}

	public function save($isNewUser = false) {
		//create a new database object.
		$db = DB::getInstance();


		if ($isNewUser) {
			$data = array(
				"firstName" => DB::makeSafe("'$this->firstName'"),
				"lastName" => DB::makeSafe("'$this->lastName'"),
				"middleName" => DB::makeSafe("'$this->middleName'"),
				"createdDate" => DB::makeSafe("'$this->createdDate'"),
				"isActive" => DB::makeSafe("'$this->isActive'"),
				"emailId" => DB::makeSafe("'$this->emailId'"),
				"mobileNo" => DB::makeSafe("'$this->mobileNo'"),
				"isAdmin" => DB::makeSafe("'$this->isAdmin'"),
			);

			$this->id = $db->insert($data, "USERS");
		}
		return true;
	}
	
}

?>