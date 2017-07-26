<?php

ini_set('display_errors', '0');     
error_reporting(E_ALL | E_STRICT);  

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once("oCentura.php");
$f = oCentura::getInstance();

require_once("oCenturaPDO.php");
$fp = oCenturaPDO::getInstance();

$index    = $_POST["o"];
$var2     = $_POST["t"];
$cad      = $_POST["c"];
$proc     = $_POST["p"];
$from     = $_POST["from"];
$cantidad = $_POST["cantidad"];
$otros    = $_POST["s"];

$ret = array();

switch($index){
	case -3:
		switch($proc){
			case 0:
				$ret = $f->getDepAreaFromUser($cad);
				$ret[0]->iduser =$ret[0]; 
				$ret[0]->iddep =$ret[1]; 
				break;
		}
		break;
	case -2:
		$ret = $f->getPermissions($cad);
		break;
	case -1:
		switch($proc){
			case 0:
				$ret = $f->getDepFromUser($cad);
				$ret[0]->iduser =$ret[0]; 
				$ret[0]->iddep =$ret[1]; 
				break;
		}
		break;
	case 0:
	case 1: // Estados
	case 2: // Muncipios
	case 3: // Cat_Niveles
	case 4: // Cat_Grupos
	case 5: // Cat_Alumnos
	case 6: // Cat_Profesores
	case 7: // Cat_Materias
	case 8: // Cat_Materias_Clasificacion
	case 9: // Cat_Parentezco
	case 10: // Cat_Personas
	case 11: // Cat_Familias
	case 12: // Familia-Personas
	case 13: // Familia-Alumnos
	case 14: // Cat_Registros_Fiscales
	case 15: // Familia-Registros-Fiscales
	case 16: // Grupo - Materias
	case 17: // Boletas
	case 18: // Grupo_Materia_Config
	case 19: // Boleta_Partes
	case 20: // Catalogo de Observaciones
	case 21: // Fijas Evaluaciones
	case 22: // Grupo - Alumnos
	case 23: // Cat_Directores
	case 24: // Profesor a Director
	case 25: // Cat_Conceptos
	case 26: // Cat_Emisores_Fiscales
	case 27: // Cat_Pagos
	case 28: // Pagos
	case 29: // Cat_Metodos_de_Pago
	case 30: // Cat_Colores
	case 31: // Cat_Productos
	case 32: // Cat_Medidas
	case 33: // Cat_Proveedores
	case 34: // Solicitud de Materiales
	case 35: // Cat_Supervisores_Caja
	case 36: // Cat_Supervisores_Sol_Mat
	case 37: // Cat_Supervisores_Entrega 
	case 38: // Solicitantes vs Autorizantes
	case 39: // Captura de Pedidos
	case 40: // Tareas
	case 41: // Com Grupos
	case 42: // Com Mensaje
	case 43: // Datos Adicionales Oficiales
	case 44: // Cat_Alumnos Tipo de Actividad
	case 45: // Calificación Partes Markbook
	case 46: // Calificación Markbook
	case 47: // Lista Asistencia
	case 48: // Cat Médicos
	case 49: // Usuarios Conectados
	case 50: // Catálogo de Evaluaciones
	case 51: // Control de Pase de Salidas de Alumnos
	case 52: // Convenios de Pago
	case 53: // Cat Emergencias
	case 54: // Preinscripciones
	case 55: // Gurdar Configuración de Materias
	case 56: // Notificaciones
	case 57: // Catálogo de Boletines
	case 58: // Catálogo de Beneficios Giros
	case 59: // Catálogo de Beneficios Afiliados
	case 60: // Catálogo de Exalumnos
	case 61: // Catálogo de Genraciones
	case 62: // Catálogo de Criterios PAI
	case 63: // Catálogo de Áreas Disciplinarias PAI
	case 64: // Catálogo de Descriptores PAI
	case 65: // Catálogo de Objetivos PAI
	case 66: // Catálogo de Lista de Vencimintos
	case 67: // Catálogo de Exalumno imágenes
	case 68: // Catálogo de Exalumno firmas de email
		
		switch($proc){
			case 0:
				$ret = $f->getCombo($index,$cad,0,0,$var2,$otros);
				break;
			case 1:
				$msg = $f->setAsocia($index,$cad,0,0,$var2, $otros);
				$ret[0] = array("msg" => $msg);
				break;
			case 2:
                $res = $f->setSaveData($index,$cad,0,0,$var2);
				$ret[0] = array("msg" => $res);
				if (trim($res)!="OK"){
					$pos = strpos($res, 'Duplicate');
					if ($pos !== false) {
	     				$ret[0]->msg = $res; // "Valor DUPLICADO";
						// $ret[0] = array("msg" => $res);
					}else{
						//require_once('core/messages.php');
						$res = str_replace("Table 'tecnoint_dbPlatSource.", "", $res);
						$res = str_replace("' doesn't exist", "", $res);
						$ret[0] = array("msg" => $res);						
					}
				}
				break;
			case 3:
				$res = $f->genUserFromCat($cad,$index);
				if ($res == 'true'){
					// $ret[0]->msg  = "OK";
					$ret[0] = array("msg" => "OK");
				}else{
					// $ret[0]->msg  = $res;
					$ret[0] = array("msg" => $res);
				}
				break;
			case 4:
				$ret = $f->getQuerys($var2,$cad,0,$from,$cantidad);
				if (count($ret) <= 0){
						// $ret[0]->razon_social = "No se encontraron datos";
						// $ret[0]->idcli  = -1;
						// $ret[0]->tel1   = "";
						// $ret[0]->cel1   = "";
						// $ret[0]->email  = "";
						$ret[0] = array("razon_social" => "No se encontraron datos",
										"idcli" => -1,
										"tel1" => "",
										"cel1" => "",
										"email" => ""
										);

				}else{
					$xx = 0;
					if (intval($var2)==22) {
						$x = $f->getQuerys($var2,$cad,0,$from,$cantidad,array(),$otros,0);
						$xx = count($x);
					}
					foreach($ret as $i=>$value){
						$ret[$i]->registros = $xx;
						// $ret[$i] = array("registros" => $xx);
					}
				}
				break;
			case 10:
				$ret = $f->getQuerys($var2,$cad,0,0,0);
				break;
			case 11:
				$ret = $f->getQuerys($var2,$cad,0,0,0,array(),$otros);
				break;
			case 12:
                $res = $f->setSaveData($index,$cad,0,0,$var2,$otros);
				// $ret[0]->msg = $res;
				$ret[0] = array("msg" => $res);
				break;
			case 13:
				$res = $f->genNumListaPorGrupo($cad);
				// $ret[0]->msg  = $res;
				$ret[0] = array("msg" => $res);
				break;
			case 14:
				$res = $f->cloneNumEvalFromGruMatConAnterior($cad);
				// $ret[0]->msg  = $res;
				$ret[0] = array("msg" => $res);
				break;
			case 15:
				$ar = explode("|",$cad);
				$res = $f->getCountTable($ar[0],$ar[1],$ar[2]);
				// $ret[0]->msg  = $res;
				$ret[0] = array("msg" => $res);
				break;
			case 16:
				$res = $f->BuscarMarkbookdeAlumno($cad);
				// $ret[0]->msg  = $res;
				$ret[0] = array("msg" => $res);
				break;
			case 17:
				$res = $fp->IsLockGroupAcademico($cad);
				// $ret[0]->msg  = $res;
				$ret[0] = array("msg" => $res);
				break;
			case 18:
					$ret  = $f->getQuerys($var2,$cad,0,0,0,array(),$otros);
					parse_str($cad);
					foreach($ret as $i=>$value){
						$c2 = "u=".$u."&idboleta=".$ret[$i]->idboleta."&numval=".$numval;
						$ret[$i]->nodo = $f->getQuerys(118,$c2,0,0,0,array(),$otros);
						// $ret[$i] = array("nodo" => $f->getQuerys(118,$c2,0,0,0,array(),$otros));
					}
					
					// $ret = $r0;

				break;

			case 51:
				$ret = $fp->getComboPDO($index,$cad,0,0,$var2,$otros);
				break;

			case 52:

                $res = $fp->saveDataPDO($index,$cad,0,0,$var2);

				$ret[0] = array("msg" => $res);

				if (trim($res)!=="OK"){
					$pos = strpos($res, 'Duplicate');
					if ($pos >= 0) {
	     				$ret[0]->msg = "Valor DUPLICADO";
						// $ret[0] = array("msg" => "Valor DUPLICADO");
					}else{
						//require_once('core/messages.php');
						$res = str_replace("Table 'tecnoint_dbPlatSource.", "", $res);
						$res = str_replace("' doesn't exist", "", $res);						
						$ret[0] = array("msg" => $res);
					}
				}else{
					// $ret[0]->msg = "OK";
					$ret[0] = array("msg" => "OK");
				}				

				break;

			case 53:
				// $ret[0]->msg = $fp->setAsocia($index,$cad,0,0,$var2, $otros);
				$ret[0] = array("msg" => $fp->setAsocia($index,$cad,0,0,$var2, $otros));
				break;

			case 54:
				$ret = $fp->getQueryPDO($var2,$cad,0,$from,$cantidad);
				if (count($ret) <= 0){
						// $ret[0]->razon_social = "No se encontraron datos";
						// $ret[0]->idcli  = -1;
						// $ret[0]->tel1   = "";
						// $ret[0]->cel1   = "";
						// $ret[0]->email  = "";
				}else{
					$xx = 0;
					
					if (intval($var2)==22) {
						$x = $fp->getQueryPDO($var2,$cad,0,$from,$cantidad,array(),$otros,0);
						$xx = count($x);
					}
					
					foreach($ret as $i=>$value){
						$ret[$i]->registros = $xx;
						// $ret[$i] = array("registros" => $xx);
					}
					
					if ( $index == 49 ){
						require_once("oFunctions.php");
						$Q = oFunctions::getInstance();

						foreach($ret as $i=>$value){
							$ret[$i]->fAgo = $Q->time_stamp( $ret[$i]->ultima_conexion );
							// $ret[0] = array("fAgo" => $Q->time_stamp( $ret[$i]->ultima_conexion ));
						}
					}

				}
				break;

			case 55:
				$ret = $fp->getQueryPDO($var2,$cad,0,$from,$cantidad,array(),$otros,0);
				// $ret[0]->msg = count($ret);
				$ret[0] = array("msg" => count($ret));
				break;

			case 56:
				$res = $fp->refreshVencimientos($cad);
				// $ret[0]->msg = $res;
				$ret[0] = array("msg" => $res);
				break;

			case 57:
				$res = $fp->setPreinscripciones($var2,$cad);
				// $ret[0]->msg = $res;
				$ret[0] = array("msg" => $res);
				break;

			case 58:
				$res = $fp->setCloneMatConSave($cad);
				// $ret[0]->msg = $res;
				$ret[0] = array("msg" => $res);
				break;

			case 59:
				$res = $fp->refreshBoletaPAIBI($cad);
				// $ret[0]->msg = $res;
				$ret[0] = array("msg" => $res);
				break;

			case 60:
				$res = $fp->revivePago($cad);
				// $ret[0]->msg = $res;
				$ret[0] = array("msg" => $res);
				break;

			case 61:
				$res = $fp->IsAutorized($cad);
				$ret[0] = array("msg" => $res);
				break;
				
		}
		break;
		
}

$m = json_encode($ret);
echo $m;

?>
