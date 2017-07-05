<?php 



ini_set('display_errors', '0');
error_reporting(E_ALL | E_STRICT);

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

date_default_timezone_set('America/Mexico_City');

require_once('vo/voConn.php');
require_once('vo/voConnPDO.php');
require_once('vo/voCombo.php');
require_once('vo/voUsuario.php');

require_once('vo/voEmpty.php');

require_once('vo/voEstado.php');
require_once('vo/voMunicipio.php');

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
			$this->URL      = "http://platsource.mx/";
	}

	public static function getInstance(){
				if (  !self::$instancia instanceof self){
					  self::$instancia = new self;
				}
				return self::$instancia;
	}

	 private function getIdUserFromAlias($str){
	  
	    $query = "select iduser from usuarios where username = '$str' and status_usuario = 1";

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
	  
	    $query = "select idemp from usuarios where username = '$str' and status_usuario = 1";

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
	  
	    $query = "select idemp from estados_de_cuenta where idedocta = $id";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->idemp;
		}
	    return $ret;
	 }

	 private function getCicloFromIdEmp($idemp=0){
	  
	    $query = "select idciclo from cat_ciclos where idemp = $idemp and predeterminado = 1 and status_ciclo = 1 limit 1";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if ($result <= 0) {
			$ret=0;
		}else{
				$ret = $result[0]->idciclo;
		}
	    return $ret;
	 }

	 private function getNivelFromIdGrupo($idgrupo=0,$idciclo=0){
	  
	    $query = "select idnivel from _viNivel_Grupos where idgrupo = $idgrupo and idciclo = $idciclo limit 1";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if ($result <= 0) {
			$ret=0;
		}else{
				$ret = $result[0]->idnivel;
		}
	    return $ret;
	 }


	 private function getNivelFromIdUserAlu($iduseralu=0){
	  
	    $query = "select idnivel from _viGrupo_Alumnos where iduseralu = $iduseralu order by idciclo desc limit 1";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if ($result <= 0) {
			$ret=0;
		}else{
				$ret = $result[0]->idnivel;
		}
	    return $ret;
	 }

	public function IsLockGroupAcademico($cad) {
		
		parse_str($cad);

        $idemp = $this->getIdEmpFromAlias($u);
	    $query = "select count(idgrupo) as idgrupo from cat_grupos where idgrupo = $idgrupo and idemp = $idemp and bloqueado = 1 limit 1";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if ($result <= 0) {
			$ret=0;
		}else{
				$ret = $result[0]->idgrupo;
		}
	    return $ret;

	}

	private function IsExistUserConnect($iduser,$idemp) {
	  
	    $query = "select iduser from usuarios_conectados where iduser = $iduser and idemp = $idemp limit 1";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->iduser;
		}
	    return $ret;
	 }

	private function IsConnectUser($iduser,$idemp) {
	  
	    $query = "select iduser from usuarios_conectados where iduser = $iduser and idemp = $idemp and isconectado = 1 limit 1";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->iduser;
		}
	    return $ret;
	 }

	public function getNumDiasAsistencia($idgrumat,$eval) {
	  
	    $query = "SELECT DISTINCT fecha AS dia FROM _viBolAsist WHERE idgrumat = $idgrumat AND evaluacion = $eval ";

     	$Conn = new voConnPDO();
		$ret = $Conn->queryFetchAllAssocOBJ($query);

	    return $ret;
	 }

	 public function getLogoEmp($idemp){
	  
	    $query = "select valor from config where llave = 'logo-emp-rep' and idemp = $idemp";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->valor;
		}
	    return $ret;
	 }

	 public function getLogoIB($idemp){
	  
	    $query = "select valor from config where llave = 'logo-ib-emp' and idemp = $idemp";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->valor;
		}
	    return $ret;
	 }


	 public function getNombreEmp($idemp){
	  
	    $query = "select rs from empresa where idemp = $idemp";

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		if (!$result) {
				$ret=0;
		}else{
				$ret= $result[0]->rs;
		}
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


    public function getComboPDO($index=0,$arg="",$pag=0,$limite=0,$tipo=0,$otros=""){

		$query="";
    	switch ($index){

			case 0:
					parse_str($arg);
					$pass = md5($passwordL);
					$query = "SELECT _viUsuarios.*, username as label, concat(iduser,'|',password,'|',idemp,'|',empresa,'|',idusernivelacceso,'|',registrosporpagina,'|',clave,'|',param1) as data 
							FROM  _viUsuarios where username = '$username' and password = '$pass' and status_usuario = 1";
				break;						

			case 1:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				// $idciclo = $this->getCicloFromIdEmp($idemp);		        
				$idnivel = $this->getNivelFromIdGrupo($idgrupo,$idciclo);		        
				$query = "SELECT grupo as label, idgrupo as data 
						FROM _viNivel_Grupos where idemp = $idemp and idciclo = $idciclo and idnivel = $idnivel
						Order By idgrupo asc ";
				break;		

			case 2:
				$query = "SELECT *
						FROM _viEdosCta where idedocta = $arg limit 1";
				break;		

			case 3:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT descripcion as label, idlistavencimiento as data
						FROM cat_listas_vencimientos where idemp = $idemp ";
				break;		

			case 4:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT distinct materia as label , idgrumat as data, idboleta, alumno
						FROM _viBoletas where idgrualu = $idgrualu and isagrupadora_grumat = 0 and idciclo = $idciclo and idemp = $idemp order by orden_impresion asc ";
				break;		

			case 5:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$eval = intval($eval)+1;
				$query = "SELECT *, round(cal_real,1) as calreal, trim(descripcion) as desc2
						FROM _viGruMatBol where idgrumat = $idgrumat and num_eval = $eval and idboleta = $idboleta and idemp = $idemp order by idbolpar asc ";
				break;	

			case 6:

				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *, descripcion_avanzada as descavanz
						FROM _viGruMatConMKB 
						where idbolpar = $idbolpar 
							and idboleta = $idboleta 
							and idgrumatcon = $idgrumatcon 
							and idgrualu = $idgrualu
							and idciclo = $idciclo
							and idemp = $idemp order by idbolpar asc ";
				break;		

			case 7:

				parse_str($arg);
				// $idemp = $this->getIdEmpFromAlias($u);
				// $idciclo = $this->getCicloFromIdEmp($idemp);
				$eval = intval($eval) ;
				$cal = "cal".$eval;		        
				$con = "con".$eval;		        
				$ina = "ina".$eval;		        
				$query = "SELECT round($cal,0) as cal, $con as con, $ina as ina, profesor
						FROM _viBoletas 
						where idboleta = $idboleta ";
				break;		

			case 8:

				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);	
				$eval = intval($eval) + 1;	        
				$query = "SELECT *
						FROM _viBolAsist 
						where idgrualu = $idgrualu 
							and idboleta = $idboleta 
							and evaluacion = $eval 
							and idemp = $idemp
							and (asistencia = 0 or asistencia = 3 or observaciones != '')  order by fecha desc ";
				break;		
			case 9:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT prefijo_evaluacion, numero_evaluaciones
						FROM cat_niveles where idemp = $idemp and clave_nivel = $clave_nivel limit 1 ";
				break;		

			case 10: // 
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);

				$query = "SELECT nombres_alumno as label, idgrualu as data, grupo, clave_nivel, ver_boleta_interna, grupo_bloqueado, grado, grado_pai, ispai_grupo
						FROM _viGrupo_Alumnos 
						where idemp = $idemp 
							and idciclo = $idciclo 
							and idalumno = $idalumno 
							and status_grualu = 1 
							and grupo_bloqueado = 0 
						Order By label asc ";
				break;		

			case 11:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);

				$query = "SELECT distinct vencimiento as data
						FROM _viEdosCta 
						where idemp = $idemp 
							  AND idciclo = $idciclo 
						";

				break;

			case 12:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idemergencia, nombre, tel1, parentezco
						FROM cat_emergencias where idemp = $idemp ";
				break;		

			case 13:
				$query = "SELECT idemergencia, nombre, tel1, parentezco, status_emergencia
						FROM cat_emergencias where idemergencia = ".$arg;
				break;		

			case 14:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT distinct materia as label , idgrumat as data, idboleta, alumno
						FROM _viBolForPAI where idgrualu = $idgrualu and idciclo = $idciclo and idemp = $idemp order by idboleta asc ";
				break;		

			case 15:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT idboleta, materia, idgrumat, idpaiareadisciplinaria, grado_pai
						FROM _viBolForPAI where idgrualu = $idgrualu and ispai_grupo = 1 and ispai_materia = 1 and idciclo = $idciclo and idemp = $idemp order by orden_impresion asc ";
				break;	

			case 16:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT generacion as label, idgeneracion as data  
						FROM exa_generaciones where idemp = $idemp and status_generacion = 1
						Order By data asc ";
				break;		

			case 51:
				parse_str($arg);
				$idemp = $this->getIdEmpFromAlias($u);
				$arr0 = array(8,9,10,11,12,19);
				$cve = intval($clavenivelacceso);
				$pos = array_search($cve, $arr0);
				$arr1 = array(1,2,3,4,5);
				if ( intval($otros) > 0 ){
					$query = "SELECT concat(director,' - ',nivel) as label, iddirector as data 
							FROM _viDirectores where idemp = $idemp and status_director = 1 and clave_nivel IN ($otros)
							Order By data asc ";
				}else{
					$query = "SELECT concat(director,' - ',nivel) as label, iddirector as data 
							FROM _viDirectores where idemp = $idemp and status_director = 1 
							Order By data asc ";
				}		
				break;	

			case 55:
				parse_str($arg);
				$idusr = $this->getIdUserFromAlias($u);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        

				$query = "SELECT *
						FROM grupo_materia_config_save 
						where idprofesor = $idusr 
								and idciclo = $idciclo 
								and idemp = $idemp 
						";
				break;		

			case 57:

				$query = "SELECT ruta
						FROM _viPDFs 
						Where status_pdf = 1 and 
								categoria_pdf = 0
						Order By idpdf desc 
						Limit 1 
						";
				break;		

			case 58:
				parse_str($arg);
				$idnivel = $this->getNivelFromIdUserAlu($arg);
				$query = "SELECT ruta
						FROM _viPDFs 
						Where status_pdf = 1 and 
								idnivel = $idnivel and
								categoria_pdf = 1
						Order By idpdf desc 
						Limit 1 
						";
				break;		

			case 59:
				parse_str($arg);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM cat_beneficios_giros 
						Where idemp = $idemp and 
								status_giro_beneficio = 1 
						Order By idgirobeneficio desc ";
				break;		

			case 60:
				parse_str($arg);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM exa_generaciones
						Where idemp = $idemp and 
								status_generacion = 1 
						Order By idgeneracion desc ";
				break;		

	  	}

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		$Conn = null;

		return $result;
	}


	public function getQueryPDO($tipo=0,$cad="",$type=0,$from=0,$cant=0,$ar=array(),$otros="",$withPag=1) {
		$query="";
    	switch ($tipo){
			case -1:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM empresa where idemp = $idemp and status_empresa = 1 limit 1";
				break;			

			case 0:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viGruMatConMKB where idgrumatconmkb = $idgrumatconmkb and idemp = $idemp and idciclo = $idciclo and status_alumno = 1 order by num_lista asc";
				break;						
			case 1:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viBoletas where idgrumat = $idgrumat and idemp = $idemp and idciclo = $idciclo order by num_lista asc";
				break;						
			case 2:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viBolAsist where idgrumat = $idgrumat and fecha = '$fecha' and idemp = $idemp order by num_lista asc";
				break;						
			case 3:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viGruMatConMKB where idgrumatcon = $idgrumatcon and idgrumatconmkb = $idgrumatconmkb and idgrualu = $idgrualu and idemp = $idemp and idciclo = $idciclo and status_alumno = 1 limit 1";
				break;						

			case 4:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM _viUsuariosConectados where idemp = $idemp and isconectado = 1 ";
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
								Where idemp = $idemp and clave_nivel IN ($otros) order by clave_nivel asc ";
				}else{
						$query = "SELECT *
						FROM _viEvalConfig where idemp = $idemp order by clave_nivel asc ";
				}

				break;						

			case 6:
				$query = "SELECT *
								FROM evaluaciones_config
							where idevalconfig = $cad ";
				break;

			case 7:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM _viBolAsist where idboleta = $idboleta and fecha = '$fecha' and evaluacion = $eval and idemp = $idemp order by num_lista asc";
				break;		

			case 8:
				parse_str($cad);
		  //       $idemp = $this->getIdEmpFromAlias($u);
				// $idciclo = $this->getCicloFromIdEmp($idemp);		        
				$query = "SELECT *
						FROM boleta_partes where idboleta = $idboleta and idgrumatcon = $idgrumatcon limit 1";
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
					$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, idmatclas, padre
									FROM _viBoletas
								Where idboleta = $idboleta $otros ";
		        }elseif ( $numval == 10 ){
					$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, idmatclas, padre
									FROM _viBoletas
								Where idboleta = $idboleta $otros ";
				}else{
					$query = "SELECT ".$ncal." as cal, ".$ncon." as con, ".$nina." as ina, ".$nobs." as obs, idmatclas, padre
									FROM _viBoletas
								Where idboleta = $idboleta $otros ";
				}

				break;

			case 10:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM pases_salida
							Where idciclo = $idciclo and idgrupo = $idgrupo and idemp = $idemp and status_psa = 1  order by idpsa desc ";
				break;
			case 11:
				$query = "SELECT  *
								FROM pases_salida 
							where idpsa = $cad ";
				break;

			case 12:
				parse_str($cad);
				$query = "SELECT *
								FROM _viPSA_Alumnos
							Where idpsa = $idpsa order by idpsa asc ";
				break;

			case 13:
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
								Where idemp = $idemp and grupo_ciclo_nivel_visible = 1 and clave_nivel IN ($otros) order by idnivel, idgrupo asc";
				}else{
						$query = "SELECT *
										FROM _viNivel_Grupos
									Where idemp = $idemp and grupo_ciclo_nivel_visible = 1 order by  idnivel, idgrupo asc";
				}

				break;

			case 14:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT alumno, idalumno 
						FROM _viGrupo_Alumnos where idciclo = $idciclo and idgrupo = $idgrupo and idemp = $idemp and status_grualu = 1
						order by alumno asc ";
				break;		

			case 15:
				$query = "SELECT  *
								FROM _viPSA 
							where idpsa = $cad ";
				break;

			case 16:
				parse_str($cad);
				$query = "SELECT *
								FROM _viPSA_Alumnos
							Where idpsa = $idpsa and idalumno = $idalumno limit 1 ";
				break;

			case 17:
					parse_str($cad);
					$iduseralumno = $this->getIdUserFromAlias($u);
			        $idemp = $this->getIdEmpFromAlias($u);

					$query = "SELECT alumno as label, idalumno as data, nombre_alumno 
							FROM _viFamAlu where iduseralufortutor = $iduseralumno and status_famalu = 1 and idemp = 1";
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
		        		$tBeca = " ( beca_arji > 0 And descto_becas > 0 ) And ";
		        		$tDescto = " ( (beca_arji/100) * subtotal ) ";
		        		break;

		        	case 2:
		        		$tBeca = " ( beca_sep > 0 And descto_becas > 0 ) And ";
		        		$tDescto = " ( (beca_sep/100) * subtotal ) ";
		        		break;

		        	case 3:
		        		$tBeca = " ( beca_bach > 0 And descto_becas > 0 ) And ";
		        		$tDescto = " ( (beca_bach/100) * subtotal ) ";
		        		break;

		        	case 4:
		        		$tBeca = " ( beca_sp > 0 And descto_becas > 0 ) And ";
		        		$tDescto = " ( (beca_sp/100) * subtotal ) ";
		        		break;		        		

		        }

		        $f0 = explode('-',$fi);
		        $f1 = explode('-',$ff);
		        $fi = $f0[2].'-'.$f0[1].'-'.$f0[0].' 00:00:00';
		        $ff = $f1[2].'-'.$f1[1].'-'.$f1[0].' 23:59:59';

				$query = "SELECT idconcepto, concepto, 
								SUM( IF ( clave_nivel = 1, ".$tDescto.", 0 ) ) as 'cero', 
								SUM( IF ( clave_nivel = 2, ".$tDescto.", 0 ) ) as 'uno', 
								SUM( IF ( clave_nivel = 3, ".$tDescto.", 0 ) ) as 'dos', 
								SUM( IF ( clave_nivel = 4, ".$tDescto.", 0 ) ) as 'tres', 
								SUM( IF ( clave_nivel = 5, ".$tDescto.", 0 ) ) as 'cuatro' 
							FROM _viEdosCta
							WHERE 	idemp = $idemp And 
									idciclo = $idciclo And 
									status_movto = 1 And 
									idemisorfiscal = $emisor And 
									".$tBeca."
									(fecha_de_pago >= '$fi' and fecha_de_pago <= '$ff')
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
						FROM _viGrupo_Alumnos where idciclo = $idciclo and idgrupo = $idgrupo and idemp = $idemp and idciclo = $idciclo and status_grualu = 1 order by num_lista ";
				break;		

			case 24: // ARJI
				parse_str($cad);
				$query = "SELECT alumno, idgrualu, grupo, num_lista, familia, nivel, ciclo
						FROM _viGrupo_Alumnos where idgrualu = $idgrualu limit 1 ";
				break;

			case 25:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM _viEmerAlu
							Where idalumno = $idalumno and idemp = $idemp ";
				break;

			case 26:
				$query = "SELECT *
								FROM _viEmerAlu
							where idemeralu = $cad ";
				break;

			case 27:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
								FROM cat_emergencias
							Where idemp = $idemp order by idemergencia desc";
				break;

			case 28:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$query = "SELECT *
								FROM preinscripciones
							Where idemp = $idemp and idciclo = $idciclo order by idpreinscripcion desc";
				break;

			case 29:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idciclo = $this->getCicloFromIdEmp($idemp);
				$query = "SELECT *
								FROM preinscripciones
							Where idemp = $idemp and idciclo = $idciclo and idpreinscripcion = $idpreinscripcion order by idpreinscripcion desc";
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


				$query = "	SELECT distinct idfamilia, familia, idalumno 
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
						Limit 1 ";
				break;

			case 33:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($user);
		        $iduser = $this->getIdUserFromAlias($user);
		        $idciclo = $this->getCicloFromIdEmp($idemp);

		        // AND iduser = $iduser 
		        
				$query = "SELECT distinct iddevice, iduser, device_token
							FROM cat_devices 
							WHERE idemp = $idemp AND 
									idciclo = $idciclo AND 
									type = $type AND 
									status_device = 1 AND 
									device_token != '(null)' 
							ORDER BY iddevice DESC";
				break;

			case 34:

				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
		        $iduser = $this->getIdUserFromAlias($u);
		        $idciclo = $this->getCicloFromIdEmp($idemp);

				$query = "SELECT *
							FROM _viPDFs 
							WHERE idemp = $idemp and 
									idciclo = $idciclo and 
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
						Where idemp = $idemp and 
							status_giro_beneficio = 1
						Order By idgirobeneficio desc ";
				break;	

			case 37:
				parse_str($cad);
				$query = "SELECT *
						FROM cat_beneficios_giros 
						Where idgirobeneficio = $cad";
				break;		

			case 38:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM _viBenAfil 
						Where idemp = $idemp
						Order By idbeneficio desc ";
				break;	

			case 39:
				parse_str($cad);
				$query = "SELECT *
						FROM _viBenAfil 
						Where idbeneficio = $cad";
				break;		

			case 40:

				$query = "SELECT *
						FROM _viBenAfil 
						Where idemp = 1
						Order By empresa asc ";
				break;	

			case 41:

				parse_str($cad);
				$query = "	SELECT idmobilmensaje, mensaje
							FROM _viMobileMensajes 
							WHERE iduser = $iduser and 
									device_token = '$device' and 
									status_read = $sts 
									order by fecha desc ";
				break;

			case 42:

				parse_str($cad);
				$query = "	SELECT idmobilmensaje, titulo, mensaje
							FROM _viMobileMensajes 
							WHERE idmobilmensaje = $idmobilmensaje and 
									iduser = $iduser and 
									idemp = $idemp 
							Limit 1";
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
								SUM( IF ( clave_nivel = 1, recargo, 0 ) ) as 'cero', 
								SUM( IF ( clave_nivel = 2, recargo, 0 ) ) as 'uno', 
								SUM( IF ( clave_nivel = 3, recargo, 0 ) ) as 'dos', 
								SUM( IF ( clave_nivel = 4, recargo, 0 ) ) as 'tres', 
								SUM( IF ( clave_nivel = 5, recargo, 0 ) ) as 'cuatro' 
							FROM _viEdosCta
							WHERE idemp = $idemp And 
									status_movto = 1 And 
									idemisorfiscal = $emisor And 
									(fecha_de_pago >= '$fi' and fecha_de_pago <= '$ff') and 
									recargo > 0
							GROUP BY idconcepto ";

				break;

			case 44:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$idusr = $this->getIdUserFromAlias($u);
				$query = "SELECT DISTINCT profesor as label,idusuarioprofesor as data 
						FROM _viDirProf where idemp = $idemp and idusuariodirector = $idusr
						Order By label asc ";
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
						Where idemp = $idemp and 
							status_exalumno = 1
						Order By nombre_exalumno asc ";
				break;	

			case 48:
				parse_str($cad);
				$query = "SELECT *
						FROM _viExAlumnos 
						Where idexalumno = $cad";
				break;		

			case 49:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM exa_generaciones 
						Where idemp = $idemp and 
							status_generacion = 1
						Order By generacion desc ";
				break;	

			case 50:
				parse_str($cad);
				$query = "SELECT *
						FROM exa_generaciones 
						Where idgeneracion = $cad";
				break;		

			case 51:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM cat_pai_criterios 
						Where idemp = $idemp 
						Order By idpaicriterio desc ";
				break;	

			case 52:
				parse_str($cad);
				$query = "SELECT *
						FROM cat_pai_criterios 
						Where idpaicriterio = $cad";
				break;		

			case 53:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);

				$query = "SELECT *
						FROM cat_pai_areas_disciplinarias 
						Where idemp = $idemp 
						Order By idpaiareadisciplinaria desc ";
				break;	

			case 54:
				parse_str($cad);
				$query = "SELECT *
						FROM cat_pai_areas_disciplinarias 
						Where idpaiareadisciplinaria = $cad";
				break;		

			case 55:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idpaiconcepto, area_disciplinaria, descripcion_criterio_large, concepto, rango_califica, grado_pai
						FROM _viPAIConceptos 
						Where idemp = $idemp 
						Order By idpaiconcepto desc ";
				break;	

			case 56:
				parse_str($cad);
				$query = "SELECT *
						FROM _viPAIConceptos 
						Where idpaiconcepto = $cad";
				break;		

			case 57:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT idpaiobjetivo, area_disciplinaria, descripcion_criterio, objetivo, grado_pai
						FROM _viPAIObjetivos 
						Where idemp = $idemp 
						Order By idpaiobjetivo desc ";
				break;	

			case 58:
				parse_str($cad);
				$query = "SELECT *
						FROM _viPAIObjetivos 
						Where idpaiobjetivo = $cad";
				break;		

			case 59:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT solicitan as label, idsolicita as data 
						FROM _viSolAut where idemp = $idemp and idautoriza = $otros
						Order By label asc ";
				break;


			case 60:
				parse_str($cad);
				$idemp = $this->getIdEmpFromAlias($u);
				$rc1 = $this->defineRangoEvaluacionPAI($rango_califica);
				$query = "SELECT concepto, criterio, descripcion_criterio, descripcion_criterio_large
						FROM _viPAIConceptos 
						WHERE idpaiareadisciplinaria = $idpaiareadisciplinaria
							  and idpaicriterio = $idpaicriterio
							  and grado_pai = $grado_pai
							  and rango_califica = $rc1
							  and idemp = $idemp
						limit 1 ";
				break;

			case 61:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);
				$query = "SELECT *
						FROM cat_listas_vencimientos
						Where idemp = $idemp and 
								status_fecha_vencimiento = 1 
						Order By idlistavencimiento desc ";
				break;		

			case 62:
				parse_str($cad);
				$query = "SELECT *
						FROM cat_listas_vencimientos 
						Where idlistavencimiento = $cad";
				break;		


			case 63:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	


				$query = "SELECT idexalumno, nombre_exalumno, generacion, email, profesion, ocupacion
							FROM _viExAlumnos
							WHERE idemp = $idemp And 
									status_exalumno = 1 And 
									(idgeneracion >= $desdegen and idgeneracion <= $hastagen)
							ORDER BY idgeneracion asc, nombre_exalumno asc";
				break;

			case 64:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT idexaemailenviado, para, cuerpo, titulo, iddestinatarios, creado_por, creado_el
							FROM exa_emails_enviados
							WHERE idemp = $idemp And 
									status_emails_enviados  = 1 
							ORDER BY idexaemailenviado desc";
				break;

			case 65:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT *
							FROM _viExaEmailsEnviados
							WHERE idemp = $idemp And 
									idexaemailenviado  = $idexaemailenviado";
				break;

			case 66:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$query = "SELECT *
							FROM _viExAlumnos
							WHERE idemp = $idemp And 
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
							WHERE idemp = $idemp And 
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
							WHERE idemp = $idemp And 
									idexafirma  = $idexafirma";
				break;

			case 71:
				parse_str($cad);
		        $idemp = $this->getIdEmpFromAlias($u);	
				$idusr = $this->getIdUserFromAlias($u);

				$query = "SELECT idexafirma, descripcion_firma, firma
							FROM exa_firmas_email
							WHERE idemp = $idemp And
									status_exa_firma = 1 And 
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

	  	}

     	$Conn = new voConnPDO();
		$result = $Conn->queryFetchAllAssocOBJ($query);

		$Conn = null;

		return $result;
			
	}


     public function setAsocia($tipo=0,$arg="",$pag=0,$limite=0,$var2=0, $otros=""){
	  	$query="";
		$vRet = "Error";

	  	$ip=$_SERVER['REMOTE_ADDR']; 
	  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
     	$Conn = new voConnPDO();

    	switch ($tipo){
			case 51:
				switch($var2){
					case 10:
						parse_str($arg);
						$iduser = $this->getIdUserFromAlias($u);
						$idemp = $this->getIdEmpFromAlias($u);

	          			$ar = explode("|",$dests);
						foreach($ar as $i=>$valor){
							if ((int)($ar[$i])>0){
								$query = "Insert Into pase_salida_alumnos(idpsa,idalumno,idciclo,clave_nivel,idgrupo,idemp,ip,host,creado_por,creado_el)
																	value($idpsa,$ar[$i],$idciclo,$clave_nivel,$idgrupo,$idemp,'$ip','$host',$iduser,NOW())";
								
								$result = $Conn->exec($query);

								if ($result != 1){
									$vR = $Conn->errorInfo();
									$vRet = 'Hey'; //var_dump($vR[2]);
								}else{
									$vRet = "OK";
								}

							}
						}
						break;		
					case 20:
						parse_str($arg);
	          			$ar = explode("|",$dests);
						foreach($ar as $i=>$valor){
							if ((int)($ar[$i])>0){
								$query = "Delete from pase_salida_alumnos where idpsaalumno = ".$ar[$i];

								$result = $Conn->exec($query);

								if ($result != 1){
									$vR = $Conn->errorInfo();
									$vRet = var_dump($vR[2]);
								}else{
									$vRet = "OK";
								}

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
     	$Conn = new voConnPDO();

    	switch ($index){


			case 19:
				switch($tipo){
					case 1:
					     //$ar = $this->unserialice_force($arg);

				
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

							$query = "update boleta_paibi set 	
															".$ec0." = ".$arrIdPAICRIT[$i].",
															".$ev0." = ".$arrIdPAICAL[$i].",
															".$rc0." = ".$rc1.",
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									Where idboletapaibi = ".$arrIdPAIID[$i];
									$result = $Conn->exec($query);
									if ($result != 1){
										$vR =  $Conn->errorInfo();
										$vRet = is_null($vR[2]) ? "OK":var_dump($vR[2]);
										
									}

						}					
						
						break;		
				}
				break;

			case 46: //46
				switch($tipo){
					case 1:
					     //$ar = $this->unserialice_force($arg);
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);
						$idciclo = $this->getCicloFromIdEmp($idemp);		        

						$c0 = explode('|', $cal0);
						$c1 = explode('|', $cal1);

						$o1 = explode('|', $obs1);

						for ($i=0; $i < count($c0); $i++) { 
							$query = "update boleta_partes_markbook set 	
															calificacion = ".floatval($c1[$i]).",
															observaciones = '".$o1[$i]."',
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									Where idbolparmkb = ".intval($c0[$i]);
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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
							$query = "insert into boleta_asistencias(
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
															values(
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $fecha;//var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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
							$query = "update boleta_asistencias set 	
															asistencia = ".floatval($c1[$i]).",
															observaciones = '".$o1[$i]."',
															evaluacion = $evaluacion,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									Where idbolasist = ".intval($c0[$i]);
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
						}					
						break;		

					case 2:
						parse_str($arg);

						$c0 = explode('|', $cal0);

						for ($i=0; $i < count($c0); $i++) { 
							$query = "delete from boleta_asistencias Where idbolasist = ".intval($c0[$i]);
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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
							$query = "insert into usuarios_conectados(
															iduser,
															username,
															isconectado,
															ultima_conexion,
															idemp,
															ip,
															host,
															creado_por,
															creado_el)
													values(
															$idusr,
															'$u',
															1,
															NOW(),
															$idemp,
															'$ip',
															'$host',
															$idusr,
															NOW() )" ;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}

						}else{
					        $IsConnect = $this->IsConnectUser($idusr,$idemp);
					        if (intval($IsConnect) <= 0){
								$query = "update usuarios_conectados set 	
																isconectado = 1,
																ultima_conexion = NOW(),
																ip = '$ip', 
																host = '$host',
																modi_por = $idusr, 
																modi_el = NOW()
										Where iduser = $idusr and idemp = $idemp and isconectado = 0";
								$result = $Conn->exec($query);
								if ($result != 1){
									$vR = $Conn->errorInfo();
									$vRet = var_dump($vR[2]);
								}else{
									$vRet = "OK";
								}
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
							$query = "update usuarios_conectados set 	
															isconectado = 0,
															ultima_conexion = NOW(),
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									Where iduser = $idusr and idemp = $idemp and isconectado = 1";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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

						$query = "insert into evaluaciones_config(
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
														values(
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
						$result = $Conn->exec($query);
						if ($result != 1){
							$vR = $Conn->errorInfo();
							$vRet = var_dump($vR[2]);
						}else{
							$vRet = "OK";
						}

						break;		

					case 1:
					     //$ar = $this->unserialice_force($arg);
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);

/*
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
*/

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

						$query = "update evaluaciones_config set 	
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
								Where idevalconfig = $idevalconfig";
						$result = $Conn->exec($query);
						if ($result != 1){
							$vR = $Conn->errorInfo();
							$vRet = var_dump($vR[2]);
						}else{
							$vRet = "OK";
						}

						break;		
					case 2:
						$query = "delete from evaluaciones_config Where idevalconfig = ".$arg;
						$result = $Conn->exec($query);
						if ($result != 1){
							$vR = $Conn->errorInfo();
							$vRet = var_dump($vR[2]);
						}else{
							$vRet = "OK";
						}

						break;		

				} //50
				break;

				case 51:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);
							$query = "Insert Into pases_salida(
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
										value(
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		
						case 1:
						     //$ar = $this->unserialice_force($arg);
														  	// fecha = NOW(),
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$query = "update pases_salida set 	
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
									Where idpsa = $idpsa";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		
						case 2:
							$query = "delete from pases_salida Where idpsa = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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

							$query = "Insert Into familia_convenios(
												idfamilia,
												convenio,
												responsable,
												fecha,
												avisar_caja,
												idemp,ip,host,creado_por,creado_el)
										value(
												$idfamilia2,
												'$convenio',
												'$responsable',
												'$fn',
												$avisar_caja,
												$idemp,'$ip','$host',$idusr,NOW())";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								//$vRet = var_dump($vR[2]);
								$vRet = $fecha; // $vR;
							}else{
								$vRet = "OK";
							}
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);
							$avisar_caja = !isset($avisar_caja)?0:1;
							$fn = explode('-',$fecha);
							$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

							$query = "update familia_convenios set 	
										  	convenio = '$convenio',
										  	responsable = '$responsable',
										  	fecha = '$fn',
										  	avisar_caja = $avisar_caja,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									Where idfamconv = $idfamconv";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;	

						case 2:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($u);
							$idemp = $this->getIdEmpFromAlias($u);

							$query = "delete from familia_convenios Where idfamconv = ".$idfamconv;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		
					} // 52
					break;



				case 53:
					switch($tipo){
						case 0:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);
							//$status_emergencia = !isset($status_emergencia)?0:1;

							$query = "Insert Into cat_emergencias(
												nombre,
												tel1,
												parentezco,
												status_emergencia,
												idemp,ip,host,creado_por,creado_el)
										value(
												'$nombre',
												'$tel1',
												'$parentezco',
												$status_emergencia,
												$idemp,'$ip','$host',$idusr,NOW())";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR;
							}else{
								$vRet = "OK";
							}
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);
							//$status_emergencia = !isset($status_emergencia)?0:1;

							$query = "update cat_emergencias set 	
										  	nombre = '$nombre',
										  	tel1 = '$tel1',
										  	parentezco = '$parentezco',
										  	status_emergencia = $status_emergencia,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									Where idemergencia = $idemergencia";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR ="B ".$Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;	

						case 2:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($u);
							$idemp = $this->getIdEmpFromAlias($u);

							$query = "delete from cat_emergencias Where idemergencia = ".$idemergencia;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		

						case 3:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);
							$predeterminado = !isset($predeterminado)?0:1;	
							$query = "Insert Into emergencias_alumno(
															idemergencia,
															idalumno,
															predeterminado,
															idemp,ip,host,creado_por,creado_el)
														value(
															$idemergencia,
															$idalumno,
															$predeterminado,
												$idemp,'$ip','$host',$idusr,NOW())";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		
							
						case 4:
						     //$ar = $this->unserialice_force($arg);
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);

							$predeterminado = !isset($predeterminado)?0:1;	

							$query = "update emergencias_alumno set 	
															idemergencia = $idemergencia,
															idalumno = $idalumno,
															predeterminado = $predeterminado,
															ip = '$ip', 
															host = '$host',
															modi_por = $idusr, 
															modi_el = NOW()
									Where idemeralu = $idemeralu ";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		

						case 5:
							$query = "delete from emergencias_alumno Where idemeralu = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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

							$query = "Insert Into grupo_materia_config_save(
												idprofesor,
												idgrumat,
												titulo,
												isitem,
												num_eval,
												idciclo,
												idemp,ip,host,creado_por,creado_el)
										value(
												$idusr,
												$idgrumat,
												'$titulo',
												$isitem,
												$num_eval,
												$idciclo,
												$idemp,'$ip','$host',$idusr,NOW())";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$isitem = !isset($isitem)?0:1;	

							$query = "update grupo_materia_config_save set 	
										  	titulo = '$titulo',
										  	isitem = $isitem,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									Where 	idmatconsave = $idmatconsave";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;	

						case 2:

							$query = "delete from grupo_materia_config_save Where idmatconsave = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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

							// $qry = "SELECT iddevice as IDs from cat_devices where iduser = $idusr and UUID = '$UUID' and device_token = '$device_token' and idemp = $idemp limit 1";
							$qry = "SELECT iddevice as IDs from cat_devices where iduser = $idusr and UUID = '$UUID' and idemp = $idemp limit 1";
							
							$result23 = $Conn->queryFetchAllAssocOBJ($qry);
							
							// $v = $result23 ? "OK" : "ERROR";

							
							
							if (!$result23) {
								

								$query = "update cat_devices set 	
											  	status_device = 0
										Where 	iduser = ".$idusr." and type = " . $tD ;

								$result = $Conn->exec($query);

								$query = "Insert Into cat_devices(
													iduser,
													UUID,
													device_token,
													type,
													idciclo,
													idemp,ip,host,creado_por,creado_el)
											value(
													$idusr,
													'$UUID',
													'$device_token',
													'$tD',
													$idciclo,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = $Conn->exec($query);
								if ($result != 1){
									$vR = $Conn->errorInfo();
									$vRet = $idusr;
								}else{
									$vRet = "OK";
								}

							}else{
								$IDs = $result23[0]->IDs;

								$query = "update cat_devices set 	
											  	status_device = 0
										Where 	iduser = ".$idusr." and type = " . $tD ;
								$result = $Conn->exec($query);


								$query = "update cat_devices set 	
											  	UUID = '$UUID',
											  	device_token = '$device_token',
											  	iduser = $idusr,
											  	status_device = 1,
											  	type = $tD,
												ip = '$ip', 
												host = '$host',
												modi_por = $idusr, 
												modi_el = NOW()
										Where 	iddevice = ".$IDs;
								$result = $Conn->exec($query);
								if ($result != 1){
									$vR = $Conn->errorInfo();
									$vRet = "ERROR 2";
								}else{
									$vRet = "OK";
								}
							}

							

							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);

							$query = "update cat_devices set 	
										  	UUID = '$UUID',
										  	device_token = '$device_token',
										  	idsuer = $idusr,
										  	type = '$tD',
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									Where 	iddevice = $iddevice";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;	

						case 2:

							$query = "delete from cat_devices Where iddevice = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = "ERROR D2";
							}else{
								$vRet = "OK";
							}
							break;	

						case 3:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
					        $idemp = $this->getIdEmpFromAlias($user);
								
							$query = "Insert Into mobil_mensaje(
												iddevice,
												titulo,
												mensaje,
												fecha,
												from_module,
												idremitente,
												idemp,ip,host,creado_por,creado_el)
										value(
												$iddevice,
												'$titulo',
												'$mensaje',
												NOW(),
												'$from_module',
												$idusr,
												$idemp,'$ip','$host',$idusr,NOW())";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = "ERROR M3";
