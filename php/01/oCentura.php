<?php

/*
ini_set('display_errors', '0');     
error_reporting(E_ALL | E_STRICT);  

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
*/


date_default_timezone_set('America/Mexico_City');

require_once('vo/voConn.php');
require_once('vo/voConnPDO.php');
require_once('vo/voCombo.php');
require_once('vo/voUsuario.php');

require_once('vo/voEmpty.php');

/*

require_once('vo/voAvaluo.php');
require_once('vo/voAvaluoZona.php');
require_once('vo/voAvaluoInmueble.php');
require_once('vo/voEAFCompConstruccion.php');

*/

require_once('vo/voEstado.php');
require_once('vo/voMunicipio.php');

class oCentura {
	 
	 private static $instancia;
	 public $IdEmp;
	 public $IdUser;
	 public $User;
	 public $Pass;
	 public $Nav;
	 public $URL;
	 public $defaultMail;
	 public $CID;
	 public $Mail;
	 public $Foto;
	 public $iva;
	 
	 private function __construct(){ 
	 		$this->Nav      = "Ninguno";
			$this->IdUser    = 0;
			$this->User     = "";
			$this->Pass     = "";
			$this->iva      = 0.16;
			$this->URL      = "http://platsource.mx/";
	 }

	 public static function getInstance(){
				if (  !self::$instancia instanceof self){
					  self::$instancia = new self;
				}
				return self::$instancia;
	 }

	 public function getFolioTim($serie, $idemp){
		    mysql_query("SET NAMES UTF8");		
		    $result = mysql_query("select max(folio) as folio from facturas_encabezado where serie = '$serie' and idemp = $idemp and isfe = 1 limit 1 ");

			if (!$result) {
    				$ret=1;
			}else{
    				$ret=intval(mysql_result($result, 0))+1;
			}

		    return $ret;
	 }

	 public function getFolio($serie){
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select max(folio) as folio from facturas_encabezado where serie = '$serie' limit 1 ");

			if (!$result) {
    				$ret=1;
			}else{
    				$ret=intval(mysql_result($result, 0))+1;
			}

		    return $ret;
	 }

	 

	 private function getIdUserFromAlias($str){
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select iduser from usuarios where username = '$str' and status_usuario = 1");

			if (!$result) {
    				$ret=0;
			}else{
    				$ret=intval(mysql_result($result, 0,"iduser"));
			}
		    return $ret;
	 }

	 private function getIdEmpFromAlias($str){
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select idemp from usuarios where username = '$str' and status_usuario = 1");

			if (!$result) {
    				$ret=0;
			}else{
    				$ret=intval(mysql_result($result, 0,"idemp"));
			}
		    return $ret;
	 }

	 private function getCicloFromIdEmp($idemp=0){
		    mysql_query("SET NAMES UTF8");
		  
		    $res = mysql_query("select idciclo from cat_ciclos where idemp = $idemp and predeterminado = 1 and status_ciclo = 1 limit 1");

			$num_rows = mysql_num_rows($res);

			if ($num_rows <= 0) {
    			$ret=0;
			}else{
					$row = mysql_fetch_row($res);
    				$ret = intval($row[0]);
			}
		    return $ret;
	 }

	 private function getCicloAntFromIdEmp($idemp=0){
		    mysql_query("SET NAMES UTF8");
		  
		    $res = mysql_query("select anterior from cat_ciclos where idemp = $idemp and predeterminado = 1 and status_ciclo = 1 limit 1");

			$num_rows = mysql_num_rows($res);

			if ($num_rows <= 0) {
    			$ret=0;
			}else{
					$row = mysql_fetch_row($res);
    				$ret = intval($row[0]);
			}
		    return $ret;
	 }




	 private function getIdFamFromIdUser($IdUsername=0, $type=0){
		    mysql_query("SET NAMES UTF8");
		    
		    if ($type == 0){
			    $res = mysql_query("SELECT idfamilia FROM _viFamPer WHERE idusername = $IdUsername AND status_famper = 1 LIMIT 1");
		    }else if  ($type == 1) {
			    $res = mysql_query("SELECT idfamilia FROM _viFamAlu WHERE iduseralufortutor = $IdUsername AND status_famalu = 1 LIMIT 1");
		    }

			$num_rows = mysql_num_rows($res);

			if ($num_rows <= 0) {
    			$ret=0;
			}else{
					$row = mysql_fetch_row($res);
    				$ret = intval($row[0]);
			}
		    return $ret;
	 }

	private function sayLiked($tipo,$val=""){
			switch(intval($tipo)){
					case 1:
					    return $val."%";
						break;
					case 2:
					    return "%".$val;
						break;
					default:
					    return "%".$val."%";
						break;
			}
	}	

	private function getIdProfFromAlias($str){
	    mysql_query("SET NAMES UTF8");
	  
	    $result = mysql_query("select idprofesor from _viProfesores where username = '$str' and status_usuario = 1");

		if (!$result) {
				$ret=0;
		}else{
				$ret=intval(mysql_result($result, 0,"idprofesor"));
		}
	    return $ret;
	}

	public function isExistUserFromEmp($user=""){
		    mysql_query("SET NAMES UTF8");
		  	$idemp = $this->getPubIdEmp($user);
		    $result = mysql_query("select iduser from usuarios where username = '$user' and status_usuario = 1 and idemp = ".$idemp." limit 1");
			if (!$result) {
    				$ret=0;
			}else{
    				$ret=intval(mysql_result($result, 0,"iduser"));
			}
		    return $ret;
	 }

     public function getCombo($index=0,$arg="",$pag=0,$limite=0,$tipo=0,$otros=""){

		  // $Conn = voConnPDO::getInstance();
		  $Conn = voConn::getInstance();
		  $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  mysql_select_db($Conn->db);
		  mysql_query("SET NAMES UTF8");

		  $arr = array('voCombo');
		  $indice = 0;
		  $ret = array();
		  $query="";
		 
            	switch ($index){
					case -2:
						switch($tipo){
							case 0:
								parse_str($arg);
								$pass = md5($password);
								$query = "SELECT username as label, iduser as data 
										FROM  _viUsuarios where username = '$username' and password = '$pass' and status_usuario = 1 ";
								break;		
						}
						break;
					case -1:// valida loguin de usuarios
			          	$ar = explode(".",$arg);
						$pass = md5($ar[1]);
						$query = "SELECT username as label,password as data 
								FROM usuarios 
								Where username = '$ar[0]' and password = '$pass' and status_usuario = 1";
						break;
					case 0:
						switch($tipo){
							case 0:
								parse_str($arg);
								$pass = md5($passwordL);
								$query = "SELECT username as label, concat(iduser,'|',password,'|',idemp,'|',empresa,'|',idusernivelacceso,'|',registrosporpagina,'|',clave,'|',param1,'|',nombre_completo_usuario) as data 
										FROM  _viUsuarios where username = '$username' and password = '$pass' and status_usuario = 1";
								break;		
							case 1:
								parse_str($arg);
								$pass = md5($passwordL);
								$query = "SELECT username as label, concat(iduser,'|',password,'|',idemp,'|',empresa,'|',idusernivelacceso,'|',registrosporpagina,'|',clave,'|',param1,'|',nombre_completo_usuario) as data 
										FROM  _viUsuarios where username = '$username' and password = '$pass' and status_usuario = 1";
								break;		
							case 2:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nivel_de_acceso as label,idusernivelacceso as data 
										FROM usuarios_niveldeacceso where idemp = $idemp
										Order By label asc ";
								break;		
							case 3:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(username,' - ',apellidos,' ',nombres) as label, iduser as data 
										FROM  _viUsuarios where idemp = $idemp and status_usuario = 1 and idusernivelacceso = 1";
								break;		
							case 4:
								parse_str($arg);
								$pass = md5($passwordL);
								$query = "SELECT username as label, concat(
																		iduser,'|',
																		password,'|',
																		idemp,'|',
																		idusernivelacceso,'|',
																		registrosporpagina,'|',
																		clave,'|', 
																			CASE param1 
																				WHEN '' THEN -1
																				WHEN NULL THEN -2 
																				ELSE param1 END,'|',
																		nombre_completo_usuario) 
														as data 
										FROM  _viUsuarios where username = '$username' and password = '$pass' and status_usuario = 1";
								break;		
						}
						break;						
					case 1:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT municipio as label, idmunicipio as data 
										FROM cat_municipios where idestado = $otros and status_municipio = 1 and idemp = $idemp
										Order By data asc ";
								break;		
							case 1:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT estado as label, idestado as data 
										FROM cat_estados where idemp = $idemp and status_estado = 1 and idemp = $idemp
										Order By data asc ";
								break;		
							case 2:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT CASE WHEN predeterminado = 1 THEN CONCAT(ciclo,' (default)') else ciclo end as label, idciclo as data, predeterminado 
											FROM cat_ciclos 
											WHERE idemp = $idemp and status_ciclo = 1 Order By data asc  ";
								break;		

							case 3:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nivel as label, idnivel as data 
										FROM cat_niveles where idemp = $idemp and status_nivel = 1
										Order By data asc ";
								break;		

							case 4:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo as label, idgrupo as data 
										FROM cat_grupos where idemp = $idemp and status_grupo = 1  and visible = 1
										Order By data asc ";
								break;		
							case 5:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nombre_alumno as label, idalumno as data 
										FROM _viAlumnos where idemp = $idemp and status_alumno = 1
										Order By label asc ";
								break;		
							case 6:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo as label, idgrupo as data 
										FROM _viNivel_Grupos where idemp = $idemp and idciclo = $idciclo and idnivel = $otros and grupo_ciclo_nivel_visible = 1
										Order By idgrupo asc ";
								break;		
							case 7:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT clasificacion as label, idmatclas as data 
										FROM cat_materias_clasificacion where idemp = $idemp and status_materia_clasificacion
										Order By idmatclas asc ";
								break;		
							case 8:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT parentezco as label, idparentezco as data 
										FROM cat_parentezcos where idemp = $idemp and status_parentezco
										Order By idparentezco asc ";
								break;		
							case 9:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(ap_paterno,' ',ap_materno,' ',nombre) as label, idpersona as data 
										FROM  cat_personas where idemp = $idemp and status_persona = 1 $otros ";
								break;		
							case 10:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nombre_persona as label, idpersona as data, parentezco, email1, email2, 
												 fecha_nacimiento, cfecha_nacimiento, lugar_nacimiento_persona, 
												username_persona, idfamper, tel1, tel2, cel1, cel2 
										FROM _viFamPer where idfamilia = $idfamilia and idemp = $idemp and status_famper = 1
										Order By parentezco asc ";
								break;		
							case 11:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(razon_social,' - ',rfc) as label, idregfis as data 
										FROM _viRegFis where idemp = $idemp and status_regfis = 1
										Order By razon_social asc ";
								break;		
							case 12:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nombre_profesor as label, idprofesor as data 
										FROM _viProfesores where idemp = $idemp and status_profesor = 1
										$otros ";
								break;		
							case 13:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT materia as label, idmateria as data 
										FROM _viMaterias where idemp = $idemp and status_materia = 1
										$otros ";
								break;		
							case 14:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT alumno as label, idgrualu as data 
										FROM _viGrupo_Alumnos where idciclo = $idciclo and idgrupo = $idgrupo and idemp = $idemp and status_grualu = 1
										$otros ";
								break;		
							case 15:
								parse_str($arg);

								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT alumno as label, idboleta as data 
										FROM _viBoletas where idgrumat = $idgrumat and idemp = $idemp
										$otros ";
								break;		
							case 16:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT distinct grupo as label, idgrupo as data, ispai_grupo 
										FROM _viGrupo_Materias where idciclo = $idciclo and idprofesor = $idprofesor and isagrupadora = 0 and grupo_visible = 1 
										$otros ";
								break;		
							case 17:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT materia as label, idgrumat as data, eval_default, eval_mod, materia_bloqueada, idpaiareadisciplinaria    
										FROM _viGrupo_Materias where idciclo = $idciclo and idprofesor = $idprofesor and idgrupo = $idgrupo and isagrupadora = 0 $otros ";
								break;	
									
							case 18:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT materia as label, idgrumat as data 
										FROM _viGrupo_Materias where  idciclo = $idciclo and idgrupo = $idgrupo and isagrupadora = 1 and idemp = $idemp $otros ";
								break;	

							case 19:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT materia as label, idgrumat as data 
										FROM _viGrupo_Materias where  idciclo = $idciclo and idgrupo = $idgrupo and isagrupadora = 0 and idemp = $idemp $otros ";
								break;	

							case 20:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT materia as label, idgrumat as data 
										FROM _viGrupo_Materias where  idciclo = $idciclo and idgrupo = $idgrupo and padre = $idgrumat and idemp = $idemp $otros ";
								break;	
							case 21:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								//$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT alumno as label, idgrualu as data, num_lista, clave_nivel, 
												genero, idalumno, usernamealumno, nombre_tutor, idfamilia, 
												familia, email_tutor1, email_tutor2, email_fiscal, 
												username_tutor, idtutor, ap_paterno, ap_materno, nombre, 
												tel1_tutor, tel2_tutor, cel1_tutor, cel2_tutor, grupo,
												fn_tutor, cfn_tutor, idemp, curp, iduseralu
										FROM _viGrupo_Alumnos where idemp = $idemp and idciclo = $idciclo and idgrupo = $idgrupo and status_grualu = 1 order by num_lista ";
								break;		
							case 22:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo as label, idgrupo as data 
										FROM _viGrupo_Alumnos where clave_nivel = $clave_nivel and idemp = $idemp and status_grupo = 1
										Order By data asc ";
								break;

							case 23:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT observacion as label, idobservacion as data 
										FROM cat_observaciones where idemp = $idemp and status_observacion = 1 
										Order By data asc ";
								break;		

							case 24:
								parse_str($arg);
								// $idemp = $this->getIdEmpFromAlias($user);
								$query = "SELECT distinct abreviatura as label, idgrumat as data 
										FROM _viBoletas where idgrupo = $idgrupo and idciclo = $idciclo
										$otros ";
								break;		


							case 25:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(director,' - ',nivel) as label, iddirector as data 
										FROM _viDirectores where idemp = $idemp and status_director = 1
										Order By data asc ";
								break;		

							case 26:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT razon_social as label, concat(idemisorfiscal,'-',serie) as data  
										FROM cat_emisores_fiscales where idemp = $idemp and status_emisor_fiscal = 1
										Order By data asc ";
								break;		

							case 27:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concepto as label, idconcepto as data 
										FROM cat_conceptos where idemp = $idemp and status_concepto = 1
										Order By data asc ";
								break;		

							case 28:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nivel as label, clave_nivel as data 
										FROM cat_niveles where idemp = $idemp and status_nivel = 1
										Order By data asc ";
								break;		

							case 29:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT distinct familia as label, idfamilia as data, nombre_tutor as tutor 
										FROM _viFamAlu 
										where idemp = $idemp and status_famalu = 1 and familia != 'null'
										Order By label asc ";
								break;	

							case 30:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(razon_social,' - ',rfc) as label, idregfis as data, predeterminado 
										FROM _viFamRegFis where idemp = $idemp and idfamilia = $idfamilia and status_famregfis = 1
										Order By razon_social asc ";
								break;		

							case 31:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT metodo_de_pago as label, idmetododepago as data, metodo_de_pago_predeterminado as isdefault, clave
										FROM cat_metodos_de_pago where idemp = $idemp and status_metodo_de_pago = 1
										Order By clave asc ";
								break;		

							case 32:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT color as label, idcolor as data, codigo_color_hex
										FROM cat_colores where idemp = $idemp and status_color = 1
										Order By data asc ";
								break;		

							case 33:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT producto as label, idproducto as data
										FROM cat_productos where idemp = $idemp and status_producto = 1
										Order By data asc ";
								break;		

							case 34:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT medida2 as label, idmedida as data
										FROM cat_medidas where idemp = $idemp and status_medida = 1
										Order By data asc ";
								break;		

							case 35:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT proveedor as label, idproveedor as data
										FROM cat_proveedores where idemp = $idemp and status_proveedor = 1
										Order By data asc ";
								break;	

							case 36:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(apellidos,' ',nombres) as label, iduser as data 
										FROM  _viUsuarios where idemp = $idemp and status_usuario = 1 
										ORDER BY label asc";
								break;
	
							case 37:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT autorizan as label, idusersupervisorsolmat as data 
										FROM  _viSupervisorSolMat where idemp = $idemp and status_supervisor_sol_mat = 1 
										ORDER BY label asc";
								break;

							case 38:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(producto,' ',medida1) as label, idproducto as data, costo_unitario
										FROM _viProductos where idemp = $idemp and status_producto = 1
										Order By label asc ";
								break;		
							case 39:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT distinct solicitan as label, idsolicita as data 
										FROM _viSolAut where idemp = $idemp
										Order By label asc ";
								break;	

							case 40:
								parse_str($arg);
								$iduseralu = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT distinct materia as label, idboleta as data 
										FROM _viBoletas where idciclo = $idciclo and iduseralu = $iduseralu and grupo_visible = 1 and isagrupadora_grumat = 0 
										$otros ";
								break;		
	
							case 41:
								parse_str($arg);
								$idusertutor = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
						        $idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT alumno as label, iduseralufortutor as data 
										FROM _viFamAlu where idusertutor = $idusertutor and status_famalu = 1 
										$otros ";
								break;		

							case 42:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT distinct materia as label, idboleta as data 
										FROM _viBoletas where idciclo = $idciclo and iduseralu = $iduseralu and grupo_visible = 1 and isagrupadora_grumat = 0
										$otros ";
								break;	

							case 43:
								parse_str($arg);
								$idusertutor = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);

								$query = "SELECT familia as label, idfamilia as data, nombre_tutor 
										FROM _viFamAlu where idusertutor = $idusertutor and status_famalu = 1 and idemp = $idemp
										$otros ";
								break;		

