<?php


$data = $_POST['data'];
parse_str($data);

require_once("../oCentura.php");
$f = oCentura::getInstance();

$idusr = $f->getPubIdUser($user);
$idemp = $f->getPubIdEmp($user);

$ip=$_SERVER['REMOTE_ADDR']; 
$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 

$isExistUser = $f->isExistUserFromEmp($user);

$isFiles = false;

$idtareaexistente = $idtareadestinatario;

$arr = array();

if ($v4 !== md5($user.$idtareadestinatario) || $isExistUser <= 0 ){

	$arr['status'] = 'Error';
	$arr['message'] = 'No se ha podido conectar al servidor!';
	$arr['image'] = 'none';

	echo json_encode($arr);	

}else{

	$IdTar=$idtareadestinatario;

	for($i=0;$i<5;++$i){
		if ( isset($_FILES['file_'.$i])  ){			
			$isFiles = true;
			$res2 = saveFileTarea($_FILES['file_'.$i],'foto-'.$i,$arr,$idtareaexistente,$IdTar,$idemp,$i);
			if ( $res2['status'] == "OK" ){

				$query = "Insert Into tareas_dest_resp_archivos(
											idtareadestinatario,
											directorio,
											archivo,
											descripcion_archivo,
											idemp,
											ip,
											host,
											creado_por,
											creado_el
										)value( 
											$IdTar,
											'up_tareas/',
											'".$res2['image']."',
											'$descripcion_archivo',
										    $idemp,
								    		'$ip',
								    		'$host',
								    		$idusr,
								    		NOW()
								    		)";
				$result = $f->guardarDatos($query);
				
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


function saveFileTarea($file,$descripcion="",$arr=array(),$objeto,$idtareadestinatario,$idemp,$i){
	if( isset($file) ){
		if(!preg_match('/\.(jpe?g|gif|png|pdf|doc|docx|xls|xlsx|ppt|pptx|txt|mp3|mp4|pages|key|numbers|svg)$/' , $file['name'])
			
		) {
		
			$arr['status'] = 'ERR';
			// $x = end(explode(".", $file['name']));
			$ext0 = explode(".", $file['name']);
			$x = $ext0[count($ext0)-1];
			$arr['message'] = 'Formato incorrecto de archivo: '.$x;
		
		} else {

			$i=0;
			$name = $file['name'];
			//$nameFile = md5($name).time();
			$nameFile = $idtareadestinatario.'_'.$idemp.'_'.$i;
			// $ext = end(explode(".", $name));
			$ext0 = explode(".", $name);
			$ext = $ext0[count($ext0)-1];

			if ($ext == "php" || $ext == "PHP"){
			
					$arr['status'] = 'ERR';
					$arr['message'] = 'El archivo no se pudo subir!';
					$arr['image'] = $nFle;
			
			}else{


				$nFle   = $nameFile."_r.".strtolower($ext);//$file['name']."_|_".$curp."_|_";

				$save_path = '../../../up_tareas/'.$nFle;

				
				while (file_exists($save_path)) {

					$name = $file['name'];
					//$nameFile = md5($name).time();
					$y = ++$i;
					$nameFile = $idtareadestinatario.'_'.$idemp.'_'.$y;
					// $ext = end(explode(".", $name));
					$ext0 = explode(".", $name);
					$ext = $ext0[count($ext0)-1];
					$nFle   = $nameFile."_r.".strtolower($ext);//$file['name']."_|_".$curp."_|_";

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