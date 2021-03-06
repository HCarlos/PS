﻿<?php
$buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
$reemplazar=array("", "", "", "");
$cert=str_ireplace($buscar,$reemplazar,$certificado_texto);
$cadena_xml='<?xml version="1.0" encoding="utf-8"?>'."\r\n";
$cadena_xml.='<cfdi:Comprobante Certificado="'.$cert.'" Sello="'.$sello.'" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" Version="3.3" Serie="'.$serie.'" Folio="'.$folio.'" Fecha="'.$fecha.'" FormaPago="'.$metodo_pago.'" NoCertificado="'.$num_certificado.'" SubTotal="'.number_format($subtotal2, 2, '.','').'" Moneda="MXN" Total="'.number_format($total_cadena, 2, '.','').'" TipoDeComprobante="I" MetodoPago="PUE" LugarExpedicion="'.$codigo_postal_emisor.'" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd">'."\r\n";
$cadena_xml.='  <cfdi:Emisor Rfc="'.$rfc_emisor.'" RegimenFiscal="601" Nombre="'.$razon_social_emisor.'" />'."\r\n";
$cadena_xml.='  <cfdi:Receptor Rfc="'.$rfc.'" UsoCFDI="'.$usoCFDi33.'" Nombre="'.trim($razon_social).'" />'."\r\n";
$cadena_xml.='  <cfdi:Conceptos>'."\r\n";
$arConc = explode(';',$cadConc);

$tasa = '0.000000'; 

$sumaIva=0;
foreach($arConc as $i=>$value){
  $Item = explode('|',$arConc[$i]);
  if (intval($Item[0])>0) {
      $cadena_xml.='    <cfdi:Concepto ClaveProdServ="01010101" Cantidad="1" ClaveUnidad="'.trim($Item[15]).'" Unidad="'.trim($Item[16]).'" Descripcion="'.trim($Item[1]).'" ValorUnitario="'.trim($Item[11]).'" Importe="'.trim($Item[11]).'" >'."\r\n";
      $cadena_xml.='      <cfdi:Impuestos>'."\r\n";
      $cadena_xml.='        <cfdi:Traslados>'."\r\n";
      $cadena_xml.='          <cfdi:Traslado Base="'.trim($Item[11]).'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="'.$tasa.'" Importe="'.trim($Item[10]).'" />'."\r\n";
      $cadena_xml.='        </cfdi:Traslados>'."\r\n";
      $cadena_xml.='      </cfdi:Impuestos>'."\r\n";
      $cadena_xml.='      <cfdi:ComplementoConcepto>'."\r\n";
      $cadena_xml.='        <iedu:instEducativas xmlns:iedu="http://www.sat.gob.mx/iedu" xsi:schemaLocation="http://www.sat.gob.mx/iedu http://www.sat.gob.mx/sitio_internet/cfd/iedu/iedu.xsd"  version="1.0" nombreAlumno="'.trim($Item[4]).'" CURP="'.trim($Item[5]).'" nivelEducativo="'.trim($Item[7]).'" autRVOE="'.trim($Item[6]).'" rfcPago="'.trim($rfc).'" /> '."\r\n";
      $cadena_xml.='      </cfdi:ComplementoConcepto>'."\r\n";
      $cadena_xml.='    </cfdi:Concepto>'."\r\n";
      $sumaIva = $sumaIva + floatval($Item[10]);
  }
}
$cadena_xml.='  </cfdi:Conceptos>'."\r\n";
$cadena_xml.='  <cfdi:Impuestos TotalImpuestosTrasladados="0.00">'."\r\n";
$cadena_xml.='    <cfdi:Traslados>'."\r\n";
$cadena_xml.='      <cfdi:Traslado Impuesto="002" TipoFactor="Tasa" TasaOCuota="'.$tasa.'" Importe="0.00" />'."\r\n";
$cadena_xml.='    </cfdi:Traslados>'."\r\n";
$cadena_xml.='  </cfdi:Impuestos>'."\r\n";
$cadena_xml.='</cfdi:Comprobante>';
?>