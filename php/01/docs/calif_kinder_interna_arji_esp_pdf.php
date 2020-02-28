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
	header('Location: https://platsource.mx/');
}else{
	if ( $c=='0' ){
		$u = $_POST['u'];
		$strgrualu = $_POST['strgrualu'];
		$logoEmp = $_POST['logoEmp'];
		$logoIbo = $_POST['logoIbo'];
	}
	parse_str($c);
}

define('FPDF_FONTPATH','font/');
require('../diag/sector.php');

require('../oCentura.php');
$f = oCentura::getInstance();

require('../oMetodos.php');
$M = oMetodos::getInstance();

require('../oFunctions.php');
$Q = oFunctions::getInstance();

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
    var $matricula;
    var $headTitle;
    var $profesor;


    var $calumno;
    var $cmateria;
    var $cgrupo;
    var $cfecha;
    var $cperiodo;
    var $cnum_lista;
    var $cmatricula;

    var $aspectos;
    var $evaluacion;
    var $camposformativos;
    var $inicial;
    var $media;
    var $final;

    var $leg0;
    var $leg1;
    var $leg2;
    var $leg3;

    var $fechaImpresa;


    function Header(){   

		$this->Image('../../../images/web/'.$this->logoEmp,5.44444,5,20,20);
		//$this->Image('../../../images/web/'.$this->logoIBO,196,5.44444,10,10);

		$this->sety(5);
		$this->setX(0);

		// /* *********************************************************
		// ** ENCABEZADO
		// ** ********************************************************* */

		$this->SetTextColor(0,0,0);
		$this->SetFont('Times','B',12);
		$this->Cell(210.5,4,utf8_decode("COLEGIO ARJÍ A.C."),'',1,'C');
		$this->setX(0);
		$this->SetFont('Arial','',10);
		$this->Cell(210.5,4,utf8_decode("AV. MÉXICO NUM. 2 COL. DEL BOSQUE, VILLAHERMOSA TABASCO, TELS 351-02-60 EXT 100"),'',1,'C');
		$this->setX(0);
		$this->Cell(210.5,4,utf8_decode("INCORPORADO A LA SEP CLAVE 27PJN0007L"),'',1,'C');
		$this->setX(0);
		$this->SetFont('Arial','B',10);
		$this->setX(0);
		$this->Cell(210.5,4,utf8_decode("BOLETA DE EVALUACIÓN PREESCOLAR - ".$this->headTitle),'',1,'C');

		$this->Ln(6);
		$this->setX(5);
		$y = $this->GetY();
		$this->SetFillColor(192);
		$this->RoundedRect(5, $y, 205.5, 4, 2, '12', 'FD');
		$this->SetFont('Arial','B',8);
		$this->Cell(77,4,utf8_decode($this->calumno),'',0,'C');
		$this->Cell(28,4,utf8_decode($this->cmatricula),'L',0,'C');
		$this->Cell(28,4,utf8_decode($this->cperiodo),'L',0,'C');
		//$this->Cell(20,6,utf8_decode("GRADO",'L',0,'C');
		$this->Cell(28,4,utf8_decode($this->cfecha),'L',0,'C');
		$this->Cell(28,4,utf8_decode($this->cgrupo),'L',0,'C');
		$this->Cell(16,4,utf8_decode($this->cnum_lista),'L',1,'C');

		$this->setX(5);
		$y = $this->GetY();
		$this->SetFillColor(255);
		$this->RoundedRect(5, $y, 205.5, 4, 2, '34', 'FD');
		$this->SetFont('courier','',8);
		$this->Cell(77,4,utf8_decode($this->alumno),'',0,'C');
		$this->Cell(28,4,utf8_decode($this->matricula),'L',0,'C');
		$this->Cell(28,4,utf8_decode($this->ciclo),'L',0,'C');
		//$this->Cell(20,6,utf8_decode("5",'L',0,'C');
		$this->Cell(28,4,utf8_decode($this->fechaImpresa),'L',0,'C');
		$this->Cell(28,4,utf8_decode($this->grupo),'L',0,'C');
		$this->Cell(16,4,utf8_decode($this->num_lista),'L',1,'C');

		$this->Ln(2);

    }

	function Footer(){

		$this->SetY(-7);
		//Arial italic 8
		$this->SetFont('Arial','I',4);
		$this->Cell(0,10,utf8_decode('Última Actualización: ').date("d-m-Y H:i:s"),0,0,'L');
		$this->Cell(0,10,utf8_decode('https://platsource.mx © ').date('Y'),0,0,'R');

	}


	function FormatCal($cal=0,$d=0,$ina=false){
		$calx = "";
		$vc = intval($cal);

		if ($vc >= 95 && $vc <= 100){
			$calx = $d==0?"D":"O";
		}else if ($vc >= 85 && $vc <= 94){
			$calx = $d==0?"L":"P";
		}else if ($vc >= 65 && $vc <= 84){
			$calx = $d==0?"EP":"IP";
		}else if ($vc >= 60 && $vc <= 64){
			$calx = $d==0?"I":"B";
		}else if ($vc <= 59){
			$calx = "";
		}

		$caly = round(floatval($cal),0);
		if ($caly >= 95 && $caly <= 100){
			$cony = "IV";
		}elseif ($caly >= 75 && $caly <= 94){
			$cony = "III";
		}elseif ($caly >= 55 && $caly <= 74){
			$cony = "II";
		}elseif ($caly >= 1 && $caly <= 54){
			$cony = "I";
		}else{
			$cony = " ";
		}

		if ($ina){
			$calx = intval($cal);
			if ($calx<=0){
				$calx = '';
			}			
		}

		// return str_pad($calx, 2, " ", STR_PAD_LEFT).'    '.str_pad($cony, 3, " ", STR_PAD_LEFT);

		return str_pad($calx, 2, " ", STR_PAD_LEFT);

	}


}

