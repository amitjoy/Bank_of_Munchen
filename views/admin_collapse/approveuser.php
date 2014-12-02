<?php
require_once '../../includes/global.inc.php';
require_once '../../includes/mail.inc.php';
require_once '../../libs/pdf/mpdf.php';
require_once '../../utils/Generators.util.php';


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
  $initialAmount = Validation::xss_clean(DB::makeSafe ($_GET["initial_amount"]));

  $updateData = array (
        "isActive" => 1
      );

  // Update the initial balance
  $updateBalanceData = array (
      "balance" => $initialAmount
    );

  if (filter_var($emailToUpdate, FILTER_VALIDATE_EMAIL) != true) {
    header ("Location: error.php?message=Email Validation Failed");
  }
  
  
  if (!preg_match("/^[[:digit:]]+$/", $initialAmount)) {
    header ("Location: error.php?message=Initial Amount Validation Failed");
  }

  //$tanNos = $db->select("TANS", "userId = '$emailToUpdate'");
  $tanNos = Generators::generateTANs ($emailToUpdate, NO_OF_TAN);
  $tanEmailMessage = "";

  if (count($tanNos) > 2) {

    for ($i=0; $i < count($tanNos); $i++) { 
      $tanEmailMessage .= $i . ": " . $tanNos[$i] . "<br/>";
      $tanEmailMessage .= "<br/><hr>";
    }

    $password = Generators::randomPasswordGenerate(8);
  
    $mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 

    $mpdf=new mPDF('win-1252','A4','','',20,15,48,25,10,10); 
    $mpdf->useOnlyCoreFonts = true;
    $mpdf->SetTitle("Bank of Muenchen TANS");
    $mpdf->SetAuthor("Bank of Muenchen");
    $mpdf->SetWatermarkText("Bank of Muenchen");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->SetProtection(array('print'), $password, "");
    $mpdf->WriteHTML($tanEmailMessage);
    $filename = 'TANs_List_'.$emailToUpdate.'.pdf';

    $mpdf->Output($filename,'F');

    $attachment = Swift_Attachment::fromPath($filename);

    // Make the user active
    $db->update ($updateData, "USERS", "emailId = '$emailToUpdate'");

    $db->update ($updateBalanceData, "ACCOUNTS", "userId = '$emailToUpdate'");

    //send TAN email to the user 
    $message = Swift_Message::newInstance()

              ->setSubject(MAIL_SUBJECT_USER_APPROVED)

              ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

              ->setTo(array($emailToUpdate))

              ->attach($attachment)
      
              ->setBody("Password to access your TAN list: ". $password .  "\nBIC Code for online transaction:  634211")

                ;

    $mailer->send($message);
	chown($filename, 666);
    unlink($filename);

  }
  else if (count($tanNos) == 2) {

    // Make the user active
    $db->update ($updateData, "USERS", "emailId = '$emailToUpdate'");

    $db->update ($updateBalanceData, "ACCOUNTS", "userId = '$emailToUpdate'");

    //send TAN email to the user 
    $message = Swift_Message::newInstance()

              ->setSubject(MAIL_SUBJECT_USER_APPROVED)

              ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

              ->setTo(array($emailToUpdate))
      
              ->setBody("SCS Username: ". $emailToUpdate ."\nSCS Password: ". $tanNos[0]."\nBIC Code for online transaction:  634211\n"." Please download the application from this link.\n Linux:- https://drive.google.com/file/d/0B9rxvt5WzazHaVMteFJNR2lBeXc/view?usp=sharing\n Windows:- https://drive.google.com/file/d/0B9rxvt5WzazHLW5SWXJ4OEF6S2c/view?usp=sharing  "  )
  
                ;

    $mailer->send($message);

  }
}
catch (Exception $e){
	
  header("Location: error.php");
  return;
}
  $token = NoCSRF::generate( 'csrf_token' );

	header("Location: admin.php?csrf_token=".$token);

?>