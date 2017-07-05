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
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();
require_once('../oCentura.php');
$F = oCentura::getInstance();
$alu = $F->getQuerys(10, $idalumno);
$fam = $F->getQuerys(10019, "u=".$u."&idalumno=".$idalumno);
$vivecon = $F->getQuerys(112, "u=".$u."&idpersona=".$fam[0]->vive_con);
$tutor = $F->getQuerys(112, "u=".$u."&idpersona=".$fam[0]->idtutor);

$madre = $F->getQuerys(111, "u=".$u."&idfamilia=".$fam[0]->idfamilia,0,0,0,array(),'madre');
//$padre = $F->getQuerys(111, "u=".$u."&idfamilia=".$fam[0]->idfamilia,0,0,0,array(),'padre');

// echo "u=".$u."&idalumno=".$idalumno;

$med = $F->getQuerys(108, "u=".$u."&idalumno=".$idalumno,0,0,0,array(),'idmedalu');

//echo count($med);

//$med = array(); //$F->getQuerys(108, "u=".$u."&idalumno=".$idalumno);

class PDF_Diag extends PDF_Sector {
	var $nFont;

    function Header(){ }
	
	function Footer(){ }
    
}

// require('../oFunctions.php');
// $F = oFunctions::getInstance();


$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->nFont = 6;
$pdf->SetFillColor(192,192,192);

$pdf->AddPage();

$pdf->Image('../../../images/web/logo-arji.gif',5,5,25,25);
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

$pdf->Ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(22,$pdf->nFont,'','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(123,$pdf->nFont,'','',0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,$pdf->nFont,utf8_decode("FECHA:"),'',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,$pdf->nFont,date('d-m-Y'),'',1,'R');
 
$pdf->RoundedRect(5, 35, 205, 8, 2, '', '');

// Línea 1 = NOMBRE DEL ALUMNO
$pdf->setY(35);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,'NOMBRE DEL ALUMNO : ','',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(130,6,utf8_decode($alu[0]->nombre_alumno),'',0,'L');
$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,6,$alu[0]->idalumno,'',1,'R');

// Línea 2 = DATOS PERSONALES
$pdf->setY(45);
$pdf->Ln(1);
$pdf->setX(5);
$pdf->SetFont('Times','',12);
$pdf->Cell(44,6,'DATOS PERSONALES','',1,'L');

$pdf->RoundedRect(5, 54, 205, 29, 2, '', '');

// Línea 3 = FECHA DE NACIMIENTO
$pdf->setY(55);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,'FECHA DE NACIMIENTO : ','',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,6,utf8_decode($alu[0]->cfecha_nacimiento),'',1,'L');

// Línea 4 = FECHA DE INGRESO
$pdf->setY(60);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,'FECHA DE INGRESO : ','',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,6,utf8_decode($alu[0]->cfecha_ingreso),'',1,'L');

// Línea 5 = DOMICILIO
$pdf->setY(65);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,'DOMICILIO : ','',0,'R');
$pdf->SetFont('Arial','',8);

$pdf->setY(67);
$pdf->setX(60);
$domgen = count($tutor)>0 ? $tutor[0]->domicilio_generico:'';
$pdf->MultiCell(150, 5, utf8_decode(mb_strtoupper($domgen, 'UTF-8') ) );
// Línea 6 = Telefonos
$pdf->setY(75);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('TELÉFONOS : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$tel1 = count($tutor)>0 ? $tutor[0]->tel1:'';
$tel2 = count($tutor)>0 ? $tutor[0]->tel2:'';
$pdf->Cell(155,6,$tel1.', '.$tel2,'',1,'L');

// Línea 7 = PADRE O TUTOR
$pdf->setY(85);
$pdf->Ln(1);
$pdf->setX(5);
$pdf->SetFont('Times','',12);
$pdf->Cell(44,6,'PADRE O TUTOR','',1,'L');

$pdf->RoundedRect(5, 94, 205, 24, 2, '', '');

// Línea 8 = PADRE O TUTOR
$pdf->setY(95);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,'PADRE O TUTOR : ','',0,'R');
$pdf->SetFont('Arial','',9);
$nombre_persona = count($tutor)>0 ? $tutor[0]->nombre_persona:'';
$pdf->Cell(155,6,utf8_decode(mb_strtoupper($nombre_persona, 'UTF-8')),'',1,'L');

// Línea 9 = OCUPACION
$pdf->setY(100);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('OCUPACIÓN : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$ocupacion = count($tutor)>0 ? $tutor[0]->ocupacion:'';
$pdf->Cell(155,6,utf8_decode(mb_strtoupper($ocupacion, 'UTF-8')),'',1,'L');

// Línea 10 = LUGAR DE TRABAJO
$pdf->setY(105);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,'LUGAR DE TRABAJO : ','',0,'R');
$pdf->SetFont('Arial','',9);
$lugar_trabajo = count($tutor)>0 ? $tutor[0]->lugar_trabajo:'';
$pdf->Cell(155,6,utf8_decode(mb_strtoupper($lugar_trabajo, 'UTF-8')),'',1,'L');

