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
		$this->URL      = "https://platsource.mx/";
	}

	public static function getInstance(){
			if (  !self::$instancia instanceof self){
				  self::$instancia = new self;
			}
			return self::$instancia;
	}

	public function getFolioTim($serie, $idemp){
		$query = "SELECT max(folio) AS folio FROM facturas_encabezado WHERE serie = '$serie' AND idemp = $idemp AND isfe = 1 LIMIT 1 ";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=1;
		}else{
			   	$ret= intval($result[0]->folio)+1;
		}
		$Conn = null;
		return $ret;

	}

	public function getFolio($serie){
	    $query = "SELECT max(folio) AS folio FROM facturas_encabezado WHERE serie = '$serie' LIMIT 1 ";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=1;
		}else{
				   	$ret= intval($result[0]->folio)+1;

		}
		$Conn = null;
	    return $ret;
	}



	private function getIdUserFromAlias($str){
	    $query = "SELECT iduser FROM usuarios WHERE username = '$str' AND status_usuario = 1";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
			   	$ret= intval($result[0]->iduser);
		}
		$Conn = null;
	    return $ret;

	}

	private function getIdEmpFromAlias($str){
	    $query = "SELECT idemp FROM usuarios WHERE username = '$str' AND status_usuario = 1";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
			   	$ret= intval($result[0]->idemp);
		}
		$Conn = null;
	    return $ret;
	}

	private function getCicloFromIdEmp($idemp=0){
	    $query = "SELECT idciclo FROM cat_ciclos WHERE idemp = $idemp AND predeterminado = 1 AND status_ciclo = 1 LIMIT 1";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
			   	$ret= intval($result[0]->idciclo);
		}
		$Conn = null;
	    return $ret;
	}

	private function getCicloAntFromIdEmp($idemp=0){
	    $query = "SELECT anterior FROM cat_ciclos WHERE idemp = $idemp AND predeterminado = 1 AND status_ciclo = 1 LIMIT 1";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
			   	$ret= intval($result[0]->anterior);
		}
		$Conn = null;
	    return $ret;
	}




	private function getIdFamFromIdUser($IdUsername=0, $type=0){
	    
	    if ($type == 0){
	    	$query = "SELECT idfamilia FROM _viFamPer WHERE idusername = $IdUsername AND status_famper = 1 LIMIT 1";
	    }else if  ($type == 1) {
	    	$query = "SELECT idfamilia FROM _viFamAlu WHERE iduseralufortutor = $IdUsername AND status_famalu = 1 LIMIT 1";
	    }

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
			   	$ret= intval($result[0]->idfamilia);
		}
		$Conn = null;
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
	    	$query = "SELECT idprofesor FROM _viProfesores WHERE username = '$str' AND status_usuario = 1";

			$Conn = new voConnPDO();
			$result = $Conn->queryFetchAllAssocOBJ($query);

			if (!$result) {
    				$ret=0;
			}else{
				   	$ret= intval($result[0]->idprofesor);
			}
			$Conn = null;
	    	return $ret;
	}

	public function isExistUserFromEmp($user=""){
		  	$idemp = $this->getPubIdEmp($user);
			
			$query = "SELECT iduser FROM usuarios WHERE username = '$user' AND status_usuario = 1 AND idemp = ".$idemp." LIMIT 1";

			$Conn = new voConnPDO();
			$result = $Conn->queryFetchAllAssocOBJ($query);

			if (!$result) {
    				$ret=0;
			}else{
    				$ret= intval($result[0]->iduser);
			}
			$Conn = null;
		    return $ret;
	}

	public function guardarDatos($query=""){

			$Conn = new voConnPDO();
			$result = $Conn->exec($query);

			if (!$result){
				$rt  = $Conn->errorInfo();
				$ret = is_null($rt[2]) ? "OK" : $rt[2];
			}else{
				$ret = "OK";
			}

			$Conn = null;
			return $ret;
	}

	public function getArray($query){
			$rs=0;
		 	$Conn = new voConnPDO();
			$result = $Conn->queryFetchAllAssocOBJ($query);
			$Conn = null;
			return $result;
	}

	public function execQuery($query){
			$vRet = "OK";
			$Conn = new voConnPDO();
			$result = $Conn->query($query);
			$query="SELECT @X AS outvar;";
			$rt = $Conn->query($query);
			foreach ($rt AS $x){$vRet= is_null($x['outvar']) ? 'Operación no permitida, contacte al administrador' : $x['outvar']; }
			$Conn = null;
			return $vRet;
	}

    public function getCombo($index=0,$arg="",$pag=0,$limite=0,$tipo=0,$otros=""){

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
								$query = "SELECT username AS label, iduser AS data 
										FROM  _viUsuarios WHERE username = '$username' AND password = '$pass' AND status_usuario = 1 ";
								break;		
						}
						break;
					case -1:// valida loguin de usuarios
			          	$ar = explode(".",$arg);
						$pass = md5($ar[1]);
						$query = "SELECT username AS label,password AS data 
								FROM usuarios 
								WHERE username = '$ar[0]' AND password = '$pass' AND status_usuario = 1";
						break;
					case 0:
						switch($tipo){
							case 0:
								parse_str($arg);
								$pass = md5($passwordL);
								$query = "SELECT username AS label, concat(iduser,'|',password,'|',idemp,'|',empresa,'|',idusernivelacceso,'|',registrosporpagina,'|',clave,'|',param1,'|',nombre_completo_usuario) AS data 
										FROM  _viUsuarios WHERE username = '$username' AND password = '$pass' AND status_usuario = 1";
								break;		
							case 1:
								parse_str($arg);
								$pass = md5($passwordL);
								$query = "SELECT username AS label, concat(iduser,'|',password,'|',idemp,'|',empresa,'|',idusernivelacceso,'|',registrosporpagina,'|',clave,'|',param1,'|',nombre_completo_usuario) AS data 
										FROM  _viUsuarios WHERE username = '$username' AND password = '$pass' AND status_usuario = 1";
								break;		
							case 2:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nivel_de_acceso AS label,idusernivelacceso AS data 
										FROM usuarios_niveldeacceso WHERE idemp = $idemp
										ORDER BY label ASC ";
								break;		
							case 3:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(username,' - ',apellidos,' ',nombres) AS label, iduser AS data 
										FROM  _viUsuarios WHERE idemp = $idemp AND status_usuario = 1 AND idusernivelacceso = 1";
								break;		
							case 4:
								parse_str($arg);
								$pass = md5($passwordL);
								$query = "SELECT username AS label, concat(
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
														AS data 
										FROM  _viUsuarios WHERE username = '$username' AND password = '$pass' AND status_usuario = 1";
								break;		
							case 5:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$iduser = $this->getIdUserFromAlias($u);
								$query = "SELECT username AS label, concat(
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
														AS data 
										FROM  _viUsuarios WHERE iduser = $iduser AND idemp = $idemp AND status_usuario = 1";
								break;		
						}
						break;						
					case 1:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT municipio AS label, idmunicipio AS data 
										FROM cat_municipios WHERE idestado = $otros AND status_municipio = 1 AND idemp = $idemp
										ORDER BY data ASC ";
								break;		
							case 1:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT estado AS label, idestado AS data 
										FROM cat_estados WHERE idemp = $idemp AND status_estado = 1 AND idemp = $idemp
										ORDER BY data ASC ";
								break;		
							case 2:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT CASE WHEN predeterminado = 1 THEN CONCAT(ciclo,' (default)') else ciclo end AS label, idciclo AS data, predeterminado 
											FROM cat_ciclos 
											WHERE idemp = $idemp AND status_ciclo = 1 ORDER BY data ASC  ";
								break;		

							case 3:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nivel AS label, idnivel AS data 
										FROM cat_niveles WHERE idemp = $idemp AND status_nivel = 1
										ORDER BY data ASC ";
								break;		

							case 4:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo AS label, idgrupo AS data 
										FROM cat_grupos WHERE idemp = $idemp AND status_grupo = 1  AND visible = 1
										ORDER BY data ASC ";
								break;		
							case 5:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nombre_alumno AS label, idalumno AS data 
										FROM _viAlumnos WHERE idemp = $idemp AND status_alumno = 1
										ORDER BY label ASC ";
								break;		
							case 6:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo AS label, idgrupo AS data 
										FROM _viNivel_Grupos WHERE idemp = $idemp AND idciclo = $idciclo AND idnivel = $otros AND grupo_ciclo_nivel_visible = 1
										ORDER BY idgrupo ASC ";
								break;		
							case 7:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT clasificacion AS label, idmatclas AS data 
										FROM cat_materias_clasificacion WHERE idemp = $idemp AND status_materia_clasificacion
										ORDER BY idmatclas ASC ";
								break;		
							case 8:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT parentezco AS label, idparentezco AS data 
										FROM cat_parentezcos WHERE idemp = $idemp AND status_parentezco
										ORDER BY idparentezco ASC ";
								break;		
							case 9:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(ap_paterno,' ',ap_materno,' ',nombre) AS label, idpersona AS data 
										FROM  cat_personas WHERE idemp = $idemp AND status_persona = 1 $otros ";
								break;		
							case 10:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nombre_persona AS label, idpersona AS data, parentezco, email1, email2, 
												 fecha_nacimiento, cfecha_nacimiento, lugar_nacimiento_persona, 
												username_persona, idfamper, tel1, tel2, cel1, cel2 
										FROM _viFamPer WHERE idfamilia = $idfamilia AND idemp = $idemp AND status_famper = 1
										ORDER BY parentezco ASC ";
								break;		
							case 11:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(razon_social,' - ',rfc) AS label, idregfis AS data 
										FROM _viRegFis WHERE idemp = $idemp AND status_regfis = 1
										ORDER BY razon_social ASC ";
								break;		
							case 12:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nombre_profesor AS label, idprofesor AS data 
										FROM _viProfesores WHERE idemp = $idemp AND status_profesor = 1
										$otros ";
								break;		
							case 13:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT materia AS label, idmateria AS data 
										FROM _viMaterias WHERE idemp = $idemp AND status_materia = 1
										$otros ";
								break;		
							case 14:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT alumno AS label, idgrualu AS data 
										FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND idgrupo = $idgrupo AND idemp = $idemp AND status_grualu = 1
										$otros ";
								break;		
							case 15:
								parse_str($arg);

								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT alumno AS label, idboleta AS data 
										FROM _viBoletas WHERE idgrumat = $idgrumat AND idemp = $idemp
										$otros ";
								break;		
							case 16:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT DISTINCT grupo AS label, idgrupo AS data, ispai_grupo 
										FROM _viGrupo_Materias WHERE idciclo = $idciclo AND idprofesor = $idprofesor AND isagrupadora = 0 AND grupo_visible = 1 
										$otros ";
								break;		
							case 17:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT materia AS label, idgrumat AS data, eval_default, eval_mod, materia_bloqueada, idpaiareadisciplinaria    
										FROM _viGrupo_Materias WHERE idciclo = $idciclo AND idprofesor = $idprofesor AND idgrupo = $idgrupo AND isagrupadora = 0 $otros ";
								break;	
									
							case 18:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT materia AS label, idgrumat AS data 
										FROM _viGrupo_Materias WHERE  idciclo = $idciclo AND idgrupo = $idgrupo AND isagrupadora = 1 AND idemp = $idemp $otros ";
								break;	

							case 19:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT materia AS label, idgrumat AS data 
										FROM _viGrupo_Materias WHERE  idciclo = $idciclo AND idgrupo = $idgrupo AND isagrupadora = 0 AND idemp = $idemp $otros ";
								break;	

							case 20:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT materia AS label, idgrumat AS data 
										FROM _viGrupo_Materias WHERE idciclo = $idciclo AND idgrupo = $idgrupo AND padre = $idgrumat AND idemp = $idemp $otros ";
								break;	
							case 21:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								//$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT alumno AS label, idgrualu AS data, num_lista, clave_nivel, 
												genero, idalumno, usernamealumno, nombre_tutor, idfamilia, 
												familia, email_tutor1, email_tutor2, email_fiscal, 
												username_tutor, idtutor, ap_paterno, ap_materno, nombre, 
												tel1_tutor, tel2_tutor, cel1_tutor, cel2_tutor, grupo,
												fn_tutor, cfn_tutor, idemp, curp, iduseralu
										FROM _viGrupo_Alumnos WHERE idemp = $idemp AND idciclo = $idciclo AND idgrupo = $idgrupo AND status_grualu = 1 ORDER BY num_lista ";
								break;		
							case 22:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo AS label, idgrupo AS data 
										FROM _viGrupo_Alumnos WHERE clave_nivel = $clave_nivel AND idemp = $idemp AND status_grupo = 1
										ORDER BY data ASC ";
								break;

							case 23:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT observacion AS label, idobservacion AS data 
										FROM cat_observaciones WHERE idemp = $idemp AND status_observacion = 1 
										ORDER BY data ASC ";
								break;		

							case 24:
								parse_str($arg);
								// $idemp = $this->getIdEmpFromAlias($user);
								$query = "SELECT DISTINCT abreviatura AS label, idgrumat AS data 
										FROM _viBoletas WHERE idgrupo = $idgrupo AND idciclo = $idciclo
										$otros ";
								break;		


							case 25:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(director,' - ',nivel) AS label, iddirector AS data 
										FROM _viDirectores WHERE idemp = $idemp AND status_director = 1
										ORDER BY data ASC ";
								break;		

							case 26:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT razon_social AS label, concat(idemisorfiscal,'-',serie) AS data  
										FROM cat_emisores_fiscales WHERE idemp = $idemp AND status_emisor_fiscal = 1
										ORDER BY data ASC ";
								break;		

							case 27:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concepto AS label, idconcepto AS data 
										FROM cat_conceptos WHERE idemp = $idemp AND status_concepto = 1
										ORDER BY data ASC ";
								break;		

							case 28:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nivel AS label, clave_nivel AS data 
										FROM cat_niveles WHERE idemp = $idemp AND status_nivel = 1
										ORDER BY data ASC ";
								break;		

							case 29:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT DISTINCT familia AS label, idfamilia AS data, nombre_tutor AS tutor 
										FROM _viFamAlu 
										WHERE idemp = $idemp AND status_famalu = 1 AND familia != 'null'
										ORDER BY label ASC ";
								break;	

							case 30:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(razon_social,' - ',rfc) AS label, idregfis AS data, predeterminado 
										FROM _viFamRegFis WHERE idemp = $idemp AND idfamilia = $idfamilia AND status_famregfis = 1
										ORDER BY razon_social ASC ";
								break;		

							case 31:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT metodo_de_pago AS label, idmetododepago AS data, metodo_de_pago_predeterminado AS isdefault, clave
										FROM cat_metodos_de_pago WHERE idemp = $idemp AND status_metodo_de_pago = 1
										ORDER BY clave ASC ";
								break;		

							case 32:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT color AS label, idcolor AS data, codigo_color_hex
										FROM cat_colores WHERE idemp = $idemp AND status_color = 1
										ORDER BY data ASC ";
								break;		

							case 33:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT producto AS label, idproducto AS data
										FROM cat_productos WHERE idemp = $idemp AND status_producto = 1
										ORDER BY data ASC ";
								break;		

							case 34:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT medida2 AS label, idmedida AS data
										FROM cat_medidas WHERE idemp = $idemp AND status_medida = 1
										ORDER BY data ASC ";
								break;		

							case 35:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT proveedor AS label, idproveedor AS data
										FROM cat_proveedores WHERE idemp = $idemp AND status_proveedor = 1
										ORDER BY data ASC ";
								break;	

							case 36:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(apellidos,' ',nombres) AS label, iduser AS data 
										FROM  _viUsuarios WHERE idemp = $idemp AND status_usuario = 1 
										ORDER BY label ASC";
								break;
	
							case 37:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT autorizan AS label, idusersupervisorsolmat AS data 
										FROM  _viSupervisorSolMat WHERE idemp = $idemp AND status_supervisor_sol_mat = 1 
										ORDER BY label ASC";
								break;

							case 38:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(producto,' ',medida1) AS label, idproducto AS data, costo_unitario
										FROM _viProductos WHERE idemp = $idemp AND status_producto = 1
										ORDER BY label ASC ";
								break;		
							case 39:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT DISTINCT solicitan AS label, idsolicita AS data 
										FROM _viSolAut WHERE idemp = $idemp
										ORDER BY label ASC ";
								break;	

							case 40:
								parse_str($arg);
								$iduseralu = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT DISTINCT materia AS label, idboleta AS data 
											FROM _viBoletas 
											WHERE idciclo = $idciclo AND 
												iduseralu = $iduseralu AND 
												grupo_visible = 1 AND 
												isagrupadora_grumat = 0 AND
												grupo_bloqueado = 0 
											$otros ";
								break;		
	
							case 41:
								parse_str($arg);
								$idusertutor = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
						        $idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT alumno AS label, iduseralufortutor AS data 
										FROM _viFamAlu WHERE idusertutor = $idusertutor AND status_famalu = 1 
										$otros ";
								break;		

							case 42:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT DISTINCT materia AS label, idboleta AS data 
										FROM _viBoletas WHERE idciclo = $idciclo AND iduseralu = $iduseralu AND grupo_visible = 1 AND isagrupadora_grumat = 0
										$otros ";
								break;	

							case 43:
								parse_str($arg);
								$idusertutor = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);

								$query = "SELECT familia AS label, idfamilia AS data, nombre_tutor 
										FROM _viFamAlu WHERE idusertutor = $idusertutor AND status_famalu = 1 AND idemp = $idemp
										$otros ";
								break;		

							case 44:
								parse_str($arg);
								$idusertutor = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);

								$query = "SELECT alumno AS label, idalumno AS data 
										FROM _viFamAlu WHERE idusertutor = $idusertutor AND status_famalu = 1 AND idemp = $idemp
										$otros ";
								break;		

							case 45:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT nivel AS label, clave_nivel AS data 
										FROM cat_niveles WHERE idemp = $idemp AND status_nivel = 1
										ORDER BY data ASC ";
								break;		

							case 46:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT grupo AS label, idgrupo AS data 
										FROM _viNivel_Grupos WHERE idemp = $idemp AND idciclo = $idciclo AND clave_nivel = $clave_nivel AND grupo_ciclo_nivel_visible = 1 AND activo_en_caja = 1 AND status_grupo = 1 
										ORDER BY idgrupo ASC ";
								break;		

							case 47:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);

								$query = "SELECT nivel_de_acceso AS label, idusernivelacceso AS data, clave
										FROM usuarios_niveldeacceso WHERE idemp = $idemp AND visible_in_com = 1 
										ORDER BY clave ASC ";
								break;		

							case 48:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT director AS label, idusuariodirector AS data 
										FROM _viDirectores 
										WHERE idemp = $idemp AND status_director = 1 AND director != 'null'
										ORDER BY label ASC ";
								break;	

							case 49:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT DISTINCT profesor AS label, idusuarioprofesor AS data 
										FROM _viGrupo_Materias 
										WHERE idemp = $idemp AND idciclo = $idciclo AND idgrupo = $idgrupo AND status_grumat = 1 AND profesor != 'null'
										ORDER BY label ASC ";
								break;	

							case 50:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT DISTINCT alumno AS label, iduseralu AS data 
										FROM _viGrupo_Alumnos 
										WHERE idemp = $idemp AND idciclo = $idciclo AND idgrupo = $idgrupo AND status_grualu = 1 AND alumno != 'null'
										ORDER BY label ASC ";
								break;	

							case 51:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT DISTINCT nombre_tutor AS label, idusertutor AS data 
										FROM _viGrupo_Alumnos 
										WHERE idemp = $idemp AND idciclo = $idciclo AND idgrupo = $idgrupo AND status_grualu = 1 AND nombre_tutor != 'null' 
										ORDER BY label ASC ";
								break;	

							case 52:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT DISTINCT nombre_completo_usuario AS label, iduser AS data 
										FROM _viUsuarios 
										WHERE idemp = $idemp  AND idusernivelacceso = $idusernivelacceso AND status_usuario = 1 AND nombre_completo_usuario != 'null' 
										ORDER BY label ASC ";
								break;	

							case 53:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
						        $iduserpropietario = $this->getIdUserFromAlias($u);				
								$query = "SELECT grupo AS label, idcomgrupo AS data 
										FROM com_grupos 
										WHERE idemp = $idemp  AND iduserpropietario = $iduserpropietario AND status_com_grupo = 1 AND grupo != 'null' 
										ORDER BY label ASC ";
								break;	

							case 54:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
						        $iduserpropietario = $this->getIdUserFromAlias($u);				
								$query = "SELECT usuario AS label, iduser AS data 
										FROM _viComGpoUser 
										WHERE idemp = $idemp AND idcomgrupo = $idcomgrupo 
										ORDER BY label ASC ";
								break;	

							case 55:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								//$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT DISTINCT alumno AS label, idalumno AS data, idnivel, num_lista 
										FROM _viGrupo_Alumnos 
										WHERE idemp = $idemp AND idciclo = $idciclo AND idgrupo = $idgrupo AND status_grualu = 1 AND alumno != 'null'
										ORDER BY num_lista ASC ";
								break;	

							case 56:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
						        $iduserpropietario = $this->getIdUserFromAlias($u);				
								$query = "SELECT descripcion_breve AS label, idgrumatconmkb AS data 
										FROM grupo_materia_config_markbook 
										WHERE idemp = $idemp  AND idgrumatcon = $idgrumatcon AND status_grumatconmkb = 1
										ORDER BY label ASC ";
								break;

							case 57:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								// $idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT alumno AS label, idgrualu AS data, num_lista, clave_nivel, 
												genero, idalumno, usernamealumno, nombre_tutor, idfamilia, 
												familia, email_tutor1, email_tutor2, email_fiscal, username_tutor, idtutor
										FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND idgrupo = $idgrupo AND idemp = $idemp AND status_grualu = 1 ORDER BY num_lista ";
								break;		

							case 58:
								parse_str($arg);
						        $idemp = $this->getIdEmpFromAlias($u);

								$query = "SELECT alumno AS label, idalumno AS data 
										FROM _viFamAlu WHERE iduseralufortutor = $iduseralu AND status_famalu = 1 AND idemp = $idemp LIMIT 1
										";
								break;		

							case 59:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT * 
										FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND idemp = $idemp AND iduseralu = $iduseralu AND status_grualu = 1
										$otros ";
								break;		

							case 60:
								parse_str($arg);
								$idusertutor = $this->getIdUserFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
						        $idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT alumno AS label, iduseralufortutor AS data 
										FROM _viFamAlu WHERE idusertutor = $idusertutor AND status_famalu = 1 AND idemp = $idemp AND status_alumno = 1 
										$otros ";
								break;		

							case 61:
								parse_str($arg);
								$idusername = $this->getIdUserFromAlias($u);
						        $idemp      = $this->getIdEmpFromAlias($u);
						        $idfamilia  = $this->getIdFamFromIdUser($idusername,0);

								$query = "SELECT alumno AS label, iduseralufortutor AS data 
										FROM _viFamAlu WHERE idfamilia = $idfamilia AND status_famalu = 1 AND idemp = $idemp
										$otros ";
								break;		

							case 62:
								parse_str($arg);
								$idusername = $this->getIdUserFromAlias($u);
						        $idemp      = $this->getIdEmpFromAlias($u);
						        $idfamilia  = $this->getIdFamFromIdUser($idusername,0);

								$query = "SELECT familia AS label, idfamilia AS data, nombre_tutor 
										FROM _viFamAlu WHERE idfamilia = $idfamilia AND status_famalu = 1 AND idemp = $idemp
										$otros ";
								break;		

							case 63:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT ispai_materia, isagrupadora 
										FROM cat_materias WHERE idemp = $idemp AND status_materia = 1 AND idmateria = $idmateria
										limit 1";
								break;		

							case 64:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT ispai_grupo 
										FROM cat_grupos WHERE idemp = $idemp AND status_grupo = 1 AND idgrupo = $idgrupo
										limit 1";
								break;		

							case 65:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT area_disciplinaria AS label, idpaiareadisciplinaria AS data 
										FROM cat_pai_areas_disciplinarias WHERE idemp = $idemp AND status_area_disciplinaria
										ORDER BY idpaiareadisciplinaria ASC ";
								break;		

							case 66:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT DISTINCT grupo AS label, idgrupo AS data, grado_pai
										FROM _viGrupo_Materias WHERE idciclo = $idciclo AND idprofesor = $idprofesor AND isagrupadora = 0 AND grupo_visible = 1 AND ispai_grupo = 1 AND idpaiareadisciplinaria > 0 AND idemp = $idemp 
										$otros ";
								break;		

							case 67:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$query = "SELECT materia AS label, idgrumat AS data, eval_default, eval_mod, materia_bloqueada, idpaiareadisciplinaria, grado_pai   
										FROM _viGrupo_Materias WHERE idciclo = $idciclo AND idprofesor = $idprofesor AND idgrupo = $idgrupo AND grado_pai = $grado_pai AND isagrupadora = 0 AND idemp = $idemp $otros ";
								break;	

							case 68:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT descripcion_claveprodserv AS label, idclaveprodservsat AS data
										FROM cat_cveprodserv_sat WHERE idemp = $idemp and status_claveprodserv = 1
										ORDER BY label ASC ";
								break;	

							case 69:
								parse_str($arg);
								$idprofesor = $this->getIdProfFromAlias($u);
						        $idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT concat(claveunidadmedida,' - ',claveunidadmedida_descripcion) AS label, idclaveunidadmedida AS data
										FROM cat_claveunidadmedida_sat WHERE idemp = $idemp and status_claveunidadmedida = 1
										ORDER BY label ASC ";
								break;	

							case 70:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idusr = $this->getIdUserFromAlias($u);
								$query = "SELECT DISTINCT escenario AS label, iduserconceptoescenario AS data  
										FROM _viUsersConceptosPagos WHERE idemp = $idemp AND iduser = $idusr AND status_usuario_concepto_escenario = 1
										ORDER BY iduserconceptoescenario ASC ";
								break;		

							case 71:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idusr = $this->getIdUserFromAlias($u);
								$query = "SELECT motivo_baja AS label, idalumotivobaja AS data, clave  
										FROM cat_alu_baja_motivos WHERE idemp = $idemp AND status_motivo_baja = 1
										ORDER BY idalumotivobaja ASC ";
								break;		
								
						}
						break;
					case 2:  // Asociaciones
						switch($tipo){
							case 0:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo AS label,idgponiv AS data 
										FROM _viNivel_Grupos WHERE idemp = $idemp AND idciclo = $idciclo AND idnivel = $otros  AND grupo_ciclo_nivel_visible = 1
										ORDER BY label ASC ";
								break;		

							case 1: // Obtiene a Lista de Todos los Alumnos de la empresa
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT alumno AS label,idgrualu AS data 
										FROM _viGrupo_Alumnos WHERE idemp = $idemp AND idciclo = $idciclo AND idgrupo = $otros
										ORDER BY label ASC ";
								break;		

							case 2:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT observacion AS label,idnivobs AS data 
										FROM _viNivel_Observaciones WHERE idemp = $idemp AND idnivel = $otros
										ORDER BY label ASC ";
								break;		
							case 3:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT profesor AS label,iddirprof AS data 
										FROM _viDirProf WHERE idemp = $idemp AND iddirector = $otros
										ORDER BY profesor ASC ";
								break;		
							case 4: // Obtiene a Lista de Todos los Alumnos de la empresa basado en el Ciclo
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT alumno AS label,idgrualu AS data 
										FROM _viGrupo_Alumnos 
										WHERE idemp = $idemp AND idciclo = $idciclo AND idgrupo = $otros
										ORDER BY label ASC ";
								break;		
							case 5:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT grupo AS label,idgponiv AS data 
										FROM _viNivel_Grupos WHERE idemp = $idemp AND idciclo = $idciclo AND status_ciclo = 1  AND grupo_ciclo_nivel_visible = 1
										ORDER BY clave_nivel, clave ASC ";
								break;		

							case 6:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT solicitan AS label, idsolicitanteautorizante AS data 
										FROM _viSolAut WHERE idemp = $idemp AND idautoriza = $otros
										ORDER BY label ASC ";
								break;

							case 7: // 
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT nombres_alumno AS label, idgrualu AS data, grupo, clave_nivel, ver_boleta_interna, grupo_bloqueado, grado_pai, ispai_grupo
										FROM _viGrupo_Alumnos WHERE idemp = $idemp AND idciclo = $idciclo AND idfamilia = $idfamilia AND status_grualu = 1
										ORDER BY label ASC ";
								break;		
			
							case 8:
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "SELECT usuario AS label, idcomuserasocgpo AS data 
										FROM _viComGpoUser WHERE idemp = $idemp AND idcomgrupo = $idcomgrupo AND status_com_usuario_asoc_grupo = 1
										ORDER BY label ASC ";
								break;

							case 9: // 
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT nombres_alumno AS label, idgrualu AS data, grupo, clave_nivel, idfamilia
										FROM _viGrupo_Alumnos WHERE idemp = $idemp AND idciclo = $idciclo AND idfamilia = $idfamilia AND idgrualu = $idgrualu AND status_grualu = 1
										ORDER BY label ASC ";
								break;		

							case 10: // 
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT nombres_alumno AS label, idgrualu AS data, grupo, clave_nivel
										FROM _viGrupo_Alumnos WHERE idemp = $idemp AND idciclo = $idciclo AND idalumno = $idalumno AND status_grualu = 1
										ORDER BY label ASC ";
								break;		

							case 11: 
								parse_str($arg);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SELECT *
										FROM _viGrupo_Alumnos 
											WHERE 
												idemp = $idemp AND 
												idciclo = $idciclo AND 
												iduseralu = $idgrualu AND 
												status_grualu = 1 AND 
												grupo_bloqueado = 0 
										limit 1";
								break;		
			


						}
						break;


		  	}

			$result = $this->getArray($query);
			return $result;

	}

    public function setAsocia($tipo=0,$arg="",$pag=0,$limite=0,$var2=0, $otros=""){
			$query="";

			$ip=$_SERVER['REMOTE_ADDR']; 
			$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
			$vRet = "Error";
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
							foreach($item AS $i=>$valor){
								if ((int)($item[$i])>0){
									$query = "INSERT INTO nivel_grupos(idciclo,idnivel,idgrupo,idemp,ip,host,creado_por,creado_el)VALUES($idciclo,$ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
									$vRet = $this->guardarDatos($query);
								}
							}
							break;		
						case 20:

		          			$ar = explode("|",$arg);
							foreach($ar AS $i=>$valor){
								if ((int)($ar[$i])>0){
									$query = "DELETE FROM nivel_grupos WHERE idgponiv = ".$ar[$i];
									$vRet = $this->guardarDatos($query);
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
							foreach($item AS $i=>$valor){
								if ((int)($item[$i])>0){
									$query = "INSERT INTO grupo_alumnos(idciclo,idgrupo,idalumno,idemp,ip,host,creado_por,creado_el)VALUES($idciclo,$ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
									$vRet = $this->guardarDatos($query);
								}
							}
							break;		
						case 20:

		          			$ar = explode("|",$arg);
							foreach($ar AS $i=>$valor){
								if ((int)($ar[$i])>0){
									$query = "DELETE FROM grupo_alumnos WHERE idgrualu = ".$ar[$i];
									$vRet = $this->guardarDatos($query);
								}
							}
							break;		
						case 30:
		          			$ar = parse_str($otros);
							$iduser = $this->getIdUserFromAlias($u);
							$idemp = $this->getIdEmpFromAlias($u);
							$idciclo = $this->getCicloFromIdEmp($idemp);
							$idcicloant = $this->getCicloAntFromIdEmp($idemp);
							$query = "SET @X = Copiar_Alumnos_de_Grupo_a_Grupo(".$idgrupoorigen.",".$idgrupodestino.",".$idciclo.",".$iduser.",".$idemp.",'".$ip."','".$host."',".$idcicloant.")";
							$vRet = $this->execQuery($query);
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
							foreach($item AS $i=>$valor){
								if ((int)($item[$i])>0){
									$query = "INSERT INTO nivel_observaciones(idnivel,idobservacion,idemp,ip,host,creado_por,creado_el)
												VALUES($ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
									$vRet = $this->guardarDatos($query);
								}
							}
							break;		
						case 20:

		          			$ar = explode("|",$arg);
							foreach($ar AS $i=>$valor){
								if ((int)($ar[$i])>0){
									$query = "DELETE FROM nivel_observaciones WHERE idnivobs = ".$ar[$i];
									$vRet = $this->guardarDatos($query);
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
							foreach($item AS $i=>$valor){
								if ((int)($item[$i])>0){
									$query = "INSERT INTO director_profesores(iddirector,idprofesor,idemp,ip,host,creado_por,creado_el)VALUES($ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
									$vRet = $this->guardarDatos($query);
								}
							}
							break;		
						case 20:

		          			$ar = explode("|",$arg);
							foreach($ar AS $i=>$valor){
								if ((int)($ar[$i])>0){
									$query = "DELETE FROM director_profesores WHERE iddirprof = ".$ar[$i];
									$vRet = $this->guardarDatos($query);
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
							foreach($item AS $i=>$valor){
								if ((int)($item[$i])>0){
									$query = "INSERT INTO solicitantes_vs_autorizantes(idautoriza,idsolicita,idemp,ip,host,creado_por,creado_el)VALUES($ar[1],$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
									$vRet = $this->guardarDatos($query);
								}
							}
							break;		
						case 20:

		          			$ar = explode("|",$arg);
							foreach($ar AS $i=>$valor){
								if ((int)($ar[$i])>0){
									$query = "DELETE FROM solicitantes_vs_autorizantes WHERE idsolicitanteautorizante = ".$ar[$i];
									$vRet = $this->guardarDatos($query);
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
							foreach($item AS $i=>$valor){
								if ((int)($item[$i])>0){
									$query = "INSERT INTO com_usuarios_asoc_grupos(idcomgrupo,iduser,idemp,ip,host,creado_por,creado_el)VALUES($idcomgrupo,$item[$i],$idemp,'$ip','$host',$iduser,NOW())";
									$vRet = $this->guardarDatos($query);
								}
							}
							break;	

						case 20:
							parse_str($otros);
		          			$ar = explode("|",$dests);
							foreach($ar AS $i=>$valor){
								if ((int)($ar[$i])>0){
									$query = "DELETE FROM com_usuarios_asoc_grupos WHERE idcomuserasocgpo = ".$ar[$i];
									$vRet = $this->guardarDatos($query);
								}
							}
							break;		

					}
					break; // 41

	  		}

	  	return  $vRet;
	}


    public function setSaveData($index=0,$arg="",$pag=0,$limite=0,$tipo=0,$cadena2=""){
		  	$query="";

		  	$ip=$_SERVER['REMOTE_ADDR']; 
		  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
		  	$vRet = "Error";
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
									$query = "INSERT INTO usuarios(username,password,apellidos,nombres,
																	correoelectronico,idusernivelacceso,
																	status_usuario,
																	idemp,ip,host,creado_por,creado_el)
												VALUES( '$username','$pass','$apellidos','$nombres',
														'$correoelectronico',$idusernivelacceso,
														$status_usuario,
													    $idemp,'$ip','$host',$idusr,NOW())";
									$vRet = $this->guardarDatos($query);
								}else{
									$vRet = "Error: No puede usar ese prefijo en el Nombre de Usuario";
								}
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								if ( isset($idusernivelacceso) ){
									$idnivacc = " idusernivelacceso = $idusernivelacceso, ";	
								}else{
										$idnivacc = "";
								}
								$query = "UPDATE usuarios SET apellidos = '$apellidos',
																nombres = '$nombres',
																correoelectronico = '$correoelectronico',
																".$idnivacc."
																status_usuario = $status_usuario,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE iduser = $iduser";

								$vRet = $this->guardarDatos($query);

								break;		
							case 2:
								$query = "DELETE FROM usuarios WHERE iduser = ".$arg;
								$vRet = $this->guardarDatos($query);

								break;		
							case 3:
								parse_str($arg);
								$pass = md5($password1);
								$query = "UPDATE usuarios SET password = '$pass',
																ip = '$ip', 
																host = '$host',
																modi_por = $iduser2, 
																modi_el = NOW()
										WHERE iduser = $iduser";
								$vRet = $this->guardarDatos($query);

								break;		
							case 100:
							     
								parse_str($arg);
								$tel = trim(utf8_decode($celular));
								$pass = md5($password);
								$query = "INSERT INTO usuarios(username,password,nombres,celular,idF,latitud,longitud,ip,host,creado_el)
													VALUES('$username','$pass','$nombre','$tel','$idF','$latitud','$longitud','$ip','$host',NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 101:
							     
								parse_str($arg);
								$query = "UPDATE usuarios SET valid = 1 WHERE username='$username'";
								$vRet = $this->guardarDatos($query);
								break;		
							case 200:
							     
								parse_str($arg);
								$pass = md5($password);
								$query = "INSERT INTO usuarios(username,password,ip,host,creado_el)
													VALUES('$username','$pass','$ip','$host',NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 203:
							     
								parse_str($arg);
								if ( isset($idusernivelacceso) ){
									$idnivacc = " idusernivelacceso = $idusernivelacceso, ";	
								}else{
									$idnivacc = "";
								}
								
								$token_validated = $token == $token_source ? 1 : 0;
								$token = intval($token_validated) == 1? $token :"";

								$query = "UPDATE usuarios SET 
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
														WHERE username LIKE ('$username2%')";
								$vRet = $this->guardarDatos($query);
								break;		
							case 204:
							     
								parse_str($arg);
								$query = "UPDATE usuarios SET foto = '$foto',
															 ip = '$ip',
															 host = '$host'
															 WHERE username LIKE ('$username%')";
								$vRet = $this->guardarDatos($query);

								break;		

							case 205:
							     
								parse_str($arg);
								$pass = md5($password);

								$query = "UPDATE usuarios SET 
															 password = '$pass', 
															 ip = '$ip',
															 host = '$host'
														WHERE username LIKE ('$username2%')";
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break;
					case 1:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_estados(clave,estado,status_estado,idemp,ip,host,creado_por,creado_el)
											VALUES( '$clave','$estado',
												    $status_estado,$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_estados SET 	clave = '$clave',
															  	estado = '$estado',
															  	status_estado = $status_estado,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idestado = $idestado";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_estados WHERE idestado = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break;
					case 2:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_municipios(idestado,clave,municipio,status_municipio,idemp,ip,host,creado_por,creado_el)
											VALUES( $idestado, '$clave','$municipio',
												    $status_municipio,$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_municipios SET idestado = $idestado,
																clave = '$clave',
															  	municipio = '$municipio',
															  	status_municipio = $status_municipio,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idmunicipio = $idmunicipio";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_municipios WHERE idmunicipio = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break;

					case 3:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_niveles(nivel,clave_nivel,nivel_oficial,nivel_fiscal,clave_registro_nivel,status_nivel,
																	fecha_actas,		
																	idemp,ip,host,creado_por,creado_el)
											VALUES('$nivel','$clave_nivel','$nivel_oficial','$nivel_fiscal','$clave_registro_nivel',$status_nivel,
													'$fecha_actas',	
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_niveles SET 	
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
										WHERE idnivel = $idnivel";
								$vRet = $this->guardarDatos($query);

								break;		
							case 2:
								$query = "DELETE FROM cat_niveles WHERE idnivel = ".$arg;
								$vRet = $this->guardarDatos($query);
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
								$query = "INSERT INTO cat_grupos(
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
															VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$isbloqueado = isset($bloqueado)?1:0;
								$activo_en_caja = isset($activo_en_caja)?1:0;
								$ver_boleta_interna = isset($ver_boleta_interna)?1:0;
								$ver_boleta_oficial = isset($ver_boleta_oficial)?1:0;
								$isvisible = isset($visible)?1:0;
								$ispai_grupo = isset($ispai_grupo)?1:0;
								$query = "UPDATE cat_grupos SET 	
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
										WHERE idgrupo = $idgrupo";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_grupos WHERE idgrupo = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
							case 3:
								$query = "UPDATE nivel_grupos SET visible = 0 WHERE idgponiv = ".$arg;
								$vRet = $this->guardarDatos($query);
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

								$fb = explode('-',$fecha_baja);
								$fb = $fb[2].'-'.$fb[1].'-'.$fb[0];

								$activo_en_ciclo = !isset($activo_en_ciclo)?0:1;
								$valid_for_admin = !isset($valid_for_admin)?0:1;
								$status_alumno = !isset($status_alumno)?0:1;
								$is_baja = !isset($is_baja)?0:1;

								$query = "INSERT INTO cat_alumnos(
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
																is_baja,
																idalumotivobaja,
																tipo_baja,
																fecha_baja,
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
											VALUES(
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
																$is_baja,
																$idalumotivobaja,
																$tipo_baja,
																'$fb',
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$fn = explode('-',$fecha_nacimiento);
								$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];
		
								$fi = explode('-',$fecha_ingreso);
								$fi = $fi[2].'-'.$fi[1].'-'.$fi[0];

								$fb = explode('-',$fecha_baja);
								$fb = $fb[2].'-'.$fb[1].'-'.$fb[0];

								$activo_en_ciclo = !isset($activo_en_ciclo)?0:1;
								$valid_for_admin = !isset($valid_for_admin)?0:1;
								$status_alumno = !isset($status_alumno)?0:1;
								$is_baja = !isset($is_baja)?0:1;

								$query = "UPDATE cat_alumnos SET 	
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
																is_baja = $is_baja,
																idalumotivobaja = $idalumotivobaja,
																tipo_baja = $tipo_baja,
																fecha_baja = '$fb',
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
										WHERE idalumno = $idalumno";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_alumnos WHERE idalumno = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
							
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_alumnos SET 	
																beca_sep = $beca_sep,
																beca_arji = $beca_arji,
																beca_sp = $beca_sp,
																beca_bach = $beca_bach,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idalumno = $idalumno";
								$vRet = $this->guardarDatos($query);
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

								$query = "INSERT INTO cat_profesores(
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
											VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$fn = explode('-',$fecha_nacimiento);
								$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];
		
								$fi = explode('-',$fecha_ingreso);
								$fi = $fi[2].'-'.$fi[1].'-'.$fi[0];

								$query = "UPDATE cat_profesores SET 	
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
										WHERE idprofesor = $idprofesor";
								$vRet = $this->guardarDatos($query);

								break;		
							case 2:
								$query = "DELETE FROM cat_profesores WHERE idprofesor = ".$arg;
								$vRet = $this->guardarDatos($query);
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

								$query = "INSERT INTO cat_materias(
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
											VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$idioma = !isset($idioma)?1:0;
								$isoficial = !isset($isoficial)?0:1;
								$isedutec = !isset($isedutec)?0:1;
								$status_materia = !isset($status_materia)?0:1;
								$isagrupadora = !isset($isagrupadora)?0:1;
								$ispai_materia = !isset($ispai_materia)?0:1;

								$query = "UPDATE cat_materias SET 	
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
										WHERE idmateria = $idmateria";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_materias WHERE idmateria = ".$arg;
								$vRet = $this->guardarDatos($query);
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

								$query = "INSERT INTO cat_materias_clasificacion(clasificacion,
																				status_materia_clasificacion,
																				idemp,
																				ip,
																				host,
																				creado_por,
																				creado_el
																			)VALUES(
																				'$clasificacion',
																				$status_materia_clasificacion,
																				$idemp,
																				'$ip',
																				'$host',
																				$idusr,
																				NOW()
																				)";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$status_materia_clasificacion = !isset($status_materia_clasificacion)?0:1;
								$query = "UPDATE cat_materias_clasificacion SET 	
															  	clasificacion = '$clasificacion',
															  	status_materia_clasificacion = $status_materia_clasificacion,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idmatclas = $idmatclas";
								$vRet = $this->guardarDatos($query);

								break;		
							case 2:
								$query = "DELETE FROM cat_materias_clasificacion WHERE idmatclas = ".$arg;
								$vRet = $this->guardarDatos($query);

								break;		
						}
						break;

					case 9:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_parentezcos(parentezco,status_parentezco,
																	idemp,ip,host,creado_por,creado_el)
											VALUES('$parentezco',$status_parentezco,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);

								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_parentezcos SET 	
															  	parentezco = '$parentezco',
															  	status_parentezco = $status_parentezco,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idparentezco = $idparentezco";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_parentezcos WHERE idparentezco = ".$arg;
								$vRet = $this->guardarDatos($query);
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

								$query = "INSERT INTO cat_personas(
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
											VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$fn = explode('-',$fecha_nacimiento);
								$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

								$query = "UPDATE cat_personas SET 	
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
										WHERE idpersona = $idpersona";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_personas WHERE idpersona = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break;

					case 11:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "INSERT INTO cat_familias(
																	familia,
																	email,
																	status_familia,
																	idemp,ip,host,creado_por,creado_el)
											VALUES(
																	'$familia',
																	'$email',
																	$status_familia,
																	$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_familias SET 	
																	familia = '$familia',
																	email = '$email',
															  	status_familia = $status_familia,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idfamilia = $idfamilia";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_familias WHERE idfamilia = ".$arg;
								$vRet = $this->guardarDatos($query);
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
								$query = "INSERT INTO familia_personas(
																	idpersona,
																	idfamilia,
																	idparentezco,
																	is_email,
																	status_famper,
																	idemp,ip,host,creado_por,creado_el)
											VALUES(
																	$idpersona,
																	$idfamilia,
																	$idparentezco,
																	$is_email,
																	$status_famper,
																	$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$is_email = !isset($is_email)?0:1;	
								$status_famper = !isset($status_famper)?0:1;	

								$query = "UPDATE familia_personas SET 	
																idpersona = $idpersona,
																idfamilia = $idfamilia,
																idparentezco = $idparentezco,
																is_email = $is_email,
															  	status_famper = $status_famper,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idfamper = $idfamper";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM familia_personas WHERE idfamper = ".$arg;
								$vRet = $this->guardarDatos($query);
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
								$query = "INSERT INTO familia_alumnos(
																	idalumno,
																	idfamilia,
																	idtutor,
																	is_minor,
																	vive_con,
																	status_famalu,
																	idemp,ip,host,creado_por,creado_el)
											VALUES(
																	$idalumno,
																	$idfamilia,
																	$idtutor,
																	$is_minor,
																	$vive_con,
																	$status_famalu,
																	$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$is_minor = !isset($is_minor)?0:1;	
								$status_famalu = !isset($status_famalu)?0:1;	

								$query = "UPDATE familia_alumnos SET 	
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
										WHERE idfamalu = $idfamalu";
								$vRet = $this->guardarDatos($query);

								break;		
							case 2:
								$query = "DELETE FROM familia_alumnos WHERE idfamalu = ".$arg;
								$vRet = $this->guardarDatos($query);
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
								$query = "INSERT INTO cat_registros_fiscales(
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
											VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$is_email = !isset($is_email)?0:1;	
								$is_extranjero = !isset($is_extranjero)?0:1;	
								$status_regfis = !isset($status_regfis)?0:1;	
								$idfammig = intval($idfammig);	

								$query = "UPDATE cat_registros_fiscales SET 	
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
										WHERE idregfis = $idregfis";
								$vRet = $this->guardarDatos($query);

								break;		
							case 2:
								$query = "DELETE FROM cat_registros_fiscales WHERE idregfis = ".$arg;
								$vRet = $this->guardarDatos($query);
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
								$query = "INSERT INTO familia_reg_fis(
																	idfamilia,
																	idregfis,
																	predeterminado,
																	status_famregfis,
																	idemp,ip,host,creado_por,creado_el)
											VALUES(
																	$idfamilia,
																	$idregfis,
																	$predeterminado,
																	$status_famregfis,
																	$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$status_famregfis = !isset($status_famregfis)?0:1;	
								$predeterminado = !isset($predeterminado)?0:1;	
								$query = "UPDATE familia_reg_fis SET 	
																idfamilia = $idfamilia,
																idregfis = $idregfis,
																predeterminado = $predeterminado,
															  	status_famregfis = $status_famregfis,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idfamregfis = $idfamregfis";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM familia_reg_fis WHERE idfamregfis = ".$arg;
								$vRet = $this->guardarDatos($query);
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

								$query = "INSERT INTO grupo_materias(
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
											VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$status_grumat = !isset($status_grumat)?0:1;	
								$idemp = $this->getIdEmpFromAlias($user);
								$isoficial = !isset($isoficial)?0:1;	
								$orden_impresion = intval($orden_impresion); 
								$orden_historial = intval($orden_historial); 
								$bloqueado = !isset($bloqueado)?0:1;	
								$ispai_materia = !isset($ispai_materia)?0:1;

								$query = "UPDATE grupo_materias SET 	
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
										WHERE idgrumat = $idgrumat";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM grupo_materias WHERE idgrumat = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;	

							case 3:
								parse_str($cadena2);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								parse_str($arg);
			          			$ar = explode(".",$arg);
			          			$item = explode("|",$ar[0]);
								foreach($item AS $i=>$valor){
									if ( intval($item[$i]) > 0 ){

										$query = "UPDATE grupo_materias SET 	
																		padre = ".$ar[1].",
																		ip = '$ip', 
																		host = '$host',
																		modi_por = $idusr, 
																		modi_el = NOW()
												WHERE idgrumat = ".$item[$i];
										$vRet = $this->guardarDatos($query);
									}
								}
								break;

							case 4:
								parse_str($cadena2);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								parse_str($arg);

			          			$item = explode("|",$arg);
								foreach($item AS $i=>$valor){
									if ( intval($item[$i]) > 0 ){

										$query = "UPDATE grupo_materias SET 	
																		padre = 0,
																		ip = '$ip', 
																		host = '$host',
																		modi_por = $idusr, 
																		modi_el = NOW()
												WHERE idgrumat = ".$item[$i];
										$vRet = $this->guardarDatos($query);
									}
								}
								break;		

						}
						break;

					case 17:
						switch($tipo){
							case 4:
								$query = "DELETE FROM boletas WHERE idboleta IN ($arg)";
								$vRet = $this->guardarDatos($query);
								break;		
							case 5:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "INSERT INTO boletas(
																	idgrumat,
																	idgrualu,
																	idemp,ip,host,creado_por,creado_el)
											VALUES(
																	$idgrumat,
																	$idgrualu,
																	$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
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
									$query = "INSERT INTO grupo_materia_config(
																		idgrumat,
																		num_eval,
																		descripcion,
																		porcentaje,
																		idalutipoactividad,
																		idemp,ip,host,creado_por,creado_el)
												VALUES(
																		$idgrumat,
																		$num_eval_matcon,
																		'$descripcion',
																		$porcentaje,
																		$idalutipoactividad,
																		$idemp,'$ip','$host',$idusr,NOW())";
									$vRet = $this->guardarDatos($query);
								}else{
									$vRet = "Error: No se permite un Núnmero de Evaluación <= 0"; 
								}
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								if (intval($num_eval_matcon)>0){
									$query = "UPDATE grupo_materia_config SET 	
																	idgrumat = $idgrumat,
																	num_eval = $num_eval_matcon,
																  	descripcion = '$descripcion',
																	porcentaje = $porcentaje,
																	idalutipoactividad = $idalutipoactividad,
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											WHERE idgrumatcon = $idgrumatcon";
									$vRet = $this->guardarDatos($query);
								}else{
									$vRet = "Error: No se permite un Núnmero de Evaluación <= 0"; 
								}
								break;		
							case 2:
								$query = "DELETE FROM grupo_materia_config WHERE idgrumatcon = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break;

					case 19:
						switch($tipo){
							case 1:
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
									$query = "UPDATE boletas SET 	
																	".$con." = ".$arrBolConCal[$i].",
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											WHERE idboleta = ".$arrBolCon[$i];
											$vRet = $this->guardarDatos($query);

									}					
									
								for ($i=0; $i < count($arrBolIna); $i++) {
									$ina = "ina".$num_eval;		 
									$query = "UPDATE boletas SET 	
																	".$ina." = ".$arrBolInaCal[$i].",
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											WHERE idboleta = ".$arrBolIna[$i];
											$vRet = $this->guardarDatos($query);

									}					

								for ($i=0; $i < count($arrBolObs); $i++) {
									$obs = "obs".$num_eval;		 
									$query = "UPDATE boletas SET 	
																	".$obs." = ".$arrBolObsCal[$i].",
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											WHERE idboleta = ".$arrBolObs[$i];

											$vRet = $this->guardarDatos($query);

									}			
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

								$query = "INSERT INTO cat_observaciones(
																	observacion,
																	idioma,
																	status_observacion,
																	idemp,ip,host,creado_por,creado_el)
											VALUES(
												'$observacion',
												$idioma,
												$status_observacion,
												$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;

							case 1:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idioma = !isset($idioma)?1:0;
								$query = "UPDATE cat_observaciones SET 	
															  	observacion = '$observacion',
															  	idioma = $idioma,
															  	status_observacion = $status_observacion,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idobservacion = $idobservacion";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_observaciones WHERE idobservacion = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break;

					case 21:		
						switch($tipo){
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "UPDATE config SET valor = $evalpred,
															modi_por = $idusr, 
															modi_el = NOW()
										WHERE llave = '$hevalpred' AND idemp = $idemp ";
								$vRet = $this->guardarDatos($query);

								$query = "UPDATE config SET valor = $evalmod,
															modi_por = $idusr, 
															modi_el = NOW()
										WHERE llave = '$hevalmod' AND idemp = $idemp ";
								$vRet = $this->guardarDatos($query);

								$query = "UPDATE config SET valor = $epai,
															modi_por = $idusr, 
															modi_el = NOW()
										WHERE llave = '$hepai' AND idemp = $idemp ";
								$vRet = $this->guardarDatos($query);

								$arrParam = explode(',',$param1);

								if ( count($arrParam) > 1){
									for( $i=0; $i<count($arrParam); ++$i ){
										$query = "SET @X = Fijar_Predeterminada_y_Modificable_Eval(".$arrParam[$i].",".$idciclo.",".$idemp.",".$idusr.",'".$ip."','".$host."',".$evalpred.",".$evalmod.")";
										$vRet = $this->execQuery($query);
									}
								}else{
									$query = "SET @X = Fijar_Predeterminada_y_Modificable_Eval(".$param1.",".$idciclo.",".$idemp.",".$idusr.",'".$ip."','".$host."',".$evalpred.",".$evalmod.")";
									$vRet = $this->execQuery($query);
								}
								break;		
						}
						break;

					case 22:
						switch($tipo){

							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$arrGruAlu = explode('|', $idgrualu);
								$arrGruAluVal = explode('|', $idgrualuval);

								for ($i=0; $i < count($arrGruAlu); $i++) { 
									$query = "UPDATE grupo_alumnos SET 	
																	num_lista = ".$arrGruAluVal[$i].",
																	ip = '$ip', 
																	host = '$host',
																	modi_por = $idusr, 
																	modi_el = NOW()
											WHERE idgrualu = ".$arrGruAlu[$i];
											$vRet = $this->guardarDatos($query);

								}					
						}
						break;

					case 23:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_directores(idnivel,idprofesor,status_director,
																	idemp,ip,host,creado_por,creado_el)
											VALUES($idnivel,$idprofesor,$status_director,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_directores SET 	
															  	idnivel = $idnivel,
															  	idprofesor = $idprofesor,
															  	status_director = $status_director,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE iddirector = $iddirector";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_directores WHERE iddirector = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break;

					case 25:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_conceptos(concepto,status_concepto,
																	idemp,ip,host,creado_por,creado_el)
											VALUES('$concepto',$status_concepto,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_conceptos SET 	
															  	concepto = '$concepto',
															  	status_concepto = $status_concepto,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idconcepto = $idconcepto";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_conceptos WHERE idconcepto = ".$arg;
								$vRet = $this->guardarDatos($query);
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
								
								$query = "INSERT INTO cat_emisores_fiscales(
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
											VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$status_emisor_fiscal = !isset($status_emisor_fiscal)?0:1;
								$is_iva = !isset($is_iva)?0:1;

								$query = "UPDATE cat_emisores_fiscales SET 	
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
										WHERE idemisorfiscal = $idemisorfiscal";
								$vRet = $this->guardarDatos($query);

								break;		
							case 2:
								$query = "DELETE FROM cat_emisores_fiscales WHERE idemisorfiscal = ".$arg;
								$vRet = $this->guardarDatos($query);
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
								
								$query = "INSERT INTO cat_pagos(
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
																	idclaveprodservsat,
																	idclaveunidadmedida,
																	status_pago,
																	idemp,ip,host,creado_por,creado_el)
											VALUES(

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
																	$idclaveprodservsat,
																	$idclaveunidadmedida,
																	$status_pago,
																	$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
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

								$query = "UPDATE cat_pagos SET 	
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
																idclaveprodservsat = $idclaveprodservsat,
																idclaveunidadmedida = $idclaveunidadmedida,
															  	status_pago = $status_pago,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idpago = $idpago";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_pagos WHERE idpago = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break;

					case 28:
						switch($tipo){

							case 2:
								parse_str($arg);
								$query = "DELETE FROM facturas_encabezado WHERE idfactura = $idfactura AND isfe = 0";
								$vRet = $this->guardarDatos($query);
								break;		
							case 5:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$idcicloant = $this->getCicloAntFromIdEmp($idemp);
								$omitir_descto_beca = !isset($omitir_descto_beca)?0:1;

								$query = "UPDATE estados_de_cuenta SET 	
																porcdescto = $porcentaje,
																omitir_descto_beca = $omitir_descto_beca,
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idedocta = $idedocta";
								$vRet = $this->guardarDatos($query);
								break;		
							case 6:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$basadoen = intval($basadoen);
								if ($basadoen != 0){
									$recargo = ($basadoen * 100) / $subtotal;
								}

								$query = "UPDATE estados_de_cuenta SET 	
																porcrecargo = $recargo,
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idedocta = $idedocta";
								$vRet = $this->guardarDatos($query);
								break;		

							case 7:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$arrPago = explode('-',$idconcepto);
								$query = "SET @X = Generar_Estado_de_Cuenta_por_Concepto(".$arrPago[0].",".$idciclo.",".$idfamilia.",".$idalumno.",".$clave_nivel.",".$beca_sep.",".$beca_arji.",".$beca_sp.",".$beca_bach.",".$idusr.",".$idemp.",'".$ip."','".$host."',".$num_pagos.",".$descuento.",".$recargo.")";
								$vRet = $this->execQuery($query);

								break;		

							case 8:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$idciclo = $this->getCicloFromIdEmp($idemp);

								$query = "SET @X = Quitar_Concepto_de_Pago_de_Alumno(".$idfamilia.",".$idalumno.",".$idedocta.",".$idpago.",".$idusr.",".$idciclo.")";
								$vRet = $this->execQuery($query);

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
							    $query = "INSERT INTO facturas_encabezado(idcliente,idmetododepago,referencia,fecha,subtotal,descto_becas,importe,descto,recargo,total,idemp,ip,host,creado_por,creado_el)
							    					VALUES(".$IdFs[0].",$idmetododepago,'$referencia',NOW(),$subtotal,$descto_becas,$importe,$descto,$recargo,$total,$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
							    $query = "SELECT MAX(idfactura) AS IDs FROM facturas_encabezado";
							    $result = $this->getArray($query);
							    $rFac = !$result ? 0 : intval($result[0]->IDs);

								for ($i=0; $i < count($IdFs); $i++) { 
									
									$dBecas = !isset($aDesctoBecas[$i]) ? 0 : $aDesctoBecas[$i]; 
							    	$query = "SELECT * FROM estados_de_cuenta WHERE idedocta = ".$IDs[$i];
								    $fD = $this->getArray($query);

									$precio_venta = $fD[0]->subtotal;
									$subtotal  	  = $fD[0]->subtotal;
									$descto_becas = $fD[0]->descto_becas;
									$importe  	  = $fD[0]->importe;
									$descto  	  = $fD[0]->descto;
									$recargo  	  = $fD[0]->recargo;
									$total  	  = $fD[0]->total;

									$qry = "INSERT INTO facturas_detalle(
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
													$idemp,'$ip','$host',$idusr,NOW())";

									$vRet = $this->guardarDatos($qry);

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
									$vRet = $this->guardarDatos($query);
								}					
								break;		
							case 10:
								parse_str($arg);
								$iduser = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$idcicloant = $this->getCicloAntFromIdEmp($idemp);
								$query = "SET @X = Generar_Estado_de_Cuenta_por_Familia(".$idfamilia.",".$idciclo.",".$idemp.",".$iduser.",'".$ip."','".$host."',".$idcicloant.")";
								$vRet = $this->execQuery($query);
								break;		
							case 11:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
							    $facEnc = "INSERT INTO facturas_encabezado(idcliente,idemisorfiscal,idregfis,forma_de_pago,metodo_de_pago,referencia,fecha,subtotal,descto_becas,importe,descto,recargo,importe2,iva,total,padre,tipo_documento,idemp,ip,host,creado_por,creado_el)
							    					VALUES($idcliente,$idemisorfiscal,$idregfis,0,$idmetododepago,'$referencia',NOW(),$subtotal,$descto_becas,$importe,$descto,$recargo,$importe2,$iva,$total,$padre,1,$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($facEnc);
							    $query = "SELECT MAX(idfactura) AS IDs FROM facturas_encabezado";
							    $result = $this->getArray($query);
							    $rFac = !$result ? 0 : intval($result[0]->IDs);

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

										$qry = "INSERT INTO facturas_detalle(
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
														$idemp,'$ip','$host',$idusr,NOW())";
												
										$vRet = $this->guardarDatos($qry);
									}else{
										break;
									}
								}					
								break; // 11;
							case 12:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
							    $query = "UPDATE facturas_encabezado 
							    	SET idcliente = $idcliente,
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
							    	WHERE idfactura = $idfactura";
								$vRet = $this->guardarDatos($query);

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

										$query = "UPDATE facturas_detalle
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
											    	WHERE idfacdet = ".$$idfacdet0;

										$vRet = $this->guardarDatos($query);
									}else{
										break;
									}
								}					
								break; 
							case 13: 

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$idciclo = $this->getCicloFromIdEmp($idemp);
								$ief = explode('-',$idemisorfiscal);
							    $query = "INSERT INTO facturas_encabezado(idcliente,idemisorfiscal,idregfis,forma_de_pago,metodo_de_pago,referencia,fecha,subtotal,descto_becas,importe,descto,recargo,importe2,iva,total,padre,tipo_documento,idemp,ip,host,creado_por,creado_el)
							    					VALUES($idcliente,$ief[0],$idregfis,0,$idmetododepago,'$referencia',NOW(),$subtotal,$descto_becas,$importe,$descto,$recargo,$importe2,$iva,$total,$padre,2,$idemp,'$ip','$host',$idusr,NOW())";								
								$vRet = $this->guardarDatos($query);
							    $query = "SELECT MAX(idfactura) AS IDs FROM facturas_encabezado";
							    $result = $this->getArray($query);
							    $rFac = !$result ? 0 : intval($result[0]->IDs);

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

										$query = "INSERT INTO facturas_detalle(
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
														$idemp,'$ip','$host',$idusr,NOW())";
												
										$vRet = $this->guardarDatos($query);									
									}
								}					
								break; // 13;
							case 14: // Factura Manual
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);								
								$ief = explode('-',$idemisorfiscal);

							    $query = "UPDATE facturas_encabezado 
							    	SET idcliente = $idcliente,
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
							    	WHERE idfactura = $idfactura";
								$vRet = $this->guardarDatos($query);

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

										$query = "UPDATE facturas_detalle
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
											    	WHERE idfacdet = ".$$idfacdet0;
										$vRet = $this->guardarDatos($query);									
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
								$query = "INSERT INTO cat_metodos_de_pago(metodo_de_pago,metodo_de_pago_predeterminado,status_metodo_de_pago,
																	idemp,ip,host,creado_por,creado_el)
											VALUES('$metodo_de_pago',0,$status_metodo_de_pago,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_metodos_de_pago SET 	
															  	metodo_de_pago = '$metodo_de_pago',
															  	metodo_de_pago_predeterminado = $,metodo_de_pago_predeterminado
															  	status_metodo_de_pago = $status_metodo_de_pago,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idmetododepago = $idmetododepago";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_metodos_de_pago WHERE idmetododepago = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($u);
								$idemp = $this->getIdEmpFromAlias($u);
								$query = "UPDATE cat_metodos_de_pago SET metodo_de_pago_predeterminado = 0
										  WHERE idemp = $idemp";
								$vRet = $this->guardarDatos($query);

								$query = "UPDATE cat_metodos_de_pago SET 	
															  	metodo_de_pago_predeterminado = 1,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idmetododepago = $idmetododepago";
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break; // 29
					case 30:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_colores(color,codigo_color_hex,status_color,
																	idemp,ip,host,creado_por,creado_el)
											VALUES('$color','$codigo_color_hex',$status_color,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_colores SET 	
															  	color = '$color',
															  	codigo_color_hex = '$codigo_color_hex',
															  	status_color = $status_color,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idcolor = $idcolor";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_colores WHERE idcolor = ".$arg;
								$vRet = $this->guardarDatos($query);
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

								$query = "INSERT INTO cat_productos(idproveedor,producto,idmedida,idcolor,costo_unitario,iscolor,status_producto,
																	idemp,ip,host,creado_por,creado_el)
											VALUES($idproveedor,'$producto',$idmedida,$idcolor,$costo_unitario,$iscolor,$status_producto,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$iscolor = !isset($iscolor)?0:1;	
								$status_producto = !isset($status_producto)?0:1;

								$query = "UPDATE cat_productos SET 	
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
										WHERE idproducto = $idproducto";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_productos WHERE idproducto = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break; // 31

					case 32:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_medidas(medida1,medida2,clave,status_medida,
																	idemp,ip,host,creado_por,creado_el)
											VALUES('$medida1','$medida2','$clave',$status_medida,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_medidas SET 	
															  	medida1 = '$medida1',
															  	medida2 = '$medida2',
															  	clave = '$clave',
															  	status_medida = $status_medida,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idmedida = $idmedida";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_medidas WHERE idmedida = ".$arg;
								$vRet = $this->guardarDatos($query);
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
								$query = "INSERT INTO cat_proveedores(
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
											VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$status_proveedor = !isset($status_proveedor)?0:1;	

								$query = "UPDATE cat_proveedores SET 	
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
										WHERE idproveedor = $idproveedor";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_proveedores WHERE idproveedor = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break; // 33
					case 34:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO solicitudes_de_material(idsolicita,status_solicitud_de_material,
																	idemp,ip,host,creado_por,creado_el)
											VALUES($idsolicita,$status_solicitud_de_material,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE solicitudes_de_material SET 	
															  	idsolicita = $idsolicita,
															  	status_solicitud_de_material = $status_solicitud_de_material,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsolicituddematerial = $idsolicituddematerial";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM solicitudes_de_material WHERE idsolicituddematerial = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break; // 34
					case 35:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_supervisores_caja(idusersupervisor,status_supervisor_caja,
																	idemp,ip,host,creado_por,creado_el)
											VALUES($idusersupervisor,$status_supervisor_caja,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_supervisores_caja SET 	
															  	idusersupervisor = $idusersupervisor,
															  	status_supervisor_caja = $status_supervisor_caja,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsupervisorcaja = $idsupervisorcaja";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_supervisores_caja WHERE idsupervisorcaja = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break; // 35


					case 36:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_supervisores_sol_mat(idusersupervisorsolmat,status_supervisor_sol_mat,
																	idemp,ip,host,creado_por,creado_el)
											VALUES($idusersupervisorsolmat,$status_supervisor_sol_mat,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_supervisores_sol_mat SET 	
															  	idusersupervisorsolmat = $idusersupervisorsolmat,
															  	status_supervisor_sol_mat = $status_supervisor_sol_mat,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsupervisorsolmat = $idsupervisorsolmat";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_supervisores_sol_mat WHERE idsupervisorsolmat = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break; // 36
					case 37:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_supervisores_entrega(idusersupervisorentrega,status_supervisor_entrega,
																	idemp,ip,host,creado_por,creado_el)
											VALUES($idusersupervisorentrega,$status_supervisor_entrega,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_supervisores_entrega SET 	
															  	idusersupervisorentrega = $idusersupervisorentrega,
															  	status_supervisor_entrega = $status_supervisor_entrega,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsupervisorentrega = $idsupervisorentrega";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_supervisores_entrega WHERE idsupervisorentrega = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break; // 37
					case 38:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO solicitudes_de_material(
														idsolicita,
														observaciones,
														fecha_solicitud,
														idemp,ip,host,creado_por,creado_el)
												VALUES($idusr,
														'$observaciones',
														NOW(),
														$idemp,
														'$ip',
														'$host',
														$idusr,
														NOW()
												)";								
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE solicitudes_de_material SET 	
																observaciones = '$observaciones',
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsolicituddematerial = $idsolicituddematerial";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM solicitudes_de_material WHERE idsolicituddematerial = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE solicitudes_de_material SET 	
															  	status_solicitud_de_material = $val,
															  	fecha_autorizacion = NOW(),
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsolicituddematerial = $id";
								$vRet = $this->guardarDatos($query);
								break;		
							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE solicitudes_de_material SET 	
															  	status_solicitud_de_material = $val,
															  	fecha_entrega = NOW(),
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsolicituddematerial = $id";
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break; // 38
					case 39:
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "INSERT INTO solicitudes_de_material_detalles(
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
											VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE solicitudes_de_material_detalles SET 	
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
										WHERE idsolicituddematerialdetalle = $idsolicituddematerialdetalle";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM solicitudes_de_material_detalles WHERE idsolicituddematerialdetalle = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE solicitudes_de_material_detalles SET 	
															  	status_solicitud_de_materiales = $val,
															  	fecha_autorizacion = NOW(),
															  	idautoriza = $idusr,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsolicituddematerialdetalle = $id";
								$vRet = $this->guardarDatos($query);
								break;		
							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE solicitudes_de_material_detalles SET 	
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
										WHERE idsolicituddematerialdetalle = $idsolicituddematerialdetalle";
								$vRet = $this->guardarDatos($query);
								break;	
							case 5:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE solicitudes_de_material_detalles SET 	
															  	status_solicitud_de_materiales = $val,
															  	fecha_entrega = NOW(),
															  	identrega = $idusr,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsolicituddematerialdetalle = $id";
								$vRet = $this->guardarDatos($query);
								break;	

							case 6:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE solicitudes_de_material_detalles SET 	
																cantidad_entregado = $cantidad_entregado,
																importe_entregado = $cantidad_entregado*costo_unitario,
																observaciones_entrega = '$observaciones_entrega',
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idsolicituddematerialdetalle = $idsolicituddematerialdetalle";
								$vRet = $this->guardarDatos($query);
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

								$query = "INSERT INTO tareas(
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
														)VALUES( 
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
								$vRet = $this->guardarDatos($query);
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

								$query = "UPDATE tareas SET titulo_tarea = '$titulo',
															tarea = '$tarea',
															fecha_inicio = '".$fecha_inicio."',
															fecha_fin = '".$fecha_fin."',
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											WHERE idtarea = ".$idtarea;
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM tareas WHERE idtarea = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$bols  = explode('|',$bols);
								$dests = explode('|',$dests);
								foreach ($bols AS $i => $VALUE) {
									if ( intval($bols[$i]) > 0 && intval($dests[$i]) > 0 ){
										$query = "INSERT INTO tareas_dest(
																	idtarea,
																	idboleta,
																	idremitente,
																	iddestinatario,
																	idemp,
																	ip,
																	host,
																	creado_por,
																	creado_el
																)VALUES( 
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
										$vRet = $this->guardarDatos($query);
									}
								}
								break;
							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$dests = explode('|',$dests);
								foreach ($dests AS $i => $VALUE) {
									$query = "DELETE FROM tareas_dest WHERE idtareadestinatario = ".$dests[$i];
									$vRet = $this->guardarDatos($query);
								}
								break;

							case 5:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "DELETE FROM tareas_dest WHERE idtareadestinatario = ".$idtareadestinatario;
								$vRet = $this->guardarDatos($query);
								break;

							case 6:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "INSERT INTO tareas_dest_respuestas(
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
														)VALUES( 
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
								$vRet = $this->guardarDatos($query);
								break;

							case 7:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "UPDATE tareas_dest_respuestas 
														SET 
															idtareadestinatario = $idtareadestinatario,	
															respuesta = '$respuesta',
															fecha_respuesta = NOW(),
															idparent = $idusr,
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											WHERE idtareadestinatariorespuesta = ".$idtareadestinatariorespuesta;
								$vRet = $this->guardarDatos($query);
								break;		
							case 8:
								$query = "DELETE FROM tareas_dest_respuestas WHERE idtareadestinatariorespuesta = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
							case 9:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "UPDATE tareas_dest 
														SET 
															isleida = 1,	
															fecha_leida = NOW(),
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											WHERE idtareadestinatario = ".$idtareadestinatario;
								$vRet = $this->guardarDatos($query);
								break;		
							case 10:
								$query = "SET @X = Actualizar_Archivos_y_Destinatarios_en_Tareas(".$arg.")";
								$vRet = $this->execQuery($query);
								break;		
						}
						break; // 40
					case 41: // 41
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "INSERT INTO com_grupos(
															iduserpropietario,
															grupo,
															status_com_grupo,
															idemp,
															ip,
															host,
															creado_por,
															creado_el
														)VALUES( 
															$idusr,
															'$grupo',
															$status_com_grupo,
														    $idemp,
												    		'$ip',
												    		'$host',
												    		$idusr,
												    		NOW()
												    		)";
								$vRet = $this->guardarDatos($query);
								break;
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$query = "UPDATE com_grupos SET 
															grupo = '$grupo',
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											WHERE idcomgrupo = ".$idcomgrupo;
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM com_grupos WHERE idcomgrupo = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
							case 3:
								$query = "DELETE FROM com_usuarios_asoc_grupos WHERE idcomuserasocgpo = ".$arg;
								$vRet = $this->guardarDatos($query);
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
								
								if ( isset($hora0) ){
									$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0].' '.$hora0.':'.$min0.':'.$seg0;
								}else{
									$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0];
								}
								$query = "INSERT INTO com_mensajes(
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
														)VALUES( 
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
								$vRet = $this->guardarDatos($query);
								break;
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$f0 = explode('-',$fecha);
								$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0].' '.$hora0.':'.$min0.':'.$seg0;

								$query = "UPDATE com_mensajes 
														SET titulo_mensaje = '$titulo',
															mensaje = '$mensaje',
															fecha = '".$fecha."',
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											WHERE idcommensaje = ".$idcommensaje;
								$vRet = $this->guardarDatos($query);
								break;		

							case 2:
								$query = "DELETE FROM com_mensajes WHERE idcommensaje = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		

							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$dests = explode('|',$dests);
								foreach ($dests AS $i => $VALUE) {
									if ( intval($dests[$i]) > 0 ){
										$query = "INSERT INTO com_mensaje_dest(
																	idcomgrupo,
																	idcommensaje,
																	idremitente,
																	iddestinatario,
																	idemp,
																	ip,
																	host,
																	creado_por,
																	creado_el
																)VALUES( 
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
										$vRet = $this->guardarDatos($query);
									}
								}
								break;

							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$dests = explode('|',$dests);
								foreach ($dests AS $i => $VALUE) {
									$query = "DELETE FROM com_mensaje_dest WHERE idcommensajedestinatario = ".$dests[$i];
									$vRet = $this->guardarDatos($query);
								}
								break;
							case 5:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "DELETE FROM com_mensaje_dest WHERE idcommensajedestinatario = ".$idcommensajedestinatario;
								$vRet = $this->guardarDatos($query);
								break;
							case 6:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "INSERT INTO com_mensaje_dest_respuestas(
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
														)VALUES( 
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
								$vRet = $this->guardarDatos($query);
								break;
							case 7:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "UPDATE com_mensaje_dest_respuestas 
														SET 
															idcommensajedestinatario = $idcommensajedestinatario,	
															respuesta = '$respuesta',
															fecha_respuesta = NOW(),
															idparent = $idusr,
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											WHERE idcommensajedestinatariorespuesta = ".$idcommensajedestinatariorespuesta;
								$vRet = $this->guardarDatos($query);
								break;		
							case 8:
								$query = "DELETE FROM com_mensaje_dest_respuestas WHERE idcommensajedestinatariorespuesta = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
							case 9:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);

								$query = "UPDATE com_mensaje_dest 
														SET 
															isleida = 1,	
															fecha_leida = NOW(),
															ip = '$ip',
															host = '$host',
															modi_por = $idusr,
															modi_el = NOW()
											WHERE idcommensajedestinatario = ".$idcommensajedestinatario;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break; // 42
					case 43:  // 43
						switch($tipo){
							case 0:
							case 1:
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

								    $query = "SELECT idalumno FROM cat_alu_refer_oficiales WHERE idalumno = ".$alumnos[$i]." AND idnivel = $idnivel AND idemp = $idemp";
								    $result = $this->getArray($query);
								    $rrd = !$result ? 0 : floatval($result[0]->idalumno);

									if ($rrd<=0) {
						    				

											$query = "INSERT INTO cat_alu_refer_oficiales(
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
											)VALUES(
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
											$vRet = $this->guardarDatos($query);
									}else{
											$query = "UPDATE cat_alu_refer_oficiales SET 
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
														WHERE idalumno = ".$alumnos[$i]." AND idnivel = $idnivel AND idemp = $idemp";
											$vRet = $this->guardarDatos($query);					    				
									}
								} // 1
								break;
							case 2:

								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$query = "UPDATE cat_alu_refer_oficiales 
											SET ispromovido = $ispromovido,
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
											WHERE idalumno = $idalumno AND idnivel = $idnivel AND idemp = $idemp";
								$vRet = $this->guardarDatos($query);
								break; // 2
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$f0 = explode('-',$fecha);
								$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0];
							    $query = "SELECT clave_nivel FROM pos_lectura_sep WHERE clave_nivel = $idnivel AND grado = $grado AND idemp = $idemp";
							    $result = $this->getArray($query);
							    $rrd = !$result ? 0 : floatval($result[0]->clave_nivel);

								if ($rrd<=0) {
					    				

										$query = "INSERT INTO pos_lectura_sep(
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
										)VALUES(
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
										$vRet = $this->guardarDatos($query);
								}else{
										$query = "UPDATE pos_lectura_sep SET 
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
													WHERE clave_nivel = $idnivel AND grado = $grado AND idemp = $idemp";
										$vRet = $this->guardarDatos($query);					    				
								}
								break;								
							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);

								$f0 = explode('-',$fecha);
								$fecha = $f0[2].'-'.$f0[1].'-'.$f0[0];

								$query = "UPDATE pos_lectura_sep SET 
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
											WHERE clave_nivel = $idnivel AND grado = $grado AND idemp = $idemp";
								$vRet = $this->guardarDatos($query);
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

								$query = "UPDATE cat_alu_refer_oficiales 
											SET 
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
											WHERE idalumno = $idalumno AND idnivel = $idnivel AND idemp = $idemp";
								$vRet = $this->guardarDatos($query);
								break; // 2
						}
						break; // 43
					case 44:  // 44
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO cat_alu_tipo_actividad(tipo_actividad,status_tipo_actividad,idemp,ip,host,creado_por,creado_el)
											VALUES( '$tipo_actividad',
												    $status_tipo_actividad,$idemp,'$ip','$host',$idusr,NOW())";
								// $result = mysql_query($query); 
								// $vRet = $result!=1? mysql_error():"OK";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE cat_alu_tipo_actividad SET tipo_actividad = '$tipo_actividad',
															  	status_tipo_actividad = $status_tipo_actividad,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idalutipoactividad = $idalutipoactividad";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_alu_tipo_actividad WHERE idalutipoactividad = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;		
						}
						break;  // 44

					case 45:  // 45
						switch($tipo){
							case 0:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$query = "INSERT INTO grupo_materia_config_markbook(
																					descripcion_breve,
																					descripcion_avanzada,
																					idgrumatcon,
																					status_grumatconmkb,idemp,ip,host,creado_por,creado_el)
											VALUES( 
													'$descripcion_breve',
													'$descripcion_avanzada',
													$idgrumatcon,
												    $status_grumatconmkb,$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$query = "UPDATE grupo_materia_config_markbook 
															SET descripcion_breve = '$descripcion_breve',
																descripcion_avanzada = '$descripcion_avanzada',
															  	status_grumatconmkb = $status_grumatconmkb,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idgrumatconmkb = $idgrumatconmkb";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM grupo_materia_config_markbook WHERE idgrumatconmkb = ".$arg;
								$vRet = $this->guardarDatos($query);
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

								$query = "INSERT INTO cat_medicos(
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
											VALUES(
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
								$vRet = $this->guardarDatos($query);
								break;		
							case 1:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$status_medico = !isset($status_medico)?0:1;	

								$query = "UPDATE cat_medicos SET 	
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
										WHERE idmedico = $idmedico";
								$vRet = $this->guardarDatos($query);
								break;		
							case 2:
								$query = "DELETE FROM cat_medicos WHERE idmedico = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;
							case 3:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$idemp = $this->getIdEmpFromAlias($user);
								$predeterminado = !isset($predeterminado)?0:1;	
								$query = "INSERT INTO medicos_alumno(
																idmedico,
																idalumno,
																predeterminado,
																idemp,ip,host,creado_por,creado_el)
															VALUES(
																$idmedico,
																$idalumno,
																$predeterminado,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);
								break;		
							case 4:
								parse_str($arg);
								$idusr = $this->getIdUserFromAlias($user);
								$predeterminado = !isset($predeterminado)?0:1;	

								$query = "UPDATE medicos_alumno SET 	
																idmedico = $idmedico,
																idalumno = $idalumno,
																predeterminado = $predeterminado,
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE idmedalu = $idmedalu";
								$vRet = $this->guardarDatos($query);
								break;		
							case 5:
								$query = "DELETE FROM medicos_alumno WHERE idmedalu = ".$arg;
								$vRet = $this->guardarDatos($query);
								break;										
						}
						break; // 48
		  		}
		  return  $vRet;
	}

	public function getQuerys($tipo=0,$cad="",$type=0,$from=0,$cant=0,$ar=array(),$otros="",$withPag=1) {
		  	$arr = array('voEmpty');
		  	$ret = array();
			$index = 0;		
		  
        	switch ($tipo){
			case -5:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
							FROM empresa
							WHERE idemp = $idemp ";
				break;
			case -4:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT llave,valor
							FROM config
							WHERE idemp = $idemp AND llave = '$llave' ";
				break;
			case -3:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT llave,valor
								FROM config
							WHERE idemp = $idemp";
				break;
			case -2:
				$query = "SELECT *
								FROM _viUsuarios
							WHERE iduser = $cad  AND status_usuario = 1  AND idusernivelacceso <= 100";
				break;
			case -1:
				parse_str($cad);
				$iduser = $this->getIdUserFromAlias($u);
		        $idemp = $this->getIdEmpFromAlias($u);
				
				$query = "SELECT iduser, username, apellidos, nombres, foto
							FROM _viUsuarios 
							WHERE  idemp = $idemp AND status_usuario = 1  AND idusernivelacceso <= 100 
							ORDER BY iduser DESC";
				break;
			case 0:
					$query="SELECT *
							FROM _viUsuarios 
							WHERE username LIKE ('$cad%')  AND status_usuario = 1  AND idusernivelacceso <= 1000 ";	
					break;	   
			case 1:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_estados
							WHERE idemp = $idemp ORDER BY idestado DESC";
				break;
			case 2:
				$query = "SELECT  *
								FROM cat_estados 
							WHERE idestado = $cad ";
				break;
			case 3:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viMunicipios
							WHERE idemp = $idemp AND status_municipio = 1 ORDER BY idmunicipio DESC";
				break;
			case 4:
				$query = "SELECT  *
								FROM _viMunicipios
							WHERE idmunicipio = $cad ";
				break;
			case 5:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_niveles
							WHERE idemp = $idemp ORDER BY idnivel DESC";
				break;
			case 6:
				$query = "SELECT *
								FROM cat_niveles
							WHERE idnivel = $cad ";
				break;

			case 7:
				parse_str($cad);
				
				$idemp = $this->getIdEmpFromAlias($u);
				$arr0 = array(8,9,10,11,12,22);
				$cve = intval($clavenivelacceso);
				$pos = array_search($cve, $arr0);
				$arr1 = array(1,2,3,4,5);

				if (    in_array( $cve, $arr0 )     ) {
						$query = "SELECT idgponiv, idgrupo, grupo_visible, grupo_ciclo_nivel_visible, bloqueado, clave, grupo, 
										ciclo, clave_nivel, grado, idciclo
								FROM _viNivel_Grupos
								WHERE idemp = $idemp AND grupo_ciclo_nivel_visible = 1 AND clave_nivel IN ($otros) ORDER BY clave_nivel ASC";
				}else{
						$query = "SELECT *
										FROM _viNivel_Grupos
									WHERE idemp = $idemp AND grupo_ciclo_nivel_visible = 1 ORDER BY clave_nivel ASC";
				}
				break;
				
			case 8:
				$query = "SELECT *
								FROM cat_grupos
							WHERE idgrupo = $cad AND visible = 1 ";
				break;

			case 9:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idalumno, nombre_alumno, username, genero, valid_for_admin, idusuario AS idusername
								FROM _viAlumnos
							WHERE idemp = $idemp ORDER BY idalumno DESC";
				break;
			case 10:
				$query = "SELECT * 
								FROM _viAlumnos 
							WHERE idalumno = $cad "; 
				break;

			case 11:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idprofesor, nombre_profesor, username, cel1, cel2, direccion
								FROM _viProfesores
							WHERE idemp = $idemp ORDER BY idprofesor DESC";
				break;
			case 12:
				$query = "SELECT *
								FROM _viProfesores
							WHERE idprofesor = $cad ";
				break;

			case 13:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viMaterias
							WHERE idemp = $idemp ORDER BY idmateria DESC";
				break;
			case 14:
				$query = "SELECT *
								FROM _viMaterias
							WHERE idmateria = $cad ";
				break;

			case 15:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_materias_clasificacion
							WHERE idemp = $idemp ORDER BY idmatclas DESC";
				break;
			case 16:
				$query = "SELECT *
								FROM cat_materias_clasificacion
							WHERE idmatclas = $cad ";
				break;

			case 17:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_parentezcos
							WHERE idemp = $idemp ORDER BY idparentezco DESC";
				break;
			case 18:
				$query = "SELECT *
								FROM cat_parentezcos
							WHERE idparentezco = $cad ";
				break;

			case 19:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idpersona, nombre_persona, username
								FROM _viPersonas
							WHERE idemp = $idemp ORDER BY idpersona DESC";
				break;
			case 20:
				$query = "SELECT *
								FROM _viPersonas
							WHERE idpersona = $cad ";
				break;

			case 21:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idfamilia, familia
								FROM cat_familias
							WHERE idemp = $idemp ORDER BY $otros DESC";
				break;
			case 22:
				$query = "SELECT *
								FROM cat_familias
							WHERE idfamilia = $cad ";
				break;

			case 23:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viFamPer
							WHERE idfamilia = $idfamilia AND idemp = $idemp ORDER BY $otros DESC";
				break;
			case 24:
				$query = "SELECT *
								FROM _viFamPer
							WHERE idfamper = $cad ";
				break;

			case 25:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viFamAlu
							WHERE idfamilia = $idfamilia AND idemp = $idemp ORDER BY $otros DESC";
				break;
			case 26:
				$query = "SELECT *
								FROM _viFamAlu
							WHERE idfamalu = $cad ";
				break;

			case 27:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idregfis, rfc, cp, razon_social, is_email
								FROM _viRegFis
							WHERE idemp = $idemp ORDER BY $otros DESC";
				break;
			case 28:
				$query = "SELECT *
								FROM _viRegFis
							WHERE idregfis = $cad ";
				break;

			case 29:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viFamRegFis
							WHERE idfamilia = $idfamilia AND idemp = $idemp ORDER BY $otros DESC";
				break;
			case 30:
				$query = "SELECT *
								FROM _viFamRegFis
							WHERE idfamregfis = $cad ";
				break;

			case 31:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        // $idciclo = $this->getCicloFromIdEmp($idemp);
				$query = "SELECT *
								FROM _viGrupo_Materias
							WHERE  idciclo = $idciclo AND idgrupo = $idgrupo AND idemp = $idemp ORDER BY $otros DESC";
				break;

			case 32:
				$query = "SELECT *
								FROM _viGrupo_Materias
							WHERE idgrumat = $cad ";
				break;

			case 33:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

		        $numval = intval($numval)-1;
		        $ncal = "cal".$numval;
		        $ncon = "con".$numval;
		        $nina = "ina".$numval;
		        $nobs = "obs".$numval;
				$query = "SELECT idboleta, num_lista, alumno, ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, ".$nobs." AS obs 
							FROM _viBoletas
							WHERE idemp = $idemp AND idgrumat = $idgrumat ORDER BY num_lista ASC";
				break;

			case 34:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idgrumatcon, descripcion, porcentaje, idalutipoactividad
								FROM grupo_materia_config
							WHERE idemp = $idemp AND idgrumat = $idgrumat AND num_eval = $numval ORDER BY idgrumatcon ASC ";
				break;

			case 35:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idbolpar, idgrumatcon, idboleta, calificacion
								FROM boleta_partes
							WHERE idemp = $idemp AND idgrumatcon = $idgrumatcon  ORDER BY idboleta ";
				break;

			case 36:
				parse_str($cad);
				$query = "SELECT idbolpar, idgrumatcon, idboleta, calificacion
								FROM boleta_partes
							WHERE idgrumatcon = $idgrumatcon ";
				break;

			case 37: // get Evaluaciones
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);

				$query = "SELECT idgponiv, idciclo, idnivel, idgrupo, clave_nivel
								FROM _viNivel_Grupos
							WHERE idgrupo = $idgrupo AND idemp = $idemp AND idciclo = $idciclo  AND grupo_ciclo_nivel_visible = 1  LIMIT 1 ";
				break;
			case 38:
				parse_str($cad);
		        // $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idgrumatcon, idgrumat, descripcion, porcentaje, num_eval, idalutipoactividad, tipo_actividad, elementos
								FROM _viGruMatConf
							WHERE idgrumat = $idgrumat AND num_eval = $numval $otros ";
				break;

			case 39:
				parse_str($cad);
				$query = "SELECT idgrumatcon, descripcion, porcentaje, num_eval, idalutipoactividad, tipo_actividad, elementos
								FROM _viGruMatConf
							WHERE idgrumatcon = $cad ";
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
							WHERE idgrualu = $idgrualu $otros ";
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
							WHERE idgrualu = $idgrualu $otros ";
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
							WHERE idgrupo = $idgrupo AND idciclo = $idciclo $otros ";
				break;

			case 43: // ARJI
				parse_str($cad);
				$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia,abreviatura, idgrupo, grupo, 
									profesor, idalumno, idnivel, clave_nivel, grado, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
									cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
									cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
								FROM _viBoletas
							WHERE idgrualu = $idgrualu AND padre <= 0 AND (idmatclas in (1,2,3,4,5) ) $otros ";
				break;

			case 44: // ARJI
				parse_str($cad);
				$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia,abreviatura, idgrupo, grupo, 
									profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
									cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
									cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
								FROM _viBoletas
							WHERE idgrualu = $idgrualu AND padre > 0 AND (idmatclas in (1,2,3,4,5) ) AND orden_impresion <= 100 $otros ";
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
							WHERE (idgrualu = $idgrualu) AND (padre <= 0) AND (idioma = 0) AND (idmatclas <= 5) $otros ";
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
							WHERE (idgrualu = $idgrualu) AND (padre > 0) AND (idioma = 0) AND ( idmatclas in (1,2,3,4,5) ) $otros ";
				break;
			case 47: // ARJI
				parse_str($cad);
				$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, idgrupo, grupo, 
									profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
									cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
									cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
								FROM _viBoletas 
							WHERE (idgrualu = $idgrualu) AND (padre <= 0) AND (idioma = 1) AND (idmatclas <= 5) $otros ";
				break;
			case 48: // ARJI - MATERIAS HIJAS INGLES
				parse_str($cad);
				$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, abreviatura, idgrupo, grupo, 
									profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
									cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
									cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
								FROM _viBoletas
							WHERE (idgrualu = $idgrualu) AND (padre > 0) AND (idioma = 1) AND ( idmatclas in (1,2,3,4,5) ) $otros ";
				break;
			case 49: // ARJI
				parse_str($cad);
				$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
								cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
								cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
								promcal, promcon, sumina, modi_el,
								promcalgpo, promcongpo, suminagpo
								FROM grupo_alumno_promedio_idioma
							WHERE idgrualu = $idgrualu AND idioma = $idioma  $otros ";
				break;

			case 50: // ARJI
				parse_str($cad);
				$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
								cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
								cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
								promcal, promcon, sumina,
								promcalgpo, promcongpo, suminagpo
								FROM grupo_promedios_idiomas
							WHERE idgrupo = $idgrupo AND idciclo = $idciclo AND idioma = $idioma $otros ";
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
							WHERE (idgrualu = $idgrualu) AND (idioma = 0) AND ( idmatclas in (7) ) $otros ";
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
							WHERE (idgrualu = $idgrualu) AND (idioma = 1) AND ( idmatclas in (7) ) $otros ";
				break;
			
			case 53: // ARJI
				parse_str($cad);
				$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, abreviatura, idgrupo, grupo, 
									profesor, alumno, matricula_interna, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
									cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
									cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
								FROM _viBoletas
							WHERE (idgrualu = $idgrualu) AND (padre > 0) AND (idioma = $idioma) AND (idmatclas <= 5) $otros ";
							// WHERE (idgrualu = $idgrualu) AND (padre <= 0) AND (idioma = 0) AND (idmatclas <= 5) $otros ";
				break;

			case 54: // ARJI
				parse_str($cad);
				$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, abreviatura, idgrupo, grupo, 
									profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
									cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
									cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
								FROM _viBoletas
							WHERE idgrualu = $idgrualu AND idioma = $idioma AND isagrupadora_grumat = 1 AND (idmatclas in (1,2,3,4,5) ) $otros ";
				break;
	
			case 55: // ARJI
				parse_str($cad);
				$query = "SELECT idboleta, idgrualu, idgrumat, idciclo, ciclo, num_lista, materia, abreviatura, idgrupo, grupo, 
									profesor, alumno, cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, 
									cal2, con2, ina2, obs2, cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, 
									cal5, con5, ina5, obs5, cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
									promcal, promcon, sumina, promcalgpo, promcongpo, suminagpo
								FROM _viBoletas
							WHERE idgrualu = $idgrualu AND idioma = $idioma AND padre > 0 AND (idmatclas in (1,2,3,4,5) ) AND ( orden_impresion between $rango ) $otros ";
				break;

			case 56:  // Get Eval for IdGruAlu
				parse_str($cad);
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
					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, idmatclas, padre
									FROM _viBoletas
								WHERE idgrualu = $idgrualu AND idgrumat = $idgrumat $otros ";
		        }elseif ( $numval == 10 ){
					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, idmatclas, padre
									FROM _viBoletas
								WHERE idgrualu = $idgrualu AND idgrumat = $idgrumat $otros ";
				}else{
					
					$qrytemp = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, ".$nobs." AS obs, bol.idmatclas, bol.padre
									FROM _viBoletas bol
								WHERE bol.idgrumat = $idgrumat AND bol.idgrualu = $idgrualu $otros";

					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, ".$nobs." AS obs, bol.idmatclas, bol.padre
									FROM _viBoletas bol
								WHERE bol.idgrumat = $idgrumat AND bol.idgrualu = $idgrualu $otros";
				}

				break;

			case 57:  // Get Eval for IdGruAlu
				parse_str($cad);
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
					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina
									FROM grupo_alumno_promedio
								WHERE idgrualu = $idgrualu $otros ";
		        }elseif ( $numval == 10 ){
						$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina
										FROM grupo_alumno_promedio
									WHERE idgrualu = $idgrualu $otros ";
				}else{
					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, ".$nobs." AS obs
									FROM grupo_alumno_promedio
								WHERE idgrualu = $idgrualu $otros ";
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
					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina
									FROM grupo_alumno_promedio_idioma
								WHERE idgrualu = $idgrualu $otros ";
		        }elseif ( $numval == 10 ){
						$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina
										FROM grupo_alumno_promedio_idioma
									WHERE idgrualu = $idgrualu $otros ";
				}else{
					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, ".$nobs." AS obs
									FROM grupo_alumno_promedio_idioma
								WHERE idgrualu = $idgrualu $otros ";
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
							WHERE idgrupo = $idgrupo AND idgrumat = $idgrumat $otros ";
				break;

			case 60:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viFamAlu
							WHERE idfamilia = $idfamilia AND idalumno = $idalumno AND idemp = $idemp LIMIT 1";
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
							WHERE idgrualu = $idgrualu AND isoficial = 1 $otros ";
				break;
			case 71: // ARJI
				parse_str($cad);
				$query = "SELECT cal0, con0, ina0, obs0, cal1, con1, ina1, obs1, cal2, con2, ina2, obs2, 
								cal3, con3, ina3, obs3, cal4, con4, ina4, obs4, cal5, con5, ina5, obs5, 
								cal6, con6, ina6, obs6, cal7, con7, ina7, obs7, 
								promcalof, promconof, suminaof,bim0,bim1,bim2,bim3,bim4,
								modi_el
								FROM grupo_alumno_promedio
							WHERE idgrualu = $idgrualu $otros ";
				break;
			
			case 72:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT DISTINCT materia_oficial
								FROM _viGrupo_Materias
							WHERE idgrupo = $idgrupo AND isoficial = 1 AND idemp = $idemp";
				break;

			case 73: // ARJI
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
							WHERE $cad $otros ";
				break;

			case 74:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_metodos_de_pago
							WHERE idemp = $idemp ORDER BY idmetododepago ASC";
				break;
			case 75:
				$query = "SELECT *
								FROM cat_metodos_de_pago
							WHERE idmetododepago = $cad ";
				break;

			case 76:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_colores
							WHERE idemp = $idemp ORDER BY idcolor ASC";
				break;
			case 77:
				$query = "SELECT *
								FROM cat_colores
							WHERE idcolor = $cad ";
				break;

			case 78:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idproducto, idmedida, medida1, producto, proveedor, 
								costo_unitario, codigo_color_hex, color
								FROM _viProductos
							WHERE idemp = $idemp ORDER BY idproducto ASC";
				break;
			case 79:
				$query = "SELECT *
								FROM _viProductos
							WHERE idproducto = $cad ";
				break;

			case 80:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_medidas
							WHERE idemp = $idemp ORDER BY idmedida ASC";
				break;
			case 81:
				$query = "SELECT *
								FROM cat_medidas
							WHERE idmedida = $cad ";
				break;

			case 82:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_proveedores
							WHERE idemp = $idemp ORDER BY idproveedor ASC";
				break;
			case 83:
				$query = "SELECT *
								FROM cat_proveedores
							WHERE idproveedor = $cad ";
				break;

			case 84:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT DISTINCT idsolicituddematerial, solicitante, fecha_solicitud, observaciones, cEstatus, status_solicitud_de_material
								FROM _viSolMatEnc
							WHERE idemp = $idemp AND idsolicita = $idusr ORDER BY idsolicita DESC";
				break;

			case 85:
				parse_str($cad);
				$query = "SELECT *
								FROM _viSolMatDet
							WHERE idsolicituddematerial = $idsolicituddematerial $otros ";
				break;

			case 86:
				$query = "SELECT *
								FROM _viSolMatDet
							WHERE idsolicituddematerialdetalle = $cad ";
				break;

			case 87:
				parse_str($cad);
				$query = "SELECT *
								FROM _viSolMatEnc
							WHERE idsolicituddematerial = $cad";
				break;

			case 88:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT *
								FROM _viSolMatEnc
							WHERE idemp = $idemp AND idautoriza = $idusr AND status_solicitud_de_material = $sts ORDER BY fecha_solicitud DESC";
				break;

			case 89:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT DISTINCT idsolicituddematerial, solicitante, fecha_entrega, observaciones, cEstatus, fecha_autorizacion
								FROM _viSolMatEnc
							WHERE idemp = $idemp AND status_solicitud_de_material = $sts ORDER BY fecha_solicitud DESC";
				break;

			case 90:
				parse_str($cad);
				$query = "SELECT idboleta, idgrualu, idgrumat, num_lista, alumno, grupo, materia, profesor, 
							CASE WHEN iduseralu IS NOT NULL THEN iduseralu ELSE 0 END AS iduseralu
								FROM _viBoletas
							WHERE idgrumat = $idgrumat ORDER BY alumno ASC";
				break;

			case 91:
				parse_str($cad);
				$query = "SELECT *
								FROM  cat_alu_refer_oficiales
							WHERE idalumno = $idalumno AND idnivel = $idnivel AND idemp = $idemp LIMIT 1 ";
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
								modi_el,".$ncal." AS cal
								FROM grupo_alumno_promedio
							WHERE idgrualu = $idgrualu $otros ";
				break;

			case 93:  // Get Eval for IdGruAlu
				parse_str($cad);
		        if ( $numval == 6 ){
			        $ncal = "promcalof";
		        }else{
			        $numval = intval($numval)-1;
			        $ncal = "bim".$numval;
		        }
		        
					$query = "SELECT ".$ncal." AS cal, idmatclas, padre
									FROM _viBolOf
								WHERE idgrualu = $idgrualu AND idgrumat = $idgrumat $otros ";
				break;

			case 94:
				parse_str($cad);
				$query = "SELECT idboleta
								FROM _viBoletas
							WHERE idgrualu = $idgrualu AND idioma = 0 AND idmatclas = 6";
				break;

			case 95:
				parse_str($cad);
				$query = "SELECT calificacion 
								FROM _viGruMatBol 
								WHERE idboleta = $idboleta AND num_eval = $numeval ORDER BY idgrumatcon ASC LIMIT 3 ";
				break;

			case 96:
				parse_str($cad);
				$query = "SELECT *, DATE_FORMAT(fecha_boleta, '%d-%m-%Y') AS cfecha_boleta
								FROM  pos_lectura_sep
							WHERE clave_nivel = $idnivel AND grado = $grado AND idemp = $idemp LIMIT 1 ";
				break;

			case 97:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viDirectores
							WHERE clave_nivel = $clavenivel AND idemp = $idemp AND status_director = 1 ";
				break;

			case 98: // ARJI
				parse_str($cad);
				$query = "SELECT inabim0, inabim1, inabim2, inabim3, inabim4
								FROM _viBoletas
							WHERE idgrualu = $idgrualu $otros ";
				break;

			case 99:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT materia, idgrumat
								FROM _viGrupo_Materias
							WHERE idgrupo = $idgrupo AND isoficial = 1 AND idemp = $idemp ORDER BY orden_oficial ASC";
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
							WHERE $cad $otros ";
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
							WHERE idboleta = $idboleta $otros ";
				break;

			case 102:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_alu_tipo_actividad
							WHERE idemp = $idemp ORDER BY idalutipoactividad DESC";
				break;
			case 103:
				$query = "SELECT  *
								FROM cat_alu_tipo_actividad 
							WHERE idalutipoactividad = $cad ";
				break;

			case 104:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM grupo_materia_config_markbook
							WHERE idgrumatcon = $idgrumatcon $otros ";
				break;

			case 105:
				$query = "SELECT  *
								FROM grupo_materia_config_markbook 
							WHERE idgrumatconmkb = $cad ";
				break;

			case 106:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM boleta_partes_markbook
							WHERE idgrumatconmkb = $idgrumatconmkb ORDER BY idgrumatconmkb DESC";
				break;

			case 107:
				$query = "SELECT *
								FROM _viMedAlu
							WHERE idmedalu = $cad ";
				break;

			case 108:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viMedAlu
							WHERE idalumno = $idalumno AND idemp = $idemp ";
				break;

			case 109:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_medicos
							WHERE idemp = $idemp ORDER BY idmedico DESC";
				break;
				
			case 110:
				$query = "SELECT *
								FROM cat_medicos
							WHERE idmedico = $cad ";
				break;

			case 111:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viFamPer
							WHERE idfamilia = $idfamilia AND clave_parentezco = '$otros' AND idemp = $idemp LIMIT 1";
				break;

			case 112:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viFamPer
							WHERE idpersona = $idpersona  AND idemp = $idemp LIMIT 1";
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
								modi_el,".$ncal." AS cal
								FROM grupo_alumno_promedio_idioma
							WHERE idgrualu = $idgrualu $otros ";
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
							WHERE idgrualu = $idgrualu AND isoficial = 1 $otros ";
				break;
				
			case 115:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viEmerAlu
							WHERE idalumno = $idalumno AND idemp = $idemp ";
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
							WHERE idgrumat = $idgrumat ORDER BY num_lista ASC";
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
								.$e11." AS e11, ".$e1." AS e1, ".$e12." AS e12," 
								.$e21." AS e21, ".$e2." AS e2, ".$e22." AS e22,"
								.$e31." AS e31, ".$e3." AS e3, ".$e32." AS e32," 
								.$e41." AS e41, ".$e4." AS e4, ".$e42." AS e42 
								FROM boleta_paibi 
							WHERE idboleta = $idboleta LIMIT 1";
				break;

			case 119:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($user);
				$idciclo = $this->getCicloFromIdEmp($idemp);

				$query = "SELECT DISTINCT idprofesor
							FROM _viGrupo_Materias
							WHERE idciclo = $idciclo AND idemp = $idemp ORDER BY profesor ASC";
				break;

			case 120:
				parse_str($cad);

				$query = "SELECT *
							FROM _viProfesores
							WHERE idprofesor = $idprofesor AND  status_profesor = 1 Limit 1";
				break;


			case 500:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viDirectores
							WHERE idemp = $idemp ORDER BY iddirector DESC";
				break;

			case 501:
				$query = "SELECT *
								FROM _viDirectores
							WHERE iddirector = $cad ";
				break;

			case 502:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viSupervisorCaja
							WHERE idemp = $idemp ORDER BY idsupervisorcaja ASC";
				break;
			case 503:
				$query = "SELECT *
								FROM _viSupervisorCaja
							WHERE idsupervisorcaja = $cad ";
				break;

			case 504:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viSupervisorSolMat
							WHERE idemp = $idemp ORDER BY idsupervisorsolmat ASC";
				break;
			case 505:
				$query = "SELECT *
								FROM _viSupervisorSolMat
							WHERE idsupervisorsolmat = $cad ";
				break;


			case 506:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viSupervisorEntrega
							WHERE idemp = $idemp ORDER BY idsupervisorentrega ASC";
				break;

			case 507:
				$query = "SELECT *
								FROM _viSupervisorEntrega
							WHERE idsupervisorentrega = $cad ";
				break;

			case 508:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT *
								FROM _viSolAut
							WHERE idemp = $idemp AND idsolicita = $idusr ";
				break;

			case 509:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT *
								FROM _viSupervisorSolMat
							WHERE idemp = $idemp AND idusersupervisorsolmat = $idusr ";
				break;

			case 510:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT *
								FROM _viSupervisorEntrega
							WHERE idemp = $idemp AND idusersupervisorentrega= $idusr ";
				break;
			
			case 511:
				$query = "SELECT DISTINCT idsolicita, solicitante
								FROM _viSolMatDet
							WHERE idproveedor = $cad AND status_solicitud_de_material = 1 AND status_solicitud_de_materiales = 1 ";
				break;

			case 512:
				parse_str($cad);
				$query = "SELECT  *
								FROM _viSolMatDet
							WHERE idproveedor = $idproveedor AND idsolicita = $idsolicita AND status_solicitud_de_material = 1 AND status_solicitud_de_materiales = 1 ";
				break;

			case 513:
				$query = "SELECT DISTINCT idsolicita, solicitante
								FROM _viSolMatDet
							WHERE idautoriza = $cad AND status_solicitud_de_material = 1 ";
				break;

			case 514:
				parse_str($cad);
				$query = "SELECT  *
								FROM _viSolMatDet
							WHERE idautoriza = $idautoriza AND idsolicita = $idsolicita AND status_solicitud_de_materiales = 1 ";
				break;

			case 515:
				$query = "SELECT *
								FROM _viSolMatDet
							WHERE idsolicita = $cad AND status_solicitud_de_material = 1 ";
				break;

			case 516:
				$query = "SELECT *
								FROM _viDirectores
							WHERE idusuariodirector = $cad ";
				break;

			case 517:
				parse_str($cad);
		        $f0 = explode('-',$fi);
		        $f1 = explode('-',$ff);
		        $fi = $f0[2].'-'.$f0[1].'-'.$f0[0].' 00:00:00';
		        $ff = $f1[2].'-'.$f1[1].'-'.$f1[0].' 23:59:59';

				$query = "SELECT
								sum(cantidad_autorizada) AS cantidad, 
								producto, 
								medida1,
								idcolor,
								color,
								costo_unitario, 
								sum(importe_solicitado) AS suma
							FROM _viSolMatDet
							WHERE idsolicita = $lstProfDir AND 
									status_solicitud_de_materiales = $cmbStatus AND 
									( ( DATE(fecha_solicitud) >= '$fi') OR (DATE(fecha_solicitud) <= '$ff') ) 
							GROUP BY idproducto 
							ORDER BY cantidad DESC ";
				break;

			case 10000:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idobservacion, observacion, idioma, status_observacion
						FROM cat_observaciones WHERE idemp = $idemp AND status_observacion = 1
						ORDER BY idobservacion ASC ";
				break;		

			case 10001:
				$query = "SELECT idobservacion, observacion, idioma, status_observacion
								FROM cat_observaciones
							WHERE idobservacion = $cad ";
				break;

			case 10002:
				$query = "SELECT idnivobs, observacion, clave_nivel, nivel, idioma
								FROM _viNivel_Observaciones
							WHERE idnivobs = $cad ";
				break;

			case 10003:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idconcepto,concepto,status_concepto
								FROM cat_conceptos
							WHERE idemp = $idemp ORDER BY idconcepto DESC";
				break;
			case 10004:
				$query = "SELECT idconcepto,concepto,status_concepto
								FROM cat_conceptos
							WHERE idconcepto = $cad ";
				break;

			case 10005:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viEmiFis
							WHERE idemp = $idemp ORDER BY $otros DESC";
				break;
			case 10006:
				$query = "SELECT *
								FROM _viEmiFis
							WHERE idemisorfiscal = $cad ";
				break;

			case 10007:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viPagos
							WHERE 
									idemp = $idemp AND 
									status_concepto = 1 AND 
									status_pago = 1
							ORDER BY $otros DESC";
				break;
			case 10008:
				$query = "SELECT *
								FROM _viPagos
							WHERE idpago = $cad ";
				break;

			case 10009:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$query = "SELECT DISTINCT idalumno, alumno, genero, idciclo
								FROM _viEdosCta
							WHERE idfamilia = $idfamilia AND idciclo = $idciclo AND idemp = $idemp  AND status_movto IN (0,1) ORDER BY $otros ASC";
				break;

			case 10010:
				parse_str($cad);
				// AQUI SI STATUS_MOVT
		        $idemp = $this->getIdEmpFromAlias($u);		
		        $idciclo = $this->getCicloFromIdEmp($idemp);		
				$query = "SELECT *
								FROM _viEdosCta
							WHERE idfamilia = $idfamilia AND idalumno = $idalumno AND idciclo = $idciclo AND idemp = $idemp AND status_movto IN (0,1)  $otros ";
				break;

			case 10011:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viPagos
							WHERE 
								idemp = $idemp AND 
								idemisorfiscal = $idemisorfiscal AND 
								clave_nivel = $clave_nivel AND 
								status_concepto = 1 AND 
								status_pago = 1
							ORDER BY $otros ASC";
				break;

			case 10012:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);				
				$query = "SELECT *
								FROM _viEdosCta
							WHERE idfamilia = $idfamilia AND idemp = $idemp AND status_movto IN (0,1) ";
				break;

			case 10013:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);				
				$query = " SELECT *
								FROM _viFacEnc
							WHERE idfactura = $idfactura AND idemp = $idemp ORDER BY idfactura ASC ";
				break;

			case 10014:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);				
				$query = " SELECT *
								FROM _viFacDet
							WHERE idfactura = $idfactura AND idemp = $idemp ORDER BY idfacdet ASC ";
				break;

			case 10015:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
		        $strIN = $this->getIdConceptosIN($u,$iduserconceptoescenario);
		        $f0 = explode('-',$fi);
		        $f1 = explode('-',$ff);
		        $fi = $f0[2].'-'.$f0[1].'-'.$f0[0].' 00:00:00';
		        $ff = $f1[2].'-'.$f1[1].'-'.$f1[0].' 23:59:59';

				$query = "SELECT idconcepto, concepto, 
								SUM( IF ( clave_nivel = 1, total, 0 ) ) AS 'cero', 
								SUM( IF ( clave_nivel = 2, total, 0 ) ) AS 'uno', 
								SUM( IF ( clave_nivel = 3, total, 0 ) ) AS 'dos', 
								SUM( IF ( clave_nivel = 4, total, 0 ) ) AS 'tres', 
								SUM( IF ( clave_nivel = 5, total, 0 ) ) AS 'cuatro' 
							FROM _viEdosCta
							WHERE idemp = $idemp AND  
									status_movto = 1 AND  
									idemisorfiscal = $emisor AND  
									idconcepto IN ($strIN) AND 
									(fecha_de_pago >= '$fi' AND fecha_de_pago <= '$ff')
							GROUP BY idconcepto ";
				break;

			case 10016:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
		        $f0 = explode('-',$fi);
		        $f1 = explode('-',$ff);
		        $fi = $f0[2].'-'.$f0[1].'-'.$f0[0].' 00:00:00';
		        $ff = $f1[2].'-'.$f1[1].'-'.$f1[0].' 23:59:00';

				if ( $tiporeporte==3 || $tiporeporte==4 ){
			        $conce =  intval($vconcepto) > 0 ? ' idconcepto = '.$vconcepto.' AND ':'';		        
				}else{
		        	$conce =  intval($conceptos) > 0 ? ' idconcepto = '.$conceptos.' AND ':'';
				}

				if ( $tiporeporte==3 || $tiporeporte==4 ){
			        $pagado =  " status_movto = 0 ";
				}else{
			        $pagado =  " status_movto = 1 And ( fecha_de_pago >= '".$fi."' AND fecha_de_pago <= '".$ff."' )";
				}

				$query = "SELECT idedocta, idconcepto, concepto, familia, alumno, mes, directorio, 
								is_pagos_diversos, fecha_de_pago, cfolio, idfamilia, pdf, xml,
								subtotal, descto_becas, descto, importe, recargo, total,
								idalumno,
								IF ( clave_nivel = 1, total, 0 ) AS 'cero', 
								IF ( clave_nivel = 2, total, 0 ) AS 'uno', 
								IF ( clave_nivel = 3, total, 0 ) AS 'dos', 
								IF ( clave_nivel = 4, total, 0 ) AS 'tres', 
								IF ( clave_nivel = 5, total, 0 ) AS 'cuatro' 
							FROM _viEdosCta
							WHERE idemp = $idemp And 
									idemisorfiscal = $emisor And 
									$conce
									$pagado 
							ORDER BY fecha_de_pago ASC";
				break;

			case 10017:
			
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);				
				$query = " SELECT *
								FROM _viFacEnc
							WHERE idcliente = $idfamilia AND (isfe = 1 OR padre > 0) AND idemp = $idemp ORDER BY idfactura DESC ";
				break;

			case 10018:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT DISTINCT idalumno, alumno, genero, 
											beca_sep, beca_arji, beca_sp, beca_bach
								FROM _viFamAlu
							WHERE idfamilia = $idfamilia AND idemp = $idemp ORDER BY $otros DESC";
				break;

			case 10019:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
								FROM _viFamAlu
							WHERE idalumno = $idalumno AND idemp = $idemp LIMIT 1";
				break;

			case 10020:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT DISTINCT idconcepto, concepto
								FROM _viPagos
							WHERE idemp = $idemp AND 
									idemisorfiscal = $idemisorfiscal AND 
									status_concepto = 1 AND 
									status_pago = 1
							ORDER BY concepto ASC";
				break;

			case 10021:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);				
				$idciclo = $this->getCicloFromIdEmp($idemp);

				$query = "SELECT DISTINCT idalumno, nombre_completo_alumno
								FROM _viEdosCta
							WHERE idfamilia = $idfamilia AND idciclo = $idciclo AND ( ( isfe = 0) OR (isfe IS NULL) ) AND idemp = $idemp $otros";
				break;


			case 10022:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);				
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$query = "SELECT *
								FROM _viEdosCta
							WHERE idfamilia = $idfamilia AND idalumno = $idalumno AND idconcepto = $idconcepto AND idciclo = $idciclo AND idemp = $idemp  AND status_movto IN (0,1)  ";
				break;

			case 10023:
					parse_str($cad);
					$idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT * 
							FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND idemp = $idemp AND idfamilia = $idfamilia AND idalumno = $idalumno AND status_grualu = 1 LIMIT 1";
				break;	

			case 10024:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT DISTINCT idconcepto, concepto
								FROM _viPagos
							WHERE 
									idemp = $idemp AND 
									idemisorfiscal = $idemisorfiscal AND 
									is_pagos_diversos = 1 AND 
									status_concepto = 1 AND 
									status_pago = 1
							ORDER BY $otros ASC";
				break;

			case 10025:
					parse_str($cad);
					$idemp = $this->getIdEmpFromAlias($u);
					$idciclo = $this->getCicloFromIdEmp($idemp);
							// FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND idemp = $idemp AND idfamilia = $idfamilia AND idalumno = $idalumno AND status_grualu = 1 LIMIT 1";
					$query = "SELECT * 
							FROM _viGrupo_Alumnos WHERE idemp = $idemp AND idfamilia = $idfamilia AND idalumno = $idalumno AND status_grualu = 1 LIMIT 1";
				break;	

			case 10026:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        $idusr = $this->getIdUserFromAlias($u);
		        $strIN = $this->getIdConceptosIN($u,$iduserconceptoescenario);
				$query = "SELECT DISTINCT idconcepto, concepto
								FROM _viPagos
							WHERE idemp = $idemp AND 									
									idconcepto IN ($strIN) AND 
									idemisorfiscal = $idemisorfiscal AND 
									status_concepto = 1 AND 
									status_pago = 1						 
							ORDER BY concepto ASC";
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
							WHERE creado_por = $idprofesor AND idemp = $idemp $cfg ORDER BY idtarea DESC ";
				break;

			case 20001:
				parse_str($cad);
				$query = " SELECT * 
								FROM _viTareas
							WHERE idtarea = $idtarea ";
				break;

			case 20002:
				parse_str($cad);
				$query = " SELECT idtareaarchivo, directorio, archivo, descripcion_archivo, creado_el
								FROM tareas_archivos
							WHERE idtarea = $idtarea AND status_tarea_archivo = 1 ORDER BY idtareaarchivo DESC";
				break;

			case 20003:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);

				$query = " SELECT idtareadestinatario, alumno, materia, abreviatura, grupo, isrespuesta, isleida, iddestinatario, idtarea, iteracciones, profesor, profesor_tarea, archivos
								FROM _viTareasDestinatarios
							WHERE idemp = $idemp AND idtarea = $idtarea AND status_tarea = 1 ORDER BY alumno ASC ";
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
								WHERE idemp = $idemp AND iduseralu = $iduseralu AND isleida = $sts ORDER BY alumno ASC ";
				}else{
					$query = " SELECT idtareadestinatario, idtarea, materia, grupo, profesor, titulo_tarea, fecha_inicio, fecha_fin, isleida, isrespuesta, profesor_tarea, archivos, respuestas, iteracciones
									FROM _viTareasDestinatarios
								WHERE idemp = $idemp AND iduseralu = $iduseralu AND idboleta = $sts ORDER BY alumno ASC ";

				}			
				break;

			case 20005:
				parse_str($cad);
				$query = " SELECT * 
								FROM _viTareasDest_Resp
							WHERE idtareadestinatario = $idtareadestinatario ";
				break;

			case 20006:
				//parse_str($cad);
				$query = " SELECT * 
								FROM _viTareasDest_Resp
							WHERE idtareadestinatariorespuesta = $cad ";
				break;

			case 20007:
				parse_str($cad);
				$query = " SELECT idtareaarchivorespuesta, directorio, archivo, descripcion_archivo, idtareadestinatario, creado_por, creado_el
								FROM tareas_dest_resp_archivos
							WHERE idtareadestinatario = $idtareadestinatario AND status_tarea_archivo_respuesta = 1 ORDER BY idtareaarchivorespuesta DESC ";
				break;

			case 20008:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        
				if (intval($sts) <= 0){
					$sts = $sts * -1;
					$query = " SELECT idtareadestinatario, idtarea, materia, grupo, profesor, titulo_tarea, fecha_inicio, fecha_fin, isleida, isrespuesta, profesor_tarea, respuestas, iteracciones, archivos
									FROM _viTareasDestinatarios
								WHERE idemp = $idemp AND iduseralu = $iduseralu AND isleida = $sts ORDER BY alumno ASC ";
				}else{
					$query = " SELECT idtareadestinatario, idtarea, materia, grupo, profesor, titulo_tarea, fecha_inicio, fecha_fin, isleida, isrespuesta, profesor_tarea, respuestas, iteracciones, archivos
									FROM _viTareasDestinatarios
								WHERE idemp = $idemp AND iduseralu = $iduseralu AND idboleta = $sts ORDER BY alumno ASC ";

				}			
				break;

			case 20009:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        $sts = intval($sts);
		        $loSts = "";
				switch ($sts) {
					case 0:
						$loSts = " AND isleida = 0 "; 
						break;						
					case 1:
						$loSts = " AND isleida = 1 "; 
						break;
					default:
						$loSts = "  "; 
						break;
				}
		        
				$query = " SELECT idtareadestinatario, idtarea, materia, grupo, profesor, titulo_tarea, fecha_inicio, fecha_fin, isleida, isrespuesta, profesor_tarea, respuestas, iteracciones, archivos
								FROM _viTareasDestinatarios
							WHERE idemp = $idemp AND iduseralu = $iduseralu ".$loSts." ORDER BY idtareadestinatario DESC ";
				break;

			case 20010:
				parse_str($cad);
					$query = " SELECT * 
									FROM _viTareasDestinatarios
								WHERE idtareadestinatario = $idtareadestinatario ";
				break;

			case 20011:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        if ( intval($idprofesor) > 0 ){
					$query = " SELECT idtarea, titulo_tarea, tarea, fecha_inicio, fecha_fin, lecturas, respuestas, archivos, destinatarios, status_tarea 
									FROM _viTareas
								WHERE creado_por = $idprofesor AND idemp = $idemp ORDER BY idtarea DESC ";
				} else {
					$query = " SELECT DISTINCT idtarea, profesor, titulo_tarea, materia, grupo 
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
							WHERE iduserpropietario = $iduserpropietario AND idemp = $idemp AND status_com_grupo = 1 ORDER BY idcomgrupo ASC ";
				break;

			case 30002:
				$query = " SELECT *
								FROM com_grupos
							WHERE idcomgrupo = $cad AND status_com_grupo = 1 ORDER BY idcomgrupo ASC ";
				break;

			case 30003:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = " SELECT *
								FROM _viComGpoUser
							WHERE idcomgrupo = $idcomgrupo AND idemp = $idemp AND status_com_usuario_asoc_grupo = 1 ORDER BY idcomgrupo ASC ";
				break;

			case 31000:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        $iduserpropietario = $this->getIdUserFromAlias($u);				
				$query = " SELECT idcommensaje, titulo_mensaje, mensaje, cfecha, lecturas, respuestas, archivos, destinatarios, status_mensaje 
								FROM _viComMensajes
							WHERE iduserpropietario = $iduserpropietario AND idemp = $idemp ORDER BY idcommensaje DESC ";
				break;

			case 31001:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        $iduserpropietario = $this->getIdUserFromAlias($u);				
				$query = " SELECT idcommensaje, titulo_mensaje, mensaje, cfecha, lecturas, respuestas, archivos, destinatarios, status_mensaje
								FROM _viComMensajes
							WHERE iduserpropietario = $iduserpropietario AND idcommensaje = $idcommensaje ORDER BY idcommensaje DESC ";
				break;

			case 31002:
				parse_str($cad);
				$query = " SELECT idcommensajearchivo, directorio, archivo, descripcion_archivo, creado_el
								FROM com_mensaje_archivos
							WHERE idcommensaje = $idcommensaje AND status_mensaje_archivo = 1 ORDER BY idcommensajearchivo DESC ";
				break;

			case 31003:
				parse_str($cad);
				$query = " SELECT idcommensajedestinatario, nombre_destinatario, nombre_remitente, grupo, isrespuesta, isleida, iddestinatario, idcommensaje, iteracciones, archivos
								FROM _viComMensajeDestinatarios
							WHERE idcommensaje = $idcommensaje AND status_mensaje_destinatario = 1 ORDER BY nombre_destinatario ASC ";
				break;

			case 31004:
				parse_str($cad);
				$query = " SELECT * 
								FROM _viComMensajes
							WHERE idcommensaje = $idcommensaje ";
				break;

			case 31005:
				parse_str($cad);
				$query = " SELECT idcommensajearchivo, directorio, archivo, descripcion_archivo, creado_el
								FROM com_mensaje_archivos
							WHERE idcommensaje = $idcommensaje AND status_mensaje_archivo = 1 ORDER BY idcommensajearchivo DESC";
				break;

			case 31006:
				parse_str($cad);
				$query = " SELECT * 
								FROM _viComMenDestResp
							WHERE idcommensajedestinatario = $idcommensajedestinatario ";
				break;

			case 31007:
				parse_str($cad);
				$query = " SELECT idcommensajearchivorespuesta, directorio, archivo, descripcion_archivo, idcommensajedestinatario, creado_por, creado_el
								FROM com_mensaje_dest_resp_archivos
							WHERE idcommensajedestinatario = $idcommensajedestinatario AND status_mensaje_archivo_respuesta = 1 ORDER BY idcommensajearchivorespuesta DESC ";
				break;

			case 31008:
				//parse_str($cad);
				$query = " SELECT * 
								FROM _viComMenDestResp
							WHERE idcommensajedestinatariorespuesta = $cad ";
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
						$loSts = " AND isleida = 0 AND (titulo_mensaje IS NOT NULL) "; 
						break;						
					case 1:
						$loSts = " AND isleida = 1  AND (titulo_mensaje IS NOT NULL) "; 
						break;
					default:
						$loSts = "   AND (titulo_mensaje IS NOT NULL) "; 
						break;
				}
				$query = " SELECT idcommensajedestinatario, idcommensaje, grupo, titulo_mensaje, fecha, isleida, isrespuesta, nombre_remitente, lecturas, respuestas, iteracciones, archivos
								FROM _viComMensajeDestinatarios
							WHERE idemp = $idemp AND iddestinatario = $iddestinatario ".$loSts." ORDER BY idcommensajedestinatario DESC ";

				break;

			case 31010:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);		
		        $idciclo = $this->getCicloFromIdEmp($idemp);		
				$query = "SELECT *
								FROM _viEdosCta
							WHERE idfamilia = $idfamilia AND idalumno = $idalumno AND idciclo = $idciclo AND idemp = $idemp AND is_pagos_diversos = 1  AND status_movto IN (0,1) $otros";
				break;

			case 31011:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        $idciclo = $this->getCicloFromIdEmp($idemp);		
		        $iddestinatario = $this->getIdUserFromAlias($u);				
				$query = " SELECT *
								FROM _viComMensajes
							WHERE idemp = $idemp AND idciclo = $idciclo AND idcommensaje = $idcommensaje ORDER BY idcommensaje DESC ";
				break;

			case 31012:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($user);		
		        $idciclo = $this->getCicloFromIdEmp($idemp);		
				$query = "SELECT *
								FROM _viEdosCta
							WHERE idedocta = $idedocta AND idciclo = $idciclo AND idemp = $idemp AND is_pagos_diversos = 1 AND status_movto IN (0,1) ";
				break;

							
			}
		$result = $this->getArray($query);
		return $result;
	}


	public function genUserFromCat($iddato=0,$idcat=0) {
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
			$vRet = $this->execQuery($query);

			return $vRet;
	}

	public function genNumListaPorGrupo($cad="") {
			$ip=$_SERVER['REMOTE_ADDR']; 
			$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
			parse_str($cad);
			$idemp = $this->getIdEmpFromAlias($user);
			$idusr = $this->getIdUserFromAlias($user);
			$idciclo = $this->getCicloFromIdEmp($idemp);
			
			$query = "SET @X = Generar_Numero_de_Lista_Por_Grupo(".$idgrupo.",0,".$idusr.",".$idemp.",'".$ip."','".$host."',".$idciclo.")";
			$vRet = $this->execQuery($query);			  
			return $vRet;

	}

	public function cloneNumEvalFromGruMatConAnterior($cad="") {
			$ip=$_SERVER['REMOTE_ADDR']; 
			$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
			parse_str($cad);
			$idemp = $this->getIdEmpFromAlias($user);
			$idusr = $this->getIdUserFromAlias($user);
			
		  	$numval = intval($numval);
			$query = "SET @X = Clonar_Config_Eval_Anterior_Gru_Mat_Prof(".$idgrumat.",".$numval.",".$idusr.",".$idemp.",'".$ip."','".$host."')";
			$vRet = $this->execQuery($query);
			return $vRet;
	}

	public function getPubIdEmp($user="") {
			$idemp = $this->getIdEmpFromAlias($user);						  
			return $idemp;
	}

	public function getPubIdUser($user="") {
			$idusr = $this->getIdUserFromAlias($user);
			return $idusr;
	}


	public function getCountTable($field="",$table="", $where=""){
		    $query = "SELECT count($field) AS ntotal FROM $table WHERE $where LIMIT 1";
		    $result = $this->getArray($query);
		    $ret = !$result ? 0 : intval($result[0]->ntotal);
		    return $ret;	
	}



	public function BuscarMarkbookdeAlumno($cad) {
			$ip=$_SERVER['REMOTE_ADDR']; 
			$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
			parse_str($cad);
			$idemp = $this->getIdEmpFromAlias($user);
			$idusr = $this->getIdUserFromAlias($user);
		  	$numval = intval($numval);
			$query = "SET @X = Buscar_Markbook_de_Alumno(".$idgrumatcon.",".$idemp.",".$idusr.",'".$ip."','".$host."')";
			$vRet = $this->execQuery($query);			  
			return $vRet;
	}


	public function getIdFamFromIdUserAlu($iduseralu=0, $type=0) {
			$idusr = $this->getIdFamFromIdUser($iduseralu,1);
			return $idusr;
	}

	public function getIdConceptosIN($u="", $iduserconceptoescenario=0){
			// Chingonería
			$idemp = $this->getIdEmpFromAlias($u);
			$idusr = $this->getIdUserFromAlias($u);		
			$query = "SELECT DISTINCT idconcepto, concepto
								FROM _viUsersConceptosPagos
							WHERE idemp = $idemp AND 
									iduser = $idusr AND 
									iduserconceptoescenario = $iduserconceptoescenario 
							ORDER BY concepto ASC";
			$result = $this->getArray($query);
			$INStr = "";
			foreach ($result as $i => $value) {
				if ($i == 0){
					$INStr = $result[$i]->idconcepto.',';
				}else{
					if ($i == (count($result)-1) ) {
						$INStr .= $result[$i]->idconcepto;
					}else{
						$INStr .= $result[$i]->idconcepto.',';
					}
				}
			}

			return $INStr;

	}

 }  // OF CLASS
?>