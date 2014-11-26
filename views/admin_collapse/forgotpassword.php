<?php
require_once '../../includes/global.inc.php';
require_once '../../utils/Account.util.php';
require_once '../../includes/mail.inc.php';
require_once '../../utils/Generators.util.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
    header("Location: banklogin.php");
}

$emailToReset = Validation::xss_clean(DB::makeSafe($_GET["mailId"]));

if (filter_var($emailToReset, FILTER_VALIDATE_EMAIL) != true) {
    header ("Location: error.php?message=Email Validation Failed");
}


try {

	$db = DB::getInstance();
	$db->connect();

	$accData = $db->select("ACCOUNTS", "userId = '$emailToReset'");

	if (is_array($accData) && $accData["userId"] != "") {

		$password = Generators::randomPasswordGenerate (15);

		$updateData = array (
				"password" => hash('sha512', $password);
			);

		$db->update ($updateData, "ACCOUNTS", "userId = '$emailToReset'");

		//send transaction confirmation email to the user
	    $message = Swift_Message::newInstance()

	              ->setSubject(MAIL_SUBJECT_FORGOT_PASS)

	              ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

	              ->setTo(array($emailToReset))

	              ->setBody('You password has been updated to '.$password)
	              
	              ;

	    $mailer->send($message);

	    header("Location: success.php?message=YOUR PASSWORD HAS BEEN RESET. CHECK YOUR MAIL FOR FURTHER DETAILS.");
	}
	else
		header("Location: error.php?message=Email ID Not Found.");

}
catch (Exception $e) {
	header("Location: error.php");
	return;
}

?>
