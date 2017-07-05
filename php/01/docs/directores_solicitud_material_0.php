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
    var $descripcionPedidos;

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

$pdf->Image('../../../images/web/'.$logoEmp,5,5,25,25);

$pdf->setY(7);
$pdf->setX(30);

// /* *********************************************************
// ** ENCABEZADO
// ** ********************************************************* */

switch ( intval($cmbStatus) ) {
	case 0:
		$pdf->descripcionPedidos = "MATERIAL SOLICITADO";
		break;
	case 1:
		$pdf->descripcionPedidos = "MATERIAL AUTORIZADO";
		break;
	case 2:
		$pdf->descripcionPedidos = "MATERIAL ENTREGADO";
		break;
}

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(110,$pdf->nFont,utf8_decode("COLEGIO ARJÍ A.C."),'',0,'L');
$pdf->Cell(70,$pdf->nFont,utf8_decode($pdf->descripcionPedidos),'LTRB',1,'C',true);

$pdf->Ln(1);
$pdf->setX(28);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(22,$pdf->nFont,'USUARIO:','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(128,$pdf->nFont,"(".$lstProfDir.") ".utf8_decode($element),'',0,'L');
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,$pdf->nFont,utf8_decode('FECHA IMPRESIÓN: '),'',0,'R');
$pdf->SetFont('Arial','',6);
$pdf->Cell(12,$pdf->nFont,date('d-m-Y H:i:s'),'',1,'L');

$pdf->Ln(1);
$pdf->setX(32);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,$pdf->nFont,'DEL: ','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,$pdf->nFont,$fi,'',0,'L');
$pdf->Cell(5,$pdf->nFont,'  ','',0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,$pdf->nFont,'AL: ','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,$pdf->nFont,$ff,'',1,'L');

// echo $lstProfDir;
$cad = "idsolicita=".$lstProfDir."&fi=".$fi."&ff=".$ff;
$fl = $F->getQuerys(517,$data);

$pdf->Ln(5);

if ( count($fl) > 0 ){


	$l=0;

	$pdf->setX(5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(20,6,'CANT.','B',0,'R');
	$pdf->Cell(145,6,'PRODUCTO','B',0,'L'); 
	$pdf->Cell(20,6,'P. UNIT.','B',0,'R'); 
	$pdf->Cell(20,6,'IMPORTE','B',1,'R'); 

	$total = 0;
	foreach ($fl as $j => $value) {
		$pdf->setX(0);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(20,6,$fl[$j]->cantidad."  ",'',0,'R'); //." ".$result[$j]->idgrumat

			
		if ( intval($fl[$j]->idcolor) > 0 ){
			$colr = " | COLOR: ".$fl[$j]->color;
		}else{
			$colr = "";
		}


		$pdf->Cell(145,6,utf8_decode($fl[$j]->producto).' '.$fl[$j]->medida1.$colr,'',0,'L'); 

		$pdf->Cell(20,6,number_format( floatval($fl[$j]->costo_unitario),2,'.',',' ),'',0,'R'); 

		$pdf->Cell(20,6,number_format( floatval($fl[$j]->suma),2,'.',',' ),'',1,'R'); 

		$total = $total + floatval($fl[$j]->suma);

	/*
		if ( trim($fl[$j]->observaciones_solicitud) != '' ){
			$obs = "OBS: ".$fl[$j]->observaciones_solicitud;
			$pdf->setX(0);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(20,4,"",'',0,'R'); //." ".$result[$j]->idgrumat
			$pdf->Cell(180,4,utf8_decode($obs),'',1,'L'); //." ".$result[$j]->idgrumat
		}
	*/	

	}	

	$pdf->setX(5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(20,6,'','T',0,'L');
	$pdf->Cell(145,6,'','T',0,'L'); 
	$pdf->Cell(20,6,'TOTAL','T',0,'L'); 
	$pdf->Cell(20,6,number_format( $total,2,'.',',' ),'T',1,'R'); 

}else{

	$pdf->setX(5);
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(205,6,"No se encontraron datos",'T',1,'C'); 

}

$pdf->Ln(5);


$pdf->Output();

?>