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
			$oS->setCellValue("P".$k, $rst[$i]->ap_paterno_tutor.', '.$rst[$i]->ap_materno_tutor.', '.$rst[$i]->nombre__tutor);
			$oS->setCellValue("Q".$k, $rst[$i]->idtutor);
			$oS->setCellValue("R".$k, $rst[$i]->username_tutor);
			$oS->setCellValue("S".$k, $rst[$i]->email_tutor1);
			$oS->setCellValue("T".$k, $rst[$i]->email_tutor2);
			$oS->setCellValue("U".$k, $rst[$i]->email_fiscal);
			$oS->setCellValue("V".$k, $rst[$i]->tel1_tutor);
			$oS->setCellValue("W".$k, $rst[$i]->tel2_tutor);
			$oS->setCellValue("X".$k, $rst[$i]->cel1_tutor);
			$oS->setCellValue("Y".$k, $rst[$i]->cel2_tutor);

			$tut = $f->getQuerys(20,$rst[$i]->idtutor);
			if ( isset($tut[0]) ){
				$oS->setCellValue("Z".$k, $tut[0]->domicilio_generico);
				$oS->setCellValue("AA".$k, $tut[0]->ocupacion);
				$oS->setCellValue("AB".$k, $tut[0]->lugar_trabajo);
				$oS->setCellValue("AC".$k, $tut[0]->cfecha_nacimiento);
			}else{
				$oS->setCellValue("Z".$k, '');
				$oS->setCellValue("AA".$k, '');
				$oS->setCellValue("AB".$k, '');
				$oS->setCellValue("AC".$k, '');
			}


			$arr = array('AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ');
			
			// $arr = array('AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ');

			$emer = $f->getQuerys(115,"u=".$u."&idalumno=".$rst[$i]->idalumno);

			$j=0;
			if ( count($emer) > 0 ){
				foreach ($emer as $m => $value) {
					$oS->setCellValue($arr[$j].$k, $emer[$m]->nombre);
					$oS->setCellValue($arr[$j+1].$k, $emer[$m]->parentezco);
					$oS->setCellValue($arr[$j+2].$k, $emer[$m]->tel1);
					$j=$j+3;
				}
			}else{
				$m = 0;
				$j=$j+3;
			}
			$ll = $m;

			$c = "u=".$u."&idfamilia=".$rst[$i]->idfamilia;

			$r = $f->getCombo(1,$c,0,0,10);

			// ++$j;

			foreach ($r as $ll => $value) {
				if ( count($r)>0  ){
					$oS->setCellValue($arr[$j].$k, $r[$ll]->parentezco);
					$oS->setCellValue($arr[$j+1].$k, $r[$ll]->data);
					$oS->setCellValue($arr[$j+2].$k, $r[$ll]->username_persona);		
					$oS->setCellValue($arr[$j+3].$k, $r[$ll]->ap_paterno.', '.$r[$ll]->ap_materno.', '.$r[$ll]->nombre);		
					// $oS->setCellValue($arr[$j+3].$k, $r[$ll]->label);		
					$oS->setCellValue($arr[$j+4].$k, $r[$ll]->email1);			
					$oS->setCellValue($arr[$j+5].$k, $r[$ll]->email2);
					$oS->setCellValue($arr[$j+6].$k, $r[$ll]->tel1);			
					$oS->setCellValue($arr[$j+7].$k, $r[$ll]->tel2);
					$oS->setCellValue($arr[$j+8].$k, $r[$ll]->cel1);			
					$oS->setCellValue($arr[$j+9].$k, $r[$ll]->cel2);
					$oS->setCellValue($arr[$j+10].$k, $r[$ll]->cfecha_nacimiento);

					$tut = $f->getQuerys(20,$r[$ll]->data);

					if ( count($tut) > 0 ){
						$oS->setCellValue($arr[$j+11].$k, $tut[0]->domicilio_generico);
						$oS->setCellValue($arr[$j+12].$k, $tut[0]->ocupacion);
						$oS->setCellValue($arr[$j+13].$k, $tut[0]->lugar_trabajo);
					}else{
						$oS->setCellValue($arr[$j+11].$k, '');
						$oS->setCellValue($arr[$j+12].$k, '');
						$oS->setCellValue($arr[$j+13].$k, '');
					}

					$j=$j+14;			
					
				}
			
			}

			// $m = $ll;

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


