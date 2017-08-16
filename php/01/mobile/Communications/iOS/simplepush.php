<?php



ini_set('display_errors', '0');     
error_reporting(E_ALL | E_STRICT);  

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Put your device token here (without spaces):
$deviceToken = strtoupper('9759b56f789dc70c3c9f60abc305d4431ccfe657f41b6fe7dff61aed262ebbb8');

// Put your private key's passphrase here:
// $passphrase = 'devch43';
$passphrase = 'DevCH45';

// Put your alert message here:
$message = 'Tiene un nuevo Mensaje!';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'aps_production.ColegioArji.Colegio-Arji--A-C-.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body["aps"] = array(
	"alert" => $message,
	"badge" => 0,
	"sound" => "default"
	);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Error' . PHP_EOL;
else
	echo 'OK' . PHP_EOL;

// Close the connection to the server
fclose($fp);
