<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('default_socket_timeout', 6000);
date_default_timezone_set('America/Mexico_City');

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
require('../oCentura.php');
$f = oCentura::getInstance();
require('../oMetodos.php');
$M = oMetodos::getInstance();
require('../oFunctions.php');
$F = oFunctions::getInstance();

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
    var $periodo;
    var $semestre;
    var $materia_oficial;
    var $folio;
    var $profesor;
    var $fecha_acta;

    function Header(){   
		$this->setY(21);
		$this->setX(60);
		$this->SetFillColor(255,255,255);

		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',8);
		$this->Cell(21,4,utf8_decode("COLEGIO ARJÍ A.C."),'',0,'L');
		$this->Cell(57,4,utf8_decode(""),'',0,'L');
		$this->Cell(20,4,utf8_decode("MATUTINO"),'',0,'L');
		$this->Cell(44,4,utf8_decode(""),'',0,'L');
		$this->Cell(5,4,str_pad($this->folio, 2, "0", STR_PAD_LEFT),'',1,'L');

		$this->setX(0);
		$this->Ln(5);
		$this->setX(10);

		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',8);
		$this->Cell(48,4,'         '.utf8_decode($this->periodo).'  '.$this->fecha_acta,'',0,'L');

		$this->Cell(50,4,'     '.utf8_decode($this->semestre),'',0,'L');
		// $this->Cell(91,4,utf8_decode($this->materia_oficial),'',0,'L');

		$y = $this->getY();
		$x = $this->getX();
		$this->MultiCell(80,4, '  '.utf8_decode($this->materia_oficial) ,0,1,'L');
		$this->setY($y);
		$this->setX($x+95);

		$this->Cell(48,4,utf8_decode($this->grupo),'',1,'L');

		$this->setX(0);
		$this->Ln(18);



		$this->Ln(5);
    }

	function Footer(){

		$this->SetY(263);
		$this->setX(0);
		$this->SetFont('Arial','',8);
		$this->Cell(211,10,'______________________________________________',0,1,'C');

		$this->SetY(267); //260
		$this->setX(0);
		$this->SetFont('Arial','',8);
		$this->Cell(211,10,'AURA GRACIELA MERINO CASTELLANOS',0,1,'C');

		// $this->SetY(286);
		// $this->setX(0);
		// $this->SetFont('Arial','',8);
		// $this->Cell(95,10,'______________________________________________',0,0,'C');
		// $this->Cell(20,10,'',0,0,'L');
		// $this->Cell(96,10,'______________________________________________',0,1,'C');

		$this->SetY(283);//280
		$this->setX(0);
		$this->SetFont('Arial','',8);
		$this->Cell(95,10,utf8_decode($this->profesor),0,0,'C');
		$this->Cell(20,10,'',0,0,'L');
		$this->Cell(96,10,'SILVIA DEL CARMEN DE LA ROSA ROSALES',0,1,'C');

	}

}

$pdf = new PDF_Diag('P','mm',array(216,299));
$pdf->AliasNbPages();
$pdf->SetTopMargin(0);
$pdf->AddFont('andalemono','','AndaleMono.php');
$pdf->AddFont('andalemonomtstdbold','','AndaleMonoMTStdBold.php');
// $pdf->SetBottomMargin(0);
$pdf->SetLeftMargin(0);
$pdf->SetRightMargin(0);
$pdf->SetAutoPageBreak(true, 0);
$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);
$pdf->logoEmp = $logoEmp;
$pdf->logoIBO = $logoIbo;

//echo " idciclo = $idciclo and idgrupo = $idgrupo and materia_oficial LIKE ('%".$idgrumat."%') ";

$arrAlu = $f->getQuerys(73," idciclo = $idciclo and idgrupo = $idgrupo and materia_oficial LIKE ('%".$idgrumat."%') ",0,0,0,array()," order by num_lista asc ",1);

$arNiv = $f->getQuerys(6,$arrAlu[0]->idnivel);
$pdf->fecha_acta = $arNiv[0]->fecha_actas;

$result = $f->getQuerys(70,"idgrualu=".$arrAlu[0]->idgrualu,0,0,0,array(),"",1);

$pdf->grupo = $result[0]->grupo_oficial;
$pdf->periodo = $result[0]->grupo_periodo;
$pdf->semestre = $result[0]->grupo_periodo_ciclo;
$pdf->materia_oficial = $idgrumat;
$pdf->ciclo = $result[0]->ciclo;
$pdf->folio = $arrAlu[0]->clave;
$pdf->profesor = $arrAlu[0]->profesor;

$pdf->AddPage();

$pdf->SetFont('Arial','',6);

foreach ($arrAlu as $i => $value) {
	

	if ( count($arrAlu)>0  ){


			$pdf->setX(0);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(14,6,$arrAlu[$i]->num_lista,'',0,'C');
			$pdf->Cell(35,6,utf8_decode($arrAlu[$i]->matricula_oficial),'',0,'L');
			$pdf->Cell(110,6,utf8_decode($arrAlu[$i]->alumno),'',0,'L');
			$pdf->SetFont('andalemonomtstdbold','',8);
			$pdf->Cell(12,6,$F->FormatCal(floatval($arrAlu[$i]->bim0),0,0,0, $arrAlu[$i]->idmatclas),'',0,'R');
			$pdf->Cell(20,6,$F->FormatCal(floatval($arrAlu[$i]->bim1),0,0,0, $arrAlu[$i]->idmatclas),'',0,'R');
			$pdf->SetFont('andalemonomtstdbold','',8);
			$pdf->Cell(24,6,$F->FormatCal2(floatval($arrAlu[$i]->promcalof),0,0,0, $arrAlu[$i]->idmatclas),'',1,'R');


	} // Fin de Enf IF


}

$pdf->Output();

?>