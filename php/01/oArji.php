<?php
class oArji {
	 
	 private static $instancia;
	 
	 private function __construct(){ 
		
	 }
	 
	public static function getInstance(){
				if (  !self::$instancia instanceof self){
					  self::$instancia = new self;
				}
				return self::$instancia;
	 }
	 
	function FormatCal($cal=0,$con=0,$ina=0,$pivot=0,$round=0){
		$calx = "";
		$conx = "";
		$inax = "";
		$round = 0;
		if ($cal>0){
			$calx = round(floatval($cal),$round);
//			$calx = $cal;
		}
		switch (intval($con)) {
			case 10:
				$conx = "E";
				break;
			case 9:
				$conx = "MB";
				break;
			case 8:
				$conx = "B";
				break;
			case 7:
				$conx = "R";
				break;
			case 6:
				$conx = "D";
				break;
			case 5:
				$conx = "NA";
				break;
			default:
				$conx = "";
				break;
		}
		if ($ina>0){
			// $inax = intval($ina);
			$inax = $ina;
		}

		switch($pivot){
			case 5:
				$calx = $cal == 0 ? '' : $cal;
				return $calx;
				break;
			case 4:
				$calx = $cal;
				return $calx;
				break;
			case 3:

				if (trim($calx)!=''){
					$loC0 = explode('.',$calx);
					if ( count($loC0) > 1 ) {
						if ( intval($loC0[1]) > 0 ){
							$va = str_pad(intval($loC0[1]), 1, "0", STR_PAD_RIGHT);
							return $loC0[0].'.'.$va;
						}else{
							if ($calx >= 10){
								return $loC0[0].'';
							}else{
								return $loC0[0].'.0';
							}
						}	
					}else{
						return $loC0[0].'';						
					}
				}else{
					return '';	
				}
				break;
			case 2:
				return str_pad($calx, 3, " ", STR_PAD_LEFT).' '.str_pad($conx, 2, " ", STR_PAD_LEFT).'   ';	
				break;
			default:
				return str_pad($calx, 3, " ", STR_PAD_LEFT).' '.str_pad($conx, 2, " ", STR_PAD_LEFT).' '.str_pad($inax, 2, " ", STR_PAD_LEFT);
				break;
		}

	}

	function FormatIna($cal=0,$con=0,$ina=0,$pivot=0, $idmatclas=1){

		$inax = intval($ina);

		return $inax > 0 ? $inax : '';

	}
	


	function ref_SCOTIA($pcCic, $pcNivel, $pcFam, $pcAlu, $pcPag, $pcNPag, $pMonto, $pfFecha, $pParam=0, $loConst = "2"){
		
		$pfFecha = strtotime($pfFecha);
	
		// Calculamos la linea incompleta de Captura
		$lcCic   = str_pad($pcCic,2,'0',STR_PAD_LEFT) . str_pad($pcNivel,2,'0',STR_PAD_LEFT);
		$lcFam   = str_pad($pcFam,5,'0',STR_PAD_LEFT);
		$lcAlu   = str_pad($pcAlu,5,'0',STR_PAD_LEFT);
		$lcPag   = str_pad($pcPag,2,'0',STR_PAD_LEFT);
		$lcNPa   = str_pad($pcNPag,2,'0',STR_PAD_LEFT);
//		$loMonto = str_pad( number_format($pMonto, 2, '.', '') ,10,'0',STR_PAD_LEFT); // STRTRAN(TRANSFORM($pMonto,"#########.##")".","")
		$loMonto2 = str_replace('.','',$pMonto);
		$loMonto = str_split($loMonto2);
		$loFecha = $pfFecha; // Fecha de Dia Hábil

		$lcRef = $lcCic . $lcFam . $lcAlu . $lcPag . $lcNPa;
		$lcRef2 = $lcCic . $lcFam . $lcAlu . $lcPag . $lcNPa;

		// Calculamos condensación de la Fecha

		// $loAno = (YEAR($loFecha) - 1988)*372)
		// date("Y", $loFecha)
		$loAno = ( ( date("Y", $loFecha) - 2013)*372);
		$loMes = ( ( date("m", $loFecha) - 1) * 31);
		$loDia = ( date("d", $loFecha) - 1);
		$sumaDate = ($loAno+$loMes+$loDia);
		$lcCF = str_pad( ($sumaDate),4,'0',STR_PAD_LEFT);
		// $lcCF = ($loAno+$loMes+$loDia))

		// Calculamos la condensación del Monto a Pagar

		$Algo = array();

		$Algo[0]=7;
		$Algo[1]=3;
		$Algo[2]=1;

		$c = 0;
		$loSum = 0;

		for ($I=(count($loMonto)-1);$I>=0; --$I) {
		    $lcNum = intval( $loMonto[$I] );
		    $loSum = $loSum + ( $Algo[$c] * $lcNum );
		    if ( $c == 2 ) {
		       $c = 0;
		    } else {
		       ++$c;
		    }
		} 

		$lcDV = $loSum % 10;
		if ( $loSum <= 10 ) {
		   $lcDV = $loSum;
		}

		$lcDV3 = $lcDV;
		
		//$lcDV = str_pad( $lcDV,4,'0',STR_PAD_LEFT);
		   
		$loCP = ($lcRef . $lcCF . $lcDV . $loConst);

		$loCP2 = str_split($loCP,1);

		// Calculamos la el Dígito Verificador

		$Algo = array(); 	

		$Algo[0]=11;
		$Algo[1]=13;
		$Algo[2]=17;
		$Algo[3]=19;
		$Algo[4]=23;

		$c = 0;
		$loSum = 0;
		for ($I=count($loCP2)-1; $I>=0; $I--){ 
		    $lcNum = intval( $loCP2[$I] );
		    $loSum = $loSum + ( $Algo[$c] * $lcNum );
		    if ( $c == 4 ) {
		       $c = 0;
		    }else{
		       ++$c;
		    }
		}
		$lcDV = str_pad( ( ($loSum % 97) + 1),2,'0',STR_PAD_LEFT);

		$lcLCO = $loCP . $lcDV;   


// 0202 00518 04550 03 05 0753 3 2 86

// 0202 00518 04550 03 05 0753 3 2 86

		$rec = array();
		$rec[0] = substr($lcLCO,0,4); 
		$rec[1] = substr($lcLCO,4,5); 
		$rec[2] = substr($lcLCO,9,5); 
		$rec[3] = substr($lcLCO,14,2); 
		$rec[4] = substr($lcLCO,16,2); 
		$rec[5] = substr($lcLCO,18,4); 
		$rec[6] = substr($lcLCO,22,1); 
		$rec[7] = substr($lcLCO,23,1); 
		$rec[8] = substr($lcLCO,24,2); 

		if ($pParam == 0){
			return $lcLCO;
		}else{	
			//return $lcLCO;
			return $rec[0].' '.$rec[1].' '.$rec[2].' '.$rec[3].' '.$rec[4].' '.$rec[5].' '.$rec[6].' '.$rec[7].' '.$rec[8];
		}

	}

