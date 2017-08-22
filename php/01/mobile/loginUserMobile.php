<?php

ini_set('display_errors', '0');     
error_reporting(E_ALL | E_STRICT);  

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$us   = $_POST['username'];
$ps   = $_POST['passwordL'];
$UUID   = $_POST['UUID'];
$tD   = $_POST['tD'];
$device_token   = $_POST['device_token'];

$respuesta = array();

$arg = "username=$us&passwordL=$ps";
$res = $f->getCombo(0,$arg,0,0,4);

$respuesta = $res;
// $respuesta[0]->msg = "OK";

if (count($res)>0){

	$respuesta[0]->msg = "OK";

	try{

		$dato = explode("|", $respuesta[0]->data );

		$iduser 		   = intval($dato[0]);
		$idusernivelacceso = intval($dato[3]);
		$clave 			   = intval($dato[5]);

		$arg = "user=$us&UUID=$UUID&tD=$tD&device_token=$device_token";
		
		if ( intval($tD) == 1 ){
			$respuesta[0]->msg = $F->saveDataPDO(56,$arg,0,0,0);
		}else{
			$respuesta[0]->msg = $F->saveDataPDO(56,$arg,0,0,4);
		}

		$respuesta[0]->estadisticas = $F->getEstadisticasNoLeidas($clave,$idusernivelacceso,$us,$iduser);
		
	} catch (Exception $e) {

		$respuesta[0]->msg = $e->getMessage();
	}
	
}else{
	// $respuesta[0]->msg = "Username o Password incorrectos.";
    $respuesta[0]  = array("msg" => "Username o Password incorrectos.");
}

$m = json_encode($respuesta);
echo $m;

?>
