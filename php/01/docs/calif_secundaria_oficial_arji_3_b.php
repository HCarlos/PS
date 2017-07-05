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
require('../oCentura.php');
$f = oCentura::getInstance();
require('../oMetodos.php');
$M = oMetodos::getInstance();
require('../oFunctions.php');
$F = oFunctions::getInstance();

class PDF_Diag extends PDF_Sector {
	var $nFont;
	var $IdGruAlu;
    var $nombre;
    var $ap_paterno;
    var $ap_materno;
    var $profesor;
    var $director;

	function setPos($arr0){
		$arr1 = explode(";",$arr0);
		$this->setY( floatval( $arr1[1] ) );
		$this->setX( floatval( $arr1[0] ) );
	}

}

$arrAlu = explode(",",$strgrualu);

$rst = $f->getQuerys(114,"idgrualu=".$arrAlu[0],0,0,0,array(),' order by orden_oficial asc ',1);
$IdNivel = $rst[0]->idnivel;

$Pos = $f->getQuerys(96,"idnivel=".$IdNivel."&grado=".$grado."&idemp=".$IdEmp,0,0,0,array(),' ',1);

$pdf = new PDF_Diag('P','mm','Letter');

$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(TRUE, 0.1);
$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(0);

$pdf->nFont = 10;
$pdf->SetFillColor(255,255,255);


// $arrAlu = explode(",",$strgrualu);