	function ref_BANCOMER($pcCic, $pcNivel, $pcFam, $pcAlu, $pcPag, $pcNPag, $pMonto, $pfFecha, $pParam=0, $loConst = "2"){
		
		$pfFecha = strtotime($pfFecha);
	
		// Calculamos la linea incompleta de Captura
		// $lcCic   = str_pad($pcCic,2,'0',STR_PAD_LEFT) . str_pad($pcNivel,2,'0',STR_PAD_LEFT);
		$lcFam   = str_pad($pcFam,5,'0',STR_PAD_LEFT);
		$lcAlu   = str_pad($pcAlu,5,'0',STR_PAD_LEFT);
		// $lcPag   = str_pad($pcPag,2,'0',STR_PAD_LEFT);
		$lcNPa   = str_pad($pcNPag,2,'0',STR_PAD_LEFT);

		$loMonto2 = str_replace('.','',$pMonto);
		$loMonto = str_split($loMonto2);
		$loFecha = $pfFecha; // Fecha de Dia Hábil

		// $lcRef = $lcCic . $lcFam . $lcAlu . $lcPag . $lcNPa;
		// $lcRef2 = $lcCic . $lcFam . $lcAlu . $lcPag . $lcNPa;

		$lcRef = $lcFam . $lcAlu  . $lcNPa;
		$lcRef2 = $lcFam . $lcAlu . $lcNPa;

		// Calculamos condensación de la Fecha

		$loAno = ( ( date("Y", $loFecha) - 2013)*372);
		$loMes = ( ( date("m", $loFecha) - 1) * 31);
		$loDia = ( date("d", $loFecha) - 1);
		$sumaDate = ($loAno+$loMes+$loDia);
		$lcCF = str_pad( ($sumaDate),4,'0',STR_PAD_LEFT);
		// $lcCF = ($loAno+$loMes+$loDia))

		// Calculamos la condensación del Monto a Pagar

		$Algo = array();

		$Algo[0]=7;
		$Algo[1]=3;
		$Algo[2]=1;

		$c = 0;
		$loSum = 0;

		for ($I=(count($loMonto)-1);$I>=0; --$I) {
		    $lcNum = intval( $loMonto[$I] );
		    $loSum = $loSum + ( $Algo[$c] * $lcNum );
		    if ( $c == 2 ) {
		       $c = 0;
		    } else {
		       ++$c;
		    }
		} 

		$lcDV = $loSum % 10;
		if ( $loSum <= 10 ) {
		   $lcDV = $loSum;
		}

		$lcDV3 = $lcDV;
		
		$loCP = ($lcRef . $lcCF . $lcDV . $loConst);

		$loCP2 = str_split($loCP,1);

		// Calculamos la el Dígito Verificador

		$Algo = array(); 	

		$Algo[0]=11;
		$Algo[1]=13;
		$Algo[2]=17;
		$Algo[3]=19;
		$Algo[4]=23;

		$c = 0;
		$loSum = 0;
		for ($I=count($loCP2)-1; $I>=0; $I--){ 
		    $lcNum = intval( $loCP2[$I] );
		    $loSum = $loSum + ( $Algo[$c] * $lcNum );
		    if ( $c == 4 ) {
		       $c = 0;
		    }else{
		       ++$c;
		    }
		}
		$lcDV = str_pad( ( ($loSum % 97) + 1),2,'0',STR_PAD_LEFT);

		$lcLCO = $loCP . $lcDV;   

		$rec = array();
		$rec[0] = substr($lcLCO,0,5); 
		$rec[1] = substr($lcLCO,5,5); 
		$rec[2] = substr($lcLCO,10,2); 
		$rec[3] = substr($lcLCO,12,4); 
		$rec[4] = substr($lcLCO,16,2); 
		$rec[5] = substr($lcLCO,18,2); 

		if ($pParam == 0){
			return $lcLCO;
		}else{	
			return $rec[0].' '.$rec[1].' '.$rec[2].' '.$rec[3].' '.$rec[4].' '.$rec[5];
		}

	}

	
	
}

?>