<?php

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

$res = array();

$res = $F->getComboPDO(57);
if (count($res)>0){
	$res[0]->msg = "OK";
	$res[0]->ruta = $F->URL.$res[0]->ruta;
}else{
	// $res[0]->msg = "OK";	
	// $res[0]->ruta = '';
    $res[0]  = array(
    				"msg" => "OK",
    				"ruta" => ""
    				);
}


$m = json_encode($res);
echo $m;

?>
