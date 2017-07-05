<?php

include("../includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$iduser = $_POST['iduser'];
// $idtarea = $_POST['idtarea'];
$idedocta = $_POST['idedocta'];

if ( isset( $_POST['idconcepto'] ) ){
    $idconcepto = intval($_POST['idconcepto']);
}else{
    $idconcepto = 0;    
}

$rs = $f->getQuerys(31012,"user=$user&idedocta=$idedocta");

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="tecnointel.mx" name="author">

    <link href="<?= "http://".$_SERVER['SERVER_NAME'];?>/css/style-t1.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= "http://".$_SERVER['SERVER_NAME'];?>/assets/css_/font-awesome.css" />

    <link rel="stylesheet" href="<?= "http://".$_SERVER['SERVER_NAME'];?>/assets/css/ace-fonts.css" />

    <!--ace styles-->

    <link rel="stylesheet" href="<?= "http://".$_SERVER['SERVER_NAME'];?>/assets/css/ace.css" />
    <link rel="stylesheet" href="<?= "http://".$_SERVER['SERVER_NAME'];?>/assets/css/ace-responsive.css" />

    <link href="<?= "http://".$_SERVER['SERVER_NAME'];?>/css/docs.css" rel="stylesheet">
    <link href="<?= "http://".$_SERVER['SERVER_NAME'];?>/css/sg-01.css" rel="stylesheet">

<style type="text/css">

@media screen and (max-width: 980px){
    #contenedor{
        width: 96%;
    }
    #contenido{
        width: 60%;
    }
    #barra_lateral{
        width:30%;
    }
}


@media screen and (max-width: 480px){
    #encabezado{
        height: auto;
    }
    #contenido{
        width: auto;
    }
    #barra_lateral{
        display:none;
    }
}

body {
    width: 96%;
    max-width: 1024px;
    padding: 1%;
}

html { 
    -webkit-background-size: cover;
    background-size: cover;
}

@media only screen 
    and (min-device-width : 375px) 
    and (max-device-width : 667px) 
    and (width : 667px) 
    and (height : 375px) 
    and (orientation : landscape) 
    and (color : 8)
    and (device-aspect-ratio : 375/667)
    and (aspect-ratio : 667/375)
    and (device-pixel-ratio : 2)
    and (-webkit-min-device-pixel-ratio : 2)
{ }

@media only screen 
    and (min-device-width : 375px) 
    and (max-device-width : 667px) 
    and (width : 375px) 
    and (height : 559px) 
    and (orientation : portrait) 
    and (color : 8)
    and (device-aspect-ratio : 375/667)
    and (aspect-ratio : 375/559)
    and (device-pixel-ratio : 2)
    and (-webkit-min-device-pixel-ratio : 2)
{ }


@media only screen 
    and (min-device-width : 414px) 
    and (max-device-width : 736px) 
    and (orientation : landscape) 
    and (-webkit-min-device-pixel-ratio : 3) 
{ }


@media only screen 
    and (min-device-width : 414px) 
    and (max-device-width : 736px)
    and (device-width : 414px)
    and (device-height : 736px)
    and (orientation : portrait) 
    and (-webkit-min-device-pixel-ratio : 3) 
    and (-webkit-device-pixel-ratio : 3)
{ }


@media only screen 
    and (max-device-width: 640px), 
    only screen and (max-device-width: 667px), 
    only screen and (max-width: 480px)
{ }

</style>

</head>
<body>
<div class="row-fluid">
    <div class="span12 widget-container-span ui-sortable">
        <div class="widget-box">
            <div class="widget-header widget-header-flat">
                <h4 class="smaller lighter blue">
                    <i class="icon-flag"></i>
                    <span id="tituloPanel">Pagos</span>
                </h4>                       
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    
                    <form action="https://www.adquiramexico.com.mx/clb/endpoint/colegioarji/" method="POST" target="_blank">
                        <table class="table">
                            <tr>
                                <td>ID</td>
                                <td><?= $rs[0]->idedocta; ?></td>
                            </tr>
                            <tr>
                                <td>CONCEPTO</td>
                                <td><?= $rs[0]->concepto.' '.$rs[0]->mes; ?></td>
                            </tr>
                            <tr>
                                <td>IMPORTE</td>
                                <td><?= $rs[0]->importe; ?></td>
                            </tr>
                            <tr>
                                <td>- DESCUENTO</td>
                                <td><?= $rs[0]->descto; ?></td>
                            </tr>
                            <tr>
                                <td>+ RECARGO</td>
                                <td><?= $rs[0]->recargo; ?></td>
                            </tr>
                            <tr>
                                <td>TOTAL</td>
                                <td><?= $rs[0]->total; ?></td>
                            </tr>
                            <tr>
                                <td>FECHA DE PAGO</td>
                                <td><?= $rs[0]->fecha_de_pago; ?></td>
                            </tr>
                            <tr>
                                <td>STATUS</td>
                                <td><?= intval($rs[0]->status_movto) == 0 ? "<b style='color:red'>ACTIVO<b>" : "<b style='color:green'>PAGADO<b>" ; ?></td>
                            </tr>
                        </table>
                        <input type="hidden" name="s_transm" value="<?= $rs[0]->idedocta; ?>" id="s_transm"/>
                        <input type="hidden" name="c_referencia" value="<?= $rs[0]->idedocta; ?>" id="c_referencia"/>
                        <input type="hidden" name="val_1" value="000" id="val_1"/>
                        <input type="hidden" name="t_servicio" value="<?= $rs[0]->concepto2; ?>" id="t_servicio"/>
                        <input type="hidden" name="t_importe" value="<?= $rs[0]->total; ?>" id="t_importe"/>
                        <input type="hidden" name="val_2" value="<?= $rs[0]->tutor; ?>" id="val_2"/>
                        <input type="hidden" name="val_3" value="1" id="val_3"/>
                        <input type="hidden" name="val_4" value="1" id="val_4"/>
                        <input type="hidden" name="val_5" value="1" id="val_5"/>
                        <input type="hidden" name="val_6" value="1" id="val_6"/>
                        <input type="hidden" name="IdUser" value="<?= $iduser; ?>" id="IdUser"/>
                        
                        <?php
                            if ( intval($rs[0]->status_movto) == 0 && $idconcepto > 0){
                        ?>
                        <div class="row-fluid">
                            <input type="submit" class="btn btn-primary pull-right" value="Realizar Pago" />
                        </div>
                        <?php
                            }
                        ?>

                    </form>

                </div><!--/widget-main-->
            </div><!--/widget-body-->

        </div>

    </div>

</div>

</body>
</html>
