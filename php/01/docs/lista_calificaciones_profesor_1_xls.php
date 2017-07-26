<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Listado de Calificaciones Detalle en MS Excel</title>
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

if (!isset($c)){
	header('Location: http://platsource.mx/');
}

parse_str($c);

ini_set('default_socket_timeout', 6000);
date_default_timezone_set('America/Mexico_City');

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
$objPHPExcel = $objReader->load("templates/_fmt_lista_calif_detalle_1.xlsx"); //cargamos el archivo excel (extensión *.xlsx)
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
$objWriter->setIncludeCharts(TRUE);

$oS = $objPHPExcel->getActiveSheet();
$L = 8; // Linea

require('../oCentura.php');
$f = oCentura::getInstance();

require_once("../oCenturaPDO.php");
$fp = oCenturaPDO::getInstance();


$arr = array();

$nc = "u=".$u."&idgrumat=".$idgrumat."&numval=".$eval;
$MC = $f->getQuerys(38,$nc,0,0,0,array()," order by idgrumatcon asc ",1);

foreach ($MC as $i => $value) {

	$nc = "u=".$u."&idgrumatcon=".$MC[$i]->idgrumatcon;
	$MCP = $f->getQuerys(104,$nc,0,0,0,array()," order by idgrumatconmkb asc ",1);
	$sepa = count($MCP);
	
	$arr[$i] = array("idgrumatcon" => $MC[$i]->idgrumatcon,"idgrumatconmkb" => $MCP, "separador" => $sepa);

}	

$strAlph = "ABCDEFGHIJKLMNOPQRZUVWXYZ";
$arrAplh = str_split($strAlph);

foreach ($MC as $i => $value) {

	$oS->setCellValue($arrAplh[$i].$L, $MC[$i]->descripcion.' ( '.intval($MC[$i]->porcentaje).'% )');

}

++$L;
$c = 0;
foreach ($MC as $i => $value) {

	$sepa2 = $arr[$i]['separador'];
	$MCP = $arr[$i]['idgrumatconmkb'];//$arr[$i]->idgrumatconmkb;

	$oS->mergeCells($arrAplh[$c].($L-1).':'.$arrAplh[$c+count($MCP)].($L-1));

	foreach ($MCP as $j => $value) {

		// $pdf->Cell($sepa2,$pdf->nFont,substr(utf8_decode($MCP[$j]->descripcion_breve),0,10),'LBT',0,'C');
		$oS->setCellValue($arrAplh[$c].$L, $MCP[$j]->descripcion_breve);
		++$c;

	}	


	$saltoI = ( $i==(count($MC)-1) ) ? 1:0;
	$lx = ( $i==(count($MC)-1) ) ? 'LBTR':'LBT';
	
	$arr[$i] = array("idgrumatcon" => $MC[$i]->idgrumatcon,"idgrumatconmkb" => $MCP, "separador" => $sepa2);


}


