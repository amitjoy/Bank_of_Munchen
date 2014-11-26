<?php

require_once "RandomAccNoGenerator.util.php";
require_once "../../classes/DB.class.php";
require_once '../../libs/aes-sec/AES.php';
require_once '../../includes/constants.inc.php';

ini_set('precision', 17);

class Generators {

	/**
	 * Generates Random Password of given length
	 * @param unknown_type $length Password Length
	 */
	public static function randomPasswordGenerate ($length) {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < $length; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	
	/**
	 * Generates Unique id
	 * @param unknown_type $userId
	 */
	public static function generateuniqueId ($id) {
		return md5(uniqid($id, true));
	}
	
	/**
	 * Generates Unique Random Account No
	 */
	public static function generateUniqueAccountNo () {
		$customAlphabet = '0123456789';
		
		// Set initial alphabet.
		$generator = new RandomStringGenerator($customAlphabet);
		
		// Change alphabet whenever needed.
		$generator->setAlphabet($customAlphabet);
		
		// Set token length.
		$tokenLength = 14;
		
		// Call method to generate random string.
		$token = $generator->generate($tokenLength);
		
		return $token;
	}
	/**
	* Generate Unique TAN No to be stored in the DB
	*/
	private static function generateTAN_old () {

		$db = DB::getInstance();
		$db->connect();
		$randomNumber = 0;

		while(1) {
		    // generate unique random number
		    $randomNumber = rand(0, 999999999999999);
		    // check if it exists in database
		    $query = "SELECT * FROM TANS WHERE no=$randomNumber";
		    $res = mysql_query($query);
		    $rowCount = mysql_num_rows($res);
		    // if not found in the db (it is unique), break out of the loop
		    if($rowCount < 1) {
		        break;
		    }
		}
		return $randomNumber; 
	}

	public static function generateTANs_old ($limit) {

		$tanArray = array();

		for ($i = 0; $i < $limit; $i++) { 
			array_push($tanArray, self::generateTAN());
		}

		return $tanArray;
	}

	private static function generateTAN_old_old_old ($key) {

		$imputText = bcadd (self::num ($key), self::randomPrimeNumber());
		$imputKey = $key;
		$blockSize = 256;

		$aes = new AES($imputText, $imputKey, $blockSize);

		$enc = $aes->encrypt();
		return $enc;
	}
	
	private static function generateKey ($emailId) {
	
		$db = DB::getInstance();
		$db->connect();

		$config = array(
		    "digest_alg" => DIGEST_ALG,
		    "private_key_bits" => PRIVATE_KEY_BITS,
		    "private_key_type" => KEY_TYPE,
		);   
		
		$privateKeyResource = openssl_pkey_new($config);
		openssl_pkey_export($privateKeyResource, $privateKey);
		$privateKey = str_replace('-----BEGIN PUBLIC KEY-----', '', $privateKey);
		$privateKey = trim(str_replace('-----END PUBLIC KEY-----', '', $privateKey));
		
		$publicKeyResource = openssl_pkey_get_details ($privateKeyResource);
		$publicKey = $publicKeyResource["key"];
		$publicKey = str_replace('-----BEGIN PUBLIC KEY-----', '', $publicKey);
		$publicKey = trim(str_replace('-----END PUBLIC KEY-----', '', $publicKey));
		
		$data = array(
				"pkey" => "'". $publicKey ."'",
				"ptkey" => "'". $privateKey ."'"
			);
		
		$db->update ($data, "ACCOUNTS", "userId = '$emailId'");

		openssl_pkey_free($privateKeyResource);
		openssl_pkey_free($publicKeyResource);

		return $publicKey;
		
	}
	
	private static function generateTAN ($key) {
	
		$db = DB::getInstance();
		$db->connect();

		$accountData = $db->select("ACCOUNTS", "userId = '$key'");
		$accountNo = "";

		if (is_array($accountData) && $accountData["accountNo"] != "") {
			$accountNo = $accountData["accountNo"];
		}
		
		$tanNo = "";
		
		// while (1) {
		
			openssl_public_encrypt($accountNo, $tanNo, self::generateKey ($key));
			// check if it exists in database
			// $query = $db->select ("TANS", "no = '$tanNo'");
			// $rowCount = count($query);
		    // if not found in the db (it is unique), break out of the loop
		    // if($rowCount == 0) {
		    //     break;
		    // }
			
		// }
		
		return base64_encode($tanNo);
	}

	private static function randomPrimeNumber () {

		$start = rand ( 12345 , 7999999 );

		for ($i = $start; $i < 9999999 ; $i++) { 

			if (self::is_prime($i)) {
				return $i;
			}
		}

		return false;

	}


	private static function is_prime($number){

		$limit = round(bcsqrt($number));
		
		$counter = 2;

		while ($counter <= $limit){

			if (bcmod($number, $counter) == 0){
				return true;
			}

			$counter ++;
		}
		return false;
	}
	public static function generateTANs ($emailId, $limit) {
		
		$db = DB::getInstance();
		$db->connect();
		
		$tanArray = array();
		
		$data = $db->select("ACCOUNTS", "userId = '$emailId'");
		
		if (is_array($data) & $data["securitytype"] != "") {
			$securitytype = $data["securitytype"];
			
			if ($securitytype == 1) {
				//TAN
				for ($i = 0; $i < $limit; $i++) { 
				
					$tanNo = self::generateTAN($emailId);
					array_push($tanArray, $tanNo);
					
					$insertData = array(
							"no" => "'". $tanNo ."'",
							"userId" => "'". $emailId ."'",
							"isActive" => 0
						);
						
					$db->insert($insertData, "TANS");
				}
				
			}
			else if ($securitytype == 2) {
				//SCS
			}
			else {
				//DO NOTHING
			}
		}

		return $tanArray;
	}

	
	public static function generateTANs_old_old ($emailId, $limit) {
		$tanArray = array();

		for ($i = 0; $i < $limit; $i++) { 
			array_push($tanArray, self::generateTAN($emailId));
		}

		return $tanArray;
	}

	private static function num($text)
    {
	    $num = null;

	    for ($i = 0; $i < strlen($text); $i++)
	    {
	    	$num =$num.ord($text[$i]);
	    }
	    return ($num);
    }

	/**
	* Used to generate transaction ids
	*/
	public static function generateTAN_Old_old ($limit) {

		$db = DB::getInstance();
		$db->connect();

		$tanArray = array();

		$startTANdefaultNo = 456928631837232;

		$query = "SELECT * FROM TANS ORDER BY no DESC LIMIT 1";
		
		$result = mysql_query($query);

		if (mysql_num_rows($result) == 1) {
			$row = mysql_fetch_object($result);

			$startTAN = $row->no + 1;

			for ($i = $startTAN; $i < $startTAN + $limit; $i++) { 
				array_push($tanArray, $i);
			}

			return $tanArray;
		}

		for ($i = $startTANdefaultNo; $i < $startTANdefaultNo + $limit; $i++) { 
			array_push($tanArray, $i);
		}

		return $tanArray;
	}
	
	function trunc($float, $prec = 2) {
		return substr(round($float, $prec+1), 0, -1);
	}
}