$arrAlu = explode(",",$strgrualu);

$prom_x = $f->getQuerys(41,"idgrualu=".$arrAlu[0],0,0,0,array(),'',1);

$pdf = new PDF_Diag('P','mm','Letter');
//$pdf->AddFont('helvetica','','helvetica.php');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(TRUE, 0.1);
$pdf->SetLeftMargin(5);

$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);
$pdf->logoEmp = $logoEmp;
$pdf->logoIBO = $logoIbo;
$pdf->lastupdate = ""; // $prom_x[0]->modi_el;
$pdf->fechaImpresa = $Q->getWith3LetterMonthD(date('Y-m-d'));

$d=0;
$i = 0;
foreach ($arrAlu as $i => $value) {

	// $result = $f->getQuerys(53,"idgrualu=".$arrAlu[$i]."&idioma=".$d,0,0,0,array()," order by orden_impresion asc ",1);
	$result = $f->getQuerys(53,"idgrualu=".$arrAlu[$i]."&idioma=".$d,0,0,0,array()," order by orden_impresion asc ",1);
	if ( count($result) > 0 ){

		if ( intval($result[0]->obs7) > 0 ) {
			$idobs = $result[0]->obs7;
		}else if ( intval($result[0]->obs6) > 0 ) {
			$idobs = $result[0]->obs6;
		}else if ( intval($result[0]->obs5) > 0 ) {
			$idobs = $result[0]->obs5;
		}else if ( intval($result[0]->obs4) > 0 ) {
			$idobs = $result[0]->obs4;
		}else if ( intval($result[0]->obs3) > 0 ) {
			$idobs = $result[0]->obs3;
		}else if ( intval($result[0]->obs2) > 0 ) {
			$idobs = $result[0]->obs2;
		}else if ( intval($result[0]->obs1) > 0 ) {
			$idobs = $result[0]->obs1;
		}else{
			$idobs = $result[0]->obs0;
		}	

		$pdf->alumno = $result[0]->alumno; // .' '.$arrAlu[$i];
		$pdf->num_lista = $result[0]->num_lista;
		$pdf->grupo = $result[0]->grupo;
		$pdf->ciclo = $result[0]->ciclo;
		$pdf->matricula = $result[0]->matricula_interna;
		$pdf->profesor = $result[0]->profesor;
	
		//for ($d=0; $d<2; ++$d){ // Buble Idiomas	
		$a0 = 50;
		$a1 = 107;
		$a2 = 48;

	    $pdf->calumno = $d==0?'NOMBRE DEL ALUMNO':'STUDENT NAME';
	    $pdf->cgrupo = $d==0?'GRUPO':'GROUP';
	    $pdf->cfecha = $d==0?'FECHA':'DATE';
	    $pdf->cperiodo = $d==0?'PERÍODO':'PERIOD';
	    $pdf->cnum_lista = $d==0?'N° LISTA':'LIST';
	    $pdf->cmatricula = $d==0?'MATRÍCULA':'REGISTRATION';

		$pdf->headTitle = $d==0?'ESPAÑOL':'ENGLISH';
		$pdf->aspectos = $d==0?'A  S  P  E  C  T  O  S':'A  S  P  E  C  T  S';
	    $pdf->camposformativos = $d==0?'CAMPOS DE FORMACIÓN ACADEMICA':'FORMATIVE FIELDS';
		$pdf->evaluacion = $d==0?'EVALUACIÓN':'EVALUATION';
		// $pdf->inicial = $d==0?'I     N':'INITIAL';
		// $pdf->media = $d==0?'M     N':'MIDDLE';
		// $pdf->final = $d==0?'F     N':'FINAL';
		$pdf->inicial = $d==0?'INICIAL':'INITIAL';
		$pdf->media = $d==0?'MEDIA':'MIDDLE';
		$pdf->final = $d==0?'FINAL':'FINAL';
		$pdf->AddPage();

		$pdf->SetFont('Arial','B',8);

		// Encabezado Cuerpo
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(5, $y, $a0, 8, 2, '1', 'FD');
		$pdf->RoundedRect($a0+5, $y, $a1, 8, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, 4, 2, '2', 'FD');

		$pdf->setX(5);
		$pdf->Cell($a0,8,utf8_decode($pdf->headTitle),'',0,'C');
		$pdf->Cell($a1,8,utf8_decode($pdf->aspectos),'',0,'C');
		$pdf->Cell($a2,4,utf8_decode($pdf->evaluacion),'',1,'C');

		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(192);
		// $pdf->RoundedRect(5, $y, $a0, 4, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, 4, 2, '', 'FD');

		$pdf->setX(5);
		$pdf->SetFont('Courier','B',7);
		$pdf->SetFillColor(192);
		// $pdf->Cell($a0,4,utf8_decode($pdf->camposformativos),'LTRB',0,'C',true);
		$pdf->Cell($a0,4,'','',0,'C');
		$pdf->SetFont('Arial','B',8);
		$pdf->SetFillColor(255);
		$pdf->Cell($a1,8,utf8_decode(''),'',0,'C');
		$pdf->Cell(16,4,utf8_decode($pdf->inicial),'',0,'C');
		$pdf->Cell(16,4,utf8_decode($pdf->media),'LR',0,'C');
		$pdf->Cell(16,4,utf8_decode($pdf->final),'',1,'C');


		$al = 5.41;

		// AREA DE FORMACION

		$pdf->setX(5);
		$pdf->SetFillColor(220);
		$pdf->SetFont('Courier','B',7);
		$pdf->Cell(205,5.44444,utf8_decode('CAMPOS DE FORMACIÓN ACADEMICA'),'LTRB',1,'C',true);
		$pdf->SetFont('Arial','',8);
		$pdf->SetFillColor(255);


		//PRIMER BLOQUE
		$arrCal = $f->getQuerys(55,"idgrualu=".$result[0]->idgrualu."&idioma=".$d."&rango=110 and 119",0,0,0,array(),' order by orden_impresion asc ',1);		
		$cantRow = (count($arrCal)+1); 
		$alto = $cantRow * $al;
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(5, $y, $a0, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+5, $y, $a1, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, $alto, 2, '', 'FD');

		$pdf->SetFont('Arial','',8);

		for ($i=0; $i<$cantRow;$i++) {

			$pdf->setX(5);
			$pdf->Cell($a0,5.44444,utf8_decode(''),'',0,'L');

			if (isset($arrCal[$i]->materia)){
				$pdf->Cell($a1,5.44444,utf8_decode($arrCal[$i]->materia),'',0,'L');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal0,$d),'',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal1,$d),'LR',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal2,$d),'',1,'C');
			}else{
				$pdf->Cell($a1,5.44444,'','',0,'L');
				$pdf->Cell(16,5.44444,' ','L',0,'C');
				$pdf->Cell(16,5.44444,' ','LR',0,'C');
				$pdf->Cell(16,5.44444,' ','',1,'C');
			}

		}

		
		//SEGUNDO BLOQUE

		$arrCal = $f->getQuerys(55,"idgrualu=".$result[0]->idgrualu."&idioma=".$d."&rango=120 and 129",0,0,0,array(),' order by orden_impresion asc ',1);

		$cantRow = (count($arrCal)+2); 
		$alto = $cantRow * $al;
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(5, $y, $a0, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+5, $y, $a1, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, $alto, 2, '', 'FD');

		for ($i=0; $i<$cantRow;$i++) {
			$pdf->setX(5);
			$pdf->Cell($a0,5.44444,utf8_decode(''),'',0,'L');
			if (isset($arrCal[$i]->materia)){
				$pdf->Cell($a1,5.44444,utf8_decode($arrCal[$i]->materia),'',0,'L');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal0,$d),'',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal1,$d),'LR',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal2,$d),'',1,'C');
			}else{
				$pdf->Cell($a1,5.44444,'','',0,'L');
				$pdf->Cell(16,5.44444,'','',0,'C');
				$pdf->Cell(16,5.44444,'','LR',0,'C');
				$pdf->Cell(16,5.44444,'','',1,'C');
			}
		}

		
		//TERCER BLOQUE

		$arrCal = $f->getQuerys(55,"idgrualu=".$result[0]->idgrualu."&idioma=".$d."&rango=130 and 139",0,0,0,array(),' order by orden_impresion asc ',1);

		$cantRow = (count($arrCal)+2); 
		$alto = $cantRow * $al;
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(5, $y, $a0, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+5, $y, $a1, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, $alto, 2, '', 'FD');

		$pdf->SetFont('Arial','',8);

		for ($i=0; $i<$cantRow;$i++) {

			$pdf->setX(5);
			$pdf->Cell($a0,5.44444,utf8_decode(''),'',0,'L');

			if (isset($arrCal[$i]->materia)){
				$pdf->Cell($a1,5.44444,utf8_decode($arrCal[$i]->materia),'',0,'L');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal0,$d),'',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal1,$d),'LR',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal2,$d),'',1,'C');
			}else{
				$pdf->Cell($a1,5.44444,'','',0,'L');
				$pdf->Cell(16,5.44444,'','',0,'C');
				$pdf->Cell(16,5.44444,'','LR',0,'C');
				$pdf->Cell(16,5.44444,'','',1,'C');
			}

		}


		// AREA DE FORMACION

		$pdf->setX(5);
		$pdf->SetFillColor(220);
		$pdf->SetFont('Courier','B',7);
		$pdf->Cell(205,5.44444,utf8_decode('ÁREA DE DESARROLLO SOCIAL Y PERSONAL'),'LTRB',1,'C',true);
		$pdf->SetFont('Arial','',8);
		$pdf->SetFillColor(255);


		//CUARTO BLOQUE
		$arrCal = $f->getQuerys(55,"idgrualu=".$result[0]->idgrualu."&idioma=".$d."&rango=140 and 149",0,0,0,array(),' order by orden_impresion asc ',1);
		$cantRow = (count($arrCal)+1); 
		$alto = $cantRow * $al;
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(5, $y, $a0, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+5, $y, $a1, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, $alto, 2, '', 'FD');

		$pdf->SetFont('Arial','',8);

		for ($i=0; $i<$cantRow;$i++) {

			$pdf->setX(5);
			$pdf->Cell($a0,5.44444,utf8_decode(''),'',0,'L');
			if (isset($arrCal[$i]->materia)){
				$pdf->Cell($a1,5.44444,utf8_decode($arrCal[$i]->materia),'',0,'L');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal0,$d),'',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal1,$d),'LR',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal2,$d),'',1,'C');
			}else{
				$pdf->Cell($a1,5.44444,'','',0,'L');
				$pdf->Cell(16,5.44444,'','',0,'C');
				$pdf->Cell(16,5.44444,'','LR',0,'C');
				$pdf->Cell(16,5.44444,'','',1,'C');
			}

		}

		//QUINTO BLOQUE

		$arrCal = $f->getQuerys(55,"idgrualu=".$result[0]->idgrualu."&idioma=".$d."&rango=150 and 159",0,0,0,array(),' order by orden_impresion asc ',1);
		$cantRow = (count($arrCal)+2); 
		$alto = $cantRow * $al;
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(5, $y, $a0, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+5, $y, $a1, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, $alto, 2, '', 'FD');

		$pdf->SetFont('Arial','',8);

		for ($i=0; $i<$cantRow;$i++) {

			$pdf->setX(5);
			$pdf->Cell($a0,5.44444,utf8_decode(''),'',0,'L');

			if (isset($arrCal[$i]->materia)){
				$pdf->Cell($a1,5.44444,utf8_decode($arrCal[$i]->materia),'',0,'L');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal0,$d),'',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal1,$d),'LR',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal2,$d),'',1,'C');
			}else{
				$pdf->Cell($a1,5.44444,'','',0,'L');
				$pdf->Cell(16,5.44444,'','',0,'C');
				$pdf->Cell(16,5.44444,'','LR',0,'C');
				$pdf->Cell(16,5.44444,'','',1,'C');
			}

		}


		//SEXTO BLOQUE
		$arrCal = $f->getQuerys(55,"idgrualu=".$result[0]->idgrualu."&idioma=".$d."&rango=160 and 169",0,0,0,array(),' order by orden_impresion asc ',1);
		$cantRow = (count($arrCal)+1)+5; 
		$alto = $cantRow * $al;
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(5, $y, $a0, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+5, $y, $a1, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, $alto, 2, '', 'FD');

		$pdf->SetFont('Arial','',8);

		for ($i=0; $i<$cantRow;$i++) {

			$pdf->setX(5);
			$pdf->Cell($a0,5.44444,utf8_decode(''),'',0,'L');

			if (isset($arrCal[$i]->materia)){
				$pdf->Cell($a1,5.44444,utf8_decode($arrCal[$i]->materia),'',0,'L');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal0,$d),'',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal1,$d),'LR',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal2,$d),'',1,'C');
			}else{
				$pdf->Cell($a1,5.44444,'','',0,'L');
				$pdf->Cell(16,5.44444,'','',0,'C');
				$pdf->Cell(16,5.44444,'','LR',0,'C');
				$pdf->Cell(16,5.44444,'','',1,'C');
			}

		}


