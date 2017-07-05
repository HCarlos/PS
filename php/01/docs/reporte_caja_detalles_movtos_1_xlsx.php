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

$data = $_POST['c'];

if (!isset($data)){
	header('Location: http://platsource.mx/');
}

parse_str($data);

set_include_path(get_include_path() . PATH_SEPARATOR . '../PHPExcel/Classes/');
set_time_limit(600);
require_once("../PHPExcel/Classes/PHPExcel.php");
require_once("../PHPExcel/Classes/PHPExcel/Reader/Excel2007.php");
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(false);
$objPHPExcel = $objReader->load("templates/_fmt_reporte_caja_movtos_".$IdEmp.".xlsx"); //cargamos el archivo excel (extensión *.xlsx)
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
$objWriter->setIncludeCharts(TRUE);

$oS = $objPHPExcel->getActiveSheet();

$oS->setCellValue("H1", " ".Date('d-m-Y h:m:s') );
$oS->setCellValue("H3", " DESDE ".$fi." HASTA ".$ff );

require('../oCentura.php');
$f = oCentura::getInstance();

require('../oPHPExcel.php');
$E = oPHPExcel::getInstance();

$k=7;

$result = $f->getQuerys(10016,$data,0,0,0,array(),"",1);


foreach ($result as $i => $value) {
	
		$descto = $result[$i]->descto_becas + $result[$i]->descto;

		$arrAlu = $f->getQuerys(10025,"u=".$user."&idfamilia=".$result[$i]->idfamilia."&idalumno=".$result[$i]->idalumno,0,0,0,array(),"",1);

		$oS->setCellValue("A".$k, $result[$i]->idedocta);
		$oS->setCellValue("B".$k, $result[$i]->concepto);
		$oS->setCellValue("C".$k, $result[$i]->idfamilia);
		$oS->setCellValue("D".$k, $result[$i]->familia);
		$oS->setCellValue("E".$k, $arrAlu[0]->idalumno );
		$oS->setCellValue("F".$k, $arrAlu[0]->apellidos_alumno );
		$oS->setCellValue("G".$k, $arrAlu[0]->nombres_alumno );
		$oS->setCellValue("H".$k, $arrAlu[0]->grupo );
		$oS->setCellValue("I".$k, $result[$i]->fecha_de_pago);
		$oS->setCellValue("J".$k, $result[$i]->subtotal);
		$oS->setCellValue("K".$k, $result[$i]->descto);
		$oS->setCellValue("L".$k, $result[$i]->importe);
		$oS->setCellValue("M".$k, $result[$i]->recargo);
		$oS->setCellValue("N".$k, $result[$i]->total);

	++$k;

}

$fileout= "reporte-caja_movtos-".$IdEmp.".xlsx";
$objWriter->save($fileout); 

echo "Archivo generado con &eacute;xito, para abrir haga click <a href='http://platsource.mx/php/01/docs/".$fileout."'>aqu&iacute;</a>"  

?>


</body>
</html>


