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
$objPHPExcel = $objReader->load("templates/_fmt_rep_primaria_promedios_internos_arji_1.xlsx"); //cargamos el archivo excel (extensión *.xlsx)
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

$k=6;

$miCal = 4;

// LISTADO DE CALIFICACIONES

$rst = $f->getQuerys($t,"idgrualu=".$arrAlu[0],0,0,0,array(),$s,1);
$idciclo = $idciclo; //$rst[0]->idciclo;
$idgrupo = $rst[0]->idgrupo;
$grupo = $rst[0]->grupo;
$clave = $rst[0]->clave_grupo;

$fl=$miCal;
$arrIdGruMat = array();

$E->cellColor($objPHPExcel, "A".$k.':'."Z".$k, '99FF66');

$oS->setCellValue("H2", $grupo);

$k=7;

if ( intval($numeval) == 0 ){
	$numeval = 9;
}

foreach ($arrAlu as $i => $value) {
	$result = $f->getQuerys($t,"idgrualu=".$arrAlu[$i],0,0,0,array(),$s,1);

	if ( count($result)>0  ){

		$oS->setCellValue("A".$k, $result[0]->num_lista);
		$oS->setCellValue("B".$k, $result[0]->alumno);

		$w = $numeval;

		$oS->setCellValue("C".$k, $w);

		$p0 = 0;
		$p1 = 0;
		$p2 = 0;

		// Obtenemos el Promedio del Alumno en Español
		$fl=3;
		$mat = $f->getQuerys(58,"idgrualu=".$arrAlu[$i]."&numval=".$w,0,0,0,array(),' and idioma = 0 ');
		$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3);
		$p0 = floatval($mat[0]->cal);
		$oS->setCellValueByColumnAndRow($fl, $k, $cal);

		// Obtenemos el Promedio del Alumno en Inglés
		$fl=4;
		$mat = $f->getQuerys(58,"idgrualu=".$arrAlu[$i]."&numval=".$w,0,0,0,array(),' and idioma = 1 ');
		$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3);
		$p1 = floatval($mat[0]->cal);		
		$oS->setCellValueByColumnAndRow($fl, $k, $cal);


		// Pintamos el promedio general
		$p2 = round((($p0 + $p1) / 2),2) ;
		$fl=5;
		$oS->setCellValueByColumnAndRow($fl, $k, $p2);


		// Obtenemos las Calificaciones por Num Eval
		/*
		$fl=$miCal;
		for ($l=0;$l<count($arrIdGruMat); ++$l){
			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=".$w."&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' and idioma = 0 order by orden_historial asc ');
			if ( count($mat)>0 ){
				$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3);
				$oS->setCellValueByColumnAndRow($fl,$k, $cal);
				++$fl;
			}else{
				$cal =  '';
				$oS->setCellValueByColumnAndRow($fl,$k, $cal);
				++$fl;
			}
		}
		*/

		++$k;

	} // Fin de Enf IF

}

$ti=$clave."-".$idciclo;//  time();
$fileout= "reporte-calif-primaria-esp-arji-eval-".$numeval.'-'.$ti.".xlsx";
$objWriter->save($fileout);//guardamos el archivo excel  

echo "Archivo generado con &eacute;xito, para abrir haga click <a href='http://platsource.mx/php/01/docs/".$fileout."'>aqu&iacute;</a>"  

?>


</body>
</html>