/*


		// AREA DE FORMACION

		$pdf->setX(5);
		$pdf->SetFillColor(220);
		$pdf->SetFont('Courier','B',7);
		$pdf->Cell(205,5.44444,utf8_decode('ÁMBITOS DE AUTONOMÍA CURRICULAR'),'LTRB',1,'C',true);
		$pdf->SetFont('Arial','',8);
		$pdf->SetFillColor(255);


		//SEPTIMO BLOQUE


		$arrCal = $f->getQuerys(55,"idgrualu=".$result[0]->idgrualu."&idioma=".$d."&rango=170 and 179",0,0,0,array(),' order by orden_impresion asc ',1);

		$cantRow = (count($arrCal)+2); 
		$alto = $cantRow * $al;
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(5, $y, $a0, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+5, $y, $a1, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, $alto, 2, '', 'FD');

		$pdf->SetFont('Arial','',8);

		for ($i=0; $i<$cantRow;$i++) {

			$pdf->setX(5);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell($a0,5.44444,utf8_decode(''),'',0,'L');

			if (isset($arrCal[$i]->materia)){
				$pdf->Cell($a1,5.44444,utf8_decode($arrCal[$i]->materia),'',0,'L');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal0,$d),'',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal1,$d),'LR',0,'C');
				$pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal2,$d),'',1,'C');
			}else{
				$pdf->Cell($a1,5.44444,'','',0,'L');
				$pdf->Cell(16,5.44444,'','',0,'C');
				$pdf->Cell(16,5.44444,'','LR',0,'C');
				$pdf->Cell(16,5.44444,'','',1,'C');
			}

		}

*/

		//INASISTENCIAS

		$arrCal = $f->getQuerys(200,"idgrualu=".$result[0]->idgrualu."&idioma=".$d."&rango=180 and 189",0,0,0,array(),' order by orden_impresion asc ',1);
		// $arrCal = $f->getQuerys(51,"idgrualu=".$result[0]->idgrualu."&idioma=".$d."&rango=18 and 34",0,0,0,array(),' order by orden_impresion asc ',1);

		$cantRow = (count($arrCal)); 
		$alto = $cantRow * $al;
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(5, $y, $a0, $alto, 2, '4', 'FD');
		$pdf->RoundedRect($a0+5, $y, $a1, $alto, 2, '', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, $alto, 2, '3', 'FD');

		$pdf->SetFont('Arial','',8);

		for ($i=0; $i<$cantRow;$i++) {

			$pdf->setX(5);
			$pdf->Cell($a0,5.44444,utf8_decode(''),'',0,'L');

			if (isset($arrCal[$i]->materia)){
				$pdf->Cell($a1,5.44444,utf8_decode($arrCal[$i]->materia),'',0,'L');

				// $pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal0,$d),'',0,'C');
				// $pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal1,$d),'LR',0,'C');
				// $pdf->Cell(16,5.44444,$pdf->FormatCal($arrCal[$i]->cal2,$d),'',1,'C');

				$ina0 = $arrCal[$i]->cal0 > 0 ? number_format($arrCal[$i]->cal0,0) : '';
				$ina1 = $arrCal[$i]->cal1 > 0 ? number_format($arrCal[$i]->cal1,0) : '';
				$ina2 = $arrCal[$i]->cal2 > 0 ? number_format($arrCal[$i]->cal2,0) : '';
				
				$pdf->Cell(16,5.44444,$ina0,'',0,'C');
				$pdf->Cell(16,5.44444,$ina1,'LR',0,'C');
				$pdf->Cell(16,5.44444,$ina2,'',1,'C');
			}else{
				$pdf->Cell($a1,5.44444,'','',0,'L');
				$pdf->Cell(16,5.44444,'','',0,'C');
				$pdf->Cell(16,5.44444,'','LR',0,'C');
				$pdf->Cell(16,5.44444,'','',1,'C');
			}

		}




		// BLOQUE FINAL
		$vP = array(63,95,117,144,170,201,228);
		// $vPArr = $f->getQuerys(54,"idgrualu=".$result[0]->idgrualu."&idioma=".$d,0,0,0,array(),'  ',1);
		$vPArr = $f->getQuerys(54,"idgrualu=".$result[0]->idgrualu."&idioma=".$d,0,0,0,array(),' order by orden_impresion asc ',1);
		foreach ($vPArr as $k => $value) {
			if ($k <= 6){
				$pdf->setX(5);
				$pdf->setY($vP[$k]);
				$pdf->SetFont('Courier','B',8);
				$pdf->MultiCell($a0, 4, utf8_decode($vPArr[$k]->materia), 0, 'L');
			}
		}


		$pdf->setX(5);
		$pdf->setY(248);

		// PERFIL IBO

		$obsss = $f->getQuerys(10002,$idobs,0,0,0,array()," ",1);
		if (count($obsss)>0){
			$pdf->obsEsp = $obsss[0]->observacion;
		}else{
			$pdf->obsEsp = "";
		}
		
		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(5, $y, $a0+$a1, 4, 2, '1', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, 4, 2, '2', 'FD');

		$pdf->setX(5);
		$pdf->Cell($a0+$a1,4,utf8_decode('PERFIL IB'),'',0,'L');
		$pdf->Cell($a2,4,utf8_decode('TITULAR'),'',1,'C');

		$pdf->setX(5);
		$y = $pdf->GetY();
		$pdf->SetFillColor(255);
		$pdf->SetFont('Arial','',8);	
		$pdf->RoundedRect(5, $y, $a0+$a1, 15, 2, '4', 'FD');
		$pdf->RoundedRect($a0+$a1+5, $y, $a2, 15, 2, '3', 'FD');

		$pdf->setX(5);
		// $pdf->Cell($a0+$a1,4,utf8_decode($pdf->obsEsp),'',0,'L');
		// $pdf->Cell($a2,4,utf8_decode($pdf->profesor),'',1,'L');

		$pdf->setX(150);
		$pdf->setY($y+1);
		$pdf->MultiCell($a0+$a1, 4, utf8_decode($pdf->obsEsp), 0, 'L');
		$pdf->setX(150);
		$pdf->setY($y+1);
		$pdf->Cell($a0+$a1,4,'','',0,'L');
		$pdf->MultiCell($a2, 4, utf8_decode($pdf->profesor), 0, 'L');

		// NOMENCLATURA

		$pdf->Ln(10);
		$pdf->setX(5);

		$pdf->SetFont('Arial','B',7);	
		// $pdf->Cell(12.5,6,utf8_decode('D - (N: IV)'),'',0,'L');
		$pdf->Cell(4,6,utf8_decode('D  '),'',0,'L');
		$pdf->SetFont('Arial','',7);	
		$pdf->Cell(24,6,utf8_decode('=  DESTACADO'),'',0,'L');

		$pdf->SetFont('Arial','B',7);	
		// $pdf->Cell(12,6,utf8_decode('L - (N: III)'),'',0,'L');
		$pdf->Cell(4,6,utf8_decode('L'),'',0,'L');
		$pdf->SetFont('Arial','',7);	
		$pdf->Cell(20,6,utf8_decode('=  LOGRADO'),'',0,'L');

		$pdf->SetFont('Arial','B',7);	
		// $pdf->Cell(13,6,utf8_decode('EP - (N: II)'),'',0,'L');
		$pdf->Cell(5,6,utf8_decode('EP  '),'',0,'L');
		$pdf->SetFont('Arial','',7);	
		$pdf->Cell(24,6,utf8_decode('=  EN PROCESO'),'',0,'L');

		// $pdf->SetFont('Arial','B',7);	
		// $pdf->Cell(10,6,utf8_decode('I - (N: I)'),'',0,'L');
		// $pdf->SetFont('Arial','',7);	
		// $pdf->Cell(24,6,utf8_decode('=  INICIADO'),'',0,'L');

		$pdf->SetFont('Arial','B',7);	
		$pdf->Cell(5,6,utf8_decode('I '),'',0,'L');
		$pdf->SetFont('Arial','',7);	
		$pdf->Cell(30,6,utf8_decode('=  INICIANDO'),'',1,'L');


	} // Fin Si

}



$pdf->Output();

?>