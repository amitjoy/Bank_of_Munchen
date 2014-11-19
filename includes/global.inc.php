<?php

error_reporting (E_ERROR | E_PARSE | E_WARNING);
// error_reporting(E_ALL);

//start the session
session_start();

// Requirements
require_once '../../libs/nocsrf.php';
require_once '../../classes/User.class.php';
require_once '../../classes/UserTools.class.php';
require_once '../../classes/DB.class.php';
require_once '../../classes/Account.class.php';
require_once '../../includes/constants.inc.php';
require_once '../../utils/InputValidation.util.php';

//connect to the database
$db = DB::getInstance();
$db->connect();

//initialize UserTools object
$userTools = new UserTools();

//refresh session variables if logged in
if(isset($_SESSION['logged_in'])) {

	$user = unserialize(Validation::xss_clean($_SESSION['user']));
	$_SESSION['user'] = serialize($userTools->get(Validation::xss_clean($_SESSION["emailId"])));
}
?>
