<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('default_socket_timeout', 6000);

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
require('../oCenturaPDO.php');
$f = oCenturaPDO::getInstance();
require('../oFunctions.php');
$F = oFunctions::getInstance();
//getQuerys($tipo=0,$cad="",$type=0,$from=0,$cant=0,$ar=array(),$otros="",$withPag=1) {

class PDF_Diag extends PDF_Sector {
	var $nFont;
	var $logoEmp;
	var $logoIBO;
    var $alumno;
    var $materia;
    var $grupo;
    var $ciclo;
    var $num_lista;
    var $lastupdate;
    var $obsEsp;
    var $obsIng;
    var $folio;

    function Header(){   

		$this->Image('../../../images/web/'.$this->logoEmp,5,5,20,20);

		$this->sety(5);
		$this->setX(0);

		// /* *********************************************************
		// ** ENCABEZADO
		// ** ********************************************************* */

		$this->Ln(5);
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','B',16);
		$this->setX(30);
		$this->Cell(200,7,utf8_decode("COLEGIO ARJÍ A.C."),'',1,'L');
		$this->SetFont('Arial','',14);
		$this->setX(30);
		$this->Cell(130,7,utf8_decode("CONTROL DEL SALIDA DE ALUMNOS "),'',0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(40,7,utf8_decode("FOLIO: ").$this->folio,'',1,'R');
		$this->setX(30);
		$this->Cell(170,7,'','',1,'L');
		$this->Ln(5);

    }

	function Footer(){

		$this->SetY(-7);

		$this->SetFont('Arial','I',4);
		// $this->Cell(0,10,utf8_decode('Última Actualización:').$this->lastupdate,0,0,'L');

		$this->Cell(0,10,utf8_decode('PlatSource.mx © '.date('Y')),0,0,'R');

	}

}

$pdf = new PDF_Diag('P','mm',array(216,140));
//$pdf->AddFont('helvetica','','helvetica.php');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(TRUE, 0.1);
$pdf->SetLeftMargin(5);
//$pdf->municipio = $rs->municipio;// strtoupper(utf8_decode($F->getBFecha(date("Y-m-d"),"00:00:00",7)));
$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);
$pdf->logoEmp = $logoEmp;
$pdf->logoIBO = $logoIbo;

$arrPSAS = explode(",",$idpsas);

