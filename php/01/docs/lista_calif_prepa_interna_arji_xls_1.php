<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Reporte de Calificaciones en Español - Prepa Arjí</title>
<link rel="stylesheet" type="text/css" href="../../../css/01/class_gen.css"/>
</head>

<body>

<?php

ini_set('default_socket_timeout', 100000);
date_default_timezone_set('America/Mexico_City');
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

$o = $_POST['o'];
$c = $_POST['c'];
$t = $_POST['t'];
$from = $_POST['from'];
$cantidad = $_POST['cantidad'];
$s = $_POST['s'];

if (!isset($c)){
	header('Location: https://platsource.mx/');
}

/* MS Excel */
set_include_path(get_include_path() . PATH_SEPARATOR . '../PHPExcel/Classes/');
set_time_limit(100000);
require_once("../PHPExcel/Classes/PHPExcel.php");
$objPHPExcel = new PHPExcel();
// require_once("../PHPExcel/Classes/PHPExcel/Reader/Excel2007.php");
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
// $objReader->setReadDataOnly(false);
$objPHPExcel = $objReader->load("templates/_fmt_rep_prepa_arji_1.xlsx"); //cargamos el archivo excel (extensión *.xlsx)
// $objPHPExcel = $objReader->load("templates/_fmt_rep_prepa_arji_1.xlsx"); //cargamos el archivo excel (extensión *.xlsx)
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

// LISTADO DE CALIFICACIONES

$intro = true;
$lk = 0;

// echo $t;
while ( $intro ){

	$rst = $f->getQuerys($t,"idgrualu=".$arrAlu[$lk],0,0,0,array(),$s,1);
	if ( (count($rst) > 0) ){
		$intro = false;
	}
	if ( $lk <= (count($rst)-1) ){
		$intro = false;
	}
	++$lk;
}

if ( $intro ){
	print "No hay datos.";
	return;
}

$idciclo = $idciclo;
$idgrupo = $rst[0]->idgrupo;
$grupo = $rst[0]->grupo;
$clave = $rst[0]->clave_grupo;

$fl=4;
$arrIdGruMat = array();

// echo "idgrupo=".$idgrupo."&idciclo=".$idciclo;

$mats = $f->getCombo(1,"idgrupo=".$idgrupo."&idciclo=".$idciclo,0,0,24,' order by orden_historial asc '); 
if ( count($mats) > 0 ) {
	foreach ($mats as $i => $value) {
		// echo $mats[$i]->label.' = '.$mats[$i]->data.';   ';
		// echo eval( $mats[$i]->data );
		$oS->setCellValueByColumnAndRow($fl,$k, $mats[$i]->label);
		$arrIdGruMat[$i] = $mats[$i]->data;
		++$fl;
	}
}

$E->cellColor($objPHPExcel, "A".$k.':'."Z".$k, '99FF66');

$oS->setCellValue("S3", $grupo);

$k=7;

// echo $k;



foreach ($arrAlu as $i => $value) {

	//echo "idgrualu=".$arrAlu[$i];
	$result = $f->getQuerys($t,"idgrualu=".$arrAlu[$i],0,0,0,array(),$s,1);

	if ( count($result)>0  ){

		$oS->setCellValue("A".$k, $result[0]->num_lista);
		$oS->setCellValue("B".$k, $result[0]->alumno);
		$E->cellColor($objPHPExcel, "A".$k.':'."B".$k, 'CCF4CC');



		for ($w=1; $w<4; ++$w){

			$oS->setCellValue("C".$k, $w);

			// Obtenemos el Promedio del Alumno
			$fl=3;
			$mat = $f->getQuerys(57,"idgrualu=".$arrAlu[$i]."&numval=".$w,0,0,0,array(),'  ');
			$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3);
			$oS->setCellValueByColumnAndRow($fl,$k, $cal);

			// Obtenemos las Calificaciones por Num Eval
			$callStartTime = microtime(true);

			$fl=4;
			for ($l=0;$l<count($arrIdGruMat); ++$l){
				$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=".$w."&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' order by orden_historial asc ');
				if ( count($mat)>0 ){
					$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3);
					$oS->setCellValueByColumnAndRow($fl,$k, $cal);
					++$fl;
				}else{
					$cal =  '';
					$oS->setCellValueByColumnAndRow($fl,$k, $cal);
					++$fl;
				}
				// echo "idgrualu=".$arrAlu[$i]." numval=".$w." "." idgrumat=".$arrIdGruMat[$l].", \n", EOL;
			}
			
			$callEndTime = microtime(true);
			$callTime = $callEndTime - $callStartTime;
			// echo "idgrualu=".$arrAlu[$i]." numval=".$w, sprintf(' %.4f',$callTime) , " seconds" , EOL;

			++$k;

		}
		

		// Obtenemos el Promedio del alumno

		$oS->setCellValue("C".$k, "PARC");
 
		$fl=3;
		$mat = $f->getQuerys(57,"idgrualu=".$arrAlu[$i]."&numval=7",0,0,0,array(),'  ');

		$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3);
		$oS->setCellValueByColumnAndRow($fl,$k, $cal);


		$fl=4;
		for ($l=0;$l<count($arrIdGruMat); ++$l){
			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=7&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' order by orden_historial asc ');
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

		++$k;

		// Obtenemos el Promedio del alumno

		$oS->setCellValue("C".$k, "EX. ORD");
 
		$fl=3;
		$mat = $f->getQuerys(57,"idgrualu=".$arrAlu[$i]."&numval=4",0,0,0,array(),'  ');
		$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3);
		$oS->setCellValueByColumnAndRow($fl,$k, $cal);


		$fl=4;
		for ($l=0;$l<count($arrIdGruMat); ++$l){
			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=4&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' order by orden_historial asc ');
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

		++$k;


		// Obtenemos el Promedio del alumno

		$oS->setCellValue("C".$k, "FINAL");
 
		$fl=3;
		$mat = $f->getQuerys(57,"idgrualu=".$arrAlu[$i]."&numval=8",0,0,0,array(),'  ');
		$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3);
		$oS->setCellValueByColumnAndRow($fl,$k, $cal);


		$fl=4;
		for ($l=0;$l<count($arrIdGruMat); ++$l){
			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=8&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' order by orden_historial asc ');
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

		++$k;


		// Obtenemos el Promedio del Grupo

		$oS->setCellValue("C".$k, "GPO");
 
		$fl=3;
		$mat = $f->getQuerys(57,"idgrualu=".$arrAlu[$i]."&numval=10",0,0,0,array(),'  ');
		$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,3);
		$oS->setCellValueByColumnAndRow($fl,$k, $cal);
		// echo count($cal)."-gpo";

		$fl=4;
		for ($l=0;$l<count($arrIdGruMat); ++$l){
			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=10&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' order by orden_historial asc ');
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


		++$k;

		


	} // Fin de Enf IF

		++$k;

}

$ti=$clave."-".$idciclo;//  time();
$fileout= "reporte-calif-prepa-arji-".$ti.".xlsx";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
$objWriter->setIncludeCharts(FALSE);
$objWriter->save($fileout);//guardamos el archivo excel  

echo "Archivo generado con &eacute;xito, para abrir haga click <a href='https://platsource.mx/php/01/docs/".$fileout."'>aqu&iacute;</a>"  

?>


</body>
</html>


