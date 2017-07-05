<?php
class oCommunications {
	 
	 private static $instancia;
	 
	 private function __construct(){ 
		
	 }
	 
	public static function getInstance(){
				if (  !self::$instancia instanceof self){
					  self::$instancia = new self;
				}
				return self::$instancia;
	 }

	 public function sendNotification_iOS($token,$mensaje){

		$deviceToken = strtoupper($token);
		// $passphrase = 'devch43';
		$passphrase = 'DevCH45';
		$message = $mensaje;
		$ret = "";

		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'aps_production.ColegioArji.Colegio-Arji--A-C-.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		$ret = 'Connected to APNS' . PHP_EOL;

		// Create the payload body
		$body['aps'] = array(
			'alert' => $message,
			'sound' => 'default'
			);

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		if (!$result)
			$ret = 'Message not delivered' . PHP_EOL;
		else
			$ret = 'OK'; //'Message successfully delivered' . PHP_EOL;

		// Close the connection to the server
		fclose($fp);

		return $ret;

	 }
	 	

}

?>