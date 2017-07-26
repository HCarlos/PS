<?php

$c = $_POST['c'];

if (!isset($c)){
	header('Location: http://platsource.mx/');
}

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();
require_once('../oCentura.php');
$f = oCentura::getInstance();
// require_once('../oCenturaPDO.php');
// $F = oCenturaPDO::getInstance();

parse_str($c);

$arrHD 	  = array();

$emp = $f->getQuerys(-5,$c,0,0,0,array(),"");

// echo $c;

$rs = $f->getQuerys(116,$c,0,0,0,array(),"");
foreach ($rs as $i => $value) {
	
	$arrHD[$i] = array(
						"idpaicriterio" => $rs[$i]->idpaicriterio,
						"criterio" => $rs[$i]->criterio,
						"descripcion_criterio" => $rs[$i]->descripcion_criterio,
						"numCriterio" => $i+1
						);
	

	// $arrHD[$i] = array("ID"=>$i);		

	// $arrHD[$i]->idpaicriterio 		 = $rs[$i]->idpaicriterio;
	// $arrHD[$i]->criterio 			 = $rs[$i]->criterio;
	// $arrHD[$i]->descripcion_criterio = $rs[$i]->descripcion_criterio;
	// $arrHD[$i]->numCriterio 		 = $i+1; 

}

// var_dump($arrHD);

$items = $f->getQuerys(117,$c,0,0,0,array(),"");
foreach ($items as $i => $value) {
	$c2 = "u=".$u."&idboleta=".$items[$i]->idboleta."&numval=".$numval;
	$nodo = $f->getQuerys(118,$c2,0,0,0,array(),"");

	$items[$i]->idboletapaibi = $nodo[0]->idboletapaibi;
	$items[$i]->idboleta = $items[$i]->idboleta;
	$items[$i]->alumno = $items[$i]->alumno;
	$items[$i]->num_lista = $items[$i]->num_lista;
										
	$items[$i]->e11 = $nodo[0]->e11;
	$items[$i]->e1 = $nodo[0]->e1;
	$items[$i]->e12 = $nodo[0]->e12;
										
	$items[$i]->e21 = $nodo[0]->e21;
	$items[$i]->e2 = $nodo[0]->e2;
	$items[$i]->e22 = $nodo[0]->e22;
										
	$items[$i]->e31 = $nodo[0]->e31;
	$items[$i]->e3 = $nodo[0]->e3;
	$items[$i]->e32 = $nodo[0]->e32;
										
	$items[$i]->e41 = $nodo[0]->e41;
	$items[$i]->e4 = $nodo[0]->e4;
	$items[$i]->e42 = $nodo[0]->e42;

}

class PDF_Diag extends PDF_Sector {
	var $nFont;
    var $grupo;
    var $nombreEmpresa;
    var $Materia;
    var $Profesor;

    function Header(){   }
	
	function Footer()
	{
	    //Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',7);
	    //Page number
	    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
	}
    
}

// require('../oFunctions.php');
// $f = oFunctions::getInstance();


$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->grupo = $grupo;
$pdf->nombreEmpresa = $emp[0]->rs;
$pdf->Materia = $materia;
$pdf->Profesor = $items[0]->profesor;
$pdf->NumEval = $numval;
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
$pdf->Cell(110,$pdf->nFont,utf8_decode($pdf->nombreEmpresa),'',0,'L');
$pdf->Cell(70,$pdf->nFont,utf8_decode("CALIFICACIONES PAI"),'LTRB',1,'C',true);

