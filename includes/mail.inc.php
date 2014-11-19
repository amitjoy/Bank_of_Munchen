<?php

require_once '../../libs/mail/swift_required.php';

$transport = Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
				  ->setUsername('bankofmuenchen@gmail.com')
				  ->setPassword('ILoveSecureCoding')
				  ;

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);


?>