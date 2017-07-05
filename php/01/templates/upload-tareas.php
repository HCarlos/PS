<?php


$data = $_POST['data'];
parse_str($data);

require_once("../vo/voConn.php");
require_once("../oCentura.php");
$f = oCentura::getInstance();

$idusr = $f->getPubIdUser($user);
$idemp = $f->getPubIdEmp($user);

$ip=$_SERVER['REMOTE_ADDR']; 
$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 

$vRet = "Error";
$Conn = voConn::getInstance();
$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
mysql_select_db($Conn->db);
mysql_query("SET NAMES 'utf8'");	

$isExistUser = $f->isExistUserFromEmp($user);

$f0 = explode('-',$fecha_inicio);
$fecha_inicio = $f0[2].'-'.$f0[1].'-'.$f0[0].' '.$hora0.':'.$min0.':'.$seg0;

$f1 = explode('-',$fecha_fin);
$fecha_fin = $f1[2].'-'.$f1[1].'-'.$f1[0].' '.$hora1.':'.$min1.':'.$seg1;

$idtareaexistente = $idtarea;

$arr = array();
$arr['status'] = 'OK';
$arr['message'] = 'Datos guardados con éxito!';
$arr['image'] = 'none';

if ($isExistUser > 0 ){

	if ( $idtarea <= 0){

		$query = "Insert Into tareas(
									idgrumat,
									titulo_tarea,
									tarea,
									fecha_inicio,
									fecha_fin,
									status_tarea,
									idemp,
									ip,
									host,
									creado_por,
									creado_el
								)value( 
									$idgrumat,
									'$titulo',
									'$tarea',
									'".$fecha_inicio."',
									'".$fecha_fin."',
									1,
								    $idemp,
						    		'$ip',
						    		'$host',
						    		$idusr,
						    		NOW()
						    		)";

		$result = mysql_query($query); 
		$result = mysql_query("SELECT MAX(idtarea) as IDs from tareas");
		$IdTar=intval(mysql_result($result, 0,"IDs"));

	}else{
		mysql_query("SET NAMES 'utf8'");	
		$query = "update tareas set titulo_tarea = '$titulo',
									tarea = '$tarea',
									fecha_inicio = '".$fecha_inicio."',
									fecha_fin = '".$fecha_fin."',
									ip = '$ip',
									host = '$host',
									modi_por = $idusr,
									modi_el = NOW()
					Where idtarea = ".$idtarea;
		$result = mysql_query($query); 
		$ret = $result==false ? mysql_error():"OK";
		$IdTar=$idtarea;
		//$arr['message'] = 'Datos guardados con éxito! '.$ret;

	}

	for($i=0;$i<5;++$i){
		if ( isset($_FILES['file_'.$i])  ){
			$res2 = saveFileTarea($_FILES['file_'.$i],'foto-'.$i,$arr,$idtareaexistente,$IdTar,$idemp,$i);
			if ( $res2['status'] == "OK" ){

				$query = "Insert Into tareas_archivos(
											idtarea,
											directorio,
											archivo,
											idemp,
											ip,
											host,
											creado_por,
											creado_el
										)value( 
											$IdTar,
											'up_tareas/',
											'".$res2['image']."',
										    $idemp,
								    		'$ip',
								    		'$host',
								    		$idusr,
								    		NOW()
								    		)";
				$result = mysql_query($query); 
				$arr = $res2;
				
			}	
		}
	}


	$dArr = explode('|',$destinatarios);
	foreach ($dArr as $key => $value) {
				$df = explode('°',$dArr[$key]);
				$idbol = $df[0];
				$iddes = $df[1];
				$des = intval($iddes);

				if ( $des > 0 ){
					$query = "Insert Into tareas_dest(
												idtarea,
												idboleta,
												idremitente,
												iddestinatario,
												idemp,
												ip,
												host,
												creado_por,
												creado_el
											)value( 
												$IdTar,
												".$idbol.",
												$idusr,
												".$iddes.",
											    $idemp,
									    		'$ip',
									    		'$host',
									    		$idusr,
									    		NOW()
									    		)";
					$result = mysql_query($query); 
			 	}

	}

}else{

	$arr['status'] = 'Error';
	$arr['message'] = 'No se ha podido conectar al servidor!';
	$arr['image'] = 'none';

}

mysql_close($mysql);

echo json_encode($arr);



function saveFileTarea($file,$descripcion="",$arr=array(),$objeto,$idtarea,$idemp,$i){
	if( isset($file) ){
		if(!preg_match('/\.(jpe?g|gif|png|pdf|doc|docx|xls|xlsx|ppt|pptx|txt)$/' , $file['name'])
			
		) {
		
			$arr['status'] = 'ERR';
			$x = end(explode(".", $file['name']));
			$arr['message'] = 'Formato incorrecto de archivo: '.$x;
		
		} else {

			$i=0;
			$name = $file['name'];
			//$nameFile = md5($name).time();
			$nameFile = $idtarea.'_'.$idemp.'_'.$i;
			$ext = end(explode(".", $name));
			$nFle   = $nameFile.".".strtolower($ext);//$file['name']."_|_".$curp."_|_";

			$save_path = '../../../up_tareas/'.$nFle;

			
			while (file_exists($save_path)) {

				$name = $file['name'];
				//$nameFile = md5($name).time();
				$y = ++$i;
				$nameFile = $idtarea.'_'.$idemp.'_'.$y;
				$ext = end(explode(".", $name));
				$nFle   = $nameFile.".".strtolower($ext);//$file['name']."_|_".$curp."_|_";

				$save_path = '../../../up_tareas/'.$nFle;

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
		
	}else{
				$arr['status'] = 'OK';
				$arr['message'] = 'Archivo subido satisfactoriamente!';
				$arr['image'] = $objeto;
				$arr['thumb'] = '';

	}
	
	return $arr;

}






?>