// Línea 11 = TELEFONO
$pdf->setY(110);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('TELÉFONOS : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,6,$tel1.', '.$tel2,'',1,'L');






// Línea 12 = madre
$pdf->setY(120);
$pdf->Ln(1);
$pdf->setX(5);
$pdf->SetFont('Times','',12);
$pdf->Cell(44,6,'MADRE','',1,'L');

$pdf->RoundedRect(5, 129, 205, 24, 2, '', '');

// Línea 13 = MADRE
$pdf->setY(130);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,'MADRE : ','',0,'R');
$pdf->SetFont('Arial','',9);
$nombre_persona = count($madre)>0 ? $madre[0]->nombre_persona:'';
$pdf->Cell(155,6,utf8_decode($madre[0]->nombre_persona),'',1,'L');

// Línea 14 = OCUPACION
$pdf->setY(135);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('OCUPACIÓN : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$ocupacion = count($madre)>0 ? $madre[0]->ocupacion:'';
$pdf->Cell(155,6,utf8_decode($ocupacion),'',1,'L');

// Línea 15 = LUGAR DE TRABAJO
$pdf->setY(140);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,'LUGAR DE TRABAJO : ','',0,'R');
$pdf->SetFont('Arial','',9);
$lugar_trabajo = count($madre)>0 ? $madre[0]->lugar_trabajo:'';
$pdf->Cell(155,6,utf8_decode($lugar_trabajo),'',1,'L');

// Línea 16 = TELEFONO
$pdf->setY(145);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('TELÉFONOS : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$tel1 = count($madre)>0 ? $madre[0]->tel1:'';
$tel2 = count($madre)>0 ? $madre[0]->tel2:'';
$pdf->Cell(155,6,$tel1.', '.$tel2,'',1,'L');








// Línea 17 = Casos de Emergencia
$pdf->setY(155);
$pdf->Ln(1);
$pdf->setX(5);
$pdf->SetFont('Times','',12);
$pdf->Cell(100,6,utf8_decode('INFORMACIÓN PARA LOS CASOS DE EMERGENCIA'),'',1,'L');

$pdf->RoundedRect(5, 164, 205, 40, 2, '', '');

// Línea 18 = TELEFONOS 1
$pdf->setY(165);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('TELÉFONOS : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$tel1 = count($med)>0 ? $med[0]->tel1:'';
$tel2 = count($med)>0 ? $med[0]->tel2:'';
$pdf->Cell(25,6,$tel1.', '.$tel2,'',0,'L');
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('CON : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$medico = count($med)>0 ? $med[0]->medico:'';
$pdf->Cell(75,6,utf8_decode($medico),'',1,'L');

// Línea 19 = TELEFONOS 2
$pdf->setY(170);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('TELÉFONOS : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$tel1 = count($med)>1 ? $med[1]->tel1:'';
$tel2 = count($med)>1 ? $med[1]->tel2:'';
$pdf->Cell(25,6,$tel1.', '.$tel2,'',0,'L');
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('CON : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$medico = count($med)>1 ? $med[1]->medico:'';
$pdf->Cell(75,6,utf8_decode($medico),'',1,'L');

// Línea 20 = pediatra 1
/*
$pdf->setY(175);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('PEDIATRA : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,utf8_decode('PEDIATRA'),'',0,'L');
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('TEL. CONSULTORIO : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,utf8_decode('TEL. CONSULTORIO'),'',1,'L');

// Línea 21 = pediatra 2
$pdf->setY(180);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode(''),'',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,utf8_decode(''),'',0,'L');
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('TEL. CASA : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,utf8_decode('TEL. CASA'),'',1,'L');
*/

// Línea 22 = ENFERMEDADES
$pdf->setY(185);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('ENFERMEDADES : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,6,utf8_decode($alu[0]->enfermedades),'',1,'L');

// Línea 23 = ALERGIAS
$pdf->setY(190);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('REACIONES ALÉRGICAS : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,6,utf8_decode($alu[0]->reacciones_alergicas),'',1,'L');

// Línea 24 = TIPO SANGRE
$pdf->setY(195);
$pdf->setX(5);
$pdf->Ln(1);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(50,6,utf8_decode('TIPO DE SANGRE : '),'',0,'R');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,6,utf8_decode($alu[0]->tipo_sangre),'',1,'L');









// Línea 17 = FINALLY
$pdf->setY(205);
$pdf->Ln(1);
$pdf->setX(5);
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


// /* *********************************************************
// ** CLOSE REPORT
// ** ********************************************************* */

//mysql_free_result($alut);
$pdf->Output();

?>