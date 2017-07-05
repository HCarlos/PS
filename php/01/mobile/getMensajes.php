<?php

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

$iduser   = $_POST['iduser'];
$sts   = $_POST['sts'];
$device   = $_POST['device'];

$arg = "iduser=$iduser&sts=$sts&device=$device";

$res = array();

$r = $F->getQueryPDO(41,$arg);
$res = $r;

if (count($res)>0){
	foreach ($res as $i => $value) {
			$res[$i]->msg = "OK";
	}
}else{
	$res[0]->msg = "Error";	
}

$m = json_encode($res);
echo $m;

?>
