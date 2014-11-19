<?php

require_once("../../classes/PluploadHandler.php");
require_once '../../includes/global.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
    header("Location: banklogin.php");
}

PluploadHandler::no_cache_headers();
PluploadHandler::cors_headers();

$emailId = Validation::xss_clean($_SESSION["emailId"]);

if (filter_var($emailId, FILTER_VALIDATE_EMAIL) != true) {
    header ("Location: error.php?message=Email Validation Failed");
}

$targetDir = LOCATION_OF_UPLOAD_DIR . $emailId;
$targetDirBlankFile = LOCATION_OF_UPLOAD_DIR . $emailId . "/index.php"; //Used to prevent listing of the folder contents

$fileName = date("Y-m-d_His").".txt";

if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (!file_exists($targetDirBlankFile)) {
	fopen($targetDirBlankFile, "w");
}

$configArray = array(
	'target_dir' => $targetDir,
	'allow_extensions' => 'txt',
	'file_name' => $fileName
);

if (!PluploadHandler::handle($configArray)) {

	die(json_encode(array(
		'OK' => 0, 
		'error' => array(
			'code' => PluploadHandler::get_error_code(),
			'message' => PluploadHandler::get_error_message()
		)
	)));
} else {

	// system calls to execute c program for batch processing
	$commandToExecute = C_EXECUTABLE_NAME . " ". "'" . realpath($targetDir) . "/" .$fileName . "'" . " ". "'" . $emailId . "'";
	//echo $commandToExecute;
	//exit();

	system($commandToExecute);

}
