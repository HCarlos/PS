<?php
ini_set('display_errors', '0');    
error_reporting(E_ALL | E_STRICT);  
class voConn
{
	
		private static $instancia;
		public static $server;
		public static $user;
		public static $pass;
		public static $db;

		private function __construct(){ 
			   $this->server = "localhost:3306";
			   $this->user = "tecnoint_usrSCPR";
			   $this->pass = "yvhevt5MJfyu";
			   $this->db = "tecnoint_dbPlatSource";
		}


	     public static function getInstance(){
			     	 self::$instancia = new self;
				    if (  !self::$instancia instanceof self){
					    self::$instancia = new self;

				     }
					return self::$instancia;
	     }

   
}

?>