							case 44:
								parse_str($arg);
								$idusertutor = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);

								$query = "SELECT alumno as label, idalumno as data 
										FROM _viFamAlu where idusertutor = $idusertutor and status_famalu = 1 and idemp = $idemp
										$otros ";
								break;		

							case 45:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nivel as label, clave_nivel as data 
										FROM cat_niveles where idemp = $idemp and status_nivel = 1
										Order By data asc ";
								break;		

							case 46:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT grupo as label, idgrupo as data 
										FROM _viNivel_Grupos where idemp = $idemp and idciclo = $idciclo and clave_nivel = $clave_nivel and grupo_ciclo_nivel_visible = 1 and status_grupo = 1 
										Order By idgrupo asc ";
								break;		

							case 47:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);

								$query = "SELECT nivel_de_acceso as label, idusernivelacceso as data, clave
										FROM usuarios_niveldeacceso where idemp = $idemp and visible_in_com = 1 
										Order By clave asc ";
								break;		

							case 48:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT director as label, idusuariodirector as data 
										FROM _viDirectores 
										where idemp = $idemp and status_director = 1 and director != 'null'
										Order By label asc ";
								break;	

							case 49:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT distinct profesor as label, idusuarioprofesor as data 
										FROM _viGrupo_Materias 
										where idemp = $idemp and idciclo = $idciclo and idgrupo = $idgrupo and status_grumat = 1 and profesor != 'null'
										Order By label asc ";
								break;	

							case 50:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT distinct alumno as label, iduseralu as data 
										FROM _viGrupo_Alumnos 
										where idemp = $idemp and idciclo = $idciclo and idgrupo = $idgrupo and status_grualu = 1 and alumno != 'null'
										Order By label asc ";
								break;	

							case 51:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT distinct nombre_tutor as label, idusertutor as data 
										FROM _viGrupo_Alumnos 
										where idemp = $idemp and idciclo = $idciclo and idgrupo = $idgrupo and status_grualu = 1 and nombre_tutor != 'null' 
										Order By label asc ";
								break;	

							case 52:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT distinct nombre_completo_usuario as label, iduser as data 
										FROM _viUsuarios 
										where idemp = $idemp  and idusernivelacceso = $idusernivelacceso and status_usuario = 1 and nombre_completo_usuario != 'null' 
										Order By label asc ";
								break;	

							case 53:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
						        $iduserpropietario = $this->getIdUserFromAlias($u);				
								$query = "SELECT grupo as label, idcomgrupo as data 
										FROM com_grupos 
										where idemp = $idemp  and iduserpropietario = $iduserpropietario and status_com_grupo = 1 and grupo != 'null' 
										Order By label asc ";
								break;	

							case 54:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
						        $iduserpropietario = $this->getIdUserFromAlias($u);				
								$query = "SELECT usuario as label, iduser as data 
										FROM _viComGpoUser 
										where idemp = $idemp and idcomgrupo = $idcomgrupo 
										Order By label asc ";
								break;	

							case 55:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								//$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT distinct alumno as label, idalumno as data, idnivel, num_lista 
										FROM _viGrupo_Alumnos 
										where idemp = $idemp and idciclo = $idciclo and idgrupo = $idgrupo and status_grualu = 1 and alumno != 'null'
										Order By num_lista asc ";
								break;	

							case 56:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
						        $iduserpropietario = $this->getIdUserFromAlias($u);				
								$query = "SELECT descripcion_breve as label, idgrumatconmkb as data 
										FROM grupo_materia_config_markbook 
										where idemp = $idemp  and idgrumatcon = $idgrumatcon and status_grumatconmkb = 1
										Order By label asc ";
								break;

							case 57:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								// $idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT alumno as label, idgrualu as data, num_lista, clave_nivel, 
												genero, idalumno, usernamealumno, nombre_tutor, idfamilia, 
												familia, email_tutor1, email_tutor2, email_fiscal, username_tutor, idtutor
										FROM _viGrupo_Alumnos where idciclo = $idciclo and idgrupo = $idgrupo and idemp = $idemp and status_grualu = 1 order by num_lista ";
								break;		

							case 58:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);

								$query = "SELECT alumno as label, idalumno as data 
										FROM _viFamAlu where iduseralufortutor = $iduseralu and status_famalu = 1 and idemp = $idemp limit 1
										";
								break;		

							case 59:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT * 
										FROM _viGrupo_Alumnos where idciclo = $idciclo and idemp = $idemp and iduseralu = $iduseralu and status_grualu = 1
										$otros ";
								break;		

							case 60:
								parse_str($arg);
								$idusertutor = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
						        $idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT alumno as label, iduseralufortutor as data 
										FROM _viFamAlu where idusertutor = $idusertutor and status_famalu = 1 and idemp = $idemp and status_alumno = 1 
										$otros ";
								break;		

							case 61:
								parse_str($arg);
								$idusername = $this->getIdUserFromAlias($u);
						        $idemp      = $this->getIdEmpFromAlias($u);
						        $idfamilia  = $this->getIdFamFromIdUser($idusername,0);

								$query = "SELECT alumno as label, iduseralufortutor as data 
										FROM _viFamAlu where idfamilia = $idfamilia and status_famalu = 1 and idemp = $idemp
										$otros ";
								break;		

							case 62:
								parse_str($arg);
								$idusername = $this->getIdUserFromAlias($u);
						        $idemp      = $this->getIdEmpFromAlias($u);
						        $idfamilia  = $this->getIdFamFromIdUser($idusername,0);

								$query = "SELECT familia as label, idfamilia as data, nombre_tutor 
										FROM _viFamAlu where idfamilia = $idfamilia and status_famalu = 1 and idemp = $idemp
										$otros ";
								break;		

							case 63:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT ispai_materia, isagrupadora 
										FROM cat_materias where idemp = $idemp and status_materia = 1 and idmateria = $idmateria
										limit 1";
								break;		

							case 64:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT ispai_grupo 
										FROM cat_grupos where idemp = $idemp and status_grupo = 1 and idgrupo = $idgrupo
										limit 1";
								break;		

							case 65:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT area_disciplinaria as label, idpaiareadisciplinaria as data 
										FROM cat_pai_areas_disciplinarias where idemp = $idemp and status_area_disciplinaria
										Order By idpaiareadisciplinaria asc ";
								break;		

							case 66:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT distinct grupo as label, idgrupo as data, grado_pai
										FROM _viGrupo_Materias where idciclo = $idciclo and idprofesor = $idprofesor and isagrupadora = 0 and grupo_visible = 1 and ispai_grupo = 1 and idpaiareadisciplinaria > 0 and idemp = $idemp 
										$otros ";
								break;		

							case 67:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT materia as label, idgrumat as data, eval_default, eval_mod, materia_bloqueada, idpaiareadisciplinaria, grado_pai   
										FROM _viGrupo_Materias where idciclo = $idciclo and idprofesor = $idprofesor and idgrupo = $idgrupo and grado_pai = $grado_pai and isagrupadora = 0 and idemp = $idemp $otros ";
								break;	




						}
						break;
					case 2:  // Asociaciones
						switch($tipo){
							case 0:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo as label,idgponiv as data 
										FROM _viNivel_Grupos where idemp = $idemp and idciclo = $idciclo and idnivel = $otros  and grupo_ciclo_nivel_visible = 1
										Order By label asc ";
								break;		

							case 1: // Obtiene a Lista de Todos los Alumnos de la empresa
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT alumno as label,idgrualu as data 
										FROM _viGrupo_Alumnos where idemp = $idemp and idciclo = $idciclo and idgrupo = $otros
										Order By label asc ";
								break;		

							case 2:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT observacion as label,idnivobs as data 
										FROM _viNivel_Observaciones where idemp = $idemp and idnivel = $otros
										Order By label asc ";
								break;		
							case 3:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT profesor as label,iddirprof as data 
										FROM _viDirProf where idemp = $idemp and iddirector = $otros
										Order By profesor asc ";
								break;		
							case 4: // Obtiene a Lista de Todos los Alumnos de la empresa basado en el Ciclo
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT alumno as label,idgrualu as data 
										FROM _viGrupo_Alumnos 
										where idemp = $idemp and idciclo = $idciclo and idgrupo = $otros
										Order By label asc ";
								break;		
							case 5:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo as label,idgponiv as data 
										FROM _viNivel_Grupos where idemp = $idemp and idciclo = $idciclo and status_ciclo = 1  and grupo_ciclo_nivel_visible = 1
										Order By clave_nivel, clave asc ";
								break;		

							case 6:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT solicitan as label, idsolicitanteautorizante as data 
										FROM _viSolAut where idemp = $idemp and idautoriza = $otros
										Order By label asc ";
								break;

							case 7: // 
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT nombres_alumno as label, idgrualu as data, grupo, clave_nivel, ver_boleta_interna, grupo_bloqueado, grado_pai, ispai_grupo
										FROM _viGrupo_Alumnos where idemp = $idemp and idciclo = $idciclo and idfamilia = $idfamilia and status_grualu = 1
										Order By label asc ";
								break;		
			
							case 8:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT usuario as label, idcomuserasocgpo as data 
										FROM _viComGpoUser where idemp = $idemp and idcomgrupo = $idcomgrupo and status_com_usuario_asoc_grupo = 1
										Order By label asc ";
								break;

							case 9: // 
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT nombres_alumno as label, idgrualu as data, grupo, clave_nivel, idfamilia
										FROM _viGrupo_Alumnos where idemp = $idemp and idciclo = $idciclo and idfamilia = $idfamilia and idgrualu = $idgrualu and status_grualu = 1
										Order By label asc ";
								break;		

							case 10: // 
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT nombres_alumno as label, idgrualu as data, grupo, clave_nivel
										FROM _viGrupo_Alumnos where idemp = $idemp and idciclo = $idciclo and idalumno = $idalumno and status_grualu = 1
										Order By label asc ";
								break;		

							case 11: 
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT *
										FROM _viGrupo_Alumnos 
											where 
												idemp = $idemp and 
												idciclo = $idciclo and 
												iduseralu = $idgrualu and 
												status_grualu = 1 and 
												grupo_bloqueado = 0 
										limit 1";
								break;		
			


						}
						break;


		  	}

		  	// $result =$Conn->query($query);

  			$result = mysql_query($query);

		  	while ($obj = mysql_fetch_object($result, $arr[0])) {
			   	 $ret[] = $obj;
		  	}
		  
	       	mysql_close($mysql);
			
			return $ret;
			
	}

     public function setAsocia($tipo=0,$arg="",$pag=0,$limite=0,$var2=0, $otros=""){
		  $query="";

		  $ip=$_SERVER['REMOTE_ADDR']; 
		  $host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
	
		  $vRet = "Error";
		  $Conn = voConn::getInstance();
		  $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  mysql_select_db($Conn->db);
		  mysql_query("SET NAMES 'utf8'");	
            	switch ($tipo){
					case 0:
						switch($var2){
							case 10:
								parse_str($otros);
								$iduser = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

			          			$ar = explode(".",$arg);
			          			$item = explode("|",$ar[0]);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into nivel_grupos(idciclo,idnivel,idgrupo,idemp,ip,host,creado_por,creado_el)value($idciclo,$ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.".mysql_error():"OK";
									}
								}
								break;		
							case 20:

			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									if ((int)($ar[$i])>0){
										$query = "Delete from nivel_grupos where idgponiv = ".$ar[$i];
										$result = mysql_query($query);
										$vRet = $result!=1?"Error-- ".$ar[$i].' '.mysql_error():"OK";
									}
								}
								break;		
						}
						break;

					case 1:
						switch($var2){
							case 10:
								parse_str($otros);
								$iduser = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

			          			$ar = explode(".",$arg);
			          			$item = explode("|",$ar[0]);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into grupo_alumnos(idciclo,idgrupo,idalumno,idemp,ip,host,creado_por,creado_el)value($idciclo,$ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:

			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									if ((int)($ar[$i])>0){
										$query = "Delete from grupo_alumnos where idgrualu = ".$ar[$i];
										$result = mysql_query($query);
										$vRet = $result!=1?"Error-- ".$ar[$i]:"OK";
									}
								}
								break;		
							case 30:
			          			$ar = parse_str($otros);
								$iduser = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$idcicloant = $this->getCicloAntFromIdEmp($idemp);

								//$query = "update grupo_alumnos set idgrupo = ".$idgrupo." where idgrualu = ".$idgrualu;

								$query = "Set @X = Copiar_Alumnos_de_Grupo_a_Grupo(".$idgrupoorigen.",".$idgrupodestino.",".$idciclo.",".$iduser.",".$idemp.",'".$ip."','".$host."',".$idcicloant.")";
								
								$result = mysql_query($query);
								$vRet = $result!=1?"Error-- ":"OK";
								break;		

						}
						break;

					case 2:
						switch($var2){
							case 10:
								parse_str($otros);
								$iduser = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);

			          			$ar = explode(".",$arg);
			          			$item = explode("|",$ar[0]);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into nivel_observaciones(idnivel,idobservacion,idemp,ip,host,creado_por,creado_el)
													value($ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:

			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									if ((int)($ar[$i])>0){
										$query = "Delete from nivel_observaciones where idnivobs = ".$ar[$i];
										$result = mysql_query($query);
										$vRet = $result!=1?"Error-- ".$ar[$i]:"OK";
									}
								}
								break;		
						}
						break;

					case 3:
						switch($var2){
							case 10:
								parse_str($otros);
								$iduser = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

			          			$ar = explode(".",$arg);
			          			$item = explode("|",$ar[0]);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into director_profesores(iddirector,idprofesor,idemp,ip,host,creado_por,creado_el)value($ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:

			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									if ((int)($ar[$i])>0){
										$query = "Delete from director_profesores where iddirprof = ".$ar[$i];
										$result = mysql_query($query);
										$vRet = $result!=1?"Error-- ".$ar[$i]:"OK";
									}
								}
								break;		

						}
						break; // 3

					case 4:
						switch($var2){
							case 10:
								parse_str($otros);
								$iduser = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

			          			$ar = explode(".",$arg);
			          			$item = explode("|",$ar[0]);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into solicitantes_vs_autorizantes(idautoriza,idsolicita,idemp,ip,host,creado_por,creado_el)value($ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:

			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									if ((int)($ar[$i])>0){
										$query = "Delete from solicitantes_vs_autorizantes where idsolicitanteautorizante = ".$ar[$i];
										$result = mysql_query($query);
										$vRet = $result!=1?"Error-- ".$ar[$i]:"OK";
									}
								}
								break;		

						}
						break; // 4


					case 41:
						switch($var2){
							case 10:
								parse_str($otros);
								$iduser = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

			          			$item = explode("|",$bols);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into com_usuarios_asoc_grupos(idcomgrupo,iduser,idemp,ip,host,creado_por,creado_el)value($idcomgrupo,$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error: ".mysql_error():"OK";
									}
								}
								break;	

							case 20:
								parse_str($otros);
			          			$ar = explode("|",$dests);
								foreach($ar as $i=>$valor){
									if ((int)($ar[$i])>0){
										$query = "Delete from com_usuarios_asoc_grupos where idcomuserasocgpo = ".$ar[$i];
										$result = mysql_query($query);
										$vRet = $result!=1?"Error: ".$ar[$i]:"OK";
									}
								}
								break;		

						}
						break; // 41




		  		}
		  
			mysql_close($mysql);

		  return  $vRet;
	}


     public function setSaveData($index=0,$arg="",$pag=0,$limite=0,$tipo=0,$cadena2=""){
		  	$query="";

		  	$ip=$_SERVER['REMOTE_ADDR']; 
		  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
	
		  	$vRet = "Error";
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);
		  	mysql_query("SET NAMES 'utf8'");	
		  	$ar = array();
		 
            	switch ($index){
					case 0:
						switch($tipo){
							case 0:
								parse_str($arg);
								$arr = array("alu","pro","per");
								if (!in_array(substr($username, 0,3), $arr)){
									$pass = md5($password1);
									$idusr = $this->getIdUserFromAlias($user);
									$idemp = $this->getIdEmpFromAlias($user);
									$query = "Insert Into usuarios(username,password,apellidos,nombres,
																	correoelectronico,idusernivelacceso,
																	status_usuario,
																	idemp,ip,host,creado_por,creado_el)
												value( '$username','$pass','$apellidos','$nombres',
														'$correoelectronico',$idusernivelacceso,
														$status_usuario,
													    $idemp,'$ip','$host',$idusr,NOW())";
									$result = mysql_query($query); 
									$vRet = $result!=1? mysql_error():"OK";
								}else{
									$vRet = "Error: No puede usar ese prefijo en el Nombre de Usuario";
								}
								break;		
							case 1:
								parse_str($arg);
								// if ($username !== $username2){
								// 	$arr = array("alu","pro","per","adm");
								// 	if ( (!in_array(substr($username, 0,3), $arr)) ){
										$idusr = $this->getIdUserFromAlias($user);
										$idemp = $this->getIdEmpFromAlias($user);
										if ( isset($idusernivelacceso) ){
											$idnivacc = " idusernivelacceso = $idusernivelacceso, ";	
										}else{
												$idnivacc = "";
										}
										//$query = "update usuarios set username = '$username',
										$query = "update usuarios set apellidos = '$apellidos',
																		nombres = '$nombres',
																		correoelectronico = '$correoelectronico',
																		".$idnivacc."
																		status_usuario = $status_usuario,
																		ip = '$ip', 
																		host = '$host',
																		modi_por = $idusr, 
																		modi_el = NOW()
												Where iduser = $iduser";
										$result = mysql_query($query);
										$vRet = $result!=1? mysql_error():"OK";
								// 	}else{
								// 		$vRet = "Error: No puede usar ese prefijo en el Nombre de Usuario";
								// 	}

								// }

								break;		
							case 2:
								$query = "delete from usuarios Where iduser = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 3:
								parse_str($arg);
								$pass = md5($password1);
								$query = "update usuarios set password = '$pass',
																ip = '$ip', 
																host = '$host',
																modi_por = $iduser2, 
																modi_el = NOW()
										Where iduser = $iduser";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error().$iduser:"OK";
								break;		
							case 100:
							     
								parse_str($arg);
								$tel = trim(utf8_decode($celular));
								$pass = md5($password);
								$query = "Insert Into usuarios(username,password,nombres,celular,idF,latitud,longitud,ip,host,creado_el)
													value('$username','$pass','$nombre','$tel','$idF','$latitud','$longitud','$ip','$host',NOW())";
								$result = mysql_query($query); 
								
								if ($result!=1){
									$vRet = "CMHR ".mysql_error();
								}else{
									//$cfolio = $this->getIDFromDenuncias();
									$vRet = "OK";
								}
								break;		
							case 101:
							     
								parse_str($arg);
								$query = "update usuarios set valid = 1 where username='$username'";
								$result = mysql_query($query); 
								
								if ($result!=1){
									$vRet = "CMHR ".mysql_error();
								}else{
									//$cfolio = $this->getIDFromDenuncias();
									$vRet = "OK";
								}
								break;		
							case 200:
							     
								parse_str($arg);
								$pass = md5($password);
								$query = "Insert Into usuarios(username,password,ip,host,creado_el)
													value('$username','$pass','$ip','$host',NOW())";
								$result = mysql_query($query); 
								
								if ($result!=1){
									$vRet = "CMHR ".mysql_error();
								}else{
									//$cfolio = $this->getIDFromDenuncias();
									$vRet = "OK";
								}
								break;		
							case 203:
							     
								parse_str($arg);
								//$pass = md5($password);
								/*	
								if (!isset($idusernivelacceso)){
									$idusernivelacceso = 1;
								}
								*/
								if ( isset($idusernivelacceso) ){
									$idnivacc = " idusernivelacceso = $idusernivelacceso, ";	
								}else{
									$idnivacc = "";
								}
								
								$token_validated = $token == $token_source ? 1 : 0;
								$token = intval($token_validated) == 1? $token :"";

								$query = "update usuarios set 
															 apellidos = '$apellidos', 
															 nombres = '$nombres', 
															 correoelectronico = '$correoelectronico',
															 ".$idnivacc."
															 teloficina = '$teloficina',
															 telpersonal = '$telpersonal',
															 token = '$token',
															 token_validated = $token_validated,
															 registrosporpagina = $registrosporpagina,
															 param1 = '$param1',
															 ip = '$ip',
															 host = '$host'
														where username LIKE ('$username2%')";
								$result = mysql_query($query); 
								
								if ($result!=1){
									$vRet = "CMHR ".mysql_error();
								}else{
									//$cfolio = $this->getIDFromDenuncias();
									$vRet = "OK";
								}
								break;		
							case 204:
							     
								parse_str($arg);
								$query = "update usuarios set foto = '$foto',
															 ip = '$ip',
															 host = '$host'
															 where username LIKE ('$username%')";
								$result = mysql_query($query); 
								
								if ($result!=1){
									$vRet = "CMHR ".mysql_error();
								}else{
									//$cfolio = $this->getIDFromDenuncias();
									$vRet = "OK";
								}
								break;		

							case 205:
							     
								parse_str($arg);
								$pass = md5($password);

								$query = "update usuarios set 
															 password = '$pass', 
															 ip = '$ip',
															 host = '$host'
														where username LIKE ('$username2%')";
								$result = mysql_query($query); 
								
								if ($result!=1){
									$vRet = "CMHR ".mysql_error();
								}else{
									//$cfolio = $this->getIDFromDenuncias();
									$vRet = "OK";
								}
								break;		

						}
						break;
					case 1:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_estados(clave,estado,status_estado,idemp,ip,host,creado_por,creado_el)
											value( '$clave','$estado',
												    $status_estado,$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_estados set 	clave = '$clave',
															  	estado = '$estado',
															  	status_estado = $status_estado,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idestado = $idestado";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_estados Where idestado = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;
					case 2:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_municipios(idestado,clave,municipio,status_municipio,idemp,ip,host,creado_por,creado_el)
											value( $idestado, '$clave','$municipio',
												    $status_municipio,$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_municipios set idestado = $idestado,
																clave = '$clave',
															  	municipio = '$municipio',
															  	status_municipio = $status_municipio,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idmunicipio = $idmunicipio";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_municipios Where idmunicipio = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 3:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_niveles(nivel,clave_nivel,nivel_oficial,nivel_fiscal,clave_registro_nivel,status_nivel,
																	fecha_actas,		
																	idemp,ip,host,creado_por,creado_el)
											value('$nivel','$clave_nivel','$nivel_oficial','$nivel_fiscal','$clave_registro_nivel',$status_nivel,
													'$fecha_actas',	
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_niveles set 	
															  	nivel = '$nivel',
															  	clave_nivel = '$clave_nivel',
															  	nivel_oficial = '$nivel_oficial',
															  	nivel_fiscal = '$nivel_fiscal',
															  	fecha_actas = '$fecha_actas',
															  	clave_registro_nivel = '$clave_registro_nivel',
															  	status_nivel = $status_nivel,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idnivel = $idnivel";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_niveles Where idnivel = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 4:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$isbloqueado = isset($bloqueado)?1:0;
								$activo_en_caja = isset($activo_en_caja)?1:0;
								$ver_boleta_interna = isset($ver_boleta_interna)?1:0;
								$ver_boleta_oficial = isset($ver_boleta_oficial)?1:0;
								$ispai_grupo = isset($ispai_grupo)?1:0;
								$query = "Insert Into cat_grupos(
																grupo,
																grado,
																clave,
																bloqueado,
																grupo_periodo,
																grupo_periodo_ciclo,
																grupo_oficial,
																activo_en_caja,
																ver_boleta_interna,
																ver_boleta_oficial,
																ispai_grupo,
																grado_pai,
																status_grupo,
																idemp,ip,host,creado_por,creado_el)
															value(
																'$grupo',
																$grado,
																'$clave',
																$isbloqueado,
																'$grupo_periodo',
																'$grupo_periodo_ciclo',
																'$grupo_oficial',
																$activo_en_caja,
																$ver_boleta_interna,
																$ver_boleta_oficial,
																$ispai_grupo,
																$grado_pai,
																$status_grupo,
																	$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$isbloqueado = isset($bloqueado)?1:0;
								$activo_en_caja = isset($activo_en_caja)?1:0;
								$ver_boleta_interna = isset($ver_boleta_interna)?1:0;
								$ver_boleta_oficial = isset($ver_boleta_oficial)?1:0;
								$isvisible = isset($visible)?1:0;
								$ispai_grupo = isset($ispai_grupo)?1:0;
								$query = "update cat_grupos set 	
															  	clave = '$clave',
															  	grupo = '$grupo',
															  	grado = $grado,
															  	bloqueado = $isbloqueado,
															  	ispai_grupo = $ispai_grupo,
															  	grado_pai = $grado_pai,
															  	activo_en_caja = $activo_en_caja,
															  	ver_boleta_interna = $ver_boleta_interna,
															  	ver_boleta_oficial = $ver_boleta_oficial,
															  	grupo_periodo = '$grupo_periodo',
															  	grupo_periodo_ciclo = '$grupo_periodo_ciclo',
															  	grupo_oficial = '$grupo_oficial',
															  	status_grupo = $status_grupo,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idgrupo = $idgrupo";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_grupos Where idgrupo = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 3:
								$query = "update nivel_grupos set visible = 0 Where idgponiv = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;
					case 5:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$fn = explode('-',$fecha_nacimiento);
								$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];
		
								$fi = explode('-',$fecha_ingreso);
								$fi = $fi[2].'-'.$fi[1].'-'.$fi[0];

								$activo_en_ciclo = !isset($activo_en_ciclo)?0:1;
								$valid_for_admin = !isset($valid_for_admin)?0:1;


								$query = "Insert Into cat_alumnos(
																ap_paterno,
																ap_materno,
																nombre,
																curp,
																rfc,
																email,
																lugar_nacimiento,
																fecha_nacimiento,
																fecha_ingreso,
																matricula_interna,
																matricula_oficial,
																status_alumno,
																tipo_sangre,
																enfermedades,
																reacciones_alergicas,
																genero,
																beca_sep,
																beca_arji,
																beca_sp,
																beca_bach,
																activo_en_ciclo,
																valid_for_admin,
																idemp,ip,host,creado_por,creado_el)
											value(
																'$ap_paterno',
																'$ap_materno',
																'$nombre',
																'$curp',
																'$rfc',
																'$email',
																'$lugar_nacimiento',
																'$fn',
																'$fi',
																'$matricula_interna',
																'$matricula_oficial',
																$status_alumno,
																'$tipo_sangre',
																'$enfermedades',
																'$reacciones_alergicas',
																$genero,
																$beca_sep,
																$beca_arji,
																$beca_sp,
																$beca_bach,
																$activo_en_ciclo,
																$valid_for_admin,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$fn = explode('-',$fecha_nacimiento);
								$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];
		
								$fi = explode('-',$fecha_ingreso);
								$fi = $fi[2].'-'.$fi[1].'-'.$fi[0];

								$activo_en_ciclo = !isset($activo_en_ciclo)?0:1;
								$valid_for_admin = !isset($valid_for_admin)?0:1;

								$query = "update cat_alumnos set 	
																ap_paterno = '$ap_paterno',
																ap_materno = '$ap_materno',
																nombre = '$nombre',
																curp = '$curp',
																rfc = '$rfc',
																email = '$email',
																lugar_nacimiento = '$lugar_nacimiento',
																fecha_nacimiento = '$fn',
																fecha_ingreso = '$fi',
																matricula_interna = '$matricula_interna',
																matricula_oficial = '$matricula_oficial',
																status_alumno = $status_alumno,
																genero = $genero,
																tipo_sangre = '$tipo_sangre',
																enfermedades = '$enfermedades',
																reacciones_alergicas = '$reacciones_alergicas',
																beca_sep = $beca_sep,
																beca_arji = $beca_arji,
																beca_sp = $beca_sp,
																beca_bach = $beca_bach,
																activo_en_ciclo = $activo_en_ciclo,
																valid_for_admin = $valid_for_admin,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idalumno = $idalumno";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_alumnos Where idalumno = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);


								$query = "update cat_alumnos set 	
																beca_sep = $beca_sep,
																beca_arji = $beca_arji,
																beca_sp = $beca_sp,
																beca_bach = $beca_bach,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idalumno = $idalumno";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;								}
						break;

					case 6:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$fn = explode('-',$fecha_nacimiento);
								$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];
		
								$fi = explode('-',$fecha_ingreso);
								$fi = $fi[2].'-'.$fi[1].'-'.$fi[0];

								$query = "Insert Into cat_profesores(
																ap_paterno,
																ap_materno,
																nombre,
																email,
																cel1,
																cel2,
																direccion,
																fecha_nacimiento,
																fecha_ingreso,
																status_profesor,
																idemp,ip,host,creado_por,creado_el)
											value(
																'$ap_paterno',
																'$ap_materno',
																'$nombre',
																'$email',
																'$cel1',
																'$cel2',
																'$direccion',
																'$fn',
																'$fi',
													$status_profesor,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$fn = explode('-',$fecha_nacimiento);
								$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];
		
								$fi = explode('-',$fecha_ingreso);
								$fi = $fi[2].'-'.$fi[1].'-'.$fi[0];

								$query = "update cat_profesores set 	
																ap_paterno = '$ap_paterno',
																ap_materno = '$ap_materno',
																nombre = '$nombre',
																email = '$email',
																cel1 = '$cel1',
																cel2 = '$cel2',
																direccion = '$direccion',
																fecha_nacimiento = '$fn',
																fecha_ingreso = '$fi',
																status_profesor = $status_profesor,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idprofesor = $idprofesor";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_profesores Where idprofesor = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 7:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$idioma = !isset($idioma)?1:0;
								$isoficial = !isset($isoficial)?0:1;
								$isedutec = !isset($isedutec)?0:1;
								$ispai_materia = !isset($ispai_materia)?0:1;
								$isagrupadora = !isset($isagrupadora)?0:1;
								$status_materia = !isset($status_materia)?0:1;

								$query = "Insert Into cat_materias(
																materia,
																abreviatura,
																materia_oficial,
																abreviatura_oficial,
																clave,
																creditos,
																idmatclas,
																ord_imp,
																ord_hist,
																ord_oficial,
																idioma,
																isoficial,
																isedutec,
																ispai_materia,
																isagrupadora,
																idpaiareadisciplinaria,
																status_materia,
																idemp,ip,host,creado_por,creado_el)
											value(
																'$materia',
																'$abreviatura',
																'$materia_oficial',
																'$abreviatura_oficial',
																'$clave',
																$creditos,
																$idmatclas,
																$ord_imp,
																$ord_hist,
																$ord_oficial,
																$idioma,
																$isoficial,
																$isedutec,
																$ispai_materia,
																$isagrupadora,
																$idpaiareadisciplinaria,
																$status_materia,
																$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$idioma = !isset($idioma)?1:0;
								$isoficial = !isset($isoficial)?0:1;
								$isedutec = !isset($isedutec)?0:1;
								$status_materia = !isset($status_materia)?0:1;
								$isagrupadora = !isset($isagrupadora)?0:1;
								$ispai_materia = !isset($ispai_materia)?0:1;

								$query = "update cat_materias set 	
																materia = '$materia',
																abreviatura = '$abreviatura',
																materia_oficial = '$materia_oficial',
																abreviatura_oficial = '$abreviatura_oficial',
																clave = '$clave',
																creditos = $creditos,
																idmatclas = $idmatclas,
																ord_imp = $ord_imp,
																ord_hist = $ord_hist,
																ord_oficial = $ord_oficial,
																idioma = $idioma,
																isoficial = $isoficial,
																isedutec = $isedutec,
																ispai_materia = $ispai_materia,
																idpaiareadisciplinaria = $idpaiareadisciplinaria,
																isagrupadora = $isagrupadora,
																status_materia = $status_materia,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idmateria = $idmateria";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_materias Where idmateria = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;


					case 8:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$status_materia_clasificacion = !isset($status_materia_clasificacion)?0:1;								

								$query = "Insert Into cat_materias_clasificacion(clasificacion,
																				status_materia_clasificacion,
																				idemp,
																				ip,
																				host,
																				creado_por,
																				creado_el
																			)value(
																				'$clasificacion',
																				$status_materia_clasificacion,
																				$idemp,
																				'$ip',
																				'$host',
																				$idusr,
																				NOW()
																				)";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);

								$idusr = $this->getIdUserFromAlias($user);

								$status_materia_clasificacion = !isset($status_materia_clasificacion)?0:1;

								$query = "update cat_materias_clasificacion set 	
															  	clasificacion = '$clasificacion',
															  	status_materia_clasificacion = $status_materia_clasificacion,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idmatclas = $idmatclas";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_materias_clasificacion Where idmatclas = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 9:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_parentezcos(parentezco,status_parentezco,
																	idemp,ip,host,creado_por,creado_el)
											value('$parentezco',$status_parentezco,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_parentezcos set 	
															  	parentezco = '$parentezco',
															  	status_parentezco = $status_parentezco,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idparentezco = $idparentezco";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_parentezcos Where idparentezco = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 10:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$fn = explode('-',$fecha_nacimiento);
								$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

								$query = "Insert Into cat_personas(
																	ap_paterno,
																	ap_materno,
																	nombre,
																	email1,
																	email2,
																	tel1,
																	tel2,
																	cel1,
																	cel2,
																	lugar_nacimiento,
																	fecha_nacimiento,
																	curp,
																	genero,
																	ocupacion,
																	domicilio_generico,
																	calle,
																	num_ext,
																	num_int,
																	colonia,
																	localidad,
																	estado,
																	municipio,
																	pais,
																	cp,
																	lugar_trabajo,
																	status_persona,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	'$ap_paterno',
																	'$ap_materno',
																	'$nombre',
																	'$email1',
																	'$email2',
																	'$tel1',
																	'$tel2',
																	'$cel1',
																	'$cel2',
																	'$lugar_nacimiento',
																	'$fn',
																	'$curp',
																	$genero,
																	'$ocupacion',
																	'".mb_strtoupper($domicilio_generico,'UTF-8')."',
																	'".mb_strtoupper($calle,'UTF-8')."',
																	'".mb_strtoupper($num_ext,'UTF-8')."',
																	'".mb_strtoupper($num_int,'UTF-8')."',
																	'".mb_strtoupper($colonia,'UTF-8')."',
																	'".mb_strtoupper($localidad,'UTF-8')."',
																	'".mb_strtoupper($estado,'UTF-8')."',
																	'".mb_strtoupper($municipio,'UTF-8')."',
																	'".mb_strtoupper($pais,'UTF-8')."',
																	'".mb_strtoupper($cp,'UTF-8')."',
																	'".mb_strtoupper($lugar_trabajo,'UTF-8')."',
																	$status_persona,
																	$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$fn = explode('-',$fecha_nacimiento);
								$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

								$query = "update cat_personas set 	
																ap_paterno = '$ap_paterno',
																ap_materno = '$ap_materno',
																nombre = '$nombre',
																email1 = '$email1',
																email2 = '$email2',
																tel1 = '$tel1',
																tel2 = '$tel2',
																cel1 = '$cel1',
																cel2 = '$cel2',
																lugar_nacimiento = '$lugar_nacimiento',
																fecha_nacimiento = '$fn',
																curp = '$curp',
																calle = '".mb_strtoupper($calle,'UTF-8')."',
																num_ext = '".mb_strtoupper($num_ext,'UTF-8')."',
																num_int = '".mb_strtoupper($num_int,'UTF-8')."',
																colonia = '".mb_strtoupper($colonia,'UTF-8')."',
																localidad = '".mb_strtoupper($localidad,'UTF-8')."',
																estado = '".mb_strtoupper($estado,'UTF-8')."',
																municipio = '".mb_strtoupper($municipio,'UTF-8')."',
																pais = '".mb_strtoupper($pais,'UTF-8')."',
																cp = '".mb_strtoupper($cp,'UTF-8')."',
																genero = $genero,
																ocupacion = '".mb_strtoupper($ocupacion,'UTF-8')."',
																domicilio_generico = '".mb_strtoupper($domicilio_generico,'UTF-8')."',
																lugar_trabajo = '".mb_strtoupper($lugar_trabajo,'UTF-8')."',
														  		status_persona = $status_persona,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idpersona = $idpersona";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_personas Where idpersona = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;


					case 11:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "Insert Into cat_familias(
																	familia,
																	email,
																	status_familia,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	'$familia',
																	'$email',
																	$status_familia,
																	$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								// $fn = explode('-',$fecha_nacimiento);
								// $fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

								$query = "update cat_familias set 	
																	familia = '$familia',
																	email = '$email',
															  	status_familia = $status_familia,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idfamilia = $idfamilia";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_familias Where idfamilia = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;


					case 12:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$is_email = !isset($is_email)?0:1;	
								$status_famper = !isset($status_famper)?0:1;	
								$query = "Insert Into familia_personas(
																	idpersona,
																	idfamilia,
																	idparentezco,
																	is_email,
																	status_famper,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	$idpersona,
																	$idfamilia,
																	$idparentezco,
																	$is_email,
																	$status_famper,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$is_email = !isset($is_email)?0:1;	
								$status_famper = !isset($status_famper)?0:1;	

								$query = "update familia_personas set 	
																idpersona = $idpersona,
																idfamilia = $idfamilia,
																idparentezco = $idparentezco,
																is_email = $is_email,
															  	status_famper = $status_famper,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idfamper = $idfamper";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from familia_personas Where idfamper = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;



					case 13:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$is_minor = !isset($is_minor)?0:1;	
								$status_famalu = !isset($status_famalu)?0:1;	
								$query = "Insert Into familia_alumnos(
																	idalumno,
																	idfamilia,
																	idtutor,
																	is_minor,
																	vive_con,
																	status_famalu,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	$idalumno,
																	$idfamilia,
																	$idtutor,
																	$is_minor,
																	$vive_con,
																	$status_famalu,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$is_minor = !isset($is_minor)?0:1;	
								$status_famalu = !isset($status_famalu)?0:1;	

								$query = "update familia_alumnos set 	
																idalumno = $idalumno,
																idfamilia = $idfamilia,
																idtutor = $idtutor,
																is_minor = $is_minor,
																vive_con = $vive_con,
															  	status_famalu = $status_famalu,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idfamalu = $idfamalu";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from familia_alumnos Where idfamalu = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;



					case 14:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$is_email = !isset($is_email)?0:1;	
								$is_extranjero = !isset($is_extranjero)?0:1;	
								$status_regfis = !isset($status_regfis)?0:1;
								$idfammig = intval($idfammig);	
								$query = "Insert Into cat_registros_fiscales(
																	rfc,
																	curp,
																	razon_social,
																	calle,
																	num_ext,
																	num_int,
																	colonia,
																	localidad,
																	estado,
																	pais,
																	cp,
																	idfammig,
																	email1,
																	email2,
																	is_email,
																	is_extranjero,
																	referencia,
																	status_regfis,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	'".strtoupper($rfc)."',
																	'".strtoupper($curp)."',
																	'".strtoupper($razon_social)."',
																	'".strtoupper($calle)."',
																	'".strtoupper($num_ext)."',
																	'".strtoupper($num_int)."',
																	'".strtoupper($colonia)."',
																	'".strtoupper($localidad)."',
																	'".strtoupper($estado)."',
																	'".mb_strtoupper($pais, 'UTF-8')."',
																	'".strtoupper($cp)."',
																	$idfammig,
																	'$email1',
																	'$email2',
																	$is_email,
																	$is_extranjero,
																	'$referencia',
																	$status_regfis,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$is_email = !isset($is_email)?0:1;	
								$is_extranjero = !isset($is_extranjero)?0:1;	
								$status_regfis = !isset($status_regfis)?0:1;	
								$idfammig = intval($idfammig);	

								$query = "update cat_registros_fiscales set 	
																rfc = '".strtoupper($rfc)."',
																curp = '".strtoupper($curp)."',
																razon_social = '".strtoupper($razon_social)."',
																calle = '".strtoupper($calle)."',
																num_ext = '".strtoupper($num_ext)."',
																num_int = '".strtoupper($num_int)."',
																colonia = '".strtoupper($colonia)."',
																localidad = '".strtoupper($localidad)."',
																estado = '".strtoupper($estado)."',
																pais = '".mb_strtoupper($pais, 'UTF-8')."',
																cp = '".strtoupper($cp)."',
																email1 = '$email1',
																email2 = '$email2',
																idfammig = $idfammig,
																is_email = $is_email,
																is_extranjero = $is_extranjero,
																referencia = '$referencia',
															  	status_regfis = $status_regfis,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idregfis = $idregfis";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_registros_fiscales Where idregfis = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 15:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$status_famregfis = !isset($status_famregfis)?0:1;	
								$predeterminado = !isset($predeterminado)?0:1;	
								$query = "Insert Into familia_reg_fis(
																	idfamilia,
																	idregfis,
																	predeterminado,
																	status_famregfis,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	$idfamilia,
																	$idregfis,
																	$predeterminado,
																	$status_famregfis,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$status_famregfis = !isset($status_famregfis)?0:1;	

								$predeterminado = !isset($predeterminado)?0:1;	

								$query = "update familia_reg_fis set 	
																idfamilia = $idfamilia,
																idregfis = $idregfis,
																predeterminado = $predeterminado,
															  	status_famregfis = $status_famregfis,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idfamregfis = $idfamregfis";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from familia_reg_fis Where idfamregfis = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 16:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$status_grumat = !isset($status_grumat)?0:1;	
								$isoficial = !isset($isoficial)?0:1;	
								$bloqueado = !isset($bloqueado)?0:1;	
								$ispai = !isset($ispai)?0:1;
								//
								
								$orden_impresion = intval($orden_impresion); 
								$orden_historial = intval($orden_historial); 
								$ispai_materia = !isset($ispai_materia)?0:1;

								$query = "Insert Into grupo_materias(
																	idciclo,
																	idgrupo,
																	idprofesor,
																	idmateria,
																	isagrupadora,
																	orden_impresion,
																	orden_historial,
																	orden_oficial,
																	materia_oficial,
																	abreviatura_oficial,
																	clave,
																	creditos,
																	isoficial,
																	ispai_materia,
																	ispai_grupo,
																	bloqueado,
																	eval_default,
																	eval_mod,
																	status_grumat,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	$idciclo,
																	$idgrupo,
																	$idprofesor,
																	$idmateria,
																	$isagrupadora0,
																	$orden_impresion,
																	$orden_historial,
																	$orden_oficial,
																	'$materia_oficial',
																	'$abreviatura_oficial',
																	'$clave',
																	$creditos,
																	$isoficial,
																	$ispai_materia,
																	$ispai_grupo,
																	$bloqueado,
																	$eval_default,
																	$eval_mod,
																	$status_grumat,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$status_grumat = !isset($status_grumat)?0:1;	
								$idemp = $this->getIdEmpFromAlias($user);
								//$idciclo = $this->getCicloFromIdEmp($idemp);

								$isoficial = !isset($isoficial)?0:1;	

								$orden_impresion = intval($orden_impresion); 
								$orden_historial = intval($orden_historial); 
								$bloqueado = !isset($bloqueado)?0:1;	
								$ispai_materia = !isset($ispai_materia)?0:1;

								$query = "update grupo_materias set 	
																idciclo = $idciclo,
																idgrupo = $idgrupo,
																idprofesor = $idprofesor,
																idmateria = $idmateria,
															  	isagrupadora = $isagrupadora0,
															  	orden_impresion = $orden_impresion,
															  	orden_historial = $orden_historial,
															  	orden_oficial = $orden_oficial,
															  	materia_oficial = '$materia_oficial',
															  	abreviatura_oficial = '$abreviatura_oficial',
															  	clave = '$clave',
															  	creditos = $creditos,
															  	status_grumat = $status_grumat,
															  	isoficial = $isoficial,
															  	ispai_materia = $ispai_materia,
															  	ispai_grupo = $ispai_grupo,
																bloqueado = $bloqueado,
																eval_default = $eval_default,
																eval_mod = $eval_mod,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idgrumat = $idgrumat";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from grupo_materias Where idgrumat = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;	

							case 3:
							     //$ar = $this->unserialice_force($arg);
								parse_str($cadena2);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								parse_str($arg);

			          			$ar = explode(".",$arg);
			          			$item = explode("|",$ar[0]);
								foreach($item as $i=>$valor){
									if ( intval($item[$i]) > 0 ){

										$query = "update grupo_materias set 	
																		padre = ".$ar[1].",
																		ip = '$ip', 
																		host = '$host',
																		modi_por = $idusr, 
																		modi_el = NOW()
												Where idgrumat = ".$item[$i];
										$result = mysql_query($query);

									}
								}

								$vRet = $result!=1? mysql_error():"OK";
								break;

							case 4:
							     //$ar = $this->unserialice_force($arg);
								parse_str($cadena2);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								parse_str($arg);

			          			$item = explode("|",$arg);
								foreach($item as $i=>$valor){
									if ( intval($item[$i]) > 0 ){

										$query = "update grupo_materias set 	
																		padre = 0,
																		ip = '$ip', 
																		host = '$host',
																		modi_por = $idusr, 
																		modi_el = NOW()
												Where idgrumat = ".$item[$i];
										$result = mysql_query($query);

									}
								}

								$vRet = $result!=1? mysql_error():"OK";
								break;		





						}
						break;

					case 17:
						switch($tipo){
							case 4:
								$query = "delete from boletas Where idboleta IN ($arg)";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 5:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "Insert Into boletas(
																	idgrumat,
																	idgrualu,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	$idgrumat,
																	$idgrualu,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 18:
						switch($tipo){
							case 0:
								parse_str($arg);
								if (intval($num_eval_matcon)>0){
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into grupo_materia_config(
																	idgrumat,
																	num_eval,
																	descripcion,
																	porcentaje,
																	idalutipoactividad,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	$idgrumat,
																	$num_eval_matcon,
																	'$descripcion',
																	$porcentaje,
																	$idalutipoactividad,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								}else{
									$vRet = "Error: No se permite un Núnmero de Evaluación <= 0"; 
								}
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								if (intval($num_eval_matcon)>0){
								$query = "update grupo_materia_config set 	
																idgrumat = $idgrumat,
																num_eval = $num_eval_matcon,
															  	descripcion = '$descripcion',
																porcentaje = $porcentaje,
																idalutipoactividad = $idalutipoactividad,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idgrumatcon = $idgrumatcon";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								}else{
									$vRet = "Error: No se permite un Núnmero de Evaluación <= 0"; 
								}
								break;		
							case 2:
								$query = "delete from grupo_materia_config Where idgrumatcon = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 19:
						switch($tipo){
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$arrBolCon = explode('|', $IdBolCon);
								$arrBolConCal = explode('|', $IdBolConCal);

								$arrBolIna = explode('|', $IdBolIna);
								$arrBolInaCal = explode('|', $IdBolInaCal);

								$arrBolObs = explode('|', $IdBolObs);
								$arrBolObsCal = explode('|', $IdBolObsCal);

								$num_eval = intval($num_eval_capcal_fmt_0);
								$numval = $num_eval;
								$num_eval--; 

								for ($i=0; $i < count($arrBolCon); $i++) {
									$con = "con".$num_eval;		 
									$query = "update boletas set 	
																	".$con." = ".$arrBolConCal[$i].",
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											Where idboleta = ".$arrBolCon[$i];
											$result = mysql_query($query);
									}					
									
								for ($i=0; $i < count($arrBolIna); $i++) {
									$ina = "ina".$num_eval;		 
									$query = "update boletas set 	
																	".$ina." = ".$arrBolInaCal[$i].",
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											Where idboleta = ".$arrBolIna[$i];
											$result = mysql_query($query);
									}					

								for ($i=0; $i < count($arrBolObs); $i++) {
									$obs = "obs".$num_eval;		 
									$query = "update boletas set 	
																	".$obs." = ".$arrBolObsCal[$i].",
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											Where idboleta = ".$arrBolObs[$i];
											$result = mysql_query($query);
									}			
								
								$vRet = $result!=1? mysql_error():"OK";

								break;		
						}
						break;

					case 20:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idioma = !isset($idioma)?1:0;

								$query = "Insert Into cat_observaciones(
																	observacion,
																	idioma,
																	status_observacion,
																	idemp,ip,host,creado_por,creado_el)
											value(
												'$observacion',
												$idioma,
												$status_observacion,
												$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;

							case 1:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idioma = !isset($idioma)?1:0;
								$query = "update cat_observaciones set 	
															  	observacion = '$observacion',
															  	idioma = $idioma,
															  	status_observacion = $status_observacion,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idobservacion = $idobservacion";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_observaciones Where idobservacion = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 21:

// evalpred=1&evalmod=1&clavenivelacceso=11&user=lcecilia&hevalpred=eds&hevalmod=ems					
						switch($tipo){
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "update config set valor = $evalpred,
															modi_por = $idusr, 
															modi_el = NOW()
										Where llave = '$hevalpred' and idemp = $idemp ";
								$result = mysql_query($query);

								$query = "update config set valor = $evalmod,
															modi_por = $idusr, 
															modi_el = NOW()
										Where llave = '$hevalmod' and idemp = $idemp ";
								$result = mysql_query($query);

								$query = "update config set valor = $epai,
															modi_por = $idusr, 
															modi_el = NOW()
										Where llave = '$hepai' and idemp = $idemp ";
								$result = mysql_query($query);

								$arrParam = explode(',',$param1);

								if ( count($arrParam) > 1){
									for( $i=0; $i<count($arrParam); ++$i ){
										$query = "set @X = Fijar_Predeterminada_y_Modificable_Eval(".$arrParam[$i].",".$idciclo.",".$idemp.",".$idusr.",'".$ip."','".$host."',".$evalpred.",".$evalmod.")";
										$result = mysql_query($query);
									}
								}else{
									$query = "set @X = Fijar_Predeterminada_y_Modificable_Eval(".$param1.",".$idciclo.",".$idemp.",".$idusr.",'".$ip."','".$host."',".$evalpred.",".$evalmod.")";
									$result = mysql_query($query);
								}

								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 22:
						switch($tipo){

							case 3:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$arrGruAlu = explode('|', $idgrualu);
								$arrGruAluVal = explode('|', $idgrualuval);

								for ($i=0; $i < count($arrGruAlu); $i++) { 
									$query = "update grupo_alumnos set 	
																	num_lista = ".$arrGruAluVal[$i].",
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											Where idgrualu = ".$arrGruAlu[$i];
											$result = mysql_query($query);
									}					

								$vRet = $result!=1? mysql_error():"OK";
						}
						break;

					case 23:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_directores(idnivel,idprofesor,status_director,
																	idemp,ip,host,creado_por,creado_el)
											value($idnivel,$idprofesor,$status_director,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_directores set 	
															  	idnivel = $idnivel,
															  	idprofesor = $idprofesor,
															  	status_director = $status_director,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where iddirector = $iddirector";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_directores Where iddirector = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 25:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_conceptos(concepto,status_concepto,
																	idemp,ip,host,creado_por,creado_el)
											value('$concepto',$status_concepto,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_conceptos set 	
															  	concepto = '$concepto',
															  	status_concepto = $status_concepto,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idconcepto = $idconcepto";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_conceptos Where idconcepto = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 26:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$status_emisor_fiscal = !isset($status_emisor_fiscal)?0:1;
								$is_iva = !isset($is_iva)?0:1;
								
								$query = "Insert Into cat_emisores_fiscales(
																	rfc,
																	razon_social,
																	calle,
																	num_ext,
																	num_int,
																	colonia,
																	localidad,
																	estado,
																	pais,
																	cp,
																	serie,
																	tipo_comprobante,
																	status_emisor_fiscal,
																	is_iva,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	'".strtoupper($rfc)."',
																	'".strtoupper($razon_social)."',
																	'".strtoupper($calle)."',
																	'".strtoupper($num_ext)."',
																	'".strtoupper($num_int)."',
																	'".strtoupper($colonia)."',
																	'".strtoupper($localidad)."',
																	'".strtoupper($estado)."',
																	'".strtoupper($pais)."',
																	'".strtoupper($cp)."',
																	'".strtoupper($serie)."',
																	$tipo_comprobante,
																	$status_emisor_fiscal,
																	$is_iva,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$status_emisor_fiscal = !isset($status_emisor_fiscal)?0:1;
								$is_iva = !isset($is_iva)?0:1;

								$query = "update cat_emisores_fiscales set 	
																rfc = '".strtoupper($rfc)."',
																razon_social = '".strtoupper($razon_social)."',
																calle = '".strtoupper($calle)."',
																num_ext = '".strtoupper($num_ext)."',
																num_int = '".strtoupper($num_int)."',
																colonia = '".strtoupper($colonia)."',
																localidad = '".strtoupper($localidad)."',
																estado = '".strtoupper($estado)."',
																pais = '".strtoupper($pais)."',
																cp = '".strtoupper($cp)."',
																serie = '".strtoupper($serie)."',
																tipo_comprobante = $tipo_comprobante,
																is_iva = $is_iva,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idemisorfiscal = $idemisorfiscal";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_emisores_fiscales Where idemisorfiscal = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 27:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$is_descto_beca = !isset($is_descto_beca)?0:1;
								$is_descto_promocion = !isset($is_descto_promocion)?0:1;
								$is_descto = !isset($is_descto)?0:1;
								$is_pagos_diversos = !isset($is_pagos_diversos)?0:1;
								$is_siguiente_nivel = !isset($is_siguiente_nivel)?0:1;
								$is_facturable = !isset($is_facturable)?0:1;
								$is_mostrable = !isset($is_mostrable)?0:1;
								$status_pago = !isset($status_pago)?0:1;
								$ef = explode("-",$idemisorfiscal);
								
								$query = "Insert Into cat_pagos(
																	clave_nivel,
																	idemisorfiscal,
																	idconcepto,
																	importe,
																	dia_limite,
																	dia_de_pago,
																	is_descto_beca,
																	is_descto,
																	is_descto_promocion,
																	is_pagos_diversos,
																	is_siguiente_nivel,
																	is_facturable,
																	is_mostrable,
																	orden_prioridad,
																	aplica_a,
																	idlistavencimiento,
																	status_pago,
																	idemp,ip,host,creado_por,creado_el)
											value(

																	$clave_nivel,
																	$ef[0],
																	$idconcepto,
																	$importe,
																	$dia_limite,
																	$dia_de_pago,
																	$is_descto_beca,
																	$is_descto,
																	$is_descto_promocion,
																	$is_pagos_diversos,
																	$is_siguiente_nivel,
																	$is_facturable,
																	$is_mostrable,
																	$orden_prioridad,
																	$aplica_a,
																	$idlistavencimiento,
																	$status_pago,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$is_descto_beca = !isset($is_descto_beca)?0:1;
								$is_descto_promocion = !isset($is_descto_promocion)?0:1;
								$is_descto = !isset($is_descto)?0:1;
								$is_pagos_diversos = !isset($is_pagos_diversos)?0:1;
								$is_siguiente_nivel = !isset($is_siguiente_nivel)?0:1;
								$is_facturable = !isset($is_facturable)?0:1;
								$is_mostrable = !isset($is_mostrable)?0:1;
								$status_pago = !isset($status_pago)?0:1;
								$ef = explode("-",$idemisorfiscal);

								$query = "update cat_pagos set 	
																clave_nivel = $clave_nivel,
																idemisorfiscal = $ef[0],
																idconcepto = $idconcepto,
																importe = $importe,
																dia_limite = $dia_limite,
																dia_de_pago = $dia_de_pago,
																is_descto_beca = $is_descto_beca,
																is_descto = $is_descto,
																is_descto_promocion = $is_descto_promocion,
																is_pagos_diversos = $is_pagos_diversos,
																is_siguiente_nivel = $is_siguiente_nivel,
																is_facturable = $is_facturable,
																is_mostrable = $is_mostrable,
																orden_prioridad = $orden_prioridad,
																aplica_a = $aplica_a,
																idlistavencimiento = $idlistavencimiento,
															  	status_pago = $status_pago,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idpago = $idpago";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_pagos Where idpago = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;

					case 28:
						switch($tipo){

							case 2:
								parse_str($arg);
								$query = "delete from facturas_encabezado Where idfactura = $idfactura and isfe = 0";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							
							case 5:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$idcicloant = $this->getCicloAntFromIdEmp($idemp);
								$omitir_descto_beca = !isset($omitir_descto_beca)?0:1;

								$query = "update estados_de_cuenta set 	
																porcdescto = $porcentaje,
																omitir_descto_beca = $omitir_descto_beca,
																modi_por = $idusr, 
																modi_el = NOW()
										Where idedocta = $idedocta";
								$result = mysql_query($query);

								//$query = "set @X = Generar_Estado_de_Cuenta_por_Familia(".$idfamilia.",".$idciclo.",".$idemp.",".$idusr.",'".$ip."','".$host."')";
								$result = mysql_query($query);

								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 6:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$basadoen = intval($basadoen);
								if ($basadoen != 0){
									$recargo = ($basadoen * 100) / $subtotal;
								}

								$query = "update estados_de_cuenta set 	
																porcrecargo = $recargo,
																modi_por = $idusr, 
																modi_el = NOW()
										Where idedocta = $idedocta";
								$result = mysql_query($query);

								//$query = "set @X = Generar_Estado_de_Cuenta_por_Familia(".$idfamilia.",".$idciclo.",".$idemp.",".$idusr.",'".$ip."','".$host."')";
								$result = mysql_query($query);

								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 7:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$arrPago = explode('-',$idconcepto);
								$query = "set @X = Generar_Estado_de_Cuenta_por_Concepto(".$arrPago[0].",".$idciclo.",".$idfamilia.",".$idalumno.",".$clave_nivel.",".$beca_sep.",".$beca_arji.",".$beca_sp.",".$beca_bach.",".$idusr.",".$idemp.",'".$ip."','".$host."',".$num_pagos.",".$descuento.",".$recargo.")";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 8:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "set @X = Quitar_Concepto_de_Pago_de_Alumno(".$idfamilia.",".$idalumno.",".$idedocta.",".$idpago.",".$idusr.",".$idciclo.")";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 9:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$IDs = explode('|', $ids);

								$IdFs = explode('|', $idfs);
								$aIdPago = explode('|', $arrIdPago);

								$aConcepto = explode('|', $arrConcepto);

								$aSubtotal = explode('|', $arrSubtotal);
								$aDescto = explode('|', $arrDescto);
								$aDesctoBecas = explode('|', $arrDesctoBecas);
								$aImporte = explode('|', $arrImporte);
								$aRecargo = explode('|', $arrRecargo);
								$aTotal = explode('|', $arrTotal);
								
								$descto_becas = !isset($descto_becas) ? 0 : $descto_becas;

							    $facEnc = mysql_query("INSERT INTO facturas_encabezado(idcliente,idmetododepago,referencia,fecha,subtotal,descto_becas,importe,descto,recargo,total,idemp,ip,host,creado_por,creado_el)
							    					VALUES(".$IdFs[0].",$idmetododepago,'$referencia',NOW(),$subtotal,$descto_becas,$importe,$descto,$recargo,$total,$idemp,'$ip','$host',$idusr,NOW())");

							    $result = mysql_query("SELECT MAX(idfactura) as IDs FROM facturas_encabezado");
								$rFac=intval(mysql_result($result, 0,"IDs"));


								for ($i=0; $i < count($IdFs); $i++) { 
									
									$dBecas = !isset($aDesctoBecas[$i]) ? 0 : $aDesctoBecas[$i]; 

							    	$fD = mysql_query("SELECT * FROM estados_de_cuenta WHERE idedocta = ".$IDs[$i]);
									
									$precio_venta = mysql_result($fD, 0,"subtotal");
									$subtotal  	  = mysql_result($fD, 0,"subtotal");
									$descto_becas = mysql_result($fD, 0,"descto_becas");
									$importe  	  = mysql_result($fD, 0,"importe");
									$descto  	  = mysql_result($fD, 0,"descto");
									$recargo  	  = mysql_result($fD, 0,"recargo");
									$total  	  = mysql_result($fD, 0,"total");

									$facDet = mysql_query("INSERT INTO facturas_detalle(
													idfactura,
													idedocta,
													idproducto,
													descrip_prod, 
													descrip_medida, 
													cantidad, 
													precio_venta, 
													subtotal, 
													descto_becas, 
													importe, 
													descto, 
													recargo, 
													total, 
													idemp,ip,host,creado_por,creado_el)
											VALUES(".$rFac.",
													".$IDs[$i].",
													".$aIdPago[$i].",
													'".$aConcepto[$i]."',
													'pza', 
													1, 
													$precio_venta, 
													$subtotal, 
													$descto_becas, 
													$importe, 
													$descto, 
													$recargo, 
													$total, 
													$idemp,'$ip','$host',$idusr,NOW())");


									$query = "UPDATE estados_de_cuenta SET 	
																	idfactura = ".$rFac.",
																	status_movto = 1,
																	idmetododepago = $idmetododepago,
																	referencia = '$referencia',
																	fecha_de_pago = NOW(),
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											WHERE idedocta = ".$IDs[$i];
											$result = mysql_query($query);
									}					
								
								$vRet = $result!=1? mysql_error():"OK";


								break;		

							case 10:
								parse_str($arg);
								$iduser = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$idcicloant = $this->getCicloAntFromIdEmp($idemp);

								$query = "set @X = Generar_Estado_de_Cuenta_por_Familia(".$idfamilia.",".$idciclo.",".$idemp.",".$iduser.",'".$ip."','".$host."',".$idcicloant.")";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 11:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

							    $facEnc = mysql_query("INSERT INTO facturas_encabezado(idcliente,idemisorfiscal,idregfis,forma_de_pago,metodo_de_pago,referencia,fecha,subtotal,descto_becas,importe,descto,recargo,importe2,iva,total,padre,tipo_documento,idemp,ip,host,creado_por,creado_el)
							    					VALUES($idcliente,$idemisorfiscal,$idregfis,0,$idmetododepago,'$referencia',NOW(),$subtotal,$descto_becas,$importe,$descto,$recargo,$importe2,$iva,$total,$padre,1,$idemp,'$ip','$host',$idusr,NOW())");
							    
							    $vRet = $facEnc!=1? mysql_error():"OK";

							    $result = mysql_query("SELECT MAX(idfactura) as IDs FROM facturas_encabezado");
								$rFac=intval(mysql_result($result, 0,"IDs"));

								for ($i=0; $i < 100; $i++) { 
								
									$idedocta0 = "idedocta_".$i;
								
									if ( isset($$idedocta0) && intval($$idedocta0)>0 ){

										$idpro0 = "idproducto_".$i;
										$pro0 = "producto_".$i;
										$subtotal = "subtotal_".$i;
										$descto_becas = "descto_becas_".$i;
										$importe = "importe_".$i;
										$descto = "descto_".$i;
										$recargo = "recargo_".$i;
										$total = "total_".$i;

										$facDet = mysql_query("INSERT INTO facturas_detalle(
														idfactura,
														idedocta,
														idproducto,
														descrip_prod, 
														descrip_medida, 
														cantidad, 
														precio_venta, 
														subtotal, 
														descto_becas, 
														importe, 
														descto, 
														recargo, 
														importe2, 
														iva, 
														total, 
														idemp,ip,host,creado_por,creado_el)
												VALUES(".$rFac.",
														".$$idedocta0.",
														".$$idpro0.",
														'".$$pro0."',
														'pza', 
														1, 
														".$$subtotal.", 
														".$$subtotal.", 
														".$$descto_becas.", 
														".$$importe.", 
														".$$descto.", 
														".$$recargo.", 
														".$$total.",
														0, 
														".$$total.",
														$idemp,'$ip','$host',$idusr,NOW())");
												
												//$vRet = $result!=1? mysql_error():"OK";
									
									}else{
										break;
									}

									
								}					

								break; // 11;

							case 12:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								
								// $emifis = explode('-',$idemisorfiscal);

							    $facEnc = mysql_query("
							    	UPDATE facturas_encabezado 
							    	set idcliente = $idcliente,
							    		idemisorfiscal = $idemisorfiscal,
							    		idregfis = $idregfis,
							    		idmetododeidpago = $idmetododepagoNC,
							    		referencia = '$referenciaNC',
							    		fecha = NOW(),
							    		subtotal = $subtotal,
							    		descto_becas = $descto_becas,
							    		importe = $importe,
							    		descto = $descto,
							    		recargo = $recargo,
							    		importe2 = $importe2,
							    		iva = $iva,
							    		total = $total,
							    		tipo_documento = 1,
							    		ip = '$ip',
							    		host = '$host',
							    		modi_por = $idusr,
							    		modi_el = NOW()
							    	WHERE idfactura = $idfactura");


								for ($i=0; $i < 100; $i++) { 
								
									$idfacdet0 = "idfacdet_".$i;
								
									if ( isset($$idfacdet0) && intval($$idfacdet0)>0 ){

										$idedocta0 = "idedocta_".$i;
										$idpro0 = "idproducto_".$i;
										$pro0 = "producto_".$i;
										$subtotal = "subtotal_".$i;
										$descto_becas = "descto_becas_".$i;
										$importe = "importe_".$i;
										$descto = "descto_".$i;
										$recargo = "recargo_".$i;
										$total = "total_".$i;

										$facDet = mysql_query("
											UPDATE facturas_detalle
													SET
														idedocta = ".$$idedocta0.",
														idproducto = ".$$idpro0.",
														descrip_prod = '".$$pro0."', 
														precio_venta = ".$$subtotal.", 
														subtotal = ".$$subtotal.", 
														descto_becas = ".$$descto_becas.", 
														importe = ".$$importe.", 
														descto = ".$$descto.", 
														recargo = ".$$recargo.", 
														importe2 = ".$$total.", 
														total = ".$$total.", 
											    		ip = '".$ip."',
											    		host = '".$host."',
											    		modi_por = ".$idusr.",
											    		modi_el = NOW()
											    	WHERE idfacdet = ".$$idfacdet0 );
												
												$vRet = "OK";
									
									}else{
										break;
									}

									
								}					

								break; // 12


							case 13: // 13 FACTURA MANUAL

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$ief = explode('-',$idemisorfiscal);
							    $facEnc = mysql_query("Insert Into facturas_encabezado(idcliente,idemisorfiscal,idregfis,forma_de_pago,metodo_de_pago,referencia,fecha,subtotal,descto_becas,importe,descto,recargo,importe2,iva,total,padre,tipo_documento,idemp,ip,host,creado_por,creado_el)
							    					value($idcliente,$ief[0],$idregfis,0,$idmetododepago,'$referencia',NOW(),$subtotal,$descto_becas,$importe,$descto,$recargo,$importe2,$iva,$total,$padre,2,$idemp,'$ip','$host',$idusr,NOW())");
							    
							    $vRet = $facEnc!=1? mysql_error():"OK";

							    $result = mysql_query("SELECT MAX(idfactura) as IDs from facturas_encabezado");
								$rFac=intval(mysql_result($result, 0,"IDs"));

								for ($i=0; $i < 100; $i++) { 
								
									$idedocta0 = "idedocta_".$i;
								
									if ( isset($$idedocta0) && intval($$idedocta0)>0 ){

										$idpro0 = "idproducto_".$i;
										$pro0 = "producto_".$i;
										$subtotal = "subtotal_".$i;
										$descto_becas = "descto_becas_".$i;
										$importe = "importe_".$i;
										$descto = "descto_".$i;
										$recargo = "recargo_".$i;
										$total = "total_".$i;

										$facDet = mysql_query("Insert Into facturas_detalle(
														idfactura,
														idedocta,
														idproducto,
														descrip_prod, 
														descrip_medida, 
														cantidad, 
														precio_venta, 
														subtotal, 
														descto_becas, 
														importe, 
														descto, 
														recargo, 
														importe2, 
														iva, 
														total, 
														idemp,ip,host,creado_por,creado_el)
												value(".$rFac.",
														".$$idedocta0.",
														".$$idpro0.",
														'".$$pro0."',
														'pza', 
														1, 
														".$$subtotal.", 
														".$$subtotal.", 
														".$$descto_becas.", 
														".$$importe.", 
														".$$descto.", 
														".$$recargo.", 
														".$$total.",
														0, 
														".$$total.",
														$idemp,'$ip','$host',$idusr,NOW())");
												
												//$vRet = $result!=1? mysql_error():"OK";
									
									}else{
										//break;
									}

									
								}					

								break; // 13;

							case 14: // Factura Manual

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								
								$ief = explode('-',$idemisorfiscal);

							    $facEnc = mysql_query("
							    	update facturas_encabezado 
							    	set idcliente = $idcliente,
							    		idemisorfiscal = $ief[0],
							    		idregfis = $idregfis,
							    		idmetododepago = $idmetododepago,
							    		referencia = '$referencia',
							    		fecha = NOW(),
							    		subtotal = $subtotal,
							    		descto_becas = $descto_becas,
							    		importe = $importe,
							    		descto = $descto,
							    		recargo = $recargo,
							    		importe2 = $importe2,
							    		iva = $iva,
							    		total = $total,
							    		tipo_documento = 2,
							    		ip = '$ip',
							    		host = '$host',
							    		modi_por = $idusr,
							    		modi_el = NOW()
							    	Where idfactura = $idfactura");
							    $vRet = $facEnc!=1? mysql_error():"OK";


								for ($i=0; $i < 100; $i++) { 
								
									$idfacdet0 = "idfacdet_".$i;
								
									if ( isset($$idfacdet0) && intval($$idfacdet0)>0 ){

										$idedocta0 = "idedocta_".$i;
										$idpro0 = "idproducto_".$i;
										$pro0 = "producto_".$i;
										$subtotal = "subtotal_".$i;
										$descto_becas = "descto_becas_".$i;
										$importe = "importe_".$i;
										$descto = "descto_".$i;
										$recargo = "recargo_".$i;
										$total = "total_".$i;

										$facDet = mysql_query("
											update facturas_detalle
													set
														idedocta = ".$$idedocta0.",
														idproducto = ".$$idpro0.",
														descrip_prod = '".$$pro0."', 
														precio_venta = ".$$subtotal.", 
														subtotal = ".$$subtotal.", 
														descto_becas = ".$$descto_becas.", 
														importe = ".$$importe.", 
														descto = ".$$descto.", 
														recargo = ".$$recargo.", 
														importe2 = ".$$total.", 
														total = ".$$total.", 
											    		ip = '".$ip."',
											    		host = '".$host."',
											    		modi_por = ".$idusr.",
											    		modi_el = NOW()
											    	Where idfacdet = ".$$idfacdet0 );
												
													$vRet = $facDet!=1? mysql_error():"OK";

									
									}else{
										break;
									}

									
								}					

								break; // 14





						}
						break; // 28

					case 29:

						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_metodos_de_pago(metodo_de_pago,metodo_de_pago_predeterminado,status_metodo_de_pago,
																	idemp,ip,host,creado_por,creado_el)
											value('$metodo_de_pago',0,$status_metodo_de_pago,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_metodos_de_pago set 	
															  	metodo_de_pago = '$metodo_de_pago',
															  	metodo_de_pago_predeterminado = $,metodo_de_pago_predeterminado
															  	status_metodo_de_pago = $status_metodo_de_pago,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idmetododepago = $idmetododepago";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_metodos_de_pago Where idmetododepago = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "update cat_metodos_de_pago set 	
															  	metodo_de_pago_predeterminado = 0
										Where idemp = $idemp";
								$result = mysql_query($query);

								$query = "update cat_metodos_de_pago set 	
															  	metodo_de_pago_predeterminado = 1,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idmetododepago = $idmetododepago";
								$result = mysql_query($query);

								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 29


					case 30:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_colores(color,codigo_color_hex,status_color,
																	idemp,ip,host,creado_por,creado_el)
											value('$color','$codigo_color_hex',$status_color,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_colores set 	
															  	color = '$color',
															  	codigo_color_hex = '$codigo_color_hex',
															  	status_color = $status_color,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idcolor = $idcolor";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_colores Where idcolor = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 30

					case 31:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$iscolor = !isset($iscolor)?0:1;	
								$status_producto = !isset($status_producto)?0:1;

								$query = "Insert Into cat_productos(idproveedor,producto,idmedida,idcolor,costo_unitario,iscolor,status_producto,
																	idemp,ip,host,creado_por,creado_el)
											value($idproveedor,'$producto',$idmedida,$idcolor,$costo_unitario,$iscolor,$status_producto,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$iscolor = !isset($iscolor)?0:1;	
								$status_producto = !isset($status_producto)?0:1;

								$query = "update cat_productos set 	
															  	producto = '$producto',
															  	idproveedor = $idproveedor,
															  	idmedida = $idmedida,
															  	idcolor = $idcolor,
															  	costo_unitario = $costo_unitario,
															  	iscolor = $iscolor,
															  	status_producto = $status_producto,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idproducto = $idproducto";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_productos Where idproducto = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 31

					case 32:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_medidas(medida1,medida2,clave,status_medida,
																	idemp,ip,host,creado_por,creado_el)
											value('$medida1','$medida2','$clave',$status_medida,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_medidas set 	
															  	medida1 = '$medida1',
															  	medida2 = '$medida2',
															  	clave = '$clave',
															  	status_medida = $status_medida,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idmedida = $idmedida";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_medidas Where idmedida = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 32

					case 33:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$status_proveedor = !isset($status_proveedor)?0:1;
								$query = "Insert Into cat_proveedores(
																	rfc,
																	contacto,
																	proveedor,
																	direccion,
																	localidad,
																	idmunicipio,
																	idestado,
																	pais,
																	codpos,
																	email1,
																	email2,
																	tel1,
																	tel2,
																	status_proveedor,
																	idemp,ip,host,creado_por,creado_el)
											value(
																	'".strtoupper($rfc)."',
																	'".strtoupper($contacto)."',
																	'".strtoupper($proveedor)."',
																	'".strtoupper($direccion)."',
																	'".strtoupper($localidad)."',
																	$idmunicipio,
																	$idestado,
																	'".strtoupper($pais)."',
																	'".strtoupper($codpos)."',
																	'$email1',
																	'$email2',
																	'$tel1',
																	'$tel2',
																	$status_proveedor,
																	$idemp,'$ip','$host',$idusr,NOW())";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$status_proveedor = !isset($status_proveedor)?0:1;	

								$query = "update cat_proveedores set 	
																rfc = '".strtoupper($rfc)."',
																contacto = '".strtoupper($contacto)."',
																proveedor = '".strtoupper($proveedor)."',
																direccion = '".strtoupper($direccion)."',
																localidad = '".strtoupper($localidad)."',
																idmunicipio = $idmunicipio,
																idestado = $idestado,
																pais = '".strtoupper($pais)."',
																codpos = '".strtoupper($codpos)."',
																email1 = '$email1',
																email2 = '$email2',
																tel1 = '$tel1',
																tel2 = '$tel2',
															  	status_proveedor = $status_proveedor,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idproveedor = $idproveedor";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_proveedores Where idproveedor = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 33







					case 34:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into solicitudes_de_material(idsolicita,status_solicitud_de_material,
																	idemp,ip,host,creado_por,creado_el)
											value($idsolicita,$status_solicitud_de_material,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update solicitudes_de_material set 	
															  	idsolicita = $idsolicita,
															  	status_solicitud_de_material = $status_solicitud_de_material,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsolicituddematerial = $idsolicituddematerial";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from solicitudes_de_material Where idsolicituddematerial = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 34





					case 35:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_supervisores_caja(idusersupervisor,status_supervisor_caja,
																	idemp,ip,host,creado_por,creado_el)
											value($idusersupervisor,$status_supervisor_caja,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_supervisores_caja set 	
															  	idusersupervisor = $idusersupervisor,
															  	status_supervisor_caja = $status_supervisor_caja,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsupervisorcaja = $idsupervisorcaja";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_supervisores_caja Where idsupervisorcaja = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 35


					case 36:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_supervisores_sol_mat(idusersupervisorsolmat,status_supervisor_sol_mat,
																	idemp,ip,host,creado_por,creado_el)
											value($idusersupervisorsolmat,$status_supervisor_sol_mat,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_supervisores_sol_mat set 	
															  	idusersupervisorsolmat = $idusersupervisorsolmat,
															  	status_supervisor_sol_mat = $status_supervisor_sol_mat,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsupervisorsolmat = $idsupervisorsolmat";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_supervisores_sol_mat Where idsupervisorsolmat = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 36


					case 37:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_supervisores_entrega(idusersupervisorentrega,status_supervisor_entrega,
																	idemp,ip,host,creado_por,creado_el)
											value($idusersupervisorentrega,$status_supervisor_entrega,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_supervisores_entrega set 	
															  	idusersupervisorentrega = $idusersupervisorentrega,
															  	status_supervisor_entrega = $status_supervisor_entrega,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsupervisorentrega = $idsupervisorentrega";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_supervisores_entrega Where idsupervisorentrega = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 37


					case 38:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								//$status_solicitud_de_material = !isset($status_solicitud_de_material)?0:1;	

								$query = "Insert Into solicitudes_de_material(
														idsolicita,
														observaciones,
														fecha_solicitud,
														idemp,ip,host,creado_por,creado_el)
												values($idusr,
														'$observaciones',
														NOW(),
														$idemp,
														'$ip',
														'$host',
														$idusr,
														NOW()
												)";
								
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								//$status_solicitud_de_material = !isset($status_solicitud_de_material)?0:1;	
								$query = "update solicitudes_de_material set 	
																observaciones = '$observaciones',
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsolicituddematerial = $idsolicituddematerial";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from solicitudes_de_material Where idsolicituddematerial = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update solicitudes_de_material set 	
															  	status_solicitud_de_material = $val,
															  	fecha_autorizacion = NOW(),
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsolicituddematerial = $id";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update solicitudes_de_material set 	
															  	status_solicitud_de_material = $val,
															  	fecha_entrega = NOW(),
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsolicituddematerial = $id";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break; // 38




					case 39:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "Insert Into solicitudes_de_material_detalles(
														idsolicituddematerial,
														idproducto,
														idcolor,
														idsolicita,
														cantidad_solicitada,
														cantidad_autorizada,
														fecha_solicitud,
														costo_unitario,
														importe_solicitado,
														observaciones_solicitud,
														status_solicitud_de_materiales,
														idemp,ip,host,creado_por,creado_el)
											value(
														$idsolicituddematerial,
														$idprod,
														$idcolor,
														$idusr,
														$cantidad_solicitada,
														$cantidad_solicitada,	
														NOW(),							
														$costo_unitario,						
														$cantidad_solicitada*$costo_unitario,
														'$observaciones_solicitud',
														0,
														$idemp,
														'$ip',
														'$host',
														$idusr,
														NOW()
														)";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update solicitudes_de_material_detalles set 	
															  	idsolicituddematerial = $idsolicituddematerial,
																idproducto = $idprod,
																idcolor = $idcolor,
																idsolicita = $idusr,
																cantidad_solicitada = $cantidad_solicitada,
																cantidad_autorizada = $cantidad_solicitada,
																costo_unitario = $costo_unitario,
																importe_solicitado = $cantidad_solicitada*$costo_unitario,
																importe_autorizado = $cantidad_solicitada*$costo_unitario,
																observaciones_solicitud = '$observaciones_solicitud',
															  	status_solicitud_de_materiales = 0,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsolicituddematerialdetalle = $idsolicituddematerialdetalle";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from solicitudes_de_material_detalles Where idsolicituddematerialdetalle = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update solicitudes_de_material_detalles set 	
															  	status_solicitud_de_materiales = $val,
															  	fecha_autorizacion = NOW(),
															  	idautoriza = $idusr,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsolicituddematerialdetalle = $id";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update solicitudes_de_material_detalles set 	
																cantidad_autorizada = $cantidad_autorizada,
																importe_autorizado = $cantidad_autorizada*costo_unitario,
																observaciones_autorizacion = '$observaciones_autorizacion',
																cantidad_entregado = $cantidad_autorizada,
																importe_entregado = $cantidad_autorizada*costo_unitario,
																observaciones_autorizacion = '$observaciones_autorizacion',
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsolicituddematerialdetalle = $idsolicituddematerialdetalle";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;	

							case 5:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update solicitudes_de_material_detalles set 	
															  	status_solicitud_de_materiales = $val,
															  	fecha_entrega = NOW(),
															  	identrega = $idusr,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsolicituddematerialdetalle = $id";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;	

							case 6:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update solicitudes_de_material_detalles set 	
																cantidad_entregado = $cantidad_entregado,
																importe_entregado = $cantidad_entregado*costo_unitario,
																observaciones_entrega = '$observaciones_entrega',
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idsolicituddematerialdetalle = $idsolicituddematerialdetalle";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;	

						}
						break; // 39



					case 40: // 40
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$f0 = explode('-',$fecha_inicio);
								$fecha_inicio = $f0[2].'-'.$f0[1].'-'.$f0[0].' '.$hora0.':'.$min0.':'.$seg0;

								$f1 = explode('-',$fecha_fin);
								$fecha_fin = $f1[2].'-'.$f1[1].'-'.$f1[0].' '.$hora1.':'.$min1.':'.$seg1;

								$idtareaexistente = $idtarea;

								$query = "Insert Into tareas(
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
								$vRet = $result!=1? mysql_error():"OK";
								break;

							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$f0 = explode('-',$fecha_inicio);
								$fecha_inicio = $f0[2].'-'.$f0[1].'-'.$f0[0].' '.$hora0.':'.$min0.':'.$seg0;

								$f1 = explode('-',$fecha_fin);
								$fecha_fin = $f1[2].'-'.$f1[1].'-'.$f1[0].' '.$hora1.':'.$min1.':'.$seg1;

								$idtareaexistente = $idtarea;

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
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 2:
								$query = "delete from tareas Where idtarea = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$bols  = explode('|',$bols);
								$dests = explode('|',$dests);
								foreach ($bols as $i => $value) {
									if ( intval($bols[$i]) > 0 && intval($dests[$i]) > 0 ){
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
																	$idtarea,
																	".$bols[$i].",
																	$idusr,
																	".$dests[$i].",
																    $idemp,
														    		'$ip',
														    		'$host',
														    		$idusr,
														    		NOW()
														    		)";
										$result = mysql_query($query);
										$vRet = $result!=1? mysql_error():"OK";
									}
								}
								break;

							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$dests = explode('|',$dests);
								foreach ($dests as $i => $value) {
									$query = "delete from tareas_dest Where idtareadestinatario = ".$dests[$i];
									$result = mysql_query($query);
									$vRet = $result!=1? mysql_error():"OK";
								}
								break;

							case 5:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "delete from tareas_dest Where idtareadestinatario = ".$idtareadestinatario;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";

								break;

							case 6:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "Insert Into tareas_dest_respuestas(
															idtareadestinatario,
															respuesta,
															fecha_respuesta,
															idparent,
															status_tarea_destinatario_respuesta,
															idemp,
															ip,
															host,
															creado_por,
															creado_el
														)value( 
															$idtareadestinatario,
															'$respuesta',
															NOW(),
															$idusr,
															1,
														    $idemp,
												    		'$ip',
												    		'$host',
												    		$idusr,
												    		NOW()
												    		)";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;

							case 7:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "update tareas_dest_respuestas 
														set 
															idtareadestinatario = $idtareadestinatario,	
															respuesta = '$respuesta',
															fecha_respuesta = NOW(),
															idparent = $idusr,
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											Where idtareadestinatariorespuesta = ".$idtareadestinatariorespuesta;

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 8:
								$query = "delete from tareas_dest_respuestas Where idtareadestinatariorespuesta = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		


							case 9:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "update tareas_dest 
														set 
															isleida = 1,	
															fecha_leida = NOW(),
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											Where idtareadestinatario = ".$idtareadestinatario;

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		


						}
						break; // 40

					case 41: // 41
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "Insert Into com_grupos(
															iduserpropietario,
															grupo,
															status_com_grupo,
															idemp,
															ip,
															host,
															creado_por,
															creado_el
														)value( 
															$idusr,
															'$grupo',
															$status_com_grupo,
														    $idemp,
												    		'$ip',
												    		'$host',
												    		$idusr,
												    		NOW()
												    		)";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;

							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$query = "update com_grupos set 
															grupo = '$grupo',
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											Where idcomgrupo = ".$idcomgrupo;

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 2:
								$query = "delete from com_grupos Where idcomgrupo = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 3:
								$query = "delete from com_usuarios_asoc_grupos Where idcomuserasocgpo = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

						}
						break; // 41

					case 42: // 42
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$f0 = explode('-',$fecha);
								// $fecha = $f0[2].'-'.$f0[1].'-'.$f0[0].' '.$hora0.':'.$min0.':'.$seg0;
								
								if ( isset($hora0) ){
									$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0].' '.$hora0.':'.$min0.':'.$seg0;
								}else{
									$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0];
								}
								$query = "Insert Into com_mensajes(
															iduserpropietario,
															titulo_mensaje,
															mensaje,
															fecha,
															status_mensaje,
															idciclo,
															idemp,
															ip,
															host,
															creado_por,
															creado_el
														)value( 
															$idusr,
															'$titulo',
															'$mensaje',
															'".$fecha."',
															1,
														    $idciclo,
														    $idemp,
												    		'$ip',
												    		'$host',
												    		$idusr,
												    		NOW()
												    		)";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;

							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$f0 = explode('-',$fecha);
								$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0].' '.$hora0.':'.$min0.':'.$seg0;

								$query = "update com_mensajes 
														set titulo_mensaje = '$titulo',
															mensaje = '$mensaje',
															fecha = '".$fecha."',
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											Where idcommensaje = ".$idcommensaje;

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 2:
								$query = "delete from com_mensajes Where idcommensaje = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$dests = explode('|',$dests);
								foreach ($dests as $i => $value) {
									if ( intval($dests[$i]) > 0 ){
										$query = "Insert Into com_mensaje_dest(
																	idcomgrupo,
																	idcommensaje,
																	idremitente,
																	iddestinatario,
																	idemp,
																	ip,
																	host,
																	creado_por,
																	creado_el
																)value( 
																	$idcomgrupo,
																	$idcommensaje,
																	$idusr,
																	".$dests[$i].",
																    $idemp,
														    		'$ip',
														    		'$host',
														    		$idusr,
														    		NOW()
														    		)";
										$result = mysql_query($query);
										$vRet = $result!=1? mysql_error():"OK";
									}
								}
								break;

							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$dests = explode('|',$dests);
								foreach ($dests as $i => $value) {
									$query = "delete from com_mensaje_dest Where idcommensajedestinatario = ".$dests[$i];
									$result = mysql_query($query);
									$vRet = $result!=1? mysql_error():"OK";
								}
								break;

							case 5:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "delete from com_mensaje_dest Where idcommensajedestinatario = ".$idcommensajedestinatario;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";

								break;

							case 6:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "Insert Into com_mensaje_dest_respuestas(
															idcommensajedestinatario,
															respuesta,
															fecha_respuesta,
															idparent,
															status_mensaje_destinatario_respuesta,
															idemp,
															ip,
															host,
															creado_por,
															creado_el
														)value( 
															$idcommensajedestinatario,
															'$respuesta',
															NOW(),
															$idusr,
															1,
														    $idemp,
												    		'$ip',
												    		'$host',
												    		$idusr,
												    		NOW()
												    		)";

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;

							case 7:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "update com_mensaje_dest_respuestas 
														set 
															idcommensajedestinatario = $idcommensajedestinatario,	
															respuesta = '$respuesta',
															fecha_respuesta = NOW(),
															idparent = $idusr,
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											Where idcommensajedestinatariorespuesta = ".$idcommensajedestinatariorespuesta;

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		



							case 8:
								$query = "delete from com_mensaje_dest_respuestas Where idcommensajedestinatariorespuesta = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		


							case 9:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "update com_mensaje_dest 
														set 
															isleida = 1,	
															fecha_leida = NOW(),
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											Where idcommensajedestinatario = ".$idcommensajedestinatario;

								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		



						}
						break; // 42


					case 43:  // 43
						switch($tipo){
							case 0:
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$alumnos = explode('|', $alumnos);

								for ($i=0; $i<count($alumnos); ++$i) {

				    				$prom0 = "dap0_".$alumnos[$i];
				    				$prom1 = "dap1_".$alumnos[$i];
				    				$prom2 = "dap2_".$alumnos[$i];
				    				$prom3 = "dap3_".$alumnos[$i];
				    				$prom4 = "dap4_".$alumnos[$i];
				    				$prom5 = "dap5_".$alumnos[$i];

				    				$prom00 = floatval($$prom0);
				    				$prom11 = floatval($$prom1);
				    				$prom22 = floatval($$prom2);
				    				$prom33 = floatval($$prom3);
				    				$prom44 = floatval($$prom4);
				    				$prom55 = floatval($$prom5);


								    $result = mysql_query("select idalumno from cat_alu_refer_oficiales where idalumno = ".$alumnos[$i]." and idnivel = $idnivel and idemp = $idemp");
								    $rrd=floatval(mysql_result($result, 0,"idalumno"));
	
									if ($rrd<=0) {
						    				

											$query = "Insert Into cat_alu_refer_oficiales(
												idalumno,
												idnivel,
												prom0,
												prom1,
												prom2,
												prom3,
												prom4,
												prom5,
												idemp,
												ip,
												host,
												creado_por,
												creado_el
											)values(
												".$alumnos[$i].",
												$idnivel,
												".$prom00.", 
												".$prom11.", 
												".$prom22.", 
												".$prom33.", 
												".$prom44.", 
												".$prom55.", 
												$idemp,
												'$ip',
												'$host',
												 $idusr,
												 NOW()
												)";
											
											$result = mysql_query($query);

									}else{
											$query = "Update cat_alu_refer_oficiales Set 
															prom0 = ".$prom00.",
															prom1 = ".$prom11.",
															prom2 = ".$prom22.",
															prom3 = ".$prom33.",
															prom4 = ".$prom44.",
															prom5 = ".$prom55.",
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
														Where idalumno = ".$alumnos[$i]." and idnivel = $idnivel and idemp = $idemp";
											
											$result = mysql_query($query);
						    				
									}

									$vRet = $result!=1? mysql_error():"OK";

								} // 1
								break;

							case 2:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$query = "Update cat_alu_refer_oficiales 
											Set ispromovido = $ispromovido,
												escritura = '$escritura',
												escritura_eval = $escritura_eval,
												lectura = '$lectura',
												lectura_eval = $lectura_eval,
												matematica = '$matematica',
												matematica_eval = $matematica_eval,
												bim0 = '$bim0',
												asignatura0 = '$asignatura0',
												observaciones_especificas0 = '$observaciones_especificas0',
												recomendaciones0 = '$recomendaciones0',
												bim1 = '$bim1',
												asignatura1 = '$asignatura1',
												observaciones_especificas1 = '$observaciones_especificas1',
												recomendaciones1 = '$recomendaciones1',
												bim2 = '$bim2',
												asignatura2 = '$asignatura2',
												observaciones_especificas2 = '$observaciones_especificas2',
												recomendaciones2 = '$recomendaciones2',
												bim3 = '$bim3',
												asignatura3 = '$asignatura3',
												observaciones_especificas3 = '$observaciones_especificas3',
												recomendaciones3 = '$recomendaciones3',
												bim4 = '$bim4',
												asignatura4 = '$asignatura4',
												observaciones_especificas4 = '$observaciones_especificas4',
												recomendaciones4 = '$recomendaciones4',
												observaciones_generales = '$observaciones_generales',
												ip = '$ip',
												host = '$host',
												modi_por = $idusr,
												modi_el = NOW()
											Where idalumno = $idalumno and idnivel = $idnivel and idemp = $idemp";
											
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";

								break; // 2

							case 3:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$f0 = explode('-',$fecha);
								$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0];

							    $result = mysql_query("select clave_nivel from pos_lectura_sep where clave_nivel = $idnivel and grado = $grado and idemp = $idemp");
							    $rrd=floatval(mysql_result($result, 0,"clave_nivel"));

								if ($rrd<=0) {
					    				

										$query = "Insert Into pos_lectura_sep(
											clave_nivel,
											grado,
											mr0,er00,er01,er02,er03,
											mr1,er10,er11,er12,er13,
											mr2,er20,er21,er22,er23,
											mr3,er30,er31,er32,er33,
											lectura, lec0, lec1, lec2, lec3, lec4,
											escritura, esc0, esc1, esc2, esc3, esc4,
											matematicas, mate0, mate1, mate2, mate3, mate4,
											observaciones_generales,
											bim0, asig0, obsesp0, rec0,
											bim1, asig1, obsesp1, rec1,
											bim2, asig2, obsesp2, rec2,
											bim3, asig3, obsesp3, rec3,
											bim4, asig4, obsesp4, rec4,
											x0x0,x0x1,x0x2,x0x3,
											x1x0,x1x1,x1x2,x1x3,
											x2x0,x2x1,x2x2,x2x3,
											x3x0,x3x1,x3x2,x3x3,
											x4x0,x4x1,x4x2,x4x3,
											x5x0,x5x1,x5x2,x5x3,
											x6x0,x6x1,x6x2,x6x3,
											x7x0,x7x1,x7x2,x7x3,
											x8x0,x8x1,x8x2,x8x3,
											x9x0,x9x1,x9x2,x9x3,
											x10x0,x10x1,x10x2,x10x3,
											x11x0,x11x1,x11x2,x11x3,
											initcal_x,
											altofilacal,
											promedio_nivel,
											promedio_grado,
											clave_tecnologia_pos,
											tecnologia_pos,
											area_diciplinaria_pos,
											asesoria_si_pos,
											asignatura_sec,
											asignatura_sec_pos,
											lugar,
											clave_tecnologia,
											tecnologia,
											area_diciplinaria,
											promovido_si,
											promovido_no,
											promovido_condiciones,
											fecha_boleta,
											lugar_pos,
											maestro,
											director,
											iduserdirector,
											dia,
											mes,
											anno,
											idemp,
											ip,
											host,
											creado_por,
											creado_el
										)values(
											$idnivel,
											$grado,
											'$mr0','$er00','$er01','$er02','$er03',
											'$mr1','$er10','$er11','$er12','$er13',
											'$mr2','$er20','$er21','$er22','$er23',
											'$mr3','$er30','$er31','$er32','$er33',
											'$lectura', '$lec0', '$lec1', '$lec2', '$lec3', '$lec4',
											'$escritura', '$esc0', '$esc1', '$esc2', '$esc3', '$esc4',
											'$matematicas', '$mate0', '$mate1', '$mate2', '$mate3', '$mate4',
											'$observaciones_generales',
											'$bim0', '$asig0', '$obsesp0', '$rec0',
											'$bim1', '$asig1', '$obsesp1', '$rec1',
											'$bim2', '$asig2', '$obsesp2', '$rec2',
											'$bim3', '$asig3', '$obsesp3', '$rec3',
											'$bim4', '$asig4', '$obsesp4', '$rec4',
											'$x0x0','$x0x1','$x0x2','$x0x3',
											'$x1x0','$x1x1','$x1x2','$x1x3',
											'$x2x0','$x2x1','$x2x2','$x2x3',
											'$x3x0','$x3x1','$x3x2','$x3x3',
											'$x4x0','$x4x1','$x4x2','$x4x3',
											'$x5x0','$x5x1','$x5x2','$x5x3',
											'$x6x0','$x6x1','$x6x2','$x6x3',
											'$x7x0','$x7x1','$x7x2','$x7x3',
											'$x8x0','$x8x1','$x8x2','$x8x3',
											'$x9x0','$x9x1','$x9x2','$x9x3',
											'$x10x0','$x10x1','$x10x2','$x10x3',
											'$x11x0','$x11x1','$x11x2','$x11x3',
											'$lugar',
											'$clave_tecnologia',
											'$tecnologia',
											'$area_diciplinaria',
											'$initcal_x',
											'$altofilacal',
											'$promedio_nivel',
											'$promedio_grado',
											'$clave_tecnologia_pos',
											'$tecnologia_pos',
											'$area_diciplinaria_pos',
											'$asesoria_si_pos',
											'$asignatura_sec',
											'$asignatura_sec_pos',
											'$promovido_si',
											'$promovido_no',
											'$promovido_condiciones',
											'".$fecha."',
											'$lugar_pos',
											'$maestro',
											'$director',
											$iduserdirector,
											'$dia',
											'$mes',
											'$anno',
											$idemp,
											'$ip',
											'$host',
											 $idusr,
											 NOW()
											)";
										
										$result = mysql_query($query);

								}else{
										$query = "Update pos_lectura_sep Set 
														mr0 = '$mr0', er00 = '$er00', er01 = '$er01', er02 = '$er02', er03 = '$er03',
														mr1 = '$mr1', er10 = '$er10', er11 = '$er11', er12 = '$er12', er13 = '$er13',
														mr2 = '$mr2', er20 = '$er20', er21 = '$er21', er22 = '$er22', er23 = '$er23',
														mr3 = '$mr3', er30 = '$er30', er31 = '$er31', er32 = '$er32', er33 = '$er33',
														lectura = '$lectura', lec0 = '$lec0', lec1 = '$lec1', lec2 = '$lec2', lec3 = '$lec3', lec4 = '$lec4',
														escritura = '$escritura', esc0 = '$esc0', esc1 = '$esc1', esc2 = '$esc2', esc3 = '$esc3', esc4 = '$esc4',
														matematicas = '$matematicas', mate0 = '$mate0', mate1 = '$mate1', mate2 = '$mate2', mate3 = '$mate3', mate4 = '$mate4',
														bim0 = '$bim0', asig0 = '$asig0', obsesp0 = '$obsesp0', rec0 = '$rec0',
														bim1 = '$bim1', asig1 = '$asig1', obsesp1 = '$obsesp1', rec1 = '$rec1',
														bim2 = '$bim2', asig2 = '$asig2', obsesp2 = '$obsesp2', rec2 = '$rec2',
														bim3 = '$bim3', asig3 = '$asig3', obsesp3 = '$obsesp3', rec3 = '$rec3',
														bim4 = '$bim4', asig4 = '$asig4', obsesp4 = '$obsesp4', rec4 = '$rec4',
														observaciones_generales = '$observaciones_generales',
														x0x0 = '$x0x0', x0x1 = '$x0x1', x0x2 = '$x0x2', x0x3='$x0x3',
														x1x0 = '$x1x0', x1x1 = '$x1x1', x1x2 = '$x1x2', x1x3='$x1x3',
														x2x0 = '$x2x0', x2x1 = '$x2x1', x2x2 = '$x2x2', x2x3='$x2x3',
														x3x0 = '$x3x0', x3x1 = '$x3x1', x3x2 = '$x3x2', x3x3='$x3x3',
														x4x0 = '$x4x0', x4x1 = '$x4x1', x4x2 = '$x4x2', x4x3='$x4x3',
														x5x0 = '$x5x0', x5x1 = '$x5x1', x5x2 = '$x5x2', x5x3='$x5x3',
														x6x0 = '$x6x0', x6x1 = '$x6x1', x6x2 = '$x6x2', x6x3='$x6x3',
														x7x0 = '$x7x0', x7x1 = '$x7x1', x7x2 = '$x7x2', x7x3='$x7x3',
														x8x0 = '$x8x0', x8x1 = '$x8x1', x8x2 = '$x8x2', x8x3='$x8x3',
														x9x0 = '$x9x0', x9x1 = '$x9x1', x9x2 = '$x9x2', x9x3='$x9x3',
														x10x0 = '$x10x0', x10x1 = '$x10x1', x10x2 = '$x10x2', x10x3='$x10x3',
														x11x0 = '$x11x0', x11x1 = '$x11x1', x11x2 = '$x11x2', x11x3='$x11x3',
														promedio_nivel = '$promedio_nivel',
														promedio_grado = '$promedio_grado',
														clave_tecnologia_pos = '$clave_tecnologia_pos',
														tecnologia_pos = '$tecnologia_pos',
														area_diciplinaria_pos = '$area_diciplinaria_pos',
														asesoria_si_pos = '$asesoria_si_pos',
														asignatura_sec = '$asignatura_sec',
														asignatura_sec_pos = '$asignatura_sec_pos',
														promovido_si = '$promovido_si',
														promovido_no = '$promovido_no',
														promovido_condiciones = '$promovido_condiciones',
														lugar = '$lugar',
														clave_tecnologia = '$clave_tecnologia',
														tecnologia = '$tecnologia',
														area_diciplinaria = '$area_diciplinaria',
														initcal_x = '$initcal_x',
														altofilacal = '$altofilacal',
														fecha_boleta = '".$fecha."',
														lugar_pos = '$lugar_pos',
														maestro = '$maestro',
														director = '$director',
														iduserdirector = $iduserdirector,
														dia = '$dia',
														mes = '$mes',
														anno = '$anno',
														ip = '$ip',
														host = '$host',
														modi_por = $idusr,
														modi_el = NOW()
													Where clave_nivel = $idnivel and grado = $grado and idemp = $idemp";
										
										$result = mysql_query($query);
					    				
								}

								$vRet = $result!=1? mysql_error():"OK";

								break;
								
							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$f0 = explode('-',$fecha);
								$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0];

								$query = "Update pos_lectura_sep Set 
												0x0 = '$0x0', 0x1 = '$0x1', 0x2 = '$0x2', 0x3='$0x3',
												1x0 = '$1x0', 1x1 = '$1x1', 1x2 = '$1x2', 1x3='$1x3',
												2x0 = '$2x0', 2x1 = '$2x1', 2x2 = '$2x2', 2x3='$2x3',
												3x0 = '$3x0', 3x1 = '$3x1', 3x2 = '$3x2', 3x3='$3x3',
												4x0 = '$4x0', 4x1 = '$4x1', 4x2 = '$4x2', 4x3='$4x3',
												5x0 = '$5x0', 5x1 = '$5x1', 5x2 = '$5x2', 5x3='$5x3',
												6x0 = '$6x0', 6x1 = '$6x1', 6x2 = '$6x2', 6x3='$6x3',
												7x0 = '$7x0', 7x1 = '$7x1', 7x2 = '$7x2', 7x3='$7x3',
												8x0 = '$8x0', 8x1 = '$8x1', 8x2 = '$8x2', 8x3='$8x3',
												9x0 = '$9x0', 9x1 = '$9x1', 9x2 = '$9x2', 9x3='$9x3',
												10x0 = '$10x0', 10x1 = '$10x1', 10x2 = '$10x2', 10x3='$10x3',
												11x0 = '$11x0', 11x1 = '$11x1', 11x2 = '$11x2', 11x3='$11x3',
												lugar = '$lugar',
												fecha_boleta = '".$fecha."',
												ip = '$ip',
												host = '$host',
												modi_por = $idusr,
												modi_el = NOW()
											Where clave_nivel = $idnivel and grado = $grado and idemp = $idemp";
								
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";

								break;


							case 5:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$evalrep00 = floatval($evalrep00);
								$evalrep01 = floatval($evalrep01);
								$evalrep02 = floatval($evalrep02);
								$evalrep03 = floatval($evalrep03);
								$evalrep10 = floatval($evalrep10);
								$evalrep11 = floatval($evalrep11);
								$evalrep12 = floatval($evalrep12);
								$evalrep13 = floatval($evalrep13);
								$evalrep20 = floatval($evalrep20);
								$evalrep21 = floatval($evalrep21);
								$evalrep22 = floatval($evalrep22);
								$evalrep23 = floatval($evalrep23);
								$evalrep30 = floatval($evalrep30);
								$evalrep31 = floatval($evalrep31);
								$evalrep32 = floatval($evalrep32);
								$evalrep33 = floatval($evalrep33);
								$evalrep40 = floatval($evalrep40);
								$evalrep41 = floatval($evalrep41);
								$evalrep42 = floatval($evalrep42);
								$evalrep43 = floatval($evalrep43);

								$query = "Update cat_alu_refer_oficiales 
											Set 
												asigrep0 = '$asigrep0',
												evalrep00 = $evalrep00,
												evalrep01 = $evalrep01,
												evalrep02 = $evalrep02,
												evalrep03 = $evalrep03,
												asigrep1 = '$asigrep1',
												evalrep10 = $evalrep10,
												evalrep11 = $evalrep11,
												evalrep12 = $evalrep12,
												evalrep13 = $evalrep13,
												asigrep2 = '$asigrep2',
												evalrep20 = $evalrep20,
												evalrep21 = $evalrep21,
												evalrep22 = $evalrep22,
												evalrep23 = $evalrep23,
												asigrep3 = '$asigrep3',
												evalrep30 = $evalrep30,
												evalrep31 = $evalrep31,
												evalrep32 = $evalrep32,
												evalrep33 = $evalrep33,
												asigrep4 = '$asigrep4',
												evalrep40 = $evalrep40,
												evalrep41 = $evalrep41,
												evalrep42 = $evalrep42,
												evalrep43 = $evalrep43,
												ip = '$ip',
												host = '$host',
												modi_por = $idusr,
												modi_el = NOW()
											Where idalumno = $idalumno and idnivel = $idnivel and idemp = $idemp";
											
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";

								break; // 2



						}
						break; // 43

					case 44:  // 44
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into cat_alu_tipo_actividad(tipo_actividad,status_tipo_actividad,idemp,ip,host,creado_por,creado_el)
											value( '$tipo_actividad',
												    $status_tipo_actividad,$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update cat_alu_tipo_actividad set tipo_actividad = '$tipo_actividad',
															  	status_tipo_actividad = $status_tipo_actividad,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idalutipoactividad = $idalutipoactividad";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from cat_alu_tipo_actividad Where idalutipoactividad = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;  // 44

					case 45:  // 45
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "Insert Into grupo_materia_config_markbook(
																					descripcion_breve,
																					descripcion_avanzada,
																					idgrumatcon,
																					status_grumatconmkb,idemp,ip,host,creado_por,creado_el)
											value( 
													'$descripcion_breve',
													'$descripcion_avanzada',
													$idgrumatcon,
												    $status_grumatconmkb,$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "update grupo_materia_config_markbook 
															set descripcion_breve = '$descripcion_breve',
																descripcion_avanzada = '$descripcion_avanzada',
															  	status_grumatconmkb = $status_grumatconmkb,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idgrumatconmkb = $idgrumatconmkb";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
								$query = "delete from grupo_materia_config_markbook Where idgrumatconmkb = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;  // 45

					case 48: // 48
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$status_medico = !isset($status_medico)?0:1;	

								$query = "Insert Into cat_medicos(
																app_medico,
																apm_medico,
																nombre_medico,
																especialidad,
																tel1,
																email1,
																tel2,
																email2,
																status_medico,
																idemp,ip,host,creado_por,creado_el)
											value(
																'".mb_strtoupper($app_medico,'UTF-8')."',
																'".mb_strtoupper($apm_medico,'UTF-8')."',
																'".mb_strtoupper($nombre_medico,'UTF-8')."',
																'".mb_strtoupper($especialidad,'UTF-8')."',
																'$tel1',
																'$email1',
																'$tel2',
																'$email2',
																$status_medico,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$status_medico = !isset($status_medico)?0:1;	

								$query = "update cat_medicos set 	
																app_medico = '".mb_strtoupper($app_medico,'UTF-8')."',
																apm_medico = '".mb_strtoupper($apm_medico,'UTF-8')."',
																nombre_medico = '".mb_strtoupper($nombre_medico,'UTF-8')."',
																especialidad = '".mb_strtoupper($especialidad,'UTF-8')."',
																tel1 = '$tel1',
																email1 = '$email1',
																tel2 = '$tel2',
																email2 = '$email2',
																status_medico = $status_medico,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idmedico = $idmedico";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 2:
								$query = "delete from cat_medicos Where idmedico = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;

							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$predeterminado = !isset($predeterminado)?0:1;	
								$query = "Insert Into medicos_alumno(
																idmedico,
																idalumno,
																predeterminado,
																idemp,ip,host,creado_por,creado_el)
															value(
																$idmedico,
																$idalumno,
																$predeterminado,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 4:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$predeterminado = !isset($predeterminado)?0:1;	

								$query = "update medicos_alumno set 	
																idmedico = $idmedico,
																idalumno = $idalumno,
																predeterminado = $predeterminado,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where idmedalu = $idmedalu";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		

							case 5:
								$query = "delete from medicos_alumno Where idmedalu = ".$arg;
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;										
						}
						break; // 48



		  		}
		  
			mysql_close($mysql);

		  return  $vRet;
	}


	public function getQuerys($tipo=0,$cad="",$type=0,$from=0,$cant=0,$ar=array(),$otros="",$withPag=1) {
		  	$arr = array('voEmpty');
		  	$ret = array();

		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);
			
		  	mysql_query("SET NAMES 'utf8'");	
			$index = 0;		
		  
            	switch ($tipo){
				case -5:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
								FROM empresa
								where idemp = $idemp ";
					break;
				case -4:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT llave,valor
								FROM config
								where idemp = $idemp and llave = '$llave' ";
					break;
				case -3:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT llave,valor
									FROM config
								where idemp = $idemp";
					break;
				case -2:
					$query = "SELECT *
									FROM _viUsuarios
								where iduser = $cad  and status_usuario = 1  and idusernivelacceso <= 100";
					break;
				case -1:
					parse_str($cad);
					$iduser = $this->getIdUserFromAlias($u);
			        $idemp = $this->getIdEmpFromAlias($u);
					
					$query = "SELECT iduser, username, apellidos, nombres, foto
								FROM _viUsuarios 
								WHERE  idemp = $idemp and status_usuario = 1  and idusernivelacceso <= 100 
								Order by iduser desc";
					break;
				case 0:
						$query="SELECT *
								from _viUsuarios 
								where username LIKE ('$cad%')  and status_usuario = 1  and idusernivelacceso <= 1000 ";	
						break;	   
				case 1:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_estados
								Where idemp = $idemp order by idestado desc";
					break;
				case 2:
					$query = "SELECT  *
									FROM cat_estados 
								where idestado = $cad ";
					break;
				case 3:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viMunicipios
								Where idemp = $idemp and status_municipio = 1 order by idmunicipio desc";
					break;
				case 4:
					$query = "SELECT  *
									FROM _viMunicipios
								where idmunicipio = $cad ";
					break;
				case 5:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_niveles
								Where idemp = $idemp order by idnivel desc";
					break;
				case 6:
					$query = "SELECT *
									FROM cat_niveles
								where idnivel = $cad ";
					break;

				case 7:
					parse_str($cad);
					
					$idemp = $this->getIdEmpFromAlias($u);
					$arr0 = array(8,9,10,11,12,22);
					$cve = intval($clavenivelacceso);
					$pos = array_search($cve, $arr0);
					$arr1 = array(1,2,3,4,5);

									// Where idemp = $idemp and grupo_ciclo_nivel_visible = 1 and clave_nivel IN ($otros) order by clave_nivel asc";
	
					if (    in_array( $cve, $arr0 )     ) {
							$query = "SELECT idgponiv, idgrupo, grupo_visible, grupo_ciclo_nivel_visible, bloqueado, clave, grupo, 
											ciclo, clave_nivel, grado, idciclo
									FROM _viNivel_Grupos
									Where idemp = $idemp and grupo_ciclo_nivel_visible = 1 and clave_nivel IN ($otros) order by clave_nivel asc";
					}else{
							$query = "SELECT *
											FROM _viNivel_Grupos
										Where idemp = $idemp and grupo_ciclo_nivel_visible = 1 order by clave_nivel asc";
					}
					break;
					
				case 8:
					$query = "SELECT *
									FROM cat_grupos
								where idgrupo = $cad and visible = 1 ";
					break;

				case 9:
					parse_str($cad);
					$idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idalumno, nombre_alumno, username, genero, valid_for_admin, idusuario as idusername
									FROM _viAlumnos
								Where idemp = $idemp order by idalumno desc";
					break;
				case 10:
					$query = "SELECT * 
									FROM _viAlumnos 
								where idalumno = $cad "; 
					break;

				case 11:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idprofesor, nombre_profesor, username, cel1, cel2, direccion
									FROM _viProfesores
								Where idemp = $idemp order by idprofesor desc";
					break;
				case 12:
					$query = "SELECT *
									FROM _viProfesores
								where idprofesor = $cad ";
					break;

				case 13:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viMaterias
								Where idemp = $idemp order by idmateria desc";
					break;
				case 14:
					$query = "SELECT *
									FROM _viMaterias
								where idmateria = $cad ";
					break;

				case 15:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_materias_clasificacion
								Where idemp = $idemp order by idmatclas desc";
					break;
				case 16:
					$query = "SELECT *
									FROM cat_materias_clasificacion
								where idmatclas = $cad ";
					break;

				case 17:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_parentezcos
								Where idemp = $idemp order by idparentezco desc";
					break;
				case 18:
					$query = "SELECT *
									FROM cat_parentezcos
								where idparentezco = $cad ";
					break;

				case 19:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idpersona, nombre_persona, username
									FROM _viPersonas
								Where idemp = $idemp order by idpersona desc";
					break;
				case 20:
					$query = "SELECT *
									FROM _viPersonas
								where idpersona = $cad ";
					break;

				case 21:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idfamilia, familia
									FROM cat_familias
								Where idemp = $idemp order by $otros desc";
					break;
				case 22:
					$query = "SELECT *
									FROM cat_familias
								where idfamilia = $cad ";
					break;

				case 23:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viFamPer
								Where idfamilia = $idfamilia and idemp = $idemp order by $otros desc";
					break;
				case 24:
					$query = "SELECT *
									FROM _viFamPer
								where idfamper = $cad ";
					break;

				case 25:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viFamAlu
								Where idfamilia = $idfamilia and idemp = $idemp order by $otros desc";
					break;
				case 26:
					$query = "SELECT *
									FROM _viFamAlu
								where idfamalu = $cad ";
					break;

				case 27:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idregfis, rfc, cp, razon_social, is_email
									FROM _viRegFis
								Where idemp = $idemp order by $otros desc";
					break;
				case 28:
					$query = "SELECT *
									FROM _viRegFis
								where idregfis = $cad ";
					break;

				case 29:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viFamRegFis
								Where idfamilia = $idfamilia and idemp = $idemp order by $otros desc";
					break;
				case 30:
					$query = "SELECT *
									FROM _viFamRegFis
								where idfamregfis = $cad ";
					break;

				case 31:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        // $idciclo = $this->getCicloFromIdEmp($idemp);
					$query = "SELECT *
									FROM _viGrupo_Materias
								Where  idciclo = $idciclo and idgrupo = $idgrupo and idemp = $idemp order by $otros desc";
					break;

				case 32:
					$query = "SELECT *
									FROM _viGrupo_Materias
								where idgrumat = $cad ";
					break;

				case 33:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);

			        $numval = intval($numval)-1;
			        $ncal = "cal".$numval;
			        $ncon = "con".$numval;
			        $nina = "ina".$numval;
			        $nobs = "obs".$numval;
					$query = "SELECT idboleta, num_lista, alumno, ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, ".$nobs." as obs 
								FROM _viBoletas
								Where idemp = $idemp and idgrumat = $idgrumat order by num_lista asc";


					break;

				case 34:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idgrumatcon, descripcion, porcentaje, idalutipoactividad
									FROM grupo_materia_config
								Where idemp = $idemp and idgrumat = $idgrumat and num_eval = $numval order by idgrumatcon asc ";
					break;

				case 35:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idbolpar, idgrumatcon, idboleta, calificacion
									FROM boleta_partes
								Where idemp = $idemp and idgrumatcon = $idgrumatcon  order by idboleta ";
					break;

				case 36:
					parse_str($cad);
			        // $idemp = $this->getIdEmpFromAlias($user);
					$query = "SELECT idbolpar, idgrumatcon, idboleta, calificacion
									FROM boleta_partes
								Where idgrumatcon = $idgrumatcon ";
					break;

				case 37: // get Evaluaciones
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$idciclo = $this->getCicloFromIdEmp($idemp);

					$query = "SELECT idgponiv, idciclo, idnivel, idgrupo, clave_nivel
									FROM _viNivel_Grupos
								Where idgrupo = $idgrupo and idemp = $idemp and idciclo = $idciclo  and grupo_ciclo_nivel_visible = 1  limit 1 ";
					break;
				case 38:
					parse_str($cad);
			        // $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idgrumatcon, idgrumat, descripcion, porcentaje, num_eval, idalutipoactividad, tipo_actividad, elementos
									FROM _viGruMatConf
								Where idgrumat = $idgrumat and num_eval = $numval $otros ";
					break;

				case 39:
					parse_str($cad);
			        //$idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idgrumatcon, descripcion, porcentaje, num_eval, idalutipoactividad, tipo_actividad, elementos
									FROM _viGruMatConf
								Where idgrumatcon = $cad ";
					break;

				case 40: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, abreviatura, 
										idgrupo, clave_grupo,grupo, profesor, alumno, 
										cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, 
										cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
										cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where idgrualu = $idgrualu $otros ";
					break;

				case 41: // ARJI
					parse_str($cad);
					$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
									cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
									cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina,
									promcalgpo, promcongpo, suminagpo,
									modi_el
									FROM grupo_alumno_promedio
								Where idgrualu = $idgrualu $otros ";
					break;

				case 42: // ARJI
					parse_str($cad);
			        // $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
									cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
									cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina,
									promcalgpo, promcongpo, suminagpo
									FROM grupo_promedios
								Where idgrupo = $idgrupo and idciclo = $idciclo $otros ";
					break;

				case 43: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia,abreviatura, idgrupo, grupo, 
										profesor, idalumno, idnivel, clave_nivel, grado, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where idgrualu = $idgrualu and padre <= 0 and (idmatclas in (1,2,3,4,5) ) $otros ";
					break;

				case 44: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia,abreviatura, idgrupo, grupo, 
										profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where idgrualu = $idgrualu and padre > 0 and (idmatclas in (1,2,3,4,5) ) and orden_impresion <= 100 $otros ";
					break;
				case 45: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia,abreviatura, idgrupo, grupo, 
										profesor, idalumno, idnivel, clave_nivel, grado, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo,
										promcalof
									FROM _viBoletas
								Where (idgrualu = $idgrualu) and (padre <= 0) and (idioma = 0) and (idmatclas <= 5) $otros ";
					break;
				case 46: // ARJI - MATERIAS HIJAS ESPAÑOL
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia,abreviatura, idgrupo, grupo, 
										profesor, idalumno, idnivel, clave_nivel, grado, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo,
										promcalof
									FROM _viBoletas
								Where (idgrualu = $idgrualu) and (padre > 0) and (idioma = 0) and ( idmatclas in (1,2,3,4,5) ) $otros ";
					break;
				case 47: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, idgrupo, grupo, 
										profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas 
								Where (idgrualu = $idgrualu) and (padre <= 0) and (idioma = 1) and (idmatclas <= 5) $otros ";
					break;
				case 48: // ARJI - MATERIAS HIJAS INGLES
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, abreviatura, idgrupo, grupo, 
										profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where (idgrualu = $idgrualu) and (padre > 0) and (idioma = 1) and ( idmatclas in (1,2,3,4,5) ) $otros ";
					break;
				case 49: // ARJI
					parse_str($cad);
					$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
									cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
									cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina, modi_el,
									promcalgpo, promcongpo, suminagpo
									FROM grupo_alumno_promedio_idioma
								Where idgrualu = $idgrualu and idioma = $idioma  $otros ";
					break;

				case 50: // ARJI
					parse_str($cad);
					$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
									cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
									cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina,
									promcalgpo, promcongpo, suminagpo
									FROM grupo_promedios_idiomas
								Where idgrupo = $idgrupo and idciclo = $idciclo and idioma = $idioma $otros ";
					break;

				case 51: // ARJI - MATERIAS INASISTENCIAS ESPAÑOL
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, 
										abreviatura, idgrupo, grupo, idmatclas, 
										profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where (idgrualu = $idgrualu) and (idioma = 0) and ( idmatclas in (7) ) $otros ";
					break;
				case 52: // ARJI - MATERIAS INASISTENCIAS INGLES
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, 
										abreviatura, idgrupo, grupo, idmatclas, 
										profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where (idgrualu = $idgrualu) and (idioma = 1) and ( idmatclas in (7) ) $otros ";
					break;
				
				case 53: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, abreviatura, idgrupo, grupo, 
										profesor, alumno, matricula_interna, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where (idgrualu = $idgrualu) and (padre > 0) and (idioma = $idioma) and (idmatclas <= 5) $otros ";
								// Where (idgrualu = $idgrualu) and (padre <= 0) and (idioma = 0) and (idmatclas <= 5) $otros ";
					break;

				case 54: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, abreviatura, idgrupo, grupo, 
										profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where idgrualu = $idgrualu and idioma = $idioma and isagrupadora_grumat = 1 and (idmatclas in (1,2,3,4,5) ) $otros ";
					break;
		
				case 55: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, abreviatura, idgrupo, grupo, 
										profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
										cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where idgrualu = $idgrualu and idioma = $idioma and padre > 0 and (idmatclas in (1,2,3,4,5) ) and ( orden_impresion between $rango ) $otros ";
					break;

				case 56:  // Get Eval for IdGruAlu
					parse_str($cad);
			        //$idemp = $this->getIdEmpFromAlias($u);
			        if ( $numval == 9 ){
				        $ncal = "promcal";
				        $ncon = "promcon";
				        $nina = "sumina";
			        }elseif ( $numval == 10 ){
				        $ncal = "promcalgpo";
				        $ncon = "promcongpo";
				        $nina = "suminagpo";
			        }else{
				        $numval = intval($numval)-1;
				        $ncal = "bol.cal".$numval;
				        $ncon = "bol.con".$numval;
				        $nina = "bol.ina".$numval;
				        $nobs = "bol.obs".$numval;
			        }
			        
			        if ( $numval == 9 ){
						$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, idmatclas, padre
										FROM _viBoletas
									Where idgrualu = $idgrualu and idgrumat = $idgrumat $otros ";
			        }elseif ( $numval == 10 ){
						$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, idmatclas, padre
										FROM _viBoletas
									Where idgrualu = $idgrualu and idgrumat = $idgrumat $otros ";
					}else{
						
						$qrytemp = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, ".$nobs." as obs, bol.idmatclas, bol.padre
										FROM _viBoletas bol
									Where bol.idgrumat = $idgrumat and bol.idgrualu = $idgrualu $otros";

						$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, ".$nobs." as obs, bol.idmatclas, bol.padre
										FROM _viBoletas bol
									Where bol.idgrumat = $idgrumat and bol.idgrualu = $idgrualu $otros";
					}

					break;

				case 57:  // Get Eval for IdGruAlu
					parse_str($cad);
			        //$idemp = $this->getIdEmpFromAlias($u);
			        if ( $numval == 9 ){
				        $ncal = "promcal";
				        $ncon = "promcon";
				        $nina = "sumina";
			        }elseif ( $numval == 10 ){
				        $ncal = "promcalgpo";
				        $ncon = "promcongpo";
				        $nina = "suminagpo";
			        }else{
				        $numval = intval($numval)-1;
				        $ncal = "cal".$numval;
				        $ncon = "con".$numval;
				        $nina = "ina".$numval;
				        $nobs = "obs".$numval;
			        }
			        
			        if ( $numval == 9 ){
						$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina
										FROM grupo_alumno_promedio
									Where idgrualu = $idgrualu $otros ";
			        }elseif ( $numval == 10 ){
							$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina
											FROM grupo_alumno_promedio
										Where idgrualu = $idgrualu $otros ";
					}else{
						$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, ".$nobs." as obs
										FROM grupo_alumno_promedio
									Where idgrualu = $idgrualu $otros ";
					}
					break;

				case 58:  // Get Eval for IdGruAlu
					parse_str($cad);
			        //$idemp = $this->getIdEmpFromAlias($u);
			        if ( $numval == 9 ){
				        $ncal = "promcal";
				        $ncon = "promcon";
				        $nina = "sumina";
			        }elseif ( $numval == 10 ){
				        $ncal = "promcalgpo";
				        $ncon = "promcongpo";
				        $nina = "suminagpo";
			        }else{
				        $numval = intval($numval)-1;
				        $ncal = "cal".$numval;
				        $ncon = "con".$numval;
				        $nina = "ina".$numval;
				        $nobs = "obs".$numval;
			        }
			        
			        if ( $numval == 9 ){
						$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina
										FROM grupo_alumno_promedio_idioma
									Where idgrualu = $idgrualu $otros ";
			        }elseif ( $numval == 10 ){
							$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina
											FROM grupo_alumno_promedio_idioma
										Where idgrualu = $idgrualu $otros ";
					}else{
						$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, ".$nobs." as obs
										FROM grupo_alumno_promedio_idioma
									Where idgrualu = $idgrualu $otros ";
					}
					break;

				case 59: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idciclo, ciclo, num_lista, materia, abreviatura, 
										idgrupo, clave_grupo,grupo, profesor, alumno, 
										cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, 
										cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
										cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
									FROM _viBoletas
								Where idgrupo = $idgrupo and idgrumat = $idgrumat $otros ";
					break;

				case 60:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viFamAlu
								Where idfamilia = $idfamilia and idalumno = $idalumno and idemp = $idemp limit 1";
					break;

				case 70: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, 
										grupo_oficial, grupo_periodo, grupo_periodo_ciclo,
										materia_oficial, abreviatura_oficial, matricula_oficial,
										matricula_interna, clave, creditos, idmatclas,
										idgrupo, clave_grupo,grupo, profesor, alumno, 
										cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, 
										cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
										cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo,
										bim0,bim1,bim2,bim3,bim4,promcalof, 
										materia, abreviatura 
									FROM _viBoletas
								Where idgrualu = $idgrualu and isoficial = 1 $otros ";
					break;
				case 71: // ARJI
					parse_str($cad);
					$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
									cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
									cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcalof, promconof, suminaof,bim0,bim1,bim2,bim3,bim4,
									modi_el
									FROM grupo_alumno_promedio
								Where idgrualu = $idgrualu $otros ";
					break;
				
				case 72:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT distinct materia_oficial
									FROM _viGrupo_Materias
								Where idgrupo = $idgrupo and isoficial = 1 and idemp = $idemp";
					break;

				case 73: // ARJI
					//parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, 
										grupo_oficial, grupo_periodo, grupo_periodo_ciclo,
										materia_oficial, abreviatura_oficial, matricula_oficial,
										matricula_interna, clave, creditos, idmatclas,
										idgrupo, clave_grupo,grupo, profesor, alumno, 
										cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
										cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, 
										cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
										cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
										promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo,
										bim0,bim1,bim2,bim3,bim4,promcalof, 
										materia, abreviatura, idnivel 
									FROM _viBoletas
								Where $cad $otros ";
					break;

				case 74:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_metodos_de_pago
								Where idemp = $idemp order by idmetododepago asc";
					break;
				case 75:
					$query = "SELECT *
									FROM cat_metodos_de_pago
								where idmetododepago = $cad ";
					break;

				case 76:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_colores
								Where idemp = $idemp order by idcolor asc";
					break;
				case 77:
					$query = "SELECT *
									FROM cat_colores
								where idcolor = $cad ";
					break;

				case 78:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idproducto, idmedida, medida1, producto, proveedor, 
									costo_unitario, codigo_color_hex, color
									FROM _viProductos
								Where idemp = $idemp order by idproducto asc";
					break;
				case 79:
					$query = "SELECT *
									FROM _viProductos
								where idproducto = $cad ";
					break;

				case 80:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_medidas
								Where idemp = $idemp order by idmedida asc";
					break;
				case 81:
					$query = "SELECT *
									FROM cat_medidas
								where idmedida = $cad ";
					break;

				case 82:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_proveedores
								Where idemp = $idemp order by idproveedor asc";
					break;
				case 83:
					$query = "SELECT *
									FROM cat_proveedores
								where idproveedor = $cad ";
					break;

				case 84:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$idusr = $this->getIdUserFromAlias($u);
					$query = "SELECT distinct idsolicituddematerial, solicitante, fecha_solicitud, observaciones, cEstatus, status_solicitud_de_material
									FROM _viSolMatEnc
								Where idemp = $idemp and idsolicita = $idusr order by idsolicita desc";
					break;

				case 85:
					parse_str($cad);
					$query = "SELECT *
									FROM _viSolMatDet
								where idsolicituddematerial = $idsolicituddematerial $otros ";
					break;

				case 86:
					$query = "SELECT *
									FROM _viSolMatDet
								where idsolicituddematerialdetalle = $cad ";
					break;

				case 87:
					parse_str($cad);
					$query = "SELECT *
									FROM _viSolMatEnc
								Where idsolicituddematerial = $cad";
					break;

				case 88:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$idusr = $this->getIdUserFromAlias($u);
					$query = "SELECT *
									FROM _viSolMatEnc
								Where idemp = $idemp and idautoriza = $idusr and status_solicitud_de_material = $sts order by fecha_solicitud desc";
					break;

				case 89:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$idusr = $this->getIdUserFromAlias($u);
					$query = "SELECT distinct idsolicituddematerial, solicitante, fecha_entrega, observaciones, cEstatus, fecha_autorizacion
									FROM _viSolMatEnc
								Where idemp = $idemp and status_solicitud_de_material = $sts order by fecha_solicitud desc";
					break;

				case 90:
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, num_lista, alumno, grupo, materia, profesor, 
								CASE WHEN iduseralu IS NOT NULL THEN iduseralu ELSE 0 END AS iduseralu
									FROM _viBoletas
								Where idgrumat = $idgrumat order by alumno asc";
					break;

				case 91:
					parse_str($cad);
					$query = "SELECT *
									FROM  cat_alu_refer_oficiales
								Where idalumno = $idalumno and idnivel = $idnivel and idemp = $idemp limit 1 ";
					break;

				case 92: // ARJI
					parse_str($cad);
			        if ( $numval == 6 ){
				        $ncal = "promcalof";
			        }else{
				        $numval = intval($numval)-1;
				        $ncal = "bim".$numval;
			        }
					$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
									cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
									cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcalof, promconof, suminaof,bim0,bim1,bim2,bim3,bim4,
									modi_el,".$ncal." as cal
									FROM grupo_alumno_promedio
								Where idgrualu = $idgrualu $otros ";
					break;
				

				case 93:  // Get Eval for IdGruAlu
					parse_str($cad);
			        //$idemp = $this->getIdEmpFromAlias($u);
			        if ( $numval == 6 ){
				        $ncal = "promcalof";
			        }else{
				        $numval = intval($numval)-1;
				        $ncal = "bim".$numval;
			        }
			        
						$query = "SELECT ".$ncal." as cal, idmatclas, padre
										FROM _viBolOf
									Where idgrualu = $idgrualu and idgrumat = $idgrumat $otros ";

					break;

				case 94:
					parse_str($cad);
					$query = "SELECT idboleta
									FROM _viBoletas
								Where idgrualu = $idgrualu and idioma = 0 and idmatclas = 6";
					break;

				case 95:
					parse_str($cad);
					$query = "SELECT calificacion 
									FROM _viGruMatBol 
									WHERE idboleta = $idboleta and num_eval = $numeval order by idgrumatcon asc limit 3 ";
					break;

				case 96:
					parse_str($cad);
					$query = "SELECT *, DATE_FORMAT(fecha_boleta, '%d-%m-%Y') as cfecha_boleta
									FROM  pos_lectura_sep
								Where clave_nivel = $idnivel and grado = $grado and idemp = $idemp limit 1 ";
					break;

				case 97:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viDirectores
								where clave_nivel = $clavenivel and idemp = $idemp and status_director = 1 ";
					break;

				case 98: // ARJI
					parse_str($cad);
					$query = "SELECT inabim0, inabim1, inabim2, inabim3, inabim4
									FROM _viBoletas
								Where idgrualu = $idgrualu $otros ";
					break;

				case 99:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT materia, idgrumat
									FROM _viGrupo_Materias
								Where idgrupo = $idgrupo and isoficial = 1 and idemp = $idemp order by orden_oficial asc";
					break;

				case 100: // ARJI
					//parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, curp,
										grupo_oficial, grupo_periodo, grupo_periodo_ciclo, materia,
										materia_oficial, abreviatura_oficial, matricula_oficial,
										matricula_interna, clave, creditos, idmatclas,
										idgrupo, clave_grupo,grupo, profesor, alumno, 
										bim0,bim1,bim2,bim3,bim4,promcalof, 
										materia, abreviatura 
									FROM _viBolOf
								Where $cad $otros ";
					break;

				case 101: // ARJI
					parse_str($cad);
					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, curp,
									grupo_oficial, grupo_periodo, grupo_periodo_ciclo, materia,
									materia_oficial, abreviatura_oficial, matricula_oficial,
									matricula_interna, clave, creditos, idmatclas,
									idgrupo, clave_grupo,grupo, profesor, alumno, 
									bim0,bim1,bim2,bim3,bim4,promcalof, 
									materia, abreviatura 
								FROM _viBolOf
								Where idboleta = $idboleta $otros ";
							// Where idgrualu = $idgrualu $otros ";
					break;

				case 102:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_alu_tipo_actividad
								Where idemp = $idemp order by idalutipoactividad desc";
					break;
				case 103:
					$query = "SELECT  *
									FROM cat_alu_tipo_actividad 
								where idalutipoactividad = $cad ";
					break;

				case 104:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM grupo_materia_config_markbook
								Where idgrumatcon = $idgrumatcon $otros ";
					break;

				case 105:
					$query = "SELECT  *
									FROM grupo_materia_config_markbook 
								where idgrumatconmkb = $cad ";
					break;

				case 106:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM boleta_partes_markbook
								Where idgrumatconmkb = $idgrumatconmkb order by idgrumatconmkb desc";
					break;

				case 107:
					$query = "SELECT *
									FROM _viMedAlu
								where idmedalu = $cad ";
					break;

				case 108:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viMedAlu
								Where idalumno = $idalumno and idemp = $idemp ";
					break;

				case 109:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM cat_medicos
								Where idemp = $idemp order by idmedico desc";
					break;
					
				case 110:
					$query = "SELECT *
									FROM cat_medicos
								where idmedico = $cad ";
					break;

				case 111:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viFamPer
								Where idfamilia = $idfamilia and clave_parentezco = '$otros' and idemp = $idemp limit 1";
					break;

				case 112:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viFamPer
								Where idpersona = $idpersona  and idemp = $idemp limit 1";
					break;

				case 113: // ARJI
					parse_str($cad);
			        if ( $numval == 6 ){
				        $ncal = "promcalof";
			        }else{
				        $numval = intval($numval)-1;
				        $ncal = "bim".$numval;
			        }
					$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
									cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
									cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcalof, promconof, suminaof,bim0,bim1,bim2,bim3,bim4,
									modi_el,".$ncal." as cal
									FROM grupo_alumno_promedio_idioma
								Where idgrualu = $idgrualu $otros ";
					break;

				case 114: // ARJI
					
					parse_str($cad);

					$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, 
										grupo_oficial, grupo_periodo, grupo_periodo_ciclo,
										materia_oficial, abreviatura_oficial, matricula_oficial,
										matricula_interna, clave, creditos, idmatclas,
										idgrupo, clave_grupo,grupo, profesor, alumno, curp,
										ap_paterno, ap_materno, nombre, idalumno, idnivel,
										bim0,bim1,bim2,bim3,bim4,promcalof, promconof, suminaof, 
										orden_oficial, clave_nivel, 
										inabim0,inabim1,inabim2,inabim3,inabim4,
										materia, abreviatura
									FROM _viBolOf
								Where idgrualu = $idgrualu and isoficial = 1 $otros ";
					break;
					
				case 115:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viEmerAlu
								Where idalumno = $idalumno and idemp = $idemp ";
					break;

				case 116:
					parse_str($cad);

					$query = "SELECT DISTINCT idpaicriterio, criterio, descripcion_criterio 
								FROM _viPAIConceptos 
								WHERE idpaiareadisciplinaria = $idpaiareadisciplinaria 
									AND grado_pai = $grado_pai ";
					break;

				case 117:
					parse_str($cad);

					$query = "SELECT idboleta, num_lista, alumno, profesor 
								FROM _viBolForPAI
								Where idgrumat = $idgrumat order by num_lista asc";
					break;

				case 118:
					parse_str($cad);

			        $numval = intval($numval);

			        $e11 = "eval_".$numval."_1_idcriterio";
			        $e1 = "eval_".$numval."_1";
			        $e12 = "eval_".$numval."_1_rc";

			        $e21 = "eval_".$numval."_2_idcriterio";
			        $e2 = "eval_".$numval."_2";
			        $e22 = "eval_".$numval."_2_rc";

			        $e31 = "eval_".$numval."_3_idcriterio";
			        $e3 = "eval_".$numval."_3";
			        $e32 = "eval_".$numval."_3_rc";

			        $e41 = "eval_".$numval."_4_idcriterio";
			        $e4 = "eval_".$numval."_4";
			        $e42 = "eval_".$numval."_4_rc";

					$query = "SELECT idboletapaibi, idboleta, "
									.$e11." as e11, ".$e1." as e1, ".$e12." as e12," 
									.$e21." as e21, ".$e2." as e2, ".$e22." as e22,"
									.$e31." as e31, ".$e3." as e3, ".$e32." as e32," 
									.$e41." as e41, ".$e4." as e4, ".$e42." as e42 
									FROM boleta_paibi 
								WHERE idboleta = $idboleta limit 1";

					break;

				case 119:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($user);
					$idciclo = $this->getCicloFromIdEmp($idemp);

					$query = "SELECT DISTINCT idprofesor
								FROM _viGrupo_Materias
								Where idciclo = $idciclo and idemp = $idemp order by profesor asc";
					break;

				case 120:
					parse_str($cad);

					$query = "SELECT *
								FROM _viProfesores
								Where idprofesor = $idprofesor and  status_profesor = 1 Limit 1";
					break;


				case 500:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viDirectores
								Where idemp = $idemp order by iddirector desc";
					break;

				case 501:
					$query = "SELECT *
									FROM _viDirectores
								where iddirector = $cad ";
					break;

				case 502:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viSupervisorCaja
								Where idemp = $idemp order by idsupervisorcaja asc";
					break;
				case 503:
					$query = "SELECT *
									FROM _viSupervisorCaja
								where idsupervisorcaja = $cad ";
					break;

				case 504:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viSupervisorSolMat
								Where idemp = $idemp order by idsupervisorsolmat asc";
					break;
				case 505:
					$query = "SELECT *
									FROM _viSupervisorSolMat
								where idsupervisorsolmat = $cad ";
					break;


				case 506:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viSupervisorEntrega
								Where idemp = $idemp order by idsupervisorentrega asc";
					break;

				case 507:
					$query = "SELECT *
									FROM _viSupervisorEntrega
								where idsupervisorentrega = $cad ";
					break;

				case 508:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$idusr = $this->getIdUserFromAlias($u);
					$query = "SELECT *
									FROM _viSolAut
								where idemp = $idemp and idsolicita = $idusr ";
					break;

				case 509:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$idusr = $this->getIdUserFromAlias($u);
					$query = "SELECT *
									FROM _viSupervisorSolMat
								where idemp = $idemp and idusersupervisorsolmat = $idusr ";
					break;

				case 510:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$idusr = $this->getIdUserFromAlias($u);
					$query = "SELECT *
									FROM _viSupervisorEntrega
								where idemp = $idemp and idusersupervisorentrega= $idusr ";
					break;
				
				case 511:
					$query = "SELECT distinct idsolicita, solicitante
									FROM _viSolMatDet
								where idproveedor = $cad and status_solicitud_de_material = 1 and status_solicitud_de_materiales = 1 ";
					break;

				case 512:
					parse_str($cad);
					$query = "SELECT  *
									FROM _viSolMatDet
								where idproveedor = $idproveedor and idsolicita = $idsolicita and status_solicitud_de_material = 1 and status_solicitud_de_materiales = 1 ";
					break;

				case 513:
					$query = "SELECT distinct idsolicita, solicitante
									FROM _viSolMatDet
								where idautoriza = $cad and status_solicitud_de_material = 1 ";
					break;

				case 514:
					parse_str($cad);
					$query = "SELECT  *
									FROM _viSolMatDet
								where idautoriza = $idautoriza and idsolicita = $idsolicita and status_solicitud_de_materiales = 1 ";
					break;

				case 515:
					$query = "SELECT *
									FROM _viSolMatDet
								where idsolicita = $cad and status_solicitud_de_material = 1 ";
					break;

				case 516:
					$query = "SELECT *
									FROM _viDirectores
								where idusuariodirector = $cad ";
					break;

				case 517:
					parse_str($cad);
			        $f0 = explode('-',$fi);
			        $f1 = explode('-',$ff);
			        $fi = $f0[2].'-'.$f0[1].'-'.$f0[0].' 00:00:00';
			        $ff = $f1[2].'-'.$f1[1].'-'.$f1[0].' 23:59:59';

					$query = "SELECT
									sum(cantidad_autorizada) as cantidad, 
									producto, 
									medida1,
									idcolor,
									color,
									costo_unitario, 
									sum(importe_solicitado) as suma
								FROM _viSolMatDet
								where idsolicita = $lstProfDir and 
										status_solicitud_de_materiales = $cmbStatus and 
										( ( DATE(fecha_solicitud) >= '$fi') or (DATE(fecha_solicitud) <= '$ff') ) 
								Group by idproducto 
								Order by cantidad desc";
					break;

				case 10000:
					parse_str($cad);
					$idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idobservacion, observacion, idioma, status_observacion
							FROM cat_observaciones where idemp = $idemp and status_observacion = 1
							Order By idobservacion asc ";
					break;		

				case 10001:
					$query = "SELECT idobservacion, observacion, idioma, status_observacion
									FROM cat_observaciones
								where idobservacion = $cad ";
					break;

				case 10002:
					$query = "SELECT idnivobs, observacion, clave_nivel, nivel, idioma
									FROM _viNivel_Observaciones
								where idnivobs = $cad ";
					break;

				case 10003:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT idconcepto,concepto,status_concepto
									FROM cat_conceptos
								Where idemp = $idemp order by idconcepto desc";
					break;
				case 10004:
					$query = "SELECT idconcepto,concepto,status_concepto
									FROM cat_conceptos
								where idconcepto = $cad ";
					break;

				case 10005:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viEmiFis
								Where idemp = $idemp order by $otros desc";
					break;
				case 10006:
					$query = "SELECT *
									FROM _viEmiFis
								where idemisorfiscal = $cad ";
					break;

				case 10007:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viPagos
								Where idemp = $idemp order by $otros desc";
					break;
				case 10008:
					$query = "SELECT *
									FROM _viPagos
								where idpago = $cad ";
					break;

				case 10009:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$idciclo = $this->getCicloFromIdEmp($idemp);

					// $query = "SELECT distinct idalumno, alumno, clave_nivel, nivel, genero, idciclo, 
					// 							beca_sep, beca_arji, beca_sp, beca_bach
					// 				FROM _viEdosCta
					// 			Where idfamilia = $idfamilia and idciclo = $idciclo and idemp = $idemp order by $otros desc";

					$query = "SELECT distinct idalumno, alumno, genero, idciclo
									FROM _viEdosCta
								Where idfamilia = $idfamilia and idciclo = $idciclo and idemp = $idemp order by $otros asc";
					break;

				case 10010:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);		
			        $idciclo = $this->getCicloFromIdEmp($idemp);		
			        //	and ( ( isfe = 0) or (isfe IS NULL) )
					$query = "SELECT *
									FROM _viEdosCta
								where idfamilia = $idfamilia and idalumno = $idalumno and idciclo = $idciclo and idemp = $idemp $otros ";
					break;

				case 10011:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT *
									FROM _viPagos
								Where idemp = $idemp and idemisorfiscal = $idemisorfiscal and clave_nivel = $clave_nivel order by $otros asc";
					break;

				case 10012:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);				
					$query = "SELECT *
									FROM _viEdosCta
								where idfamilia = $idfamilia and idemp = $idemp ";
					break;

				case 10013:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);				
					$query = " SELECT *
									FROM _viFacEnc
								where idfactura = $idfactura and idemp = $idemp order by idfactura asc ";
					break;

				case 10014:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);				
					$query = " SELECT *
									FROM _viFacDet
								where idfactura = $idfactura and idemp = $idemp order by idfacdet asc ";
					break;

				case 10015:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);	
			        
			        $f0 = explode('-',$fi);
			        $f1 = explode('-',$ff);
			        $fi = $f0[2].'-'.$f0[1].'-'.$f0[0].' 00:00:00';
			        $ff = $f1[2].'-'.$f1[1].'-'.$f1[0].' 23:59:59';

					$query = "SELECT idconcepto, concepto, 
									SUM( IF ( clave_nivel = 1, total, 0 ) ) as 'cero', 
									SUM( IF ( clave_nivel = 2, total, 0 ) ) as 'uno', 
									SUM( IF ( clave_nivel = 3, total, 0 ) ) as 'dos', 
									SUM( IF ( clave_nivel = 4, total, 0 ) ) as 'tres', 
									SUM( IF ( clave_nivel = 5, total, 0 ) ) as 'cuatro' 
								FROM _viEdosCta
								WHERE idemp = $idemp And 
										status_movto = 1 And 
										idemisorfiscal = $emisor And 
										(fecha_de_pago >= '$fi' and fecha_de_pago <= '$ff')
								GROUP BY idconcepto ";
					break;

				case 10016:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);	
			        
			        $f0 = explode('-',$fi);
			        $f1 = explode('-',$ff);
			        $fi = $f0[2].'-'.$f0[1].'-'.$f0[0].' 00:00:00';
			        $ff = $f1[2].'-'.$f1[1].'-'.$f1[0].' 23:59:00';

			        // $conce =  intval($conceptos) > 0 ? ' idconcepto = '.$conceptos.' and ':'';
			        $conce =  intval($vconcepto) > 0 ? ' idconcepto = '.$vconcepto.' and ':'';
			        

					if ( $tiporeporte==3 || $tiporeporte==4 ){
				        $pagado =  " status_movto = 0 ";
					}else{
				        $pagado =  " status_movto = 1 And ( fecha_de_pago >= '".$fi."' and fecha_de_pago <= '".$ff."' )";
					}

			        

					$query = "SELECT idedocta, idconcepto, concepto, familia, alumno, mes, directorio, 
									is_pagos_diversos, fecha_de_pago, cfolio, idfamilia, pdf, xml,
									subtotal, descto_becas, descto, importe, recargo, total,
									idalumno,
									IF ( clave_nivel = 1, total, 0 ) as 'cero', 
									IF ( clave_nivel = 2, total, 0 ) as 'uno', 
									IF ( clave_nivel = 3, total, 0 ) as 'dos', 
									IF ( clave_nivel = 4, total, 0 ) as 'tres', 
									IF ( clave_nivel = 5, total, 0 ) as 'cuatro' 
								FROM _viEdosCta
								WHERE idemp = $idemp And 
										idemisorfiscal = $emisor And 
										$conce
										$pagado 
								ORDER BY fecha_de_pago asc";
					break;

				case 10017:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);				
					$query = " SELECT *
									FROM _viFacEnc
								where idcliente = $idfamilia and (isfe = 1 or padre > 0) and idemp = $idemp order by idfactura desc ";
					break;

				case 10018:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);

					$query = "SELECT distinct idalumno, alumno, genero, 
												beca_sep, beca_arji, beca_sp, beca_bach
									FROM _viFamAlu
								Where idfamilia = $idfamilia and idemp = $idemp order by $otros desc";
					break;

				case 10019:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);

					$query = "SELECT *
									FROM _viFamAlu
								Where idalumno = $idalumno and idemp = $idemp limit 1";
					break;

				case 10020:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT distinct idconcepto, concepto
									FROM _viPagos
								Where idemp = $idemp and idemisorfiscal = $idemisorfiscal order by $otros asc";
					break;

				case 10021:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);				
					$idciclo = $this->getCicloFromIdEmp($idemp);

					$query = "SELECT distinct idalumno, nombre_completo_alumno
									FROM _viEdosCta
								where idfamilia = $idfamilia and idciclo = $idciclo and ( ( isfe = 0) or (isfe IS NULL) ) and idemp = $idemp $otros";
					break;


				case 10022:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);				
					$idciclo = $this->getCicloFromIdEmp($idemp);
					$query = "SELECT *
									FROM _viEdosCta
								where idfamilia = $idfamilia and idalumno = $idalumno and idconcepto = $idconcepto and idciclo = $idciclo and idemp = $idemp ";
					break;

				case 10023:
						parse_str($cad);
						$idemp = $this->getIdEmpFromAlias($u);
						$query = "SELECT * 
								FROM _viGrupo_Alumnos where idciclo = $idciclo and idemp = $idemp and idfamilia = $idfamilia and idalumno = $idalumno and status_grualu = 1 limit 1";
					break;	

				case 10024:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT distinct idconcepto, concepto
									FROM _viPagos
								Where idemp = $idemp and idemisorfiscal = $idemisorfiscal and is_pagos_diversos = 1 order by $otros asc";
					break;

				case 10025:
						parse_str($cad);
						$idemp = $this->getIdEmpFromAlias($u);
						$idciclo = $this->getCicloFromIdEmp($idemp);
						$query = "SELECT * 
								FROM _viGrupo_Alumnos where idciclo = $idciclo and idemp = $idemp and idfamilia = $idfamilia and idalumno = $idalumno and status_grualu = 1 limit 1";
					break;	

				case 20000:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        $idprofesor = $this->getIdUserFromAlias($u);			
			        if ( intval($sts) == 0 ){
			        	$cfg = " AND ( NOW() >= fecha_inicio AND NOW() <= fecha_fin ) ";
			        }else{
			        	$cfg = " AND NOT ( fecha_inicio < NOW() AND fecha_fin > NOW()  ) ";
			        }
					$query = " SELECT idtarea, titulo_tarea, tarea, fecha_inicio, fecha_fin, lecturas, respuestas, archivos, destinatarios, status_tarea 
									FROM _viTareas
								where creado_por = $idprofesor and idemp = $idemp $cfg order by idtarea desc ";
					break;

				case 20001:
					parse_str($cad);
					$query = " SELECT * 
									FROM _viTareas
								where idtarea = $idtarea ";
					break;

				case 20002:
					parse_str($cad);
					$query = " SELECT idtareaarchivo, directorio, archivo, descripcion_archivo, creado_el
									FROM tareas_archivos
								where idtarea = $idtarea and status_tarea_archivo = 1 order by idtareaarchivo desc";
					break;

				case 20003:
					parse_str($cad);
					$idemp = $this->getIdEmpFromAlias($u);

					$query = " SELECT idtareadestinatario, alumno, materia, abreviatura, grupo, isrespuesta, isleida, iddestinatario, idtarea, iteracciones, profesor, profesor_tarea, archivos
									FROM _viTareasDestinatarios
								where idemp = $idemp and idtarea = $idtarea and status_tarea = 1 order by alumno asc ";
					break;

				case 20004:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        $iduseralu = $this->getIdUserFromAlias($u);				
			        $sts = intval($sts);
					if (intval($sts) <= 0){
						$sts = $sts * -1;
						$query = " SELECT idtareadestinatario, idtarea, materia, grupo, profesor, titulo_tarea, fecha_inicio, fecha_fin, isleida, isrespuesta, profesor_tarea, archivos, respuestas, iteracciones
										FROM _viTareasDestinatarios
									where idemp = $idemp and iduseralu = $iduseralu and isleida = $sts order by alumno asc ";
					}else{
						$query = " SELECT idtareadestinatario, idtarea, materia, grupo, profesor, titulo_tarea, fecha_inicio, fecha_fin, isleida, isrespuesta, profesor_tarea, archivos, respuestas, iteracciones
										FROM _viTareasDestinatarios
									where idemp = $idemp and iduseralu = $iduseralu and idboleta = $sts order by alumno asc ";

					}			
					break;

				case 20005:
					parse_str($cad);
					$query = " SELECT * 
									FROM _viTareasDest_Resp
								where idtareadestinatario = $idtareadestinatario ";
					break;

				case 20006:
					//parse_str($cad);
					$query = " SELECT * 
									FROM _viTareasDest_Resp
								where idtareadestinatariorespuesta = $cad ";
					break;

				case 20007:
					parse_str($cad);
					$query = " SELECT idtareaarchivorespuesta, directorio, archivo, descripcion_archivo, idtareadestinatario, creado_por, creado_el
									FROM tareas_dest_resp_archivos
								where idtareadestinatario = $idtareadestinatario and status_tarea_archivo_respuesta = 1 order by idtareaarchivorespuesta desc ";
					break;

				case 20008:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        
					if (intval($sts) <= 0){
						$sts = $sts * -1;
						$query = " SELECT idtareadestinatario, idtarea, materia, grupo, profesor, titulo_tarea, fecha_inicio, fecha_fin, isleida, isrespuesta, profesor_tarea, respuestas, iteracciones, archivos
										FROM _viTareasDestinatarios
									where idemp = $idemp and iduseralu = $iduseralu and isleida = $sts order by alumno asc ";
					}else{
						$query = " SELECT idtareadestinatario, idtarea, materia, grupo, profesor, titulo_tarea, fecha_inicio, fecha_fin, isleida, isrespuesta, profesor_tarea, respuestas, iteracciones, archivos
										FROM _viTareasDestinatarios
									where idemp = $idemp and iduseralu = $iduseralu and idboleta = $sts order by alumno asc ";

					}			
					break;

				case 20009:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        $sts = intval($sts);
			        $loSts = "";
					switch ($sts) {
						case 0:
							$loSts = " and isleida = 0 "; 
							break;						
						case 1:
							$loSts = " and isleida = 1 "; 
							break;
						default:
							$loSts = "  "; 
							break;
					}
			        
					$query = " SELECT idtareadestinatario, idtarea, materia, grupo, profesor, titulo_tarea, fecha_inicio, fecha_fin, isleida, isrespuesta, profesor_tarea, respuestas, iteracciones, archivos
									FROM _viTareasDestinatarios
								where idemp = $idemp and iduseralu = $iduseralu ".$loSts." order by idtareadestinatario desc ";
					break;

				case 20010:
					parse_str($cad);
						$query = " SELECT * 
										FROM _viTareasDestinatarios
									where idtareadestinatario = $idtareadestinatario ";
					break;

				case 20011:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        if ( intval($idprofesor) > 0 ){
						$query = " SELECT idtarea, titulo_tarea, tarea, fecha_inicio, fecha_fin, lecturas, respuestas, archivos, destinatarios, status_tarea 
										FROM _viTareas
									where creado_por = $idprofesor and idemp = $idemp order by idtarea desc ";
					} else {
						$query = " SELECT distinct idtarea, profesor, titulo_tarea, materia, grupo 
										FROM _viTareasDestinatarios
									WHERE creado_por IN ($profesores) AND 
										idemp = $idemp 
									GROUP BY idtarea 	
									ORDER BY idtarea DESC";

					}
					break;

				case 30001:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        $iduserpropietario = $this->getIdUserFromAlias($u);				

					$query = " SELECT *
									FROM com_grupos
								where iduserpropietario = $iduserpropietario and idemp = $idemp and status_com_grupo = 1 order by idcomgrupo asc ";
					break;

				case 30002:
					$query = " SELECT *
									FROM com_grupos
								where idcomgrupo = $cad and status_com_grupo = 1 order by idcomgrupo asc ";
					break;

				case 30003:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
					$query = " SELECT *
									FROM _viComGpoUser
								where idcomgrupo = $idcomgrupo and idemp = $idemp and status_com_usuario_asoc_grupo = 1 order by idcomgrupo asc ";
					break;

				case 31000:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        $iduserpropietario = $this->getIdUserFromAlias($u);				
					$query = " SELECT idcommensaje, titulo_mensaje, mensaje, cfecha, lecturas, respuestas, archivos, destinatarios, status_mensaje 
									FROM _viComMensajes
								where iduserpropietario = $iduserpropietario and idemp = $idemp order by idcommensaje desc ";
					break;

				case 31001:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        $iduserpropietario = $this->getIdUserFromAlias($u);				
					$query = " SELECT idcommensaje, titulo_mensaje, mensaje, cfecha, lecturas, respuestas, archivos, destinatarios, status_mensaje
									FROM _viComMensajes
								where iduserpropietario = $iduserpropietario and idcommensaje = $idcommensaje order by idcommensaje desc ";
					break;

				case 31002:
					parse_str($cad);
					$query = " SELECT idcommensajearchivo, directorio, archivo, descripcion_archivo, creado_el
									FROM com_mensaje_archivos
								where idcommensaje = $idcommensaje and status_mensaje_archivo = 1 order by idcommensajearchivo desc ";
					break;

				case 31003:
					parse_str($cad);
					$query = " SELECT idcommensajedestinatario, nombre_destinatario, nombre_remitente, grupo, isrespuesta, isleida, iddestinatario, idcommensaje, iteracciones, archivos
									FROM _viComMensajeDestinatarios
								where idcommensaje = $idcommensaje and status_mensaje_destinatario = 1 order by nombre_destinatario asc ";
					break;

				case 31004:
					parse_str($cad);
					$query = " SELECT * 
									FROM _viComMensajes
								where idcommensaje = $idcommensaje ";
					break;

				case 31005:
					parse_str($cad);
					$query = " SELECT idcommensajearchivo, directorio, archivo, descripcion_archivo, creado_el
									FROM com_mensaje_archivos
								where idcommensaje = $idcommensaje and status_mensaje_archivo = 1 order by idcommensajearchivo desc";
					break;

				case 31006:
					parse_str($cad);
					$query = " SELECT * 
									FROM _viComMenDestResp
								where idcommensajedestinatario = $idcommensajedestinatario ";
					break;

				case 31007:
					parse_str($cad);
					$query = " SELECT idcommensajearchivorespuesta, directorio, archivo, descripcion_archivo, idcommensajedestinatario, creado_por, creado_el
									FROM com_mensaje_dest_resp_archivos
								where idcommensajedestinatario = $idcommensajedestinatario and status_mensaje_archivo_respuesta = 1 order by idcommensajearchivorespuesta desc ";
					break;

				case 31008:
					//parse_str($cad);
					$query = " SELECT * 
									FROM _viComMenDestResp
								where idcommensajedestinatariorespuesta = $cad ";
					break;

				case 31009:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        $iddestinatario = $this->getIdUserFromAlias($u);				
			        $sts = intval($sts);
			        $loSts = "";
					//$sts = $sts * -1;
					switch ($sts) {
						case 0:
							$loSts = " and isleida = 0 AND (titulo_mensaje IS NOT NULL) "; 
							break;						
						case 1:
							$loSts = " and isleida = 1  AND (titulo_mensaje IS NOT NULL) "; 
							break;
						default:
							$loSts = "   AND (titulo_mensaje IS NOT NULL) "; 
							break;
					}
					$query = " SELECT idcommensajedestinatario, idcommensaje, grupo, titulo_mensaje, fecha, isleida, isrespuesta, nombre_remitente, lecturas, respuestas, iteracciones, archivos
									FROM _viComMensajeDestinatarios
								where idemp = $idemp and iddestinatario = $iddestinatario ".$loSts." order by idcommensajedestinatario desc ";

					break;

				case 31010:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);		
			        $idciclo = $this->getCicloFromIdEmp($idemp);		
			        //	and ( ( isfe = 0) or (isfe IS NULL) )
					$query = "SELECT *
									FROM _viEdosCta
								where idfamilia = $idfamilia and idalumno = $idalumno and idciclo = $idciclo and idemp = $idemp and is_pagos_diversos = 1 $otros";
					break;

				case 31011:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($u);
			        $idciclo = $this->getCicloFromIdEmp($idemp);		
			        $iddestinatario = $this->getIdUserFromAlias($u);				
					$query = " SELECT *
									FROM _viComMensajes
								where idemp = $idemp and idciclo = $idciclo and idcommensaje = $idcommensaje order by idcommensaje desc ";

					break;

				case 31012:
					parse_str($cad);
			        $idemp = $this->getIdEmpFromAlias($user);		
			        $idciclo = $this->getCicloFromIdEmp($idemp);		
					$query = "SELECT *
									FROM _viEdosCta
								where idedocta = $idedocta and idciclo = $idciclo and idemp = $idemp and is_pagos_diversos = 1 ";
					break;

								
				}

			$result = mysql_query($query);

			while ($obj = mysql_fetch_object($result, $arr[$index])) {
						$ret[] = $obj;
			}
			mysql_free_result($result);
		    mysql_close($mysql);
			  
			return $ret;
	
	}


	public function genUserFromCat($iddato=0,$idcat=0) {
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);
			
		  	mysql_query("SET NAMES 'utf8'");	
		  	switch ($idcat) {
		  		case 5:
					$query = "SET @X = Generar_Usuario_from_Alumno(".$iddato.")";
		  			break;
		  		case 6:
					$query = "SET @X = Generar_Usuario_from_Profesor(".$iddato.")";
		  			break;
		  		case 10:
					$query = "SET @X = Generar_Usuario_from_Persona(".$iddato.")";
		  			break;
		  		case 60:
					$query = "SET @X = Generar_Usuario_from_Ex_Alumno(".$iddato.")";
		  			break;
		  	}

			$result = mysql_query($query);
			$ret = $result;
			//mysql_free_result($result);
		    mysql_close($mysql);
			  
			return $ret;

	}

	public function genNumListaPorGrupo($cad="") {
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);

			$ip=$_SERVER['REMOTE_ADDR']; 
			$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
			parse_str($cad);
			$idemp = $this->getIdEmpFromAlias($user);
			$idusr = $this->getIdUserFromAlias($user);
			$idciclo = $this->getCicloFromIdEmp($idemp);
			
		  	mysql_query("SET NAMES 'utf8'");	
			$query = "SET @X = Generar_Numero_de_Lista_Por_Grupo(".$idgrupo.",0,".$idusr.",".$idemp.",'".$ip."','".$host."',".$idciclo.")";

			$result = mysql_query($query);
			$ret = $result==false ? mysql_error():"OK";
			//mysql_free_result($result);
		    mysql_close($mysql);
			  
			return $ret;

	}

	public function cloneNumEvalFromGruMatConAnterior($cad="") {
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);

			$ip=$_SERVER['REMOTE_ADDR']; 
			$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
			parse_str($cad);
			$idemp = $this->getIdEmpFromAlias($user);
			$idusr = $this->getIdUserFromAlias($user);
			
		  	mysql_query("SET NAMES 'utf8'");
		  	$numval = intval($numval);
			$query = "SET @X = Clonar_Config_Eval_Anterior_Gru_Mat_Prof(".$idgrumat.",".$numval.",".$idusr.",".$idemp.",'".$ip."','".$host."')";

			$result = mysql_query($query);
			$ret = $result==false ? mysql_error():"OK";
			//mysql_free_result($result);
		    mysql_close($mysql);
			  
			return $ret;

	}

	public function getPubIdEmp($user="") {
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);

			$idemp = $this->getIdEmpFromAlias($user);
						  
			return $idemp;

	}

	public function getPubIdUser($user="") {
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);

			$idusr = $this->getIdUserFromAlias($user);

		    mysql_close($mysql);
						  
			return $idusr;

	}


	public function getCountTable($field="",$table="", $where=""){
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select count($field) as ntotal from $table where $where limit 1");

			if (!$result) {
					$ret=0;
			}else{
					$ret=intval(mysql_result($result, 0,"ntotal"));
			}
			mysql_free_result($result);
		    mysql_close($mysql);
		    return $ret;
	}



	public function BuscarMarkbookdeAlumno($cad) {
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);

			$ip=$_SERVER['REMOTE_ADDR']; 
			$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
			parse_str($cad);
			$idemp = $this->getIdEmpFromAlias($user);
			$idusr = $this->getIdUserFromAlias($user);


		  	mysql_query("SET NAMES 'utf8'");
		  	$numval = intval($numval);
			$query = "SET @X = Buscar_Markbook_de_Alumno(".$idgrumatcon.",".$idemp.",".$idusr.",'".$ip."','".$host."')";

			$result = mysql_query($query);
			$ret = $result==false ? mysql_error():"OK";
		    mysql_close($mysql);
			  
			return $ret;

	}


	public function getIdFamFromIdUserAlu($iduseralu=0, $type=0) {
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);

			$idusr = $this->getIdFamFromIdUser($iduseralu,1);

		    mysql_close($mysql);

			return $idusr;

	}


 }  // OF CLASS


?>