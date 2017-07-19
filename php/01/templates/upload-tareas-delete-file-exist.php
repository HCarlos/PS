<?php

$arr = array();

$data = $_POST['data'];
parse_str($data);

require_once("../oCentura.php");
$f = oCentura::getInstance();

$arr = array();

$query = "Delete from tareas_archivos where idtareaarchivo = ".$idtareaarchivo;
$result = $f->guardarDatos($query);

$save_path = '../../../up_tareas/'.$archivo;

			
if  (file_exists($save_path)) {
	unlink($save_path);
}

$arr['status'] = 'OK';
$arr['message'] = 'Archivo eliminado satisfactoriamente!';
$arr['image'] = $archivo;
$arr['thumb'] = '';

echo json_encode($arr);


?>