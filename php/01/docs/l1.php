<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SIBM | Centro 2013 - 2015</title>
<link rel="stylesheet" type="text/css" href="../../../css/01/class_gen.css"/>
</head>

<body>

<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Mexico_City');
set_include_path(get_include_path() . PATH_SEPARATOR . '../PHPExcel/Classes/');
set_time_limit(600);

require_once("../PHPExcel/Classes/PHPExcel.php");
require_once("../PHPExcel/Classes/PHPExcel/Reader/Excel2007.php");
// require_once('../vo/voConn.php');
require_once("../oFunctions.php");
require_once("../oCentura.php");
$f = oCentura::getInstance();

$arg = $_POST["arg"];

$F = oFunctions::getInstance();
// $Conn = voConn::getInstance();
// $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
// mysql_select_db($Conn->db);
// mysql_query("SET NAMES UTF8");

$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(false);



$objPHPExcel = $objReader->load("templates/_fmt_rep_prepa_arji_1.xlsx"); //cargamos el archivo excel (extensión *.xlsx)
$fileout= "--rep-1.xlsx";
//$query = "Select count(idprodgpo) as sumid, idprodgpo,abrdep as grupo, grupo as dependencia from _viDemanda where (fecha between '$fi' and '$ff')  group by idprodgpo";
$query = "SELECT * FROM _viUsuariosBecas $cad ";

// $result = mysql_query($query);
$result = $this->getArray($query);

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
$objWriter->setIncludeCharts(TRUE);


	$i=9;$k=0;	
	// while ($fila = mysql_fetch_object($result)) {
	foreach ($result as $j => $value) {

		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, $result[$j]->idusuario);
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $result[$j]->curp);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $result[$j]->apellido_paterno);

		$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $result[$j]->apellido_materno);
		$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $result[$j]->nombre);
		$objPHPExcel->getActiveSheet()->setCellValue("F".$i, $result[$j]->fecha_nacimiento);

		$objPHPExcel->getActiveSheet()->setCellValue("G".$i, $result[$j]->lugar_nacimiento);
		$objPHPExcel->getActiveSheet()->setCellValue("H".$i, $result[$j]->sexo);
		$objPHPExcel->getActiveSheet()->setCellValue("I".$i, $result[$j]->edad);
		$objPHPExcel->getActiveSheet()->setCellValue("J".$i, $result[$j]->escuela);
		$objPHPExcel->getActiveSheet()->setCellValue("K".$i, $result[$j]->otra_escuela);

		$objPHPExcel->getActiveSheet()->setCellValue("L".$i, $result[$j]->nivelc);
		$objPHPExcel->getActiveSheet()->setCellValue("M".$i, $result[$j]->grado);
		$objPHPExcel->getActiveSheet()->setCellValue("N".$i, $result[$j]->promedio);
		$objPHPExcel->getActiveSheet()->setCellValue("O".$i, $result[$j]->calle);
		$objPHPExcel->getActiveSheet()->setCellValue("P".$i, $result[$j]->no_ext);
		$objPHPExcel->getActiveSheet()->setCellValue("Q".$i, $result[$j]->no_int);
		

		$objPHPExcel->getActiveSheet()->setCellValue("R".$i, $result[$j]->colonia);
		$objPHPExcel->getActiveSheet()->setCellValue("S".$i, $result[$j]->localidad);
		$objPHPExcel->getActiveSheet()->setCellValue("T".$i, $result[$j]->ciudad);
		$objPHPExcel->getActiveSheet()->setCellValue("U".$i, $result[$j]->municipio);
		$objPHPExcel->getActiveSheet()->setCellValue("V".$i, $result[$j]->estado);
		$objPHPExcel->getActiveSheet()->setCellValue("W".$i, $result[$j]->email);

	// TUTOR	IFE	ARCHIVO IFE	DOM TUTOR	STATUS


		$objPHPExcel->getActiveSheet()->setCellValue("X".$i, $result[$j]->celular);
		$objPHPExcel->getActiveSheet()->setCellValue("Y".$i, $result[$j]->telefono);
		$objPHPExcel->getActiveSheet()->setCellValue("Z".$i, $result[$j]->formato1);
		$objPHPExcel->getActiveSheet()->setCellValue("AA".$i, $result[$j]->no_apoyo);
		$objPHPExcel->getActiveSheet()->setCellValue("AB".$i, $result[$j]->tipo_asesoria);
		$objPHPExcel->getActiveSheet()->setCellValue("AC".$i, $result[$j]->beneficiario);

		$objPHPExcel->getActiveSheet()->setCellValue("AD".$i, $result[$j]->beneficio);
		$objPHPExcel->getActiveSheet()->setCellValue("AE".$i, $result[$j]->tipo_asesoria2);
		$objPHPExcel->getActiveSheet()->setCellValue("AF".$i, $result[$j]->beneficiario2);
		$objPHPExcel->getActiveSheet()->setCellValue("AG".$i, $result[$j]->beneficio2);
		$objPHPExcel->getActiveSheet()->setCellValue("AH".$i, $result[$j]->tipo_asesoria2);
		$objPHPExcel->getActiveSheet()->setCellValue("AI".$i, $result[$j]->beneficiario3);

		$objPHPExcel->getActiveSheet()->setCellValue("AJ".$i, $result[$j]->beneficio3);
		$objPHPExcel->getActiveSheet()->setCellValue("AK".$i, $result[$j]->compromiso1);
		$objPHPExcel->getActiveSheet()->setCellValue("AL".$i, $result[$j]->compromiso2);
		$objPHPExcel->getActiveSheet()->setCellValue("AM".$i, $result[$j]->compromiso3);
		$objPHPExcel->getActiveSheet()->setCellValue("AN".$i, $result[$j]->areayuda);
		$objPHPExcel->getActiveSheet()->setCellValue("AO".$i, $result[$j]->areayuda2);
		$objPHPExcel->getActiveSheet()->setCellValue("AP".$i, $result[$j]->areayuda3);

		$objPHPExcel->getActiveSheet()->setCellValue("AQ".$i, $result[$j]->tutor);
		$objPHPExcel->getActiveSheet()->setCellValue("AR".$i, $result[$j]->ife);
		$objPHPExcel->getActiveSheet()->setCellValue("AS".$i, $result[$j]->ife_file);
		$objPHPExcel->getActiveSheet()->setCellValue("AT".$i, $result[$j]->dom_tutor);
		$objPHPExcel->getActiveSheet()->setCellValue("AU".$i, $result[$j]->status);
		$objPHPExcel->getActiveSheet()->setCellValue("AV".$i, $result[$j]->is_beca);


		++$i;++$k;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i, 1);
		//$title=$iddep==0?"CATALOGO DE SERVICIOS POR DEPENDENCIA ":"CATALOGO DE SERVICIOS DE '".utf8_decode($result[$j]->grupo)."'";
	}
	$j = $i+3;
	//$objPHPExcel->getActiveSheet()->setCellValue("C3", $title);
	$objPHPExcel->getActiveSheet()->setCellValue("B5", $F->getWith3LetterMonthH(date('Y-m-d H:i:s')));
	$objPHPExcel->getActiveSheet()->setCellValue("B".$j, $k);

            
	//$objWriter->save($fileout);//guardamos el archivo excel  
	$objWriter->save($fileout);//guardamos el archivo excel  



?>

</body>
</html>


