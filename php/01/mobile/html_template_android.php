<?php

include("../templates/includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
// $idtarea = $_POST['idtarea'];
$idtarea = $_POST['idtarea'];
$idtareadestinatario = $_POST['idtareadestinatario'];

$rs = $f->getQuerys(20001,"idtarea=".$idtarea);

if ( count($rs) <= 0 ){
    $rs[0] = new StdClass();
    $rs[0]->titulo_tarea = "";
    $rs[0]->fecha0 = "";
    $rs[0]->fecha1 = "";
    $rs[0]->tarea = "";
}

$rprof = $f->getQuerys(20010,"idtareadestinatario=".$idtareadestinatario);

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="es-MX"><!--<![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="platsource.mx" name="author">

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
            <div class="widget-header widget-header-flat">
                <h4 class="smaller lighter blue">
                    <i class="icon-flag"></i>
                    <span id="tituloPanel"><?= utf8_decode($rs[0]->titulo_tarea); ?></span>
                </h4>                       
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    
                    <div> 
                        <i class="icon-calendar blue"></i>  
                        <span><strong>Inicio:</strong></span>
                        <span id="fecha_inicio"><?= $rs[0]->fecha0; ?></span>

                        <span class="marginLeft2em"></span>

                        <i class="icon-calendar blue"></i>  
                         <span><strong>Entrega:</strong></span>
                        <span id="fecha_fin"><?= $rs[0]->fecha1; ?></span>

                    </div> <br/>

                    <div class="hr hr2 hr-double"></div>

                    <div> 
                        <h4 class="header smaller lighter green">
                            <i class="icon-bullhorn"></i>
                            Tarea
                        </h4>                
                        <div id="tarea"><?= nl2br(utf8_decode($rs[0]->tarea)); ?></div>
                    </div> <br/>

                    <div class="hr hr2 hr-double"></div>

                    <h4 class="header smaller lighter orange">
                        <i class="fa fa-paperclip bigger-130 cafe"></i>
                        Archivos adjuntos
                    </h4>
                    <?php
                        $rat = $f->getQuerys(20002,"idtarea=".$idtarea); 
                        if (count($rat) > 0){
                    ?>

                    <ul class="wd95prc" id="tbl_FileRespAlu0">
                    <?php
                        foreach ($rat as $i => $value) {
         
                    ?>
                        <li><a href="https://platsource.mx/<?= $rat[0]->directorio; ?><?= $rat[0]->archivo; ?>" target="_blank" rel="external"><?= utf8_decode($rat[0]->descripcion_archivo); ?></a>  <small class="grey"><i><?= $rat[0]->creado_el; ?></i></small>  </li>
                    <?php
                        } 
                    ?>

                    </ul>
                    <?php
                                        
                        } else {

                    ?>
                        <small><i>No se encontraron archivos.</i></small>

                    <?php

                        }

                        $cad = "user=".$user."&idtareadestinatario=".$idtareadestinatario;
                        $f->setSaveData(40,$cad,0,0,9);

                    ?>


                    <br/><br/>

                    <div><strong>Profesor(a):</strong> <?= utf8_decode($rprof[0]->profesor); ?></div>

                </div><!--/widget-main-->
            </div><!--/widget-body-->

        </div>

    </div>

</div>
<!--
<script src="<?= "https://".$_SERVER['SERVER_NAME'];?>/js/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('a[rel="external"]').click(function() {
            alert("Hola Mundo")
            window.open($(this).attr('href'));
            return false;
        });
    });    
</script>
-->
</body>
</html>
