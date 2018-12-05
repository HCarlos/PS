<?php

$data = $_POST['data'];

if (!isset($data)){
	header('Location: http://platsource.mx/');
}

parse_str($data);

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();
require_once('../oCentura.php');
$F = oCentura::getInstance();

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


$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->grupo = strtoupper(utf8_decode($Q->getBFecha(date("Y-m-d"),"00:00:00",6)));
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
$pdf->Cell(70,$pdf->nFont,utf8_decode("SOLICITUD DE PEDIDOS"),'LTRB',1,'C',true);

$pdf->Ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(22,$pdf->nFont,'USUARIO:','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(123,$pdf->nFont,utf8_decode($element),'',1,'L');


$fl = $F->getQuerys(515,$idlista);

$pdf->Ln(5);

$l=0;

$pdf->setX(5);
$pdf->SetFont('Arial','B',8);

if (count($fl) > 0){


	$pdf->Cell(10,6,$fl[0]->idsolicita,'B',0,'L'); //." ".$result[$j]->idgrumat
	$pdf->Cell(165,6,utf8_decode($fl[0]->solicitante),'B',0,'L'); //." ".$result[$j]->idgrumat
	$sm = count($fl) > 0 ? $fl[0]->fecha_solicitud : '';
	$pdf->Cell(20,6,utf8_decode($sm),'B',1,'R'); //." ".$result[$j]->idgrumat

	foreach ($fl as $j => $value) {
		$pdf->setX(0);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(20,6,$fl[$j]->cantidad_autorizada."  ",'',0,'R'); //." ".$result[$j]->idgrumat
			
		if ( intval($fl[$j]->idcolor) > 0 ){
			$colr = " | COLOR: ".$fl[$j]->color;
		}else{
			$colr = "";
		}
		
		$pdf->Cell(160,6,utf8_decode($fl[$j]->producto).' '.$fl[$j]->medida1.$colr,'',0,'L'); //." ".$result[$j]->idgrumat
		$pdf->Cell(20,6,utf8_decode($fl[$j]->fecha_autorizacion),'',1,'R'); //." ".$result[$j]->idgrumat

		if ( trim($fl[$j]->observaciones_solicitud) != '' ){
			$obs = "OBS: ".$fl[$j]->observaciones_solicitud;
			$pdf->setX(0);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(20,4,"",'',0,'R'); //." ".$result[$j]->idgrumat
			$pdf->Cell(180,4,utf8_decode($obs),'',1,'L'); //." ".$result[$j]->idgrumat
		}
	}	

	$pdf->Ln(5);

}else{
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(205,10,'NO SE ENCONTRARON ELEMENTOS','RTLB',1,'C'); 
}

$pdf->Ln(5);

$pdf->Output();

?>