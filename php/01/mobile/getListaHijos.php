<?php

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../oCentura.php");
$f = oCentura::getInstance();
$us   = $_POST['username'];

$idusernivelacceso   = isset( $_POST['idusernivelacceso'] ) ? intval($_POST['idusernivelacceso']) : 0;
$arg = "u=$us";

$res = array();

if ( $idusernivelacceso == 7 ) {
	$res = $f->getCombo(1,$arg,0,0,60,'');
}else{
	$res = $f->getCombo(1,$arg,0,0,61,'');
}

if (count($res)>0){
	foreach ($res as $i => $value) {
		$iduseralu = $res[$i]->data;
		$arg = "u=".$us."&iduseralu=".$iduseralu;
		$r = $f->getCombo(1,$arg,0,0,59,' limit 1 ');
		if (count($r)>0){

			$res[$i]->iduseralu = $r[0]->iduseralu;
			$res[$i]->idgrualu = $r[0]->idgrualu;
			$res[$i]->grupo = $r[0]->grupo;
			$res[$i]->genero = $r[0]->genero;
			$urlBase = "https://platsource.mx/";
            switch (intval($r[0]->clave_nivel)) {
                 case 5:
                     $res[$i]->urlBoleta = $urlBase."print-calif-prepa-interna-arji/";
                     $res[$i]->urlBoleta2 = $urlBase."";
                     break;
                 case 4:
                     $res[$i]->urlBoleta = $urlBase."print-calif-secundaria-interna-arji/";
                     $res[$i]->urlBoleta2 = $urlBase."";
                     break;
                 case 2:
                     $res[$i]->urlBoleta = $urlBase."print-calif-primaria-interna-arji/";
                     $res[$i]->urlBoleta2 = $urlBase."";
                     break;
                 case 3:
                     $res[$i]->urlBoleta = $urlBase."print-calif-primaria-interna-arji/";
                     $res[$i]->urlBoleta2 = $urlBase."";
                     break;
                 case 1:
                     $res[$i]->urlBoleta = $urlBase."print-calif-kinder-interna-arji-esp/";
                     $res[$i]->urlBoleta2 = $urlBase."print-calif-kinder-interna-arji-ing/";
                     break;
             } 

			require_once("../oCenturaPDO.php");
			$F = oCenturaPDO::getInstance();
			$res[$i]->logoEmp = $F->getLogoEmp($r[0]->idemp);
			$res[$i]->logoIB = $F->getLogoIB($r[0]->idemp);
			$res[$i]->msg = "OK";

			$arguments = "u=$us&idgrualu=".$r[0]->iduseralu;
			$rst = $f->getCombo(2,$arguments,0,0,11,'');
			if ( count($rst) > 0 ){
				$res[$i]->IsBoleta = 1;
			}else{
				$res[$i]->IsBoleta = 0;
			}


		}else{
			// unset($res[$i]);
			$res[$i]->iduseralu = 0;
			$res[$i]->grupo = "";
			$res[$i]->logoEmp = "";
			$res[$i]->logoIB = "";
			$res[$i]->urlBoleta = "";
			$res[$i]->urlBoleta2 = "";
			$res[$i]->IsBoleta = 0;				
			$res[$i]->msg = "OK";
			$res[$i]->idgrualu = 0;
			$res[$i]->genero = 0;
		}
	}
}else{
	// $res[0]->msg = "OK";	
    $res[0]  = array("msg" => "OK");
}


$m = json_encode($res);
echo $m;

?>
