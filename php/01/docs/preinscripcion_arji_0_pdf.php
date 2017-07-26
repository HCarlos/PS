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

define('FPDF_FONTPATH','font/');
require('../diag/sector.php');
require('../oCenturaPDO.php');
$f = oCenturaPDO::getInstance();

class PDF_Diag extends PDF_Sector {
	var $nFont;
	var $logoPreinscripcion;

    function Header(){  }

	function Footer(){  }

}

$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(TRUE, 0.1);
$pdf->SetLeftMargin(0);
$pdf->nFont = 6;
$pdf->SetFillColor(152,72,7);
$pdf->logoPreinscripcion = $logoPreinscripcion;

$Alu = $f->getQueryPDO($t,$c,0,0,0,array(),$s,1);

$pdf->AddPage();

$pdf->setY(5);
$pdf->setX(0);
$pdf->Image('../../../images/web/'.$pdf->logoPreinscripcion,5,2,205,35);
$pdf->SetFont('ARIAL','',6);
$pdf->Ln(30);
$pdf->setX(5);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(205,4,utf8_decode('Página 1 de 2'),'',1,'R');

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
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(53,4,utf8_decode(mb_strtoupper($Alu[0]->ap_paterno_alumno,'UTF-8')),'B',0,'C');
$pdf->Cell(53,4,utf8_decode(mb_strtoupper($Alu[0]->ap_materno_alumno,'UTF-8')),'B',0,'C');
$pdf->Cell(53,4,utf8_decode(mb_strtoupper($Alu[0]->nombre_alumno,'UTF-8')),'B',1,'C');

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
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(40,4,utf8_decode(mb_strtoupper($Alu[0]->curp_alumno,'UTF-8')),'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(34,4,utf8_decode('GRADO QUE CURSARÁ'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(49,4,utf8_decode(mb_strtoupper($Alu[0]->grado_cursara,'UTF-8')),'B',0,'C');
$pdf->Cell(6,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(25,4,utf8_decode('CICLO ESCOLAR'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(30,4,utf8_decode(mb_strtoupper($Alu[0]->ciclo_escolar,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Ln(4);
$pdf->setX(5);
$pdf->Cell(14,4,'HOMBRE','',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$lH = intval($Alu[0]->genero_alumno)==1?'X':'';
$lM = intval($Alu[0]->genero_alumno)==0?'X':'';
$pdf->Cell(5,4,$lH,'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(11,4,'MUJER','',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(5,4,$lM,'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(29,4,utf8_decode('FECHA DE INGRESO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(36,4,utf8_decode(mb_strtoupper($Alu[0]->fecha_ingreso,'UTF-8')),'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(33,4,utf8_decode('EDAD AL 1° DE SEPT.'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(36,4,utf8_decode(mb_strtoupper($Alu[0]->edad_septiembre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(31,4,utf8_decode('LUGAR NACIMIENTO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(86,4,utf8_decode(mb_strtoupper($Alu[0]->lugar_nacimiento_alumno,'UTF-8')),'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(31,4,utf8_decode('FECHA NACIMIENTO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(36,4,utf8_decode(mb_strtoupper($Alu[0]->fecha_nacimiento_alumno,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(60,4,utf8_decode('ENFERMEDADES / REACIONES ALÉRGICAS'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(70,4,utf8_decode(mb_strtoupper($Alu[0]->enfermedades.' / '.$Alu[0]->reacciones_alergicas,'UTF-8')),'B',0,'C');
$pdf->Cell(5,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(23,4,utf8_decode('TIPO SANGRE'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(36,4,utf8_decode(mb_strtoupper($Alu[0]->tipo_sangre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(32,4,utf8_decode('PEDIATRA O DOCTOR'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(100,4,utf8_decode(mb_strtoupper($Alu[0]->app_medico.' '.$Alu[0]->apm_medico.' '.$Alu[0]->nombre_medico,'UTF-8')),'B',0,'C');
$pdf->Cell(6,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(20,4,utf8_decode('TELÉFONO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(36,4,$Alu[0]->telefono_medico,'B',1,'C');



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
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(35,4,utf8_decode('NOMBRE DE LA MADRE'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(102,4,utf8_decode(mb_strtoupper($Alu[0]->ap_paterno_madre.' '.$Alu[0]->ap_materno_madre.' '.$Alu[0]->nombre_madre,'UTF-8')),'B',0,'C');
$pdf->Cell(6,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(10,4,utf8_decode('CURP'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,utf8_decode(mb_strtoupper($Alu[0]->curp_madre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(35,4,utf8_decode('LUGAR DE NACIMIENTO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(85,4,utf8_decode(mb_strtoupper($Alu[0]->lugar_nacimiento_madre,'UTF-8')),'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(35,4,utf8_decode('FECHA DE NACIMIENTO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(34,4,utf8_decode(mb_strtoupper($Alu[0]->fecha_nacimiento_madre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(20,4,utf8_decode('OCUPACIÓN'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(81,4,utf8_decode(mb_strtoupper($Alu[0]->ocupacion_madre,'UTF-8')),'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(31,4,utf8_decode('LUGAR DE TRABAJO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(57,4,utf8_decode(mb_strtoupper($Alu[0]->lugar_trabajo_madre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(36,4,utf8_decode('DOMICILIO PARTICULAR'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(163,4,utf8_decode(mb_strtoupper($Alu[0]->domicilio_madre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(30,4,utf8_decode('TELÉFONO DE CASA'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(44,4,$Alu[0]->telefono_casa_madre,'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(17,4,utf8_decode('CELULAR'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,$Alu[0]->telefono_celular_madre,'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(16,4,utf8_decode('OFICINA'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,$Alu[0]->telefono_oficina_madre,'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(13,4,utf8_decode('E-MAIL'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(186,4,utf8_decode($Alu[0]->email_madre),'B',1,'C');


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
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(35,4,utf8_decode('NOMBRE DEL PADRE'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(102,4,utf8_decode(mb_strtoupper($Alu[0]->ap_paterno_padre.' '.$Alu[0]->ap_materno_padre.' '.$Alu[0]->nombre_padre,'UTF-8')),'B',0,'C');
$pdf->Cell(6,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(10,4,utf8_decode('CURP'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,utf8_decode(mb_strtoupper($Alu[0]->curp_padre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(35,4,utf8_decode('LUGAR DE NACIMIENTO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(85,4,utf8_decode(mb_strtoupper($Alu[0]->lugar_nacimiento_padre,'UTF-8')),'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(35,4,utf8_decode('FECHA DE NACIMIENTO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(34,4,utf8_decode(mb_strtoupper($Alu[0]->fecha_nacimiento_padre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(20,4,utf8_decode('OCUPACIÓN'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(81,4,utf8_decode(mb_strtoupper($Alu[0]->ocupacion_padre,'UTF-8')),'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(31,4,utf8_decode('LUGAR DE TRABAJO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(57,4,utf8_decode(mb_strtoupper($Alu[0]->lugar_trabajo_padre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(36,4,utf8_decode('DOMICILIO PARTICULAR'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(163,4,utf8_decode(mb_strtoupper($Alu[0]->domicilio_padre,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(30,4,utf8_decode('TELÉFONO DE CASA'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(44,4,$Alu[0]->telefono_casa_padre,'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(17,4,utf8_decode('CELULAR'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,$Alu[0]->telefono_celular_padre,'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(16,4,utf8_decode('OFICINA'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,$Alu[0]->telefono_oficina_padre,'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(13,4,utf8_decode('E-MAIL'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(186,4,utf8_decode($Alu[0]->email_padre),'B',1,'C');


$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(8);
$pdf->Cell(5,4,'','',0,'L');
switch ( intval($Alu[0]->quien_es_tutor) ) {
	case 0:
		$tut = "MADRE: ".utf8_decode(mb_strtoupper($Alu[0]->ap_paterno_madre.' '.$Alu[0]->ap_materno_madre.' '.$Alu[0]->nombre_madre,'UTF-8'));
		break;
	case 1:
		$tut = "PADRE: ".utf8_decode(mb_strtoupper($Alu[0]->ap_paterno_padre.' '.$Alu[0]->ap_materno_padre.' '.$Alu[0]->nombre_padre,'UTF-8'));
		break;	
	default:
		$tut = utf8_decode(strtoupper($Alu[0]->parentezco_otro_tutor)).": ".utf8_decode(mb_strtoupper($Alu[0]->nombre_otro_tutor.' '.$Alu[0]->telefono_otro_tutor,'UTF-8'));
		break;	
}
$pdf->Cell(30,4,utf8_decode('QUIEN ES EL TUTOR'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(169,4,$tut,'B',1,'C');





// lINEA 4
$pdf->SetFont('ARIAL','',6);
$pdf->SetTextColor(152,72,7);
$pdf->Ln(22);
$pdf->setX(5);
$pdf->Cell(205,4,utf8_decode('Página 2 de 2'),'',1,'R');

$pdf->SetFont('ARIAL','B',10);
$pdf->SetTextColor(152,72,7);
$pdf->Ln(5);
$pdf->setX(5);
$pdf->Cell(205,4,utf8_decode('TELÉFONOS DE EMERGENCIA'),'',1,'C');
$pdf->setX(5);
$y = $pdf->GetY();
$pdf->RoundedRect(5, $y, 205, 100, 0, '1234');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(15,4,utf8_decode('NOMBRE'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(44,4,$Alu[0]->nombre_emergencia,'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(8,4,'','',0,'L');
$pdf->Cell(18,4,utf8_decode('TELÉFONO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,$Alu[0]->tel_emergencia,'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(9,4,'','',0,'L');
$pdf->Cell(23,4,utf8_decode('PARENTESCO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,$Alu[0]->parentezco_emergencia,'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(15,4,utf8_decode('NOMBRE'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(44,4,$Alu[0]->nombre_emergencia1,'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(8,4,'','',0,'L');
$pdf->Cell(18,4,utf8_decode('TELÉFONO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,$Alu[0]->tel_emergencia1,'B',0,'C');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(9,4,'','',0,'L');
$pdf->Cell(23,4,utf8_decode('PARENTESCO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(41,4,$Alu[0]->parentezco_emergencia1,'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(8);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(43,4,utf8_decode('COLEGIO DEL QUE PROCEDE'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(156,4,$Alu[0]->colegio_procede,'B',1,'C');

$bNo = intval($Alu[0]->bilingue) == 0 ? 'X':'';
$bSi = intval($Alu[0]->bilingue) == 1 ? 'X':'';
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(30,4,utf8_decode('BILINGÜE'),'',0,'L');
$pdf->Cell(8,4,utf8_decode('SI'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bSi,'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetTextColor(152,72,7);
$pdf->SetFont('ARIAL','',8);
$pdf->Cell(8,4,utf8_decode('NO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bNo,'B',0,'C');
$pdf->Cell(18,4,'','',0,'L');
$pdf->SetTextColor(152,72,7);
$pdf->SetFont('ARIAL','',8);
$pdf->Cell(20,4,utf8_decode('2DO IDIOMA'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(85,4,utf8_decode(mb_strtoupper($Alu[0]->idioma_2,'UTF-8')),'B',1,'C');

$bNo = intval($Alu[0]->tiene_hermanos) == 0 ? 'X':'';
$bSi = intval($Alu[0]->tiene_hermanos) == 1 ? 'X':'';
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(8);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(70,4,utf8_decode('¿TIENE HERMANOS EN ESTA ESCUELA?'),'',0,'L');
$pdf->Cell(8,4,utf8_decode('SI'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bSi,'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetTextColor(152,72,7);
$pdf->SetFont('ARIAL','',8);
$pdf->Cell(16,4,utf8_decode('GRADOS'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(56,4,utf8_decode(mb_strtoupper($Alu[0]->grado_hermanos,'UTF-8')),'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetTextColor(152,72,7);
$pdf->SetFont('ARIAL','',8);
$pdf->Cell(8,4,utf8_decode('NO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bNo,'B',1,'C');

$bNo = intval($Alu[0]->tuvo_hermanos) == 0 ? 'X':'';
$bSi = intval($Alu[0]->tuvo_hermanos) == 1 ? 'X':'';
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(70,4,utf8_decode('¿TUVO HERMANOS EN AÑOS ANTERIORES?'),'',0,'L');
$pdf->Cell(8,4,utf8_decode('SI'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bSi,'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetTextColor(152,72,7);
$pdf->SetFont('ARIAL','',8);
$pdf->Cell(27,4,utf8_decode('CICLO ESCOLAR'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(45,4,utf8_decode(mb_strtoupper($Alu[0]->ciclo_hermanos,'UTF-8')),'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetTextColor(152,72,7);
$pdf->SetFont('ARIAL','',8);
$pdf->Cell(8,4,utf8_decode('NO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bNo,'B',1,'C');

$bNo = intval($Alu[0]->hijo_exalumno) == 0 ? 'X':'';
$bSi = intval($Alu[0]->hijo_exalumno) == 1 ? 'X':'';
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(70,4,utf8_decode('¿ES HIJO DE EXALUMNO?'),'',0,'L');
$pdf->Cell(8,4,utf8_decode('SI'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bSi,'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetTextColor(152,72,7);
$pdf->SetFont('ARIAL','',8);
$pdf->Cell(8,4,utf8_decode('NO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bNo,'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(40,4,utf8_decode('¿QUIÉN LO RECOMIENDA?'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(159,4,$Alu[0]->quien_recomienda,'B',1,'C');

$bNo = intval($Alu[0]->recomienda_hijos) == 0 ? 'X':'';
$bSi = intval($Alu[0]->recomienda_hijos) == 1 ? 'X':'';
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(98,4,utf8_decode('LA PERSONA QUE RECOMIENDA, ¿TIENE HIJOS EN EL COLEGIO?'),'',0,'L');
$pdf->Cell(8,4,utf8_decode('SI'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bSi,'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetTextColor(152,72,7);
$pdf->SetFont('ARIAL','',8);
$pdf->Cell(8,4,utf8_decode('NO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(10,4,$bNo,'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(98,4,utf8_decode('¿POR QUÉ ELIGIÓ ESTE COLEGIO?'),'',1,'L');

$y = $pdf->GetY();
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
	
$pdf->Ln(1);
$pdf->setY($y-4);
$pdf->setX(56);
$pdf->MultiCell(149, 4, utf8_decode(mb_strtoupper($Alu[0]->porque_eligio,'UTF-8')),'', 'J');

// LINEA 5
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setY(120);
$pdf->setX(5);
$pdf->Ln(15);
$pdf->Cell(215,4,"FECHA __________________________________",'',1,'C');

// LINEA 6
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(40);
$pdf->Cell(80,4,'','',0,'L');
$pdf->Cell(60,4,"FIRMA DEL PADRE O TUTOR",'T',0,'C');
$pdf->Cell(70,4,'','',1,'L');

// lINEA 7

$pdf->setY(190);
$pdf->setX(5);

$pdf->SetFont('ARIAL','B',10);
$pdf->SetTextColor(152,72,7);
$pdf->Ln(20);
$pdf->Cell(205,4,utf8_decode('DATOS FISCALES'),'',1,'C');
$pdf->setX(5);
$y = $pdf->GetY();
$pdf->RoundedRect(5, $y, 205, 49, 0, '1234');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(40,4,utf8_decode('NOMBRE O RAZÓN SOCIAL'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(160,4,$Alu[0]->razon_social_fiscal,'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(10,4,utf8_decode('RFC'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(85,4,$Alu[0]->rfc_fiscal,'B',0,'C');
$pdf->Cell(9,4,'','',0,'L');
$pdf->Cell(11,4,utf8_decode('CURP'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(85,4,$Alu[0]->curp_fiscal,'B',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->Ln(4);
$pdf->setX(5);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(29,4,'DOMICILIO FISCAL','',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(103,4,utf8_decode(mb_strtoupper($Alu[0]->calle_fiscal,'UTF-8')),'B',0,'C');
$pdf->Cell(34,4,utf8_decode(mb_strtoupper($Alu[0]->num_ext_fiscal,'UTF-8')),'B',0,'C');
$pdf->Cell(34,4,utf8_decode(mb_strtoupper($Alu[0]->num_int_fiscal,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',5);
$pdf->SetTextColor(152,72,7);
$pdf->Ln(1);
$pdf->setX(5);
$pdf->Cell(29,2,'','',0,'L');
$pdf->Cell(103,2,'CALLE','',0,'C');
$pdf->Cell(34,2,'NÚM. EXT.','',0,'C');
$pdf->Cell(34,2,'NÚM. INT.','',1,'C');


$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Ln(4);
$pdf->setX(5);
$pdf->Cell(2,4,'','',0,'L');
$pdf->Cell(85,4,utf8_decode(mb_strtoupper($Alu[0]->colonia_fiscal,'UTF-8')),'B',0,'C');
$pdf->Cell(50,4,utf8_decode(mb_strtoupper($Alu[0]->localidad_fiscal,'UTF-8')),'B',0,'C');
$pdf->Cell(21,4,utf8_decode(mb_strtoupper($Alu[0]->estado_fiscal,'UTF-8')),'B',0,'C');
$pdf->Cell(21,4,utf8_decode(mb_strtoupper($Alu[0]->pais_fiscal,'UTF-8')),'B',0,'C');
$pdf->Cell(21,4,utf8_decode(mb_strtoupper($Alu[0]->cp_fiscal,'UTF-8')),'B',1,'C');

$pdf->SetFont('ARIAL','',5);
$pdf->SetTextColor(152,72,7);
$pdf->Ln(1);
$pdf->setX(5);
$pdf->Cell(2,2,'','',0,'L');
$pdf->Cell(85,2,'COLONIA','',0,'C');
$pdf->Cell(50,2,'LOCALIDAD','',0,'C');
$pdf->Cell(21,2,'ESTADO','',0,'C');
$pdf->Cell(21,2,'MÉXICO','',0,'C');
$pdf->Cell(21,2,'C.P.','',1,'C');

$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->setX(5);
$pdf->Ln(4);
$pdf->Cell(5,4,'','',0,'L');
$pdf->Cell(19,4,utf8_decode('TELÉFONO'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(50,4,$Alu[0]->tel1_fiscal,'B',0,'C');
$pdf->Cell(10,4,'','',0,'L');
$pdf->SetFont('ARIAL','',8);
$pdf->SetTextColor(152,72,7);
$pdf->Cell(25,4,utf8_decode('E-MAIL FISCAL'),'',0,'L');
$pdf->SetFont('ARIAL','B',8);
$pdf->SetTextColor(64);
$pdf->Cell(96,4,utf8_decode($Alu[0]->email1_fiscal),'B',1,'C');

$pdf->SetFont('ARIAL','',6);
$pdf->SetTextColor(152,72,7);
$pdf->Ln(4);
$pdf->setX(5);
$pdf->Cell(205,2,'Aviso de Privacidad: http://www.arji.edu.mx/privacy.html','',1,'L');


$pdf->Output();

?>