;
							}else{
								$vRet = "OK";
							}

							break;		

						case 4:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
					        $idemp = $this->getIdEmpFromAlias($user);
							$idciclo = $this->getCicloFromIdEmp($idemp);		        
							//  and device_token = '$device_token'
							$qry = "SELECT iddevice as IDs from cat_devices where iduser = $idusr and UUID = '$UUID' and idemp = $idemp limit 1";
							
							$result23 = $Conn->queryFetchAllAssocOBJ($qry);
							
							if (!$result23) {
								
								$query = "update cat_devices set 	
											  	status_device = 0
										Where 	iduser = ".$idusr." and type = " . $tD ;
								$result = $Conn->exec($query);

								$query = "Insert Into cat_devices(
													iduser,
													UUID,
													device_token,
													type,
													idciclo,
													idemp,ip,host,creado_por,creado_el)
											value(
													$idusr,
													'$UUID',
													'$device_token',
													'$tD',
													$idciclo,
													$idemp,'$ip','$host',$idusr,NOW())";
								$result = $Conn->exec($query);
								if ($result != 1){
									$vR = $Conn->errorInfo();
									$vRet = "ERROR 1"; // var_dump($vR[2]);
								}else{
									$vRet = "OK";
								}

							}else{
								$IDs = $result23[0]->IDs;

								$query = "update cat_devices set 	
											  	status_device = 0
										Where 	iduser = ".$idusr." and type = " . $tD ;
								$result = $Conn->exec($query);

								$query3 = "UPDATE cat_devices 
												SET device_token = '$device_token',
													status_device = 1
											WHERE iddevice = $IDs";
								$result3 = $Conn->exec($query3);
								if ($result3 != 1){
									$vR = $Conn->errorInfo();
									$vRet = "OK";
								}else{
									$vRet = "OK";
								}
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

							$query = "Insert Into cat_pdfs(
												idnivel,
												pdf,
												ruta,
												fecha,
												idciclo,
												categoria_pdf,
												status_pdf,
												idemp,ip,host,creado_por,creado_el)
										value(
												$idnivel,
												'$pdf',
												'$ruta',
												NOW(),
												$idciclo,
												$categoria_pdf,
												$status_pdf,
												$idemp,'$ip','$host',$idusr,NOW())";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}


							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$status_pdf = !isset($status_pdf)?0:1;

							$query = "update cat_pdfs set 	
										  	pdf = '$pdf',
										  	idnivel = $idnivel,
										  	status_pdf = $status_pdf,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									Where 	idpdf = $idpdf";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;	

						case 2:

							$qry = "SELECT ruta from cat_pdfs where idpdf = ".$arg;							
							$rt = $Conn->queryFetchAllAssocOBJ($qry);
							unlink("../../".$rt[0]->ruta);

							$query = "DELETE FROM cat_pdfs WHERE idpdf = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = "Hols Munfo";//var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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

							$query = "Insert Into cat_beneficios_giros(
												girobeneficio,
												status_giro_beneficio,
												idemp,ip,host,creado_por,creado_el)
										value(
												'$girobeneficio',
												$status_giro_beneficio,
												$idemp,'$ip','$host',$idusr,NOW())";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2]; //var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}


							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$status_giro_beneficio = !isset($status_giro_beneficio)?0:1;

							$query = "update cat_beneficios_giros set 	
										  	girobeneficio = '$girobeneficio',
										  	status_giro_beneficio = $status_giro_beneficio,
											ip = '$ip', 
											host = '$host',
											modi_por = $idusr, 
											modi_el = NOW()
									Where 	idgirobeneficio = $idgirobeneficio";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;	

						case 2:

							$query = "DELETE FROM cat_beneficios_giros WHERE idgirobeneficio = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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

							$query = "Insert Into cat_beneficios_afiliados(
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
										value(
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}


							break;		
						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$status_beneficio = !isset($status_beneficio)?0:1;

							$query = "update cat_beneficios_afiliados set 	
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
									Where 	idbeneficio = $idbeneficio";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							break;	

						case 2:

							$qry = "SELECT imagen from cat_beneficios_afiliados where idbeneficio = ".$arg;							
							$rt = $Conn->queryFetchAllAssocOBJ($qry);
							unlink("../../".$rt[0]->imagen);

							$query = "DELETE FROM cat_beneficios_afiliados WHERE idbeneficio = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
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


							$query = "Insert Into cat_exalumnos(
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
										values(
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $query; // var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		
						case 1:
						     //$ar = $this->unserialice_force($arg);
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);

							$fn = explode('-',$fecha_nacimiento);
							$fn = $fn[2].'-'.$fn[1].'-'.$fn[0];

							$isfam = !isset($isfam)?0:1;
							$status_exalumno = !isset($status_exalumno)?0:1;

							$query = "update cat_exalumnos set 	
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
									Where idexalumno = $idexalumno";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		
						case 2:
							$query = "delete from cat_exalumnos Where idexalumno = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		

						case 3:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);


							$query = "Insert Into exa_emails_enviados(
															para,
															cco,
															titulo,
															cuerpo,
															iddestinatarios,
															idexafirma,
															status_emails_enviados,
															idemp,ip,host,creado_por,creado_el)
										values(
															'$para',
															'$cco',
															'$titulo',
															'$cuerpo',
															'$iddestinatarios',
															$idexafirma,
															1,
												$idemp,'$ip','$host',$idusr,NOW())";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $query; // var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		

						case 4:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);


							$query = "update exa_emails_enviados set 	
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
									Where idexaemailenviado = $idexaemailenviado";
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
							break;		

						case 5:
							$query = "delete from exa_emails_enviados Where idexaemailenviado = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = var_dump($vR[2]);
							}else{
								$vRet = "OK";
							}
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							break;		
						case 1:
						     //$ar = $this->unserialice_force($arg);
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							if ( $vRet == "OK" ){
								if ( isset($predeterminado) ) {
									$q0 = "UPDATE exa_generaciones SET predeterminado = 0 WHERE idemp = $idemp and predeterminado = 1";
									$result = $Conn->exec($q0);
									$q1 = "UPDATE exa_generaciones SET predeterminado = 1 WHERE idgeneracion = $idgeneracion";
									$result = $Conn->exec($q1);
								}
							}
							break;		
						case 2:
							$query = "DELETE FROM exa_generaciones WHERE idgeneracion = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							break;		
						case 1:
						     //$ar = $this->unserialice_force($arg);
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							break;		
						case 2:
							$query = "DELETE FROM cat_pai_criterios WHERE idpaicriterio = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							break;
						case 1:
						     //$ar = $this->unserialice_force($arg);
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							break;		
						case 2:
							$query = "DELETE FROM cat_pai_areas_disciplinarias WHERE idpai = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							break;		
						case 2:
							$query = "DELETE FROM pai_conceptos WHERE idpaiconcepto = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							break;		
						case 2:
							$query = "DELETE FROM pai_objetivos WHERE idpaiobjetivo = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
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

						$query = "insert into cat_listas_vencimientos(
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
														values(
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
						$result = $Conn->exec($query);
						if ($result != 1){
							$vR = $Conn->errorInfo();
							$vRet = var_dump($vR[2]);
						}else{
							$vRet = "OK";
						}

						break;		

					case 1:
					     //$ar = $this->unserialice_force($arg);
						parse_str($arg);
						$idusr = $this->getIdUserFromAlias($u);
				        $idemp = $this->getIdEmpFromAlias($u);

				        $status_fecha_vencimiento = isset($status_fecha_vencimiento)?1:0;

						$query = "update cat_listas_vencimientos set 	
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
								Where idlistavencimiento = $idlistavencimiento";
						$result = $Conn->exec($query);
						if ($result != 1){
							$vR = $Conn->errorInfo();
							$vRet = var_dump($vR[2]);
						}else{
							$vRet = "OK";
						}

						break;		
					case 2:
						$query = "delete from cat_listas_vencimientos Where idlistavencimiento = ".$arg;
						$result = $Conn->exec($query);
						if ($result != 1){
							$vR = $Conn->errorInfo();
							$vRet = var_dump($vR[2]);
						}else{
							$vRet = "OK";
						}

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
								$result = $Conn->exec($query);

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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $query;// $vR[2];
							}else{
								$vRet = "OK";
							}
							break;

						case 1:
							parse_str($arg);
							$idusr = $this->getIdUserFromAlias($user);
							$idemp = $this->getIdEmpFromAlias($user);

							$status_exa_firma = isset($status_exa_firma)?1:0;
							$is_default_firma = isset($is_default_firma)?1:0;

							if ( $is_default_firma == 1 ){

								$query = "UPDATE exa_firmas_email  SET is_default_firma = 0 WHERE iduser = ".$idusr;
								$result = $Conn->exec($query);

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
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $query;// $vR[2];
							}else{
								$vRet = "OK";
							}
							break;		

						case 2:
							$query = "DELETE FROM exa_firmas_email WHERE idexafirma = ".$arg;
							$result = $Conn->exec($query);
							if ($result != 1){
								$vR = $Conn->errorInfo();
								$vRet = $vR[2];
							}else{
								$vRet = "OK";
							}
							break;		
					}
					break; // 68


	  	}

		$Conn = null;
		  
		return $vRet;
	}





	public function setPagos($id=0,$importe=0,$referencia='',$IdUser=0){
	  	$query="";
		$vRet = "Error";

	  	$ip=$_SERVER['REMOTE_ADDR']; 
	  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
     	$Conn = new voConnPDO();

	    $query = "SELECT * FROM _viEdosCta WHERE idedocta = $id LIMIT 1";

     	$Conn = new voConnPDO();
		$rst = $Conn->queryFetchAllAssocOBJ($query);

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
		// $aImporte2 = $rst[0]->importe2;
		// $aIva = $rst[0]->iva;
		$aTotal = $importe;

		$subtotal = $rst[0]->subtotal;
		$descto_becas = $rst[0]->descto_becas;
		$importe = $rst[0]->importe;
		$descto = $rst[0]->descto;
		$recargo = $rst[0]->recargo;
		// $importe2 = $rst[0]->importe2;
		// $iva = $rst[0]->iva;
		$total = $importe;

		$idemisorfiscal = $rst[0]->idemisorfiscal;
		$serie = $rst[0]->serie;
		
		$idmetododepago = 7;

	    $facEnc = "INSERT INTO facturas_encabezado(idcliente,idmetododepago,idemisorfiscal,serie,referencia,fecha,fecha_total_pagado,subtotal,descto_becas,importe,descto,recargo,total,idemp,ip,host,creado_por,creado_el)
	    		VALUES(".$IdFs.",$idmetododepago,$idemisorfiscal,'$serie','$referencia',NOW(),NOW(),$subtotal,$descto_becas,$importe,$descto,$recargo,$total,$idemp,'$ip','$host',$idusr,NOW())";

		$result = $Conn->exec($facEnc);
		if ($result != 1){
			$vR = $Conn->errorInfo();
			$vRet = var_dump($vR[2]);
		}else{
			$vRet = "OK";
		}

	    $qry = "SELECT MAX(idfactura) as IDs from facturas_encabezado";
		$result23 = $Conn->queryFetchAllAssocOBJ($qry);
		if (!$result23) {
			$rFac=0;
		}else{
			$rFac = $result23[0]->IDs;
		}

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

		$result = $Conn->exec($facDet);
		if ($result != 1){
			$vR = $Conn->errorInfo();
			$vRet = var_dump($vR[2]);
		}else{
			$vRet = "OK";
		}


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
	
		$result = $Conn->exec($qry);
		if ($result != 1){
			$vR = $Conn->errorInfo();
			$vRet = var_dump($vR[2]);
		}else{
			$vRet = "OK";
		}


		$Conn = null;		  

		return $vRet;
	}





	public function setPreinscripciones($tipo=0,$cad=""){

	  	$query="";
		$vRet = "Error";

	  	$ip=$_SERVER['REMOTE_ADDR']; 
	  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
     	$Conn = new voConnPDO();

		switch($tipo){
			case 0:
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

				$query = "Insert Into preinscripciones(
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
									)value(
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
					     Where idpreinscripcion = $idpreinscripcion";

				break;		

		}

		$result = $Conn->exec($query);

		if ($result != 1){
			$vR = $Conn->errorInfo();
			$vRet = $vR;//var_dump($vR[2]);
		}else{
			$vRet = "OK";
		}


		$Conn = null;
	  

		return $vRet;

}


	public function updateVencimientoEdoCta($cad) {

		parse_str($cad);

		$query = "SET @X = Actualizar_Pagos_Metodo_B(".$idfamilia.",0,1)";
		$ret = $Conn->query($query);

		$query="SELECT @X as outvar;";
		$result = $Conn->query($query);
		foreach ($result as $x)
		{
		    $ret=$x['outvar'];
		}

		$Conn = null;
	    return $ret;

	}

	public function refreshVencimientos($cad) {

		parse_str($cad);
     	$Conn = new voConnPDO();

		$query = "SET @X = Actualizar_Pagos_Metodo_B(".$idfamilia.",0,1)";
		$ret = $Conn->query($query);

		$query="SELECT @X as outvar;";
		$result = $Conn->query($query);
		foreach ($result as $x)
		{
		    $ret=$x['outvar'];
		}

		if ( $ret == "OK" ) {

			$query = "SET @Y = Actualizar_Pagos_Metodo_A(".$idfamilia.",0,1)";
			$ret = $Conn->query($query);

			$query="SELECT @Y as outvar;";
			$result = $Conn->query($query);
			foreach ($result as $x)
			{
			    $ret=$x['outvar'];
			}

		}

		$Conn = null;
	    return $ret;

	}

	public function revivePago($cad='') {

		parse_str($cad);
     	$Conn = new voConnPDO();

		$query = "SET @X = Revive_Pago(".$pIdEdoCta.",".$pIdUser.",'".$pUsuario."')";
		$ret = $Conn->query($query);

		$Conn = null;
	    return $ret;

	}



	public function setCloneMatConSave($cad=''){
	  	$query="";
		$vRet = "Error";

	  	$ip=$_SERVER['REMOTE_ADDR']; 
	  	$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
     	$Conn = new voConnPDO();

		parse_str($cad);
		$idusr = $this->getIdUserFromAlias($u);
        $idemp = $this->getIdEmpFromAlias($u);
		$idciclo = $this->getCicloFromIdEmp($idemp);		        

	    $query = "select * from grupo_materia_config where idgrumat = $idgrumatold and num_eval = $num_eval_old ";

     	$Conn = new voConnPDO();
		$rst = $Conn->queryFetchAllAssocOBJ($query);

		if (!$rst) {
			return false;
		}

		foreach($rst as $i=>$valor){

			$descripcion = $rst[$i]->descripcion;
			$porcentaje = $rst[$i]->porcentaje;
			$aceptacero = $rst[$i]->aceptacero;
			$secuencia = $rst[$i]->secuencia;
			$idalutipoactividad = $rst[$i]->idalutipoactividad;
			$idgrumatconold = $rst[$i]->idgrumatcon;

			$query = "Insert Into grupo_materia_config(
								idgrumat,
								num_eval,
								descripcion,
								porcentaje,
								aceptacero,
								secuencia,
								idalutipoactividad,
								idemp,ip,host,creado_por,creado_el)
						value(
								$idgrumat,
								$num_eval,
								'$descripcion',
								$porcentaje,
								$aceptacero,
								$secuencia,
								$idalutipoactividad,
								$idemp,'$ip','$host',$idusr,NOW())";
			$result = $Conn->exec($query);
			if ($result != 1){
				$vR = $Conn->errorInfo();
				$vRet = $vR;
			}else{
				$vRet = "OK";
			}

			if (intval($isitem) > 0){

				$idusr = $this->getIdUserFromAlias($u);
		        $idemp = $this->getIdEmpFromAlias($u);

			    $q0 = "SELECT MAX(idgrumatcon) as ids FROM grupo_materia_config ";
				$r0 = $Conn->queryFetchAllAssocOBJ($q0);
				$idgrumatcon = $r0[0]->ids;

			    $q1 = "SELECT * FROM grupo_materia_config_markbook WHERE idgrumatcon = $idgrumatconold ";
				$r1 = $Conn->queryFetchAllAssocOBJ($q1);
				foreach($r1 as $j=>$valor){
					$db = $r1[$j]->descripcion_breve;
					$da = $r1[$j]->descripcion_avanzada;

					$q2 = "Insert Into grupo_materia_config_markbook(
										idgrumatcon,
										descripcion_breve,
										descripcion_avanzada,
										idemp,ip,host,creado_por,creado_el)
								value(
										$idgrumatcon,
										'$db',
										'$da',
										$idemp,'$ip','$host',$idusr,NOW())";
					$r2 = $Conn->exec($q2);
					if ($r2 != 1){
						$vR = $Conn->errorInfo();
						$vRet = $vR;
					}else{
						$vRet = "OK";
					}

				}

			}


		}

		$Conn = null;
	    return $vRet;

	}


	public function refreshBoletaPAIBI($cad) {

		parse_str($cad);
     	$Conn = new voConnPDO();

		$query = "SET @X = Actualizar_Boletas_PAIBI(".$idgrumat.")";
		$ret = $Conn->query($query);

		$query="SELECT @X as outvar;";
		$result = $Conn->query($query);
		foreach ($result as $x)
		{
		    $ret=$x['outvar'];
		}

		$Conn = null;
	    return $ret;

	}



}

?>