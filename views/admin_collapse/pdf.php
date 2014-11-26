<?php
ob_start();

require_once '../../includes/global.inc.php';
require_once '../../libs/pdf/mpdf.php';
require_once '../../utils/Generators.util.php';
require_once '../../includes/mail.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
    header("Location: banklogin.php");
}

try {
  NoCSRF::check( 'csrf_token', $_GET, true, 60*10, false );
  
  $emailIdToRetrieveData = Validation::xss_clean(DB::makeSafe($_GET['emailId']));
  $emailId = Validation::xss_clean(DB::makeSafe($_SESSION["emailId"]));

  if (filter_var($emailId, FILTER_VALIDATE_EMAIL) != true) {
    header ("Location: error.php?message=Email Validation Failed");
  }

  if (filter_var($emailIdToRetrieveData, FILTER_VALIDATE_EMAIL) != true) {
    header ("Location: error.php?message=Email Validation Failed");
  }

  if (strlen($emailIdToRetrieveData) != 0)
      if (!$userTools->isAdmin($emailId) && ($emailId != $emailIdToRetrieveData)) {
          header("Location: banklogin.php");
      }

  $userData = $db->select("USERS", "emailId = '$emailIdToRetrieveData' AND isActive = 1");
  $transactionData = mysql_query("SELECT * FROM TRANSACTIONS WHERE userId = '$emailIdToRetrieveData'");
  $accountData = $db->select("ACCOUNTS", "userId = '$emailIdToRetrieveData'");

}
catch (Exception $e) {
  header ("Location: error.php");
}

$html = '
<html>
<head>
<style>
body {font-family: sans-serif;
    font-size: 10pt;
}
p {    margin: 0pt;
}
td { vertical-align: top; }
.items td {
    border-left: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
    text-align: center;
    border: 0.1mm solid #000000;
}
.items td.blanktotal {
    background-color: #FFFFFF;
    border: 0mm none #000000;
    border-top: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;
}
.items td.totals {
    text-align: right;
    border: 0.1mm solid #000000;
}
</style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB;"><span style="font-weight: bold; font-size: 14pt;">Bank of Muenchen</span><br />123 Hochstr. 22a<br />81669 Munich<br /><br /><span style="font-size: 15pt;">&#9742;</span> 01777 123 567</td>
<td width="50%" style="text-align: right;"><br /><span style="font-weight: bold; font-size: 12pt;"></span></td>
</tr></table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<div style="text-align: right">Date: '.date('jS F Y').'</div>

<table width="100%" style="font-family: serif;" cellpadding="10">
<tr>
<td width="45%" style="border: 0.1mm solid #888888;"><span style="font-size: 7pt; color: #555555; font-family: sans;">STATEMENT FOR:</span><br /><br />'.$userData["firstName"]. " " . $userData["middleName"]. " " . $userData["lastName"].'<br /> '. $userData["emailId"] .'<br />'. $userData["mobileNo"] .'</td>
<td width="10%">&nbsp;</td>
<td width="45%" style="border: 0.0mm solid #888888;"></td>
</tr>
</table>


<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
<thead>
<tr>
<td width="15%">IBAN</td>
<td width="10%">DATE</td>
<td width="45%">AMOUNT</td>
<td width="15%">STATUS</td>
<td width="15%">CLOSING BALANCE</td>
</tr>
</thead>
<tbody>';

$html1 = "";

while ($row = mysql_fetch_object($transactionData)) {

	if ($row->isActive == 1)
		$active = 'APPROVED';
	else if ($row->isActive == 0)
		$active = 'PENDING';
	else
		$active = 'REJECTED';

	$html1 .= '<tr>
			<td align="center">'. $row->iban .'</td>
			<td align="center">'. $row->date .'</td>
			<td>&euro; '. $row->amount .'</td>
			<td align="right">'. $active .'</td>
			<td align="right">&euro; '. $row->closingBalance .'</td>
			</tr>';
}


$html2 = '<tr>
<td class="blanktotal" colspan="5" rowspan="6"></td>
</tr>
<tr>
</tr>
</tbody>
</table>
<div style="text-align: center; font-style: italic;">Do keep the statement safe</div>
</body>
</html>
';

$fileName = date("Y-m-d H:i:s")."_".$emailIdToRetrieveData;
$password = Generators::randomPasswordGenerate(8);

// SEND THE PASSWORD TO THE ONE WHO IS ACCESSING THE PDF
$message = Swift_Message::newInstance()

          ->setSubject(MAIL_SUBJECT_PDF)

          ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

          ->setTo(array($emailId))

          ->setBody("Password: ". $password)
          
          ;

$mailer->send($message);

$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 

$mpdf=new mPDF('win-1252','A4','','',20,15,48,25,10,10); 
$mpdf->useOnlyCoreFonts = true;    // false is default
$mpdf->SetProtection(array('print'), $password, "");
$mpdf->SetTitle("Bank of Muenchen Statement");
$mpdf->SetAuthor("Bank of Muenchen");
$mpdf->SetWatermarkText("Bank of Muenchen");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($html.$html1.$html2);

$mpdf->Output($fileName, "D");

exit;

?>
