<?php 
/*
ini_set('display_errors', '0');
error_reporting(E_ALL | E_STRICT);

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
*/

date_default_timezone_set('America/Mexico_City');

require_once('vo/voConnPDO.php');
require_once('vo/voEmpty.php');

class oCenturaPDO {
	 
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

	private function getIdUserFromAlias($str){

		$query = "SELECT iduser FROM usuarios WHERE username = '$str' AND status_usuario = 1";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
			$ret=0;
		}else{
		   	$ret= $result[0]->iduser;
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
			$ret= $result[0]->idemp;
		}
		$Conn = null;
		return $ret;
	}

	private function getIdEmpFromIdEdoCta($id){

		$query = "SELECT idemp FROM estados_de_cuenta WHERE idedocta = $id";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
			$ret=0;
		}else{
			$ret= $result[0]->idemp;
		}
		$Conn = null;
		return $ret;

	}

	private function getCicloFromIdEmp($idemp=0){

		$query = "SELECT idciclo FROM cat_ciclos WHERE idemp = $idemp AND predeterminado = 1 AND status_ciclo = 1 LIMIT 1";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if ($result <= 0) {
		$ret=0;
		}else{
			$ret = $result[0]->idciclo;
		}
		$Conn = null;
		return $ret;
	
	}

	private function getNivelFromIdGrupo($idgrupo=0,$idciclo=0){

		$query = "SELECT idnivel FROM _viNivel_Grupos WHERE idgrupo = $idgrupo AND idciclo = $idciclo LIMIT 1";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if ($result <= 0) {
		$ret=0;
		}else{
			$ret = $result[0]->idnivel;
		}
		$Conn = null;
		return $ret;

	}


	private function getNivelFromIdUserAlu($iduseralu=0){

		$query = "SELECT idnivel FROM _viGrupo_Alumnos WHERE iduseralu = $iduseralu ORDER BY idciclo DESC LIMIT 1";

		$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if ($result <= 0) {
		$ret=0;
		}else{
			$ret = $result[0]->idnivel;
		}
		$Conn = null;
		return $ret;

	}

	public function IsLockGroupAcademico($cad) {
		
		parse_str($cad);

        $idemp = $this->getIdEmpFromAlias($u);
	    $query = "SELECT count(idgrupo) AS idgrupo FROM cat_grupos WHERE idgrupo = $idgrupo AND idemp = $idemp AND bloqueado = 1 LIMIT 1";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if ($result <= 0) {
			$ret=0;
		}else{
				$ret = $result[0]->idgrupo;
		}
		$Conn = null;
	    return $ret;

	}

	private function IsExistUserConnect($iduser,$idemp) {
	  
	    $query = "SELECT iduser FROM usuarios_conectados WHERE iduser = $iduser AND idemp = $idemp LIMIT 1";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->iduser;
		}
		$Conn = null;
	    return $ret;
	 }

	private function IsConnectUser($iduser,$idemp) {
	  
	    $query = "SELECT iduser FROM usuarios_conectados WHERE iduser = $iduser AND idemp = $idemp AND isconectado = 1 LIMIT 1";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->iduser;
		}
		$Conn = null;
	    return $ret;
	 }

	public function getNumDiasAsistencia($idgrumat,$eval) {
	  
	    $query = "SELECT DISTINCT fecha AS dia FROM _viBolAsist WHERE idgrumat = $idgrumat AND evaluacion = $eval ";

     	$Conn = new voConnPDO();
		$ret = $Conn->queryFetchAllAssocOBJ($query);
		$Conn = null;
	    return $ret;
	 }

	 public function getLogoEmp($idemp){
	  
	    $query = "SELECT valor FROM config WHERE llave = 'logo-emp-rep' AND idemp = $idemp";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->valor;
		}
		$Conn = null;
	    return $ret;
	 }

	 public function getLogoIB($idemp){
	  
	    $query = "SELECT valor FROM config WHERE llave = 'logo-ib-emp' AND idemp = $idemp";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->valor;
		}
		$Conn = null;
	    return $ret;
	 }


	 public function getNombreEmp($idemp){
	  
	    $query = "SELECT rs FROM empresa WHERE idemp = $idemp";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->rs;
		}
		$Conn = null;
	    return $ret;
	 }

	 public function defineRangoEvaluacionPAI($valor){
	 	$eval = intval($valor);
			switch ( $eval) {
				case 0:
					$rc1 = 0;
					break;
				case 1:
				case 2:
					$rc1 = 2;
					break;
				case 3:
				case 4:
					$rc1 = 4;
					break;
				case 5:
				case 6:
					$rc1 = 6;
					break;
				case 7:
				case 8:
					$rc1 = 8;
					break;								
				default:
					$rc1 = -1;
					break;
			} 
		return $rc1;	
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
			$rst = $Conn->queryFetchAllAssocOBJ($query);
			$Conn = null;
			return $rst;
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

	public function getComboPDO($index=0,$arg="",$pag=0,$limite=0,$tipo=0,$otros=""){

		$query="";
		switch ($index){

			case 0:
					parse_str($arg);
					$pass = md5($passwordL);
					$query = "SELECT username AS label, concat(iduser,'|',password,'|',idemp,'|',empresa,'|',idusernivelacceso,'|',registrosporpagina,'|',clave,'|',param1) AS data 
							FROM  _viUsuarios WHERE username = '$username' AND password = '$pass' AND status_usuario = 1";
				break;						

			case 1:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idnivel = $this->getNivelFromIdGrupo($idgrupo,$idciclo);		        
				$query = "SELECT grupo AS label, idgrupo AS data 
						FROM _viNivel_Grupos WHERE idemp = $idemp AND idciclo = $idciclo AND idnivel = $idnivel
						ORDER BY idgrupo ASC ";
				break;		

			case 2:
				$query = "SELECT *
						FROM _viEdosCta WHERE idedocta = $arg LIMIT 1";
				break;		

			case 3:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT descripcion AS label, idlistavencimiento AS data
						FROM cat_listas_vencimientos WHERE idemp = $idemp ";
				break;		

			case 4:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT DISTINCT materia AS label , idgrumat AS data, idboleta, alumno
						FROM _viBoletas WHERE idgrualu = $idgrualu AND isagrupadora_grumat = 0 AND idciclo = $idciclo AND idemp = $idemp ORDER BY orden_impresion ASC ";
				break;		

			case 5:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$eval = intval($eval)+1;
				$query = "SELECT *, round(cal_real,1) AS calreal, trim(descripcion) AS desc2
						FROM _viGruMatBol WHERE idgrumat = $idgrumat AND num_eval = $eval AND idboleta = $idboleta AND idemp = $idemp ORDER BY idbolpar ASC ";
				break;	

			case 6:

				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *, descripcion_avanzada AS descavanz
						FROM _viGruMatConMKB 
						WHERE idbolpar = $idbolpar 
							AND idboleta = $idboleta 
							AND idgrumatcon = $idgrumatcon 
							AND idgrualu = $idgrualu
							AND idciclo = $idciclo
							AND idemp = $idemp ORDER BY idbolpar ASC ";
				break;		

			case 7:

				parse_str($arg);
				$eval = intval($eval) ;
				$cal = "cal".$eval;		        
				$con = "con".$eval;		        
				$ina = "ina".$eval;		        
				$query = "SELECT round($cal,0) AS cal, $con AS con, $ina AS ina, profesor
						FROM _viBoletas 
						WHERE idboleta = $idboleta ";
				break;		

			case 8:

				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);	
				$eval = intval($eval) + 1;	        
				$query = "SELECT *
						FROM _viBolAsist 
						WHERE idgrualu = $idgrualu 
							AND idboleta = $idboleta 
							AND evaluacion = $eval 
							AND idemp = $idemp
							AND (asistencia = 0 OR asistencia = 3 OR observaciones != '') ORDER BY fecha DESC ";
				break;		
			case 9:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT prefijo_evaluacion, numero_evaluaciones
						FROM cat_niveles WHERE idemp = $idemp AND clave_nivel = $clave_nivel LIMIT 1 ";
				break;		

			case 10: // 
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);

				$query = "SELECT nombres_alumno AS label, idgrualu AS data, grupo, clave_nivel, ver_boleta_interna, grupo_bloqueado, grado, grado_pai, ispai_grupo
						FROM _viGrupo_Alumnos 
						WHERE idemp = $idemp 
							AND idciclo = $idciclo 
							AND idalumno = $idalumno 
							AND status_grualu = 1 
							AND grupo_bloqueado = 0 
						ORDER BY label ASC ";
				break;		

			case 11:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);

				$query = "SELECT DISTINCT vencimiento AS data
						FROM _viEdosCta 
						WHERE idemp = $idemp 
							  AND idciclo = $idciclo 
							  AND status_movto IN (0,1) 
						";

				break;

			case 12:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idemergencia, nombre, tel1, parentezco
						FROM cat_emergencias WHERE idemp = $idemp ";
				break;		

			case 13:
				$query = "SELECT idemergencia, nombre, tel1, parentezco, status_emergencia
						FROM cat_emergencias WHERE idemergencia = ".$arg;
				break;		

			case 14:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT DISTINCT materia AS label , idgrumat AS data, idboleta, alumno
						FROM _viBolForPAI WHERE idgrualu = $idgrualu AND idciclo = $idciclo AND idemp = $idemp ORDER BY idboleta ASC ";
				break;		

			case 15:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT idboleta, materia, idgrumat, idpaiareadisciplinaria, grado_pai
						FROM _viBolForPAI WHERE idgrualu = $idgrualu AND ispai_grupo = 1 AND ispai_materia = 1 AND idciclo = $idciclo AND idemp = $idemp ORDER BY orden_impresion ASC ";
				break;	

			case 16:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT generacion AS label, idgeneracion AS data  
						FROM exa_generaciones WHERE idemp = $idemp AND status_generacion = 1
						ORDER BY data ASC ";
				break;		

			case 51:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$arr0 = array(8,9,10,11,12,19);
				$cve = intval($clavenivelacceso);
				$pos = array_search($cve, $arr0);
				$arr1 = array(1,2,3,4,5);
				if ( intval($otros) > 0 ){
					$query = "SELECT concat(director,' - ',nivel) AS label, iddirector AS data 
							FROM _viDirectores WHERE idemp = $idemp AND status_director = 1 AND clave_nivel IN ($otros)
							ORDER BY data ASC ";
				}else{
					$query = "SELECT concat(director,' - ',nivel) AS label, iddirector AS data 
							FROM _viDirectores WHERE idemp = $idemp AND status_director = 1 
							ORDER BY data ASC ";
				}		
				break;	

			case 55:
				parse_str($arg);
				$idusr = $this->getIdUserFromAlias($u);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        

				$query = "SELECT *
						FROM grupo_materia_config_save 
						WHERE idprofesor = $idusr 
								AND idciclo = $idciclo 
								AND idemp = $idemp 
						";
				break;		

			case 57:

				$query = "SELECT ruta
						FROM _viPDFs 
						WHERE status_pdf = 1 AND 
								categoria_pdf = 0
						ORDER BY idpdf DESC 
						LIMIT 1 
						";
				break;		

			case 58:
				parse_str($arg);
				$idnivel = $this->getNivelFromIdUserAlu($arg);
				$query = "SELECT ruta
						FROM _viPDFs 
						WHERE status_pdf = 1 AND 
								idnivel = $idnivel and
								categoria_pdf = 1
						ORDER BY idpdf DESC 
						LIMIT 1 
						";
				break;		

			case 59:
				parse_str($arg);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM cat_beneficios_giros 
						WHERE idemp = $idemp AND 
								status_giro_beneficio = 1 
						ORDER BY idgirobeneficio DESC ";
				break;		

			case 60:
				parse_str($arg);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM exa_generaciones
						WHERE idemp = $idemp AND 
								status_generacion = 1 
						ORDER BY idgeneracion DESC ";
				break;		

	  	}
		$result = $this->getArray($query);
		return $result;
	}


	public function getQueryPDO($tipo=0,$cad="",$type=0,$from=0,$cant=0,$ar=array(),$otros="",$withPag=1) {
		$query="";
    	switch ($tipo){

			case -6:
					parse_str($cad);
					$idemp = $this->getIdEmpFromAlias($u);
					$query = "SELECT nombre_completo_usuario AS label, iduser AS data 
							FROM  _viUsuarios 
							WHERE 
								idemp = $idemp AND
								idusernivelacceso IN (12,13,14,15,16,17,20,21,23,24,999,1000) AND 
								status_usuario = 1
							ORDER BY nombre_completo_usuario ASC ";
				break;						

			case -5:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
							FROM empresa
							WHERE idemp = $idemp ";
				break;

			case -1:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM empresa WHERE idemp = $idemp AND status_empresa = 1 LIMIT 1";
				break;			

			case 0:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viGruMatConMKB WHERE idgrumatconmkb = $idgrumatconmkb AND idemp = $idemp AND idciclo = $idciclo AND status_alumno = 1 ORDER BY num_lista asc";
				break;						
			case 1:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viBoletas WHERE idgrumat = $idgrumat AND idemp = $idemp AND idciclo = $idciclo ORDER BY num_lista asc";
				break;						
			case 2:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viBolAsist WHERE idgrumat = $idgrumat AND fecha = '$fecha' AND idemp = $idemp ORDER BY num_lista asc";
				break;						
			case 3:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viGruMatConMKB WHERE idgrumatcon = $idgrumatcon AND idgrumatconmkb = $idgrumatconmkb AND idgrualu = $idgrualu AND idemp = $idemp AND idciclo = $idciclo AND status_alumno = 1 LIMIT 1";
				break;						

			case 4:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM _viUsuariosConectados WHERE idemp = $idemp AND isconectado = 1 ";
				break;						

			case 5:
				parse_str($cad);

				$idemp = $this->getIdEmpFromAlias($u);
				$arr0 = array(8,9,10,11,12);
				$cve = intval($clavenivelacceso);
				$pos = array_search($cve, $arr0);
				$arr1 = array(1,2,3,4,5);

				if (    in_array( $cve, $arr0 )     ) {
						$query = "SELECT *
								FROM _viEvalConfig
								WHERE idemp = $idemp AND clave_nivel IN ($otros) ORDER BY clave_nivel ASC ";
				}else{
						$query = "SELECT *
						FROM _viEvalConfig WHERE idemp = $idemp ORDER BY clave_nivel ASC ";
				}

				break;						

			case 6:
				$query = "SELECT *
								FROM evaluaciones_config
							WHERE idevalconfig = $cad ";
				break;

			case 7:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viBolAsist WHERE idboleta = $idboleta AND fecha = '$fecha' AND evaluacion = $eval AND idemp = $idemp ORDER BY num_lista asc";
				break;		

			case 8:
				parse_str($cad);
				$query = "SELECT *
						FROM boleta_partes WHERE idboleta = $idboleta AND idgrumatcon = $idgrumatcon LIMIT 1";
				break;						

			case 9:  // Get Eval for IdGruAlu
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
					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, idmatclas, padre
									FROM _viBoletas
								WHERE idboleta = $idboleta $otros ";
		        }elseif ( $numval == 10 ){
					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, idmatclas, padre
									FROM _viBoletas
								WHERE idboleta = $idboleta $otros ";
				}else{
					$query = "SELECT ".$ncal." AS cal, ".$ncon." AS con, ".$nina." AS ina, ".$nobs." AS obs, idmatclas, padre
									FROM _viBoletas
								WHERE idboleta = $idboleta $otros ";
				}

				break;

			case 10:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM pases_salida
							WHERE idciclo = $idciclo AND idgrupo = $idgrupo AND idemp = $idemp AND status_psa = 1 ORDER BY idpsa DESC ";
				break;
			case 11:
				$query = "SELECT  *
								FROM pases_salida 
							WHERE idpsa = $cad ";
				break;

			case 12:
				parse_str($cad);
				$query = "SELECT *
								FROM _viPSA_Alumnos
							WHERE idpsa = $idpsa ORDER BY idpsa ASC ";
				break;

			case 13:
				parse_str($cad);
				
				$idemp = $this->getIdEmpFromAlias($u);
				$arr0 = array(8,9,10,11,12,22);
				$cve = intval($clavenivelacceso);
				$pos = array_search($cve, $arr0);
				$arr1 = array(1,2,3,4,5);

								// WHERE idemp = $idemp AND grupo_ciclo_nivel_visible = 1 AND clave_nivel IN ($otros) ORDER BY clave_nivel asc";

				if (    in_array( $cve, $arr0 )     ) {
						$query = "SELECT idgponiv, idgrupo, grupo_visible, grupo_ciclo_nivel_visible, bloqueado, clave, grupo, 
										ciclo, clave_nivel, grado, idciclo
								FROM _viNivel_Grupos
								WHERE idemp = $idemp AND grupo_ciclo_nivel_visible = 1 AND clave_nivel IN ($otros) ORDER BY idnivel, idgrupo asc";
				}else{
						$query = "SELECT *
										FROM _viNivel_Grupos
									WHERE idemp = $idemp AND grupo_ciclo_nivel_visible = 1 ORDER BY  idnivel, idgrupo asc";
				}

				break;

			case 14:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT alumno, idalumno 
						FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND idgrupo = $idgrupo AND idemp = $idemp AND status_grualu = 1
						ORDER BY alumno ASC ";
				break;		

			case 15:
				$query = "SELECT  *
								FROM _viPSA 
							WHERE idpsa = $cad ";
				break;

			case 16:
				parse_str($cad);
				$query = "SELECT *
								FROM _viPSA_Alumnos
							WHERE idpsa = $idpsa AND idalumno = $idalumno LIMIT 1 ";
				break;

			case 17:
					parse_str($cad);
					$iduseralumno = $this->getIdUserFromAlias($u);
			        $idemp = $this->getIdEmpFromAlias($u);

					$query = "SELECT alumno AS label, idalumno AS data, nombre_alumno 
							FROM _viFamAlu WHERE iduseralufortutor = $iduseralumno AND status_famalu = 1 AND idemp = 1";
					break;		

			case 18:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$idciclo = $this->getCicloFromIdEmp($idemp);		        

		        switch (intval($tipoBeca)) {
		        	case -2:
		        		$tBeca = "";
		        		$tDescto = " descto_becas ";
		        		break;

		        	case -1:
		        		$tBeca = "";
		        		$tDescto = " descto ";
		        		break;

		        	case 0:
		        		$tBeca = "";
		        		$tDescto = " (descto_becas + descto) ";
		        		break;

		        	case 1:
		        		$tBeca = " ( beca_arji > 0 AND descto_becas > 0 ) AND ";
		        		$tDescto = " ( (beca_arji/100) * subtotal ) ";
		        		break;

		        	case 2:
		        		$tBeca = " ( beca_sep > 0 AND descto_becas > 0 ) AND ";
		        		$tDescto = " ( (beca_sep/100) * subtotal ) ";
		        		break;

		        	case 3:
		        		$tBeca = " ( beca_bach > 0 AND descto_becas > 0 ) AND ";
		        		$tDescto = " ( (beca_bach/100) * subtotal ) ";
		        		break;

		        	case 4:
		        		$tBeca = " ( beca_sp > 0 AND descto_becas > 0 ) AND ";
		        		$tDescto = " ( (beca_sp/100) * subtotal ) ";
		        		break;		        		

		        }

		        $f0 = explode('-',$fi);
		        $f1 = explode('-',$ff);
		        $fi = $f0[2].'-'.$f0[1].'-'.$f0[0].' 00:00:00';
		        $ff = $f1[2].'-'.$f1[1].'-'.$f1[0].' 23:59:59';

				$query = "SELECT idconcepto, concepto, 
								SUM( IF ( clave_nivel = 1, ".$tDescto.", 0 ) ) AS 'cero', 
								SUM( IF ( clave_nivel = 2, ".$tDescto.", 0 ) ) AS 'uno', 
								SUM( IF ( clave_nivel = 3, ".$tDescto.", 0 ) ) AS 'dos', 
								SUM( IF ( clave_nivel = 4, ".$tDescto.", 0 ) ) AS 'tres', 
								SUM( IF ( clave_nivel = 5, ".$tDescto.", 0 ) ) AS 'cuatro' 
							FROM _viEdosCta
							WHERE 	idemp = $idemp AND 
									idciclo = $idciclo AND 
									status_movto = 1 AND 
									idemisorfiscal = $emisor AND 
									".$tBeca."
									(fecha_de_pago >= '$fi' AND fecha_de_pago <= '$ff')
							GROUP BY idconcepto ";
				break;

			case 19:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$fv0 = explode("-",$fvencimiento);
				$fv = $fv0[2].'-'.$fv0[1].'-'.$fv0[0];

				if ( intval($idgrupo) == 0){
					$cvn = " AND clave_nivel = $clave_nivel ";
				} else {
					$cvn = " AND clave_nivel = $clave_nivel AND idgrupo = $idgrupo ";
				}

				$query = "	SELECT idfamilia, familia, idalumno 
							FROM _viEdoCtaFamilia 
							WHERE idemp = $idemp 
								AND idciclo = $idciclo 
								$cvn 
								AND idconcepto = $vconcepto 
								AND is_pagos_diversos = 1 
								AND is_vencimiento = 1 
								AND vencimiento <= '$fv' 
								AND status_movto = 0 
							GROUP BY idfamilia	
							";
				break;

			case 20:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$fv0 = explode("-",$fvencimiento);
				$fv = $fv0[2].'-'.$fv0[1].'-'.$fv0[0];
				$query = "	SELECT *
							FROM _viEdoCtaFamilia 
							WHERE idemp = $idemp 
								AND idciclo = $idciclo 
								AND clave_nivel = $clave_nivel 
								AND idconcepto = $vconcepto 
								AND idfamilia = $idfamilia 
								AND is_pagos_diversos = 1 
								AND is_vencimiento = 1 
								AND vencimiento <= '$fv' 
								AND status_movto = 0 
							ORDER BY idedocta ASC 	
							";
				break;

			case 21:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$fvencimiento = date('Y-m-d', time());
				$fv0 = explode("-",$fvencimiento);
				$fv = $fv0[2].'-'.$fv0[1].'-'.$fv0[0];
				$query = "	SELECT *
							FROM _viEdoCtaFamilia 
							WHERE idemp = $idemp 
								AND idciclo = $idciclo 
								AND idfamilia = $idfamilia 
								AND is_pagos_diversos = 1 
								AND is_vencimiento = 1 
								AND dias_que_faltan_para_vencer <= -22 
								AND status_movto = 0 
							ORDER BY idedocta ASC 	
							";
				break;

			case 22:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "	SELECT *
							FROM _viFamConv 
							WHERE idemp = $idemp 
								AND idfamilia = $idfamilia 
							limit 1";
				break;

			case 23:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$query = "SELECT idgrualu
						FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND idgrupo = $idgrupo AND idemp = $idemp AND status_grualu = 1 ORDER BY num_lista ";
				break;		

			case 24: // ARJI
				parse_str($cad);
				$query = "SELECT alumno, idgrualu, grupo, num_lista, familia, nivel, ciclo
						FROM _viGrupo_Alumnos WHERE idgrualu = $idgrualu LIMIT 1 ";
				break;

			case 25:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viEmerAlu
							WHERE idalumno = $idalumno AND idemp = $idemp ";
				break;

			case 26:
				$query = "SELECT *
								FROM _viEmerAlu
							WHERE idemeralu = $cad ";
				break;

			case 27:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_emergencias
							WHERE idemp = $idemp ORDER BY idemergencia DESC";
				break;

			case 28:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$query = "SELECT *
								FROM preinscripciones
							WHERE idemp = $idemp AND idciclo = $idciclo ORDER BY idpreinscripcion DESC";
				break;

			case 29:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$query = "SELECT *
								FROM preinscripciones
							WHERE idemp = $idemp AND idciclo = $idciclo AND idpreinscripcion = $idpreinscripcion ORDER BY idpreinscripcion DESC";
				break;

			case 30:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$fv0 = explode("-",$fvencimiento);
				$fv = $fv0[2].'-'.$fv0[1].'-'.$fv0[0];

				if ( intval($idgrupo) == 0){
					$cvn = " AND clave_nivel = $clave_nivel ";
				} else {
					$cvn = " AND clave_nivel = $clave_nivel AND idgrupo = $idgrupo ";
				}


				$query = "	SELECT DISTINCT idfamilia, familia, idalumno 
							FROM _viEdoCtaFamilia 
							WHERE idemp = $idemp 
								AND idciclo = $idciclo 
								$cvn 
								AND idconcepto = $vconcepto 
								AND is_pagos_diversos = 1 
								AND is_vencimiento = 1 
								AND vencimiento <= '$fv' 
								AND status_movto = 0 
							GROUP BY idalumno	
							";
				break;

			case 31:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$fv0 = explode("-",$fvencimiento);
				$fv = $fv0[2].'-'.$fv0[1].'-'.$fv0[0];
				$query = "	SELECT *
							FROM _viEdoCtaFamilia 
							WHERE idemp = $idemp 
								AND idciclo = $idciclo 
								AND clave_nivel = $clave_nivel 
								AND idconcepto = $vconcepto 
								AND idfamilia = $idfamilia 
								AND idalumno = $idalumno 
								AND is_pagos_diversos = 1 
								AND is_vencimiento = 1 
								AND vencimiento <= '$fv' 
								AND status_movto = 0 
							ORDER BY idedocta ASC 	
							";
				break;

			case 32:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($user);
				$query = " SELECT *
						FROM _viEdoCtaFamilia 
						WHERE idemp = $idemp 
							AND idedocta = $idedocta 
						LIMIT 1 ";
				break;

			case 33:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($user);
		        $iduser = $this->getIdUserFromAlias($user);
		        $idciclo = $this->getCicloFromIdEmp($idemp);

		        // AND iduser = $iduser AND type = $type
		        
				$query = "SELECT DISTINCT iddevice, iduser, device_token, type
							FROM cat_devices 
							WHERE idemp = $idemp AND 
									idciclo = $idciclo AND 
									status_device = 1 AND 
									(device_token LIKE '%:%') 
							ORDER BY iddevice DESC";
				break;

			case 34:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        $iduser = $this->getIdUserFromAlias($u);
		        $idciclo = $this->getCicloFromIdEmp($idemp);

				$query = "SELECT *
							FROM _viPDFs 
							WHERE idemp = $idemp AND 
									idciclo = $idciclo AND 
									categoria_pdf = $categoria_pdf";
				break;

			case 35:

				$query = "SELECT *
							FROM _viPDFs 
							WHERE idpdf = ".$cad;
				break;

			case 36:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM cat_beneficios_giros 
						WHERE idemp = $idemp AND 
							status_giro_beneficio = 1
						ORDER BY idgirobeneficio DESC ";
				break;	

			case 37:
				parse_str($cad);
				$query = "SELECT *
						FROM cat_beneficios_giros 
						WHERE idgirobeneficio = $cad";
				break;		

			case 38:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM _viBenAfil 
						WHERE idemp = $idemp
						ORDER BY idbeneficio DESC ";
				break;	

			case 39:
				parse_str($cad);
				$query = "SELECT *
						FROM _viBenAfil 
						WHERE idbeneficio = $cad";
				break;		

			case 40:

				$query = "SELECT *
						FROM _viBenAfil 
						WHERE idemp = 1
						ORDER BY empresa ASC ";
				break;	

			case 41:

				parse_str($cad);
				
				$query = "	SELECT idmobilmensaje, mensaje
							FROM _viMobileMensajes 
							WHERE iduser = $iduser AND 
									device_token = '$device' AND 
									status_read = $sts 
									ORDER BY fecha DESC ";
				break;

			case 42:

				parse_str($cad);
				$query = "	SELECT idmobilmensaje, titulo, mensaje
							FROM _viMobileMensajes 
							WHERE idmobilmensaje = $idmobilmensaje AND 
									iduser = $iduser AND 
									idemp = $idemp 
							LIMIT 1";
				break;

			case 43:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$idciclo = $this->getCicloFromIdEmp($idemp);		        

		        $f0 = explode('-',$fi);
		        $f1 = explode('-',$ff);
		        $fi = $f0[2].'-'.$f0[1].'-'.$f0[0].' 00:00:00';
		        $ff = $f1[2].'-'.$f1[1].'-'.$f1[0].' 23:59:59';

				$query = "SELECT idconcepto, concepto, 
								SUM( IF ( clave_nivel = 1, recargo, 0 ) ) AS 'cero', 
								SUM( IF ( clave_nivel = 2, recargo, 0 ) ) AS 'uno', 
								SUM( IF ( clave_nivel = 3, recargo, 0 ) ) AS 'dos', 
								SUM( IF ( clave_nivel = 4, recargo, 0 ) ) AS 'tres', 
								SUM( IF ( clave_nivel = 5, recargo, 0 ) ) AS 'cuatro' 
							FROM _viEdosCta
							WHERE idemp = $idemp AND 
									status_movto = 1 AND 
									idemisorfiscal = $emisor AND 
									(fecha_de_pago >= '$fi' AND fecha_de_pago <= '$ff') AND 
									recargo > 0
							GROUP BY idconcepto ";

				break;

			case 44:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT DISTINCT profesor AS label,idusuarioprofesor AS data 
						FROM _viDirProf WHERE idemp = $idemp AND idusuariodirector = $idusr
						ORDER BY label ASC ";
				break;


			case 45:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$fv0 = explode("-",$fvencimiento);
				$fv = $fv0[2].'-'.$fv0[1].'-'.$fv0[0];

				if ( intval($idgrupo) == 0){
					$cvn = " AND clave_nivel = $clave_nivel ";
				} else {
					$cvn = " AND clave_nivel = $clave_nivel AND idgrupo = $idgrupo ";
				}


				$query = "	SELECT idfamilia, familia, idalumno 
							FROM _viEdoCtaFamilia 
							WHERE idemp = $idemp 
								AND idciclo = $idciclo 
								$cvn 
								AND idconcepto = $vconcepto 
								AND is_vencimiento = 1 
								AND vencimiento <= '$fv' 
								AND status_movto = 0 
							GROUP BY idfamilia	
							";
				break;

			case 46:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$fv0 = explode("-",$fvencimiento);
				$fv = $fv0[2].'-'.$fv0[1].'-'.$fv0[0];
				$query = "	SELECT *
							FROM _viEdoCtaFamilia 
							WHERE idemp = $idemp 
								AND idciclo = $idciclo 
								AND clave_nivel = $clave_nivel 
								AND idconcepto = $vconcepto 
								AND idfamilia = $idfamilia 
								AND is_vencimiento = 1 
								AND vencimiento <= '$fv' 
								AND status_movto = 0 
							ORDER BY idedocta ASC 	
							";
				break;

			case 47:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM _viExAlumnos 
						WHERE idemp = $idemp AND 
							status_exalumno = 1
						ORDER BY nombre_exalumno ASC ";
				break;	

			case 48:
				parse_str($cad);
				$query = "SELECT *
						FROM _viExAlumnos 
						WHERE idexalumno = $cad";
				break;		

			case 49:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM exa_generaciones 
						WHERE idemp = $idemp AND 
							status_generacion = 1
						ORDER BY generacion DESC ";
				break;	

			case 50:
				parse_str($cad);
				$query = "SELECT *
						FROM exa_generaciones 
						WHERE idgeneracion = $cad";
				break;		

			case 51:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM cat_pai_criterios 
						WHERE idemp = $idemp 
						ORDER BY idpaicriterio DESC ";
				break;	

			case 52:
				parse_str($cad);
				$query = "SELECT *
						FROM cat_pai_criterios 
						WHERE idpaicriterio = $cad";
				break;		

			case 53:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM cat_pai_areas_disciplinarias 
						WHERE idemp = $idemp 
						ORDER BY idpaiareadisciplinaria DESC ";
				break;	

			case 54:
				parse_str($cad);
				$query = "SELECT *
						FROM cat_pai_areas_disciplinarias 
						WHERE idpaiareadisciplinaria = $cad";
				break;		

			case 55:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idpaiconcepto, area_disciplinaria, descripcion_criterio_large, concepto, rango_califica, grado_pai
						FROM _viPAIConceptos 
						WHERE idemp = $idemp 
						ORDER BY idpaiconcepto DESC ";
				break;	

			case 56:
				parse_str($cad);
				$query = "SELECT *
						FROM _viPAIConceptos 
						WHERE idpaiconcepto = $cad";
				break;		

			case 57:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idpaiobjetivo, area_disciplinaria, descripcion_criterio, objetivo, grado_pai
						FROM _viPAIObjetivos 
						WHERE idemp = $idemp 
						ORDER BY idpaiobjetivo DESC ";
				break;	

			case 58:
				parse_str($cad);
				$query = "SELECT *
						FROM _viPAIObjetivos 
						WHERE idpaiobjetivo = $cad";
				break;		

			case 59:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT solicitan AS label, idsolicita AS data 
						FROM _viSolAut WHERE idemp = $idemp AND idautoriza = $otros
						ORDER BY label ASC ";
				break;


			case 60:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);
				$rc1 = $this->defineRangoEvaluacionPAI($rango_califica);
				$query = "SELECT concepto, criterio, descripcion_criterio, descripcion_criterio_large
						FROM _viPAIConceptos 
						WHERE idpaiareadisciplinaria = $idpaiareadisciplinaria
							  AND idpaicriterio = $idpaicriterio
							  AND grado_pai = $grado_pai
							  AND rango_califica = $rc1
							  AND idemp = $idemp
						limit 1 ";
				break;

			case 61:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM cat_listas_vencimientos
						WHERE idemp = $idemp AND 
								status_fecha_vencimiento = 1 
						ORDER BY idlistavencimiento DESC ";
				break;		

			case 62:
				parse_str($cad);
				$query = "SELECT *
						FROM cat_listas_vencimientos 
						WHERE idlistavencimiento = $cad";
				break;		


			case 63:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	


				$query = "SELECT idexalumno, nombre_exalumno, generacion, email, profesion, ocupacion
							FROM _viExAlumnos
							WHERE idemp = $idemp AND 
									status_exalumno = 1 AND 
									(idgeneracion >= $desdegen AND idgeneracion <= $hastagen)
							ORDER BY idgeneracion asc, nombre_exalumno asc";
				break;

			case 64:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT idexaemailenviado, para, cuerpo, titulo, iddestinatarios, creado_por, creado_el
							FROM exa_emails_enviados
							WHERE idemp = $idemp AND 
									status_emails_enviados  = 1 
							ORDER BY idexaemailenviado DESC";
				break;

			case 65:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT *
							FROM _viExaEmailsEnviados
							WHERE idemp = $idemp AND 
									idexaemailenviado  = $idexaemailenviado";
				break;

			case 66:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT *
							FROM _viExAlumnos
							WHERE idemp = $idemp AND 
									idexalumno  = $idexalumno";
				break;

			case 67:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT idexaimage, descripcion_archivo, directorio, archivo, texto_alternativo
							FROM exa_imagenes
							WHERE idemp = $idemp And
									status_exa_image  = 1";
				break;

			case 68:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT *
							FROM exa_imagenes
							WHERE idemp = $idemp AND 
									idexaimage  = $idexaimage";
				break;

			case 69:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT idexafirma, descripcion_firma, firma, is_default_firma, status_exa_firma
							FROM exa_firmas_email
							WHERE idemp = $idemp And
									status_exa_firma = 1";
				break;

			case 70:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT *
							FROM exa_firmas_email
							WHERE idemp = $idemp AND 
									idexafirma  = $idexafirma";
				break;

			case 71:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$idusr = $this->getIdUserFromAlias($u);

				$query = "SELECT idexafirma, descripcion_firma, firma
							FROM exa_firmas_email
							WHERE idemp = $idemp And
									status_exa_firma = 1 AND 
									creado_por = $idusr ";

				break;

			case 72:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$query = "	SELECT *
							FROM _viEdoCtaFamilia 
							WHERE idemp = $idemp 
								AND idciclo = $idciclo 
								AND idfamilia = $idfamilia
							ORDER BY idedocta ASC 
							LIMIT 1	
							";
				break;

			case 73:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$clave_nivel = intval($clave_nivel);
				if ($clave_nivel > -1){
					$query = "SELECT *
							FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND clave_nivel = $clave_nivel AND idemp = $idemp AND activo_en_caja = 1 AND status_grualu = 1
							ORDER BY idgrupo, num_lista ASC ";
					}else{
						$query = "SELECT *
								FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND idemp = $idemp AND activo_en_caja = 1 AND status_grualu = 1
								ORDER BY clave_nivel, idgrupo, num_lista ASC ";
					}		
				break;

			case 74:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$clave_nivel = intval($clave_nivel);
				if ($clave_nivel > -1){
					$query = "SELECT *
							FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND clave_nivel = $clave_nivel AND idgrupo = $idgrupo AND idemp = $idemp AND status_grualu = 1
							ORDER BY num_lista ASC ";
				}else{
					$query = "SELECT *
							FROM _viGrupo_Alumnos WHERE idciclo = $idciclo AND idgrupo = $idgrupo AND idemp = $idemp AND status_grualu = 1
							ORDER BY num_lista ASC ";
				}
				break;

			case 75:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);		
		        $idciclo = $this->getCicloFromIdEmp($idemp);	
		        $sts = intval($status0);
		        switch ($sts) {
		        		case 0:
		        			$csts = ' ';
		        			break;
		        		case 1:
		        			$csts = ' AND status_movto = 1';
		        			break;
		        		case 2:
		        			$csts = ' AND status_movto = 0';
		        			break;
		        	}	
		        	// AND deuda_anterior = 0
				$query = "SELECT * 
								FROM _viEdosCta
							WHERE 
								idfamilia = $idfamilia AND 
								idalumno = $idalumno AND 
								idciclo = $idciclo AND 
								idemp = $idemp AND 
								idconcepto = $idconcepto
								$csts
							$otros ";
				break;

			case 76:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT iduserconceptoescenario, escenario
							FROM usuarios_conceptos_escenarios
							WHERE idemp = $idemp AND 
								status_usuario_concepto_escenario = 1 ";

				break;

			case 77:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT idusuarioconceptopago, concepto
							FROM _viUsersConceptosPagos
							WHERE  
								iduser = $idusuario AND 
								iduserconceptoescenario = $escenario AND 
								idemp = $idemp 
							ORDER BY nombre_completo_usuario ASC";

				break;


	  	}
		$result = $this->getArray($query);
		return $result;	
	}

	public function setAsocia($tipo=0,$arg="",$pag=0,$limite=0,$var2=0, $otros=""){

		$query="";
		$vRet = "Error";

		$ip=$_SERVER['REMOTE_ADDR']; 
		$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);

		switch ($tipo){
		case 51:
			switch($var2){
				case 10:
					parse_str($arg);
					parse_str($otros);
					$iduser = $this->getIdUserFromAlias($u);
					$idemp = $this->getIdEmpFromAlias($u);

		  			$ar = explode("|",$dests);
					foreach($ar AS $i=>$valor){
						if ((int)($ar[$i])>0){
							$query = "INSERT INTO pase_salida_alumnos(idpsa,idalumno,idciclo,clave_nivel,idgrupo,idemp,ip,host,creado_por,creado_el)
																VALUES($idpsa,$ar[$i],$idciclo,$clave_nivel,$idgrupo,$idemp,'$ip','$host',$iduser,NOW())";
							$vRet = $this->guardarDatos($query);
						}
					}
					break;		
				case 20:
					parse_str($arg);
		  			$ar = explode("|",$dests);
					foreach($ar AS $i=>$valor){
						if ((int)($ar[$i])>0){
							$query = "DELETE FROM pase_salida_alumnos WHERE idpsaalumno = ".$ar[$i];
							$vRet = $this->guardarDatos($query);
						}
					}
					break;		
			}
			break;

		case 52:
			switch($var2){
				case 10:
					parse_str($arg);
					parse_str($otros);
					$iduser = $this->getIdUserFromAlias($u);
					$idemp = $this->getIdEmpFromAlias($u);

		  			$ar = explode("|",$IdConceptos);
					foreach($ar AS $i=>$valor){
						if ((int)($ar[$i])>0){
							$query = "INSERT INTO usuarios_conceptos_pago(
														iduser,
														idconcepto,
														iduserconceptoescenario
														,idemp,ip,host,creado_por,creado_el)
												VALUES(
													$IdUsuario,
													$ar[$i],
													$escenario,
													$idemp,'$ip','$host',$iduser,NOW())";
							$vRet = $this->guardarDatos($query);
						}
					}
					break;		
				case 20:
					parse_str($arg);
		  			$ar = explode("|",$IdConceptos);
					foreach($ar AS $i=>$valor){
						if ((int)($ar[$i])>0){
							$query = "DELETE FROM usuarios_conceptos_pago WHERE idusuarioconceptopago = ".$ar[$i];
							$vRet = $this->guardarDatos($query);
						}
					}
					break;		
			}
			break;
		}

	}

	public function saveDataPDO($index=0,$arg="",$pag=0,$limite=0,$tipo=0,$cadena2=""){
	  	$query="";
		$vRet = "Error";

	  	$ip=$_SERVER['REMOTE_ADDR']; 
	  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);

		switch ($index){
			case 19:
				switch($tipo){
					case 1:
				
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($user);

						$arrIdPAIID   = explode('|', $IdPAIID);
						$arrIdPAICRIT = explode('|', $IdPAICRIT);
						$arrIdPAICAL  = explode('|', $IdPAICAL);
						$arrNUMCRIT   = explode('|', $NUMCRIT);

						$num_eval = intval($num_eval_capcal_fmt_0);
						$num_eval = $num_eval;
						// $num_eval--; 

						for ($i=0; $i < count($arrIdPAIID); $i++) {
							
							$ec0 = "eval_".$num_eval."_".$arrNUMCRIT[$i]."_idcriterio";		 
							$ev0 = "eval_".$num_eval."_".$arrNUMCRIT[$i];		 
							$rc0 = "eval_".$num_eval."_".$arrNUMCRIT[$i]."_rc";	

							$rc1 = $this->defineRangoEvaluacionPAI($arrIdPAICAL[$i]);

							$vRet = "OK";

							$query = "UPDATE boleta_paibi SET 	
															".$ec0." = ".$arrIdPAICRIT[$i].",
															".$ev0." = ".$arrIdPAICAL[$i].",
															".$rc0." = ".$rc1.",
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idboletapaibi = ".$arrIdPAIID[$i];
									$vRet = $this->guardarDatos($query);
						}					
						break;		
				}
				break;

			case 46: //46
				switch($tipo){
					case 1:
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);
						$idciclo = $this->getCicloFromIdEmp($idemp);		        

						$c0 = explode('|', $cal0);
						$c1 = explode('|', $cal1);

						$o1 = explode('|', $obs1);

						for ($i=0; $i < count($c0); $i++) { 
							$query = "UPDATE boleta_partes_markbook SET 	
															calificacion = ".floatval($c1[$i]).",
															observaciones = '".$o1[$i]."',
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idbolparmkb = ".intval($c0[$i]);
							$vRet = $this->guardarDatos($query);
						}					
						break;		
				} //46
				break;

			case 47: //47
				switch($tipo){
					case 0:
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);
						$idciclo = $this->getCicloFromIdEmp($idemp);		        

						$c0 = explode('|', $cal0);
						$c1 = explode('|', $cal1);

						$o1 = explode('|', $obs1);

						for ($i=0; $i < count($c0); $i++) { 
							$query = "INSERT INTO boleta_asistencias(
																	idboleta,
																	asistencia,
																	observaciones,
																	fecha,
																	evaluacion,
																	idemp,
																	ip,
																	host,
																	creado_por,
																	creado_el)
															VALUES(
																	".$c0[$i].",
																	".$c1[$i].",
																	'".mb_strtoupper($o1[$i],'UTF-8')."',
																	'".$fecha."',
																	$evaluacion,
																	$idemp,
																	'$ip',
																	'$host',
																	$idusr,
																	NOW())" ;
							$vRet = $this->guardarDatos($query);
						}					
						break;		

					case 1:
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);
						$idciclo = $this->getCicloFromIdEmp($idemp);		        

						$c0 = explode('|', $cal0);
						$c1 = explode('|', $cal1);

						$o1 = explode('|', $obs1);

						for ($i=0; $i < count($c0); $i++) { 
							$query = "UPDATE boleta_asistencias SET 	
															asistencia = ".floatval($c1[$i]).",
															observaciones = '".$o1[$i]."',
															evaluacion = $evaluacion,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idbolasist = ".intval($c0[$i]);
							$vRet = $this->guardarDatos($query);
						}					
						break;		

					case 2:
						parse_str($arg);

						$c0 = explode('|', $cal0);

						for ($i=0; $i < count($c0); $i++) { 
							$query = "DELETE FROM boleta_asistencias WHERE idbolasist = ".intval($c0[$i]);
							$vRet = $this->guardarDatos($query);
						}					
						break;		

				} //47
				break;

			case 49: //49
				switch($tipo){
					case 0:
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);
				        $IsConnect = $this->IsExistUserConnect($idusr,$idemp);
				        if (intval($IsConnect) <= 0){
							$query = "INSERT INTO usuarios_conectados(
															iduser,
															username,
															isconectado,
															ultima_conexion,
															idemp,
															ip,
															host,
															creado_por,
															creado_el)
													VALUES(
															$idusr,
															'$u',
															1,
															NOW(),
															$idemp,
															'$ip',
															'$host',
															$idusr,
															NOW() )" ;
							$vRet = $this->guardarDatos($query);

						}else{
					        $IsConnect = $this->IsConnectUser($idusr,$idemp);
					        if (intval($IsConnect) <= 0){
								$query = "UPDATE usuarios_conectados SET 	
																isconectado = 1,
																ultima_conexion = NOW(),
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										WHERE iduser = $idusr AND idemp = $idemp AND isconectado = 0";
								$vRet = $this->guardarDatos($query);
							}else{
								$vRet = "OK";
							}
						}
						break;
					case 1:
						parse_str($arg);

						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);
				        $IsConnect = $this->IsConnectUser($idusr,$idemp);
				        if (intval($IsConnect) > 0){
							$query = "UPDATE usuarios_conectados SET 	
															isconectado = 0,
															ultima_conexion = NOW(),
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE iduser = $idusr AND idemp = $idemp AND isconectado = 1";
							$vRet = $this->guardarDatos($query);
						}else{
							$vRet = "OK";
						}	
						break;	
				} //49
				break;

			case 50: //50
				switch($tipo){
					case 0:
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);

						$fi = explode('-',$fecha_inicio_eval_1);
						$fi1 = $fi[2].'-'.$fi[1].'-'.$fi[0];
						$ff = explode('-',$fecha_fin_eval_1);
						$ff1 = $ff[2].'-'.$ff[1].'-'.$ff[0];

						$fi = explode('-',$fecha_inicio_eval_2);
						$fi2 = $fi[2].'-'.$fi[1].'-'.$fi[0];
						$ff = explode('-',$fecha_fin_eval_2);
						$ff2 = $ff[2].'-'.$ff[1].'-'.$ff[0];

						$fi = explode('-',$fecha_inicio_eval_3);
						$fi3 = $fi[2].'-'.$fi[1].'-'.$fi[0];
						$ff = explode('-',$fecha_fin_eval_3);
						$ff3 = $ff[2].'-'.$ff[1].'-'.$ff[0];

						$fi = explode('-',$fecha_inicio_eval_4);
						$fi4 = $fi[2].'-'.$fi[1].'-'.$fi[0];
						$ff = explode('-',$fecha_fin_eval_4);
						$ff4 = $ff[2].'-'.$ff[1].'-'.$ff[0];

						$fi = explode('-',$fecha_inicio_eval_5);
						$fi5 = $fi[2].'-'.$fi[1].'-'.$fi[0];
						$ff = explode('-',$fecha_fin_eval_5);
						$ff5 = $ff[2].'-'.$ff[1].'-'.$ff[0];

						$fi = explode('-',$fecha_inicio_eval_6);
						$fi6 = $fi[2].'-'.$fi[1].'-'.$fi[0];
						$ff = explode('-',$fecha_fin_eval_6);
						$ff6 = $ff[2].'-'.$ff[1].'-'.$ff[0];

						$fi = explode('-',$fecha_inicio_eval_7);
						$fi7 = $fi[2].'-'.$fi[1].'-'.$fi[0];
						$ff = explode('-',$fecha_fin_eval_7);
						$ff7 = $ff[2].'-'.$ff[1].'-'.$ff[0];

						$fi = explode('-',$fecha_inicio_eval_8);
						$fi8 = $fi[2].'-'.$fi[1].'-'.$fi[0];
						$ff = explode('-',$fecha_fin_eval_8);
						$ff8 = $ff[2].'-'.$ff[1].'-'.$ff[0];

						$query = "INSERT INTO evaluaciones_config(
																idnivel,
																idciclo,
																periodo,
																eval_1,
																fecha_inicio_eval_1,
																fecha_fin_eval_1,
																eval_2,
																fecha_inicio_eval_2,
																fecha_fin_eval_2,
																eval_3,
																fecha_inicio_eval_3,
																fecha_fin_eval_3,
																eval_4,
																fecha_inicio_eval_4,
																fecha_fin_eval_4,
																eval_5,
																fecha_inicio_eval_5,
																fecha_fin_eval_5,
																eval_6,
																fecha_inicio_eval_6,
																fecha_fin_eval_6,
																eval_7,
																fecha_inicio_eval_7,
																fecha_fin_eval_7,
																eval_8,
																fecha_inicio_eval_8,
																fecha_fin_eval_8,
																idemp,
																ip,
																host,
																creado_por,
																creado_el)
														VALUES(
																$idnivel,
																$idciclo,
																$periodo,
																'$eval_1',
																'$fi1',
																'$ff1',
																'$eval_2',
																'$fi2',
																'$ff2',
																'$eval_3',
																'$fi3',
																'$ff3',
																'$eval_4',
																'$fi4',
																'$ff4',
																'$eval_5',
																'$fi5',
																'$ff5',
																'$eval_6',
																'$fi6',
																'$ff6',
																'$eval_7',
																'$fi7',
																'$ff7',
																'$eval_8',
																'$fi8',
																'$ff8',
																$idemp,
																'$ip',
																'$host',
																$idusr,
																NOW())" ;
						$vRet = $this->guardarDatos($query);
						break;		
					case 1:
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);

						$fecha_inicio_eval_1 = $fecha_inicio_eval_1 == '' ? '0000-00-00' : $fecha_inicio_eval_1;
						$fecha_inicio_eval_2 = $fecha_inicio_eval_2 == '' ? '0000-00-00' : $fecha_inicio_eval_2;
						$fecha_inicio_eval_3 = $fecha_inicio_eval_3 == '' ? '0000-00-00' : $fecha_inicio_eval_3;
						$fecha_inicio_eval_4 = $fecha_inicio_eval_4 == '' ? '0000-00-00' : $fecha_inicio_eval_4;
						$fecha_inicio_eval_5 = $fecha_inicio_eval_5 == '' ? '0000-00-00' : $fecha_inicio_eval_5;
						$fecha_inicio_eval_6 = $fecha_inicio_eval_6 == '' ? '0000-00-00' : $fecha_inicio_eval_6;
						$fecha_inicio_eval_7 = $fecha_inicio_eval_7 == '' ? '0000-00-00' : $fecha_inicio_eval_7;
						$fecha_inicio_eval_8 = $fecha_inicio_eval_8 == '' ? '0000-00-00' : $fecha_inicio_eval_8;

						$fecha_fin_eval_1 = $fecha_fin_eval_1 == '' ? '0000-00-00' : $fecha_fin_eval_1;
						$fecha_fin_eval_2 = $fecha_fin_eval_2 == '' ? '0000-00-00' : $fecha_fin_eval_2;
						$fecha_fin_eval_3 = $fecha_fin_eval_3 == '' ? '0000-00-00' : $fecha_fin_eval_3;
						$fecha_fin_eval_4 = $fecha_fin_eval_4 == '' ? '0000-00-00' : $fecha_fin_eval_4;
						$fecha_fin_eval_5 = $fecha_fin_eval_5 == '' ? '0000-00-00' : $fecha_fin_eval_5;
						$fecha_fin_eval_6 = $fecha_fin_eval_6 == '' ? '0000-00-00' : $fecha_fin_eval_6;
						$fecha_fin_eval_7 = $fecha_fin_eval_7 == '' ? '0000-00-00' : $fecha_fin_eval_7;
						$fecha_fin_eval_8 = $fecha_fin_eval_7 == '' ? '0000-00-00' : $fecha_fin_eval_8;

						$query = "UPDATE evaluaciones_config SET 	
														idnivel = $idnivel,
														idciclo = $idciclo,
														periodo = $periodo,
														eval_1 = '$eval_1',
														fecha_inicio_eval_1 = '$fecha_inicio_eval_1',
														fecha_fin_eval_1 = '$fecha_fin_eval_1',
														eval_2 = '$eval_2',
														fecha_inicio_eval_2 = '$fecha_inicio_eval_2',
														fecha_fin_eval_2 = '$fecha_fin_eval_2',
														eval_3 = '$eval_3',
														fecha_inicio_eval_3 = '$fecha_inicio_eval_3',
														fecha_fin_eval_3 = '$fecha_fin_eval_3',
														eval_4 = '$eval_4',
														fecha_inicio_eval_4 = '$fecha_inicio_eval_4',
														fecha_fin_eval_4 = '$fecha_fin_eval_4',
														eval_5 = '$eval_5',
														fecha_inicio_eval_5 = '$fecha_inicio_eval_5',
														fecha_fin_eval_5 = '$fecha_fin_eval_5',
														eval_6 = '$eval_6',
														fecha_inicio_eval_6 = '$fecha_inicio_eval_6',
														fecha_fin_eval_6 = '$fecha_fin_eval_6',
														eval_7 = '$eval_7',
														fecha_inicio_eval_7 = '$fecha_inicio_eval_7',
														fecha_fin_eval_7 = '$fecha_fin_eval_7',
														eval_8 = '$eval_8',
														fecha_inicio_eval_8 = '$fecha_inicio_eval_8',
														fecha_fin_eval_8 = '$fecha_fin_eval_8',
														ip = '$ip', 
														host = '$host',
														modi_por = $idusr, 
														modi_el = NOW()
								WHERE idevalconfig = $idevalconfig";
						$vRet = $this->guardarDatos($query);
						break;		
					case 2:
						$query = "DELETE FROM evaluaciones_config WHERE idevalconfig = ".$arg;
						$vRet = $this->guardarDatos($query);
						break;		
				} //50
				break;

				case 51:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);
							$query = "INSERT INTO pases_salida(
																referencia,
																fecha,
																motivos,
																otro_motivo,
																idautorizo,
																comentario,
																regreso,
																otro_regreso,
																recoge,
																otro_recoge,
																idciclo,
																idgrupo,
																clave_nivel,
																status_psa,
																idemp,ip,host,creado_por,creado_el)
										VALUES(
																'$referencia',
																NOW(),
																'$motivos',
																'$otro_motivo',
																$idautorizo,
																'$comentario',
																'$regreso',
																'$otro_regreso',
																'$recoge',
																'$otro_recoge',
																$idciclo,
																$idgrupo,
																$clave_nivel,
																$status_psa,
																$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$query = "UPDATE pases_salida SET 	
														  	referencia = '$referencia',
														  	motivos = '$motivos',
														  	otro_motivo = '$otro_motivo',
														  	idautorizo = $idautorizo,
														  	comentario = '$comentario',
														  	regreso = '$regreso',
														  	otro_regreso = '$otro_regreso',
														  	recoge = '$recoge',
														  	otro_recoge = '$otro_recoge',
														  	status_psa = $status_psa,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idpsa = $idpsa";
							$vRet = $this->guardarDatos($query);
							break;		
						case 2:
							$query = "DELETE FROM pases_salida WHERE idpsa = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					} // 51
					break;


				case 52:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);
							$avisar_caja = !isset($avisar_caja)?0:1;
							$fn = explode('-',$fecha);
							$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

							$query = "INSERT INTO familia_convenios(
												idfamilia,
												convenio,
												responsable,
												fecha,
												avisar_caja,
												idemp,ip,host,creado_por,creado_el)
										VALUES(
												$idfamilia2,
												'$convenio',
												'$responsable',
												'$fn',
												$avisar_caja,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);
							$avisar_caja = !isset($avisar_caja)?0:1;
							$fn = explode('-',$fecha);
							$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

							$query = "UPDATE familia_convenios SET 	
										  	convenio = '$convenio',
										  	responsable = '$responsable',
										  	fecha = '$fn',
										  	avisar_caja = $avisar_caja,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									WHERE idfamconv = $idfamconv";
							$vRet = $this->guardarDatos($query);
							break;	

						case 2:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($u);
							$idemp = $this->getIdEmpFromAlias($u);

							$query = "DELETE FROM familia_convenios WHERE idfamconv = ".$idfamconv;
							$vRet = $this->guardarDatos($query);
							break;		
					} // 52
					break;
				case 53:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$query = "INSERT INTO cat_emergencias(
												nombre,
												tel1,
												parentezco,
												status_emergencia,
												idemp,ip,host,creado_por,creado_el)
										VALUES(
												'$nombre',
												'$tel1',
												'$parentezco',
												$status_emergencia,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$query = "UPDATE cat_emergencias SET 	
										  	nombre = '$nombre',
										  	tel1 = '$tel1',
										  	parentezco = '$parentezco',
										  	status_emergencia = $status_emergencia,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									WHERE idemergencia = $idemergencia";
							$vRet = $this->guardarDatos($query);
							break;	

						case 2:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($u);
							$idemp = $this->getIdEmpFromAlias($u);

							$query = "DELETE FROM cat_emergencias WHERE idemergencia = ".$idemergencia;
							$vRet = $this->guardarDatos($query);
							break;		

						case 3:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);
							$predeterminado = !isset($predeterminado)?0:1;	
							$query = "INSERT INTO emergencias_alumno(
															idemergencia,
															idalumno,
															predeterminado,
															idemp,ip,host,creado_por,creado_el)
														VALUES(
															$idemergencia,
															$idalumno,
															$predeterminado,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
							
						case 4:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$predeterminado = !isset($predeterminado)?0:1;	

							$query = "UPDATE emergencias_alumno SET 	
															idemergencia = $idemergencia,
															idalumno = $idalumno,
															predeterminado = $predeterminado,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idemeralu = $idemeralu ";
							$vRet = $this->guardarDatos($query);
							break;		
						case 5:
							$query = "DELETE FROM emergencias_alumno WHERE idemeralu = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;	
					} // 53
					break;

				case 55:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
					        $idemp = $this->getIdEmpFromAlias($user);
							$idciclo = $this->getCicloFromIdEmp($idemp);		        
							$isitem = !isset($isitem)?0:1;	

							$query = "INSERT INTO grupo_materia_config_save(
												idprofesor,
												idgrumat,
												titulo,
												isitem,
												num_eval,
												idciclo,
												idemp,ip,host,creado_por,creado_el)
										VALUES(
												$idusr,
												$idgrumat,
												'$titulo',
												$isitem,
												$num_eval,
												$idciclo,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$isitem = !isset($isitem)?0:1;	

							$query = "UPDATE grupo_materia_config_save SET 	
										  	titulo = '$titulo',
										  	isitem = $isitem,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									WHERE 	idmatconsave = $idmatconsave";
							$vRet = $this->guardarDatos($query);
							break;	

						case 2:

							$query = "DELETE FROM grupo_materia_config_save WHERE idmatconsave = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		

					} // 55
					break;

				case 56:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
					        $idemp = $this->getIdEmpFromAlias($user);
							$idciclo = $this->getCicloFromIdEmp($idemp);		        

							$qry = "SELECT iddevice AS IDs FROM cat_devices WHERE iduser = $idusr AND device_token = '$device_token' AND idemp = $idemp LIMIT 1";							
							$result23 = $this->getArray($qry);
							
							if (!$result23) {
								
								$query = "UPDATE cat_devices SET 	
											  	status_device = 0
										WHERE 	iduser = ".$idusr." AND type = " . $tD ;
								$result = $this->guardarDatos($query);

								$query = "INSERT INTO cat_devices(
													iduser,
													UUID,
													device_token,
													type,
													idciclo,
													idemp,ip,host,creado_por,creado_el)
											VALUES(
													$idusr,
													'$UUID',
													'$device_token',
													'$tD',
													$idciclo,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);

							}else{
								$IDs = $result23[0]->IDs;

								$query = "UPDATE cat_devices SET 	
											  	status_device = 0
										WHERE 	iduser = ".$idusr." AND type = " . $tD ;
								$result = $this->guardarDatos($query);

								$query = "UPDATE cat_devices SET 	
											  	UUID = '$UUID',
											  	device_token = '$device_token',
											  	iduser = $idusr,
											  	status_device = 1,
											  	type = $tD,
												ip = '$ip', 
												host = '$host',
												modi_por = $idusr, 
												modi_el = NOW()
										WHERE 	iddevice = ".$IDs;
								$vRet = $this->guardarDatos($query);
							}
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);

							$query = "UPDATE cat_devices SET 	
										  	UUID = '$UUID',
										  	device_token = '$device_token',
										  	idsuer = $idusr,
										  	type = '$tD',
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									WHERE 	iddevice = $iddevice";
							$vRet = $this->guardarDatos($query);
							break;	
						case 2:

							$query = "DELETE FROM cat_devices WHERE iddevice = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;	

						case 3:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
					        $idemp = $this->getIdEmpFromAlias($user);
								
							$query = "INSERT INTO mobil_mensaje(
												iddevice,
												titulo,
												mensaje,
												fecha,
												from_module,
												idremitente,
												idemp,ip,host,creado_por,creado_el)
										VALUES(
												$iddevice,
												'$titulo',
												'$mensaje',
												NOW(),
												'$from_module',
												$idusr,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 4:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
					        $idemp = $this->getIdEmpFromAlias($user);
							$idciclo = $this->getCicloFromIdEmp($idemp);		        
							$qry = "SELECT iddevice AS IDs FROM cat_devices WHERE iduser = $idusr AND UUID = '$UUID' AND idemp = $idemp LIMIT 1";
							$result23 = $this->getArray($qry);
							
							if (!$result23) {
								
								$query = "UPDATE cat_devices SET 	
											  	status_device = 0
										WHERE 	iduser = ".$idusr." AND type = " . $tD ;
								$result = $this->guardarDatos($query);

								$query = "INSERT INTO cat_devices(
													iduser,
													UUID,
													device_token,
													type,
													idciclo,
													idemp,ip,host,creado_por,creado_el)
											VALUES(
													$idusr,
													'$UUID',
													'$device_token',
													'$tD',
													$idciclo,
													$idemp,'$ip','$host',$idusr,NOW())";
								$vRet = $this->guardarDatos($query);

							}else{
								$IDs = $result23[0]->IDs;

								$query = "UPDATE cat_devices SET 	
											  	status_device = 0
										WHERE 	iduser = ".$idusr." AND type = " . $tD ;
								$result = $this->guardarDatos($query);

								$query3 = "UPDATE cat_devices 
												SET device_token = '$device_token',
													status_device = 1
											WHERE iddevice = $IDs";
								$vRet = $this->guardarDatos($query3);
							}
							break;	
					} // 56
					break;
				case 57:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
					        $idemp = $this->getIdEmpFromAlias($user);
							$idciclo = $this->getCicloFromIdEmp($idemp);		        
							$status_pdf = !isset($status_pdf)?0:1;

							$query = "INSERT INTO cat_pdfs(
												idnivel,
												pdf,
												ruta,
												fecha,
												idciclo,
												categoria_pdf,
												status_pdf,
												idemp,ip,host,creado_por,creado_el)
										VALUES(
												$idnivel,
												'$pdf',
												'$ruta',
												NOW(),
												$idciclo,
												$categoria_pdf,
												$status_pdf,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$status_pdf = !isset($status_pdf)?0:1;

							$query = "UPDATE cat_pdfs SET 	
										  	pdf = '$pdf',
										  	idnivel = $idnivel,
										  	status_pdf = $status_pdf,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									WHERE 	idpdf = $idpdf";
							$vRet = $this->guardarDatos($query);
							break;	

						case 2:

							$qry = "SELECT ruta FROM cat_pdfs WHERE idpdf = ".$arg;							
							$rt = $this->getArray($qry);
							unlink("../../".$rt[0]->ruta);

							$query = "DELETE FROM cat_pdfs WHERE idpdf = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					} // 57
					break;
				case 58:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
					        $idemp = $this->getIdEmpFromAlias($user);
							$idciclo = $this->getCicloFromIdEmp($idemp);		        

							$query = "INSERT INTO cat_beneficios_giros(
												girobeneficio,
												status_giro_beneficio,
												idemp,ip,host,creado_por,creado_el)
										VALUES(
												'$girobeneficio',
												$status_giro_beneficio,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$status_giro_beneficio = !isset($status_giro_beneficio)?0:1;

							$query = "UPDATE cat_beneficios_giros SET 	
										  	girobeneficio = '$girobeneficio',
										  	status_giro_beneficio = $status_giro_beneficio,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									WHERE 	idgirobeneficio = $idgirobeneficio";
							$vRet = $this->guardarDatos($query);
							break;	

						case 2:

							$query = "DELETE FROM cat_beneficios_giros WHERE idgirobeneficio = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					} // 58
					break;

				case 59:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
					        $idemp = $this->getIdEmpFromAlias($user);
							$idciclo = $this->getCicloFromIdEmp($idemp);		        
							$status_beneficio = !isset($status_beneficio)?0:1;

							$query = "INSERT INTO cat_beneficios_afiliados(
												idgirobeneficio,
												empresa,
												descuento,
												telefonos,
												emails,
												web,
												facebook,
												twitter,
												direccion1,
												direccion2,
												direccion3,
												direccion4,
												imagen,
												status_beneficio,
												idemp,ip,host,creado_por,creado_el)
										VALUES(
												$idgirobeneficio,
												'$empresa',
												'$descuento',
												'$telefonos',
												'$emails',
												'$web',
												'$facebook',
												'$twitter',
												'$direccion1',
												'$direccion2',
												'$direccion3',
												'$direccion4',
												'$imagen',
												$status_beneficio,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$status_beneficio = !isset($status_beneficio)?0:1;

							$query = "UPDATE cat_beneficios_afiliados SET 	
										  	empresa = '$empresa',
										  	idgirobeneficio = $idgirobeneficio,
										  	descuento = '$descuento',
										  	telefonos = '$telefonos',
										  	emails = '$emails',
										  	web = '$web',
										  	facebook = '$facebook',
										  	twitter = '$twitter',
										  	direccion1 = '$direccion1',
										  	direccion2 = '$direccion2',
										  	direccion3 = '$direccion3',
										  	direccion4 = '$direccion4',
										  	status_beneficio = $status_beneficio,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									WHERE 	idbeneficio = $idbeneficio";
							$vRet = $this->guardarDatos($query);
							break;	
						case 2:

							$qry = "SELECT imagen FROM cat_beneficios_afiliados WHERE idbeneficio = ".$arg;							
							$rt = $this->getArray($qry);
							unlink("../../".$rt[0]->imagen);

							$query = "DELETE FROM cat_beneficios_afiliados WHERE idbeneficio = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					} // 59
					break;

				case 60:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$fn = explode('-',$fecha_nacimiento);
							$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

							$isfam = !isset($isfam)?0:1;
							$status_exalumno = !isset($status_exalumno)?0:1;

							$num_hijos = !isset($num_hijos)?0:intval($num_hijos);

							$query = "INSERT INTO cat_exalumnos(
															ap_paterno,
															ap_materno,
															nombre,
															email,
															direccion,
															telefono,
															extension,
															celular,
															fecha_nacimiento,
															genero,
															profesion,
															ocupacion,
															facebook,
															twitter,
															instagram,
															isfam,
															num_hijos,
															idgeneracion,
															status_exalumno,
															idemp,ip,host,creado_por,creado_el)
										VALUES(
															'$ap_paterno',
															'$ap_materno',
															'$nombre',
															'$email',
															'$direccion',
															'$telefono',
															'$extension',
															'$celular',
															'$fn',
															$genero,
															'$profesion',
															'$ocupacion',
															'$facebook',
															'$twitter',
															'$instagram',
															$isfam,
															$num_hijos,
															$idgeneracion,
															$status_exalumno,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);

							$fn = explode('-',$fecha_nacimiento);
							$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

							$isfam = !isset($isfam)?0:1;
							$status_exalumno = !isset($status_exalumno)?0:1;

							$query = "UPDATE cat_exalumnos SET 	
															ap_paterno 		= '$ap_paterno',
															ap_materno 		= '$ap_materno',
															nombre 			= '$nombre',
															email 			= '$email',
															fecha_nacimiento = '$fn',
															genero 			= $genero,
															direccion 		= '$direccion',
															telefono 		= '$telefono',
															extension 		= '$extension',
															celular 		= '$celular',
															profesion 		= '$profesion',
															ocupacion 		= '$ocupacion',
															facebook		= '$facebook',
															twitter			= '$twitter',
															instagram		= '$instagram',
															num_hijos       = $num_hijos,
															isfam           = $isfam,
															idgeneracion    = $idgeneracion,
															status_exalumno = $status_exalumno,
															ip 				= '$ip', 
															host 			= '$host',
															modi_por 		= $idusr, 
															modi_el 		= NOW()
									WHERE idexalumno = $idexalumno";
							$vRet = $this->guardarDatos($query);
							break;		
						case 2:
							$query = "DELETE FROM cat_exalumnos WHERE idexalumno = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		

						case 3:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$query = "INSERT INTO exa_emails_enviados(
															para,
															cco,
															titulo,
															cuerpo,
															iddestinatarios,
															idexafirma,
															status_emails_enviados,
															idemp,ip,host,creado_por,creado_el)
										VALUES(
															'$para',
															'$cco',
															'$titulo',
															'$cuerpo',
															'$iddestinatarios',
															$idexafirma,
															1,
												$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		

						case 4:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$query = "UPDATE exa_emails_enviados SET 	
															para 		= '$para',
															cco 		= '$cco',
															titulo 		= '$titulo',
															cuerpo 			= '$cuerpo',
															iddestinatarios = '$iddestinatarios',
															idexafirma = $idexafirma,
															ip 				= '$ip', 
															host 			= '$host',
															modi_por 		= $idusr, 
															modi_el 		= NOW()
									WHERE idexaemailenviado = $idexaemailenviado";
							$vRet = $this->guardarDatos($query);
							break;		

						case 5:
							$query = "DELETE FROM exa_emails_enviados WHERE idexaemailenviado = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					} //60	
					break; 

				case 61:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_generacion = isset($status_generacion)?1:0;

							$query = "INSERT INTO exa_generaciones(
																generacion,
																status_generacion,
																idemp,ip,host,creado_por,creado_el)
										VALUES(
																'$generacion',
																$status_generacion,
																$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_generacion = isset($status_generacion)?1:0;

							$query = "UPDATE exa_generaciones SET 	
															generacion     = '$generacion',
													  		status_generacion = $status_generacion,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idgeneracion = $idgeneracion";
							$vRet = $this->guardarDatos($query);
							if ( $vRet == "OK" ){
								if ( isset($predeterminado) ) {
									$q0 = "UPDATE exa_generaciones SET predeterminado = 0 WHERE idemp = $idemp AND predeterminado = 1";
									$result = $this->getArray($q0);
									$q1 = "UPDATE exa_generaciones SET predeterminado = 1 WHERE idgeneracion = $idgeneracion";
									$result = $this->getArray($q1);
								}
							}
							break;		
						case 2:
							$query = "DELETE FROM exa_generaciones WHERE idgeneracion = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					}
					break; // 61
				case 62:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_pai_criterio = isset($status_pai_criterio)?1:0;

							$query = "INSERT INTO cat_pai_criterios(
																criterio,
																descripcion_criterio,
																status_pai_criterio,
																idemp,ip,host,creado_por,creado_el)
										VALUES(
																'$criterio',
																'$descripcion_criterio',
																$status_pai_criterio,
																$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_pai_criterio = isset($status_pai_criterio)?1:0;

							$query = "UPDATE cat_pai_criterios SET 	
															criterio     = '$criterio',
															descripcion_criterio = '$descripcion_criterio',
													  		status_pai_criterio = $status_pai_criterio,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idpaicriterio = $idpaicriterio";
							$vRet = $this->guardarDatos($query);
							break;		
						case 2:
							$query = "DELETE FROM cat_pai_criterios WHERE idpaicriterio = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					}
					break; // 62
				case 63:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_area_disciplinaria = isset($status_area_disciplinaria)?1:0;

							$query = "INSERT INTO cat_pai_areas_disciplinarias(
																area_disciplinaria,
																orden_impresion,
																status_area_disciplinaria,
																idemp,ip,host,creado_por,creado_el)
										VALUES(
																'$area_disciplinaria',
																$orden_impresion,
																$status_area_disciplinaria,
																$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_area_disciplinaria = isset($status_area_disciplinaria)?1:0;

							$query = "UPDATE cat_pai_areas_disciplinarias SET 	
															area_disciplinaria = '$area_disciplinaria',
															orden_impresion = $orden_impresion,
													  		status_area_disciplinaria = $status_area_disciplinaria,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idpaiareadisciplinaria = $idpaiareadisciplinaria";
							$vRet = $this->guardarDatos($query);
							break;		
						case 2:
							$query = "DELETE FROM cat_pai_areas_disciplinarias WHERE idpai = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					}
					break; // 63
				case 64:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_pai_concepto = isset($status_pai_concepto)?1:0;

							$query = "INSERT INTO pai_conceptos(
																concepto,
																idpaiareadisciplinaria,
																idpaicriterio,
																rango_califica,
																grado_pai,
																status_pai_concepto,
																idemp,ip,host,creado_por,creado_el)
										VALUES(
																'$concepto',
																$idpaiareadisciplinaria,
																$idpaicriterio,
																$rango_califica,
																$grado_pai,
																$status_pai_concepto,
																$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_pai_concepto = isset($status_pai_concepto)?1:0;

							$query = "UPDATE pai_conceptos SET 	
															concepto = '$concepto',
															idpaiareadisciplinaria = $idpaiareadisciplinaria,
															idpaicriterio = $idpaicriterio,
															rango_califica = $rango_califica,
															grado_pai = $grado_pai,
													  		status_pai_concepto = $status_pai_concepto,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idpaiconcepto = $idpaiconcepto";
							$vRet = $this->guardarDatos($query);
							break;		
						case 2:
							$query = "DELETE FROM pai_conceptos WHERE idpaiconcepto = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					}
					break; // 64
				case 65:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_pai_objetivo = isset($status_pai_objetivo)?1:0;

							$query = "INSERT INTO pai_objetivos(
																objetivo,
																idpaiareadisciplinaria,
																idpaicriterio,
																grado_pai,
																status_pai_objetivo,
																idemp,ip,host,creado_por,creado_el)
										VALUES(
																'$objetivo',
																$idpaiareadisciplinaria,
																$idpaicriterio,
																$grado_pai,
																$status_pai_objetivo,
																$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_pai_objetivo = isset($status_pai_objetivo)?1:0;

							$query = "UPDATE pai_objetivos SET 	
															objetivo = '$objetivo',
															idpaiareadisciplinaria = $idpaiareadisciplinaria,
															idpaicriterio = $idpaicriterio,
															grado_pai = $grado_pai,
													  		status_pai_objetivo = $status_pai_objetivo,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idpaiobjetivo = $idpaiobjetivo";
							$vRet = $this->guardarDatos($query);
							break;		
						case 2:
							$query = "DELETE FROM pai_objetivos WHERE idpaiobjetivo = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					}
					break; // 65

			case 66: //66
				switch($tipo){
					case 0:
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);

				        $status_fecha_vencimiento = isset($status_fecha_vencimiento)?1:0;

						$query = "INSERT INTO cat_listas_vencimientos(
																descripcion,
																v1,
																v2,
																v3,
																v4,
																v5,
																v6,
																v7,
																v8,
																v9,
																v10,
																v11,
																v12,
																status_fecha_vencimiento,
																idemp,
																ip,
																host,
																creado_por,
																creado_el)
														VALUES(
																'$descripcion',
																'$v1',
																'$v2',
																'$v3',
																'$v4',
																'$v5',
																'$v6',
																'$v7',
																'$v8',
																'$v9',
																'$v10',
																'$v11',
																'$v12',
																$status_fecha_vencimiento,
																$idemp,
																'$ip',
																'$host',
																$idusr,
																NOW())" ;
						$vRet = $this->guardarDatos($query);
						break;		
					case 1:
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);

				        $status_fecha_vencimiento = isset($status_fecha_vencimiento)?1:0;

						$query = "UPDATE cat_listas_vencimientos SET 	
														descripcion = '$descripcion',
														v1 = '$v1',
														v2 = '$v2',
														v3 = '$v3',
														v4 = '$v4',
														v5 = '$v5',
														v6 = '$v6',
														v7 = '$v7',
														v8 = '$v8',
														v9 = '$v9',
														v10 = '$v10',
														v11 = '$v11',
														v12 = '$v12',
														status_fecha_vencimiento = $status_fecha_vencimiento,
														ip = '$ip', 
														host = '$host',
														modi_por = $idusr, 
														modi_el = NOW()
								WHERE idlistavencimiento = $idlistavencimiento";
						$vRet = $this->guardarDatos($query);
						break;		
					case 2:
						$query = "DELETE FROM cat_listas_vencimientos WHERE idlistavencimiento = ".$arg;
						$vRet = $this->guardarDatos($query);
						break;		
				} //66
				break;

			case 68:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_exa_firma = isset($status_exa_firma)?1:0;
							$is_default_firma = isset($is_default_firma)?1:0;
							
							if ( $is_default_firma == 1 ){
								$query = "UPDATE exa_firmas_email  SET is_default_firma = 0 WHERE iduser = ".$idusr;
								$result = $this->guardarDatos($query);
							}	
							
							$query = "INSERT INTO exa_firmas_email(
															descripcion_firma,
															firma,
															iduser,
															is_default_firma,
															status_exa_firma,
															idemp,ip,host,creado_por,creado_el)
										VALUES(
															'$descripcion_firma',
															'$cuerpo',
															$idusr,
															$is_default_firma,
															$status_exa_firma,
															$idemp,'$ip','$host',$idusr,NOW())";
							$vRet = $this->guardarDatos($query);
							break;
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_exa_firma = isset($status_exa_firma)?1:0;
							$is_default_firma = isset($is_default_firma)?1:0;

							if ( $is_default_firma == 1 ){
								$query = "UPDATE exa_firmas_email  SET is_default_firma = 0 WHERE iduser = ".$idusr;
								$result = $this->guardarDatos($query);
							}	

							$query = "UPDATE exa_firmas_email SET 	
															descripcion_firma = '$descripcion_firma',
															firma = '$cuerpo',
													  		is_default_firma = $is_default_firma,
													  		status_exa_firma = $status_exa_firma,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									WHERE idexafirma = $idexafirma";
							$vRet = $this->guardarDatos($query);
							break;		
						case 2:
							$query = "DELETE FROM exa_firmas_email WHERE idexafirma = ".$arg;
							$vRet = $this->guardarDatos($query);
							break;		
					}
					break; // 68
	  	}
		return $vRet;
	}


	public function setPagos($id=0,$importe=0,$referencia='',$IdUser=0){
	  	$query="";
		$vRet = "Error";

	  	$ip=$_SERVER['REMOTE_ADDR']; 
	  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
     	// $Conn = new voConnPDO();

	    $query = "SELECT * FROM _viEdosCta WHERE idedocta = $id LIMIT 1";

  //    	$Conn = new voConnPDO();
		// $rst = $Conn->queryFetchAllAssocOBJ($query);

	    $rst = $this->getArray($query);

		if (!$rst) {
			return false;
		}

		$idusr = $IdUser;// $rst[0]->idemp;
		$idemp = $rst[0]->idemp;
		$idciclo = $rst[0]->idciclo;

		$IDs = $id;

		$IdFs = $rst[0]->idfamilia;
		$aIdPago = $rst[0]->idpago;

		$iPD = intval($rst[0]->is_pagos_diversos);

		$aConcepto = $rst[0]->concepto;

		if ( $iPD == 1 ) {
			$aConcepto = $rst[0]->concepto.' '.$rst[0]->mes;
		}

		$aSubtotal = $rst[0]->subtotal;
		$aDesctoBecas = $rst[0]->descto_becas;
		$aImporte = $rst[0]->importe;
		
		$aRecargo = $rst[0]->recargo;
		$aDescto = $rst[0]->descto;
		$aTotal = $importe;

		$subtotal = $rst[0]->subtotal;
		$descto_becas = $rst[0]->descto_becas;
		$importe = $rst[0]->importe;
		$descto = $rst[0]->descto;
		$recargo = $rst[0]->recargo;
		$total = $importe;

		$idemisorfiscal = $rst[0]->idemisorfiscal;
		$serie = $rst[0]->serie;
		
		$idmetododepago = 7;

	    $facEnc = "INSERT INTO facturas_encabezado(idcliente,idmetododepago,idemisorfiscal,serie,referencia,fecha,fecha_total_pagado,subtotal,descto_becas,importe,descto,recargo,total,idemp,ip,host,creado_por,creado_el)
	    		VALUES(".$IdFs.",$idmetododepago,$idemisorfiscal,'$serie','$referencia',NOW(),NOW(),$subtotal,$descto_becas,$importe,$descto,$recargo,$total,$idemp,'$ip','$host',$idusr,NOW())";
/*
		$result = $Conn->exec($facEnc);
		if ($result != 1){
			$vR = $Conn->errorInfo();
			$vRet = var_dump($vR[2]);
		}else{
			$vRet = "OK";
		}
*/
		$vRet = $this->guardarDatos($facEnc);


	    $qry = "SELECT MAX(idfactura) AS IDs FROM facturas_encabezado";
	    /*
		$result23 = $Conn->queryFetchAllAssocOBJ($qry);
		if (!$result23) {
			$rFac=0;
		}else{
			$rFac = $result23[0]->IDs;
		}
		*/
	    $result23 = $this->getArray($qry);
	    $rFac = !$result23 ? 0 : $result23[0]->IDs;


		$facDet = "INSERT INTO facturas_detalle(
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
						".$IDs.",
						".$aIdPago.",
						'".$aConcepto."',
						'pza', 
						1, 
						".$aSubtotal.", 
						".$aSubtotal.", 
						".$aDesctoBecas.", 
						".$aImporte.", 
						".$aDescto.", 
						".$aRecargo.",
						".$aTotal.",
						$idemp,'$ip','$host',$idusr,NOW())";
