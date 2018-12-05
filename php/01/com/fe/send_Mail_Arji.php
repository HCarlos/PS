<?php
$ex = explode(';',$emailto);
foreach ($ex as $i => $value) {

    $TO = trim($ex[$i]);

    if ( $TO != ""){

        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // Cabeceras adicionales
        $cabeceras .= 'To: '.utf8_decode($tutor).' <'.$TO.'>'. "\r\n";
        $cabeceras .= 'From: '.$razon_social_emisor.' <caja@arji.edu.mx>' . "\r\n";
        $cabeceras .= 'Bcc: devch@arji.edu.mx' . "\r\n";
        $titulo = $razon_social_emisor.", Factura Electrónica";

        $body = "<html>
        <body style='font-size: 10pt; font-family: Verdana,Geneva,sans-serif'
          bgcolor='#FFFFFF' text='#000000'>
           <p><img src='https://platsource.mx/images/web/logo-arji-horiz-3.png' alt=''></p>
          <p>Estimad@ ".utf8_decode($tutor).", le enviamos la siguiente factura:</p>
          <p class='ecxmsonormal'>
            <ul style='list-style: circle'>
              <li>
                <a href='".$dir_upload.$pdf."' target='_blank'>$pdf</a>
              </li>
              <li>
                <a href='".$dir_upload.$xml."' target='_blank'>$xml</a>
              </li>
            </ul>
        </p>
          <p>Para abrir el archivo requiere el programa Acrobat Reader el cual puede descargar aquí:&nbsp;<a
              href='http://get.adobe.com/es/reader/' target='_blank'><strong><em>Acrobat
                  Reader</em></strong></a></p>
          <p>Para mayor información comuníquese a los teléfonos:&nbsp;<em><strong>351-02-50</strong> ext. <strong>507</strong></em></p>
          <br/>
          <p><small>Powered by <em> <a href='https://www.facebook.com/pages/PlatSource/389634781187356?ref=bookmarks' style='color:green;'>platsource.mx</a></em> <span style='color:#808080'>|</span> versión de CFDi <strong>".$CFDi_ver."</strong></small></p>
          
        </body>
        </html>";

        mail($TO,$titulo,$body,$cabeceras);

    }

}

?>

