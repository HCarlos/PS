<?php

$data = $_POST['data'];

if (!isset($data)){
	header('Location: http://platsource.mx/');
}

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();
require_once('../oCenturaPDO.php');
$F = oCenturaPDO::getInstance();

parse_str($data);

class PDF_Diag extends PDF_Sector {
	var $nFont;
    var $grupo;
    var $logoEmpresa;
    var $nombreEmpresa;
    var $tConcepto;
    var $aC;
    var $IdConcepto;
    var $Clave_Nivel;
    var $IdGrupo;
    var $cClave_Nivel;
    var $cIdGrupo;
    var $Status0;
    var $Consecutivo;
    var $Ciclo;

    function Header(){ 

		$this->Image('../../../images/web/'.$this->logoEmpresa,5,5,25,25);
		$this->Ln(1);
	    $this->setY(7);
		$this->setX(40);
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',10);
		$this->Cell(70,6,utf8_decode($this->nombreEmpresa),'',1,'L');
	    $this->setX(40);
		$this->SetFont('Arial','B',12);
		$this->Cell(100,6,utf8_decode("ANÁLISIS DE ".utf8_decode(strtoupper($this->tConcepto))." PAGADO EN SU TOTALIDAD"),'',1,'L');
	    $this->setX(40);
		$this->SetFont('Arial','',9);
		if ($this->IdGrupo == 0){
			$this->Cell(13,6,"NIVEL: ",'',0,'L');
			$this->SetFont('Arial','B',9);
			$this->Cell(55,6,utf8_decode(strtoupper($this->cClave_Nivel)),'',0,'L');
		}else{
			$this->Cell(15,6,"GRUPO: ",'',0,'L');
			$this->SetFont('Arial','B',9);
			$this->Cell(53,6,utf8_decode(strtoupper($this->cIdGrupo)),'',0,'L');
		}
		$this->SetFont('Arial','',6);
		$this->Cell(100,6,utf8_decode("FECHA DE IMPRESION: ").DATE('d-m-Y h:m:s'),'',1,'R');

	    $this->setX(40);
		$this->SetFont('Arial','',9);
		$this->Cell(30,6,"CICLO ESCOLAR: ",'',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(55,6,utf8_decode(strtoupper($this->Ciclo)),'',0,'L');
		$this->SetFont('Arial','',6);
	    $this->Cell(85,4,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');

		$this->Ln(10);

		$this->SetFont('Arial','B',8);
		$this->setX(5);
		if ($this->IdGrupo == 0){
			$this->Cell(25,6,'GRUPO','LBT',0,'C');
		}
		$this->Cell(12,6,'IDFAM','LBT',0,'C');
		$this->Cell(12,6,'IDALU','LBT',0,'C');
		$this->Cell(90,6,'A  L  U  M  N  O','LBT',0,'L');
		$this->SetFont('Arial','',6);
		$this->Cell(28,6,'IMPORTE','LBTR',1,'R');


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

	function getPagados($countPagos, $rsPago, $numCol){
		$total = 0;

		$numPagos = $countPagos > 0 ? intval($rsPago[0]->num_pagos) == 0 ? 1 : intval($rsPago[0]->num_pagos) : 0;

		$numPagos = $numPagos > 10 ? 10 : $numPagos < $countPagos ? $countPagos : $numPagos;

		$numPago = 0;
		$t = 0;
		$leyenda = '';
		for($j=1;$j<=$numCol;++$j){
			$cierre = $j==$numCol ? 1 : 0;
			$cuadro = $j==$numCol ? 'LBTR' : 'LBT';
			if ($j <= $countPagos){
				
				if (intval($rsPago[$j-1]->status_movto) == 1){
				    $t = $t + $rsPago[$j-1]->total; 
					$numPago++;
				}				
			}else{
				$total = (($numPagos == $numPago) && ($numPagos > 0)) ? $t : 0;

			}			
			
		}	
		return $total;
	}
    
}

$rs = $F->getQueryPDO(-5,"u=".$u);

$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetFillColor(192,192,192);

$pdf->aC=6.25;
$pdf->logoEmpresa = $F->getLogoEmp($rs[0]->idemp);
$pdf->nombreEmpresa = $F->getNombreEmp($rs[0]->idemp);
$pdf->tConcepto = $concepto;
$pdf->IdConcepto = intval($vconcepto);
$pdf->Clave_Nivel = intval($clave_nivel);
$pdf->IdGrupo = intval($idgrupo);
$pdf->cClave_Nivel = $cclave_nivel;
$pdf->cIdGrupo = $cidgrupo;
$pdf->Status0 = intval($status0);
$pdf->Consecutivo = 0;

if ($pdf->IdGrupo == 0){
	$rsAlu = $F->getQueryPDO(73,"u=".$u."&clave_nivel=".$pdf->Clave_Nivel);
}else{
	$rsAlu = $F->getQueryPDO(74,"u=".$u."&clave_nivel=".$pdf->Clave_Nivel."&idgrupo=".$pdf->IdGrupo);	
}

$idgrupo = intval($rsAlu[0]->idgrupo);
$pdf->Ciclo = $rsAlu[0]->ciclo;

$pdf->AddPage();
$pdf->SetTextColor(0,0,0);

$superTotal = 0;

if ( count($rsAlu) > 0 ){
	foreach ($rsAlu as $i => $value) {
	
		$rsPago = $F->getQueryPDO(75,
			"u=".$u.
			"&idfamilia=".$rsAlu[$i]->idfamilia.
			"&idalumno=".$rsAlu[$i]->idalumno.
			"&status0=".$status0.
			"&idconcepto=".$pdf->IdConcepto,
			0,0,0,array(),
			" order by idfamilia, idalumno, num_pago asc ");	
		
		$countPagos = count($rsPago);
		$numCol = 11;
		
		if ( $countPagos > 0){

			// if ($idgrupo != intval($rsAlu[$i]->idgrupo) ){
			// 	$idgrupo = intval($rsAlu[$i]->idgrupo);
			// 	if ($pdf->Status0 == 0){
			// 		$pdf->AddPage();
			// 	}
			// }

			$total = $pdf->getPagados($countPagos,$rsPago,$numCol);

			if ($total > 0){

				$pdf->SetFont('Arial','',6);
				$pdf->setX(5);
				if ($pdf->IdGrupo == 0){
					$pdf->Cell(25,6,substr($rsAlu[$i]->grupo,0,30),'LBT',0,'C');
				}		
				$pdf->Consecutivo++;
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(12,6,$rsAlu[$i]->idfamilia,'LBT',0,'C');
				$pdf->Cell(12,6,$rsAlu[$i]->idalumno,'LBT',0,'C');
				$pdf->Cell(90,6,utf8_decode($rsAlu[$i]->alumno),'LBT',0,'L');
				$pdf->Cell(28,6,number_format($total,2,'.',','),'LBTR',1,'R');
				$superTotal = $superTotal + $total;
			}
			
		}

	}

	$pdf->setX(5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(139,6,'TOTAL','LBT',0,'L');
	$pdf->Cell(28,6,number_format($superTotal,2,'.',','),'LBTR',1,'R');


}else{
	$pdf->SetFont('Arial','I',10);
	$pdf->setX(5);
	$pdf->Cell(200,12,'NO SE ENCONTRARON REGISTROS','',0,'C');
}

$pdf->Output();

?>