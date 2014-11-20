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

if (!$userTools->isAdmin($sessionEmailId)) {
    header("Location: banklogin.php");
}

try {
	NoCSRF::check( 'csrf_token', $_GET, true, 60*10, false );

	$emailId = Validation::xss_clean(DB::makeSafe($_SESSION["emailId"]));

	$isAdmin = false;

	$data = mysql_query("SELECT * FROM USERS WHERE emailId = '$emailId' AND isActive = 1 AND isAdmin = 1");

	if (mysql_num_rows($data) == 1) {

		$updateData = array (
				"isActive" => 1
			);

		$transactionToUpdate = Validation::xss_clean(DB::makeSafe ($_GET["id"]));

		$emailIdOfTransaction = Validation::xss_clean(DB::makeSafe ($_GET["emailId"]));

		if (filter_var($emailIdOfTransaction, FILTER_VALIDATE_EMAIL) != true) {
   			 header ("Location: error.php?message=Email Validation Failed");
   		}

   		if (filter_var($transactionToUpdate, FILTER_VALIDATE_INT) != true) {
   			 header ("Location: error.php?message=Transaction ID Validation Failed");
		}

	}
}
catch (Exception $e){
	header("Location: error.php");
	return;
}
$token = NoCSRF::generate( 'csrf_token' );

    header("Location: admin.php?csrf_token=".$token);
}

?>
