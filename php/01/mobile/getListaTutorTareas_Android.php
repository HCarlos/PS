<?php

header("Content-type:application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../oCentura.php");
$f = oCentura::getInstance();
require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

$username     = $_POST['username'];
$sts   		  = $_POST['sts'];
$iduseralu    = $_POST['iduseralu'];
$tipoConsulta = intval( $_POST['tipoconsulta'] );
$fuente       = !isset($_POST['fuente']) ? 1 : 0;

$tipo = 0;
$otros="";
switch ($tipoConsulta) {
	case 0:
		$arg = "u=$username&sts=$sts&iduseralu=$iduseralu";
		$tipo = 20012;
		break;	
	case 1:
		$arg = "u=$username&sts=$sts";
		$tipo = 31013;
		break;
	case 2:
		$arg = "u=$username";
		$res = $f->getCombo(1,$arg,0,0,43,'');
		$idfamilia = $res[0]->data;
		$arg = "u=$username&idfamilia=$idfamilia";
		$tipo = 10017;
		break;
	case 3:
		$arg = "u=$username";
		$res = $f->getCombo(1,$arg,0,0,43,'');
		$idfamilia = $res[0]->data;
		$arg = "u=$username&iduseralu=$iduseralu";
		$res = $f->getCombo(1,$arg,0,0,58,'');
		$idalumno = $res[0]->data;
		$arg = "u=$username&idfamilia=$idfamilia&idalumno=$idalumno";
		$tipo = 31010;
		$otros = " and is_mostrable = 1 order by idedocta asc ";
		break;
}

if ( ($tipoConsulta >= 0) && ($tipoConsulta <= 3) ){

	ini_set('default_socket_timeout', 6000);
	set_time_limit(6000);

	$r = $f->getQuerys($tipo,$arg,0,0,0,array(),$otros,1);

	if (count($r)>0){
	            
	            $r[0]->msg="OK";

	            if ($tipoConsulta == 3){

	            	foreach ($r as $i => $value) {
	            		$r[$i]->idconceptounico = 0;
	            	}

	            	foreach ($r as $i => $value) {

		                $encontrado = false;

		        		$IdConcepto = $r[$i]->idconcepto;

		            	foreach ($r as $j => $value) {
		                    if( $r[$j]->idconceptounico == $IdConcepto ) {
		                        $encontrado = true;
		                        break;
		                    }
		            	}

	                    if ( !$encontrado && intval($r[$i]->status_movto) == 0){
	                        $r[$i]->idconceptounico = $IdConcepto;
	                    }

	            	}

	            }

	}else{
	    $r[0]  = array("msg" => "empty");
	}

}else{
    $r[0]  = array("msg" => "empty");
}

$m = json_encode($r);
echo $m;

?>
