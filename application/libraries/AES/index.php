<?php
require_once('padCrypt.php');
require_once('AES_Encryption.php');
 
$key 	          = "bossupsolution@9";
$iv               = "bossupsolution@9";
$message          = "+boNYG67yFYOpcTnvBPkHA==";

$AES              = new AES_Encryption($key, $iv);
$encode  		  = base64_decode($message);
$decrypted        = $AES->decrypt($encode);

?>