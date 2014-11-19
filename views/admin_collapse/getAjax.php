<?php
require_once '../../includes/global.inc.php';
require_once '../../utils/Account.util.php';
require_once '../../includes/mail.inc.php';


//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
    header("Location: banklogin.php");
}

$function = Validation::xss_clean(DB::makeSafe($_POST["function"]));
$emailId = Validation::xss_clean(DB::makeSafe($_POST["emailId"]));
$amount = Validation::xss_clean(DB::makeSafe($_POST["amount"]));
$iban = Validation::xss_clean(DB::makeSafe($_POST["iban"]));
$bic = Validation::xss_clean(DB::makeSafe($_POST["bic"]));
$tan = Validation::xss_clean(DB::makeSafe($_POST["tan"]));
$isActive = ($amount > 10000) ? 0 : 1;
$password = Validation::xss_clean(DB::makeSafe($_POST["password"]));
$error = "";

if ($function == "transaction") {

	$sessionEmailId = Validation::xss_clean($_SESSION["emailId"]);

	if (filter_var($sessionEmailId, FILTER_VALIDATE_EMAIL) != true) {
        $error.="Email Validation Failed";
    }

	//The Main Validation Begins
	if (filter_var($emailId, FILTER_VALIDATE_EMAIL) != true) {
		$error.=" Email Validation Failed ");
	}

	if (!preg_match("[-+]?([0-9]*.[0-9]+|[0-9]+)", $amount)) {
		$error.=" Amount Validation Failed ";
	}

	if (!preg_match("^\d{14}$", $iban)) {
		$error.=" IBAN Validation Failed ";
	}

	if (!preg_match("^\d{6}$", $bic)) {
		$error.=" BIC Validation Failed ";
	}

	if (!preg_match("^\d{15}$", $tan)) {
		$error.=" TAN Validation Failed ";
	}

	if ($error != "") {
		echo $error;
		return;
	}

	if ($emailId != $sessionEmailId) {
		header ("Location: banklogin.php");
	}

	if (!$userTools->login($emailId, $password)){ 
        echo("Login Failed");
		return;
    }

	if (!isset($_SESSION["emailId"])) {
		header ("Location: banklogin.php");
	}



	// Check the balance of the current user
	$balance = AccountUtils::checkBalance($emailId);

	//Check if IBAN already exists and if yes, then return the balance
	$balanceOfTheTargetUser = AccountUtils::checkBalanceIBAN($iban);


	$data = array(
			"iban" => $iban,
			"bic" => $bic,
			"amount" => $amount,
			"userId" => "'$emailId'",
			"date" => "'".date('Y-m-d H:i:s')."'",
			"closingBalance" => $balance,
			"isActive" => $isActive,
			"type" => "DEBIT"
		);
	// Check if the user has a transaction that is not yet approved
	$noOfUnapprovedTransactionsArray = $db->select("TRANSACTIONS", "userId = '$userId' AND isActive = 0");

	// Balance check whether it can get executed or not
	if ($balance != "") {

		if ( bccomp($amount, $balance, FLOAT_PRECISION) == 1) {
			echo "Insufficient Fund";
			return;
		}
		elseif (array_key_exists("id", $noOfUnapprovedTransactionsArray)) {
			echo "You have previous unapproved transactions. Please wait for previous transaction approval first and then try again";
			return;
		}
		else {
			//Check TAN Validity
			if (AccountUtils::checkTANValidity($emailId, $tan)) {

				// If approval is not required, directly update the balance
				if ($isActive == 1) {

					//Update the balance
					$updatedBalanceAfterDeduction = 0;

					//Update the balance of the target user if the target user is already present in the same bank
					$updatedBalanceAfterAddition = 0;

					if ($balanceOfTheTargetUser != false) {

						// Insert the data in the TRANSACTION TABLE
						$db->insert($data, "TRANSACTIONS");

						$updatedBalanceAfterDeduction = bcsub ($balance, $amount, FLOAT_PRECISION);

						//Email id of target user
						$emailTargetUser = AccountUtils::getEmailFromIBAN($iban)

						$data = array(
									"iban" => AccountUtils::getIBANFromEmail($emailId),
									"bic" => $bic,
									"amount" => $amount,
									"userId" => $emailTargetUser,
									"date" => "'".date('Y-m-d H:i:s')."'",
									"closingBalance" => $balanceOfTheTargetUser,
									"isActive" => $isActive,
									"type" => "CREDIT"
								);

						// Insert the credit data in the TRANSACTION TABLE
						$db->insert($data, "TRANSACTIONS");
						
						$updatedBalanceAfterAddition = bcadd($balanceOfTheTargetUser, $amount, FLOAT_PRECISION);

						$dataTargetUser = array(
							"balance" => $updatedBalanceAfterAddition
						);

						$db->update ($dataTargetUser, "ACCOUNTS", "accountNo = '$iban'");

						$data = array (
							"balance" => $updatedBalanceAfterDeduction
						);

						$db->update ($data, "ACCOUNTS", "userId = '$emailId'");

						$data = array (
								"isActive" => 0
							);

						$db->update ($data, "TANS", "no = '$tan'");
					}
					else {
						echo "Invalid Recepient";
						return;
					}

					//send transaction confirmation email to the user
				    $message = Swift_Message::newInstance()

				              ->setSubject(MAIL_SUBJECT_TRANSACTION)

				              ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

				              ->setTo(array($emailId))

				              ->setBody(MAIL_BODY_TRANSACTION_NO_APPROVAL)
				              
				              ;

				    $mailer->send($message);

					echo "Balance Updated";

					return;
				}
					//send transaction confirmation email to the user
				    $message = Swift_Message::newInstance()

				              ->setSubject(MAIL_SUBJECT_TRANSACTION)

				              ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

				              ->setTo(array($emailId))

				              ->setBody(MAIL_BODY_TRANSACTION_APPROVAL)
				              
				              ;

				    $mailer->send($message);
				    
				    $data = array (
							"isActive" => 0
						);

					$db->update ($data, "TANS", "no = '$tan'");

				echo "Transaction Sent for Approval";

				return;
			}
			else {
				echo "TAN No invalid";
				return;
			}
		}
	}
	echo "Something went wrong please try again!";
	return;
}
?>
