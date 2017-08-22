<?php

ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$registrationIds = $_POST['token'];
$body = $_POST['body'];
$type = intval($_POST['type']);
$title = $_POST['title'];
$badge = $_POST['badge'];

date_default_timezone_set('America/Mexico_City');
if ( $type == 1 ){
	// iOS
	define( 'API_ACCESS_KEY', 'AIzaSyD6p5QiWIA9zrUlTBsgJJ8Pbg2225cec7E' );
}else{
	// Android
	define( 'API_ACCESS_KEY', 'AIzaSyDOffRahfHSX0fqoQ2FkQacpnP-AJg4NwM' );
}

$msg = array
(
	"body" => $body,
	"title"	=> $title,
	"priority" => "normal",
	"sound" => "",
	"content-available" => 1
);

$data = array
(
	"badge" => $badge
);

$fields = array
(
 	"to" 	=> $registrationIds,
	"notification" => $msg,
	"data" => $data
);

$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
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
echo $result;


?>