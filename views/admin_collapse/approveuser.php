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

  if (filter_var($emailToUpdate, FILTER_VALIDATE_EMAIL) != true) {
    header ("Location: error.php?message=Email Validation Failed");
  }
  
  
  if (!preg_match("/^[[:digit:]]+$/", $initialAmount)) {
    header ("Location: error.php?message=Initial Amount Validation Failed");
  }

  //$tanNos = $db->select("TANS", "userId = '$emailToUpdate'");
  $tanNos = Generators::generateTANs ($emailToUpdate, 100);

  $tanEmailMessage = "";

  for ($i=0; $i < count($tanNos); $i++) { 
    $tanEmailMessage .= $i . ": " . $tanNos[$i] . "<br/>";
    $tanEmailMessage .= "<br/><hr>";
  }

  // Email message to list all the tans for the user
  // foreach ($tanNos as $key => $value) {
  //   foreach ($value as $k => $v) {
  //     // if ($k == "no")
  //       $tanEmailMessage .= $k. ":" .$v . "<br/>";
  //   }
  //   $tanEmailMessage .= "<br/><hr>";
  // }

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
  $mpdf->WriteHTML(utf8_encode($tanEmailMessage));
  $filename = 'TANs_List_'.$emailToUpdate.'.pdf';

  $mpdf->Output($filename,'F');

  $attachment = Swift_Attachment::fromPath($filename);


    $updateData = array (
        "isActive" => 1
      );

	$emailToUpdateWithQuotes = "'$emailToUpdate'";
    // Make the user active
    $db->update ($updateData, "USERS", "emailId = $emailToUpdateWithQuotes");

    // Update the initial balance
    $updateData = array (
      "balance" => $initialAmount
    );

    $db->update ($updateData, "ACCOUNTS", "userId = $emailToUpdateWithQuotes");

    //send TAN email to the user 
      $message = Swift_Message::newInstance()

                ->setSubject(MAIL_SUBJECT_USER_APPROVED)

                ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

                ->setTo(array($emailToUpdate))

                ->attach($attachment)
  
                ;

      $mailer->send($message);
}
catch (Exception $e){
	
  header("Location: error.php");
  return;
}
  $token = NoCSRF::generate( 'csrf_token' );

	header("Location: admin.php?csrf_token=".$token);

?>