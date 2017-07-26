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
    var $nombre;
    var $ap_paterno;
    var $ap_materno;
    var $profesor;
    var $curp;
    
    function sayLine($x,$y,$anchoCol){
		$this->Line($x+3,$y+5,$x+10,$y+2);
    }

    function setLineCal($val=0,$anchoCol,$Posx,$param=0){
    	$this->setX(0);
    	$ar = explode(';',$Posx);
    	$x = floatval( $ar[0] );
    	$y = floatval( $ar[1] );
		$this->setY($y);
    	$this->setX($x);
    	switch ($param) {
    		case 0:
		    	$this->Cell($anchoCol,$this->nFont,utf8_decode($val),'',0,'L');
    			break;
    		default:
    			$val = floatval($val);
    			if ($val > 0 ){
			    	$this->Cell($anchoCol,$this->nFont,number_format($val,1),'',0,'C');
    			}else{
			    	$this->Line($x,$y+7,$x+11,$y+2);
    			}
    			break;
    	}
    }

}

//echo $arrAlu;
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


foreach ($arrAlu as $i => $value) {

	$result = $f->getQuerys(114,"idgrualu=".$arrAlu[$i],0,0,0,array(),' order by orden_oficial asc ',1);
	if ( count($result)>0  ){

		$IdAlumno = $result[0]->idalumno;

		$arPos = explode(';',$Pos[0]->initcal_x);
		
		$pdf->SetFont('Arial','',9);
		$pdf->AddPage();
		$pdf->setY( floatval($arPos[1]) );

		$bim0 = 0;
		$bim1 = 0;
		$bim2 = 0;
		$bim3 = 0;
		$bim4 = 0;

		foreach ($result as $j => $value) {
			
			$pdf->setX(floatval($arPos[0]));
			$pdf->nFont = floatval($Pos[0]->altofilacal);
			$anchoCol = 13;
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim0,1),1),'',0,'C');
			if ( ROUND($result[$j]->bim0,1) < 6){
				// $pdf->sayLine(($pdf->GetX()-$anchoCol),$pdf->GetY(),$anchoCol);
			}
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim1,1),1),'',0,'C');
			if ( ROUND($result[$j]->bim1,1) < 6){
				// $pdf->sayLine(($pdf->GetX()-$anchoCol),$pdf->GetY(),$anchoCol);
			}
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim2,1),1),'',0,'C');
			if ( ROUND($result[$j]->bim2,1) < 6){
				// $pdf->sayLine(($pdf->GetX()-$anchoCol),$pdf->GetY(),$anchoCol);
			}
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim3,1),1),'',0,'C');
			if ( ROUND($result[$j]->bim3,1) < 6){
				// $pdf->sayLine(($pdf->GetX()-$anchoCol),$pdf->GetY(),$anchoCol);
			}
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim4,1),1),'',0,'C');
			if ( ROUND($result[$j]->bim4,1) < 6){
				// $pdf->sayLine(($pdf->GetX()-$anchoCol),$pdf->GetY(),$anchoCol);
			}
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->promcalof,1),1),'',1,'R');

			$bim0 += intval($result[$j]->inabim0);		
			$bim1 += intval($result[$j]->inabim1);		
			$bim2 += intval($result[$j]->inabim2);		
			$bim3 += intval($result[$j]->inabim3);		
			$bim4 += intval($result[$j]->inabim4);		
			

		}

		$totalFaltas = $bim0 + $bim1 + $bim2 + $bim3 + $bim4;
		$pdf->setX(floatval($arPos[0]));
		$pdf->nFont = floatval($Pos[0]->altofilacal);
		$anchoCol = 13;
		$pdf->Cell($anchoCol,$pdf->nFont,$bim0>0?$bim0:'','',0,'C');
		$pdf->Cell($anchoCol,$pdf->nFont,$bim1>0?$bim1:'','',0,'C');
		$pdf->Cell($anchoCol,$pdf->nFont,$bim2>0?$bim2:'','',0,'C');
		$pdf->Cell($anchoCol,$pdf->nFont,$bim3>0?$bim3:'','',0,'C');
		$pdf->Cell($anchoCol,$pdf->nFont,$bim4>0?$bim4:'','',0,'C');
		$pdf->Cell($anchoCol,$pdf->nFont,$totalFaltas>0?$totalFaltas:'','',1,'C');


		$caro = $f->getQuerys(91,"idalumno=".$IdAlumno."&idnivel=".$IdNivel."&idemp=".$IdEmp,0,0,0,array(),' ',1);

		// Pintamos las REPORBADAS

		$pdf->nFont = 8.5;
		$pdf->SetFont('Arial','',8);
		// $l0=154;
		// $l1=168;
		// $l2=181;
		// $l3=195;

		// $nCol = 72;
		$pdf->setLineCal($caro[0]->asigrep0,$anchoCol,$Pos[0]->mr0,0);
		$pdf->setLineCal(ROUND($caro[0]->evalrep00,1),$anchoCol,$Pos[0]->er00,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep01,1),$anchoCol,$Pos[0]->er01,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep02,1),$anchoCol,$Pos[0]->er02,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep03,1),$anchoCol,$Pos[0]->er03,1);

		// $nCol = 78;
		$pdf->setLineCal($caro[0]->asigrep1,$anchoCol,$Pos[0]->mr1,0);
		$pdf->setLineCal(ROUND($caro[0]->evalrep10,1),$anchoCol,$Pos[0]->er10,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep11,1),$anchoCol,$Pos[0]->er11,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep12,1),$anchoCol,$Pos[0]->er12,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep13,1),$anchoCol,$Pos[0]->er13,1);

		// $nCol = 83;
		$pdf->setLineCal($caro[0]->asigrep2,$anchoCol,$Pos[0]->mr2,0);
		$pdf->setLineCal(ROUND($caro[0]->evalrep20,1),$anchoCol,$Pos[0]->er20,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep21,1),$anchoCol,$Pos[0]->er21,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep22,1),$anchoCol,$Pos[0]->er22,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep23,1),$anchoCol,$Pos[0]->er23,1);

		// $nCol = 90;
		$pdf->setLineCal($caro[0]->asigrep3,$anchoCol,$Pos[0]->mr3,0);
		$pdf->setLineCal(ROUND($caro[0]->evalrep30,1),$anchoCol,$Pos[0]->er30,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep31,1),$anchoCol,$Pos[0]->er31,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep32,1),$anchoCol,$Pos[0]->er32,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep33,1),$anchoCol,$Pos[0]->er33,1);
