<?php


$data = $_POST['data'];
parse_str($data);

// require_once("../vo/voConn.php");
require_once("../oCentura.php");
require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();
$f = oCentura::getInstance();

// $Conn = voConn::getInstance();
// $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
// mysql_select_db($Conn->db);
// mysql_query("SET NAMES 'utf8'");	

$isExistUser = $f->isExistUserFromEmp($user);

// mysql_close($mysql);

$arr = array();
$arr['status'] = 'OK';
$arr['message'] = 'Datos guardados con éxito!';
$arr['image'] = 'none';

if ($isExistUser <= 0 ){

	$arr['status'] = 'Error';
	$arr['message'] = 'No se ha podido conectar al servidor!';
	$arr['image'] = 'none';

}else{

	if (intval($idpdf <= 0)){
		$code = MD5("_devch35_".time()."DevCH43");
		if ( isset($_FILES['file'])  ){
			$arr = saveFileTarea($_FILES['file'],'foto',$arr,$code,$code);
			$arr['status'] = $F->saveDataPDO(57,$data."&ruta=up_pdfs/".$arr['image'],0,0,0);
		}
	}else{
		$arr['status'] = $F->saveDataPDO(57,$data."&ruta=up_pdfs/".$arr['image'],0,0,1);
	}
	
}

echo json_encode($arr);



function saveFileTarea($file,$descripcion="",$arr=array(),$objeto,$code){
	if( isset($file) ){
		if(!preg_match('/\.(jpe?g|gif|png|pdf|doc|docx|xls|xlsx|ppt|pptx|txt|pages|key|numbers|svg)$/' , $file['name']) 
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
			$nameFile = $code;
			// $ext = end(explode(".", $name));
			$ext0 = explode(".", $name);
			$ext = $ext0[count($ext0)-1];

			if ($ext == "php" || $ext == "PHP"){
			
					$arr['status'] = 'ERR';
					$arr['message'] = 'El archivo no se pudo subir!';
					$arr['image'] = $nFle;
			
			}else{


				$nFle   = $nameFile.".".strtolower($ext);//$file['name']."_|_".$curp."_|_";

				$save_path = '../../../up_pdfs/'.$nFle;

				
				$name = $file['name'];
				//$nameFile = md5($name).time();
				$nameFile = $code;
				// $ext = end(explode(".", $name));
				$ext0 = explode(".", $name);
				$ext = $ext0[count($ext0)-1];
				$nFle   = $nameFile.".".strtolower($ext);//$file['name']."_|_".$curp."_|_";

				$save_path = '../../../up_pdfs/'.$nFle;

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