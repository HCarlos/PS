<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Mexico_City');

header("application/json; charset=utf-8");  
header("Cache-Control: no-cache");


$data = $_POST['data'];
parse_str($data);

require_once("../vo/voConn.php");
require_once("../oCentura.php");
$f = oCentura::getInstance();

$idusr = $f->getPubIdUser($user);
$idemp = $f->getPubIdEmp($user);

$ip=$_SERVER['REMOTE_ADDR']; 
$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);

$Conn = voConn::getInstance();
$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
mysql_select_db($Conn->db);
mysql_query("SET NAMES 'utf8'");	

$isExistUser = $f->isExistUserFromEmp($user);

mysql_close($mysql);

$isFiles = false;

$idexaimageexistente = $idexaimage;

$arr = array();

if ($v1 !== md5($user.$idexaimage) || $isExistUser <= 0 ){
	
	$arr['status'] = 'Error';
	$arr['message'] = 'No se ha podido conectar al servidor!';
	$arr['image'] = 'none';

	echo json_encode($arr);	

}else{

	$IdEI=$idexaimage;

	for($i=0;$i<5;++$i){
		if ( isset($_FILES['file_'.$i])  ){
			$isFiles = true;
			$res2 = saveFileTarea($_FILES['file_'.$i],'foto-'.$i,$arr,$idexaimageexistente,$IdEI,$idemp,$i);
			if ( $res2['status'] == "OK" ){

				$Conn = voConn::getInstance();
				$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
				mysql_select_db($Conn->db);
				mysql_query("SET NAMES 'utf8'");	

				$query = "Insert Into exa_imagenes(
											idexaimage,
											directorio,
											archivo,
											descripcion_archivo,
											texto_alternativo,
											idemp,
											ip,
											host,
											creado_por,
											creado_el
										)value( 
											$IdEI,
											'up_exa_images/',
											'".$res2['image']."',
											'$descripcion_archivo',
											'$texto_alternativo',
										    $idemp,
								    		'$ip',
								    		'$host',
								    		$idusr,
								    		NOW()
								    		)";
				$result = mysql_query($query); 

				mysql_close($mysql);

				
			}

			$arr = $res2;
			echo json_encode($arr);

		}
	}

	if ( !$isFiles ){

		$arr['status'] = 'ERR';
		$arr['message'] = 'No proporcionó ningún archivo!';
		$arr['image'] = 'none';
		echo json_encode($arr);

	}


}


function saveFileTarea($file,$descripcion="",$arr=array(),$objeto,$idexaimage,$idemp,$i){
	if( isset($file) ){
		if(!preg_match('/\.(jpe?g|gif|png|pdf|doc|docx|xls|xlsx|ppt|pptx|txt|mp3|mp4)$/' , $file['name'])
			
		) {
		
			$arr['status'] = 'ERR';
			$x = end(explode(".", $file['name']));
			$arr['message'] = 'Formato incorrecto de archivo: '.$x;
		
		} else {

			$i=0;
			$name = $file['name'];
			//$nameFile = md5($name).time();
			$nameFile = 'exa_'.$idemp.'_'.$i;
			$ext = end(explode(".", $name));

			if ($ext == "php" || $ext == "PHP"){
			
					$arr['status'] = 'ERR';
					$arr['message'] = 'El archivo no se pudo subir!';
					$arr['image'] = $nFle;
			
			}else{

				$nFle   = $nameFile.".".strtolower($ext);//$file['name']."_|_".$curp."_|_";

				$save_path = '../../../up_exa_images/'.$nFle;

				
				while (file_exists($save_path)) {

					$name = $file['name'];
					//$nameFile = md5($name).time();
					$y = ++$i;
					$nameFile = 'exa_'.$idemp.'_'.$y;
					$ext = end(explode(".", $name));
					$nFle   = $nameFile.".".strtolower($ext);//$file['name']."_|_".$curp."_|_";

					$save_path = '../../../up_exa_images/'.$nFle;

				}

				if( 
					! move_uploaded_file($file['tmp_name'] , $save_path)
					 
				  )
				{
					$arr['status'] = 'ERR';
					$arr['message'] = 'El archivo no se pudo subir!';
					$arr['image'] = $nFle;
				}else{
					$arr['status'] = 'OK';
					$arr['message'] = 'Archivo subido satisfactoriamente!';
					$arr['image'] = $nFle;
				}

			}

		}
		
	}else{
				$arr['status'] = 'OK';
				$arr['message'] = 'Archivo subido satisfactoriamente!';
				$arr['image'] = $objeto;
				$arr['thumb'] = '';

	}
	
	return $arr;

}






?>