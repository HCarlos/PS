<?php

header("Content-type:application/json; charset=utf-8");  
header("Cache-Control: no-cache");

require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

$iduser = $_POST['iduser'];
$sts    = $_POST['sts'];
$device = $_POST['device'];
$type   = !isset($_POST['type']) ? 1 : intval($_POST['type']);

$arg = "iduser=$iduser&sts=$sts&device=$device&type=$type";

$res = array();

$r = $F->getQueryPDO(41,$arg);
$res = $r;

if (count($res)>0){
	foreach ($res as $i => $value) {
			$res[$i]->msg = "OK";
	}
}else{
    $res[0]  = array("msg" => "Error");
}

$m = json_encode($res);
echo $m;

?>
