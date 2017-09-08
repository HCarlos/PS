<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('default_socket_timeout', 6000);
mb_internal_encoding('UTF-8');
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

// echo $c;

define('FPDF_FONTPATH','font/');
require('../diag/sector.php');

require_once('../oFunctions.php');
$Q = oFunctions::getInstance();

require_once('../oCentura.php');
$f = oCentura::getInstance();

require_once('../oCenturaPDO.php');
$F = oCenturaPDO::getInstance();

$idfamilia = $f->getIdFamFromIdUserAlu($iduseralu,1);

$cad = $c."&idfamilia=".$idfamilia;

$alu2 = $f->getQuerys(10,$idalumno);

$alu = $f->getQuerys(10025,$cad,0,0,0,array(),$s,1);


$fam = $f->getQuerys(10019, "u=".$u."&idalumno=".$idalumno);
$vivecon = $f->getQuerys(112, "u=".$u."&idpersona=".$fam[0]->vive_con);
$tutor = $f->getQuerys(112, "u=".$u."&idpersona=".$fam[0]->idtutor);

$madre = $f->getQuerys(111, "u=".$u."&idfamilia=".$fam[0]->idfamilia,0,0,0,array(),'madre');
$padre = $f->getQuerys(111, "u=".$u."&idfamilia=".$fam[0]->idfamilia,0,0,0,array(),'padre');

// echo "u=".$u."&idalumno=".$idalumno;

$med = $f->getQuerys(108, "u=".$u."&idalumno=".$idalumno,0,0,0,array(),'idmedalu');

$emer = $f->getQuerys(115,$c);


class PDF_Diag extends PDF_Sector {
	var $nFont;
	var $logoPreinscripcion;

    function Header(){  }

	function Footer(){  }

}


$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);

$pdf->AddPage();

$pdf->Ln(5);

$pdf->setX(30);

