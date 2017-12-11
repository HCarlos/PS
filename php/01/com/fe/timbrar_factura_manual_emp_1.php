<?php 
ob_end_clean();

ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

header("Content-type:application/json; charset=utf-8");  
header("Cache-Control: no-cache");

// require_once('../../vo/voConn.php');
require_once('../../oCentura.php');
$f = oCentura::getInstance();

$arg   = $_POST["data"];
parse_str($arg);
// echo $arg;
$regimen_fiscal = 'Régimen General de Ley Personas Morales';//$_REQUEST['regimen_emisor'];
$view = 1;

date_default_timezone_set('America/Mexico_city');

//
$fecha             = date('Y-m-d')."T".date("H:i:s",time()-(2*60));
$fechacomp         = date('Y-m-d');
$lugar_expedicion  = "Villahermosa, Tabasco";
$aprobacion        = 1;
$year_aprobacion   = "2012";

$tipo_cfdi         = "ingreso";

$folio             = "";
$dias_credito      = 0;
$iva               = 0; // 16;
$ivaRet            = 0;

$tipo_docto        = "FACTURA";

$f0 = date_create();
$folSer = date_timestamp_get($f0);
$folio = $folSer;

// $Conn = voConn::getInstance();
// $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
// mysql_SELECT_db($Conn->db);

$efxi = explode('-', $idemisorfiscal);

// $ef = mysql_query("SELECT rfc,razon_social,calle, num_ext, num_int,colonia,localidad,estado,cp,pais,is_iva FROM _viEmiFis WHERE idemisorfiscal = ".$efxi[0]." AND idemp = $idemp AND status_emisor_fiscal = 1");
$query = "SELECT rfc,razon_social,calle, num_ext, num_int,colonia,localidad,estado,cp,pais,is_iva FROM _viEmiFis WHERE idemisorfiscal = ".$efxi[0]." AND idemp = $idemp AND status_emisor_fiscal = 1";
$ef = $f->getArray($query);

switch ($serie){
	case "AFM":

			$num_certificado   = "00001000000403139734";
			$file_cer          = "00001000000403139734_arji/00001000000403139734.txt";
			$file_key          = "00001000000403139734_arji/CSD_matriz_CAR7909222P7_20160718_125941.pem";
			$file_user         = "rived67@hotmail.com";
			$file_rfc          = "CAR7909222P7";
			$file_pass         = "u98Kh7";
			$cadena_original   = "00001000000403139734_arji/cadenaoriginal_3_2.xslt";
			$dir_imgs          = "arji_Imgs/";
			$dir_upload        = "../../../../uw_fe/";
			$file_logo         = "logo_arji.gif";
			$file_back         = "back.jpg";
/*
			$rfc_emisor           	= mysql_result($ef, 0,"rfc");
			$razon_social_emisor  	= mysql_result($ef, 0,"razon_social");
			$calle_emisor         	= mysql_result($ef, 0,"calle");
			$num_exterior_emisor  	= mysql_result($ef, 0,"num_ext");
			$num_interior_emisor  	= mysql_result($ef, 0,"num_int");;
			$colonia_emisor       	= mysql_result($ef, 0,"colonia");;
			$localidad_emisor     	= mysql_result($ef, 0,"localidad");
			$estado_emisor        	= mysql_result($ef, 0,"estado");
			$codigo_postal_emisor 	= mysql_result($ef, 0,"cp");
			$pais_emisor          	= mysql_result($ef, 0,"pais");
			$is_iva          	    = intval(mysql_result($ef, 0,"is_iva"));
*/			
			$rfc_emisor           	= $ef[0]->rfc;
			$razon_social_emisor  	= $ef[0]->razon_social;
			$calle_emisor         	= $ef[0]->calle;
			$num_exterior_emisor  	= $ef[0]->num_ext;
			$num_interior_emisor  	= $ef[0]->num_int;
			$colonia_emisor       	= $ef[0]->colonia;
			$localidad_emisor     	= $ef[0]->localidad;
			$estado_emisor        	= $ef[0]->estado;
			$codigo_postal_emisor 	= $ef[0]->cp;
			$pais_emisor          	= $ef[0]->pais;
			$is_iva          	    = intval($ef[0]->is_iva);

			$regimen_fiscal_emisor 	= "ASOCIACION CIVIL";
			
			$rgb  = array(64,105,154);
			//$logo = 'imgs/logo_arji.gif';
			
			break;
	case "BFM":
			
			$num_certificado   = "00001000000202748523";
			$file_cer          = "COMESA_OpenSSL/00001000000202748523.txt";
			$file_key          = "COMESA_OpenSSL/00001000000202748523.key.pem";
			$file_user         = "caja_arji@hotmail.com";
			$file_rfc          = "CAR930816FH0";
			$file_pass         = "CAR930816FH0";
			$cadena_original   = "COMESA_OpenSSL/cadenaoriginal_3_2.xslt";
			$dir_imgs          = "arji_Imgs/";
			$dir_upload        = "../../../../uw_fe/";
			$file_logo         = "logo_comer_arji.gif";
			$file_back         = "back.jpg";

/*
			$rfc_emisor            = mysql_result($ef, 0,"rfc");
			$razon_social_emisor   = mysql_result($ef, 0,"razon_social");
			$calle_emisor          = mysql_result($ef, 0,"calle");
			$num_exterior_emisor   = mysql_result($ef, 0,"num_ext");
			$num_interior_emisor   = mysql_result($ef, 0,"num_int");;
			$colonia_emisor        = mysql_result($ef, 0,"colonia");;
			$localidad_emisor      = mysql_result($ef, 0,"localidad");
			$estado_emisor         = mysql_result($ef, 0,"estado");
			$codigo_postal_emisor  = mysql_result($ef, 0,"cp");
			$pais_emisor           = mysql_result($ef, 0,"pais");
			$is_iva          	   = intval(mysql_result($ef, 0,"is_iva"));
*/

			$rfc_emisor           	= $ef[0]->rfc;
			$razon_social_emisor  	= $ef[0]->razon_social;
			$calle_emisor         	= $ef[0]->calle;
			$num_exterior_emisor  	= $ef[0]->num_ext;
			$num_interior_emisor  	= $ef[0]->num_int;
			$colonia_emisor       	= $ef[0]->colonia;
			$localidad_emisor     	= $ef[0]->localidad;
			$estado_emisor        	= $ef[0]->estado;
			$codigo_postal_emisor 	= $ef[0]->cp;
			$pais_emisor          	= $ef[0]->pais;
			$is_iva          	    = intval($ef[0]->is_iva);

			$regimen_fiscal_emisor = "PERSONAS MORALES DEL REGIMEN GENERAL";
			
			$rgb  = array(64,105,154);
			
			break;
}


