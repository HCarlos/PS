<?php

$idfamilia = $_POST['idfamilia'];
$u = $_POST['u'];

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();
require_once('../oCentura.php');
$F = oCentura::getInstance();
require_once('../oArji.php');
$A = oArji::getInstance();
require_once('../oCenturaPDO.php');
$fp = oCenturaPDO::getInstance();

$vars = "u=".$u."&idfamilia=".$idfamilia."&idconcepto=3";

$eject = $F->getQuerys(10021, $vars,0,0,0,array(),'');

if ( $eject == "OK" ) {
	echo "Ha ocurrido un problema al generar las Líneas de Facturas de esta Familia: ".$idfamilia;
	return false;
}

$fam = $F->getQuerys(10021,$vars,0,0,0,array(),'');

class PDF_Diag extends PDF_Sector {
	var $nFont;

    function Header(){ }
	
	function Footer(){ }
    
}

$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetTopMargin(0);
$pdf->AddFont('andalemono','','AndaleMono.php');

$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);

$pdf->AddPage();

$pdf->Image('../../../images/web/logo-arji.gif',5,5,25,25);

$pdf->ln(10);
$pdf->setX(30);

// /* *********************************************************
// ** ENCABEZADO
// ** ********************************************************* */

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(110,$pdf->nFont,utf8_decode("COLEGIO ARJÍ A.C."),'',0,'L');
$pdf->SetFont('Times','B',12);
$pdf->Cell(70,6,utf8_decode("LINEAS DE CAPTURA"),'LTRB',1,'C',true);
$pdf->setX(30);
$pdf->Cell(110,$pdf->nFont,utf8_decode("COLEGIATURAS"),'',1,'L');
$pdf->setX(30);
$pdf->SetFont('Times','',12);
$pdf->Cell(25,$pdf->nFont,utf8_decode("CONVENIO:"),'',0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,$pdf->nFont,'1390252','',1,'L');
$pdf->SetFont('Times','B',12);
$pdf->Image('../../../images/web/bancomer-logo-330-80.gif',157.5,18,36,8);

$pdf->ln(12);

$pdf->SetTextColor(0,0,0);

foreach ($fam as $i => $value) {
	$pdf->setX(5);
	$y = $pdf->GetY();
	$pdf->SetFillColor(192);
	$pdf->RoundedRect(5, $y, 205, 6, 1, '1234', 'FD');

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22,$pdf->nFont,'ALUMNO: ','',0,'L');
	$pdf->SetFont('Times','',10);
	$pdf->Cell(160,$pdf->nFont,utf8_decode($fam[$i]->nombre_completo_alumno),'',0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20,$pdf->nFont,$fam[$i]->idalumno,'',1,'R');

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(90,$pdf->nFont,'REFERENCIA','TB',0,'L');
	$pdf->Cell(34,$pdf->nFont,'MES A PAGAR','TB',0,'R');
	$pdf->Cell(34,$pdf->nFont,'IMPORTE','TB',0,'R');
	$pdf->Cell(34,$pdf->nFont,'VENCIMIENTO','TB',1,'R');

	$alu = $F->getQuerys(10022, "u=".$u."&idfamilia=".$idfamilia."&idalumno=".$fam[$i]->idalumno."&idconcepto=3",0,0,0,array(),'');

	foreach ($alu as $j => $value) {

		$pdf->setX(10);

		$ref = $A->ref_BANCOMER(
				$alu[$j]->idciclo, 
				$alu[$j]->clave_nivel, 
				$idfamilia, 
				$alu[$j]->idalumno, 
				$alu[$j]->idconcepto, 
				$alu[$j]->num_pago, 
				$alu[$j]->total, 
				$alu[$j]->vencimiento,
				1
				);
		$pfFecha = strtotime($alu[$j]->vencimiento);
		$pdf->SetFont('andalemono','',8);
		$pdf->Cell(90,$pdf->nFont,$ref,'',0,'L');
		$pdf->Cell(34,$pdf->nFont,$alu[$j]->mes.' '.substr(date('Y',$pfFecha),2,2),'',0,'R');
		$pdf->Cell(34,$pdf->nFont,$alu[$j]->total,'',0,'R');
		$pdf->Cell(34,$pdf->nFont,date('d-m-Y',$pfFecha),'',1,'R');

	}

	$pdf->ln(2);

}

// /* *********************************************************
// ** CLOSE REPORT
// ** ********************************************************* */

//mysql_free_result($alut);
$pdf->Output();

?>