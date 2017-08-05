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

define('FPDF_FONTPATH','font/');

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
    var $numDiasAsistencia;

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
		$this->Cell(70,6,utf8_decode("LISTA DE ASISTENCIA"),'LTRB',1,'C',true);

		$this->Ln(3);
		$this->setX(30);
		$this->SetFont('Arial','B',8);
		$this->Cell(22,$this->nFont,'PROFESOR:','',0,'R');
		$this->SetFont('Arial','',8);
		$this->Cell(85,$this->nFont,$this->profesor,'',0,'L');
		$this->SetFont('Arial','B',8);
		$this->Cell(15,$this->nFont,utf8_decode("GRUPO:"),'',0,'R');
		$this->SetFont('Arial','',8);
		$this->Cell(45,$this->nFont,$this->grupo,'',0,'L');
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

		$this->Ln(5);

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

// require('../oCentura.php');
// $f = oCentura::getInstance();

require_once("../oCenturaPDO.php");
$fp = oCenturaPDO::getInstance();

$MC = $fp->getNumDiasAsistencia($idgrumat,$eval);

$arr = array();

if ( count($MC) > 3 ){
	$hHoja = 'P'; // 'L';
	$param0 = 126; // 160;
}else{
	$hHoja = 'P';
	$param0 = 126;// 120;
}

if (count($MC) > 0){
	$aCol = ($param0 / count($MC) );
}else{
	echo "NO SE ENCONTRARON DATOS";
	$aCol = 0;
	return false;
}


$pdf = new PDF_Diag($hHoja,'mm','Letter');
$pdf->AliasNbPages();
$pdf->AddFont('andalemono','','AndaleMono.php');
$pdf->AddFont('andalemonomtstdbold','','AndaleMonoMTStdBold.php');
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


// PINTAMOS 1RA LINEA

$pdf->setX(5);
$pdf->nFont = 10;
$pdf->SetFont('Arial','B',8);

$anchoAlumno = 70;

$pdf->Cell(05,$pdf->nFont,'#','LT',0,'C');
$pdf->Cell($anchoAlumno,$pdf->nFont,'N O M B R E   D E L   A L U M N O','LT',0,'C');

$pdf->SetFont('andalemono','',7);
$x = $pdf->getX() + ($aCol/2) + 1;
foreach ($MC as $i => $value) {

	$y = $pdf->getY()+$pdf->nFont-1;
	$pdf->Rotate(90,$x,$y);
    $pdf->Text($x,$y, date('d-m',strtotime($MC[$i]->dia) ) );
    $pdf->Rotate(0);

	$x = $x + $aCol;


}

foreach ($MC as $i => $value) {

	$pdf->Cell($aCol,$pdf->nFont,'','LT',0,'C');

}

$pdf->Cell(4,$pdf->nFont,'T','LTR',1,'C');


$pdf->nFont = 6;

// PINTAMOS 2DA LINEA

$pdf->Ln(0);

$pdf->setX(5);
$pdf->SetFont('Arial','',7);