/*

$pdf = new PDF_Diag($hHoja,'mm','Letter');
$pdf->AliasNbPages();
$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);
$pdf->materia = $materia;
$pdf->grupo = $grupo;
$pdf->profesor = $profesor;
$pdf->eval = $eval;
$pdf->phead = ""; //$head;
$pdf->logoEmp = $logoEmp;
$pdf->lastWidht=0;
$pdf->promcal = 0;
$pdf->promcon = 0;
$pdf->sumina = 0;
$pdf->numregs = 0;


$pdf->AddPage();


// PINTAMOS 1RA LINEA

$pdf->setX(5);

$pdf->SetFont('Arial','B',8);

$pdf->Cell(05,12,'#','LT',0,'C');
$pdf->Cell(80,12,'N O M B R E   D E L   A L U M N O','LT',0,'C');

$pdf->SetFont('Arial','',8);

foreach ($MC as $i => $value) {

	$saltoI = $i==(count($MC)-1)?1:0;

	$lb = $i==(count($MC)-1)?'LTR':'LT';

	$pdf->Cell($aCol,$pdf->nFont,substr(utf8_decode($MC[$i]->descripcion),0,10).' ( '.intval($MC[$i]->porcentaje).'% )',$lb,$saltoI,'C');

}

// PINTAMOS 2DA LINEA

$pdf->setX(5); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(05,$pdf->nFont,'','LB',0,'C');
$pdf->Cell(80,$pdf->nFont,'','LB',0,'C');
$sepa0 = count($MC);
foreach ($MC as $i => $value) {

	$sepa2 = $arr[$i]['separador'];
	$MCP = $arr[$i]['idgrumatconmkb'];//$arr[$i]->idgrumatconmkb;

	foreach ($MCP as $j => $value) {

		$pdf->SetFont('Arial','',6);
		$pdf->Cell($sepa2,$pdf->nFont,substr(utf8_decode($MCP[$j]->descripcion_breve),0,10),'LBT',0,'C');

	}	

	$saltoI = ( $i==(count($MC)-1) ) ? 1:0;
	$lx = ( $i==(count($MC)-1) ) ? 'LBTR':'LBT';
	
	$pdf->SetFont('Arial','B',6);	
	$pdf->SetTextColor(0,0,192);
	$pdf->Cell($prm,$pdf->nFont,'Pts',$lx,$saltoI,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',7);	
	
	$arr[$i] = array("idgrumatcon" => $MC[$i]->idgrumatcon,"idgrumatconmkb" => $MCP, "separador" => $sepa2);

}


// PINTAMOS 3RA LINEA

//var_dump($arr[$i]);

$pdf->setX(5);
$pdf->SetFont('Arial','',7);

$nc = "u=".$u."&idgrumatconmkb=".$MCP[0]->idgrumatconmkb;
$Alu = $fp->getQueryPDO(0,$nc,0,0,0,array()," order by nume_lista asc ",1);

foreach ($Alu as $k => $value) {

	$saltoI = $k==(count($Alu))?1:0;
	$lb = $k==(count($Alu))?'LBTR':'LBT';

	$pdf->setX(5);
	$pdf->Cell(05,$pdf->nFont,$Alu[$k]->num_lista,$lb,$saltoI,'C');
	$pdf->Cell(80,$pdf->nFont,utf8_decode($Alu[$k]->ap_paterno.' '.$Alu[$k]->ap_materno.' '.$Alu[$k]->nombre), $lb,$saltoI,'L');

	foreach ($MC as $i => $value) {
		
		$sepa2 = $arr[$i]['separador'];
		$MCP = $arr[$i]['idgrumatconmkb'];//$arr[$i]->idgrumatconmkb;
		foreach ($MCP as $j => $value) {

			$nc = "u=".$u."&idgrumatcon=".$MC[$i]->idgrumatcon."&idgrumatconmkb=".$MCP[$j]->idgrumatconmkb.'&idgrualu='.$Alu[$k]->idgrualu;

			$Cal = $fp->getQueryPDO(3,$nc,0,0,0,array(),"  ",1);

			$calif = count($Cal) > 0 ? intval($Cal[0]->calificacion) > 0 ? intval($Cal[0]->calificacion) : '' : '';
			$pdf->SetFont('Arial','',6);	
			$pdf->Cell($sepa2,$pdf->nFont,$calif,'LBT',0,'R');
		}

			$saltoI = ( $i==(count($MC)-1) ) ? 1:0;
			$lx = ( $i==(count($MC)-1) ) ? 'LBTR':'LBT';

		// Promedio de la Parte	

		$pdf->SetFont('Arial','B',6);	
		$nc = "&idboleta=".$Alu[$k]->idboleta."&idgrumatcon=".$MC[$i]->idgrumatcon;
		$Cal = $fp->getQueryPDO(8,$nc,0,0,0,array(),"  ",1);
		if ( count($Cal) > 0 ){
			$iCal = intval($Cal[0]->calificacion);
			if ( $iCal >= 60 ){
				$calif = $Cal[0]->cal_real;
				$pdf->SetTextColor(0,128,0);
			}elseif ( $iCal >= 0 && $iCal < 60 ){
				$calif = $Cal[0]->cal_real;
				$pdf->SetTextColor(192,0,0);
			}else{
				$calif = '';
			}	
		}else{
				$calif = '';
		}
		// $calif = count($Cal) > 0 ? intval($Cal[0]->calificacion) > 0 ? intval($Cal[0]->calificacion) : '' : '';
		$pdf->Cell($prm,$pdf->nFont,$calif,$lx,$saltoI,'R');
		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(0,0,0);

	}

}

$pdf->Output();

*/

$fileout= "lista_calif_detalle_1.xlsx"; 
$objWriter->save($fileout); 
//guardamos el archivo excel 

echo "Archivo generado con &eacute;xito, para abrir haga click <a href='http://platsource.mx/php/01/docs/".$fileout."'>aqu&iacute;</a>"  

?>


</body>
</html>

