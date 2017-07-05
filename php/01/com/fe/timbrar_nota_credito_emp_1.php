<?php 
ob_end_clean();

header("html/text; charset=utf-8");  
header("Cache-Control: no-cache");

require_once('../../vo/voConn.php');
require_once('../../oCentura.php');

$Q = oCentura::getInstance();

$arg   = $_POST["data"];
parse_str($arg);

$regimen_fiscal_emisor = 'Régimen General de Ley Personas Morales';//$_REQUEST['regimen_emisor'];
$view = 1;

date_default_timezone_set('America/Mexico_city');

$fecha             = date('Y-m-d')."T".date("H:i:s",time()-(2*60));
$fechacomp         = date('Y-m-d');
$lugar_expedicion  = "Villahermosa, Tabasco";
$aprobacion        = 1;
$year_aprobacion   = "2012";

$tipo_cfdi         = "egreso";
$folio             = "";
$dias_credito      = 0;
$iva               = 0; // 16;
$ivaRet            = 0;

$tipo_docto        = "NOTA DE CRÉDITO";

$f0 = date_create();
$folSer = date_timestamp_get($f0);
$folio = $folSer;

$Conn = voConn::getInstance();
$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
mysql_select_db($Conn->db);

$efx = explode('-', $idemisorfiscal);

$emifisNC0 = mysql_query("select rfc,razon_social,calle, num_ext, num_int,colonia,localidad,estado,cp,pais,is_iva from _viEmiFis where idemisorfiscal = $efx[0] and idemp = $idemp and status_emisor_fiscal = 1");

switch ( intval($idemisorfiscal) ){
	case 1:

			$num_certificado   = "00001000000403139734";
			$file_cer          = "00001000000403139734_arji/00001000000403139734.txt";
			$file_key          = "00001000000403139734_arji/CSD_matriz_CAR7909222P7_20160718_125941.pem";
			$file_user         = "rived67@hotmail.com";
			$file_rfc          = "CAR7909222P7";
			$file_pass         = "u98Kh7";
			$cadena_original   = "00001000000403139734_arji/cadenaoriginal_3_2.xslt";
			$dir_imgs              = "arji_Imgs/";
			$dir_upload            = "../../../../uw_fe/";
			$file_logo         	   = "logo_arji.gif";
			$file_back             = "back.jpg";
			$serie			       = "ANC";
			$rfc_emisor            = mysql_result($emifisNC0, 0,"rfc");
			$razon_social_emisor   = mysql_result($emifisNC0, 0,"razon_social");
			$calle_emisor          = mysql_result($emifisNC0, 0,"calle");
			$num_exterior_emisor   = mysql_result($emifisNC0, 0,"num_ext");
			$num_interior_emisor   = mysql_result($emifisNC0, 0,"num_int");;
			$colonia_emisor        = mysql_result($emifisNC0, 0,"colonia");;
			$localidad_emisor      = mysql_result($emifisNC0, 0,"localidad");
			$estado_emisor         = mysql_result($emifisNC0, 0,"estado");
			$codigo_postal_emisor  = mysql_result($emifisNC0, 0,"cp");
			$pais_emisor           = mysql_result($emifisNC0, 0,"pais");
			$is_iva          	   = intval(mysql_result($ef, 0,"is_iva"));
			$regimen_fiscal_emisor = "ASOCIACION CIVIL";
			$rgb  = array(64,105,154);
			
			break;
	case 2:
			
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

			$serie   			   = "BNC";

			$rfc_emisor            = mysql_result($emifisNC0, 0,"rfc");
			$razon_social_emisor   = mysql_result($emifisNC0, 0,"razon_social");
			$calle_emisor          = mysql_result($emifisNC0, 0,"calle");
			$num_exterior_emisor   = mysql_result($emifisNC0, 0,"num_ext");
			$num_interior_emisor   = mysql_result($emifisNC0, 0,"num_int");;
			$colonia_emisor        = mysql_result($emifisNC0, 0,"colonia");;
			$localidad_emisor      = mysql_result($emifisNC0, 0,"localidad");
			$estado_emisor         = mysql_result($emifisNC0, 0,"estado");
			$codigo_postal_emisor  = mysql_result($emifisNC0, 0,"cp");
			$pais_emisor           = mysql_result($emifisNC0, 0,"pais");
			$is_iva          	   = intval(mysql_result($ef, 0,"is_iva"));
			$regimen_fiscal_emisor = "PERSONAS MORALES DEL REGIMEN GENERAL";
			
			$rgb  = array(64,105,154);
			
			break;
}
echo  $idfactura;
$fe0 = mysql_query("select idcliente, importe, descto, recargo, importe2, iva, total from facturas_encabezado where idfactura = $idfactura and idemp = $idemp limit 1");
$idfamilia 	= mysql_result($fe0, 0,"idcliente");

$certificado_texto = "";
$sello             = "";	

$Conn = voConn::getInstance();
$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
mysql_select_db($Conn->db);
mysql_query("SET NAMES UTF8");

$result = mysql_query("select rfc,razon_social,calle,num_ext, num_int,colonia, localidad,estado, pais, cp from _viRegFis where idregfis = $idregfis and idemp = $idemp limit 1");

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
$referencia    = $referencia;//$arrec[11]; // trim($_REQUEST['referencia']);

$tot = $total; //$_GET["total"];	
$iva    = $iva; //0;
$ivaRet = $total; //0;

$tasaIVA = 16.00;

$subtt = substr($rfc,0,4);
if (in_array($subtt, array("XAXX","XEXX") ) ){
	$tot = floatval($tot); // + floatval($iva);//$_GET["total"];	
	$iva = 0;
}

$subtotal = mysql_result($fe0, 0,"importe");
$descuento= mysql_result($fe0, 0,"descto");
$recargo= mysql_result($fe0, 0,"recargo");
$subtotal2 = mysql_result($fe0, 0,"importe2");
$iva = mysql_result($fe0, 0,"iva");
$total =  mysql_result($fe0, 0,"total");

$total_cadena = $total;

$forma_pago        =  "Pago en una sola exhibición";//trim($_REQUEST['forma_pago']); 

mysql_close($mysql);

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
$servicio = "https://www.factorumweb.com/FactorumWSv32/FactorumCFDiService.asmx?wsdl";
$parametros=array();
$data = file_get_contents($myXML);
$parametros['usuario']  = $file_user;
$parametros['rfc']      = $file_rfc;
$parametros['password'] = $file_pass;
$parametros['xml']=$data; //string, pero se maneja String aqui

try {
	$client = new SoapClient($servicio, $parametros);
	// $result = $client->FactorumGenYaSelladoConArchivoTest($parametros);
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

$Conn = voConn::getInstance();
$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
mysql_select_db($Conn->db);
mysql_query("SET NAMES UTF8");

$folio  = $Q->getFolioTim($serie,$idemp);

mysql_close($mysql);

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

		$Conn = voConn::getInstance();
		$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		mysql_select_db($Conn->db);
		
		$result = mysql_query("
			update facturas_encabezado 
			set isfe = 1, 
				UUID = '$folfis', 
				xml = '$fxml', 
				pdf='$fpdf', 
				serie = '$serie', 
				folio = $folio, 
				fecha_timbrado = NOW(), 
				directorio = '$directorio',
				email_enviado = '$email1'  
			where idfactura = $idfactura");

		unlink($folSer2);

		include("crear_PDF_Arji.php");

		$dir_upload = "http://platsource.mx/uw_fe/".$directorio;
		$pdf = $fpdf;
		$xml = $fxml;
		$emailto = $email1;

		mysql_close($mysql);

	}

}


			
?>