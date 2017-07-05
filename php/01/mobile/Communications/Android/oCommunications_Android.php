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

	 public function sendNotification_Android($token,$mensaje){

		$registrationIds = $token;
		$body = $mensaje;


		$API_ACCESS_KEY = 'AIzaSyDOffRahfHSX0fqoQ2FkQacpnP-AJg4NwM';

		// $registrationIds = "eLrEEuwYxqA:APA91bH2RaxbnSrDD2NVFB52wIzZ_9wfsqTLmIgQp_5lqsKSVHSQd_FE7dbb5Q4K8wwoo-7_X7jXhg1HPZ1H-Movp8jgy64tTGfdbQeXAbbyFQvE7gEJdH0VMK3u2S-AQtvvRRmDMy0T" ;

		$msg = array
		(
			"body" => $body,
			"title"	=> "Colegio Arjí AC"
		);

		$fields = array
		(
		 	'to' 	=> $registrationIds,
			'notification' => $msg
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