<?php

ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$registrationIds = $_POST['token'];
$body = $_POST['body'];

date_default_timezone_set('America/Mexico_City');

define( 'API_ACCESS_KEY', 'AIzaSyDOffRahfHSX0fqoQ2FkQacpnP-AJg4NwM' );

// $registrationIds = "cyLy-w9RtDA:APA91bFLV1nlTjRSr2cW4uJOaKBUN9822t9pjIkFp5OZGLP9arFCFvOG8CpYuGu8VPEvNJW4mN3P8j8BXdYWfVLuymeOTmCpjkODKku4dAzB26JnLb8Ct7XhZEZXFZ7TuQol6FUPEqmP" ;

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