/*
		$nCol = 96;
		$pdf->setLineCal($caro[0]->asigrep4,120,$nCol,$anchoCol,0);
		$pdf->setLineCal(ROUND($caro[0]->evalrep40,1),$l0,$nCol,$anchoCol,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep41,1),$l1,$nCol,$anchoCol,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep42,1),$l2,$nCol,$anchoCol,1);
		$pdf->setLineCal(ROUND($caro[0]->evalrep43,1),$l3,$nCol,$anchoCol,1);
*/

		// Obtenemos el Promedio del Grado
		$prom = $f->getQuerys(71,"idgrualu=".$result[0]->idgrualu,0,0,0,array(),'',1);

		$ar = explode(';',$Pos[0]->promedio_grado);

		$nCol = floatval($ar[1]);

		$pdf->setX(0);
		$pdf->setY($nCol);
		$pdf->setX( floatval($ar[0]) );

		$pr = explode('.', ROUND( $prom[0]->promcalof,1 ) ) ;

		$pdf->SetFont('Arial','B',10);

		// $pdf->Cell($anchoCol,$pdf->nFont,$pr[0].".",'',0,'R');
		if ( count($pr)>1 ){
			// $pdf->Cell($anchoCol,$pdf->nFont,$pr[1],'',1,'R');
			$zero = $pr[1];
		}else{
			// $pdf->Cell($anchoCol,$pdf->nFont,'0','',1,'R');
			$zero = '0';
		}
		$pdf->Cell($anchoCol,$pdf->nFont,$pr[0].".".$zero,'',0,'R');


		// Obtenemos el Promedio del Nivel
