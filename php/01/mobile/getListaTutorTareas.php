<?php

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../oCentura.php");
$f = oCentura::getInstance();
$username     = $_POST['username'];
$sts   		  = $_POST['sts'];
$iduseralu    = $_POST['iduseralu'];
$tipoConsulta = intval( $_POST['tipoconsulta'] );

//$sts = !isset($_POST['sts']) ? '1' : $_POST['sts'];

$tipo = 0;
$otros="";
switch ($tipoConsulta) {
	case 0:
		$arg = "u=$username&sts=$sts&iduseralu=$iduseralu";
		$tipo = 20009;
		break;	
	case 1:
		$arg = "u=$username&sts=$sts";
		$tipo = 31009;
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


	// var nc = "u="+localStorage.nc+ "&idfamilia="+IdFamilia+"&idalumno="+idalu;

/*

        var nc = "u="+localStorage.nc+"&idfamilia="+IdFamilia;
        $.post(obj.getValue(0) + "data/", {o:2, t:7, c:nc, p:0, from:0, cantidad:0, s:''},

	var nc = "u="+localStorage.nc+ "&sts="+val+ "&iduseralu="+$("#listAlumnosTarTutor0 option:selected").val();

	$.post(obj.getValue(0) + "data/", {o:40, t:20008, c:nc, p:10, from:0, cantidad:0,s:''},
	getQuerys($tipo=0,$cad="",$type=0,$from=0,$cant=0,$ar=array(),$otros="",$withPag=1)

*/


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
    $r[0]->msg="empty";
}

$m = json_encode($r);
echo $m;

?>