$nc = "u=".$u."&idgrumat=".$idgrumat;
$Alu = $fp->getQueryPDO(1,$nc,0,0,0,array()," order by nume_lista asc ",1);
$fT = 0;
foreach ($Alu as $k => $value) {

	$saltoI = $i==(count($Alu)-1)?1:0;
	$lb = $i==(count($Alu)-1)?'LBTR':'LBT';

	$pdf->setX(5);
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(05,$pdf->nFont,$Alu[$k]->num_lista,$lb,$saltoI,'C');
	$pdf->Cell($anchoAlumno,$pdf->nFont,mb_strtoupper(utf8_decode($Alu[$k]->apellidos_alumno.' '.$Alu[$k]->nombres_alumno),'UTF-8'),$lb,$saltoI,'L');

	$pdf->SetFont('Arial','B',7);
	$faltas = 0;
	foreach ($MC as $i => $value) {

		// $saltoJ = ( $i==(count($MC)-1) ) ? 1:0;
		// $lx = ( $i==(count($MC)-1) ) ? 'LBTR':'LBT';

		$nc = "u=".$u."&idboleta=".$Alu[$k]->idboleta."&fecha=".$MC[$i]->dia."&eval=".$eval;
		$MCP = $fp->getQueryPDO(7,$nc,0,0,0,array(),"  ",1);
		foreach ($MCP as $j => $value) {

			$Cal = intval($MCP[$j]->asistencia);//$fp->getQueryPDO(3,$nc,0,0,0,array(),"  ",1);
			switch ($Cal) {
				case 1:
					$pdf->SetTextColor(0,0,212);
					$pdf->SetFont('Arial','B',10);
					$calif = iconv('utf-8', 'cp1252//IGNORE', "•");
					break;
				// case 2:
				// 	$pdf->SetFont('Arial','B',7);
				// 	$pdf->SetTextColor(0,0,192);
				// 	$calif = "R";
				// 	break;
				case 3:
					$pdf->SetFont('Arial','B',7);
					$pdf->SetTextColor(212,0,0);
					$calif = "XX";
					$faltas = $faltas + 2;
					break;
				default:
					$pdf->SetFont('Arial','B',7);
					$pdf->SetTextColor(212,0,0);
					$calif = "X";
					++$faltas;
					break;
			}
			$pdf->Cell($aCol,$pdf->nFont,$calif,'LBT',0,'C');
		}
	}

	$flt = $faltas > 0 ? $faltas : '';
	$fT = $fT + $faltas;
	$pdf->SetFont('Arial','',7);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(4,$pdf->nFont,$flt,'LBTR',1,'C');

}

// GRACIAS, TOTALES
$pdf->setX(5);
$pdf->SetFont('Arial','B',8);

$pdf->Cell(05,$pdf->nFont,'','LTRB',0,'C');
$pdf->Cell($anchoAlumno,$pdf->nFont,'','LTRB',0,'C');

foreach ($MC as $i => $value) {

	$pdf->Cell($aCol,$pdf->nFont,'','LTRB',0,'C');

}

$pdf->Cell(4,$pdf->nFont,$fT,'LTRB',1,'C');

// NOMENCLATURAS

$pdf->Ln(5);

$pdf->setX(5);

$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,212);
$pdf->Cell(3,$pdf->nFont,iconv('utf-8', 'cp1252//IGNORE', "•"),'LTB',0,'L');

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(192,192,192);
$pdf->Cell(3,$pdf->nFont,'=','TB',0,'L');

$pdf->SetTextColor(0,0,0);
$pdf->Cell(20,$pdf->nFont,'Asistencia','TB',0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(212,0,0);
$pdf->Cell(3,$pdf->nFont,'X','TB',0,'L');

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(192,192,192);
$pdf->Cell(3,$pdf->nFont,'=','TB',0,'L');

$pdf->SetTextColor(0,0,0);
$pdf->Cell(13,$pdf->nFont,'Falta','TB',0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(212,0,0);
$pdf->Cell(3,$pdf->nFont,'XX','TB',0,'L');

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(192,192,192);
$pdf->Cell(3,$pdf->nFont,'=','TB',0,'L');

$pdf->SetTextColor(0,0,0);
$pdf->Cell(22,$pdf->nFont,'Doble Falta','TRB',1,'L');

// $pdf->SetFont('Arial','B',8);
// $pdf->SetTextColor(0,0,192);
// $pdf->Cell(3,$pdf->nFont,'R','TB',0,'L');

// $pdf->SetFont('Arial','',8);
// $pdf->SetTextColor(192,192,192);
// $pdf->Cell(3,$pdf->nFont,'=','TB',0,'L');

// $pdf->SetFont('Arial','',8);
// $pdf->SetTextColor(0,0,0);
// $pdf->Cell(20,$pdf->nFont,'Retardo','TRB',1,'L');

$pdf->Output();

?>