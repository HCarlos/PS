<?php
/*
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

class oMetodos {
	 
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
				$ret= $result[0]->idemp;
			}
			$Conn = null;
			return $ret;


	 }

	 private function getCicloFromIdEmp($idemp=0){

			$query = "SELECT idciclo FROM cat_ciclos WHERE idemp = $idemp AND status_ciclo = 1 LIMIT 1";

			$Conn = new voConnPDO();
			$result = $Conn->queryFetchAllAssocOBJ($query);

			if (!$result) {
				$ret=0;
			}else{
				$ret= $result[0]->idciclo;
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
			$ret= $result[0]->idprofesor;
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


	public function Actualizar_Promedios_Grupales($idgrupo=0, $idciclo=0, $user='',$idgrualu=0) {

		$ip=$_SERVER['REMOTE_ADDR']; 
		$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 

		$idemp = $this->getIdEmpFromAlias($user);
		$idusr = $this->getIdUserFromAlias($user);

		// $query = "SET @X = Actualizar_Pagos_Metodo_B(".$idfamilia.",0,".$idemp.",".$idciclo.")";
		$query = "Set @X = Actualizar_Promedios_Grupales(".$idgrupo.", ".$idciclo.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."',".$idgrualu.")";
		$ret = $this->execQuery($query);
	    
	    return $ret;


	}


	public function  Actualiza_Grupo_Alumno_Promedio($user='',$idgrualu=0, $flag=0) {

		$ip=$_SERVER['REMOTE_ADDR']; 
		$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
		$idemp = $this->getIdEmpFromAlias($user);
		$idusr = $this->getIdUserFromAlias($user);

		$query = "SET @X =  Actualiza_Grupo_Alumno_Promedio(".$idgrualu.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."'); ";
	    if ( $flag == 0){
			$ret = $this->execQuery($query);
	    }else{
	    	$ret = $query;
	    }

	    
	    return $ret;


	}

	public function  Actualiza_Grupo_Alumno_Promedio_Prepa($user='',$idgrualu=0, $flag=0) {

		$ip=$_SERVER['REMOTE_ADDR']; 
		$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
		$idemp = $this->getIdEmpFromAlias($user);
		$idusr = $this->getIdUserFromAlias($user);

		$query = "SET @X =  Actualiza_Grupo_Alumno_Promedio_Prepa(".$idgrualu.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."'); ";
	    if ( $flag == 0){
			$ret = $this->execQuery($query);
	    }else{
	    	$ret = $query;
	    }

	    
	    return $ret;


	}


	public function Actualiza_Promedios_Grupales_por_Materia($user='',$idgrualu=0) {
		/*
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);

		  	mysql_query("SET NAMES 'utf8'");
			$query = "Set @Y = Actualiza_Promedios_Grupales_por_Materia(".$idgrualu.")";

			$result = mysql_query($query);
			$ret = $result==false ? mysql_error():"OK";
		    mysql_close($mysql);
			  
			return $ret;

		*/

		// $ip=$_SERVER['REMOTE_ADDR']; 
		// $host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
		// $idemp = $this->getIdEmpFromAlias($user);
		// $idusr = $this->getIdUserFromAlias($user);

		// $query = "Set @Y = Actualiza_Grupo_Alumno_Promedio(".$idgrualu.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."')";
		
		$query = "Set @X = Actualiza_Promedios_Grupales_por_Materia(".$idgrualu.")";
		
		$ret = $this->execQuery($query);
	    
	    return $ret;


	}


	public function  Llamar_Actualizar_Promedios_Padres_from_IdGruAlu($user='',$idgrualu=0) {
		/*
		  	$Conn = voConn::getInstance();
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  	mysql_select_db($Conn->db);

			$ip=$_SERVER['REMOTE_ADDR']; 
			$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
			$idemp = $this->getIdEmpFromAlias($user);
			$idusr = $this->getIdUserFromAlias($user);
			
		  	mysql_query("SET NAMES 'utf8'");
			$query = "Set @Y =  Llamar_Actualizar_Promedios_Padres_from_IdGruAlu(".$idgrualu.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."')";

			$result = mysql_query($query);
			$ret = $result==false ? mysql_error():"OK";
		    mysql_close($mysql);
			  
			return $ret;
		
		*/

		$ip=$_SERVER['REMOTE_ADDR']; 
		$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
		$idemp = $this->getIdEmpFromAlias($user);
		$idusr = $this->getIdUserFromAlias($user);

		// $query = "Set @Y = Actualiza_Grupo_Alumno_Promedio(".$idgrualu.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."')";
		$query = "Set @X =  Llamar_Actualizar_Promedios_Padres_from_IdGruAlu(".$idgrualu.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."')";
		$ret = $this->execQuery($query);
	    
	    return $ret;



	}




	public function Actualizar_Promedios_Grupales_Idiomas($idgrupo=0, $idciclo=0, $user='',$idgrualu=0,$pIdioma=0) {

		$ip=$_SERVER['REMOTE_ADDR']; 
		$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
		$idemp = $this->getIdEmpFromAlias($user);
		$idusr = $this->getIdUserFromAlias($user);

		$query = "Set @X = Actualizar_Promedios_Grupales_Idiomas(".$idgrupo.",".$idgrualu.",".$pIdioma.", ".$idciclo.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."')";
		$ret = $this->execQuery($query);
	    
	    return $ret;



	}


	public function Actualiza_Grupo_Alumno_Promedio_Idioma($user='',$idgrualu=0,$pIdioma=0) {
		$ip=$_SERVER['REMOTE_ADDR']; 
		$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
		$idemp = $this->getIdEmpFromAlias($user);
		$idusr = $this->getIdUserFromAlias($user);

		$query = "Set @X = Actualiza_Grupo_Alumno_Promedio_Idioma(".$idgrualu.", ".$pIdioma.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."')";
		$ret = $this->execQuery($query);

	    return $ret;

	}


	public function Actualiza_Grupo_Alumno_Promedio_Idioma_Kinder($user='',$idgrualu=0,$pIdioma=0) {
		$ip=$_SERVER['REMOTE_ADDR']; 
		$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
		$idemp = $this->getIdEmpFromAlias($user);
		$idusr = $this->getIdUserFromAlias($user);

		$query = "Set @X = Actualiza_Grupo_Alumno_Promedio_Idioma_Kinder(".$idgrualu.", ".$pIdioma.", ".$idusr.", ".$idemp.", '".$ip."', '".$host."')";
		$ret = $this->execQuery($query);

	    return $ret;

	}

	public function Llamar_Actualiza_Promedios_Boletas_por_Grupo($idgrualu=0) {
			
		$query = "Set @X = Llamar_Actualiza_Promedios_Boletas_por_Grupo(".$idgrualu.")";
		$ret = $this->execQuery($query);

	    return $ret;

	}


	public function  Llamar_Actualiza_Boleta_Datos_Secundarios($idgrualu=0) {
			
		$query = "Set @X =  Llamar_Actualiza_Boleta_Datos_Secundarios(".$idgrualu.")";
		$ret = $this->execQuery($query);

	    return $ret;

	}


	public function Copiar_Promedio_a_Promedios_Oficiales_por_Alumno($idalumno=0,$idnivel=0,$user='',$valor=0,$grado=0) {
		  	
		$ip=$_SERVER['REMOTE_ADDR']; 
		$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
		$idemp = $this->getIdEmpFromAlias($user);
		$idusr = $this->getIdUserFromAlias($user);
		$query = "SET @X = Copiar_Promedio_a_Promedios_Oficiales_por_Alumno(".$idalumno.",".$idnivel.",".$idemp.",".$idusr.",".$valor.", '".$ip."', '".$host."', ".$grado.")";
		$ret = $this->execQuery($query);

	    return $ret;


	}




 }  // OF CLASS


?>