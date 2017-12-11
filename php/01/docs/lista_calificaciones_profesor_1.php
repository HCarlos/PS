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
		$this->SetFont('Arial','B',9);
		$this->Cell(70,6,utf8_decode(" LISTA DE CALIFICACIONES A DETALLE "),'LTRB',1,'C',true);

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

	}
    
}

require('../oCentura.php');
$f = oCentura::getInstance();

require_once("../oCenturaPDO.php");
$fp = oCenturaPDO::getInstance();

$arr = array();

$nc = "u=".$u."&idgrumat=".$idgrumat."&numval=".$eval;

$MC = $f->getQuerys(38,$nc,0,0,0,array()," order by idgrumatcon asc ",1);

$totalColumnas = count($MC);

if ( $totalColumnas > 3 ){
	$hHoja = 'L';
	$param0 = 186;
	$prm = 7;
}else{
	$hHoja = 'P';
	$param0 = 124;
	$prm = 7;
}

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


$totalColumnas = $totalColumnas;

if ( $totalColumnas > 0 ){

	$aCol = ($param0 / $totalColumnas );

	foreach ($MC as $i => $value) {

		$nc = "u=".$u."&idgrumatcon=".$MC[$i]->idgrumatcon;
		
		$MCP = $f->getQuerys(104,$nc,0,0,0,array()," order by idgrumatconmkb asc ",1);
		$sepa1 = count($MCP) == 0 ? 1 : count($MCP);
		$sepa2 = ($aCol - $prm) / $sepa1;
		
		$arr[$i] = array("idgrumatcon" => $MC[$i]->idgrumatcon,"idgrumatconmkb" => $MCP, "separador" => $sepa2);

	}




	// PINTAMOS 1RA LINEA

	$pdf->setX(5);

	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(05,26,'#','LT',0,'C');
	$pdf->Cell(80,26,'N O M B R E   D E L   A L U M N O','LT',0,'C');

	$pdf->SetFont('Arial','',8);

	foreach ($MC as $i => $value) {

		$saltoI = $i==($totalColumnas-1)?1:0;

		$lb = $i==($totalColumnas-1)?'LTR':'LT';

		$pdf->Cell($aCol,$pdf->nFont,substr(utf8_decode($MC[$i]->descripcion),0,10).' ( '.intval($MC[$i]->porcentaje).'% )',$lb,$saltoI,'C');

	}

	// PINTAMOS 2DA LINEA

	$pdf->setX(5); 
	$pdf->SetFont('Arial','',8);

	$pdf->nFont = 20;

	$pdf->Cell(05,$pdf->nFont,'','LB',0,'C');
	$pdf->Cell(80,$pdf->nFont,'','LB',0,'C');
	$sepa0 = $totalColumnas;
	foreach ($MC as $i => $value) {

		$sepa2 = $arr[$i]['separador'];
		$MCP = $arr[$i]['idgrumatconmkb'];//$arr[$i]->idgrumatconmkb;

		foreach ($MCP as $j => $value) {

			$pdf->SetFont('Arial','',6);
			if ( count($MCP) <= 1 ){
				$pdf->Cell($sepa2,$pdf->nFont,substr(utf8_decode($MCP[$j]->descripcion_breve),0,20),'LBT',0,'C');
				// $pdf->Cell($sepa2,$pdf->nFont,utf8_decode($MCP[$j]->descripcion_breve),'LBT',0,'C');
			}else{
				$pdf->Cell($sepa2,$pdf->nFont,'','LBT',0,'C');
				$x = $pdf->getX()-(($sepa2/2)-0.8);
				$y = $pdf->getY()+18.8;
				$txt = substr(utf8_decode($MCP[$j]->descripcion_breve),0,18);
				// $txt = utf8_decode($MCP[$j]->descripcion_breve);
				$pdf->Rotate( 90, $x, $y);
				$pdf->Text($x, $y, $txt);
				$pdf->Rotate(0);
			}
		}	

		$saltoI = ( $i==($totalColumnas-1) ) ? 1:0;
		$lx = ( $i==($totalColumnas-1) ) ? 'LBTR':'LBT';
		
		$pdf->SetFont('Arial','B',6);	
		$pdf->SetTextColor(0,0,192);
		$pdf->Cell($prm,$pdf->nFont,'Pts',$lx,$saltoI,'C');
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',7);	
		
		$arr[$i] = array("idgrumatcon" => $MC[$i]->idgrumatcon,"idgrumatconmkb" => $MCP, "separador" => $sepa2);

	}

	$pdf->nFont = 6;


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

				$saltoI = ( $i==($totalColumnas-1) ) ? 1:0;
				$lx = ( $i==($totalColumnas-1) ) ? 'LBTR':'LBT';

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
			$pdf->Cell($prm,$pdf->nFont,floatval($calif),$lx,$saltoI,'R');
			$pdf->SetFont('Arial','',7);
			$pdf->SetTextColor(0,0,0);

		}


	}

}else{
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(195,12,"Faltan elementos por configurar", 'LTBR',1,'C');

}


$pdf->Output();

?>