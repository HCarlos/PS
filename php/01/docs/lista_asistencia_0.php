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

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();
require_once('../oCentura.php');
$F = oCentura::getInstance();
$rs = $F->getCombo($o, $c, $from, $cantidad, $t, $s);

$rs[0]->label;

parse_str($c);

class PDF_Diag extends PDF_Sector {
	var $nFont;
    var $grupo;

    function Header(){   }
	
	function Footer()
	{
	    //Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',7);
	    //Page number
	    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
	}
    
}

// require('../oFunctions.php');
// $F = oFunctions::getInstance();


$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->grupo = $grupo;// strtoupper(utf8_decode($F->getBFecha(date("Y-m-d"),"00:00:00",7)));
$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);

$pdf->AddPage();

$pdf->Image('../../../images/web/logo-arji.gif',5,5,25,25);
$pdf->Ln(5);

$pdf->setX(30);

// /* *********************************************************
// ** ENCABEZADO
// ** ********************************************************* */

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(110,$pdf->nFont,utf8_decode("COLEGIO ARJÍ A.C."),'',0,'L');
$pdf->Cell(70,$pdf->nFont,utf8_decode("LISTA DE ASISTENCIA"),'LTRB',1,'C',true);

$pdf->Ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(22,$pdf->nFont,'PROFESOR:','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(123,$pdf->nFont,'____________________________________________','',0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,$pdf->nFont,utf8_decode("GRUPO:"),'',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,$pdf->nFont,utf8_decode($pdf->grupo),'',1,'R');

$pdf->Ln(1);
$pdf->setX(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(22,$pdf->nFont,'MATERIA:','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(123,$pdf->nFont,'____________________________________________','',0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,$pdf->nFont,utf8_decode("FECHA:"),'',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,$pdf->nFont,date('d-m-Y'),'',1,'R');

$pdf->Ln(5);
$pdf->setX(5);
$y = $pdf->GetY();
$pdf->SetFillColor(192);
$pdf->RoundedRect(5, $y, 205, 6, 2, '12', 'FD');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,$pdf->nFont,utf8_decode("#"),'',0,'C');
$pdf->Cell(95,$pdf->nFont,utf8_decode("NOMBRE DEL ALUMNO "),'L',0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',1,'L');
$l=0;
foreach ($rs as $i => $value) {
	
	//$this->images[$file]['data']

	$pdf->setX(5);
	$pdf->Cell(10,$pdf->nFont,intval($rs[$i]->num_lista)==0?'':$rs[$i]->num_lista,'LB',0,'C');
	$pdf->Cell(95,$pdf->nFont,utf8_decode( $rs[$i]->label ),'LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LBR',1,'L');
	$l = $i;
}

for ($l=$i; $l<32; $l++) {
	
	//$this->images[$file]['data']

	$pdf->setX(5);
	$pdf->Cell(10,$pdf->nFont,'','LB',0,'C');
	$pdf->Cell(95,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LB',0,'L');
	$pdf->Cell(5,$pdf->nFont,'','LBR',1,'L');
}

$pdf->setX(5);
$y = $pdf->GetY();
$pdf->SetFillColor(192);
$pdf->RoundedRect(5, $y, 205, 6, 2, '34', 'FD');

$pdf->setX(5);
$pdf->Cell(10,$pdf->nFont,'','',0,'C');
$pdf->Cell(95,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',0,'L');
$pdf->Cell(5,$pdf->nFont,'','L',1,'L');


$pdf->Output();

?>