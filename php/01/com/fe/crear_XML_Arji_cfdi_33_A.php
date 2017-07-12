<?php
$cadena_xml='<?xml version="1.0" encoding="utf-8"?>'."\r\n";
$cadena_xml.='<cfdi:Comprobante Certificado="'.$certificado_texto.'" Sello="'.$sello.'" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="3.3" Serie="'.$serie.'" Folio="'.$folio.'" Fecha="'.$fecha.'" FormaPago="'.$metodo_pago.'" NoCertificado="'.$num_certificado.'" SubTotal="'.number_format($subtotal2, 2, '.','').'" Moneda="MXN" Total="'.number_format($total_cadena, 2, '.','').'" TipoDeComprobante="I" MetodoPago="PUE" LugarExpedicion="'.$codigo_postal_emisor.'" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd" xmlns:cfdi="http://www.sat.gob.mx/cfd/3">'."\r\n";
$cadena_xml.='  <cfdi:Emisor Rfc="'.trim($rfc_emisor).'" RegimenFiscal="603" Nombre="'.$razon_social_emisor.'" />'."\r\n";
$cadena_xml.='  <cfdi:Receptor Rfc="'.trim($rfc).'" UsoCFDI="G01" Nombre="'.trim($razon_social).'" />'."\r\n";
$cadena_xml.='  <cfdi:Conceptos>'."\r\n";
$arConc = explode(';',$cadConc);

$tasa = $is_iva == 0 ? '0' : '0.160000'; 

foreach($arConc as $i=>$value){
  $Item = explode('|',$arConc[$i]);
  $sumaIva=0;
  if (intval($Item[0])>0) {
      $cadena_xml.='    <cfdi:Concepto Cantidad="'.trim($Item[0]).'" Unidad="Pza" Descripcion="'.trim($Item[1]).'" ValorUnitario="'.trim($Item[3]).'" Importe="'.trim($Item[11]).'" ClaveProdServ="'.trim($Item[9]).'" ClaveUnidad="Pza">'."\r\n";
      $cadena_xml.='      <cfdi:Impuestos>'."\r\n";
      $cadena_xml.='        <cfdi:Traslados>'."\r\n";
      $cadena_xml.='          <cfdi:Traslado Base="'.trim($Item[11]).'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="'.$tasa.'" Importe="'.trim($Item[10]).'" />'."\r\n";
      $cadena_xml.='        </cfdi:Traslados>'."\r\n";
      $cadena_xml.='      </cfdi:Impuestos>'."\r\n";
      $cadena_xml.='      <cfdi:ComplementoConcepto>'."\r\n";
      $cadena_xml.='        <iedu:instEducativas xmlns:iedu="http://www.sat.gob.mx/iedu" xsi:schemaLocation="http://www.sat.gob.mx/iedu http://www.sat.gob.mx/sitio_internet/cfd/iedu/iedu.xsd"  version="1.0" nombreAlumno="'.trim($Item[4]).'" CURP="'.trim($Item[5]).'" nivelEducativo="'.trim($Item[7]).'" autRVOE="'.trim($Item[6]).'" rfcPago="'.trim($rfc).'" /> '."\r\n";
      $cadena_xml.='        </cfdi:ComplementoConcepto>'."\r\n";
      $cadena_xml.='    </cfdi:Concepto>'."\r\n";
      $sumaIva = $sumaIva + floatval($Item[10]);
  }
}
$cadena_xml.='  </cfdi:Conceptos>'."\r\n";
$cadena_xml.='  <cfdi:Impuestos TotalImpuestosTrasladados="'.$sumaIva.'">'."\r\n";
$cadena_xml.='  <cfdi:Traslados>'."\r\n";
$cadena_xml.='  <cfdi:Traslado Impuesto="002" TipoFactor="Tasa" TasaOCuota="'.$tasa.'" Importe="'.$sumaIva.'" />'."\r\n";
$cadena_xml.='  </cfdi:Traslados>'."\r\n";
$cadena_xml.='  </cfdi:Impuestos>'."\r\n";

//  $cadena_xml.='<cfdi:Impuestos totalImpuestosTrasladados="0.00" totalImpuestosRetenidos="0.00" /> '."\r\n";
// $cadena_xml.='  <cfdi:Complemento>'."\r\n";
// $cadena_xml.='    <tfd:TimbreFiscalDigital FechaTimbrado="2017-07-03T10:49:01" NoCertificadoSAT="20001000000300022323" RfcProvCertif="EME000602QR9" SelloCFD="Ei4S9/wAE24gAf1f2BgS4Ce/n2Syc7pHCUTcGFcReGf1QFIW1ljJyZJLt9X9BXffB6yrhzsScMW7C+xF+HOUz3D/JVcKrz1pby04zlYk6m/ADjfCoOylxmzrf22XIMeP8GQ4+/Pl87EmeV9G4lrFU7HBDaTM9nVXbvpwJFOoW3rcW6ig+VaFkVCGmHGmSBYI9oBw21EUQL3ghMU52WDOWaStRBigCEmlUbKu6dlg0olAw2r9zS/GYNoXp9Ny1gRbpcE1f+gJn/wIDYqkBHU0WRL3508w10yxGIsxi+VwJ9n31D8vX7K9n5ZsRLRwFfaUzHzOXeO7DvCo80psGYsjEA==" SelloSAT="GQcUje/ZW5wxqWYz4uNMqaV0G/655kQSWNHRxybskwnbSBobIYCm/6Ftf8FnDIpujmpd28sUQ/hJ27++6Xch+IC23V89lu6C6T1a7aZ6R4VsFko8rf2M0u8Qts5Xob1pKdssSXUY8sVYJatEfr2NDmccL1JGVHsyx0KEGGNkVl9WQ5nWYpj4mRus5X0aohc9dTcxtEfF7AxtLPHixaYSJtTJd0+0VJ4d7u3aXEkKI+P2LHxGf4SkgL2xGqZ/wIT2rRGy85eLLCArABRD2VH7PTSNqbIN6YSJfrRso7ytGDn25uTJzD5maHIu9ZmU7pFtFfEwheTuh7fawaKPZX3ixg==" UUID="120293AB-7E57-472A-85E7-E3507839D338" Version="1.1" xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/timbrefiscaldigital/TimbreFiscalDigitalv11.xsd" />'."\r\n";
// $cadena_xml.='  </cfdi:Complemento>'."\r\n";
$cadena_xml.='</cfdi:Comprobante>';
?>