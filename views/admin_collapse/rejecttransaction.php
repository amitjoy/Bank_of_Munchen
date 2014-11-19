<?php
require_once '../../includes/global.inc.php';
require_once '../../utils/Account.util.php';
require_once '../../includes/mail.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
    header("Location: banklogin.php");
}

$sessionEmailId = Validation::xss_clean($_SESSION["emailId"]);

if (filter_var($sessionEmailId, FILTER_VALIDATE_EMAIL) != true) {
    header ("Location: error.php?message=Email Validation Failed");
 }

if (!$userTools->isAdmin($sessionEmailId) {
    header("Location: banklogin.php");
}

try {
	NoCSRF::check( 'csrf_token', $_GET, true, 60*10, false );

	$emailId = Validation::xss_clean(DB::makeSafe($_SESSION["emailId"]));

	if (filter_var($emailId, FILTER_VALIDATE_EMAIL) != true) {
    	header ("Location: error.php?message=Email Validation Failed");
 	}

	$isAdmin = false;

	$data = mysql_query("SELECT * FROM USERS WHERE emailId = '$emailId' AND isActive = 1 AND isAdmin = 1");

	if (mysql_num_rows($data) == 1) {

		$updateData = array (
				"isActive" => 2
			);

		$transactionToUpdate = Validation::xss_clean(DB::makeSafe ($_GET["id"]));

		if (filter_var($transactionToUpdate, FILTER_VALIDATE_INT) != true) {
    		header ("Location: error.php?message=Transaction ID Validation Failed");
	    }

		$emailIdOfTransaction = Validation::xss_clean(DB::makeSafe ($_GET["emailId"]));

		if (filter_var($emailIdOfTransaction, FILTER_VALIDATE_EMAIL) != true) {
    		header ("Location: error.php?message=Email Validation Failed");
 	    }

		$transactionArray = $db->select("TRANSACTIONS", "id = '$transactionToUpdate'");

		// Check to see if the admin is rejecting its own transaction
		if ($emailIdOfTransaction == $emailId) {
			header("Location: error.php?message=You can't reject your own transaction");
			return;
		}


		// Make the transaction rejected
		$db->update ($updateData, "TRANSACTIONS", "id = '$transactionToUpdate'");


	    //send transaction confirmation email to the user
	    $message = Swift_Message::newInstance()

	              ->setSubject(MAIL_SUBJECT_REJECTION)

	              ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

	              ->setTo(array($emailIdOfTransaction))

	              ->setBody('We are very sorry to inform you that your transaction #'.$transactionToUpdate.' is rejected. Contact your branch for more details.')
	              
	              ;

	    $mailer->send($message);

	}
}
catch (Exception $e) {
	header("Location: error.php");
	return;
}
$token = NoCSRF::generate( 'csrf_token' );

    header("Location: admin.php?csrf_token=".$token);

?>
