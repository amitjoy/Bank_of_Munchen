<?php

require_once("../../classes/PluploadHandler.php");
require_once '../../includes/global.inc.php';
require_once '../../utils/Account.util.php';
require_once '../../utils/Generators.util.php';

$emailToUpdate = "admin@amitinside.com";

$tanNos = Generators::generateTANs ($emailToUpdate, 10);

  $tanEmailMessage = "";

  for ($i=0; $i < count($tanNos); $i++) { 
    $tanEmailMessage .= $i . ": " . $tanNos[$i] . "<br/>";
    $tanEmailMessage .= "<br/><hr>";
  }

echo $tanEmailMessage;

$tanToDecrypt = "dHDhS024hPzH/T8GxZiWFZoVDNVVJWCj/nfi7rBeNxBWzeDd0Dv9zYrCptJH37bvYvnZ2D+TqW2VAMjIiBRk3g==";

echo "====>".AccountUtils::checkTANValidity($emailToUpdate, $tanToDecrypt);

