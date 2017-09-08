<?php

/*
ini_set('display_errors', '0');     
error_reporting(E_ALL | E_STRICT);  

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

date_default_timezone_set('America/Mexico_City');
*/

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../../../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

require_once("oCommunications_Android.php");
$C = oCommunications_Android::getInstance();

$user   = $_POST['user'];
$mensaje   = $_POST['mensaje'];
if ( isset($_POST['titulo']) ){
	$titulo = $_POST['titulo'];	
}else{
	$titulo = "Colegio Arjí A.C.";	
}


$res = array();

$cad = "";
$rt = $F->getQueryPDO(33,"user=$user");
$res = $rt;
foreach ($rt as $i => $value) {
	$cad = $C->sendNotification_Android($rt[$i]->device_token,$mensaje,$rt[$i]->type,$titulo);
	$cad2 = "user=$user&iddevice=".$rt[$i]->iddevice."&titulo=$titulo&mensaje=$mensaje&from_module=Usuarios";
	$F->saveDataPDO(56,$cad2,0,0,3);
}

$res[0]->msg = "OK";
$m = json_encode($res);
echo $m;

?>
