<?php

class oCommunications_Android {
	 
	 private static $instancia;
	 
	 private function __construct(){ 
		
	 }
	 
	public static function getInstance(){
				if (  !self::$instancia instanceof self){
					  self::$instancia = new self;
				}
				return self::$instancia;
	 }

	 public function sendNotification_Android($token,$mensaje,$type,$title="Colegio Arjí AC",$badge="0"){

		$registrationIds = $token;
		$body = $mensaje;

		if ( $type == 1 ){
			// iOS
			$API_ACCESS_KEY = 'AIzaSyD6p5QiWIA9zrUlTBsgJJ8Pbg2225cec7E';
		} else{
			// Android
			$API_ACCESS_KEY = 'AIzaSyDOffRahfHSX0fqoQ2FkQacpnP-AJg4NwM';
		}	


		$msg = array
		(
			"body" => $body,
			"title"	=> $title
		);

		$data = array
		(
			"badge" => $badge
		);

		$fields = array
		(
		 	"to" 	=> $registrationIds,
			"priority" => "normal",
			"notification" => $msg,
			"data" => $data
		);

		$headers = array
		(
			'Authorization: key=' . $API_ACCESS_KEY,
			'Content-Type: application/json',
			'Application: x-www-form-urlencoded',
			'Charset: UTF-8'
		);

		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		return $result;

		}

}

?>