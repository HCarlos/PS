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

require('../diag/sector.php');

class PDF_Diag extends PDF_Sector {
	var $nFont;
    var $profesor;
    var $materia;
    var $grupo;
    var $eval;
    var $fecha;
    var $phead;
    var $lastWidht;
    var $prom;
    var $promcal;
    var $promcon;
    var $sumina;
    var $numregs;
    var $logoEmp;

    function Header(){   
		$this->Image('../../../images/web/'.$this->logoEmp,5,5,25,25);
		$this->Ln(5);

		$this->setX(30);

		// /* *********************************************************
		// ** ENCABEZADO
		// ** ********************************************************* */

		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','B',12);
		$this->Cell(110,$this->nFont,utf8_decode("COLEGIO ARJÍ A.C."),'',0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(70,6,utf8_decode("LISTA DE CALIFICACIONES"),'LTRB',1,'C',true);

		$this->Ln(3);
		$this->setX(30);
		$this->SetFont('Arial','B',8);
		$this->Cell(22,$this->nFont,'PROFESOR:','',0,'R');
		$this->SetFont('Arial','',8);
		$this->Cell(85,$this->nFont,utf8_decode($this->profesor),'',0,'L');
		$this->SetFont('Arial','B',8);
		$this->Cell(15,$this->nFont,utf8_decode("GRUPO:"),'',0,'R');
		$this->SetFont('Arial','',8);
		$this->Cell(45,$this->nFont,utf8_decode($this->grupo),'',0,'L');
		$this->SetFont('Arial','B',8);
		$this->Cell(10,$this->nFont,utf8_decode("EVAL:"),'',0,'R');
		$this->SetFont('Arial','',8);
		$this->Cell(10,$this->nFont,$this->eval,'',1,'L');

		$this->Ln(0);
		$this->setX(30);
		$this->SetFont('Arial','B',8);
		$this->Cell(22,$this->nFont,'MATERIA:','',0,'R');
		$this->SetFont('Arial','',8);
		$this->Cell(85,$this->nFont,utf8_decode($this->materia),'',0,'L');
		$this->SetFont('Arial','B',8);
		$this->Cell(15,$this->nFont,utf8_decode("FECHA:"),'',0,'R');
		$this->SetFont('Arial','',8);
		$this->Cell(30,$this->nFont,date('d-M-Y'),'',1,'L');

		$this->Ln(2);

    }
	
	function Footer()
	{
	    //Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',7);
	    //Page number
	    $this->Cell(0,10,utf8_decode('PlatSource © '.date('Y')),0,0,'L');
	    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
	}

	function ImprimeFooterTemp($val=0){

			$this->Ln(5);
			$this->setX(5);
			$this->SetFont('Arial','',8);
			$this->Cell(68.333333333,$this->nFont,utf8_decode('FIRMA DEL LÍDER DE ACADEMIA:'),'',0,'C');
			$this->Cell(68.333333333,$this->nFont,'FIRMA DEL PROFESOR:','',0,'C');
			$this->Cell(68.333333333,$this->nFont,'FIRMA DEL JEFE DE GRUPO:','',1,'C');

			$this->Ln(10);
			$this->setX(5);
			$this->Cell(68.333333333,$this->nFont,'_________________________________','',0,'C');
			$this->Cell(68.333333333,$this->nFont,'_________________________________','',0,'C');
			$this->Cell(68.333333333,$this->nFont,'_________________________________','',1,'C');

	}
    
}

require('../oCentura.php');
$f = oCentura::getInstance();

require_once("../oCenturaPDO.php");
$fp = oCenturaPDO::getInstance();


$nc = "u=".$u."&idgrumat=".$idgrumat."&numval=".$eval;

$MC = $f->getQuerys(38,$nc,0,0,0,array()," order by idgrumatcon asc ",1);


if ( count($MC) > 3 ){
	$hHoja = 'L';
	$prm = 9;
	$param0 = 192 - ($prm * 5);
}else{
	$hHoja = 'P';
	$prm = 9;
	$param0 = 130 - ($prm * 5);
}


$aCol = ( $param0 / count($MC) );

$nc = "u=".$u."&idgrumatcon=".$MC[0]->idgrumatcon;
$MCP = $f->getQuerys(104,$nc,0,0,0,array()," order by idgrumatconmkb asc ",1);


$pdf = new PDF_Diag($hHoja,'mm','Letter');
$pdf->AliasNbPages();
//$pdf->municipio = $rs->municipio;// strtoupper(utf8_decode($F->getBFecha(date("Y-m-d"),"00:00:00",7)));
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

$anchoNombre = 70;


$pdf->AddPage();


// PINTAMOS 1RA LINEA

$pdf->setX(5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(05,$pdf->nFont,'#','LT',0,'C');
$pdf->Cell($anchoNombre,$pdf->nFont,'N O M B R E   D E L   A L U M N O','LT',0,'C');

$pdf->SetFont('Arial','',8);

foreach ($MC as $i => $value) {

	$pdf->Cell($aCol,$pdf->nFont,substr(utf8_decode($MC[$i]->descripcion),0,10).' ( '.intval($MC[$i]->porcentaje).'% )','LT',0,'C');

}
		
$pdf->SetTextColor(0,0,192);
$pdf->Cell($prm,$pdf->nFont,'Cal','LT',0,'C');
$pdf->SetTextColor(0,0,0);
$pdf->Cell($prm,$pdf->nFont,'CR','LT',0,'C');
$pdf->Cell($prm,$pdf->nFont,'Cond','LT',0,'C');
$pdf->Cell($prm,$pdf->nFont,'Ina','LT',0,'C');
$pdf->Cell($prm,$pdf->nFont,'Obs','LTR',1,'C');

// PINTAMOS 2DA LINEA

// PINTAMOS 3RA LINEA

//var_dump($arr[$i]);

$pdf->setX(5);
$pdf->SetFont('Arial','',7);

$nc = "u=".$u."&idgrumatconmkb=".$MCP[0]->idgrumatconmkb;
$Alu = $fp->getQueryPDO(0,$nc,0,0,0,array()," order by nume_lista asc ",1);

foreach ($Alu as $k => $value) {

	$saltoI = $k==( count($Alu) )?1:0;
	$lb = $k==( count($Alu) )?'LBTR':'LBT';

	$pdf->setX(5);
	$pdf->Cell(05,$pdf->nFont,$Alu[$k]->num_lista,$lb,$saltoI,'C');
	$pdf->Cell($anchoNombre,$pdf->nFont,utf8_decode($Alu[$k]->ap_paterno.' '.$Alu[$k]->ap_materno.' '.$Alu[$k]->nombre),$lb,$saltoI,'L');
	// Califiaciones
	foreach ($MC as $i => $value) {

		$pdf->SetFont('Arial','',7);	
		$nc = "&idboleta=".$Alu[$k]->idboleta."&idgrumatcon=".$MC[$i]->idgrumatcon;
		$Cal = $fp->getQueryPDO(8,$nc,0,0,0,array(),"  ",1);

		if ( count($Cal) > 0 ){

			$calif0 = $Cal[0]->calificacion;
			$calif1 = $Cal[0]->cal_real;

		}else{
				$calif0 = '';
				$calif1 = '';
		}

		$prm2 = $aCol / 2;



		$pdf->Cell($prm2,$pdf->nFont,$calif0,'LBT',0,'R');
		
		if ( count($Cal) > 0 ){
			$iCal = intval($Cal[0]->calificacion);
			if ( $iCal >= 60 ){
				$pdf->SetTextColor(0,128,0);
			}elseif ( $iCal >= 0 && $iCal < 60 ){
				$pdf->SetTextColor(192,0,0);
			}else{
				$calif0 = '';
				$calif1 = '';
			}	
		}else{
				$calif0 = '';
				$calif1 = '';
		}
		
		$pdf->Cell($prm2,$pdf->nFont,$calif1,'LBT',0,'R');

		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(0,0,0);

	}

	// Pintamos los Promedios

	$nc = "&idboleta=".$Alu[$k]->idboleta."&numval=".$pdf->eval ;
	$Cal = $fp->getQueryPDO(9,$nc,0,0,0,array(),"  ",1);

	if ( count($Cal) > 0 ){

		$iCal = intval($Cal[0]->cal);
		if ( $iCal >= 60 ){
			$calif0 = $Cal[0]->cal;
		}elseif ( $iCal >= 0 && $iCal < 60 ){
			$calif0 = $Cal[0]->cal;
		}else{
			$calif0 = '';
		}	

		$iCal = intval($Cal[0]->con);
		if ( $iCal > 0 ){
			$cond = intval($Cal[0]->con);
		}else{
			$cond = '';
		}	

		$iCal = intval($Cal[0]->ina);
		if ( $iCal > 0 ){
			$ina = $Cal[0]->ina;
		}else{
			$ina = '';
		}	

		$iCal = intval($Cal[0]->obs);
		if ( $iCal > 0 ){
			$obs = $Cal[0]->obs;
		}else{
			$obs = '';
		}	

	}else{
			$calif0 = '';
			$cond = '';
			$ina = '';
			$obs = '';
	}

	$pdf->Cell($prm,$pdf->nFont,$calif0,'LBT',0,'R');
	$pdf->Cell($prm,$pdf->nFont,round($calif0,0),'LBT',0,'R');
	$pdf->Cell($prm,$pdf->nFont,$cond,'LBT',0,'C');
	$pdf->Cell($prm,$pdf->nFont,$ina,'LBT',0,'C');
	$pdf->Cell($prm,$pdf->nFont,$obs,'LBTR',1,'C');


}

$pdf->ln(10);
$pdf->ImprimeFooterTemp(0);

$pdf->Output();

?>