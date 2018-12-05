<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Listado de Alumnos</title>
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

// echo $t;
// echo $c;

// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);
ini_set('default_socket_timeout', 6000);

if (!isset($c)){
	header('Location: http://platsource.mx/');
}

/* MS Excel */
set_include_path(get_include_path() . PATH_SEPARATOR . '../PHPExcel/Classes/');
set_time_limit(600);
require_once("../PHPExcel/Classes/PHPExcel.php");
require_once("../PHPExcel/Classes/PHPExcel/Reader/Excel2007.php");
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(false);
$objPHPExcel = $objReader->load("templates/_fmt_lista_alumnos_0.xlsx"); //cargamos el archivo excel (extensión *.xlsx)
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
$objWriter->setIncludeCharts(TRUE);

$oS = $objPHPExcel->getActiveSheet();

/* FIN MS Excel */

parse_str($c);

// echo $c;

require('../oCentura.php');
$f = oCentura::getInstance();

require('../oArji.php');
$A = oArji::getInstance();

require('../oPHPExcel.php');
$E = oPHPExcel::getInstance();

$oS->setCellValue("E2", $grupo);

$k=7;

$arrAlu = explode('-',$idgrupos);

foreach ($arrAlu as $g => $value) {

	$c = "u=".$u."&idgrupo=".$arrAlu[$g]."&grupo=".$grupo."&idciclo=".$idciclo;

	// echo $o;
	// echo $t;

	$rst = $f->getCombo($o,$c,0,0,$t);

	foreach ($rst as $i => $value) {

		if ( count($rst)>0  ){

			$oS->setCellValue("A".$k, $rst[$i]->grupo);
			$oS->setCellValue("B".$k, $rst[$i]->num_lista);
			$oS->setCellValue("C".$k, $rst[$i]->ap_paterno);
			$oS->setCellValue("D".$k, $rst[$i]->ap_materno);
			$oS->setCellValue("E".$k, $rst[$i]->nombre);

			$oS->setCellValue("F".$k, $rst[$i]->curp);

			$oS->setCellValue("G".$k, $rst[$i]->idalumno);
			$oS->setCellValue("H".$k, $rst[$i]->usernamealumno);

			$a = $f->getQuerys(10,$rst[$i]->idalumno);

			$oS->setCellValue("I".$k, $a[0]->cfecha_nacimiento);
			$oS->setCellValue("J".$k, $a[0]->genero==0?"FEMENINO":"MASCULINO");
			$oS->setCellValue("K".$k, $a[0]->matricula_interna);
			$oS->setCellValue("L".$k, $a[0]->matricula_oficial);

			$fm = $f->getQuerys(60,"u=".$u."&idfamilia=".$rst[$i]->idfamilia."&idalumno=".$rst[$i]->idalumno);
			$oS->setCellValue("M".$k, $fm[0]->vivecon);
			
			$oS->setCellValue("N".$k, $rst[$i]->familia);
			$oS->setCellValue("O".$k, $rst[$i]->idfamilia);
			$oS->setCellValue("P".$k, $rst[$i]->nombre_tutor);
			$oS->setCellValue("Q".$k, $rst[$i]->idtutor);
			$oS->setCellValue("R".$k, $rst[$i]->username_tutor);

			$oS->setCellValue("S".$k, $rst[$i]->cfecha_baja);
			$oS->setCellValue("T".$k, $rst[$i]->ctipo_baja);
			$oS->setCellValue("U".$k, $rst[$i]->motivo_baja);


			++$k;

		} // Fin de Enf IF

	} // $rst 

} // $arrAlu

if ( count($arrAlu) > 1 ){
	$nameFile = "NIVEL";
}else{
	$nameFile = $arrAlu[0];
}

$fileout= "listado-de-alumno-".$nameFile.".xlsx";
$objWriter->save($fileout); //guardamos el archivo excel  

echo "Archivo generado con &eacute;xito, para abrir haga click <a href='http://platsource.mx/php/01/docs/".$fileout."'>aqu&iacute;</a>"  

?>


</body>
</html>