// $fe0 = mysql_query("SELECT idcliente, importe, descto, recargo, importe2, iva, total FROM facturas_encabezado WHERE idfactura = $idfactura AND idemp = $idemp LIMIT 1");
// $idfamilia 	= mysql_result($fe0, 0,"idcliente");

$query = "SELECT idcliente, importe, descto, recargo, importe2, iva, total FROM facturas_encabezado WHERE idfactura = $idfactura AND idemp = $idemp LIMIT 1";
$fe0 = $f->getArray($query);
$idfamilia = $fe0[0]->idcliente;


$certificado_texto = "";
$sello             = "";	
/*
$Conn = voConn::getInstance();
$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
mysql_SELECT_db($Conn->db);
mysql_query("SET NAMES UTF8");

$result = mysql_query("SELECT rfc,razon_social,calle,num_ext, num_int,colonia, localidad,estado, pais, cp FROM _viRegFis WHERE idregfis = $idregfis AND idemp = $idemp LIMIT 1");

$rfc           = mysql_result($result, 0,"rfc");//$arrec[0]; // trim($_REQUEST['rfc']); 
$rf0           = explode('-',$rfc);  
$rfc           = $rf0[0];
$razon_social  = mysql_result($result, 0,"razon_social");//$arrec[1]; // trim($_REQUEST['razon_social']);
$calle         = mysql_result($result, 0,"calle");//$arrec[2]; // trim($_REQUEST['calle']); 
$num_exterior  = mysql_result($result, 0,"num_ext");//$arrec[3]; // trim($_REQUEST['num_exterior']); 
$num_interior  = mysql_result($result, 0,"num_int");//$arrec[4]; // trim($_REQUEST['num_interior']);
$colonia       = mysql_result($result, 0,"colonia");//$arrec[5]; // trim($_REQUEST['colonia']); 
$localidad     = mysql_result($result, 0,"localidad");//$arrec[6]; // trim($_REQUEST['localidad']);
$estado        = mysql_result($result, 0,"estado");//$arrec[8]; // trim($_REQUEST['estado']); 
$pais          = mysql_result($result, 0,"pais");//$arrec[9]; // trim($_REQUEST['pais']);
$codigo_postal = mysql_result($result, 0,"cp");//$arrec[10]; // trim($_REQUEST['codigo_postal']); 
*/

