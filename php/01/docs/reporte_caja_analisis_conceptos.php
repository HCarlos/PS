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
		$this->Cell(100,6,utf8_decode("ANÁLISIS DE ".strtoupper($this->tConcepto)),'',1,'L');
	    $this->setX(40);
		$this->SetFont('Arial','',9);
		if ($this->IdGrupo == 0){
			$this->Cell(13,6,"NIVEL: ",'',0,'L');
			$this->SetFont('Arial','B',9);
			$this->Cell(55,6,strtoupper($this->cClave_Nivel),'',0,'L');
		}else{
			$this->Cell(15,6,"GRUPO: ",'',0,'L');
			$this->SetFont('Arial','B',9);
			$this->Cell(53,6,strtoupper($this->cIdGrupo),'',0,'L');
		}
		$this->SetFont('Arial','',6);
		$this->Cell(100,6,utf8_decode("FECHA DE IMPRESION: ").DATE('d-m-Y h:m:s'),'',1,'R');
	    $this->Cell(199,4,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');

		$this->Ln(10);

		$this->SetFont('Arial','B',8);
		$this->setX(5);
		if ($this->IdGrupo == 0){
			$this->Cell(25,6,'GRUPO','LBT',0,'C');
		}
		$this->Cell(10,6,'#','LBT',0,'C');
		$this->Cell(12,6,'IDFAM','LBT',0,'C');
		$this->Cell(90,6,'A  L  U  M  N  O','LBT',0,'L');
		$this->SetFont('Arial','',6);
		$this->Cell($this->aC,6,'1','LBT',0,'C');
		$this->Cell($this->aC,6,'2','LBT',0,'C');
		$this->Cell($this->aC,6,'3','LBT',0,'C');
		$this->Cell($this->aC,6,'4','LBT',0,'C');
		$this->Cell($this->aC,6,'5','LBT',0,'C');
		$this->Cell($this->aC,6,'6','LBT',0,'C');
		$this->Cell($this->aC,6,'7','LBT',0,'C');
		$this->Cell($this->aC,6,'8','LBT',0,'C');
		$this->Cell($this->aC,6,'9','LBT',0,'C');
		$this->Cell($this->aC,6,'10','LBT',0,'C');
		$this->SetFont('Arial','B',6);
		$this->Cell($this->aC,6,'STS','LBTR',1,'C');


    }
	
	function Footer()
	{
		$this->Ln(5);
		$this->setX(5);
	    $this->SetFont('Arial','',6);

		// Pagado en Caja
		$this->SetFillColor(64,64,64);
		$this->Cell($this->aC,6,'','LBTR',0,'L',true);
		$this->Cell(2,6,'','',0,'L',false);
		$this->Cell(30,6,'PAGADO EN CAJA','',0,'L',false);

		// Pagado en Banco
		$this->SetFillColor(92,92,92);
		$this->Cell($this->aC,6,'','LBTR',0,'L',true);
		$this->Cell(2,6,'','',0,'L',false);
		$this->Cell(30,6,'PAGADO EN BANCO','',0,'L',false);

		// Pagado en Internet
		$this->SetFillColor(128,128,128);
		$this->Cell($this->aC,6,'','LBTR',0,'L',true);
		$this->Cell(2,6,'','',0,'L',false);
		$this->Cell(30,6,'PAGADO EN INTERNET','',0,'L',false);

		// Adeudo
		$this->SetFillColor(255,125,125);
		$this->Cell($this->aC,6,'#','LBTR',0,'C',true);
		$this->Cell(2,6,'','',0,'L',false);
		$this->Cell(30,6,'ADEUDO','',1,'L',false);

	    
	    //Position at 1.5 cm from bottom
	    $this->SetY(-10);
	    //Arial italic 8
	    $this->SetFont('Arial','I',7);
	    //Page number
	    $this->Cell(100,4,utf8_decode('platsource.mx ©'),0,0,'L');
	    $this->Cell(100,4,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
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
$pdf->AddPage();

if ($pdf->IdGrupo == 0){
	$rsAlu = $F->getQueryPDO(73,"u=".$u."&clave_nivel=".$pdf->Clave_Nivel);
}else{
	$rsAlu = $F->getQueryPDO(74,"u=".$u."&clave_nivel=".$pdf->Clave_Nivel."&idgrupo=".$pdf->IdGrupo);	
}

$idgrupo = intval($rsAlu[0]->idgrupo);

$pdf->SetTextColor(0,0,0);

if ( count($rsAlu) > 0 ){
	foreach ($rsAlu as $i => $value) {
	
		$rsPago = $F->getQueryPDO(75,
			"u=".$u.
			"&idfamilia=".$rsAlu[$i]->idfamilia.
			"&idalumno=".$rsAlu[$i]->idalumno.
			"&status0=".$status0.
			"&idconcepto=".$pdf->IdConcepto,
			0,0,0,array(),
			" order by num_pago asc ");	
		
		$countPagos = count($rsPago);
		$numCol = 11;
		
		if ( $countPagos > 0){

			if ($idgrupo != intval($rsAlu[$i]->idgrupo) ){
				$idgrupo = intval($rsAlu[$i]->idgrupo);
				if ($pdf->Status0 == 0){
					$pdf->AddPage();
				}
			}
			
			$pdf->SetFont('Arial','',6);
			$pdf->setX(5);
			if ($pdf->IdGrupo == 0){
				$pdf->Cell(25,6,substr($rsAlu[$i]->grupo,0,30),'LBT',0,'C');
			}		
			$pdf->Consecutivo++;
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(10,6,$pdf->Consecutivo,'LBT',0,'C');
			$pdf->Cell(12,6,$rsAlu[$i]->idfamilia,'LBT',0,'C');
			$pdf->Cell(90,6,utf8_decode($rsAlu[$i]->alumno),'LBT',0,'L');

			$numPagos = $countPagos > 0 ? $rsPago[0]->num_pagos == 0 ? 1 : $rsPago[0]->num_pagos : 0;

			$numPagos = $numPagos > 10 ? 10 : $numPagos;

			$pdf->SetFont('Arial','',6);

			$numPago = 0;
			$leyenda = '';
			for($j=1;$j<=$numCol;++$j){
				$cierre = $j==$numCol ? 1 : 0;
				$cuadro = $j==$numCol ? 'LBTR' : 'LBT';
				if ($j <= $countPagos){
					if (intval($rsPago[$j-1]->status_movto) == 1){
						$numPago++;
						switch (intval($rsPago[$j-1]->origen)) {
							case 0:
								$pdf->SetFillColor(64,64,64);
								break;
							case 1:
								$pdf->SetFillColor(92,92,92);
								break;
							case 2:
								$pdf->SetFillColor(128,128,128);
								break;
						}

						$pdf->Cell($pdf->aC,6,'',$cuadro,$cierre,'C',true);
					}else{
						if ($leyenda != 'PAG'){						
							$leyenda = (($numPagos == $numPago) && ($numPagos > 0)) ? 'PAG' : $rsPago[$j-1]->num_pago;
						}else{
							$leyenda = ' ';
						}
						$pdf->SetFillColor(255,125,125);
						$pdf->Cell($pdf->aC,6,$leyenda,$cuadro,$cierre,'C',true);
					}
				}else{
						$pdf->SetFillColor(255,255,255);
						if ($leyenda == ''){						
							$leyenda = (($numPagos == $numPago) && ($numPagos > 0)) ? 'PAG' : '';
						}else{
							$leyenda = ' ';
						}
						$pdf->Cell($pdf->aC,6,$leyenda,$cuadro,$cierre,'L',false);				
				}			
			}

		}else{
			if ($pdf->Status0 == 0 ){

				$pdf->SetFont('Arial','',6);
				$pdf->setX(5);
				if ($pdf->IdGrupo == 0){
					$pdf->Cell(25,6,substr($rsAlu[$i]->grupo,0,30),'LBT',0,'C');
				}		
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(10,6,'','LBT',0,'C');
				$pdf->Cell(12,6,$rsAlu[$i]->idfamilia,'LBT',0,'C');
				$pdf->Cell(90,6,utf8_decode($rsAlu[$i]->alumno),'LBT',0,'L');

				$pdf->SetFont('Arial','',6);
				$pdf->Cell($pdf->aC*$numCol,6,utf8_decode('CONCEPTO NO ENCONTRADO Ó EDO. CTA. INEXISTENTE'),'LBTR',1,'L',false);				
			}
		}


	}

}else{
	$pdf->SetFont('Arial','I',10);
	$pdf->setX(5);
	$pdf->Cell(200,12,'NO SE ENCONTRARON REGISTROS','',0,'C');
}

$pdf->Output();

?>