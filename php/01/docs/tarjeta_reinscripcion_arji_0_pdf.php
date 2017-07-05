<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('default_socket_timeout', 6000);
mb_internal_encoding('UTF-8');

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
// require('../oMetodos.php');
// $M = oMetodos::getInstance();

class PDF_Diag extends PDF_Sector {
	var $nFont;
	var $logoEmp;
	var $logoIBO;
	var $logoFR;
    var $alumno;
    var $materia;
    var $grupo;
    var $proximoCiclo;
    var $num_lista;
    var $lastupdate;
    var $obsEsp;
    var $obsIng;

    function Header(){   

		$this->SetY(5);
		$this->SetX(0);

		$this->SetTextColor(0,0,0);
		$this->SetFont('Times','B',14);
		$this->Cell(108,6,utf8_decode("COLEGIO ARJÍ A.C."),'',0,'C');
		$this->Cell(108,6,utf8_decode("COLEGIO ARJÍ A.C."),'',1,'C');
		$this->Ln(1);
		
		$this->SetFont('Times','B',12);
		$this->Cell(108,6,utf8_decode("NOTIFICACIÓN PARA REINSCRIPCIÓN"),'',0,'C');
		$this->Cell(108,6,utf8_decode("FORMATO PARA REINSCRIPCIÓN"),'',1,'C');
		$this->Ln(1);

		$this->SetFont('Times','',12);
		$this->Cell(108,6,utf8_decode("CICLO ESCOLAR: ".$this->proximoCiclo),'',0,'C');
		$this->Cell(108,6,utf8_decode("CICLO ESCOLAR: ".$this->proximoCiclo),'',1,'C');
		$this->Ln(5);

    }

	function Footer(){

		// $this->SetY(-7);

		// $this->Image('../../../images/web/'.$this->logoFR,29,115,50,15);

		$this->SetFont('TIMES','',9);
		$this->SetY(122);
		$this->SetX(112);
		$this->MultiCell(95, 4, utf8_decode("* Para reinscribir presentar en caja este formato."),'', 'L');

	}


}

$pdf = new PDF_Diag('P','mm',array(216,140));
//$pdf->AddFont('helvetica','','helvetica.php');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(TRUE, 0.1);
$pdf->SetLeftMargin(0);
//$pdf->municipio = $rs->municipio;// strtoupper(utf8_decode($F->getBFecha(date("Y-m-d"),"00:00:00",7)));
$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);
$pdf->logoEmp = $logoEmp;
$pdf->logoIBO = $logoIbo;
$pdf->logoFR = $logoFR;
$pdf->proximoCiclo = $proximociclo;


$arrAlu = explode('|',$idalumnos);

foreach ($arrAlu as $i => $value) {
	if ( intval($arrAlu[$i]) > 0 ) {

		$Alu = $f->getQueryPDO(24,"idgrualu=".$arrAlu[$i],0,0,0,array(),$s,1);

		$pdf->AddPage();
		

		$pdf->SetFont('TIMES','',10);
		$pdf->setX(0);
		$pdf->SetFillColor(64);
		
		// Linea 1
		$pdf->Cell(5,5,'','',0,'L');
		$pdf->Cell(31,5,utf8_decode('Estimados Señores: '),'',0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(69,5,utf8_decode(mb_strtoupper($Alu[0]->familia,'UTF-8')),'',0,'L');
		$pdf->Cell(8,5,'','',0,'L');
		$pdf->Cell(95,5,utf8_decode(mb_strtoupper($Alu[0]->alumno,'UTF-8')),'RTLB',1,'C');

		// Linea 2
		$pdf->Cell(5,5,'','',0,'L');
		$pdf->Cell(100,5,'','',0,'L');
		$pdf->Cell(8,5,'','',0,'L');
		$pdf->SetFont('TIMES','',8);
		$pdf->Cell(95,5,'NOMBRE DEL ALUMNO','',1,'C');

		$pdf->Ln(5);

		// Linea 3
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(5,5,'','',0,'L');
		$pdf->Cell(100,5,'','',0,'L');
		$pdf->Cell(8,5,'','',0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(42.5,5, utf8_decode(mb_strtoupper($Alu[0]->grupo,'UTF-8')),'RTLB',0,'C');
		$pdf->Cell(10,5,'','',0,'L');
		$pdf->Cell(42.5,5,utf8_decode(mb_strtoupper($Alu[0]->nivel,'UTF-8')),'RTLB',1,'C');

		// Linea 4
		$pdf->Cell(5,5,'','',0,'L');
		$pdf->Cell(100,5,'','',0,'L');
		$pdf->Cell(8,5,'','',0,'L');
		$pdf->SetFont('TIMES','',8);
		$pdf->Cell(42.5,5,'GRUPO','',0,'C');
		$pdf->Cell(10,5,'','',0,'L');
		$pdf->Cell(42.5,5,'NIVEL','',1,'C');

		$pdf->Ln(2);

		// Linea 5
		$pdf->Cell(5,5,'','',0,'L');
		$pdf->Cell(100,5,'','',0,'L');
		$pdf->Cell(8,5,'','',0,'L');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(95,5,'','',1,'C');

		$pdf->Ln(2);

		$pdf->SetX(112);

		$pdf->SetFont('TIMES','',10);
		$pdf->MultiCell(95, 5, utf8_decode("AL REINSCRIBIR A NUESTRO HIJO(A) NOS COMPROMETEMOS NUEVAMENTE A CUMPLIR CON LAS DISPOSICIONES DEL REGLAMENTO ESCOLAR Y MANUAL DE PADRES DE FAMILIA."),'', 'J');
		$pdf->Image('../../../images/web/'.$pdf->logoFR,31,114,40,8);

		$pdf->SetY(40);
		$pdf->SetX(05);
		$pdf->MultiCell(90, 4, utf8_decode("Sirva la presente para agradecer a Ustedes el que nos hayan elegido como Institución Educativa, para ser copartícipes en la formación de su hijo(a)."),'', 'J');
		
		$pdf->SetY(55);
		$pdf->SetX(05);
		$pdf->MultiCell(90, 4, utf8_decode("Esta carta tiene como finalidad comunicarles que debido a la respuesta adecuada que ha dado su hijo(a) en los aspectos conductual y académico durante el presente periodo, podrán ustedes realizar su reinscripción para el siguiente ciclo escolar."),'', 'J');

		$pdf->SetY(78);
		$pdf->SetX(05);
		$pdf->MultiCell(90, 4, utf8_decode("Sabemos que con el valioso apoyo de ustedes seguiremos promoviendo con éxito la Formación Integral de sus hijos."),'', 'J');

		$pdf->SetY(90);
		$pdf->SetX(05);
		$pdf->MultiCell(90, 4, utf8_decode("Reciban un afectuoso saludo."),'', 'L');

		$pdf->Ln(10);

		// Linea 6
		$pdf->Cell(5,5,'','',0,'L');
		$pdf->Cell(100,5,'','',0,'L');
		$pdf->Cell(8,5,'','',0,'L');
		$pdf->SetFont('TIMES','',8);
		$pdf->Cell(95,5,'NOMBRE Y FIRMA DEL PADRE O TUTOR','T',1,'C');

		$pdf->Ln(2);

			// $pdf->SetFillColor(255);
			// $pdf->RoundedRect(169, 121, 42, 15, 2, '3', 'FD');

	}
}



$pdf->Output();

?>