foreach ($arrAlu as $i => $value) {
	$pdf->IdGruAlu = $arrAlu[$i];
	$result = $f->getQuerys(114,"idgrualu=".$arrAlu[$i],0,0,0,array(),' order by orden_oficial asc ',1);
	if ( count($result)>0  ){

		$IdAlumno = $result[0]->idalumno;
		$IdNivel = $result[0]->idnivel;
		$ClaveNivel = $result[0]->clave_nivel;
		$pdf->profesor = $result[0]->profesor;
		$pdf->nombre = $result[0]->alumno;

		// Obtenemos el Promedio del Nivel
		$caro = $f->getQuerys(91,"idalumno=".$IdAlumno."&idnivel=".$IdNivel."&idemp=".$IdEmp,0,0,0,array(),' ',1);

		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',8);
		$pdf->AddPage();
	
		// OBSERVACIONES Y RECOMENDACIONES

		// $pdf->SetFillColor(192,192,192);

		// BIM 0
		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->bim0);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );

		if ( trim($caro[0]->bim0) != '' ) { 
			$pdf->Cell(13,$pdf->nFont,$caro[0]->bim0,'',0,'C');
		}else{
			$pdf->Cell(13,$pdf->nFont,'','',0,'C');
		}

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->asig0);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(32,$pdf->nFont,utf8_decode($caro[0]->asignatura0),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->obsesp0);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(60,$pdf->nFont,utf8_decode($caro[0]->observaciones_especificas0),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->rec0);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		// $pdf->Cell(90,$pdf->nFont,utf8_decode($caro[0]->recomendaciones0),'',0,'L');
		$pdf->MultiCell(88,4, utf8_decode($caro[0]->recomendaciones0) ,0,1,'L'); 


		// BIM 1
		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->bim1);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );

		if ( trim($caro[0]->bim1) != '' ) { 
			$pdf->Cell(13,$pdf->nFont,$caro[0]->bim1,'',0,'C');
		}else{
			$pdf->Cell(13,$pdf->nFont,'','',0,'C');
		}

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->asig1);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(32,$pdf->nFont,utf8_decode($caro[0]->asignatura1),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->obsesp1);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(60,$pdf->nFont,utf8_decode($caro[0]->observaciones_especificas1),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->rec1);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		// $pdf->Cell(90,$pdf->nFont,utf8_decode($caro[0]->recomendaciones1),'',0,'L');
		$pdf->MultiCell(88,4, utf8_decode($caro[0]->recomendaciones1) ,0,1,'L'); 



		// BIM 2
		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->bim2);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );

		if ( trim($caro[0]->bim2) != '' ) { 
			$pdf->Cell(13,$pdf->nFont,$caro[0]->bim2,'',0,'C');
		}else{
			$pdf->Cell(13,$pdf->nFont,'','',0,'C');
		}

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->asig2);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(32,$pdf->nFont,utf8_decode($caro[0]->asignatura2),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->obsesp2);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(60,$pdf->nFont,utf8_decode($caro[0]->observaciones_especificas2),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->rec2);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		// $pdf->Cell(90,$pdf->nFont,utf8_decode($caro[0]->recomendaciones2),'',0,'L');
		$pdf->MultiCell(88,4, utf8_decode($caro[0]->recomendaciones2) ,0,1,'L'); 




		// BIM 3
		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->bim3);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );

		if ( trim($caro[0]->bim3) != '' ) { 
			$pdf->Cell(13,$pdf->nFont,$caro[0]->bim3,'',0,'C');
		}else{
			$pdf->Cell(13,$pdf->nFont,'','',0,'C');
		}

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->asig3);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(32,$pdf->nFont,utf8_decode($caro[0]->asignatura3),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->obsesp3);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(60,$pdf->nFont,utf8_decode($caro[0]->observaciones_especificas3),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->rec3);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		// $pdf->Cell(90,$pdf->nFont,utf8_decode($caro[0]->recomendaciones3),'',0,'L');
		$pdf->MultiCell(88,4, utf8_decode($caro[0]->recomendaciones3) ,0,1,'L'); 




		// BIM 4
		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->bim4);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );

		if ( trim($caro[0]->bim4) != '' ) { 
			$pdf->Cell(13,$pdf->nFont,$caro[0]->bim4,'',0,'C');
		}else{
			$pdf->Cell(13,$pdf->nFont,'','',0,'C');
		}

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->asig4);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(32,$pdf->nFont,utf8_decode($caro[0]->asignatura4),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->obsesp4);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(60,$pdf->nFont,utf8_decode($caro[0]->observaciones_especificas4),'',0,'L');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->rec4);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		// $pdf->Cell(90,$pdf->nFont,utf8_decode($caro[0]->recomendaciones4),'',0,'L');
		$pdf->MultiCell(88,4, utf8_decode($caro[0]->recomendaciones4) ,0,1,'L'); 

		// OBSERVACIONES GENERALES
		
		$pdf->SetFont('Arial','',8);
 		$pdf->SetFillColor(255,255,255);

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->observaciones_generales);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->MultiCell(190,6, utf8_decode($caro[0]->observaciones_generales) ,0,1,'L'); 




		// Pintamos el Módulo de LECTURA ESPECIAL
		$pdf->SetFont('Arial','',10);

		$lSEPGen = $f->getQuerys(94,"idgrualu=".$pdf->IdGruAlu,0,0,0,array(),' ',1);
		
		if ( count($lSEPGen) > 0 ){
		
			$IdBol = $lSEPGen[0]->idboleta;
			
			// echo $IdBol." ";
			
			// $Eval1 = $f->getQuerys(95,"idboleta=".$IdBol."&numeval=1",0,0,0,array(),' ',1);
			// $Eval3 = $f->getQuerys(95,"idboleta=".$IdBol."&numeval=3",0,0,0,array(),' ',1);
			// $Eval5 = $f->getQuerys(95,"idboleta=".$IdBol."&numeval=6",0,0,0,array(),' ',1);
			// $Eval7 = $f->getQuerys(95,"idboleta=".$IdBol."&numeval=7",0,0,0,array(),' ',1);

			$Eval1 = $f->getQuerys(95,"idboleta=".$IdBol."&numeval=1",0,0,0,array(),' ',1);
			$Eval3 = $f->getQuerys(95,"idboleta=".$IdBol."&numeval=2",0,0,0,array(),' ',1);
			$Eval5 = $f->getQuerys(95,"idboleta=".$IdBol."&numeval=3",0,0,0,array(),' ',1);
			$Eval7 = $f->getQuerys(95,"idboleta=".$IdBol."&numeval=4",0,0,0,array(),' ',1);

			$Pos = $f->getQuerys(96,"idnivel=".$IdNivel."&grado=".$grado."&idemp=".$IdEmp,0,0,0,array(),' ',1);

			$posEval = 96.5;
			$anchoCol = 13;

			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',7);

			// [0 , 0]
			$eval = intval($Eval1[0]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x0x0);
				// $pdf->Cell($anchoCol+8,$pdf->nFont,$Pos[0]->x0x0 ,'',1,'C');
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x1x0);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x2x0);
			}else {
				$pdf->setPos($Pos[0]->x3x0);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [0 , 1]
			$eval = intval($Eval3[0]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x0x1);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x1x1);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x2x1);
			}else {
				$pdf->setPos($Pos[0]->x3x1);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [0 , 2]
			$eval = intval($Eval5[0]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x0x2);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x1x2);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x2x2);
			}else {
				$pdf->setPos($Pos[0]->x3x2);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [0 , 3]
			$eval = intval($Eval7[0]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x0x3);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x1x3);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x2x3);
			}else {
				$pdf->setPos($Pos[0]->x3x3);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}



			// [1 , 0]
			$pdf->setX(0);
			$eval = intval($Eval1[1]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x4x0);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x5x0);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x6x0);
			}else {
				$pdf->setPos($Pos[0]->x7x0);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [1 , 1]
			$pdf->setX(0);
			$eval = intval($Eval3[1]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x4x1);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x5x1);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x6x1);
			}else {
				$pdf->setPos($Pos[0]->x7x1);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [1 , 2]
			$pdf->setX(0);
			$eval = intval($Eval5[1]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x4x2);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x5x2);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x6x2);
			}else {
				$pdf->setPos($Pos[0]->x7x2);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [1 , 3]
			$pdf->setX(0);
			$eval = intval($Eval7[1]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x4x3);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x5x3);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x6x3);
			}else {
				$pdf->setPos($Pos[0]->x7x3);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [2 , 0]
			$pdf->setX(0);
			$eval = intval($Eval1[2]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x8x0);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x9x0);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x10x0);
			}else {
				$pdf->setPos($Pos[0]->x11x0);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [2 , 1]
			$pdf->setX(0);
			$eval = intval($Eval3[2]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x8x1);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x9x1);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x10x1);
			}else {
				$pdf->setPos($Pos[0]->x11x1);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [2 , 2]
			$pdf->setX(0);
			$eval = intval($Eval5[2]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x8x2);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x9x2);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x10x2);
			}else {
				$pdf->setPos($Pos[0]->x11x2);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}

			// [2 , 3]
			$pdf->setX(0);
			$eval = intval($Eval7[2]->calificacion);
			if ( $eval >= 90 and $eval <= 100){
				$pdf->setPos($Pos[0]->x8x3);
			}else if ( $eval >= 80 and $eval < 90){
				$pdf->setPos($Pos[0]->x9x3);
			}else if ( $eval >= 70 and $eval < 80){
				$pdf->setPos($Pos[0]->x10x3);
			}else {
				$pdf->setPos($Pos[0]->x11x3);
			}			
			if ($eval > 0 ){
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X' ,'',1,'C');
			}


		}else{
			//$pdf->nombre;
			//$pdf->Cell(80,$pdf->nFont,strtoupper(utf8_decode($pdf->nombre)),'',1,'C');
		}

		$pdf->SetFont('Arial','',10);

		$iduserdirector = $Pos[0]->iduserdirector;	
		$dirr = $f->getQuerys(516,$iduserdirector,0,0,0,array(),'',1);
		$pdf->director = $dirr[0]->director;

		$ar = explode(';',$Pos[0]->director);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(80,$pdf->nFont,strtoupper(utf8_decode($pdf->director)),'',1,'C');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->lugar_pos);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(80,$pdf->nFont,strtoupper(utf8_decode($Pos[0]->lugar)),'',0,'C');
		$pdf->Cell(31,$pdf->nFont,'','',0,'C');

		$f0 = explode('-',$Pos[0]->fecha_boleta);

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->dia);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(15,$pdf->nFont,$f0[0],'',0,'C');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->mes);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(10,$pdf->nFont,$f0[1],'',0,'C');

		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->anno);				
		$pdf->setY(  floatval($ar[1])  );
		$pdf->setX(  floatval($ar[0])  );
		$pdf->Cell(10,$pdf->nFont,$f0[2],'',1,'C');




	} // Fin de Enf IF

}

$pdf->Output();

?>