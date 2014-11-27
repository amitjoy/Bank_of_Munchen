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
    echo("Email Validation Failed");
    return;
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

		//send forgot password confirmation email to the user
	    $message = Swift_Message::newInstance()

	              ->setSubject(MAIL_SUBJECT_FORGOT_PASS)

	              ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

	              ->setTo(array($emailToReset))

	              ->setBody('You password has been updated to '.$password)
	              
	              ;

	    $mailer->send($message);

	    echo("Your password has been reset. Please check your mail for further details.");
	}
	else
		echo("Email ID Not Registered");

}
catch (Exception $e) {
	echo ("Error in request");
	return;
}

?>
