<?php
$cadena_xml='<?xml version="1.0" encoding="utf-8" standalone="yes"?>'."\r\n";
$cadena_xml.='<cfdi:Comprobante xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:iedu="http://www.sat.gob.mx/iedu" version="3.3" serie="'.$serie.'" folio="'.$folio.'" fecha="'.$fecha.'" sello="'.$sello.'" formaDePago="'.$forma_pago.'" noCertificado="'.$num_certificado.'" certificado="'.$certificado_texto.'" subTotal="'.number_format($subtotal2, 2, '.','').'" TipoCambio="1.00" Moneda="MXN" total="'.number_format($total_cadena, 2, '.','').'" tipoDeComprobante="'.$tipo_cfdi.'" metodoDePago="'.$metodo_pago.'" LugarExpedicion="'.$codigo_postal_emisor." FechaFolioFiscalOrig="'.$fecha.'" MontoFolioFiscalOrig="'.number_format($total_cadena, 2, '.','').'" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3  http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/iedu http://www.sat.gob.mx/sitio_internet/cfd/iedu/iedu.xsd" xmlns:cfdi="http://www.sat.gob.mx/cfd/3">'."\r\n";
$cadena_xml.='<cfdi:Emisor rfc="'.$rfc_emisor.'" nombre="'.$razon_social_emisor.' RegimenFiscal="603" />'."\r\n";
$cadena_xml.='<cfdi:Receptor rfc="'.trim($rfc).'" nombre="'.trim($razon_social).'" UsoCFDI="G01" />'."\r\n";
$cadena_xml.='<cfdi:Conceptos>'."\r\n"; 
$arConc = explode(';',$cadConc);
foreach($arConc as $i=>$value){
	$Item = explode('|',$arConc[$i]);
	if (intval($Item[0])>0) {
    $cadena_xml.='<cfdi:Concepto cantidad="'.trim($Item[0]).'" unidad="Pza" descripcion="'.trim($Item[1]).'" valorUnitario="'.trim($Item[3]).'" importe="'.trim($Item[3]).'">'."\r\n";
      $cadena_xml.='<cfdi:ComplementoConcepto>'."\r\n";
        $cadena_xml.='<iedu:instEducativas version="1.0" nombreAlumno="'.trim($Item[4]).'" CURP="'.trim($Item[5]).'" nivelEducativo="'.trim($Item[7]).'" autRVOE="'.trim($Item[6]).'" rfcPago="'.trim($rfc).'" /> '."\r\n";
      $cadena_xml.='</cfdi:ComplementoConcepto>'."\r\n";
    $cadena_xml.='</cfdi:Concepto>'."\r\n";
	}
}
  $cadena_xml.='</cfdi:Conceptos>'."\r\n";
  $cadena_xml.='<cfdi:Impuestos totalImpuestosTrasladados="0.00" totalImpuestosRetenidos="0.00" /> '."\r\n";
$cadena_xml.=trim('</cfdi:Comprobante>');
?>