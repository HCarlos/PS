<?php

$data = $_POST['data'];

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
		$this->Cell(100,6,utf8_decode("REPORTE DE VENCIMIENTOS"),'',1,'L');
	    $this->setX(40);
		$this->SetFont('Arial','B',12);
		$this->Cell(100,6,utf8_decode($this->vconcepto),'',1,'L');
	    $this->setX(40);
		$this->SetFont('Arial','',10);
		$this->Cell(35,6,utf8_decode("VENCIMIENTOS AL:"),'',0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(65,6,$this->vencimiento,'',0,'L');
		$this->SetFont('Arial','',7);
		$this->Cell(66,6,utf8_decode("FECHA DE IMPRESION: ").DATE('d-m-Y h:m:s'),'',1,'R');
		$this->Ln(10);

		$this->SetFont('Arial','B',8);
		$this->setX(5);
		$this->Cell(5,6,'#','T',0,'C');
		$this->Cell(2,6,'','T',0,'C');
		$this->Cell(50,6,'FAMILIA / ALUMNO','T',0,'L');
		$this->Cell(2,6,'','T',0,'C');
		$this->Cell(40,6,'CONCEPTO','T',0,'R');
		$this->Cell(5,6,'','T',0,'C');
		$this->Cell(20,6,'IMPORTE','T',0,'R');
		$this->Cell(10,6,'','T',0,'C');
		$this->Cell(20,6,'VENCIMIENTO','T',0,'R');
		$this->Cell(20,6,'GRUPO','T',0,'R');
		$this->Cell(26,6,' ','T',1,'C');
		// $this->Cell(25,6,'1RO INGLES' ,'BT',0,'R');
		// $this->Cell(25,6,'PRIMARIA','BT',0,'R');
		// $this->Cell(25,6,'SECUNDARIA' ,'BT',0,'R');
		// $this->Cell(25,6,'PREPARATORIA' ,'BT',1,'R');


    }
	
	function Footer()
	{
	    //Position at 1.5 cm from bottom
	    $this->SetY(-10);
	    //Arial italic 8
	    $this->SetFont('Arial','I',7);
	    //Page number
	    $this->Cell(100,4,utf8_decode('platsource.mx ©'),0,0,'L');
	    $this->Cell(100,4,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
	}
    
}



$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetFillColor(192,192,192);

$pdf->fi = $fi;
$pdf->ff = $ff;

$pdf->vconcepto = trim($concepto).' | '.trim($cclave_nivel).' | '.trim($cidgrupo);
$pdf->vencimiento = $fvencimiento;

$pdf->AddPage();



// /* *********************************************************
// ** ENCABEZADO
// ** ********************************************************* */

// echo $data;

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8);

$rs = $fP->getQueryPDO(45,$data,0,0,0,array(),"",1);

$hFont = 6;

if ( count($rs) > 0 ){

	// $l=0;
	// $r0=$r1=$r2=$r3=$r4=0;

	$stotal = 0;
	foreach ($rs as $i => $value) {

		$rb = 'TB';
		$pdf->setX(5);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(5,$hFont,$rs[$i]->idfamilia,$rb,0,'R');
		$pdf->Cell(2,$hFont,'',$rb,0,'L');
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(193,$hFont,utf8_decode( $rs[$i]->familia ),$rb,1,'L');

		$dt = "u=$u&vconcepto=$vconcepto&clave_nivel=$clave_nivel&idfamilia=".$rs[$i]->idfamilia."&fvencimiento=$fvencimiento";

		// $pdf->Cell(5,$hFont,$dt,$rb,1,'L');

		$sftotal = 0;
		$rsa = $fP->getQueryPDO(46,$dt,0,0,0,array(),"",1);
		foreach ($rsa as $j => $value) {
			$rb = '';
			$pdf->setX(15);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(5,$hFont,$rsa[$j]->idalumno,$rb,0,'R');
			$pdf->Cell(2,$hFont,'',$rb,0,'L');
			$pdf->Cell(50,$hFont,utf8_decode( $rsa[$j]->alumno ),$rb,0,'L');
			$pdf->Cell(2,$hFont,'',$rb,0,'L');

			if ( intval($rsa[$j]->is_pagos_diversos) == 1 ){
				$concp0 = $rsa[$j]->concepto.' '.$rsa[$j]->mes.' '.date('Y',strtotime($fvencimiento));
			}else{
				$concp0 = $rsa[$j]->concepto;
			}
			
			$pdf->Cell(40,$hFont,utf8_decode( $concp0 ),$rb,0,'L');
			$pdf->Cell(2,$hFont,'',$rb,0,'L');
			$total = number_format($rsa[$j]->total,2);
			$pdf->Cell(20,$hFont,$total,$rb,0,'R');
			$pdf->Cell(2,$hFont,'',$rb,0,'R');
			$fv0 = explode("-",$rsa[$j]->vencimiento);
			$fv = $fv0[2].'-'.$fv0[1].'-'.$fv0[0];
			$pdf->Cell(20,$hFont,$fv,$rb,0,'R');
			$pdf->Cell(2,$hFont,'',$rb,0,'R');
			$pdf->Cell(20,$hFont,$rsa[$j]->grupo,$rb,1,'R');
			$sftotal += $rsa[$j]->total;
		}

		$rb = 'T';
		$pdf->setX(15);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(5,$hFont,'',$rb,0,'R');
		$pdf->Cell(2,$hFont,'',$rb,0,'L');
		$pdf->Cell(50,$hFont,'',$rb,0,'L');
		$pdf->Cell(2,$hFont,'',$rb,0,'L');
		$concp0 = '';
		$pdf->Cell(40,$hFont,'TOTAL',$rb,0,'L');
		$pdf->Cell(2,$hFont,'',$rb,0,'L');
		$total = number_format($sftotal,2);
		$pdf->Cell(20,$hFont,$total,$rb,0,'R');
		$pdf->Cell(2,$hFont,'',$rb,0,'R');
		$fv0 ='';
		$fv = '';
		$pdf->Cell(20,$hFont,$fv,$rb,0,'R');
		$pdf->Cell(2,$hFont,'',$rb,0,'R');
		$pdf->Cell(20,$hFont,'',$rb,1,'R');

		$stotal += $sftotal;

	}

	$rb = 'T';
	$pdf->Ln(5);
	$pdf->setX(15);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,$hFont,'',$rb,0,'R');
	$pdf->Cell(2,$hFont,'',$rb,0,'L');
	$pdf->Cell(50,$hFont,'',$rb,0,'L');
	$pdf->Cell(2,$hFont,'',$rb,0,'L');
	$concp0 = '';
	$pdf->Cell(40,$hFont,'TOTAL GENERAL',$rb,0,'L');
	$pdf->Cell(2,$hFont,'',$rb,0,'L');
	$total = number_format($stotal,2);
	$pdf->Cell(20,$hFont,$total,$rb,0,'R');
	$pdf->Cell(2,$hFont,'',$rb,0,'R');
	$fv0 ='';
	$fv = '';
	$pdf->Cell(20,$hFont,$fv,$rb,0,'R');
	$pdf->Cell(2,$hFont,'',$rb,0,'R');
	$pdf->Cell(20,$hFont,'',$rb,1,'R');

}else{

	$pdf->SetFont('Arial','I',10);
	$pdf->setX(5);
	$pdf->Cell(200,12,'NO SE ENCONTRARON REGISTROS','',0,'C');

}

$pdf->Output();

?>