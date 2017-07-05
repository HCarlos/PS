<?php

$data = $_POST['data'];
$idfamilia = $_POST['idfamilia'];
$familia = $_POST['familia'];
$mails = $_POST['mails'];

if (!isset($data)){
  header('Location: http://platsource.mx/');
}

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();

require_once('../oCentura.php');
$f = oCentura::getInstance();

require_once('../oCenturaPDO.php');
$fP = oCenturaPDO::getInstance();

parse_str($data);

$dt = "u=".$u."&vconcepto=".$vconcepto."&clave_nivel=".$clave_nivel."&idfamilia=".$idfamilia."&fvencimiento=$fvencimiento";
    
$rsa = $fP->getQueryPDO(20,$dt,0,0,0,array(),"",1);

$concepto = $rsa[0]->concepto;

$tbl = "<table border='1' style='border-collapse: collapse;'>";
$tbl .= "<thead><tr>";
$tbl .= "<th>ALUMNO</th>";
$tbl .= "<th>CONCEPTO</th>";
$tbl .= "<th>TOTAL</th>";
$tbl .= "<th>VENCIMIENTO</th>";
$tbl .= "<th>GRUPO</th>";
$tbl .= "</tr></thead><tbody>";

foreach ($rsa as $j => $value) {
      $concp0 = $rsa[$j]->concepto.' '.$rsa[$j]->mes.' '.date('Y',strtotime($rsa[$j]->vencimiento));
      $total = number_format($rsa[$j]->total,2);

      $tbl .= "<tr>";
      $tbl .= "<td style='padding:0 10px;'>".utf8_decode( $rsa[$j]->alumno )."</td>";
      $tbl .= "<td style='padding:0 10px;'>".utf8_decode( $concp0 )."</td>";
      $tbl .= "<td style='padding:0 10px; text-align:right;'>".utf8_decode( $total )."</td>";
      $tbl .= "<td style='padding:0 10px; text-align:right;'>".$Q->getWith3LetterMonthD($rsa[$j]->vencimiento)."</td>";
      $tbl .= "<td style='padding:0 10px; text-align:right;'>".$rsa[$j]->grupo."</td>";
      $tbl .= "</tr>";
}

$tbl .= "</tbody></table>";

$ex = explode(';',$mails);
foreach ($ex as $i => $value) {

  // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
  $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
  $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

  // Cabeceras adicionales
  $cabeceras .= 'To: '.utf8_decode($familia).' <'.$ex[$i].'>'. "\r\n";
  $cabeceras .= 'From: Dirección Administrativa Arjí A.C. <caja@arji.edu.mx>' . "\r\n";
  $cabeceras .= 'Cco: devch@arji.edu.mx' . "\r\n";
  $titulo = "Colegio Arjí A.C., Recordatorio de Pago";

$body = "<html>
    <body style='font-size: 10pt; font-family: Verdana,Geneva,sans-serif'
      bgcolor='#FFFFFF' text='#000000'>
       <p><img src='http://platsource.mx/images/web/logo-arji-horiz-2.png' alt=''></p>
    <p>Estimados señores: <strong>".utf8_decode($familia)."</strong>,</p>
    <p>De la manera más atenta les recordamos que en nuestros registros aparece que usted tiene los siguientes adeudos de <b>".$concepto."</b>:</p>
    <p class='ecxmsonormal'>
    $tbl   
    </p>
    <p>&nbsp;Por lo que le pedimos pasar a la brevedad posible a liquidar su adeudo.</p>
    <p>&nbsp;También puede pagar en <a href='http://platsource.mx' target='_blank'>http://platsource.mx</a> </p>
    <p>&nbsp;Para mayor información comuníquese a los teléfonos:&nbsp;<em><strong>351-02-50</strong> ext. <strong>507</strong></em></p>
    <p><small>Powered by <em> <a href='https://www.facebook.com/pages/PlatSource/389634781187356?ref=bookmarks' style='color:green;'>platsource.mx</a></em></small></p>
  </body>
</html>";

  mail($ex[$i],$titulo,$body,$cabeceras);

}

?>

