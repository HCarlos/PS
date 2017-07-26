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
    var $totalAlumnos;
    var $alumnosAcreditados;
    var $alumnosNoAcreditados;

    function Header(){   
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',9);

		$this->Image('../../../images/web/head-sep-tab-0.jpg',5,5,65,25);
		$this->Image('../../../images/web/head-sep-tab-1.jpg',186,5,25,25);

		$this->setY(7);

		$this->Cell(100,4,'','',0,'L');
		$this->Cell(90,4,utf8_decode("SUBDIRECCIÓN DE PLANEACIÓN Y EVALUACIÓN"),'',1,'C');

		$this->Cell(100,4,'','',0,'L');
		$this->Cell(90,4,utf8_decode("DIRECCIÓN DE CONTROL ESCOLAR E INCORPORACIÓN"),'',1,'C');

		$this->Cell(100,4,'','',0,'L');
		$this->Cell(90,4,utf8_decode("DEPARTAMENTO DE ACREDITACIÓN Y CERTIFICACIÓN"),'',1,'C');

		$this->Cell(100,4,'','',0,'L');
		$this->Cell(90,4,utf8_decode("DE EDUCACIÓN SECUNDARIA"),'',1,'C');

		$this->Ln(10);

		$this->SetFont('Arial','B',12);
		$this->Cell(206,4,utf8_decode("ACTA DE CALIFICACIONES FINALES OFICIALES"),'',1,'C');

		$this->Ln(5);
		$this->SetDrawColor(128,128,128);

		// Línea 1

		$this->setX(5);

		$this->SetFont('Arial','',8);
		$this->Cell(38,4,utf8_decode("NOMBRE DE LA ESCUELA:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Cell(50,4,utf8_decode("COLEGIO ARJÍ, A.C."),'',0,'L');
		$this->Line(44,$this->getY()+4,80,$this->getY()+4);

		$this->SetFont('Arial','',8);
		$this->Cell(37,4,utf8_decode("CLAVE SEGÚN CCTM7MN:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Cell(40,4,utf8_decode("2 7 P E S 0 0 7 7 Q"),'',0,'L');
		$this->Line(131,$this->getY()+4,162,$this->getY()+4);

		$this->SetFont('Arial','',8);
		$this->Cell(25,4,utf8_decode("ZONA ESCOLAR:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Line(195,$this->getY()+4,201,$this->getY()+4);
		$this->Cell(20,4,utf8_decode("09"),'',1,'L');

		// Línea 2

		$this->Ln(2);
		$this->setX(5);

		$this->SetFont('Arial','',8);
		$this->Cell(18,4,utf8_decode("DOMICILIO:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Cell(181,4,utf8_decode("AV. MÉXICO NÚM. 2 COL. DEL BOSQUE, VILLAHERMOSA, TABASCO"),'',1,'L');
		$this->Line(24,$this->getY(),201,$this->getY());


		// Línea 3

		$this->Ln(2);
		$this->setX(5);

		$this->SetFont('Arial','',8);
		$this->Cell(50,4,utf8_decode("GRADO, GRUPO Y TURNO ACTUAL:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Cell(90,4,utf8_decode($this->grupo." MATUTINO"),'',0,'L');
		$this->Line(56,$this->getY()+4,100,$this->getY()+4);

		$this->SetFont('Arial','',8);
		$this->Cell(26,4,utf8_decode("CICLO ESCOLAR:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Cell(30,4,utf8_decode($this->ciclo),'',1,'L');
		$this->Line(172,$this->getY(),201,$this->getY());

		// Línea 4

		$this->Ln(2);
		$this->setX(5);

		$this->SetFont('Arial','',8);
		$this->Cell(22,4,utf8_decode("ASIGNATURA:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Cell(181,4,utf8_decode($this->materia),'',1,'L');
		$this->Line(28,$this->getY(),201,$this->getY());

		$this->Ln(5);
		$this->setX(5);

		// $this->RoundedRect(5,$this->GetY(),206, 6, 2, '', 'FD');

		// $this->Ln(2);
		// $this->setX(5);

		$this->SetFont('Times','B',8);
		$this->Cell(10,11,utf8_decode("N°:"),'LT',0,'C');
		$this->Cell(40,11,utf8_decode("CURP"),'LT',0,'C');
		$this->Cell(90,11,utf8_decode("NOMBRE DEL ALUMNO"),'LT',0,'C');
		$this->Cell(66,6,utf8_decode("C    A    L    I    F    I    C    A    C    I    Ó    N"),'LTR',1,'C');

		$this->setX(5);

		$this->Cell(10,6,utf8_decode(""),'LB',0,'C');
		$this->Cell(40,6,utf8_decode(""),'LB',0,'C');
		$this->Cell(90,6,utf8_decode(""),'LB',0,'C');
		$this->Cell(20,6,utf8_decode("NÚMERO"),'LTB',0,'C');
		$this->Cell(46,6,utf8_decode("LETRA"),'LTBR',1,'C');

    }

	function Footer(){

		// Línea 1

		$this->Ln(4);
		$this->setX(5);

		$this->SetFont('Arial','',8);
		$this->Cell(34,4,utf8_decode("FECHA DE VALIDACIÓN:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Cell(181,4,date('d-m-Y'),'',1,'L');
		$this->Line(40,$this->getY(),201,$this->getY());

		// Línea 2

		$this->Ln(2);
		$this->setX(5);

		$this->SetFont('Arial','',8);
		$this->Cell(34,4,utf8_decode("TOTAL DE ALUMNOS:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Cell(50,4,$this->totalAlumnos,'',0,'L');
		$this->Line(40,$this->getY()+4,80,$this->getY()+4);

		$this->SetFont('Arial','',8);
		$this->Cell(23,4,utf8_decode("ACREDITADOS:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Cell(30,4,$this->alumnosAcreditados,'',0,'L');
		$this->Line(113,$this->getY()+4,132,$this->getY()+4);

		$this->SetFont('Arial','',8);
		$this->Cell(28,4,utf8_decode("NO ACREDITADOS:"),'',0,'L');
		$this->SetFont('Times','B',10);
		$this->Line(171,$this->getY()+4,201,$this->getY()+4);
		$this->Cell(20,4,$this->alumnosNoAcreditados,'',1,'L');

		// Línea 3

		$this->Ln(2);
		$this->setX(5);

		$this->SetFont('Arial','',8);
		$this->Cell(10,4,utf8_decode("NOTA:"),'',0,'L');
		$this->SetFont('Times','BI',7);
		$this->Cell(181,4,'EL DOCENTE ANTES DE FIRMAR (TINTA NEGRA) DEBE REVISAR Y CANCELAR CON DIUREX LAS CALIFICACIONES Y ESPACIOS EN BLANCO.','',1,'L');
		$this->Line(16,$this->getY(),201,$this->getY());


		$this->Ln(6);
		$this->setX(5);
		$this->SetFont('Arial','B',8);
		$this->Cell(85,4,utf8_decode($this->profesor),0,0,'C');
		$this->Cell(40,4,'',0,0,'L');
		$this->Cell(86,4,'AURA GRACIELA MERINO CASTELLANOS',0,1,'C');

		$this->Ln(10);
		$this->setX(5);
		$this->SetFont('Arial','',8);
		$this->Cell(85,4,'__________________________________________',0,0,'C');
		$this->Cell(40,4,'__________________________',0,0,'C');
		$this->Cell(86,4,'__________________________________________',0,1,'C');

		$this->setX(5);
		$this->SetFont('Arial','',8);
		$this->Cell(85,4,'NOMBRE Y FIRMA DEL PROFESOR',0,0,'C');
		$this->Cell(40,4,'SELLO DE LA ESCUELA',0,0,'C');
		$this->Cell(86,4,'NOMBRE Y FIRMA DEL DIRECTOR',0,1,'C');

	}

}

$pdf = new PDF_Diag('P','mm',array(216,299));
$pdf->AliasNbPages();
$pdf->SetTopMargin(0);
$pdf->AddFont('andalemono','','AndaleMono.php');
// $pdf->SetBottomMargin(0);
$pdf->SetLeftMargin(0);
$pdf->SetRightMargin(0);
$pdf->SetAutoPageBreak(true, 0);
$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);
$pdf->logoEmp = $logoEmp;
$pdf->logoIBO = $logoIbo;

// echo $idgrupo;
// echo $idgrumat;

$arrAlu = $f->getQuerys(100," idgrupo = $idgrupo and idgrumat = $idgrumat ",0,0,0,array()," order by num_lista asc ",1);
$pdf->totalAlumnos = count($arrAlu);
$pdf->alumnosAcreditados = 0;
$pdf->alumnosNoAcreditados = 0;


// $result = $f->getQuerys(100,"idgrualu=".$arrAlu[0]->idgrualu,0,0,0,array(),"",1);

$pdf->grupo = $arrAlu[0]->grupo_oficial;
$pdf->periodo = $arrAlu[0]->grupo_periodo;
$pdf->semestre = $arrAlu[0]->grupo_periodo_ciclo;
$pdf->materia = $arrAlu[0]->materia;
$pdf->ciclo = $arrAlu[0]->ciclo;
$pdf->folio = $arrAlu[0]->clave;
$pdf->profesor = $arrAlu[0]->profesor;

$pdf->AddPage();

$pdf->SetFont('andalemono','',10);



foreach ($arrAlu as $i => $value) {
	

	// $prom = $f->getQuerys(101," idgrumat = $idgrumat, &idgrualu=".$arrAlu[$i]->idgrualu,0,0,0,array(),'',1);
	$prom = $f->getQuerys(101," idboleta=".$arrAlu[$i]->idboleta,0,0,0,array(),'',1);

	if ( count($prom)>0  ){

		$pr = explode('.', ROUND( $prom[0]->promcalof,1 ) ) ;
		
		$dig = $F->Letras(floatval($pr[0]));
		if (count($pr) > 1){ 
			$dec = $F->Letras(floatval($pr[1]));
		}else{
			$dec = 'CERO';
		}	
		$pdf->setX(5);
		$pdf->SetFont('andalemono','',8);		
		$pdf->Cell(10,6,utf8_decode($arrAlu[$i]->num_lista),'LB',0,'C');
		$pdf->Cell(40,6,utf8_decode($arrAlu[$i]->curp),'LB',0,'C');
		$pdf->Cell(90,6,utf8_decode($arrAlu[$i]->alumno),'LB',0,'L');
		$pdf->Cell(15,6,number_format($prom[0]->promcalof, 1, '.', ' '),'LTB',0,'R');
		$pdf->Cell(5,6,'','TB',0,'R');
		$pdf->Cell(46,6,utf8_decode($dig." PUNTO ".$dec),'LTBR',1,'C');

		if ( floatval($prom[0]->promcalof) >= 6 ){
			++$pdf->alumnosAcreditados;
		}else{
			++$pdf->alumnosNoAcreditados;
		}



	} // Fin de Enf IF


}

$pdf->Output();

?>