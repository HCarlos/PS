<?php

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

$idgrualu = $_GET["idgrualu"];

$res = array();

$res = $F->getComboPDO(58,$idgrualu);
if (count($res)>0){
	$res[0]->msg = "OK";
	$res[0]->ruta = $F->URL.$res[0]->ruta;
}else{
	$res[0]->msg = "OK";	
	$res[0]->ruta = '';
}


$m = json_encode($res);
echo $m;

?>
