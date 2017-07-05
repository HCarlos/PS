<?php



ini_set('display_errors', '0');     
error_reporting(E_ALL | E_STRICT);  

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);




date_default_timezone_set('America/Mexico_City');

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../../../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

require_once("oCommunications.php");
$C = oCommunications::getInstance();

$user   = $_POST['user'];
$mensaje   = $_POST['mensaje'];

$res = array();

$cad = "user=$user";
$rt = $F->getQueryPDO(33,$cad,1);

foreach ($rt as $i => $value) {

	$C->sendNotification_iOS($rt[$i]->device_token,$mensaje);

	$cad = "user=$user&iddevice=".$rt[$i]->iddevice."&titulo=$mensaje&mensaje=$mensaje&from_module=Usuarios";
	$F->saveDataPDO(56,$cad,0,0,3);
	
}


// $C->sendNotification_iOS('e98ddcd1db96004a0b1566708177181a9840fd15d4baa18b166390bd5cf53a65',$mensaje);


$res[0]->msg = "OK";
$m = json_encode($res);
echo $m;

?>
