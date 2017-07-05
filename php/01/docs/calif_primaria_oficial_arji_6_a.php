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
    var $nombre;
    var $ap_paterno;
    var $ap_materno;
    var $profesor;
    var $curp;
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

		$pdf->SetFont('Arial','',10);
		$pdf->AddPage();
		$pdf->setY( floatval($arPos[1]) );

		$bim0 = 0;
		$bim1 = 0;
		$bim2 = 0;
		$bim3 = 0;
		$bim4 = 0;

		foreach ($result as $j => $value) {
			
			$pdf->setX( floatval($arPos[0]) );
			$pdf->nFont = floatval($Pos[0]->altofilacal);
			$anchoCol = 13;
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim0,1),1),'',0,'C');
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim1,1),1),'',0,'C');
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim2,1),1),'',0,'C');
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim3,1),1),'',0,'C');
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->bim4,1),1),'',0,'C');
			$pdf->Cell($anchoCol,$pdf->nFont,number_format(ROUND($result[$j]->promcalof,1),1),'',1,'C');

		}
		$rst = $f->getQuerys(98,"idgrualu=".$arrAlu[$i],0,0,0,array(),' and idmatclas = 7 and idioma = 0 ',1);
		foreach ($rst as $j => $value) {
			$bim0 += intval($rst[$j]->inabim0);		
			$bim1 += intval($rst[$j]->inabim1);		
			$bim2 += intval($rst[$j]->inabim2);		
			$bim3 += intval($rst[$j]->inabim3);		
			$bim4 += intval($rst[$j]->inabim4);		
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


		// Obtenemos el Promedio del Grado
		$prom = $f->getQuerys(71,"idgrualu=".$result[0]->idgrualu,0,0,0,array(),'',1);
		$ar = explode(';',$Pos[0]->promedio_grado);

		$pdf->setX(0);
		$pdf->setY( floatval($ar[1]) );
		$pdf->setX( floatval($ar[0]) );

		$pr = explode('.', ROUND( $prom[0]->promcalof,1 ) ) ;

		$pdf->SetFont('Arial','B',10);

		// $pdf->Cell($anchoCol,$pdf->nFont,$pr[0],'',0,'R');
		// $pdf->Cell($anchoCol,$pdf->nFont,$pr[0].".",'',0,'R');
		if ( count($pr)>1 ){
			// $pdf->Cell($anchoCol+8,$pdf->nFont,$pr[1],'',1,'R');
			// $pdf->Cell($anchoCol,$pdf->nFont,$pr[1],'',1,'R');
			$zero = $pr[1];
		}else{
			// $pdf->Cell($anchoCol+8,$pdf->nFont,'0','',1,'R');
			// $pdf->Cell($anchoCol,$pdf->nFont,'0','',1,'R');
			$zero = '0';
		}
		$pdf->Cell($anchoCol,$pdf->nFont,$pr[0].".".$zero,'',0,'R');


		// Obtenemos el Promedio del Nivel
		$caro = $f->getQuerys(91,"idalumno=".$IdAlumno."&idnivel=".$IdNivel."&idemp=".$IdEmp,0,0,0,array(),'',1);


		// Pintamos el Promovido
		$pdf->setX(0);
		switch ( intval($caro[0]->ispromovido) ) {

			case 1:
				
				$ar = explode(';',$Pos[0]->promovido_si);
				
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;

			case 0:
				
				$ar = explode(';',$Pos[0]->promovido_no);
				
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );
				
				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;
				
			default:
				
				$ar = explode(';',$Pos[0]->promovido_condiciones);
				
				$pdf->setY( floatval($ar[1]) );
				$pdf->setX( floatval($ar[0]) );

				$pdf->Cell($anchoCol+8,$pdf->nFont,'X','',1,'R');
				break;

		}


		// Pintamos el Promedio del Nivel

		$ar = explode(';',$Pos[0]->promedio_nivel);
 
		$pdf->setX(0);
		$pdf->setY( floatval($ar[1]) );
		$pdf->setX( floatval($ar[0]) );

		$pr = explode('.', ROUND( $caro[0]->promedio_general,1 ) ) ;

		$pdf->SetFont('Arial','B',10);

		//$pdf->Cell($anchoCol,$pdf->nFont,$pr[0].".",'',0,'R');
		if ( count($pr)>1 ){
			// $pdf->Cell($anchoCol,$pdf->nFont,$pr[1],'',1,'R');
			$zero = $pr[1];
		}else{
			// $pdf->Cell($anchoCol,$pdf->nFont,'0','',1,'R');
			$zero = "0";
		}
		$pdf->Cell($anchoCol,$pdf->nFont,$pr[0].".".$zero,'',0,'R');



		// Pintamos el Módulo de ESCRITURA

		$pdf->SetFont('Arial','',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->setX(0);
		$ar = explode(';',$Pos[0]->escritura );
		$pdf->setY( floatval($ar[1]) );
		$pdf->setX( floatval($ar[0]) );
		$pdf->MultiCell(155,6,utf8_decode( $caro[0]->escritura ),0,1,'L'); 
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
		$ar = explode(';', $Pos[0]->lectura );
		$pdf->setY( floatval($ar[1]) );
		$pdf->setX( floatval($ar[0]) );
		$pdf->MultiCell(155,6,utf8_decode( $caro[0]->lectura ),0,1,'L'); 
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
		$ar = explode(';',$Pos[0]->matematicas );
		$pdf->setY( floatval($ar[1]) );
		$pdf->setX( floatval($ar[0]) );
		$pdf->MultiCell(155,6,utf8_decode( $caro[0]->matematica ),0,1,'L'); 
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