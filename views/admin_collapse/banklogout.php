<?php

require_once '../../includes/global.inc.php';

try {
	NoCSRF::check( 'csrf_token', $_GET, true, 60*10, false );

	$userTools = new UserTools();
	$userTools->logout();

	header("Location: banklogin.php");
}
catch (Exception $e) {
	header("Location: error.php");
}

?>