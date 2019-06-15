<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Reporte de Calificaciones en Español - secundaria Arjí</title>
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
$objPHPExcel = $objReader->load("templates/_fmt_rep_secundaria_ing_arji_1.xlsx"); //cargamos el archivo excel (extensión *.xlsx)
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

//echo $strgrualu;

$arrAlu = explode(",",$strgrualu);

$k=6;

$miCal = 4;

// LISTADO DE CALIFICACIONES

//echo "t=".$t."&idgrualu=".$arrAlu[0];
$rst = $f->getQuerys($t,"idgrualu=".$arrAlu[0],0,0,0,array(),$s,1);
$idgrupo = $rst[0]->idgrupo;
$grupo = $rst[0]->grupo;
$clave = $rst[0]->clave_grupo;

$fl=$miCal;
$arrIdGruMat = array();
//echo "idgrupo=".$idgrupo."&idciclo=".$idciclo;
$mats = $f->getCombo(1,"idgrupo=".$idgrupo."&idciclo=".$idciclo,0,0,24,' and padre > 0 and (idmatclas in (1,2,3,4,5) ) and orden_historial <= 100 order by orden_historial asc '); 
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


	if ( count($result)>0  ){

		$oS->setCellValue("A".$k, $result[0]->num_lista);
		$oS->setCellValue("B".$k, $result[0]->alumno);
		$E->cellColor($objPHPExcel, "A".$k.':'."B".$k, 'CCF4CC');

		// $E->cellColor($objPHPExcel, "A".$k.':'."Z".$k, '99FF66');

		for ($w=1; $w<6; ++$w){

			$oS->setCellValue("C".$k, $w);

			// Obtenemos el Promedio del Alumno
			$fl=3;
			$maxmat = count($arrIdGruMat)-1;
			for($yy=$maxmat;$yy>=0;--$yy){
				$mimat = $f->getQuerys(121,"idgrualu=".$arrAlu[$i]."&numval=".$w."&idgrumat=".$arrIdGruMat[$yy],0,0,0,array(),' and padre > 0 and (idmatclas in (1,2,3,4,5) ) and orden_historial <= 100 order by orden_historial asc ');
				if (count($mimat)>0){
					break;
				};
			};
			
			if ( count($mimat) > 0 ){
				$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=".$w."&idgrumat=".$mimat[0]->padre,0,0,0,array(),' and padre >= 0 ');
								   // echo "idgrualu=".$arrAlu[$i]."&numval=".$w."&idgrumat=".$mimat[0]->padre.'\n\t';
				// echo count($mat);
				if ( count($mat) ){
					if ( intval($mat[0]->con) > 0 ){
						$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,2);
						// echo $cal;
						$oS->setCellValueByColumnAndRow($fl,$k, $cal);
					}
				}
			}

			// Obtenemos las Calificaciones por Num Eval
			$fl=$miCal; 
			for ($l=0;$l<count($arrIdGruMat); ++$l){
				$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=".$w."&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' and padre > 0 and (idmatclas in (1,2,3,4,5) ) and orden_historial <= 100 order by orden_historial asc ');
				if ( count($mat)>0 ){
					$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,2);
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

		$oS->setCellValue("C".$k, "PROM");
 
		$fl=3;

		if (count($mimat)){

			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=9&idgrumat=".$mimat[0]->padre,0,0,0,array(),'  ');
			if (count($mat)>0){
				// $cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,2);
				// $cal =  $A->FormatCal( bcdiv($mat[0]->cal,'1',1),$mat[0]->con,$mat[0]->ina,4);
				$cal =  $A->FormatCal( $mat[0]->cal,$mat[0]->con,$mat[0]->ina,2);
				$oS->setCellValueByColumnAndRow($fl,$k, $cal);
			}
		}

		$fl=$miCal;
		for ($l=0;$l<count($arrIdGruMat); ++$l){
			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=9&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' and padre > 0 and (idmatclas in (1,2,3,4,5) ) and orden_historial <= 100 order by orden_historial asc ');
			if ( count($mat)>0 ){
				// $cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina);
				// $cal =  $A->FormatCal( bcdiv($mat[0]->cal,'1',1),$mat[0]->con,$mat[0]->ina,4);
				$cal =  $A->FormatCal( $mat[0]->cal,$mat[0]->con,$mat[0]->ina,2);
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
		
		//$mat = $f->getQuerys(57,"idgrualu=".$arrAlu[$i]."&numval=10",0,0,0,array(),'  ');
		if (count($mimat)){
			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=10&idgrumat=".$mimat[0]->padre,0,0,0,array(),'  ');
			if (count($mat)>0){
				$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,2);
				$oS->setCellValueByColumnAndRow($fl,$k, $cal);
			}
		}

		$fl=$miCal;
		for ($l=0;$l<count($arrIdGruMat); ++$l){
			$mat = $f->getQuerys(56,"idgrualu=".$arrAlu[$i]."&numval=10&idgrumat=".$arrIdGruMat[$l],0,0,0,array(),' and padre > 0 and (idmatclas in (1,2,3,4,5) ) and orden_historial <= 100 order by orden_historial asc ');
			if ( count($mat)>0 ){
				$cal =  $A->FormatCal($mat[0]->cal,$mat[0]->con,$mat[0]->ina,2);
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
$fileout= "reporte-calif-secundaria-ing-arji-".$ti.".xlsx";
$objWriter->save($fileout);//guardamos el archivo excel  

echo "Archivo generado con &eacute;xito, para abrir haga click <a href='http://platsource.mx/php/01/docs/".$fileout."'>aqu&iacute;</a>"  

?>


</body>
</html>


