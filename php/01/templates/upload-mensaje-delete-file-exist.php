<?php

$arr = array();

$data = $_POST['data'];
parse_str($data);

require_once("../vo/voConn.php");
require_once("../oCentura.php");
$f = oCentura::getInstance();


$Conn = voConn::getInstance();
$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
mysql_select_db($Conn->db);
mysql_query("SET NAMES 'utf8'");	
$arr = array();

$query = "Delete from com_mensaje_archivos where idcommensajearchivo = ".$idcommensajearchivo;
$result = mysql_query($query); 

$save_path = '../../../up_mensajes/'.$archivo;

			
if  (file_exists($save_path)) {
	unlink($save_path);
}

$arr['status'] = 'OK';
$arr['message'] = 'Archivo eliminado satisfactoriamente!';
$arr['image'] = $archivo;
$arr['thumb'] = '';

mysql_close($mysql);

echo json_encode($arr);


?>