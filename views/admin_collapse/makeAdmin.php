<?php
require_once '../../includes/global.inc.php';
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

  $emailToUpdate = Validation::xss_clean(DB::makeSafe ($_GET["emailId"]));

  if (filter_var($emailToUpdate, FILTER_VALIDATE_EMAIL) != true) {
    header ("Location: error.php?message=Email Validation Failed");
  }


  $updateData = array (
      "isAdmin" => 1
    );

  // Make the user active
  $db->update ($updateData, "USERS", "emailId = '$emailToUpdate'");

  //send TAN email to the user 
    $message = Swift_Message::newInstance()

              ->setSubject(MAIL_SUBJECT_USER_APPROVED_AS_ADMIN)

              ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

              ->setTo(array($emailToUpdate))

              ->addPart(MAIL_BODY_USER_APPROVED_AS_ADMIN)
              
              ;

    $mailer->send($message);

}
catch (Exception $e) {
  header("Location: error.php");
  return;
}
$token = NoCSRF::generate( 'csrf_token' );

	header("Location: usersPrivChange.php?csrf_token=".$token);
?>
