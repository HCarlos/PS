<?php

// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

// date_default_timezone_set('America/Mexico_City');


header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");


if (isset($_POST["s_transm"])){
	$codigo = $_POST["codigo"];
	$mensaje = $_POST["mensaje"];
	$n_autoriz = $_POST["autorizacion"];
	$referencia = $_POST["referencia"];
	$importe   = $_POST["t_importe"];
	$mediopago = $_POST["mediopago"];
	$financiado = $_POST["financiado"];
	$plazos = $_POST["plazos"];
	$id        = $_POST["s_transm"];
	$hash = $_POST["hash"];
	$tarjetahabiente = $_POST["tarjetahabiente"];
	$cveTipoPago = $_POST["cveTipoPago"];


	$fecha     = NOW(); // $_POST["val_10"];
	$IdUser     = isset($_POST["IdUser"]) ? $_POST["IdUser"] : 0;

	require_once("../oCenturaPDO.php");
	$f = oCenturaPDO::getInstance();
	$f->setPagos($id,$importe,$n_autoriz,$IdUser);
}else{
	echo "Ocurrió un error al entregar el Control...";
	return false;
}

$dt = $f->getComboPDO(2,$id);

$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'To: Celia <caja@arji.edu.mx>' . "\r\n";
$cabeceras .= utf8_decode('From: Caja en línea Arjí <devch@arji.edu.mx>') . "\r\n";
$cabeceras .= 'Cc: rived67@hotmail.com' . "\r\n";
$cabeceras .= 'Bcc: manager@tabascoweb.com' . "\r\n";
$titulo = utf8_decode("Colegio Arji: Pago Realizado");

$cuerpo = "<p>";
$cuerpo .= "Se realizó el pago vía <a href='https://www.facebook.com/PlatSource-389634781187356/timeline/' target='_blank'>PlatSource.mx</a> ". "</br></br>";
$cuerpo .= "Folio:";
$cuerpo .= "<strong>".$id . "</strong></br>";
$cuerpo .= "Usuario: ";
$cuerpo .= "<strong>".$IdUser . "</strong></br>";
$cuerpo .= "Realizado el día: ";
$cuerpo .= "<strong>".$fecha . "</strong></br>";
$cuerpo .= "Con un importe de: ";
$cuerpo .= "<strong>".$importe . "</strong></br>";
$cuerpo .= "Folio de autorización: ";
$cuerpo .= "<strong>".$n_autoriz . "</strong></br>";
$cuerpo .= "Familia: ";
$cuerpo .= "<strong>".$dt[0]->idfamilia . '  ' . $dt[0]->familia . "</strong></br>";
$cuerpo .= "Tutor: ";
$cuerpo .= "<strong>".$dt[0]->idusertutor .'  '.$dt[0]->username_tutor.'  '.$dt[0]->tutor . "</strong></br>";
$cuerpo .= "Alumno: ";
$cuerpo .= "<strong>".$dt[0]->idalumno . '  ' . $dt[0]->nombre_completo_alumno . "</strong></br>";
$cuerpo .= "Nivel: ";
$cuerpo .= "<strong>".$dt[0]->nivel . "</strong></br>";
$cuerpo .= "Emisor Fiscal: ";
$cuerpo .= "<strong>".$dt[0]->razon_social . "</strong></br>";
$cuerpo .= "Concepto: ";
$cuerpo .= "<strong>".$dt[0]->concepto . '  ' .$dt[0]->mes. "</strong></br>";
$cuerpo .= "</p>";


mail("caja@arji.edu.mx",$titulo,$cuerpo,$cabeceras);

echo utf8_decode("Su pago se ha efectuado con éxito...");

?>