$query = "SELECT rfc,razon_social,calle,num_ext, num_int,colonia, localidad,estado, pais, cp FROM _viRegFis WHERE idregfis = $idregfis AND idemp = $idemp LIMIT 1";
$result = $f->getArray($query);
$rfc           = $result[0]->rfc; 
$rf0           = explode('-',$rfc);  
$rfc           = $rf0[0];
$razon_social  = $result[0]->razon_social;
$calle         = $result[0]->calle; 
$num_exterior  = $result[0]->num_ext; 
$num_interior  = $result[0]->num_int;
$colonia       = $result[0]->colonia; 
$localidad     = $result[0]->localidad;
$estado        = $result[0]->estado; 
$pais          = $result[0]->pais;
$codigo_postal = $result[0]->cp; 


$tot = $total; //$_GET["total"];	
$iva    = $iva; //0;
$ivaRet = $total; //0;

$tasaIVA = 16.00;

$subtt = substr($rfc,0,4);
if (in_array($subtt, array("XAXX","XEXX") ) ){
	$tot = floatval($tot); // + floatval($iva);//$_GET["total"];	
	$iva = 0;
}

/*
$subtotal = mysql_result($fe0, 0,"importe");
$descuento= mysql_result($fe0, 0,"descto");
$recargo= mysql_result($fe0, 0,"recargo");
$subtotal2 = mysql_result($fe0, 0,"importe2");
$iva = mysql_result($fe0, 0,"iva");
$total =  mysql_result($fe0, 0,"total");
*/

$subtotal  = $fe0[0]->importe;
$descuento = $fe0[0]->descto;
$recargo   = $fe0[0]->recargo;
$subtotal2 = $fe0[0]->importe2;
$iva 	   = $fe0[0]->iva;
$total     = $fe0[0]->total;


$total_cadena = $total;

$forma_pago        =  "Pago en una sola exhibición";//trim($_REQUEST['forma_pago']); 

// mysql_close($mysql);

$cadConc = $cadOrd;	

include("crear_XML_Arji.php");

//Generamos la Cadena Original
$cfdi = $cadena_xml;//simplexml_load_file("facturas/Factura-".$serie."-".$folio.".xml");
$xml = new DOMDocument();
$xml->loadXML($cadena_xml) or die("\n\n\nXML no válido..");
$xslt = new XSLTProcessor();
$XSL = new DOMDocument();
$XSL->load($cadena_original, LIBXML_NOCDATA);
error_reporting(0); # Se deshabilitan los errores pues el xssl de la cadena esta en version 2 y eso genera algunos warnings
$xslt->importStylesheet( $XSL );
error_reporting(E_ALL); # Se habilitan de nuevo los errores (se asume que originalmente estaban habilitados)
$c = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0);
$cadena = $xslt->transformToXML( $c );
unset($xslt, $XSL);


$ar=fopen($file_cer,"r") or die("No se pudo abrir el archivo...");

while (!feof($ar))
	  {
		$certificado_texto.= fgets($ar);
	  }
fclose($ar);
	
//Gneramos el Sello Digital
$key=$file_key;
$fp = fopen($key, "r");
$priv_key = fread($fp, 8192);
//echo $fp;

fclose($fp);		
$pkeyid = openssl_get_privatekey($priv_key);
openssl_sign($cadena,$cadenafirmada,$pkeyid,OPENSSL_ALGO_SHA1);
$sello = base64_encode($cadenafirmada);

$folfis="";

include("crear_XML_Arji.php");

$myXML = $dir_upload."Fac-".$folSer.".xml";

$new_xml = fopen ($myXML, "w");
fwrite($new_xml,$cadena_xml);
fclose($new_xml);

// Ahora Timbramos la Factura
		// https://www.factorumweb.com/FactorumWSV32/FactorumCFDiService.asmx 
// $servicio = "https://www.factorumweb.com/FactorumWSv32/FactorumCFDiService.asmx?wsdl";
$servicio = "http://factorumweb.com/FactorumWSv32/FactorumCFDiService.asmx?wsdl";