$pdf->Ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(22,$pdf->nFont,'PROFESOR:','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(123,$pdf->nFont,utf8_decode($pdf->Profesor),'',0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,$pdf->nFont,utf8_decode("GRUPO:"),'',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,$pdf->nFont,utf8_decode($pdf->grupo),'',1,'R');

$pdf->Ln(1);
$pdf->setX(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(22,$pdf->nFont,'MATERIA PAI:','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,$pdf->nFont,utf8_decode($pdf->Materia),'',0,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,$pdf->nFont,'EVAL:','',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(13,$pdf->nFont,$pdf->NumEval,'',0,'L');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,$pdf->nFont,utf8_decode("FECHA:"),'',0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,$pdf->nFont,date('d-m-Y'),'',1,'R');

$pdf->Ln(5);
$pdf->setX(5);
$y = $pdf->GetY();
$pdf->SetFillColor(192);
$pdf->RoundedRect(5, $y, 205, 6, 2, '12', 'FD');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,$pdf->nFont,utf8_decode("#"),'',0,'C');
$pdf->Cell(95,$pdf->nFont,utf8_decode("NOMBRE DEL ALUMNO "),'L',0,'L');

foreach ($rs as $i => $value) {
	
	$par = count($rs) == $i+1 ? 1 : 0;
	$pdf->Cell(25,$pdf->nFont,"Criterio ".$arrHD[$i]["criterio"],'L',$par,'C');

}
/*
$pdf->setX(5);
$pdf->Cell(10,$pdf->nFont,"",'',0,'C');
$pdf->Cell(95,$pdf->nFont,"",'L',0,'L');
$pdf->SetFont('Arial','',6);

foreach ($rs as $i => $value) {
	
	$par = count($rs) == $i+1 ? 1 : 0;
	$pdf->Cell(25,$pdf->nFont,utf8_decode($arrHD[$i]->descripcion_criterio),'L',$par,'C');

}
*/

$l=0;

$pdf->SetFont('Arial','',10);

foreach ($items as $i => $value) {
	
	$pdf->setX(5);
	$pdf->Cell(10,$pdf->nFont,$items[$i]->num_lista,'L',0,'C');
	$pdf->Cell(95,$pdf->nFont,utf8_decode($items[$i]->alumno),'L',0,'L');
	$e1 = $items[$i]->e1 == "-1" ? "" : $items[$i]->e1; 
	$pdf->Cell(25,$pdf->nFont,$e1,'L',0,'C');
	$e2 = $items[$i]->e2 == "-1" ? "" : $items[$i]->e2; 
	$pdf->Cell(25,$pdf->nFont,$e2,'L',0,'C');
	$e3 = $items[$i]->e3 == "-1" ? "" : $items[$i]->e3; 
	$pdf->Cell(25,$pdf->nFont,$e3,'L',0,'C');
	$e4 = $items[$i]->e4 == "-1" ? "" : $items[$i]->e4; 
	$pdf->Cell(25,$pdf->nFont,$e4,'LR',1,'C');

}

$pdf->setX(5);
$pdf->Cell(10,$pdf->nFont,'','LB',0,'C');
$pdf->Cell(95,$pdf->nFont,'','LB',0,'L');
$pdf->Cell(25,$pdf->nFont,'','LB',0,'C');
$pdf->Cell(25,$pdf->nFont,'','LB',0,'C');
$pdf->Cell(25,$pdf->nFont,'','LB',0,'C');
$pdf->Cell(25,$pdf->nFont,'','LRB',1,'C');

$pdf->Ln(5);

foreach ($rs as $i => $value) {
	
	$pdf->setX(5);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(20,4,"CRITERIO ".$arrHD[$i]["criterio"].': ','',0,'L');
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(180,4,utf8_decode($arrHD[$i]["descripcion_criterio"]),'',1,'L');

}

$pdf->Ln(5);

	$pdf->setX(5);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(25,4,"NIVELES DE LOGRO:",'',0,'L');
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(10,4,'0','',0,'C');
	$pdf->Cell(10,4,'1-2','',0,'C');
	$pdf->Cell(10,4,'3-4','',0,'C');
	$pdf->Cell(10,4,'5-6','',0,'C');
	$pdf->Cell(10,4,'7-8','',1,'C');


$pdf->Output();

?>