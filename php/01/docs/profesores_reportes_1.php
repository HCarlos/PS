<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Reporte de Calificaciones en Español - Prepa Arjí</title>
<link rel="stylesheet" type="text/css" href="../../../css/01/class_gen.css"/>
</head>

<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('default_socket_timeout', 6000);

$o = $_POST['o'];
$c = $_POST['c'];
$t = $_POST['t'];
$from = $_POST['from'];
$cantidad = $_POST['cantidad'];
$s = $_POST['s'];

if (!isset($c)){
	header('Location: http://platsource.mx/');
}

parse_str($c);

set_include_path(get_include_path() . PATH_SEPARATOR . '../PHPExcel/Classes/');
set_time_limit(600);
require_once("../PHPExcel/Classes/PHPExcel.php");
require_once("../PHPExcel/Classes/PHPExcel/Reader/Excel2007.php");
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(false);
$objPHPExcel = $objReader->load("templates/_fmt_reportes_profesores_".$IdEmp.".xlsx"); //cargamos el archivo excel (extensión *.xlsx)
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
$objWriter->setIncludeCharts(TRUE);

$oS = $objPHPExcel->getActiveSheet();
$oS->setCellValue("E4", " ".Date('d-m-Y h:m:s') );

require('../oCentura.php');
$f = oCentura::getInstance();

require('../oPHPExcel.php');
$E = oPHPExcel::getInstance();

$k=7;

$arrProf = $f->getQuerys(119,"user=".$user,0,0,0,array(),"",1);


foreach ($arrProf as $i => $value) {
	$result = $f->getQuerys(120,"idprofesor=".$arrProf[$i]->idprofesor,0,0,0,array(),"",1);

	if ( count($result)>0  ){

		$oS->setCellValue("A".$k, $result[0]->idprofesor);
		$oS->setCellValue("B".$k, $result[0]->nombre_profesor);
		$oS->setCellValue("C".$k, $result[0]->email);
		$oS->setCellValue("D".$k, $result[0]->cel1);
		$oS->setCellValue("E".$k, $result[0]->cel2);
		$oS->setCellValue("F".$k, $result[0]->direccion);

	} 

	++$k;

}

$fileout= "reporte-profesores-".$IdEmp.".xlsx";
$objWriter->save($fileout); 

echo "Archivo generado con &eacute;xito, para abrir haga click <a href='http://platsource.mx/php/01/docs/".$fileout."'>aqu&iacute;</a>"  

?>


</body>
</html>


