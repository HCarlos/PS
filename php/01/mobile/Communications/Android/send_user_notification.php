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


require_once("oCommunications_Android.php");
$C = oCommunications_Android::getInstance();


$user_sender     = $_POST['user_sender'];
$user    		 = $_POST['user'];
$mensaje 		 = $_POST['mensaje'];
$titulo  		 = isset($_POST['titulo']) ? $_POST['titulo'] : "Colegio Arjí A.C.";
$version_mobile  = isset($_POST['version_mobile']) ? $_POST['version_mobile'] : "";

$res = array();
$cad = "";
$rt = $F->getTokensMobileString($user);
$res[0] = new StdClass();
$res[0]->response = $rt;

if ($rt != ""){

	$str0 = explode(',', $rt);
	for ($i=0 ; $i<count($str0) ; ++$i) {
		try{
			$str1 = explode('|DevCH|', $str0[$i]);
			$iddevice     = intval($str1[0]);
			if ($iddevice > 0){
				$device_token = $str1[1];
				$type 		  = intval($str1[2]);

				$cad = $C->sendNotification_Android($device_token,$mensaje,$type,$titulo);
				$cad2 = "user=$user&iddevice=".$iddevice."&titulo=$titulo&mensaje=$mensaje&from_module=PlatSource&respuesta_envio=".$cad."&version_mobile=".$version_mobile."&user_sender=".$user_sender;
				$r = $F->saveDataPDO(56,$cad2,0,0,3);
			}

		}
		catch(Exception $e){
			// show_exception($e->getMessage());
		}	
	}
	
	$res[0]->msg = "OK";
	
}else{
	$res = array("msg" => "Error => (".$rt.")");
}

$m = json_encode($res);
echo $m;

?>
