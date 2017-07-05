<?php

$o = $_POST['o'];
$c = $_POST['c'];
$t = $_POST['t'];
$from = $_POST['from'];
$cantidad = $_POST['cantidad'];
$s = $_POST['s'];

// echo $c;

if (!isset($c)){
	header('Location: http://platsource.mx/');
}

require('../diag/sector.php');

require_once('../oFunctions.php');
$Q = oFunctions::getInstance();

require_once('../oCentura.php');
$F = oCentura::getInstance();

require_once('../oCenturaPDO.php');
$P = oCenturaPDO::getInstance();

parse_str($c);

class PDF_Diag extends PDF_Sector {
	var $nFont;
    var $grupo;
    var $idemp = 1;
    var $logoEmp;
    var $nombreEmp;

    function Header(){   

		$this->Image('../../../images/web/'.$this->logoEmp,5,5,25,25);
		$this->Ln(5);

		$this->setX(30);

		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','B',14);
		$this->Cell(80,8,utf8_decode($this->nombreEmp),'',0,'L');
		$this->Cell(100,8,utf8_decode("CATÁLOGO GENERAL DE ALUMNOS"),'LTRB',1,'C',true);

		$this->Ln(10);
		$this->setX(5);
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','B',8);
		$this->Cell(5,$this->nFont,utf8_decode("N°"),'T',0,'L');
		$this->Cell(5,$this->nFont,'','T',0,'L');
		$this->Cell(70,$this->nFont,utf8_decode("N O M B R E  D E L  A L U M N O"),'T',0,'L');
		$this->Cell(80,$this->nFont,"",'T',0,'L');
		$this->Cell(50,$this->nFont,utf8_decode("PADRE O TUTOR"),'T',1,'L');

		$this->Ln(1);
		$this->setX(5);
		$this->Cell(2,$this->nFont,'','',0,'L');
		$this->Cell(8,$this->nFont,'','',0,'L');
		$this->Cell(25,$this->nFont,utf8_decode("FECHA"),'',0,'L');
		$this->Cell(25,$this->nFont,utf8_decode("GÉNERO"),'',0,'L');
		$this->Cell(20,$this->nFont,utf8_decode("GRUPO"),'',0,'L');
		$this->Cell(80,$this->nFont,utf8_decode("D O M I C I L I O"),'',0,'L');
		$this->Cell(50,$this->nFont,utf8_decode("PROFESION"),'',1,'L');

		$this->Ln(1);
		$this->setX(5);
		$this->Cell(2,$this->nFont,'','B',0,'L');
		$this->Cell(8,$this->nFont,'','B',0,'L');
		$this->Cell(35,$this->nFont,utf8_decode("NOMBRE DE LA MADRE"),'B',0,'L');
		$this->Cell(35,$this->nFont,'','B',0,'L');
		$this->Cell(80,$this->nFont,utf8_decode("TELÉFONOS"),'B',0,'L');
		$this->Cell(50,$this->nFont,'','B',1,'L');

		$this->Ln(2);
    
    }
	
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


$pdf = new PDF_Diag('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->grupo = $grupo;// strtoupper(utf8_decode($F->getBFecha(date("Y-m-d"),"00:00:00",7)));
$pdf->nFont = 4;
$pdf->SetFillColor(192,192,192);

$l=0;

$arrAlu = explode('-',$idgrupos);

foreach ($arrAlu as $g => $value) {

	$c = "u=".$u."&idgrupo=".$arrAlu[$g]."&grupo=".$grupo."&idciclo=".$idciclo;
	$rs = $F->getCombo($o,$c,0,0,$t);

	if ( count($rs) > 0 ){

		$pdf->idemp = intval($rs[0]->idemp);

		if ( $pdf->idemp == 1 ) {
			$pdf->logoEmp = $P->getLogoEmp($pdf->idemp);
			$pdf->nombreEmp = $P->getNombreEmp($pdf->idemp);
		}

		$pdf->AddPage();

		foreach ($rs as $i => $value) {

			if ( count($rs)>0  ){
		
				// Linea 1
				$pdf->setX(5);
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(5,$pdf->nFont,intval($rs[$i]->num_lista)==0?'':$rs[$i]->num_lista,'',0,'L');
				$pdf->Cell(5,$pdf->nFont,'','',0,'L');
				$alumno = $rs[$i]->ap_paterno.' '.$rs[$i]->ap_materno.' '.$rs[$i]->nombre;
				$pdf->Cell(70,$pdf->nFont,utf8_decode( $alumno ),'',0,'L');
				
				$tut = $F->getQuerys(20,$rs[$i]->idtutor);
				if ( count($tut) > 0 ){
					$domicilio = $tut[0]->domicilio_generico;
				}else{
					$domicilio = '';
				}	
				$x = $pdf->GetX();
				$y = $pdf->GetY();

				$tutor = $rs[$i]->nombre_tutor;

				$pdf->SetXY($x+80, $y);
				$pdf->Cell(50,$pdf->nFont,utf8_decode( $tutor ),'',1,'L');
				$pdf->SetXY($x, $y);
				$pdf->MultiCell(80, $pdf->nFont, utf8_decode(trim($domicilio) ),'', 'L');
				$pdf->SetXY($x, $y+$pdf->nFont);

				$x = $pdf->GetX();
				$y = $pdf->GetY();

				// Linea 2
				$pdf->Ln(1);
				$a = $F->getQuerys(10,$rs[$i]->idalumno);
				$pdf->SetXY(5, $y);
				$pdf->Cell(5,$pdf->nFont,'','',0,'L');
				$pdf->Cell(5,$pdf->nFont,'','',0,'L');
				$pdf->Cell(25,$pdf->nFont,utf8_decode( trim( $a[0]->cfecha_nacimiento ) ),'',0,'L');
				$genero = $a[0]->genero==0?"FEMENINO":"MASCULINO";
				$pdf->Cell(25,$pdf->nFont,utf8_decode(trim($genero) ),'',0,'L');
				$pdf->Cell(20,$pdf->nFont,utf8_decode(trim($rs[$i]->grupo) ),'',0,'L');
				$pdf->Cell(80,$pdf->nFont,'','',0,'L');
				$pdf->Cell(10,$pdf->nFont,utf8_decode( trim($tut[0]->ocupacion) ),'',1,'L');
				$pdf->SetXY($x, $y+$pdf->nFont);

				$x = $pdf->GetX();
				$y = $pdf->GetY();

				// Linea 3
				$pdf->Ln(1);
				$emer = $F->getQuerys(115,"u=".$u."&idalumno=".$rs[$i]->idalumno);
				$c = "u=".$u."&idfamilia=".$rs[$i]->idfamilia;
				$r = $F->getCombo(1,$c,0,0,10);

				$pdf->SetXY(5, $y);
				$pdf->Cell(5,$pdf->nFont,'','B',0,'L');
				$pdf->Cell(5,$pdf->nFont,'','B',0,'L');
				$pdf->Cell(70,$pdf->nFont,utf8_decode( trim($r[0]->label) ),'B',0,'L');
				$tels = trim($rs[$i]->tel1_tutor).", ".trim($rs[$i]->tel2_tutor).", ".trim($rs[$i]->cel1_tutor).", ".trim($rs[$i]->cel2_tutor);
				$telseme = $tels;
				if ( count($emer) > 0 ){
					foreach ($emer as $m => $value) {
						if ( (trim($emer[$m]->tel1) != "EMPTY") && (trim($emer[$m]->tel1) != "EMPTY1")  ){
							$telseme .= trim($emer[$m]->tel1) == "" ? $emer[$m]->tel1 : ', '.$emer[$m]->tel1;
						}else{
							$telseme .= trim($emer[$m]->tel1) == "" ? '' : '';

						}
					}
				}

				$pdf->Cell(80,$pdf->nFont,$telseme,'B',0,'L');
				//$pdf->Cell(30,$pdf->nFont,utf8_decode( trim($tut[0]->lugar_trabajo) ),'B',1,'L');
				$pdf->Cell(30,$pdf->nFont,'','B',1,'L');

				$pdf->Ln(2);



				$l = $i;

			}
		}

	}

}


$pdf->Output();

?>