$parametros=array();
$data = file_get_contents($myXML);
$parametros['usuario']  = $file_user;
$parametros['rfc']      = $file_rfc;
$parametros['password'] = $file_pass;
$parametros['xml']=$data; //string, pero se maneja String aqui
try {
	$client = new SoapClient($servicio, $parametros);
	$result = $client->FactorumGenYaSelladoConArchivo($parametros);
} catch (SoapFault $E) {  
    echo $E->faultstring; 
    return false;
}  

foreach($result as $key => $value) {
    $data = $value->ReturnFileXML;
    $img = $value->ReturnFileQRCode;    
}

// BUSCAMOS EL ARCHIVO

$folSer2 = $dir_upload."Fac-".$folSer.".xml";

// $Conn = voConn::getInstance();
// $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
// mysql_SELECT_db($Conn->db);
// mysql_query("SET NAMES UTF8");

$folio  = $f->getFolioTim($serie,$idemp);

// mysql_close($mysql);

$folSer = $serie."-".str_pad($folio, 6, "0", STR_PAD_LEFT);
$x_x    = $dir_upload.$idcliente."/"."Fac-".$folSer.".pdf";

$isFound = false;
while (!$isFound) {
	if (!file_exists($x_x)){
	   $isFound=true;	
	   break;
	}else{
		++$folio;
		$folSer = $serie."-".str_pad($folio, 6, "0", STR_PAD_LEFT);
		$x_x = $dir_upload.$idcliente."/"."Fac-".$folSer.".xml";
	}
}

$directorio = $idcliente."/";


if(is_dir($dir_upload.$directorio )==false){ 
	mkdir($dir_upload.$directorio, 0777);
}

$myXML    = $dir_upload.$directorio."Fac-".$folSer.".xml";
$gif      = $dir_upload.$directorio."Fac-Img-".$folSer.".gif";
$pdf_file = $dir_upload.$directorio."Fac-".$folSer.".pdf";

$selloSAT = "";
$certSAT  = "";

$fp = fopen($gif, 'w');
fwrite($fp, $img);
fclose($fp);

$new_xml = fopen ($myXML, "w");
fwrite($new_xml,$data);
fclose($new_xml);

$xml = simplexml_load_file($myXML);
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
$xml->registerXPathNamespace('t', $ns['tfd']);

//ESTA ULTIMA PARTE ES LA QUE GENERABA EL ERROR
foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
  
	$folfis =  strtoupper($tfd['UUID']);
  	$selloSAT = $tfd['selloSAT'];
  	$certSAT  = $tfd['noCertificadoSAT'];
  	$fhSAT  = $tfd['FechaTimbrado'];

	if ($folfis!=""){
		$fxml = "Fac-".$folSer.".xml";
		$fpdf = "Fac-".$folSer.".pdf";

/*
		$Conn = voConn::getInstance();
		$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		mysql_SELECT_db($Conn->db);
		
		$result = mysql_query("
			UPDATE facturas_encabezado 
				set isfe = 1, 
					idemisorfiscal = ".$efxi[0].", 
					idregfis = $idregfis,
					metodo_de_pago = $idmetododepago,
					referencia = '$referencia',
					UUID = '$folfis', 
					xml = '$fxml', 
					pdf='$fpdf', 
					serie = '$serie', 
					folio = $folio, 
					fecha_timbrado = NOW(), 
					directorio = '$directorio',
					email_enviado = '$email1'  
				WHERE idfactura = $idfactura");
*/

		$query = "
			UPDATE facturas_encabezado 
				SET isfe = 1, 
					idemisorfiscal = ".$efxi[0].", 
					idregfis = $idregfis,
					metodo_de_pago = $idmetododepago,
					referencia = '$referencia',
					UUID = '$folfis', 
					xml = '$fxml', 
					pdf='$fpdf', 
					serie = '$serie', 
					folio = $folio, 
					fecha_timbrado = NOW(), 
					directorio = '$directorio',
					email_enviado = '$email1'  
				WHERE idfactura = $idfactura";
		$result = $f->guardarDatos($query);

		unlink($folSer2);

		include("crear_PDF_Arji.php");

		$dir_upload = "https://platsource.mx/uw_fe/".$directorio;
		$pdf = $fpdf;
		$xml = $fxml;
		$emailto = $email1;
		$CFDi_ver = "3.2";

		include("send_Mail_Arji.php");

		// mysql_close($mysql);

	}

}

			
?>