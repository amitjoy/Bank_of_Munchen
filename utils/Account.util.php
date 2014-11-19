<?php
require_once "../../classes/DB.class.php";

class AccountUtils {
	// Furnction used to check balance of the
	// email id mentioned in the argument
	public static function checkBalance ($emailId) {

		$isActive = "";
		$balance = "";

		$db = DB::getInstance();
		$db->connect();

		$return = $db->select("USERS", "emailId = '$emailId'");

		if (array_key_exists("isActive", $return)) {
			$isActive = $return["isActive"];
		}

		if ($isActive == 0) {
			return $balance;
		}
		else {
			$return = $db->select("ACCOUNTS", "userId = '$emailId'");
			return $return["balance"];
		}

	}

	// Furnction used to check balance of the
	// IBAN mentioned in the argument
	public static function checkBalanceIBAN ($iban) {

		$isActive = "";
		$balance = "";

		$db = DB::getInstance();
		$db->connect();

		$return = $db->select("ACCOUNTS", "accountNo = '$iban'");

		if (is_array($return) && isset($return["balance"]))
			return $return["balance"];

		return false;

	}

	// Used to check whether the user has right to 
	// access the tan provided for the transaction
	public static function checkTANValidity ($emailId, $tanNo) {

		$db = DB::getInstance();
		$db->connect();

		$sql = "SELECT * FROM TANS WHERE isActive = 1 AND userId = '$emailId' ORDER BY id ASC LIMIT 1";

		$row = mysql_fetch_object(mysql_query($sql));

		if ($tanNo != $row->no) {
			return false;
		}
		else
			return true;
	} 

	// Returns IBAN from Email ID
	public static function getIBANFromEmail ($email) {

		$db = DB::getInstance();
		$db->connect();

		$return = $db->select("ACCOUNTS", "userId = '$email'");

		if (is_array($return) && isset($return["accountNo"]))
			return $return["accountNo"];

		return false;

	}

	// Returns Email ID from IBAN
	public static function getEmailFromIBAN ($iban) {

		$db = DB::getInstance();
		$db->connect();

		$return = $db->select("ACCOUNTS", "accountNo = '$iban'");

		if (is_array($return) && isset($return["userId"]))
			return $return["userId"];

		return false;

	}
}

?>