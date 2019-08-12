<?php

/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
*/

// include("../includes/metas.php");

require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_GET["user"];
$iduser = $_GET["iduser"];
$idgrualu = $_GET["idgrualu"];
$idemp = $_GET["idemp"];

$arg = "u=$user&idgrualu=$idgrualu";

$rs = $f->getCombo(2,$arg,0,0,11,'');

$logoEmp = $F->getLogoEmp($idemp);
$logoIB = $F->getLogoIB($idemp);

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="tecnointel.mx" name="author">

    <link href="<?= "https://".$_SERVER['SERVER_NAME'];?>/css/style-t1.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= "https://".$_SERVER['SERVER_NAME'];?>/assets/css_/font-awesome.css" />

    <link rel="stylesheet" href="<?= "https://".$_SERVER['SERVER_NAME'];?>/assets/css/ace-fonts.css" />

    <!--ace styles-->

    <link rel="stylesheet" href="<?= "https://".$_SERVER['SERVER_NAME'];?>/assets/css/ace.css" />
    <link rel="stylesheet" href="<?= "https://".$_SERVER['SERVER_NAME'];?>/assets/css/ace-responsive.css" />

    <link href="<?= "https://".$_SERVER['SERVER_NAME'];?>/css/docs.css" rel="stylesheet">
    <link href="<?= "https://".$_SERVER['SERVER_NAME'];?>/css/sg-01.css" rel="stylesheet">

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
            <div class="widget-header widget-header-flat header-color-orange">
                <h4 class="">
                    <i class="icon-calendar"></i>
                    <?php 
                        if ( count($rs) > 0 ) { 
                    ?>
                    <span> <?= $rs[0]->nombres_alumno.' '.$rs[0]->apellidos_alumno;  ?></span>
                    <?php 
                        } 
                    ?>
                </h4>                       
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <?php
                        if ( count($rs) > 0 && intval($rs[0]->ver_boleta_interna) == 1 ){
                            $claveNivel = intval($rs[0]->clave_nivel);
                            $bEsp = "";
                            $bing = "Inglés";

                            switch ($claveNivel) {
                                 case 5:
                                     $url = "print-calif-prepa-interna-arji/";
                                     break;
                                 case 4:
                                     $url = "print-calif-secundaria-interna-arji/";
                                     break;
                                 case 2:
                                     $url = "print-calif-primaria-interna-arji/";
                                     break;
                                 case 3:
                                     $url = "print-calif-primaria-interna-arji/";
                                     break;
                                 case 1:
                                    $bEsp = "Español";
                                     $url = "print-calif-kinder-interna-arji-esp/";
                                     $url2 = "print-calif-kinder-interna-arji-ing/";
                                     break;
                             } 
    
                        $idgrualu = $rs[0]->idgrualu;
                        $nc = "u=$user&strgrualu=$idgrualu&logoEmp=$logoEmp&logoIbo=$logoIB&grado=".$rs[0]->grado;

                            if ( $claveNivel != 1 ){

                            ?>

                                <form action="https://platsource.mx/<?= $url; ?>" method="POST">
                
                                    <input type="hidden" name="o" value="0" id="o" />
                                    <input type="hidden" name="t" value="40" id="t" />
                                    <input type="hidden" name="c" value="<?= $nc; ?>" id="c" />
                                    <input type="hidden" name="from" value="0" id="from" />
                                    <input type="hidden" name="cantidad" value="0" id="cantidad" />
                                    <input type="hidden" name="s" value=" order by orden_impresion asc " id="s" />
                                    
                                    <div class="row-fluid">
                                        <button type="submit" class="btn btn-app btn-yellow btn-mini pull-right" >
                                            <i class="icon-calendar bigger-160"></i>
                                            Ver Boleta <?= $bEsp; ?>
                                        </button>
                                    </div>

                                </form>

                            <?php
                            }else{
                            ?>

                                <form action="https://platsource.mx/<?= $url2; ?>" method="POST">
                
                                    <input type="hidden" name="o" value="0" id="o" />
                                    <input type="hidden" name="t" value="40" id="t" />
                                    <input type="hidden" name="c" value="<?= $nc; ?>" id="c" />
                                    <input type="hidden" name="from" value="0" id="from" />
                                    <input type="hidden" name="cantidad" value="0" id="cantidad" />
                                    <input type="hidden" name="s" value=" order by orden_impresion asc " id="s" />
                                    
                                    <div class="row-fluid">
                                        <button type="submit" class="btn btn-app btn-yellow btn-mini pull-right" >
                                            <i class="icon-calendar bigger-160"></i>
                                            Ver Boleta  <?= $bIng; ?>
                                        </button>
                                    </div>

                                </form>

                            <?php

                            }

                        }else{
                    ?>
                        <b>Boleta NO DISPONIBLE</b>
                    <?php
                        }
                    ?>

                </div><!--/widget-main-->
            </div><!--/widget-body-->

        </div>

    </div>

</div>

</body>
</html>
