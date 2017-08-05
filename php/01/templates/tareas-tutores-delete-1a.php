<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Mexico_City');

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");

$data = $_POST['data'];
parse_str($data);

require_once("../oCenturaPDO.php");
$f = oCenturaPDO::getInstance();
$ret = array();

$query0 = "SELECT directorio, archivo FROM tareas_archivos WHERE idtarea = ".$idtarea;
$rst = $f->getArray($query0);

foreach($rst AS $i=>$valor){
	$save_path = '../../../'.$rst[$i]->directorio.$rst[$i]->archivo;				
	if  (file_exists($save_path)) {
		// chown($save_path, 777);
		unlink($save_path);
	}
}

$query = "DELETE FROM tareas WHERE idtarea = ".$idtarea;
$result = $f->guardarDatos($query);

$ret[0] = array("msg" => "OK");

$m = json_encode($ret);
echo $m;


?>