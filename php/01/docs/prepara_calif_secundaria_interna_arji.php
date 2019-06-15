<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Mexico_City');
set_time_limit(60000);


header("Content-type:application/json; charset=utf-8");  
header("Cache-Control: no-cache");
$o = $_POST['o'];
$c = $_POST['c'];
$t = $_POST['t'];
$from = $_POST['from'];
$cantidad = $_POST['cantidad'];
$s = $_POST['s'];

parse_str($c);

require('../oCentura.php');
$f = oCentura::getInstance();

require('../oMetodos.php');
$M = oMetodos::getInstance();
$ret = array();

$arrAlu = explode(",",$strgrualu);
$O0 = $M->Llamar_Actualiza_Boleta_Datos_Secundarios($arrAlu[0]);
$O1 = $M->Llamar_Actualiza_Promedios_Boletas_por_Grupo($arrAlu[0]);
$O2 = $M->Actualizar_Promedios_Grupales(0,0,$user,$arrAlu[0]);
$dato = "";
foreach ($arrAlu as $i => $value) {

	$O3 = $M->Llamar_Actualizar_Promedios_Padres_from_IdGruAlu($user,$arrAlu[$i]);

	$O4 = $M->Actualiza_Promedios_Grupales_por_Materia($user,$arrAlu[$i]);


	$result = $f->getQuerys(43,"idgrualu=".$arrAlu[$i],0,0,0,array()," order by orden_impresion asc ",1);

	if ( count($result)>0  ){

		foreach ($result as $j => $value) {  }

		try {

			$srs = $M->Actualiza_Grupo_Alumno_Promedio($user,$result[$j]->idgrualu);

			$prm = $f->getQuerys(71,"idgrualu=".$result[$j]->idgrualu,0,0,0,array(),'',1);

			$dato =  $M->Copiar_Promedio_a_Promedios_Oficiales_por_Alumno($result[$j]->idalumno,$result[$j]->idnivel,$user, $prm[0]->promcalof, $grado);
			
		} catch (Exception $e) {
		   $dato =  $e->getMessage();
		   //echo $dato;
		}

	}


}

//$ret[0] = array("msg" => $dato. " O1 => ".$O1. " O2 => ".$O2. " O3 => ".$O3. " O4 => ".$O4. " result => ".$result. " srs => ".$srs. " prm => ".$prm);
$ret[0] = array("msg" => $dato);
$m = json_encode($ret);
echo $m;

?>