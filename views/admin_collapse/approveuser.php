<?php
require_once '../../includes/global.inc.php';
require_once '../../includes/mail.inc.php';
require_once '../../libs/pdf/mpdf.php';


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

  $tanNos = $db->select("TANS", "userId = '$emailToUpdate'");

  $tanEmailMessage = "";

  // Email message to list all the tans for the user
  foreach ($tanNos as $key => $value) {
    foreach ($value as $k => $v) {
      if ($k == "no")
        $tanEmailMessage .= $k. ":" .$v . "<br/>";
    }
    $tanEmailMessage .= "<br/><hr>";
  }

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

  $content = chunk_split(base64_encode($content));
  $filename = 'TANs_List_'.$emailToUpdate.'.pdf';

  //Headers of PDF and e-mail
  $boundary = "XYZ-" . date("dmYis") . "-ZYX"; 

  $header = "--$boundary\r\n"; 
  $header .= "Content-Transfer-Encoding: 8bits\r\n"; 
  $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n\r\n"; //plain 
  $header .= "$message\r\n";
  $header .= "--$boundary\r\n";
  $header .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
  $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n";
  $header .= "Content-Transfer-Encoding: base64\r\n\r\n";
  $header .= "$content\r\n"; 
  $header .= "--$boundary--\r\n";

  $header2 = "MIME-Version: 1.0\r\n";
  $header2 .= "From: ".$from_name." \r\n"; 
  $header2 .= "Return-Path: $from_mail\r\n";
  $header2 .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
  $header2 .= "$boundary\r\n";

  $attachment = Swift_Attachment::newInstance($content, $filename, 'application/pdf');

  $attachment->getHeaders()->get('Content-Transfer-Encoding')->setValue('base64\r\n\r\n');


    $updateData = array (
        "isActive" => 1
      );

    // Make the user active
    $db->update ($updateData, "USERS", "emailId = '$emailToUpdate'");

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