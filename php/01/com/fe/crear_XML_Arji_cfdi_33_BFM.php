<?php
$arConc = explode(';',$cadConc);

$SubtotalX = number_format($subtotal2, 2, '.','');
//$xBase     = number_format( ( $SubtotalX/count($arConc) ) , 2, '.',''); // sustituye a $Item[11];
// $SubtotalX = number_format( ( $xBase*count($arConc) ) , 2, '.','');
$xB = 0;
foreach($arConc as $i=>$value){
  $Item = explode('|',$arConc[$i]);
  if (intval($Item[0])>0) {
        $xB = $xB + number_format($Item[11], 2, '.','');
    }
}

$SubtotalX = number_format( $xB , 2, '.','');

$buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
$reemplazar=array("", "", "", "");
$cert=str_ireplace($buscar,$reemplazar,$certificado_texto);
$cadena_xml='<?xml version="1.0" encoding="utf-8"?>'."\r\n";
$cadena_xml.='<cfdi:Comprobante Certificado="'.$cert.'" Sello="'.$sello.'" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="3.3" Serie="'.$serie.'" Folio="'.$folio.'" Fecha="'.$fecha.'" FormaPago="'.$metodo_pago.'" NoCertificado="'.$num_certificado.'" SubTotal="'.$SubtotalX.'" Moneda="MXN" Total="'.number_format($total_cadena, 2, '.','').'" TipoDeComprobante="I" MetodoPago="PUE" LugarExpedicion="'.$codigo_postal_emisor.'" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd" xmlns:cfdi="http://www.sat.gob.mx/cfd/3">'."\r\n";
$cadena_xml.='  <cfdi:Emisor Rfc="'.$rfc_emisor.'" RegimenFiscal="601" Nombre="'.$razon_social_emisor.'" />'."\r\n";
$cadena_xml.='  <cfdi:Receptor Rfc="'.$rfc.'" UsoCFDI="'.$usoCFDi33.'" Nombre="'.trim($razon_social).'" />'."\r\n";
$cadena_xml.='  <cfdi:Conceptos>'."\r\n";
$arConc = explode(';',$cadConc);
$xBase = $SubtotalX; // sustituye a $Item[11];

$tasa = '0.160000'; 
$sumaIva=0;

foreach($arConc as $i=>$value){
  $Item = explode('|',$arConc[$i]);
  if (intval($Item[0])>0) {
      $cadena_xml.='    <cfdi:Concepto Cantidad="'.trim($Item[0]).'" Unidad="'.trim($Item[16]).'" Descripcion="'.trim($Item[1]).'" ValorUnitario="'.trim($Item[11]).'" Importe="'.trim($Item[11]).'" ClaveProdServ="'.trim($Item[14]).'" ClaveUnidad="'.trim($Item[15]).'">'."\r\n";
      $cadena_xml.='      <cfdi:Impuestos>'."\r\n";
      $cadena_xml.='        <cfdi:Traslados>'."\r\n";
      $cadena_xml.='          <cfdi:Traslado Base="'.trim($Item[11]).'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="'.$tasa.'" Importe="'.trim($Item[10]).'" />'."\r\n";
      $cadena_xml.='        </cfdi:Traslados>'."\r\n";
      $cadena_xml.='      </cfdi:Impuestos>'."\r\n";
      $cadena_xml.='    </cfdi:Concepto>'."\r\n";
      $sumaIva = $sumaIva + number_format(floatval($Item[10]), 2, '.', '');
  }
}
$cadena_xml.='  </cfdi:Conceptos>'."\r\n";
$cadena_xml.='  <cfdi:Impuestos TotalImpuestosTrasladados="'.$sumaIva.'">'."\r\n";
$cadena_xml.='    <cfdi:Traslados>'."\r\n";
$cadena_xml.='      <cfdi:Traslado Impuesto="002" TipoFactor="Tasa" TasaOCuota="'.$tasa.'" Importe="'.$sumaIva.'" />'."\r\n";
$cadena_xml.='    </cfdi:Traslados>'."\r\n";
$cadena_xml.='  </cfdi:Impuestos>'."\r\n";
$cadena_xml.='</cfdi:Comprobante>';
?>