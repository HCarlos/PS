<?php

$data = $_POST['data'];
$cads = $_POST['cads'];
$familias = $_POST['familias'];

if (!isset($data)){
	header('Location: http://platsource.mx/');
}

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();

require_once('../oCentura.php');
$f = oCentura::getInstance();

require_once('../oCenturaPDO.php');
$fP = oCenturaPDO::getInstance();

parse_str($data);

class PDF_Diag extends PDF_Sector {
	var $nFont;
    var $grupo;
    var $fi;
    var $ff;
    var $vencimiento;
    var $vconcepto;

    function Header(){ 

		$this->Image('../../../images/web/logo-arji.gif',5,5,25,25);
		$this->Ln(1);
	    $this->setY(7);
		$this->setX(40);
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',10);
		$this->Cell(70,6,utf8_decode("COLEGIO ARJÍ A.C."),'',1,'L');
	    $this->setX(40);
		$this->SetFont('Arial','',12);
		$this->Cell(100,6,utf8_decode("RECORDATORIO"),'',1,'L');
		$this->Ln(25);
		$this->setX(5);

    }
	
	function Footer()
	{ 
		/*
	    $this->SetY(-15);
	    $this->SetFont('Arial','I',7);
	    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
		*/

	    $this->SetY(-15);
	    $this->SetFont('Arial','',6);
	    $this->Cell(0,10,'FMT-01',0,0,'L');
	}

    
}



$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetFillColor(192,192,192);


$pdf->AddPage();



// /* *********************************************************
// ** ENCABEZADO
// ** ********************************************************* */

// echo $data;

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);

//$rs = $fP->getQueryPDO(30,$data,0,0,0,array(),"",1);
$rs = explode('|', $cads);
$fams = explode('|', $familias);

$hFont = 6;

if ( count($rs) > 0 ){

	foreach ($rs as $i => $value) {

		$dt = "u=".$u."&vconcepto=".$vconcepto."&clave_nivel=".$clave_nivel."&idfamilia=".$rs[$i]."&idalumno=0&fvencimiento=$fvencimiento";		
		$rsa = $fP->getQueryPDO(46,$dt,0,0,0,array(),"",1);

		if ( count($rsa) > 0 ){

			$rb = 'TB';
			$pdf->setX(10);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(43,$hFont,utf8_decode("ESTIMADOS SEÑORES: "),'',0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(150,$hFont,utf8_decode($fams[$i]),'',1,'L');
			//$pdf->Cell(150,$hFont,$rs[$i],'',1,'L');
			$pdf->Ln(5);
			$pdf->setX(10);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(205,$hFont,utf8_decode("DE LA MANERA MAS ATENTA LES RECORDAMOS QUE EN NUESTROS REGISTROS APARECE QUE USTED TIENE"),'',1,'L');
			$pdf->Cell(205,$hFont,utf8_decode("LOS SIGUIENTES ADEUDOS DE ".strtoupper($rsa[0]->concepto).": "),'',1,'L');
			$pdf->Ln(5);				

			$alu0 = 0;

			foreach ($rsa as $j => $value) {

				if ($alu0 != intval($rsa[$j]->idalumno) ){

					$pdf->Ln(5);
					$pdf->setX(10);
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(45,$hFont,"ALUMNO",'',0,'L');
					$pdf->Cell(55,$hFont,'CONCEPTO','',0,'L');
					$pdf->Cell(30,$hFont,'TOTAL','',0,'R');
					$pdf->Cell(30,$hFont,'VENCIMIENTO','',0,'R');
					$pdf->Cell(25,$hFont,'GRUPO','',1,'R');
					$pdf->SetFont('Arial','',10);
					$alu0 = intval($rsa[$j]->idalumno);
				}

				$pdf->setX(10);
				$pdf->Cell(45,$hFont,utf8_decode( $rsa[$j]->alumno ),'TLB',0,'L');
				if ( intval($rsa[$j]->is_pagos_diversos) == 1 ){
					$concp0 = $rsa[$j]->concepto.' '.$rsa[$j]->mes.' '.date('Y',strtotime($rsa[$j]->vencimiento));
				}else{
					$concp0 = $rsa[$j]->concepto;
				}
				$pdf->Cell(55,$hFont,utf8_decode( $concp0 ),$rb,0,'L');
				$total = number_format($rsa[$j]->total,2);
				$pdf->Cell(30,$hFont,$total,$rb,0,'R');
				$pdf->Cell(30,$hFont,$Q->getWith3LetterMonthD($rsa[$j]->vencimiento),$rb,0,'R');
				$pdf->Cell(25,$hFont,$rsa[$j]->grupo,'RTB',1,'R');
			}

			$pdf->Ln(10);
			$pdf->setX(10);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(205,$hFont,utf8_decode("POR LO QUE LE SUPLICAMOS PASAR A LA BREVEDAD POSIBLE A LIQUIDAR SU ADEUDO."),'',1,'L');

			$pdf->Ln(5);
			$pdf->setX(10);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(205,$hFont,utf8_decode("NOTA: RECUERDE QUE SI USTED ADEUDA TRES MESES DE COLEGIATURA O MAS, SE SUSPENDERÁ EL SERVICIO A SUS HIJOS."),'',1,'L');
			$pdf->Cell(50,$hFont,utf8_decode("TAMBIÉN PUEDE PAGAR EN:"),'',0,'L');
			$hY = $pdf->GetY();
			$hX = $pdf->GetX();
			//$pdf->Cell(50,$hFont,utf8_decode("TAMBIÉN PUEDE PAGAR EN :,"),'',1,'L');
			$text=stripslashes("<a href='http://platsource.mx/' target='_blank' sytle='color:green'>http://platsource.mx</a>");
			$pdf->setY($hY);
			$pdf->SetX($hX-9);
			$pdf->WriteHTML($text);

			$pdf->Ln(20);
			$pdf->setX(10);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(195,$hFont,utf8_decode("ATENTAMENTE"),'',1,'C');

			$pdf->Ln(10);
			$pdf->setX(10);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(195,$hFont,utf8_decode("LA ADMINISTRACIÓN"),'',1,'C');

			if ( ($i+1) < count($rs) ){
				$pdf->AddPage();
			}

		}else{

			$pdf->SetFont('Arial','I',10);
			$pdf->setX(5);
			$pdf->Cell(200,12,'NO SE ENCONTRARON REGISTROS','',0,'C');

		}

	}


}else{

	$pdf->SetFont('Arial','I',10);
	$pdf->setX(5);
	$pdf->Cell(200,12,'NO SE ENCONTRARON REGISTROS','',0,'C');

}

$pdf->Output();

?>