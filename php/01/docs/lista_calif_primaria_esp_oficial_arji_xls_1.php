<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Reporte de Calificaciones en Español - Primaria Arjí</title>
<link rel="stylesheet" type="text/css" href="../../../css/01/class_gen.css"/>
</head>

<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('default_socket_timeout', 6000);
date_default_timezone_set('America/Mexico_City');

$o = $_POST['o'];
$c = $_POST['c'];
$t = $_POST['t'];
$from = $_POST['from'];
$cantidad = $_POST['cantidad'];
$s = $_POST['s'];

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
$objPHPExcel = $objReader->load("templates/_fmt_rep_primaria_esp_arji_1.xlsx"); //cargamos el archivo excel (extensión *.xlsx)
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
$objWriter->setIncludeCharts(TRUE);

$oS = $objPHPExcel->getActiveSheet();

/* FIN MS Excel */

parse_str($c);

require('../oCentura.php');
$f = oCentura::getInstance();

require('../oArji.php');
$A = oArji::getInstance();

require('../oPHPExcel.php');
$E = oPHPExcel::getInstance();

$arrAlu = explode(",",$strgrualu);

$miCal = 4;

$k=6;

// LISTADO DE CALIFICACIONES

$rst = $f->getQuerys($t,"idgrualu=".$arrAlu[0],0,0,0,array(),$s,1);
$idciclo = $idciclo; //$rst[0]->idciclo;
$idgrupo = $rst[0]->idgrupo;
$grupo = $rst[0]->grupo;
$clave = $rst[0]->clave_grupo;

$fl=$miCal;
$arrIdGruMat = array();

// echo $arrAlu[0];
// echo "idgrupo=".$idgrupo."&idciclo=".$idciclo;

$mats = $f->getCombo(1,"idgrupo=".$idgrupo."&idciclo=".$idciclo,0,0,24,' and idioma = 0 and isoficial = 1 order by orden_historial asc '); 
foreach ($mats as $i => $value) {
	$oS->setCellValueByColumnAndRow($fl,$k, $mats[$i]->label);
	$arrIdGruMat[$i] = $mats[$i]->data;

	++$fl;
}

$E->cellColor($objPHPExcel, "A".$k.':'."Z".$k, '99FF66');

$oS->setCellValue("S3", $grupo);

$k=7;

foreach ($arrAlu as $i => $value) {
	$result = $f->getQuerys($t,"idgrualu=".$arrAlu[$i],0,0,0,array(),$s,1);

	if ( count($result)>0 ){

		$oS->setCellValue("A".$k, $result[0]->num_lista);
		$oS->setCellValue("B".$k, $result[0]->alumno .' '.$arrAlu[$i].' '.$result[0]->idgrumat);
		// $oS->setCellValue("B".$k, $result[0]->alumno);
		$E->cellColor($objPHPExcel, "A".$k.':'."B".$k, 'CCF4CC');

		for ($w=1; $w<4; ++$w){

			$oS->setCellValue("C".$k, $w);

			// Obtenemos el Promedio del Alumno
			$fl=3;
			$mat = $f->getQuerys(113,"idgrualu=".$arrAlu[$i]."&numval=".$w,0,0,0,array(),'  and idioma = 0 ');
			//$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3,1);
			$cal =  $A->FormatCal($mat[0]->cal,0,0,3,1);
			
			$oS->setCellValueByColumnAndRow($fl,$k, $cal);

			// Obtenemos las Calificaciones por Num Eval
			$fl=$miCal;

			for ($l=0;$l<count($arrIdGruMat); ++$l){

				$mat = $f->getQuerys(93,"idgrualu=".$arrAlu[$i]."&numval=".$w."&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),'  and idioma = 0 and isoficial = 1  order by orden_historial asc ');
				if ( count($mat)>0 ){
					$cal =  $A->FormatCal($mat[0]->cal,0,0,3,1);
					// $cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3,1);
					$oS->setCellValueByColumnAndRow($fl,$k, $cal);
					++$fl;
				}else{
					$cal =  '';
					$oS->setCellValueByColumnAndRow($fl,$k, $cal);
					++$fl;
				}
			}

			++$k;

		}

		// Obtenemos el Promedio del alumno

		$os = array(1,2,3,4,5);

		$oS->setCellValue("C".$k, "PROM");
 
		$fl=3;
		// $mat = $f->getQuerys(93,"idgrualu=".$arrAlu[$i]."&numval=6",0,0,0,array(),' and idioma = 0 ');
		$mat = $f->getQuerys(71,"idgrualu=".$arrAlu[$i],0,0,0,array(),' ');
		// $cal =  bcdiv($mat[0]->promcalof,'1',1);
		$cal =  $mat[0]->promcalof;
		$oS->setCellValue("D".$k, $cal);

		$fl=$miCal;
		for ($l=0;$l<count($arrIdGruMat); ++$l){
			$mat = $f->getQuerys(93,"idgrualu=".$arrAlu[$i]."&numval=6&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' and idioma = 0 order by orden_historial asc ');
			if ( count($mat)>0 ){
				if ( in_array(intval($mat[0]->idmatclas) , $os) ){
					// $cal = $A->FormatCal($mat[0]->cal,0,0,4,1);
					$cal =  $mat[0]->cal;
					// $cal =  bcdiv($mat[0]->cal,'1',1);
					$oS->setCellValueByColumnAndRow($fl,$k, $cal);
				}else{
					$cal =  '';
					$oS->setCellValueByColumnAndRow($fl,$k, $cal);
				}
				++$fl;
			}else{
				$cal =  '';
				$oS->setCellValueByColumnAndRow($fl,$k, $cal);
				++$fl;
			}
		}

		++$k;


		// Obtenemos el Promedio del Grupo
/*
		$oS->setCellValue("C".$k, "GPO");
 
		$fl=3;
		$mat = $f->getQuerys(58,"idgrualu=".$arrAlu[$i]."&numval=10",0,0,0,array(),' and idioma = 0 ');
		$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3,1);
		// $cal =  $mat[0]->cal;
		$oS->setCellValueByColumnAndRow($fl,$k, $cal);


		$fl=$miCal;
		for ($l=0;$l<count($arrIdGruMat); ++$l){
			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=10&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' and idioma = 0 order by orden_historial asc ');
			if ( count($mat)>0 ){
				//$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3,1);
				//$oS->setCellValueByColumnAndRow($fl,$k, $cal);
				if ( in_array(intval($mat[0]->idmatclas) , $os) ){
					$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3,1);
					$oS->setCellValueByColumnAndRow($fl,$k, $cal);
				}else{
					$cal =  '';
					$oS->setCellValueByColumnAndRow($fl,$k, $cal);
				}
				++$fl;
			}else{
				$cal =  '';
				$oS->setCellValueByColumnAndRow($fl,$k, $cal);
				++$fl;
			}
		}

		++$k;
*/


	} // Fin de Enf IF

		++$k;

}

$ti=$clave."-".$idciclo;//  time();
$fileout= "reporte-calif-primaria-esp-arji-".$ti.".xlsx";
$objWriter->save($fileout);//guardamos el archivo excel  

echo "Archivo generado con &eacute;xito, para abrir haga click <a href='http://platsource.mx/php/01/docs/".$fileout."'>aqu&iacute;</a>"  

?>


</body>
</html>