foreach ($arrPSAS as $i => $value) {
	
	$idpsa = $arrPSAS[$i];

	$PSA = $f->getQueryPDO(15,$idpsa);

	$arrAlu = explode(",",$idalumnos);

	foreach ($arrAlu as $j => $value) {

		$result = $f->getQueryPDO(16,"idpsa=".$idpsa."&idalumno=".$arrAlu[$j]);

		$anno = date('Y', strtotime($PSA[0]->fecha));
		$pdf->folio = $idpsa.'-'.$result[0]->idpsaalumno.'-'.$anno;

		$pdf->AddPage();

		$pdf->SetFont('Arial','B',12);

		$pdf->setX(10);
		$y = $pdf->GetY();
		$pdf->SetFillColor(192);
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(5, 28, 205, 105, 5, '1234');

		// Linea 1
		$pdf->SetFont('Arial','B',12);
	 	$pdf->Cell(55,4,utf8_decode('AUTORIZACIÓN PARA: '),'',0,'L');
		$pdf->SetFont('Arial','',12);
	 	$pdf->Cell(20,4,' SALIR ','B',0,'');
	 	$pdf->Cell(50,4,'','',0,'L');
		$pdf->SetFont('Arial','B',12);
	 	$pdf->Cell(20,4,'GRUPO: ','',0,'L');
		$pdf->SetFont('Arial','',12);
	 	$pdf->Cell(50,4," ".$result[0]->grupo." ",'B',1,'L');

		// Linea 2
		$pdf->Ln(5);
		$pdf->setX(10);
		$pdf->SetFont('Arial','B',12);
	 	$pdf->Cell(55,4,utf8_decode('ALUMNO (A): '),'',0,'L');
		$pdf->SetFont('Arial','',12);
	 	$pdf->Cell(140,4,' '.utf8_decode(mb_strtoupper($result[0]->nombre_alumno,'UTF-8')).' ','B',1,'');

		// Linea 3
		$pdf->Ln(5);
		$pdf->setX(10);
		$pdf->SetFont('Arial','B',12);
	 	$pdf->Cell(55,4,utf8_decode('MOTIVO: '),'',0,'L');
		$pdf->SetFont('Arial','',12);
		$motivo = $PSA[0]->motivos=="Otro" ? $PSA[0]->otro_motivo : $PSA[0]->motivos;
	 	$pdf->Cell(140,4,' '.utf8_decode(mb_strtoupper($motivo,'UTF-8')).' ','B',1,'');

		// Linea 4
		$pdf->Ln(5);
		$pdf->setX(10);
		$pdf->SetFont('Arial','B',12);
	 	$pdf->Cell(55,4,utf8_decode('LO (LA) RECOGE: '),'',0,'L');
		$pdf->SetFont('Arial','',12);
		$recoge = $PSA[0]->recoge=="Otro" ? $PSA[0]->otro_recoge : $PSA[0]->recoge;
	 	$pdf->Cell(140,4,' '.utf8_decode(mb_strtoupper($recoge,'UTF-8')).' ','B',1,'');

		// Linea 5
		$pdf->Ln(5);
		$pdf->setX(10);
		$pdf->SetFont('Arial','B',12);
	 	$pdf->Cell(55,4,utf8_decode('REGRESA: '),'',0,'L');
		$pdf->SetFont('Arial','',12);
		$regreso = $PSA[0]->regreso=="Otro" ? $PSA[0]->otro_regreso : $PSA[0]->regreso;
	 	$pdf->Cell(140,4,' '.utf8_decode(mb_strtoupper($regreso,'UTF-8')).' ','B',1,'');

		// Linea 6
		$pdf->Ln(5);
		$pdf->setX(10);
		$pdf->SetFont('Arial','B',12);
	 	$pdf->Cell(55,4,utf8_decode('COMENTARIO: '),'',0,'L');
		$pdf->SetFont('Arial','',12);
		$regreso = $PSA[0]->regreso=="Otro" ? $PSA[0]->otro_regreso : $PSA[0]->regreso;
	 	$pdf->Cell(140,4,' '.utf8_decode(mb_strtoupper(trim($PSA[0]->comentario),'UTF-8')).' ','B',1,'');

		// Linea 7
		$pdf->Ln(10);
		$pdf->setX(10);
		$pdf->SetFont('Arial','B',12);
	 	$pdf->Cell(55,4,'','',0,'L');
		$pdf->SetFont('Arial','',12);

		$oMes = intval(date('m', strtotime($PSA[0]->fecha)));
		
		$mes = $F->aMeses[ $oMes ];
		$dia = date('d', strtotime($PSA[0]->fecha));
		$anno = date('Y', strtotime($PSA[0]->fecha));

	 	$pdf->Cell(140,4,'VILLAHERMOSA, TABASCO  A  '.$dia.'  DE  '.utf8_decode(mb_strtoupper($mes,'UTF-8')).'  DE  '.$anno,'B',1,'');

		// Linea 8
		$pdf->Ln(20);
		$pdf->setX(15);
		$pdf->SetFont('Arial','',12);
	 	$pdf->Cell(75,4,utf8_decode(mb_strtoupper(trim($PSA[0]->director),'UTF-8')),'',1,'C');

		$pdf->Ln(1);
		$pdf->setX(15);
		$pdf->SetFont('Arial','B',12);
	 	$pdf->Cell(75,8,'PROFESOR','T',0,'C');
	 	$pdf->Cell(35,8,'','',0,'C');
	 	$pdf->Cell(75,8,utf8_decode('LA DIRECCIÓN'),'T',1,'C');

	}

}

$pdf->Output();

?>