/*
		$result = $Conn->exec($facDet);
		if ($result != 1){
			$vR = $Conn->errorInfo();
			$vRet = var_dump($vR[2]);
		}else{
			$vRet = "OK";
		}
*/
		$vRet = $this->guardarDatos($facDet);

		$qry = "UPDATE estados_de_cuenta SET 	
										idfactura = ".$rFac.",
										status_movto = 1,
										idmetododepago = $idmetododepago,
										total = $importe,
										referencia = '$referencia',
										origen = 2,
										fecha_de_pago = NOW(),
										ip = '$ip', 
										host = '$host',
										modi_por = $idusr, 
										modi_el = NOW()
				WHERE idedocta = ".$IDs;
/*	
		$result = $Conn->exec($qry);
		if ($result != 1){
			$vR = $Conn->errorInfo();
			$vRet = var_dump($vR[2]);
		}else{
			$vRet = "OK";
		}
*/
		$vRet = $this->guardarDatos($qry);

		// $Conn = null;		  

		return $vRet;
	}


	public function setPreinscripciones($tipo=0,$cad=""){

	  	$query="";
		$vRet = "Error";

	  	$ip=$_SERVER['REMOTE_ADDR']; 
	  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);

		switch($tipo){
			case 0:
				parse_str($cad);
				$idusr   = $this->getIdUserFromAlias($user);
		        $idemp   = $this->getIdEmpFromAlias($user);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				
				$tiene_hermanos 	   = !isset($tiene_hermanos)?0:1;
				$tuvo_hermanos 		   = !isset($tuvo_hermanos)?0:1;
				$hijo_exalumno 		   = !isset($hijo_exalumno)?0:1;
				$recomienda_hijos 	   = !isset($recomienda_hijos)?0:1;
				// $quien_es_tutor 	   = !isset($quien_es_tutor)?0:1;
				$genero_alumno 		   = !isset($genero_alumno)?0:1;
				$genero_madre 		   = !isset($genero_madre)?0:1;
				$genero_padre 		   = !isset($genero_padre)?0:1;
				$bilingue 			   = !isset($bilingue)?0:1;

				$query = "INSERT INTO preinscripciones(
										ap_paterno_alumno,
										ap_materno_alumno,
										nombre_alumno,
										grado_cursara,
										ciclo_escolar,
										edad_septiembre,
										fecha_nacimiento_alumno,
										fecha_ingreso,
										genero_alumno,
										lugar_nacimiento_alumno,
										curp_alumno, 
										enfermedades,
										reacciones_alergicas,
										tipo_sangre,
										app_medico,
										apm_medico,
										nombre_medico,
										especialidad_medico,
										telefono_medico,
										ap_paterno_padre,
										ap_materno_padre,
										nombre_padre,
										curp_padre,
										fecha_nacimiento_padre,
										lugar_nacimiento_padre,
										ocupacion_padre,
										lugar_trabajo_padre,
										domicilio_padre,
										telefono_casa_padre,
										telefono_celular_padre,
										telefono_oficina_padre,
										email_padre,
										genero_padre,
										ap_paterno_madre,
										ap_materno_madre,
										nombre_madre,
										curp_madre,
										fecha_nacimiento_madre,
										lugar_nacimiento_madre,
										ocupacion_madre,
										lugar_trabajo_madre,
										domicilio_madre,
										telefono_casa_madre,
										telefono_celular_madre,
										telefono_oficina_madre,
										email_madre,
										genero_madre,
										quien_es_tutor,
										nombre_otro_tutor,
										parentezco_otro_tutor,
										telefono_otro_tutor,
										nombre_emergencia,
										tel_emergencia,
										parentezco_emergencia,
										nombre_emergencia1,
										tel_emergencia1,
										parentezco_emergencia1,
										colegio_procede,
										bilingue, 
										idioma_2,
										tiene_hermanos,
										grado_hermanos,
										tuvo_hermanos,
										ciclo_hermanos,
										hijo_exalumno,
										quien_recomienda,
										recomienda_hijos,
										porque_eligio,
										rfc_fiscal,
										curp_fiscal,
										razon_social_fiscal,
										calle_fiscal,
										num_ext_fiscal,
										num_int_fiscal,
										colonia_fiscal,
										localidad_fiscal,
										estado_fiscal,
										pais_fiscal,
										cp_fiscal,
										email1_fiscal,
										tel1_fiscal,
										idciclo,
										idemp,
										ip,
										host,
										creado_por,
										creado_el
									)VALUES(
										'$ap_paterno_alumno',
										'$ap_materno_alumno',
										'$nombre_alumno',
										'$grado_cursara',
										'$ciclo_escolar',
										'$edad_septiembre',
										'$fecha_nacimiento_alumno',
										'$fecha_ingreso',
										$genero_alumno,
										'$lugar_nacimiento_alumno',
										'$curp_alumno', 
										'$enfermedades',
										'$reacciones_alergicas',
										'$tipo_sangre',
										'$app_medico',
										'$apm_medico',
										'$nombre_medico',
										'$especialidad_medico',
										'$telefono_medico',
										'$ap_paterno_padre',
										'$ap_materno_padre',
										'$nombre_padre',
										'$curp_padre',
										'$fecha_nacimiento_padre',
										'$lugar_nacimiento_padre',
										'$ocupacion_padre',
										'$lugar_trabajo_padre',
										'$domicilio_padre',
										'$telefono_casa_padre',
										'$telefono_celular_padre',
										'$telefono_oficina_padre',
										'$email_padre',
										$genero_padre,
										'$ap_paterno_madre',
										'$ap_materno_madre',
										'$nombre_madre',
										'$curp_madre',
										'$fecha_nacimiento_madre',
										'$lugar_nacimiento_madre',
										'$ocupacion_madre',
										'$lugar_trabajo_madre',
										'$domicilio_madre',
										'$telefono_casa_madre',
										'$telefono_celular_madre',
										'$telefono_oficina_madre',
										'$email_madre',
										$genero_madre,
										$quien_es_tutor,
										'$nombre_otro_tutor',
										'$parentezco_otro_tutor',
										'$telefono_otro_tutor',
										'$nombre_emergencia',
										'$tel_emergencia',
										'$parentezco_emergencia',
										'$nombre_emergencia1',
										'$tel_emergencia1',
										'$parentezco_emergencia1',
										'$colegio_procede',
										$bilingue, 
										'$idioma_2',
										$tiene_hermanos,
										'$grado_hermanos',
										$tuvo_hermanos,
										'$ciclo_hermanos',
										$hijo_exalumno,
										'$quien_recomienda',
										$recomienda_hijos,
										'$porque_eligio',
										'$rfc_fiscal',
										'$curp_fiscal',
										'$razon_social_fiscal',
										'$calle_fiscal',
										'$num_ext_fiscal',
										'$num_int_fiscal',
										'$colonia_fiscal',
										'$localidad_fiscal',
										'$estado_fiscal',
										'$pais_fiscal',
										'$cp_fiscal',
										'$email1_fiscal',
										'$tel1_fiscal',
										$idciclo,
										$idemp,
										'$ip',
										'$host',
										$idusr,
										NOW()
										)";

				break;		

			case 1:
				parse_str($cad);
				$idusr = $this->getIdUserFromAlias($user);
		        $idemp = $this->getIdEmpFromAlias($user);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				
				$tiene_hermanos 	   = !isset($tiene_hermanos)?0:1;
				$tuvo_hermanos 		   = !isset($tuvo_hermanos)?0:1;
				$hijo_exalumno 		   = !isset($hijo_exalumno)?0:1;
				$recomienda_hijos 	   = !isset($recomienda_hijos)?0:1;
				// $quien_es_tutor 	   = !isset($quien_es_tutor)?0:1;
				$genero_alumno 		   = !isset($genero_alumno)?0:1;
				$genero_madre 		   = !isset($genero_madre)?0:1;
				$genero_padre 		   = !isset($genero_padre)?0:1;
				$bilingue 			   = !isset($bilingue)?0:1;

				$query = "Update preinscripciones Set
										ap_paterno_alumno = '$ap_paterno_alumno',
										ap_materno_alumno = '$ap_materno_alumno',
										nombre_alumno = '$nombre_alumno',
										grado_cursara = '$grado_cursara',
										ciclo_escolar = '$ciclo_escolar',
										edad_septiembre = '$edad_septiembre',
										fecha_nacimiento_alumno = '$fecha_nacimiento_alumno',
										fecha_ingreso = '$fecha_ingreso',
										genero_alumno = $genero_alumno,
										lugar_nacimiento_alumno = '$lugar_nacimiento_alumno',
										curp_alumno = '$curp_alumno', 
										enfermedades = '$enfermedades',
										reacciones_alergicas = '$reacciones_alergicas',
										tipo_sangre = '$tipo_sangre',
										app_medico = '$app_medico',
										apm_medico = '$apm_medico',
										nombre_medico = '$nombre_medico',
										especialidad_medico = '$especialidad_medico',
										telefono_medico = '$telefono_medico',
										ap_paterno_padre = '$ap_paterno_padre',
										ap_materno_padre = '$ap_materno_padre',
										nombre_padre = '$nombre_padre',
										curp_padre = '$curp_padre',
										fecha_nacimiento_padre = '$fecha_nacimiento_padre',
										lugar_nacimiento_padre = '$lugar_nacimiento_padre',
										ocupacion_padre = '$ocupacion_padre',
										lugar_trabajo_padre = '$lugar_trabajo_padre',
										domicilio_padre = '$domicilio_padre',
										telefono_casa_padre = '$telefono_casa_padre',
										telefono_celular_padre = '$telefono_celular_padre',
										telefono_oficina_padre = '$telefono_oficina_padre',
										email_padre = '$email_padre',
										genero_padre = $genero_padre,
										ap_paterno_madre = '$ap_paterno_madre',
										ap_materno_madre = '$ap_materno_madre',
										nombre_madre = '$nombre_madre',
										curp_madre = '$curp_madre',
										fecha_nacimiento_madre = '$fecha_nacimiento_madre',
										lugar_nacimiento_madre = '$lugar_nacimiento_madre',
										ocupacion_madre = '$ocupacion_madre',
										lugar_trabajo_madre = '$lugar_trabajo_madre',
										domicilio_madre = '$domicilio_madre',
										telefono_casa_madre = '$telefono_casa_madre',
										telefono_celular_madre = '$telefono_celular_madre',
										telefono_oficina_madre = '$telefono_oficina_madre',
										email_madre = '$email_madre',
										genero_madre = $genero_madre,
										quien_es_tutor = $quien_es_tutor,
										nombre_otro_tutor = '$nombre_otro_tutor',
										parentezco_otro_tutor = '$parentezco_otro_tutor',
										telefono_otro_tutor = '$telefono_otro_tutor',
										nombre_emergencia = '$nombre_emergencia',
										tel_emergencia = '$tel_emergencia',
										parentezco_emergencia = '$parentezco_emergencia',
										nombre_emergencia1 = '$nombre_emergencia1',
										tel_emergencia1 = '$tel_emergencia1',
										parentezco_emergencia1 = '$parentezco_emergencia1',
										colegio_procede = '$colegio_procede',
										bilingue = $bilingue, 
										idioma_2 = '$idioma_2',
										tiene_hermanos = $tiene_hermanos,
										grado_hermanos = '$grado_hermanos',
										tuvo_hermanos = $tuvo_hermanos,
										ciclo_hermanos = '$ciclo_hermanos',
										hijo_exalumno = $hijo_exalumno,
										quien_recomienda = '$quien_recomienda',
										recomienda_hijos = $recomienda_hijos,
										porque_eligio = '$porque_eligio',
										rfc_fiscal = '$rfc_fiscal',
										curp_fiscal = '$curp_fiscal',
										razon_social_fiscal = '$razon_social_fiscal',
										calle_fiscal = '$calle_fiscal',
										num_ext_fiscal = '$num_ext_fiscal',
										num_int_fiscal = '$num_int_fiscal',
										colonia_fiscal = '$colonia_fiscal',
										localidad_fiscal = '$localidad_fiscal',
										estado_fiscal = '$estado_fiscal',
										pais_fiscal = '$pais_fiscal',
										cp_fiscal = '$cp_fiscal',
										email1_fiscal = '$email1_fiscal',
										tel1_fiscal = '$tel1_fiscal',
										modi_por = $idusr,
										modi_el = NOW()				
					     WHERE idpreinscripcion = $idpreinscripcion";

				break;		

		}

		$result = $this->guardarDatos($query);
		return $result;

	}


	public function UPDATEVencimientoEdoCta($cad) {

		parse_str($cad);
		$query = "SET @X = Actualizar_Pagos_Metodo_B(".$idfamilia.",0,1)";
		$ret = $this->execQuery($query);
	    return $ret;

	}

	public function refreshVencimientos($cad) {

		parse_str($cad);

		$query = "SET @X = Actualizar_Pagos_Metodo_B(".$idfamilia.",0,1)";
		$ret = $this->execQuery($query);

		if ( $ret[0]->Respuesta == "OK" ) {

			$query = "SET @X = Actualizar_Pagos_Metodo_A(".$idfamilia.",0,1)";
			$ret = $this->execQuery($query);

		}

	    return $ret;

	}

	public function revivePago($cad='') {

		parse_str($cad);
		$query = "SET @X = Revive_Pago(".$pIdEdoCta.",".$pIdUser.",'".$pUsuario."')";
		$vRet = $this->execQuery($query);
		return $vRet;

	}

	public function IsAutorized($cad='') {

		parse_str($cad);
		$clave = SHA1($claveAutorizacion);
		$idusr = $this->getIdUserFromAlias($u);
        $idemp = $this->getIdEmpFromAlias($u);
		// iduser = $idusr AND 
		$query = "SELECT iduser 
					FROM cat_claves_autorizacion 
					WHERE clave = '$clave' AND 
							idemp = $idemp 
					LIMIT 1 ";
		$result = $this->getArray($query);
		$vRet = count($result) > 0 ? "OK" : "No esta autorizado para realizar esta operación";

		if ($vRet == "OK"){
			$iduserauth = $result[0]->iduser;			
			$query = "SET @X = Cancelar_Concepto_de_Pago_de_Alumno(".$idedocta.",".$idusr.",".$iduserauth.")";
			$vRet = $this->execQuery($query);

		}
		return $vRet;

	}


	public function setCloneMatConSave($cad=''){
	  	$query="";
		$vRet = "Error";

	  	$ip=$_SERVER['REMOTE_ADDR']; 
	  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);

		parse_str($cad);
		$idusr = $this->getIdUserFromAlias($u);
        $idemp = $this->getIdEmpFromAlias($u);
		$idciclo = $this->getCicloFromIdEmp($idemp);		        

	    $query = "SELECT * FROM grupo_materia_config WHERE idgrumat = $idgrumatold AND num_eval = $num_eval_old ";

	    $rst = $this->getArray($query);

		if (!$rst) {
			return false;
		}

		foreach($rst AS $i=>$valor){

			$descripcion = $rst[$i]->descripcion;
			$porcentaje = $rst[$i]->porcentaje;
			$aceptacero = $rst[$i]->aceptacero;
			$secuencia = $rst[$i]->secuencia;
			$idalutipoactividad = $rst[$i]->idalutipoactividad;
			$idgrumatconold = $rst[$i]->idgrumatcon;

			$query = "INSERT INTO grupo_materia_config(
								idgrumat,
								num_eval,
								descripcion,
								porcentaje,
								aceptacero,
								secuencia,
								idalutipoactividad,
								idemp,ip,host,creado_por,creado_el)
						VALUES(
								$idgrumat,
								$num_eval,
								'$descripcion',
								$porcentaje,
								$aceptacero,
								$secuencia,
								$idalutipoactividad,
								$idemp,'$ip','$host',$idusr,NOW())";
			$vRet = $f->guardarDatos($query);

			if (intval($isitem) > 0){

				$idusr = $this->getIdUserFromAlias($u);
		        $idemp = $this->getIdEmpFromAlias($u);

			    $q0 = "SELECT MAX(idgrumatcon) AS ids FROM grupo_materia_config ";
			    $r0 = $this->getArray($q0);
			    $idgrumatcon = !$r0 ? 0 : $r0[0]->ids;

			    $q1 = "SELECT * FROM grupo_materia_config_markbook WHERE idgrumatcon = $idgrumatconold ";
			    $r1 = $this->getArray($q1);
				foreach($r1 AS $j=>$valor){
					$db = $r1[$j]->descripcion_breve;
					$da = $r1[$j]->descripcion_avanzada;

					$q2 = "INSERT INTO grupo_materia_config_markbook(
										idgrumatcon,
										descripcion_breve,
										descripcion_avanzada,
										idemp,ip,host,creado_por,creado_el)
								VALUES(
										$idgrumatcon,
										'$db',
										'$da',
										$idemp,'$ip','$host',$idusr,NOW())";
					$vRet = $f->guardarDatos($q2);
				}
			}
		}
	    return $vRet;
	}

	public function refreshBoletaPAIBI($cad) {

		parse_str($cad);

		$query = "SET @X = Actualizar_Boletas_PAIBI(".$idgrumat.")";
		$ret = $this->execQuery($query);

	    return $ret;

	}

	public function getEstadisticasNoLeidas($Clave=0,$IdUserNivelAcceso=0,$u="",$iduser=0){
		$totalNoLeidasTareas     = 0;
		$totalNoLeidasCirculares = 0;
		$totalNoLeidasMensajes   = 0;
		$totalNoLeidasBadge      = 0;

		require_once("oCentura.php");
		$f = oCentura::getInstance();

		switch ($Clave) {
			case 5:
					// Tareas
					$arg = "u=$u&sts=0&iduseralu=".$iduser;
					$tipo = 20009;
					$r = $f->getQuerys($tipo,$arg,0,0,0,array(),"",1);
					$totalNoLeidasTareas = $totalNoLeidasTareas + count($r);
					// Circulaes
					$arg = "u=$u&sts=0";
					$tipo = 31009;
					$r = $f->getQuerys($tipo,$arg,0,0,0,array(),"",1);
					$totalNoLeidasCirculares = $totalNoLeidasCirculares + count($r);

				break;

			case 7:
			case 28:
			case 29:

				$arg = "u=".$u;
				
				$res = $f->getCombo(1,$arg,0,0,61,'');
				
				if ( count($res) > 0 ){	
					foreach ($res as $i => $value) {
						// Tareas
						$arg = "u=".$u."&sts=0&iduseralu=".$res[$i]->data;
						$tipo = 20009;
						$r = $f->getQuerys($tipo,$arg,0,0,0,array(),"",1);
						$totalNoLeidasTareas = $totalNoLeidasTareas + count($r);
					}	
					// Circulaes
					$arg = "u=".$u."&sts=0";
					$tipo = 31009;
					$r = $f->getQuerys($tipo,$arg,0,0,0,array(),"",1);
					// $totalNoLeidasCirculares = $totalNoLeidasCirculares + count($r);
					$totalNoLeidasCirculares = $totalNoLeidasCirculares + count($r);
				}
				

				break;
		}

		$totalNoLeidasBadge = $totalNoLeidasTareas + $totalNoLeidasCirculares + $totalNoLeidasMensajes;

		return array(
					"totalNoLeidasTareas"     => $totalNoLeidasTareas,
					"totalNoLeidasCirculares" => $totalNoLeidasCirculares,
					"totalNoLeidasMensajes"   => $totalNoLeidasMensajes,
					"totalNoLeidasBadge"      => $totalNoLeidasBadge,
					"currentVersion"		  => "1.1.31"
					);

	}

}

?>