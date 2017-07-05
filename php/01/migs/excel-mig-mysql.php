<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>SIBM | Centro 2013 - 2015</title>
	<link rel="stylesheet" type="text/css" href="../../css/01/class_gen.css"/>
</head>

<body>

	<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Mexico_City');
set_include_path(get_include_path() . PATH_SEPARATOR . 'PHPExcel/Classes/');
set_time_limit(600000);


require_once("../PHPExcel/Classes/PHPExcel.php");
require_once("../PHPExcel/Classes/PHPExcel/Reader/Excel2007.php");
require_once('../vo/voConn.php');
require_once("../oFunctions.php");

$F = oFunctions::getInstance();

$Conn = voConn::getInstance();
$mysql = mysql_connect($Conn->
	server, $Conn->user, $Conn->pass);
mysql_select_db($Conn->db);
mysql_query("SET NAMES UTF8");

$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp; 
$cacheSettings = array( ' memoryCacheSize ' => '64MB'); 
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings); 

$objReader = PHPExcel_IOFactory::createReader('Excel2007');

$objReader->setReadDataOnly(true);


$objPHPExcel = $objReader->load("../../../otros/fam.xlsx"); //cargamos el archivo excel (extensión *.xlsx)

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
$objWriter->setIncludeCharts(false);
$objWriter->setPreCalculateFormulas(false);

$sheet = $objPHPExcel->getActiveSheet();

$i=1;

while ($i <= 1150) {

	if ( trim($sheet->getCell("A".$i)) != '' ){

		$iduser    = (int)trim($sheet->getCell("A".$i)) ;

		if ( $iduser > 0 ) {
			$query = "UPDATE usuarios 
						SET 
							idusernivelacceso = 25 
						WHERE iduser = ".$iduser;
		}

		$result = mysql_query($query);

	}

	++$i;
}

mysql_close($mysql);

echo "Proceso terminado con éxito.";

?>
</body>
</html>