// /* *********************************************************
// ** ENCABEZADO
// ** ********************************************************* */

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(110,$pdf->nFont,utf8_decode("COLEGIO ARJÍ A.C."),'',0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(70,6,utf8_decode("K   A   R   D   E   X"),'LTRB',1,'C',true);

// echo $iduseralu;

// $idfamilia = $f->getIdFamFromIdUserAlu($iduseralu,1);

// $cad = $c."&idfamilia=".$idfamilia;

// echo $cad;

// $alu = $F->getQueryPDO(72,$cad,0,0,0,array(),$s,1);

if ( count($alu) > 0 ){


	$pdf->setY(5);
	$pdf->setX(0);
	$pdf->Image('../../../images/web/logo-arji.gif',5,5,25,25);
	$pdf->SetFont('ARIAL','',6);
	$pdf->Ln(20);
	$pdf->setX(5);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(205,4,utf8_decode('Página 1 de 2'),'',1,'R');

	$pdf->Ln(5);
	$pdf->setX(30);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22,$pdf->nFont,'','',0,'R');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(123,$pdf->nFont,'','',0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(15,$pdf->nFont,utf8_decode("FECHA:"),'',0,'R');
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(64);
	$pdf->Cell(20,$pdf->nFont,date('d-m-Y'),'',1,'R');

	// lINEA 1
	$pdf->SetFont('ARIAL','B',10);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(10);
	$pdf->setX(5);
	$pdf->Cell(205,4,'DATOS PERSONALES DEL ALUMNO(A)','',1,'C');
	$pdf->setX(5);
	$y = $pdf->GetY();
	$pdf->SetDrawColor(152,72,7);
	$pdf->RoundedRect(5, $y, 205, 54, 0, '1234');

	$pdf->SetFont('ARIAL','',8);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(40,4,'NOMBRE DEL ALUMNO(A)','',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(50,4,utf8_decode(mb_strtoupper($alu[0]->ap_paterno,'UTF-8')),'B',0,'C');
	$pdf->Cell(50,4,utf8_decode(mb_strtoupper($alu[0]->ap_materno,'UTF-8')),'B',0,'C');
	$pdf->Cell(50,4,utf8_decode(mb_strtoupper($alu[0]->nombre,'UTF-8')),'B',0,'C');
	$pdf->SetFont('ARIAL','',6);
	$pdf->Cell(09,4,$alu[0]->idalumno,'B',1,'R');

	$pdf->SetFont('ARIAL','',5);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(1);
	$pdf->setX(5);
	$pdf->Cell(40,2,'','',0,'L');
	$pdf->Cell(53,2,'APELLIDO PATERNO','',0,'C');
	$pdf->Cell(53,2,'APELLIDO MATERNO','',0,'C');
	$pdf->Cell(53,2,'NOMBRE(S)','',1,'C');


	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(2);
	$pdf->setX(5);
	$pdf->Cell(10,4,'CURP','',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(40,4,utf8_decode(mb_strtoupper($alu[0]->curp,'UTF-8')),'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(34,4,utf8_decode('GRADO QUE CURSA'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(49,4,utf8_decode(mb_strtoupper($alu[0]->grado.', '.$alu[0]->grupo,'UTF-8')),'B',0,'C');
	$pdf->Cell(6,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(25,4,utf8_decode('CICLO ESCOLAR'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(30,4,utf8_decode(mb_strtoupper($alu[0]->ciclo,'UTF-8')),'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(14,4,'HOMBRE','',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$lH = intval($alu[0]->genero)==1?'X':'';
	$lM = intval($alu[0]->genero)==0?'X':'';
	$pdf->Cell(5,4,$lH,'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(11,4,'MUJER','',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(5,4,$lM,'B',0,'C');
	$pdf->Cell(10,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(29,4,utf8_decode('FECHA DE INGRESO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(36,4,utf8_decode(mb_strtoupper($alu2[0]->cfecha_ingreso,'UTF-8')),'B',0,'C');
	$pdf->Cell(10,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(33,4,utf8_decode('EDAD AL 1° DE SEPT.'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);

	// $pdf->Cell(36,4,utf8_decode(mb_strtoupper($alu[0]->edad,'UTF-8')),'B',1,'C');
	$pdf->Cell(36,4,utf8_decode(mb_strtoupper($Q->getEdad1Sep($alu2[0]->fecha_nacimiento),'UTF-8')),'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(31,4,utf8_decode('LUGAR NACIMIENTO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(86,4,utf8_decode(mb_strtoupper($alu2[0]->lugar_nacimiento,'UTF-8')),'B',0,'C');
	$pdf->Cell(10,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(31,4,utf8_decode('FECHA NACIMIENTO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(36,4,utf8_decode(mb_strtoupper($alu2[0]->cfecha_nacimiento,'UTF-8')),'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(60,4,utf8_decode('ENFERMEDADES / REACIONES ALÉRGICAS'),'',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(70,4,utf8_decode(mb_strtoupper($alu2[0]->enfermedades.' / '.$alu2[0]->reacciones_alergicas,'UTF-8')),'B',0,'C');
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(23,4,utf8_decode('TIPO SANGRE'),'',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(36,4,utf8_decode(mb_strtoupper($alu2[0]->tipo_sangre,'UTF-8')),'B',1,'C');

	if ( count($med) > 0 ){
		if ( $med[0]->medico == "EMPTY EMPTY EMPTY" || $med[0]->medico == "EMPTY1 EMPTY EMPTY" ){
			$nommed0 = "";
		}else{
			$nommed0 = $med[0]->medico;
		}
		$telmed1 = $med[0]->tel1 == "empty" ? "" : $med[0]->tel1;
		$telmed2 = $med[0]->tel2 == "empty" ? "" : $med[0]->tel2;
	}else{
		$nommed0 = "";
		$telmed1 = "";
		$telmed2 = "";
	}

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(35,4,utf8_decode('PEDIATRA O DOCTOR'),'',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(70,4,utf8_decode(mb_strtoupper($nommed0,'UTF-8')),'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(20,4,utf8_decode('TELÉFONO'),'',0,'R');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(74,4,$telmed1.' '.$telmed2,'B',1,'L');



	// lINEA 2
	$pdf->SetFont('ARIAL','B',10);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(20);
	$pdf->setX(5);
	$pdf->Cell(205,4,'DATOS DE LA MADRE O TUTORA','',1,'C');
	$pdf->setX(5);
	$y = $pdf->GetY();
	$pdf->RoundedRect(5, $y, 205, 54, 0, '1234');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(35,4,utf8_decode('NOMBRE DE LA MADRE'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$nombreMama = count($madre) <= 0 ? '' : $madre[0]->nombre_persona;
	$pdf->Cell(102,4,utf8_decode(mb_strtoupper($nombreMama,'UTF-8')),'B',0,'C');
	$pdf->Cell(6,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(10,4,utf8_decode('CURP'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$curpMama = count($madre) <= 0 ? '' : $madre[0]->curp_persona;
	$idpersona = count($madre) <= 0 ? '' : $madre[0]->idpersona;
	$pdf->Cell(36,4,utf8_decode(mb_strtoupper($curpMama,'UTF-8')),'B',0,'C');
	$pdf->SetFont('ARIAL','',6);
	$pdf->Cell(05,4,$idpersona,'B',1,'R');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(35,4,utf8_decode('LUGAR DE NACIMIENTO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$lnMama = count($madre) <= 0 ? '' : $madre[0]->lugar_nacimiento_persona;
	$pdf->Cell(85,4,utf8_decode(mb_strtoupper($lnMama,'UTF-8')),'B',0,'C');
	$pdf->Cell(10,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(35,4,utf8_decode('FECHA DE NACIMIENTO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$fnMama = count($madre) <= 0 ? '' : $madre[0]->cfecha_nacimiento;
	$pdf->Cell(34,4,utf8_decode(mb_strtoupper($fnMama,'UTF-8')),'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(20,4,utf8_decode('OCUPACIÓN'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$ocupaMama = count($madre) <= 0 ? '' : $madre[0]->ocupacion;
	$pdf->Cell(81,4,utf8_decode(mb_strtoupper($ocupaMama,'UTF-8')),'B',0,'C');
	$pdf->Cell(10,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(31,4,utf8_decode('LUGAR DE TRABAJO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$ltMama = count($madre) <= 0 ? '' : $madre[0]->lugar_trabajo;
	$pdf->Cell(57,4,utf8_decode(mb_strtoupper($ltMama,'UTF-8')),'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(36,4,utf8_decode('DOMICILIO PARTICULAR'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->SetFont('ARIAL','',7);
	$dmpMama = count($madre) <= 0 ? '' : $madre[0]->domicilio_generico;
	$pdf->Cell(163,4,utf8_decode(mb_strtoupper($dmpMama,'UTF-8')),'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(30,4,utf8_decode('TELÉFONO DE CASA'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$tel1Mama = count($madre) <= 0 ? '' : $madre[0]->tel1;
	$pdf->Cell(44,4,$tel1Mama,'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(17,4,utf8_decode('CELULAR'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$cel1Mama = count($madre) <= 0 ? '' : $madre[0]->cel1;
	$cel2Mama = count($madre) <= 0 ? '' : $madre[0]->cel2;
	$pdf->Cell(41,4,$cel1Mama.' '.$cel2Mama,'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(16,4,utf8_decode('OFICINA'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$tel2Mama = count($madre) <= 0 ? '' : $madre[0]->tel2;
	$pdf->Cell(41,4,$tel2Mama,'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(13,4,utf8_decode('E-MAIL'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$email1Mama = count($madre) <= 0 ? '' : $madre[0]->email1;
	$email2Mama = count($madre) <= 0 ? '' : $madre[0]->email2;
	$pdf->Cell(186,4,utf8_decode($email1Mama.' '.$email2Mama),'B',1,'C');


	// lINEA 3
	$pdf->SetFont('ARIAL','B',10);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(22);
	$pdf->setX(5);
	$pdf->Cell(205,4,'DATOS DEL PADRE O TUTOR','',1,'C');
	$pdf->setX(5);
	$y = $pdf->GetY();
	$pdf->RoundedRect(5, $y, 205, 66, 0, '1234');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(35,4,utf8_decode('NOMBRE DEL PADRE'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$nombrePapa = count($padre) <= 0 ? '' : $padre[0]->nombre_persona;
	$pdf->Cell(102,4,utf8_decode(mb_strtoupper($nombrePapa,'UTF-8')),'B',0,'C');
	$pdf->Cell(6,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(10,4,utf8_decode('CURP'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$curpPapa = count($padre) <= 0 ? '' : $padre[0]->curp_persona;
	$idpersona = count($padre) <= 0 ? '' : $padre[0]->idpersona;
	$pdf->Cell(36,4,utf8_decode(mb_strtoupper($curpPapa,'UTF-8')),'B',0,'C');
	$pdf->SetFont('ARIAL','',6);
	$pdf->Cell(05,4,$idpersona,'B',1,'R');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(35,4,utf8_decode('LUGAR DE NACIMIENTO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$lnPapa = count($padre) <= 0 ? '' : $padre[0]->lugar_nacimiento_persona;
	$pdf->Cell(85,4,utf8_decode(mb_strtoupper($lnPapa,'UTF-8')),'B',0,'C');
	$pdf->Cell(10,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(35,4,utf8_decode('FECHA DE NACIMIENTO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$fnPapa = count($padre) <= 0 ? '' : $padre[0]->cfecha_nacimiento;
	$pdf->Cell(34,4,utf8_decode(mb_strtoupper($fnPapa,'UTF-8')),'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(20,4,utf8_decode('OCUPACIÓN'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$ocupaPapa = count($padre) <= 0 ? '' : $padre[0]->ocupacion;
	$pdf->Cell(81,4,utf8_decode(mb_strtoupper($ocupaPapa,'UTF-8')),'B',0,'C');
	$pdf->Cell(10,4,'','',0,'L');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(31,4,utf8_decode('LUGAR DE TRABAJO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$ltPapa = count($padre) <= 0 ? '' : $padre[0]->lugar_trabajo;
	$pdf->Cell(57,4,utf8_decode(mb_strtoupper($ltPapa,'UTF-8')),'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(36,4,utf8_decode('DOMICILIO PARTICULAR'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->SetFont('ARIAL','',7);
	$dmpPapa = count($padre) <= 0 ? '' : $padre[0]->domicilio_generico;
	$pdf->Cell(163,4,utf8_decode(mb_strtoupper($dmpPapa,'UTF-8')),'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(30,4,utf8_decode('TELÉFONO DE CASA'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$tel1Papa = count($padre) <= 0 ? '' : $padre[0]->tel1;
	$pdf->Cell(44,4,$tel1Papa,'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(17,4,utf8_decode('CELULAR'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$cel1Papa = count($padre) <= 0 ? '' : $padre[0]->cel1;
	$cel2Papa = count($padre) <= 0 ? '' : $padre[0]->cel2;
	$pdf->Cell(41,4,$cel1Papa.' '.$cel2Papa,'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(16,4,utf8_decode('OFICINA'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$tel2Papa = count($padre) <= 0 ? '' : $padre[0]->tel2;
	$pdf->Cell(41,4,$tel2Papa,'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(13,4,utf8_decode('E-MAIL'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$email1Papa = count($padre) <= 0 ? '' : $padre[0]->email1;
	$email2Papa = count($padre) <= 0 ? '' : $padre[0]->email2;
	$pdf->Cell(186,4,utf8_decode($email1Papa.' '.$email2Papa),'B',1,'C');


	$pdf->SetFont('ARIAL','',6);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(10);
	$pdf->setX(5);
	$pdf->Cell(205,4,utf8_decode('Página 2 de 2'),'',1,'R');


	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(10);
	$pdf->setX(5);
	$isMama = count($madre) <= 0 ? 0 : $madre[0]->idpersona;
	$isPapa = count($padre) <= 0 ? 0 : $padre[0]->idpersona;
	switch ( intval($alu[0]->idtutor) ) {
		case $isMama:
			$nombreMama = count($madre) <= 0 ? '' : $madre[0]->nombre_persona;
			$tut = "MADRE: ".utf8_decode(mb_strtoupper($nombreMama,'UTF-8'));
			break;
		case $isPapa:
			$nombrePapa = count($padre) <= 0 ? '' : $padre[0]->nombre_persona;
			$tut = "PADRE: ".utf8_decode(mb_strtoupper($nombrePapa,'UTF-8'));
			break;	
		default:
			$nombreTutor = count($tut) <= 0 ? '' : $tut[0]->nombre_persona;
			$parentTutor = count($tut) <= 0 ? '' : $tut[0]->parentezco;
			$tut = utf8_decode(strtoupper($parentTutor)).": ".utf8_decode(mb_strtoupper($nombreTutor,'UTF-8'));
			break;	
	}
	$pdf->Cell(30,4,utf8_decode('QUIEN ES EL TUTOR'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(169,4,$tut,'B',1,'C');


	if ( count($emer) > 1 ) {
		$nom0  = $emer[0]->nombre == "EMPTY1" ? "" : $emer[0]->nombre;
		$tel01 = $emer[0]->tel1 == "EMPTY1" ? "" : $emer[0]->tel1;
		$par0  = $emer[0]->parentezco == "EMPTY1" ? "" : $emer[0]->parentezco;

		$nom1  = $emer[1]->nombre == "EMPTY" || is_null($emer[1]->nombre) ? "" : $emer[1]->nombre;
		$tel11 = $emer[1]->tel1 == "EMPTY" || is_null($emer[1]->tel1) ? "" : $emer[1]->tel1;
		$par1  = $emer[1]->parentezco == "EMPTY" || is_null($emer[1]->parentezco) ? "" : $emer[1]->tel1;

	}else{

		$nom0 = "";
		$tel01 = "";
		$par0 = "";

		$nom1 = "";
		$tel11 = "";
		$par1 = "";

	}



	// lINEA 4

	$pdf->SetFont('ARIAL','B',10);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(10);
	$pdf->setX(5);
	$pdf->Cell(205,4,utf8_decode('TELÉFONOS DE EMERGENCIA'),'',1,'C');
	$pdf->setX(5);
	$y = $pdf->GetY();
	$pdf->RoundedRect(5, $y, 205, 230, 0, '1234');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(15,4,utf8_decode('NOMBRE'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(44,4,$nom0,'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(8,4,'','',0,'L');
	$pdf->Cell(18,4,utf8_decode('TELÉFONO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(41,4,$tel01,'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(9,4,'','',0,'L');
	$pdf->Cell(23,4,utf8_decode('PARENTESCO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(41,4,$par0,'B',1,'C');

	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(15,4,utf8_decode('NOMBRE'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(44,4,$nom1,'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(8,4,'','',0,'L');
	$pdf->Cell(18,4,utf8_decode('TELÉFONO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(41,4,$tel11,'B',0,'C');
	$pdf->SetFont('ARIAL','',8);
	$pdf->SetTextColor(152,72,7);
	$pdf->Cell(9,4,'','',0,'L');
	$pdf->Cell(23,4,utf8_decode('PARENTESCO'),'',0,'L');
	// $pdf->SetFont('ARIAL','B',8);
	$pdf->SetTextColor(64);
	$pdf->Cell(41,4,$par1,'B',1,'C');

	$pdf->SetFont('ARIAL','',6);
	$pdf->SetTextColor(152,72,7);
	$pdf->Ln(4);
	$pdf->setX(5);
	$pdf->Cell(205,2,'Aviso de Privacidad: http://www.arji.edu.mx/privacy.html','',1,'L');

	// Línea 17 = FINALLY
	$pdf->setY(205);
	$pdf->Ln(1);
	$pdf->setX(5);
	// $pdf->SetTextColor(64);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(205, 5, utf8_decode(mb_strtoupper("DOY MI AUTORIZACIÓN PARA QUE EN CASO DE EMERGENCIA Y EN CASO DE NO ENCONTRARLOS EN LOS TELÉFONOS CITADOS, NI A LAS PERSONAS QUE AUTORIZAMOS PARA CASOS DE EMERGENCIA, LA ESCUELA PROCEDA SEGÚN SEA CONVENIENTE, PARA QUE MI HIJO(A) SEA ATENDIDO(A).", 'UTF-8') ) );

	$pdf->setY(222);
	$pdf->Ln(1);
	$pdf->setX(5);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(205, 5, utf8_decode(mb_strtoupper("CONSCIENTE DE LOS OBJETIVOS Y MÉTODOS DEL COLEGIO ARJÍ, FIRMO COMO CORRESPONSABLE Y FACTOR DETERMINANTE EN EL LOGRO DE LOS MISMOS.", 'UTF-8') ) );

	$pdf->setY(248);
	$pdf->setX(5);
	$pdf->Ln(1);
	$pdf->SetFont('Courier','B',10);
	$pdf->Cell(80,6,'_________________________________________','',0,'C');
	$pdf->Cell(35,6,'','',0,'C');
	$pdf->Cell(80,6,'_________________________________________','',1,'C');

	$pdf->setY(252);
	$pdf->setX(5);
	$pdf->Ln(1);
	$pdf->SetFont('Courier','B',10);
	$pdf->Cell(80,6,'FIRMA DEL PADRE O TUTOR','',0,'C');
	$pdf->Cell(35,6,'','',0,'C');
	$pdf->Cell(80,6,'FIRMA DE LA MADRE','',1,'C');

}else{

	$pdf->setX(5);
	$pdf->Ln(4);
	$pdf->Cell(5,4,'','',0,'L');
	$pdf->Cell(100,4,utf8_decode('NO SE ENCONTRÓ EL ALUMNO(A) INSCRITO EN ESTE CICLO'),'',0,'L');

}

$pdf->Output();

?>