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

$tanToDecrypt = "dHDhS024hPzH/T8GxZiWFZoVDNVVJWCj/nfi7rBeNxBKQf904WD5zSEV4KppYKCzpC4mldvM9THJB2gwlw==";

echo "====>".AccountUtils::checkTANValidity($emailToUpdate, $tanToDecrypt);