/*
		$ar = explode(';',$Pos[0]->promedio_nivel);
 		$nCol = floatval($ar[1]);

		$pdf->setX(0);
		$pdf->setY($nCol);
		$pdf->setX( floatval($ar[0]) );

		$pr = explode('.', ROUND( $caro[0]->promedio_general,1 ) ) ;

		$pdf->SetFont('Arial','B',10);

		$pdf->Cell($anchoCol,$pdf->nFont,$pr[0],'',0,'R');
		if ( count($pr)>1 ){
			$pdf->Cell($anchoCol+8,$pdf->nFont,$pr[1],'',1,'R');
		}else{
			$pdf->Cell($anchoCol+8,$pdf->nFont,'0','',1,'R');
		}
*/

		$pdf->SetFont('Arial','',8);
		$ar = explode(';',$Pos[0]->clave_tecnologia_pos);
 		$nCol = floatval($ar[1]);

		// Pintaos Tecnología
		$pdf->setX(0);
		$pdf->setY($nCol);
		$pdf->setX( floatval($ar[0]) );

		$pdf->Cell($anchoCol,$pdf->nFont,$Pos[0]->clave_tecnologia,'',0,'R');

		$ar = explode(';',$Pos[0]->tecnologia_pos);
 		$nCol = floatval($ar[1]);
		$pdf->setX(0);
		$pdf->setY($nCol);
		$pdf->setX( floatval($ar[0]) );

		$pdf->Cell($anchoCol,$pdf->nFont,utf8_decode($Pos[0]->tecnologia),'',0,'R');

		// Pintaos ARTES DICIPLINARIAS

		$ar = explode(';',$Pos[0]->area_diciplinaria_pos);
 		$nCol = floatval($ar[1]);
		$pdf->setX(0);
		$pdf->setY($nCol);
		$pdf->setX( floatval($ar[0]) );

		$pdf->Cell($anchoCol,$pdf->nFont,utf8_decode($Pos[0]->area_diciplinaria),'',0,'R');

		// Pintaos ASISTIO A ASESORIAS
		$ar = explode(';',$Pos[0]->asesoria_si_pos);
 		$nCol = floatval($ar[1]);
		$pdf->setX(0);
		$pdf->setY($nCol);
		$pdf->setX( floatval($ar[0]) );

		$pdf->SetFont('Arial','B',8);
		$pdf->Cell($anchoCol,$pdf->nFont,'X','',0,'C');


		$posEval = 184;

		// Pintamos el Módulo de ESCRITURA

		$pdf->SetFont('Arial','',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->escritura);
		$pdf->setY( floatval($ar[1]) );
		$pdf->setX( floatval($ar[0]) );
		$pdf->MultiCell(155,6,utf8_decode($caro[0]->escritura),0,1,'L'); 
		$pdf->SetFont('Arial','B',10);

		switch ( intval($caro[0]->escritura_eval) ) {
			case 1:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->esc0);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 2:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->esc1);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 3:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->esc2);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 4:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->esc3);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 5:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->esc4);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			default:
				# code...
				break;
		}


		// Pintamos el Módulo de LECTURA
		
		$pdf->SetFont('Arial','',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->lectura);
		$pdf->setY( floatval($ar[1]) );
		$pdf->setX( floatval($ar[0]) );
		$pdf->MultiCell(155,6,utf8_decode($caro[0]->lectura),0,1,'L'); 
		$pdf->SetFont('Arial','B',10);

		switch ( intval($caro[0]->lectura_eval) ) {
			case 1:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->lec0);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 2:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->lec1);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 3:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->lec2);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 4:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->lec3);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 5:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->lec4);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			default:
				# code...
				break;
		}



		// Pintamos el Módulo de METEMATICAS
		
		$pdf->SetFont('Arial','',10);
		$pdf->SetFillColor(255,255,255);
		$ar = explode(';',$Pos[0]->matematicas);
		$pdf->setY( floatval($ar[1]) );
		$pdf->setX( floatval($ar[0]) );
		$pdf->MultiCell(155,6,utf8_decode($caro[0]->matematica),0,1,'L'); 
		$pdf->SetFont('Arial','B',10);

		switch ( intval($caro[0]->matematica_eval) ) {
			case 1:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->mate0);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 2:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->mate1);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 3:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->mate2);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 4:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->mate3);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
			case 5:
				$pdf->setX(0);
				$ar = explode(';',$Pos[0]->mate4);
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				$pdf->Cell($anchoCol+8,$pdf->nFont, 'X' ,'',1,'R');
				break;
			default:
				# code...
				break;
		}




	} // Fin de Enf IF
}

$pdf->Output();

?>