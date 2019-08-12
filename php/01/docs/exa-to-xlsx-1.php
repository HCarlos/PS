<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Listado de ExAlumnos</title>
<link rel="stylesheet" type="text/css" href="../../../css/01/class_gen.css"/>
</head>

<body>

<?php


$o = $_POST['o'];
$c = $_POST['c'];
$t = $_POST['t'];
$from = $_POST['from'];
$cantidad = $_POST['cantidad'];
$s = $_POST['s'];

ini_set('default_socket_timeout', 6000);


if (!isset($c)){
	header('Location: http://platsource.mx/');
}

// header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");

set_include_path(get_include_path() . PATH_SEPARATOR . '../PHPExcel/Classes/');
set_time_limit(600);
require_once("../PHPExcel/Classes/PHPExcel.php");
require_once("../PHPExcel/Classes/PHPExcel/Reader/Excel2007.php");
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(false);

//cargamos el archivo excel (extensión *.xlsx)
$objPHPExcel = $objReader->load("templates/_fmt_exa_1.xlsx"); 

//objeto de PHPExcel, para escribir en el excel
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 

$objWriter->setIncludeCharts(TRUE);

$oS = $objPHPExcel->getActiveSheet();

parse_str($c);

require('../oCenturaPDO.php');
$fp = oCenturaPDO::getInstance();

require('../oPHPExcel.php');
$E = oPHPExcel::getInstance();

// $oS->setCellValue("E2", $grupo);

$k=5;

$arrExa = explode(',',$iddestinatarios);

foreach ($arrExa as $g => $value) {

	$c = "u=".$user."&idexalumno=".$arrExa[$g];

	$rst = $fp->getQueryPDO(66,$c,0,0,0,array(),"",$withPag=1);

	foreach ($rst as $i => $value) {

		if ( count($rst)>0  ){

			$oS->setCellValue("A".$k, $rst[$i]->idexalumno);
			$oS->setCellValue("B".$k, $rst[$i]->ap_paterno);
			$oS->setCellValue("C".$k, $rst[$i]->ap_materno);
			$oS->setCellValue("D".$k, $rst[$i]->nombre);
			$oS->setCellValue("E".$k, $rst[$i]->generacion);
			$oS->setCellValue("F".$k, $rst[$i]->username);
			$oS->setCellValue("G".$k, $rst[$i]->fecha_nacimiento);
			$oS->setCellValue("H".$k, $rst[$i]->generoc);
			$oS->setCellValue("I".$k, $rst[$i]->email);
			$oS->setCellValue("J".$k, $rst[$i]->telefono);
			$oS->setCellValue("K".$k, $rst[$i]->extension);
			$oS->setCellValue("L".$k, $rst[$i]->celular);
			$oS->setCellValue("M".$k, $rst[$i]->direccion);
			$oS->setCellValue("N".$k, $rst[$i]->profesion);
			$oS->setCellValue("O".$k, $rst[$i]->ocupacion);
			$oS->setCellValue("P".$k, $rst[$i]->isfamc);
			$oS->setCellValue("Q".$k, $rst[$i]->num_hijos);
			$oS->setCellValue("R".$k, $rst[$i]->facebook);
			$oS->setCellValue("S".$k, $rst[$i]->twitter);
			$oS->setCellValue("T".$k, $rst[$i]->instagram);

			++$k;

		} // Fin de End IF

	} // $rst 

} // $arrExa
$fileout= "listado-de-exalumno.xlsx";
$objWriter->save($fileout); //guardamos el archivo excel  

echo "Archivo de exalumnos generado con &eacute;xito, para abrir haga click <a href='http://platsource.mx/php/01/docs/".$fileout."'>aqu&iacute;</a>"  



?>


</body>
</html>


